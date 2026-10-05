<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        return response()->json(Expense::with(['user', 'movie'])->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'fecha' => 'required|date',
            'monto' => 'required|numeric',
            'usuario_id' => 'required|integer',
            'pelicula_id' => 'required|integer',
        ]);

        $expense = Expense::create($request->only([
            'fecha',
            'monto',
            'usuario_id',
            'pelicula_id',
        ]));

        return response()->json([
            'message' => 'Gasto creado exitosamente',
            'expense' => $expense,
        ], 201);
    }

    public function show($id)
    {
        $expense = Expense::with(['user', 'movie'])->find($id);

        if (!$expense) {
            return response()->json(['message' => 'Gasto no encontrado'], 404);
        }

        return response()->json($expense);
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Gasto no encontrado'], 404);
        }

        $this->validate($request, [
            'fecha' => 'sometimes|date',
            'monto' => 'sometimes|numeric',
            'usuario_id' => 'sometimes|integer',
            'pelicula_id' => 'sometimes|integer',
        ]);

        $expense->update($request->only([
            'fecha',
            'monto',
            'usuario_id',
            'pelicula_id',
        ]));

        return response()->json([
            'message' => 'Gasto actualizado exitosamente',
            'expense' => $expense,
        ]);
    }

    public function destroy($id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Gasto no encontrado'], 404);
        }

        $expense->delete();

        return response()->json(['message' => 'Gasto eliminado exitosamente']);
    }
}
