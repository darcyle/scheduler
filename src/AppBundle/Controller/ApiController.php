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
	 * @Route("/schedule/number")
	 */
	public function numberAction()
	{
		$number = rand(0, 100);

		return new Response(
			'<html><body>Schedule number: '.$number.'</body></html>'
		);
	}

	/**
	 * @Route("/schedule/")
	 */
	function indexAction(Request $request) {
		// Get parameters for the week that is displayed.

		return $this->render(
        	'views/schedule/index.html.php',
        array('name' => 'NAMEGOESHERE')
    );
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