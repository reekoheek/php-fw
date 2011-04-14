<?php
class BaseDao extends BaseClass {
	function loginUserName() {
		$user = Session::load(LOGIN_SCOPE, "user");
		return $user["username"];
	}

	function loginFullName() {
		$user = Session::load(LOGIN_SCOPE, "user");
		$name[] = $user["firstName"];
		$name[] = $user["lastName"]; 
		return implode(' ',$name);
	}

	function byId($id, $table) {
		$select = new Select($table);
		$select->add(Exp::eq("id", $id));
		return DB::unique($select);
	}
}
?>