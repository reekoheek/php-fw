<?php
Apu::import("/message/Msg.php");

class Locale extends BaseClass {
	function lang($lang = null) {
		if ($lang == null) {
			$sessionLang = Session::load(MSG_SCOPE, "lang");
			if (empty($sessionLang)) {
				Session::save(MSG_SCOPE, Locale::_defaultBrowserLang(), "lang");
			}
			return Session::load(MSG_SCOPE, "lang");
		} else {
			Session::save(MSG_SCOPE, $lang, "lang");
		}
	}

	function _defaultBrowserLang() {
		$langs = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$langs = explode(",", $langs);
		reset($langs);
		while (list($key, $lang) = each($langs)) {
			$lang = explode(";", $lang);
			$lang = $lang[0];
			$lang = explode("-", $lang);
			return $lang[0];
		}
	}
}
?>