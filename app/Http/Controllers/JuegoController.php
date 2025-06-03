<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Juegos",
 *     description="Operaciones de gestión de juegos"
 * )
 */

/**
 * @OA\Info(
 *     title="API de Juegos",
 *     version="1.0.0"
 * )
 * @OA\Server(url=L5_SWAGGER_CONST_HOST)
 */

class JuegoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/juegos",
     *     tags={"Juegos"},
     *     summary="Lista todos los juegos",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return Juego::all();
    }

    /**
     * @OA\Post(
     *     path="/api/juegos",
     *     tags={"Juegos"},
     *     summary="Crea un nuevo juego",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titulo","autores"},
     *             @OA\Property(property="titulo", type="string"),
     *             @OA\Property(property="autores", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Creado")
     * )
     */

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string',
            'autores'=> 'required|string',
        ]);
        return Juego::create($data);
    }

    /**
     * @OA\Get(
     *     path="/api/juegos/{id}",
     *     tags={"Juegos"},
     *     summary="Muestra un juego",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show(Juego $juego)
    {
        return $juego;
    }

     /**
     * @OA\Put(
     *     path="/api/juegos/{id}",
     *     tags={"Juegos"},
     *     summary="Actualiza un juego",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="titulo", type="string"),
     *             @OA\Property(property="autores", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Actualizado"),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function update(Request $request, Juego $juego)
    {
        $data = $request->validate([
            'titulo' => 'sometimes|string',
            'autores'=> 'sometimes|string',
        ]);
        $juego->update($data);
        return $juego;
    }
/**
     * @OA\Delete(
     *     path="/api/juegos/{id}",
     *     tags={"Juegos"},
     *     summary="Elimina un juego",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Sin contenido"),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function destroy(Juego $juego)
    {
        $juego->delete();
        return response()->noContent();
    }
}
