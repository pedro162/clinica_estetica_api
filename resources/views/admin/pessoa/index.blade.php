@php $randId = rand(11111, 99999); @endphp
<div class="row">
	<!--<div class="col-md-6">
		<h4>Lista de Categorias</h4>	
	</div> -->
	<div class="col">
		<table style="width: 100%;" id="lista-pessoas{{$randId}}" class="data-table table table-sm table-responsive table-hover display">
			<thead>
				<tr>
					<th>
						Cód
					</th>
					<th>
						Nome / Razão Social
					</th>
					<th>
						Sobrenome / Nome Fantazia
					</th>
					<th>
						CP / CNPJ
					</th>
					<th>
						RG / IE
					</th>
					<th>
						Grupo
					</th>
					<th>
						Email
					</th>
					<th>
						Ativo
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($registro as $valor)
				<tr class="assistenteModalPessoa">
					<td class="text-left">{{$valor->id}}</td>
					<td class="text-left">{{$valor->name}}</td>
					<td class="text-left">{{$valor->name_opcional ?? '-'}}</td>
					<td class="text-left">{{$valor->documento}}</td>
					<td class="text-left">{{$valor->documento_complementar ?? '-'}}</td>
					<td class="text-left">{{$valor->grupo[0]->name ?? '-'}}</td>
					<td class="text-left">{{$valor->email ?? '-'}}</td>
					<td class="text-left">{{$valor->active == 'yes' ? 'Sim' : 'Não'}}</td>
					<input type="hidden" name="pessoa" value="{{$valor->id}}">
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	Utilitarios.useDataTable($('#lista-pessoas{{$randId}}'))
</script>