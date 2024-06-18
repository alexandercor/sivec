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
        $this->configLetterFin    = 'AW';
        helper('fn_helper');
    }

    public function c_reportes_consolidado_xls($fechaIni, $fechaFin) {

        if( (isset($fechaIni) && !empty($fechaIni)) && (isset($fechaFin) && !empty($fechaFin)) ){

            $resDataInsp = $this->mreportes->m_reporte_consolidado_inspectores([$fechaIni, $fechaFin]);

            if(!empty($resDataInsp)){

                $objSheet = new Spreadsheet();
                $sheet = $objSheet->getActiveSheet();
                $sheet->setTitle('Reporte Consolidado Diario');
        
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setHorizontalCentered(true);
                $sheet->getPageSetup()->setScale(90);
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageMargins()->setLeft(0.472441);
                $sheet->getPageMargins()->setRight(0.393701);
        
                $this->c_reportes_consolidado_header($sheet);
                $this->c_reportes_consolidado_body($sheet, $resDataInsp, $fechaIni, $fechaFin);
                $this->c_reportes_consolidado_footer($sheet);
        
                $writer = new Xlsx($objSheet);
                $filePath = "Reporte Consolidado Diario.xlsx";
                $writer->save($filePath);
        
                $response = service('response');
                $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                $response->setHeader('Content-Disposition', 'attachment; filename="'.$filePath.'"');
                $response->setBody(file_get_contents($filePath));
        
                return $response;

            }else{
                return redirect()->to(base_url('reportes-consolidado-diario'));
            }

        }else{
            return redirect()->to(base_url('reportes-consolidado-diario'));
        }

    }

    public function c_reportes_consolidado_header($sheet) {

        if($sheet){
            $LI = $this->configLetterInicia;
            $LF = $this->configLetterFin;
            
            // $inspecctor = $dataInspeccion->inspecctor;
            // $eess       = $dataInspeccion->eess;
            // $sector     = $dataInspeccion->sector;
            // $localidad  = $dataInspeccion->localidad;
            // $tipoActi   = (int) $dataInspeccion->tipo_act;    

            // $cellTipoAct = match($tipoActi){
            //     1 => 'AD',
            //     2 => 'Y',
            //     3 => 'AJ',
            //     4 => 'AO',
            //     default => '',
            // };
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
            $sheet->setCellValue($LI.$row3, 'Formato 04: Consolidado diario de vigilancia y control del Aedes aegypti');
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
            $row4 = 4;
            $logo = new Drawing();
            $logo->setCoordinates($LI.$row4);
            $logo->setPath('resources/img/msalud.png');
            $logo->setHeight(35);
            $logo->setWorksheet($sheet);

            $sheet->setCellValue("D".$row4,'CONSOLIDADO DIARIO DE VIGILANCIA Y DE CONTROL del Aedes aegypti');
            
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
            $sheet->setCellValue("A7","ACTIVIDAD :");
            $sheet->mergeCells("D".$row5.":O".$row5);
            $sheet->mergeCells("D".$row6.":O".$row6);

            $sheet->getStyle("D".$row5)->getFont()->setBold(false);
            $sheet->getStyle("M".$row7)->getFont()->setBold(false);
            $sheet->getStyle("I".$row5)->getFont()->setBold(false);
            $sheet->getStyle("T".$row5)->getFont()->setBold(false);
            $sheet->getStyle("AM".$row5)->getFont()->setBold(false);

            $sheet->getStyle("D".$row5.":O".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

            $sheet->mergeCells("P5:P6");
            $sheet->mergeCells("AH5:AH6");
            $sheet->mergeCells("AR5:AV6");
            $sheet->mergeCells("X7:AE7");
            $sheet->mergeCells("AF7:AV7");
            $sheet->mergeCells("D8:AR8");

            $sheet->mergeCells("Q".$row5.":S".$row6);
            $sheet->setCellValue("Q".$row5, "SECTOR:");
            $sheet->setCellValue("X".$row7, "SUPERVISOR/JEFE DE BRIGADA:");

            $sheet->mergeCells("T".$row5.":AG".$row5);
            $sheet->mergeCells("T".$row6.":AG".$row6);
            $sheet->getStyle("T".$row5.":AG".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("AF".$row7.":AV".$row7)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

            $sheet->mergeCells("AI".$row5.":AK".$row6);
            $sheet->setCellValue("AI".$row5, "FECHA:");
            $sheet->mergeCells("AL".$row5.":AQ".$row5);
            $sheet->mergeCells("AL".$row6.":AQ".$row6);
            $sheet->getStyle("AL".$row5.":AQ".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

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

            $sheet->mergeCells("D".$row7.":F".$row7);
            $sheet->setCellValue("D".$row7, "VIGILANCIA");
            $sheet->getStyle("G".$row7)->applyFromArray($tipoActividadChecked);

            $sheet->mergeCells("I".$row7.":K".$row7);
            $sheet->setCellValue("I".$row7, "CONTROL");
            $sheet->getStyle("L".$row7)->applyFromArray($tipoActividadChecked);

            $sheet->mergeCells("N".$row7.":Q".$row7);
            $sheet->setCellValue("N".$row7, "RECUPERACIÓN");
            $sheet->getStyle("R".$row7)->applyFromArray($tipoActividadChecked);

            $sheet->mergeCells("T".$row7.":U".$row7);
            $sheet->setCellValue("T".$row7, "CERCO");
            $sheet->getStyle("V".$row7)->applyFromArray($tipoActividadChecked);

            // $sheet->mergeCells("T".$row8.":AR".$row8);

            // $sheet->setCellValue("B15",$fechaIni);
            // $sheet->setCellValue("I5",$eess);
            // $sheet->setCellValue("T5",$sector);
            // $sheet->setCellValue("D7",$inspecctor);
            // $sheet->setCellValue($cellTipoAct."7",'X');

        }else{
            return redirect()->to(base_url('reportes-inspeccion'));
        }
    }

    public function c_reportes_consolidado_body($sheet, $resDataInsp, $fechaIni, $fechaFin) {

        if (isset($sheet) && !empty($sheet)) {
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
                    'size' => 9
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
            $sheet->getStyle("E9:AW12")->applyFromArray($styleHeadTableTexHorizontal);

            $row9 = 9;
            $row12 = 12;

            $sheet->mergeCells($LI.$row9.":".$LI.$row12);
            $sheet->mergeCells("B".$row9.":"."B".$row12);
            $sheet->mergeCells("C".$row9.":"."C".$row12);
            $sheet->mergeCells("D".$row9.":"."D".$row12);
            $sheet->mergeCells("E".$row9.":"."E".$row12);
            $sheet->mergeCells("F".$row9.":"."F".$row12);
            $sheet->mergeCells("G".$row9.":"."G".$row12);
            $sheet->mergeCells("H".$row9.":"."H".$row12);
            $sheet->mergeCells("I".$row9.":"."I".$row12);
            $sheet->mergeCells("AV".$row9.":"."AV".$row12);
            $sheet->mergeCells("AW".$row9.":"."AW".$row12);

            $sheet->setCellValue($LI.$row9,'N°');
            $sheet->setCellValue("B".$row9,'Nombre de Inspector de vivienda o jefe de brigada');
            $sheet->setCellValue("C".$row9,'N° de residentes');
            $sheet->setCellValue("D".$row9,'Inspeccionadas');
            $sheet->setCellValue("E".$row9,'Cerradas');
            $sheet->setCellValue("F".$row9,'Renuentes');
            $sheet->setCellValue("G".$row9,'Deshabitadas');
            $sheet->setCellValue("H".$row9,'Tratadas');
            $sheet->setCellValue("I".$row9,'Positivos');
            $sheet->setCellValue("AV".$row9,'Consumo de Larvicida(g)');
            $sheet->setCellValue("AW".$row9,'Febriles');

            $arrColTextVert = ['C','D','E','F','G','H','I','AV','AW'];
            foreach ($arrColTextVert as $key => $cel) {
                $sheet->getStyle($cel.$row9)->applyFromArray($styleHeadTableTexVertical);
            }
            $arrColTextHori = ['A','B'];
            foreach ($arrColTextHori as $key => $cel) {
                $sheet->getStyle($cel.$row9)->applyFromArray($styleHeadTableTexHorizontal);
            }

            $sheet->getColumnDimension("A")->setWidth(4);
            $sheet->getColumnDimension("B")->setWidth(25);
            $sheet->getColumnDimension("C")->setWidth(4);
            $sheet->getColumnDimension("D")->setWidth(4);
            $sheet->getColumnDimension("E")->setWidth(4);
            $sheet->getColumnDimension("F")->setWidth(4);
            $sheet->getColumnDimension("G")->setWidth(4);
            $sheet->getColumnDimension("H")->setWidth(4);
            $sheet->getColumnDimension("I")->setWidth(4);
            $sheet->getColumnDimension("AV")->setWidth(4);
            $sheet->getColumnDimension("AW")->setWidth(4);

            /** */
            $row9= 9;
            $sheet->mergeCells("J$row9:AU$row9");
            $sheet->setCellValue("J$row9",'Depósitos');
            /** */

            //** */
            $row10 = 10;
            $sheet->mergeCells("J$row10:Q$row10");
            $sheet->mergeCells("R$row10:U$row10");
            $sheet->mergeCells("V$row10:Y$row10");
            $sheet->mergeCells("Z$row10:AC$row10");

            $sheet->setCellValue("J$row10", "> 500 L");
            $sheet->setCellValue("R$row10", "- 200 L");
            $sheet->setCellValue("V$row10", "> 200 L - 100 L");
            $sheet->setCellValue("Z$row10", "< 100 L");
            //** */

            // ***
            $row11 = 11;
            $arrDepositosCol = ['J,M', 'N,Q', 'R,U', 'V,Y', 'Z,AC'];
            foreach ($arrDepositosCol as $key => $dep) {
                $arrLetter = explode(',', $dep);
                [$colIni, $colFin] = $arrLetter;
                $sheet->mergeCells("$colIni$row11:$colFin$row11");  
            }
            $sheet->mergeCells("AD10:AG$row11");
            $sheet->mergeCells("AH10:AK$row11");
            $sheet->mergeCells("AL10:AP$row11");
            $sheet->mergeCells("AQ10:AU$row11");
            $sheet->getRowDimension($row11)->setRowHeight(40);

            $sheet->setCellValue("J".$row11, "Tanque alto");
            $sheet->setCellValue("N".$row11, "Tanque bajo");
            $sheet->setCellValue("R".$row11, "Barril-cilindro");
            $sheet->setCellValue("V".$row11, "Sansón-bidon");
            $sheet->setCellValue("Z".$row11, "Baldes, bateas, tinajas");
            $sheet->setCellValue("AD10", "Llantas");
            $sheet->setCellValue("AH10", "Floreros, maceteros");
            $sheet->setCellValue("AL10", "Latas, botellas");
            $sheet->setCellValue("AQ10", "Otros");
            //** */

            //** Row 12*/
            $arrDepositosColLetter = 
            [
                ['J','K','L','M'],
                ['N','O','P','Q'],
                ['R','S','T','U'],
                ['V','W','X','Y'],
                ['Z','AA','AB','AC'],
                ['AD','AE','AF','AG'],
                ['AH','AI','AJ','AK'],
                ['AL','AM','AN','AO','AP'],
                ['AQ','AR','AS','AT','AU']
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

            $count = 13;
            foreach ($resDataInsp as $key => $ins) {
                $numReg = ++$key;
                $keyPer = $ins->key_persona;
                $insp = $ins->inspector;
                $canRes  = $ins->cant_resi;
                $consLer = $ins->con_ler;

                $sheet->setCellValue("A$count", $numReg);
                $sheet->setCellValue("B$count", $insp);
                $sheet->setCellValue("C$count", $canRes);
                $sheet->setCellValue("AV$count", $consLer);
                $sheet->getStyle("A$count")->getFont()->setBold(true);
                $sheet->getStyle("B$count")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $resTotalesViviInp = $this->mreportes->m_reporte_consolidado_viviendas_totales([$fechaIni, $fechaFin, $keyPer]);

                // $resTotalesTipoDep = $this->mreportes->m_reporte_consolidado_tipodep_totales([$fechaIni, $fechaFin, $keyPer]);

                if(!empty($resTotalesViviInp)){
                    $vivInsp = $resTotalesViviInp->inspeccionada;
                    $vivCerr = $resTotalesViviInp->cerrada;
                    $vivRen  = $resTotalesViviInp->renuente;
                    $vivDes  = $resTotalesViviInp->deshabitada;
                    
                    // $tdePos = $resTotalesTipoDep->positivos;
                    // $tdeTra = $resTotalesTipoDep->tratados;

                    $sheet->setCellValue("D$count", $vivInsp);
                    $sheet->setCellValue("E$count", $vivCerr);
                    $sheet->setCellValue("F$count", $vivRen);
                    $sheet->setCellValue("G$count", $vivDes);

                    // $sheet->setCellValue("H$count", $tdeTra);
                    // $sheet->setCellValue("I$count", $tdePos);
                }

                $letterDepositoTipDetalle = [
                    1 => [1 => 'J',2 => 'K',3 => 'L',4 => 'M'],
                    2 => [1 => 'N',2 => 'O',3 => 'P',4 => 'Q'],
                    3 => [1 => 'R',2 => 'S',3 => 'T',4 => 'U'],
                    4 => [1 => 'V',2 => 'W',3 => 'X',4 => 'Y'],
                    5 => [1 => 'Z',2 => 'AA',3 => 'AB',4 => 'AC'],
                    6 => [1 => 'AD',2 => 'AE',3 => 'AF',4 => 'AG'],
                    7 => [1 => 'AH',2 => 'AI',3 => 'AJ',4 => 'AK'],
                    8 => [1 => 'AL',2 => 'AM',3 => 'AN',4 => 'AO', 5 => 'AP'],
                    9 => [1 => 'AQ',2 => 'AR',3 => 'AS',4 => 'AT', 5 => 'AU'],
                ];

                $countDeposito = 1;
                $countTipoDep = 1;

                foreach ($letterDepositoTipDetalle as $keyDeposito => $arrlde) {
                       
                    foreach ($arrlde as $keyTipoDep => $item) {
                        $celdaTipoDep = $item;

                        $resTotalXTipo = $this->mreportes->m_reporte_consolidado_totales_X_deposito_tipo_X_inspector([$keyDeposito, $keyTipoDep, $keyPer]);
                        if(!empty($resTotalXTipo)){
                            $total = $resTotalXTipo->total;
                            $sheet->setCellValue($celdaTipoDep.$count,$total);
                        }
                        $countDeposito++;
                    }
                    $countTipoDep++;
                }

                $arrColCalcularTotalRecTra = ['L', 'P', 'T', 'X', 'AB', 'AF', 'AJ', 'AN', 'AS'];
                $arrColCalcularTotalRecPos = ['K', 'O', 'S', 'W', 'AA', 'AE', 'AI', 'AM', 'AR'];
                $rangoTra = '';
                $rangoPos = '';

                foreach ($arrColCalcularTotalRecTra as $key => $col) {
                    $spacet = ($key < 8)? ',' : '';
                    $rangoTra .= $col. $count. $spacet;
                }

                foreach ($arrColCalcularTotalRecPos as $key => $col) {
                    $space = ($key < 8)? ',' : '';
                    $rangoPos .= $col. $count. $space;
                }

                $sheet->setCellValue("H$count", "=SUM($rangoTra)");
                $sheet->getCell("H$count")->getCalculatedValue();

                $sheet->setCellValue("I$count", "=SUM($rangoPos)");
                $sheet->getCell("I$count")->getCalculatedValue();


                $count++;
            }

            $row37 = 37;

            foreach ($arrDepositosColLetter as $key => $arrDepTipo) {
               foreach ($arrDepTipo as $key => $col) {
                    $colSuma = $col."13:".$col."36";
                    $sheet->setCellValue($col.$row37, "=SUM($colSuma)");
                    $sheet->getCell($col.$row37)->getCalculatedValue();
               }
            }

            $sheet->mergeCells("A".$row37.":C".$row37);
            $sheet->setCellValue("A".$row37, "Total");
            $colCalcularTotales = ['D', 'E', 'F', 'G', 'H', 'I', 'AV'];
            foreach ($colCalcularTotales as $key => $col) {
                $colSumaTipoViv = $col."13:".$col."36";
                $sheet->setCellValue($col.$row37, "=SUM($colSumaTipoViv)");
                $sheet->getCell($col.$row37)->getCalculatedValue();
            }

            $sheet->getStyle("A37:AW37")->getFont()->setBold(true);
        }
    }

    public function c_reportes_consolidado_footer($sheet) {
        if($sheet){

            $styleFooterObser = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 10,
                    'bold' => true
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => Border::BORDER_THIN
                    ],
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THIN
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical'   => Alignment::VERTICAL_CENTER
                ],
            ];

            $styleFooterBorders = [
                'borders' => [
                    'top' => [
                        'borderStyle' => Border::BORDER_THIN
                    ],
                    'bottom' => [
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

            $row39 = 39;
            $row40 = 40;
            $row41 = 41;
            $row42 = 42;

            $sheet->mergeCells("A$row39:"."S$row39");
            $sheet->mergeCells("A$row40:"."S$row41");
            $sheet->mergeCells("Z45:"."AD45");
            $sheet->mergeCells("Z47:"."AD47");

            $sheet->setCellValue("A$row39", "Observaciones");
            $sheet->getStyle("A$row39:S".$row39)->applyFromArray($styleFooterObser);
            $sheet->getStyle("V43:AW49")->applyFromArray($styleBorderTableBorderWhite);
            $sheet->getStyle("Z45:"."AD45")->applyFromArray($styleBordetBotton);
            $sheet->getStyle("Z47:"."AD47")->applyFromArray($styleBordetBotton);

            $count = 42;
            for ($i=0; $i < 8; $i++) { 
                $sheet->mergeCells("A$count:"."S$count");
                $sheet->getStyle("A$count:S".$count)->applyFromArray($styleFooterBorders);
                $count++;
            }

            $sheet->mergeCells("V$row39:"."AW$row39");
            $sheet->mergeCells("V$row40:"."AW$row42");

            $sheet->setCellValue("V$row39", "Abreviaturas");
            $sheet->getStyle("V$row39:"."AW".$row39)->applyFromArray($styleFooterObser);

            $sheet->setCellValue("V$row40", "Depósitos: en la columna: I(inspeccionado), P(positivo), TQ(tratamiento químico), TF(tratamiento fisico) o D(destruido), colocar el número de recipientes segun corresponda.");
            $sheet->getStyle("V$row40")->getAlignment()->setWrapText(true);
            $sheet->getStyle("V$row40")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("V$row41:AW".$row42)->applyFromArray($styleFooterBorders);

            $sheet->setCellValue("V45", "Hora de ingreso");
            $sheet->setCellValue("V47", "Hora de salida");

            $sheet->mergeCells("V$row40:"."AW$row42");
            $sheet->mergeCells("AK48:AT48");
            $sheet->mergeCells("AK49:AT49");

            $sheet->getStyle("AK48:AT48")->applyFromArray($styleBordetBotton);
            $sheet->setCellValue("AK49", "FIRMA DEL SUPERVISOR O JEFE DE BRIGADA");
            $sheet->getStyle("AK49")->getFont()->setBold(true);
            $sheet->getStyle("AK49")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        }   
    }


// ***
}
?>