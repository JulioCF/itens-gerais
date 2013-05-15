// Copyright (c) Athena Dev Teams - Licensed under GNU GPL
// For more information, see LICENCE in the main folder

#include "../common/cbasetypes.h"
#include "../common/mmo.h"
#include "../common/core.h"
#include "../common/socket.h"
#include "../common/db.h"
#include "../common/timer.h"
#include "../common/malloc.h"
#include "../common/strlib.h"
#include "../common/showmsg.h"
#include "../common/version.h"
#include "../common/md5calc.h"
#include "../common/lock.h"
#include "account.h"
#include "login.h"

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/stat.h> // for stat/lstat/fstat

extern AccountDB* accounts;

int charif_sendallwos(int sfd, unsigned char *buf, unsigned int len);
bool check_password(const char* md5key, int passwdenc, const char* passwd, const char* refpass);
int mmo_auth_new(const char* userid, const char* pass, const char sex, const char* last_ip);
int parse_admin(int fd);


bool ladmin_auth(struct login_session_data* sd, const char* ip)
{
	bool result = false;

	if( str2ip(ip) != host2ip(login_config.admin_allowed_host) )
		ShowNotice("'ladmin'-login: Connection in administration mode REFUSED - IP isn't authorised (ip: %s).\n", ip);
	else
	if( !login_config.admin_state )
		ShowNotice("'ladmin'-login: Connection in administration mode REFUSED - remote administration is disabled (ip: %s)\n", ip);
	else
	if( !check_password(sd->md5key, sd->passwdenc, sd->passwd, login_config.admin_pass) )
		ShowNotice("'ladmin'-login: Connection in administration mode REFUSED - invalid password (ip: %s)\n", ip);
	else
	{
		ShowNotice("'ladmin'-login: Connection in administration mode accepted (ip: %s)\n", ip);
		session[sd->fd]->func_parse = parse_admin;
		result = true;
	}

	return result;
}

//---------------------------------------
// Packet parsing for administation login
//
// List of supported operations:
// 0x7530 - request server version (response: 0x7531)
// 0x7938 - request server list (response: 0x7939)
// 0x7920 - request entire list of accounts (response: 0x7921)
// 0x794e - request message broadcast (response: 0x794f + 0x2726)

// 0x7930 - request account creation (response: 0x7931)
// 0x7932 - request account deletion (response: 0x7933 + 0x2730)

// 0x7934 - request account password modification (response: 0x7935)
// 0x7936 - request account state modification (response: 0x7937 + 0x2731)
// 0x793a - request password check (response: 0x793b)
// 0x793c - request account sex modification (response: 0x793d + 0x2723)
// 0x793e - request account gm-level modification (response: 0x793f)
// 0x7940 - request account email modification (response: 0x7941)
// 0x7942 - request account memo modification (response: 0x7943)
// 0x7948 - request account expiration-time modification - absolute (response: 0x7949)
// 0x7950 - request account expiration-time modification - relative (response: 0x7951)
// 0x794a - request account unban-time modification - absolute (response: 0x794b + 0x2731)
// 0x794c - request account unban-time modification - relative (response: 0x794d + 0x2731)

