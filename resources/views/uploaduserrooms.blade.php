@extends('layouts.app')

@section('title-block')Особистий кабінет@endsection

@section('aside')
  @parent

  <div class="container">
    <h3>Дані про види кімнат</h3>
    <form method="post" action="{{ route('userroom.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="hotel_id" id="hotel_id" class="hidden_hotel_id" value="{{ $hotel->id }}">
    <div class="m-2 p-2">
        <label class="form-label">Назва</label>
        <input class="form-control" type="text" name="name" value="{{ old('name') }}" />
        @error('name')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Ціна</label>
        <input class="form-control" type="number" name="price" value="{{ old('price') }}" />
        @error('price')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Короткий опис кімнати</label>
        <textarea class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Зручності в кімнаті</label>
        <input class="form-control" type="text" name="amenities" value="{{ old('amenities') }}"/>
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Кількість одномісних ліжок</label>
        <input class="form-control" type="number" name="count_one_bed" value="{{ old('count_one_bed') }}"/>
        <label class="form-label">Кількість двомісних ліжок</label>
        <input class="form-control" type="number" name="count_two_bed" value="{{ old('count_two_bed') }}"/>
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Кількість таких кімнат в готелі</label>
        <input class="form-control" type="number" name="count_rooms" value="{{ old('count_rooms') }}"/>
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Фото кімнати</label>
        <input class="form-control" type="file" name="room_photos[]" id="room_photos" accept=".jpg, .jpeg, .png, .gif, .bmp" multiple />

        @error('room_photos')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

<div><button class="btn btn-primary m-2" type="submit">Зберегти</button></div>

</form>
</div>


@endsection