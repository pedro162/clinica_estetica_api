<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Atendimento;
use App\Pessoa;
use App\Profissional;
use App\Filial;
use App\Agenda;
use App\Application\Commands\CreateAppointmentCommand;
use App\Application\Commands\CreateNotificationCommand;
use App\Application\Handlers\CreateAppointmentHandler;
use App\Application\Handlers\CreateNotificationHandler;
use App\Application\Handlers\CreateNotificationVariableHandler;
use App\Application\Services\AppointmentApplicationService;
use App\Application\Services\NotificationApplicationService;
use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\ValueObjects\NotificationTargetContactAddress;
use App\Domain\Notification\ValueObjects\NotificationTargetContactName;
use App\HoraProfExpediente;
use App\Exceptions\AtendimentoException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Helpers\BaseHelper;
use App\Infrastructure\Persistence\Eloquent\EloquentAppointmentRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentNotificationRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentNotificationVariableRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentTemplateRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentTemplateVariableRepository;
use App\Infrastructure\Services\Notifications\Whatsapp\WhatsAppOfficialApi;

class AtendimentoHelper extends BaseHelper
{

    public function store(array $dados)
    {
        $pessoas = Pessoa::where('active', '=', 'yes')->where('id', '=', $dados['pessoa_id'])->first();
        if (!$pessoas) {
            throw new AtendimentoException('País não identificado. Tente novamente ou entre em contato com o suporte.');
        }

        $profissional = Profissional::where('id', '=', $dados['profissional_id'])->where('active', '=', 'yes')->first();
        if (!$profissional) {
            throw new AtendimentoException('Profissional não identificado');
        }

        $filial = Filial::where('id', '=', $dados['filial_id'])->where('active', '=', 'yes')->first();
        if (!$filial) {
            throw new AtendimentoException('Filial não identificada');
        }

        $horario = null;
        if (isset($dados['horario_id']) && $dados['horario_id'] > 0) {

            $horario = HoraProfExpediente::where('id', '=', $dados['horario_id'])->where('active', '=', 'yes')->first();
            if (!$horario) {
                throw new AtendimentoException('Horário não identificado');
            }
        }

        $hrInico = $dados['hr_inicio'] ? $dados['hr_inicio'] : ($horario ? $horario->hora : null);

        $dtInico = $dados['dt_inicio'] ?? $dados['dt_inicio'];

        $agenda = Agenda::where('pessoa_id', '=', $profissional->pessoa->id)
            ->where('active', '=', 'yes')->where('data', '=', $dtInico)
            ->where('hora', '=', $hrInico)->whereIn('status', ['pendente'])->first();

        if ($agenda) {
            throw new AtendimentoException('O profissional ecolhido não está mais com esse horário disponível. Tente ecolher um outro horário, por favor.');
        }

        $dadosRequest = [];

        $dadosRequest['user_id']            = \Auth::User()->id;
        $dadosRequest['name']               = $dados['name'];
        $dadosRequest['historico']          = $dados['historico'];
        $dadosRequest['pessoa_id']          = $pessoas->id;
        $dadosRequest['dt_inicio']          = $dtInico;
        $dadosRequest['hr_inicio']          = $hrInico;
        $dadosRequest['prioridade']         = $dados['prioridade'];
        $dadosRequest['status']             = $dados['status'] ?? 'pendente';
        $dadosRequest['dt_fim']             = $dados['dt_fim'];
        $dadosRequest['hr_fim']             = $dados['hr_fim'];
        $dadosRequest['name_atendido']      = $dados['name_atendido'];
        $dadosRequest['tipo']               = $dados['tipo'] ?? 'consulta';
        $dadosRequest['profissional_id']    = $profissional->id;
        $dadosRequest['filial_id']          = $filial->id;
        $dadosRequest['active']             = 'yes';



        //-------------------------------------------
        //Appointment $appointment

        $objRepo = new EloquentAppointmentRepository();
        $objCreateHandler = new CreateAppointmentHandler($objRepo);
        $objServiceAppointment = new AppointmentApplicationService($objCreateHandler);

        $command = new CreateAppointmentCommand();
        $command->appointmentId(0)
            ->appointmentStartDate($dtInico)
            ->appointmentPersonId($pessoas->id)
            ->appointmentStartHour($hrInico)
            ->appointmentEndDate($dados['dt_fim'] ?? '')
            ->appointmentEndHour($dados['hr_fim'] ?? '')
            ->appointmentProfessionalId($profissional->id)
            ->appointmentBranchId($filial->id)
            ->appointmentName($pessoas->name)
            ->appointmentNickname($dados['name'])
            ->appointmentReminder($dados['historico'])
            ->appointmentPriority($dados['prioridade'])
            ->appointmentType($dados['tipo'] ?? 'consulta')
            ->appointmentActive('yes')
            ->appointmentUserId(\Auth::User()->id)
            ->appointmentStatus($dados['status'] ?? 'pendente');

        $newAppointment = $objServiceAppointment->createAppointment($command);

        $registro = Atendimento::find((string)$newAppointment->getId());
        //$registro = Atendimento::create($dadosRequest);
        if (!$registro) {
            throw new AtendimentoException('Erro ao registrar atendimento');
        }

        $dadosRequest = [];

        $dadosRequest['user_id']            = \Auth::User()->id;
        $dadosRequest['descricao']          = ucfirst($dados['tipo'] ?? 'consulta');
        $dadosRequest['data']               = $dados['dt_inicio'];
        $dadosRequest['hora']               = $dados['hr_inicio'];
        $dadosRequest['name_atendido']      = $dados['name_atendido'];
        $dadosRequest['status']             = 'pendente';
        $dadosRequest['pessoa_id']          = $profissional->pessoa_id;
        $dadosRequest['referencia']         = 'atendimentos';
        $dadosRequest['referencia_id']      = $registro->id;
        $dadosRequest['active']             = 'yes';

        $registroAgenda = Agenda::create($dadosRequest);
        if (!$registroAgenda) {
            throw new AtendimentoException('Erro ao registrar agenda');
        }

        //-------------------------------------------

        /* $objRepo = new EloquentNotificationRepository();
        $objCreatHandler = new CreateNotificationHandler($objRepo);
        $objServiceNotification = new NotificationApplicationService($objCreatHandler);

        $sender = new WhatsAppOfficialApi();
        $notification = new Notification();
        $notification->setTargetContactAddress(new NotificationTargetContactAddress('5598984257623'));
        $notification->setTargetContactName(new NotificationTargetContactName($registro->pessoa->name));
        $objServiceNotification->sender($sender);
        $response = $objServiceNotification->sendNotification($notification); */
        $notificationResponse = $this->createNotificationAppointment($newAppointment);

        if (!$notificationResponse) {
            throw new AtendimentoException('Was not possible to create the appointment notification.');
        }
        return $registro;
    }

