<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReservationTemplateController extends Controller
{
    public function downloadTemplate()
    {
        $pdf = Pdf::loadView('pdf.reservation-template');
        return $pdf->download('Template_Reservasi_Perpustakaan.pdf');
    }
}
