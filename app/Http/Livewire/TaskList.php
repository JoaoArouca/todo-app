<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Task;

class TaskList extends Component
{
    public $tasks;
    public $updateContent;
    protected $listeners = ['taskUpdate'];

    public function mount()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $request = Request::create("/api/task/{$user_id}", 'GET');
            $response = app()->handle($request);
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getContent(), true);
                $this->tasks = $data['tasks'];
            }
        } else {
            $this->tasks = ['Você não possui nenhuma tarefa.'];
        }
    }

    public function delete($taskId)
    {
        if (Auth::check()) {
            $request = Request::create("/api/task/{$taskId}", 'delete');
            $response = app()->handle($request);
            $this->emit('taskUpdate');
        } else {
            return redirect()->to('http://127.0.0.1:8000/');
        }
    }

    public function isCompleted($taskId)
    {
        if (Auth::check()) {
            $task = Task::where('id', $taskId)->first();
            $status = $task->is_completed;
            if ($status === 0) {
                $request = Request::create(
                    "/api/task/status/{$taskId}",
                    'PUT',
                    [
                        'is_completed' => 1,
                    ]
                );
                $response = app()->handle($request);
                $this->emit('taskUpdate');
            } elseif ($status === 1) {
                $request = Request::create(
                    "/api/task/status/{$taskId}",
                    'PUT',
                    [
                        'is_completed' => 0,
                    ]
                );
                $response = app()->handle($request);
                $this->updateContent = '';
                $this->emit('taskUpdate');
            }
        } else {
            return redirect()->to('http://127.0.0.1:8000/');
        }
    }

    public function updateContent($taskId)
    {
        if (Auth::check()) {
            $newContent = $this->updateContent;
            $task = Task::where('id', $taskId)->first();
            $request = Request::create("/api/task/content/{$taskId}", 'PUT', [
                'content' => $newContent,
            ]);
            $response = app()->handle($request);
            $this->isEditing($taskId);
            $this->emit('taskUpdate');
        } else {
            return redirect()->to('http://127.0.0.1:8000/');
        }
    }

    public function isEditing($taskId)
    {
        if (Auth::check()) {
            $task = Task::find($taskId);
            $isEditing = $task->is_editing;
            $newEditing = $isEditing === 0 ? 1 : 0;
            $task->is_editing = $newEditing;
            $task->save();
            $this->emit('taskUpdate');
        } else {
            return redirect()->to('http://127.0.0.1:8000/');
        }
    }

    public function taskUpdate()
    {
        $this->mount();
    }

    public function render()
    {
        return view('livewire.task-list');
    }
}
