
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TRANSPORTS SMT | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page" style="background-image: url({{asset('dist/img/165092157_137040205088167_60158687874427769_n.jpg')}}); background-size: cover;
background-repeat: no-repeat; background-position: center;">
<div class="login-box">
  <div class="login-logo">
    {{-- <a href="{{route('dashboard')}}" class="text-white"><b>SMT</b> LOGIN</a> --}}
  </div>

  @if (session()->has('error'))
    <div class="alert alert-danger">
      <li>{{session()->get('error')}}</li>
    </div>
  @endif
  <!-- /.login-logo -->
  <div class="card bg-transparent">
    <div class="card-body login-card-body">
      <img src="{{asset('images/bagages/logo.jpg')}}" alt="" class="center mx-auto img-fluid">
      <p class="login-box-msg">Connectez-vous svp !</p>

      <form action="{{route('login')}}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="mb-2 btn btn-success btn-block">Je me connecte </button>
          </div>
          <!-- /.col -->
          <div class="col-12">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
                Se souvenir de moi
              </label>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="#forgot-password.html">Mot de passe oublié</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html
