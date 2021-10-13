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

