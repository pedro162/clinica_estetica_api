<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Appointment\Repositories\AppointmentRepositoryInterface;
use App\Domain\Appointment\ValueObjects\AppointmentDocument;
use App\Domain\Appointment\ValueObjects\AppointmentEmail;
use App\Domain\Appointment\ValueObjects\AppointmentExtraDocument;
use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Appointment\ValueObjects\AppointmentMessage;
use App\Domain\Appointment\ValueObjects\AppointmentSex;
use Illuminate\Support\Facades\DB;
use App\Atendimento as AppointmentModel;
use App\Domain\Appointment\ValueObjects\AppointmentActive;
use App\Domain\Appointment\ValueObjects\AppointmentBranchId;
use App\Domain\Appointment\ValueObjects\AppointmentEndDate;
use App\Domain\Appointment\ValueObjects\AppointmentEndHour;
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
use App\User;
use Exception;

class EloquentAppointmentRepository implements AppointmentRepositoryInterface
{
    public function save(Appointment $appointment): ?Appointment
    {
        //Todo
        //Implement an object model instance and save or update within database, after that, return the object appointment implementation
        $appointmentId = (string) $appointment->getId();
        $appointmentId = (int) $appointmentId;
        $userId   = User::first()->id;
        if ($appointmentId > 0) {
            //update
            $appointmentMomel = AppointmentModel::where('id', '=', $appointmentId)->first();
            $appointmentMomel->updated([
                'name' => (string)$appointment->getName(),
                'historico' => (string)$appointment->getReminder(),
                'pessoa_id' => (string)$appointment->getPersonId(),
                'user_id' => $userId,
                'user_update_id' => $userId,
                'active' => (string)$appointment->getActive(),
                'profissional_id' => (string)$appointment->getProfessionalId(),
                'prioridade' => (string)$appointment->getPriority(),
                'status' => (string)$appointment->getStatus(),
                'dt_fim' => (string)$appointment->getEndDate(),
                'hr_fim' => (string)$appointment->getEndHour(),
                'name_atendido' => (string)$appointment->getName(),
                'tipo' => (string)$appointment->getType(),
                'dt_inicio' => (string)$appointment->getStartDate(),
                'hr_inicio' => (string)$appointment->getStartHour(),
                'filial_id' => (string)$appointment->getBranchId(),
                'dt_cancelamento' => null,
                'ds_cancelamento' => null,
                'pess_cancel_id' => null,
                'vr_atendimento' => null,
                'vr_desconto' => null,
                'vr_acrescimo' => null,
            ]);
        } else {
            //create
            $end_date = (string)$appointment->getEndDate();
            $end_hour = (string)$appointment->getEndHour();
            $appointmentMomel = AppointmentModel::create([
                'name' => (string)$appointment->getName(),
                'historico' => (string)$appointment->getReminder(),
                'pessoa_id' => (string)$appointment->getPersonId(),
                'user_id' => $userId,
                'user_update_id' => null,
                'active' => (string)$appointment->getActive(),
                'profissional_id' => (string)$appointment->getProfessionalId(),
                'prioridade' => (string)$appointment->getPriority(),
                'status' => (string)$appointment->getStatus(),
                'dt_fim' => strlen($end_date) > 0 ? $end_date : null,
                'hr_fim' => strlen($end_hour) > 0 ? $end_hour : null,
                'name_atendido' => (string)$appointment->getName(),
                'tipo' => (string)$appointment->getType(),
                'dt_inicio' => (string)$appointment->getStartDate(),
                'hr_inicio' => (string)$appointment->getStartHour(),
                'filial_id' => (string)$appointment->getBranchId(),
                'dt_cancelamento' => null,
                'ds_cancelamento' => null,
                'pess_cancel_id' => null,
                'vr_atendimento' => null,
                'vr_desconto' => null,
                'vr_acrescimo' => null,
            ]);
            $appointment->setId(new AppointmentId($appointmentMomel->id));
        }

        return $this->findById($appointment->getId());
    }
    public function findById(AppointmentId $id): ?Appointment
    {
        $appointment = DB::table('atendimentos')->where('id', '=', (string)$id)->first();
        if ($appointment) {
            $objAppointment =  new Appointment();
            $objAppointment->setId(new AppointmentId($appointment->id ?? ''))
                ->setPersonId(new AppointmentPersonId($appointment->pessoa_id ?? ''))
                ->setStartDate(new AppointmentStartDate($appointment->dt_inicio ?? ''))
                ->setStartHour(new AppointmentStartHour($appointment->hr_inicio ?? ''))
                ->setEndDate(new AppointmentEndDate($appointment->dt_fim ?? ''))
                ->setEndHour(new AppointmentEndHour($appointment->hr_fim ?? ''))
                ->setProfessionalId(new AppointmentProfessionalId($appointment->profissional_id ?? ''))
                ->setBranchId(new AppointmentBranchId($appointment->filial_id ?? ''))
                ->setName(new AppointmentPersonContactName($appointment->name ?? ''))
                ->setNickname(new AppointmentPersonContactNickname($appointment->id ?? ''))
                ->setReminder(new AppointmentReminder($appointment->historico ?? ''))
                ->setPriority(new AppointmentPriority($appointment->prioridade ?? ''))
                ->setType(new AppointmentType($appointment->tipo ?? ''))
                ->setActive(new AppointmentActive($appointment->active ?? ''))
                ->setUserId(new AppointmentUserId($appointment->user_id ?? ''))
                ->setStatus(new AppointmentStatus($appointment->status ?? ''));
            return $objAppointment;
        }
        return null;
    }
}
