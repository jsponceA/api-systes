<?php

namespace App\Interfaces;

interface UsuarioRepositoryInterface
{
    public function todosLosUsuarios(array $params);
    public function usuarioPorId(int $id);
    public function crearUsuario(array $data);
    public function modificarUsuario(int $id, array $newData);
    public function eliminarUsuario(int $id);
}
