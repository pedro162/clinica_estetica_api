
@php $randId = rand(11111, 99999); @endphp
<div class="row">
	<div class="col-md-12 col-sm-12">
		<buttom type="buttom" class="btn btn-sm btn-outline-primary mr-2 mb-sm-1" id="form_search_pessoa">Acertar / Desdobrar Selecionados</buttom>

		<table id="contas-recebeer{{$randId}}" class="table table-sm table-responsive table-hover" style="width: 100%;">
			<thead style="width: 100%;">
				<tr>
					<th><input class="custom-control" type="checkbox" name=""></th>
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
			<tbody  style="width: 100%;">
				@foreach($registro as $cobranca)
					<tr class="{{$cobranca->statusCobranca == 'baixado' ? 'text-success': ''}}">
						<td><input type="checkbox" name=""></td>
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
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<script>
	
	Utilitarios.useDataTable($('#contas-recebeer{{$randId}}'))

</script>