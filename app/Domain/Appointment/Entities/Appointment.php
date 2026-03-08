<?php

namespace App\Domain\Appointment\Entities;

use App\Domain\Appointment\ValueObjects\AppointmentActive;
use App\Domain\Appointment\ValueObjects\AppointmentBranchId;
use App\Domain\Appointment\ValueObjects\AppointmentEndDate;
use App\Domain\Appointment\ValueObjects\AppointmentEndHour;
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

class Appointment
{
    protected AppointmentId $id; //user_id
    protected AppointmentStartDate $start_date; //dt_inicio
    protected AppointmentStartHour $start_hour; //hr_inicio
    protected AppointmentEndDate $end_date; //dt_fim
    protected AppointmentEndHour $end_hour; //hr_fim
    protected AppointmentPersonId $person_id; //pessoa_id
    protected AppointmentProfessionalId $professional_id; //profissional_id
    protected AppointmentBranchId $branch_id; //filial_id
    protected AppointmentPersonContactName $name; //name
    protected AppointmentPersonContactNickname $nickname; //name
    protected AppointmentReminder $reminder; //historico
    protected AppointmentPriority $priority; //prioridadet
    protected AppointmentStatus $status; //status
    protected AppointmentType $type; //tipo
    protected AppointmentActive $active; //active
    protected AppointmentUserId $user_id; //user_id


    public function setId(AppointmentId $id): Appointment
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): AppointmentId
    {
        return $this->id;
    }

    public function setPersonId(AppointmentPersonId $person_id): Appointment
    {
        $this->person_id = $person_id;
        return $this;
    }

    public function getPersonId(): AppointmentPersonId
    {
        return $this->person_id;
    }

    public function setStartDate(AppointmentStartDate $start_date): Appointment
    {
        $this->start_date = $start_date;
        return $this;
    }

    public function getStartDate(): AppointmentStartDate
    {
        return $this->start_date;
    }

    public function setStartHour(AppointmentStartHour $start_hour): Appointment
    {
        $this->start_hour = $start_hour;
        return $this;
    }

    public function getStartHour(): AppointmentStartHour
    {
        return $this->start_hour;
    }

    public function setEndDate(AppointmentEndDate $end_date): Appointment
    {
        $this->end_date = $end_date;
        return $this;
    }

    public function getEndDate(): AppointmentEndDate
    {
        return $this->end_date;
    }

    public function setEndHour(AppointmentEndHour $end_hour): Appointment
    {
        $this->end_hour = $end_hour;
        return $this;
    }

    public function getEndHour(): AppointmentEndHour
    {
        return $this->end_hour;
    }

    public function setProfessionalId(AppointmentProfessionalId $professional_id): Appointment
    {
        $this->professional_id = $professional_id;
        return $this;
    }

    public function getProfessionalId(): AppointmentProfessionalId
    {
        return $this->professional_id;
    }

    public function setBranchId(AppointmentBranchId $branch_id): Appointment
    {
        $this->branch_id = $branch_id;
        return $this;
    }

    public function getBranchId(): AppointmentBranchId
    {
        return $this->branch_id;
    }

    public function setName(AppointmentPersonContactName $name): Appointment
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): AppointmentPersonContactName
    {
        return $this->name;
    }

    public function setNickname(AppointmentPersonContactNickname $nickname): Appointment
    {
        $this->nickname = $nickname;
        return $this;
    }

    public function getNickname(): AppointmentPersonContactNickname
    {
        return $this->nickname;
    }

    public function setReminder(AppointmentReminder $reminder): Appointment
    {
        $this->reminder = $reminder;
        return $this;
    }

    public function getReminder(): AppointmentReminder
    {
        return $this->reminder;
    }

    public function setPriority(AppointmentPriority $priority): Appointment
    {
        $this->priority = $priority;
        return $this;
    }

    public function getPriority(): AppointmentPriority
    {
        return $this->priority;
    }

    public function setType(AppointmentType $type): Appointment
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): AppointmentType
    {
        return $this->type;
    }

    public function setActive(AppointmentActive $active): Appointment
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): AppointmentActive
    {
        return $this->active;
    }

    public function setUserId(AppointmentUserId $user_id): Appointment
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getUserId(): AppointmentUserId
    {
        return $this->user_id;
    }
    public function setStatus(AppointmentStatus $status): Appointment
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): AppointmentStatus
    {
        return $this->status;
    }
}
