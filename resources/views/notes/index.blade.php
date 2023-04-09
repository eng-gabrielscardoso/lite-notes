<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('notes.create') }}" class="btn btn-lg mb-6">
                New note
            </a>

            @forelse ($notes as $note)
                <div class="mb-6 p-6 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                    <h2 class="font-bold text-2xl">
                        <a href="{{ route('notes.show', $note->id )}}">{{ $note->title }}</a>
                    </h2>
                    <p class="mt-2">
                        {{ Str::limit($note->content, 255) }}
                    </p>
                    <span class="block mt-4 text-sm opacity-70">
                        {{ $note->updated_at->diffForHumans() }}
                    </span>
                </div>
            @empty
                <p class="text-gray-800 dark:text-gray-200">
                    You have no notes yet.
                </p>
            @endforelse

            {{ $notes->links() }}
        </div>
    </div>
</x-app-layout>
