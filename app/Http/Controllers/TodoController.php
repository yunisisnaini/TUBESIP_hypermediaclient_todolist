<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // public function index()
    // {
    //     return response()->json(Todo::with('user')->get());
    // }

    // public function show($id)
    // {
    //     $todo = Todo::with('user')->find($id);

    //     if (!$todo) {
    //         return response()->json(['message' => 'Todo not found'], 404);
    //     }

    //     return response()->json($todo);
    // }


    public function index()
    {
        // Memuat semua tugas (Todo) tanpa informasi pengguna (User)
        $todos = Todo::all();

        // Mengubah format respons JSON untuk tugas
        $formattedTodos = $todos->map(function ($todo) {
            return [
                'id' => $todo->id,
                'title' => $todo->title,
                'description' => $todo->description,
                'completed' => $todo->completed,
            ];
        });

        return response()->json($formattedTodos);
    }

    public function show($id)
    {
        // Memuat tugas (Todo) dengan ID tertentu tanpa informasi pengguna (User)
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        // Mengubah format respons JSON untuk tugas
        $formattedTodo = [
            'id' => $todo->id,
            'title' => $todo->title,
            'description' => $todo->description,
            'completed' => $todo->completed,
        ];

        return response()->json($formattedTodo);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        $todo = Todo::create($request->all());

        return response()->json($todo, 201);
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $this->validate($request, [
            'title' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        $todo->update($request->all());

        return response()->json($todo);
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $todo->delete();

        return response()->json(['message' => 'Todo deleted']);
    }
}
