@php $randId = rand(11111, 99999); @endphp
<div class="row">
	<!--<div class="col-md-12">
		<h4>Lista de produtos</h4>	
	</div>-->
	<div class="col">
		<table style="width: 100%;" id="lista{{$randId}}" class=" data-table table table-sm table-responsive table-hover display">
			@csrf
			<thead style="width: 100%;">
				<tr>
					<th>
						Cód
					</th>
					<th>
						NCM
					</th>
					<th>
						Descrição
					</th>
					<th>
						Ex. NCM
					</th>
					<th>
						Tipo código
					</th>
					<th>
						Ex. tip
					</th>
					<th>
						Tabela
					</th>
					<th>
						Alíquota nacional
					</th>
					<th>
						Alíquota importada
					</th>
					<th>
						Alíquota estadual
					</th>
					<th>
						Alíquota municipal
					</th>
					
				</tr>
			</thead>
			<tbody style="width: 100%;">
				@foreach($registro as $valor)
				<tr class="assistenteModalNCM">
					<td class="text-right">{{$valor->id}}</td>
					<td>{{$valor->codNcm}}</td>
					<td>{{$valor->nmNcm}}</td>
					<td>{{$valor->excecaoNcm}}</td>
					<td>{{$valor->tpCodigo}}</td>
					<td >{{$valor->exTipi}}</td>
					<td>{{$valor->nmTabela}}</td>
					<td class="text-right">{{$valor->vrAliqNacional}}</td>
					<td class="text-right">{{$valor->vrAliqImportada }}</td>
					<td class="text-right">{{$valor->vrAliqEstadual}}</td>
					<td class="text-right">{{$valor->vrAliqMunicipal}}</td>
					<input type="hidden" name="item" value="{{$valor->id}}">
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	let idTable = $('#lista{{$randId}}');
	Utilitarios.useDataTable(idTable);

	let idModalOptions{{$randId}} = null;

	let callBack{{$randId}} = '{{$consulta["callBack"]}}'
	//alert(callBack{{$randId}})


	/**
	*	CHAMA O MODAL DE OPÇÕES DE NCM
	*/
	$('body').find('#lista{{$randId}}').find('.assistenteModalNCM').on('click', function(ev){
		try{
			let id = $(this).find('input:hidden').val();

			let arrLinks = [
				//['Ediar', '/ncm/edit/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_editar'],
				['Ediar', '/ncm/edit/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_editar{{$randId}}', id , 'editar{{$randId}}(this);'],
				['Excluir', '/ncm/info/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_deletar{{$randId}}', id, 'deletar{{$randId}}(this);'],
				

			];
			//widthOptions='200px', widModal = 'md', height=null //, 'HTML','Marca-Editar', 'sm', '400px'
			idModal = Utilitarios.assitentOpcoes(arrLinks, '100%', 'xs');
			idModalOptions{{$randId}} = idModal;
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	})

	

	function editar{{$randId}}(element){
		try{
			let url = $(element).attr('href');
			let id = $(element).attr('idItem');
			let idModal= $(element).attr('idModal');
			// //
			Utilitarios.fecharAssistente(idModalOptions{{$randId}});
			let data = new FormData();
			data.append('id', id)
			data.append('idAssistente', '')
			data.append('callBack', ''+callBack{{$randId}}+'')

			let token = $('html').find('#lista{{$randId}}').find('input[name="_token"]').val()
			data.append('_token', token)

			Utilitarios.assistentAjaxModal('POST',url, 'HTML','NCM-Editar', 'sm', '300px', null, data)
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function deletar{{$randId}}(element){
		try{
			
			let url = $(element).attr('href');
			let id = $(element).attr('idItem');
			let idModal= $(element).attr('idModal');
			// //
			Utilitarios.fecharAssistente(idModalOptions{{$randId}});

			let data = new FormData();
			data.append('id', id)
			data.append('idAssistente', '')
			data.append('callBack', ''+callBack{{$randId}}+'')

			let token = $('html').find('#lista{{$randId}}').find('input[name="_token"]').val()
			data.append('_token', token)

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','NCM-Deletar', 'sm', '700px', null, data)
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

</script>