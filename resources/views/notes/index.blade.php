<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('My Notes') }}</h2>
            <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                + New Note
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 flex gap-4">
                <form method="GET" class="flex gap-2 flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search notes..." class="flex-1 rounded-md border-gray-300">
                    <select name="category" class="rounded-md border-gray-300">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Filter</button>
                    <a href="{{ route('notes.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Reset</a>
                </form>
                <a href="{{ route('notes.archived') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 whitespace-nowrap">📦 Archive</a>
                <a href="{{ route('notes.trashed') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 whitespace-nowrap">🗑️ Trash</a>
            </div>

            @if($notes->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($notes as $note)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 hover:shadow-md transition {{ $note->is_pinned ? 'ring-2 ring-yellow-400' : '' }}">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-lg">
                                    @if($note->is_pinned) 📌 @endif
                                    {{ Str::limit($note->title, 40) }}
                                </h3>
                                <form action="{{ route('notes.pin', $note) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-yellow-500 hover:text-yellow-600">
                                        {{ $note->is_pinned ? '★' : '☆' }}
                                    </button>
                                </form>
                            </div>
                            
                            @if($note->content)
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($note->content, 100) }}</p>
                            @endif

                            <div class="flex flex-wrap gap-1 mb-3">
                                @if($note->category)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">{{ $note->category }}</span>
                                @endif
                                @if($note->tags)
                                    @foreach($note->tags as $tag)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">#{{ $tag }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <div class="text-xs text-gray-500 mb-3">
                                Updated {{ $note->updated_at->diffForHumans() }}
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('notes.show', $note) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">View</a>
                                <a href="{{ route('notes.edit', $note) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                                <form action="{{ route('notes.archive', $note) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-600 hover:text-gray-800 text-sm">Archive</button>
                                </form>
                                <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline" onsubmit="return confirm('Move to trash?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $notes->links() }}
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <p class="text-gray-500 mb-4">No notes found. Create your first note!</p>
                    <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        + New Note
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
