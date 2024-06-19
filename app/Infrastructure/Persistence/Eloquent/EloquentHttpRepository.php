<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Http\Entities\Http;
use App\Domain\Http\Repositories\HttpRepositoryInterface;
use App\Domain\Http\ValueObjects\HttpDocument;
use App\Domain\Http\ValueObjects\HttpEmail;
use App\Domain\Http\ValueObjects\HttpExtraDocument;
use App\Domain\Http\ValueObjects\HttpId;
use App\Domain\Http\ValueObjects\HttpName;
use App\Domain\Http\ValueObjects\HttpOptionalName;
use App\Domain\Http\ValueObjects\HttpSex;
use Illuminate\Support\Facades\DB;
use App\Http as HttpModel;
use App\User;

class EloquentHttpRepository implements HttpRepositoryInterface
{
    public function save(Http $person): ?Http
    {
        //Todo
        //Implement an object model instance and save or update within database, after that, return the object person implementation
        $personId = (string) $person->getId();
        $personId = (int) $personId;
        $userId   = User::first()->id;
        if ($personId > 0) {
            //update
            $personMomel = HttpModel::where('id', '=', $personId)->first();
            $personMomel->updated([
                //'users_create_id'
                //'users_update_id'   
            ]);
        } else {
            //create
            $personMomel = HttpModel::create([
                'user_id' => $userId
            ]);
            $person->setId(new HttpId($personMomel->id));
        }

        return $this->findById($person->getId());
    }
    public function findById(HttpId $id): ?Http
    {
        $person = DB::table('https')->where('id', '=', (string)$id)->first();
        if ($person) {
            $objHttp =  new Http();
            $objHttp->setId(new HttpId($person->id));
            return $objHttp;
        }
        return null;
    }
}
