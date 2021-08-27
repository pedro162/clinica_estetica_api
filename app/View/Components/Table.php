<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    protected $dados = [];
    protected $tituloColunas = [];
    protected $callback;

      /*
      Ex de formado do array de dados passado
        $tituloColunas =[
            'dados'=>[

                ['nmColuna'=>'Código',
                'class_cel'=>'class',
                'style_cel'=>'style_cel',]
            ],

            'style_row'=>'style_row',
            'class_row'=>'style_row',
            'onClick'=>null,

      ];

        $dados = [
            [
                'row'=>[
                    'id'=>null
                    'dados'=>[
                    
                        [
                            'val'=>'val',
                            'class'=>'class',
                            'style_cel'=>'style_cel',
                            
                        ]
                    ],
                    'acoes'=>[
                        'label'=>'Label',
                        'link'=>'/produto/head/1'
                        'style_action'=>'estilo',
                        'class_action'=>'estilo',
                        'onClick'=>null
                    ],
                    'style_row'=>'style_row',
                    'class_row'=>'class_row',

                ],
                
            ]
        ];
    */


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tituloColunas,$dados, $calback = null)
    {
        $this->setColunas($tituloColunas);
        $this->setDados($dados);
        $this->setCallback($calback);

    }

  

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.table');
    }

    public function setDados($dados)
    {
        $this->dados = $dados;
        return true;
    }

    public function getDados()
    {
        return $this->dados ?? [];
    }

    public function setColunas($dados)
    {
        $this->tituloColunas = $dados;
        return true;
    }

    public function getColunas()
    {
        return $this->tituloColunas ?? [];
    }


    public function setCallback($dados)
    {
        $this->callback = $dados;
        return true;
    }
    public function getCallback()
    {
        return $this->callback ?? null;
    }

}
