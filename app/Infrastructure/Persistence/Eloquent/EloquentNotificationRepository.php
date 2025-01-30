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
use App\Domain\Notification\ValueObjects\NotificationTenantId;
use App\Domain\Notification\ValueObjects\NotificationTitle;
use Illuminate\Support\Facades\DB;
use App\Notification as NotificationModel;
use App\User;
use Illuminate\Support\Facades\Auth;

class EloquentNotificationRepository implements NotificationRepositoryInterface
{
    public function save(Notification $notification): ?Notification
    {

        //Todo
        //Implement an object model instance and save or update within database, after that, return the object notification implementation
        $notificationId = (string) $notification->getId();
        $notificationId = (int) $notificationId;
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $templateId =  (string) $notification->getTemplateId();
        $templateId = (int) $templateId;

        if (!$templateId > 0) $templateId = null;

        if ($notificationId > 0) {
            //update
            $notificationMomel = NotificationModel::where('id', '=', $notificationId)->first();
            $notificationMomel->updated([
                'title' => (string) $notification->getTitle(),
                'message' => (string) $notification->getMessage(),
                'origin_contact_address' => (string) $notification->getOriginContactAddress(),
                'target_contact_address' => (string) $notification->getTargetContactAddress(),
                'target_contact_name' => (string) $notification->getTargetContactName(),
                'template_id' => $templateId,
                'shipping_state' => (string) $notification->getShippingState(),
                'tenant_id' => $tenantId ?? null,
                'sent_date' => (string) $tenantId,
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
                'template_id' => $templateId,
                'shipping_state' => (string) $notification->getShippingState(),
                'sent_date' => (string) $notification->getSentDate(),
                'tenant_id' => (string) $tenantId,
                'user_id' => (string) $userId,
                'user_update_id' => null,
                'active' => 'yes'
            ]);
            $notification->setId(new NotificationId($notificationMomel->id));
        }

        return $this->findById($notification->getId());
    }

    public function delete(Notification $notification)
    {
        $notificationId = (string) $notification->getId();
        $notificationId = (int) $notificationId;
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;
        $notificationMomel = NotificationModel::where('tenant_id', '=', $tenantId)->where('id', '=', $notificationId)->first();

        if ($notificationMomel) {
            $notificationMomel->updated([
                'active' => 'no',
            ]);

            $notificationMomel->delete();
        }
    }

    public function findById(NotificationId $id): ?Notification
    {
        $userId   = Auth::user()->id;
        $tenantId   = Auth::user()->tenant_id;

        $notification = DB::table('notifications')->where('id', '=', (string)$id)->first();

        if ($notification) {
            $objNotification =  new Notification();
            $objNotification->setId(new NotificationId($notification->id))
                ->setTitle(new NotificationTitle($notification->title))
                ->setMessage(new NotificationMessage($notification->message))
                ->setTemplateId(new NotificationTemplateId($notification->template_id > 0 ? $notification->template_id : 0))
                ->setTargetContactAddress(new NotificationTargetContactAddress($notification->target_contact_address))
                ->setTargetContactName(new NotificationTargetContactName($notification->target_contact_name))
                ->setOriginContactAddress(new NotificationOriginContactAddress($notification->origin_contact_address))
                ->setTenantId(new NotificationTenantId($notification->tenant_id))
                ->setSentDate(new NotificationSentDate($notification->sent_date ?? ''))
                ->setShippingState(new NotificationShippingState($notification->shipping_state));
            return $objNotification;
        }
        return null;
    }
}
