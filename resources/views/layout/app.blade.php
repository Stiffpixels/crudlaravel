<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <!--add this to have this styles on all pages-->
    @yield('css')
    <!--for adding additional styles-->
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
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{Auth::user()->username}}
                        </button>
                        <ul class="dropdown-menu">
                            <a class="dropdown-item" href="{{url('logout')}}"><i class="fas fa-sign-out-alt"></i>
                                Logout</a>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </header>
    <!-- Navbar Area End -->


    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @yield('scripts')
</body>

</html>
