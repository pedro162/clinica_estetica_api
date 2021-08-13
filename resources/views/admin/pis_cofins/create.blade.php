@php $randId = rand(11111, 99999);@endphp
<div class="row mb-5 p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('pis.cofins.store')}}" method="post" class="form " id="form{{$randId}}" enctype="multipart/form-data">
			@csrf

			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>
			@if(isset($formCofins) && $formCofins == true)
				<input type="hidden" name="tpRegistro" value="cofins" />
				<div class="row  mt-5">
					<div class="form-group col-md-12 col-sm-12">
						<label class="label" for="dsPisCofins{{$randId}}">Descrição</label>
						<input id="dsPisCofins{{$randId}}" name="dsPisCofins" type="text" name="nmNcm" class="form-control form-control-sm">
					</div>
				</div>

				<div class="row">

					<div class="form-group col-md-6 col-sm-12">
						<label for="st{{$randId}}" class="label">CST</label>
						<select id="st{{$randId}}" type="text" name="st" class="form-control form-control-sm">
							<@php $trib_icms_csosn = [
									'01'=>'Operação Tributável com Alíquota Básica',
									'02'=>'Operação Tributável com Alíquota Diferenciada',
									'03'=>'Operação Tributável com Alíquota por Unidade de Medida de Produto',
									'04'=>'Operação Tributável Monofásica – Revenda a Alíquota Zero',
									'05'=>'Operação Tributável por Substituição Tributária',
									'06'=>'Operação Tributável a Alíquota Zero',
									'07'=>'Operação Isenta da Contribuição',
									'08'=>'Operação sem Incidência da Contribuição',
									'09'=>'Operação com Suspensão da Contribuição',
									'49'=>'Outras Operações de Saída',
									'50'=>'Operação com Direito a Crédito – Vinculado Exclusivamente a Receita Tributada no Mercado Interno',
									'51'=>'Operação com Direito a Crédito – Vinculado Exclusivamente a Receita Não Tributada no Mercado Interno',
									'52'=>'Operação com Direito a Crédito – Vinculado Exclusivamente a Receita de Exportação',
									'53'=>'Operação com Direito a Crédito – Vinculado a Receitas Tributadas e Não-Tributadas no Mercado Interno',
									'54'=>'Operação com Direito a Crédito – Vinculado a Receitas Tributadas no Mercado Interno e de Exportação',
									'55'=>'Operação com Direito a Crédito – Vinculado a Receitas Não-Tributadas no Mercado Interno e de Exportação',
									'56'=>'Operação com Direito a Crédito – Vinculado a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
									'60'=>'Crédito Presumido – Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno',
									'61'=>'Crédito Presumido – Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno',
									'62'=>'Crédito Presumido – Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação',
									'63'=>'Crédito Presumido – Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno',
									'64'=>'Crédito Presumido – Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação',
									'65'=>'Crédito Presumido – Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação',
									'66'=>'Crédito Presumido – Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
									'67'=>'Crédito Presumido – Outras Operações',
									'70'=>'Operação de Aquisição sem Direito a Crédito',
									'71'=>'Operação de Aquisição com Isenção',
									'72'=>'Operação de Aquisição com Suspensão',
									'73'=>'Operação de Aquisição a Alíquota Zero',
									'74'=>'Operação de Aquisição sem Incidência da Contribuição',
									'75'=>'Operação de Aquisição por Substituição Tributária',
									'98'=>'Outras Operações de Entrada',
									'99'=>'Outras Operações',
								]; 
							@endphp

							@foreach($trib_icms_csosn as $key=>$al)
								<option value="{{$key}}">{{$al}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label for="tpCalculo{{$randId}}" class="label">Tip. cal COFINS </label>
						<select id="tpCalculo{{$randId}}" type="text" name="tpCalculo" class="form-control form-control-sm">
							<option value="pc">Porcentagem ( % )</option>
							<option value="vr">Valor ( R$ ) </option>
						</select>
					</div>

				</div>


				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="pcPisCofins{{$randId}}">Aliq. COFINS (%)</label>
						<input type="text" name="pcPisCofins" id="pcPisCofins{{$randId}}" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label for="vrPisCofins{{$randId}}" class="label">Valor COFINS (R$)</label>
						<input type="text" id="vrPisCofins{{$randId}}" name="vrPisCofins" class="form-control form-control-sm">
					</div>
				</div>

			@else
				<input type="hidden" name="tpRegistro" value="pis" />
				<div class="row  mt-5">
					<div class="form-group col-md-12 col-sm-12">
					<label class="label" for="dsPisCofins{{$randId}}">Descrição</label>
						<input id="dsPisCofins{{$randId}}" name="dsPisCofins" type="text" name="nmNcm" class="form-control form-control-sm">
					</div>

				</div>

				<div class="row">
					
					<div class="form-group col-md-6 col-sm-12">
						<label for="st{{$randId}}" class="label">CST</label>
						<select id="st{{$randId}}" type="text" name="st" class="form-control form-control-sm">
							<@php $trib_icms_csosn = [
									'01'=>'Operação Tributável com Alíquota Básica',
									'02'=>'Operação Tributável com Alíquota Diferenciada',
									'03'=>'Operação Tributável com Alíquota por Unidade de Medida de Produto',
									'04'=>'Operação Tributável Monofásica – Revenda a Alíquota Zero',
									'05'=>'Operação Tributável por Substituição Tributária',
									'06'=>'Operação Tributável a Alíquota Zero',
									'07'=>'Operação Isenta da Contribuição',
									'08'=>'Operação sem Incidência da Contribuição',
									'09'=>'Operação com Suspensão da Contribuição',
									'49'=>'Outras Operações de Saída',
									'50'=>'Operação com Direito a Crédito – Vinculado Exclusivamente a Receita Tributada no Mercado Interno',
									'51'=>'Operação com Direito a Crédito – Vinculado Exclusivamente a Receita Não Tributada no Mercado Interno',
									'52'=>'Operação com Direito a Crédito – Vinculado Exclusivamente a Receita de Exportação',
									'53'=>'Operação com Direito a Crédito – Vinculado a Receitas Tributadas e Não-Tributadas no Mercado Interno',
									'54'=>'Operação com Direito a Crédito – Vinculado a Receitas Tributadas no Mercado Interno e de Exportação',
									'55'=>'Operação com Direito a Crédito – Vinculado a Receitas Não-Tributadas no Mercado Interno e de Exportação',
									'56'=>'Operação com Direito a Crédito – Vinculado a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
									'60'=>'Crédito Presumido – Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno',
									'61'=>'Crédito Presumido – Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno',
									'62'=>'Crédito Presumido – Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação',
									'63'=>'Crédito Presumido – Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno',
									'64'=>'Crédito Presumido – Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação',
									'65'=>'Crédito Presumido – Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação',
									'66'=>'Crédito Presumido – Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
									'67'=>'Crédito Presumido – Outras Operações',
									'70'=>'Operação de Aquisição sem Direito a Crédito',
									'71'=>'Operação de Aquisição com Isenção',
									'72'=>'Operação de Aquisição com Suspensão',
									'73'=>'Operação de Aquisição a Alíquota Zero',
									'74'=>'Operação de Aquisição sem Incidência da Contribuição',
									'75'=>'Operação de Aquisição por Substituição Tributária',
									'98'=>'Outras Operações de Entrada',
									'99'=>'Outras Operações',
								]; 
							@endphp

							@foreach($trib_icms_csosn as $key=>$al)
								<option value="{{$key}}">{{$al}}</option>
							@endforeach
						</select>
					</div>
					


					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Tip. cal PIS </label>
						<select id="tpCalculo{{$randId}}" type="text" name="tpCalculo" class="form-control form-control-sm">
							<option value="pc">Porcentagem ( % )</option>
							<option value="vr">Valor ( R$ ) </option>
						</select>
					</div>
					
				</div>


				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="pcPisCofins{{$randId}}">Aliq. PIS (%)</label>
						<input type="text" name="pcPisCofins" id="pcPisCofins{{$randId}}" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6 col-sm-12">
					<label for="vrPisCofins{{$randId}}" class="label">Valor PIS (R$)</label>
						<input type="text" id="vrPisCofins{{$randId}}" name="vrPisCofins" class="form-control form-control-sm">
					</div>
				</div>
				
			@endif

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