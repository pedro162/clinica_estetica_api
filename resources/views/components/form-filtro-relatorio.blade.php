@php 

	/**
	*	Este componente é o filtro dos relatorios
	 */

    $randId = rand(11111, 99999);

    $fieldsForm = $getFieldsForm() ?? [
        [
            'label'     =>'',
            'value'     =>'',
            'name'      =>'',
            'class'     =>'',
            'onChange'  =>'',
            'onClick'   =>'',
            'type'      =>'',
            'options'   =>[],

        ]
    ];   

    $acoes = $getAcoes() ?? [
    
    ]; 

    $callback = $getCallback() ?? '';

	$idContainer = $getIdContainer() ?? 'container_filtros'.$randId;
	$idAreaFiltrados = $getIdAreaFiltrados() ?? 'container_filtred'.$randId;

@endphp


<div class="row">
    <div class="col-md-12" id="{{$idContainer}}">
        <div class="card card-togle card-sistem" >

            <div class="card-header form-inline"  style="background-color: #E9ECEF; height: 60px !important" >
                <div class="row" style="width: 100%;text-align: left;">
                    <div class="col-md-1 col-sm-3" id="container_icon_filter{{$randId}}">
                        <button type="button" class="btn btn-sm btn-outline-primary mb-sm-1" id="form_filtro{{$randId}}"><i class="fas fa-filter"></i></button>
                    </div>
                    <div class="col-md-11 col-sm-9">
                        <div  id="{{$idAreaFiltrados}}" style="overflow: auto;max-height: 40px !important;flex-wrap: wrap;display: flex;">
						</div>
                    </div>
                </div>
                
            </div>

            <div class="card-body" style="display: block !important;">
                <form class="" id="filtros{{$randId}}">
                        @csrf
                        <div class="row" >
                            @if(is_array($fieldsForm) && count($fieldsForm) > 0)
                                @for($i=0; !($i == count($fieldsForm)); $i++)

                                    @php 
                                    $label      =   $fieldsForm[$i]['label']            ?? ''; 
                                    $value      =   $fieldsForm[$i]['value']            ?? ''; 
                                    $name       =   $fieldsForm[$i]['name']             ?? ''; 
                                    $class      =   $fieldsForm[$i]['class']            ?? ''; 
                                    $onChange   =   $fieldsForm[$i]['onChange']         ?? ''; 
                                    $onClick    =   $fieldsForm[$i]['onClick']          ?? ''; 
                                    $type       =   $fieldsForm[$i]['type']             ?? ''; 
                                    $options    =   $fieldsForm[$i]['options']          ?? []; 
                                    $id         =   $fieldsForm[$i]['name'].$randId     ?? ''; 
									$classContainer = $fieldsForm[$i]['classContainer'] ?? '';

                                    @endphp

                                    @switch($type)
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

                                        @case('radio')

                                        @break

                                        @case('textarea')

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
                                    
                                @endfor

                            @endif
                            
                        </div>
                    
                </form>
            </div>

            <div class="card-footer bg-white form-inline" style="display: block !important;" >

				<x-controll-action-relatorio
					:acoes="$acoes"
				/>

            </div>

        </div>
    </div>
