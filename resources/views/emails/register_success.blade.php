<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml><![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
    <title></title>

    <style type="text/css" id="media-query">
        body {
            margin: 0;
            padding: 0;
        }

        table, tr, td {
            vertical-align: top;
            border-collapse: collapse;
        }

        .ie-browser table, .mso-container table {
            table-layout: fixed;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

        .email-html {
            max-width: 600px;
            margin: 0 auto;
        }

        .header {
            background-color: #ff3845;
            color: #fff;
            padding: 10px 20px;
        }

        .header h2 {
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
        }

        .header p {
            font-size: 12px;
            font-weight: 300;
            text-transform: uppercase;
        }

        .center {
            text-align: center;
        }

        h1, h2, h3, p {
            margin: 0 0 5px
        }

        .table {
            margin-top: 20px;
        }

        .table h3 {
            margin: 20px auto;
            text-align: center;
        }

        .table table {
            margin: 0 auto;
            border-collapse: separate;
        }

        .table td {
            background-color: #f7f7f7;
            padding: 5px 10px;
        }

        .img {
            text-align: center;
        }

        .img p {
            font-size: 14px;
            margin: 15px 0 30px;
        }

        .body {
            padding: 20px 0 50px;
        }

        @media (min-width: 768px) {
            .table table {
                width: 500px;
            }
        }

        @media (max-width: 767px) {
            .table table {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="email-html">
    <div class="header">
        <h2>Xin chào {{$user->name}}
        </h2>

    </div>
    <div class="body">

        <div class="table">
            <h3>Chúc mừng Anh/Chị đã đăng ký thành công Chương trình {{$grade->course->name}}. Thông tin chi tiết như sau:
            </h3>
            <table>
                <tr>
                    <td>Mã học viên</td>
                    <td width="60%">{{$user->username}}</td>
                </tr>
                <tr>
                    <td>Chương trình</td>
                    <td>{{$grade->course->name}}</td>
                </tr>

                <tr>
                    <td>Thời gian đăng ký</td>
                    <td>{{\Illuminate\Support\Carbon::now()->format('Y-m-d H:i')}}</td>
                </tr>
                <tr>
                    <td>Thời gian diễn ra lớp</td>
                    <td>{{$grade->start_time? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $grade->start_time)->format('Y-m-d H:i'): ''}}</td>
                </tr>
                <tr>
                    <td>Địa điểm</td>
                    <td> {{$grade->place}} - {{$grade->phoenix? $grade->phoenix->name.' - ': ''}}  {{$grade->district? $grade->district->name.' - ':''}} {{$grade->province? $grade->province->name:''}} </td>
                </tr>

            </table>
            <p>
                Cảm ơn Anh/Chị đã quan tâm chương trình của chúng tôi, mọi thắc mắc xin liên hệ hotline: 028 7300 0050 hoặc truy cập website: http://svf.org.vn để được hỗ trợ giải đáp.
            </p>
            <p>--------------------------------------------------- Trân trọng  ----------------------------------------------------</p>
            <table style="width: 100%">

                <tr>
                    <td style="background-color: #fff; font-weight: bold; padding-left: 0px;">
                        Startup Vietnam Foundation


                    </td>
                </tr>
                <tr>
                    <td style="background-color: #fff; padding-left: 0px;">
                        <div  style="background-color: #fff; font-weight: bold; padding-left: 0px;">Hồ Chí Minh</div>
                        <div>Tầng 6, Kova Center, 92 G-H Nguyễn Hữu Cảnh, phường 22, quận Bình Thạnh, Hồ Chí Minh</div>
                        <br/>
                        <div  style="background-color: #fff; font-weight: bold; padding-left: 0px;">Hà Nội</div>
                        <div>E-space Coworking, Tầng 3 toà nhà Savina, Số 1 Đinh Lễ, Hoàn Kiếm, Hà Nội</div>

                    </td>
                </tr>

                <tr>
                    <td style="background-color: #fff; padding-left: 0px;">
                        Website: <a href="http://svf.org.vn">svf.org.vn</a>

                    </td>
                </tr>
                <tr>
                    <td style="background-color: #fff; padding-left: 0px;">
                        Facebook: <a href="bit.ly/SVFfanpage"> bit.ly/SVFfanpage</a>

                    </td>
                </tr>
                <tr>
                    <td style="background-color: #fff; padding-left: 0px;">
                        Linkedin: <a href="bit.ly/SVFlinkedin"> bit.ly/SVFlinkedin</a>

                    </td>
                </tr>
                <tr>
                    <td style="background-color: #fff; padding-left: 0px;">
                        Youtube: <a href="bit.ly/SVFyoutube"> bit.ly/SVFyoutube</a>

                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>
