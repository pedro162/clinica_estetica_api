<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormFiltroRelatorio extends Component
{
    protected $fieldsForm;
    protected $acoes;
    protected $callback;
    protected $idContainer;
    protected $idAreaFiltrados;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fieldsForm = [], $acoes = [], $callback = null, $idContainer = null, $idAreaFiltrados = null)
    {
        $this->fieldsForm   = $fieldsForm;
        $this->acoes        = $acoes;
        $this->callback     = $callback;
        $this->idContainer = $idContainer;
        $this->idAreaFiltrados = $idAreaFiltrados;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form-filtro-relatorio');
    }

    public function getFieldsForm()
    {
        return $this->fieldsForm;
    }

    public function getAcoes()
    {
        return $this->acoes;
    }

    public function getCallback()
    {
        return $this->callback;
    }


    public function getIdContainer()
    {
        return $this->idContainer;
    }


    public function getIdAreaFiltrados()
    {
        return $this->idAreaFiltrados;
    }



}
