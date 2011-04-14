<?php
Apu::import("/action/BaseUserAction.php");

class TaskAction extends BaseUserAction {
//	var $validation = "/todo/action/login/LoginAction_validation.php";
	
	function doIndex() {
		$select = new Select("tasks");
		$list = DB::query($select);
		$_REQUEST["list"] = $list; 
		Apu::dispatch("/todo/faces/task/task_list.php");
	}
	
	function doAdd() {
		Apu::dispatch("/todo/faces/task/task_add.php");
	}
}
?>