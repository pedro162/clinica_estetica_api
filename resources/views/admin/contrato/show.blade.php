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
									<table class="table table-sm table-responsive table-hover" id="table-pessoa{{$randId}}" style="width: 100%;">
										<tbody  style="width: 100%;">
											<tr  style="width: 100%;">
												<td>{{$registro->tipo == 'fisica' ? 'Nome' : 'Razão Social'}} :</td>
												<td>{{$registro->name}}</td>
											</tr>
											<tr  style="width: 100%;">
												<td>{{$registro->tipo == 'fisica' ? 'Sobrenome' : 'Nome Fantasia'}} :</td>
												<td>{{$registro->nome_complementar}}</td>
											</tr>
											<tr>
												<td>{{$registro->tipo == 'fisica' ? 'CPF' : 'CNPJ'}}:</td>
												<td>{{$registro->documento}}</td>
											</tr>
											<tr  style="width: 100%;">
												<td>{{$registro->tipo == 'fisica' ? 'RG' : 'IE'}} :</td>
												<td>{{$registro->documento_complementar}}</td>
											</tr>
											<tr>
												<td>E-mail :</td>
												<td>{{$registro->email}}</td>
											</tr  style="width: 100%;">
											@if($registro->sexo != null)
											<tr  style="width: 100%;">
												<td>Sexo:</td>
												<td>{{$registro->sexo}}</td>
											</tr>
											@endif
											<input type="hidden" name="pessoa" value="{{$registro->id}}">
										</tbody>
									</table>
								</div>

								<div class="col">
									@php $telefone = $registro->telefone; @endphp
									<table class="table table-sm table-responsive table-hover" style="width: 100%;">
										<thead>
											<tr>
												<td>Numero</td>
												<td>Whatsapp</td>
												<td>Tipo</td>
											</tr>
										</thead>
										<tbody  style="width: 100%;">
											@foreach($telefone as $val)
											<tr>
												<td>{{$val->numero}}</td>
												<td>{{$val->whatsapp == 'sim'? 'Sim': 'Não'}}</td>
												<td>{{$val->tipo}}</td>
												<input type="hidden" name="pessoa" value="{{$val->id}}">
											</tr>
											@endforeach
											
										</tbody>
									</table>
								</div>

								<div class="col">
									@php $logradouro = $registro->logradouro; @endphp
									<table class="table table-sm table-responsive table-hover" style="width: 100%;">
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
											<tr>
												<td>{{$val->cep}}</td>
												<td>{{$val->logradouro}}</td>
												<td>{{$val->numero}}</td>
												<td>{{$val->complemento}}</td>
												<td>{{$val->cidade}}</td>
												<td>{{$val->estado}}</td>
												<input type="hidden" name="pessoa" value="{{$val->id}}">
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
						<div class="card-body" style="display: block;">
							<table id="contas-recebeer{{$randId}}" class="table table-sm table-responsive table-hover" style="width: 100%;">
								<thead style="width: 100%;">
									<tr>
										<th>Cod</th>
										<th>Duplicata</th>
										<th>Cod Venda</th>
										<th>Cliente</th>
										<th>Valor</th>
										<th>Juros</th>
										<th>Multa</th>
										<th>Vencimento</th>
										<th>Pagamento</th>
										<th>Status</th>
										<th>Posse</th>
										<th>Desdobrado</th>
									</tr>
								</thead>
								<tbody  style="width: 100%;">
									
								</tbody>
							</table>
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
						<div class="card-body" style="display: block;text-align: center;font-size: 100px;font-weight: bolder;">
							R$ 1.200,00
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

	Utilitarios.useDataTable($('#contas-recebeer{{$randId}}'))

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


</script>
@endsection