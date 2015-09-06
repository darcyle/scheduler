<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
	/**
	 * @Route("/schedule/")
	 */
	function indexAction(Request $request) {
		return $this->render('views/schedule/index.html.php');
	}
	
	/**
	 * @Route("/api/v{version}/",  requirements={
 	 *     "version": "\d+"	
 	 * });
	 */
	public function api($version, Request $request) {
		$apiFactory = $this->get('api');

		$api = $apiFactory->getApiByVersion($version);
		if ($api) {
			$response = $api->execute($request, $this);
			return $response;
		}

		return new JsonResponse(array('error' => 'API version not found.'), 404);
	}
}