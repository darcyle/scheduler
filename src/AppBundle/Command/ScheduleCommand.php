<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\ScheduleDay;
use AppBundle\Entity\ScheduleAppointment;

class ScheduleCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('schedule:auto')
			->setDescription('Schedule future appointments.')
			->addArgument(
				'start',
				InputArgument::REQUIRED,
				'First day to schedule'
			)
			->addArgument(
				'end',
				InputArgument::REQUIRED,
				'Final day to schedule'
			)
			->addOption(
				'mon',
				null,
				InputOption::VALUE_NONE,
				'Schedule Monday.'
			)
			->addOption(
				'tue',
				null,
				InputOption::VALUE_NONE,
				'Schedule Tuesday.'
			)
			->addOption(
				'wed',
				null,
				InputOption::VALUE_NONE,
				'Schedule Wed.'
			)
			->addOption(
				'thu',
				null,
				InputOption::VALUE_NONE,
				'Schedule Thursday.'
			)
			->addOption(
				'fri',
				null,
				InputOption::VALUE_NONE,
				'Schedule Friday.'
			)

			->addArgument(
				'times',
				InputArgument::IS_ARRAY | InputArgument::REQUIRED,
				'A list of times. 11:00AM 13:00 03:00PM'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$start 	= $input->getArgument('start');
		$end 	= $input->getArgument('end');
		$times 	= $input->getArgument('times');

		// Weekends are not available for scheduling.
		$days = array();
		$days[0] = false;
		$days[1] = $input->getOption('mon');
		$days[2] = $input->getOption('tue');
		$days[3] = $input->getOption('wed');
		$days[4] = $input->getOption('thu');
		$days[5] = $input->getOption('fri');
		$days[6] = false;

		$output->writeln("<info>Automatically scheduling $start to $end @ ".join(' ', $times).'<info>');

		$startDate = new \DateTime($start);
		$endDate = new \DateTime($end);

		$timesDate = array();
		foreach ($times as $time) {
			$timesDate[] = new \DateTime($time);
		}

		while ($startDate <= $endDate) {
			try {
				if ($days[$startDate->format('w')] === true) {
					$this->schedule($startDate, $timesDate, $output);
				} else {
					if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
						$output->writeln($startDate->format('Y-m-d') . ' skipped.');
					}
					continue;
				}
			} finally {
				$startDate = $startDate->add(date_interval_create_from_date_string('1 days'));
			}

		}
	}

	protected function schedule(\DateTime $date, array $times, OutputInterface $output) {
		// Validate the times. There are only certain times.
		$em = $this->getContainer()->get('doctrine')->getManager();
		
		// Try to load the date.
		$scheduleDay = $em->getRepository('AppBundle:ScheduleDay')
			->findOneBy(array('date' => $date));

		if ($scheduleDay === null) {
			$scheduleDay = new ScheduleDay;
			$scheduleDay->setDate($date);
		}

		foreach ($times as $time) {
			$appointment = $scheduleDay->getAppointmentByDateTime($time);
			if ($appointment === null) {
				$appointment = new ScheduleAppointment();
				$appointment->setDay($scheduleDay);
				$appointment->setTime($time);

				// Only persist new appointments.
				$em->persist($appointment);
			}
		}

		$output->writeln($date->format('Y-m-d') . ' scheduled.');

		$em->persist($scheduleDay);
		$em->flush();
	}
}