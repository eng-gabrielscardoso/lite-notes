<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 p-6 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                <form action="{{ route('notes.update', $note) }}" method="POST">
                    @csrf
                    @method('put')

                    <div class="mb-6">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            placeholder="Type here the title" aria-placeholder="Type here the title" :value="@old('title', $note->title)"
                            required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="content" :value="__('Content')" />
                        <x-textarea id="content" class="block mt-1 w-full" type="text" name="content"
                            rows="10" placeholder="Type here the content" aria-placeholder="Type here the content"
                            :value="@old('content', $note->content)" required />
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <x-primary-button class="ml-3">
                        {{ __('Save note') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
