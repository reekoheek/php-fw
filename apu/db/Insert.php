<?php
Apu::import("/db/DB.php");
Apu::import("/db/MysqlDriver.php");
Apu::import("/db/Exp.php");
Apu::import("/db/Query.php");

class Insert extends Query {
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
			$values[] = $this->escape($value, $meta["name"]);
		}
		return implode(', ', $values);
	}
	function sql() {
		$sql = sprintf("insert into %s(%s) values(%s)", $this->tableString(), $this->fieldString(), $this->valueString());
		return $sql;
	}
}
?>