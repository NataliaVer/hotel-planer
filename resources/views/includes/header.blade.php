<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 border-bottom">

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/" class="nav-link px-2 link-secondary">Головна</a></li>
        <li><a href="/news" class="nav-link px-2 link-dark">Новини</a></li>
        <li><a href="/about" class="nav-link px-2 link-dark">Про нас</a></li>
      </ul>

      <div class="col-md-3 text-end">
        @guest
          <a href="{{ route('submit') }}" class="btn btn-outline-primary me-2">Реєстрація</a>
          <a href="{{ route('singin') }}" class="btn btn-primary">Увійти</a>
        @else
          <a class="btn btn-primary" href="{{ route('useroffice') }}">{{ auth()->user()->name }}</a>
          <a class="btn btn-primary" href="{{ route('logout') }}">Вихід</a>
        @endguest
      </div>
    </header>
  </div>