<?php
class Format extends BaseClass {
	function datetime($format, Date $date) {
		// TODO you can only use dd MM yy yyyy HH mm ss
		$format = Msg::get($format);
		$patterns[0] = '/dd/';
		$patterns[1] = '/MM/';
		$patterns[2] = '/yyyy/';
		$patterns[3] = '/yy/';
		$patterns[4] = '/HH/';
		$patterns[5] = '/mm/';
		$patterns[6] = '/ss/';
		$replacements[6] = sprintf("%02d", $date->date);
		$replacements[5] = sprintf("%02d", $date->month);
		$replacements[4] = sprintf("%04d", $date->year);
		$replacements[3] = sprintf("%02d", $date->year % 100);
		$replacements[2] = sprintf("%02d", $date->hour);
		$replacements[1] = sprintf("%02d", $date->minute);
		$replacements[0] = sprintf("%02d", $date->second);
		echo preg_replace($patterns, $replacements, $format);
	}
}
?>