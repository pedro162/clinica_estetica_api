
@php $randId = rand(11111, 99999); @endphp

<div class="container-fluid">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('logradouro.update', [$registro->id, $pessoa->id])}}" id="form_logradouro_atualizar{{$randId}}" method="post" class="form row p-5">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<h4>Endereço</h4>
						<div class="row"><legend></legend>
							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="cep{{$randId}}">Cep</label>
								<input type="text" id="cep{{$randId}}" name="cep" value="{{$registro->cep}}" class="form-control form-control-sm" required="required">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="logradouro">Logradouro</label>
								<input type="text" id="logradouro{{$randId}}" value="{{$registro->logradouro}}" name="logradouro" class="form-control form-control-sm" required="required"  minlength="3" maxlength="255">
							</div>


							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="numero">Número</label>
								<input type="number" id="numero{{$randId}}" name="numero" value="{{$registro->numero}}" class="form-control form-control-sm"  min="1" max="100000">
							</div>

							<!--<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="tipo">Tipo</label>
								<select id="tipo{{$randId}}"  name="tipo" class="form-control form-control-sm" required="required">
									<option value="casa">Casa</option>
									<option value="apartamento">Apartamento</option>
									<option value="outros">Otros</option>
								</select>
							</div>-->

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="complemento">Complemento</label>
								<input id="complemento{{$randId}}" type="text" name="complemento" class="form-control form-control-sm"  minlength="3" maxlength="255" value="{{$registro->complemento}}">
								</select>
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="bairro">Bairro</label>
								<input type="text" id="bairro{{$randId}}" name="bairro" class="form-control form-control-sm" required="required" value="{{$registro->bairro}}" minlength="3" maxlength="255">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="cidade">Cidade</label>
								<input type="text" id="cidade{{$randId}}" name="cidade" class="form-control form-control-sm" required="required" value="{{$registro->cidade}}" minlength="3" maxlength="255">
							</div>

							<div class="form-group col-md-12 col-sm-12">
								<label class="label" for="estado">Estado</label>
								<input type="text" id="estado{{$randId}}" value="{{$registro->estado}}" name="estado" class="form-control form-control-sm" required="required" minlength="2" maxlength="2">
							</div>

							<div class="form-group col-md-12 col-sm-12" align="center">
								<button style="width: 50%;" type="submit" class=" btn btn-sm btn-outline-primary">Atualizar</button>
							</div>

						</div>
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>

<script type="text/javascript">

	//----- define mascaras para algusn campos
	$('#cep{{$randId}}').mask("00.000-000");
	
	//----- edita ou salva um logradouro
	$('html body').delegate('form#form_logradouro_atualizar{{$randId}}','submit', function(ev){

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
					console.log(response.mensagem.id); //widthModal='lg', title='Titulo', height = null

					if(response.mensagem.hasOwnProperty('id') || response.mensagem == true){
						Utilitarios.assistenteMensageAlert('Registro atualizado com sucesso');
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
