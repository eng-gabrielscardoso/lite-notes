<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $notes = Note::where('user_id', Auth::id())->latest('updated_at')->paginate(5);

        // $notes = Auth::user()->notes()->latest('updated_at')->paginate(6);

        $notes = Note::whereBelongsTo(Auth::user())->latest('updated_at')->paginate(6);

        return view('notes.index')->with('notes', $notes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:120',
            'content' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            Auth::user()->notes()->create([
                'public_id' => Str::uuid(),
                'user_id' => Auth::id(),
                'title' => $request->title,
                'content' => $request->content,
            ]);

            DB::commit();

            return to_route('notes.index');
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if (! $note->user->is(Auth::user())) {
            return abort(403, 'You are not allowed to access the specified note.');
        }

        return view('notes.show')->with('note', $note);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        if (! $note->user->is(Auth::user())) {
            return abort(403, 'You are not allowed to access the specified note.');
        }

        return view('notes.edit')->with('note', $note);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if (! $note->user->is(Auth::user())) {
            return abort(403, 'You are not allowed to access the specified note.');
        }

        $request->validate([
            'title' => 'required|string|max:120',
            'content' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            if (Arr::has($request, 'title')) {
                $note->title = Arr::get($request, 'title');
            }

            if (Arr::has($request, 'content')) {
                $note->content = Arr::get($request, 'content');
            }

            $note->save();

            DB::commit();

            return to_route('notes.show', $note)->with('success', 'Note updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if (! $note->user->is(Auth::user())) {
            return abort(403, 'You are not allowed to access the specified note.');
        }

        try {
            DB::transaction(function () use ($note) {
                $note->delete();
            });

            return to_route('notes.index')->with('success', 'Note deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
