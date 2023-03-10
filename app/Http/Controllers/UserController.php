<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email')
            ->with('tasks')
            ->get();

        return response()->json($users);
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6',
                ],
                [
                    'name.required' => 'O campo nome é obrigatório.',
                    'email.required' => 'O campo e-mail é obrigatório.',
                    'email.email' => 'Por favor, informe um e-mail válido.',
                    'email.unique' =>
                        'Este e-mail já está sendo usado por outro usuário.',
                    'password.required' => 'O campo senha é obrigatório.',
                    'password.min' =>
                        'A senha deve ter pelo menos 6 caracteres.',
                ]
            );

            if ($validator->fails()) {
                throw new Exception(
                    implode(',', $validator->errors()->all()),
                    400
                ); // converte o array de mensagens de erro em uma única string separada por vírgula
            }

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
