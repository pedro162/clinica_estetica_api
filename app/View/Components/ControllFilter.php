<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ControllFilter extends Component
{
    protected $idCod;
    protected $typeCod;
    protected $nameCod;
    protected $labelCod;
    protected $idDescription;
    protected $typeDescrption;
    protected $nameDescription;
    protected $labelDescription;
    protected $valueDescription;
    protected $valueCod;
    protected $colCod;
    protected $colDescription;
    protected $searsh;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($idCod, $typeCod, $nameCod, $labelCod, $valueCod, $colCod, $idDescription, $typeDescrption, $nameDescription, $labelDescription, $valueDescription, $colDescription, $searsh)
    {
        $this->idCod                = $idCod;
        $this->typeCod              = $typeCod;
        $this->nameCod              = $nameCod;
        $this->labelCod             = $labelCod;
        $this->idDescription        = $idDescription;
        $this->typeDescrption       = $typeDescrption;
        $this->nameDescription      = $nameDescription;
        $this->labelDescription     = $labelDescription;
        $this->valueDescription     = $valueDescription;
        $this->valueCod             = $valueCod;
        $this->colCod               = $colCod;
        $this->colDescription       = $colDescription;
        $this->searsh               = $searsh;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.controll-filter');
    }

    public function getIddCod()
    {
        return $this->idCod;   
    }

    public function getTypeCod()
    {
        return $this->typeCod;   
    }

    public function getNameCod()
    {
        return $this->nameCod;   
    }

    public function getLabelCod()
    {
        return $this->labelCod;   
    }
    public function getIdDescription()
    {
        return $this->idDescription;   
    }

    public function getTypeDescrption()
    {
        return $this->typeDescrption;   
    }

    public function getNameDescription()
    {
        return $this->nameDescription;   
    }

    public function getLabelDescription()
    {
        return $this->labelDescription;   
    }
    
    public function getValueDescription()
    {
        return $this->valueDescription;   
    }
    

    public function getValueCod()
    {
        return $this->valueCod;   
    }

    public function getColCod()
    {
        return $this->colCod;   
    }

    public function getColDescription()
    {
        return $this->colDescription;   
    }
    
    public function getSearsh()
    {
        return $this->searsh;
    }
}
