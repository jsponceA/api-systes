<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArchivoRequest;
use App\Imports\ArchivoImport;
use App\Interfaces\CargaArchivoRepositoryInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class CargaArchivoController extends Controller
{
    protected $archivoRepository;
    public function __construct(CargaArchivoRepositoryInterface $archivoRepository)
    {
        $this->middleware("auth:sanctum");
        $this->archivoRepository = $archivoRepository;
    }

    public function index(Request $request)
    {
        return response()->json([
            "archivos" => $this->archivoRepository->todosLosArchivo($request->all())
        ],Response::HTTP_OK);
    }

    public function store(ArchivoRequest $request)
    {
        $data = $request->except("archivo");
        if ($request->hasFile("archivo")){
            $data["archivo"] = $this->archivoRepository->cargarExcel("archivos",$request->file("archivo"));
        }
        $data["usuario_id"] = auth()->user()->id;
        $this->archivoRepository->crearArchivo($data);
        Excel::import( new ArchivoImport(),$request->file("archivo"));
        //$archivoImport = new ArchivoImport();

        return response()->json([
            "message" => "Archivo creado con exito."
        ],Response::HTTP_CREATED);
    }

    public function show(Request $request,$id)
    {
        return response()->json([
            "archivo" => $this->archivoRepository->archivoPorId($id)
        ],Response::HTTP_OK);
    }

   /* public function update(ArchivoRequest $request,$id)
    {
        $data = $request->except("archivo");
        $archivoActual = $this->archivoRepository->archivoPorId($id);

        if ($request->hasFile("archivo")){
            if (!empty($archivoActual->archivo)){
                $this->archivoRepository->eliminarExcel("archivos",$archivoActual->archivo);
            }
            $data["archivo"] = $this->archivoRepository->cargarExcel("archivos",$request->file("archivo"));
        }

        $this->archivoRepository->modificarUsuario($id,$data);

        return response()->json([
            "message" => "Usuario modificado con exito."
        ],Response::HTTP_OK);
    }*/

    public function destroy(Request $request,$id)
    {
        $archivoActual = $this->archivoRepository->archivoPorId($id);
        if (!empty($archivoActual->archivo)){
            $this->archivoRepository->eliminarExcel("archivos",$archivoActual->archivo);
        }
        $this->archivoRepository->eliminarArchivo($id);
        return response()->json(null,Response::HTTP_NO_CONTENT);
    }
}
