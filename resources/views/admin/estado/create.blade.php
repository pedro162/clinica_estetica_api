@php $randId = rand(11111, 99999);@endphp
<div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('estado.store')}}" method="post" class="form " id="form{{$randId}}" enctype="multipart/form-data">
			@csrf

			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>
			<div  class="row" >
				<div class="form-group col-md-12 col-sm-12">
					<label class="label" for="nmEStado{{$randId}}" >Descrição</label>
					<input type="text" name="nmEStado" id="nmEStado{{$randId}}" class="form-control form-control-sm ">
				</div>
			</div>

			<div  class="row" >
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="pais_id{{$randId}}">País</label>
					<select type="text"  name="pais_id" title="Define o país do estado" id="pais_id{{$randId}}" class="form-control form-control-sm">
						@foreach($paises as $pais)
							<option value="{{$pais->id}}">{{$pais->nmPais}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="padrao{{$randId}}" >Definir como padrão</label>
					<select type="text" name="padrao" title="Define o estado como padrão" id="padrao{{$randId}}" class="form-control form-control-sm">
						<option value="yes">Sim</option>
						<option value="no" selected>Não</option>
					</select>
				</div>
			</div>	

			<div  class="row" >
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="codEstado{{$randId}}" >Código do estado</label>
					<input type="text" name="codEstado" title="Classe de enquadramento" id="codEstado{{$randId}}" class="form-control form-control-sm ">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="sigla{{$randId}}" >Sigla</label>
					<input type="text" name="sigla" title="Classe de enquadramento" id="sigla{{$randId}}" class="form-control form-control-sm ">
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