<?php

namespace App\Helpers;

use App\Application\Commands\CreateNotificationCommand;
use App\Application\Handlers\CreateNotificationHandler;
use App\Application\Services\NotificationApplicationService;
use App\Exceptions\NotificationException;
use App\Filial;
use App\Infrastructure\Persistence\Eloquent\EloquentNotificationRepository;
use App\Notification as AppNotification;
use App\Parametro;
use App\Pessoa;
use App\Validators\NotificationValidator;

class NotificationHelper extends BaseHelper
{
    public const USE_NOTIFICATION_SERVICE = true;
    public const NOTIFICATION_TYPE_EMAIL = 'email';
    public const NOTIFICATION_TYPE_WHATSAPP = 'whatsapp';
    public const NOTIFIATION_TYPE = [
        self::NOTIFICATION_TYPE_EMAIL,
        self::NOTIFICATION_TYPE_WHATSAPP,
    ];
    protected static $TENANT_ID;

    public function __construct()
    {

        self::$TENANT_ID = \Auth::User()->tenant_id;
    }

    public function store(array $dados, $id = 0)
    {
        NotificationValidator::validationCreate($dados);

        $pessoas = Pessoa::where('active', '=', 'yes')->where('id', '=', $dados['pessoa_id'])->first();
        if (!$pessoas) {
            throw new NotificationException('País não identificado. Tente novamente ou entre em contato com o suporte.');
        }

        $filial = Filial::where('id', '=', \Auth::User()->filial_id)->where('active', '=', 'yes')->first();
        if (!$filial) {
            throw new NotificationException('Filial não identificada');
        }

        $notificationType = $dados['type'] ?? self::NOTIFICATION_TYPE_EMAIL;

        switch ($notificationType) {
            case self::NOTIFICATION_TYPE_EMAIL:
                $emailParameters = $this->getParamEmail();
                $dados['origin_contact_address'] = $emailParameters['domain'];
                break;
            case self::NOTIFICATION_TYPE_WHATSAPP:
                $emailParameters = $this->getParamWhatsApp();
                $dados['origin_contact_address'] = $emailParameters['whatsapp_number'];
                break;
        }

        $objRepo = new EloquentNotificationRepository();
        $objCreateHandler = new CreateNotificationHandler($objRepo);
        $objServiceNotification = new NotificationApplicationService($objCreateHandler);

        if ($id) {
            $command = new CreateNotificationCommand();
            $command->notificationId($id);
            $notificationEntity = $objServiceNotification->findById($command);
            $entityId = $notificationEntity->getId();
            $entityId = (string) $entityId;
            $entityId = (int) $entityId;
            if (!$entityId > 0) {
                throw new NotificationException('Registro não identificado.');
            }
        }

        $command = new CreateNotificationCommand();
        $command->notificationId($id)
            ->notificationTemplateId(0)
            ->notificationSentDate(date('Y-m-d H:i:s'))
            ->notificationTitle($dados['title'])
            ->notificationMessage($dados['message'])
            ->notificationOriginContactAddress($dados['origin_contact_address'])
            ->notificationTargetContactAddress($dados['target_contact_address'])
            ->notificationTargetContactName($pessoas->name)
            ->notificationTenantId(self::$TENANT_ID)
            ->notificationShippingState('waiting');

        $newNotification = $objServiceNotification->createNotification($command);
        $registro = AppNotification::where('tenant_id', '=', self::$TENANT_ID)->find((string)$newNotification->getId());
        //$registro = AppNotification::create($dadosRequest);
        if (!$registro) {
            throw new NotificationException('Erro ao registrar notificação');
        }

        return $registro;
    }

    public function emailStore(array $dados, $id = 0)
    {
        $dados['type'] = self::NOTIFICATION_TYPE_EMAIL;
        NotificationValidator::validationCreate($dados);
        $registro = $this->store($dados);
        return $registro;
    }

    public function whatsAppStore(array $dados, $id = 0)
    {
        $dados['type'] = self::NOTIFICATION_TYPE_WHATSAPP;
        NotificationValidator::validationCreate($dados);
        $registro = $this->store($dados);
        return $registro;
    }

