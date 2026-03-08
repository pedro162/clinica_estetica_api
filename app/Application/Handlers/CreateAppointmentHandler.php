<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateAppointmentCommand;
use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Appointment\Repositories\AppointmentRepositoryInterface;
use App\Domain\Appointment\ValueObjects\AppointmentActive;
use App\Domain\Appointment\ValueObjects\AppointmentBranchId;
use App\Domain\Appointment\ValueObjects\AppointmentEndDate;
use App\Domain\Appointment\ValueObjects\AppointmentEndHour;

;

use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Appointment\ValueObjects\AppointmentPersonContactName;
use App\Domain\Appointment\ValueObjects\AppointmentPersonContactNickname;
use App\Domain\Appointment\ValueObjects\AppointmentPersonId;
use App\Domain\Appointment\ValueObjects\AppointmentPriority;
use App\Domain\Appointment\ValueObjects\AppointmentProfessionalId;
use App\Domain\Appointment\ValueObjects\AppointmentReminder;
use App\Domain\Appointment\ValueObjects\AppointmentStartDate;
use App\Domain\Appointment\ValueObjects\AppointmentStartHour;
use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use App\Domain\Appointment\ValueObjects\AppointmentType;
use App\Domain\Appointment\ValueObjects\AppointmentUserId;

class CreateAppointmentHandler
{
    private AppointmentRepositoryInterface $repository;

    public function __construct(AppointmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateAppointmentCommand $command): ?Appointment
    {
        $appointment = new Appointment();
        $appointment->setId(new AppointmentId($command->getAppointmentId()));
        $appointment->setStartDate(new AppointmentStartDate($command->getAppointmentStartDate()));
        $appointment->setPersonId(new AppointmentPersonId($command->getAppointmentPersonId()));

        $appointment->setPersonId(new AppointmentPersonId($command->getAppointmentPersonId()));
        $appointment->setStartHour(new AppointmentStartHour($command->getAppointmentStartHour()));
        $appointment->setEndDate(new AppointmentEndDate($command->getAppointmentEndDate()));
        $appointment->setEndHour(new AppointmentEndHour($command->getAppointmentEndHour()));
        $appointment->setProfessionalId(new AppointmentProfessionalId($command->getAppointmentProfessionalId()));
        $appointment->setBranchId(new AppointmentBranchId($command->getAppointmentBranchId()));
        $appointment->setName(new AppointmentPersonContactName($command->getAppointmentName()));
        $appointment->setNickname(new AppointmentPersonContactNickname($command->getAppointmentNickname()));
        $appointment->setReminder(new AppointmentReminder($command->getAppointmentReminder()));
        $appointment->setPriority(new AppointmentPriority($command->getAppointmentPriority()));
        $appointment->setType(new AppointmentType($command->getAppointmentType()));
        $appointment->setActive(new AppointmentActive($command->getAppointmentActive()));
        $appointment->setUserId(new AppointmentUserId($command->getAppointmentUserId()));
        $appointment->setStatus(new AppointmentStatus($command->getAppointmentStatus()));

        return $this->repository->save($appointment);
    }
}
