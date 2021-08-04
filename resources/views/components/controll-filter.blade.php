<div class="row">
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
</div>
