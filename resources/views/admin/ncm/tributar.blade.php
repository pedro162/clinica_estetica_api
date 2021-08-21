
@php 

	$csosn = false;
	$randId = rand(11111, 99999);

@endphp
<div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('produto.store')}}" method="post" class="form " id="form_{{$randId}}" enctype="multipart/form-data">
			@csrf

			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>

			<div class="  mt-5">
				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Estado</label>
						<select type="text" name="uf" id="uf{{$randId}}" class="form-control form-control-sm">
							<option value=""></option>
						</select>
					</div>
					
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">GTIN TRIBUTÁVEL</label>
						<input alt="Código de barras de uma caixa, por exemploe." type="text" name="ncm" class="form-control form-control-sm">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 col-sm-12">
						@php
							
							$idCodAnp = '01';
							$typeCodAnp = 'number';
							$nameCodAnp = 'anp';
							$labelCodAnp = 'ANP';
							$idDescriptionAnp = '02';
							$typeDescrptionAnp = 'text';
							$nameDescriptionAnp = 'dsNcm';
							$labelDescriptionAnp = 'Descrição';
							$valueDescriptionAnp = "01";
							$valueCodAnp = "Teste 01";
							$colCodAnp = "2";
							$colDescriptionAnp = "9";
							$searshAnp = "searshNcm".$randId."();";
						
						@endphp
						<x-controll-filter
							:idCod="$idCodAnp"
							:typeCod="$typeCodAnp"
							:nameCod="$nameCodAnp"
							:labelCod="$labelCodAnp"
							:idDescription="$idDescriptionAnp"
							:typeDescrption="$typeDescrptionAnp"
							:nameDescription="$nameDescriptionAnp"
							:labelDescription="$labelDescriptionAnp"
							:valueDescription="$valueDescriptionAnp"
							:valueCod="$valueCodAnp"
							:colCod="$colCodAnp"
							:colDescription="$colDescriptionAnp"
							:searsh="$searshAnp"

						/>
					</div>
				</div>
			</div>
			
			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Operação</h5>
			<hr/>
			<div class="row">
				<div class="form-group col-md-6 col-sm-12">
				
					@php
				
						$idCodCfop = '001';
						$typeCodCfop = 'number';
						$nameCodCfop = 'idCFOP';
						$labelCodCfop = 'CFOP';
						$idDescriptionCfop = '002';
						$typeDescrptionCfop = 'text';
						$nameDescriptionCfop = 'dsCFOP';
						$labelDescriptionCfop = 'Descrição';
						$valueDescriptionCfop = "001";
						$valueCodCfop = "Teste CFOP 001";
						$colCodCfop = "3";
						$colDescriptionCfop = "8";
						$searshCfop = "";

					@endphp
					<x-controll-filter
						:idCod="$idCodCfop"
						:typeCod="$typeCodCfop"
						:nameCod="$nameCodCfop"
						:labelCod="$labelCodCfop"
						:idDescription="$idDescriptionCfop"
						:typeDescrption="$typeDescrptionCfop"
						:nameDescription="$nameDescriptionCfop"
						:labelDescription="$labelDescriptionCfop"
						:valueDescription="$valueDescriptionCfop"
						:valueCod="$valueCodCfop"
						:colCod="$colCodCfop"
						:colDescription="$colDescriptionCfop"
						:searsh="$searshCfop"
					/>

				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Origem CST ICMS A</label>
					<select type="text" title="Origem da mercadoria ou serviço" name="marca_id" class="form-control form-control-sm">
                        @php $origem = [
							
							'0'=>'Nacional - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8',
                            '1'=>'Estrangeira - Importação direta, exceto a indicada no código 6',
                            '2'=>'Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7',
                            '3'=>'Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%',
                            '4'=>'Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam as legislações citadas nos Ajustes',
                            '5'=>'Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%; ',
                            '6'=>'Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX; ',
                            '7'=>'Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista da CAMEX.',
                            '8'=>'Nacional , mercadoria ou bem com Conteúdo de Importação Superior a 70%.',
                        ]; @endphp
						@foreach($origem as $key=>$val)
							<option value="{{$key}}">{{$val}}</option>
						@endforeach
					</select>
				</div>

			</div>
			
			@if($csosn == false)
				<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">ICMS</h5>
				<hr/>
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
						<label class="label">MVA ICMS ST (%)</label>
						<input alt="Percentual da margem do Valor Adicionado ao ICMS ST" type="text" name="ncm" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aliq. IPI (%)</label>
						<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
							<option value=""></option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 col-sm-12">

						@php
						
							$idCodPis = '001';
							$typeCodPis = 'number';
							$nameCodPis = 'idPis';
							$labelCodPis = 'PIS';
							$idDescriptionPis = '002';
							$typeDescrptionPis = 'text';
							$nameDescriptionPis = 'dsPis';
							$labelDescriptionPis = 'Descrição';
							$valueDescriptionPis = "001";
							$valueCodPis = "Teste PIS 001";
							$colCodPis = "3";
							$colDescriptionPis = "8";
							$searshPis = "searshPis".$randId."();";

						@endphp
						<x-controll-filter
							:idCod="$idCodPis"
							:typeCod="$typeCodPis"
							:nameCod="$nameCodPis"
							:labelCod="$labelCodPis"
							:idDescription="$idDescriptionPis"
							:typeDescrption="$typeDescrptionPis"
							:nameDescription="$nameDescriptionPis"
							:labelDescription="$labelDescriptionPis"
							:valueDescription="$valueDescriptionPis"
							:valueCod="$valueCodPis"
							:colCod="$colCodPis"
							:colDescription="$colDescriptionPis"
							:searsh="$searshPis"
						/>
					</div>

					<div class="form-group col-md-6 col-sm-12">

						@php
						
							$idCodPisSt = '001';
							$typeCodPisSt = 'number';
							$nameCodPisSt = 'idPisSt';
							$labelCodPisSt = 'PISST';
							$idDescriptionPisSt = '002';
							$typeDescrptionPisSt = 'text';
							$nameDescriptionPisSt = 'dsPisSt';
							$labelDescriptionPisSt = 'Descrição';
							$valueDescriptionPisSt = "001";
							$valueCodPisSt = "Teste PISST 001";
							$colCodPisSt = "3";
							$colDescriptionPisSt = "8";
							$searshPisSt = "searshPisSt".$randId."();";
						@endphp
						<x-controll-filter
							:idCod="$idCodPisSt"
							:typeCod="$typeCodPisSt"
							:nameCod="$nameCodPisSt"
							:labelCod="$labelCodPisSt"
							:idDescription="$idDescriptionPisSt"
							:typeDescrption="$typeDescrptionPisSt"
							:nameDescription="$nameDescriptionPisSt"
							:labelDescription="$labelDescriptionPisSt"
							:valueDescription="$valueDescriptionPisSt"
							:valueCod="$valueCodPisSt"
							:colCod="$colCodPisSt"
							:colDescription="$colDescriptionPisSt"
							:searsh="$searshPisSt"
						/>
					</div>
				</div>
				

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">

						@php
						
							$idCodCofins = '001';
							$typeCodCofins = 'number';
							$nameCodCofins = 'idCofins';
							$labelCodCofins = 'Cofins';
							$idDescriptionCofins = '002';
							$typeDescrptionCofins = 'text';
							$nameDescriptionCofins = 'dsCofins';
							$labelDescriptionCofins = 'Descrição';
							$valueDescriptionCofins = "001";
							$valueCodCofins = "Teste Cofins 001";
							$colCodCofins = "3";
							$colDescriptionCofins = "8";
							$searshCofins = "searshCofins".$randId."();";
						@endphp
						<x-controll-filter
							:idCod="$idCodCofins"
							:typeCod="$typeCodCofins"
							:nameCod="$nameCodCofins"
							:labelCod="$labelCodCofins"
							:idDescription="$idDescriptionCofins"
							:typeDescrption="$typeDescrptionCofins"
							:nameDescription="$nameDescriptionCofins"
							:labelDescription="$labelDescriptionCofins"
							:valueDescription="$valueDescriptionCofins"
							:valueCod="$valueCodCofins"
							:colCod="$colCodCofins"
							:colDescription="$colDescriptionCofins"
							:searsh="$searshCofins"
						/>
					</div>

					<div class="form-group col-md-6 col-sm-12">

						@php
						
							$idCodCofinsSt = '001';
							$typeCodCofinsSt = 'number';
							$nameCodCofinsSt = 'idCofinsst';
							$labelCodCofinsSt = 'Cofinsst';
							$idDescriptionCofinsSt = '002';
							$typeDescrptionCofinsSt = 'text';
							$nameDescriptionCofinsSt = 'dsCofinsSt';
							$labelDescriptionCofinsSt = 'Descrição';
							$valueDescriptionCofinsSt = "001";
							$valueCodCofinsSt = "Teste CofinsSt 001";
							$colCodCofinsSt = "3";
							$colDescriptionCofinsSt = "8";
							$searshCofinsSt = "searshCofinsSt".$randId."();";
						@endphp
						<x-controll-filter
							:idCod="$idCodCofinsSt"
							:typeCod="$typeCodCofinsSt"
							:nameCod="$nameCodCofinsSt"
							:labelCod="$labelCodCofinsSt"
							:idDescription="$idDescriptionCofinsSt"
							:typeDescrption="$typeDescrptionCofinsSt"
							:nameDescription="$nameDescriptionCofinsSt"
							:labelDescription="$labelDescriptionCofinsSt"
							:valueDescription="$valueDescriptionCofinsSt"
							:valueCod="$valueCodCofinsSt"
							:colCod="$colCodCofinsSt"
							:colDescription="$colDescriptionCofinsSt"
							:searsh="$searshCofinsSt"
						/>
					</div>
				</div>
							
				<!--<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Red. BC ICMS (%)</label>
						<select type="text" name="origem" class="form-control form-control-sm">						
							<option value=""></option>						
						</select>
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

				</div>-->

			@else

				<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">ICMS SIMPLES NACIONAL </h5>
				<hr/>
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
						<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
							<option value=""></option>
						</select>
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

            <h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">IPI </h5>
				<hr/>
				<div class="row">
					<div class="form-group col-md-6 col-sm-12">	
						@php
							
							$idCodIpi = '001';
							$typeCodIpi = 'number';
							$nameCodIpi = 'idIpi';
							$labelCodIpi = 'Ipi';
							$idDescriptionIpi = '002';
							$typeDescrptionIpi = 'text';
							$nameDescriptionIpi = 'dsIpi';
							$labelDescriptionIpi = 'Descrição';
							$valueDescriptionIpi = "001";
							$valueCodIpi = "Teste Ipi 001";
							$colCodIpi = "3";
							$colDescriptionIpi = "8";
							$searshIpi = "searshIpi".$randId."();";
						@endphp
						<x-controll-filter
							:idCod="$idCodIpi"
							:typeCod="$typeCodIpi"
							:nameCod="$nameCodIpi"
							:labelCod="$labelCodIpi"
							:idDescription="$idDescriptionIpi"
							:typeDescrption="$typeDescrptionIpi"
							:nameDescription="$nameDescriptionIpi"
							:labelDescription="$labelDescriptionIpi"
							:valueDescription="$valueDescriptionIpi"
							:valueCod="$valueCodIpi"
							:colCod="$colCodIpi"
							:colDescription="$colDescriptionIpi"
							:searsh="$searshIpi"
						/>
					</div>
				</div>

				<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">OUTROS </h5>
				<hr/>
				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">I.I</label>
						<input type="text" title="Imposto sobre importação" name="imagem" class="form-control form-control-sm ">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">ISSQN</label>
						<input type="text" title="Imposto sobre qualquer natureza" name="imagem" class="form-control form-control-sm ">
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

