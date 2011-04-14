<?php
Apu::import("/action/JsonAction.php");
Apu::import("/Test.php");

class RpcAction extends JsonAction {
	var $_md;
	
	function doIndex() {
		$modules = array();
		reset($GLOBALS['CFG_RPC']->MODULES);
		while (list($moduleKey,$moduleCfg) = each($GLOBALS['CFG_RPC']->MODULES)) {
			try {
				$clazz = new ReflectionClass($moduleCfg->NAME);
				$module["name"] = $moduleCfg->NAME;
				while (list(,$methodCfg) = each($moduleCfg->METHODS)) {
					$methodRef = $clazz->getMethod($methodCfg);
					$parameterCfgs = $methodRef->getParameters();
					$parameters = array();
					$args = array();
					while(list(,$param) = each($parameterCfgs)) {
						$parameters[] = $param->getName();
						$args[] = "'ps[]=' + ".$param->getName();
					}
					$parameters[] = '__callback';
	
					$method = array();
					$method["name"] = $methodCfg;
					$method["parameters"] = implode(', ', $parameters);
					$method["args"] = implode(" + '&' + ", $args);
	
					$module["methods"][] = $method;
				}
				$modules[] = $module;
			} catch (Exception $e) {
				continue;
			}
		}
		$this->modules = $modules;
		header('Content-type: text/plain');
		Apu::dispatch("/faces/rpc.php");
		exit;
	}
	
	function doInvoke() {
		try {
		$result = Bean::invoke($this->md, $this->mt, $this->ps);
		$this->json = $result;
		} catch (Exception $e) {
			$error = new stdClass();
			$error->error = $e->getMessage();
			$this->json = $error;
		}
	}
}
?>