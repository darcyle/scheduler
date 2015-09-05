<?php

namespace AppBundle\Helper;

class Util {

	const MONDAY_DAY_OF_WEEK = 1;
	const FRIDAY_DAY_OF_WEEK = 5;

	public static function getMondayOfSameWeek($date) {
		return self::getDayOfSameWeek($date, self::MONDAY_DAY_OF_WEEK);
	}

	public static function getFridayOfSameWeek($date) {
		return self::getDayOfSameWeek($date, self::FRIDAY_DAY_OF_WEEK);
	}

	private static function getDayOfSameWeek($date, $dayToFind) {
		$dateCopy = clone $date;
		$dayOfWeek = $date->format('w');
		$offset = $dayToFind - $dayOfWeek;
		$dateCopy->modify("{$offset} day");

		return $dateCopy;
	}

	public static function getStartAndEndOfWeek($date) {
		return [self::getMondayOfSameWeek($date), self::getFridayOfSameWeek($date)];
	}
}
