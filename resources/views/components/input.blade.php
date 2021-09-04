
@php 
   
    $label      =  $getLabel();
    $value      =  $getValue();
    $name       =  $getName();
    $class      =  $getClass();
    $onChange   =  $getOnChange();
    $onClick    =  $getOnClick();
    $type       =  $getType();
    $id         =  $getId();

@endphp

<div class="custom-control my-1 col-md-6 col-sm-12">
    <label class="label text-left" for="{{$id ?? ''}}"> {{$label ?? ''}}</label>
    <input {{isset($onClick) && strlen(trim($onClick)) > 0 ? 'onClick="'.$onClick.'"' : ''}} {{isset($onChange) && strlen(trim($onChange)) > 0 ? 'onChange="'.$onChange.'"' : ''}} value="{{$value ?? ''}}" type="{{$type ?? ''}}" name="{{$name ?? ''}}" class="form-control form-control-sm filtro  {{$class ?? ''}}" id="{{$id ?? ''}}">
</div>