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
						'style_cel'=>'width: 600px;',
					],
					[
						'nmColuna'=>'Cep',
						'class_cel'=>'',
						'style_cel'=>'width: 600px;',
					],
					[
						'nmColuna'=>'Cód. IBGE',
						'class_cel'=>'',
						'style_cel'=>'width: 600px;',
					],
					[
						'nmColuna'=>'Cidade',
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
						'val'=>$valor->name,
						'class'=>'',
						'style_cel'=>'width: 600px;',
						
                    ],
					[
						'val'=>$valor->cep,
						'class'=>'',
						'style_cel'=>'width: 600px;',
						
                    ],
					[
						'val'=>$valor->codIbge,
						'class'=>'',
						'style_cel'=>'width: 600px;',
						
                    ],
					[
						'val'=>$valor->nmCidade,
						'class'=>'',
						'style_cel'=>'width: 600px;',
						
                    ]

				];
				
				$row['acoes']=[

                       	[ 
							'label'=>'Editar',
							'link'=>'/bairro/edit/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'BAIRRO - EDITAR',
							'width_assistente'=>'sm',
							'height_assistente'=>'300px;'

						],
						[ 
							'label'=>'Excluir',
							'link'=>'/bairro/info/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'BAIRRO - DELETAR',
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