<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Http\Requests\StoreEntradaRequest;
use App\Http\Requests\UpdateEntradaRequest;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entradas = Entrada::simplePaginate(10);
        return response()->json($entradas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEntradaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEntradaRequest $request)
    {
        try {
            $usuario = Entrada::create([
                'name' => $request->input('name'),
                'amount' => $request->float('amount'),
            ]);

            return response()->json($usuario, 201);
        } catch (\Throwable $th) {
            return response('Falha ao criar a entrada, erro: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function show(Entrada $entrada)
    {
        if ($entrada) {
            return response()->json($entrada);
        }

        return response()->json([
            'message' => 'Entrada não encontrada',
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEntradaRequest  $request
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEntradaRequest $request, Entrada $entrada)
    {

        $updated = $entrada->update([
            'name' => $request->input('name'),
            'amount' => $request->float('amount'),
        ]);

        if ($updated) {
            return response()->json([
                'entrada' => $entrada,
                'message' => 'Entrada atualizada com sucesso',
            ]);
        }
        return response()->json([
            'message' => 'Falha ao atualizar entrada',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entrada $entrada)
    {
        if ($entrada->delete()) {
            return response()->json([
                'usuario' => $entrada,
                'message' => 'Entrada ' . $entrada->name . ' excluida com sucesso',
            ]);
        }

        return response()->json([
            'message' => 'Falha ao excluir a entrada ' . $entrada->name,
        ]);
    }
}
