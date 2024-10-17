@extends('layouts.app')

@section('title', 'Редактирование мероприятий')

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
        <h1 class="text-2xl font-semibold mb-6">Все мероприятия</h1>

        <table class="min-w-full bg-white">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Название</th>
                <th class="py-2 px-4 border-b">Дата</th>
                <th class="py-2 px-4 border-b">Публикация</th>
                <th class="py-2 px-4 border-b">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $event->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $event->title }}</td>
                    <td class="py-2 px-4 border-b">{{ $event->event_date->format('d.m.Y') }}</td>
                    <td class="py-2 px-2 border-b">
                        <form action="{{ route('events.toggleEventStatus', $event->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @if($event->is_published)
                                <button type="submit"
                                        class="bg-yellow-500 text-white px-3 py-2 rounded-lg hover:bg-yellow-600">
                                    Снять с публикации
                                </button>
                            @else
                                <button type="submit"
                                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                    Опубликовать
                                </button>
                            @endif
                        </form>
                    </td>

                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                              onsubmit="return confirm('Вы уверены, что хотите удалить это мероприятие?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $events->links() }}
        </div>
    </div>
@endsection
