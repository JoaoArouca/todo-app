<div class="card">
    <div class="card-header bg-purple text-purple">
        <h4>Faça seu Login</h4>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="login">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Seu e-mail"
                    wire:model.lazy="email">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" class="form-control" id="password" placeholder="Sua senha"
                    wire:model.lazy="password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" wire:model.lazy="remember">
                <label class="form-check-label" for="remember">Lembrar de mim</label>
            </div>
            <div class="mt-3 submit-button">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Entrar</button>
            </div>
        </form>
    </div>
    <div class="card-footer text-center">
        <p class="mb-0">Ainda não tem uma conta?</p>
        <a class="custom-link" href="{{ route('register-page') }}">Registrar</a>
    </div>
</div>
