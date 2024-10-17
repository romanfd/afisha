@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <div class="container mx-auto p-4">
        @php
            $messages = ['success', 'status', 'message'];
        @endphp

        @foreach ($messages as $msg)
            @if (session($msg))
                <div class="bg-green-500 text-white p-4 rounded-lg mb-4 max-w-md mx-auto text-center">
                    {{ session($msg) }}
                </div>
            @endif
        @endforeach

        {{-- Верхний блок с поиском и авторизацией --}}
        <div class="flex justify-between items-center py-6 border-b-2 border-gray-300">
            {{-- Левая колонка: Поиск --}}
            <div class="flex space-x-4">
                <form action="{{ route('home') }}" method="GET">
                    <div class="flex items-center space-x-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Поиск по названию"
                               class="border border-gray-300 p-2 rounded-lg"/>

                        <select name="category" class="border border-gray-300 p-2 rounded-lg">
                            <option value="">Выберите категорию</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Поиск
                        </button>

                        <a href="{{ route('home') }}"
                           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            Сбросить
                        </a>
                    </div>
                </form>
            </div>

            <nav>
                <div class="container mx-auto flex justify-between items-center space-x-4">
                    @auth
                        <!-- Перенаправление на страницу в зависимости от роли -->
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin') }}"
                               class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Личный
                                кабинет</a>
                        @else
                            <a href="{{ route('user') }}"
                               class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Личный
                                кабинет</a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                                Выйти
                            </button>
                        </form>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Войти</a>
                        <a href="{{ route('register') }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Регистрация</a>
                    @endguest
                </div>
            </nav>
        </div>

        {{-- Основной блок: Карточки мероприятий --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 py-8">
            @foreach($events as $event)
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="rounded-lg mb-4">
                    <h2 class="text-xl font-semibold">{{ $event->title }}</h2>

                    <p class="text-gray-600">
                        @foreach($event->categories as $category)
                            {{ $category->title }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </p>

                    <p class="text-gray-600">{{ $event->event_date->format('d.m.Y') }}</p>

                    @auth
                        @if(!auth()->user()->is_admin && auth()->user()->is_active && !auth()->user()->events->contains($event->id))
                            <form action="{{ route('events.register', $event->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="bg-green-500 text-white px-4 py-2 rounded-lg mt-4 hover:bg-green-600">
                                    Записаться
                                </button>
                            </form>
                        @elseif(auth()->user()->events->contains($event->id) && auth()->user()->is_active)
                            <button class="bg-gray-500 text-white px-4 py-2 rounded-lg mt-4" disabled>
                                Зарегистрирован
                            </button>
                        @endif
                    @endauth
                </div>
            @endforeach
        </div>

        {{-- Пагинация --}}
        <div class="mt-6">
            {{ $events->links() }}
        </div>

    </div>
@endsection
