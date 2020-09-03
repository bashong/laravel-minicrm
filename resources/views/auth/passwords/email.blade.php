@extends('master')

<body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/login"><b>Mini</b>CRM</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    
        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

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
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
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

