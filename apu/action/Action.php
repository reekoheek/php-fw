<?php
Apu::import("/action/BaseAction.php");
Apu::import("/action/Validatable.php");
Apu::import("/action/Populatable.php");
Apu::import("/json/JSON.php");
Apu::import("/validation/Validation.php");

abstract class Action extends BaseAction implements Validatable, Populatable {
	var $messages;
	var $validation;
	var $serverDatas;

	function __construct($method) {
		parent::__construct($method);
		$this->messages = array();
	}

	function validate() {
		if (empty($this->validation)) {
			return;
		}
		Validation::validate($this);
	}

	function populate() {
		$scope = $GLOBALS["CFG_ACTION"]->SCOPE;
		$scopeVars = Bean::get('$'.$scope);
		while (list($key, $var) = each($scopeVars)) {
			if ($scope == "_REQUEST" || $scope == "_POST" || $scope == "_GET") {
				$key = str_replace("_", ".", $key);
			}
			Bean::set($this, $key, $var);
		}
	}

	function addMsgString($string, $field = null) {
		$message["string"] = $string;
		$message["field"] = $field;
		$this->messages[] = $message;
	}

	function addMsgMessage($key, $field = null, $param = null) {
		if ($field != null) {
			$param[] = Msg::get($field);
		}
		$this->addMsgString(Msg::get($key, $param), $field);
	}

	function pre() {
		parent::pre();
		$this->validate();
		$this->populate();
	}

	function post() {
		parent::post();
		Msg::remove();
		$this->serverDatas["messages"] = $this->messages;
		echo '<div id="serverDatas" style="display:none">'.JSON::encode($this->serverDatas)."</div>\n";
	}
}
?>