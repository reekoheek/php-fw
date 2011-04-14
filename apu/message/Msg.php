<?php
Apu::import("/common/Locale.php");

function Msg_formatCallback($matches) {
	$result = $GLOBALS['Msg_formatParam'][$matches[1]];
	if ($result == null) {
		$result = $matches[0];
	}
	return $result;
}

define("MSG_SCOPE", "MSG");

class Msg extends BaseClass {
	function save($messages, $scope = "global") {
		Session::save(MSG_SCOPE, $messages, $scope);
	}

	function fetch($scope = "global") {
		return Session::load(MSG_SCOPE, $scope);
	}

	function remove($scope = "global") {
		Session::remove(MSG_SCOPE, $scope);
	}

	function init() {
		$lang = Locale::lang();
		if ($GLOBALS["CFG_APU"]->DEBUG) {
			Session::remove(MSG_SCOPE, "lang");
		}
		if (Session::load(MSG_SCOPE, "lang") != $lang) {
			reset($GLOBALS["CFG_MSG"]->NS);
			while (list(,$value) = each($GLOBALS["CFG_MSG"]->NS)) {
				try { Apu::dispatch($value.".php"); } catch (Exception $e) {}
				try { Apu::dispatch($value.'_'.strtolower($lang).".php"); } catch (Exception $e) {}
			}
			Session::save(MSG_SCOPE, $lang, "lang");			
			//Session::save(MSG_SCOPE, $GLOBALS[MSG_SCOPE], "msgList");
		}
	}
	
	function getMsgList() {
//		return Session::load(MSG_SCOPE, "msgList");
		return $GLOBALS[MSG_SCOPE];
	}

	function get($key, $param = null) {
		Msg::init();
		$msgList = Msg::getMsgList();
		$message = $msgList[$key];
		if (empty($message)) {
			$message = $key;
		}
		return Msg::format($message, $param);
	}

	function message($key = "message.defaultMessage", $scope = "global") {
		$retval = "";
		$sessionMsg = Session::load(MSG_SCOPE, $scope);
		if (!empty($sessionMsg)) {
			reset($sessionMsg);
			$retval .= Msg::get("message.extra.warning");
			foreach ($sessionMsg as $message) {
				$retval .= "<div>".$message["string"]."</div>\n";
			}
			
		} else {
			$retval = Msg::get("message.extra.tooltip").Msg::get($key);
		}
		return $retval;
	}

	function format($message, $param) {
		$GLOBALS['Msg_formatParam'] = $param;
		return preg_replace_callback("({(\d)})", "Msg_formatCallback", $message);
	}
}
?>