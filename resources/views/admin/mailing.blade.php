<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('admin.mailing.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form class="admin_create-mailing_from pl-5 pb-5 pt-5 space-y-10" action="{{ route('admin.createMailing') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="mailing-name">Название рассылки</label>
                    <input class="mailing_from-name" type="text" name="name" id="mailing-name">
                    <label for="text">Текст рассылки</label>
                    <textarea class="mailing_from-text" name="text" id="text" cols="30" rows="10" placeholder="текст"></textarea>
                    <label for="mailing-date">Когда рассылать</label>
                    <input class="mailing_from-date" type="datetime-local" name="start" id="mailing-date">
                    <label for="file">Загрузить файлы</label>
                    <input class="mailing_from-file" type="file" name="mailingFile" id="file">
                    <button class="mailing_from-submit-btn mt-10 sm:mt-0 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" type="submit">
                        Отправить
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
