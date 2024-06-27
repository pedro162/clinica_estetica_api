<?php

namespace App\Jobs;

use App\Application\Handlers\CreateNotificationHandler;
use App\Application\Services\NotificationApplicationService;
use App\Domain\Notification\Entities\Notification;
use App\Infrastructure\Persistence\Eloquent\EloquentNotificationRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $notification_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notification_id)
    {
        $this->notification_id = $notification_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notificationRepository = new EloquentNotificationRepository();
        $notificationHandler = new CreateNotificationHandler($notificationRepository);
        $notificationService = new NotificationApplicationService($notificationHandler);
        $notificationService->sendNotificationOfId($this->notification_id);
    }
}
