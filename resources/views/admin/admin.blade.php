@extends('layouts.app')

@section('title', 'Профиль администратора')

@section('content')
    <div class="max-w-4xl mx-auto p-6">

        @if(session('status'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4 max-w-md mx-auto text-center">
                {{ session('status') }}
            </div>
        @endif

        <!-- Первый ряд -->
        @include('partials.admin-account')

        <!-- Второй ряд -->
        @include('partials.admin-control')

        <!-- Третий ряд -->
        <div class="mb-8 p-4 bg-white shadow-md rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Привет, {{ $user->name }}</h2>
            <form method="POST" action="{{ route('admin.update') }}">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Имя</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if(session('name_updated'))
                        <p class="text-green-500 text-xs mt-1">{{ session('name_updated') }}</p>
                    @endif
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Почта (Email)</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if(session('email_updated'))
                        <p class="text-green-500 text-xs mt-1">{{ session('email_updated') }}</p>
                    @endif
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-bold mb-2">Пароль</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if(session('password_updated'))
                        <p class="text-green-500 text-xs mt-1">{{ session('password_updated') }}</p>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Подтверждение
                        пароля</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200 ease-in-out">
                        Сохранить изменения
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
