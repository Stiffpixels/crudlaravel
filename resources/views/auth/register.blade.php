@extends('layout.app')
    @section('content')
        <form action="/register" method="post">
            @csrf
            <!-- User Name -->
            <div>
                <label for="username">User Name</label> 
                <input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            </div>

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

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="username">Confirm Password</label> 

                <input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="/login">
                    Already registered?
                </a>

                <button class="ms-4">
                    Register
                </button>
            </div>
        </form>
    @endsection