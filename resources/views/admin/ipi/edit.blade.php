@php $randId = rand(11111, 99999); @endphp

<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{route('ncm.update', $registro->id)}}" method="post" class="form" id="form_{{$randId}}" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				
				<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
				<hr/>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">CST</label>
						<select title="Código da situação tributária referente ao imposto sobre produtos industrializados (CST-IPI):" type="text" name="categoria_id" class="form-control form-control-sm">
							
							@php $cst = [
									'0'	=>'Entrada com Recuperação de Crédito',
									'1'	=>'Entrada Tributável com Alíquota Zero',
									'2'	=>'Entrada Isenta',
									'3'	=>'Entrada Não-Tributada',
									'4'	=>'Entrada Imune',
									'5'	=>'Entrada com Suspensão',
									'49'=>'Outras Entradas',
									'50'=>'Saída Tributada',
									'51'=>'Saída Tributável com Alíquota Zero',
									'52'=>'Saída Isenta',
									'53'=>'Saída Não-Tributada',
									'54'=>'Saída Imune',
									'55'=>'Saída com Suspensão',
									'99'=>'Outras Saídas',
								]; 
							@endphp

							@foreach($cst as $key=>$al)
								<option {{isset($registro->st) && trim($registro->st) == $key ? 'selected': ''}} value="{{$key}}">{{$al}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Cód. ex. da TIPI</label>
						<input title="Código de excessão da incidência de IPI" value="{{$registro->cdTip}}" type="text" name="cdTip" class="form-control form-control-sm ">
					</div>
				</div>
				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Modalidade IPI</label>
						<select type="text"  name="tpCalculoIpi" id="tpCalculoIpi{{$randId}}" class="form-control form-control-sm">
							<option {{isset($registro->tpCalculoIpi) && trim($registro->tpCalculoIpi) == 'pc' ? 'selected': ''}} value="pc">Aliq.</option>
							<option {{isset($registro->tpCalculoIpi) && trim($registro->tpCalculoIpi) == 'vr' ? 'selected': ''}} value="vr">Vr. por un.</option>
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aiq. IPI (%)</label>
						<input type="text" value="{{$registro->aliqIpi}}" name="aliqIpi" id="aliqIpi{{$randId}}" class="form-control form-control-sm ">
					</div>
				</div>
				<div  class="row" >

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Vr. IPI</label>
						<input readonly="readonly" value="{{$registro->vrIpi}}" type="text"  name="vrIpi" id="vrIpi{{$randId}}" class="form-control form-control-sm ">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">BC IPI</label>
						<input type="text" name="baseCalculo" value="{{$registro->baseCalculo}}" class="form-control form-control-sm ">
					</div>

				</div>
				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Soma IPI BC do ICMS</label>
						<select type="text" name="somaIpiIcms" class="form-control form-control-sm">
							<option  {{isset($registro->somaIpiIcms) && trim($registro->somaIpiIcms) == 'yes' ? 'selected': ''}} value="yes">sim.</option>
							<option  {{isset($registro->somaIpiIcms) && trim($registro->somaIpiIcms) == 'no' ? 'selected': ''}} value="no">Não</option>
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Soma IPI BC do ICMS ST</label>
						<select type="text" name="somaIpiIcmsSt" class="form-control form-control-sm">
							<option  {{isset($registro->somaIpiIcmsSt) && trim($registro->somaIpiIcmsSt) == 'yes' ? 'selected': ''}} value="yes">sim.</option>
							<option  {{isset($registro->somaIpiIcmsSt) && trim($registro->somaIpiIcmsSt) == 'no' ? 'selected': ''}} value="no">Não</option>
						</select>
					</div>
				</div>		

				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Classe de enquadramento</label>
						<input type="text" value="{{$registro->classEnquadra}}" name="classEnquadra" class="form-control form-control-sm ">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Código de enquadramento</label>
						<input type="text" value="{{$registro->cdEnquadra}}" name="cdEnquadra" class="form-control form-control-sm ">
					</div>
				</div>

				<div class="row">

					<div class="col-md-8 col-sm-12">
					</div>
					<div class="col-md-4 col-sm-12" style="text-align: right;">
						<button type="submit" class=" btn btn-md btn-primary">Salvar</button>
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