@extends('layouts.app')
@section('content')
@php $randId = rand(11111, 99999); @endphp
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">	
			<nav aria-label="breadcrumb" class="my-2">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active"><a href="{{route('produto.index')}}">Inicio</a></li>
					<li class="breadcrumb-item desable" aria-current="page"><a >{{$registro->name}}</a></li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-md-12">
			<a  href="{{route('pessoa.show', $registro->id)}}" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="show_painel_pessoa"><i class="fas fa-star"></i> Painel</a>

			<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="exportar_relatorio">Duplicatas</buttom>

			<a href="{{route('pessoa.create')}}" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="cadastrar_pessoa"><i class="fas fa-plus"></i> Gerar Mensalidade</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-sm-12">
			<div class="row">
				<div class="col-md-12 col-sm-12 mb-2">
					<div class="card card-togle">
						<div class="card-header bg-white h4">
							Dados pessoais -> Contato -> Endereço
						</div>
						<div class="card-body" style="display: block;">
							<div class="row">
								<div class="col">
									<a id="btn-edita-pessoa{{$randId}}" href="{{route('pessoa.edit', $registro->id)}}" class="btn btn-sm btn-outline-primary" style="float: right;"><i class="fa fa-plus"></i></a>
									<table class="table table-sm table-responsive table-hover" id="table-pessoa{{$randId}}" style="width: 100%;">
										<tbody  style="width: 100%;">
											<tr  style="width: 100%;">
												<td >{{$registro->tipo == 'fisica' ? 'Nome' : 'Razão Social'}} :</td>
												<td style="width: 100%;">{{$registro->name}}</td>
											</tr>
											<tr  style="width: 100%;">
												<td>{{$registro->tipo == 'fisica' ? 'Sobrenome' : 'Nome Fantasia'}} :</td>
												<td style="width: 100%;">{{$registro->nome_complementar}}</td>
											</tr>
											<tr>
												<td>{{$registro->tipo == 'fisica' ? 'CPF' : 'CNPJ'}}:</td>
												<td style="width: 100%;">{{$registro->documento}}</td>
											</tr>
											<tr  style="width: 100%;">
												<td>{{$registro->tipo == 'fisica' ? 'RG' : 'IE'}} :</td>
												<td style="width: 100%;">{{$registro->documento_complementar}}</td>
											</tr>
											<tr>
												<td>E-mail :</td>
												<td style="width: 100%;">{{$registro->email}}</td>
											</tr  style="width: 100%;">
											@if($registro->sexo != null)
											<tr  style="width: 100%;">
												<td>Sexo:</td>
												<td style="width: 100%;">{{$registro->sexo}}</td>
											</tr>
											@endif
											<input type="hidden" name="pessoa" value="{{$registro->id}}">
										</tbody>
									</table>
								</div>

								<div class="col">
									@php $telefone = $registro->telefone; @endphp
									<a id="btn-adiciona-telefone{{$randId}}" href="{{route('pessoa.edit', $registro->id)}}" class="btn btn-sm btn-outline-primary" style="float: right;"><i class="fa fa-plus"></i></a>
									<table class="table table-sm table-responsive table-hover" style="width: 100%;">
										<thead>
											<tr>
												<td style="width: 100%;">Numero</td>
												<td style="width: 100%;">Whatsapp</td>
												<td style="width: 100%;">Tipo</td>
											</tr>
										</thead>
										<tbody  style="width: 100%;">
											@foreach($telefone as $val)
											<tr>
												<td>{{$val->numero}}</td>
												<td>{{$val->whatsapp == 'sim'? 'Sim': 'Não'}}</td>
												<td>{{$val->tipo}}</td>
												<input type="hidden"  value="{{$val->id}}">
											</tr>
											@endforeach
											
										</tbody>
									</table>
								</div>

								<div class="col">
									@php $logradouro = $registro->logradouro->where('active', '=', 'yes'); @endphp

									<a href="{{route('logradouro.create', $registro->id)}}" class="btn btn-sm btn-outline-primary" id="id_logradouro_create{{$randId}}" style="float: right;"><i class="fa fa-plus"></i></a>
									<table style="clear: both;" class="table table-sm table-responsive table-hover" id="table-lograouro{{$randId}}" style="width: 100%;">
										<thead>
											<tr>
												<td>Cep</td>
												<td>Logradouro</td>
												<td>Número</td>
												<td>Complemento:</td>
												<td>Cidade</td>
												<td>Estado</td>
											</tr>
										</thead>
										<tbody  style="width: 100%;">
											@foreach($logradouro as $val)
											<tr class="assistenteModalLogradouro">
												<td>{{$val->cep}}</td>
												<td>{{$val->logradouro}}</td>
												<td>{{$val->numero}}</td>
												<td>{{$val->complemento}}</td>
												<td>{{$val->cidade}}</td>
												<td>{{$val->estado}}</td>
												<input type="hidden" value="{{$val->id}}">
											</tr>
											@endforeach
											
										</tbody>
									</table>
								</div>
							</div>
							
						</div>
						<div class="card-footer bg-white form-inline">
							
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="card card-togle">
						<div class="card-header bg-white form-inline h4">
							Contas a Receber
						</div>
						<div class="card-body" style="display: block;" id="containerContReceber{{$randId}}">
							
						</div>
						<div class="card-footer bg-white form-inline">
						</div>
					</div>
				</div>
			</div>			
		</div>
		
		<div class="col-md-4 col-sm-12">
			<div class="row">
				<div class="col-sm-12 col-md-12 mb-2">
					<div class="card card-togle">
						<div class="card-header bg-white form-inline h4">
							Frequência
						</div>
						<div class="card-body" style="display: block;">
							 <canvas id="frequencia{{$randId}}"></canvas>
						</div>
						<div class="card-footer bg-white form-inline">
							
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-md-12">
					<div class="card card-togle">
						<div class="card-header bg-white form-inline h4">
							Saldo Pendente
						</div>
						<div class="card-body" style="display: block;text-align: center;font-size: 100px;font-weight: bolder;" id="aberto{{$randId}}">
							0,00
						</div>
						<div class="card-footer bg-white form-inline">
							
						</div>
					</div>
				</div>
			</div>
			
		</div>

	</div>
