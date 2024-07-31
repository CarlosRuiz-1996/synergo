<?php

namespace App\Http\Controllers;

use App\Jobs\ProcesarArchivosXml;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacturaController extends Controller
{
    public function mostrarFormularioSubida()
    {
        return view('upload');
    }

    public function procesarArchivos(Request $request)
    {
        // Validar el archivo ZIP
        $request->validate([
            'archivo_zip' => 'required|mimes:zip', // Max 10MB
        ]);
    
        // Guardar el archivo ZIP en el servidor
        $archivoZip = $request->file('archivo_zip');
        $rutaArchivoZip = $archivoZip->store('archivos');
    
        // Verificar si se guardó correctamente el archivo ZIP
        if ($rutaArchivoZip) {
            $rutaAbsolutaArchivoZip = Storage::disk('local')->path($rutaArchivoZip);

            // Asignar permisos de lectura y escritura al archivo
            chmod($rutaAbsolutaArchivoZip, 0644);
            // Encolar el trabajo para procesar los archivos XML
            ProcesarArchivosXml::dispatch($rutaArchivoZip);
    
            // Redireccionar con un mensaje de éxito
            return redirect()->back()->with('success', 'El archivo ZIP se ha cargado correctamente y está encolado para procesamiento.');
        } else {
            // En caso de que ocurra un error al guardar el archivo ZIP
            return redirect()->back()->with('error', 'Hubo un problema al cargar el archivo ZIP. Por favor, inténtalo de nuevo.');
        }
    }    
    
}
