@extends('layouts.app')

@section('title-block')Ваш готель@endsection

@section('content')

<div class="container col-sm-5 max-w-2xl m-8 bg-slate-200 rounded p-4">
	<h3>Змінити ваш готель</h3>
<form method="post" action="{{ route('userhotel.update', $hotel->id) }}" enctype="multipart/form-data">
	@method('patch')
	@csrf
	<div class="m-2 p-2">
	    <label class="form-label">Назва готелю</label>
	    <input class="form-control" type="text" name="hotel_name" value="{{ $hotel->hotel_name }}" />
	</div>
	<div class="m-2 p-2">
      <label for="country" class="form-label">Країна</label>
      <input name="country" type="text" class="form-control" id="country" value="{{ $hotel->country }}" required="">
      <div class="invalid-feedback">
          Виберіть вашу країну.
      </div>
  </div>

  <div class="m-2 p-2">
      <label for="city" class="form-label">Місто</label>
      <input name="city" type="text" class="form-control" id="city" value="{{ $hotel->city }}" required="">
      <div class="invalid-feedback">
          Укажіть дійсне місто.
      </div>
  </div>
	<div class="m-2 p-2">
	    <label class="form-label">Місто, населений пункт</label>
	    <input class="form-control" type="text" name="settlement" value="{{ $hotel->settlement }}"/>
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Вулиця</label>
	    <input class="form-control" type="text" name="street" value="{{ $hotel->street }}"/>
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Номер будинку</label>
	    <input class="form-control" type="text" name="number_house" value="{{ $hotel->number_house }}"/>
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Телефон</label>
	    <input class="form-control" type="text" name="phone" value="{{ $hotel->phone }}"/>
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Додаткові послуги</label>
	    <input class="form-control" type="text" name="aditional_services" value="{{ $hotel->aditional_services }}"/>
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Короткий опис готелю</label>
	    <textarea class="form-control" name="description" rows="4">{{ $hotel->description }}</textarea>
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Час заселення</label>
	    <input class="form-control" type="time" name="time_of_settlement" value="{{ $hotel->time_of_settlement }}"/>
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Час виселення</label>
	    <input class="form-control" type="time" name="time_of_eviction" value="{{ $hotel->time_of_eviction }}"/>
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Фонове фото</label>
	    <input class="form-control" type="file" name="baground_photo" id="baground" accept=".jpg, .jpeg, .png, .gif, .bmp" />
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Інші фото</label>
	    <input class="form-control" type="file" name="all_photos[]" id="all" accept=".jpg, .jpeg, .png, .gif, .bmp" multiple />
	</div>
    <div class="m-2 p-2">
	    <button class="btn btn-primary" type="submit">Зберегти</button>
    </div>
</form>
</div>


@endsection