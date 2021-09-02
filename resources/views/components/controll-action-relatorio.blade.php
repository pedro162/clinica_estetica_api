
@php 

/**
 * Este componente monta as ações do filtro do relatório
 */

$acoes = $getAcoes() ?? [
    [
        'type'      =>'',
        'onClick'   =>'',
        'herf'      =>'',
        'class'     =>'',
        'style'     =>'',
        'id'        =>'',
        'icone'     =>'',
        'label'     =>'',
    ]
];
@endphp



<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="form-inline">
            @if(is_array($acoes) && count($acoes) > 0)
                @for($i = 0; !($i == count($acoes)); $i++)
                    @php
                        $atual = $acoes[$i];

                        $type           = $atual['type']           ??  '';
                        $onClick        = $atual['onClick']        ??  '';
                        $href           = $atual['href']           ??  '';
                        $class          = $atual['class']          ??  '';
                        $style          = $atual['style']          ??  '';
                        $id             = $atual['id']             ??  '';
                        $icone          = $atual['icone']          ??  '';
                        $label          = $atual['label']          ??  '';

                        
                    @endphp

                    @if($type == 'link')
                        
                        <x-link

                            :type="$type"
                            :onClick="$onClick"
                            :href="$href"
                            :class="$class"
                            :style="$style"
                            :id="$id"
                            :icone="$icone"
                            :label="$label"
                        />

                    @elseif($type == 'buttom')
                        
                        <x-buttom
                            :type="$type"
                            :onClick="$onClick"
                            :class="$class"
                            :style="$style"
                            :id="$id"
                            :icone="$icone"
                            :label="$label"
                        />

                    @endif

                @endfor

            @endif
        </div>
    </div>
</div>
