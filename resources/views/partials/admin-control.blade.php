<div class="mb-8 p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-semibold mb-4">Управление</h2>
    <div class="flex space-x-4">
        <a href="{{ route('admin') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Профиль</a>
        <a href="{{ route('admin.events') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Мероприятия</a>
        <a href="{{ route('admin.categories') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Категории</a>
        <a href="{{ route('admin.users') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Пользователи</a>
    </div>
</div>
