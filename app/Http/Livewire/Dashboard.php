<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Task;

class Dashboard extends Component
{
    public $tasks;

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

    protected $listeners = ['taskAdded' => 'taskAdded'];
    public function delete($taskId)
    {
        if (Auth::check()) {
            $request = Request::create("/api/task/{$taskId}", 'delete');
            $response = app()->handle($request);
            $this->emit('taskAdded');
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
                $this->emit('taskAdded');
            } elseif ($status === 1) {
                $request = Request::create(
                    "/api/task/status/{$taskId}",
                    'PUT',
                    [
                        'is_completed' => 0,
                    ]
                );
                $response = app()->handle($request);
                $this->emit('taskAdded');
            }
        } else {
            return redirect()->to('http://127.0.0.1:8000/');
        }
    }

    public function updateContent($taskId, $newContent)
    {
        if (Auth::check()) {
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
            $this->emit('taskAdded');
        } else {
            return redirect()->to('http://127.0.0.1:8000/');
        }
    }

    public function taskAdded()
    {
        // toda vez que a lista for atualizada o componente é montado novamente
        return $this->render();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
