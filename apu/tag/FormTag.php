<?php
class FormTag extends BaseClass {
	function text($name, $value = "") {
		return "<input type=\"text\" class=\"Text\" id=\"$name\" name=\"$name\" value=\"$value\" />\n";
	}

	function password($name) {
		return "<input type=\"password\" class=\"Text\" id=\"$name\" name=\"$name\" />\n";
	}

	function submit($name) {
		$value = Msg::get($name);
		return "<input type=\"submit\" class=\"Button\" id=\"$name\" name=\"$name\" value=\"$value\" />\n";
	}

	function textArea($name, $value = "") {
		return "<textarea class=\"Text\" id=\"$name\" name=\"$name\" >$value</textarea>\n";
	}

	function reset($name) {
		$value = Msg::get($name);
		return "<input type=\"reset\" class=\"Button\" id=\"$name\" name=\"$name\" value=\"$value\" />\n";
	}

	function button($name) {
		$value = Msg::get($name);
		return "<input type=\"button\" class=\"Button\" id=\"$name\" name=\"$name\" value=\"$value\" />\n";
	}

	function back($name, $url) {
		$value = Msg::get($name);
		return "<input type=\"button\" class=\"Button\" id=\"$name\" name=\"$name\" value=\"$value\" onclick=\"window.location.href = '".Apu::base()."/$url'\"/>\n";
	}
}
?>