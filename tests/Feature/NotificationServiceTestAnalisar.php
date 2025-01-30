<?php

namespace Tests\Feature;

use App\Application\Commands\CreateAppointmentCommand;
use App\Application\Commands\CreateTemplateCommand;
use App\Application\Handlers\CreateAppointmentHandler;
use App\Application\Handlers\CreateNotificationHandler;
use App\Application\Services\AppointmentApplicationService;
use App\Application\Services\NotificationApplicationService;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\ValueObjects\NotificationMessage;
use App\Domain\Notification\ValueObjects\NotificationTargetContactAddress;
use App\Domain\Notification\ValueObjects\NotificationTargetContactName;
use App\Domain\Notification\ValueObjects\NotificationTemplateId;
use App\Domain\Template\Entities\WhatsAppTemplate;
use App\Domain\Template\ValueObjects\TemplateId;
use App\Domain\Template\ValueObjects\TemplateLanguage;
use App\Domain\Template\ValueObjects\TemplateTitle;
use App\Domain\TemplateVariable\Entities\TemplateVariable;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableId;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableSyntax;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableValue;
use App\Filial;
use App\Infrastructure\Persistence\Eloquent\EloquentAppointmentRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentNotificationRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentTemplateRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentTemplateVariableRepository;
use App\Infrastructure\Services\Notifications\Whatsapp\WhatsAppOfficialApi;
use App\Jobs\SendNotification;
use App\Notification as AppNotification;
use App\Pessoa;
use App\Profissional;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Mockery\MockInterface;
use Laravel\Passport\Passport;
use Tests\TestCase;


class NotificationServiceTest extends TestCase
{
    protected NotificationApplicationService $notificationApplicationService;
    protected AppointmentApplicationService $appointmentApplicationService;

    //Test Documentatin: https://www.devmedia.com.br/teste-unitario-com-phpunit/41231#assertgreaterthan-
    ///opt/lampp$ sudo ./manager-linux-x64.run


    protected function setUp(): void
    {
        parent::setUp();

        // Cria um usuário fictício para teste
        $user = factory(User::class)->create();

        // Define o usuário como autenticado via Passport
        Passport::actingAs($user);

        $objSetup = new SetupTest();
        $objSetup->settingUpUser();
        $this->testNotificationApplicationServiceBootstrap();
    }

    public function testSendNotificationById()
    {
        $response = $this->notificationApplicationService->sendNotificationOfId((string)(factory(AppNotification::class)->create()->id));
        $this->assertTrue($response);
    }

    /**
     * Attempt to create a notification using the DDD Service class resource
     *@return void
     */
    public function testCreateNotificationFromAppointmentData()
    {
        $objRepo = new EloquentNotificationRepository();
        $objCreateHandler = new CreateNotificationHandler($objRepo);
        $objServiceNotification = new NotificationApplicationService($objCreateHandler);
        $sender = new WhatsAppOfficialApi();
        $objServiceNotification->sender($sender);
        $objServiceNotification->templateRepository(new EloquentTemplateRepository());
        $objServiceNotification->templateVariableRepository(new EloquentTemplateVariableRepository());

        $command = new CreateAppointmentCommand();
        $command->appointmentId(0)
            ->appointmentStartDate("2024-06-30")
            ->appointmentPersonId(factory(Pessoa::class)->create()->id)
            ->appointmentStartHour('10:45')
            ->appointmentEndDate('')
            ->appointmentEndHour('')
            ->appointmentProfessionalId(factory(Profissional::class)->create()->id)
            ->appointmentBranchId(factory(Filial::class)->create()->id)
            ->appointmentName('José')
            ->appointmentNickname('Pedro')
            ->appointmentReminder("Test")
            ->appointmentPriority('alta')
            ->appointmentType('consulta')
            ->appointmentActive('yes')
            ->appointmentUserId(factory(User::class)->create()->id)
            ->appointmentStatus('pendente');
        $appointment = $this->appointmentApplicationService->createAppointment($command);
        $response = $objServiceNotification->createAppointmentNotification($appointment);

        $idNotification = (string) $response->getId();
        $idNotification = (int) $idNotification;

        $this->assertGreaterThan(0, $idNotification, "it was not possible to create a natural person");
    }

