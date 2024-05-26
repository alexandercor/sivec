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
    protected $styleFontName;
    protected $configLetterInicia;
    protected $configLetterFin;

    public function __construct()
    {
        $this->mreportes = new MreportesModel();
        $this->styleFontName      = 'calibri';
        $this->configLetterInicia = 'A';
        $this->configLetterFin    = 'AR';
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

            $LI = $this->configLetterInicia;
            $LF = $this->configLetterFin;
            
            $headTitleA1 = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 11,
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
            ];
            $headTitleA2 = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 8,
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
            ];

            $sheet->mergeCells($LI."1:".$LF."1");
            $sheet->mergeCells($LI."2:".$LF."2");
            $sheet->mergeCells($LI."3:".$LF."3");
            $sheet->setCellValue($LI."1",'NTS N° 198 - MINSA/DIGESA-2023');//44
            $sheet->setCellValue($LI."2",'Norma Técnica de Salud para la Vigilancia Entomológica y Control de Aedes aegypti, vector de Arbovirosis y la Vigilancia del Ingreso de Aedes albopictus en el territorio nacional');

            $sheet->getStyle($LI."1")->applyFromArray($headTitleA1);
            $sheet->getStyle($LI."2")->applyFromArray($headTitleA2);

            $headTitleFormato = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 11,
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
            ];
            $row4 = 4;
            $sheet->mergeCells($LI.$row4.":".$LF.$row4);
            $sheet->getStyle($LI.$row4)->applyFromArray($headTitleFormato);
            $sheet->setCellValue($LI.$row4, 'Formato 03: Inspección de viviendas para la vigilancia y control del Aedes aegypti');

            $sheet->mergeCells($LI."5:".$LF."5");

            $headTitleInspeccion = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 12,
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER
                ],
            ];
            $row6 = 6;
            // $logo = new Drawing();
            // $logo->setCoordinates($LI.$row6);
            // $logo->setPath('resources/img/logo.png');
            // $logo->setWidth(1398);

            // $logo->setWorksheet($sheet);

            // $sheet->setCellValue($LI.$row6,'od');
            $sheet->setCellValue("J".$row6,'INSPECCIÓN DE VIVIENDAS PARA LA VIGILANCIA Y CONTROL DEL Aedes aegypti');
            
            $sheet->getStyle("J".$row6)->applyFromArray($headTitleInspeccion);
            $sheet->mergeCells("J".$row6.":".$LF.$row6);


        }else{
            return redirect()->to(base_url('reportes-inspeccion'));
        }
    }
    
    public function c_reportes_inspeccion_body($sheet) {
        // $sheet->setCellValue('A2','BODY');
    }

    public function c_reportes_inspeccion_footer($sheet) {
        // $sheet->setCellValue('A3','FOOTER');
    }

}
?>