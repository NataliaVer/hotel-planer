@extends('layouts.app')

@section('title-block')Особистий кабінет@endsection

@section('aside')
  @parent

  <h3>Змінити</h3>

  <div>
  <form class="user-hotel-form" action="{{ route('useroffice.update') }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('patch')
  <div class="form-group">
    <label for="phone" class="form-label">Телефон</label>
      <input name="phone" type="text" class="form-control" id="phone" placeholder="+380000000000" value="{{ auth()->user()->phone }}">
      @error('phone')
      <p class="text-danger">{{ $message }}</p>
      @enderror
  </div>

  <div class="form-group">
    <label for="email" class="form-label">E-mail</label>
      <input name="email" type="text" class="form-control" id="email" placeholder="you@example.com" value="{{ auth()->user()->email }}">
      @error('email')
      <p class="text-danger">{{ $message }}</p>
      @enderror
  </div>

<button class="btn btn-primary m-2" type="submit">Зберегти</button>

</form>
</div>

@endsection