</div>
<!--
<script>
    let idModalOptions = null;
		
		$('html body').delegate('#form_filtro{{$randId}}', 'click', function(ev){
			ev.preventDefault();
			//Utilitarios.toggleFiltro();
			togleFiltros();
		});	

		function pesquisar{{$randId}}(){
			let url = '/estado/index';

			let objResponse = '#response-request{{$randId}}';
			//Utilitarios.assistentAjax('GET',url, 'HTML', objResponse)
			//togleFiltros();
			carregarItens{{$randId}}('POST', url, 'HTML', objResponse)

		}

		function togleFiltros(){
			$('html').find('#container_filtros{{$randId}}').find('.card').find('.card-body').toggle('fast');
			$('html').find('#container_filtros{{$randId}}').find('.card').find('.card-footer').toggle('fast');
			//filtros{{$randId}}

		}

		function carregarItens{{$randId}}(type, url, dataType, objResponse){

			let filtro = montarFiltro{{$randId}}();
			let formData = new FormData();

			let token = $('html').find('#filtros{{$randId}}').find('input[name="_token"]').val()
			formData.append('_token', token)
			formData.append('callBack', btoa('carregarItens{{$randId}}("'+type+'", "'+url+'", "'+dataType+'", "'+objResponse+'");'))

			if(Array.isArray(filtro) && filtro.length > 0){
				let escuta = false;
				
				for(let i=0; !(i == filtro.length); i++){
					let condition = filtro[i].hasOwnProperty('name') && filtro[i].hasOwnProperty('value')
					if(condition == true){
						escuta = true;
					
						formData.append(filtro[i].name, filtro[i].value)
					}
				}

				if(escuta){
					
					exibeFiltroHead{{$randId}}();
					
				}
			}
			objResponse = $('html body').find('' +objResponse+ '');
			Utilitarios.assistentAjax(type, url, dataType, objResponse, null, formData)
		}

		function montarFiltro{{$randId}}(){
			
			let dados = [];
			$('html').find('#filtros{{$randId}}').find('.filtro').each(function(){
				let atual 	= $(this);
				let name 	= String(atual.attr('name')).trim();
				let valor 	= String(atual.val()).trim()
				let id 		= String(atual.attr('id').trim())
				let label 	= String($('html').find('#filtros{{$randId}}').find('label[for="'+id+'"]').text()).trim();

				if(valor.length > 0 && valor != 'null' && valor != 'undefined'){
					let obj ={
						'label': label,
						'name': name,
						'id': id,
						'value': valor
					}
					dados.push(obj)
				}
			})
			
			return dados;
		}


		function exibeFiltroHead{{$randId}}(containerSlector = '#container_filtred{{$randId}}'){
			let filtro = montarFiltro{{$randId}}();
		
			if(Array.isArray(filtro) && filtro.length > 0){
				let filtros_head = '';

				for(let i=0; !(i == filtro.length); i++){
					let condition = filtro[i].hasOwnProperty('name') && filtro[i].hasOwnProperty('value')
					if(condition == true){
						
						let param = filtro[i].id;
						filtros_head += `<span onClick="try{removerFiltro{{$randId}}('${'#'+param}');}catch(e){console.log(e)}" class="filtred">${filtro[i].label}: ${filtro[i].value}</span>`;
						console.log('aqui 03')
					}
				}
				$('html').find(containerSlector).html(filtros_head)
				return true;

			}
			$('html').find(containerSlector).html('')
			return false;
		}


		function removerFiltro{{$randId}}(selectorImput){
			
			$('html').find(selectorImput).val('');
			montarFiltro{{$randId}}()
			exibeFiltroHead{{$randId}}(containerSlector = '#container_filtred{{$randId}}')
			
		}
		
		function cadastrar{{$randId}}(element){
			try{
				let url = $(element).attr('href');
				let id = $(element).attr('idItem');
				let idModal= $(element).attr('idModal');
				
				//Utilitarios.fecharAssistente(idModalOptions{{$randId}});
				let data = new FormData();
				data.append('id', id)
				data.append('idAssistente', '')
				data.append('callBack', ''+btoa('pesquisar{{$randId}}();')+'')

				let token = $('html').find('#filtros{{$randId}}').find('input[name="_token"]').val()
				data.append('_token', token)

				Utilitarios.assistentAjaxModal('POST',url, 'HTML','NCM-Cadastrar', 'sm', '300px', null, data)
				Utilitarios.toggleFiltro();
			}catch(ex){
					console.log('Erro: '+ex.message);
			}
		}


		function tributar{{$randId}}(element){
			
			try{
				let url = $(element).attr('href');
				let id = $(element).attr('idItem');
				let idModal= $(element).attr('idModal');
				// //
				//Utilitarios.fecharAssistente(idModalOptions{{$randId}});
				let data = new FormData();
				data.append('id', id)
				data.append('idAssistente', '')
				data.append('callBack', ''+btoa('pesquisar{{$randId}}();')+'')

				let token = $('html').find('#filtros{{$randId}}').find('input[name="_token"]').val()
				data.append('_token', token)

				Utilitarios.assistentAjaxModal('POST',url, 'HTML','NCM-Editar', 'sm', '300px', null, data)
				

			}catch(ex){
					console.log('Erro: '+ex.message);
			}
		}

		togleFiltros();
		pesquisar{{$randId}}()
</script> -->