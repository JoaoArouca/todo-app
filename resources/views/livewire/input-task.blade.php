<div class="card input-task">
    <div class="card-header">
                Adicionar Tarefa
    </div>
    <div class="card-body">
         <form wire:submit.prevent="create">
                <div class="form-group">
                    <label for="content">Descrição</label>
                    <input type="text" class="form-control" id="content" wire:model.defer="content">
                    @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                 </div>
                <div class="submit-button">
                        <button type="submit" class="btn btn-primary">Adicionar Tarefa</button>
                </div>
        </form>
    </div>
</div>
