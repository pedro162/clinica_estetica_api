<div class="row">
<div class="col-md-12 col-sm-12">
        <h4>Dados do Desdobramento</h4>
        <table class="table table-sm table-responsive">
           
            <tbody>
                <tr>
                    <td><b>Juros</b></td>
                    <td>120,00</td>
                    <td><b>Data</b></td>
                    <td>20-12-2020</td>
                </tr>

                <tr>
                    <td><b>Juros Dispensados</b></td>
                    <td>0,00</td>
                    <td><b>Usuario</b></td>
                    <td>José Pedro Aguiar Ferreira</td>
                </tr>

                <tr>
                    <td><b>Multa</b></td>
                    <td>120,00</td>
                    <td><b>Crédito Gerado</b></td>
                    <td>0</td>
                </tr>

                <tr>
                    <td><b>Multa Dispensada</b></td>
                    <td>0,00</td>
                    <td><b>Valor Duplicatas</b></td>
                    <td>200,00</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-md-12 col-sm-12">
        <h4>Origem</h4>
        <table class="table table-sm table-responsive">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cobranca</th>
                    <th>Pessoa</th>
                    <th>Descrição</th>
                    <th>Vencimento</th>
                    <th>Baixa</th>
                    <th>Situação</th>
                    <th>Dias</th>
                    <th>Valor Bruto</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($origem as $or)
                <tr>
                
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-md-12 col-sm-12">
        <h4>Destino</h4>
        <table class="table table-sm table-responsive">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cobranca</th>
                    <th>Pessoa</th>
                    <th>Descrição</th>
                    <th>Vencimento</th>
                    <th>Baixa</th>
                    <th>Situação</th>
                    <th>Dias</th>
                    <th>Valor Bruto</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($destino as $or)
                <tr>
                
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>