</div>
<script type="text/javascript">

	/*-------------- Exercicio anual ---------*/
    let excAnual = $('#frequencia{{$randId}}');
    let cahrExAnual = new Chart(excAnual, {
    type: 'line',//pie
    data: {
	      labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'],
	      datasets: [{
	          label: '2020',
	          data: [12, 19, 3, 5, 2, 3],
	          backgroundColor: 'rgba(255, 255, 255, 0.001)',
	          borderColor:'rgba(0,255,0)',
	          borderWidth: 3
	      },
	      {
	          label: '2019',
	          data: [10, 5, 8, 7, 10, 15],
	          backgroundColor: 'rgba(255, 255, 255, 0.001)',
	          borderColor:'rgba(0,255,255)',
	          borderWidth: 3
	      }]
	     },
		options: {
	    layout:{
	       padding: {
	            left: 0,
	            right: 0,
	            top: 0,
	            bottom: 0
	        },
	        width:'10px'
	    }
        ,scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    fontColor: '#000'
                }
            }],
            xAxes:[{
              ticks: {
                    barPercentage: 0.2,
                    fontColor: '#000'
                }
            }]
        }
      }
  });

    //----- chama a view de atualizar pessoa
    $('html body').delegate('table#table-pessoa{{$randId}}', 'click', function(ev){
    	let idPessoa = $(this).find('input:hidden[name=pessoa]').val();
    	let url = '/pessoa/edit/'+idPessoa+'';
    	Utilitarios.assistentAjaxModal('GET',url, 'HTML', 'Pessoa - Editar','lg');

    })

    $('html body').delegate('#btn-edita-pessoa{{$randId}}', 'click', function(ev){
    	ev.preventDefault();

    	let url = $(this).attr('href');
    	Utilitarios.assistentAjaxModal('GET',url, 'HTML', 'Pessoa - Editar','lg');
    })

    
    /**
	*	CHAMA O MODAL DE LOGRADOURO
	*/
	$('body').delegate('.assistenteModalLogradouro', 'click', function(ev){

		let id = $(this).find('input:hidden').val();
		let idPessoa = $('html body').find('table#table-pessoa{{$randId}} input:hidden[name=pessoa]').val();
 
		
		let arrLinks = [
			['Ediar', '/logradouro/edit/'+id+'/'+idPessoa, 'btn btn-lg btn-outline-primary', 'id_logradouro_editar{{$randId}}'],
			['Excluir', '/logradouro/info/'+id+'/'+idPessoa, 'btn btn-lg btn-outline-primary', 'id_logradouro_deletar{{$randId}}']
		];

		Utilitarios.assitentOpcoes(arrLinks);
	})

	//----- chama a view de atualizar pessoa
   $('html body').delegate('a#id_logradouro_editar{{$randId}}', 'click', function(ev){
    	
		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','logradouro - Editar');

    })

   //----- chama a view de deletar logradouro
   $('html body').delegate('a#id_logradouro_deletar{{$randId}}', 'click', function(ev){
    	
		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','logradouro - Deletar', 'md');

    })

   //----- chama a view de cadastrar logradouro
   $('html body').delegate('a#id_logradouro_create{{$randId}}', 'click', function(ev){
    	
		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Logradouro - Cadastrar');

    })

   //----- chama a view de cadastrar telefone
   $('html body').delegate('a#btn-adiciona-telefone{{$randId}}', 'click', function(ev){
    	
		ev.preventDefault();return false;
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Contato - Cadastrar');

    })

   
   Utilitarios.assistentAjax('GET','/cobranca/receber/index?id={{$registro->id}}', 'HTML', $('html body').find('#containerContReceber{{$randId}}'));

   $.ajax({
   		url: '/cobranca/receber/index/json?id={{$registro->id}}&statusCobranca=aberto',
   		dataType: 'json',
   		type: 'GET',
   		success: function(response){
   			console.log(response);
   			let data = response.data;
   			let totAberto = 0;
   			if(Array.isArray(data) && (data.length > 0)){
   				for(let i=0; !(i == data.length); i++){
   					totAberto += data[i].vrCobrancaReceber ? Number(data[i].vrCobrancaReceber) : 0;
   				}

   			}

   			totAberto = Utilitarios.formatMoney(totAberto);   				
   			$('#aberto{{$randId}}').html('R$ '+totAberto);
   			console.log(totAberto);
   		},
   		error:function(response, status, error){
			//console.log(response, status, error)
			console.log(response.responseJSON);
			let objErros = response.responseJSON.errors
			let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';
			for (let prop in objErros){
				msg+='<strong>'+prop+': </strong>'+objErros[prop]+'<br/>';
			}

		}

   })

</script>
@endsection