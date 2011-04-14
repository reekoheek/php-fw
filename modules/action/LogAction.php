<?php
Apu::import("/action/JsonAction.php");

class LogAction extends JsonAction {
	var $message;
	
	function doIndex() {
		$result = new stdClass();
		$result->message = $this->message;
		$this->json = $result;	 
	}
}
?>