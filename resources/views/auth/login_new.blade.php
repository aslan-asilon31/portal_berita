@extends('layouts/auth_layout')

@section('title','Login')
@section('content')

<img class="wave" src="{{asset('auth-page/img/wave-purple.svg')}}">
    <div class="container">
        <div class="img">
            <img src="{{asset('auth-page/img/auth-3d-purple/1.png')}}">
        </div>
        <div class="login-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h2>@yield('title')</h2>
                <p>Welcome !</p>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <input class="input form-control @error('email') is-invalid @enderror" id="email" type="email" placeholder="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-div two">
                    <div class="i">
                        <i class="fas fa-key"></i>
                    </div>
                    <div>
                        <input class="input form-control @error('password') is-invalid @enderror" type="password" placeholder="password" id="password" name="password" required autocomplete="current-password">
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <input type="submit" class="btn" value="Login">
                <a class="forgot" href="registration">Don't have an acount ? , Click here to Register</a>
                <div class="others">
                    <hr>
                    <p>OR</p>
                    <hr>
                </div>
                <div class="social" hidden>
                    <div class="social-icons google">
                        <a href="#"><img src="img/3d-icon/3d-icon-gmail.png">Login with Google</a>
                    </div>
                    <div class="social-icons facebook">
                        <a href="#"><img src="img/3d-icon/3d-icon-facebook.png">Login with Facebook</a>
                    </div>
                    <div class="social-icons github">
                        <a href="#"><img src="img/3d-icon/3d-icon-github.png">Login with Github</a>
                    </div>
                    <div class="social-icons twitter">
                        <a href="#"><img src="img/3d-icon/3d-icon-twitter.png">Login with Twitter</a>
                    </div>
                    <div class="social-icons discord">
                        <a href="#"><img src="img/3d-icon/3d-icon-discord.png">Login with Discord</a>
                    </div>
                </div>
                <div class="account">
                    <p>Forgot Password ?</p>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                        Click Here
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

@endsection