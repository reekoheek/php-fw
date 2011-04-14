<?php
class Date extends BaseClass {
	var $date;
	var $month;
	var $year;
	var $hour;
	var $minute;
	var $second;

	function __construct($string = null) {
		if (empty($string)) {
			$date = getdate();
			$this->date = intval($date["mday"]);
			$this->month = intval($date["mon"]);
			$this->year = intval($date["year"]);
			$this->hour = intval($date["hours"]);
			$this->minute = intval($date["minutes"]);
			$this->second = intval($date["seconds"]);
		} else {
			$date = explode(" ", $string);
			$date[0] = explode("-", $date[0]);
			$date[1] = explode(":", $date[1]);
			$this->date = intval($date[0][2]);
			$this->month = intval($date[0][1]);
			$this->year = intval($date[0][0]);
			$this->hour = intval($date[1][0]);
			$this->minute = intval($date[1][1]);
			$this->second = intval($date[1][2]);
		}
	}

	function __toString() {
		return sprintf("%04d-%02d-%02d %02d:%02d:%02d", $this->year, $this->month, $this->date, 
			$this->hour, $this->minute, $this->second);
	}
}
?>