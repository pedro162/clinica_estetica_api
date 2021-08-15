@php $randId = rand(11111, 99999); @endphp

<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{route('ncm.update', $registro->id)}}" method="post" class="form" id="form_{{$randId}}" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				
				<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
				<hr/>
				<div  class="row" >
					<div class="form-group col-md-12 col-sm-12">
						<label class="label" for="dsIpi{{$randId}}" >Descrição</label>
						<input value="{{$registro->dsIpi}}" type="text" name="dsIpi" id="dsIpi{{$randId}}" class="form-control form-control-sm ">
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
								<option {{isset($registro->cst) && trim($registro->cst) == $key ? 'selected' : ''}} value="{{$key}}">{{$al}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="cdExTipi{{$randId}}" >Cód. ex. da TIPI</label>
						<input value="{{$registro->cdExTipi}}" id="cdExTipi{{$randId}}" title="Código de excessão da incidência de IPI " type="text" name="cdExTipi" class="form-control form-control-sm ">
					</div>
				</div>
				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="tpCalculo{{$randId}}" >Tip. calculo IPI</label>
						<select type="text" title="Tipo de cálculo do IPI" name="tpCalculo" id="tpCalculo{{$randId}}" class="form-control form-control-sm">
							<option {{isset($registro->tpCalculo) && trim($registro->tpCalculo) == 'pc' ? 'selected' : ''}} value="pc">Aliq.</option>
							<option {{isset($registro->tpCalculo) && trim($registro->tpCalculo) == 'vr' ? 'selected' : ''}} value="vr">Vr. por un.</option>
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="pcIpi{{$randId}}">Aiq. IPI (%)</label>
						<input type="text" name="pcIpi" id="pcIpi{{$randId}}" title="Alíquota do ipi" class="form-control form-control-sm ">
					</div>
				</div>
				<div  class="row" >

					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="vrIpi{{$randId}}" >Vr. IPI</label>
						<input value="{{$registro->vrIpi}}" title="Valor do ipi" readonly="readonly" type="text"  name="vrIpi" id="vrIpi{{$randId}}" class="form-control form-control-sm ">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="bcIpi{{$randId}}">BC IPI</label>
						<input value="{{$registro->bcIpi}}" type="text" name="bcIpi" title="Base ce cálculo do IPI" id="bcIpi{{$randId}}" class="form-control form-control-sm ">
					</div>

				</div>
				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="somaBcIcms{{$randId}}">Soma IPI BC do ICMS</label>
						<select type="text"  name="somaBcIcms" title="Base ce cálculo do IPI" id="somaBcIcms{{$randId}}" class="form-control form-control-sm">
							<option {{isset($registro->somaBcIcms) && trim($registro->somaBcIcms) == 'yes' ? 'selected' : ''}} value="yes">sim.</option>
							<option {{isset($registro->somaBcIcms) && trim($registro->somaBcIcms) == 'no' ? 'selected' : ''}} value="no">Não</option>
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="somaBcIcmsSt{{$randId}}" >Soma IPI BC do ICMS ST</label>
						<select type="text" name="somaBcIcmsSt" title="Base ce cálculo do IPI ST" id="somaBcIcmsSt{{$randId}}" class="form-control form-control-sm">
							<option {{isset($registro->somaBcIcms) && trim($registro->somaBcIcms) == 'yes' ? 'selected' : ''}} value="yes">sim.</option>
							<option {{isset($registro->somaBcIcms) && trim($registro->somaBcIcms) == 'no' ? 'selected' : ''}} value="no">Não</option>
						</select>
					</div>
				</div>		

				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="dsClassEnquadra{{$randId}}" >Classe de enquadramento</label>
						<input type="text"  value="{{$registro->dsClassEnquadra}}" name="dsClassEnquadra" title="Classe de enquadramento" id="dsClassEnquadra{{$randId}}" class="form-control form-control-sm ">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="cdEnquadra{{$randId}}" >Código de enquadramento</label>
						<input type="text"  value="{{$registro->cdEnquadra}}" name="cdEnquadra" title="Classe de enquadramento" id="cdEnquadra{{$randId}}" class="form-control form-control-sm ">
					</div>
				</div>

				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="cnpjProdutor{{$randId}}" >CNPJ do produtor</label>
						<input type="text"  value="{{$registro->cnpjProdutor}}" name="cnpjProdutor" title="CNPJ do produtor" id="cnpjProdutor{{$randId}}" class="form-control form-control-sm ">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="cdCeloControle{{$randId}}">Código do celo de controle</label>
						<input type="text"  value="{{$registro->cdCeloControle}}" name="cdCeloControle" title="CNPJ do produtor" id="cdCeloControle{{$randId}}" class="form-control form-control-sm ">
					</div>
				</div>
				
				<div class="row">

					<div class="col-md-8 col-sm-12">
					</div>
					<div class="col-md-4 col-sm-12" style="text-align: right;">
						<button type="submit" class=" btn btn-md btn-primary">Salvar</button>
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>
<script>
	const assistente = '{{$idAssistente}}';
	$("#tabs{{$randId}}").tabs()
	//edita ou salva um produto
	$('html body').find('#form_{{$randId}}').on('submit', function(ev){
		ev.preventDefault();
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
						Utilitarios.fecharAssistente(assistente);
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

					Utilitarios.assistenteMensage(msg, 'warning', 'Erro');
				}


			})

		}catch(ex){

			console.log(ex.message);
		}

		
	});
</script>