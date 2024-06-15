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
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;


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
                $this->c_reportes_inspeccion_body($sheet, $dataInspeccionDetalle, $codInspeccion);
                $this->c_reportes_inspeccion_footer($sheet, $codControl);

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
            $localidad  = $dataInspeccion->localidad;
            $fechCont   = fdate($dataInspeccion->fecha_control);
            $tipoActi   = (int) $dataInspeccion->tipo_act;    

            $cellTipoAct = match($tipoActi){
                1 => 'AD',
                2 => 'Y',
                3 => 'AJ',
                4 => 'AO',
                default => '',
            };
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
            $row3 = 3;
            $sheet->mergeCells($LI.$row3.":".$LF.$row3);
            $sheet->getStyle($LI.$row3)->applyFromArray($headTitleFormato);
            $sheet->setCellValue($LI.$row3, 'Formato 03: Inspección de viviendas para la vigilancia y control del Aedes aegypti');

            // $sheet->mergeCells($LI."5:".$LF."5");
            $sheet->getRowDimension($row3)->setRowHeight(24);

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
            $row4 = 4;
            $logo = new Drawing();
            $logo->setCoordinates($LI.$row4);
            $logo->setPath('resources/img/msalud.png');
            $logo->setHeight(35);
            $logo->setWorksheet($sheet);

            $sheet->setCellValue("D".$row4,'INSPECCIÓN DE VIVIENDAS PARA LA VIGILANCIA Y CONTROL DEL Aedes aegypti');
            
            $sheet->getStyle("D".$row4)->applyFromArray($headTitleInspeccion);
            $sheet->mergeCells("D".$row4.":".$LF.$row4);
            $sheet->getRowDimension($row4)->setRowHeight(28);
            //** */

            //** */
            $row5 = 5;
            $row6 = 6;
            $row7 = 7;
            $row8 = 8;

            $headTitleLocalidad = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 10.5,
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical'   => Alignment::VERTICAL_CENTER
                ],
            ];
            $sheet->getStyle("A".$row5.":$LF".$row8)->applyFromArray($headTitleLocalidad);

            $sheet->getRowDimension($row6)->setRowHeight(9);
            $sheet->getRowDimension($row8)->setRowHeight(14);
            $sheet->getRowDimension($row5)->setRowHeight(17);
            $sheet->getRowDimension($row7)->setRowHeight(17);
            $sheet->mergeCells($LI.$row5.":C".$row6);
            $sheet->mergeCells($LI.$row7.":C".$row8);

            $sheet->setCellValue("A5", "LOCALIDAD (EESS):");
            $sheet->setCellValue("A7","NOMBRES Y APELLIDOS DEL INSPECTOR:");
            $sheet->mergeCells("D".$row5.":G".$row5);
            $sheet->mergeCells("I".$row5.":O".$row5);
            $sheet->mergeCells("D".$row6.":G".$row6);
            $sheet->mergeCells("I".$row6.":O".$row6);

            $sheet->mergeCells("D".$row7.":O".$row7);
            $sheet->mergeCells("D".$row8.":O".$row8);

            $sheet->getStyle("D".$row5)->getFont()->setBold(false);
            $sheet->getStyle("D".$row7)->getFont()->setBold(false);
            $sheet->getStyle("I".$row5)->getFont()->setBold(false);
            $sheet->getStyle("T".$row5)->getFont()->setBold(false);
            $sheet->getStyle("AM".$row5)->getFont()->setBold(false);

            $sheet->getStyle("D".$row5.":G".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("I".$row5.":O".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("D".$row7.":O".$row7)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

            $sheet->mergeCells("H5:H6");
            $sheet->mergeCells("P5:P8");
            $sheet->mergeCells("AH5:AH6");
            $sheet->mergeCells("AL5:AL6");
            $sheet->mergeCells("AR5:AR6");
            $sheet->mergeCells("AQ7:AR7");

            $sheet->mergeCells("Q".$row5.":S".$row6);
            $sheet->mergeCells("Q".$row7.":S".$row8);
            $sheet->setCellValue("Q".$row5, "SECTOR:");
            $sheet->setCellValue("Q".$row7, "ACTIVIDAD:");

            $sheet->mergeCells("T".$row5.":AG".$row5);
            $sheet->mergeCells("T".$row6.":AG".$row6);
            $sheet->getStyle("T".$row5.":AG".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

            $sheet->mergeCells("AI".$row5.":AK".$row6);
            $sheet->setCellValue("AI".$row5, "FECHA:");
            $sheet->setCellValue("AM".$row5,  $fechCont);
            $sheet->mergeCells("AM".$row5.":AQ".$row5);
            $sheet->mergeCells("AM".$row6.":AQ".$row6);
            $sheet->getStyle("AM".$row5.":AQ".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

            $tipoActividadChecked = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER
                ],
            ];

            $sheet->mergeCells("T".$row7.":W".$row7);
            $sheet->setCellValue("T".$row7, "VIGILANCIA");
            $sheet->getStyle("Y".$row7)->applyFromArray($tipoActividadChecked);

            $sheet->mergeCells("AA".$row7.":AC".$row7);
            $sheet->setCellValue("AA".$row7, "CONTROL");
            $sheet->getStyle("AD".$row7)->applyFromArray($tipoActividadChecked);

            $sheet->mergeCells("AF".$row7.":AI".$row7);
            $sheet->setCellValue("AF".$row7, "RECUPERACIÓN");
            $sheet->getStyle("AJ".$row7)->applyFromArray($tipoActividadChecked);

            $sheet->mergeCells("AL".$row7.":AN".$row7);
            $sheet->setCellValue("AL".$row7, "CERCO");
            $sheet->getStyle("AO".$row7)->applyFromArray($tipoActividadChecked);

            $sheet->mergeCells("T".$row8.":AR".$row8);

            $sheet->setCellValue("D5",$localidad);
            $sheet->setCellValue("I5",$eess);
            $sheet->setCellValue("T5",$sector);
            $sheet->setCellValue("D7",$inspecctor);
            $sheet->setCellValue($cellTipoAct."7",'X');
        }else{
            return redirect()->to(base_url('reportes-inspeccion'));
        }
    }
    
    public function c_reportes_inspeccion_body($sheet, $dataInspeccionDetalle, $codInspeccion) {
        
        if(isset($sheet) && !empty($sheet)){
            $LI = $this->configLetterInicia;
            $LF = $this->configLetterFin;

            $styleTableHead = [
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

            $styleTableLista = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 11
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
            $sheet->getStyle($LI."9:".$LF."12")->applyFromArray($styleTableHead);
            $sheet->getStyle($LI."13:".$LF."37")->applyFromArray($styleTableLista);

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
            $cantidad = 0;

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
                    9 => [1 => 'AL',2 => 'AM',3 => 'AN',4 => 'AO', 5 => 'AO'],
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

                    if($keyDepTip === 1 && $keyDep === 1){
                        $cantidad = $cantidad + $depCantidad;
                    }
                }
                $rowActual++;
            }

            $sheet->fromArray($arrDataInspeccionDetalle, NULL, $LI."13");

            // ****

            $styleTableListaTotal = [
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
            $sheet->getStyle($LI."38:".$LF."38")->applyFromArray($styleTableListaTotal);

            $row38 = 38;
            $CI = 13;
            // $sheet->setCellValue("E38", "=SUM(E$CI:E37)" );
            // $sheet->getCell("E$row38")->getCalculatedValue();

            foreach($arrDepositosColLetter as $arrCel){
                foreach($arrCel as $cel){
                    $colSuma = $cel.$CI.":".$cel."37";
                    $sheet->setCellValue("$cel$row38", "=SUM($colSuma)" );
                    $sheet->getCell("$cel$row38")->getCalculatedValue();
                }
            }

            $sheet->setCellValue("AQ38", "=SUM(AQ$CI:AQ37)" );
            $sheet->getCell("AQ$row38")->getCalculatedValue();

        }else{
            return redirect()->to(base_url('reportes-inspeccion'));
        }
    }

    public function c_reportes_inspeccion_footer($sheet, $codControl) {
        if($sheet){
            $LI = $this->configLetterInicia;
            $LF = $this->configLetterFin;

            $styleConsolidadoTable = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 11
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ],
                ],
            ];

            $styleBordetBotton = [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => Color::COLOR_BLACK],
                    ],
                ],
            ];

            $styleBorderTableBorderWhite = [
                'borders' => [
                    'inside' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => Color::COLOR_WHITE],
                    ],
                ],
            ];

            $styleBorderTableBorderDark = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => Color::COLOR_BLACK],
                    ],
                ],
            ];

            // $headTitleFormato = [
            //     'alignment' => [
            //         'horizontal' => Alignment::HORIZONTAL_CENTER,
            //         'vertical' => Alignment::VERTICAL_CENTER
            //     ],
            // ];
            
            $row40 = 40;
            $row41 = 41;
            $row42 = 42;
            $row43 = 43;
            $row44 = 44;
            $row45 = 45;
            $row46 = 46;
            $row47 = 47;

            $sheet->mergeCells("B$row40:D$row40");
            $sheet->mergeCells("F$row40:AR$row40");
            $sheet->mergeCells("G$row41:AR$row41");
            $sheet->mergeCells("G$row42:AR$row42");
            $sheet->mergeCells("F$row43:$LF$row43");
            $sheet->mergeCells("F$row47:$LF$row47");
            $sheet->mergeCells("F$row44:I$row44");
            $sheet->mergeCells("F$row45:I$row45");
            $sheet->mergeCells("J$row44:N$row44");
            $sheet->mergeCells("J$row45:N$row45");
            $sheet->mergeCells("S$row45:Y$row45");
            $sheet->mergeCells("S$row46:Y$row46");
            $sheet->mergeCells("AH$row45:AO$row45");
            $sheet->mergeCells("AH$row46:AO$row46");

            $sheet->setCellValue("B$row40", "Consolidado");
            $sheet->getStyle("B$row40:D47")->applyFromArray($styleConsolidadoTable);
            $sheet->getStyle("F$row40:$LF$row42")->applyFromArray($styleConsolidadoTable);
            $sheet->getStyle("F$row44:$LF$row46")->applyFromArray($styleBorderTableBorderWhite);
            $sheet->getStyle("F$row44:$LF$row46")->applyFromArray($styleBorderTableBorderDark);
            $sheet->setCellValue("F$row44", "Hora de ingreso");
            $sheet->getStyle("J$row44:N$row44")->applyFromArray($styleBordetBotton);
            $sheet->setCellValue("F$row45", "Hora de salida");
            $sheet->getStyle("J$row45:N$row45")->applyFromArray($styleBordetBotton);
            $sheet->setCellValue("S$row46", "FIRMA DEL JEFE DE BRIGADA");
            $sheet->getStyle("S$row46")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("S$row45:Y$row45")->applyFromArray($styleBordetBotton);
            $sheet->setCellValue("AH$row46", "FIRMA DEL JEFE DEL INSPECTOR");
            $sheet->getStyle("AH$row45:AO$row45")->applyFromArray($styleBordetBotton);
            $sheet->getStyle("AH$row46")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $arrNum = [1,2,3,4,5,6,7];
            $arrTipViv = ['inspeccionadas','cerradas','renuentes','deshabitadas','tratadas','positivas','positivos'];

            $count = 41;
            foreach ($arrNum as $key => $num) {
                $sheet->getStyle("B$count")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->setCellValue("B$count", $num);

                $tipo = ($key < 6) ? 'viviendas ' : 'recipientes ';
                $sheet->setCellValue("C$count", $tipo.$arrTipViv[$key]);
                $count++;
            }

            $consolidadoViv = $this->mreportes->mreporte_inspeccion_inspeccionados_consolidado_viv($codControl);
            $consolidadoTipoDep = $this->mreportes->mreporte_inspeccion_inspeccionados_consolidado_tipodep($codControl);

            if(!empty($consolidadoViv) && !empty($consolidadoTipoDep)){
                $insp = $consolidadoViv->inspe;
                $renu = $consolidadoViv->renu;
                $desha = $consolidadoViv->desha;
                $cerra = $consolidadoViv->cerra;
                $posi = $consolidadoTipoDep->posi;
                $trat = $consolidadoTipoDep->trat;

                $sheet->setCellValue("D41", $insp);
                $sheet->setCellValue("D42", $cerra);
                $sheet->setCellValue("D43", $renu);
                $sheet->setCellValue("D44", $desha);

                $sheet->setCellValue("D45", $trat);
                $sheet->setCellValue("D46", $posi);
                $sheet->setCellValue("D47", $posi);

            }

            $sheet->setCellValue("F$row40", "Abreriaturas");
            $sheet->setCellValue("F$row41", "1");
            $sheet->setCellValue("F$row42", "2");

            $objRichTextViv = new RichText();
            $textResDir = $objRichTextViv->createText("");
            $textResDir = $objRichTextViv->createTextRun("Viviendas: ");
            $textResDir->getFont()->setBold(true);
            $textResDir = $objRichTextViv->createText("si la vivienda no se pudo inspeccionar consignar C(vivienda cerrada), R(vivienda renuente) o D(vivienda deshabitada).");

            $sheet->setCellValue("G$row41", $objRichTextViv);

            $objRichTextDep = new RichText();
            $textResDir = $objRichTextDep->createText("");
            $textResDir = $objRichTextDep->createTextRun("Depositos: ");
                $textResDir->getFont()->setBold(true);
            $textResDir = $objRichTextDep->createText("en la columna: ");
            $textResDir = $objRichTextDep->createTextRun("I");
                $textResDir->getFont()->setBold(true);
            $textResDir = $objRichTextDep->createText("(inspeccionado), ");
            $textResDir = $objRichTextDep->createTextRun("P");
            $textResDir->getFont()->setBold(true);
            $textResDir = $objRichTextDep->createText("(positivo), ");
            $textResDir = $objRichTextDep->createTextRun("TQ");
            $textResDir->getFont()->setBold(true);
            $textResDir = $objRichTextDep->createText("(tratamiento fisico), ");
            $textResDir = $objRichTextDep->createTextRun("D");
            $textResDir->getFont()->setBold(true);
            $textResDir = $objRichTextDep->createText("(destruido), ");
            $textResDir = $objRichTextDep->createText("colocar el número de recipientes segun corresponda.");
            $sheet->setCellValue("G$row42", $objRichTextDep);



        }
    }

}
?>