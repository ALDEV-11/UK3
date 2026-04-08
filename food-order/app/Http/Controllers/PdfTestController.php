<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfTestController extends Controller
{
    public function download()
    {
        $pdf = Pdf::loadHTML('<h1>Test PDF</h1>')
            ->setPaper('A4', 'portrait');

        return $pdf->download('test-pdf.pdf');
    }
}
