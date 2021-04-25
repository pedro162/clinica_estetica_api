@php $randId = rand(11111, 99999); @endphp
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-12" id="tabs{{$randId}}">
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
	$("#tabs{{$randId}}").tabs()	
    let urlItem = '/produto/edit/'+idRegistro;
	let objRender = $('#tabs-1-{{$randId}}');
	let funcao = ()=>{Utilitarios.adicionarLoading(objRender)};
    Utilitarios.assistentAjax('GET',urlItem, 'HTML', objRender, funcao)

	$('#tb-1-{{$randId}}').on('click', function(){
		Utilitarios.assistentAjax('GET',urlItem, 'HTML', objRender, funcao)
	})
	//adicionarLoading
</script>