@php $randId = rand(11111, 99999); @endphp

<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{route('pis.cofins.update', $registro->id)}}" method="post" class="form" id="form_{{$randId}}" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				
				<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
				<hr/>
				@if(isset($formCofins) && $formCofins == true)
					<input type="hidden" name="tpRegistro" value="{{$registro->tpRegistro}}" />
					<div class="row  mt-5">
						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="dsPisCofins{{$randId}}">Descrição</label>
							<input title="Descrição" value="{{$registro->dsPisCofins}}" id="dsPisCofins{{$randId}}" name="dsPisCofins" type="text" name="nmNcm" class="form-control form-control-sm">
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label for="tpCalculo{{$randId}}" class="label">Tip. cal COFINS {{$sufixo}}</label>
							<select title="Tipo de cálculo" id="tpCalculo{{$randId}}" value="{{$registro->tpCalculo}}" type="text" name="tpCalculo" class="form-control form-control-sm">
								<option {{isset($registro->tpCalculo) && trim($registro->tpCalculo) == 'pc' ? 'selected': ''}} value="pc">Porcentagem ( % )</option>
								<option {{isset($registro->tpCalculo) && trim($registro->tpCalculo) == 'vr' ? 'selected': ''}} value="vr">Valor ( R$ ) </option>
							</select>
						</div>

					</div>

					<div class="row">
						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="pcPisCofins{{$randId}}">Aliq. COFINS {{$sufixo}} (%)</label>
							<input title="Aliquota" type="text" name="pcPisCofins" value="{{$registro->pcPisCofins}}" id="pcPisCofins{{$randId}}" class="form-control form-control-sm">
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label for="vrPisCofins{{$randId}}" class="label">Valor COFINS {{$sufixo}} (R$)</label>
							<input title="Valor" type="text" id="vrPisCofins{{$randId}}" value="{{$registro->vrPisCofins}}" name="vrPisCofins" class="form-control form-control-sm">
						</div>
					</div>

				@else
					<input type="hidden" name="tpRegistro" value="{{$registro->tpRegistro}}" />
					<div class="row  mt-5">
						<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="dsPisCofins{{$randId}}">Descrição</label>
							<input title="Descrição" id="dsPisCofins{{$randId}}" value="{{$registro->dsPisCofins}}" name="dsPisCofins" type="text" name="nmNcm" class="form-control form-control-sm">
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label class="label">Tip. cal PIS {{$sufixo}} </label>
							<select title="Tipo de cálculo" id="tpCalculo{{$randId}}" type="text" name="tpCalculo" class="form-control form-control-sm">
								<option {{isset($registro->tpCalculo) && trim($registro->tpCalculo) == 'pc' ? 'selected': ''}} value="pc">Porcentagem ( % )</option>
								<option {{isset($registro->tpCalculo) && trim($registro->tpCalculo) == 'vr' ? 'selected': ''}} value="vr">Valor ( R$ ) </option>
							</select>
						</div>

					</div>


					<div class="row">
						<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="pcPisCofins{{$randId}}">Aliq. PIS {{$sufixo}} (%)</label>
							<input title="Alíquota" type="text" value="{{$registro->pcPisCofins}}" name="pcPisCofins" id="pcPisCofins{{$randId}}" class="form-control form-control-sm">
						</div>

						<div class="form-group col-md-6 col-sm-12">
						<label title="Valor" for="vrPisCofins{{$randId}}" class="label">Valor PIS {{$sufixo}} (R$)</label>
							<input type="text" id="vrPisCofins{{$randId}}" value="{{$registro->vrPisCofins}}" name="vrPisCofins" class="form-control form-control-sm">
						</div>
					</div>
					
				@endif

				<div class="row">
					<div class="col-md-8 col-sm-12">
					</div>
					<div class="col-md-4 col-sm-12" style="text-align: right;">
						<button type="submit" class=" btn btn-md btn-primary"><b>Atualizar</b></button>
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