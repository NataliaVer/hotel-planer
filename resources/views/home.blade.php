@extends('layouts.app')

@section('title-block')Головна@endsection

@section('content')
<div class="position-relative">
	<h1 class="display-4 fw-bolder fst-italic">ПОДОРОЖУЙ РАЗОМ З НАМИ</h1>
    <img src="/img/border_view.jpg" alt="...">
</div>

<div class="container">
<form method="post" class="row">
	@csrf
    <div class="row wrapper">
    <div class="form-group col-md-6">
        <label for="city">Місто</label>
        <input type="text" class="form-control searchCity" id="searchCity" list="searchCityList" autocomplete="off">
        <datalist id="searchCityList">
            <!-- <option value="Суми"><b>Суми</b></option> -->
        </datalist>
    </div>
    <div class="form-group col-md-2">
        <label for="dateFromHome">Дата з</label>
        <input type="date" class="form-control" id="dateFromHome">
    </div>
    <div class="form-group col-md-2">
        <label for="dateToHome">Дата до</label>
        <input type="date" class="form-control" id="dateToHome">
    </div>
    <div class="form-group col-md-2" style="display: none;">
        <label for="count">Дорослих</label>
        <input type="number" class="form-control" id="count_adult">
    </div>
    <div class="form-group col-md-2" style="display: none;">
        <label for="count">Дітей</label>
        <input type="number" class="form-control" id="count_children">
    </div>
    <div class="form-group col-md-2">
        <label for="count"></label>
        <button class="w-100 btn btn-primary searchHotels" type="button" id="searchHotels">Знайти</button>
    </div>
    </div>
</form>
</div>

<!-- Тут будуть результати пошуку -->
<div class="container pt-3" id="seachResult">
</div>

@endsection
