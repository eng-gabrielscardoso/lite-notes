<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ request()->routeIs('notes.index') ? __('Notes') : __('Trash') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-danger-badge>
                {{ session('success') }}
            </x-danger-badge>

            @if(request()->routeIs('notes.index'))
                <a href="{{ route('notes.create') }}" class="btn btn-lg mb-6">
                    New note
                </a>
            @endif

            @forelse ($notes as $note)
                <div class="mb-6 p-6 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                    <h2 class="font-bold text-2xl">
                        @if(request()->routeIs('notes.index'))
                            <a href="{{ route('notes.show', $note->public_id )}}">{{ $note->title }}</a>
                        @else
                            <a href="{{ route('trash.show', $note->public_id )}}">{{ $note->title }}</a>
                        @endif
                    </h2>
                    <p class="mt-2">
                        {{ Str::limit($note->content, 255) }}
                    </p>
                    <span class="block mt-4 text-sm opacity-70">
                        {{ $note->updated_at->diffForHumans() }}
                    </span>
                </div>
            @empty
            @if(request()->routeIs('notes.index'))
                <p class="text-gray-800 dark:text-gray-200">
                    You have no notes yet.
                </p>
            @else
            <p class="text-gray-800 dark:text-gray-200">
                No items in trash yet.
            </p>
            @endif
            @endforelse

            {{ $notes->links() }}
        </div>
    </div>
</x-app-layout>
