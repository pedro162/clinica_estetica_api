<?php

namespace Tests\Feature;

use App\Application\Commands\CreateTemplateCommand;
use App\Application\Handlers\CreateNotificationHandler;
use App\Application\Services\NotificationApplicationService;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\ValueObjects\NotificationMessage;
use App\Domain\Notification\ValueObjects\NotificationTargetContactAddress;
use App\Domain\Notification\ValueObjects\NotificationTargetContactName;
use App\Domain\Template\Entities\WhatsAppTemplate;
use App\Domain\Template\ValueObjects\TemplateId;
use App\Domain\Template\ValueObjects\TemplateLanguage;
use App\Domain\Template\ValueObjects\TemplateTitle;
use App\Domain\TemplateVariable\Entities\TemplateVariable;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableId;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableSyntax;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableValue;
use App\Infrastructure\Persistence\Eloquent\EloquentNotificationRepository;
use App\Infrastructure\Services\Notifications\Whatsapp\WhatsAppOfficialApi;
use App\Jobs\SendNotification;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    protected NotificationApplicationService $notificationApplicationService;
    //Test Documentatin: https://www.devmedia.com.br/teste-unitario-com-phpunit/41231#assertgreaterthan-
    ///opt/lampp$ sudo ./manager-linux-x64.run


    protected function setUp(): void
    {
        parent::setUp();
        $objSetup = new SetupTest();
        $objSetup->settingUpUser();
        $this->testNotificationApplicationServiceBootstrap();
    }

    /**
     * Attempt to create a notification using the DDD Service class resource
     *@return void
     */
    public function testSendNotificationOfServiceConfirmationWhatsApp()
    {
        $sender = new WhatsAppOfficialApi();
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
        $this->notificationApplicationService->sender($sender);
        SendNotification::dispatch('9')->onQueue('notifications');
        //$response = $this->notificationApplicationService->sendNotification($notification);
        $response = false;
        $this->assertTrue($response);
    }

    /**
     * Attempt to create a notification using the DDD Service class resource
     *@return void
     */
    /* public function testCreateNaturalNotificationUsingServiceNotificationWithUseAnUrl()
    {
        $response = $this->notificationApplicationService->createNotification(0, 'Pedro', 'aguiar', '61224450370', '', 'm', '');

        $idNotification = (string) $response->getId();
        $idNotification = (int) $idNotification;
        $this->assertGreaterThan(0, $idNotification, "it was not possible to create a natural notification");
    } */

    private function testNotificationApplicationServiceBootstrap()
    {
        $objRepo = new EloquentNotificationRepository();
        $objCreatHandler = new CreateNotificationHandler($objRepo);
        $objServiceNotification = new NotificationApplicationService($objCreatHandler);
        $this->notificationApplicationService = $objServiceNotification;
    }

    /* private function settingUpUser(): void
    {
        if (!User::where('email', '=', 'admin@gmail.com')->first()) {
            User::create(['name' => 'admin', 'email' => 'admin@gmail.com',  'password' => bcrypt(123456)]);
        }
    } */
}
