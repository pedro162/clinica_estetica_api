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
        <link rel="stylesheet" href="{{asset('_styles/admin.css')}}">
        <link rel="stylesheet" href="{{asset('_styles/css_data_table/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('_styles/fontawesome/css/all.min.css')}}">
        <script src="{{asset('jquery/jquery.min_google.js')}}"></script>
        <script src="{{asset('jquery/jquery-ui/external/jquery/jquery.js')}}"></script>
        <script src="{{asset('jquery/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{asset('jquery/plugins/jQuery-Mask/src/jquery.mask.js')}}"></script>
        <script src="{{asset('jquery/plugins/chart-JS/chart.js')}}"></script>
        <script src="{{asset('jquery/plugins/jqueryDataTable/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('scripts/admin.js')}}" ></script>
        <script src="{{asset('bootstrap-4/js/bootstrap.min.js')}}"></script>

    </head>
    <body class="container-laraval-body" id="container-laraval-body">
        @if(Auth::check())
        <header>
            @include('layouts._admin._nav')
        </header>
        @endif
        <main>
            @if(isset($errors) && (count($errors) > 0))
            <div class="container-fluid">
                <div class="row">
                    <div class="col text-center alert alert-danger">
                        @foreach($errors->all() as $erro)
                        <p>{{$erro}}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if(Session::has('mensagem'))
            <div class="container-fluid">
                <div class="row">
                    <div class="col text-center {{Session::get('mensagem')['class']}}">
                        {{Session::get('mensagem')['msg']}}
                    </div>
                </div>
            </div>
            @endif
            <div class="row"><div class="col" id="menssageForUser"></div></div>
            <div id="container-principal">
                @yield('content')
            </div>
        </main>
    </body>
    <footer id='footer'>
        <!-- The Modal -->
      <div class="modal fade" id="assistenteModal">
        <div class="" id="modal-size" role="document">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Modal Heading</h4>
              <button type="button" class="close" data-dismiss="modal" id="closeModal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col" id="messagem_modal">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col" id="content_modal">
                        
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              
            </div>

          </div>
        </div>
      </div>
    </footer>
</html>
