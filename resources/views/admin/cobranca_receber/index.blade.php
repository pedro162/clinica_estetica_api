
@php $randId = rand(11111, 99999); @endphp
<div class="row">
	<div class="col-md-12 col-sm-12" style="">
		<buttom type="buttom" class="btn btn-sm btn-outline-primary mr-2 mb-sm-1" id="acertar-receber{{$randId}}">Acertar / Desdobrar Selecionados</buttom>

		<table id="contas-recebeer{{$randId}}" class="table table-sm table-responsive table-hover" style="width: 100%; height: 300px; overflow: scroll;">
			<thead style="width: 100%;">
				<tr>
					<th><input class="custom-control" type="checkbox" name="" onchange="+Utilitarios.selecionarMultiplosTable('contas-recebeer{{$randId}}')"></th>
					<th>Cod</th>
					<th>Duplicata</th>
					<th>Parcela</th>
					<th>Cliente</th>
					<th>Histórico</th>
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
			<tbody  style="width: 100%;" id="tbody-cob-receber{{$randId}}">
				@foreach($registro as $cobranca)
					<tr class="{{$cobranca->statusCobranca == 'baixado' ? 'text-success': ''}}">
						<td index="0"><input type="checkbox" name="" ></td>
						<td>{{ $cobranca->id ?? '0' }}</td>
						<td>{{ $cobranca->nrDuplicata ?? '0' }}</td>
						<td>{{ $cobranca->nrParcela ?? '0'}}</td>
						<td>{{ $cobranca->pessoa->name ?? '0' }}</td>
						<td>{{ $cobranca->dsHistorico ?? '-' }}</td>
						<td>{{ number_format($cobranca->vrCobrancaReceber, 2, ',', '.') ?? '0' }}</td>
						<td>{{ number_format($cobranca->vrJuros, 2, ',', '.') ?? '0' }}</td>
						<td>{{ number_format($cobranca->vrMulta, 2, ',', '.') ?? '0' }}</td>
						<td>{{ $cobranca->dtVencimentoCobrancaReceber ?? '-' }}</td>
						<td>{{ $cobranca->dtCobrancaReceberRecebimento ?? '-' }}</td>
						<td>{{ $cobranca->statusCobranca ?? '-'}}</td>
						<td>{{'-'}}</td>
						<td>{{ $cobranca->isDuplicataOriginal == 'yes' ? 'Não' : 'Sim' }}</td>
						<input type="hidden" class="id-referencia" value="{{$cobranca->idReferencia}}">
						<input type="hidden" class="tp-referencia" value="{{$cobranca->tpReferencia}}">
						<input type="hidden" class="id" value="{{$cobranca->id}}">
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<script>
	
	Utilitarios.useDataTable($('#contas-recebeer{{$randId}}'))
	$('html body').find('table tbody#tbody-cob-receber{{$randId}}').delegate('tr td', 'click', function(){

		if($(this).attr('index')){
			
		}else{
			let idReferencia = $(this).parent().find('input:hidden.id-referencia').val();
			let tpReferencia = $(this).parent().find('input:hidden.tp-referencia').val();
			let arrLinks = [
				['Baixar', '/cobranca/receber/baixar/'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Baixar com Credito de Cliente', '/cobranca/receber/baixar/credito/cliente/'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Extornar', '/cobranca/receber/extornar/'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Editar', '/cobranca/receber/edit//'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Acertar', '/cobranca/receber/acertar/'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Desdobrar', '/cobranca/receber/desdobrar/'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Negativar', '/cobranca/receber/negativar/'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Conciliar CNI', '/cobranca/receber/conciliar/cni/'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Recibo', '/cobranca/receber/recibo/'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Anexar Documento', '/cobranca/receber/anexar/documento/'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Visualizar Documento', '/cobranca/receber/show//'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Ver Desdobramento', '/cobranca/receber/ver/desdobramento/'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
				['Ficha de Débitos', '/cobranca/receber/ficha/debitos/'+idReferencia+'/'+tpReferencia,'btn btn-lg btn-outline-primary', 'id_baixar_cobranca_receber{{$randId}}'],
			];

			Utilitarios.assitentOpcoes(arrLinks, '100%');
		}

	})

	
	$('html body').delegate('#acertar-receber{{$randId}}', 'click', function(ev){
		ev.preventDefault();

		let ids = Utilitarios.selecionadosTable('contas-recebeer{{$randId}}');
		console.log(ids);

		let url = '/cobranca/receber/acertar/'+ids
		let typeResponse = 'HTML';
		let title = 'Desdobramento - Cobrança Receber';
		let width = 'lg';
		let heigh = '900px';
		Utilitarios.assistentAjaxModal('GET',url, typeResponse, title, width, heigh)

	})

	
	
</script>