<?php
define("SESSION_SCOPE", "SESSION");

$GLOBALS[SESSION_SCOPE]["started"] = false;
class Session extends BaseClass {
	function start($force = false) {
		if (!$GLOBALS["SESSION"]["started"] || $force) {
			if (!empty($GLOBALS["APU"]->APP_NAME)) {
				session_name($GLOBALS["APU"]->APP_NAME);
			}
			session_start();
		}
		$GLOBALS["SESSION"]["started"] = true;
	}

	function load($name, $property = null) {
		Session::start();
		if (empty($property)) {
			return $_SESSION[$name];
		} else {
			$session = Bean::get($_SESSION[$name], $property);
			return $session;
		}
	}

	function save($name, $value, $property = null) {
		Session::start();
		if (empty($property)) {
			$_SESSION[$name] = $value;
		} else {
			if (empty($_SESSION[$name])) {
				$_SESSION[$name] = array();
			}
			Bean::set($_SESSION[$name], $property, $value);
		}
	}

	function remove($name, $property = null) {
		Session::start();
		if (empty($property)) {
			unset($_SESSION[$name]);
		} else {
			Bean::set($_SESSION[$name], $property, null);
		}
	}

	function destroy() {
		Session::start();
		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		session_destroy();
		session_write_close();
		Session::start(true);
	}
}
?>