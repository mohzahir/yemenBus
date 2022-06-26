<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>يمن باص | Yemen bus</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('passenger-assets/img/favicon.ico') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('passenger-assets/css/custom.css?v=1') }}">


    {{-- <link
        href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap"
        rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap" rel="stylesheet">
    @yield('css')
</head>

<body style="font-family: 'Tajawal', sans-serif;">
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ asset('passenger-assets/img/logo/loggo.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header ">
                <div class="header-top top-bg d-none d-lg-block">
                    <div class="container">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-lg-8">
                                <div class="header-info-left">
                                    <ul>
                                        <li>Yemenbus1@gmail.com</li>
                                        <li>0507703877</li>
                                        <li>يمن باص</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="header-info-right f-right">
                                    <ul class="header-social">
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li> <a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-bottom  header-sticky">
                    <div class="container">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-2 col-lg-2 col-md-1">
                                <div class="logo">
                                    <a href="{{ route('passengers.cards') }}" class="logo-font">
                                        <img src="{{ asset('passenger-assets/img/logo/loggo.png') }}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-8">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="{{ route('passengers.cards') }}">الرئيسية</a></li>
                                            <li><a href="#">عنا</a></li>
                                            <li><a href="#">تواصل معنا</a></li>
                                        </ul>
                                    </nav>

                                </div>
                            </div>
                            @if (Auth::guard('passenger')->check())
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-1">

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            style="padding: 20px">
                                            {{ Auth::guard('passenger')->user()->name_passenger }}

                                        </button>
                                        <div class="dropdown-menu logout-menu" style="left: auto; right:0">
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">تسجيل الخروج</a>

                                        </div>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-1">
                                    <a class="pass-login" style="color: #0e1c35"
                                        href="{{ route('login.passenger') }}">تسجيل
                                        الدخول</a>

                                </div>
                            @endif


                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>


    @yield('content')
    <footer>
        <!-- Footer Start-->
        <div class="footer-area footer-padding footer-bg" style="padding-bottom: 17px; padding-top:17px"
            data-background="{{ asset('passenger-assets/img/service/footer_bg.jpg') }}">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-6">
                        <div class="single-footer-caption mb-50">
                            <div class="single-footer-caption mb-30">
                                <!-- logo -->
                                <div class="footer-logo">
                                    <a href="index.html"><img src="assets/img/logo/logo2_footer.png" alt=""></a>
                                </div>
                                <div class="footer-tittle">
                                    <div class="footer-pera">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4></h4>
                                <ul>
                                    <li><a href="#"></a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-7">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4></h4>
                                <ul>
                                    <li><a href="#"></a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-7">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4></h4>
                                <ul>
                                    <li><a href="#"></a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer bottom -->
                <div class="row pt-padding">
                    <div class="col-xl-7 col-lg-7 col-md-7">
                        <div class="footer-copy-right">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-5">
                        <!-- social -->
                        <!--   <div class="footer-social f-right">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-behance"></i></a>
                            <a href="#"><i class="fas fa-globe"></i></a>
                        </div>
                    -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End-->
    </footer>

    <!-- JS here -->

    <!-- All JS Custom Plugins Link Here here -->
    <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>

    <!-- Jquery, Popper, Bootstrap -->
    <script src="{{ asset('passenger-assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/bootstrap.min.js') }}"></script>
    <!-- Jquery Mobile Menu -->
    <script src="{{ asset('passenger-assets/js/jquery.slicknav.min.js') }}"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="{{ asset('passenger-assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/slick.min.js') }}"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="{{ asset('passenger-assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/animated.headline.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/jquery.magnific-popup.js') }}"></script>

    <!-- Scrollup, nice-select, sticky -->
    <script src="{{ asset('passenger-assets/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/jquery.sticky.js') }}"></script>

    <!-- contact js -->
    <script src="{{ asset('passenger-assets/js/contact.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/jquery.form.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/mail-script.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/jquery.ajaxchimp.min.js') }}"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="{{ asset('passenger-assets/js/plugins.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/main.js') }}"></script>
    <script src="{{ asset('passenger-assets/js/ticket.js') }}"></script>
    @yield('js')

</body>

</html>