<script>

	let callBack{{$randId}} = '{{$callBack}}'
	

	$('html').find('#tpCalculoIpi{{$randId}}').on('change', function(ev){
		let val = $(this).val();
		let objAliqIpi = $('html').find('#aliqIpi{{$randId}}');
		let objVrIpi = $('html').find('#vrIpi{{$randId}}');

		if(val && String(val).trim() == 'pc'){
			objVrIpi.attr('readonly', 'readonly')
			objAliqIpi.removeAttr('readonly')

		}else{
			objAliqIpi.attr('readonly', 'readonly')
			objVrIpi.removeAttr('readonly')

		}
	})
	//edita ou salva um produto
	$('html body').delegate('form#form_{{$randId}}','submit', function(ev){

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

	function searshNcm{{$randId}}(){
		try{
			let url = '/ncm/head';
			//let idModal= $(element).attr('idModal');
			// //
			//Utilitarios.fecharAssistente(idModalOptions{{$randId}});
			//let data = new FormData();
			//data.append('id', id)
			//data.append('idAssistente', '')
			//data.append('callBack', ''+callBack{{$randId}}+'')

			//let token = $('html').find('#lista{{$randId}}').find('input[name="_token"]').val()
			//data.append('_token', token)

			//Utilitarios.assistentAjaxModal('POST',url, 'HTML','NCM-Editar', 'sm', '300px', null, data)
			Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produtos', 'sm', '700px', null, null)
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function searshPis{{$randId}}(){
		try{
			
			let url = '/pis/cofins/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			data.append('tp', 'pis')

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','PIS', 'sm', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function searshPisSt{{$randId}}(){
		try{
			
			let url = '/pis/cofins/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			data.append('tp', 'pisst')

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','PIS ST', 'sm', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function searshCofins{{$randId}}(){
		try{
			
			let url = '/pis/cofins/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			data.append('tp', 'cofins')

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','COFINS', 'sm', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function searshCofinsSt{{$randId}}(){
		try{
			
			let url = '/pis/cofins/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			data.append('tp', 'cofinsst')

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','COFINS ST', 'sm', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function searshIpi{{$randId}}(){
		try{
			
			let url = '/ipi/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			data.append('tp', 'cofinsst')

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','IPI', 'sm', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	
	function preparaBasicRequestPost{{$randId}}(){
		let token = $('html').find('#form_{{$randId}}').find('input[name="_token"]').val()

		let data = new FormData();
		data.append('idAssistente', '')
		data.append('callBack', ''+callBack{{$randId}}+'')
		data.append('_token', token)

		return data;

	}

</script>