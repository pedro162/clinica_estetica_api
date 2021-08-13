@php $randId = rand(11111, 99999);@endphp
<div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('ncm.store')}}" method="post" class="form " id="form{{$randId}}" enctype="multipart/form-data">
			@csrf

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
							<option value="{{$key}}">{{$al}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Cód. ex. da TIPI</label>
					<input title="Código de excessão da incidência de IPI " type="text" name="imagem" class="form-control form-control-sm ">
				</div>
			</div>
			<div  class="row" >
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Modalidade IPI</label>
					<select type="text" name="tpCalculoIpi" id="tpCalculoIpi{{$randId}}" class="form-control form-control-sm">
						<option value="pc">Aliq.</option>
						<option value="vr">Vr. por un.</option>
					</select>
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Aiq. IPI (%)</label>
					<input type="text" name="aliqIpi" id="aliqIpi{{$randId}}" class="form-control form-control-sm ">
				</div>
			</div>
			<div  class="row" >

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Vr. IPI</label>
					<input readonly="readonly" type="text"  name="vrIpi" id="vrIpi{{$randId}}" class="form-control form-control-sm ">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">BC IPI</label>
					<input type="text" name="imagem" class="form-control form-control-sm ">
				</div>

			</div>
			<div  class="row" >
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Soma IPI BC do ICMS</label>
					<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
						<option value="">sim.</option>
						<option value="">Não</option>
					</select>
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Soma IPI BC do ICMS ST</label>
					<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
						<option value="">sim.</option>
						<option value="">Não</option>
					</select>
				</div>
			</div>		

			<div  class="row" >
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Classe de enquadramento</label>
					<input type="text" name="imagem" class="form-control form-control-sm ">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Código de enquadramento</label>
					<input type="text" name="imagem" class="form-control form-control-sm ">
				</div>
			</div>

			<div  class="row" >
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">CNPJ do produtor</label>
					<input type="text" name="imagem" class="form-control form-control-sm ">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Código do celo de controle</label>
					<input type="text" name="imagem" class="form-control form-control-sm ">
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