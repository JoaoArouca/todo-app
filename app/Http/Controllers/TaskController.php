<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create(User $user, Request $request)
    {
        try {
            // Valida a requisição recebida
            $validator = Validator::make($request->all(), [
                'content' => 'required|string',
            ]);

            $validator->setCustomMessages([
                'required' => 'Campo obrigatório.',
                'string' => 'O campo deve ser uma string.',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }

            $validated_user = User::find($user->id);
            if (!$validated_user) {
                // Valida se existe o usuário passado
                throw new Exception('User do not exist', 404);
            }

            $task = $user->tasks()->create($validator->validated());
            return response()->json($task, 201);
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
