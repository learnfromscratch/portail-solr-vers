<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Alegreya" rel="stylesheet">

    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel="stylesheet" href="{{ asset('css/w3.css') }}">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Styles -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/6.4.4/sweetalert2.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<link rel="stylesheet" href="{{ asset('css/bootstrap-tags.css') }}">
    @yield('css')

    <!-- Scripts -->.
    <!--<script src="//{{ Request::getHost() }}:3001/socket.io/socket.io.js"></script>-->
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.0/vue.min.js"></script>
    <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script> -->
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <!--
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    -->
</head>
<body style="background: {{App\Miseforme::where('user_id', Auth::id())->first()->color_background}}">
   
    <div id="">
    

           <input type="hidden" id="receiver_id" value="" />
        <nav class="navbar navbar-default navbar-fixed-top w3-light-gray">
            <div class="container">
            
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="/portail-solr-vers/public/{{Request::segment(1)}}">
                        {{ config('app.name') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li><a href="">Contact</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('parametres.show')}}"><i class="fa fa-user-o fa-lg fa-fw"></i> Paramétres</a></li>


                                  @if (Auth::user()->role_id === 1)
                                  <li>
                <a href="{{ route('admin.dashboard') }}"><i class="fa fa-lock fa-lg fa-fw" aria-hidden="true"></i> Espace Administration</a>
                </li>
              @endif
              @if (Auth::user()->role_id === 2)
              <li>
                <a class="mdl-navigation__link" href="{{ route('client.admin', ['id' => Auth::user()->groupe->id]) }}"><i class="fa fa-lock fa-lg fa-fw" aria-hidden="true"></i>Tableau de bord</a>
              </li>
              @endif
                               
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Se déconnecter
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>


                            <!-- <li class="form-group ">
                                    <select class="form-control lang" id="exampleSelect1" name="language">
                                    <option value="fr" selected>FR</option>
                                      <option value="ar">AR</option>
                                      <option value="en">EN</option>
                                    </select>
                                </li> -->

                    </ul>
                </div>

            </div>
        </nav>
 
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/datepicker.min.js') }}"></script>
   <script src="{{ asset('js/bootstrap-tags.min.js') }}"></script>
    <script type="text/javascript">
        $('.input-daterange').datepicker({
        todayBtn: true,
        format: 'yyyy-mm-dd'
});
        $('#dateinput').datepicker({
            todayHighlight: true,
             format: 'yyyy-mm-dd'
});

         $('#dateinput1').datepicker({
            todayHighlight: true,
             format: 'yyyy-mm-dd'
});
    </script>
    <script src="https://cdn.jsdelivr.net/sweetalert2/6.4.4/sweetalert2.min.js"></script>
    @include('sweet::alert')
    <!-- <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>-->
    <script src="{{ asset('js/app.js') }}"></script>
    
    
</body>
</html>