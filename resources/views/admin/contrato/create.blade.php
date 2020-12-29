
@php $randId = rand(11111, 99999); @endphp

<div class="container-fluid">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('contrato.store', $registro->id)}}" method="post" class="form row p-2" id="form_contrato_cadastrar{{$randId}}">
				@csrf
				<div class="row">
					<div class="col-md-12 col-sm-12 " >
						<fieldset class="row"><legend></legend>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="filial_id{{$randId}}">Filial</label>
								<select id="filial_id{{$randId}}" name="filial_id" class="form-control form-control-sm" required="required" >
									<option></option>
									@foreach($filial as $fil)
										<option value="{{$fil->id}}" >{{$fil->pessoa->name}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="vrAdesao{{$randId}}">Valor da Adesao</label>
								<input type="text" id="vrAdesao{{$randId}}" name="vrAdesao" class="form-control form-control-sm" required="required"  minlength="3" maxlength="255">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="vrContrato{{$randId}}">Valor do Contrato</label>
								<input type="text" id="vrContrato{{$randId}}" name="vrContrato" class="form-control form-control-sm" required="required">
							</div>

							
							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="dtVencimento{{$randId}}">Vencimento</label>
								<input type="date" id="dtVencimento{{$randId}}" name="dtVencimento" class="form-control form-control-sm">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="tpVencimento{{$randId}}">Vencimento</label>								
								<select id="tpVencimento{{$randId}}" name="tpVencimento" class="form-control form-control-sm" required="required" >
									<option></option>
									<option value="semana" >Semanal</option>
									<option value="mes" >Mensal</option>
								</select>
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<label class="label" for="isLiberaCatraca{{$randId}}">Liberar Catraca</label>								
								<select id="isLiberaCatraca{{$randId}}" name="isLiberaCatraca" class="form-control form-control-sm" required="required" >
									<option value="false">Não</option>
									<option value="true" >Sim</option>
								</select>
							</div>

							<div class="form-group col-md-12 col-sm-12" >
								<button style="float:right;" type="submit" class=" btn btn-sm btn-outline-primary">Salvar</button>
							</div>
							<div style="clear:both;"></div>
						</fieldset>
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>

<script type="text/javascript">
	

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
