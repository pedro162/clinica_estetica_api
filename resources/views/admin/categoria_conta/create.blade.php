
@php $randId = rand(11111, 99999); @endphp

<div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('categoria_conta.store')}}" method="post" class="form" id="form{{$randId}}">
			@csrf
			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>

			<div class="row  mt-5">
				<div class="form-group col-md-12 col-sm-12">
					<label class="label" for="name">Nome</label>
					<input type="text" name="name" id="name" class="form-control form-control-sm">
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8 col-sm-12">
				</div>
				<div class="col-md-4 col-sm-12" style="text-align: right;">
					<button id="btn-salvar{{$randId}}" type="submit" class=" btn btn-sm btn-primary">Salvar</button>
				</div>
			</div>
		</form>
	</div>	
</div>
<script>
	/*
		aTIVO CIRCULANTE:
			DISPONIVEL:{
				CAIXA, EQUIVALENTE DE CAIXA, BANCOS CONTA MOVIMENTO,BANCOS TONTA VINCULADA (DEPOSITO JUDICIAL),
				APLICAÇÕES FINANCEIRAS DE CURTO PRAZO

			},
			CLIENTES:{
				CLIENTES,
				DUPLICATAS A RECEBER,
				TITULOS A RECEBER,
				DIVIDENDOS,
				(-) PERDA ESTIMADAS COM CREDITOS LIQUIDAÇÃO DUVIDOSA (OBS: VALOR QUE NÃO SE VAI RECEBER, EX: TAXA),
				(-) AJUSTE A VALOR PRESENTE SOBRE CLIENTES (EX: JUROS),NUMERÁRIOS EM TRANSITO

			},
			TRIBUTOS:{
				TRIBUTO A RECUPERAR (ICMS, PIS, COFINS, IPI)
			},
			ADIANTAMENTO:{
				ADIANTAMENTO A FORNECEDORES,
				ADIANTAMENTO DE SALÁRIOS
			},
			PRÊMIO DE SEGURO A APROPRIAR,
			ASSINATURA E ANUIDADE A APROPRIAR,
			ALUGUES ANTECIPADOS APROPRIADOS,
			ESTOQUE:{
				ESTOQUE PARA REVENDA,
				ESTOQUE DE MATÉRIA PRIMA,
				PRODUTOS EM ELABORAÇÃO,
				ESTOQUE DE PRODUTOS ACABADOS,
				PERDA ESTIMADA NOS ESTOQUES / AJUSTES
			}
		aTIVO NÃO CIRCULANTE > 12 MESES:
			EMPRESTIMOS, FEITO A DIRETORES, ACIONISTA, EMPRESAS COLIGADAS, CONTROLADAS
			INVESTIMENTOS:{
				PARTICIPAÇÕES PERMANENTES,
				INVESTIMENTO EM COLIGADAS (INFLUENCIA SIGNIFICATIVA),
				INVESTIMENTO EM CONTROLADAS,
				PROPRIEDADE PRA INVESTIMENTOS

			}
		IMOBILIZADO:{
			TERRENOS,
			MÓVEIS E UTENCÍLIOS,
			VEICULOS,
			FERRAMENTAS,
			MÁQUINAS,
			APARELHOS,
			DQUIPAMENTOS,
			INSTALAÇÕES,
			BENS ARRENDADOS,
			(-) DEPRECIAÇÃO ACUMULADA,
			IMOBILIZADOS EM ANDAMENTO,
			ADIANTAMENTO A FORNECEDORES IMOBILIZADO,
			(-) PERDA COM AJUSTE AO VALOR RECUPERADO
			(-) EXAUSTÃO ACUMULADA
		},
		INTANGÍVEIS:{
			MARCAS,
			PATENTES,
			CONCESSOES,
			DIREITOS AUTORAIS,
			DIREITOS SOBRE RECURSOS MINERAIS,
			ÁGIO POR EXPECTATIVA DE RENTABILIDADE FUTURA (GOODWILL) - SO NO BALANÇO CONSOLIDADO,
			(-) ARMOTIZAÇÃO ACUMULADA
			(-) PERDA AJUSTE AO VALOR RECUPERÁVEL (TESTE DE RECUPERABILIDADE)
		}
	
		PASSIVOS
			CIRCULANTES 12 MESES
				SALÁRIOS A PAGAR,
				ENCARGOS A PAGAR (13, FÉRIAS, INSS, FGTS)
				HONORÁRIOS A PAGAR,
				COMISSÕES A PAGAR,
				FORNECEDORES,
				TRIBUTOS A PAGAR(ICMS, ISS, PIS, COFINS, IPI, IOF, TAXAS),
				FINANCIAMENTOS A PAGAR,
				DIVIDENDOS A PAGAR,
				DUPLICATAS A PAGAR,
				DUPLICATAS DISCONTADAS (SOLICITAÇÕES DE ADIANTAMENTOS DO RECEBER),
				ADIANTAMENTO DE CLIENTE (CLIENTE PAGOU ADIANTADO0,
				PROVISÕES(FISCAIS, TRABALHISTAS, PREVIDENCIÁRIAS, CÍVEIS ),
				DIVIDENDOS JSCP A PAGAR,
				(-) ENCARGOS A TRANSCORRER (JUROS QUE ESTÃO ESPERANDO IR PAR O RESULTADO, PQ AINDA NÃO HOUVE O RIGIME DE COMPETÊNCIA
				)
			NAO CIRCULANTES:{
				FORNECEDORES SUPERIORES A 12 MESES,
				RECEITAS DIFERIDAS (RECEITAS QUE VC RECEBEU), MAS INDA NÃO FORAM PARA DRE, REGIME DE COMPETÊNCIA (RECEBEU MAS NÃO HA CHANCE DE DEVOLUÇÃO)
				PARTRIMÔNIO LÍQUIDO,

				CAPITAL SOCIAL SUBSCRITO
				(-) CAPITAL A INTEGRALIZAR (PARTE AINDA NÃO ENTREGE)
				
			}





	*/

const assistente{{$randId}} = '{{$idAssistente}}';
	//edita ou salva um produto
	$('html body').find('#form{{$randId}}').on('submit', function(ev){

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
							Utilitarios.fecharAssistente(assistente{{$randId}});
							Utilitarios.assistenteMensage('Registrado com sucesso');
							@php echo base64_decode($callBack) @endphp

						}else{

							Utilitarios.assistenteMensage('Erro ao atuaolizar registro', 'warning', 'Erro');


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