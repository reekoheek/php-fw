<?php
Apu::import("/action/Action.php");
Apu::import("/db/Select.php");

class LoginAction extends Action {
	var $validation = "/todo/action/LoginAction_validation.php";
	
	var $login;
	
	function doIndex() {
		$this->fetch("login");
		Apu::dispatch("/todo/faces/login/login.php");
		$this->messages = Msg::fetch();
		$this->remove();
	}
	
	function doLogin() {
		$this->save("login");
		if (empty($this->messages)) {
			$select = new Select("users");
			$select->add(Exp::eq("username", $this->login["username"]));
			$user = DB::unique($select);
			if (empty($user)) {
				$this->addMsgMessage("error.fieldNotFound", "login.username");
				Msg::save($this->messages);
				Apu::redirect("login");
			}
			if ($user["password"] != $this->login["password"]) {
				$this->addMsgMessage("error.fieldNotFound", "login.password");
				Msg::save($this->messages);
				Apu::redirect("login");
			}	
			$date = new Date();
			Session::save(LOGIN_SCOPE, $user, "user");
			Session::save(LOGIN_SCOPE, $date, "last_access");
			$this->remove();
			Apu::redirect("frame");
		} else {
			Msg::save($this->messages);
			Apu::redirect("login");
		}
	}
	
	function doLogout() {
		$this->addMsgMessage("message.alreadyLogout");
		Session::destroy();
		Msg::save($this->messages);
		Apu::redirect("login");
	}
}
?>