<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

use Livewire\Component;

class LoginForm extends Component
{
    public $email;
    public $password;
    public $remember;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
            'remember' => $this->remember,
        ];

        $request = Request::create('/api/login', 'POST', $credentials);
        $response = app()->handle($request);

        if ($response->getStatusCode() === 201) {
            $content = json_decode($response->getContent(), true);
            $user = $content['user'];
            $token = $content['token'];
            $modelUser = User::where('email', $this->email)->first();

            Auth::login($modelUser);

            session()->put('token', $token);
            return redirect()->to('/dashboard');
        } else {
            $this->addError('email', $response->getContent());
        }
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}
