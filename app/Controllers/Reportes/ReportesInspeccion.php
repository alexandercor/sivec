<?php

namespace App\Controllers\Reportes;
use App\Controllers\BaseController;
use App\Models\Reportes\MreportesInspeccionModel;

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
        $this->mreportes = new MreportesInspeccionModel();
        $this->styleFontName      = 'calibri';
        $this->configLetterInicia = 'A';
        $this->configLetterFin    = 'AR';
        helper('fn_helper');
    }

    public function c_reportes_inspeccion_xls($codControl) {

        $codControl = bs64url_dec($codControl);

        if(isset($codControl) && !empty($codControl)){

            $dataInspeccion = $this->mreportes->mreporte_inspecciones_inspeccion_head($codControl);

            if(isset($dataInspeccion) && !empty($dataInspeccion)){

                $objSheet = new Spreadsheet();
                $sheet = $objSheet->getActiveSheet();
                $sheet->setTitle('Reporte Ispeccion');
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setHorizontalCentered(true);
                $sheet->getPageSetup()->setScale(90);
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageMargins()->setLeft(0.472441);
                $sheet->getPageMargins()->setRight(0.393701);

                $codInspeccion = $dataInspeccion->key_control;
                if ( isset($codInspeccion) && !empty($codInspeccion) ) {
                    $dataInspeccionDetalle = $this->mreportes->mreporte_inspeccion_inspeccionados_detalle_lista($codInspeccion);
                }


                $this->c_reportes_inspeccion_header($sheet, $dataInspeccion);
                $this->c_reportes_inspeccion_body($sheet, $dataInspeccionDetalle);
                $this->c_reportes_inspeccion_footer($sheet);

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
        }else{
            return redirect()->to(base_url('reportes-inspeccion'));
        }
    }

    public function c_reportes_inspeccion_header($sheet, $dataInspeccion) {

        if($sheet){

            $LI = $this->configLetterInicia;
            $LF = $this->configLetterFin;
            
            $inspecctor = $dataInspeccion->inspecctor;
            $eess       = $dataInspeccion->eess;
            $sector     = $dataInspeccion->sector;


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

            //** */
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
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'indent'     => 21
                ],
            ];
            //** */

            //** */
            $row6 = 6;
            $logo = new Drawing();
            $logo->setCoordinates($LI.$row6);
            $logo->setPath('resources/img/msalud.png');
            $logo->setHeight(35);
            $logo->setWorksheet($sheet);

            $sheet->setCellValue("D".$row6,'INSPECCIÓN DE VIVIENDAS PARA LA VIGILANCIA Y CONTROL DEL Aedes aegypti');
            
            $sheet->getStyle("D".$row6)->applyFromArray($headTitleInspeccion);
            $sheet->mergeCells("D".$row6.":".$LF.$row6);
            $sheet->getRowDimension($row6)->setRowHeight(28);
            //** */

            //** */
            $row7 = 7;
            $row8 = 8;
            $sheet->getRowDimension($row7)->setRowHeight(28);
            $sheet->getRowDimension($row8)->setRowHeight(28);
            $sheet->mergeCells($LI."7:".$LF."7");
            $sheet->mergeCells($LI."8:".$LF."8");

            $sheet->setCellValue("A7",$eess.$sector);
            $sheet->setCellValue("A8",$inspecctor);

        }else{
            return redirect()->to(base_url('reportes-inspeccion'));
        }
    }
    
    public function c_reportes_inspeccion_body($sheet, $dataInspeccionDetalle) {
        
        if(isset($sheet) && !empty($sheet)){
            $LI = $this->configLetterInicia;
            $LF = $this->configLetterFin;

            $styleTableLista = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 11,
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'wrapText'    => true,    
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ],
                ],
            ];
            $sheet->getStyle($LI."9:".$LF."38")->applyFromArray($styleTableLista);

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
            $sheet->getStyle("E9:AR12")->applyFromArray($styleHeadTableTexHorizontal);

            $row9 = 9;
            $row12 = 12;

            $sheet->mergeCells($LI.$row9.":".$LI.$row12);
            $sheet->mergeCells("B".$row9.":"."B".$row12);
            $sheet->mergeCells("C".$row9.":"."C".$row12);
            $sheet->mergeCells("D".$row9.":"."D".$row12);
            $sheet->mergeCells("AQ".$row9.":"."AQ".$row12);
            $sheet->mergeCells("AR".$row9.":"."AR".$row12);

            $sheet->setCellValue($LI.$row9,'N°');
            $sheet->setCellValue("B".$row9,'Codigo de Manzana');
            $sheet->setCellValue("C".$row9,'Dirección o persona que atiende');
            $sheet->setCellValue("D".$row9,'N° de residentes');
            $sheet->setCellValue("AQ".$row9,'Consumo de Larvicida(g)');
            $sheet->setCellValue("AR".$row9,'Febriles');

            $arrColTextVert = ['B','D','AQ','AR'];
            foreach ($arrColTextVert as $key => $cel) {
                $sheet->getStyle($cel.$row9)->applyFromArray($styleHeadTableTexVertical);
            }
            $arrColTextHori = ['A','C'];
            foreach ($arrColTextHori as $key => $cel) {
                $sheet->getStyle($cel.$row9)->applyFromArray($styleHeadTableTexHorizontal);
            }

            $sheet->getColumnDimension("A")->setWidth(4);
            $sheet->getColumnDimension("B")->setWidth(6);
            $sheet->getColumnDimension("C")->setWidth(25);
            $sheet->getColumnDimension("D")->setWidth(5);
            $sheet->getColumnDimension("AQ")->setWidth(6);
            $sheet->getColumnDimension("AR")->setWidth(4);

            /** */
            $row9= 9;
            $sheet->mergeCells("E$row9:AP$row9");
            $sheet->setCellValue("E9",'Depósitos');
            /** */

            //** */
            $row10 = 10;
            $sheet->mergeCells("E$row10:L$row10");
            $sheet->mergeCells("M$row10:P$row10");
            $sheet->mergeCells("Q$row10:T$row10");
            $sheet->mergeCells("U$row10:X$row10");

            $sheet->setCellValue("E$row10", "> 500 L");
            $sheet->setCellValue("M$row10", "- 200 L");
            $sheet->setCellValue("Q$row10", "> 200 L - 100 L");
            $sheet->setCellValue("U$row10", "< 100 L");
            //** */

            // ***
            $row11 = 11;
            $arrDepositosCol = ['E,H', 'I,L', 'M,P', 'Q,T', 'U,X'];
            foreach ($arrDepositosCol as $key => $dep) {
                $arrLetter = explode(',', $dep);
                [$colIni, $colFin] = $arrLetter;
                $sheet->mergeCells("$colIni$row11:$colFin$row11");  
            }
            $sheet->mergeCells("Y10:AB$row11");
            $sheet->mergeCells("AC10:AF$row11");
            $sheet->mergeCells("AG10:AK$row11");
            $sheet->mergeCells("AL10:AP$row11");
            $sheet->getRowDimension($row11)->setRowHeight(37);

            $sheet->setCellValue("E".$row11, "Tanque alto");
            $sheet->setCellValue("I".$row11, "Tanque bajo");
            $sheet->setCellValue("M".$row11, "Barril-cilindro");
            $sheet->setCellValue("Q".$row11, "Sansón-bidon");
            $sheet->setCellValue("U".$row11, "Baldes, bateas, tinajas");
            $sheet->setCellValue("Y10", "Llantas");
            $sheet->setCellValue("AC10", "Floreros, maceteros");
            $sheet->setCellValue("AG10", "Latas, botellas");
            $sheet->setCellValue("AL10", "Otros");
            //** */

            //** Row 12*/
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
                }
            }
            //** */

            //** */
            $row38 = 38;
            $sheet->mergeCells($LI.$row38.":"."D38");
            $sheet->setCellValue($LI.$row38, 'Total');

            $arrDataInspeccionDetalle = [];
            $rowActual = 13;
            foreach ($dataInspeccionDetalle as $key => $det) {
                $count = ++$key;
                $keyDetIns = $det->key_detalle_control;
                $codManza  = $det->cod_manzan;
                $perAtien  = $det->per_aten;
                $rresiden  = $det->n_resid;
                $consLarv  = $det->cons_larvi;

                $arrDataInspeccionDetalle[$key] = [$count, $codManza, $perAtien, $rresiden];
                $sheet->setCellValue("AQ".$rowActual, $consLarv);
                // Detalle

                $letterDepTipDetalle = [
                    1 => [1 => 'E',2 => 'F',3 => 'G',4 => 'H'],
                    2 => [1 => 'I',2 => 'J',3 => 'K',4 => 'L'],
                    3 => [1 => 'M',2 => 'N',3 => 'O',4 => 'P'],
                    4 => [1 => 'Q',2 => 'R',3 => 'S',4 => 'T'],
                    5 => [1 => 'U',2 => 'V',3 => 'W',4 => 'X'],
                    6 => [1 => 'Y',2 => 'Z',3 => 'AA',4 => 'AB'],
                    7 => [1 => 'AC',2 => 'AD',3 => 'AE',4 => 'AF'],
                    8 => [1 => 'AG',2 => 'AH',3 => 'AI',4 => 'AJ', 5 => 'AK'],
                    11 => [1 => 'AL',2 => 'AM',3 => 'AN',4 => 'AO', 5 => 'AO'],
                ];

                $dataDetalleInspTipoDep = $this->mreportes->mreporte_inspeccion_inspeccionados_depositos_tipos($keyDetIns);

                foreach ($dataDetalleInspTipoDep as $key => $dtp) {
                    $keyDep      = (int) $dtp->key_deposito;
                    $keyDepTip   = (int) $dtp->key_dep_tipo;
                    $depCantidad = $dtp->cantidad;

                    if(array_key_exists($keyDep, $letterDepTipDetalle)){
                        $arrDepTipDetalle = $letterDepTipDetalle[$keyDep];
                        if(array_key_exists($keyDepTip, $arrDepTipDetalle)){
                            $letteCurrent = $arrDepTipDetalle[$keyDepTip];
                            $sheet->setCellValue($letteCurrent.$rowActual,$depCantidad);
                        }
                    }
                }
                $rowActual++;
            }
            
            $sheet->fromArray($arrDataInspeccionDetalle, NULL, $LI."13");

        }else{
            return redirect()->to(base_url('reportes-inspeccion'));
        }
    }

    public function c_reportes_inspeccion_footer($sheet) {
        // $sheet->setCellValue('A3','FOOTER');
    }

}
?>