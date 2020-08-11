@extends('backend::layouts.auth')

@section('content')
    <div class="login-box-body">
        <p class="login-box-msg">{{trans('backend::auth.label.Reset Password')}}</p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group has-feedback">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{trans('backend::auth.label.email')}}"
                       name="email" value="{{ $email ?? old('email') }}" required autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group has-feedback">
                <input id="password" type="password" placeholder="{{trans('backend::auth.label.password')}}"
                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group has-feedback">
                <input id="password_confirmation" type="password" placeholder="{{trans('backend::auth.label.password_confirmation')}}"
                       class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                       name="password_confirmation" required>

                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password_confirmation'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="row">

                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit"
                            class="btn btn-primary btn-block btn-flat">{{trans('backend::auth.label.submit')}}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>


    </div>


@endsection
