@extends('layouts.app')

@section('title', 'Профиль пользователя')

@section('content')
    <div class="max-w-4xl mx-auto p-6">

        @if(session('status'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4 max-w-md mx-auto text-center">
                {{ session('status') }}
            </div>
        @endif

        <!-- Первый ряд -->
        <div class="mb-8 p-4 bg-white shadow-md rounded-lg flex justify-between items-center">
            <h1 class="text-xl font-semibold">Личный кабинет</h1>
            <div>
                <a href="{{ route('home') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Главная</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 ml-4">
                        Выход
                    </button>
                </form>
            </div>
        </div>

        @if(!$user->is_active)
            <div class="bg-red-500 text-white p-4 rounded-lg mb-4 max-w-md mx-auto text-center">
                Ваша учетная запись заблокирована. Обратитесь к администратору.
            </div>
        @else

            <!-- Второй ряд -->
            <div class="mb-8 p-4 bg-white shadow-md rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Привет, {{ $user->name }}</h2>
                <form method="POST" action="{{ route('user.update') }}">
                    @csrf
                    @method('PUT')

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

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Подтверждение
                            пароля</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="text-center">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200 ease-in-out">
                            Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>

            <!-- Третий ряд -->
            @if($events->isEmpty())
                <h2 class="text-gray-600">Вы не зарегистрированы на мероприятия</h2>
            @else
                <h2 class="text-xl font-semibold mb-4">Вы зарегистрированы на мероприятия</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <img src="{{ asset($event->image_url) }}" alt="{{ $event->title }}"
                                 class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">{{ $event->title }}</h3>
                                <p class="text-gray-600 mb-2">
                                    @foreach($event->categories as $category)
                                        {{ $category->title }}{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </p>
                                <p class="text-gray-600">{{ $event->event_date->format('d.m.Y') }}</p>
                                <form action="{{ route('events.cancel', $event->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-200 ease-in-out">
                                        Отменить регистрацию
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        @endif
    </div>
@endsection
