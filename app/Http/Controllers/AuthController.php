<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum")->only("logout");
    }

    public function login(LoginRequest $request)
    {
        $usuario = $request->input("usuario");
        $clave = $request->input("clave");

        $validarUsuario = User::query()
            ->where("usuario",$usuario)
            ->where("estado",true)
            ->first();

        if (!empty($validarUsuario) && Hash::check($clave,$validarUsuario->clave)){

            return response()->json([
                "message" => "Usuario autenticado con exito",
                "usuario" => $validarUsuario->load(["rol"]),
                "token" => $validarUsuario->createToken("TOKEN_LOGIN")->plainTextToken
            ],Response::HTTP_OK);

        }else{
            return response()->json([
                "message" => "Error credenciales no validas"
            ],Response::HTTP_NOT_FOUND);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(null,Response::HTTP_NO_CONTENT);
    }
}
