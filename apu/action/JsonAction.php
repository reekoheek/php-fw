<?php
Apu::import("/action/Action.php");

class JsonAction extends Action {
	var $json;
	
	function post() {
		echo JSON::encode($this->json);	
	}
}
?>