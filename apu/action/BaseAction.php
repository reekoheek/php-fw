<?php
Apu::import("/message/Msg.php");
Apu::import("/common/String.php");
Apu::import("/common/Session.php");
Apu::import("/util/Bean.php");

define("ACTION_SCOPE", "ACTION");

abstract class BaseAction extends BaseClass {
	var $method;
	var $_time;

	function __construct($method) {
		$this->method = $method;
	}

	function save($key) {
		Session::save(ACTION_SCOPE, $this->$key, get_class($this).".$key");
	}

	function fetch($key) {
		$value = Session::load(ACTION_SCOPE, get_class($this).".$key");
		Bean::set($this, $key, $value);
		return $value;
	}

	function remove($key = null) {
		if ($key == null) {
			$key = get_class($this);
		} else {
			$key = get_class($this).".$key";
		}
		Session::remove(ACTION_SCOPE, $key);
	}

	function doIndex() {

	}

	function pre() {
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	}

	function post() {

	}

	function get($key = null) {
		$scope = $GLOBALS["CFG_ACTION"]->SCOPE;
		if ($scope == "_REQUEST" || $scope == "_POST" || $scope == "_GET") {
			$key = str_replace(".", "_", $key);
		}
		return Bean::get('$'.$scope, $key);
	}

	function listen() {
		$this->pre();
		$methodName = String::camelize("do_".$this->method);
		Bean::invoke($this, $methodName);
		$this->post();
	}
}
?>