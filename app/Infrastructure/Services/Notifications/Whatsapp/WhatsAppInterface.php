<?php

namespace App\Infrastructure\Services\Notifications\Whatsapp;

use Illuminate\Support\Facades\Http;

interface WhatsAppInterface
{
    public function fetchSomeData(): array;

    // Outros métodos para diferentes endpoints podem ser adicionados aqui
}
