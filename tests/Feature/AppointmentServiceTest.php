<?php

namespace Tests\Feature;

use App\Application\Commands\CreateAppointmentCommand;
use App\Application\Handlers\CreateAppointmentHandler;
use App\Application\Handlers\CreateNotificationHandler;
use App\Application\Services\AppointmentApplicationService;
use App\Application\Services\NotificationApplicationService;
use App\Filial;
use App\Infrastructure\Persistence\Eloquent\EloquentAppointmentRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentNotificationRepository;
use App\Infrastructure\Services\Notifications\Whatsapp\WhatsAppOfficialApi;
use App\Pessoa;
use App\Profissional;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AppointmentServiceTest extends TestCase
{
    protected AppointmentApplicationService $appointmentApplicationService;
    //Test Documentatin: https://www.devmedia.com.br/teste-unitario-com-phpunit/41231#assertgreaterthan-
    ///opt/lampp$ sudo ./manager-linux-x64.run


    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate', ['--force']);
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
        $person = Pessoa::where('id', '>', '1')->first();
        $branch = Filial::where('id', '>', '1')->first();
        $command = new CreateAppointmentCommand();
        $command->appointmentId(0)
            ->appointmentStartDate("2024-06-30")
            ->appointmentPersonId(1)
            ->appointmentStartHour('10:45')
            ->appointmentEndDate('')
            ->appointmentEndHour('')
            ->appointmentProfessionalId(3)
            ->appointmentBranchId(1)
            ->appointmentName('José')
            ->appointmentNickname('Pedro')
            ->appointmentReminder("Test")
            ->appointmentPriority('alta')
            ->appointmentType('consulta')
            ->appointmentActive('yes')
            ->appointmentUserId(1)
            ->appointmentStatus('pendente');

        //--------------------------
        $appointment = $this->appointmentApplicationService->createAppointment($command);

        /* $objRepo = new EloquentNotificationRepository();
        $objCreatHandler = new CreateNotificationHandler($objRepo);
        $objServiceNotification = new NotificationApplicationService($objCreatHandler);
        $sender = new WhatsAppOfficialApi();
        $objServiceNotification->sender($sender);
        return $objServiceNotification->createAppointmentNotification($appointment); */
        $idAppointment = (string) $appointment->getId();
        $idAppointment = (int) $idAppointment;
        $this->assertGreaterThan(0, 1, "it was not possible to create the appointment");
    }

    /**
     * Attempt to create a notification using the DDD Service class resource
     *@return void
     */
    /* public function testCreateNaturalNotificationUsingServiceNotificationWithUseAnUrl()
    {
        $response = $this->appointmentApplicationService->createNotification(0, 'Pedro', 'aguiar', '61224450370', '', 'm', '');

        $idNotification = (string) $response->getId();
        $idNotification = (int) $idNotification;
        $this->assertGreaterThan(0, $idNotification, "it was not possible to create a natural notification");
    } */

    private function testNotificationApplicationServiceBootstrap()
    {
        $objRepo = new EloquentAppointmentRepository();
        $objCreateHandler = new CreateAppointmentHandler($objRepo);
        $objServiceNotification = new AppointmentApplicationService($objCreateHandler);
        $this->appointmentApplicationService = $objServiceNotification;
    }
}
