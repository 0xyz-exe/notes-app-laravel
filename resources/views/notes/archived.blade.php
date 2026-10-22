<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Archived Notes</h2>
            <a href="{{ route('notes.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">← Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($notes->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($notes as $note)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                            <h3 class="font-bold text-lg mb-2">{{ Str::limit($note->title, 40) }}</h3>
                            @if($note->content)
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($note->content, 100) }}</p>
                            @endif
                            <div class="flex gap-2">
                                <a href="{{ route('notes.show', $note) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">View</a>
                                <form action="{{ route('notes.unarchive', $note) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Unarchive</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $notes->links() }}</div>
            @else
                <div class="bg-white p-12 text-center rounded-lg">
                    <p class="text-gray-500">No archived notes.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
