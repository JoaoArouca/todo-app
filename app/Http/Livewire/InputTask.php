<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Livewire\Component;

class InputTask extends Component
{
    public $content;

    protected $rules = [
        'content' => 'required|string',
    ];

    public function create()
    {
        $this->validate();

        $credential = [
            'content' => $this->content,
        ];

        $user_id = Auth::user()->id;

        $request = Request::create("/api/task/{$user_id}", 'POST', $credential);
        $response = app()->handle($request);

        $this->content = '';
        $this->emit('taskUpdate');
    }

    public function render()
    {
        return view('livewire.input-task');
    }
}
