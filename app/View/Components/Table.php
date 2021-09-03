<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    protected $dados = [];
    protected $tituloColunas = [];
    protected $callback;
    protected $idTable;
    protected $selectorsLine;

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
    public function __construct($tituloColunas,$dados, $calback = null, $idTable = null, $selectorsLine=false)
    {
        $this->setColunas($tituloColunas);
        $this->setDados($dados);
        $this->setCallback($calback);
        $this->setIdTable($idTable);
        $this->setSelectorsLine($selectorsLine);
        
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

    /**
     * Define um id para a tabela
     */

    public function setIdTable($idTable)
    {
        $this->idTable = $idTable;
        return true;
    }

    /**
     * Retorna o id da tabela caso tenha sido definido
     */
    public function getIdTable()
    {
        return $this->idTable ?? null;
    }

    /**
     * Se deve ser exibido o checkbox pra selecionar
     */
    public function setSelectorsLine($selectorsLine)
    {
        $this->selectorsLine = $selectorsLine;
        return true;
    }

    /**
     * Retorna um boleano indicando se deve ser exibido as checkbox
     */
    public function getSelectorsLine()
    {
        return $this->selectorsLine ?? false;
    }

}
