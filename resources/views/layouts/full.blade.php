<!doctype html>
<html lang="zxx">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/assets/css/bootstrap..min.css">
    <link rel="stylesheet" href="/assets/css/boxicons.min.css">
    <link rel="stylesheet" href="/assets/css/flaticon.css">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/css/odometer.min.css">
    <link rel="stylesheet" href="/assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="/assets/css/animate.min.css">
    <link rel="stylesheet" href="/assets/css/nice-select.min.css">
    <link rel="stylesheet" href="/assets/css/viewer.min.css">
    <link rel="stylesheet" href="/assets/css/slick.min.css">
    <link rel="stylesheet" href="/assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>@yield('title') :: Semestro projektas</title>
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
</head>
<body>

<div class="preloader">
    <div class="loader">
        <div class="shadow"></div>
        <div class="box"></div>
    </div>
</div>


<header class="header-area">
    <div class="top-header-style-two">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="top-header-logo">
                        <a href="{{route('home')}}" class="d-inline-block"><img src="/assets/img/black-logo.png" alt="logo"></a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <ul class="top-header-contact-info">
                        <li>
                            <i class='bx bx-phone-call'></i>
                            <span>{{__('page.number')}}</span>
                            <a href="tel:37012345678">+370 123 456 78</a>
                        </li>
                        <li>
                            <i class='bx bx-map'></i>
                            <span>{{__('page.location')}}</span>
                            <a href="#">Gatvės gatvė, 34 Kaunas</a>
                        </li>
                        <li>
                            <i class='bx bx-envelope'></i>
                            <span>{{__('page.email')}}</span>
                            <a href="#">freelance@svetaine.lt</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-area navbar-style-two">
        <div class="raque-responsive-nav">
            <div class="container">
                <div class="raque-responsive-menu">
                    <div class="logo">
                        <a href="{{route('home')}}">
                            <img src="/assets/img/black-logo.png" alt="logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="raque-nav">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <div class="collapse navbar-collapse mean-menu">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{route('home')}}">{{__('nav.home')}} <span class="sr-only">(current)</span></a>
                            </li>
                            <ul class="navbar-nav">
                                @auth
                                <li class="nav-item"><a href="#" class="nav-link">{{Auth()->user()->name}} <i class='bx bx-chevron-down'></i></a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a class="nav-link" href="{{route('user.show', Auth::id())}}">{{__('user.my_account')}}</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{route("history")}}">{{__('user.history')}}</a></li>
                                        @if(\Illuminate\Support\Facades\Auth::user()->type == 2)
                                            <li class="nav-item"><a class="nav-link" href="{{route("admin")}}">{{__('page.admin')}}</a></li>
                                        @endif
                                        <li class="nav-item"><a class="nav-link" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('user.logout')}}</a></li>
                                    </ul>
                                </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('posts.create')}}">{{__('nav.post')}}</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('login')}}">{{__('nav.login')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('register')}}">{{__('nav.register')}}</a>
                                    </li>
                                @endauth
                            </ul>
                        </ul>
                        <div class="others-option">
                            <div class="dropdown language-switcher d-inline-block">
                                <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(Session::get('user_locale') === 'lt')
                                        <img src="{{asset('img/lt.jpg')}}" class="shadow-sm" alt="flag">
                                        <span>LT</span>
                                    @else
                                        <img src="/assets/img/us-flag.jpg" class="shadow-sm" alt="flag">
                                        <span>EN</span>
                                    @endif
                                </button>
                                <div class="dropdown-menu">
                                    @if(Session::get('user_locale') === 'en')
                                        <a href="{{route('lt')}}" class="dropdown-item d-flex align-items-center">
                                            <img src="{{asset('img/lt.jpg')}}" class="shadow-sm" alt="flag">
                                            <span>LT</span>
                                        </a>
                                    @else
                                        <a href="{{route('en')}}" class="dropdown-item d-flex align-items-center">
                                            <img src="/assets/img/us-flag.jpg" class="shadow-sm" alt="flag">
                                            <span>EN</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="search-box d-inline-block">
                                <i class='bx bx-search'></i>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>


    <div class="navbar-area navbar-style-two header-sticky">
        <div class="raque-nav">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{route('home')}}">{{__('nav.home')}} <span class="sr-only">(current)</span></a>
                            </li>
                            <ul class="navbar-nav">
                                @auth
                                <li class="nav-item"><a href="#" class="nav-link">{{Auth()->user()->name}} <i class='bx bx-chevron-down'></i></a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a class="nav-link" href="{{route('user.show', Auth::id())}}">{{__('user.my_account')}}</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{route("history")}}">{{__('user.history')}}</a></li>
                                        @if(\Illuminate\Support\Facades\Auth::user()->type == 2)
                                            <li class="nav-item"><a class="nav-link" href="{{route("admin")}}">Administravimas</a></li>
                                        @endif
                                        <li class="nav-item"><a class="nav-link" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('user.logout')}}</a></li>
                                    </ul>
                                </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('posts.create')}}">{{__('nav.post')}}</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('login')}}">{{__('nav.login')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('register')}}">{{__('nav.register')}}</a>
                                    </li>
                                @endauth
                            </ul>
                        </ul>
                        <div class="others-option">
                            <div class="dropdown language-switcher d-inline-block">
                                <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(Session::get('user_locale') === 'lt')
                                        <img src="{{asset('img/lt.jpg')}}" class="shadow-sm" alt="flag">
                                        <span>LT</span>
                                    @else
                                        <img src="/assets/img/us-flag.jpg" class="shadow-sm" alt="flag">
                                        <span>EN</span>
                                    @endif
                                </button>
                                <div class="dropdown-menu">
                                    @if(Session::get('user_locale') === 'en')
                                        <a href="{{route('lt')}}" class="dropdown-item d-flex align-items-center">
                                            <img src="{{asset('img/lt.jpg')}}" class="shadow-sm" alt="flag">
                                            <span>LT</span>
                                        </a>
                                    @else
                                        <a href="{{route('en')}}" class="dropdown-item d-flex align-items-center">
                                            <img src="/assets/img/us-flag.jpg" class="shadow-sm" alt="flag">
                                            <span>EN</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="search-box d-inline-block">
                                <i class='bx bx-search'></i>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

