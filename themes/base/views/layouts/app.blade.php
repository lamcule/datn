<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-api-token" content="{{ !empty($user) ? $user->getFirstTokenKey() : '' }}">
    <meta name="current-locale" content="{{ app()->getLocale() }}">
    {!! SEO::generate() !!}
    <script>
        var user = null
        @if(!empty($user))
            user =
            {!! json_encode((new \Modules\Mon\Transformers\UserTransformer($user))->toArray()) !!}
            @endif
        var MonCMS = {
                translations: {!! $staticTranslations !!},
                locale: '{{ app()->getLocale() }}',
                locale_prefix: '{{ locale_prefix() }}',
                user: user,
                assetUrl: '{{ config('app.asset_url') }}',
            }
    </script>
    <!-- <script src="//mozilla.github.io/pdf.js/build/pdf.js") !!} -->
    <!-- Styles -->

    {!! \Theme::css("css/bootstrap.min.css") !!}
    {!! \Theme::css("css/jquery-ui.css") !!}
    {!! \Theme::css("css/owl.carousel.min.css") !!}
    {!! \Theme::css("css/owl.theme.default.min.css") !!}
    {!! \Theme::css("css/owl.theme.default.min.css") !!}

    {!! \Theme::css("css/jquery.fancybox.min.css") !!}

    {!! \Theme::css("css/bootstrap-datepicker.css") !!}

    {!! \Theme::css("css/aos.css") !!}
    {!! \Theme::css("css/jquery.mb.YTPlayer.min.css") !!}

    {!! \Theme::css("css/style.css") !!}
    {!! \Theme::css("fonts/icomoon/style.css") !!}
    {!! \Theme::css("fonts/flaticon/font/flaticon.css") !!}

<!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600" rel="stylesheet">

    <!-- BASE CSS -->
    {!! \Theme::css('css/main.css?time='.time()) !!}
    {{--    {!! \Theme::css('vendors/wilio/css/bootstrap.min.css') !!}--}}
    {{--    {!! \Theme::css('vendors/wilio/css/menu.css') !!}--}}
    {{--    {!! \Theme::css('vendors/wilio/css/style.css') !!}--}}
    {{--    {!! \Theme::css('vendors/wilio/css/vendors.css') !!}--}}
    {!! \Theme::css('css/app.css?time='.time()) !!}

    @stack('css-stack')
</head>
<body>
<div id="app" class="site-wrap">
    @include('base::partials.header')
    @yield('content')
    <router-view></router-view>
    @include('base::partials.footer')
</div>

{!! \Theme::js('js/app.js') !!}

{!! \Theme::js("js/jquery-3.3.1.min.js") !!}
{!! \Theme::js("js/jquery-migrate-3.0.1.min.js") !!}
{!! \Theme::js("js/jquery-ui.js") !!}
{!! \Theme::js("js/popper.min.js") !!}
{!! \Theme::js("js/bootstrap.min.js") !!}
{!! \Theme::js("js/owl.carousel.min.js") !!}
{!! \Theme::js("js/jquery.stellar.min.js") !!}
{!! \Theme::js("js/jquery.countdown.min.js") !!}
{!! \Theme::js("js/bootstrap-datepicker.min.js") !!}
{!! \Theme::js("js/jquery.easing.1.3.js") !!}
{!! \Theme::js("js/aos.js") !!}
{!! \Theme::js("js/jquery.fancybox.min.js") !!}
{!! \Theme::js("js/jquery.sticky.js") !!}
{!! \Theme::js("js/jquery.mb.YTPlayer.min.js") !!}
{!! \Theme::js("js/main.js") !!}

@stack('js-stack')

</body>
</html>
