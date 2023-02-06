<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title-block')</title>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="{{asset('js/app.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
	<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
</head>
<body>

	@if(!Request::is('submit', 'singin'))

      @include('includes.modal')
    @endif

	@include('includes.header')

	@if(Request::is('userbookedroom', 'useroffice', 'userhotel', 'userrooms', 'useroffice/edit', 'userhotel/create', 'userroom/create', 'userhotel/*/edit', 'userroom/*/edit'))

	  @include('includes.aside')

	@endif

    @yield('content')

    @include('includes.footer')

    <script type="text/javascript">
	 	let routeShowHotel = "{{ route('hotel.show', [':id',':dateFrom',':dateTo']) }}";
	</script>

    <script src="{{asset('js/main.js')}}"></script>

</body>
</html>
