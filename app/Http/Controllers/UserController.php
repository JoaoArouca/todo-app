<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
                throw new Exception(['errors' => $validator->errors()], 400);
            }

            $data = $request->only(['name', 'email', 'password']);
            $user = User::create($data);

            return response()->json($user, 201);
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
