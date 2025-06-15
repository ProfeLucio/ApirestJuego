<?php

namespace App\Http\Controllers;

use App\Models\PartidaUser;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="PartidaUsuario",
 *     description="Operaciones sobre la relación de usuarios en partidas"
 * )
 */
class PartidaUserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/aciertos",
     *     tags={"PartidaUsuario"},
     *     summary="Lista todos los registros de participación en partidas",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return PartidaUser::with(['user', 'partida'])->get();
    }

    /**
     * @OA\Post(
     *     path="/api/aciertos",
     *     tags={"PartidaUsuario"},
     *     summary="Registra participación de un usuario en una partida",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"partida_id", "user_id", "aciertos", "tiempo"},
     *             @OA\Property(property="partida_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=5),
     *             @OA\Property(property="aciertos", type="integer", example=7),
     *             @OA\Property(property="tiempo", type="integer", example=120)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Registro creado")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'partida_id' => 'required|exists:partidas,id',
            'user_id'    => 'required|exists:users,id',
            'aciertos'   => 'required|integer|min:0',
            'tiempo'     => 'required|integer|min:0',
        ]);

        $record = PartidaUser::create($data);

        return response()->json($record, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/aciertos/{id}",
     *     tags={"PartidaUsuario"},
     *     summary="Obtiene los datos de participación por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="No encontrado")
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
     *     summary="Actualiza un registro de participación",
     *     @OA\Parameter(
     *         name="id", in="path", required=true, @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="aciertos", type="integer", example=8),
     *             @OA\Property(property="tiempo", type="integer", example=115)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Actualizado correctamente"),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function update(Request $request, PartidaUser $acierto)
    {
        $data = $request->validate([
            'aciertos' => 'sometimes|integer|min:0',
            'tiempo'   => 'sometimes|integer|min:0',
        ]);

        $acierto->update($data);

        return response()->json($acierto->load(['user', 'partida']));
    }

    /**
     * @OA\Delete(
     *     path="/api/aciertos/{id}",
     *     tags={"PartidaUsuario"},
     *     summary="Elimina un registro de participación",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Eliminado correctamente")
     * )
     */
    public function destroy(PartidaUser $acierto)
    {
        $acierto->delete();
        return response()->noContent();
    }

    /**
     * @OA\Get(
     *     path="/api/aciertos/partida/{partida_id}",
     *     tags={"PartidaUsuario"},
     *     summary="Obtiene los registros por ID de partida",
     *     @OA\Parameter(name="partida_id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function porPartida($partida_id)
    {
        $datos = PartidaUser::where('partida_id', $partida_id)
            ->with(['user', 'partida'])
            ->get();

        return response()->json($datos);
    }

    /**
     * @OA\Get(
     *     path="/api/aciertos/usuario/{user_id}",
     *     tags={"PartidaUsuario"},
     *     summary="Obtiene los registros por ID de usuario",
     *     @OA\Parameter(name="user_id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function porUsuario($user_id)
    {
        $datos = PartidaUser::where('user_id', $user_id)
            ->with(['user', 'partida'])
            ->get();

        return response()->json($datos);
    }

    /**
     * @OA\Get(
     *     path="/api/aciertos/usuario/{user_id}/partida/{partida_id}",
     *     tags={"PartidaUsuario"},
     *     summary="Obtiene el registro por usuario y partida",
     *     @OA\Parameter(name="user_id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="partida_id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function porUsuarioYPartida($user_id, $partida_id)
    {
        $registro = PartidaUser::where('user_id', $user_id)
            ->where('partida_id', $partida_id)
            ->with(['user', 'partida'])
            ->first();

        if (!$registro) {
            return response()->json(['mensaje' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }
}
