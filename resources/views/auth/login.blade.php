@extends('layouts.app')

@section('title', 'Страница авторизации')

@section('content')
    <div class="bg-gray-100 h-screen flex justify-center items-center">
        <div class="bg-white shadow-md rounded-lg max-w-md w-full p-6">
            <h2 class="text-2xl font-bold text-center mb-4 text-gray-800">Авторизация</h2>

            @if(session('status'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Почта (Email)</label>
                    <input type="email" name="email" id="email"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required autofocus>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-bold mb-2">Пароль</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200 ease-in-out">
                        Войти
                    </button>
                </div>
            </form>

            <p class="mt-4 text-center text-gray-600">
                Нет аккаунта?
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Регистрация</a>
            </p>
        </div>
    </div>
@endsection
