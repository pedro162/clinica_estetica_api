<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Template\Entities\Template;
use App\Domain\Template\Repositories\TemplateRepositoryInterface;
use App\Domain\Template\ValueObjects\TemplateDocument;
use App\Domain\Template\ValueObjects\TemplateEmail;
use App\Domain\Template\ValueObjects\TemplateExtraDocument;
use App\Domain\Template\ValueObjects\TemplateId;
use App\Domain\Template\ValueObjects\TemplateMessage;
use App\Domain\Template\ValueObjects\TemplateSex;
use Illuminate\Support\Facades\DB;
use App\Template as TemplateModel;
use App\User;

class EloquentTemplateRepository implements TemplateRepositoryInterface
{
    public function save(Template $template): ?Template
    {
        //Todo
        //Implement an object model instance and save or update within database, after that, return the object template implementation
        $templateId = (string) $template->getId();
        $templateId = (int) $templateId;
        $userId   = User::first()->id;
        if ($templateId > 0) {
            //update
            $templateMomel = TemplateModel::where('id', '=', $templateId)->first();
            $templateMomel->updated([
                'title' => $template->getTitle(),
                'body' => $template->getBody(),
                //'users_create_id'
                //'users_update_id'   
            ]);
        } else {
            //create
            $templateMomel = TemplateModel::create([
                'title' => $template->getTitle(),
                'body' => $template->getBody(),
                'user_id' => $userId
            ]);
            $template->setId(new TemplateId($templateMomel->id));
        }

        return $this->findById($template->getId());
    }
    public function findById(TemplateId $id): ?Template
    {
        $template = DB::table('pessoas')->where('id', '=', (string)$id)->first();
        if ($template) {
            $objTemplate =  new Template();
            $objTemplate->setId(new TemplateId($template->id));
            return $objTemplate;
        }
        return null;
    }
}
