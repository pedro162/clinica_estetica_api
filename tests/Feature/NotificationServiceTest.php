<?php

namespace Tests\Feature;

use App\Application\Handlers\CreateNotificationHandler;
use App\Application\Services\NotificationApplicationService;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\ValueObjects\NotificationTargetContactAddress;
use App\Domain\Notification\ValueObjects\NotificationTargetContactName;
use App\Infrastructure\Persistence\Eloquent\EloquentNotificationRepository;
use App\Infrastructure\Services\Notifications\Whatsapp\WhatsAppOfficialApi;
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
        $this->notificationApplicationService->sender($sender);
        $response = $this->notificationApplicationService->sendNotification($notification);

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
