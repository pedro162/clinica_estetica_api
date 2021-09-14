@php 
   
    $label      =  $getLabel();
    $value      =  $getValue();
    $name       =  $getName();
    $class      =  $getClass();
    $onChange   =  $getOnChange();
    $onClick    =  $getOnClick();
    $options    =  $getOptions();
    $id         =  $getId();
    $classContainer = $getClassContainer() ?? 'col-md-4 col-sm-12';

@endphp

<div class="custom-control @php echo $classContainer;@endphp">
    <label class="label  text-left" for="{{$id ?? ''}}">@php echo $label ?? '' ;@endphp</label>
    <select  {{isset($onClick) && strlen(trim($onClick)) > 0 ? 'onClick="'.$onClick.'"' : ''}} {{isset($onChange) && strlen(trim($onChange)) > 0 ? 'onChange="'.$onChange.'"' : ''}}  name="{{$name ?? ''}}" class="form-control form-control-sm filtro {{$class ?? ''}}"" id="{{$id ?? ''}}"">
        @php
            if(is_array($options) && count($options) > 0 ){
                foreach( $options as $key=>$val){
                    @endphp
                        <option {{isset($value) && trim($value) == trim($key) ? 'selected': ''}} value="{{$key}}">{{$val}}</option>
                    @php

                }

             }
        @endphp
        
    </select>
    
</div>