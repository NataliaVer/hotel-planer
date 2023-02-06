@extends('layouts.app')

@section('title-block')Особистий кабінет@endsection

@section('aside')
  @parent

  <h6>Привіт, {{ auth()->user()->name }}! Тут ти можеш додати свій готель та налаштувати види кімнат.</h6>
  
  <div class="table-responsive table-lg mt-3">
    <table class="table table-bordered" id="users-table">
      <thead>
        <tr>
          <th>Назва</th>
          <th>Дані</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-nowrap align-middle">Телефон</td>
          <td class="text-nowrap align-middle">{{ auth()->user()->phone }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Електронна пошта</td>
          <td class="text-nowrap align-middle">{{ auth()->user()->email }}</td>
        </tr>
      </tbody>
  </table>
</div>
<a class="btn btn-primary m-2" href="{{ route('useroffice.edit') }}">Змінити</a>
<button type="button" class="btn btn-info ModalChangePass" id="ModalChangePass">Змінити пароль</button>


<!-- або буде кнопка додати -->

<!-- Сторінка з кімнатами і бобов'язкова кнопка додати -->




@endsection