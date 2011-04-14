<?php
class String {
	function dasherize($string, $dash = '_') {
		preg_match_all("/[A-Z]/", $string, $matches, PREG_OFFSET_CAPTURE);
		if (empty($matches)) {
			return $string;
		}
		$start = 0;
		while (list($key, $value) = each($matches[0])) {
			if($value[1] == 0) {
				continue;
			}
			$result[] = substr($string, $start, $value[1] - $start);
			$start = $value[1];
		}
		$result[] = substr($string, $start);
		return strtolower(implode($dash, $result));
	}
	function camelize($string, $dash = '_') {
		$arr = explode($dash, $string);
		$result = "";
		$first = true;
		while(list(,$val) = each($arr)) {
			if ($first) {
				if (!empty($val)) {
					$result .= strtolower($val);
				}
				$first = false;
			} else {
				$result .= strtoupper(substr($val,0,1)).strtolower(substr($val, 1));
			}
		}
		return $result;
	}
}
?>