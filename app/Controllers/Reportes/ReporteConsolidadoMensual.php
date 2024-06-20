<?php
namespace App\Controllers\Reportes;
use App\Controllers\BaseController;
use App\Models\Reportes\MreporteConsolidadoMensualModel;

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

class ReporteConsolidadoMensual extends BaseController
{   
    protected $mreportes;
    protected $styleFontName;
    protected $configLetterInicia;
    protected $configLetterFin;
    protected $configRowFin;

    public function __construct()
    {
        $this->mreportes = new MreporteConsolidadoMensualModel();
        $this->styleFontName      = 'calibri';
        $this->configLetterInicia = 'A';
        $this->configLetterFin    = 'AI';
        $this->configRowFin    = 0;
        helper('fn_helper');
    }

    public function c_reportes_consolidado_mes_xls($localidad, $finicia, $fculmina) {

        // $codControl = bs64url_dec($codControl);
        $fecinicia = $finicia;
        $fecfin = $fculmina;

        if((isset($localidad) && !empty($localidad)) && (isset($fecinicia) && !empty($fecinicia)) &&(isset($fecfin) && !empty($fecfin))){
            $databuscar=array();
            $databuscar[] = $fecinicia;
            $databuscar[] = $fecfin;
            $databuscar[] = bs64url_dec($localidad);
            // $dataConsolida = $this->mreportes->mreporte_consolidado_mes_head($databuscar);

            if(isset($databuscar) && !empty($databuscar)){
                setlocale(LC_ALL,"es_ES");
                date_default_timezone_set('America/Lima');
                $arrayMes = array('ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SETIEMBRE','OBTUBRE','NOVIEMBRE','DICIEMBRE');
                $fechaformat = new \DateTime($fecinicia);//DateTime::createFromFormat('Y-m-d', $fecinicia);
                $mesreport = $arrayMes[date($fechaformat->format("n"))];

                $objSheet = new Spreadsheet();
                $sheet = $objSheet->getActiveSheet();
                $sheet->setTitle('Reporte Consolidado Mensual');
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setHorizontalCentered(true);
                $sheet->getPageSetup()->setScale(90);
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageMargins()->setLeft(0.472441);
                $sheet->getPageMargins()->setRight(0.393701);

                // $codInspeccion = $dataConsolida->key_control;
                // if ( isset($codInspeccion) && !empty($codInspeccion) ) {
                    $dataInspeccionDetalle = $this->mreportes->mreporte_consolidado_mes_detalle_lista($databuscar);
                    $dataInspeccionDetalleDepos = $this->mreportes->mreporte_consolidado_mensual_tipos_depositos($databuscar);
                // }


                $this->c_reportes_inspeccion_header($sheet, $mesreport);
                $this->c_reportes_inspeccion_body($sheet, $dataInspeccionDetalle, $dataInspeccionDetalleDepos);
                $this->c_reportes_inspeccion_footer($sheet);

                $writer = new Xlsx($objSheet);
                $filePath = "Reporte Consolidado_Mensual.xlsx";
                $writer->save($filePath);

                $response = service('response');
                $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                $response->setHeader('Content-Disposition', 'attachment; filename="'.$filePath.'"');
                $response->setBody(file_get_contents($filePath));

                return $response;
            }else{
                return redirect()->to(base_url('reportes-consolidado-mes'));
            }
        }else{
            return redirect()->to(base_url('reportes-consolidado-mes'));
        }
    }

