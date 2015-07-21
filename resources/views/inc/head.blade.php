
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

    <!-- A-LTE -->
    <link href="{{ asset('/res/adminLTE/2.0.5/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/res/adminLTE/2.0.5/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/res/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <!-- Pickadate Css -->
    <link href="{{ asset('/res/pickadate/themes/default.css') }}" rel="stylesheet">
    <link href="{{ asset('/res/pickadate/themes/default.date.css') }}" rel="stylesheet">
    <link href="{{ asset('/res/pickadate/themes/default.time.css') }}" rel="stylesheet">

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