// 0x7944 - request account id lookup by name (response: 0x7945)
// 0x7946 - request account name lookup by id (response: 0x7947)
// 0x7952 - request account information lookup by name (response: 0x7953)
// 0x7954 - request account information lookup by id (response: 0x7953)
//---------------------------------------
int parse_admin(int fd)
{
	char* account_name;

	uint32 ipl = session[fd]->client_addr;
	char ip[16];
	ip2str(ipl, ip);

	if( session[fd]->flag.eof )
	{
		do_close(fd);
		ShowInfo("Remote administration has disconnected (session #%d).\n", fd);
		return 0;
	}

	while( RFIFOREST(fd) >= 2 )
	{
		uint16 command = RFIFOW(fd,0);

		switch( command )
		{
		
		case 0x7530:	// Request of the server version
			ShowStatus("'ladmin': Sending of the server version (ip: %s)\n", ip);
			WFIFOHEAD(fd,10);
			WFIFOW(fd,0) = 0x7531;
			WFIFOB(fd,2) = ATHENA_MAJOR_VERSION;
			WFIFOB(fd,3) = ATHENA_MINOR_VERSION;
			WFIFOB(fd,4) = ATHENA_REVISION;
			WFIFOB(fd,5) = ATHENA_RELEASE_FLAG;
			WFIFOB(fd,6) = ATHENA_OFFICIAL_FLAG;
			WFIFOB(fd,7) = ATHENA_SERVER_LOGIN;
			WFIFOW(fd,8) = ATHENA_MOD_VERSION;
			WFIFOSET(fd,10);
			RFIFOSKIP(fd,2);
			break;
/*
		case 0x7920:	// Request of an accounts list
			if (RFIFOREST(fd) < 10)
				return 0;
			{
				int st, ed;
				uint16 len;
				CREATE_BUFFER(id, int, auth_num);
				st = RFIFOL(fd,2);
				ed = RFIFOL(fd,6);
				RFIFOSKIP(fd,10);
				WFIFOW(fd,0) = 0x7921;
				if (st < 0)
					st = 0;
				if (ed > END_ACCOUNT_NUM || ed < st || ed <= 0)
					ed = END_ACCOUNT_NUM;
				ShowStatus("'ladmin': Sending an accounts list (ask: from %d to %d, ip: %s)\n", st, ed, ip);
				// Sort before send
				for(i = 0; i < auth_num; i++) {
					unsigned int k;
					id[i] = i;
					for(j = 0; j < i; j++) {
						if (auth_dat[id[i]].account_id < auth_dat[id[j]].account_id) {
							for(k = i; k > j; k--) {
								id[k] = id[k-1];
							}
							id[j] = i; // id[i]
							break;
						}
					}
				}
				// Sending accounts information
				len = 4;
				for(i = 0; i < auth_num && len < 30000; i++) {
					int account_id = auth_dat[id[i]].account_id; // use sorted index
					if (account_id >= st && account_id <= ed) {
						j = id[i];
						WFIFOL(fd,len) = account_id;
						WFIFOB(fd,len+4) = (unsigned char)isGM(account_id);
						memcpy(WFIFOP(fd,len+5), auth_dat[j].userid, 24);
						WFIFOB(fd,len+29) = auth_dat[j].sex;
						WFIFOL(fd,len+30) = auth_dat[j].logincount;
						if (auth_dat[j].state == 0 && auth_dat[j].unban_time != 0) // if no state and banished
							WFIFOL(fd,len+34) = 7; // 6 = Your are Prohibited to log in until %s
						else
							WFIFOL(fd,len+34) = auth_dat[j].state;
						len += 38;
					}
				}
				WFIFOW(fd,2) = len;
				WFIFOSET(fd,len);
				//if (id) free(id);
				DELETE_BUFFER(id);
			}
			break;
*/
		case 0x7930:	// Request for an account creation
			if (RFIFOREST(fd) < 91)
				return 0;
		{
			struct mmo_account ma;
			safestrncpy(ma.userid, (char*)RFIFOP(fd, 2), sizeof(ma.userid));
			safestrncpy(ma.pass, (char*)RFIFOP(fd,26), sizeof(ma.pass));
			ma.sex = RFIFOB(fd,50);
			safestrncpy(ma.email, (char*)RFIFOP(fd,51), sizeof(ma.email));
			safestrncpy(ma.lastlogin, "-", sizeof(ma.lastlogin));

			ShowNotice("'ladmin': Account creation request (account: %s pass: %s, sex: %c, email: %s, ip: %s)\n", ma.userid, ma.pass, ma.sex, ma.email, ip);

			WFIFOW(fd,0) = 0x7931;
			WFIFOL(fd,2) = mmo_auth_new(ma.userid, ma.pass, ma.sex, ip);
			safestrncpy((char*)WFIFOP(fd,6), ma.userid, 24);
			WFIFOSET(fd,30);
		}
			RFIFOSKIP(fd,91);
			break;
/*
		case 0x7932:	// Request for an account deletion
			if (RFIFOREST(fd) < 26)
				return 0;
		{
			struct mmo_account acc;

			char* account_name = (char*)RFIFOP(fd,2);
			account_name[23] = '\0';

			WFIFOW(fd,0) = 0x7933;

			if( accounts->load_str(accounts, &acc, account_name) )
			{
				// Char-server is notified of deletion (for characters deletion).
				unsigned char buf[65535];
				WBUFW(buf,0) = 0x2730;
				WBUFL(buf,2) = acc.account_id;
				charif_sendallwos(-1, buf, 6);

				// send answer
				memcpy(WFIFOP(fd,6), acc.userid, 24);
				WFIFOL(fd,2) = acc.account_id;

				// delete account
				memset(acc.userid, '\0', sizeof(acc.userid));
				auth_dat[i].account_id = -1;
				mmo_auth_sync();
			} else {
				WFIFOL(fd,2) = -1;
				memcpy(WFIFOP(fd,6), account_name, 24);
				ShowNotice("'ladmin': Attempt to delete an unknown account (account: %s, ip: %s)\n", account_name, ip);
			}
			WFIFOSET(fd,30);
		}
			RFIFOSKIP(fd,26);
			break;
*/
		case 0x7934:	// Request to change a password
			if (RFIFOREST(fd) < 50)
				return 0;
		{
			struct mmo_account acc;

			char* account_name = (char*)RFIFOP(fd,2);
			account_name[23] = '\0';

			WFIFOW(fd,0) = 0x7935;

			if( accounts->load_str(accounts, &acc, account_name) )
			{
				WFIFOL(fd,2) = acc.account_id;
				safestrncpy((char*)WFIFOP(fd,6), acc.userid, 24);
				safestrncpy(acc.pass, (char*)RFIFOP(fd,26), 24);
				ShowNotice("'ladmin': Modification of a password (account: %s, new password: %s, ip: %s)\n", acc.userid, acc.pass, ip);

				accounts->save(accounts, &acc);
			}
			else
			{
				WFIFOL(fd,2) = -1;
				safestrncpy((char*)WFIFOP(fd,6), account_name, 24);
				ShowNotice("'ladmin': Attempt to modify the password of an unknown account (account: %s, ip: %s)\n", account_name, ip);
			}

			WFIFOSET(fd,30);
		}
			RFIFOSKIP(fd,50);
			break;

		case 0x7936:	// Request to modify a state
			if (RFIFOREST(fd) < 50)
				return 0;
		{
			struct mmo_account acc;

			char* account_name = (char*)RFIFOP(fd,2);
			uint32 state = RFIFOL(fd,26);
			account_name[23] = '\0';

			WFIFOW(fd,0) = 0x7937;

			if( accounts->load_str(accounts, &acc, account_name) )
			{
				memcpy(WFIFOP(fd,6), acc.userid, 24);
				WFIFOL(fd,2) = acc.account_id;

				if (acc.state == state)
					ShowNotice("'ladmin': Modification of a state, but the state of the account already has this value (account: %s, received state: %d, ip: %s)\n", account_name, state, ip);
				else
				{
					ShowNotice("'ladmin': Modification of a state (account: %s, new state: %d, ip: %s)\n", acc.userid, state, ip);

					if (acc.state == 0) {
						unsigned char buf[16];
						WBUFW(buf,0) = 0x2731;
						WBUFL(buf,2) = acc.account_id;
						WBUFB(buf,6) = 0; // 0: change of statut, 1: ban
						WBUFL(buf,7) = state; // status or final date of a banishment
						charif_sendallwos(-1, buf, 11);
					}
					acc.state = state;
					accounts->save(accounts, &acc);
				}
			}
			else
			{
				ShowNotice("'ladmin': Attempt to modify the state of an unknown account (account: %s, received state: %d, ip: %s)\n", account_name, state, ip);
				WFIFOL(fd,2) = -1;
				memcpy(WFIFOP(fd,6), account_name, 24);
			}

			WFIFOL(fd,30) = state;
			WFIFOSET(fd,34);
		}
			RFIFOSKIP(fd,50);
			break;

		case 0x7952:	// Request about informations of an account (by account name)
			if (RFIFOREST(fd) < 26)
				return 0;
		{
			struct mmo_account acc;

			WFIFOW(fd,0) = 0x7953;

			account_name = (char*)RFIFOP(fd,2);
			account_name[23] = '\0';

			if( accounts->load_str(accounts, &acc, account_name) )
			{
				ShowNotice("'ladmin': Sending information of an account (request by the name; account: %s, id: %d, ip: %s)\n", acc.userid, acc.account_id, ip);
				WFIFOL(fd,2) = acc.account_id;
				WFIFOB(fd,6) = acc.level;
				safestrncpy((char*)WFIFOP(fd,7), acc.userid, 24);
				WFIFOB(fd,31) = acc.sex;
				WFIFOL(fd,32) = acc.logincount;
				WFIFOL(fd,36) = acc.state;
				safestrncpy((char*)WFIFOP(fd,40), "-", 20); // error message (removed)
				safestrncpy((char*)WFIFOP(fd,60), acc.lastlogin, 24);
				safestrncpy((char*)WFIFOP(fd,84), acc.last_ip, 16);
				safestrncpy((char*)WFIFOP(fd,100), acc.email, 40);
				WFIFOL(fd,140) = (unsigned long)acc.expiration_time;
				WFIFOL(fd,144) = (unsigned long)acc.unban_time;
				WFIFOW(fd,148) = 0; // previously, this was strlen(memo), and memo went afterwards
			}
			else
			{
				ShowNotice("'ladmin': Attempt to obtain information (by the name) of an unknown account (account: %s, ip: %s)\n", account_name, ip);
				WFIFOL(fd,2) = -1;
				safestrncpy((char*)WFIFOP(fd,7), account_name, 24); // not found
			}

			WFIFOSET(fd,150);
		}
			RFIFOSKIP(fd,26);
			break;

		case 0x7954:	// Request about information of an account (by account id)
			if (RFIFOREST(fd) < 6)
				return 0;
		{
			struct mmo_account acc;

			int account_id = RFIFOL(fd,2);

			WFIFOHEAD(fd,150);
			WFIFOW(fd,0) = 0x7953;
			WFIFOL(fd,2) = account_id;

			if( accounts->load_num(accounts, &acc, account_id) )
			{
				ShowNotice("'ladmin': Sending information of an account (request by the id; account: %s, id: %d, ip: %s)\n", acc.userid, account_id, ip);
				WFIFOB(fd,6) = acc.level;
				safestrncpy((char*)WFIFOP(fd,7), acc.userid, 24);
				WFIFOB(fd,31) = acc.sex;
				WFIFOL(fd,32) = acc.logincount;
				WFIFOL(fd,36) = acc.state;
				safestrncpy((char*)WFIFOP(fd,40), "-", 20); // error message (removed)
				safestrncpy((char*)WFIFOP(fd,60), acc.lastlogin, 24);
				safestrncpy((char*)WFIFOP(fd,84), acc.last_ip, 16);
				safestrncpy((char*)WFIFOP(fd,100), acc.email, 40);
				WFIFOL(fd,140) = (unsigned long)acc.expiration_time;
				WFIFOL(fd,144) = (unsigned long)acc.unban_time;
				WFIFOW(fd,148) = 0; // previously, this was strlen(memo), and memo went afterwards
			}
			else
			{
				ShowNotice("'ladmin': Attempt to obtain information (by the id) of an unknown account (id: %d, ip: %s)\n", account_id, ip);
				safestrncpy((char*)WFIFOP(fd,7), "", 24); // not found
			}

			WFIFOSET(fd,150);
		}
			RFIFOSKIP(fd,6);
			break;

		default:
			ShowStatus("'ladmin': End of connection, unknown packet (ip: %s)\n", ip);
			set_eof(fd);
			return 0;
		}
	}
	RFIFOSKIP(fd,RFIFOREST(fd));
	return 0;
}
