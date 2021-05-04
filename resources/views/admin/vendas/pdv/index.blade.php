
@extends('layouts.app')

@section('content')
@php $randId = rand(11111, 99999); @endphp
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="container-fluid my-4">
    
    <div class="row">
        <div class="col-md-5 col-sm-12">
            <div id="container-token{{$randId}}">
                @csrf
            </div>
           
            <div class="row">
                <div class="form-group col-md-12 col-sm-12">
                    <label class="label" for="nome_pesquisa{{$randId}}">Cód / Produto (Ctrl + P)</label>
                    <div class="row">
                        <div class="col-md-10 ui-widget">
                        <input type="text" id="nome_pesquisa{{$randId}}" name="nmProduto" class="form-control form-control-lg input-pdv">
                        </div>
                        <div class="col-md-2 ">                        
                            <button id="pesquisar-produto{{$randId}}" type="button" name="produto" class="form-control form-control-lg input-pdv btn-pesquisa"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="form-group col-md-2 col-sm-12">
                    <label class="label" for="cod_produto{{$randId}}">Cód</label>
                   
                    <input type="text" readonly="readonly" id="cod_produto{{$randId}}" name="nmProduto" class="form-control form-control-lg input-pdv">
                        
                </div>

                <div class="form-group col-md-8 col-sm-12">
                    <label class="label" for="nome_produto{{$randId}}">Produto</label>
                   
                    <input type="text" readonly="readonly" id="nome_produto{{$randId}}" name="nmProduto" class="form-control form-control-lg input-pdv">
                        
                </div>

                <div class="form-group col-md-2 col-sm-12">
                    <label class="label" for="estoque_produto{{$randId}}">Estoque</label>
                   
                    <input type="text" readonly="readonly" id="estoque_produto{{$randId}}" name="nmProduto" class="form-control form-control-lg input-pdv">
                        
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3 col-sm-12">
                    <label for="quantidade{{$randId}}" class="label">Quantidade</label>
                    <input id="quantidade{{$randId}}" type="text" name="qtd" class="form-control form-control-lg input-pdv">
                </div>

                <div class="form-group col-md-3 col-sm-12">
                    <label for="valor_unitario{{$randId}}" class="label">Valor unitário</label>
                    <input id="valor_unitario{{$randId}}" readonly="readonly" type="text" name="qtd" class="form-control form-control-lg input-pdv">
                </div>

                <div class="form-group col-md-3 col-sm-12">
                    <label for="valor_desconto{{$randId}}" class="label">Desconto (R$)</label>
                    <input id="valor_desconto{{$randId}}" type="text" name="qtd" class="form-control form-control-lg input-pdv">
                </div>

                <div class="form-group col-md-3 col-sm-12">
                    <label for="valor_total{{$randId}}" class="label">Valor total</label>
                    <input id="valor_total{{$randId}}" readonly="readonly" type="text" name="qtd" class="form-control form-control-lg input-pdv">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12 col-sm-12">
                    <label for="observacoes{{$randId}}" class="label">Observaçãoes</label>
                    <input id="observacoes{{$randId}}" type="text" name="qtd" class="form-control form-control-sm obs-pdv">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12 col-sm-12">
                    <button type="button" id="btn-adiciona-pedito{{$randId}}" class=" btn btn-lg btn-primary btn-concluir-pdv">ADICIONAR (ENTER)</button>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-sm-12">
            <div class="row">
                <div class="col-dm-12 col-sm-12 container-itens-pdv">
                    <p>Adicione itens!</p>
                </div>
            </div>

            
        </div>
    </div>

    <div class="row mt-3">
        <div class="form-group col-md-4 col-sm-12">
            <button type="button"  class=" btn btn-lg btn-success btn-operador-pedidos-pdv">
                
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        OPERADOR (F3)
                    </div>

                    <div class="col-md-6 col-sm-12">
                        PEDIDOS EM ABERTO (F4)
                    </div>
                </div>
            </button>
        </div>

        <div class="col-md-8 col-sm-12">
            <div class="row">
                <div class="form-group col-md-3 col-sm-12">
                    <button type="button" class=" btn btn-lg btn-dark btn-acoes-dpv">DESCONTO (F7)</button>
                </div>


                <div class="form-group col-md-3 col-sm-12">
                    <button type="button" class=" btn btn-lg btn-warning btn-acoes-dpv">AJUDA (F1)</button>
                </div>

                <div class="form-group col-md-3 col-sm-12">
                    <button type="button" class=" btn btn-lg btn-danger btn-acoes-dpv">CANCELAR (F9)</button>
                </div>

                <div class="form-group col-md-3 col-sm-12">
                    <button type="button" class=" btn btn-lg btn-success btn-acoes-dpv">PAGAMENTO (F6)</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#valor_total{{$randId}}, #valor_desconto{{$randId}}, #valor_unitario{{$randId}}').mask('#.##0,00', {reverse: true})

    const token = $('#container-token{{$randId}}').find('input:hidden').val()
    let slectorObj = '#nome_pesquisa{{$randId}}';
    
   

        const url = '/produto/index/json';

        $(slectorObj).on('keyup', function(ev){

            let formData = new FormData();
            formData.append('_token', token)

            let obj = $(this)
            let val = obj.val()
            formData.append(obj.attr('name'), val)
            console.log( val)
            

            $.ajax({
                url: url,
                dataType: "JSON",
                data:formData,
                processData:false,
                contentType:false,
                type: 'POST',
                success: function( xmlResponse ) {
                    var data = xmlResponse.data.map((item, index)=> {
                        return {
                            name: item.name,
                            value: item.name,
                            id: item.id,
                            price: item.price
                        };
                    })

                    console.log( data)

                    $(slectorObj).autocomplete({
                        source: data,
                        minLength: 0,
                        select: function( event, ui ) {
                            console.log(ui.item, ui.item.value, ui.item.id);
                            let id= ui.item.id;
                            let nmProduto= ui.item.name;
                            let estoque= 10;
                            let vrUnitario= ui.item.price;
                            let vrTotal = Number(vrUnitario) * 1;
                            vrUnitario = Utilitarios.formatMoney(vrUnitario);
                            alimentaCampos(id, nmProduto, estoque, vrUnitario, vrTotal);
                        }
                    });
                }
            });

        })

        function alimentaCampos(id, nmProduto, estoque, vrUnitario, vrTotal){
            $('#cod_produto{{$randId}}').val(id);
            $('#nome_produto{{$randId}}').val(nmProduto);
            $('#estoque_produto{{$randId}}').val(estoque);
            $('#valor_unitario{{$randId}}').val(vrUnitario);
            $('#valor_total{{$randId}}').val(vrTotal);

            $('#quantidade{{$randId}}').focus();
        }

        $('#quantidade{{$randId}}').on('keydown', function(ev){
            console.log(ev.keyCode)
            if(ev.keyCode == 13){
                ev.preventDefault()
                $('#valor_desconto{{$randId}}').focus()
            }
        })

        $('#valor_desconto{{$randId}}').on('keydown', function(ev){
            if(ev.keyCode == 13){
                ev.preventDefault()
                $('#btn-adiciona-pedito{{$randId}}').focus()
            }
        })

        
        /**
         * Abre o assistente para pesquisar produtos
         */

         $('#pesquisar-produto{{$randId}}').on('click', (ev)=>{
            
            let url = '/produto/head';
            Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produtos-Pesquisar', 'lg', '100%')
         })


        /** 
         *  Valida o item a ser adicionado ao pedido
         */
        function adicionaItemVenda(id, qtd=1, vrDesconto=0){
            try{

            
            let erros = [];

                if(id <= 0){
                    erros.push('Item a ser adicionado não identificado')
                }

                if(qtd <= 0){
                    erros.push('Quantidade inválida')
                }

                if(vrDesconto < 0){
                    erros.push('Valor do desconto não pode ser negativo')
                }

                if(erros.length > 0){

                    throw new Error(erros.join('<br/><br/>'));
                }

            }catch(ex){
                Utilitarios.assistenteMensage(ex.message, 'warning')
                
            }
        }

        async function validaDesconto(id, vrDesconto){
            let url = '';
            let method = 'POST';
            let myHeaders = new Headers();
            myHeaders.append('Content-Type', 'application/json')

            let dados = await fetch(url,{
                method:method,
                headers: myHeaders,
                mode: 'cors',
                cache: 'default'
            }).then(
                (response)=>response.json()
            ).then((response)=>{
                if(response.ok){
                    console.log('tuto ok')
                }else{
                    console.log('algo errado aconteceu')
                }
            }).catch((error)=>{
                console.log('Algo errado aconteceuno servidor.')
                console.log(error.message)
            })
        }
    
</script>

@endsection