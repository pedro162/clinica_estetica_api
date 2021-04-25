<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistama Academia</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" href="{{asset('bootstrap-4/css/bootstrap.min.css')}}">
	    <link rel="stylesheet" href="{{asset('bootstrap-4/css/bootstrap-grid.min.css')}}">
        <link rel="stylesheet" href="{{asset('_styles/site.css')}}">
	    <script src="{{asset('jquery/jquery.min_google.js')}}"></script>
        <script src="{{asset('bootstrap-4/js/bootstrap.min.js')}}"></script>
    </head>
    <body>
        <header>
            @include('layouts._site._nav')
        </header>
        <main>
            @if(Session::has('mensagem'))
            <div class="container">
                <div class="row">
                    <div class="col text-center {{Session::get('mensagem')['class']}}">
                        {{Session::get('mensagem')['msg']}}
                    </div>
                </div>
            </div>
            @endif
            @yield('content')
        </main>
    </body>
</html>
