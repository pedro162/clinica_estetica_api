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
						'style_cel'=>'width: 600px;',
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
						'style_cel'=>'width: 600px;',
						
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
						'style_cel'=>'width: 600px;',
                            
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
							'onClick'=>null,
							'title_assistente'=>'ESTADO - EDITAR',
							'width_assistente'=>'sm',
							'height_assistente'=>'300px;'

						],
						[ 
							'label'=>'Excluir',
							'link'=>'/estado/info/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'ESTADO - DELETAR',
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