    /**
     * Attempt to create a notification using the DDD Service class resource
     *@return void
     */
    public function testSendNotificationOfServiceConfirmationWhatsApp()
    {
        $sender = new WhatsAppOfficialApi();

        $mockSender = $this->getMockBuilder(WhatsAppOfficialApi::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->onlyMethods(['send', 'sendMessageTemplate', 'sendMessageText'])
            ->getMock();
        $mockSender->expects($this->once())
            ->method('send')
            ->with(new Notification())
            ->willReturn(true);
        $mockSender->expects($this->once())
            ->method('sendMessageTemplate')
            ->with(new Notification())
            ->willReturn(true);

        $notification = new Notification();
        $notification->setTargetContactAddress(new NotificationTargetContactAddress('5598984257623'));
        $notification->setTargetContactName(new NotificationTargetContactName('Pedro'));
        $notification->setMessage(new NotificationMessage('Hello dear client'));

        //------------------
        $idTemplateLoad = 1;
        //$templateCommandObj = new CreateTemplateCommand();
        //$templateCommandObj->templateId($idTemplateLoad);
        //$idTemplate = new TemplateId($templateCommandObj->getTemplateId());

        //$templateObj = $this->templateRepository->findById($idTemplate);
        $templateObj = new WhatsAppTemplate();
        $templateObj->setLanguage(new TemplateLanguage('en_US'));
        $templateObj->setTitle(new TemplateTitle('confirm_service'));

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue('Pedro'));
        $varOj->setVariable(new TemplateVariableSyntax('{{1}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);


        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue((string)'Studio Beleza'));
        $varOj->setVariable(new TemplateVariableSyntax('{{2}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue("2024-06-30"));
        $varOj->setVariable(new TemplateVariableSyntax('{{3}}'));
        $varOj->setId(new TemplateVariableId(0));
        $templateObj->addVariable($varOj);

        $varOj = new TemplateVariable();
        $varOj->setValue(new TemplateVariableValue("10:30 A.M"));
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

        //--------------------------
        //---No send notification $this->notificationApplicationService->sender($sender);

        $response = $this->notificationApplicationService->sender($mockSender);
        //$resp = SendNotification::dispatch('1')->onQueue('notifications');
        //dd($resp);
        ///opt/lampp/htdocs/html# docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' rabbitmq

        //$response = $this->notificationApplicationService->sendNotification($notification);
        //$response = false;
        $this->assertTrue($response, 'Was not possible to send the message');
    }

    public function testSendWhatsAppOfficialApiTextNotification()
    {
        $sender = new WhatsAppOfficialApi();

        $notification = new Notification();
        $notification->setTemplateId(new NotificationTemplateId('0'));
        $notification->setTargetContactAddress(new NotificationTargetContactAddress('5598984257623'));
        $notification->setTargetContactName(new NotificationTargetContactName('Pedro'));
        $notification->setMessage(new NotificationMessage('Hello dear client'));
        $this->notificationApplicationService->sender($sender);
        $response = $this->notificationApplicationService->sendNotification($notification);
        $this->assertTrue($response);
    }

    private function testNotificationApplicationServiceBootstrap()
    {
        $objRepo = new EloquentNotificationRepository();
        $objCreatHandler = new CreateNotificationHandler($objRepo);
        $objServiceNotification = new NotificationApplicationService($objCreatHandler);
        $this->notificationApplicationService = $objServiceNotification;

        $objRepo = new EloquentAppointmentRepository();
        $objCreateHandler = new CreateAppointmentHandler($objRepo);
        $objServiceNotification = new AppointmentApplicationService($objCreateHandler);
        $this->appointmentApplicationService = $objServiceNotification;
    }
}
