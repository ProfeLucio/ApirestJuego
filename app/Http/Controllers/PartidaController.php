<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Partida;
use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Partida",
 *     description="Operaciones sobre el recurso Juegos"
 * )
 */
class PartidaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/partidas",
     *     tags={"Partida"},
     *     summary="Lista todas las partidas",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        // Listar todas las partidas con su juego
        return Partida::with('juego')->get();
    }

    /**
     * @OA\Post(
     *     path="/api/partidas",
     *     tags={"Partida"},
     *     summary="Crea una nueva partida",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"juego_id", "string"},
     *             @OA\Property(property="juego_id", type="string"),
     *             @OA\Property(property="fecha", type="string", format="date"),
     *             @OA\Property(property="tiempo", type="integer", format="int32", description="Tiempo en segundos"),
     *             @OA\Property(property="nivel", type="string", maxLength=100, description="Nivel de dificultad")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Creado")
     * )
     */

    public function store(Request $request)
    {
        // Validar datos de entrada
        $data = $request->validate([
            'juego_id' => 'required|exists:juegos,id',
            'fecha'    => 'required|date',
            'tiempo'   => 'nullable|integer|min:0',
            'nivel'    => 'nullable|string|max:100',
        ]);

        // Crear partida
        $partida = Partida::create($data);

        return response()->json($partida, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/partidas/{id}",
     *     tags={"Partida"},
     *     summary="Muestra una partida",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */

    public function show(Partida $partida)
    {
        // Mostrar partida con detalle de aciertos por usuario
        return $partida->load('users');
    }

    /**
     * @OA\Put(
     *     path="/api/partidas/{id}",
     *     tags={"Partida"},
     *     summary="Actualiza una partida",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"juego_id", "string"},
     *             @OA\Property(property="juego_id", type="integer"),
     *             @OA\Property(property="fecha", type="string", format="date"),
     *             @OA\Property(property="tiempo", type="integer", format="int32", description="Tiempo en segundos"),
     *             @OA\Property(property="nivel", type="string", maxLength=100, description="Nivel de dificultad")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Actualizado")
     * )
     */

    public function update(Request $request, Partida $partida)
    {
        $data = $request->validate([
            'juego_id' => 'sometimes|exists:juegos,id',
            'fecha'    => 'sometimes|date',
            'tiempo'   => 'nullable|integer|min:0',
            'nivel'    => 'nullable|string|max:100',
        ]);

        $partida->update($data);

        return response()->json($partida);
    }

    /**
     * @OA\Delete(
     *     path="/api/partidas/{id}",
     *     tags={"Partida"},
     *     summary="Elimina una partida",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="No Content")
     * )
     */
    public function destroy(Partida $partida)
    {
        $partida->delete();
        return response()->noContent();
    }
}