    public function c_reportes_inspeccion_header($sheet,$mes) {

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
            $sheet->setCellValue($LI."1",'NTS N° 198 - MINSA/DIGESA-2023');
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
            $sheet->setCellValue($LI.$row3, 'Formato 05: Consolidado Mensual de vigilancia del Aedes aegypti');

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

            $sheet->setCellValue("E".$row4,'CONSOLIDADO MENSUAL DE VIGILANCIA DEL Aedes aegypti');
            
            $sheet->getStyle("E".$row4)->applyFromArray($headTitleInspeccion);
            $sheet->mergeCells("E".$row4.":".$LF.$row4);
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
            $sheet->getStyle("A".$row5.":$LF".$row6)->applyFromArray($headTitleLocalidad);

            $sheet->getRowDimension($row6)->setRowHeight(9);
            // $sheet->getRowDimension($row8)->setRowHeight(14);
            $sheet->getRowDimension($row5)->setRowHeight(17);
            // $sheet->getRowDimension($row7)->setRowHeight(17);
            $sheet->mergeCells($LI.$row5.":C".$row6);
            // $sheet->mergeCells($LI.$row7.":C".$row8);

            $sheet->setCellValue("A5", "DIRESA / GERESA / DIRIS.");
            $sheet->setCellValue("M5","MES");
            $sheet->mergeCells("D".$row5.":K".$row5);
            $sheet->mergeCells("O".$row5.":S".$row5);

            $sheet->getStyle("D".$row5)->getFont()->setBold(false);
            $sheet->getStyle("O".$row5)->getFont()->setBold(false);

            $sheet->getStyle("D".$row5.":K".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("O".$row5.":S".$row5)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
            $sheet->setCellValue("O5", $mes);

        }else{
            return redirect()->to(base_url('reportes-consolidado-mes'));
        }
    }

