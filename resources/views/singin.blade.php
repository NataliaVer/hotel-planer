@extends('layouts.app')

@section('title-block')Вхід@endsection

@section('content')
<div class="container text-center col-sm-4">
    
<main class="form-signin">
  <form action="{{ route('singin.login') }}" method="POST">
    @csrf
    <h1 class="h3 mb-3 fw-normal">Вхід</h1>

    <div class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Пароль</label>
    </div>

    <div class="checkbox mb-3">
      <!-- <label>
        <input type="checkbox" value="remember-me"> Запам'ятати мене
      </label> -->
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Увійти</button>
    <p class="mt-5 mb-3 text-muted"></p>
  </form>
</main>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</div>

@endsection


    
  

