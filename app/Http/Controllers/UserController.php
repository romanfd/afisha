<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $events = $user->events()->with('categories')->get();

        return view('users.user', compact('user', 'events'));
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

        return redirect()->route('user')->with('status', 'Ваш профиль успешно обновлён.');
    }

    public function toggleUserStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('status', 'Статус пользователя изменен.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('status', 'Пользователь удалён.');
    }
}