    public function c_reportes_inspeccion_body($sheet, $dataInspeccionDetalle, $dataInspeccionDetalleDepos) {
        
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

            $styleTableFecIniFin = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 10
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
            $sheet->getStyle($LI."7:".$LF."10")->applyFromArray($styleTableHead);

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
            $sheet->getStyle("E7:AI10")->applyFromArray($styleHeadTableTexHorizontal);

            $row7 = 7;
            $row10 = 10;

            $sheet->mergeCells($LI.$row7.":".$LI.$row10);
            $sheet->mergeCells("B".$row7.":"."B".$row10);
            $sheet->mergeCells("C".$row7.":"."C".$row10);
            $sheet->mergeCells("D".$row7.":"."D".$row10);
            $sheet->mergeCells("E".$row7.":"."E".$row10);
            $sheet->mergeCells("F".$row7.":"."F".$row10);
            $sheet->mergeCells("G".$row7.":"."G".$row10);
            $sheet->mergeCells("H".$row7.":"."H".$row10);
            $sheet->mergeCells("I".$row7.":"."I".$row10);
            $sheet->mergeCells("J".$row7.":"."J".$row10);
            $sheet->mergeCells("K".$row7.":"."K".$row10);
            $sheet->mergeCells("L".$row7.":"."L".$row10);
            $sheet->mergeCells("M".$row7.":"."M".$row10);
            $sheet->mergeCells("N".$row7.":"."N".$row10);
            $sheet->mergeCells("O".$row7.":"."O".$row10);
            $sheet->mergeCells("AH".$row7.":"."AH".$row10);
            $sheet->mergeCells("AI".$row7.":"."AI".$row10);

            $sheet->setCellValue($LI.$row7,'Provincia');
            $sheet->setCellValue("B".$row7,'Distrito');
            $sheet->setCellValue("C".$row7,'Red de Salud');
            $sheet->setCellValue("D".$row7,'Establecimiento de Salud (Localidad)');
            $sheet->setCellValue("E".$row7,'Esc entom');
            $sheet->setCellValue("F".$row7,'N° de resid.');
            $sheet->setCellValue("G".$row7,'N° viv. Totales');
            $sheet->setCellValue("H".$row7,'N° viv. Prog.');
            $sheet->setCellValue("I".$row7,'N° viv. Insp.');
            $sheet->setCellValue("J".$row7,'N° viv. Posit.');
            $sheet->setCellValue("K".$row7,'N° recip. Insp');
            $sheet->setCellValue("L".$row7,'N° recip. Posit.');
            $sheet->setCellValue("M".$row7,'IA');
            $sheet->setCellValue("N".$row7,'IR');
            $sheet->setCellValue("O".$row7,'IB');
            $sheet->setCellValue("AH".$row7,'Fecha de Inicio');
            $sheet->setCellValue("AI".$row7,'Fecha de Termino');

            $arrColTextHori = ['A','B','D','E','F','G','H','I','J','K','L','M','N','O','AH','AI'];
            foreach ($arrColTextHori as $key => $cel) {
                $sheet->getStyle($cel.$row7)->applyFromArray($styleHeadTableTexHorizontal);
            }

            $sheet->getColumnDimension("A")->setWidth(9);
            $sheet->getColumnDimension("B")->setWidth(9);
            $sheet->getColumnDimension("C")->setWidth(11);
            $sheet->getColumnDimension("D")->setWidth(15);
            $sheet->getColumnDimension("E")->setWidth(7);
            $sheet->getColumnDimension("F")->setWidth(7);
            $sheet->getColumnDimension("G")->setWidth(8);
            $sheet->getColumnDimension("H")->setWidth(7);
            $sheet->getColumnDimension("I")->setWidth(7);
            $sheet->getColumnDimension("J")->setWidth(7);
            $sheet->getColumnDimension("K")->setWidth(8);
            $sheet->getColumnDimension("L")->setWidth(8);
            $sheet->getColumnDimension("M")->setWidth(4);
            $sheet->getColumnDimension("N")->setWidth(4);
            $sheet->getColumnDimension("O")->setWidth(4);
            $sheet->getColumnDimension("AH")->setWidth(11);
            $sheet->getColumnDimension("AI")->setWidth(11);

            /** */
            $row7= 7;
            $sheet->mergeCells("P$row7:AG$row7");
            $sheet->setCellValue("P7",'Depósitos');
            /** */

            //** */
            $row8 = 8;
            $sheet->mergeCells("P$row8:S$row8");
            $sheet->mergeCells("T$row8:U$row8");
            $sheet->mergeCells("V$row8:W$row8");
            $sheet->mergeCells("X$row8:Y$row8");

            $sheet->setCellValue("P$row8", ">= 500 L");
            $sheet->setCellValue("T$row8", "`= 200 L`");
            $sheet->setCellValue("V$row8", "< 200 L - 100 L");
            $sheet->setCellValue("X$row8", "< 100 L");
            //** */

            // ***
            $row9 = 9;
            $arrDepositosCol = ['P,Q', 'R,S', 'T,U', 'V,W', 'X,Y'];
            foreach ($arrDepositosCol as $key => $dep) {
                $arrLetter = explode(',', $dep);
                [$colIni, $colFin] = $arrLetter;
                $sheet->mergeCells("$colIni$row9:$colFin$row9");  
            }
            $sheet->mergeCells("Z8:AA$row9");
            $sheet->mergeCells("AB8:AC$row9");
            $sheet->mergeCells("AD8:AE$row9");
            $sheet->mergeCells("AF8:AG$row9");
            $sheet->getRowDimension($row9)->setRowHeight(37);

            $sheet->setCellValue("P".$row9, "Tanque alto");
            $sheet->setCellValue("R".$row9, "Tanque bajo");
            $sheet->setCellValue("T".$row9, "Barril-cilindro");
            $sheet->setCellValue("V".$row9, "Sansón-bidon");
            $sheet->setCellValue("X".$row9, "Baldes, bateas, tinajas");
            $sheet->setCellValue("Z8", "Llantas");
            $sheet->setCellValue("AB8", "Floreros, maceteros");
            $sheet->setCellValue("AD8", "Latas, botellas");
            $sheet->setCellValue("AF8", "Otros");
            //** */

            //** Row 10*/
            $arrDepositosColLetter = 
            [
                ['P','Q'],
                ['R','S'],
                ['T','U'],
                ['V','W'],
                ['X','Y'],
                ['Z','AA'],
                ['AB','AC'],
                ['AD','AE'],
                ['AF','AG']
            ];
            $arrDepositoTipo = ['I','P'];

            foreach ($arrDepositosColLetter as $key => $col) {
                foreach ($col as $key => $let) {
                    $depTipo = $arrDepositoTipo[$key];
                    $sheet->setCellValue($let.$row10,$depTipo);
                    $sheet->getColumnDimension($let)->setWidth(4);
                }
            }
            //** */

            $arrDataInspeccionDetalle = [];
            $rowActual = 11;
            $cantidad = 0;

            foreach ($dataInspeccionDetalle as $key => $det) {
                $count = ++$key;
                $keyDetIns = $det->key_detalle_control;
                $provinc    = $det->provincia;
                $distrit    = $det->distrito;
                $redsalud   = "";
                $establec   = $det->eess;
                $fechainicia= fdate($det->fecinicia);
                $fechafin   = fdate($det->fecfin);
                $rresiden  = $det->n_resid;
                $vivinsp = $det->sit_vivIns;
                $vivposit = $det->sit_vivPost;

                // $dataDetalleInspTipoVivI = $this->mreportes->mreporte_consolidado_mensual_viviendas(array(1,$keyDetIns));
                // $vivinsp = $dataDetalleInspTipoVivI->key_vivienda;
                // $dataDetalleInspTipoVivP = $this->mreportes->mreporte_consolidado_mensual_viviendas(array(6,$keyDetIns));
                // $vivposit = $dataDetalleInspTipoVivP->key_vivienda;

                $colTotViv = $vivinsp + $vivposit;

                $arrDataInspeccionDetalle[$key] = [$provinc, $distrit, $redsalud, $establec, "", $rresiden, $colTotViv, "", $vivinsp, $vivposit, $vivinsp, $vivposit];
                
                $sheet->setCellValue("AH".$rowActual, $fechainicia);
                $sheet->setCellValue("AI".$rowActual, $fechafin);

                // Detalle

                $letterDepTipDetalle = [
                    1 => [1 => 'P',2 => 'Q'],
                    2 => [1 => 'R',2 => 'S'],
                    3 => [1 => 'T',2 => 'U'],
                    4 => [1 => 'V',2 => 'W'],
                    5 => [1 => 'X',2 => 'Y'],
                    6 => [1 => 'Z',2 => 'AA'],
                    7 => [1 => 'AB',2 => 'AC'],
                    8 => [1 => 'AD',2 => 'AE'],
                    9 => [1 => 'AF',2 => 'AG'],
                ];

                $arrColDepositos = ['P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG'];

                foreach ($dataInspeccionDetalleDepos as $key => $dpst) {
                    if ($det->fecinicia == $dpst->finicia && $det->ideess == $dpst->ideess) {
                        $sheet->setCellValue("P".$rowActual,$dpst->TAI);
                        $sheet->setCellValue("Q".$rowActual,$dpst->TAP);
                        $sheet->setCellValue("R".$rowActual,$dpst->TBI);
                        $sheet->setCellValue("S".$rowActual,$dpst->TBP);
                        $sheet->setCellValue("T".$rowActual,$dpst->BCI);
                        $sheet->setCellValue("U".$rowActual,$dpst->BCP);
                        $sheet->setCellValue("V".$rowActual,$dpst->SSI);
                        $sheet->setCellValue("W".$rowActual,$dpst->SSP);
                        $sheet->setCellValue("X".$rowActual,$dpst->BBTI);
                        $sheet->setCellValue("Y".$rowActual,$dpst->BBTP);
                        $sheet->setCellValue("Z".$rowActual,$dpst->LLI);
                        $sheet->setCellValue("AA".$rowActual,$dpst->LLP);
                        $sheet->setCellValue("AB".$rowActual,$dpst->FLI);
                        $sheet->setCellValue("AC".$rowActual,$dpst->FLP);
                        $sheet->setCellValue("AD".$rowActual,$dpst->LTI);
                        $sheet->setCellValue("AE".$rowActual,$dpst->LTP);
                        $sheet->setCellValue("AF".$rowActual,$dpst->OTI);
                        $sheet->setCellValue("AG".$rowActual,$dpst->OTP);
                        
                    }
                }

                // $dataDetalleInspTipoDep = $this->mreportes->mreporte_consolidado_mensual_depositos_tipos($keyDetIns);

                // foreach ($dataDetalleInspTipoDep as $key => $dtp) {
                //     $keyDep      = (int) $dtp->key_deposito;
                //     $keyDepTip   = (int) $dtp->key_dep_tipo;
                //     $depCantidad = $dtp->cantidad;

                //     if(array_key_exists($keyDep, $letterDepTipDetalle)){
                //         $arrDepTipDetalle = $letterDepTipDetalle[$keyDep];
                        
                //         if(array_key_exists($keyDepTip, $arrDepTipDetalle)){
                //             $letteCurrent = $arrDepTipDetalle[$keyDepTip];
                //             $sheet->setCellValue($letteCurrent.$rowActual,$depCantidad);
                            
                //         }
                //     }

                //     if($keyDepTip === 1 && $keyDep === 1){
                //         $cantidad = $cantidad + $depCantidad;
                //     }
                // }
                $rowActual++;
            }
            $sheet->getStyle($LI."11:".$LF.$rowActual-1)->applyFromArray($styleTableLista);
            $sheet->fromArray($arrDataInspeccionDetalle, NULL, $LI."11");

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
            $sheet->getStyle($LI."{$rowActual}:".$LF."$rowActual")->applyFromArray($styleTableListaTotal);

            $rowEnd = $rowActual;
            $rowEndAnt = $rowEnd - 1;
            $CI = 11;

            $sheet->mergeCells($LI.$rowEnd.":"."F{$rowEnd}");
            $sheet->setCellValue($LI.$rowEnd, 'Total');
            $sheet->setCellValue("G{$rowEnd}", "=SUM(G$CI:G{$rowEndAnt})" );
            $sheet->getCell("G$rowEnd")->getCalculatedValue();
            $sheet->setCellValue("I{$rowEnd}", "=SUM(I$CI:I{$rowEndAnt})" );
            $sheet->getCell("I$rowEnd")->getCalculatedValue();
            $sheet->setCellValue("J{$rowEnd}", "=SUM(J$CI:J{$rowEndAnt})" );
            $sheet->getCell("J$rowEnd")->getCalculatedValue();
            $sheet->setCellValue("K{$rowEnd}", "=SUM(K$CI:K{$rowEndAnt})" );
            $sheet->getCell("K$rowEnd")->getCalculatedValue();
            $sheet->setCellValue("L{$rowEnd}", "=SUM(L$CI:L{$rowEndAnt})" );
            $sheet->getCell("L$rowEnd")->getCalculatedValue();

            foreach($arrDepositosColLetter as $arrCel){
                foreach($arrCel as $cel){
                    $colSuma = $cel.$CI.":".$cel.$rowEndAnt;
                    $sheet->setCellValue("$cel$rowEnd", "=SUM($colSuma)" );
                    $sheet->getCell("$cel$rowEnd")->getCalculatedValue();
                }
            }

            $sheet->getStyle("AH$CI:AH{$rowEndAnt}")->applyFromArray($styleTableFecIniFin);
            $sheet->getStyle("AI$CI:AI{$rowEndAnt}")->applyFromArray($styleTableFecIniFin);
            $this->configRowFin = $rowEnd;

        }else{
            return redirect()->to(base_url('reportes-consolidado-mes'));
        }
    }

    public function c_reportes_inspeccion_footer($sheet) {
        if($sheet){
            $LI = $this->configLetterInicia;
            $LF = $this->configLetterFin;
            $RF = $this->configRowFin;

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

            $styleHeadTableTexFirma = [
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
            
            $rowfinalIni = $RF + 3;
            $rowfinal = $RF + 3;

            $sheet->mergeCells("A$rowfinal:L$rowfinal");
            $sheet->setCellValue("A$rowfinal", "Persona responsable por el llenado del formato");
            $rowfinal++;
            $sheet->setCellValue("A$rowfinal", "Nombre:");
            $sheet->mergeCells("B$rowfinal:H$rowfinal");
            $sheet->setCellValue("I$rowfinal", "Fecha:");
            $sheet->mergeCells("J$rowfinal:L$rowfinal");
            $rowfinal++;
            $sheet->mergeCells("A$rowfinal:E$rowfinal");
            $sheet->setCellValue("A$rowfinal", "Función o cargo en la DIRESA/GERESA/DIRIS");
            $sheet->mergeCells("F$rowfinal:L$rowfinal");
            $rowfinal++;
            $sheet->mergeCells("A$rowfinal:E".$rowfinal+3);
            $sheet->mergeCells("F$rowfinal:L".$rowfinal+3);
            $rowfinal = $rowfinal+4;
            $sheet->mergeCells("A$rowfinal:E$rowfinal");
            $sheet->setCellValue("A$rowfinal", "Firma y sello del responsable de la vigilancia y control de vectores de la DIRESA/GERESA/DIRIS");
            $sheet->getColumnDimension("A")->setAutoSize(true);
            $sheet->mergeCells("F$rowfinal:L$rowfinal");
            $sheet->setCellValue("F$rowfinal", "Firma y sello del Director Ejecutivo de Salud Ambiental de la DIRESA/GERESA/DIRIS");
            $sheet->getColumnDimension("F")->setAutoSize(true);
            $sheet->getRowDimension($rowfinal)->setRowHeight(27);
            $sheet->getStyle("A$rowfinal:L$rowfinal")->applyFromArray($styleHeadTableTexFirma);
            $sheet->getStyle("A$rowfinalIni:L$rowfinal")->applyFromArray($styleConsolidadoTable);

        }
    }

}