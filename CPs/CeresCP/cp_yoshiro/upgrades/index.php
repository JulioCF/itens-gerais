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

include_once '../config.php'; // loads OLD config variables

// check which new configs don't exist to determine what version they're upgrading to
isset($CONFIG_gm_hide,		// added in r53
      $CONFIG_rag_serv, $CONFIG_rag_user, $CONFIG_rag_pass,		// added in r55
      $CONFIG_cp_serv, $CONFIG_cp_user, $CONFIG_cp_pass		// added in r59
}
	or die("<a href=\"./upgrade_svn60.php\">Upgrade config.php to SVN r60.</a>");

echo "No upgrades necessary.";

?>
