<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkin</title>
    {!! \Theme::css("css/bootstrap.min.css") !!}
</head>
<body>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6 col-8 offset-3">
            <h2>Điểm danh {{ $lesson->grade->name }}</h2>

            <form method="POST" action="{{ route('checkin.submit',['lesson' => $lesson->id]) }}" id="wrapped">
                @csrf
                <div id="middle-wizard">
                    <div class="step">
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
                <div id="bottom-wizard">
                    <button type="submit" name="process" class="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{!! \Theme::js("js/bootstrap.min.js") !!}
</body>
</html>
