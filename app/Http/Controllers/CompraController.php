<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Http\Requests\StoreCompraRequest;
use App\Http\Requests\UpdateCompraRequest;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compras = Compra::simplePaginate(10);
        if (count($compras) > 0) {
            return response()->json($compras);
        }

        return response()->json([
            'message' => 'Compras não encontrada',
        ], 404);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompraRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompraRequest $request)
    {
        try {
            $compra = Compra::create([
                'name' => $request->input('name'),
                'metodo' => $request->input('metodo'),
                'amount' => $request->float('amount'),
            ]);

            return response()->json($compra, 201);
        } catch (\Throwable $th) {
            return response('Falha ao criar a compra, erro: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
    {

        if ($compra) {
            return response()->json($compra);
        }

        return response()->json([
            'message' => 'Compra não encontrada',
        ], 404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompraRequest  $request
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompraRequest $request, Compra $compra)
    {

        $updated = $compra->update([
            'name' => $request->input('name'),
            'metodo' => $request->input('metodo'),
            'amount' => $request->float('amount'),
        ]);

        if ($updated) {
            return response()->json([
                'compra' => $compra,
                'message' => 'Compra atualizada com sucesso',
            ]);
        }
        return response()->json([
            'message' => 'Falha ao atualizar compra',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        if ($compra->delete()) {
            return response()->json([
                'usuario' => $compra,
                'message' => 'Compra ' . $compra->name . ' excluida com sucesso',
            ]);
        }

        return response()->json([
            'message' => 'Falha ao excluir a compra  ' . $compra->name,
        ]);
    }
}
