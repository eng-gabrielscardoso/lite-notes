<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashedNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::whereBelongsTo(Auth::user())->onlyTrashed()->latest('updated_at')->paginate(6);

        return view('notes.index')->with('notes', $notes);
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
}