@php 
   
   /**
    * Este Componente cria algusn  links de controle
    */
   
    $type       = $getType()      ??    '';
    $onClick    = $getOnClick()   ??    '';
    $href       = $getHref()      ??    '';
    $class      = $getClass()     ??    '';
    $style      = $getStyle()     ??    '';
    $id         = $getId()        ??    '';
    $icone      = $getIcone()     ??    '';
    $label      = $getLabel()     ??    '';

@endphp

<a @php echo isset($href) && strlen(trim($href)) > 0 ? "href='".$href."'" : ''; @endphp @php echo isset($onClick) && strlen(trim($onClick)) > 0 ? "onClick='".$onClick."'" : ''; @endphp class="@php echo $class ?? ''; @endphp" id="@php echo $id; @endphp" > @php echo $icone ? "<i class='".$icone."'></i>": ''; @endphp {{$label}}</a>
    
 