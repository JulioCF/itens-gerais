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

class ResultClass {
	var $result;
	var $row;

	function ResultClass($arg1) {
		$this->row = FALSE;
		$this->result = $arg1;
	}

	function fetch_row() {
		if ($this->result !== TRUE && $this->result !== FALSE)
			$this->row = mysqli_fetch_row($this->result);
		else
			$this->row = FALSE;
		return $this->row;
	}

	function count() {
		if ($this->result)
			return mysqli_num_rows($this->result);
		return 0;
	}

	function row($pos) {
		if (isset($this->row[$pos]))
			return $this->row[$pos];
		return FALSE;
	}

	function free() {
		if (empty($this->result))
			return;
		if ($this->result !== TRUE && $this->result !== FALSE)
			mysqli_free_result($this->result);
	}

}

class QueryClass {
	var $rag_link;
	var $cp_link;
	var $result;

	function QueryClass($rag_addr, $rag_username, $rag_password, $rag_db, $cp_addr, $cp_username, $cp_password, $cp_db) {
		global $lang;

		$this->rag_link = mysqli_connect($rag_addr,$rag_username,$rag_password,$rag_db) or die($lang['DB_ERROR']);
		$this->cp_link = mysqli_connect($cp_addr,$cp_username,$cp_password,$cp_db) or die($lang['DB_ERROR']);
	}

	function Query($query, $table = 0) {
		global $lang;

		if ($table)
			$this->result = mysqli_query($this->cp_link, $query);
		else
			$this->result = mysqli_query($this->rag_link, $query);

		if (strpos($query,"SELECT") === 0)
			return new ResultClass($this->result);

		if ($this->result === FALSE)
			return FALSE;

		return TRUE;
	}

	function finish() {
		if (empty($this->result))
			return;
		if ($this->result !== TRUE && $this->result !== FALSE)
			mysqli_free_result($this->result);
	}
}

?>
