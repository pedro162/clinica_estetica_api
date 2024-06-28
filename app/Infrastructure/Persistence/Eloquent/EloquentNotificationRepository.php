<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\Repositories\NotificationRepositoryInterface;
use App\Domain\Notification\ValueObjects\NotificationDocument;
use App\Domain\Notification\ValueObjects\NotificationEmail;
use App\Domain\Notification\ValueObjects\NotificationExtraDocument;
use App\Domain\Notification\ValueObjects\NotificationId;
use App\Domain\Notification\ValueObjects\NotificationMessage;
use App\Domain\Notification\ValueObjects\NotificationOriginContactAddress;
use App\Domain\Notification\ValueObjects\NotificationSentDate;
use App\Domain\Notification\ValueObjects\NotificationSex;
use App\Domain\Notification\ValueObjects\NotificationShippingState;
use App\Domain\Notification\ValueObjects\NotificationTargetContactAddress;
use App\Domain\Notification\ValueObjects\NotificationTargetContactName;
use App\Domain\Notification\ValueObjects\NotificationTemplateId;
use App\Domain\Notification\ValueObjects\NotificationTitle;
use Illuminate\Support\Facades\DB;
use App\Notification as NotificationModel;
use App\User;

class EloquentNotificationRepository implements NotificationRepositoryInterface
{
    public function save(Notification $notification): ?Notification
    {

        /**'title',
        'message',
        'origin_contact_address',
        'target_contact_address',
        'target_contact_name',
        'template_id',
        'shipping_state',
        'sent_date',
        'user_id',
        'user_update_id',
        'active', */
        //Todo
        //Implement an object model instance and save or update within database, after that, return the object notification implementation
        $notificationId = (string) $notification->getId();
        $notificationId = (int) $notificationId;
        $userId   = User::first()->id;
        if ($notificationId > 0) {
            //update
            $notificationMomel = NotificationModel::where('id', '=', $notificationId)->first();
            $notificationMomel->updated([
                'title' => (string) $notification->getTitle(),
                'message' => (string) $notification->getMessage(),
                'origin_contact_address' => (string) $notification->getOriginContactAddress(),
                'target_contact_address' => (string) $notification->getTargetContactAddress(),
                'target_contact_name' => (string) $notification->getTargetContactName(),
                'template_id' => (string) $notification->getTemplateId(),
                'shipping_state' => (string) $notification->getShippingState(),
                'sent_date' => (string) $notification->getSentDate(),
                'user_id' => (string) $userId,
                'user_update_id' => null,
                'active' => 'yes',
            ]);
        } else {
            //create
            $notificationMomel = NotificationModel::create([
                'title' => (string) $notification->getTitle(),
                'message' => (string) $notification->getMessage(),
                'origin_contact_address' => (string) $notification->getOriginContactAddress(),
                'target_contact_address' => (string) $notification->getTargetContactAddress(),
                'target_contact_name' => (string) $notification->getTargetContactName(),
                'template_id' => (string) $notification->getTemplateId(),
                'shipping_state' => (string) $notification->getShippingState(),
                'sent_date' => (string) $notification->getSentDate(),
                'user_id' => (string) $userId,
                'user_update_id' => null,
                'active' => 'yes'
            ]);
            $notification->setId(new NotificationId($notificationMomel->id));
        }

        return $this->findById($notification->getId());
    }
    public function findById(NotificationId $id): ?Notification
    {
        $notification = DB::table('notifications')->where('id', '=', (string)$id)->first();
        if ($notification) {
            $objNotification =  new Notification();
            $objNotification->setId(new NotificationId($notification->id))
                ->setTitle(new NotificationTitle($notification->title))
                ->setMessage(new NotificationMessage($notification->message))
                ->setTemplateId(new NotificationTemplateId($notification->template_id))
                ->setTargetContactAddress(new NotificationTargetContactAddress($notification->target_contact_address))
                ->setTargetContactName(new NotificationTargetContactName($notification->target_contact_name))
                ->setOriginContactAddress(new NotificationOriginContactAddress($notification->origin_contact_address))
                ->setSentDate(new NotificationSentDate($notification->sent_date))
                ->setShippingState(new NotificationShippingState($notification->shipping_state));
            return $objNotification;
        }
        return null;
    }
}
