@php $randId = rand(11111, 99999);@endphp
<div class="row mb-5 p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('pis.cofins.store')}}" method="post" class="form " id="form{{$randId}}" enctype="multipart/form-data">
			@csrf

			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>
			@if(isset($formCofins) && $formCofins == true)
				<input type="hidden" name="tpRegistro" value="cofinsst" />
				<div class="row  mt-5">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="dsPisCofins{{$randId}}">Descrição</label>
						<input id="dsPisCofins{{$randId}}" name="dsPisCofins" type="text" name="nmNcm" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label for="tpCalculo{{$randId}}" class="label">Tip. cal COFINS ST</label>
						<select id="tpCalculo{{$randId}}" type="text" name="tpCalculo" class="form-control form-control-sm">
							<option value="pc">Porcentagem ( % )</option>
							<option value="vr">Valor ( R$ ) </option>
						</select>
					</div>

				</div>


				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="pcPisCofins{{$randId}}">Aliq. COFINS  ST (%)</label>
						<input type="text" name="pcPisCofins" id="pcPisCofins{{$randId}}" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label for="vrPisCofins{{$randId}}" class="label">Valor COFINS  ST (R$)</label>
						<input type="text" id="vrPisCofins{{$randId}}" name="vrPisCofins" class="form-control form-control-sm">
					</div>
				</div>

			@else
				<input type="hidden" name="tpRegistro" value="pisst" />
				<div class="row  mt-5">
					<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="dsPisCofins{{$randId}}">Descrição</label>
						<input id="dsPisCofins{{$randId}}" name="dsPisCofins" type="text" name="nmNcm" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Tip. cal PIS  ST </label>
						<select id="tpCalculo{{$randId}}" type="text" name="tpCalculo" class="form-control form-control-sm">
							<option value="pc">Porcentagem ( % )</option>
							<option value="vr">Valor ( R$ ) </option>
						</select>
					</div>

				</div>


				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="pcPisCofins{{$randId}}">Aliq. PIS ST (%)</label>
						<input type="text" name="pcPisCofins" id="pcPisCofins{{$randId}}" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6 col-sm-12">
					<label for="vrPisCofins{{$randId}}" class="label">Valor PIS  ST (R$)</label>
						<input type="text" id="vrPisCofins{{$randId}}" name="vrPisCofins" class="form-control form-control-sm">
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