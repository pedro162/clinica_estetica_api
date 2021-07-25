@php $randId = rand(11111, 99999); @endphp

<div class="row">
	<div class="col" style="">
		<table style="width: 100%;" id="lista{{$randId}}"  class="data-table table table-lg table-responsive table-hover">
			@csrf
			<thead>
				<tr>
					<th>
						Cód
					</th>
					<th>
						Nome Marca
					</th>
					<th>
						Ativo
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($registro as $valor)
				<tr onClick="carregarOptions(this);">
					<td class="text-right">{{$valor->id}}</td>
					<td>{{$valor->name}}</td>
					<td>{{$valor->active == 'yes' ? 'Sim' : 'Não'}}</td>
					<input type="hidden" name="marca" value="{{$valor->id}}">
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<script>
	Utilitarios.useDataTable($('#lista{{$randId}}'))

	let idModalOptions{{$randId}} = null;
	let callBack{{$randId}} = '{{isset($consulta["callBack"]) ? $consulta["callBack"]: ""}}'
	
	/**
	*	CHAMA O MODAL DE OPÇÕES DE MARCAS
	*/

	function carregarOptions(element){
		try{
			let id = $(element).find('input:hidden').val();

			let arrLinks = [
				['Ediar', '/marca/edit/'+id+'', 'btn btn-lg btn-outline-primary', 'id_marca_editar{{$randId}}', id , 'editar(this);'],
				['Excluir', '/marca/info/'+id+'', 'btn btn-lg btn-outline-primary', 'id_marca_deletar{{$randId}}', id , 'deletar(this);']

			];
			
			//widthOptions='200px', widModal = 'md', height=null //, 'HTML','Marca-Editar', 'sm', '400px'
			let idModal = Utilitarios.assitentOpcoes(arrLinks, '100%', 'xs');
			idModalOptions{{$randId}} = idModal;
		}catch(ex){
				console.log('Erro: '+ex.message);
		}

	}

	function editar(element){
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

			Utilitarios.assistentAjaxModal('POST',url, 'HTML','Marca-Editar', 'xs', '300px', null, data)
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function deletar(element){
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
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','Marca-Deletar', 'sm', '700px', null, data)
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

</script>