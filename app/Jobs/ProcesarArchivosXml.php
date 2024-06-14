<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ProcesarArchivosXml implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * La ruta del archivo ZIP a procesar.
     *
     * @var string
     */
    protected $rutaArchivoZip;

    /**
     * Crea una nueva instancia del trabajo.
     *
     * @param  string  $rutaArchivoZip
     * @return void
     */
    public function __construct($rutaArchivoZip)
    {
        $this->rutaArchivoZip = $rutaArchivoZip;
    }

    /**
     * Ejecuta el trabajo.
     *
     * @return void
     */
    public function handle()
{
    // Ruta completa del archivo ZIP
    $rutaCompletaArchivoZip = storage_path('app/public/' . $this->rutaArchivoZip);

    // Inicio del manejo del archivo ZIP
    Log::info('Iniciando manejo del archivo ZIP.');

    // Verificar la existencia del archivo ZIP
    if (Storage::exists($this->rutaArchivoZip)) {
        // Log para indicar que se ha encontrado el archivo ZIP
        Log::info("El archivo ZIP '$rutaCompletaArchivoZip' ha sido encontrado.");

        // Intentar abrir el archivo ZIP
        $zip = new ZipArchive;
        if ($zip->open($rutaCompletaArchivoZip) === true) {
            // Operaciones con el archivo ZIP
            $zip->extractTo(storage_path('app/archivos_descomprimidos'));
            $zip->close();

            // Log para indicar que el archivo ZIP se ha manejado correctamente
            Log::info("El archivo ZIP '$rutaCompletaArchivoZip' se ha manejado correctamente.");
        } else {
            // Manejar el caso en el que no se puede abrir el archivo ZIP
            Log::error("No se pudo abrir el archivo ZIP '$rutaCompletaArchivoZip'.");
        }
    } else {
        // Manejar el caso en que el archivo ZIP no existe
        Log::error("El archivo ZIP '$rutaCompletaArchivoZip' no existe.");
    }

    // Ruta del directorio donde se extrajeron los archivos del ZIP
    $rutaDirectorioDescomprimido = storage_path('app/archivos_descomprimidos');

    // Lista de archivos en el directorio descomprimido
    $archivosDescomprimidos = scandir($rutaDirectorioDescomprimido);

    // Array para almacenar los datos de los archivos XML
    $datos = [];

    // Iterar sobre los archivos en el directorio descomprimido
    foreach ($archivosDescomprimidos as $archivo) {
        // Validar que el archivo sea un XML
        if (pathinfo($archivo, PATHINFO_EXTENSION) === 'xml') {
            // Ruta completa del archivo XML
            $rutaArchivoXml = $rutaDirectorioDescomprimido . DIRECTORY_SEPARATOR . $archivo;

            try {
                // Cargar el archivo XML
                $xml = simplexml_load_file($rutaArchivoXml);

                if ($xml === false) {
                    throw new Exception("No se pudo cargar el archivo XML '$archivo'");
                }

                // Verificar que el objeto XML se cargó correctamente
                if ($xml !== false) {
                    $comprobante = $xml->attributes();
                    $emisor = isset($xml->children('cfdi', true)->Emisor) ? $xml->children('cfdi', true)->Emisor->attributes() : null;
                    $receptor = isset($xml->children('cfdi', true)->Receptor) ? $xml->children('cfdi', true)->Receptor->attributes() : null;
                    $conceptos = [];

                    // Iterar sobre todos los Conceptos dentro de Conceptos
                    foreach ($xml->children('cfdi', true)->Conceptos->Concepto as $concepto) {
                        $conceptos[] = $concepto->attributes();
                    }

                    $complemento = isset($xml->children('cfdi', true)->Complemento) ? $xml->children('cfdi', true)->Complemento : null;
                    $Pagospago = null;
                    $DoctoRelacionado = null;
                    $DoctoRelacionado2 = null;
                    $impuestosP = null;
                    $totales = null;
                    $TimbreFiscalDigital = null;

                    // Acceder a otros elementos como PagosPago, DoctoRelacionado, etc. según sea necesario
                    if ($complemento !== null) {
                        $complemento2 = $complemento->attributes();
                        if (isset($complemento->children('pago20', true)->Pagos->Pago)) {
                            $Pagospago = $complemento->children('pago20', true)->Pagos->Pago->attributes();
                            if (isset($complemento->children('pago20', true)->Pagos->Pago->DoctoRelacionado)) {
                                $DoctoRelacionado = $complemento->children('pago20', true)->Pagos->Pago->DoctoRelacionado->attributes();
                                if (isset($complemento->children('pago20', true)->Pagos->Pago->DoctoRelacionado->ImpuestosDR->TrasladosDR->TrasladoDR)) {
                                    $DoctoRelacionado2 = $complemento->children('pago20', true)->Pagos->Pago->DoctoRelacionado->ImpuestosDR->TrasladosDR->TrasladoDR->attributes();
                                }
                            }
                            if (isset($complemento->children('pago20', true)->Pagos->Pago->ImpuestosP->TrasladosP->TrasladoP)) {
                                $impuestosP = $complemento->children('pago20', true)->Pagos->Pago->ImpuestosP->TrasladosP->TrasladoP->attributes();
                            }
                        }
                        if (isset($complemento->children('pago20', true)->Pagos->Totales)) {
                            $totales = $complemento->children('pago20', true)->Pagos->Totales->attributes();
                        }
                        if (isset($complemento->children('tfd', true)->TimbreFiscalDigital)) {
                            $TimbreFiscalDigital = $complemento->children('tfd', true)->TimbreFiscalDigital->attributes();
                        }
                    }

                    // Convertir el objeto SimpleXMLElement a un array
                    $datosXml = [
                        'Comprobante' => $comprobante ? $comprobante : [],
                        'Emisor' => $emisor ? $emisor : [],
                        'Receptor' => $receptor ? $receptor : [],
                        'Conceptos' => $conceptos ? $conceptos : [],
                        'Complemento' => $complemento2 ? $complemento2 : [],
                        'PagosPago' => $Pagospago ? $Pagospago : [],
                        'DoctoRelacionado' => $DoctoRelacionado ? $DoctoRelacionado : [],
                        'DoctoRelacionado2' => $DoctoRelacionado2 ? $DoctoRelacionado2 : [],
                        'ImpuestosP' => $impuestosP ? $impuestosP : [],
                        'Totales' => $totales ? $totales : [],
                        'TimbreFiscalDigital' => $TimbreFiscalDigital ? $TimbreFiscalDigital : [],
                    ];

                    // Agregar el array de datos del XML al array principal de datos
                    $datos[] = $datosXml;
                } else {
                    // Si no se pudo cargar el archivo XML, registra un error en el log
                    Log::error("No se pudo cargar el archivo XML '$archivo'");
                }
            } catch (Exception $e) {
                // Si ocurre un error al procesar el archivo XML, registra el error en el registro y continúa con el siguiente archivo
                Log::error("Error al procesar el archivo XML '$archivo': " . $e->getMessage());
                Log::error("El archivo '$archivo' no se pudo procesar.");
            }
        }
    }

    // Convertir el array de datos a formato JSON y guardarlo en un archivo de texto
    $texto = json_encode($datos, JSON_PRETTY_PRINT);
    $rutaArchivoTexto = storage_path('app/public/datos.json');

    try {
        // Intentar escribir el archivo de texto
        file_put_contents($rutaArchivoTexto, $texto);

        // Log para indicar que se ha generado el archivo de texto con los datos de los archivos XML
        Log::info('Archivo de texto generado con los datos de los archivos XML.');
    } catch (\Exception $e) {
        // Manejar cualquier excepción que ocurra al intentar escribir el archivo de texto
        Log::error('Error al escribir el archivo de texto: ' . $e->getMessage());
    }
}

    
}
