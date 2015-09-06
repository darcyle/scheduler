<?php

namespace AppBundle\API;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\ScheduleDay;
use AppBundle\Entity\ScheduleAppointment;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use AppBundle\Helper\Util;

// TESTING THIS:

// curl -H "Content-Type: application/json" -X POST -d '{"method":"ping","args":{"id":1,"name":"David Grossman"}}' http://scheduler.lan:8888/api/v1/

class ApiV1 {
	public $controller;
	public $logger;

	public function __construct(LoggerInterface $logger) {
		$this->logger = $logger;
	}

	function execute(Request $request, Controller $controller) {
		$this->controller = $controller;
		$content = $request->getContent();

		$data = json_decode($content, true);

		if (json_last_error() !== JSON_ERROR_NONE || $data === null) {
			$response = new JsonResponse(array('error' => 'Invalid Request.'), 400);
			return $response;
		}

		try {
			$method = $data['method'];
			if (method_exists($this, $method)) {
				$response = $this->$method($data['args'], $request);
				return $response;
			}
		} catch (\Exception $e) {
			return new JsonResponse(array('error' => $e->getMessage(), 500));
		}
	}

	function ping($data, Request $request) {
		return new JsonResponse($data);
	}

	function getSchedules($data, Request $request) {
		$date = isset($data['date']) ? $data['date'] : date('Y-m-d');

		// Hit the doctine manager and get the list of schedules and return them.
	}

/*
curl -H "Content-Type: application/json" -X POST -d '{"method":"setAppointment","args":{"date":"2015-07-01","time":"11:00AM", "user": "David Grossman"}}' http://scheduler.lan:8888/api/v1/
*/

	function setAppointment($data, Request $request) {
		$date = new \DateTime($data['date']);
		$time = new \DateTime($data['time']);
		$user = isset($data['user']) ? $data['user'] : null;

		// Validate the times. There are only certain times.
		$em = $this->controller->getDoctrine()->getManager();
		$scheduleDay = $em->getRepository('AppBundle:ScheduleDay')
			->findOneBy(array('date' => $date));

		if ($scheduleDay === null) {
			$scheduleDay = new ScheduleDay;
			$scheduleDay->setDate($date);
		}

		$appointment = $scheduleDay->getAppointmentByDateTime($time);
		if ($appointment === null) {
			$appointment = new ScheduleAppointment();
			$appointment->setDay($scheduleDay);
			$appointment->setTime($time);
		}

		$appointment->setUsername($user);

		// Try to load the date. If it doesn't exist create it.

		// Try to load the appointment. If it doesn't exist create it.
		$responseData = array();

		$em->persist($scheduleDay);
		$em->persist($appointment);
		$em->flush();

		$responseData = ['day' => $scheduleDay->getID(), 'appt' => $appointment->getID()];

		return new JsonResponse($responseData);
	}

/*
curl -H "Content-Type: application/json" -X POST -d '{"method":"deleteAppointment","args":{"date":"2015-07-01","time":"11:00AM"}}' http://scheduler.lan:8888/api/v1/
*/

	function deleteAppointment($data, Request $request) {
		$date = new \DateTime($data['date']);
		$time = new \DateTime($data['time']);

		$em = $this->controller->getDoctrine()->getManager();

		$scheduleDay = $em->getRepository('AppBundle:ScheduleDay')
				->findOneBy(array('date' => $date));

		if ($scheduleDay === null) {
			return new JsonResponse(array('error' => 'Appointment not found.'), 404);
		}

		$appointment = $scheduleDay->getAppointmentByDateTime($time);

		if ($appointment === null) {
			return new JsonResponse(array('error' => 'Appointment not found.'), 404);
		}

		$appointment->setUsername(null);

		$em->persist($appointment);
		$em->flush();

		return new JsonResponse(['message' => 'Appointment removed.']);
	}


/*
curl -H "Content-Type: application/json" -X POST -d '{"method":"getWeek","args":[]}' http://scheduler.lan:8888/api/v1/
*/
	function getWeek($data, Request $request) {
		if (isset($data['date'])) {
			$date = new \DateTime($data['date']);
		} else {
			$date = new \DateTime('now');
		}

		// Obtain week start / end of the date provided.
		$start = Util::getMondayOfSameWeek($date);
		$end = Util::getFridayOfSameWeek($date);

		// Get a weeks worth of data
		$em = $this->controller->getDoctrine()->getManager();
		$scheduleDays = $em->getRepository('AppBundle:ScheduleDay')
			->getWeek($start, $end);

		// Serialize the output:
		$serialized = [];
		foreach ($scheduleDays as $scheduleDay) {
			$day = array(
				'date' => $scheduleDay->getDate()->format('Y-m-d'),
				'day' => $scheduleDay->getDate()->format('D'),
				'appointments' => array()
			);

			foreach ($scheduleDay->getAppointments() as $appointment) {
				$day['appointments'][] = array(
					'time' => $appointment->getTime()->format('h:iA'),
					'user' => $appointment->getUsername()
				);
			}
			$serialized[] = $day;
		}

		return new JsonResponse(['schedules' => $serialized, 'weekStartDate' => $start->format('m-d-Y')]);
	}
}
