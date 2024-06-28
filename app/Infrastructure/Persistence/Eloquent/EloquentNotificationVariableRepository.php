<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\NotificationVariable\Entities\NotificationVariable;
use App\Domain\NotificationVariable\ValueObjects\NotificationId;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableId;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableSyntax;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableTemplateVariableId;
use App\Domain\NotificationVariable\ValueObjects\NotificationVariableValue;
use App\Domain\NotificationVariable\Repositories\NotificationVariableRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\NotificationVariable as NotificationVariableModel;
use App\User;


class EloquentNotificationVariableRepository implements NotificationVariableRepositoryInterface
{
    public function save(NotificationVariable $template): ?NotificationVariable
    {
        //Todo
        //Implement an object model instance and save or update within database, after that, return the object template implementation
        $templateId = (string) $template->getId();
        $templateId = (int) $templateId;
        $userId   = User::first()->id;
        if ($templateId > 0) {
            //update
            $templateMomel = NotificationVariableModel::where('id', '=', $templateId)->first();
            $templateMomel->updated([
                'syntax' => $template->getVariable(),
                'value' => $template->getValue(),
                'template_variable_id' => $template->getTemplateId(),
                'notification_id' => $template->getNotificationId(),
                'user_id' => $userId,
                'user_update_id' => null,
                'active' => 'yes',
            ]);
        } else {
            //create
            $templateMomel = NotificationVariableModel::create([
                'syntax' => $template->getVariable(),
                'value' => $template->getValue(),
                'template_variable_id' => $template->getTemplateId(),
                'notification_id' => $template->getNotificationId(),
                'user_id' => $userId,
                'user_update_id' => null,
                'active' => 'yes',
            ]);
            $template->setId(new NotificationVariableId($templateMomel->id));
        }

        return $this->findById($template->getId());
    }

    public function findById(NotificationVariableId $id): ?NotificationVariable
    {
        $template = DB::table('notification_variables')->where('id', '=', (string)$id)->first();
        if ($template) {
            $objNotificationVariable =  new NotificationVariable();
            $objNotificationVariable->setId(new NotificationVariableId($template->id ?? 0));
            $objNotificationVariable->setValue(new NotificationVariableValue($template->value ?? ''));
            $objNotificationVariable->setVariable(new NotificationVariableSyntax($template->syntax ?? ''));
            $objNotificationVariable->setTemplateId(new NotificationVariableTemplateVariableId($template->template_variable_id ?? 0));
            $objNotificationVariable->setNotificationId(new NotificationId($template->notification_id ?? 0));

            return $objNotificationVariable;
        }
        return null;
    }

    public function findByTemplateId(NotificationVariableTemplateVariableId $id): ?array
    {
        $template = DB::table('notification_variables')->where('active', '=', 'yes')->where('id', '=', (string)$id)->get();
        $variables = [];
        if ($template) {
            foreach ($template as $key => $variable) {
                $objNotificationVariable =  new NotificationVariable();
                $objNotificationVariable->setId(new NotificationVariableId($variable->id ?? 0));
                $objNotificationVariable->setValue(new NotificationVariableValue($variable->value ?? ''));
                $objNotificationVariable->setVariable(new NotificationVariableSyntax($variable->syntax ?? ''));
                $objNotificationVariable->setTemplateId(new NotificationVariableTemplateVariableId($variable->variable_id ?? 0));
                $objNotificationVariable->setNotificationId(new NotificationId($variable->template_id ?? 0));

                $variables[] = $objNotificationVariable;
            }
        }
        return $variables;
    }
}
