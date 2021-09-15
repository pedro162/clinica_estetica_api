
@php $randId = rand(11111, 99999); @endphp
<div class="row">
	<div class="col">
		

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
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Código do país',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Padrão',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],

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
						'val'=>$valor->nmPais,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=>$valor->cdPais,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->padrao == 'yes' ? 'Sim' : 'Não',
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					

				];
				
				$row['acoes']=[

                       	[ 
							'label'=>'Editar',
							'link'=>'/pais/edit/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'PAÍS - EDITAR',
							'width_assistente'=>'sm',
							'height_assistente'=>'300px;'

						],
						[ 
							'label'=>'Excluir',
							'link'=>'/pais/info/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'PAÍS - DELETAR',
							'width_assistente'=>'xs',
							'height_assistente'=>'300px;'
						]
                    ];

				
				
				$dados[] = ['row'=>$row];
			}

			$calback = "{{$consulta["callBack"]}}";

			$id = $consulta['idTable'] ?? null;
			$selectorsLine = $consulta['selectorsLine'] ?? false;
			
		@endphp
		<x-table
			:tituloColunas="$tituloColunas"
			:dados="$dados"
			:calback="$calback"
			:idTable="$id"
			:selectorsLine="$selectorsLine"
		/>
		
	</div>
</div>
