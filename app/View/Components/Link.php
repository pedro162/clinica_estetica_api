<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Link extends Component
{
    protected $type;
    protected $onClick;
    protected $href;
    protected $class;
    protected $style;
    protected $id;
    protected $icone;
    protected $label;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        
        $type='',
        $onClick='',
        $href='',
        $class='',
        $style='',
        $id='',
        $icone='',
        $label=''

    )
    {
        $this->type     = $type;
        $this->onClick  = $onClick;
        $this->href     = $href;
        $this->class    = $class;
        $this->style    = $style;
        $this->id       = $id;
        $this->icone    = $icone;
        $this->label    = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.link');
    }

    public function getType()
    {

        return $this->type;
    }

    public function getOnClick()
    {

        return $this->onClick;
    }

    public function getHref()
    {

        return $this->href;
    }

    public function getClass()
    {

        return $this->class;
    }

    public function getStyle()
    {

        return $this->style;
    }

    public function getId()
    {

        return $this->id;
    }

    public function getIcone()
    {

        return $this->icone;
    }

    public function getLabel()
    {

        return $this->label;
    }

}
