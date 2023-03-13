<div class="container collumn tasks-group">
    <div class="row">
        @if (count($tasks) > 0)
            @foreach ($tasks as $task)
                @livewire('card', ['task' => $task], key($task['id']))
                <div class="card task">
                    <div class="card-body">
                        @if ($task['is_editing'])
                            <input id="task_{{ $task['id'] }}_content" type="text" wire:model.defer="task.content"
                                class="form-control">
                        @else
                            <h4 class="card-title">{{ $task['content'] }}</h4>
                        @endif
                        <p class="card-text {{ $task['is_completed'] ? 'text-success' : 'text-warning' }}">
                            {{ $task['is_completed'] ? 'Concluído' : 'Pendente' }}</p>
                    </div>
                    <div class="card-footer">
                        <form wire:submit.prevent wire:dirty wire:target="updateTask({{ $task['id'] }})"
                            style="display: inline;">
                            @csrf
                            @if ($task['is_editing'])
                                <button wire:click="updateContent({{ $task['id'] }}, task.content"
                                    class="btn btn-sm btn-success">
                                    Salvar
                                </button>
                                <button wire:click="isEditing({{ $task['id'] }})"
                                    class="btn btn-sm btn-secondary ml-2">
                                    Cancelar
                                </button>
                            @else
                                <button wire:click="isEditing({{ $task['id'] }})" class="btn btn-sm btn-primary">
                                    Editar
                                </button>
                            @endif
                        </form>

                        <form wire:submit.prevent style="display: inline;">
                            @csrf
                            @if ($task['is_editing'])
                                <button wire:click="isCompleted({{ $task['id'] }})"
                                    class="btn
                                btn-sm
                                {{ $task['is_completed'] ? 'btn-warning' : 'btn-success' }}"
                                    hidden>
                                    {{ $task['is_completed'] ? 'Pendente' : 'Concluído' }}
                                </button>
                            @else
                                <button wire:click="isCompleted({{ $task['id'] }})"
                                    class="btn
                                btn-sm
                                {{ $task['is_completed'] ? 'btn-warning' : 'btn-success' }}">
                                    {{ $task['is_completed'] ? 'Pendente' : 'Concluído' }}
                                </button>
                            @endif

                        </form>

                        <form wire:submit.prevent style="display:
                                inline;">
                            @csrf
                            @if ($task['is_editing'])
                                <button wire:click="delete({{ $task['id'] }})" class="btn btn-sm btn-danger"
                                    hidden>Excluir</button>
                            @else
                                <button wire:click="delete({{ $task['id'] }})"
                                    class="btn btn-sm btn-danger">Excluir</button>
                            @endif

                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <div class="alert alert-warning" role="alert">
                    Você não possui nenhuma tarefa.
                </div>
            </div>
        @endif

    </div>
</div>
