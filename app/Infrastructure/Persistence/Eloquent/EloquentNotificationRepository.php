<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\Repositories\NotificationRepositoryInterface;
use App\Domain\Notification\ValueObjects\NotificationDocument;
use App\Domain\Notification\ValueObjects\NotificationEmail;
use App\Domain\Notification\ValueObjects\NotificationExtraDocument;
use App\Domain\Notification\ValueObjects\NotificationId;
use App\Domain\Notification\ValueObjects\NotificationMessage;
use App\Domain\Notification\ValueObjects\NotificationSex;
use Illuminate\Support\Facades\DB;
use App\Pessoa;
use App\User;

class EloquentNotificationRepository implements NotificationRepositoryInterface
{
    public function save(Notification $notification): ?Notification
    {
        //Todo
        //Implement an object model instance and save or update within database, after that, return the object notification implementation
        $notificationId = (string) $notification->getId();
        $notificationId = (int) $notificationId;
        $userId   = User::first()->id;
        if ($notificationId > 0) {
            //update
            $notificationMomel = Pessoa::where('id', '=', $notificationId)->first();
            $notificationMomel->updated([
                'message' => $notification->getMessage(),
                //'users_create_id'
                //'users_update_id'   
            ]);
        } else {
            //create
            $notificationMomel = Pessoa::create([
                'message' => $notification->getMessage(),
                'user_id' => $userId
            ]);
            $notification->setId(new NotificationId($notificationMomel->id));
        }

        return $this->findById($notification->getId());
    }
    public function findById(NotificationId $id): ?Notification
    {
        $notification = DB::table('pessoas')->where('id', '=', (string)$id)->first();
        if ($notification) {
            $objNotification =  new Notification();
            $objNotification->setId(new NotificationId($notification->id));
            return $objNotification;
        }
        return null;
    }
}
