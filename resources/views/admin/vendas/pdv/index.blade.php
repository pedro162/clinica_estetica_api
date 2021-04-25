
@extends('layouts.app')

@section('content')
@php $randId = rand(11111, 99999); @endphp
<div class="container-fluid my-4">
    
    <div class="row">
        <div class="col-md-4 col-sm-12">

            <div class="row">
                <div class="form-group col-md-12 col-sm-12">
                    <label class="label">Cód / Produto (Ctrl + P)</label>
                    <input type="text" name="produto" class="form-control form-control-lg input-pdv">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4 col-sm-12">
                    <label class="label">Quantidade</label>
                    <input type="text" name="qtd" class="form-control form-control-lg input-pdv">
                </div>

                <div class="form-group col-md-4 col-sm-12">
                    <label class="label">Valor unitário</label>
                    <input type="text" name="qtd" class="form-control form-control-lg input-pdv">
                </div>

                <div class="form-group col-md-4 col-sm-12">
                    <label class="label">Valor total</label>
                    <input type="text" name="qtd" class="form-control form-control-lg input-pdv">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12 col-sm-12">
                    <label class="label">Observaçãoes</label>
                    <input type="text" name="qtd" class="form-control form-control-sm obs-pdv">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12 col-sm-12">
                    <button type="submit" class=" btn btn-lg btn-primary btn-concluir-pdv">CONCLUIR (ENTER)</button>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-sm-12">
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
@endsection