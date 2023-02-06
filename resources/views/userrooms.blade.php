@extends('layouts.app')

@section('title-block')Особистий кабінет@endsection

@section('aside')
  @parent

  <!-- заборонити додавати кімнати, якщо не створено готелю -->

  @isset($hotel->id)
  <div><a class="btn btn-primary m-2" href="{{ route('userroom.create') }}">Додати</a></div>
  @else
  <p class="text-danger">Щоб додати кімнати, спочатку заповніть дані свого готелю</p>
  @endisset

   @if(count($rooms)> 0)
  
  <div class="table-responsive table-lg mt-3">
    <table class="table table-bordered" id="users-table">
      <thead>
        <tr>
          <th>Назва</th>
          <th>Дані</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rooms as $room)
        <tr id="id_user">
          <td class="text-nowrap align-middle">Назва кімнати</td>
          <td class="text-nowrap align-middle">{{ $room->name }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Ціна</td>
          <td class="text-nowrap align-middle">{{ $room->price }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Опис номеру</td>
          <td class="text-nowrap align-middle">{{ $room->description }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Зручності у номері</td>
          <td class="text-nowrap align-middle">{{ $room->amenities }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Кількість ліжок</td>
          <td class="text-nowrap align-middle">{{ $room->count_one_bed > 0 ? $room->count_one_bed.' x 1' : '' }} {{ $room->count_two_bed > 0 ? $room->count_two_bed.' x 2' : '' }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Кількість кімнат цього виду</td>
          <td class="text-nowrap align-middle">{{ $room->count_rooms }}</td>
        </tr>
        <tr>
          <tr>
          <td class="text-nowrap align-middle">Фото кімнати</td>
          <td class="text-nowrap align-middle">
        @foreach($photos as $photo)
        @if($photo->kind_photo == 'room_photos' && $photo->room_id == $room->id)
            <img src="{{ $photo->photo }}" width="60" height="60" class="img img-responsive" />
        @endif
        @endforeach
          </td>
        </tr>
          <td class="text-center align-middle">
            <div class="align-top">
              <a class="btn btn-primary m-2" href="{{ route('userroom.edit', $room->id) }}">Змінити</a>
            </div>
          </td>
          <td class="text-center align-middle">
            <!-- <form class="align-top" action="{{ route('userroom.delete', $room->id) }}" method="post">
              @csrf
              @method('delete')
              <input type="submit" value="Видалити" class="btn btn-danger m-2">
            </form> -->
            <button class="btn btn-danger m-2 openModalForDeleteRoomOrHotel" id="openModalForDeleteRoomOrHotel" type="button" data-id="{{ $room->id }}" data-target="room">Видалити</button>
          </td>
      </tr>
        @endforeach
      </tbody>
  </table>
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

@endif
<!-- <div><button class="btn btn-primary m-2" type="submit">Змінити</button></div> -->

@endsection