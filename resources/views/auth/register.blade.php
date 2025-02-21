@extends('layout.app')
    @section('content')
        <form action="/register" method="post">
            @csrf
            <!-- User Name -->
            <div>
                <label for="username">User Name</label> 
                <input id="username" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="username">Email</label> 
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="username">Password</label> 

                <input id="pw"
                                type="password"
                                name="password"
                                required autocomplete="new password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation">Confirm Password</label> 

                <input id="password_confirmation"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            </div>

            <div >
                <a  href="/login">
                    Already registered?
                </a>

                <button >
                    Register
                </button>
            </div>
        </form>
    @endsection