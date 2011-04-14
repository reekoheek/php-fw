<?php
Apu::import("/action/Action.php");
Apu::import("/db/Select.php");
Apu::import("/todo/dao/UserDao.php");

class BaseUserAction extends Action {
	function pre() {
		parent::pre();
		BaseUserAction::checkLogin();
	}
	
	function checkLogin() {
		$user = UserDao::loginUserName();
		if (empty($user)) {
			Apu::redirect("login");
		}
	}
}
?>