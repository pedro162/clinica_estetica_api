
<div class="row mb-5 p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('produto.store')}}" method="post" class="form " id="form_produto_cadastrar" enctype="multipart/form-data">
			@csrf

			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>

			<div class="row  mt-5">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Nome</label>
					<input type="text" name="name" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Descrição</label>
					<input type="text" name="description" class="form-control form-control-sm">
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Marca</label>
					<select type="text" name="marca_id" class="form-control form-control-sm">
						@foreach($marcas as $marca)
							<option value="{{$marca->id}}">{{$marca->name}}</option>
						@endforeach
					</select>
				</div>


				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Unidade</label>
					<input type="text" name="unidade" class="form-control form-control-sm">
				</div>

			</div>

			<div class="row">
				
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Categoria</label>
					<select type="text" name="categoria_id" class="form-control form-control-sm">
						@foreach($categorias as $categoria)
							<option value="{{$categoria->id}}">{{$categoria->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Sub categoria</label>
					<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
						@foreach($categorias as $categoria)
							<option value="{{$categoria->id}}">{{$categoria->name}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">EAN</label>
					<input type="text" name="ean" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">NCM</label>
					<input type="text" name="ncm" class="form-control form-control-sm">
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Origem</label>
					<select type="text" name="origem" class="form-control form-control-sm">						
						<option value=""></option>						
					</select>
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Imagem</label>
					<input type="file" name="imagem" class="form-control form-control-sm ">
				</div>
			</div>

			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados para venda</h5>
			<hr/>


			<div class="row">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Preço de custo</label>
					<input type="text" name="selling_price" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Preço de venda</label>
					<input type="text" name="price" class="form-control form-control-sm">
				</div>

				<!--<div class="form-group col-md-6 col-sm-12">
					<label class="label">Estoque mínimo</label>
					<input type="text" name="stock" class="form-control form-control-sm">
				</div> -->
			</div>

			<div class="row">
				<div class="custom-control custom-checkbox col-md-4 col-sm-12">
					
					<input type="checkbox" name="sale_without_stok" class="custom-control-input" id="sale_without_stok"/>
					<label class="custom-control-label" for="sale_without_stok">Venda sem estoque</label>
				</div>

				<div class="custom-control custom-checkbox col-md-4 col-sm-12">
					
					<input type="checkbox" name="blokade_stok" class="custom-control-input" id="blokade_stok"/>
					<label class="custom-control-label"  for="blokade_stok">Bloqueio entrada de estoque</label>
				</div>

				<div class="custom-control custom-checkbox col-md-4 col-sm-12">
					
					<input type="checkbox" name="fracioned_sale" class="custom-control-input" id="fracioned_sale"/>
					<label class="custom-control-label" for="fracioned_sale">Venda fracionada</label>
				</div>

			</div>

			<div class="row">
				<div class="col-md-8 col-sm-12">
				</div>
				<div class="col-md-4 col-sm-12" style="text-align: right;">
					<button type="submit" class=" btn btn-md btn-primary"><b>Salvar</b></button>
				</div>
			</div>
		</form>
	</div>
</div>	

<!--
	CFOP:{
		Código cfop,
		Tipo de operação,
		CFOP de devolução
		CFOP inverso/estorno
		CST escriutração de entrada
		Descrição deste CFOP
		Aplicação deste CFOP
		Gera financeiro
		Estado[Localização],
		Tipo cfop:[entrada, saída]
		Validar Sit. Tribut.: Marcando esta opção o sistema verificará se a situação tributária informada na nota fiscal é a mesma indicada na CFOP à qual a opção pertence, caso seja diferente o sistema emitirá um aviso para que a situação tributária seja alterada e não permitirá ainda que outra situação tributária diferente da configurada na referida CFOP seja posta na nota fiscal.


		//----------------------------------------
		•	Situações Tributárias por Filial
 

		•	Filial: Neste campo serão mostradas as filiais existentes para a indicação de suas respectivas situações tributárias.
		

		•	Razão Social: Neste campo serão mostradas as razões sociais das filiais existentes mostradas no campo anterior.
		

		•	Situação de ICMS SN: Indique aqui o código da situação tributária de ICMS Simples Nacional da empresa caso a mesma esteja enquadrada como simples nacional.
		

		•	Situação de ICMS SN RPA: Indique aqui o código da situação tributária de ICMS SN RPA caso o emitente esteja enquadrada como simples nacional porém o destinatário seja uma empresa enquadrada no regime normal.
		

		•	Situação de ICMS: Indique aqui o código da situação tributária de ICMS Regime Normal da empresa caso o emitente esteja enquadrada como regime normal porém o destinatário esteja enquadrado como simples nacional.
		

		•	Situação de ICMS RPA: Indique aqui o código da situação tributária de ICMS RPA caso o emitente e o destinatário sejam empresas enquadradas no regime normal.
		

		•	Situação de IPI: Indique aqui o código da situação tributária de IPI.
		

		•	Situação de COFINS: Indique aqui o código da situação tributária de COFINS.
		

		•	Situação de PIS: Indique aqui o código da situação tributária de PIS.
		

		•	% base de crédito de ICMS p/ Industrialização: Neste campo é possível indicar qual a porcentagem de crédito de ICMS poderá ser utilizada nessa cfop referente à uma industrialização quando a mesma conter matéria-prima que não permitam aproveitamento total do ICMS vindo de sua compra. Ex: 5%.
		

		•	Obs: É possível redimensionar a janela de <Cadastro de CFOP> clicando-se em uma das bordas da janela e arrastando-a com o mouse.
		

		•	CFOP de Importação: Marque esse campo caso essa seja uma CFOP de importação
		É aconselhável cadastrar todas as CFOP que serão utilizadas nas notas fiscais de entrada,saída,remessa,devolução e outras possíveis operações.
	}


	CfOP números iniciais e suas correspondências
	1-> <-5
	2-> <-6
	3-> <-7

	{
		Sufixo,
		Descriçao,
		Variação,
		Gera financeiro,
		Tipo de utilizaçao,
		operação fisca inversa,
		operação fiscal para devolucao,
		movimenta estoque,
		solicitar documento fiscal de origem,
		não tributa ICMS,
		stituação tributária,
		tipo de valor,
		[
			Sufixo: Preencha com os três últimos dígitos do código fiscal(CFOP). Exemplo: Código fiscal 1102, então o sufixo deve ser 102. 
			Variação: Este campo seve para controle interno pois existem operações fiscais com o mesmo sufixo. Pode ser usado como um resumo do que se trata o CFOP. Este campo não tem impacto fiscal. Exemplo: Compra; Transf; EntRem; 
			Descrição: É a identificação da CFOP cadastrada que será exibida. Ex: Devolução de Compra; Saída Transferência; Entrada remessa;
			Gera Financeiro: Essa opção Indica que deverá ser informado os vencimentos das receitas/despesas no lançamento da nota fiscal. Na integração da nota serão gerados lançamentos de despesas/receitas no financeiro com o(s) vencimento(s) informados. Para notas fiscais de saída também indica que ela será considerada nas consultas comerciais.
			Tipo de Utilização: Preencha este campo para identificar a finalidade da operação, sendo Saída, ou Entrada.
			Operação Fiscal Inversa (Espelho): Este campo serve para identificar se será aceito uma operação inversa com base no documento de origem. No caso de CFOP de Saída é obrigatório seu preenchimento.
			Operação Fiscal para Devolução: Este campo serve para informar se a operação realizada terá uma operação de devolução. Exemplo: A operação ‘Saída - venda’ pode ter ‘Entrada – Devolução’.
			Movimenta Estoque: Este campo tem como finalidade identificar se os produtos contidos na NF vão sair/entrar no estoque ao gerar a NF.
			Solicita Documento Fiscal de Origem: Esta opção é responsável por identificar se a operação realizada terá ou não que ter um documento de origem referenciado. Exemplo. Uma NF de devolução de compra deve ter sua NF de origem referenciada.
			Não Tributa ICMS: Esta opção define a Tributação de ICMS incidente sobre a operação fiscal.
		]
	}

	//-----------------------------------------

	Natureza operação
		E-Compras pra comercializaçaõ de outros estados
		E-Compras para comercialização 
		D-Devolução de compras para comercializaçao de outros estados
		D-Devolução de compras para comercializaçao
		E-Devolução de mercadoria
		S-Industrialização efetuada para outras empresas
		S-Outras saídas não especificadas
		S-Prestação de serviços
		S-Venda/Prestaçao de serviços
		S-Venda de mercadoria adquirida e/ou recebida de terceiros
		S-Vendas de mercadoria adquirida e/ou recebida de terceiros de outros estados
		S-Vendas de mercadoria de dentro do estado

	ICMS

		Natureza operção
		Estado
		Aliquota ICMS %
		Aliquota ICMS interna do estado emissor %
		FCP (Fundo de combate a pobreza) %
		MVA (Margem de valor agregado) % 
		Base Reduzida valor
		ST
		ST serviço
		CSOSN
		Base ICMS[Base simples, Base Dupla, Base trípla]
		Modalidade de determinação da BC do ICMS ST: [
			*Preço tabelado ou máximo sugerido
			*Lista positiva (valor)
			*Margem valor agregado (%)
			*Lista negativa (valor)
			*Lista neutra (valor)
			*Pauta
		]
		Base do ICMS ST
		Base  ST Destino
		Aliquota ST destino
		BC Operação Própria
		Base ICMS UF destino
		Alíquota UF destino
		Alíq. FCP UF Destino (Fundo de combate a pobresa destino)
		Motivo da desoneração do ICMS:{
			*Táxi
			*Produtor Agropecuário
			*Frotista/Locadora
			*Diplomático/Consumidor
			*Utilit./Motos da Am./Áreas Livre consumo
			*Suframa
			*Outros
			*Deficiente Condutor
			*Deficiente não condutor
			*Ógão de fornecimento e desenvolvimento agropecuáreo

		}
		IVA (%)
		Base do ICMS ST
		Aliqota ST
		IVA (%)
		Base ST Retido
		Alíq. ST ret

	CST
		O Código da Situação Tributária (CST) é o valor que identifica a origem da mercadoria e a forma de tributação que deverá incidir sobre a mesma.

		CST	Descrição
		00	Tributada integralmente
		10	Tributada e com cobrança do ICMS por substituição tributária
		20	Com redução da BC
		30	Isenta / não tributada e com cobrança do ICMS por substituição tributária
		40	Isenta
		41	Não tributada
		50	Com suspensão
		51	Com diferimento
		60	ICMS cobrado anteriormente por substituição tributária
		70	Com redução da BC e cobrança do ICMS por substituição tributária
		90	Outras
	Código de Regime Tributário - CRT for igual a "1″.

	*Produto{
		GTIN = "Código de barras"[
			GTIN comercial (UNIDADE):

			GTIN tributável (A caixa)
		]

		CEST:{Código especificador da subistituição tributária.}
		
		ANP (Código da agência nacional do petrôleo):{

		},
		Unidade,
		Código externo,
		Flags:{
			Ativo,
			Kit,
			Controla estoque,
			Permite devolução,
		},
		Preco de venda, 
		Desconto,
		Alterado em,

		Tributação:{Situação tributária, ICMS, Produção própria},
		Classificação:{
			Grupo,
			Departamento,
			Marca,
		},
		Observações,
		Descrição adiconada na venda,
		Animação
	}

	IPI:{
		Tipo de cálculo:[Percentual:{
			Base de cálculo, Alíquota
		}, em valor:{
			Valor da unidade
		}],
		Classe de enquadramento,
		Código de enquadramento,
		CNPJ do produtor,
		Código do selo de controle,
		Soma ipi na base do ICMS:{Sim, não},
		Soma ipi na base do ICMS ST:{Sim, não}

	}

	COFINS:{
		Descrição,
		Cód CST,
		Tipo de calculo:{
			Percentual:{
				Base de calculo, Alíquota,
			}, Em valor:{
				Valor por unidade
			}
		}
	}

	PIS:{
		Descrição,
		Cód CST,
		Tipo de calculo:{
			Percentual:{
				Base de calculo, Alíquota,
			}, Em valor:{
				Valor por unidade
			}
		}
	}

	COFINS Subistituição Tributária:{
		Descrição,
		Cód CST,
		Tipo de calculo:{
			Percentual:{
				Base de calculo, Alíquota,
			}, Em valor:{
				Valor por unidade
			}
		}
	}

	PIS Subistituição Tributária:{
		Descrição,
		Cód CST,
		Tipo de calculo:{
			Percentual:{
				Base de calculo, Alíquota,
			}, Em valor:{
				Valor por unidade
			}
		}
	}
	Inposto sobre importação,
	ISSQN (Inposto sobre importação de qualquer natureza)
	
	#Movimentação de destoque
	#Clientes e fornecedores
	#Consulta clientes
	#Notas fiscais
	#Orçamentos O.S
	#Histórico
	#PDV
	#Caixa
	#Contas a receber
	#Contas a pagar
	#Compras
	#Fechamento de caixa

 -->

<script>
	//edita ou salva um produto
	$('html body').delegate('form#form_produto_cadastrar, form#form_produto_atualizar','submit', function(ev){

		try{

			let url = $(this).attr('action');
			let id = $(this).attr('id');

			let form = new FormData($(this)[0]);
			$.ajax({
				url:url,
				type:'POST',
				dataType:'json',
				data:form,
				processData:false,
				contentType:false,
				success:function(response){
					console.log(response);
					console.log(response.mensagem.id);

					if(response.mensagem.hasOwnProperty('id') || response.mensagem == true){

						Utilitarios.assistenteMensageAlert('Registrado com sucesso');

					}else{

						Utilitarios.assistenteMensageAlert('Erro ao atuaolizar registro', 'warning');

						
					}
				},
				error:function(response, status, error){
					//console.log(response, status, error)
					console.log(response.responseJSON);
					let objErros = response.responseJSON.errors
					let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';
					for (let prop in objErros){
						msg+='<strong>'+prop+': </strong>'+objErros[prop]+'<br/>';
					}

					Utilitarios.assistenteMensageAlert(msg, 'warning');
				}


			})

		}catch(ex){

			console.log(ex.message);
		}

		ev.preventDefault();
});
</script>