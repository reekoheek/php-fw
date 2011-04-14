<?php
abstract class Query {
	var $schema;
	var $table;
	var $meta;
	var $fields;
	var $expressions;
	var $firstResult;
	var $maxResults;
	var $orders;

	abstract function sql();

	function __construct($table, $schema = "DEFAULT") {
		$this->schema = $schema;
		$this->table = $table;
		$meta = $this->fetchMeta();
		$this->clearFields();
	}

	function fetchMeta() {
		$schema = $this->schema;
		$driver = $GLOBALS["CFG_DB"]->CON[$schema]->DRIVER;
		if (!isset($this->meta)) {
			$this->meta = Bean::invoke(String::camelize('_'.$driver.'_driver'), "meta", array($this->table, $this->schema));
		}
	}

	function add($exp) {
		if (empty($this->expressions)) {
			$this->expressions = array();
		}
		$expressions = $exp->expressions;
		reset($expressions);
		while (list(,$expression) = each($expressions)) {
			$this->expressions[] = $expression;
		}
	}

	function object($name) {
		$schema = $this->schema;
		$driver = $GLOBALS["CFG_DB"]->CON[$schema]->DRIVER;
		$object = Bean::invoke(String::camelize('_'.$driver.'_driver'), "object", array($name));
		return $object;
	}

	function clearFields() {
		$this->fields = array();
	}

	function addField($field) {
		$this->fields[] = $field;
	}

	function clearOrders() {
		$this->orders = array();
	}

	function addOrder($key, $order) {
		$sort["key"] = $key;
		$sort["order"] = $order;
		$this->orders[] = $sort;
	}

	function fieldString() {
		$fields = array();
		if (empty($this->fields)) {
			reset($this->meta);
			while(list($key, $value) = each($this->meta)) {
				$fields[] = $this->object($value["name"]);
			}
		} else {
			reset($this->fields);
			while(list($key, $value) = each($this->fields)) {
				$fields[] = $this->object($value);
			}
		}
		return implode(', ', $fields);
	}

	function tableString() {
		return $this->object($this->table);
	}

	function escape($value, $name) {
		$schema = $this->schema;
		$driver = $GLOBALS["CFG_DB"]->CON[$schema]->DRIVER;
		$value = Bean::invoke(String::camelize('_'.$driver.'_driver'), "escape", array($value, $name, $this->meta));
		return $value;
	}

	function whereString() {
		$expressions = $this->expressions;
		if (!empty($expressions)) {
			reset($expressions);
			$result = array();
			while (list(, $expression) = each($expressions)) {
				$operand1 = $this->object($expression["operand1"]);

				$operand2 = $this->escape($expression["operand2"], $expression["operand1"]);

				if ($expression["operator"] == "raw") {
					$operator = "=";
					$result[] = "$operand1 $operator $operand1";
				} else {
					$operator = $expression["operator"];
					$result[] = "$operand1 $operator $operand2";
				}
			}
			return 'where '.implode($this->andString(), $result);
		}
		return "";
	}

	function andString() {
		return " and ";
	}

	function limitString() {
		if (isset($this->maxResults)) {
			if (empty($this->firstResult)) {
				return "limit ".$this->maxResults;
			} else {
				return "limit ".$this->firstResult.", ".$this->maxResults;
			}
		}
	}

	function orderString() {
		$ords = array();
		if (!empty($this->orders)) {
			reset($this->orders);
			while (list(,$order) = each($this->orders)) {
				$ords[] = $this->object($order["key"]).' '.$order["order"];
			}
			return "order by ".implode(', ', $ords);
		}
		return "";
	}

}
?>