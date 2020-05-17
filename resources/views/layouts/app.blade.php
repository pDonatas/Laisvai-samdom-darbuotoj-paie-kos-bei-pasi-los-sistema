<html>
<head>
    <title>@yield('title') :: Semestro projektas</title>
    <link rel="stylesheet" type="text/css" href="{{asset("css/bootstrap.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("css/main.css")}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{asset("js/bootstrap.js")}}" type="text/javascript"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{route('home')}}">Freelance.LT</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('home')}}">{{__('nav.home')}} <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{route('lt')}}"><img class="img-icon" src="{{asset('img/lt.jpg')}}" alt="lt" /></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('en')}}"><img class="img-icon" src="{{asset('img/en.png')}}" alt="en" /></a>
            </li>
            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth()->user()->name}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('password-change')}}">{{__('user.change_pass')}}</a>
                        <a class="dropdown-item" href="{{route("history")}}">{{__('user.history')}}</a>
                        @if(\Illuminate\Support\Facades\Auth::user()->type == 2)
                            <a class="dropdown-item" href="{{route("admin")}}">Administravimas</a>
                        @endif
                        <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('user.logout')}}</a>
                    </div>
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
        <form class="form-inline my-2 my-lg-0" action="search" method="post">
            @csrf
            <input class="form-control mr-sm-2" name="search" type="search" placeholder="{{__('page.search')}}" aria-label="{{__('page.search')}}" required>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{__('page.search')}}</button>
        </form>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @yield('content')
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
</body>
</html>
