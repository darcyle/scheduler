<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

// TODO: Custom Repository Classes
//      - Need to create a custom repository in order to load all days from a day that is in that week. Sat and Sun
//        should be considered to be the following week.

class ScheduleDay {
    protected $date;
    protected $appointments;

     public function __construct() {
        $this->appointments = new ArrayCollection();
    }
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ScheduleDay
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add appointments
     *
     * @param \AppBundle\Entity\ScheduleAppointment $appointment
     * @return ScheduleDay
     */
    public function addAppointment(\AppBundle\Entity\ScheduleAppointment $appointment)
    {
        $this->appointments[] = $appointment;

        return $this;
    }

    /**
     * Remove appointments
     *
     * @param \AppBundle\Entity\ScheduleAppointment $appointment
     */
    public function removeAppointment(\AppBundle\Entity\ScheduleAppointment $appointment)
    {
        $this->appointments->removeElement($appointments);
    }

    /**
     * Get appointments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAppointments()
    {
        return $this->appointments;
    }

    public function getAppointmentByDateTime($dateTime) {
        foreach ($this->getAppointments() as $appointment) {
            if ($appointment->getTime() == $dateTime) {
                return $appointment;
            }
        }

        return null;
    }

    // Find an appointment in the next 15 minutes
    public function findNextAppoinment($timeUntil = 900) {
        $now = time();
        foreach ($this->getAppointments() as $appointment) {
            $diff = $appointment->getStartDateTime()->getTimestamp() - $now;
            if ($now >= 0 and $diff <= $timeUntil) {
                return $appointment;
            }
        }

        return false;
    }
}
