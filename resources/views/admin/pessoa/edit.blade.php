
@php $randId = rand(11111, 99999); @endphp

<div class="container-fluid">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('pessoa.update', $registro->id)}}" id="form_pessoa_atualizar{{$randId}}" method="post" class="form row p-5">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="row">
							<div class="col-md-4 col-sm-12" style="box-sizing: border-box;">
								<img src="{{asset('img/perfil/avatar.png')}}" alt="Imagem de um avatar padrão" style="width: 80%;">
							</div>
							<div class="col-md-8 col-sm-12">
							
								<h4>Dados Pessoais</h4>
								<div class="row"><legend></legend>
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

									<div class="form-group col-md-6 col-sm-12">
										<label class="label" for="groupo_id{{$randId}}">Grupo</label>
										<select id="groupo_id{{$randId}}"  name="groupo_id" class="form-control form-control-sm" required="required">
											@foreach($grupos as $grupo)
											<option value="{{$grupo->id}}" {{ isset($registro->grupo[0]->id) ? $registro->grupo[0]->id == $grupo->id ? 'selected' : '' : ''}}>{{$grupo->name}}
											</option>
											@endforeach
										</select>
									</div>

									<div class="form-group col-md-6 col-sm-12">
										<label class="label" for="email{{$randId}}">Email</label>
										<input type="text" id="email{{$randId}}" name="email" value="{{$registro->email}}" class="form-control form-control-sm">
									</div>
									<div class="form-group col-md-12 col-sm-12" align="center">
										<button style="width: 50%;" type="submit" class=" btn btn-sm btn-outline-primary">Atualizar</button>
									</div>
								</div>
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
	$('html body').delegate('form#form_pessoa_atualizar{{$randId}}','submit', function(ev){

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
						//Utilitarios.assistenteMensageAlert('Registro atualizado com sucesso');
						Utilitarios.assistenteMensageAlert('Registrado com sucesso');
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

					//Utilitarios.assistenteMensageAlert(msg, 'warning');
					Utilitarios.assistenteModal(msg, 'md', 'Resultado', '500px')
				}


			})

		}catch(ex){

			console.log(ex.message);
		}

			ev.preventDefault();
	});

</script>
