@php $randId = rand(11111, 99999); @endphp
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-12" id="tabs{{$randId}}">
			@csrf
			<ul class="nav nav-tabs">
				<li class="nav-item"><a class="nav-link active" id="tb-1-{{$randId}}" href="#tabs-1-{{$randId}}">Item</a></li>
				<li class="nav-item"><a class="nav-link" id="tb-2-{{$randId}}" href="#tabs-2-{{$randId}}">Estoque</a></li>
				<li class="nav-item"><a class="nav-link" id="tb-3-{{$randId}}" href="#tabs-3-{{$randId}}">Tributação</a></li>
				<li class="nav-item"><a class="nav-link" id="tb-4-{{$randId}}" href="#tabs-4-{{$randId}}">Embalagem</a></li>
			</ul>
			<div id="tabs-1-{{$randId}}">
				
			</div>
			<div id="tabs-2-{{$randId}}">
				
			</div>
			<div id="tabs-3-{{$randId}}">
				
			</div>
            <div id="tabs-4-{{$randId}}">
				
			</div>
		</div>
	</div>
</div>

<script>
    const idRegistro = '{{$registro->id}}';
	const idAssistente = '{{$idAssistente}}';

	$("#tabs{{$randId}}").tabs()	
	carregarItem();

	//----------------

	//

	$('#tb-1-{{$randId}}').on('click', function(){
		carregarItem();
	})

	function carregarItem(){
		let url = '/produto/edit/'+idRegistro;
		if(idAssistente > 0){
			url += '/'+idAssistente;
		}else{
			url += '/'+0;
		}

		let objRender = $('#tabs-1-{{$randId}}');
		let idModal= $(this).attr('idModal');

		let data = new FormData();
		data.append('id', idRegistro)
		data.append('idAssistente', idAssistente)
		data.append('callBack', '{{$callBack}}')

		let token = $('html').find('#tabs{{$randId}}').find('input[name="_token"]').val()
		data.append('_token', token)

		Utilitarios.assistentAjax('POST',url, 'HTML',objRender, null, data)

	}
	//adicionarLoading
</script>