<!--<div class="row">
    <div class="form-group col-md-12 col-sm-12">
        <div class="row">
            <div class="col-md-{{$getColCod() ?? '2'}} col-sm-12 ">
                <label for="{{$getIddCod()}}" class="label">{{$getLabelCod()}}</label>
                <input value="{{$getValueDescription()}}" type="{{$getTypeCod() ?? 'text'}}" name="{{$getNameCod()}}" id="{{$getIddCod()}}" class="form-control form-control-sm">
            </div>
            <div class="col-md-{{$getColDescription() ?? '10'}} col-sm-12">
                <label for="{{$getIdDescription()}}" class="label">{{$getLabelDescription()}}</label>
                <input value="{{$getValueCod()}}" type="{{$getTypeDescrption() ?? 'text'}}" name="{{$getNameDescription()}}" id="{{$getIdDescription()}}" class="form-control form-control-sm">
            </div>
        </div>
    </div>
</div>-->
@php 
    $randId = rand(11111, 99999);
@endphp

<div class="row">
    <div class="form-group col-md-12 col-sm-12">
        <div class="row">
            <div class="col-md-{{$getColCod() ?? '2'}} col-sm-12 " style="padding-right: 0px !important;">
                <label for="{{$getIddCod()}}" class="label">{{$getLabelCod()}}</label>
                <input style="border-top-right-radius: 0px !important; border-bottom-right-radius: 0px !important;" value="{{$getValueDescription()}}" type="{{$getTypeCod() ?? 'text'}}" name="{{$getNameCod()}}" id="{{$getIddCod()}}" class="form-control form-control-sm">
            </div>
            <div class="col-md-{{'1'}} col-sm-12" style="padding-right: 0px !important; padding-left: 0px !important; margin-top: 31px; ">
                <button type="button" onClick="search{{$randId}}();" style="width: 100%; border-radius: 0px 0px !important;" class="btn btn-sm btn-default"><i class="fas fa-search"></i></button>
            </div>
            <div class="col-md-{{$getColDescription() ?? '10'}} col-sm-12" style="padding-left: 0px !important;">
                <label for="{{$getIdDescription()}}" class="label">{{$getLabelDescription()}}</label>
                <input style="  border-top-left-radius: 0px !important; border-bottom-left-radius: 0px !important;" value="{{$getValueCod()}}" type="{{$getTypeDescrption() ?? 'text'}}" name="{{$getNameDescription()}}" id="{{$getIdDescription()}}" class="form-control form-control-sm">
            </div>
        </div>
    </div>
</div>

<script>

    function search{{$randId}}(){
        {{$getSearsh()}}
    }

</script>

