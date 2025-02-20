@extends('layout.app')
    @section('content')
        <form action="/login" method="post">
            @csrf
            <!-- Email Address -->
            <div class="mt-4">
                <label for="username">Email</label> 
                <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="username">Password</label> 

                <input id="pw" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="ms-4">
                    Login
                </button>
            </div>
        </form>
    @endsection