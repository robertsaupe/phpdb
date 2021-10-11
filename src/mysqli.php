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

namespace robertsaupe\db;

use mysqli as phpmysqli;

/**
 * implements connection to mysql with mysqli
 */
abstract class mysqli {

	private phpmysqli $connection;
	private string $table;
	private false|string $error = false;
    
	protected function __construct(string $server, string $user, string $password, string $database, string $prefix, string $table) {
		$this->table = $prefix . $table;
		$this->connection = new phpmysqli($server, $user, $password, $database);
		if ($this->connection->connect_errno) $this->error = "Failed to connect to MySQL: " . $this->connection->connect_error;
	}

	public function get_connection() {
		return $this->connection;
	}

	public function get_error() {
		return $this->error;
	}

	public function get_table_name() {
		return $this->table;
	}

	protected function real_escape_string($string) {
		return $this->connection->real_escape_string($string);
	}
	
	protected function query($string) {
		return $this->connection->query("$string");
    }
    
	protected function insert($insert) {
		return $this->connection->query("insert into $this->table $insert");
    }
    
	protected function result($where) {
		return $this->connection->query("select * from $this->table where $where");
    }
    
	protected function update($update) {
		return $this->connection->query("update $this->table set $update");
    }
    
	protected function delete($where) {
		return $this->connection->query("delete from $this->table where $where");
	}

}
?>