@extends('layouts.app')

@section('title', 'Страница авторизации')

@section('content')
    <div class="bg-gray-100 h-screen flex justify-center items-center">
        <div class="bg-white shadow-md rounded-lg max-w-lg w-full p-6">
            <h2 class="text-2xl font-bold text-center mb-4 text-gray-800">Подтвердите адрес электронной почты</h2>

            <p class="text-gray-600 mb-6 text-center">
                Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.
                Если вы не получили электронное письмо, вы можете запросить другое, нажав кнопку ниже.
            </p>

            <form method="GET" action="{{ route('verification.send') }}">
                @csrf
                <div class="text-center">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200 ease-in-out">
                        Повторно отправить электронное письмо с подтверждением
                    </button>
                </div>
            </form>

            @if (session('message') == 'verification-link-sent')
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-6">
                    <p>На адрес электронной почты, указанный вами при регистрации, была отправлена новая ссылка для
                        подтверждения.
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection

