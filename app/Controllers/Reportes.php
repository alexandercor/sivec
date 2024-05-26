<?php

namespace App\Controllers;
use App\Models\Reportes\MreportesModel;

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
use PhpOffice\PhpSpreadsheet\Shared\Drawing;

use CodeIgniter\Controller;
use Config\Services;


class Reportes extends BaseController
{   
    protected $mreportes;

    public function __construct()
    {
        $this->mreportes = new MreportesModel();
        helper('fn_helper');
    }

    public function c_reportes_inspeccion_index() {
        return view('admin/reportes/vinspeccion');
    }

    public function c_reportes_inspeccion() {
        $obj = new Spreadsheet();
        $sheet = $obj->getActiveSheet();
        
        $this->c_reportes_inspeccion_header($sheet);
        $this->c_reportes_inspeccion_body($sheet);
        $this->c_reportes_inspeccion_footer($sheet);

        $writer = new Xlsx($obj);
        $filePath = "doc.xlsx";
        $writer->save($filePath);

        $response = service('response');
        $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->setHeader('Content-Disposition', 'attachment; filename="'.$filePath.'"');
        $response->setBody(file_get_contents($filePath));

        return $response;
    }

    public function c_reportes_inspeccion_header($sheet) {
        $sheet->setCellValue('A1','HOLA');
    }
    
    public function c_reportes_inspeccion_body($sheet) {
        $sheet->setCellValue('A2','BODY');
    }
    public function c_reportes_inspeccion_footer($sheet) {
        $sheet->setCellValue('A3','FOOTER');
    }



// ****
}
?>