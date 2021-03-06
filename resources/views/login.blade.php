@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-5 col-lg-6 col-xl-4 px-lg-6 my-5">

      <!-- Heading -->
      <h1 class="display-4 text-center mb-3">
        Авторизация
      </h1>

      <!-- Subheading -->
      <p class="text-muted text-center mb-5">
        Вход в панель управления
      </p>

      <!-- Form -->
      <form action="/login" method="post">
        {{csrf_field()}}
        <!-- Email address -->
        <div class="form-group">

          <!-- Label -->
          <label>Адрес почты</label>

          <!-- Input -->
          <input type="email" class="form-control" name="email" placeholder="имя@адрес.ком">

        </div>

        <!-- Password -->
        <div class="form-group">

          <div class="row">
            <div class="col">

              <!-- Label -->
              <label>Пароль</label>

            </div>
          </div> <!-- / .row -->

          <!-- Input group -->
          <div class="input-group">
            <!-- Input -->
            <input type="password" class="form-control form-control-appended" name="password" placeholder="Введите пароль">
          </div>
        </div>

        <!-- Submit -->
        <button class="btn btn-lg btn-block btn-primary mb-3">
          Войти
        </button>

      </form>

    </div>
    <div class="col-12 col-md-7 col-lg-6 col-xl-8 d-none d-lg-block">

      <!-- Image -->
      <div class="bg-cover vh-100 mt-n1 mr-n3" style="background-image: url(assets/img/covers/auth-side-cover.jpg);"></div>

    </div>
  </div> <!-- / .row -->
</div>
@endsection
