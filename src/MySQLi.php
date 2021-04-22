<?php
/**
 * phpDB
 * 
 * Please report bugs on https://github.com/robertsaupe/phpdb/issues
 *
 * @author Robert Saupe <mail@robertsaupe.de>
 * @copyright Copyright (c) 2018, Robert Saupe. All rights reserved
 * @link https://github.com/robertsaupe/phpdb
 * @license MIT License
 */

namespace RobertSaupe\DB;

use mysqli as phpmysqli;

/**
 * implements connection to mysql with mysqli
 */
abstract class MySQLi {

	private phpmysqli $conn;
	private string $table;
	private false|string $error = false;
    
	protected function __construct(string $server, string $user, string $password, string $database, string $prefix, string $table) {
		$this->table = $prefix . $table;
		$this->conn = new phpmysqli($server, $user, $password, $database);
		if ($this->conn->connect_errno) $this->error = "Failed to connect to MySQL: " . $this->conn->connect_error;

	}

	public function GetError() {
		return $this->error;
	}

	public function GetTableName() {
		return $this->table;
	}

	protected function real_escape_string($string) {
		return $this->conn->real_escape_string($string);
	}
	
	protected function query($string) {
		return $this->conn->query("$string");
    }
    
	protected function insert($insert) {
		return $this->conn->query("insert into $this->table $insert");
    }
    
	protected function result($where) {
		return $this->conn->query("select*from $this->table where $where");
    }
    
	protected function update($update) {
		return $this->conn->query("update $this->table set $update");
    }
    
	protected function delete($where) {
		return $this->conn->query("delete from $this->table where $where");
	}

}
?>