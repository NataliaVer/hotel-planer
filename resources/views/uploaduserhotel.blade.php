@extends('layouts.app')

@section('title-block')Ваш готель@endsection

@section('content')

<div class="container col-sm-5 max-w-2xl m-8 bg-slate-200 rounded p-4">
	<h3>Опис вашого готелю</h3>
<form method="post" action="{{ route('userhotel.store') }}" enctype="multipart/form-data">
	@csrf
	<div class="m-2 p-2">
	    <label class="form-label">Назва готелю</label>
	    <input class="form-control" type="text" name="hotel_name" value="{{ old('hotel_name') }}"/>

	    @error('hotel_name')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
	</div>
	<div class="m-2 p-2">
      <label for="country" class="form-label">Країна</label>
      <input name="country" type="text" class="form-control" id="country" value="Україна" value="{{ old('country') }}"/>

      @error('country')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
  </div>

  <div class="m-2 p-2">
      <label for="city" class="form-label">Місто</label>
      <input name="city" type="text" class="form-control" id="city" value="{{ old('city') }}"/>
      
      @error('city')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
  </div>
	<div class="m-2 p-2">
	    <label class="form-label">Місто, населений пункт</label>
	    <input class="form-control" type="text" name="settlement" value="{{ old('settlement') }}"/>

	    @error('settlement')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Вулиця</label>
	    <input class="form-control" type="text" name="street" value="{{ old('street') }}"/>

	    @error('street')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Номер будинку</label>
	    <input class="form-control" type="text" name="number_house" value="{{ old('number_house') }}" />

	    @error('number_house')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Телефон</label>
	    <input class="form-control" type="text" name="phone" value="{{ old('phone') }}"/>

	    @error('phone')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Додаткові послуги</label>
	    <input class="form-control" type="text" name="aditional_services" value="{{ old('aditional_services') }}"/>

	    @error('aditional_services')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Короткий опис готелю</label>
	    <textarea class="form-control" name="description" rows="4">{{ old('description') }}</textarea>

	    @error('description')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Час заселення</label>
	    <input class="form-control" type="time" name="time_of_settlement" value="{{ old('time_of_settlement') }}"/>

	    @error('time_of_settlement')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Час виселення</label>
	    <input class="form-control" type="time" name="time_of_eviction" value="{{ old('time_of_eviction') }}"/>

	    @error('time_of_eviction')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
	</div>
	<div class="m-2 p-2">
	    <label class="form-label">Фонове фото</label>
	    <input class="form-control" type="file" name="baground_photo" id="baground" accept=".jpg, .jpeg, .png, .gif, .bmp" />

	    @error('baground_photo')
	    <p class="text-danger">{{ $message }}</p>
	    @enderror
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