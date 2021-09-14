
@php 
   
    $label      =  $getLabel();
    $value      =  $getValue();
    $name       =  $getName();
    $class      =  $getClass();
    $onChange   =  $getOnChange();
    $onClick    =  $getOnClick();
    $type       =  $getType();
    $id         =  $getId();
    $classContainer = $getClassContainer() ?? 'col-md-4 col-sm-12';

@endphp

<div class="custom-control @php echo $classContainer;@endphp">
    <label class="label text-left" for="{{$id ?? ''}}"> @php echo $label ?? '' ;@endphp</label>
    <input {{isset($onClick) && strlen(trim($onClick)) > 0 ? 'onClick="'.$onClick.'"' : ''}} {{isset($onChange) && strlen(trim($onChange)) > 0 ? 'onChange="'.$onChange.'"' : ''}} value="{{$value ?? ''}}" type="{{$type ?? ''}}" name="{{$name ?? ''}}" class="form-control form-control-sm filtro  {{$class ?? ''}}" id="{{$id ?? ''}}">
</div>