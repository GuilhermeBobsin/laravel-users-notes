<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();

        return view('home', ['notes' => $notes]); 
    }

    public function newNote()
    {
        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {
        //request validade
        $request->validate([
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000'
        ],
        [
            'text_title.required' => 'O título é obrigatório', 
            'text_title.min' => 'O título deve ter pelo menos :min caracteres',
            'text_title.max' => 'O título deve ter no máximo :max caracteres',
            'text_note.required' => 'A nota é obrigatória',
            'text_note.min' => 'A nota deve ter pelo menos :min caracteres',
            'text_note.max' => 'A nota deve ter no máximo :max caracteres'
        ]
        );
        
        $id = session('user.id');

        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');
    }

    public function editNote($id)
    {
        $id = Operations::decryptId($id);
        
        //load note
        $note = Note::find($id);

        //show edit note view
        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request)
    {
        $request->validate([
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000'
        ],
        [
            'text_title.required' => 'O título é obrigatório', 
            'text_title.min' => 'O título deve ter pelo menos :min caracteres',
            'text_title.max' => 'O título deve ter no máximo :max caracteres',
            'text_note.required' => 'A nota é obrigatória',
            'text_note.min' => 'A nota deve ter pelo menos :min caracteres',
            'text_note.max' => 'A nota deve ter no máximo :max caracteres'
        ]
        );

        if($request->note_id == null)
        {
            return redirect()->route('home');
        }

        $id = Operations::decryptId($request->note_id);
        $note = Note::find($id);

        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');
    }
    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);
        
        $note = Note::find($id);
        
        return view('delete_note', ['note' => $note]);
    }
    
    public function deleteNoteConfirm($id)
    {
        $id = Operations::decryptId($id);
        $note = Note::find($id);

        $note->delete();
        return redirect()->route('home');
    }

}
