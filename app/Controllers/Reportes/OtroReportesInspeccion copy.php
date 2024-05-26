<?php

namespace App\Controllers\Reportes;
use App\Controllers\BaseController;
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
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;


class ReportesInspeccion extends BaseController
{   
    protected $mreportes;

    public function __construct()
    {
        $this->mreportes = new MreportesModel();
    }

    public function c_reportes_inspeccion_index() {
        return view('admin/reportes/vinspeccion');
    }

    public function c_reportes_inspeccion() {

        $response = $this->mreportes->cdato();
        $dis = $response->nombre_distrito;

        if(isset($response) && !empty($response)){

            $objSheet = new Spreadsheet();
            $sheet = $objSheet->getActiveSheet();
            $sheet->setTitle('Reporte Ispeccion');
            $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
            $sheet->getPageSetup()->setHorizontalCentered(true);
            $sheet->getPageSetup()->setScale(90);
            $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
            $sheet->getPageMargins()->setLeft(0.472441);
			$sheet->getPageMargins()->setRight(0.393701);

            $this->c_reportes_inspeccion_header($sheet);
            $this->c_reportes_inspeccion_body($sheet);
            $this->c_reportes_inspeccion_footer($sheet);

            // $sheet->setCellValue('C1','TEXTO DE PRUEBA');
            // $sheet->setCellValue('C5',$dis);

            $writer = new Xlsx($objSheet);
            $filePath = "Reporte Inspeccion.xlsx";
            $writer->save($filePath);

            $response = service('response');
            $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $response->setHeader('Content-Disposition', 'attachment; filename="'.$filePath.'"');
            $response->setBody(file_get_contents($filePath));

            return $response;
        }else{
            return redirect()->to(base_url('reportes-inspeccion'));
        }
    }

    public function c_reportes_inspeccion_header($sheet) {

        if($sheet){
            $sheet->mergeCells('A1:J1');
            $sheet->setCellValue('A1','NTS N° 198 - MINSA/DIGESA-2023');//44
            $sheet->setCellValue('Norma ');
        }
    }
    
    public function c_reportes_inspeccion_body($sheet) {
        $sheet->setCellValue('A2','BODY');
    }

    public function c_reportes_inspeccion_footer($sheet) {
        $sheet->setCellValue('A3','FOOTER');
    }

}
?>