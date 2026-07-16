<?php

namespace App\Controllers;
use Dompdf\Dompdf;

class HelpSupportController extends BaseController
{
    public function index()
    {
        return view('help_support/index');
    }

    public function pdf()
    {
        $dompdf = new Dompdf();
    
        $html = view('help_support/pdf');
    
        $dompdf->loadHtml($html);
    
        $dompdf->setPaper('A4', 'portrait');
    
        $dompdf->render();
    
        return $this->response
            ->setContentType('application/pdf')
            ->setBody($dompdf->output());
    }
}