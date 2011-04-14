<?php
class Exp extends BaseClass {
	const MATCH_BOTH = "BOTH";
	const MATCH_LEFT = "LEFT";
	const MATCH_RIGHT = "RIGHT";
	const MATCH_NONE = "NONE";

	var $expressions;

	function __construct($operand1, $operand2, $operator) {
		$this->expressions = array();
		$expression["operand1"] = $operand1;
		$expression["operand2"] = $operand2;
		$expression["operator"] = $operator;
		$this->add($expression);
	}

	function eq($operand1, $operand2) {
		return new Exp($operand1, $operand2, "=");
	}

	function like($operand1, $operand2, $matchMode = Exp::MATCH_BOTH) {
		if ($matchMode = Exp::MATCH_BOTH) {
			$operand2 = "%$operand2%";
		} else if ($matchMode = Exp::MATCH_LEFT) {
			$operand2 = "$operand2%";
		} else if ($matchMode = Exp::MATCH_RIGHT) {
			$operand2 = "%$operand2";
		}
		return new Exp($operand1, $operand2, "like");
	}

	function add($expression) {
		$this->expressions[] = $expression;
	}

	function raw($value) {
		return new Raw($value);
	}
}

class Raw extends Exp {
	function __construct($operand) {
		parent::__construct($operand, null, "raw");
	}

	function value() {
		return $this->expressions[0]["operand1"];
	}
}
?>