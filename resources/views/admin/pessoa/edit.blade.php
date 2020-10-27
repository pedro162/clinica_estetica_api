
@php $randId = rand(11111, 99999); @endphp

<div class="container-fluid">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('categoria.update', $registro->id)}}" method="post" class="form row p-5">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-5 col-sm-12">
						<h4>Dados Pessoais</h4>
						<fieldset class="row"><legend></legend>
							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="name{{$randId}}">Nome</label>
								<input type="text" id="name{{$randId}}" name="name" class="form-control form-control-sm" required="required" value="{{$registro->name}}" minlength="3" maxlength="255">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="name_opcional{{$randId}}">Sobrenome</label>
								<input type="text" id="name_opcional{{$randId}}" name="name_opcional" class="form-control form-control-sm" value="{{$registro->name_opcional}}" minlength="3" maxlength="255">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="documento{{$randId}}">CPF</label>
								<input type="text" id="documento{{$randId}}" name="documento" class="form-control form-control-sm" required="required" value="{{$registro->documento}}">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="documento_complementar{{$randId}}">RG</label>
								<input type="text" id="documento_complementar{{$randId}}" name="documento_complementar" class="form-control form-control-sm" value="{{$registro->documento_complementar}}">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="nascimento_fundacao{{$randId}}">Nascimento</label>
								<input type="date" id="nascimento_fundacao{{$randId}}" name="nascimento_fundacao" class="form-control form-control-sm" value="{{$registro->nascimento_fundacao}}">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="sexo{{$randId}}">Sexo</label>
								<select id="sexo{{$randId}}"  name="sexo" class="form-control form-control-sm" required="required">
									<option value="m" {{$registro->sexo == 'm' ? 'selected' : ''}}>Masculino</option>
									<option value="f" {{$registro->sexo == 'f' ? 'selected' : ''}}>Feminino</option>						
								</select>
							</div>

							<div class="form-group col-md-12 col-sm-12">
								<label class="label" for="groupo_id{{$randId}}">Grupo</label>
								<select id="groupo_id{{$randId}}"  name="groupo_id" class="form-control form-control-sm" required="required">
									@foreach($grupos as $grupo)
									<option value="{{$grupo->id}}" {{$registro->grupo[0]->id == $grupo->id ? 'selected' : ''}}>{{$grupo->name}}
									</option>
									@endforeach
								</select>
							</div>
						</fieldset>
					</div>

					<div class="col-md-5 col-sm-12">
						<h4>Endereço</h4>
						@php $enderecoPrincipal = $registro->logradouro->where('importancia', '=', 'principal')->first(); @endphp
						<fieldset class="row"><legend></legend>
							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="cep{{$randId}}">Cep</label>
								<input type="text" id="cep{{$randId}}" name="cep" class="form-control form-control-sm" required="required" value="{{$enderecoPrincipal->cep}} ">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="logradouro">Logradouro</label>
								<input type="text" id="logradouro{{$randId}}" name="logradouro" class="form-control form-control-sm" required="required" value="{{$enderecoPrincipal->logradouro}} "  minlength="3" maxlength="255">
							</div>


							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="numero">Número</label>
								<input type="number" id="numero{{$randId}}" name="numero" class="form-control form-control-sm"  min="1" max="100000" value="{{$enderecoPrincipal->numero}} ">
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
								<input id="complemento{{$randId}}" type="text" name="complemento" class="form-control form-control-sm"  minlength="3" maxlength="255" value="{{$enderecoPrincipal->complemento}} ">
								</select>
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="bairro">Bairro</label>
								<input type="text" id="bairro{{$randId}}" name="bairro" class="form-control form-control-sm" required="required"  minlength="3" maxlength="255" value="{{$enderecoPrincipal->bairro}} ">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="cidade">Cidade</label>
								<input type="text" id="cidade{{$randId}}" name="cidade" class="form-control form-control-sm" required="required" minlength="3" maxlength="255" value="{{$enderecoPrincipal->cidade}} ">
							</div>

							<div class="form-group col-md-12 col-sm-12">
								<label class="label" for="estado">Estado</label>
								<input type="text" id="estado{{$randId}}" name="estado" class="form-control form-control-sm" required="required" minlength="2" maxlength="2" value="{{$enderecoPrincipal->estado}} ">
							</div>

						</fieldset>
					</div>

					<div class="col-md-2 col-sm-12">
						<h4>Contato</h4>
						<fieldset class="row"><legend></legend>
							<div class="form-group col-md-12 col-sm-12">
								<label class="label" for="celular_1{{$randId}}">Celular 1</label>
								<input type="text" id="celular_1{{$randId}}" name="celular_1" class="form-control form-control-sm" required="required" >
							</div>

							<div class="form-group col-md-12 col-sm-12">
								<label class="label" for="celular_2{{$randId}}">Celular 2</label>
								<input type="text" id="celular_2{{$randId}}" name="celular_2" class="form-control form-control-sm">
							</div>

							<div class="form-group col-md-12 col-sm-12">
								<label class="label" for="telefone{{$randId}}">Telefone</label>
								<input type="text" id="telefone{{$randId}}" name="telefone" class="form-control form-control-sm" >
							</div>						

							<div class="form-group col-md-12 col-sm-12">
								<label class="label" for="email{{$randId}}">Email</label>
								<input type="text" id="email{{$randId}}" name="email" value="{{$registro->email}}" class="form-control form-control-sm">
							</div>
						</fieldset>
					</div>
				</div>
				
				<div class="col mt-4" align="center">
					<button style="width: 50%;" type="submit" class=" btn btn-sm btn-outline-primary">Atualizar</button>
				</div>
			</form>
		</div>
	</div>	
</div>

<script type="text/javascript">

	//----- define mascaras para algusn campos
	$('#cep{{$randId}}').mask("00.000-000");
	$('#documento{{$randId}}').mask("000.000.000-00")
	$('#telefone{{$randId}}').mask("(00) 0000-0000")
	$('celular_1{{$randId}}, celular_2{{$randId}}').mask("(00) 0000-00009").on('blur', function(ev){
		if($(this).val().length == 15){
			$(this).mask("(00) 00000-0009")
		}else{
			$(this).mask("(00) 0000-00009")
		}
	})
	$('#documento_complementar{{$randId}}').mask("999.999.999-w",{
		translation: {'w':{
				pattern:/[X0-9]/
			}
		},
		reverse:true
	})

	//----- edita ou salva uma pessoa
	$('html body').delegate('form#form_pessoa_atualizar','submit', function(ev){

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

						if(id == 'form_pessoa_atualizar'){

							Utilitarios.assistenteMensageAlert('Pessoa atualizada com sucesso');

						}else{

							Utilitarios.assistenteMensageAlert('Pessoa cadastrada com sucesso');

						}

					}else{

						if(id == 'form_pessoa_atualizar'){

							Utilitarios.assistenteMensageAlert('Erro ao atuaolizar registro', 'warning');

						}else{

							Utilitarios.assistenteMensageAlert('Erro ao cadastrar registro', 'warning');

						}

						
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
