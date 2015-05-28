<!DOCTYPE html>
<html lang="it">


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<title>@yield('title','Home') - {{ \Config::get('Silent.appName') }} - v.{{ \Config::get('Silent.version') }}</title>


<!-- BS -->
<link href="{{ asset('/res/bootstrap/3.3.4/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- FA -->
<link href="{{ asset('/res/fontawesome/4.3.0/css/font-awesome.min.css') }}" rel="stylesheet">

<!-- Ionicons
<link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
-->

<!-- Main Css -->
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

<!-- Fonts
<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
-->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>


    @yield('page-content')



    <footer class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="color: #c0c0c0">
                @include('inc.footer')
            </div>
        </div>
    </footer>


<!-- Scripts -->
<script src="{{asset('/res/jquery/2.1.3/jquery.min.js')}}"></script>
<script src="{{ asset('/res/bootstrap/3.3.4/js/bootstrap.min.js') }}"></script>
</body>
</html>
