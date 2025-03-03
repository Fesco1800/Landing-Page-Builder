<?php

class AppointmentBookingClientModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save($appointmentData)
    {
        $table = "appointments";
        return $this->add($table, $appointmentData);
    }
}
