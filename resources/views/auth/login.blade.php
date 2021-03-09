@extends('inspinia::layouts.auth')
@push('head')
    <style>
        .wrapper-login {
            background-image: url("/images/main-background.jpg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
        }
        .middle-box-login {
            background-color: #000000b8;
            padding: 30px 15px 50px;
            border-radius: 15px;
        }
        .logo-login {
            width: 100px;
            height: 100px;
        }
    </style>
@endpush
@section('content')
    <div class="wrapper-login">
        <div class="middle-box text-center loginscreen animated fadeInDown middle-box-login">
            <div>
                <div class="m-b-md">
                    <img class="logo-login" src="/images/logo-small.png" />
                    <h2 class="text-white m-t-xs"><b>warehouse<br>PPWS NGABAR</b></h2>
                </div>
              <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
               {{ csrf_field() }}
               <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" placeholder="E-Mail" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
               </div>
               <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
               </div>
               <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
              </form>
            </div>
            <div class="text-white m-t-lg">
                <h4>&copy; {{ date('Y') }} PPWS Ngabar Ponorogo</h4>
            </div>
        </div>
    </div>
@endsection
