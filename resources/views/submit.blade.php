@extends('layouts.app')

@section('title-block')Реєстрація@endsection

@section('content')
<form class="user-hotel-form" action="{{ route('submit.create') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="container col-sm-5 py-1">
  <h3>Форма реєстрації</h3>
	
        
        	<!-- <div class="col">
        		<label for="firstName" class="form-label">Тип користувача: </label>
        	    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                    <label class="btn btn-outline-info" for="btnradio1">Гість</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                    <label class="btn btn-outline-info" for="btnradio2">Готель</label>
        	    </div>
            </div> -->
        
            <!-- <div class="form-group">
              <label for="firstName" class="form-label">Ім'я</label>
              <input type="text" class="form-control" id="firstName" placeholder="" value="" required="">
              <div class="invalid-feedback">
                Потрібно вказати дійсне ім’я.
              </div>
            </div> -->

            <!-- <div class="form-group">
              <label for="lastName" class="form-label">Прізвище</label>
              <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
              <div class="invalid-feedback">
                Потрібно вказати дійсне прізвище.
              </div>
            </div> -->

            <div class="form-group">
              <label for="name" class="form-label">Ваше ім'я</label>
              <input name="name" type="text" class="form-control" id="name">
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
              <input name="email" type="email" class="form-control" id="user-email" placeholder="you@example.com">
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

            <!-- <div class="form-group">
              <label for="srteet" class="form-label">Вулиця</label>
              <input type="text" class="form-control" id="srteet" placeholder="" value="" required="">
              <div class="invalid-feedback">
                Потрібно вказати вулицю.
              </div>
            </div>

            <div class="form-group">
              <label for="numberHouse" class="form-label">Буд.</label>
              <input type="text" class="form-control" id="numberHouse" placeholder="" value="" required="">
              <div class="invalid-feedback">
                Потрібно вказати номер будинку.
              </div>
            </div> -->

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