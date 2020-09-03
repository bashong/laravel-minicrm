{{-- @extends('layouts.app') --}}
@extends('master')

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
      <a href="/login"><b>Mini</b>CRM</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>
    
          <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            @if ($errors)
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

            <div class="input-group mb-3">
                <input id="email" type="email" placeholder="Email Address" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
            </div>

            <div class="input-group mb-3">
                <input id="password" placeholder="*******" type="password" class="form-control" name="password" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}> 
                    <label for="remember">
                      Remember Me
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
            </div>

            <p class="mb-1">
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
            </p>
        </form>
    
        </div>
        <!-- /.login-card-body -->
      </div>
</div>
</body>
