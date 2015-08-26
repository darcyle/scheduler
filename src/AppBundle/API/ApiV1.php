<?php

namespace AppBundle\API;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

// TESTING THIS:

// curl -H "Content-Type: application/json" -X POST -d '{"method":"ping","args":{"id":1,"name":"David Grossman"}}' http://scheduler.lan:8888/api/v1/

class ApiV1 {
	function execute(Request $request) {
		$content = $request->getContent();

		$data = json_decode($content, true);

		if (json_last_error() !== JSON_ERROR_NONE || $data === null) {
			$response = new JsonResponse(array('error' => 'Invalid Request.'), 400);
			return $response;
		}

		$method = $data['method'];
		if (method_exists($this, $method)) {
			$response = $this->$method($data['args'], $request);
			return $response;
		}
	}

	function ping($data, $request) {
		return new JsonResponse($data);
	}
}