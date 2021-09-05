<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    protected $label;
    protected $value;
    protected $name;
    protected $class;
    protected $onChange;
    protected $onClick;
    protected $type;
    protected $id;
    protected $options;
    protected $classContainer; 

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(

        $label       =  '',
        $value       =  '',
        $name        =  '',
        $class       =  '',
        $onChange    =  '',
        $onClick     =  '',
        $type        =  '',
        $id          =  '',
        $options     =  [],
        $classContainer = ''
    )
    {
        $this->label      = $label; 
        $this->value      = $value; 
        $this->name       = $name; 
        $this->class      = $class; 
        $this->onChange   = $onChange; 
        $this->onClick    = $onClick; 
        $this->type       = $type; 
        $this->id         = $id; 
        $this->options    = $options;
        $this->classContainer = $classContainer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.select');
    }


    public function getLabel()
    {
        return $this->label;   
    }

    public function getValue()
    {
        return $this->value;   
    }

    public function getName()
    {
        return $this->name;   
    }

    public function getClass()
    {
        return $this->class;   
    }

    public function getOnChange()
    {
        return $this->onChange;   
    }

    public function getOnClick()
    {
        return $this->onClick;   
    }

    public function getType()
    {
        return $this->type;   
    }

    public function getId()
    {
        return $this->id;   
    }

    public function getOptions()
    {
        return $this->options;   
    }

    public function getClassContainer()
    {
        return $this->classContainer;
    }
}
