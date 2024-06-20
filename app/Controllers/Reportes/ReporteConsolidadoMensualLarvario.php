<?php
namespace App\Controllers\Reportes;
use App\Controllers\BaseController;
use App\Models\Reportes\MreporteConsolidadoMensualLarvarioModel;

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

class ReporteConsolidadoMensualLarvario extends BaseController
{   
    protected $mreportes;
    protected $styleFontName;
    protected $configLetterInicia;
    protected $configLetterFin;
    protected $configRowFin;

    public function __construct()
    {
        $this->mreportes = new MreporteConsolidadoMensualLarvarioModel();
        $this->styleFontName      = 'calibri';
        $this->configLetterInicia = 'A';
        $this->configLetterFin    = 'BH';
        $this->configRowFin    = 0;
        helper('fn_helper');
    }

    public function c_reportes_consolidado_mes_larvario_xls($localidad, $finicia, $fculmina) {

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
                $fechaformat = new \DateTime($fecinicia);
                $mesreport = $arrayMes[date($fechaformat->format("n"))];

                $objSheet = new Spreadsheet();
                $sheet = $objSheet->getActiveSheet();
                $sheet->setTitle('Reporte Consolidado Larvario');
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setHorizontalCentered(true);
                $sheet->getPageSetup()->setScale(90);
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageMargins()->setLeft(0.472441);
                $sheet->getPageMargins()->setRight(0.393701);

                // $codInspeccion = $dataConsolida->key_control;
                // if ( isset($codInspeccion) && !empty($codInspeccion) ) {
                    $dataInspeccionDetalle = $this->mreportes->mreporte_consolidado_mes_larvario_detalle_lista($databuscar);
                    $dataInspeccionDetalleDepos = $this->mreportes->mreporte_consolidado_mensual_larvario_tipos_depositos($databuscar);
                // }


                $this->c_reportes_inspeccion_header($sheet, $mesreport);
                $this->c_reportes_inspeccion_body($sheet, $dataInspeccionDetalle, $dataInspeccionDetalleDepos);
                $this->c_reportes_inspeccion_footer($sheet);

                $writer = new Xlsx($objSheet);
                $filePath = "Reporte Consolidado_Mensual_larvario.xlsx";
                $writer->save($filePath);

                $response = service('response');
                $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                $response->setHeader('Content-Disposition', 'attachment; filename="'.$filePath.'"');
                $response->setBody(file_get_contents($filePath));

                return $response;
            }else{
                return redirect()->to(base_url('reportes-consolidado-mes-larvario'));
            }
        }else{
            return redirect()->to(base_url('reportes-consolidado-mes-larvario'));
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
            $sheet->setCellValue($LI.$row3, 'Formato 09: Consolidado Mensual de control larvario del Aedes aegypti');

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

            $sheet->setCellValue("E".$row4,'CONSOLIDADO MENSUAL DE CONTROL LARVARIO DEL Aedes aegypti');
            
            $sheet->getStyle("E".$row4)->applyFromArray($headTitleInspeccion);
            $sheet->mergeCells("E".$row4.":".$LF.$row4);
            $sheet->getRowDimension($row4)->setRowHeight(28);
            //** */

            //** */
            $row5 = 5;
            $row6 = 6;

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
            $sheet->getRowDimension($row5)->setRowHeight(17);
            $sheet->mergeCells($LI.$row5.":C".$row6);

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
            return redirect()->to(base_url('reportes-consolidado-mes-larvario'));
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
            $sheet->getStyle("E7:BH10")->applyFromArray($styleHeadTableTexHorizontal);

            $row7 = 7;
            $row8 = 8;
            $row10 = 10;

            $sheet->mergeCells($LI.$row7.":".$LI.$row10);
            $sheet->mergeCells("B".$row7.":"."B".$row10);
            $sheet->mergeCells("C".$row7.":"."C".$row10);
            $sheet->mergeCells("D".$row7.":"."D".$row10);
            $sheet->mergeCells("E".$row7.":"."E".$row10);
            $sheet->mergeCells("F".$row8.":"."F".$row10);
            $sheet->mergeCells("G".$row8.":"."G".$row10);
            $sheet->mergeCells("H".$row8.":"."H".$row10);
            $sheet->mergeCells("I".$row8.":"."I".$row10);
            $sheet->mergeCells("J".$row8.":"."J".$row10);
            $sheet->mergeCells("K".$row8.":"."K".$row10);
            $sheet->mergeCells("L".$row8.":"."L".$row10);
            $sheet->mergeCells("M".$row8.":"."M".$row10);
            $sheet->mergeCells("N".$row8.":"."N".$row10);
            $sheet->mergeCells("O".$row8.":"."O".$row10);
            $sheet->mergeCells("P".$row8.":"."P".$row10);
            $sheet->mergeCells("Q".$row8.":"."Q".$row10);
            $sheet->mergeCells("R".$row8.":"."R".$row10);
            $sheet->mergeCells("S".$row8.":"."S".$row10);
            $sheet->mergeCells("T".$row8.":"."T".$row10);

            $sheet->mergeCells("F".$row7.":"."O".$row7);
            $sheet->mergeCells("P".$row7.":"."T".$row7);

            $sheet->mergeCells("BG".$row7.":"."BG".$row10);
            $sheet->mergeCells("BH".$row7.":"."BH".$row10);

            $sheet->setCellValue($LI.$row7,'Provincia');
            $sheet->setCellValue("B".$row7,'Distrito');
            $sheet->setCellValue("C".$row7,'Red de Salud');
            $sheet->setCellValue("D".$row7,'Establecimiento de Salud (Localidad)');
            $sheet->setCellValue("E".$row7,'N° de residentes');
            $sheet->setCellValue("F".$row7,'Viviendas');
            $sheet->setCellValue("F".$row8,'Totales');
            $sheet->setCellValue("G".$row8,'Programadas');
            $sheet->setCellValue("H".$row8,'Inspeccionadas');
            $sheet->setCellValue("I".$row8,'Cobertura viviendas inspeccionadas');
            $sheet->setCellValue("J".$row8,'Cerradas');
            $sheet->setCellValue("K".$row8,'Renuentes');
            $sheet->setCellValue("L".$row8,'Deshabitadas');
            $sheet->setCellValue("M".$row8,'No visitadas');
            $sheet->setCellValue("N".$row8,'Positivas');
            $sheet->setCellValue("O".$row8,'Tratadas');
            $sheet->setCellValue("P".$row7,'Recipientes');
            $sheet->setCellValue("P".$row8,'Inspeccionados');
            $sheet->setCellValue("Q".$row8,'Positivos');
            $sheet->setCellValue("R".$row8,'Tratados con larvicida');
            $sheet->setCellValue("S".$row8,'Tratados fisicamente');
            $sheet->setCellValue("T".$row8,'Destruidos');

            $sheet->setCellValue("BG".$row7,'Consumo de larvicida (kg)');
            $sheet->setCellValue("BH".$row7,'Fecha de Inicio y termino');

            $sheet->getStyle("E".$row7)->applyFromArray($styleHeadTableTexVertical);
            $sheet->getStyle("BG".$row7)->applyFromArray($styleHeadTableTexVertical);
            $sheet->getStyle("BH".$row7)->applyFromArray($styleHeadTableTexVertical);
            $arrColTextVert = ['F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T'];
            foreach ($arrColTextVert as $key => $cel) {
                $sheet->getStyle($cel.$row8)->applyFromArray($styleHeadTableTexVertical);
            }

            $arrColTextHori = ['A','B','C','D','F','P'];
            foreach ($arrColTextHori as $key => $cel) {
                $sheet->getStyle($cel.$row7)->applyFromArray($styleHeadTableTexHorizontal);
            }

            $sheet->getColumnDimension("A")->setWidth(10);
            $sheet->getColumnDimension("B")->setWidth(10);
            $sheet->getColumnDimension("C")->setWidth(12);
            $sheet->getColumnDimension("D")->setWidth(16);
            $sheet->getColumnDimension("E")->setWidth(5);
            $sheet->getColumnDimension("F")->setWidth(5);
            $sheet->getColumnDimension("G")->setWidth(5);
            $sheet->getColumnDimension("H")->setWidth(5);
            $sheet->getColumnDimension("I")->setWidth(6);
            $sheet->getColumnDimension("J")->setWidth(5);
            $sheet->getColumnDimension("K")->setWidth(5);
            $sheet->getColumnDimension("L")->setWidth(5);
            $sheet->getColumnDimension("M")->setWidth(5);
            $sheet->getColumnDimension("N")->setWidth(5);
            $sheet->getColumnDimension("O")->setWidth(5);
            $sheet->getColumnDimension("P")->setWidth(5);
            $sheet->getColumnDimension("Q")->setWidth(5);
            $sheet->getColumnDimension("R")->setWidth(5);
            $sheet->getColumnDimension("S")->setWidth(5);
            $sheet->getColumnDimension("T")->setWidth(5);
            $sheet->getColumnDimension("BG")->setWidth(6);
            $sheet->getColumnDimension("BH")->setWidth(22);

            /** */
            $row7= 7;
            $sheet->mergeCells("U$row7:BF$row7");
            $sheet->setCellValue("U7",'Depósitos');
            /** */

            //** */
            $row8 = 8;
            $sheet->mergeCells("U$row8:AB$row8");
            $sheet->mergeCells("AC$row8:AF$row8");
            $sheet->mergeCells("AG$row8:AJ$row8");
            $sheet->mergeCells("AK$row8:AN$row8");

            $sheet->setCellValue("U$row8", ">= 500 L");
            $sheet->setCellValue("AC$row8", "`= 200 L`");
            $sheet->setCellValue("AG$row8", "< 200 L - 100 L");
            $sheet->setCellValue("AK$row8", "< 100 L");
            //** */

            // ***
            $row9 = 9;
            $arrDepositosCol = ['U,X', 'Y,AB', 'AC,AF', 'AG,AJ', 'AK,AN'];
            foreach ($arrDepositosCol as $key => $dep) {
                $arrLetter = explode(',', $dep);
                [$colIni, $colFin] = $arrLetter;
                $sheet->mergeCells("$colIni$row9:$colFin$row9");  
            }
            $sheet->mergeCells("AO8:AR$row9");
            $sheet->mergeCells("AS8:AV$row9");
            $sheet->mergeCells("AW8:BA$row9");
            $sheet->mergeCells("BB8:BF$row9");
            $sheet->getRowDimension($row9)->setRowHeight(85);

            $sheet->setCellValue("U".$row9, "Tanque alto");
            $sheet->setCellValue("Y".$row9, "Tanque bajo");
            $sheet->setCellValue("AC".$row9, "Barril-cilindro");
            $sheet->setCellValue("AG".$row9, "Sansón-bidon");
            $sheet->setCellValue("AK".$row9, "Baldes, bateas, tinajas");
            $sheet->setCellValue("AO8", "Llantas");
            $sheet->setCellValue("AS8", "Floreros, maceteros");
            $sheet->setCellValue("AW8", "Latas, botellas");
            $sheet->setCellValue("BB8", "Otros");
            //** */

            //** Row 10*/
            $arrDepositosColLetter = 
            [
                ['U','V','W','X'],
                ['Y','Z','AA','AB'],
                ['AC','AD','AE','AF'],
                ['AG','AH','AI','AJ'],
                ['AK','AL','AM','AN'],
                ['AO','AP','AQ','AR'],
                ['AS','AT','AU','AV'],
                ['AW','AX','AY','AZ','BA'],
                ['BB','BC','BD','BE','BF']
            ];
            $arrDepositoTipo = ['I','P','TQ','TF','D'];

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
                $consLarv  = $det->cons_larvi;
                $vivinsp = $det->sit_vivIns;
                $vivcerrada = $det->sit_vivCerr;
                $vivrenuent = $det->sit_vivRenu;
                $vivdeshab = $det->sit_vivDesh;
                $vivposit = $det->sit_vivPost;
                $vivtratad = $det->sit_vivTrat;

                $colTotViv = $vivinsp + $vivcerrada + $vivrenuent + $vivdeshab + $vivposit + $vivtratad;

                $arrDataInspeccionDetalle[$key] = [$provinc, $distrit, $redsalud, $establec, $rresiden, $colTotViv, "", $vivinsp, "", $vivcerrada, $vivrenuent, $vivdeshab, "", $vivposit, $vivtratad];
                
                $sheet->setCellValue("BG".$rowActual, $consLarv);
                $fecinifin = $fechainicia." - ".$fechafin;
                $sheet->setCellValue("BH".$rowActual, $fecinifin);

                // Detalle

                $letterDepTipDetalle = [
                    1 => [1 => 'U',2 => 'V',3 => 'W',4 => 'X'],
                    2 => [1 => 'Y',2 => 'Z',3 => 'AA',4 => 'AB'],
                    3 => [1 => 'AC',2 => 'AD',3 => 'AE',4 => 'AF'],
                    4 => [1 => 'AG',2 => 'AH',3 => 'AI',4 => 'AJ'],
                    5 => [1 => 'AK',2 => 'AL',3 => 'AM',4 => 'AN'],
                    6 => [1 => 'AO',2 => 'AP',3 => 'AQ',4 => 'AR'],
                    7 => [1 => 'AS',2 => 'AT',3 => 'AU',4 => 'AV'],
                    8 => [1 => 'AW',2 => 'AX',3 => 'AY',4 => 'AZ',5 => 'BA'],
                    9 => [1 => 'BB',2 => 'BC',3 => 'BD',4 => 'BE',5 => 'BF'],
                ];

                $arrDepositosVal = array();
                $RecInsp = 0;$RecPosit=0;$RecLarv=0;$RecFisc=0;$RecDestr=0;
                foreach ($dataInspeccionDetalleDepos as $key => $dpst) {
                    if ($det->fecinicia == $dpst->finicia && $det->ideess == $dpst->ideess) {
                        $sheet->setCellValue("U".$rowActual,($dpst->TAI == 0) ? "": $dpst->TAI);
                        $sheet->setCellValue("V".$rowActual,($dpst->TAP == 0) ? "": $dpst->TAP);
                        $sheet->setCellValue("W".$rowActual,($dpst->TATQ == 0) ? "" : $dpst->TATQ);
                        $sheet->setCellValue("X".$rowActual,($dpst->TATF == 0) ? "" : $dpst->TATF);

                        $sheet->setCellValue("Y".$rowActual,($dpst->TBI == 0) ? "" : $dpst->TBI);
                        $sheet->setCellValue("Z".$rowActual,($dpst->TBP == 0) ? "" : $dpst->TBP);
                        $sheet->setCellValue("AA".$rowActual,($dpst->TBTQ == 0) ? "" : $dpst->TBTQ);
                        $sheet->setCellValue("AB".$rowActual,($dpst->TBTF == 0) ? "" : $dpst->TBTF);

                        $sheet->setCellValue("AC".$rowActual,($dpst->BCI == 0) ? "" : $dpst->BCI);
                        $sheet->setCellValue("AD".$rowActual,($dpst->BCP == 0) ? "" : $dpst->BCP);
                        $sheet->setCellValue("AE".$rowActual,($dpst->BCTQ == 0) ? "" : $dpst->BCTQ);
                        $sheet->setCellValue("AF".$rowActual,($dpst->BCTF == 0) ? "" : $dpst->BCTF);

                        $sheet->setCellValue("AG".$rowActual,($dpst->SSI == 0) ? "" : $dpst->SSI);
                        $sheet->setCellValue("AH".$rowActual,($dpst->SSP == 0) ? "" : $dpst->SSP);
                        $sheet->setCellValue("AI".$rowActual,($dpst->SSTQ == 0) ? "" : $dpst->SSTQ);
                        $sheet->setCellValue("AJ".$rowActual,($dpst->SSTF == 0) ? "" : $dpst->SSTF);

                        $sheet->setCellValue("AK".$rowActual,($dpst->BBTI == 0) ? "" : $dpst->BBTI);
                        $sheet->setCellValue("AL".$rowActual,($dpst->BBTP == 0) ? "" : $dpst->BBTP);
                        $sheet->setCellValue("AM".$rowActual,($dpst->BBTTQ == 0) ? "" : $dpst->BBTTQ);
                        $sheet->setCellValue("AN".$rowActual,($dpst->BBTTF == 0) ? "" : $dpst->BBTTF);

                        $sheet->setCellValue("AO".$rowActual,($dpst->LLI == 0) ? "" : $dpst->LLI);
                        $sheet->setCellValue("AP".$rowActual,($dpst->LLP == 0) ? "" : $dpst->LLP);
                        $sheet->setCellValue("AQ".$rowActual,($dpst->LLTQ == 0) ? "" : $dpst->LLTQ);
                        $sheet->setCellValue("AR".$rowActual,($dpst->LLTF == 0) ? "" : $dpst->LLTF);

                        $sheet->setCellValue("AS".$rowActual,($dpst->FLI == 0) ? "" : $dpst->FLI);
                        $sheet->setCellValue("AT".$rowActual,($dpst->FLP == 0) ? "" : $dpst->FLP);
                        $sheet->setCellValue("AU".$rowActual,($dpst->FLTQ == 0) ? "" : $dpst->FLTQ);
                        $sheet->setCellValue("AV".$rowActual,($dpst->FLTF == 0) ? "" : $dpst->FLTF);

                        $sheet->setCellValue("AW".$rowActual,($dpst->LTI == 0) ? "" : $dpst->LTI);
                        $sheet->setCellValue("AX".$rowActual,($dpst->LTP == 0) ? "" : $dpst->LTP);
                        $sheet->setCellValue("AY".$rowActual,($dpst->LTTQ == 0) ? "" : $dpst->LTTQ);
                        $sheet->setCellValue("AZ".$rowActual,($dpst->LTTF == 0) ? "" : $dpst->LTTF);
                        $sheet->setCellValue("BA".$rowActual,($dpst->LTD == 0) ? "" : $dpst->LTD);

                        $sheet->setCellValue("BB".$rowActual,($dpst->OTI == 0) ? "" : $dpst->OTI);
                        $sheet->setCellValue("BC".$rowActual,($dpst->OTP == 0) ? "" : $dpst->OTP);
                        $sheet->setCellValue("BD".$rowActual,($dpst->OTTQ == 0) ? "" : $dpst->OTTQ);
                        $sheet->setCellValue("BE".$rowActual,($dpst->OTTF == 0) ? "" : $dpst->OTTF);
                        $sheet->setCellValue("BF".$rowActual,($dpst->OTD == 0) ? "" : $dpst->OTD);
                        $RecInsp = $dpst->TAI+$dpst->TBI+$dpst->BCI+$dpst->SSI+$dpst->BBTI+$dpst->LLI+$dpst->FLI+$dpst->LTI+$dpst->OTI;
                        $RecPosit= $dpst->TAP+$dpst->TBP+$dpst->BCP+$dpst->SSP+$dpst->BBTP+$dpst->LLP+$dpst->FLP+$dpst->LTP+$dpst->OTP;
                        $RecLarv= $dpst->TATQ+$dpst->TBTQ+$dpst->BCTQ+$dpst->SSTQ+$dpst->BBTTQ+$dpst->LLTQ+$dpst->FLTQ+$dpst->LTTQ+$dpst->OTTQ;
                        $RecFisc= $dpst->TATF+$dpst->TBTF+$dpst->BCTF+$dpst->SSTF+$dpst->BBTTF+$dpst->LLTF+$dpst->FLTF+$dpst->LTTF+$dpst->OTTF;
                        $RecDestr= $dpst->LTD+$dpst->OTD;
                        
                    }
                }
                $sheet->setCellValue("P".$rowActual, $RecInsp);
                $sheet->setCellValue("Q".$rowActual, $RecPosit);
                $sheet->setCellValue("R".$rowActual, $RecLarv);
                $sheet->setCellValue("S".$rowActual, $RecFisc);
                $sheet->setCellValue("T".$rowActual, $RecDestr);
                
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

            $sheet->mergeCells($LI.$rowEnd.":"."E{$rowEnd}");
            $sheet->setCellValue($LI.$rowEnd, 'Total');

            foreach ($arrColTextVert as $key => $celV) {
                $colSumaVR = $celV.$CI.":".$celV.$rowEndAnt;
                $sheet->setCellValue("$celV$rowEnd", "=SUM($colSumaVR)" );
                $sheet->getCell("$celV$rowEnd")->getCalculatedValue();
            }

            foreach($arrDepositosColLetter as $arrCel){
                foreach($arrCel as $cel){
                    $colSuma = $cel.$CI.":".$cel.$rowEndAnt;
                    $sheet->setCellValue("$cel$rowEnd", "=SUM($colSuma)" );
                    $sheet->getCell("$cel$rowEnd")->getCalculatedValue();
                }
            }

            $sheet->setCellValue("BG{$rowEnd}", "=SUM(BG$CI:BG{$rowEndAnt})" );
            $sheet->getCell("BG$rowEnd")->getCalculatedValue();
            $sheet->getStyle("BH$CI:BH{$rowEndAnt}")->applyFromArray($styleTableFecIniFin);

            $this->configRowFin = $rowEnd;

        }else{
            return redirect()->to(base_url('reportes-consolidado-mes-larvario'));
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

            $styleConsolidadoTableSL = [
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
            
            $rowfinal = $RF + 3;
            $rowfinalInTB = $RF + 3;

            $sheet->mergeCells("A$rowfinal:C$rowfinal");
            $sheet->setCellValue("A$rowfinal", "Saldo de larvicida");
            $sheet->mergeCells("E$rowfinal:J$rowfinal");
            $sheet->setCellValue("E$rowfinal", "Localidades");
            $sheet->mergeCells("L$rowfinal:Q$rowfinal");
            $sheet->setCellValue("L$rowfinal", "Viviendas");
            $sheet->mergeCells("T$rowfinal:AF$rowfinal");
            $sheet->setCellValue("T$rowfinal", "Observaciones");
            $rowfinal++;
            $rowSiguient = $rowfinal + 1;
            $rowObserv = $rowfinal;
            $sheet->mergeCells("A$rowfinal:A$rowSiguient");
            $sheet->setCellValue("A$rowfinal", "N° de lote");
            $sheet->mergeCells("B$rowfinal:B$rowSiguient");
            $sheet->setCellValue("B$rowfinal", "Fecha de expiración");
            $sheet->mergeCells("C$rowfinal:C$rowSiguient");
            $sheet->setCellValue("C$rowfinal", "Cantidad (kg)");
            $sheet->mergeCells("E$rowfinal:G$rowSiguient");
            $sheet->setCellValue("E$rowfinal", "Programadas");
            $sheet->mergeCells("H$rowfinal:J$rowSiguient");
            $sheet->setCellValue("H$rowfinal", "Intervenidas");
            $sheet->mergeCells("L$rowfinal:N$rowSiguient");
            $sheet->setCellValue("L$rowfinal", "Programadas");
            $sheet->mergeCells("O$rowfinal:Q$rowSiguient");
            $sheet->setCellValue("O$rowfinal", "Intervenidas");
            $sheet->getStyle("T$rowfinal:BH$rowfinal")->applyFromArray($styleBordetBotton);
            $sheet->getStyle("T$rowSiguient:BH$rowSiguient")->applyFromArray($styleBordetBotton);
            $rowfinal = $rowfinal + 2;
            $rowSiguient = $rowfinal + 1;
            $sheet->mergeCells("A$rowfinal:A$rowSiguient");
            $sheet->mergeCells("B$rowfinal:B$rowSiguient");
            $sheet->mergeCells("C$rowfinal:C$rowSiguient");
            $sheet->mergeCells("E$rowfinal:G$rowSiguient");
            $sheet->mergeCells("H$rowfinal:J$rowSiguient");
            $sheet->mergeCells("L$rowfinal:N$rowSiguient");
            $sheet->mergeCells("O$rowfinal:Q$rowSiguient");
            $sheet->getStyle("T$rowfinal:BH$rowfinal")->applyFromArray($styleBordetBotton);
            $sheet->getStyle("T$rowSiguient:BH$rowSiguient")->applyFromArray($styleBordetBotton);
            $rowfinalSG = $rowfinal + 1;
            $rowfinalSGOB = $rowfinalSG + 2;
            $rowSiguient = $rowSiguient + 1;
            $sheet->getStyle("A$rowfinalInTB:C$rowfinalSG")->applyFromArray($styleConsolidadoTableSL);
            $sheet->getStyle("E$rowfinalInTB:J$rowfinalSG")->applyFromArray($styleConsolidadoTableSL);
            $sheet->getStyle("L$rowfinalInTB:Q$rowfinalSG")->applyFromArray($styleConsolidadoTableSL);
            $sheet->getStyle("T$rowSiguient:BH$rowSiguient")->applyFromArray($styleBordetBotton);
            $sheet->getStyle("T$rowfinalSGOB:BH$rowfinalSGOB")->applyFromArray($styleBordetBotton);

            $rowfinal = $rowSiguient + 3;
            $rowfinalIni = $rowSiguient + 3;
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