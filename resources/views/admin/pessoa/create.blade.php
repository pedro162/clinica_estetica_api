
@php $randId = rand(11111, 99999); @endphp

 
<div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('pessoa.store')}}" method="post" class="form" id="form_pessoa_cadastrar{{$randId}}">
			@csrf
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
					<hr/>
					<div class="row">
						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="name{{$randId}}">Nome</label>
							<input type="text" id="name{{$randId}}" name="name" class="form-control form-control-sm" required="required"  minlength="3" maxlength="255">
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="name_opcional{{$randId}}">Sobrenome</label>
							<input type="text" id="name_opcional{{$randId}}" name="name_opcional" class="form-control form-control-sm"  minlength="3" maxlength="255">
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="documento{{$randId}}">CPF</label>
							<input type="text" id="documento{{$randId}}" name="documento" class="form-control form-control-sm" required="required" maxlength="14">
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="documento_complementar{{$randId}}">RG</label>
							<input type="text" id="documento_complementar{{$randId}}" name="documento_complementar" class="form-control form-control-sm">
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="nascimento_fundacao{{$randId}}">Nascimento</label>
							<input type="date" id="nascimento_fundacao{{$randId}}" name="nascimento_fundacao" class="form-control form-control-sm">
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="sexo{{$randId}}">Sexo</label>
							<select id="sexo{{$randId}}"  name="sexo" class="form-control form-control-sm" required="required">
								<option value="m">Masculino</option>
								<option value="f">Feminino</option>						
							</select>
						</div>

						<div class="form-group col-md-12 col-sm-12">
							<label class="label" for="groupo_id{{$randId}}">Grupo</label>
							<select id="groupo_id{{$randId}}"  name="groupo_id" class="form-control form-control-sm" required="required">
								@foreach($grupos as $grupo)
								<option value="{{$grupo->id}}">{{$grupo->name}}
								</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Endereço</h5>
					<hr/>
					<div class="row">
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

					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Contato</h5>
					<hr/>
					<div class="row"><legend></legend>
						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="celular_1{{$randId}}">Celular 1</label>
							<input type="text" id="celular_1{{$randId}}" name="celular_1" class="form-control form-control-sm" required="required" maxlength="15">
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="celular_2{{$randId}}">Celular 2</label>
							<input type="text" id="celular_2{{$randId}}" name="celular_2" class="form-control form-control-sm" maxlength="15">
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="telefone{{$randId}}">Telefone</label>
							<input type="text" id="telefone{{$randId}}" name="telefone" class="form-control form-control-sm" minlength="14" maxlength="14">
						</div>						

						<div class="form-group col-md-6 col-sm-12">
							<label class="label" for="email{{$randId}}">Email</label>
							<input type="text" id="email{{$randId}}" name="email" class="form-control form-control-sm" minlength="4" maxlength="255">
						</div>
					</div>
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

<script type="text/javascript">
	//----- define mascaras para algusn campos
	$('#cep{{$randId}}').mask("00000-000");
	$('#documento{{$randId}}').mask("000.000.000-00")
	$('#telefone{{$randId}}').mask("(00) 0000-0000")
	$('#celular_1{{$randId}}, #celular_2{{$randId}}').mask("(00) 0000-00009").on('blur', function(ev){
		if($(this).val().length == 15){
			$(this).mask("(00) 00000-0009")
		}else{
			$(this).mask("(00) 0000-00009")
		}
	})
	$('#documento_complementar{{$randId}}').mask("999.999.999.999-w",{
		translation: {'w':{
				pattern:/[X0-9]/
			}
		},
		reverse:true
	})


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


	//----- edita ou salva uma pessoa
	$('html body').delegate('form#form_pessoa_cadastrar{{$randId}}','submit', function(ev){

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

						if(id == 'form_pessoa_atualizar'){

							Utilitarios.assistenteModal('Pessoa atualizada com sucesso');

						}else{

							Utilitarios.assistenteModal('Pessoa cadastrada com sucesso');

						}

					}else{

						if(id == 'form_pessoa_atualizar'){

							Utilitarios.assistenteModal('Erro ao atuaolizar registro', 'warning');

						}else{

							Utilitarios.assistenteModal('Erro ao cadastrar registro', 'warning');

						}

						
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


	//----- valida o cpf
	$('html').delegate('#documento{{$randId}}','keyup', function(ev){

		let cpf = $(this).val().trim().replace(/[\.]/g, '');
		cpf = cpf.replace(/[-]/g, '');

		try{

			if(cpf.trim().length < 11){
				return false;
			}

			let url = '/pessoa/valida/cpf/'+cpf;

			$.ajax({
				url:url,
				type:'GET',
				dataType:'json',
				success:function(response){
					console.log(response);
					Utilitarios.assistenteMensageAlertClear();
					if(response.hasOwnProperty('mensagem') || (response.mensagem.lenght > 0)){

						//Utilitarios.assistenteMensageAlert(response.mensagem);

					}
				},
				beforeSend:function(){
					Utilitarios.assistenteMensageAlert('Aguarde, validando cpf...', 'warning');
				},
				error:function(response, status, error){
					console.log(response);
					Utilitarios.assistenteMensageAlertClear();

					let objErros = response.responseJSON
					let msg = objErros.mensagem;

					Utilitarios.assistenteMensageAlert(msg, 'warning');
				}


			})

		}catch(ex){

			console.log(ex.message);
		}

			ev.preventDefault();
	});
	
</script>
