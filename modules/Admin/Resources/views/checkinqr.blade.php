@extends('backend::layouts.qr')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" style="background: #fff;
    width: 480px;
    margin-bottom: 20px;">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width:30%">{{trans('backend::lesson.web.course')}}:</th>
                        <td>{{$lesson->course->name}}</td>
                    </tr>
                    <tr>
                        <th style="width:30%">{{trans('backend::lesson.web.grade')}}:</th>
                        <td>{{$lesson->grade->name}}</td>
                    </tr>
                    <tr>
                        <th style="width:30%">{{trans('backend::lesson.web.lesson')}}:</th>
                        <td>{{$lesson->name}}</td>
                    </tr>
                    <tr>
                        <th style="width:30%">{{trans('backend::lesson.label.status')}}:</th>
                        <td><span class="badge {{$lesson->getStatusClass()}}">Active</span></td>
                    </tr>
                    <tr>
                        <th style="width:30%">{{trans('backend::lesson.web.type')}}:</th>
                        <td><span class="badge {{$lesson->getQRTypeClass(trans('backend::lesson.web.review'))}}">{{trans('backend::lesson.web.checkin')}}</td>
                    </tr>
                    <tr>
                        <th style="width:30%">{{trans('backend::lesson.web.type')}}:</th>
                        <td>{{trans('backend::lesson.web.checkin')}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <a href="{{ route('checkin', ['lesson' => $lesson->id], true) }}">{{ route('checkin', ['lesson' => $lesson->id], true)}} </a>
        </div>
    </div>


@endsection
@push('css-stack')
@endpush
@push('js-stack')
@endpush
