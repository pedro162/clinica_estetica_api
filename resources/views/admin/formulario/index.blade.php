
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
						'nmColuna'=>'Nome Produto',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Marca',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Categoria',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Preço',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Destaque',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Imagem',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Estoque',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Qtd Vendida',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Produto Final',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Revenda',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Fora de Linha',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Importado',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Imune a Tributação',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Venda Fracionada',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],					
					[
						'nmColuna'=>'Controle Validade',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					
					[
						'nmColuna'=>'Liberado Venda',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Validade',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					
					[
						'nmColuna'=>'Peso Bruto',
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
						'val'=>$valor->description,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->marca,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->categoria,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->price,
						'class'=>'text-right',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> ($valor->spotlight == 'yes') ? 'Sim' : 'Não',
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> "<img src='".asset($valor->image)."' style='width: 100px; height: 50px;'>",
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->stock,
						'class'=>'text-right',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->sold_amout,
						'class'=>'text-right',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->produto_final == 'yes' ? 'Sim': 'Não',
						'class'=>'text-left',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->revenda  == 'yes' ? 'Sim': 'Não',
						'class'=>'text-left',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->fora_de_linha  == 'yes' ? 'Sim': 'Não',
						'class'=>'text-left',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->importado  == 'yes' ? 'Sim': 'Não',
						'class'=>'text-left',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->imune_tributacao  == 'yes' ? 'Sim': 'Não',
						'class'=>'text-left',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->venda_fracionada  == 'yes' ? 'Sim': 'Não',
						'class'=>'text-left',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->controle_validade  == 'yes' ? 'Sim': 'Não',
						'class'=>'text-left',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->has_venda  == 'yes' ? 'Sim': 'Não',
						'class'=>'text-left',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->dt_validade  == 'yes' ? 'Sim': 'Não',
						'class'=>'text-left',
						'style_cel'=>'width: 1200px;',
						
                    ],
					[
						'val'=> $valor->peso_bruto.' Kg',
						'class'=>'text-left',
						'style_cel'=>'width: 1200px;',
						
                    ],
				
				];

				$row['acoes']=[

                       	[ 
							'label'=>'Editar',
							'link'=>'/produto/edit/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'PRODUTO - EDITAR',
							'width_assistente'=>'sm',
							'height_assistente'=>'500px;'

						],
						[ 
							'label'=>'Tributar',
							'link'=>'/ncm/tributacao/tributar/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'FISCAL',
							'width_assistente'=>'sm',
							'height_assistente'=>'700px;'

						],
						[ 
							'label'=>'EMBALAGEM',
							'link'=>'/ncm/tributacao/tributar/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'PRODUTO - EMBALAGEM',
							'width_assistente'=>'sm',
							'height_assistente'=>'500px;'

						],
						[ 
							'label'=>'Estoque',
							'link'=>'/ncm/tributacao/tributar/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'PRODUTO - ESTOQUE',
							'width_assistente'=>'sm',
							'height_assistente'=>'500px;'

						],
						[ 
							'label'=>'Excluir',
							'link'=>'/produto/info/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'PRODUTO - DELETAR',
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