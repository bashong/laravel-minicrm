@extends('master')
<body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/login"><b>Mini</b>CRM</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Reset Password</p>

        <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">


            @if ($errors->has('email'))
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

            <div class="input-group mb-3">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
            </div>

            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
    
    
    </body>
