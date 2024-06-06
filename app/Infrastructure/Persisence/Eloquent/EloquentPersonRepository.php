<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Person\Entities\Person;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Domain\Person\ValueObjects\PersonId;
use App\Domain\Person\ValueObjects\PersonName;
use Illuminate\Support\Facades\DB;

class EloquentPersonRepository implements PersonRepositoryInterface
{
    public function save(Person $task): ?Person
    {
        //Todo
        //Implement an object model instance and save or update within database, after that, return the object task implementation
        $taskId = (string) $task->getId();
        $taskId = (int) $taskId;
        if ($taskId > 0) {
            //update
        } else {
            //create
        }

        return null;
    }
    public function findById(PersonId $id): ?Person
    {
        $task = DB::table('task')->where('id', '=', (string)$id)->first();
        if ($task) {
            return new Person(
                new PersonId($task->id),
                new PersonName($task->name)
            );
        }
        return null;
    }
}
