<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\TemplateVariable\Entities\TemplateVariable;
use App\Domain\TemplateVariable\Repositories\TemplateVariableRepositoryInterface;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableId;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableSyntax;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableTemplateId;
use App\Domain\TemplateVariable\ValueObjects\TemplateVariableValue;
use App\TemplateVariable as TemplateVariableModel;
use App\User;
use Illuminate\Support\Facades\DB;

class EloquentTemplateVariableRepository implements TemplateVariableRepositoryInterface
{
    public function save(TemplateVariable $template): ?TemplateVariable
    {
        //Todo
        //Implement an object model instance and save or update within database, after that, return the object template implementation
        $templateId = (string) $template->getId();
        $templateId = (int) $templateId;
        $userId   = User::first()->id;
        if ($templateId > 0) {
            //update
            $templateMomel = TemplateVariableModel::where('id', '=', $templateId)->first();
            $templateMomel->updated([
                'syntax' => $template->getVariable(),
                'value' => $template->getValue(),
                'template_id' => $template->getTemplateId(),
                'user_id' => $userId,
                'user_update_id' => null,
                'active' => 'yes',
            ]);
        } else {
            //create
            $templateMomel = TemplateVariableModel::create([
                'syntax' => $template->getVariable(),
                'value' => $template->getValue(),
                'template_id' => $template->getTemplateId(),
                'user_id' => $userId,
                'user_update_id' => null,
                'active' => 'yes',
            ]);
            $template->setId(new TemplateVariableId($templateMomel->id));
        }

        return $this->findById($template->getId());
    }
    public function findById(TemplateVariableId $id): ?TemplateVariable
    {
        $template = DB::table('template_variables')->where('template_id', '=', (string)$id)->first();
        if ($template) {
            $objTemplateVariable =  new TemplateVariable();
            $objTemplateVariable->setId(new TemplateVariableId($template->id ?? 0));
            $objTemplateVariable->setValue(new TemplateVariableValue($template->value ?? ''));
            $objTemplateVariable->setVariable(new TemplateVariableSyntax($template->syntax ?? ''));
            $objTemplateVariable->setTemplateId(new TemplateVariableTemplateId($template->template_id ?? 0));

            return $objTemplateVariable;
        }
        return null;
    }
    public function findByTemplateId(TemplateVariableTemplateId $id): ?array
    {
        $template = DB::table('template_variables')->where('active', '=', 'yes')->where('template_id', '=', (string)$id)->get();
        $variables = [];
        if ($template) {
            foreach ($template as $key => $variable) {
                $objTemplateVariable =  new TemplateVariable();
                $objTemplateVariable->setId(new TemplateVariableId($variable->id ?? 0));
                $objTemplateVariable->setValue(new TemplateVariableValue($variable->value ?? ''));
                $objTemplateVariable->setVariable(new TemplateVariableSyntax($variable->syntax ?? ''));
                $objTemplateVariable->setTemplateId(new TemplateVariableTemplateId($variable->template_id ?? 0));

                $variables[] = $objTemplateVariable;
            }
        }
        return $variables;
    }
}
