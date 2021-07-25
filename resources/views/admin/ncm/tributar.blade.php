
@php 

	$csosn = false;

@endphp
<div class="row mb-5 p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('produto.store')}}" method="post" class="form " id="form_produto_cadastrar" enctype="multipart/form-data">
			@csrf

			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>

			<div class="row  mt-5">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Código NCM</label>
					<input type="text" name="name" class="form-control form-control-sm">
				
					<label class="label">Descrição</label>
					<input type="text" name="description" class="form-control form-control-sm">
				</div>
			
			</div>
			
			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Operação</h5>
			<hr/>
			<div class="row">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">CFOP</label>
					<input type="text" name="name" class="form-control form-control-sm">
				
					<label class="label">Descrição</label>
					<input type="text" name="description" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Origem CST A</label>
					<select type="text" name="marca_id" class="form-control form-control-sm">
                        @php $origem = [
                            '1'=>'Estrangeira - Importação direta, exceto a indicada no código 6',
                            '2'=>'Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7',
                            '3'=>'Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%',
                            '4'=>'Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam as legislações citadas nos Ajustes',
                            '5'=>'Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%; ',
                            '6'=>'Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX; ',
                            '7'=>'Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista da CAMEX.',
                            '8'=>'Nacional , mercadoria ou bem com Conteúdo de Importação Superior a 70%.',
                        ]; @endphp
						@foreach($origem as $key=>$val)
							<option value="{{$key}}">{{$val}}</option>
						@endforeach
					</select>
				</div>

			</div>
			
			@if($csosn == false)
				<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">ICMS</h5>
				<hr/>
				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">CST B</label>
						<select type="text" name="categoria_id" class="form-control form-control-sm">
								
							@php $trib_icms = [
									'00'=>'Tributada integralmente',
									'10'=>'Tributada e com cobrança do ICMS por substituição tributária',
									'20'=>'Com redução de base de cálculo',
									'30'=>'Isenta ou não tributada e com cobrança do ICMS por substituição tributária',
									'40'=>'Isenta',
									'41'=>'Não tributada',
									'50'=>'Suspensão',
									'60'=>'Diferimento',
									'70'=>'ICMS cobrado anteriormente por substituição tributária',
									'80'=>'Com redução de base de cálculo e cobrança do ICMS por substituição tributária.',
									'90'=>'Outras',
								]; 
							@endphp

							@foreach($trib_icms as $key=>$al)
								<option value="{{$key}}">{{$al}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Mod. BCICMS</label>
						<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
							<option alt="Modalidade de determinação da Base de Cálculo" value="{{$categoria->id}}">{{$categoria->name}}</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Mod. BC ICMS ST</label>
						<select alt="Modalidade de determinação da Base de Cálculo do ICMS ST" type="text" name="sub_categoria_id" class="form-control form-control-sm">
							<option  value="">Margem valor agregado</option>
							<option  value="">Pauta (valor)</option>
							<option  value="">Preço tabelado máx (valor)</option>
							<option  value="">Valor da operação</option>
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Red. BC ICMS ST(%)</label>
						<input alt="Percentual de redução da base de cáluclo" type="text" name="ncm" class="form-control form-control-sm">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aliq. ICMS(%)</label>
						<input alt="Alíquota ICMS" type="text" name="ean" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">MVA ICMS ST (%)</label>
						<input alt="Percentual da margem do Valor Adicionado ao ICMS ST" type="text" name="ncm" class="form-control form-control-sm">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">CST PIS</label>
						<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
							<option value="{{$categoria->id}}">{{$categoria->name}}</option>
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aliq. PIS (%)</label>
						<input type="text" name="ncm" class="form-control form-control-sm">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">CST COFINS</label>
						<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
							<option value="{{$categoria->id}}">{{$categoria->name}}</option>
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aliq. COFINS (%)</label>
						<input type="text" name="ncm" class="form-control form-control-sm">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 col-sm-12">
						<label class="label">Aliq. IPI (%)</label>
						<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
							<option value="{{$categoria->id}}">{{$categoria->name}}</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Red. BC ICMS (%)</label>
						<select type="text" name="origem" class="form-control form-control-sm">						
							<option value=""></option>						
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aliq. ICMS ST(%)</label>
						<input type="file" name="imagem" class="form-control form-control-sm ">
					</div>
				</div>
				
			@else

				<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">ICMS SIMPLES NACIONAL </h5>
				<hr/>
				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">COSN</label>
						<select type="text" name="categoria_id" class="form-control form-control-sm">
							
							@php $trib_icms_csosn = [
									'101'=>'Tributada pelo Simples Nacional com permissão de crédito',
									'102'=>'Tributada pelo Simples Nacional sem permissão de crédito',
									'103'=>'Isenção do ICMS no Simples Nacional para faixa de receita bruta',
									'201'=>'Tributada pelo Simples Nacional com permissão de crédito e com cobrança do ICMS por substituição tributária',
									'202'=>'Tributada pelo Simples Nacional sem permissão de crédito e com cobrança do ICMS por substituição tributária',
									'203'=>'Isenção do ICMS no Simples Nacional para faixa de receita bruta e com cobrança do ICMS por substituição tributária',
									'300'=>'Imune',
									'400'=>'Não tributada pelo Simples Nacional',
									'500'=>'ICMS cobrado anteriormente por substituição tributária (substituído) ou por antecipação',
									'900'=>'Outros',
								]; 
							@endphp

							@foreach($trib_icms_csosn as $key=>$al)
								<option value="{{$key}}">{{$al}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aiq. Cal. Cred (%)</label>
						<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
							<option value="{{$categoria->id}}">{{$categoria->name}}</option>
						</select>
					</div>
				</div>
			@endif

            <h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">IPI </h5>
				<hr/>
				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">CST</label>
						<select type="text" name="categoria_id" class="form-control form-control-sm">
							
							@php $trib_icms_csosn = [
								]; 
							@endphp

							@foreach($trib_icms_csosn as $key=>$al)
								<option value="{{$key}}">{{$al}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Modalidade IPI</label>
						<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
							<option value="">Aliq.</option>
							<option value="">Vr. por un.</option>
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Aiq. IPI (%)</label>
						<input type="file" name="imagem" class="form-control form-control-sm ">
					</div>
				</div>
				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">BC IPI</label>
						<input type="file" name="imagem" class="form-control form-control-sm ">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Vr. IPI</label>
						<input type="file" name="imagem" class="form-control form-control-sm ">
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
	//edita ou salva um produto
	$('html body').delegate('form#form_produto_cadastrar, form#form_produto_atualizar','submit', function(ev){

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

						Utilitarios.assistenteMensageAlert('Registrado com sucesso');

					}else{

						Utilitarios.assistenteMensageAlert('Erro ao atuaolizar registro', 'warning');

						
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