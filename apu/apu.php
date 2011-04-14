<?php
ini_set("output_buffering", "On");
ini_set("output_handler", "ob_gzhandler");

require_once(dirname(__FILE__)."/config.php");

class BaseClass {

}

define("APU_SCOPE", "APU");

class Apu extends BaseClass {
	const VERSION = "0.3beta";

	function base() {
		return 'http://'.$_SERVER['HTTP_HOST'].$GLOBALS["CFG_APU"]->BASEDIR;
	}

	function theme() {
		$theme = Session::load(APU_SCOPE, "theme");
		if (empty($theme)) {
			$theme = $GLOBALS["CFG_APU"]->THEME;
			Session::save(APU_SCOPE, $theme, "theme");
		}
		return Apu::base().'/themes/'.$theme;
	}

	function redirect($path) {
		$host = $_SERVER['HTTP_HOST'];
		$header = "";
		if (substr($path, 0 , 1) == "/" || substr($path, 0 , 1) == "\\") {
			$header = "Location: ".Apu::base().$path;
		} else {
			$dir   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$dir = ltrim($dir, $GLOBALS["CFG_APU"]->BASEDIR);
			if (!empty($dir) && substr($dir, 0, 1) != '/') {
				$dir = "/$dir";
			}
			$header = "Location: ".Apu::base()."/$path";
		}
		header($header);
		exit();
	}

	function import($path) {
		reset($GLOBALS["CFG_APU"]->NS);
		while (list(, $ns) = each($GLOBALS["CFG_APU"]->NS)) {
			$filename = $_SERVER['DOCUMENT_ROOT'].$GLOBALS["CFG_APU"]->BASEDIR.$ns.$path;
			if (file_exists($filename)) {
				return require_once($filename);
			}
		}
		throw new Exception("Apu::import($path) cannot found specified file ($filename)");
	}

	function dispatch($path) {
		reset($GLOBALS["CFG_APU"]->NS);
		while (list(, $ns) = each($GLOBALS["CFG_APU"]->NS)) {
			$filename = $_SERVER['DOCUMENT_ROOT'].$GLOBALS["CFG_APU"]->BASEDIR.$ns.$path;
			if (file_exists($filename)) {
				return require($filename);
			}
		}
		throw new Exception("Apu::dispatch($path) cannot found specified file");
	}

	function listen() {
		$pathInfo = Apu::fetchPath();
		$className = String::camelize("_".$pathInfo["class"]."_action");
		reset($GLOBALS["CFG_ACTION"]->NS);
		foreach ($GLOBALS["CFG_ACTION"]->NS as $ns) {
			Apu::import($ns.'/'.$className.".php");
		}
		$action = new $className($pathInfo["method"]);
		$action->listen();
	}

	function fetchPath() {
		$path = rtrim($_SERVER['REQUEST_URI'], $GLOBALS["CFG_APU"]->BASEDIR);
		$path = str_replace("\\", '/', $path);
		$path = explode('/', $path);
		$paths = array();
		reset($path);
		while(list(, $value) = each($path)) {
			if (!empty($value)) {
				$paths[] = $value;
			}
		}
		$result = array();
		$count = count($paths);
		if ($paths[0] == "") {
			$result["class"] = $GLOBALS["CFG_ACTION"]->DEFAULT;
		} else {
			$result["class"] = $paths[0];
		}
		$last = $paths[$count-1];
		$pos = strpos($last, '?');
		if (is_numeric($pos)) {
			if ($pos == 0) {
				$_REQUEST['id'] = substr($last, 1);
				$result["method"] = ($count == 3) ? $paths[1] : "index";
			} else {
				$result["method"] = substr($last, 0, $pos);
			}
		} else {
			$result["method"] = ($count == 2) ? $paths[1] : "index";
		}
		return $result;
	}
}
//Apu::import("/common/Locale.php");
//Apu::import("/common/Date.php");
//Apu::import("/common/Session.php");
//Apu::import("/common/App.php");
Apu::import("/common/String.php");
//Apu::import("/message/Msg.php");
//Apu::import("/log/Log.php");


function Apu_exceptionHandler(/*Exception*/ $exception) {
	echo '<pre>'.$exception->__toString().'</pre>';
}
set_exception_handler("Apu_exceptionHandler");

function Apu_errorHandlerNotice($errno, $errstr, $errfile, $errline) {

}
set_error_handler("Apu_errorHandlerNotice", E_NOTICE);

function debug($var, $terminate = true) {
	print $var."<br/>";
	if ($terminate) {
		exit;
	}
}

function debug_r($var, $terminate = true, $line = null) {
	print "<pre>";
	if (!empty($line)) {
		print "Line: $line<br/>";
	}
	print_r($var);
	print "</pre><br/>";
	if ($terminate) {
		exit;
	}
}
?>