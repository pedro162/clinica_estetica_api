<?php

namespace App\Application\Services;

use App\Application\Commands\CreateAppointmentCommand;
use App\Application\Handlers\CreateAppointmentHandler;
use App\Domain\Appointment\Entities\Appointment;

class AppointmentApplicationService
{
    private CreateAppointmentHandler $createAppointmentHandler;

    public function __construct(CreateAppointmentHandler $createAppointmentHandler)
    {
        $this->createAppointmentHandler = $createAppointmentHandler;
    }

    public function createAppointment(
        CreateAppointmentCommand $command
    ): ?Appointment {

        return $this->createAppointmentHandler->handler($command);
    }
}
