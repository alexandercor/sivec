<?php

namespace App\Controllers\Reportes;
use App\Controllers\BaseController;
use App\Models\Reportes\MreportesConsolidadoModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Shared\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\RichText;
use PhpOffice\PhpSpreadsheet\RichText\Run;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;


class ReporteConsolidado extends BaseController
{   
    protected $mreportes;
    protected $styleFontName;
    protected $configLetterInicia;
    protected $configLetterFin;

    public function __construct()
    {
        $this->mreportes = new MreportesConsolidadoModel();
        $this->styleFontName      = 'calibri';
        $this->configLetterInicia = 'A';
        $this->configLetterFin    = 'AR';
        helper('fn_helper');
    }


// ***
}
?>