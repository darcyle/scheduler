<?php

namespace AppBundle\Entity;

class ScheduleAppointment {
    const DURATION = 1800; // 30 minutes

    protected $day_id;
    protected $time;
    protected $username; // Just the first.last

    protected $day; // ScheduleDay
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
     * Set time
     *
     * @param \DateTime $time
     * @return ScheduleAppointment
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return ScheduleAppointment
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set day
     *
     * @param \AppBundle\Entity\ScheduleDay $day
     * @return ScheduleAppointment
     */
    public function setDay(\AppBundle\Entity\ScheduleDay $day = null)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \AppBundle\Entity\ScheduleDay 
     */
    public function getDay()
    {
        return $this->day;
    }
}
