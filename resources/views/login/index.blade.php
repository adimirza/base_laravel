<?php

use App\Lib\GetProfilWeb;

$profil = new GetProfilWeb;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $profil->getProfil()['nama']->nama }} | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ ('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ ('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ ('assets/dist/css/adminlte.min.css') }}">
  {!! htmlScriptTagJsApi() !!}
</head>

<body class="hold-transition login-page dark-mode">
  <div class="login-box">
    <div class="login-logo">
      <!-- <a href=""><b>Jeroen</b>Template</a> -->
      <img src="{{ url('upload/image/logo/'.$profil->getProfil()['logo']->logo) }}" alt="{{ $profil->getProfil()['nama']->nama }} Logo">
      <!-- <span class="brand-text font-weight-light">{{ $profil->getProfil()['nama']->nama }}</span> -->
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        @if(session()->has('loginError'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i> Fail!</h5>
          {{ session('loginError') }}
        </div>
        @endif
        <form action="{{ url('/proses_login') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" autofocus required value="{{ old('email') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            {!! htmlFormSnippet() !!}
            @if($errors->has('g-recaptcha-response'))
              <div class="invalid-feedback">
                {{ $errors->first('g-recaptcha-response') }}
              </div>
            @endif
          </div>
          <div class="row">
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="{{ ('assets/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ ('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ ('assets/dist/js/adminlte.min.js') }}"></script>
  <script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
  </script>
</body>

</html>