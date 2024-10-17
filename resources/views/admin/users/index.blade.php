@extends('layouts.app')

@section('title', 'Редактирование пользователей')

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
        <h1 class="text-2xl font-semibold mb-6">Все пользователи</h1>

        <table class="min-w-full bg-white">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Имя</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Статус</th>
                <th class="py-2 px-4 border-b">Действия</th>
                <th class="py-2 px-4 border-b"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-b">
                        {{ $user->is_active ? 'Активен' : 'Неактивен' }}
                    </td>
                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('users.toggleUserStatus', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @if($user->is_active)
                                <button type="submit"
                                        class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                                    Отключить
                                </button>
                            @else
                                <button type="submit"
                                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                    Включить
                                </button>
                            @endif


                        </form>
                    </td>

                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                              onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?');">
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
            {{ $users->links() }}
        </div>
    </div>
@endsection
