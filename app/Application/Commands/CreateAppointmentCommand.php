<?php

namespace App\Application\Commands;

class CreateAppointmentCommand
{

    protected string $appointmentId;
    protected string $appointmentStartDate;
    protected string $appointmentPersonId;

    public function appointmentId(string $appointmentId): CreateAppointmentCommand
    {
        $this->appointmentId = $appointmentId;
        return $this;
    }

    public function appointmentStartDate(string $appointmentStartDate): CreateAppointmentCommand
    {
        $this->appointmentStartDate = $appointmentStartDate;
        return $this;
    }

    public function appointmentPersonId(string $appointmentPersonId): CreateAppointmentCommand
    {
        $this->appointmentPersonId = $appointmentPersonId;
        return $this;
    }

    public function getAppointmentId(): ?string
    {
        return $this->appointmentId;
    }

    public function getAppointmentStartDate(): ?string
    {
        return $this->appointmentStartDate;
    }
    public function getAppointmentPersonId(): ?string
    {
        return $this->appointmentPersonId;
    }
}