    public function createNotificationAppointment(Appointment $appointment)
    {
        $objRepo = new EloquentNotificationRepository();
        $objCreateHandler = new CreateNotificationHandler($objRepo);
        $objServiceNotification = new NotificationApplicationService($objCreateHandler);
        $sender = new WhatsAppOfficialApi();
        $objServiceNotification->sender($sender);
        $objServiceNotification->templateRepository(new EloquentTemplateRepository());
        $objServiceNotification->templateVariableRepository(new EloquentTemplateVariableRepository());

        $objVariableRepo = new EloquentNotificationVariableRepository();
        $objVariableCreateHandler = new CreateNotificationVariableHandler($objVariableRepo);
        //$objServiceNotificationVariable = new NotificationApplicationService($objCreateHandler);
        $objServiceNotification->createNotificationVariableHandler($objVariableCreateHandler);


        return $objServiceNotification->createAppointmentNotification($appointment);

        /**
         * //---Alimentar variaveis
        $idTemplateLoad = 1;
        $templateCommandObj = new CreateTemplateCommand();
        $templateCommandObj->templateId($idTemplateLoad);
        $idTemplate = new TemplateId($templateCommandObj->getTemplateId());

        $notification = new Notification();
        $notification->setTargetContactAddress(new NotificationTargetContactAddress('5598984257623'));
        $notification->setTargetContactName(new NotificationTargetContactName((string) $appointment->getName()));

        //$templateObj = $this->templateRepository->findById($idTemplate);
        $templateObj = new WhatsAppTemplate();
        $templateObj->setLanguage(new TemplateLanguage('en_US'));
        $templateObj->setTitle(new TemplateTitle('confirm_service'));

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string)$appointment->getName()));
        $varOj->setVariable(new TemplateVariableSyntax('{{1}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);


        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string)'Studio Beleza'));
        $varOj->setVariable(new TemplateVariableSyntax('{{2}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) $appointment->getStartDate()));
        $varOj->setVariable(new TemplateVariableSyntax('{{3}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) $appointment->getStartHour()));
        $varOj->setVariable(new TemplateVariableSyntax('{{4}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) "Skin care"));
        $varOj->setVariable(new TemplateVariableSyntax('{{5}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) "Rua das Amoras, Brazil"));
        $varOj->setVariable(new TemplateVariableSyntax('{{6}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) "+55(98)984257623"));
        $varOj->setVariable(new TemplateVariableSyntax('{{7}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string) "http://localhost:3000"));
        $varOj->setVariable(new TemplateVariableSyntax('{{7}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $notification->setTemplate($templateObj);
         */
    }

