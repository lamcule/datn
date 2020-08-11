@extends('base::layouts.app')
@push('css-stack')
@endpush
@section('content')
    <router-view></router-view>
@endsection
@push('js-stack')
@endpush
