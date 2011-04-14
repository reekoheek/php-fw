<?php
Apu::import("/db/DB.php");
Apu::import("/db/MysqlDriver.php");
Apu::import("/db/Exp.php");
Apu::import("/db/Query.php");

class Update extends Query {
	var $value;

	function __construct($table, $value, $schema = "DEFAULT") {
		parent::__construct($table, $schema);
		$this->value = $value;
	}

	function valueString() {
		reset($this->meta);
		$values = array();
		while(list(,$meta) = each($this->meta)) {
			$value = Bean::get($this->value, String::camelize($meta["name"]));
			$values[] = $this->object($meta["name"])." = ".$this->escape($value, $meta["name"]);
		}
		return( implode(', ', $values) );
	}
	
	function sql() {
		$this->expressions = array();
		$this->add(Exp::eq("id", $this->value["__ID__"]));
		$sql = sprintf("update %s set %s %s", 
			$this->tableString(), 
			$this->valueString(), 
			$this->whereString());
		return $sql;
	}
}
?>