@extends('layouts.auth')

@section('auth')
    <section class="login-area">
        <div class="row m-0">
            <div class="col-lg-6 col-md-12 p-0">
                <div class="login-image">
                    <img src="assets/img/login-bg.jpg" alt="image">
                </div>
            </div>
            <div class="col-lg-6 col-md-12 p-0">
                <div class="login-content">
                    <div class="d-table">
                        <div class="d-table-cell">
                            <div class="login-form">
                                <div class="logo">
                                    <a href="{{route('home')}}"><img src="assets/img/black-logo.png" alt="image"></a>
                                </div>
                                <h3>Sveikas sugrįžęs!</h3>
                                <p>Dar nesi čia buvęs? <a href="{{route('register')}}">Užsiregistruok</a></p>
                                <form method="post" action="{{route('login')}}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('auth.E-Mail Address') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit">{{ __('auth.Login') }}</button>
                                    @if (Route::has('password.request'))
                                        <div class="forgot-password">
                                            <a href="{{ route('password.request') }}">{{ __('auth.Forgot Your Password?') }}</a>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
