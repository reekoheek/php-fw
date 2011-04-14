<?php
class Log extends BaseClass {
	function debug($message, $file = null, $line = null, $e = null) {
		Log::log("DEBUG", $message, $file, $line, $e);
	}

	function log($priority, $message, $file = null, $line = null, $e = null) {
		$schema = "DEFAULT";
		$table = "logs";
		$trace = "";
		if (!empty($e)) {
			$trace = $e->getTraceAsString();
		}
		if (is_object($message)) {
			$message = JSON::encode($message);
		}
		$now = new Date();
		$log = array();
		$log["priority"] = $priority;
		$log["message"] = $message;
		$log["trace"] = $trace;
		$log["file"] = $file;
		$log["line"] = $line;
		$log["createdBy"] = "SYS";
		$log["createdTime"] = $now;
		$log["updatedBy"] = "SYS";
		$log["updatedTime"] = $now;

		$driver = $GLOBALS["CFG_DB"]->CON[$schema]->DRIVER;
		$insert = new Insert($table, $log, $schema);
		$link = DB::connect();
		$success = mysql_query($insert->sql(), $link);
		if (!$success) {
			$result = Bean::invoke(String::camelize('_'.$driver.'_driver'), "error", array($schema));
			throw new Exception("Cannot persist object. ".$result);
		}
	}


}
?>