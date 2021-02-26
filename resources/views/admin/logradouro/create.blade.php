
@php $randId = rand(11111, 99999); @endphp

<div class="container-fluid">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('logradouro.store', $registro->id)}}" method="post" class="form row p-2" id="form_logradouro_cadastrar{{$randId}}">
				@csrf
				<div class="row">
					
					<div class="col-md-12 col-sm-12">
						<h4>Endereço</h4>
						<div class="row"><legend></legend>
							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="cep{{$randId}}">Cep</label>
								<input type="text" id="cep{{$randId}}" name="cep" class="form-control form-control-sm" required="required">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="logradouro">Logradouro</label>
								<input type="text" id="logradouro{{$randId}}" name="logradouro" class="form-control form-control-sm" required="required"  minlength="3" maxlength="255">
							</div>


							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="numero">Número</label>
								<input type="number" id="numero{{$randId}}" name="numero" class="form-control form-control-sm"  min="1" max="100000">
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
								<input id="complemento{{$randId}}" type="text" name="complemento" class="form-control form-control-sm"  minlength="3" maxlength="255">
								</select>
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="bairro">Bairro</label>
								<input type="text" id="bairro{{$randId}}" name="bairro" class="form-control form-control-sm" required="required"  minlength="3" maxlength="255">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="cidade">Cidade</label>
								<input type="text" id="cidade{{$randId}}" name="cidade" class="form-control form-control-sm" required="required" minlength="3" maxlength="255">
							</div>

							<div class="form-group col-md-12 col-sm-12">
								<label class="label" for="estado">Estado</label>
								<input type="text" id="estado{{$randId}}" name="estado" class="form-control form-control-sm" required="required" minlength="2" maxlength="2">
							</div>

							<div class="form-group col-md-12 col-sm-12" align="center">
								<button style="width: 50%;" type="submit" class=" btn btn-sm btn-outline-primary">Salvar</button>
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
	$('#cep{{$randId}}').mask("00000-000");
	//----- tenta carregar o endereço pelo cep
	$('html body').delegate('#cep{{$randId}}', 'keyup', function(){
		
		let cep = $(this).val().trim().replace(/[\.]/g, '');
		cep = cep.replace(/[-]/g, '');

		if(cep.length < 8){
			return false;
		}
		let url = '/logradouro/load/api?cep='+cep;
		let type = 'GET';
		let dataType = 'json';

		$.ajax({
			url:url,
			type:type,
			dataType:dataType,
			success:function(response){
				Utilitarios.assistenteMensageAlertClear();
				console.log(response.mensagem);

				let dados = JSON.parse(response.mensagem);
				console.log(dados.cep);
				
				let campo_cep 			= $('html body').find('#cep{{$randId}}');
				let campo_logradouro 	= $('html body').find('#logradouro{{$randId}}');
				let campo_numero 		= $('html body').find('#numero{{$randId}}');
				let campo_tipo 			= $('html body').find('#tipo{{$randId}}');
				let campo_bairro 		= $('html body').find('#bairro{{$randId}}');
				let campo_cidade 		= $('html body').find('#cidade{{$randId}}');
				let campo_estado 		= $('html body').find('#estado{{$randId}}');

				campo_cep.val(			typeof dados.cep 		=='string'	? dados.cep 		: campo_cep.val());
				campo_logradouro.val(	typeof dados.logradouro =='string'	? dados.logradouro 	: campo_logradouro.val());
				campo_bairro.val(		typeof dados.bairro 	=='string'	? dados.bairro 		: campo_bairro.val());
				campo_cidade.val(		typeof dados.localidade =='string'	? dados.localidade 	: campo_cidade.val());
				campo_estado.val(		typeof dados.uf 		=='string'	? dados.uf 			: campo_estado.val());
				
			},
			beforeSend:function(){
				Utilitarios.assistenteMensageAlert('Aguarde, carregando endreço...', 'warning');
			},
			error:function(response, status, error){
					//console.log(response, status, error)
					Utilitarios.assistenteMensageAlertClear();

					console.log(response.responseJSON);
					
					//Utilitarios.assistenteMensageAlert('Erro ao carregar o cep', 'warning');
			}
		})

	})


	//----- edita ou salva uma logradouro
	$('html body').delegate('form#form_logradouro_cadastrar{{$randId}}','submit', function(ev){

		try{

			ev.preventDefault();

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

						Utilitarios.assistenteMensageAlert('Logradouro atualizado com sucesso');

					}
				},
				error:function(response, status, error){
					//console.log(response, status, error)
					console.log(response);
					let objErros = response.responseJSON.errors;
					let errors = response.responseJSON;
					let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';

					if(response.responseJSON.errors){
						for (let prop in objErros){
							msg+='<strong>'+prop+': </strong>'+objErros[prop]+'<br/>';
						}

					}else if(errors.mensagem){
						let erros = errors.mensagem;
						console.log(erros);
						for (let i=0; !(i == erros.length); i++){
							msg+=erros[i]+'<br/>';
						}
					}
					Utilitarios.assistenteMensageAlert(msg, 'warning');
				}


			})

		}catch(ex){

			console.log(ex.message);
		}
	});


	
	
</script>
