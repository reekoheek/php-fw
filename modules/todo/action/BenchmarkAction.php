<?php
Apu::import("/action/BaseAction.php");
Apu::import("/db/DB.php");
Apu::import("/db/Select.php");
class BenchmarkAction extends BaseAction {
	function doIndex() {
		header('Content-type: text/plain');
		echo "Hello World\n";
	}

	function doUsedb() {
		header('Content-type: text/plain');
		echo "Hello World\n";
		$result = DB::query(new Select("logs"));
		foreach($result as $row) {
			$a[] = $row;
		}
		$result = DB::query(new Select("lookups"));
		foreach($result as $row) {
			$a[] = $row;
		}
	}
}
?>