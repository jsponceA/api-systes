<?php

namespace App\Repositories;

use App\Interfaces\UsuarioRepositoryInterface;
use App\Models\User;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    protected $user;

    public function todosLosUsuarios(array $params)
    {
        $buscar = $params["buscar"] ?? null;
        $cantidadRegistros = $params["cantidadRegistros"] ?? null;
        $pagina = $params["pagina"] ?? null;

        $usuarios = User::query()
            ->when(!empty($buscar),function ($query) use ($buscar){
                $query->where("usuario","ILIKE","%".$buscar."%");
            })
            ->paginate($cantidadRegistros,"*","page",$pagina);

        return $usuarios;
    }

    public function usuarioPorId(int $id)
    {
        $usuario = User::query()->findOrFail($id);
        return $usuario;
    }

    public function crearUsuario(array $data)
    {
        $usuario = User::query()->create($data);
        return $usuario;
    }

    public function modificarUsuario(int $id, array $newData)
    {
        $usuario = User::query()->findOrFail($id)->update($newData);
        return $usuario;
    }

    public function eliminarUsuario(int $id)
    {
        $usuario = User::query()->findOrFail($id)->delete();
        return $usuario;
    }
}
