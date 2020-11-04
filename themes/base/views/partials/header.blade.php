<div>
    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>
    <div class="py-2 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9 d-none d-lg-block">
                    <a href="#" class="small mr-3"><span class="icon-question-circle-o mr-2"></span> Có câu hỏi?</a>
                    <a href="#" class="small mr-3"><span class="icon-phone2 mr-2"></span> 10 20 123 456</a>
                    <a href="#" class="small mr-3"><span class="icon-envelope-o mr-2"></span> academic@gmail.com</a>
                </div>
            </div>
        </div>
    </div>
    <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">

        <div class="container">
            <div class="d-flex align-items-center">
                <div class="site-logo">
                    <a href="{{ route("guest.home") }}" class="d-block">
                        <img src="/themes/base/images/logo.jpg" alt="Image" class="img-fluid">
                    </a>
                </div>
                <div class="mr-auto">
                    <nav class="site-navigation position-relative text-right" role="navigation">
                        <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                            <li class="active">
                                <a href="{{ route("guest.home") }}" class="nav-link text-left">Trang chủ</a>
                            </li>
                            <li class="has-children">
                                <a href="{{ route("guest.about") }}" class="nav-link text-left">Về chúng tôi</a>
                                <ul class="dropdown">
                                    <li><a href="{{ route("guest.teacher") }}">Đội ngũ giảng viên</a></li>
                                    <li><a href={{ route("guest.about") }}>Về trung tâm</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="admissions.html" class="nav-link text-left">Lịch khai giảng</a>
                            </li>
                            <li>
                                <a href="{{ route("guest.course") }}" class="nav-link text-left">Khóa học</a>
                            </li>
                            <li>
                                <a href="{{ route("guest.contact") }}" class="nav-link text-left">Liên hệ</a>
                            </li>
                        </ul>
                    </nav>

                </div>
                <div class="ml-auto">
                    <div class="social-wrap">
                        <a href="#"><span class="icon-facebook"></span></a>
                        <a href="#"><span class="icon-twitter"></span></a>
                        <a href="#"><span class="icon-linkedin"></span></a>

                        <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black"><span
                                class="icon-menu h3"></span></a>
                    </div>
                </div>

            </div>
        </div>

    </header>
</div>
