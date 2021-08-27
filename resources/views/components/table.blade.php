@php 
    $randId = rand(11111, 99999);

    $tituloColunas = $getColunas()['dados'] ?? [];
    $bodyDados = $getDados();

 @endphp
<div class="row">
	<!--<div class="col-md-12">
		<h4>Lista de produtos</h4>	
	</div>-->
	<div class="col">
		<table style="width: 100%;" id="lista{{$randId}}" class=" data-table table table-sm table-responsive table-hover display">
			@csrf
			<thead style="width: 100%;">
               
                    <tr
                        style="{{ ($getColunas()['style_row'] ?? '') }}"
                             
                        class="{{($getColunas()['style_row'] ?? '')}}"

                        onClick="{{$getColunas()['onClick'] ? 'return '.$getColunas()['onClick'] : '' }}"
                        
                    >
                     @foreach($tituloColunas as $key=>$val)
                        <th
                        
                             style="{{ ($val['style_cel'] ?? '') }}"
                             
                            class="{{($val['class_cel'] ?? '')}}"
                        >
                            {{$val['nmColuna']}}
                        </th>
                        @endforeach
                    </tr>
                
				
			</thead>
			<tbody style="width: 100%;">
				@foreach($bodyDados as $key=>$valor)
                    @php 
                        $atualRow = $valor['row'] ?? [];
                        $dados = $atualRow['dados'] ?? [];

                        $acoesRow =  $atualRow['acoes'] ?? [];
                        
                        $acoesSup = [];
                        if(is_array($acoesRow) && count($acoesRow) > 0){
                            
                            for($k = 0; !($k == count($acoesRow) ); $k++){
                                
                                $acoes = [];
                                $acoes['label']                 = $acoesRow[$k]['label'] ?? '';
                                $acoes['link']                  = $acoesRow[$k]['link'] ?? '';
                                $acoes['style_action']          = $acoesRow[$k]['style_action'] ?? '';
                                $acoes['class_action']          = $acoesRow[$k]['class_action'] ?? '';
                                $acoes['onClick']               = $acoesRow[$k]['onClick'] ?? '';
                                $acoes['id_action']             = $acoesRow[$k]['id_action'] ?? '';
                                $acoes['title_assistente']      = $acoesRow[$k]['title_assistente'] ?? '';
                                $acoes['width_assistente']      = $acoesRow[$k]['width_assistente'] ?? '';
                                $acoes['height_assistente']     = $acoesRow[$k]['height_assistente'] ?? '';
                                $acoes['tp_request_assistente'] = $acoesRow[$k]['tp_request_assistente'] ?? '';
                                
                                $acoesSup[] = $acoes;

                            }
                        }
                                
                               

                        $acoes = json_encode($acoesSup);
                        //dd( $acoes);

                    @endphp

                    @if(is_array($dados) && count($dados) > 0)
                        
                        <tr 
                            class="{{$atualRow['class_row'] ?? ''}}"

                            style=" {{$atualRow['style_row'] ?? ''}}"

                            onClick="showOptions{{$randId}}(this, {{$acoes}});"
                        >

                            @for($i = 0; !($i == count($dados)); $i++)
                                <td 
                                        
                                    class=" {$dados[$i]['class'] ?? ''}}"
                                    style=" {{$dados[$i]['style_cel'] ?? ''}}"

                                >
                                    {{$dados[$i]['val'] ?? ''}}
                                </td>

                            @endfor

                            <input type="hidden" value="{{$atualRow['id'] ?? ''}}">
                        </tr>
                        
                    @endif
				@endforeach
			</tbody>

		</table>
	</div>
</div>

<script type="text/javascript">
	Utilitarios.useDataTable($('#lista-produtos{{$randId}}'))

	var idModalOptions{{$randId}} = null;
	var callBack{{$randId}} = '{{$getCallback()}}'
	//alert(callBack{{$randId}})


	function showOptions{{$randId}}(element, arrLinks)
	{
		try{
			let id = $(element).find('input:hidden').val();

            let arrLinksActions = [];

            if(Array.isArray(arrLinks) && arrLinks.length > 0){
                for(let i = 0; !(i == arrLinks.length); i++){
                    let atual                   = arrLinks[i];
                    let title                   = atual.title_assistente        ? atual.title_assistente        : 'Dados';
                    let widthAssistente         = atual.width_assistente        ? atual.width_assistente        : 'sm';
                    let heightAssistente        = atual.height_assistente       ? atual.height_assistente       : '700px';
                    let tpRequestAssistente     = atual.tp_request_assistente   ? atual.tp_request_assistente   : 'POST';

                    let subArr = [
                        ''+atual.label+'',
                        ''+atual.link+'',
                        ''+atual.class_action+'',
                        ''+atual.id_action+'',
                        ''+id+'',
                        `action{{$randId}}(this, ${tpRequestAssistente}, ${title}, ${widthAssistente}, ${heightAssistente});`
                        
                    ];
                    
                    arrLinksActions.push(subArr)
                }
            }
            
			idModal = Utilitarios.assitentOpcoes(arrLinksActions, '100%', 'xs');
			idModalOptions{{$randId}} = idModal;
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

    function action{{$randId}}(element, typeRequest='POST' ,title='Dados', width='sm', height='700px'){

        try{
			let url = $(element).attr('href');
			let id = $(element).attr('idItem');
			let idModal= $(element).attr('idModal');
			// //
			Utilitarios.fecharAssistente(idModalOptions{{$randId}});
			let data = new FormData();
			data.append('id', id)
			data.append('idAssistente', '')
			data.append('callBack', ''+callBack{{$randId}}+'')

			let token = $('html').find('#lista-produtos{{$randId}}').find('input[name="_token"]').val()
			data.append('_token', token)

			Utilitarios.assistentAjaxModal(typeRequest,url, 'HTML',title, width, height, null, data)
			
		}catch(ex){
				console.log('Erro: '+ex.message);
		}

    }


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


</script>
