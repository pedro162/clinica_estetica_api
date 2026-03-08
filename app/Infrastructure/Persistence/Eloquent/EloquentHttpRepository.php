<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Http\Entities\Http;
use App\Domain\Http\Repositories\HttpRepositoryInterface;
use App\Domain\Http\ValueObjects\HttpBody;
use App\Domain\Http\ValueObjects\HttpHeader;
use App\Domain\Http\ValueObjects\HttpId;
use App\Domain\Http\ValueObjects\HttpUrl;
use App\Http as HttpModel;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EloquentHttpRepository implements HttpRepositoryInterface
{
    public function save(Http $http): ?Http
    {
        //Todo
        //Implement an object model instance and save or update within database, after that, return the object http implementation

        $userObj   = User::first();

        $httpId = (string) $http->getId();
        $httpId = (int) $httpId;
        $userId   = Auth::user()->id; // $userObj->id
        $tenant_id   = Auth::user()->tenant_id; //$userObj->tenant_id;
        if ($httpId > 0) {
            //update
            $httpMomel = HttpModel::where('id', '=', $httpId)->first();
            $httpMomel->updated([
                'http_code'  => (string) $http->getCode(),
                'http_body'  => (string) $http->getBody(),
                'http_header'  => (string) $http->getHeader(),
                'http_url'  => (string) $http->getUrl(),
                'user_update_id'  => $userId,
            ]);
        } else {
            //create
            $httpMomel = HttpModel::create([
                'http_code'  => (string) $http->getCode(),
                'http_body'  => (string) $http->getBody(),
                'http_header'  => (string) $http->getHeader(),
                'http_url'  => (string) $http->getUrl(),
                'tenant_id'  => $tenant_id,
                'user_id'  => $userId,
            ]);
            $http->setId(new HttpId($httpMomel->id));
        }

        return $this->findById($http->getId());
    }
    public function findById(HttpId $id): ?Http
    {
        $http = DB::table('https')->where('id', '=', (string)$id)->first();
        if ($http) {
            $objHttp =  new Http();
            $objHttp->setId(new HttpId($http->id));
            $objHttp->setBody(new HttpBody($http->http_body));
            $objHttp->setHeader(new HttpHeader($http->http_header));
            $objHttp->setUrl(new HttpUrl($http->http_url));
            return $objHttp;
        }
        return null;
    }
}
