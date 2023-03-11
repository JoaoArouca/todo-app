<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterForm extends Component
{
    public $name;
    public $email;
    public $password;
    public $remember;

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function register()
    {
        $this->validate();

        $credentials = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'remember' => $this->remember,
        ];

        $request = Request::create('/api/user', 'POST', $credentials);
        $response = app()->handle($request);

        if ($response->getStatusCode() === 201) {
            $content = json_decode($response->getContent(), true);
            $user = $content['user'];
            $token = $content['token'];
            $modelUser = User::where('email', $this->email)->first();
            info($modelUser);
            Auth::login($modelUser);

            session()->put('token', $token);
            return redirect()->to('/dashboard');
        } else {
            $this->addError('email', $response->getContent());
        }
    }

    public function render()
    {
        return view('livewire.register-form');
    }
}
