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

$jobs = $_SESSION[$CONFIG_name.'jobs'];

$query = sprintf(TOP100ZENY);
$result = execute_query($query, "top100zeny.php");

opentable($lang['TOP100ZENY_TOP100ZENY']);
echo "
<table width=\"400\">
<tr>
	<td align=\"right\" class=\"head\">".$lang['POS']."</td>
	<td>&nbsp;</td>
	<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
	<td align=\"left\" class=\"head\">".$lang['CLASS']."</td>
	<td align=\"right\" class=\"head\">".$lang['ZENY']."</td>
</tr>
";
$nusers = 0;
if ($result) {
	while ($line = $result->fetch_row()) {
				$nusers++;
				if ($nusers > 100)
					break;

				$zeny = moneyformat($line[4]);
				$charname = htmlformat($line[0]);

				echo "    
				<tr>
					<td align=\"right\">$nusers</td>
					<td>&nbsp;</td>
					<td align=\"left\">$charname</td>
					<td align=\"left\">
				";
				if (isset($jobs[$line[1]]))
					echo $jobs[$line[1]];
				else
					echo $lang['UNKNOWN'];
				echo "
					</td>
					<td align=\"right\">$zeny</td>
				</tr>
				";
	}
}
echo "</table>";
closetable();
fim();
?>
