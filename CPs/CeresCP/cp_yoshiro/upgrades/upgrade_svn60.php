<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>
		Ceres Control Panel Upgrade Script
		</title>
	</head>
	<BODY style="margin-top:0; margin-bottom:0">

<?php
/*
Ceres Control Panel

This is a control panel program for eAthena and other Athena SQL based servers
Copyright (C) 2005 by Beowulf and Dekamaster

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

To contact any of the authors about special permissions send
an e-mail to cerescp@gmail.com
*/

is_file("../config.php")
	or die("CeresCP is not installed. <a href=\"../install/install.php\">Run Installation Script</a>");

extract($_POST, EXTR_PREFIX_ALL, "POST");

if (isset($POST_upgrade)) {

	include_once '../config.php'; // loads OLD config variables
	
	//write the config.php file
	$buffer = "<?php\n";
	$buffer .= "/*\n";
	$buffer .= "Ceres Control Panel\n";
	$buffer .= "\n";
	$buffer .= "This is a control pannel program for Athena and Freya\n";
	$buffer .= "Copyright (C) 2005 by Beowulf and Nightroad\n";
	$buffer .= "\n";
	$buffer .= "This program is free software; you can redistribute it and/or\n";
	$buffer .= "modify it under the terms of the GNU General Public License\n";
	$buffer .= "as published by the Free Software Foundation; either version 2\n";
	$buffer .= "of the License, or (at your option) any later version.\n";
	$buffer .= "\n";
	$buffer .= "This program is distributed in the hope that it will be useful,\n";
	$buffer .= "but WITHOUT ANY WARRANTY; without even the implied warranty of\n";
	$buffer .= "MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the\n";
	$buffer .= "GNU General Public License for more details.\n";
	$buffer .= "\n";
	$buffer .= "You should have received a copy of the GNU General Public License\n";
	$buffer .= "along with this program; if not, write to the Free Software\n";
	$buffer .= "Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.\n";
	$buffer .= "\n";
	$buffer .= "To contact any of the authors about special permissions send\n";
	$buffer .= "a mail to cerescp@gmail.com\n";
	$buffer .= "\n";
	$buffer .= "This file was generated using upgrade_svn60.php\n";
	$buffer .= "*/\n";
	$buffer .= "\n";
	$buffer .= "//sql connections\n";
	$buffer .= "\$CONFIG['rag_serv']		=	'".$CONFIG_db_serv."';	// SQL Ragnarok Host\n";
	$buffer .= "\$CONFIG['rag_user']		=	'".$CONFIG_db_user."';		// SQL Ragnarok User\n";
	$buffer .= "\$CONFIG['rag_pass']		=	'".$CONFIG_db_pass."';		// SQL Ragnarok Password\n";
	$buffer .= "\$CONFIG['rag_db']			=	'".$CONFIG_rag_db."';		// SQL Ragnarok Database name\n";
	$buffer .= "\$CONFIG['log_db']			=	'".$CONFIG_log_db."';		// SQL Ragnarok Log Database name\n";
	$buffer .= "\n";
	$buffer .= "\$CONFIG['cp_serv']		=	'".$CONFIG_db_serv."';	// SQL CP Host\n";
	$buffer .= "\$CONFIG['cp_user']		=	'".$CONFIG_db_user."';		// SQL CP User\n";
	$buffer .= "\$CONFIG['cp_pass']		=	'".$CONFIG_db_pass."';		// SQL CP Password\n";
	$buffer .= "\$CONFIG['cp_db']			=	'".$CONFIG_cp_db."';			// SQL CP Database name\n";
	$buffer .= "\n";
	$buffer .= "\$CONFIG['md5_pass']		=	'".$CONFIG_md5_pass."';			// Use MD5 password (enable = 1, disable = 0)\n";
	$buffer .= "\$CONFIG['safe_pass']		=	'".$CONFIG_safe_pass."';			// Force the use of a safer password with size 6 and at least 2 letter and 2 numbers (enable = 1, disable = 0)\n";
	$buffer .= "\n";
	$buffer .= "//Admin Area\n";
	$buffer .= "\$CONFIG['cp_admin']		=	'".$CONFIG_cp_admin."';			// CP admin functions\n";
	$buffer .= "\$CONFIG['gm_level']		=	'".$CONFIG_gm_level."';			// CP GM funtions\n";
	$buffer .= "\$CONFIG['gm_hide']		=	'".$POST_cp_hide_lvl."';			// GMs this level and above will be hidden from whoisonline.php\n";
	$buffer .= "\n";
	$buffer .= "//WOE\n";
	$buffer .= "// sun = sunday, mon = monday, tue = tuesday, wed = wednesday, thu = thursday, fri = friday, sun = sunday\n";
	$buffer .= "// place week_day(start_time, end_time) and a ';' between the times the freya default woe times is set as an example\n";
	$buffer .= "// there is no limit you can place as many as you want, no spaces are needed, but using it you can understand.\n";
	$buffer .= "\$CONFIG['woe_time']		=	'".$CONFIG_woe_time."';\n";
	$buffer .= "\$CONFIG['agit_check']		=	'".$CONFIG_agit_check."';			// This WILL NOT WORK unless you installed the npc script AND you updated your ragsrvinfo table, read the installation notes for more info.\n";
	$buffer .= "\n";
	$buffer .= "//server name, rates\n";
	$buffer .= "\$CONFIG['name']			=	'".$CONFIG_name."';	// name of the server\n";
	$buffer .= "\$CONFIG['rate']			=	'".$CONFIG_rate."';		// rates of the server\n";
	$buffer .= "date_default_timezone_set('".$POST_timezone."');		// game server Timezone (useful if your webserver's timezone is different than game server).\n";
	$buffer .= "\$CONFIG['dynamic_info']		=	'".$CONFIG_dynamic_info."';			// Use info (rates) from the server itself?\n";
	$buffer .= "\$CONFIG['dynamic_name']		=	'".$CONFIG_dynamic_name."';	// The name of the server in ragsrvinfo's server name column (Used for dynamic info)\n";
	$buffer .= "\$CONFIG['show_rates']		=	'".$CONFIG_show_rates."';			// Show rates below server status?\n";
	$buffer .= "\n";
	$buffer .= "//map,char,login servers settings\n";
	$buffer .= "\$CONFIG['accip']			=	'".$CONFIG_accip."';	// Account/Login Server IP\n";
	$buffer .= "\$CONFIG['accport']		=	'".$CONFIG_accport."';		// Account/Login Server Port\n";
	$buffer .= "\$CONFIG['charip']			=	'".$CONFIG_charip."';	// Char Server IP\n";
	$buffer .= "\$CONFIG['charport']		=	'".$CONFIG_charport."';		// Char Server Port\n";
	$buffer .= "\$CONFIG['mapip']			=	'".$CONFIG_mapip."';	// Zone/Map Server IP\n";
	$buffer .= "\$CONFIG['mapport']		=	'".$CONFIG_mapport."';		// Zone/Map Server Port\n";
	$buffer .= "\n";
	$buffer .= "//default language\n";
	$buffer .= "\$CONFIG['language']		=	'".$CONFIG_language."';		// default language (remember to check if the translation exist before set)\n";
	$buffer .= "\n";
	$buffer .= "//cp features\n";
	$buffer .= "\$CONFIG['disable_account']	=	'".$CONFIG_disable_account."';			// disable the account creation disable = 1, enable = 0\n";
	$buffer .= "\$CONFIG['auth_image']		=	'".$CONFIG_auth_image."';			// enable the verification code image, to check if it's a real person using the cp, instead of a bot (brute-force atack) - Recommended, but requires gd library (enable = 1 disable = 0)\n";
	$buffer .= "\$CONFIG['max_accounts']		=	'".$CONFIG_max_accounts."';			// Max accounts allowed to be in the DB (0 = disabled)\n";
	$buffer .= "\$CONFIG['password_recover']	=	'".$CONFIG_password_recover."';			// password recover enable = 1, disable = 0\n";
	$buffer .= "\$CONFIG['reset_enable']		=	'".$CONFIG_reset_enable."';			// reset position enable = 1, disable = 0\n";
	$buffer .= "\$CONFIG['reset_cost']		=	'".$CONFIG_reset_cost."';		// reset position cost, disable cost = 0\n";
	$buffer .= "\$CONFIG['money_transfer']	=	'".$CONFIG_money_transfer."';			// money transfer enable = 1, disable = 0\n";
	$buffer .= "\$CONFIG['money_cost']		=	'".$CONFIG_money_cost."';			// money transfer cost (100 = 1%), disable cost = 0\n";
	$buffer .= "\$CONFIG['set_slot']		=	'".$CONFIG_set_slot."';			// change char slot enable = 1, disable = 0\n";
	$buffer .= "\$CONFIG['reset_look']		=	'".$CONFIG_reset_look."';			// reset char equips and colors with error enable = 1, disable = 0\n";
	$buffer .= "\$CONFIG['marry_enable']		=	'".$CONFIG_marry_enable."';			// enable marriage view and divorce\n";
	$buffer .= "\$CONFIG['prison_map']		=	'".$CONFIG_prison_map."';		// Name of the map that is used as your jail (mapname.gat)\n";
	$buffer .= "\n";
	$buffer .= "//About Information\n";
	$buffer .= "\$CONFIG['classlist_show']	=	'".$CONFIG_classlist_show."';			// Show the class list on about.php? (disable = 0, enable = 1)\n";
	$buffer .= "\n";
	$buffer .= "//Mail\n";
	$buffer .= "\$CONFIG['smtp_server']		=	'".$CONFIG_smtp_server."';	// the smtp server, the cp will use to send mails\n";
	$buffer .= "\$CONFIG['smtp_port']		=	'".$CONFIG_smtp_port."';			// the smtp server port\n";
	$buffer .= "\$CONFIG['smtp_mail']		=	'".$CONFIG_smtp_mail."';		// the email of the admin\n";
	$buffer .= "\$CONFIG['smtp_username']	=	'".$CONFIG_smtp_username."';			// the username of the smtp server\n";
	$buffer .= "\$CONFIG['smtp_password']	=	'".$CONFIG_smtp_password."';			// the password of the smtp server\n";
	$buffer .= "\n";
	$buffer .= "\n";
	$buffer .= "//DO NOT MESS WITH THIS\n";
	$buffer .= "extract(\$CONFIG, EXTR_PREFIX_ALL, \"CONFIG\");\n";
	$buffer .= "extract(\$_GET, EXTR_PREFIX_ALL, \"GET\");\n";
	$buffer .= "extract(\$_POST, EXTR_PREFIX_ALL, \"POST\");\n";
	$buffer .= "extract(\$_SERVER, EXTR_PREFIX_ALL, \"SERVER\");\n";
	$buffer .= "error_reporting(0);\n";
	$buffer .= "?>\n";

	$handle = fopen ("config.php", "w")
		or die("Can't create config.php. Check your permissions and press back.");
	fwrite($handle, $buffer);
	fclose($handle);

	echo "Upgrade Complete. Move config.php to your Control Panel root and delete the upgrades folder.\n";
	echo "</body></html>";
	die();
}

?>
		<form action="./upgrade_svn60.php" method="post">
			<center><table border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<th height="28" style="font-size: 36px; font-weight: bold; color: #000000;">Upgrade to SVN r60</th>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend><b>Control Panel Admin Access</b></legend>
								<table border="0" width="400">
									<tr>
										<td align="left">Hide from whoisonline.php</td>
										<td align="left"><input type="text" name="cp_hide_lvl" maxlength="3" size="5" value="40"> (min GM level)</td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend><b>Server Info Settings</b></legend>
								<table border="0" width="400">
									<tr>
										<td align="left"><a href="http://www.php.net/timezones" target="_blank">Time Zone</a></td>
										<td align="left"><input type="text" name="timezone" size="30" value="America/New_York"></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<table border="0" width="400">
									<tr>
										<td><center><input type="submit" name="upgrade" value="Upgrade"><center></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table></center>
		</form>
	</BODY>
</html>
