<?php

namespace App\Domain\Appointment\Repositories;

use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Appointment\ValueObjects\AppointmentId;

interface AppointmentRepositoryInterface
{
    public function save(Appointment $task): ?Appointment;
    public function findById(AppointmentId $id): ?Appointment;
}
