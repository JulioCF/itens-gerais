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

	$query = sprintf(GET_LINKS);
	$result = execute_query($query, 'links.php', 1, 0);


	opentable($lang['LINKS_LINKS']);
echo "<table>";

for ($i = 1; $i < 10; $i++) {
			if (!($clinks = $result->fetch_row()))
				break;

	$name = htmlspecialchars(utf8_encode($clinks[0]));
	$url = htmlspecialchars($clinks[1]);
	$desc = nl2br(htmlspecialchars(utf8_encode($clinks[2])));
	$size = $clinks[3];

	if ($size==0) {
		$size="";
		$url=" <a href=$url class=\"link\" target=_blank>$name</a> $size";
		}
	else{
		$size=" ($size Mb)";
		$url=" <a href=$url class=\"link\">$name</a> $size";
		};

			echo "
				<tr><td align=\"left\"><b>".$lang['LINKS_NAME']."</b>:</td><td align=\"left\">$url</td></tr>
				<tr><td align=\"left\">&nbsp;</td><td align=\"left\">$desc</td></tr>
				<tr><td align=\"left\">&nbsp;</td></tr>
				";
}

		echo "</table>";
	closetable();
	fim();



?>
