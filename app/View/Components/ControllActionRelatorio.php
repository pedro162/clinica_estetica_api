<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ControllActionRelatorio extends Component
{
    protected $acoes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($acoes)
    {
        $this->acoes = $acoes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.controll-action-relatorio');
    }

    public function getAcoes()
    {
        return $this->acoes;
    }
}
