<?php

namespace App\Http\Controllers;

use Storage;

class PdfController extends Controller
{
    public function showPdf($filename)
    {
        $path = '/storage/pdfs/' . $filename;

        return view('kiosk.pdf-document', [
            'file' =>  $path,
        ]);
    }
}
