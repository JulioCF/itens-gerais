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
include_once 'mail.php';

if (!$CONFIG_password_recover)
	redir("motd.php", "main_div", "Disabled");

if (!empty($GET_opt)) {
	if ($GET_opt == 1 && isset($GET_frm_name) && !strcmp($GET_frm_name, "recover")) {
		$session = $_SESSION[$CONFIG_name.'sessioncode'];
		if ($CONFIG_auth_image && function_exists("gd_info")
			&& strtoupper($GET_code) != substr(strtoupper(md5("Mytext".$session['recover'])), 0,6))
			alert($lang['INCORRECT_CODE']);

		if (inject($GET_email)) 
			alert($lang['INCORRECT_CHARACTER']);
				
		$query = sprintf(RECOVER_PASSWORD, $GET_email);
		$result = execute_query($query, 'recover.php');

		if (!$result->count())
			alert($lang['UNKNOWN_MAIL']);

		for ($i = 0; $result->fetch_row(); $i++) {
			$accounts[$i][0] = $result->row[0];
			$accounts[$i][1] = $result->row[1];
			$accounts[$i][2] = $result->row[2];
		}

		$answer=email($accounts);

		erro_de_login(1);
		redir("motd.php", "main_div", $answer);
	}
}

if (isset($_SESSION[$CONFIG_name.'sessioncode']))
	$session = $_SESSION[$CONFIG_name.'sessioncode'];
$session['recover'] = rand(12345, 99999);
$_SESSION[$CONFIG_name.'sessioncode'] = $session;
$var = rand(10, 9999999);

opentable($lang['RECOVER_RECOVER']);
echo "
<form id=\"recover\" onsubmit=\"return GET_ajax('recover.php','main_div','recover')\"><table>
<tr><td align=\"right\">".$lang['MAIL'].":</td><td align=\"left\">
<input type=\"text\" name=\"email\" maxlength=\"40\" size=\"40\" onKeyPress=\"return force(this.name,this.form.id,event);\">
<input type=\"hidden\" name=\"opt\" value=\"1\"></td></tr>";

if ($CONFIG_auth_image && function_exists("gd_info")) {
	echo "<tr><td></td><td align=left><img src=\"img.php?img=recover&var=$var\" alt=\"".$lang['SECURITY_CODE']."\">
	</td></tr><tr><td align=right>".$lang['CODE'].":</td>
	<td align=\"left\">
	<input type=\"text\" name=\"code\" maxlength=\"6\" size=\"6\" onKeyPress=\"return force(this.name,this.form.id,event);\">
	&nbsp;</td></tr>";
}

echo "
<tr><td>&nbsp;</td><td><input type=\"submit\" value=\"".$lang['RECOVER']."\"></td></tr>
</table>
";
closetable();

fim();
?>
