@php $randId = rand(11111, 99999);@endphp
<div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('ipi.store')}}" method="post" class="form " id="form{{$randId}}" enctype="multipart/form-data">
			@csrf
			
			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			@if((isset($csosn) && $csosn == false) )

				
				<hr/>
				<div  class="row" >
					<div class="form-group col-md-12 col-sm-12">
						<label class="label" for="dsIpi{{$randId}}" >Descrição</label>
						<input type="text" name="dsIpi" id="dsIpi{{$randId}}" class="form-control form-control-sm ">
					</div>
				</div>

				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">CST CST ICMS B</label>
						<select title="Tributação pelo icms" type="text" name="categoria_id" class="form-control form-control-sm">
								
							@php $trib_icms = [
									'00'=>'Tributada integralmente',
									'10'=>'Tributada e com cobrança do ICMS por substituição tributária',
									'20'=>'Com redução de base de cálculo',
									'30'=>'Isenta ou não tributada e com cobrança do ICMS por substituição tributária',
									'40'=>'Isenta',
									'41'=>'Não tributada',
									'50'=>'Suspensão',
									'60'=>'Diferimento',
									'70'=>'ICMS cobrado anteriormente por substituição tributária',
									'80'=>'Com redução de base de cálculo e cobrança do ICMS por substituição tributária.',
									'90'=>'Outras',
								]; 
							@endphp

							@foreach($trib_icms as $key=>$al)
								<option value="{{$key}}">{{$al}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Mod. BCICMS</label>
						<select alt="Modalidade de determinação da Base de Cálculo ICMS"  type="text" name="sub_categoria_id" class="form-control form-control-sm">
							<option  value="">Margem valor agregado (%)</option>
							<option  value="">Pauta (valor)</option>
							<option  value="">Preço tabelado máx sugerido (valor)</option>
							<option  value="">Valor da operação (valor)</option>

						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Mod. BC ICMS ST</label>
						<select alt="Modalidade de determinação da Base de Cálculo do ICMS ST" type="text" name="sub_categoria_id" class="form-control form-control-sm">
							<option  value="">Margem valor agregado (%)</option>
							<option  value="">Pauta (valor)</option>
							<option  value="">Preço tabelado máx sugerido (valor)</option>
							<option  value="">Lista positiva (valor)</option>
							<option  value="">Lista negativa (valor)</option>
							<option  value="">Lista neutra (valor)</option>
							
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Red. BC ICMS ST(%)</label>
						<input alt="Percentual de redução da base de cáluclo" type="text" name="ncm" class="form-control form-control-sm">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aliq. ICMS CF(%)</label>
						<input alt="Alíquota ICMS" type="text" name="ean" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aliq. ICMS R(%)</label>
						<input alt="Alíquota ICMS" type="text" name="ean" class="form-control form-control-sm">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="cst{{$randId}}">CST</label>
						<select id="cst{{$randId}}" title="Código da situação tributária referente ao imposto sobre produtos industrializados (CST-IPI):" type="text" name="cst" class="form-control form-control-sm">
							
							@php $cst = [
									'0'	=>'Entrada com Recuperação de Crédito',
									'1'	=>'Entrada Tributável com Alíquota Zero',
									'2'	=>'Entrada Isenta',
									'3'	=>'Entrada Não-Tributada',
									'4'	=>'Entrada Imune',
									'5'	=>'Entrada com Suspensão',
									'49'=>'Outras Entradas',
									'50'=>'Saída Tributada',
									'51'=>'Saída Tributável com Alíquota Zero',
									'52'=>'Saída Isenta',
									'53'=>'Saída Não-Tributada',
									'54'=>'Saída Imune',
									'55'=>'Saída com Suspensão',
									'99'=>'Outras Saídas',
								]; 
							@endphp

							@foreach($cst as $key=>$al)
								<option value="{{$key}}">{{$al}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="cdExTipi{{$randId}}" >Cód. ex. da TIPI</label>
						<input id="cdExTipi{{$randId}}" title="Código de excessão da incidência de IPI " type="text" name="cdExTipi" class="form-control form-control-sm ">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Red. BC ICMS (%)</label>
						<input id="cdExTipi{{$randId}}" title="Código de excessão da incidência de IPI " type="text" name="cdExTipi" class="form-control form-control-sm ">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aliq. ICMS ST(%)</label>
						<input type="text" name="imagem" class="form-control form-control-sm ">
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">CEST</label>
						<input type="text" name="imagem" class="form-control form-control-sm ">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">IVA (%) </label>
						<input alt="O Imposto sobre o Valor Agregado (IVA)" type="text" name="imagem" class="form-control form-control-sm ">
					</div>

				</div>

				<div class="row">
					
					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="cst{{$randId}}">Mot. desoneração do ICMS </label>
						<select id="cst{{$randId}}" title="Código da situação tributária referente ao imposto sobre produtos industrializados (CST-IPI):" type="text" name="cst" class="form-control form-control-sm">
							
							@php $cst = [
									'0'	=>'Taxi',
									'1'	=>'Produtor agropecuário',
									'2'	=>'Fotista / Locadora',
									'3'	=>'Diplomático / Consular',
									'4'	=>'Utilit./Motos da am. / Áreas livre comercio',
									'5'	=>'Suframa',
									'49'=>'Outros',
									'50'=>'Deficiente condutor',
									'51'=>'Deficiente não condutor',
									'52'=>'Órgão de fomento e desenvolvimento agropecuário',
								]; 
							@endphp

							@foreach($cst as $key=>$al)
								<option value="{{$key}}">{{$al}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">MVA ICMS ST (%)</label>
						<input alt="Percentual da margem do Valor Adicionado ao ICMS ST" type="text" name="ncm" class="form-control form-control-sm">
					</div>
				</div>
			@else
				<!-- <h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">ICMS SIMPLES NACIONAL </h5>
				<hr/>-->
				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">COSN</label>
						<select type="text" name="categoria_id" class="form-control form-control-sm">
							
							@php $trib_icms_csosn = [
									'101'=>'Tributada pelo Simples Nacional com permissão de crédito',
									'102'=>'Tributada pelo Simples Nacional sem permissão de crédito',
									'103'=>'Isenção do ICMS no Simples Nacional para faixa de receita bruta',
									'201'=>'Tributada pelo Simples Nacional com permissão de crédito e com cobrança do ICMS por substituição tributária',
									'202'=>'Tributada pelo Simples Nacional sem permissão de crédito e com cobrança do ICMS por substituição tributária',
									'203'=>'Isenção do ICMS no Simples Nacional para faixa de receita bruta e com cobrança do ICMS por substituição tributária',
									'300'=>'Imune',
									'400'=>'Não tributada pelo Simples Nacional',
									'500'=>'ICMS cobrado anteriormente por substituição tributária (substituído) ou por antecipação',
									'900'=>'Outros',
								]; 
							@endphp

							@foreach($trib_icms_csosn as $key=>$al)
								<option value="{{$key}}">{{$al}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aiq. Cal. Cred (%)</label>
						<input type="text" name="imagem" class="form-control form-control-sm " />
					</div>
				</div>


				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">CEST</label>
						<input type="text" name="imagem" class="form-control form-control-sm ">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Alíq. simples nacional</label>
						<input type="text" name="imagem" class="form-control form-control-sm ">
					</div>
				</div>

			@endif
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

<script>


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