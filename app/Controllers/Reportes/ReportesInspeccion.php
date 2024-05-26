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
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
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
            $logo = new Drawing();
            $logo->setCoordinates($LI.$row6);
            $logo->setPath('resources/img/msalud.png');
            $logo->setHeight(35);
            $logo->setWorksheet($sheet);

            $sheet->setCellValue("J".$row6,'INSPECCIÓN DE VIVIENDAS PARA LA VIGILANCIA Y CONTROL DEL Aedes aegypti');
            
            $sheet->getStyle("J".$row6)->applyFromArray($headTitleInspeccion);
            $sheet->mergeCells("J".$row6.":".$LF.$row6);
            $sheet->getRowDimension($row6)->setRowHeight(28);

            $row7 = 7;
            $row8 = 8;
            $sheet->getRowDimension($row7)->setRowHeight(28);
            $sheet->getRowDimension($row8)->setRowHeight(28);
            $sheet->mergeCells($LI."7:".$LF."7");
            $sheet->mergeCells($LI."8:".$LF."8");

        }else{
            return redirect()->to(base_url('reportes-inspeccion'));
        }
    }
    
    public function c_reportes_inspeccion_body($sheet) {
        
        if(isset($sheet) && !empty($sheet)){
            $LI = $this->configLetterInicia;
            $LF = $this->configLetterFin;

            $styleHeadTableTexVertical = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 11,
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'textRotation' => 90,
                    'wrapText'    => true,    
                ]
            ];
            $styleHeadTableTexHorizontal = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 11,
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'wrapText'    => true,    
                ]
            ];
            $row9 = 9;
            $row12 = 12;

            $sheet->mergeCells($LI.$row9.":".$LI.$row12);
            $sheet->mergeCells("B".$row9.":"."B".$row12);
            $sheet->mergeCells("C".$row9.":"."C".$row12);
            $sheet->mergeCells("D".$row9.":"."D".$row12);

            $sheet->setCellValue($LI.$row9,'N°');
            $sheet->setCellValue("B".$row9,'Codigo de Manzana');
            $sheet->setCellValue("C".$row9,'Dirección o persona que atiende');
            $sheet->setCellValue("D".$row9,'N° de residentes');

            $arrColTextVert = ['B','D'];
            foreach ($arrColTextVert as $key => $cel) {
                $sheet->getStyle($cel.$row9)->applyFromArray($styleHeadTableTexVertical);
            }
            $arrColTextHori = ['A9','C9'];
            foreach ($arrColTextHori as $key => $cel) {
                $sheet->getStyle($cel)->applyFromArray($styleHeadTableTexHorizontal);
            }

            $sheet->setCellValue("E9",'Depositos');

            $arrDepositosColLetter = 
            [
                ['E','F','G','H'],
                ['I','J','K','L'],
                ['M','N','O','P'],
                ['Q','R','S','T'],
                ['U','V','W','X'],
                ['Y','Z','AA','AB'],
                ['AC','AD','AE','AF'],
                ['AG','AH','AI','AJ','AK'],
                ['AL','AM','AN','AO','AP']
            ];
            $arrDepositoTipo = ['I','P','TQ','TF','D'];

            foreach ($arrDepositosColLetter as $key => $col) {
                foreach ($col as $key => $let) {
                    $depTipo = $arrDepositoTipo[$key];
                    $sheet->setCellValue($let.$row12,$depTipo);
                    $sheet->getColumnDimension($let)->setWidth(4);
                    $sheet->getStyle($let)->applyFromArray($styleHeadTableTexHorizontal);
                }
            }




        }else{
            return redirect()->to(base_url('reportes-inspeccion'));
        }
    }

    public function c_reportes_inspeccion_footer($sheet) {
        // $sheet->setCellValue('A3','FOOTER');
    }

}
?>