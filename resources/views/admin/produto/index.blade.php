@php $randId = rand(11111, 99999); @endphp
<div class="row">
	<!--<div class="col-md-12">
		<h4>Lista de produtos</h4>	
	</div>-->
	<div class="col">
		<table style="width: 100%;" id="lista-produtos{{$randId}}" class="data-table table table-sm table-responsive table-hover display">
			@csrf
			<thead>
				<tr>
					<th>
						Cód
					</th>
					<th>
						Nome Produto
					</th>
					<th>
						Descrição
					</th>
					<th>
						Marca
					</th>
					<th>
						Categoria
					</th>
					<th>
						Preço
					</th>
					<th>
						Destaque
					</th>
					<th>
						Imagem
					</th>
					<th>
						Estoque
					</th>
					<th>
						Qtd Vendida
					</th>
					<th>
						Produto Final
					</th>
					<th>
						Revenda
					</th>
					<th>
						Fora de Linha
					</th>
					<th>
						Importado
					</th>
					<th>
						Imune a Tributação
					</th>
					<th>
						Venda Fracionada
					</th>
					<th>
						Controle Validade
					</th>
					<th>
						Liberado Venda
					</th>
					<th>
						Venda Direta
					</th>
					<th>
						Validade
					</th>
					<th>
						Peso Bruto
					</th><!--
					<th>
						Ação
					</th>-->
				</tr>
			</thead>
			<tbody>
				@foreach($registro as $valor)
				<tr onclick="showOptions{{$randId}}(this);" >
					<td class="text-right">{{$valor->id}}</td>
					<td>{{$valor->name}}</td>
					<td>{{$valor->description}}</td>
					<td>{{$valor->marca}}</td>
					<td>{{$valor->categoria}}</td>
					<td class="text-right">{{$valor->price}}</td>
					<td>{{($valor->spotlight == 'yes') ? 'Sim' : 'Não'}}</td>
					<td><img src="{{asset($valor->image)}}" style="width: 100px; height: 50px;"></td>
					<td class="text-right">{{$valor->stock}}</td>
					<td class="text-right">{{$valor->sold_amout }}</td>
					<td class="text-left">{{$valor->produto_final == 'yes' ? 'Sim': 'Não'}}</td>
					<td class="text-left">{{$valor->revenda  == 'yes' ? 'Sim': 'Não'}}</td>
					<td class="text-left">{{$valor->fora_de_linha  == 'yes' ? 'Sim': 'Não'}}</td>
					<td class="text-left">{{$valor->importado  == 'yes' ? 'Sim': 'Não'}}</td>
					<td class="text-left">{{$valor->imune_tributacao  == 'yes' ? 'Sim': 'Não'}}</td>
					<td class="text-left">{{$valor->venda_fracionada  == 'yes' ? 'Sim': 'Não'}}</td>
					<td class="text-left">{{$valor->controle_validade  == 'yes' ? 'Sim': 'Não'}}</td>
					<td class="text-left">{{$valor->has_venda == 'yes' ? 'Sim': 'Não'}}</td>
					<td class="text-left">{{$valor->has_venda_direta == 'yes' ? 'Sim': 'Não'}}</td>
					<td class="text-center">{{$valor->dt_validade ? $valor->dt_validade : '-'}}</td>
					<td class="text-center">{{$valor->peso_bruto}} Kg</td>
					<!--<td>
						<a href="#" class="btn btn-sm btn-dark mb-sm-1">Visualizar</a>
						<a href="#" class="btn btn-sm btn-primary mb-sm-1">Editar</a>
						<a href="#" class="btn btn-sm btn-danger mb-sm-1">Deletar</a>
					</td>-->
					<input type="hidden" name="produto" value="{{$valor->id}}">
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	Utilitarios.useDataTable($('#lista-produtos{{$randId}}'))

	var idModalOptions{{$randId}} = null;
	var callBack{{$randId}} = '{{$consulta["callBack"]}}'
	//alert(callBack{{$randId}})


	function showOptions{{$randId}}(element)
	{
		try{
			let id = $(element).find('input:hidden').val();

			let arrLinks = [
				//['Ediar', '/produto/edit/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_editar'],
				['Ediar', '/produto/show/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_editar{{$randId}}', id , 'editar(this);'],
				['Tributar', '/ncm/tributacao/tributar/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_deletar{{$randId}}', id, 'tributar{{$randId}}(this);'],
				['Excluir', '/produto/info/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_deletar{{$randId}}', id, 'deletar(this);'],
				

			];
			

			//widthOptions='200px', widModal = 'md', height=null //, 'HTML','Marca-Editar', 'sm', '400px'
			idModal = Utilitarios.assitentOpcoes(arrLinks, '100%', 'xs');
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

			let token = $('html').find('#lista-produtos{{$randId}}').find('input[name="_token"]').val()
			data.append('_token', token)

			Utilitarios.assistentAjaxModal('POST',url, 'HTML','Produto-Editar', 'sm', '700px', null, data)
			
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

			let token = $('html').find('#lista-produtos{{$randId}}').find('input[name="_token"]').val()
			data.append('_token', token)

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','Produto-Deletar', 'sm', '400px', null, data)
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function tributar{{$randId}}(element){
			
		try{
			let url = $(element).attr('href');
			let id = $(element).attr('idItem');
			let idModal= $(element).attr('idModal');

			Utilitarios.fecharAssistente(idModalOptions{{$randId}});
			
			let data = new FormData();
			data.append('id', id)
			data.append('idAssistente', idModal)
			data.append('callBack', ''+callBack{{$randId}}+'')

			let token = $('html').find('#lista-produtos{{$randId}}').find('input[name="_token"]').val()
			data.append('_token', token)

			Utilitarios.assistentAjaxModal('POST',url, 'HTML','PRODUTO-Tributar', 'sm', '300px', null, data)
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

</script>