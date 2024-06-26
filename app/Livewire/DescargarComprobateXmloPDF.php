<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use SimpleXMLElement;

class DescargarComprobateXmloPDF extends Component
{
    public $comprobantes;
    public $selectAllPDF = false;
    public $selectAllXML = false;
    public $selectedPDF = [];
    public $selectedXML = [];
    public $comproban;
    public $fechaInicio;
    public $fechaFin;
    public $isOpen = false;
    public $pdfUrl;



    use WithPagination;


    public function render()
    {
        $Comprobantes = $this->datos();
        return view('livewire.descargar-comprobate-xmlo-p-d-f', compact('Comprobantes'));
    }

    public function datos()
    {
        // Obtener fecha actual y sus límites
        $fechaActual = now();
        $primerDiaMesActual = $fechaActual->firstOfMonth()->startOfDay()->toDateTimeString();
        $ultimoDiaMesActual = $fechaActual->endOfMonth()->endOfDay()->toDateTimeString();
    
        // Si no se especifican fechas, obtener registros del mes y año actual
        if (empty($this->fechaInicio) && empty($this->fechaFin)) {
            return DB::table('COMPROBANTE')
                ->join('TIMBRE_FISCAL_DIGITAL', 'COMPROBANTE.id', '=', 'TIMBRE_FISCAL_DIGITAL.idcomprobante')
                ->whereBetween('COMPROBANTE.Fecha', [$primerDiaMesActual, $ultimoDiaMesActual])
                ->orderBy('COMPROBANTE.Fecha', 'desc') // Ordenar por fecha descendente
                ->select('COMPROBANTE.*', 'TIMBRE_FISCAL_DIGITAL.UUID') // Seleccionar campos necesarios
                ->paginate(10);
        }
    
        // Si se especifican fechas, filtrar por ese rango
        $fechaInicio = $this->fechaInicio ?? $primerDiaMesActual;
        $fechaFin = $this->fechaFin ?? $ultimoDiaMesActual;
    
        return DB::table('COMPROBANTE')
            ->join('TIMBRE_FISCAL_DIGITAL', 'COMPROBANTE.id', '=', 'TIMBRE_FISCAL_DIGITAL.idcomprobante')
            ->whereBetween('COMPROBANTE.Fecha', [$fechaInicio, $fechaFin])
            ->orderBy('COMPROBANTE.Fecha', 'desc') // Ordenar por fecha descendente
            ->select('COMPROBANTE.*', 'TIMBRE_FISCAL_DIGITAL.UUID') // Seleccionar campos necesarios
            ->paginate(10);
    }
    
    


    public function descargarPorID($id)
    {
        $comprobante = DB::table('TIMBRE_FISCAL_DIGITAL')
            ->where('idcomprobante', $id) // Aquí reemplaza 'id' por el campo que quieras filtrar y $id por el valor deseado
            ->first();

        $files = [];

        if (isset($this->selectedPDF[$id]) && $this->selectedPDF[$id] !== false) {
            $filenamePDF = $comprobante->UUID . '@1000000000XX0.pdf';
            $pathPDF = storage_path('app/archivos_descomprimidos/' . $filenamePDF);
            if (file_exists($pathPDF)) {
                $files[] = $pathPDF;
            }
        }

        if (isset($this->selectedXML[$id]) && $this->selectedXML[$id] !== false) {
            $filenameXML = strtoupper($comprobante->UUID) . '@1000000000XX0.xml';
            $pathXML = storage_path('app/archivos_descomprimidos/' . $filenameXML);
            if (file_exists($pathXML)) {
                $files[] = $pathXML;
            }
        }

        if (count($files) === 1) {
            return response()->download($files[0]);
        } elseif (count($files) > 1) {
            $zip = new \ZipArchive;
            $zipFileName = storage_path('app/archivos_descomprimidos/' . $comprobante->UUID . '.zip');

            if ($zip->open($zipFileName, \ZipArchive::CREATE) === TRUE) {
                foreach ($files as $file) {
                    $zip->addFile($file, basename($file));
                }
                $zip->close();
            }

            return response()->download($zipFileName);
        } else {
            return response()->json(['error' => 'No files selected or files do not exist.'], 404);
        }
    }




    public function descargarSeleccionados()
    {
        $files = [];

        foreach ($this->selectedPDF as $id => $value) {
            if ($value) {
                $comprobante =  DB::table('TIMBRE_FISCAL_DIGITAL')
                    ->where('idcomprobante', $id) // Aquí reemplaza 'id' por el campo que quieras filtrar y $id por el valor deseado
                    ->first();
                $pdfPath = storage_path('app/archivos_descomprimidos/' . $comprobante->UUID . '@1000000000XX0.pdf'); // Ajusta 'pdf_path' al nombre del campo correspondiente
                if (file_exists($pdfPath)) {
                    $files[] = $pdfPath;
                }
            }
        }

        foreach ($this->selectedXML as $id => $value) {
            if ($value) {
                $comprobante =  DB::table('TIMBRE_FISCAL_DIGITAL')
                    ->where('idcomprobante', $id) // Aquí reemplaza 'id' por el campo que quieras filtrar y $id por el valor deseado
                    ->first();
                $xmlPath = storage_path('app/archivos_descomprimidos/' . strtoupper($comprobante->UUID) . '@1000000000XX0.xml'); // Ajusta 'xml_path' al nombre del campo correspondiente
                if (file_exists($xmlPath)) {
                    $files[] = $xmlPath;
                }
            }
        }

        if (count($files) > 0) {
            $zip = new \ZipArchive;
            $zipFileName = storage_path('app/archivos_descomprimidos/selected_files.zip');

            if ($zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                foreach ($files as $file) {
                    $zip->addFile($file, basename($file));
                }
                $zip->close();

                return response()->download($zipFileName);
            } else {
                return response()->json(['error' => 'Unable to create ZIP file.'], 500);
            }
        } else {
            return response()->json(['error' => 'No files selected or files do not exist.'], 404);
        }
    }

