@extends('layouts.app')

@section('title-block')Реєстрація@endsection

@section('content')
<form class="user-hotel-form" action="{{ route('submit.create') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="container col-sm-5 py-1">
  <h3>Форма реєстрації</h3>

            <div class="form-group">
              <label for="name" class="form-label">Ваше ім'я</label>
              <input name="name" type="text" class="form-control" id="name" value="{{ old('name') }}">
              <div class="invalid-feedback">
                Потрібно вказати дійсне ім'я.
              </div>
            </div>

            <div class="form-group">
              <label for="phone" class="form-label">Телефон</label>
              <input name="phone" type="text" class="form-control" id="user-phone" placeholder="+380000000000" value="+380">
              <div class="invalid-feedback">
                Потрібно вказати дійсний номер телефону.
              </div>
            </div>

            <div class="form-group">
              <label for="email" class="form-label">E-mail</label>
              <input name="email" type="email" class="form-control" id="user-email" placeholder="you@example.com" value="{{ old('email') }}">
              <div class="invalid-feedback">
                Введіть корректний email.
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="form-label">Пароль</label>
              <input name="password" type="password" class="form-control" id="password" placeholder="" value="">
              <div class="invalid-feedback">
                Потрібно вказати пароль.
              </div>
            </div>

            <div class="form-group">
              <label for="password_confirmation" class="form-label">Повторіть пароль</label>
              <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="" value="">
              <div class="invalid-feedback">
                Паролі не співпадають.
              </div>
            </div>

            <button class="btn btn-primary m-2" type="submit">Зберегти</button>

        </div>

</form>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection