@php 
   
   /**
    * Este Componente cria algusn botoes 
    */
   
    $type       = $getType()      ??    '';
    $onClick    = $getOnClick()   ??    '';
    $class      = $getClass()     ??    '';
    $style      = $getStyle()     ??    '';
    $id         = $getId()        ??    '';
    $icone      = $getIcone()     ??    '';
    $label      = $getLabel()     ??    '';
    

@endphp


    <button @php echo isset($onClick) && strlen(trim($onClick)) > 0 ? "onClick='".$onClick."'" : ''; @endphp class="@php echo $class ?? ''; @endphp" id="@php echo $id; @endphp" > @php echo $icone ? "<i class='".$icone."'></i>": ''; @endphp {{$label}}</button>


 