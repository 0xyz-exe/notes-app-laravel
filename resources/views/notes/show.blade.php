<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Note Details</h2>
            <a href="{{ route('notes.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">← Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 flex justify-between items-start">
                    <h1 class="text-2xl font-bold">{{ $note->title }}</h1>
                    <form action="{{ route('notes.pin', $note) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-2xl">{{ $note->is_pinned ? '📌' : '📍' }}</button>
                    </form>
                </div>

                @if($note->category || $note->tags)
                    <div class="mb-4 flex gap-2">
                        @if($note->category)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $note->category }}</span>
                        @endif
                        @if($note->tags)
                            @foreach($note->tags as $tag)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">#{{ $tag }}</span>
                            @endforeach
                        @endif
                    </div>
                @endif

                @if($note->content)
                    <div class="mb-6 prose max-w-none">
                        {{ $note->content }}
                    </div>
                @endif

                <div class="text-sm text-gray-500 mb-6 pb-6 border-b">
                    Created {{ $note->created_at->format('M d, Y g:i A') }} • Updated {{ $note->updated_at->diffForHumans() }}
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('notes.edit', $note) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Edit</a>
                    <form action="{{ route('notes.archive', $note) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Archive</button>
                    </form>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Move to trash?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
