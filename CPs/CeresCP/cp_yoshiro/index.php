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

extension_loaded('mysqli')
	or die ("Mysqli extension not loaded. Please verify your PHP configuration.");

is_file("./config.php")
	or die("<a href=\"./install/install.php\">Run Installation Script</a>");

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

$_SESSION[$CONFIG_name.'castles'] = readcastles();
$_SESSION[$CONFIG_name.'jobs'] = readjobs();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>
			<?php echo htmlformat($CONFIG_name); ?> - Ceres Control Panel (SVN)
		</title>
		<link rel="stylesheet" type="text/css" href="./ceres.css">
		<script type="text/javascript" language="javascript" src="ceres.js"></script>
	</head>
	<body>
		<div id="td">
	<div id="banner"></div>
		<div id="main_menu"></div>
		<div id="load_div"></div>
		<div id="menu_load"></div>
		<div id="sub_menu"></div>
		<div id="content">
			<div id="main_div"></div>
			<div id="sidebar">
				<div id="login_div"></div>
				<div id="new_div"></div>
				<div id="status_div"></div>
				<div id="selectlang_div"></div>
			</div>
		</div>
		<div id="copyright">
			<p><a href="http://cerescp.sourceforge.net/">Ceres Control Panel</a> by Beowulf and Dekamaster</p>
			<p>Design por Yoshiro ~ | Tableless by <a href="http://www.brathena.org/forum/index.php?/user/10-gabem/">Gabem</a></p>
		</div></div>
		<script type="text/javascript">
			load_menu();
			LINK_ajax('motd.php', 'main_div');
			LINK_ajax('login.php', 'login_div');
			login_hide(2);
			server_status()
			LINK_ajax('selectlang.php', 'selectlang_div');
		</script>
	</body>
</html>

<?php
fim();
?>
