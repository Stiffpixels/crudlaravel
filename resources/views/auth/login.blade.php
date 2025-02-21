@extends('layout.app')
    @section('content')
        <form action="/login" method="post">
            @csrf
            <!-- Email Address -->
            <div class="mt-4">
                <label for="username">Email</label> 
                <input id="email" class="" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="username">Password</label> 

                <input id="pw" class=""
                                type="password"
                                name="password"
                                required autocomplete="new password" />
            </div>

            <div class="">
                <button class="">
                    Login
                </button>
            </div>
        </form>
    @endsection