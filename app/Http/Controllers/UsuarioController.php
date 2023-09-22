<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Interfaces\UsuarioRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuarioController extends Controller
{
    protected $usuarioRepository;
    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function index(Request $request)
    {
        return response()->json([
            "usuario" => $this->usuarioRepository->todosLosUsuarios($request->all())
        ],Response::HTTP_OK);
    }

    public function store(UsuarioRequest $request)
    {
        return response()->json([
            "usuario" => $this->usuarioRepository->crearUsuario($request->all())
        ],Response::HTTP_CREATED);
    }

    public function show(Request $request,$id)
    {
        return response()->json([
            "usuario" => $this->usuarioRepository->usuarioPorId($id)
        ],Response::HTTP_OK);
    }

    public function update(UsuarioRequest $request,$id)
    {
        return response()->json([
            "usuario" => $this->usuarioRepository->modificarUsuario($id,$request->all())
        ],Response::HTTP_OK);
    }

    public function destroy(Request $request,$id)
    {
        return response()->json([
            "usuario" => $this->usuarioRepository->eliminarUsuario($id)
        ],Response::HTTP_NO_CONTENT);
    }
}
