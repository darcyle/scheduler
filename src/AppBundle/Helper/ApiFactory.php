<?php

namespace AppBundle\Helper;

use Symfony\Component\HttpKernel\Log\LoggerInterface;

class ApiFactory {
	public $logger;
	public function __construct(LoggerInterface $logger) {
		$this->logger = $logger;
	}
	function getApiByVersion($version) {
		$className = "\AppBundle\API\ApiV{$version}";
		if (class_exists($className)) {
			return new $className($this->logger);
		}

		return false;
	}
}