    public function info($dados, $id)
    {

        $id = $id ?? $dados['id'];
        $callBack = $dados['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ($id <= 0) {
            throw new AtendimentoException('Parâmetro ínválido');
        }

        \DB::beginTransaction();

        $registro = Atendimento::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if ($registro == null) {
            throw new AtendimentoException('Registro não encontrado');
        }

        $registro->profissional;
        $registro->profissional->pessoa;
        $registro->pessoa;

        return $registro;
    }

    public function qtdAtendimentosPorTipo()
    {
        $rawSqlId = \DB::raw('COUNT(atendimentos.id)');
        $rawSqlTpAtendimento = \DB::raw('IFNULL(atendimentos.tipo, "SEM TIPO")');

        $data['campos'] = [
            \DB::raw('COUNT(atendimentos.id) as qtdAtendimentos'),
            \DB::raw('IFNULL(atendimentos.tipo, "SEM TIPO") as tpAtendimento'),
        ];

        $data['raw_grop_by']        = "{$rawSqlTpAtendimento}";

        return $this->json($data);
    }


    public function json(array $dados)
    {
        $consulta = $dados;

        if (!isset($consulta['ordem'])) {
            $consulta['ordem'] = 'atendimentos.id-desc';
        }

        $ordem      = $consulta['ordem'] ?? 'atendimentos.id-desc';
        $tpUser     = \Auth::User()->type;
        $pessoaUser = \Auth::User()->pessoa;

        if ($tpUser == 'external') {
            $consulta['pessoa_id'] = $pessoaUser->id;
        }

        $campos =  $dados['campos'] ?? [];
        $parse = [
            'name_atendimento' => 'atendimentos.name',
            'name_pessoa' => 'pessoas.name',
            'id' => 'atendimentos.id',
            'tipo' => 'atendimentos.tipo',
            'status' => 'atendimentos.status',
            'prioridade' => 'atendimentos.prioridade',
            'filial_id' => 'atendimentos.filial_id',
            'pessoa_id' => 'atendimentos.pessoa_id',
            'profissional_id' => 'atendimentos.profissional_id',
            'ds_cancelamento' => 'atendimentos.ds_cancelamento',
            'vr_atendimento' => 'atendimentos.vr_atendimento',
            'historico' => 'atendimentos.historico',

        ];

        $registro = \DB::table('atendimentos');
        $registro->join('pessoas', function ($join) {

            $join->on('pessoas.id', '=', 'atendimentos.pessoa_id');
        })->join("profissionals as p", function ($join) {
            $join->on('p.id', '=', 'atendimentos.profissional_id');
        })->join("pessoas as ppf", function ($join) {
            $join->on("ppf.id", '=', 'p.pessoa_id');
        });

        if (is_array($consulta) && count($consulta) > 0) {
            foreach ($consulta as $key => $val) {

                switch (trim($key)) {
                    case 'id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);

                        $registro->whereIn('atendimentos.id', $val);

                        break;
                    case 'status':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('atendimentos.status', $val);
                        }
                        break;

                    case 'prioridade':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('atendimentos.prioridade', $val);
                        }
                        break;


                    case 'tipo':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('atendimentos.tipo', $val);
                        }
                        break;

                    case 'historico':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('atendimentos.historico', 'like', '%' . $val . '%');
                        }
                        break;
                    case 'name_atendido':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('atendimentos.name_atendido', 'like', '%' . $val . '%');
                        }
                        break;

                    case 'name_profissional':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('ppf.name', 'like', '%' . $val . '%');
                        }
                        break;
                    case 'profissional_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }


                        $val = explode(',', $val);

                        $registro->whereIn('p.id', $val);

                        break;

                    case 'filial_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }


                        $val = explode(',', $val);

                        $registro->whereIn('atendimentos.filial_id', $val);

                        break;
                    case 'name':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('pessoas.name', 'like', '%' . $val . '%');
                        }
                    case 'name_pessoa':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('pessoas.name', 'like', '%' . $val . '%');
                        }
                        break;
                    case 'pessoa_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);

                        $registro->whereIn('atendimentos.pessoa_id', $val);

                        break;
                    case 'dt_periodo':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $val = explode(',', $val);

                            $registro->where('atendimentos.created_at', '>=', $val[0] . ' 00:00:00');
                            $registro->where('atendimentos.created_at', '<=', $val[1] . ' 23:59:59');
                        }
                        break;
                    case 'atendimento_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('atendimentos.id', '=', '' . $val . '');
                        }
                        break;
                    case 'limite':
                        $val = (int) $val;
                        if (is_integer($val) && $val > 0) {

                            $registro->limit($val);
                        }
                        break;
                    case 'ordem':


                        if ($val[0] == ',') {
                            $val = substr($val, 1);
                        }
                        if ($val[strlen($val) - 1] == ',') {
                            $val = substr($val, 0, -1);
                        }

                        $val = explode(',', $val);
                        for ($i = 0; !($i == count($val)); $i++) {
                            $atual = explode('-', $val[$i]);
                            if (array_key_exists(trim($atual[0]), $parse)) {

                                $parsed = $parse[trim($atual[0])];

                                if ($parsed) {

                                    $registro->orderBy($parsed, $atual[1]);
                                }
                            }
                        }

                        break;

                    case 'campos':
                        if (is_array($val) && count($val) > 0) {
                            //$campos = $this->montaCamposConsulta($registro, $val);
                        }
                        break;
                    case 'grop_by':
                        $registro->groupBy($val);
                        break;
                    case 'raw_grop_by':
                        $registro->groupByRaw($val);
                        break;
                }
            }
        }
        if ($campos) {
            $registro->select($campos);
        } else {
            $registro->select('atendimentos.*', 'pessoas.name as name_pessoa', 'ppf.name as name_profissional');
        }

        //----
        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        if ($usePaginate > 0) {
            $registro   = $registro->where('atendimentos.active', '=', 'yes')
                ->whereNull('atendimentos.deleted_at')
                ->where('pessoas.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('atendimentos.active', '=', 'yes')
                ->whereNull('atendimentos.deleted_at')
                ->where('pessoas.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->get();
        }

        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];
            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }

        return $registro;
    }
}
