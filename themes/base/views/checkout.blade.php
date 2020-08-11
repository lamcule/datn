@extends('base::layouts.app')

@section('content')

    <div class="row row-height">
        <div class="col-lg-6 content-left">
            <div class="content-left-wrapper">

                <!-- /social -->
                <div>
                    <figure><img src="/themes/base/images/svf.png" alt="" class="img-fluid"></figure>
                    <h2>{{trans('base::frontend.welcome')}}</h2>

                    <p style="font-size: x-large;">  <strong>{{$lesson->grade->name}}</strong>
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

                <form method="POST" action="{{ route('checkout.submit',['lesson' => $lesson->id]) }}" id="wrapped">
                @csrf
                <!-- Leave for security protection, read docs for details -->
                    <div id="middle-wizard">
                        <div class="step">

                            <h3 class="main_question"> Nhập mã học viên để xác nhận hoàn thành chương trình</h3>
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

                        <button type="submit" name="process" class="submit">
                            Xác nhận</button>
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
