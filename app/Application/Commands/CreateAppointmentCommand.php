<?php

namespace App\Application\Commands;

class CreateAppointmentCommand
{
    protected string $appointmentId;
    protected string $appointmentStartDate;
    protected string $appointmentPersonId;
    protected string $appointmentStartHour;
    protected string $appointmentEndDate;
    protected string $appointmentEndHour;
    protected string $appointmentProfessionalId;
    protected string $appointmentBranchId;
    protected string $appointmentName;
    protected string $appointmentNickname;
    protected string $appointmentReminder;
    protected string $appointmentPriority;
    protected string $appointmentType;
    protected string $appointmentActive;
    protected string $appointmentUserId;
    protected string $appointmentStatus;

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

    public function appointmentStartHour(string $appointmentStartHour): CreateAppointmentCommand
    {
        $this->appointmentStartHour = $appointmentStartHour;
        return $this;
    }

    public function appointmentEndDate(string $appointmentEndDate): CreateAppointmentCommand
    {
        $this->appointmentEndDate = $appointmentEndDate;
        return $this;
    }

    public function appointmentEndHour(string $appointmentEndHour): CreateAppointmentCommand
    {
        $this->appointmentEndHour = $appointmentEndHour;
        return $this;
    }

    public function appointmentProfessionalId(string $appointmentProfessionalId): CreateAppointmentCommand
    {
        $this->appointmentProfessionalId = $appointmentProfessionalId;
        return $this;
    }

    public function appointmentBranchId(string $appointmentBranchId): CreateAppointmentCommand
    {
        $this->appointmentBranchId = $appointmentBranchId;
        return $this;
    }

    public function appointmentName(string $appointmentName): CreateAppointmentCommand
    {
        $this->appointmentName = $appointmentName;
        return $this;
    }

    public function appointmentNickname(string $appointmentNickname): CreateAppointmentCommand
    {
        $this->appointmentNickname = $appointmentNickname;
        return $this;
    }

    public function appointmentReminder(string $appointmentReminder): CreateAppointmentCommand
    {
        $this->appointmentReminder = $appointmentReminder;
        return $this;
    }

    public function appointmentPriority(string $appointmentPriority): CreateAppointmentCommand
    {
        $this->appointmentPriority = $appointmentPriority;
        return $this;
    }

    public function appointmentType(string $appointmentType): CreateAppointmentCommand
    {
        $this->appointmentType = $appointmentType;
        return $this;
    }

    public function appointmentActive(string $appointmentActive): CreateAppointmentCommand
    {
        $this->appointmentActive = $appointmentActive;
        return $this;
    }

    public function appointmentUserId(string $appointmentUserId): CreateAppointmentCommand
    {
        $this->appointmentUserId = $appointmentUserId;
        return $this;
    }

    public function appointmentStatus(string $appointmentStatus): CreateAppointmentCommand
    {
        $this->appointmentStatus = $appointmentStatus;
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

    public function getAppointmentStartHour(): ?string
    {
        return $this->appointmentStartHour;
    }
    public function getAppointmentEndDate(): ?string
    {
        return $this->appointmentEndDate;
    }
    public function getAppointmentEndHour(): ?string
    {
        return $this->appointmentEndHour;
    }
    public function getAppointmentProfessionalId(): ?string
    {
        return $this->appointmentProfessionalId;
    }
    public function getAppointmentBranchId(): ?string
    {
        return $this->appointmentBranchId;
    }
    public function getAppointmentName(): ?string
    {
        return $this->appointmentName;
    }
    public function getAppointmentNickname(): ?string
    {
        return $this->appointmentNickname;
    }
    public function getAppointmentReminder(): ?string
    {
        return $this->appointmentReminder;
    }
    public function getAppointmentPriority(): ?string
    {
        return $this->appointmentPriority;
    }
    public function getAppointmentType(): ?string
    {
        return $this->appointmentType;
    }
    public function getAppointmentActive(): ?string
    {
        return $this->appointmentActive;
    }
    public function getAppointmentUserId(): ?string
    {
        return $this->appointmentUserId;
    }
    public function getAppointmentStatus(): ?string
    {
        return $this->appointmentStatus;
    }
}
