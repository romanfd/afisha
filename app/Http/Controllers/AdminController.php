<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('admin.admin', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.auth()->id()],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Имя является обязательным.',
            'email.required' => 'Почта является обязательной.',
            'email.email' => 'Введите действительный email адрес.',
            'email.unique' => 'Такой email уже зарегистрирован.',
            'password.min' => 'Пароль должен быть не менее 8 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);

        $user = auth()->user();

        if ($request->name !== $user->name) {
            $user->name = $request->name;
            session()->flash('name_updated', 'Имя успешно изменено.');
        }

        if ($request->email !== $user->email) {
            $user->email = $request->email;
            session()->flash('email_updated', 'Почта успешна изменена.');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            session()->flash('password_updated', 'Пароль успешно изменён.');
        }

        $user->save();

        return redirect()->route('admin')->with('status', 'Ваш профиль успешно обновлён.');
    }


    // Ссылка на управление мероприятиями
    public function events()
    {
        $events = Event::orderBy('id', 'asc')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    // Ссылка на управление категориями
    public function categories()
    {
        $categories = Category::orderBy('id', 'asc')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    // Ссылка на управление пользователями
    public function users()
    {
        $users = User::orderBy('id', 'asc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }
}
