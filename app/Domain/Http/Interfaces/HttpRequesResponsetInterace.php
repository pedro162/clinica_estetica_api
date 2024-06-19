<?php

namespace App\Domain\Http\Interfaces;

use App\Domain\Http\Entities\Http;

interface HttpRequesResponseInterace
{
    public function getRequest(): ?Http;
    public function getResponse(): ?Http;
}
