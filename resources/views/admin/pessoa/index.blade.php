
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
						'nmColuna'=>'Nome / Razão Social',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Sobrenome / Nome Fantazia',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'CP / CNPJ',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'RG / IE',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Email',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Grupo',
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
						'val'=>$valor->name,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=>$valor->name_opcional ?? '-',
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=>$valor->documento,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=>$valor->documento_complementar ?? '-',
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=>$valor->grupo[0]->name ?? '-',
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					
					

				];
				
				$row['acoes']=[

                       	[ 
							'label'=>'Editar',
							'link'=>'/pessoa/edit/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'PESSOA - EDITAR',
							'width_assistente'=>'sm',
							'height_assistente'=>'700px;'

						],
						[ 
							'label'=>'Visualizar',
							'link'=>'/pessoa/show/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'PESSOA - DELETAR',
							'width_assistente'=>'xs',
							'height_assistente'=>'300px;'
						],
						[ 
							'label'=>'Excluir',
							'link'=>'/pessoa/info/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'PESSOA - DELETAR',
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

<!-- -------------------------------------------------------- -->
