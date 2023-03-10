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

    public function create(int $user_id, Request $request)
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

            $user = User::find($user_id);
            if (!$user) {
                // Valida se existe o usuário passado
                throw new Exception('User do not exist', 400);
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
     * Display the specified resource.
     */
    public function read(int $id)
    {
        try {
            if (!$id) {
                // Verifica se o ID foi passado corretamente
                throw new Exception('unspecified user', 404);
            }

            $user = User::find($id);
            if (!$user) {
                // Valida se existe um usuário com o id passado no parâmetro
                throw new Exception('User do not exist', 404);
            }
            return response()->json(['tasks' => $user->tasks], 200);
        } catch (Exception $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function updateStatus(Request $request, $id)
    {
        try {
            $task = Task::find($id);
            // Valida se existe uma task com o ID recebido no parâmetro
            if (!$task) {
                throw new Exception('Task do not exist', 404);
            }
            // Valida se o status da task é igual ao status passado na requisição
            if ($task->is_completed === $request->is_completed) {
                throw new Exception('The task already has this status', 400);
            }
            // Valida se a requisição possui apenas os 2 valores permitdos
            if (
                ($request->is_completed === 0) |
                ($request->is_completed === 1)
            ) {
                $task->is_completed = $request->input('is_completed');
                $task->save();

                return response()->json($task, 200);
            } else {
                throw new Exception('Invalid status value', 400);
            }
        } catch (Exception $e) {
            return response()->json(
                [
                    'error' => $e->getMessage(),
                ],
                (int) $e->getCode()
            );
        }
    }

    public function updateContent(Request $request, $id)
    {
        try {
            // Valida a requisição
            $validator = Validator::make($request->all(), [
                'content' => 'required|string',
            ]);

            $validator->setCustomMessages([
                'required' => 'Campo obrigatório.',
                'string' => 'O campo deve ser uma string.',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 404);
            }
            // Valida se existe uma task com o ID recebido
            $task = Task::find($id);
            if (!$task) {
                throw new Exception('Task do not exist', 404);
            }
            // Valida se o conteúdo da task é igual ao passado na requisição
            if ($task->content === $request->content) {
                throw new Exception('The task already has this content', 400);
            }

            $task->content = $request->input('content');
            $task->save();

            return response()->json($task, 200);
        } catch (Exception $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $task = Task::find($id);
            if (!$task) {
                throw new Exception('Task do not exist', 404);
            }
            return response()->json(Task::destroy($id), 200);
        } catch (Exception $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        }
    }
}
