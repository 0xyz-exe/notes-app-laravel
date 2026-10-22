<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Trash</h2>
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
                            <p class="text-xs text-gray-500 mb-3">Deleted {{ $note->deleted_at->diffForHumans() }}</p>
                            <div class="flex gap-2">
                                <form action="{{ route('notes.restore', $note->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Restore</button>
                                </form>
                                <form action="{{ route('notes.forceDelete', $note->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete? Cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete Forever</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $notes->links() }}</div>
            @else
                <div class="bg-white p-12 text-center rounded-lg">
                    <p class="text-gray-500">Trash is empty.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
