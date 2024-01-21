@extends('layouts.app')
@section('title', 'Login')

@section('content')
    <form action="{{ route('login') }}" method="post" class="flex flex-col gap-y-8 w-11/12 md:w-4/12 mx-auto mt-24 border rounded-lg py-8 px-12 shadow-lg">
        @csrf
        <legend class="ml-auto text-2xl font-semibold">Sign In</legend>
        <label for="email">
            Email <br>
            <input class="border p-2 text-sm w-full rounded-md" type="email" placeholder="Enter your email" name="email" id="email" value="{{ old('email') }}" required >
            @error('email')
                <div class="text-xs text-red-700 font-medium">{{ $message }}</div>
            @enderror
        </label>
        <label for="password">
            Password <br>
            <input class="border p-2 text-sm w-full rounded-md" type="password" placeholder="Enter your password" name="password" id="password" value="{{ old('password') }}" required >
            @error('password')
                <div class="text-xs text-red-700 font-medium">{{ $message }}</div>
            @enderror
        </label>
        <button type="submit" class="w-full py-2 bg-blue-600 hover:bg-blue-700 transition-colors ease-in-out duration-150 text-white shadow-sm rounded-md">Login</button>
    </form>
@endsection