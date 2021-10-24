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
						'nmColuna'=>'Tipo',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Aceita transferência',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Valor mínimo',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Valor máximo',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Status de bloqueio',
						'class_cel'=>'',
						'style_cel'=>'width: 1200px;',
					],
					[
						'nmColuna'=>'Status de abertura',
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
						'val'=>$valor->type,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
                    [
						'val'=>$valor->aceita_transferencia,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
                    [
						'val'=>$valor->vrMin,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
                    [
						'val'=>$valor->vrMax,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
                    [
						'val'=>$valor->status_bloqueio,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
                    [
						'val'=>$valor->status_abertura,
						'class'=>'',
						'style_cel'=>'width: 1200px;',
						
                    ],
					





				];
				
				$row['acoes']=[

                       	[ 
							'label'=>'Editar',
							'link'=>'/caixa/edit/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'CAIXA - EDITAR',
							'width_assistente'=>'sm',
							'height_assistente'=>'300px;'

						],
						[ 
							'label'=>'Excluir',
							'link'=>'/caixa/info/'. $valor->id,
							'style_action'=>'',
							'class_action'=>'btn btn-lg btn-outline-primary',
							'onClick'=>null,
							'title_assistente'=>'CAIXA - DELETAR',
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
<!--
			Movimentações,
			Entradas, 
			Saídas,
			Conciliação,
			Importar ofx

			*Relatorios{
				Balancete,
				DRE,
				Fluxo de caixa:{
					Plano de contas:{
						Contábel:{
							receitas e despesas
						},
						Financeiro / Orçamentário{
							receitas (créditos):{
								Vendas loja,
								Emprestimos,
								Vendas loja virtual,

							},
							despesas (débitos):{
								Alugel,
								Energia,
								Contador,
								Fornecedores,
								Impostos e táxas,
								Salários,
								Equipamentos,
								Manutenção,
								Seguros,
								Alimentação,

							},
							indicadores:{
								A porcentagem de cada grupo de despesas em relação à receita/ faturamento,
								EX: Recita de 100 -> 100%
								Espesa de 50-> 50% da receita
							}
						}
					}
				},
				Resumo de entradas e saídas por categoria,
				Gráfico ce gastos
				OBS:{
					Pesquisaar diferença entre DRE e Fluxo de caixa
				}


			}

 -->