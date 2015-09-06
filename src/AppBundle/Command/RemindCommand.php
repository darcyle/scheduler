<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\ScheduleDay;
use AppBundle\Entity\ScheduleAppointment;
use AppBundle\Helper\SlackBot;

class RemindCommand extends ContainerAwareCommand {
	protected function configure() {
		$this
			->setName('schedule:remind')
			->setDescription('Schedule future appointments.');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// FIND AN APPOINTMENT IN THE NEXT 15 MINUTES.
		$output->writeLn('[schedule:remind] Looking for an appointment to message.');

		$em = $this->getContainer()->get('doctrine')->getManager();

		$scheduleDay = $em->getRepository('AppBundle:ScheduleDay')
			->findOneBy(array('date' => new \DateTime('today')));
		$scheduleAppointment = $scheduleDay->findNextAppoinment();

		if ($scheduleAppointment !== false) {
			$output->writeLn(
				'[schedule:remind] Found an appointment for '
				. $scheduleAppointment->getUsername().'. Messaging now.'
			);

			$startDateTime = $scheduleAppointment->getStartDateTime();

			$secondsUntilMassage = $startDateTime->getTimeStamp() - time();
			$minutesUntilMassage = round($secondsUntilMassage / 60);

			// EMAIL AND SLACKBOT THIS PERSON
			$slackBot = $this->getContainer()->get('slackbot');
			$slackBot->setUsername('Massage');
			$result = $slackBot->chatPostMessage(
				'@'.$scheduleAppointment->getUsername(), 
				"You have a massage scheduled to start in $minutesUntilMassage minutes.",
				':soon:'
			);
		}
	}
}