    public function toggleSelectAllPDF()
    {
        if ($this->selectAllPDF) {
            $this->selectAllPDF = true;
        } else {
            $this->selectAllPDF = false;
        }

        $fechaActual = now();
        $primerDiaMesActual = $fechaActual->firstOfMonth()->startOfDay()->toDateTimeString();
        $ultimoDiaMesActual = $fechaActual->endOfMonth()->endOfDay()->toDateTimeString();
    
        // Si no se especifican fechas, obtener registros del mes y año actual
        if (empty($this->fechaInicio) && empty($this->fechaFin)) {
            $comprobantes = DB::table('COMPROBANTE')
                ->join('TIMBRE_FISCAL_DIGITAL', 'COMPROBANTE.id', '=', 'TIMBRE_FISCAL_DIGITAL.idcomprobante')
                ->whereBetween('COMPROBANTE.Fecha', [$primerDiaMesActual, $ultimoDiaMesActual])
                ->orderBy('COMPROBANTE.Fecha', 'desc') // Ordenar por fecha descendente
                ->select('COMPROBANTE.*', 'TIMBRE_FISCAL_DIGITAL.UUID', 'TIMBRE_FISCAL_DIGITAL.idcomprobante') // Seleccionar campos necesarios
                ->paginate(10);
        }
    
        // Si se especifican fechas, filtrar por ese rango
        $fechaInicio = $this->fechaInicio ?? $primerDiaMesActual;
        $fechaFin = $this->fechaFin ?? $ultimoDiaMesActual;
    
        $comprobantes = DB::table('COMPROBANTE')
            ->join('TIMBRE_FISCAL_DIGITAL', 'COMPROBANTE.id', '=', 'TIMBRE_FISCAL_DIGITAL.idcomprobante')
            ->whereBetween('COMPROBANTE.Fecha', [$fechaInicio, $fechaFin])
            ->orderBy('COMPROBANTE.Fecha', 'desc') // Ordenar por fecha descendente
            ->select('COMPROBANTE.*', 'TIMBRE_FISCAL_DIGITAL.UUID', 'TIMBRE_FISCAL_DIGITAL.idcomprobante') // Seleccionar campos necesarios
            ->get();

        foreach ($comprobantes as $comprobante) {
            if ($comprobante->UUID) {
                $this->selectedPDF[$comprobante->idcomprobante] = $this->selectAllPDF;
            }
        }
    }

    public function toggleSelectAllXML()
    {
        if ($this->selectAllXML) {
            $this->selectAllXML = true;
        } else {
            $this->selectAllXML = false;
        }
        $fechaActual = now();
        $primerDiaMesActual = $fechaActual->firstOfMonth()->startOfDay()->toDateTimeString();
        $ultimoDiaMesActual = $fechaActual->endOfMonth()->endOfDay()->toDateTimeString();
    
        // Si no se especifican fechas, obtener registros del mes y año actual
        if (empty($this->fechaInicio) && empty($this->fechaFin)) {
            $comprobantes = DB::table('COMPROBANTE')
                ->join('TIMBRE_FISCAL_DIGITAL', 'COMPROBANTE.id', '=', 'TIMBRE_FISCAL_DIGITAL.idcomprobante')
                ->whereBetween('COMPROBANTE.Fecha', [$primerDiaMesActual, $ultimoDiaMesActual])
                ->orderBy('COMPROBANTE.Fecha', 'desc') // Ordenar por fecha descendente
                ->select('COMPROBANTE.*', 'TIMBRE_FISCAL_DIGITAL.UUID', 'TIMBRE_FISCAL_DIGITAL.idcomprobante') // Seleccionar campos necesarios
                ->paginate(10);
        }
    
        // Si se especifican fechas, filtrar por ese rango
        $fechaInicio = $this->fechaInicio ?? $primerDiaMesActual;
        $fechaFin = $this->fechaFin ?? $ultimoDiaMesActual;
    
        $comprobantes = DB::table('COMPROBANTE')
            ->join('TIMBRE_FISCAL_DIGITAL', 'COMPROBANTE.id', '=', 'TIMBRE_FISCAL_DIGITAL.idcomprobante')
            ->whereBetween('COMPROBANTE.Fecha', [$fechaInicio, $fechaFin])
            ->orderBy('COMPROBANTE.Fecha', 'desc') // Ordenar por fecha descendente
            ->select('COMPROBANTE.*', 'TIMBRE_FISCAL_DIGITAL.UUID', 'TIMBRE_FISCAL_DIGITAL.idcomprobante') // Seleccionar campos necesarios
            ->get();
            
        foreach ($comprobantes as $comprobante) {
            $this->selectedXML[$comprobante->idcomprobante] = $this->selectAllXML;
        }
    }
    public function mostrarPdf($pdfPath)
    {
        $this->pdfUrl = $pdfPath;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->pdfUrl = null;
    }
}
