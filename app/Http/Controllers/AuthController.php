<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthManager;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $fields = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            $user = User::where('email', $fields['email'])->first();

            if (!$user || !Hash::check($fields['password'], $user->password)) {
                throw new Exception('Email ou Senha inválidos', 404);
            }

            $token = $user->createToken($request->email)->plainTextToken;

            return response()->json(
                [
                    'user' => $user,
                    'token' => $token,
                ],
                201
            );
        } catch (Exception $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        }
    }

    protected $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    public function logout(Request $request)
    {
        $this->auth
            ->guard('sanctum')
            ->user()
            ->tokens()
            ->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }
}
