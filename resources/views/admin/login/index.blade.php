@extends('layouts.app')
@section('content')
<div class="container p-5" style="height: 100%;" >
	<form action="{{route('admin.login')}}" method="post" style="margin: auto;">
		{{csrf_field()}}
		<div class="row">
			<div class="col">

			</div>
			<div class="col">
				<h2 align="center" class="mb-3">Entrar</h2>
				@include('admin.login._form')
				<button class="btn btn-sm btn-primary p-3 mt-4" style="width: 100%;border-radius: 30px;">Entrar</button>
			</div>
		</div>
	</form>
</div>
@endsection