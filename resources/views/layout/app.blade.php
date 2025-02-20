<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  <!--add this to have this styles on all pages-->
  @yield('css')
  <!--for adding additional styles-->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

  <!-- Navbar Area Start -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark @if(auth()->check()) bg-dark @else bg-info @endif">
      <a class="navbar-brand" href="{{route('dashboard')}}">Dashboard</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
           <span class="navbar-toggler-icon"></span>
       </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="{{route('dashboard')}}">Dashboard <span class="sr-only">(current)</span></a>
        </ul>

        <ul class="navbar-nav">

          @guest
          <li class="nav-item">
            <a class="nav-link" href="route('login')"><i class="fas fa-sign-in-alt"></i> Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="route('register')"><i class="fas fa-user-plus"></i> Signup</a>
          </li>

          @endguest @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i>
              {{Auth::user()->username}}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{url('dashboard')}}"><i class="far fa-id-badge"></i></i> Profile</a>
              <a class="dropdown-item" href="{{url('contactm')}}"><i class="fas fa-envelope-open-text"></i> Messages</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{url('logout')}}"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
          </li>
          @endauth
        </ul>
      </div>
    </nav>
  </header>
  <!-- Navbar Area End -->


  @yield('content')

  @stack('scripts')
</body>
</html>