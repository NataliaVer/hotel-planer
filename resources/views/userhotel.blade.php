@extends('layouts.app')

@section('title-block')Особистий кабінет@endsection

@section('aside')
  @parent

  @isset($hotel)
  
  <div class="table-responsive table-lg mt-3">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Назва</th>
          <th>Дані</th>
        </tr>
      </thead>
      <tbody>
        <tr id="hotel_id">
          <td class="text-nowrap align-middle" id="{{ $hotel->hotel_id }}">Назва готелю</td>
          <td class="text-nowrap align-middle">{{ $hotel->hotel_name }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Країна</td>
          <td class="text-nowrap align-middle">{{ $hotel->country }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Місто</td>
          <td class="text-nowrap align-middle">{{ $hotel->city }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Населений пункт</td>
          <td class="text-nowrap align-middle">{{ $hotel->settlement }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Вулиця, буд.</td>
          <td class="text-nowrap align-middle">{{ $hotel->street }}, {{ $hotel->number_house }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Телефон готелю</td>
          <td class="text-nowrap align-middle">{{ $hotel->phone }}</td>
        </tr>
        <tr>
          <td class="align-middle">Додаткові послуги</td>
          <td class="text-nowrap align-middle">{{ $hotel->aditional_services }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Короткий опис готелю</td>
          <td class="align-middle">{{ $hotel->description }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Час заселення</td>
          <td class="text-nowrap align-middle">{{ $hotel->time_of_settlement }}</td>
        </tr>
        <tr>
          <td class="text-nowrap align-middle">Час виселення</td>
          <td class="text-nowrap align-middle">{{ $hotel->time_of_eviction }}</td>
        </tr>
        @foreach($photos as $photo)
        @if($photo->kind_photo == 'baground_photo')
        <tr>
          <td class="text-nowrap align-middle">Основне фото готелю</td>
          <td class="text-nowrap align-middle">
            <img src="{{ $photo->photo }}" width="60" height="60" class="img img-responsive" />
          </td>
        </tr>
        @endif
        @endforeach
        <tr>
          <td class="text-nowrap align-middle">Фото готелю</td>
          <td class="text-nowrap align-middle">
        @foreach($photos as $photo)
        @if($photo->kind_photo == 'all_photos')
            <img src="{{ $photo->photo }}" width="60" height="60" class="img img-responsive" />
        @endif
        @endforeach
          </td>
        </tr>
        <!-- <tr>
          <td class="text-nowrap align-middle">Додаткові фото</td>
          <td class="text-nowrap align-middle">{{ $hotel->time_of_eviction }}</td>
        </tr> -->
        <tr>
          <td class="text-center align-middle">
            <div class="align-top">
              <a class="btn btn-primary m-2" href="{{ route('userhotel.edit', $hotel->id) }}">Змінити</a>
            </div>
          </td>
          <td class="text-center align-middle">
             <!-- <form class="align-top" action="{{ route('userhotel.delete', $hotel->id) }}" method="post">
              @csrf
              @method('delete')
              <input type="submit" value="Видалити" class="btn btn-danger m-2">
            </form> -->
            <button class="btn btn-danger m-2 openModalForDeleteRoomOrHotel" id="openModalForDeleteRoomOrHotel" type="button" data-id="{{ $hotel->id }}" data-target="hotel">Видалити</button>
          </td>
      </tr>
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
<!-- <div><button class="btn btn-primary m-2" type="submit">Змінити</button></div> -->
<!-- <div><a class="btn btn-primary m-2" href="{{ route('userhotel.edit', $hotel->id) }}">Змінити</a></div> -->
@else

  <div><a class="btn btn-primary m-2" href="{{ route('userhotel.create') }}">Додати</a></div>

@endisset


@endsection