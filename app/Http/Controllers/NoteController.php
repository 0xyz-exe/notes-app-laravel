<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Note::query()->where('user_id', auth()->id())->active();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $notes = $query->orderBy('is_pinned', 'desc')
                       ->orderBy('updated_at', 'desc')
                       ->paginate(20)
                       ->withQueryString();

        $categories = Note::where('user_id', auth()->id())
                         ->whereNotNull('category')
                         ->distinct('category')
                         ->pluck('category');

        return view('notes.index', compact('notes', 'categories'));
    }

    public function archived()
    {
        $notes = Note::where('user_id', auth()->id())
                    ->archived()
                    ->orderBy('updated_at', 'desc')
                    ->paginate(20);

        return view('notes.archived', compact('notes'));
    }

    public function trashed()
    {
        $notes = Note::where('user_id', auth()->id())
                    ->onlyTrashed()
                    ->orderBy('deleted_at', 'desc')
                    ->paginate(20);

        return view('notes.trashed', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(NoteRequest $request)
    {
        $data = $request->validated();
        $data['tags'] = $request->filled('tags') ? explode(',', $request->tags) : [];
        
        auth()->user()->notes()->create($data);

        return redirect()->route('notes.index')->with('success', 'Note created successfully.');
    }

    public function show(Note $note)
    {
        Gate::authorize('view', $note);
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        Gate::authorize('update', $note);
        return view('notes.edit', compact('note'));
    }

    public function update(NoteRequest $request, Note $note)
    {
        Gate::authorize('update', $note);
        
        $data = $request->validated();
        $data['tags'] = $request->filled('tags') ? explode(',', $request->tags) : [];
        
        $note->update($data);

        return redirect()->route('notes.index')->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        Gate::authorize('delete', $note);
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note moved to trash.');
    }

    public function pin(Note $note)
    {
        Gate::authorize('update', $note);
        $note->update(['is_pinned' => !$note->is_pinned]);

        return back()->with('success', $note->is_pinned ? 'Note pinned.' : 'Note unpinned.');
    }

    public function archive(Note $note)
    {
        Gate::authorize('update', $note);
        $note->update(['is_archived' => true]);

        return back()->with('success', 'Note archived.');
    }

    public function unarchive(Note $note)
    {
        Gate::authorize('update', $note);
        $note->update(['is_archived' => false]);

        return redirect()->route('notes.index')->with('success', 'Note restored from archive.');
    }

    public function restore($id)
    {
        $note = Note::onlyTrashed()->findOrFail($id);
        Gate::authorize('update', $note);
        
        $note->restore();

        return back()->with('success', 'Note restored from trash.');
    }

    public function forceDelete($id)
    {
        $note = Note::onlyTrashed()->findOrFail($id);
        Gate::authorize('delete', $note);
        
        $note->forceDelete();

        return back()->with('success', 'Note permanently deleted.');
    }
}
