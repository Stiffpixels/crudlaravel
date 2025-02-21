<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

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
      <div class="" id="navbarNav">

        <ul class="navbar-nav">

          @guest
          <li class="nav-item">
            <a class="nav-link" href="{{route('login')}}"><i class="fas fa-sign-in-alt"></i> Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('register')}}"><i class="fas fa-user-plus"></i> Register</a>
          </li>

          @endguest @auth

            @if(Auth::user()->role=="admin")
              <li class="nav-item">
                <a class="nav-link text-white" href="{{route('users')}}">Users</a>
              </li>
            @endif

            <li class="nav-item">
              <a class="text-white" href="{{route('categories')}}">Categories </a>
              <a class="text-white" href="{{route('products')}}">Products </a>
            </li>
            <li class="nav-item dropdown text-white">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{Auth::user()->username}}
              </button>
              <ul class="dropdown-menu">
                <a class="dropdown-item" href="{{url('logout')}}"><i class="fas fa-sign-out-alt"></i> Logout</a>
              </ul>
          </li>
          @endauth
        </ul>
      </div>
    </nav>
  </header>
  <!-- Navbar Area End -->


  @yield('content')

  @yield('scripts')
</body>
</html>