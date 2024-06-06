<?php

namespace App\Infrastructure\Services\Whatsapp;

use Illuminate\Support\Facades\Http;

class WhatsAppOfficialApi implements WhatsAppInterface
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.external_api.base_url');
    }

    public function fetchSomeData(): array
    {
        $response = Http::get("{$this->baseUrl}/some-endpoint");

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception("Error fetching data from external API");
    }
}
