<?php

namespace AppBundle\Entity;

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
}
