@php $randId = rand(11111, 99999); @endphp
<div class="row">
	<!--<div class="col-md-12">
		<h4>Lista de produtos</h4>	
	</div>-->
	<div class="col">
		<!--<table style="width: 100%;" id="lista{{$randId}}" class=" data-table table table-sm table-responsive table-hover display">
			@csrf
			<thead style="width: 100%;">
				<tr>
					<th>
						Cód
					</th>
					<th>
						Descrição
					</th>
					<th>
						Sigla
					</th>
					<th>
						Código do estado
					</th>
					<th>
						Definido como padrão
					</th>
					<th>
						País
					</th>

					<th>
						Código do país
					</th>
					
				</tr>
			</thead>
			<tbody style="width: 100%;">
				@foreach($registro as $valor)
				<tr class="assistenteModalNCM">
					<td class="text-left">{{$valor->id}}</td>
					<td class="text-left">{{$valor->nmEStado}}</td>
					<td class="text-left">{{$valor->sigla}}</td>
					<td class="text-left">{{$valor->codEstado}}</td>
					<td class="text-left">{{$valor->padrao == 'yes' ? 'Sim' : 'Não'}}</td>
					<td class="text-left">{{$valor->nmPais}}</td>
					<td class="text-left">{{$valor->pais_id}}</td>
					<input type="hidden" name="item" value="{{$valor->id}}">
				</tr>
				@endforeach
			</tbody>

		</table> -->

		@php
		
			$tituloColunas = [

				'style_row'=>'',
				'class_row'=>'',
				'onClick'=>null,
				'dados'=>[

					[
						'nmColuna'=>'Cód',
						'class_cel'=>'',
						'style_cel'=>'',
					],
					[
						'nmColuna'=>'Descrição',
						'class_cel'=>'',
						'style_cel'=>'',
					],
					[
						'nmColuna'=>'Sigla',
						'class_cel'=>'',
						'style_cel'=>'',
					],
					[
						'nmColuna'=>'Código do estado',
						'class_cel'=>'',
						'style_cel'=>'',
					],
					[
						'nmColuna'=>'Definido como padrão',
						'class_cel'=>'',
						'style_cel'=>'',
					],
					[
						'nmColuna'=>'País',
						'class_cel'=>'',
						'style_cel'=>'',
					]
					,
					[
						'nmColuna'=>'Código do país',
						'class_cel'=>'',
						'style_cel'=>'',
					]

				],
			];

			$dados = [];

			foreach($registro as $valor){
				$row = [];
				$row['id'] = $valor->id;
				$row['style_row'] = '';
				$row['class_row'] = '';

				$row['dados'] = [
					[
						'val'=>$valor->id,
						'class'=>'',
						'style_cel'=>'',
                            
                    ],
					[
						'val'=>$valor->nmEStado,
						'class'=>'',
						'style_cel'=>'',
						
                    ],
					[
						'val'=>$valor->sigla,
						'class'=>'',
						'style_cel'=>'',
                            
                    ],
					[
						'val'=>$valor->codEstado,
						'class'=>'',
						'style_cel'=>'',
                            
                    ],
					[
						'val'=>$valor->padrao,
						'class'=>'',
						'style_cel'=>'',
                            
                    ],
					[
						'val'=>$valor->nmPais,
						'class'=>'',
						'style_cel'=>'',
                            
                    ],
					[
						'val'=>$valor->pais_id,
						'class'=>'',
						'style_cel'=>'',
                            
                    ]

				];
				
				$row['acoes']=[

                       	[ 
							'label'=>'Editar',
							'link'=>'/estado/edit/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null
						],
						[ 
							'label'=>'Excluir',
							'link'=>'/estado/info/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null
						]
                    ];

				
				
				$dados[] = ['row'=>$row];
			}

			$calback = null;

		
		@endphp
		<x-table
			:tituloColunas="$tituloColunas"
			:dados="$dados"
			:calback="$calback"
		/>
		
	</div>
</div>

<script type="text/javascript">
	let idTable = $('#lista{{$randId}}');
	Utilitarios.useDataTable(idTable);

	let idModalOptions{{$randId}} = null;

	let callBack{{$randId}} = '{{$consulta["callBack"]}}'
	//alert(callBack{{$randId}})


	/**
	*	CHAMA O MODAL DE OPÇÕES DE NCM
	*/
	$('body').find('#lista{{$randId}}').find('.assistenteModalNCM').on('click', function(ev){
		try{
			let id = $(this).find('input:hidden').val();

			let arrLinks = [
				//['Ediar', '/ncm/edit/'+id+'', 'btn btn-lg btn-outline-primary', 'id_editar'],
				['Ediar', '/estado/edit/'+id+'', 'btn btn-lg btn-outline-primary', 'id_editar{{$randId}}', id , 'editar{{$randId}}(this);'],
				['Excluir', '/estado/info/'+id+'', 'btn btn-lg btn-outline-primary', 'id_deletar{{$randId}}', id, 'deletar{{$randId}}(this);'],
				

			];
			//widthOptions='200px', widModal = 'md', height=null //, 'HTML','Marca-Editar', 'sm', '400px'
			idModal = Utilitarios.assitentOpcoes(arrLinks, '100%', 'xs');
			idModalOptions{{$randId}} = idModal;
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	})

	

	function editar{{$randId}}(element){
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

			let token = $('html').find('#lista{{$randId}}').find('input[name="_token"]').val()
			data.append('_token', token)

			Utilitarios.assistentAjaxModal('POST',url, 'HTML','Estado-Editar', 'sm', '300px', null, data)
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function deletar{{$randId}}(element){
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

			let token = $('html').find('#lista{{$randId}}').find('input[name="_token"]').val()
			data.append('_token', token)

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','Estado-Deletar', 'xs', '300px', null, data)
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

</script>