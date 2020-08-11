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
                        <th style="width:30%">{{trans('backend::lesson.label.start_time')}}:</th>
                        <td>{{optional($lesson->start_time)->format('d-m-Y H:i')}}</td>
                    </tr>
                    <tr>
                        <th style="width:30%">{{trans('backend::lesson.label.status')}}:</th>
                        <td><span class="badge {{$lesson->getStatusClass()}}">Active</span></td>
                    </tr>
                    <tr>
                        <th style="width:30%">{{trans('backend::lesson.web.type')}}:</th>
                        <td>
                            <span class="badge {{$lesson->getQRTypeClass(trans('backend::lesson.web.review'))}}">{{trans('backend::lesson.web.review')}}
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            {!! QrCode::size(480)->generate(route('review', ['lesson' => $lesson->id], true)); !!}
        </div>
    </div>
@endsection
@push('css-stack')
@endpush
@push('js-stack')
@endpush
