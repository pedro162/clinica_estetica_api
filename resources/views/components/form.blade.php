
@php 

$csosn = false;
$randId = rand(11111, 99999);

$dataFieldsForm = [

];

@endphp
<div class="row p-3">
    <div class="col-md-12 col-sm-12">
        <form action="{{route('produto.store')}}" method="post" class="form " id="form_{{$randId}}" enctype="multipart/form-data">
            @csrf

            @php 
                $label                  = '';
                $value                  = '';
                $name                   = '';
                $class                  = '';
                $onChange               = '';
                $onClick                = '';
                $type                   = '';
                $options                = '';
                $id                     = '';
                $classContainer         = '';
                
            @endphp 
            @switch($typeFiled)
                @case('select')
                    <x-select
                        :label="$label"
                        :value="$value"
                        :name="$name"
                        :class="$class"
                        :onChange="$onChange"
                        :onClick="$onClick"
                        :type="$type"
                        :options="$options"
                        :id="$id"
                        :classContainer="$classContainer"
                    
                    />
                @break

                @case('textarea')

                @break
                @case('radio')

                @break
                @case('checkbox')

                @break
                @default
                    <x-input
                        :label="$label"
                        :value="$value"
                        :name="$name"
                        :class="$class"
                        :onChange="$onChange"
                        :onClick="$onClick"
                        :type="$type"
                        :id="$id"
                        :classContainer="$classContainer"
                    
                    />
                                            

            @endswitch
            <h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
            <hr/>

            <div class="  mt-5">
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label class="label">Estado</label>
                        <select type="text" name="uf" id="uf{{$randId}}" class="form-control form-control-sm">
                            <option value=""></option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-6 col-sm-12">
                        <label class="label">GTIN TRIBUTÁVEL</label>
                        <input alt="Código de barras de uma caixa, por exemploe." type="text" name="ncm" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12 col-sm-12">
                        @php
                            
                            $idCodAnp = '01';
                            $typeCodAnp = 'number';
                            $nameCodAnp = 'anp';
                            $labelCodAnp = 'ANP';
                            $idDescriptionAnp = '02';
                            $typeDescrptionAnp = 'text';
                            $nameDescriptionAnp = 'dsNcm';
                            $labelDescriptionAnp = 'Descrição';
                            $valueDescriptionAnp = "01";
                            $valueCodAnp = "Teste 01";
                            $colCodAnp = "2";
                            $colDescriptionAnp = "9";
                            $searshAnp = "searshNcm".$randId."();";
                        
                        @endphp
                        <x-controll-filter
                            :idCod="$idCodAnp"
                            :typeCod="$typeCodAnp"
                            :nameCod="$nameCodAnp"
                            :labelCod="$labelCodAnp"
                            :idDescription="$idDescriptionAnp"
                            :typeDescrption="$typeDescrptionAnp"
                            :nameDescription="$nameDescriptionAnp"
                            :labelDescription="$labelDescriptionAnp"
                            :valueDescription="$valueDescriptionAnp"
                            :valueCod="$valueCodAnp"
                            :colCod="$colCodAnp"
                            :colDescription="$colDescriptionAnp"
                            :searsh="$searshAnp"

                        />
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-8 col-sm-12">
                </div>
                <div class="col-md-4 col-sm-12" style="text-align: right;">
                    <button type="submit" class=" btn btn-md btn-primary"><b>Salvar</b></button>
                </div>
            </div>
        </form>
    </div>
</div>	

<script>

let callBack{{$randId}} = '{{$callBack}}'


$('html').find('#tpCalculoIpi{{$randId}}').on('change', function(ev){
    let val = $(this).val();
    let objAliqIpi = $('html').find('#aliqIpi{{$randId}}');
    let objVrIpi = $('html').find('#vrIpi{{$randId}}');

    if(val && String(val).trim() == 'pc'){
        objVrIpi.attr('readonly', 'readonly')
        objAliqIpi.removeAttr('readonly')

    }else{
        objAliqIpi.attr('readonly', 'readonly')
        objVrIpi.removeAttr('readonly')

    }
})
//edita ou salva um produto
$('html body').delegate('form#form_{{$randId}}','submit', function(ev){

    try{

        let url = $(this).attr('action');
        let id = $(this).attr('id');

        let form = new FormData($(this)[0]);
        $.ajax({
            url:url,
            type:'POST',
            dataType:'json',
            data:form,
            processData:false,
            contentType:false,
            success:function(response){
                console.log(response);
                console.log(response.mensagem.id);

                if(response.mensagem.hasOwnProperty('id') || response.mensagem == true){

                    Utilitarios.assistenteMensageAlert('Registrado com sucesso');

                }else{

                    Utilitarios.assistenteMensageAlert('Erro ao atuaolizar registro', 'warning');

                    
                }
            },
            error:function(response, status, error){
                //console.log(response, status, error)
                console.log(response.responseJSON);
                let objErros = response.responseJSON.errors
                let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';
                for (let prop in objErros){
                    msg+='<strong>'+prop+': </strong>'+objErros[prop]+'<br/>';
                }

                Utilitarios.assistenteMensageAlert(msg, 'warning');
            }


        })

    }catch(ex){

        console.log(ex.message);
    }

    ev.preventDefault();
});



function preparaBasicRequestPost{{$randId}}(){
    let token = $('html').find('#form_{{$randId}}').find('input[name="_token"]').val()

    let data = new FormData();
    data.append('idAssistente', '')
    data.append('callBack', ''+callBack{{$randId}}+'')
    data.append('_token', token)

    return data;

}

</script>