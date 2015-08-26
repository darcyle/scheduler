<?php

namespace AppBundle\Helper;

class ApiFactory {
	static function getApiByVersion($version) {
		$className = "\AppBundle\API\ApiV{$version}.php";
		if (class_exists($className)) {
			return new $className;
		}

		return false;
	}
}