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
                $this->c_reportes_inspeccion_body($sheet, $dataInspeccionDetalle, $codInspeccion);
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

            $sheet->getStyle("D".$row5.":G".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("I".$row5.":O".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("D".$row7.":O".$row7)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

            $sheet->mergeCells("Q".$row5.":S".$row6);
            $sheet->mergeCells("Q".$row7.":S".$row8);
            $sheet->setCellValue("Q".$row5, "SECTOR:");
            $sheet->setCellValue("Q".$row7, "ACTIVIDAD:");

            $sheet->mergeCells("T".$row5.":AG".$row5);
            $sheet->mergeCells("T".$row6.":AG".$row6);
            $sheet->getStyle("T".$row5.":AG".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

            $sheet->mergeCells("AI".$row5.":AK".$row6);
            $sheet->setCellValue("AI".$row5, "FECHA:");
            $sheet->mergeCells("AM".$row5.":AQ".$row5);
            $sheet->mergeCells("AM".$row6.":AQ".$row6);
            $sheet->getStyle("AM".$row5.":AQ".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

            $sheet->mergeCells("U".$row7.":W".$row7);
            $sheet->setCellValue("U".$row7, "VIGILANCIA");
            $sheet->getStyle("Y".$row7)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->mergeCells("AA".$row7.":AC".$row7);
            $sheet->setCellValue("AA".$row7, "CONTROL");
            $sheet->getStyle("AD".$row7)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->mergeCells("AF".$row7.":AI".$row7);
            $sheet->setCellValue("AF".$row7, "RECUPERACIÓN");
            $sheet->getStyle("AJ".$row7)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->mergeCells("AL".$row7.":AN".$row7);
            $sheet->setCellValue("AL".$row7, "CONTROL");
            $sheet->getStyle("AO".$row7)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $sheet->mergeCells("T".$row8.":AR".$row8);

            $sheet->setCellValue("I5",$eess.$sector);
            $sheet->setCellValue("D7",$inspecctor);

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
            $dataDepTipw = $this->mreportes->mreporte_inspeccion_inspeccionados_depositos_tipos_total($codInspeccion);
            $tanque_elevado_I = $dataDepTipw->tanque_elevado_I;
            $tanque_elevado_P = $dataDepTipw->tanque_elevado_P;
            $tanque_elevado_TQ = $dataDepTipw->tanque_elevado_TQ;
            $tanque_elevado_TH = $dataDepTipw->tanque_elevado_TH;

            $sheet->setCellValue("E".$row38, $tanque_elevado_I);
            $sheet->setCellValue("F".$row38, $tanque_elevado_P);
            $sheet->setCellValue("G".$row38, $tanque_elevado_TQ);
            $sheet->setCellValue("H".$row38, $tanque_elevado_TH);

            $tanque_bajo_I = $dataDepTipw->tanque_bajo_I;
            $tanque_bajo_P = $dataDepTipw->tanque_bajo_P;
            $tanque_bajo_TQ = $dataDepTipw->tanque_bajo_TQ;
            $tanque_bajo_TH = $dataDepTipw->tanque_bajo_TH;
            
            $sheet->setCellValue("I".$row38, $tanque_bajo_I);
            $sheet->setCellValue("J".$row38, $tanque_bajo_P);
            $sheet->setCellValue("K".$row38, $tanque_bajo_TQ);
            $sheet->setCellValue("L".$row38, $tanque_bajo_TH);

            $barril_I = $dataDepTipw->barril_I;
            $barril_P = $dataDepTipw->barril_P;
            $barril_TQ = $dataDepTipw->barril_TQ;
            $barril_TH = $dataDepTipw->barril_TH;

            $sheet->setCellValue("M".$row38, $barril_I);
            $sheet->setCellValue("N".$row38, $barril_P);
            $sheet->setCellValue("O".$row38, $barril_TQ);
            $sheet->setCellValue("P".$row38, $barril_TH);

            $sanzon_I = $dataDepTipw->sanzon_I;
            $sanzon_P = $dataDepTipw->sanzon_P;
            $sanzon_TQ = $dataDepTipw->sanzon_TQ;
            $sanzon_TH = $dataDepTipw->sanzon_TH;

            $sheet->setCellValue("Q".$row38, $sanzon_I);
            $sheet->setCellValue("R".$row38, $sanzon_P);
            $sheet->setCellValue("S".$row38, $sanzon_TQ);
            $sheet->setCellValue("T".$row38, $sanzon_TH);

            $balde_I = $dataDepTipw->balde_I;
            $balde_P = $dataDepTipw->balde_P;
            $balde_TQ = $dataDepTipw->balde_TQ;
            $balde_TH = $dataDepTipw->balde_TH;

            $sheet->setCellValue("U".$row38, $balde_I);
            $sheet->setCellValue("V".$row38, $balde_P);
            $sheet->setCellValue("W".$row38, $balde_TQ);
            $sheet->setCellValue("X".$row38, $balde_TH);

                // $recipientes = [1, 2, 3, 4, 5, 6, 7, 8];
                // $tipoRec     = [1, 2, 3, 4, 5];

                // $res = $this->mreportes->mreporte_inspeccion_inspeccionados_depositos_re([1, 2, $codInspeccion]);

                // $dataTotal= [];
                // foreach ($recipientes as $keyRec => $rec) {
                //     foreach ($tipoRec as $keyTre => $tre) {
                //         if($rec < 7 && $tre < 5){
                //             break;
                //         }

                //         $codRec = $recipientes[$keyRec];
                //         $codTipRec = $tipoRec[$keyTre];
                //         $data = [$codRec, $codTipRec];
                //         $dataTotal[] = $this->mreportes->mreporte_inspeccion_inspeccionados_depositos_re([$codRec, $codTipRec, $codInspeccion]);
                        
                //     }
                // }
                // $count = $dataTotal[0]->total;
                // $sheet->setCellValue("E".$row38, $res->total);
            
            // $this->mreportes->mreporte_inspeccion_inspeccionados_depositos_tipos_total($codInspeccion);
            // if(!empty($dataDepTip)){
            //     // $arrTotalDepTip = [
            //     //     ['E',$dataDepTip->tanque_elevado_I],
            //     //     ['F',$dataDepTip->tanque_elevado_P],
            //     //     ['G',$dataDepTip->tanque_elevado_TQ],
            //     //     ['H',$dataDepTip->tanque_elevado_TH],
            //     // ];

            //     // $arrTotalDepTip = [
            //     //     [
            //     //         $dataDepTip->tanque_elevado_I,
            //     //         $dataDepTip->tanque_elevado_P,
            //     //         $dataDepTip->tanque_elevado_TQ,
            //     //         $dataDepTip->tanque_elevado_TH
            //     //     ],
            //     //     [1]
            //     // ];

            //     $arrDepTip = [];
            //     // foreach($dataDepTip as $key => $tip){
            //     //     $arrTotalDepTip[] = $tip;
            //     // }
            //     // foreach ($arrDepositosColLetter as $key => $arrCol) {
            //     //     foreach($arrCol as $keyChil => $colttt){//A,B,C,D
            //     //         // if ($keyChil < 4) {
            //     //             # code...
            //     //             $count = $arrTotalDepTip[$key][$keyChil];
            //     //             // $arrDepTip[$key] = [$colttt, $count];
            //     //             $sheet->setCellValue($colttt.$row38, $count);
            //     //         // }
            //     //     }
            //     // }

            //     // foreach ($arrDepTip as $key => $tdt) {
            //     //     [$letter, $suma] = $tdt;
            //     //     $sheet->setCellValue($letter.$row38,$suma);
            //     // }
            // }
            
            // $sheet->fromArray($dataDepTip, NULL, "E39");

        }else{
            return redirect()->to(base_url('reportes-inspeccion'));
        }
    }

    public function c_reportes_inspeccion_footer($sheet) {
        // $sheet->setCellValue('A3','FOOTER');
    }

}
?>