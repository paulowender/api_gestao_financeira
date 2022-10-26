<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;

class UsuarioController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $usuarios = Usuario::simplePaginate(10);
    return response()->json($usuarios);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreUsuarioRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreUsuarioRequest $request)
  {
    try {
      $usuario = Usuario::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password')),
      ]);

      return response()->json($usuario, 201);
    } catch (\Throwable $th) {
      return response('Falha ao criar o usuario, erro: ' . $th->getMessage(), 500);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Usuario $usuario
   * @return \Illuminate\Http\Response
   */
  public function show(Usuario $usuario)
  {
    if ($usuario) {
      return response()->json($usuario);
    }

    return response()->json([
      'message' => 'Usuário não encontrado',
    ], 404);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateUsuarioRequest  $request
   * @param  \App\Models\Usuario $usuario
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateUsuarioRequest $request, Usuario $usuario)
  {

    $updated = $usuario->update([
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'password' => bcrypt($request->input('password')),
    ]);

    if ($updated) {
      return response()->json([
        'usuario' => $usuario,
        'message' => 'Usuário atualizado com sucesso',
      ]);
    }
    return response()->json([
      'message' => 'Falha ao atualizar usuário',
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Usuario $usuario
   * @return \Illuminate\Http\Response
   */
  public function destroy(Usuario $usuario)
  {
    if ($usuario->delete()) {
      return response()->json([
        'usuario' => $usuario,
        'message' => 'Usuário ' . $usuario->name . ' excluido com sucesso',
      ]);
    }

    return response()->json([
      'message' => 'Falha ao excluir o usuário ' . $usuario->name,
    ]);
  }
}
