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
        </div>
    </div>
</div>

{!! \Theme::js("js/bootstrap.min.js") !!}
</body>
</html>
