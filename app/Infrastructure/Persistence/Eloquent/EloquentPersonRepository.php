<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Person\Entities\Person;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Domain\Person\ValueObjects\PersonDocument;
use App\Domain\Person\ValueObjects\PersonEmail;
use App\Domain\Person\ValueObjects\PersonExtraDocument;
use App\Domain\Person\ValueObjects\PersonId;
use App\Domain\Person\ValueObjects\PersonName;
use App\Domain\Person\ValueObjects\PersonOptionalName;
use App\Domain\Person\ValueObjects\PersonSex;
use App\Pessoa;
use App\User;
use Illuminate\Support\Facades\DB;

class EloquentPersonRepository implements PersonRepositoryInterface
{
    public function save(Person $person): ?Person
    {
        //Todo
        //Implement an object model instance and save or update within database, after that, return the object person implementation
        $personId = (string) $person->getId();
        $personId = (int) $personId;
        $userId   = User::first()->id;
        if ($personId > 0) {
            //update
            $personMomel = Pessoa::where('id', '=', $personId)->first();
            $personMomel->updated([
                'name' => $person->getName(),
                'name_opcional' => $person->getOptionalName(),
                'documento' => $person->getDocument(),
                'documento_complementar' => $person->getExtraDocument(),
                'nascimento_fundacao' => null,
                'sexo' => $person->getSex(),
                'email' => $person->getEmail()
                //'users_create_id'
                //'users_update_id'
            ]);
        } else {
            //create
            $personMomel = Pessoa::create([
                'name' => $person->getName(),
                'name_opcional' => $person->getOptionalName(),
                'documento' => $person->getDocument(),
                'documento_complementar' => $person->getExtraDocument(),
                'nascimento_fundacao' => null,
                'sexo' => $person->getSex(),
                'email' => $person->getEmail(),
                'user_id' => $userId
            ]);
            $person->setId(new PersonId($personMomel->id));
        }

        return $this->findById($person->getId());
    }
    public function findById(PersonId $id): ?Person
    {
        $person = DB::table('pessoas')->where('id', '=', (string)$id)->first();
        if ($person) {
            $objPerson =  new Person();
            $objPerson->setId(new PersonId($person->id));
            $objPerson->setName(new PersonName($person->name));
            $objPerson->setOptionalName(new PersonOptionalName($person->name_opcional));
            $objPerson->setDocument(new PersonDocument($person->documento));
            $objPerson->setExtraDocument(new PersonExtraDocument($person->documento_complementar ?? ''));
            $objPerson->setSex(new PersonSex($person->sexo));
            $objPerson->setEmail(new PersonEmail($person->email));
            return $objPerson;
        }
        return null;
    }
}
