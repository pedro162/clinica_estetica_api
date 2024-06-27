<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateAppointmentCommand;
use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Appointment\Repositories\AppointmentRepositoryInterface;;

use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Appointment\ValueObjects\AppointmentStartDate;
use App\Domain\Appointment\ValueObjects\AppointmentPersonId;

class CreateAppointmentHandler
{
    private AppointmentRepositoryInterface $repository;

    public function __construct(AppointmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateAppointmentCommand $command): ?Appointment
    {
        $template = new Appointment();
        $template->setId(new AppointmentId($command->getAppointmentId()));
        $template->setStartDate(new AppointmentStartDate($command->getAppointmentStartDate()));
        $template->setPersonId(new AppointmentPersonId($command->getAppointmentPersonId()));

        return $this->repository->save($template);
    }
}
