<?php

namespace App\Impressao\Common;

interface DaInterface
{
    public function creditsIntegratorFooter($message);
    public function monta();
    public function render();
}
