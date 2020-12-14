<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $botUser->first_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="user-show_user-wrapper">
                    <p>Имя - {{ $botUser->last_name ?: 'не указано' }}</p>
                    <p>Фамилия - {{ $botUser->username ?: 'не указано' }}</p>
                    <p>Юзернайм в телеге - {{ $botUser->custom_username ?: 'не указано' }}</p>
                    <p>Зарегистрировался - {{ $botUser->created_at }}</p>

                    <a class="botUsers-list-link" href="{{ route('admin.block', $botUser->id) }}">
                        <b>Блокировать</b>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
