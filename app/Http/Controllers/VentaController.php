<?php

namespace App\Http\Controllers;

use App\Interfaces\VentaRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VentaController extends Controller
{
    protected $ventaRepository;
    public function __construct(VentaRepositoryInterface $ventaRepository)
    {
        $this->middleware("auth:sanctum");
        $this->ventaRepository = $ventaRepository;
    }

    public function index(Request $request)
    {
        return response()->json([
            "ventas" => $this->ventaRepository->todasLasVentas($request->all())
        ],Response::HTTP_OK);
    }
}
