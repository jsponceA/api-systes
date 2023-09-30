<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GraficoController extends Controller
{
    public function index(Request $request)
    {


        $barDataResult = [];
        $rangeDatesMonths = CarbonPeriod::create(now()->subMonths(12)->format("Y-m-d"),'1 month',now()->format("Y-m-d"))->toArray();
        foreach ($rangeDatesMonths as $rdate) {
            $barDataResult["labels"][] = ucfirst($rdate->monthName);
        }

        foreach ($rangeDatesMonths as $r) {
            $barDataResult["data"][] =  Venta::query()
                ->selectRaw("producto,SUM(cantidad) as total_ventas")
                ->groupBy('producto')
                ->orderByDesc('total_ventas')
                ->whereMonth("fecha",$r)
                ->whereYear("fecha",$r)
                ->first();
        }

       return response()->json([
           "barDataResult" => $barDataResult
       ],Response::HTTP_OK);
    }
}
