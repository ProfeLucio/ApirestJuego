<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *     name="Usuarios",
 *     description="Operaciones de gestión de usuarios"
 * )
 */
class UserController extends Controller
{
     /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Usuarios"},
     *     summary="Lista todos los usuarios",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {

        return User::all();
    }

        /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"Usuarios"},
     *     summary="Crea un nuevo usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation","juego_id"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *             @OA\Property(property="password_confirmation", type="string", format="password"),
     *             @OA\Property(property="juego_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Creado")
     * )
     */

    public function store(Request $request)
    {
        // Validar datos de entrada
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'juego_id' => 'required|exists:juegos,id',
            // opcionales:
            // 'avatar_url' => 'nullable|url',
            // 'role'       => 'nullable|string',
        ]);

        // Hashear el password antes de guardar
        $data['password'] = Hash::make($data['password']);

        // Crear usuario
        $user = User::create($data);

        return response()->json($user, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     tags={"Usuarios"},
     *     summary="Muestra un usuario",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function show(User $user)
    {
        // Mostrar usuario específico
        return $user;
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"Usuarios"},
     *     summary="Actualiza un usuario",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *             @OA\Property(property="juego_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Actualizado")
     * )
     */

    public function update(Request $request, User $user)
    {
        // Validar campos que pueden cambiar
        $data = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'email'       => 'sometimes|email|unique:users,email,' . $user->id,
            'password'    => 'sometimes|string|min:8|confirmed',
            'juego_id'    => 'sometimes|exists:juegos,id',
            // opcionales:
            // 'avatar_url' => 'nullable|url',
            // 'role'       => 'nullable|string',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json($user);
    }
    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"Usuarios"},
     *     summary="Elimina un usuario",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="No Content")
     * )
     */
    public function destroy(User $user)
    {
        // Eliminar usuario (o usar softDeletes si está habilitado)
        $user->delete();
        return response()->noContent();
    }
}
