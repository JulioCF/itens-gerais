<?php
/*
Ceres Control Panel

This is a control pannel program for Athena and Freya
Copyright (C) 2005 by Beowulf and Nightroad

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

session_start();

include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

//if (!empty($_SESSION[$CONFIG_name.'account_id'])) {
//	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {
		$query = sprintf(GUILD_LADDER);
		$result = execute_query($query, "guild.php");

		opentable($lang['GUILD_TOP50']);
		echo "
		<table width=\"550\">
		<tr>
			<td align=\"right\" class=\"head\">".$lang['POS']."</td>
			<td align=\"center\" class=\"head\">".$lang['GUILD_EMBLEM']."</td>
			<td>&nbsp;</td>
			<td align=\"left\" class=\"head\">".$lang['GUILD_GNAME']."</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align=\"left\" class=\"head\">".$lang['GUILD_GLEVEL']."</td>
			<td align=\"right\" class=\"head\">".$lang['GUILD_GEXPERIENCE']."</td>
			<td>&nbsp;</td>
			<td align=\"center\" class=\"head\">".$lang['GUILD_MEMBERS']."</td>
			<td align=\"right\" class=\"head\">".$lang['GUILD_GAVLEVEL']."</td>
		</tr>
		";
		for ($i = 1; $i < 51; $i++) {
			if (!($line = $result->fetch_row()))
				break;
			$gname = $line[0];
			$gname = htmlformat($line[0]);
			$emblems[$line[4]] = $line[1];
			$experience = moneyformat($line[3]);
			echo "
			<tr>
				<td align=\"right\">$i</td>
				<td align=\"center\"><img src=\"emblema.php?data=$line[4]\" alt=\"$gname\"></td>
				<td>&nbsp;</td>
				<td align=\"left\">$gname</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align=\"left\">$line[2]</td>
				<td align=\"right\">$experience</td>
				<td>&nbsp;</td>
				<td align=\"center\">$line[6]</td>
				<td align=\"right\">$line[5]</td>
			</tr>";
		}
		echo "</table>";
		closetable();

		if (is_woe()) {
			opentable($lang['WOE_TIME']);
			closetable();
		} else {

			$query = sprintf(GUILD_CASTLE);
			$result = execute_query($query, "guild.php");
			opentable($lang['GUILD_GCASTLES']);
			$castles = $_SESSION[$CONFIG_name.'castles'];
			echo "
			<table>
			<tr>
				<td align=\"center\" class=\"head\">".$lang['GUILD_EMBLEM']."</td>
				<td>&nbsp;</td>
				<td align=\"left\" class=\"head\">".$lang['GUILD_GNAME']."</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align=\"left\" class=\"head\">".$lang['GUILD_GCASTLE']."</td>
				</tr>
			";
			for ($i = $i; $line = $result->fetch_row(); $i++) {
				$gname = htmlformat($line[0]);
				if (isset($castles[$line[2]]))
					$cname = $castles[$line[2]];
				else 
					continue;
				$emblems[$line[3]] = $line[1];
				echo "
				<tr>
					<td align=\"center\"><img src=\"emblema.php?data=$line[3]\" alt=\"$gname\"></td>
					<td>&nbsp;</td>
					<td align=\"left\">$gname</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"left\">$cname</td>
				</tr>";
			}
			echo "</table>";
			closetable();
		}
		if (isset($emblems))
			$_SESSION[$CONFIG_name.'emblems'] = $emblems;
//	}
	fim();
//}

//redir("index.php", "main_div", "You need to be logged to use this page.");
?>