    public function info($dados, $id)
    {

        $id = $id ?? $dados['id'];
        $callBack = $dados['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ($id <= 0) {
            throw new NotificationException('Parâmetro ínválido');
        }

        $registro = AppNotification::where('tenant_id', '=', self::$TENANT_ID)->where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if ($registro == null) {
            throw new NotificationException('Registro não encontrado');
        }

        return $registro;
    }

    public function destroy($id)
    {
        $objRepo = new EloquentNotificationRepository();
        $objCreateHandler = new CreateNotificationHandler($objRepo);
        $objServiceNotification = new NotificationApplicationService($objCreateHandler);
        $objServiceNotification->delete($id);
    }

    public function json(array $dados)
    {
        $consulta = $dados;

        if (!isset($consulta['ordem'])) {
            $consulta['ordem'] = 'notifications.id-desc';
        }

        $ordem      = $consulta['ordem'] ?? 'notifications.id-desc';
        $tpUser     = \Auth::User()->type;
        $pessoaUser = \Auth::User()->pessoa;

        if ($tpUser == 'external') {
            $consulta['pessoa_id'] = $pessoaUser->id;
        }

        $campos =  $dados['campos'] ?? [];
        $parse = [
            'id' => 'notifications.id',

        ];

        $registro = \DB::table('notifications');

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

                        $registro->whereIn('notifications.id', $val);

                        break;
                    case 'status':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }
                        $val = explode(',', $val);
                        $registro->whereIn('notifications.shipping_state', $val);

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

                            $registro->whereIn('notifications.prioridade', $val);
                        }
                        break;
                    case 'title':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }
                        $registro->where('notifications.title', 'like', '%' . $val . '%');

                        break;
                    case 'message':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }
                        $registro->where('notifications.message', 'like', '%' . $val . '%');
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

                            $registro->where('notifications.created_at', '>=', $val[0] . ' 00:00:00');
                            $registro->where('notifications.created_at', '<=', $val[1] . ' 23:59:59');
                        }
                        break;
                    case 'notification_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('notifications.id', '=', '' . $val . '');
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
            $registro->select('notifications.*');
        }
        $registro->where('tenant_id', '=', self::$TENANT_ID);

        //----
        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        if ($usePaginate > 0) {
            $registro   = $registro->where('notifications.active', '=', 'yes')
                ->whereNull('notifications.deleted_at')
                ->where('pessoas.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('notifications.active', '=', 'yes')
                ->whereNull('notifications.deleted_at')
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

    public function getParamEmail()
    {
        $parameter = Parametro::where('key', '=', 'email')->where('type', '=', 'default')->where('active', '=', 'yes')->first();
        $fileds = $parameter->parametroCampo;
        $configParameters = [
            'transport' => null,
            'domain' => null,
            'secret' => null,

        ];
        foreach ($fileds as $field) {
            $currentKey = $field->key;
            $currentValue = $field->parametroUser()->where('active', '=', 'yes')->first();
            switch (trim($currentKey)) {
                case 'transport':
                    $configParameters['transport'] = $currentValue->p_value;
                    break;
                case 'domain':
                    $configParameters['domain'] = $currentValue->p_value;
                    break;
                case 'secret':
                    $configParameters['secret'] = $currentValue->p_value;
                    break;
                default:
            }
        }

        return $configParameters;
    }

    public function getParamWhatsApp()
    {
        $parameter = Parametro::where('key', '=', 'whatsapp')->where('type', '=', 'default')->where('active', '=', 'yes')->first();
        $fileds = $parameter->parametroCampo;
        $configParameters = [
            'whatsapp_number' => null,
        ];
        foreach ($fileds as $field) {
            $currentKey = $field->key;
            $currentValue = $field->parametroUser()->where('active', '=', 'yes')->first();
            switch (trim($currentKey)) {
                case 'whatsapp_number':
                    $configParameters['whatsapp_number'] = $currentValue->p_value;
                    break;
                default:
            }
        }

        return $configParameters;
    }
}
