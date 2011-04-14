<?php
class Bean extends BaseClass {
	function invoke($obj, $method, $args = null) {
		$param = "";
		if (!empty($args) && is_array($args)) {
			$count = count($args);
			for($i = 0; $i < $count; $i++) {
				$param[] = "\$args[$i]";
			}
			$param = implode(', ', $param);
		}
		if (is_string($obj)) {
			if (substr($obj, 0, 1) == '$') {
				eval('$obj = '.$obj.";");
			} else {
				if (!class_exists($obj)) {
					throw new Exception("Class `$obj` not found");
				}
				eval("\$result = $obj::$method($param);");
				return $result;
			}
		}
		// TODO sebelum di-eval seharusnya direflect dulu just in case method yang dimaksud tidak ada bisa throw exception
		eval("\$result = \$obj->$method($param);");
		return $result;
	}

	function get($obj, $property = null) {
		// TODO sebelum di-eval seharusnya direflect dulu just in case property yang dimaksud tidak ada bisa throw exception
		if (is_string($obj)) {
			if (substr($obj, 0, 1) == '$') {
				eval('$obj = '.$obj.";");
			} else {
				$exist = class_exists($obj);
				if (!$exist) {
					throw new Exception("Class not found or not imported yet");
				}
				if (!empty($property)) {
					eval('$result = '.$obj.'::'.$property);
					return $result;
				}
				throw new Exception("Cannot get from class without property name");
			}
		}
		if (empty($property)) {
			return $obj;
		}

		$pos = strpos($property, '.');
		if ($pos == false) {
			if (is_array($obj)) {
				return $obj[$property];
			} else if (is_object($obj)) {
				return $obj->$property;
			}
		} else {
			$first = substr($property, 0, $pos);
			$rest = substr($property, $pos + 1);
			if (is_array($obj)) {
				return Bean::get($obj[$first], $rest);
			} else if (is_object($obj)) {
				return Bean::get($obj->$first, $rest);
			} else {
				return null;
				//				throw new Exception("Object is not array nor object, and cannot get property from it");
			}
		}
	}

	function set(&$obj, $property, $value) {
		if (is_string($obj)) {
			if (substr($obj, 0, 1) == '$') {
				eval('$obj = '.$obj.";");
			} else {
				throw new Exception("Cannot set to static class");
			}
		}
		$pos = strpos($property, '.');
		if ($pos == false) {
			if (is_object($obj)) {
				if (is_null($value)) {
					unset($obj->$property);
				} else {
					$obj->$property = $value;
				}
			} else {
				if (is_null($value)) {
					unset($obj[$property]);
				} else {
					$obj[$property] = $value;
				}
			}
		} else {
			$first = substr($property, 0, $pos);
			$rest = substr($property, $pos + 1);
			if (is_object($obj)) {
				Bean::set($obj->$first, $rest, $value);
			} else {
				Bean::set($obj[$first], $rest, $value);
			}
		}
	}

	function copy($source, &$destination, $includes) {
		while(list(,$include) = each($includes)) {
			$value = Bean::get($source, $include);
			Bean::set($destination, $include, $value);
		}
	}
}
?>