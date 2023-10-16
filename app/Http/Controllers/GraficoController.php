<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class GraficoController extends Controller
{
    public function totalesVentasPorMesAnioPasado(Request $request)
    {
        $resultado = [];
        $rangeDatesMonths = CarbonPeriod::create(now()->setDateFrom('2022-01-01'),'1 month',"2023-01-01")->toArray();

        foreach ($rangeDatesMonths as $r) {
            $mes = ucfirst($r->monthName);
            $venta =  DB::table("ventas")
                ->selectRaw("SUM(cantidad) AS cantidad, SUM(totales::numeric) AS total")
                ->whereMonth("fecha",$r)
                ->whereYear("fecha",$r)
                ->first();

            $resultado[] = [
                "label" => $mes,
                "cantidad" => $venta->cantidad ?? 0,
                "total" => $venta->total ?? 0,
            ];

        }

        return response()->json([
            "resultado" => $resultado
        ],Response::HTTP_OK);
    }
    public function totalesVentasPorMesAnioActual(Request $request)
    {
        $resultado = [];
        $rangeDatesMonths = CarbonPeriod::create("2023-01-01",'1 month',"2023-12-25")->toArray();

        foreach ($rangeDatesMonths as $r) {
            $mes = ucfirst($r->monthName);
            $venta =  DB::table("ventas")
                ->selectRaw("SUM(cantidad) AS cantidad, SUM(totales::numeric) AS total")
                ->whereMonth("fecha",$r)
                ->whereYear("fecha",$r)
                ->first();

            $resultado[] = [
                "label" => $mes,
                "cantidad" => $venta->cantidad ?? 0,
                "total" => $venta->total ?? 0,
            ];

        }

       return response()->json([
           "resultado" => $resultado
       ],Response::HTTP_OK);
    }

    public function metaPlaneadaMensual(Request $request)
    {
        $resultado = [];
        $rangeDatesMonths = CarbonPeriod::create("2023-01-01",'1 month',"2023-12-25")->toArray();
        $metas = [25,28,30,33,37,39,42,46,49,49.3,51,52];
        foreach ($rangeDatesMonths as $key => $r) {
            $mes = ucfirst($r->monthName);

            $resultado[] = [
                "label" => $mes,
                "meta" => $metas[$key]
            ];

        }

        return response()->json([
            "resultado" => $resultado
        ],Response::HTTP_OK);
    }


    public function productosMasVendidos(Request $request)
    {
        $resultado =  DB::table("ventas")
            ->selectRaw("producto,SUM(cantidad) AS cantidad")
            ->whereNotNull("producto")
            ->groupBy("producto")
            ->orderByDesc("cantidad")
            ->take(10)
            ->get();

        return response()->json([
            "resultado" => $resultado
        ],Response::HTTP_OK);
    }

    public function recomendacionProducto(Request $request)
    {
        $resultado =  DB::table("ventas")
            ->selectRaw("producto,SUM(cantidad) AS cantidad")
            ->whereNotNull("producto")
            ->groupBy("producto")
            ->orderByDesc("cantidad")
            ->first();

        return response()->json([
            "resultado" => $resultado
        ],Response::HTTP_OK);
    }

}
