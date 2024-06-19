<?php

namespace App\Application\Services;

use App\Infrastructure\Services\Notifications\Whatsapp\WhatsAppInterface;

class ExternalDataService
{
    protected WhatsAppInterface $externalApiService;

    public function __construct(WhatsAppInterface $externalApiService)
    {
        $this->externalApiService = $externalApiService;
    }

    public function fetchAndProcessExternalData(): array
    {
        $data = $this->externalApiService->fetchSomeData();

        // Processar dados conforme necessário

        return $data;
    }
}
