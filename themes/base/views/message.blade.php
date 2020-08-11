@extends('base::layouts.app')

@section('content')
    <router-view></router-view>
    <div id="success">
        <div class="icon icon--order-success svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                @if($status)
                <g fill="none" stroke="#8EC343" stroke-width="2">
                    <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                    <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                </g>
                    @else
                    <g fill="none" stroke="#FF0000" stroke-width="2">
                        <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                        <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                    </g>
                @endif
            </svg>
        </div>
        <h4>{!! $message !!}</h4>

    </div>
    <!-- /row-->
@endsection
@push('css-stack')
@endpush
@push('js-stack')
@endpush
