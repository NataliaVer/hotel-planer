@extends('layouts.app')

@section('title-block')Особистий кабінет@endsection

@section('aside')
  @parent

  <div class="container">
    <h3>Змінита кімнати</h3>
    <form method="post" action="{{ route('userroom.update', $room->id) }}" enctype="multipart/form-data">
    @method('patch')
    @csrf
    <div class="m-2 p-2">
        <label class="form-label">Назва</label>
        <input class="form-control" type="text" name="name" value="{{ $room->name }}" />
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Ціна</label>
        <input class="form-control" type="number" name="price" value="{{ $room->price }}"/>
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Короткий опис кімнати</label>
        <textarea class="form-control" name="description" rows="4">{{ $room->description }}</textarea>
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Зручності в кімнаті</label>
        <input class="form-control" type="text" name="amenities" value="{{ $room->amenities }}"/>
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Кількість одномісних ліжок</label>
        <input class="form-control" type="number" name="count_one_bed" value="{{ $room->count_one_bed }}"/>
        <label class="form-label">Кількість двомісних ліжок</label>
        <input class="form-control" type="number" name="count_two_bed" value="{{ $room->count_two_bed }}"/>
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Кількість таких кімнат в готелі</label>
        <input class="form-control" type="number" name="count_rooms" value="{{ $room->count_rooms }}"/>
    </div>
    <div class="m-2 p-2">
        <label class="form-label">Фото кімнати</label>
        <input class="form-control" type="file" name="room_photos[]" id="room_photos" accept=".jpg, .jpeg, .png, .gif, .bmp" multiple />
    </div>

<div><button class="btn btn-primary m-2" type="submit">Зберегти</button></div>

</form>
</div>


@endsection