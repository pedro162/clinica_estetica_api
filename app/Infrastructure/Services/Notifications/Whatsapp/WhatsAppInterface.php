<?php

namespace App\Infrastructure\Services\Notifications\Whatsapp;

interface WhatsAppInterface
{
    public function fetchSomeData(): array;

    // Outros métodos para diferentes endpoints podem ser adicionados aqui
}

/*
    Serviços:[Whatsapp, Sms, Facebook, Instagram
    SericoConfig:[token, numero telefone, url]
    Params:[id, name, type, optons, is_sistem]
    ValuesParams:[id, param_id, value, own_id]
    Cliente contrata serviços

*/
