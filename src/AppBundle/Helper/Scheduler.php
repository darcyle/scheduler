<?php

namespace AppBundle\Helper;

// This will hold helper functions for scheduling out an amount of time
// As well as clearing out an amount of time.
// Should also handle blocking out a period of time that cannot be scheduled.

class Scheduler {
	protected static $times = 
		array(
			'10:30',
			'11:10',
			'11:50',
			'13:15',
			'13:55',
			'14:35',
			'15:20',
			'16:00',
		);

	public static function getTimes() {
		return self::$times;
	}
}