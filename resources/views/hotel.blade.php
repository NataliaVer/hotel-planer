@extends('layouts.app')

@section('title-block'){{ $hotel->hotel_name }}@endsection

@section('content')

<div class="container">
  <div class="col-lg-12 d-flex justify-content-center">
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
  	<?php $active = 'active' ?>
  	@foreach($photos as $photo)
  	@if($photo->kind_photo == 'all_photos')
    <div class="carousel-item {{ $active }}">
      <div class="d-flex justify-content-center">
      <img src="{{ $photo->photo }}" class="d-block" alt="...">
    </div>
    </div>
    <?php $active = '' ?>
    @endif
    @endforeach
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
</div>
</div>

<div class="container pt-3 col-md-7">

  <div class="card text-center">
  <div class="card-header">
    {{ $hotel->hotel_name }}
  </div>
  <div class="card-body">
    <h5 class="card-title">{{ $hotel->city }}, {{ $hotel->settlement }}, {{ $hotel->street }}, {{ $hotel->number_house }}</h5>
    <p class="card-text">{{ $hotel->description }}</p>
    <p class="card-text">Додаткові послуги: {{ $hotel->aditional_services }}</p>
    <p class="card-text">Час заселення: {{ $hotel->time_of_settlement }} Час виїзду: {{ $hotel->time_of_eviction }}</p>
  </div>
  <div class="card-footer text-muted">
    Зателефонуйте нам: {{ $hotel->phone }}
  </div>
</div>

</div>

<form method="post">
	@csrf
<div class="container alert alert-info col-md-8 my-3" role="alert">
<div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text" id="">Оберіть дати проживання, щоб переглянути ціни і номери:</span>
  </div>
  <input type="hidden" name="hotel_id" id="hotel_id" class="hidden_hotel_id" value="{{ $hotel->id }}">
  <input type="date" class="form-control" id="dateFromHome" min="{{ date('Y-m-d') }}" value="{{$dateFrom}}">
  <input type="date" class="form-control" id="dateToHome" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{$dateTo}}">
</div>
</div>
</form>

<?php $count_days = date_diff(new DateTime($dateFrom), new DateTime($dateTo))->d ?>

<div class="container">
	<h6 style="text-align: center">Ціни, номери</h6>
  <div class="room-cards" id="room-cards">
	@foreach($rooms as $room)
  @if($room->count_rooms-$room->booked_rooms_count>0)
	<div class="card mb-3" style="max-width: 540px;">
  <div class="row g-0">
  	@foreach($photos as $photo)
  	@if($photo->room_id == $room->id)
    <div class="col-md-4">
      <img src="{{ $photo->photo }}" class="img-fluid rounded-start" id="photo_room_{{ $room->id }}" alt="{{ $room->id }}">
    </div>
    @endif
    @endforeach
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">{{ $room->name }}</h5>
        <p class="card-text">{{ $room->description }}</p>
        <p class="card-text"><small class="text-muted">Зручності в номері: {{ $room->amenities }}</small></p>
        <p class="card-text">Ціна: {{ $room->price * $count_days }} за {{$count_days." ".(substr($count_days,-1)==1&&$count_days!=11?"ніч":(in_array(substr($count_days,-1),[5,6,7,8,9])||($count_days>4&&$count_days<21)?"ночей":"ночі"))}}</p>
        <p class="card-text">Кількість спальних місць:{{ $room->count_one_bed }}</p>
        <button class="btn btn-primary openBookModal" type="button" data-id="{{ $room->id }}">Забронювати</button>
      </div>
    </div>
  </div>
</div>
@endif
@endforeach
</div>
</div>
@endsection