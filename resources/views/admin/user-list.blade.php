<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('admin.userList') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <ul class="botUsers-list">
                    @foreach ($botUsers as $botUser)
                        <li class="botUsers-list-item">
                            <p class="botUsers-list-raw botUsers-list-id">{{ $botUser->id }}</p>
                            <p class="botUsers-list-raw botUsers-list-bot">{{ $botUser->is_bot ? 'бот' : 'человек'}}</p>
                            <p class="botUsers-list-raw botUsers-list-name">{{ $botUser->first_name }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
