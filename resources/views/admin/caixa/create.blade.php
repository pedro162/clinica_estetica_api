
@php $randId = rand(11111, 99999); @endphp

<div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('caixa.store')}}" method="post" class="form" id="form{{$randId}}">
			@csrf
			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>

			<div class="row  mt-5">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="name">Nome</label>
					<input type="text" name="name" id="name" class="form-control form-control-sm">
				</div>
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="type">Aceita tranferência</label>
					<select name="type" id="type" class="form-control form-control-sm">
						<option value="" selected="selected" disabled="">Selecionde</option>
						<option value="convencional">Convencional</option>
						<option value="banco">Banco</option>
					</select>
				</div>
			</div>
			<div class="row ">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="vrMin">Valor mínimo</label>
					<input type="text" name="vrMin" id="vrMin" class="form-control form-control-sm">
				</div>
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="vrMax">Valor máximo</label>
					<input type="text" name="vrMax" id="vrMax" class="form-control form-control-sm">
				</div>
			</div>
			<div class="row ">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="status_bloqueio">Bloquear</label>
					<select name="status_bloqueio" id="status_bloqueio" class="form-control form-control-sm">
						<option value="" selected="selected" disabled="">Selecionde</option>
						<option value="bloqueado">Sim</option>
						<option value="liberado">Não</option>
					</select>
				</div>
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="aceita_transferencia">Aceita tranferência</label>
					<select name="aceita_transferencia" id="aceita_transferencia" class="form-control form-control-sm">
						<option value="" selected="selected" disabled="">Selecionde</option>
						<option value="yes">Sim</option>
						<option value="no">Não</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-sm-12">
				</div>
				<div class="col-md-4 col-sm-12" style="text-align: right;">
					<button id="btn-salvar{{$randId}}" type="submit" class=" btn btn-sm btn-primary">Salvar</button>
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