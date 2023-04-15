<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-success-badge>
                {{ session('success') }}
            </x-success-badge>
            <div class="flex mb-6 text-gray-800 dark:text-gray-200">
                <p>
                    <strong>Created at: </strong> {{ $note->created_at->diffForHumans() }}
                </p>
                <p class="ml-4">
                    <strong>Last update: </strong> {{ $note->updated_at->diffForHumans() }}
                </p>
                <a href="{{ route('notes.edit', $note) }}" class="btn ml-auto">
                    Edit note
                </a>
                <form action="{{ route('notes.destroy', $note) }}" method="post">
                    @method('delete')
                    @csrf

                    <button type="submit" class="btn btn-danger ml-4" onclick="return confirm('Have you really want to delete this note?')">Delete note</button>
                </form>
            </div>
            <div class="mb-6 p-6 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                <h2 class="font-bold text-3xl">
                    {{ $note->title }}
                </h2>
                <p class="whitespace-pre-line">
                    {{ $note->content }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
