@extends('layouts.app')

@section('title-block')Особистий кабінет@endsection

@section('aside')
  @parent

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<form method="post" class="row">
    @csrf
<div class="mb-3">
    <label for="daterange" class="form-label">Період бронювання: </label>
    <input type="text" name="daterange" value="{{ date('m/d/Y', strtotime('-10 days')) }} - {{ date('m/d/Y', strtotime('+10 days')) }}" />
</div>
</form>

<form method="post" class="row">
@csrf
@if(count($rooms)> 0)
<button type="button" class="btn btn-primary mb-3 openModalForChange" id="openModalForChange" data-id="" data-target="add">Створити бронювання</button>
@else
<p class="text-danger">Щоб створювати резервування, спочатку заповніть кімнати</p>
@endif
<div class="container" id="card-booked-room">
  <!-- <div class="card mb-3">
  <h5 class="card-header">Featured</h5>
  <div class="card-body">
    <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> 
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div> -->
</div>
</form>

<!-- <div><button class="btn btn-primary m-2" type="submit">Змінити</button></div> -->

@endsection