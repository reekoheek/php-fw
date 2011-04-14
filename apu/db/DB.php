<?php
Apu::import("/db/Insert.php");
Apu::import("/db/Update.php");
Apu::import("/db/Delete.php");
Apu::import("/log/Log.php");
Apu::import("/common/Date.php");

define("DB_SCOPE", "DB");

class DB extends BaseClass {
	function connect($schema = "DEFAULT") {
		$driver = $GLOBALS["CFG_DB"]->CON[$schema]->DRIVER;
		$result = Bean::invoke(String::camelize('_'.$driver.'_driver'), "connect", array($schema));
		return $result;
	}

	function query($query, $schema = "DEFAULT") {
		if ($query instanceof Query) {
			Log::debug($query->sql(), __FILE__, __LINE__);
		} else {
			Log::debug($query, __FILE__, __LINE__);
		}
		$driver = $GLOBALS["CFG_DB"]->CON[$schema]->DRIVER;
		$result = Bean::invoke(String::camelize('_'.$driver.'_driver'), "query", array($query, $schema));
		return $result;
	}

	function unique($query, $schema = "DEFAULT") {
		if ($query instanceof Query) {
			Log::debug($query->sql(), __FILE__, __LINE__);
		} else {
			Log::debug($query, __FILE__, __LINE__);
		}
		$driver = $GLOBALS["CFG_DB"]->CON[$schema]->DRIVER;
		$result = Bean::invoke(String::camelize('_'.$driver.'_driver'), "unique", array($query, $schema));
		return $result;
	}

	function persist($table, $obj, $schema = "DEFAULT") {
		$driver = $GLOBALS["CFG_DB"]->CON[$schema]->DRIVER;
		$objId = Bean::get($obj, "__ID__");
		if (empty($objId)) {
			$insert = new Insert($table, $obj, $schema);
			$success = DB::query($insert, $schema);
			if (!$success) {
				$result = Bean::invoke(String::camelize('_'.$driver.'_driver'), "error", array($schema));
				throw new Exception("Cannot persist object. ".$result);
			}
		} else {
			$update = new Update($table, $obj, $schema);
			$success = DB::query($update, $schema);
			if (!$success) {
				$result = Bean::invoke(String::camelize('_'.$driver.'_driver'), "error", array($schema));
				throw new Exception("Cannot persist object. ".$result);
			}
		}
	}

	function delete($table, $obj, $schema = "DEFAULT") {
		$driver = $GLOBALS["CFG_DB"]->CON[$schema]->DRIVER;
		$objId = Bean::get($obj, "__ID__");
		if (empty($objId)) {
			throw new Exception("Cannot delete unpersisted object");
		}
		$delete = new Delete($table, $obj, $schema);
		$success = DB::query($delete, $schema);
		if (!$success) {
			$result = Bean::invoke(String::camelize('_'.$driver.'_driver'), "error", array($schema));
			throw new Exception("Cannot delete object. ".$result);
		}
	}
}
?>