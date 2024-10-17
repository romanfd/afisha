<div class="mb-8 p-4 bg-white shadow-md rounded-lg flex justify-between items-center">
    <h1 class="text-xl font-semibold">Личный кабинет администратора</h1>
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
