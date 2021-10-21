
@php $randId = rand(11111, 999999); @endphp
<div class="container py-4">
	<div class="row">
		<div class="col">
			<table class="table table-sm" style="width: 100%;">
				<tbody>
					<tr>
						<td>
							<img src="#" alt="logo"><span>Orcamentista</span>
						</td>
						<td class="text-right">
							Construtora de exemplo<br/>
							Construtora de exemplo<br/>
							CNPJ: 00.00-00001-00<br/>
							Rua Exemplo: 100 A<br/>
							65061-220
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<h2 class="uppercase" style="border-bottom: 3px solid #000;">Ordem de Compra</h2>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col">
			
		</div>
		<div class="col">
			
		</div>
	</div>
	<div class="row">
		<div class="col">
			<h2 class="uppercase"  style="border-bottom: 3px solid #000;">Endereço de entrega</h2>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<table class="table table-sm">
				<tbody>
					<tr>
						<td>Endereco: Rua Exemploe</td>
						<td>Nunero: 20</td>
						<td>Complemento: proximo ao bar</td>
					</tr>
					<tr>
						<td>Bairro: Bairro exmplo</td>
						<td>Cep: 65061220</td>
						<td>Cidade: Cidade Exemplo</td>
					</tr>
					<tr>
						<td colspan="3">Estado: Ma</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col">
			<h2 class="uppercase">Itens do pedido</h2>
			<table class="table table-sm" style="width: 100%;">
				<thead>
					<tr class="uppercase">
						<th>cod</th>
						<th>descricao do produto</th>
						<th>un</th>
						<th>qtd</th>
						<th>Preço</th>
						<th>total</th>
					</tr>
				</thead>
				<tbody>
					
					<tr>
						<td>1</td>
						<td>Descricao do produto</td>
						<td>kg</td>
						<td>2</td>
						<td>750,00</td>
						<td>1.500,00</td>
					</tr>
					
					<tr>
						<td>2</td>
						<td>Descricao do produto</td>
						<td>kg</td>
						<td>1</td>
						<td>600,00</td>
						<td>600,00</td>
					</tr>
					<tr>
						<td>2</td>
						<td>Descricao do produto</td>
						<td>LT</td>
						<td>3</td>
						<td>150,00</td>
						<td>450,00</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col text-right">
			<p>
				Subtotal: R$ 9255<br/>
				Desconto: R$991,00<br/>
				Acrescimos: R$991,00<br/>
				<strong>Total: R$ 19852</strong>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<h2 class="uppercase"  style="border-bottom: 3px solid #000;">forma/condições de pagamento</h2>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<table class="table table-sm">
				<thead>
					<tr class="uppercase">
						<th>condicoes de pagamento</th>
						<th>Vencimento</th>
						<th>Pagamento</th>
						<th>Valor</th>
						<th>Obrigação</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Endereco: Rua Exemploe</td>
						<td>Nunero: 20</td>
						<td>Complemento: proximo ao bar</td>
						<td>Complemento: proximo ao bar</td>
						<td>Complemento: proximo ao bar</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col-md-12">
			<hr style="width: 50%;" class="bg-dark" />
			<p class="text-center">Assinatura do Comprador</p>
		</div>
		<div class="col-md-12">
			<hr style="width: 50%;" class="bg-dark" />
			<p class="text-center">Assinatura do Recebedor</p>
		</div>
	</div>
</div>
<!-- 

	{
    Cliente,
    Vencimento original,
    Vencimento,
    Valor,
    valorBruto,
    dsEstorno,
    Emissão,
    Nº documento,
    Competência,
    Histórico,
    Forma de pagamento, 
    Portador (Responsável),
    Categoria:{
        Acrescimos de recebidos
    },
    Vendedor,
    Ocorrência,
    status,['aberto', 'pago', 'devolvido']
}

Contas_Receber:{
    childs:{
        status:{
           'pago', 'devolvido', 'estornado'
        },
        estornado:['yes', 'no'],
        dsEstorno,
        caixa_id,
        vrDesconto,
        vrJuros,
        contas_receber_id,
        Vencimento original,
        Vencimento,
        Valor,
        valorBruto,
        Emissão,
        Nº documento,
        Competência,
        Histórico,
        Forma de pagamento:{
            dinheiro, 
            cartao debito,
            cartao credito,
            boleto,
            promissoria,

        }, 
        Portador (Responsável)
    },
    Movimentacoes:{
        'caixa_id',
        'tp_movimentacao',
        'vr_movimentacao',
        'pessoa_id',
    },
    caixa_id:{
        Caixa:{
            id,
            name,
            status_fechamento,
            vr_minimo,
            vr_max,
            pessoa_id,
            tp_caixa,
            vr_saldo,
            extrato_banco:{ //EXTRATO OFX

            }
        }

    }

}


	
-->