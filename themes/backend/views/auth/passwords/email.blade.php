@extends('base::layouts.auth')

@section('content')
<div class="login form">
    <div class="card">
        <div class="card-header">{{ __('Reset Password') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" id="frm-reset-pwd">
                @csrf

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <input type="hidden" name="g-recaptcha" value="" id="g-recaptcha-res">
                        <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}" data-callback="verifyCaptcha"></div>
                        <span class="invalid-feedback @if(!$errors->has('g-recaptcha')) hide @endif" id="captcha-error">
                            {{ $errors->first('g-recaptcha') }}
                        </span>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="button" class="btn btn-primary" onclick="onSubmit()">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js-stack')
    <script src="https://www.google.com/recaptcha/api.js?hl={{ app()->getLocale() }}" async defer></script>
    <script>
        var verifiedCaptcha = false;

        function verifyCaptcha(token) {
            verifiedCaptcha = token.length > 0;
            if(verifiedCaptcha) {
                document.getElementById('g-recaptcha-res').value = token;
                var captchaErrorEle = document.getElementById('captcha-error');
                if(!captchaErrorEle.classList.contains('hide')) {
                    captchaErrorEle.classList.add('hide');
                }
            }
        }

        function onSubmit() {
            var captchaErrorEle = document.getElementById('captcha-error');
            if (verifiedCaptcha === true) {
                captchaErrorEle.classList.add('hide');
                document.getElementById('frm-reset-pwd').submit();
            } else {
                grecaptcha.reset();
                captchaErrorEle.innerHTML = "{{ __('validation.not_check_captcha') }}";
                if(captchaErrorEle.classList.contains('hide')) {
                    captchaErrorEle.classList.remove('hide');
                }
            }
        }
    </script>
@endpush
