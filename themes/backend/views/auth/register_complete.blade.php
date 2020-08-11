@extends('base::layouts.auth')

@section('content')
    <div class="login form">
        <div class="card">
            <div class="card-header">{{ __('Register') }}</div>

            <div class="card-body">
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
