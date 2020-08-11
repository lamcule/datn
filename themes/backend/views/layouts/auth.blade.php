<!DOCTYPE html>
<html>
<head>
    <base src="{{ URL::asset('/') }}" />
    <meta charset="UTF-8">
    <title>
        @section('title')
            Admin
        @show
    </title>
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <meta name="current-locale" content="{{ app()->getLocale() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <link href="{{ asset('themes/backend/vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/backend/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/backend/vendor/admin-lte/dist/css/AdminLTE.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/backend/vendor/admin-lte/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/backend/vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('themes/backend/js/jquery.min.js') }}"></script>

     @section('styles')
    @show
    @stack('css-stack')
    @stack('translation-stack')


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @routes
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#">SVF CRM</a>
    </div>
    <!-- Main content -->
    <section class="content">

        @yield('content')

    </section><!-- /.content -->
</div>
<!-- /.login-box -->
<script src="{{ asset('themes/backend/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  @section('scripts')
@show
@stack('js-stack')
</body>
</html>
