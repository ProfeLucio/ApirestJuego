<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PartidaUser;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="PartidaUsuario",
 *     description="Operaciones sobre el recurso Juegos"
 * )
 */

class PartidaUserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/aciertos",
     *     tags={"PartidaUsuario"},
     *     summary="Lista todos los aciertos",
     *     @OA\Response(response=200, description="OK")
     * )
     */

    public function index()
    {
        // Listar todos los registros de aciertos, junto con usuario y partida
        return PartidaUser::with(['user', 'partida'])->get();
    }
    /**
     * @OA\Post(
     *     path="/api/aciertos",
     *     tags={"PartidaUsuario"},
     *     summary="Registra aciertos de un usuario en una partida",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"partida_id","user_id","aciertos"},
     *             @OA\Property(property="partida_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="aciertos", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Creado")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'partida_id' => 'required|exists:partidas,id',
            'user_id'    => 'required|exists:users,id',
            'aciertos'   => 'required|integer|min:0',
            'tiempo'   => 'required|integer|min:0',
            // opcionales:
            // 'errores'       => 'nullable|integer|min:0',
            // 'tiempo_jugador'=> 'nullable|integer|min:0',
        ]);

        $record = PartidaUser::create($data);

        return response()->json($record, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/aciertos/{id}",
     *     tags={"PartidaUsuario"},
     *     summary="Muestra un acierto",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */

    public function show(PartidaUser $acierto)
    {
        return $acierto->load(['user', 'partida']);
    }

    /**
     * @OA\Put(
     *     path="/api/aciertos/{id}",
     *     tags={"PartidaUsuario"},
     *     summary="Actualiza un registro de aciertos",
     *     @OA\Parameter(
     *         name="id", in="path", required=true, @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="aciertos", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Actualizado"),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function update(Request $request, PartidaUser $acierto)
    {
        $data = $request->validate([
            'aciertos'   => 'sometimes|integer|min:0',
            'tiempo'   => 'sometimes|integer|min:0',
            // 'errores'       => 'nullable|integer|min:0',
            // 'tiempo_jugador'=> 'nullable|integer|min:0',
        ]);

        $acierto->update($data);

        return response()->json($acierto->load(['user', 'partida']));
    }

    /**
     * @OA\Delete(
     *     path="/api/aciertos/{id}",
     *     tags={"PartidaUsuario"},
     *     summary="Elimina un acierto",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="No Content")
     * )
     */

    public function destroy(PartidaUser $acierto)
    {
        $acierto->delete();
        return response()->noContent();
    }
}
