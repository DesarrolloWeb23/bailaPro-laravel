<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Filters\UserFilter;
use App\Http\Requests\Api\V1\Store\UserStoreRequest;
use App\Http\Requests\Api\V1\Update\UserUpdateRequest;
use App\Http\Resources\Api\V1\Collections\UserCollection;
use App\Http\Resources\Api\V1\Resources\UserResource;
use App\Models\User;


class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        try {

            $filter = new UserFilter();

            $queryItems = $filter->transform($request);
            // $usuarios = Usuarios::w
            $usuarios = User::where($queryItems)->paginate();

            $usuarioResource = new UserCollection($usuarios);
            if ($usuarioResource) {
                return response()->json($usuarioResource, 200);
            } else {
                return response()->json([
                    'status' => 'Sin contenido'
                ], 204);
            }
            // return response()->json($usuarioResource, 200, [], JSON_PRETTY_PRINT);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'page not found',
            ], 400);
        }
    }

    public function store(UserStoreRequest $request)
    {
        try {

            $validateData = $request->validated();

            $filter = new UserFilter();

            $mappedData = $filter->mapAndFilter($validateData);

            $user = User::create($mappedData);

            return response()->json($user, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Ocurrió un error inesperado',
                'details' => $th->getMessage(),
            ], 500);
        }
    }


    public function update(UserUpdateRequest $request, int $id)
    {
        try {

            $validateData =   $request->validated();
            $filter = new UserFilter();

            $mappedData = $filter->mapAndFilter($validateData);

            //Recuperamos el usuario y lo actualizamos
            $user =  User::findOrFail($id);
            $user->update($mappedData);

            return new UserResource($user);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Ocurrió un error inesperado',
                'details' => $th->getMessage(),
            ], 500);
        }
    }
}
