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
    <meta name="user-api-token" content="{{ $currentUser->getFirstTokenKey() }}">
    <meta name="current-locale" content="{{ app()->getLocale() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">

    {!! \Theme::css('vendor/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! \Theme::css('vendor/font-awesome/css/all.css') !!}
    {!! \Theme::css('vendor/admin-lte/dist/css/AdminLTE.css') !!}
    {!! \Theme::css('vendor/admin-lte/dist/css/skins/_all-skins.min.css') !!}
     {!! \Theme::css('css/app.css') !!}
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    {!! Theme::js('js/jquery.min.js') !!}
    @include('backend::partials.globals')
    @section('styles')
    @show
    @stack('css-stack')
    @stack('translation-stack')

    <script>
        $.ajaxSetup({
            headers: { 'Authorization': 'Bearer  {{ $currentUser->getFirstTokenKey() }}' }
        });
        var AuthorizationHeaderValue = 'Bearer  {{ $currentUser->getFirstTokenKey() }}';
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @routes
</head>
<body class="{{ config('asgard.core.core.skin', 'skin-blue') }} sidebar-mini" style="padding-bottom: 0 !important;">
<div class="wrapper" id="app">
    <header class="main-header">
        <a href="{{route('admin.index')}}" class="logo">
         <span class="logo-mini">
                              <img src="{{ URL::asset('/themes/backend/images/logo.png') }}"/>

            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/themes/backend/images/logo.png') }}"/>
            </span>
        </a>
        @include('backend::partials.top-nav')
    </header>
    @include('backend::partials.sidebar-nav')
    <div class="content-wrapper">

        <section class="content-header">
        </section>
        <!-- Main content -->
        <section class="content" >
            @include('backend::partials.notifications')
            @yield('content')
            <router-view></router-view>
        </section><!-- /.content -->
    </div><!-- /.right-side -->
    @include('backend::partials.footer')
    @include('backend::partials.right-sidebar')
</div><!-- ./wrapper -->
<script>
    window.MonCMS = {

        locales: {!! json_encode(supported_locales()) !!},
        currentLocale: '{{app()->getLocale() }}',
        adminPrefix: 'admin',
        filesystem: '{{ config('config.filesystem.default') }}',
        translations:'',
        editorUploadUrl: '{{route('api.media.editor.store')}}',

        multipleLanguage: '{{config('mon.multiple_languages')}}',
        permissions: {!! json_encode($permissions) !!},
        permissionDenied: '{{trans('backend::mon.message.permission_denied')}}',

    };

</script>

 {!! \Theme::js('vendor/bootstrap/dist/js/bootstrap.min.js') !!}
 {!! \Theme::js('vendor/jquery-ui/ui/core.js') !!}
 {!! \Theme::js('vendor/admin-lte/dist/js/adminlte.min.js') !!}
 {!! \Theme::js('vendor/admin-lte/dist/js/demo.js') !!}
 {!! \Theme::js('vendor/tinymce/tinymce4.7.5/tinymce.min.js') !!}

 {!! \Theme::js('js/app.js') !!}
@section('scripts')
@show
@stack('js-stack')
</body>
</html>
