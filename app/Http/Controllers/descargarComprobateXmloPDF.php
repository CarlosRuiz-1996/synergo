<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class descargarComprobateXmloPDF extends Controller
{
    public function descargarComprobateXmloPDF(){
        return view('descargarComprobateXmloPDF');
    }

}
