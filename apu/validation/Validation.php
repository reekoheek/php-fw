<?php
class Validation extends BaseClass {
	function validate(&$action) {
		Apu::dispatch($action->validation);
		if (!empty($GLOBALS["VALIDATION"])) {
			reset($GLOBALS["VALIDATION"]);
			while (list($method, $methodValidations) = each($GLOBALS["VALIDATION"])) {
				if ($method == "-" || $method == $action->method) {
					reset($methodValidations);
					while (list($field, $fieldValidations) = each($methodValidations)) {
						$fieldValue = $action->get($field);
						while (list($i, $val) = each($fieldValidations)) {
							$function = $val["validate"];
							$not = false;
							if (substr($val["validate"], 0, 1) == "!") {
								$function = trim($function, "!");
								$not = true;
							}
							$validate = Bean::invoke("Validation", $function, array(&$action, $val, $field, $not));
							if ($not) {
								$validate = !$validate;
							}
							if (!$validate) {
								$defaultMessage = $GLOBALS["CFG_VALIDATION"]->MSG[$val["validate"]];
								$action->addMsgMessage($defaultMessage, $field);
							}
						}
					}
				}
			}
		}
	}

	function isEmpty(&$action, $val, $field) {
		$fieldValue = $action->get($field);
		return empty($fieldValue);
	}

	function isNumeric(&$action, $val, $field) {
		$fieldValue = $action->get($field);
		if (is_int($fieldValue)) {
			return true;
		}
		if (preg_match("/[^0-9]/", $fieldValue) == 0) {
			return true;
		}
		return false;
	}
}
?>