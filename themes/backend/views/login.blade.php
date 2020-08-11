@extends('backend::layouts.auth')
@section('content')
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">{{trans('backend::auth.label.sign in to start your session')}}</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="{{trans('backend::auth.label.username')}}" name="username"  >
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="{{trans('backend::auth.label.password')}}" name="password" >
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-7">
                    <div class="checkbox icheck">
                        <label>
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>  {{trans('backend::auth.label.remember me')}}
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-5">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{trans('backend::auth.label.sign in')}}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="{{ route('forgot') }}"> {{trans('backend::auth.label.forgot password')}}</a>


    </div>
    <!-- /.login-box-body -->
@endsection
