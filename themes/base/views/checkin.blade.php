@extends('base::layouts.app')

@section('content')

    <div class="row row-height">
        <div class="col-lg-6 content-left">
            <div class="content-left-wrapper">

                <!-- /social -->
                <div>
                    <figure><img src="/themes/base/images/svf.png" alt="" class="img-fluid"></figure>
                    <h2>{{trans('base::frontend.welcome')}}</h2>

                    <p style="font-size: x-large;"> <strong>{{$lesson->grade->name}}</strong>
                    </p>


                </div>
                <div class="copy">© 2019</div>
            </div>
            <!-- /content-left-wrapper -->
        </div>
        <!-- /content-left -->

        <div class="col-lg-6 content-right" id="start">
            <div id="wizard_container">
                <div id="top-wizard">
                    <div id="progressbar"></div>
                </div>
                <!-- /top-wizard -->

                <form method="POST" action="{{ route('checkin.submit',['lesson' => $lesson->id]) }}" id="wrapped">
                @csrf
                <!-- Leave for security protection, read docs for details -->
                    <div id="middle-wizard">
                        <div class="step">

                            <h3 class="main_question"> Nhập mã học viên để xác nhận tham gia chương trình</h3>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control required"
                                       value="{{ old('username') }}"
                                       placeholder="Mã học viên">
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                    </div>
                    <!-- /middle-wizard -->
                    <div id="bottom-wizard">
                        <a href="{{route('grade.register',['grade' => $lesson->grade_id])}}"
                           style="float: left;border: none;
    color: #fff;
    text-decoration: none;
    transition: background .5s ease;
    -moz-transition: background .5s ease;
    -webkit-transition: background .5s ease;
    -o-transition: background .5s ease;
    display: inline-block;
    cursor: pointer;
    outline: none;
    text-align: center;
    background: rgb(255, 130, 130);
    position: relative;
    font-size: 14px;
    font-size: 0.875rem;
    font-weight: 600;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -ms-border-radius: 3px;
    border-radius: 3px;
    line-height: 1;
    padding: 12px 30px;">Đăng ký chương trình</a>
                        <button type="submit" name="process" class="submit">Tham gia</button>
                    </div>
                    <!-- /bottom-wizard -->
                </form>
            </div>
            <!-- /Wizard container -->
        </div>
        <!-- /content-right-->
    </div>
    <!-- /row-->
@endsection
@push('css-stack')
@endpush
@push('js-stack')
    <script>
        $(function () {
          $('.submit').on('click', function () {
            $( this ).addClass('btn-disabled')
            $('a').addClass('btn-disabled')
          })
        })
    </script>
@endpush
