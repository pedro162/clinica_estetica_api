<?php

namespace App\Infrastructure\Services\Notifications\Whatsapp;

use App\Application\Commands\CreateHttpCommand;
use App\Application\Handlers\HttpRequestResponseHandler;
use App\Domain\Http\Interfaces\HttpRequesResponseInterace;
use App\Domain\Notification\Interfaces\NotificationInterface;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Http\Entities\Http;
use App\Http as HttpModel;
use App\Infrastructure\Persistence\Eloquent\EloquentHttpRepository;

class WhatsAppOfficialApi implements NotificationInterface, WhatsAppInterface
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.external_api.base_url');
    }

    public function fetchSomeData(): array
    {
        $response = HttpModel::get("{$this->baseUrl}/some-endpoint");

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception("Error fetching data from external API");
    }

    public function send(Notification $notification): HttpRequestResponseHandler
    {


        $commandRequest = new CreateHttpCommand();
        $commandRequest->httpId('')
            ->httpCode('')
            ->httpDataRequest('')
            ->httpUrl('')
            ->httpHeader('')
            ->httpBody('');

        $commandResponse = new CreateHttpCommand();
        $commandResponse->httpId('')
            ->httpCode('')
            ->httpDataRequest('')
            ->httpUrl('')
            ->httpHeader('')
            ->httpBody('');

        $objHttpRequest = new Http();
        $objHttpRespone = new Http();

        $objHender = new HttpRequestResponseHandler();
        $objHender->requestRepository(new EloquentHttpRepository())
            ->responseRepository(new EloquentHttpRepository());

        $objHender->requestHandler($commandRequest);
        $objHender->responseHandler($commandResponse);

        return $objHender;
    }
}
