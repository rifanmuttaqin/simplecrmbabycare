@extends('auth.login')

@section('content')

<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
  <div class="login-brand">
    <img src="{{ URL::to('/').'/layout/assets/img/bps_logo.png' }}" alt="logo" width="200">
  </div>

  <div class="card card-primary">
    <div class="card-header"><h4>Login</h4></div>

    <div class="card-body">
    <form method="POST" action="{{ route('login') }}" class="user needs-validation" novalidate="">
      @csrf
        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
          <div class="invalid-feedback">
            Masukkan Email
          </div>
        </div>

        <div class="form-group">
          <div class="d-block">
            <label for="password" class="control-label">Password</label>
          </div>
          <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
          <div class="invalid-feedback">
            Masukkan Password
          </div>
        </div>

        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
            <label class="custom-control-label" for="remember-me">Remember Me</label>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
            Masuk
          </button>
        </div>
      </form>

      <div class="text-center p-t-12">
        @if($errors->any())
        <p style="color: red; margin-top: 20px"> {{$errors->first()}}</p>
        @endif
      </div>

    </div>
  </div>
  <div class="simple-footer">
    Copyright Al Barr Software | template &copy; Stisla 2020
  </div>
</div>

@endsection