</header>


<div class="search-overlay">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="search-overlay-layer"></div>
            <div class="search-overlay-layer"></div>
            <div class="search-overlay-layer"></div>
            <div class="search-overlay-close">
                <span class="search-overlay-close-line"></span>
                <span class="search-overlay-close-line"></span>
            </div>
            <div class="search-overlay-form">
                <form method="post" action="/search">
                    @csrf
                    <input type="text" class="input-search" name="search" placeholder="{{__('page.search')}}">
                    <button type="submit"><i class='bx bx-search-alt'></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

@yield('content')

<footer>
    <div class="footer-bottom-area">
        <div class="container">
            <div class="logo">
                <a href="{{route('home')}}" class="d-inline-block"><img src="/assets/img/logo.png" alt="image"></a>
            </div>
            <p><i class='bx bx-copyright'></i>{{date("Y")}} <a href="{{route('home')}}" target="_blank">Svetaine.LT</a> | Visos teisės saugomos.</p>
        </div>
    </div>
</footer>

<div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/popper.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/owl.carousel.min.js"></script>
<script src="/assets/js/mixitup.min.js"></script>
<script src="/assets/js/parallax.min.js"></script>
<script src="/assets/js/jquery.appear.min.js"></script>
<script src="/assets/js/odometer.min.js"></script>
<script src="/assets/js/particles.min.js"></script>
<script src="/assets/js/meanmenu.min.js"></script>
<script src="/assets/js/jquery.nice-select.min.js"></script>
<script src="/assets/js/viewer.min.js"></script>
<script src="/assets/js/slick.min.js"></script>
<script src="/assets/js/jquery.magnific-popup.min.js"></script>
<script src="/assets/js/jquery.ajaxchimp.min.js"></script>
<script src="/assets/js/form-validator.min.js"></script>
<script src="/assets/js/contact-form-script.js"></script>
<script src="/assets/js/main.js"></script>
</body>

</html>
