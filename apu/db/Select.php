<?php
Apu::import("/db/DB.php");
Apu::import("/db/MysqlDriver.php");
Apu::import("/db/Exp.php");
Apu::import("/db/Query.php");

class Select extends Query {
	function __construct($table, $schema = "DEFAULT") {
		parent::__construct($table, $schema);
	}
	function sql() {
		$sql = sprintf("select %s from %s %s %s %s", 
			$this->fieldString(), 
			$this->tableString(), 
			$this->whereString(), 
			$this->orderString(), 
			$this->limitString());
		return $sql;
	}
}
?>