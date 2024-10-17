@extends('layouts.app')

@section('title', 'Редактирование категорий')

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
        <h1 class="text-2xl font-semibold mb-6">Все категории</h1>

        <table class="min-w-full bg-white">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Название</th>
                <th class="py-2 px-4 border-b">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $category->id }}</td>
                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="text" name="title" value="{{ old('title', $category->title) }}"
                                   class="border border-gray-300 rounded px-2 py-1" required>
                            <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 ml-2">
                                Изменить
                            </button>
                        </form>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
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
            {{ $categories->links() }}
        </div>
    </div>
@endsection
