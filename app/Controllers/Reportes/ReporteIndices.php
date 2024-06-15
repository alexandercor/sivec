<?php

namespace App\Controllers\Reportes;
use App\Controllers\BaseController;
use App\Models\Reportes\MreportesIndicesModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Shared\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\RichText\Run;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class ReporteIndices extends BaseController
{   
    protected $mreportes;
    protected $styleFontName;
    protected $configLetterInicia;
    protected $configLetterFin;

    public function __construct()
    {
        $this->mreportes = new MreportesIndicesModel();
        $this->styleFontName      = 'calibri';
        $this->configLetterInicia = 'A';
        $this->configLetterFin    = 'AZ';
        helper('fn_helper');
    }

    public function c_reportes_indices_xls($codLoc, $fini, $ffin) {

        $codLoc = bs64url_dec($codLoc);

        if((isset($codLoc) && !empty($codLoc)) &&(isset($fini) && !empty($fini)) && (isset($ffin) && !empty($ffin)) ){

            $objSheet = new Spreadsheet();
            $sheet = $objSheet->getActiveSheet();
            $sheet->setTitle('Reporte Ispeccion');
            $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
            $sheet->getPageSetup()->setHorizontalCentered(true);
            $sheet->getPageSetup()->setScale(90);
            $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
            $sheet->getPageMargins()->setLeft(0.472441);
            $sheet->getPageMargins()->setRight(0.393701);

            $finiFormat = fdate($fini);
            $ffinFormat = fdate($ffin);

            $resHeadLocalidad = $this->mreportes->mreporte_indices_head_localidad($codLoc);

            if(!empty($resHeadLocalidad)){
                $localidad = $resHeadLocalidad->localidad;
            }

            $this->c_reportes_indices_header($sheet, $codLoc, $localidad, $finiFormat, $ffinFormat);
            $this->c_reportes_indices_body($sheet, $codLoc, $fini, $ffin);
            $this->c_reportes_indices_footer($sheet);

            $writer = new Xlsx($objSheet);
            $filePath = "Reporte Indices - $localidad.xlsx";
            $writer->save($filePath);

            $response = service('response');
            $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $response->setHeader('Content-Disposition', 'attachment; filename="'.$filePath.'"');
            $response->setBody(file_get_contents($filePath));

            return $response;
        }else{
            return redirect()->to(base_url('reportes-indices'));
        }
    }

    public function c_reportes_indices_header($sheet, $codLoc, $localidad, $finiFormat, $ffinFormat) {

        if($sheet){
            $LI = $this->configLetterInicia;
            $LF = $this->configLetterFin;

            $row1 = 1;
            $row2 = 2;
            $row3 = 3;
            $row4 = 4;

            $sheet->mergeCells($LI.$row1.":".$LF.$row1);
            $sheet->mergeCells($LI.$row2.":".$LF.$row2);
            $sheet->mergeCells($LI.$row4.":".$LF.$row4);

            $arrStyleHeaTitle = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 13,
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'wrapText'    => true,    
                ],
            ];
            $objRichTextHead = new RichText();
            $textResDir = $objRichTextHead->createText("VIGILANCIA ENTOMOLOGICA  DEL AEDES AEGYPTI - ");
            $textResDir = $objRichTextHead->createTextRun($localidad);
            $textResDir->getFont()->setSize(13);
            $textResDir->getFont()->setBold(true);

            $sheet->setCellValue("A".$row1, $objRichTextHead);
            $sheet->setCellValue("C".$row3,'Inicio:');
            $sheet->setCellValue("J".$row3,'Avanze:');

            $sheet->getRowDimension($row1)->setRowHeight(30);
            $sheet->getStyle('A'.$row1)->applyFromArray($arrStyleHeaTitle);
            $sheet->mergeCellS("A".$row3.":B".$row3);
            $sheet->mergeCellS("D".$row3.":E".$row3);
            $sheet->mergeCellS("F".$row3.":I".$row3);
            $sheet->mergeCellS("L".$row3.":M".$row3);
            $sheet->mergeCellS("N".$row3.":".$LF.$row3);


            $sheet->setCellValue("D".$row3,$finiFormat);
            $sheet->setCellValue("L".$row3,$ffinFormat);
        }
    }

    public function c_reportes_indices_body($sheet, $codLoc, $fini, $ffin) {
        if($sheet){
            $LI = $this->configLetterInicia;
            $LF = $this->configLetterFin;

            $row5 = 5;
            $arrRecCol = ['C:H', 'I:K', 'L:N', 'O:Q', 'R:T', 'U:W', 'X:Z', 'AA:AC', 'AD:AF', 'AG:AI', 'AJ:AL', 'AM:AO', 'AP:AR', 'AS:AU', 'AV:AY'];
            foreach ($arrRecCol as $key => $arrCol) {
                $arrCol = explode(':',$arrCol);
                [$colIni, $colFin ] = $arrCol;
                $sheet->mergeCells($colIni.$row5.":".$colFin.$row5);
            }

            $sheet->setCellValue("C".$row5,'VIVIENDAS');
            $sheet->setCellValue("I".$row5,'TOTAL RECIPIENTES');
            $sheet->setCellValue("L".$row5,'TANQUE ELEVADO');
            $sheet->setCellValue("O".$row5,'TANQUE BAJO');
            $sheet->setCellValue("R".$row5,'CILINDROS');
            $sheet->setCellValue("U".$row5,'SANSON');
            $sheet->setCellValue("X".$row5,'TINAJAS');
            $sheet->setCellValue("AA".$row5,'LLANTAS');
            $sheet->setCellValue("AD".$row5,'FLOREROS');
            $sheet->setCellValue("AG".$row5,'BALDES');
            $sheet->setCellValue("AJ".$row5,'BIDONES GALONERAS');
            $sheet->setCellValue("AM".$row5,'OTROS');
            $sheet->setCellValue("AP".$row5,'INSERVIBLES');
            $sheet->setCellValue("AS".$row5,'OLLAS');
            $sheet->setCellValue("AV".$row5,'INDICES');
            $sheet->setCellValue("AZ".$row5,'LARVICIDA');

            $arrStyleHead = [
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
            $sheet->getStyle('C'.$row5.":".$LF.$row5)->applyFromArray($arrStyleHead);

            $arrTipoDepCol = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','AA','AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ'];

            foreach($arrTipoDepCol as $col){
                $sheet->getColumnDimension($col)->setWidth(6);
            }

            $row6 = 6;
            $sheet->getRowDimension($row6)->setRowHeight(55);
            $sheet->getStyle('I'.$row6.":AU".$row6)->applyFromArray($arrStyleHead);
            $sheet->getStyle('A'.$row6)->applyFromArray($arrStyleHead);
            $sheet->getStyle('B'.$row6)->applyFromArray($arrStyleHead);
            $sheet->getStyle('AZ'.$row6)->applyFromArray($arrStyleHead);
            $sheet->getColumnDimension('A')->setWidth(4);
            $sheet->getColumnDimension('B')->setWidth(36);

            $sheet->setCellValue("A".$row6,'N°');
            $sheet->setCellValue("B".$row6,'Sector');
            $sheet->setCellValue("C".$row6,'Programadas');
            $sheet->setCellValue("D".$row6,'Inspeccionadas');
            $sheet->setCellValue("E".$row6,'Con Pupas');
            $sheet->setCellValue("F".$row6,'Con Adultos');
            $sheet->setCellValue("G".$row6,'Positivas');
            $sheet->setCellValue("H".$row6,'Tratadas');
            $sheet->setCellValue("AV".$row6,'I.A.');
            $sheet->setCellValue("AW".$row6,'I.R.');
            $sheet->setCellValue("AX".$row6,'I.B.');
            $sheet->setCellValue("AY".$row6,'I.P.');
            $sheet->setCellValue("AZ".$row6,'Grs.');

            $arrStyleHeadDepTip = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 9
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'textRotation' => 90,
                    'wrapText'    => true,    
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ],
                ],
            ];
            $sheet->getStyle('C'.$row6.":H".$row6)->applyFromArray($arrStyleHeadDepTip);
            $sheet->getStyle('AV'.$row6.":AY".$row6)->applyFromArray($arrStyleHeadDepTip);

            $arrColDepTipos = [
                ['I', 'J', 'K'],
                ['L', 'M','N'],
                ['O', 'P', 'Q'], 
                ['R', 'S', 'T'],
                ['U', 'V', 'W'],
                ['X', 'Y', 'Z'],
                ['AA','AB','AC'], 
                ['AD', 'AE', 'AF'], 
                ['AG', 'AH', 'AI'], 
                ['AJ', 'AK', 'AL'], 
                ['AM', 'AN', 'AO'], 
                ['AP', 'AQ', 'AR'], 
                ['AS', 'AT', 'AU'],
            ];

            $arrDepTipos = ["I","+","T"];
            foreach ($arrColDepTipos as $key => $arrCol) {
                foreach ($arrCol as $keyChil => $col) {
                    $tipo = $arrDepTipos[$keyChil];

                    $sheet->setCellValue($col.$row6, $tipo);
                }
            }

            $row7= 7;

            $arrStyleBodySectores = [
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

            $arrStyleBodySectoresTotal = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 9.5,
                    'bold' => true
                ],
            ];

            $resSectores = $this->mreportes->mreporte_indices_lista_sectores([$codLoc, $fini, $ffin]);

            $count = 7;
            foreach($resSectores as $key => $sec){
                $keySec = $sec->key_sect;
                $sector = $sec->sector;
                $totalLarvida = $sec->total_larvida;

                $sheet->setCellValue("A".$count, ++$key);
                $sheet->setCellValue("B".$count, $sector);
                $sheet->setCellValue("AZ".$count, $totalLarvida);

                $totalVivi = $this->mreportes->mreporte_indices_totales_viviendas($keySec);
                if (!empty($totalVivi)) {
                    $insp = $totalVivi->inspeccionada;
                    $renu = $totalVivi->renuente;
                    $desh = $totalVivi->deshabitada;
                    $cerr = $totalVivi->cerrada;

                    $sheet->setCellValue("D".$count, $insp);

                }

                $arrColTipoDep = [
                    1 => [1 => 'L',2 => 'M', 3 => 'N'],
                    2 => [1 => 'O',2 => 'P', 3 => 'Q'],
                    3 => [1 => 'R',2 => 'S', 3 => 'T'],
                    4 => [1 => 'U',2 => 'V', 3 => 'W'],
                    5 => [1 => 'X',2 => 'Y', 3 => 'Z'],
                    6 => [1 => 'AA',2 => 'AB', 3 => 'AC'],
                    7 => [1 => 'AD',2 => 'AE', 3 => 'AF'],
                    16 => [1 => 'AG',2 => 'AH', 3 => 'AI'],
                    11 => [1 => 'AJ',2 => 'AK', 3 => 'AL'],
                    9 => [1 => 'AM',2 => 'AN', 3 => 'AO'],
                    12 => [1 => 'AP',2 => 'AQ', 3 => 'AR'],
                    17 => [1 => 'AS',2 => 'AT', 3 => 'AU'],
                ];

                foreach ($arrColTipoDep as $key => $arrDep) {
                    $keyDep = $key;
                    foreach ($arrDep as $keyChildrem => $col) {
                        $keyTipoDep = $keyChildrem;

                        $resTotal = $this->mreportes->mreporte_indices_totales_tipodeposito_x_sector([$keyDep, $keyTipoDep, $keySec]);

                        if (!empty($resTotal)) {
                            $total = $resTotal->total;
                            $sheet->setCellValue($col.$count, $total);
                        }
                    }
                }

                $totalesDep = $this->mreportes->mreporte_indices_totales_deposito_x_sector($keySec);
                
                if (!empty($totalesDep)) {
                    $ins = $totalesDep->ispeccionado;
                    $pos = $totalesDep->positivo;
                    $tra = $totalesDep->tratado;

                    $sheet->setCellValue("I".$count, $ins);
                    $sheet->setCellValue("J".$count, $pos);
                    $sheet->setCellValue("K".$count, $tra);

                    $sheet->setCellValue("G".$count, $pos);
                    $sheet->setCellValue("H".$count, $tra);
                }

                $sheet->setCellValue("AV".$count,"=ROUND(G$count/D$count*100, 2)");
                $sheet->getCell("AV".$count)->getCalculatedValue();
                
                $sheet->setCellValue("AW".$count,"=ROUND(J$count/I$count*100, 2)");
                $sheet->getCell("AW".$count)->getCalculatedValue();

                $sheet->setCellValue("AX".$count,"=ROUND(J$count/D$count*100, 2)");
                $sheet->getCell("AX".$count)->getCalculatedValue();

                $count++;
            }
            

            foreach ($arrTipoDepCol as $key => $col) {
                $suma = $col."7:".$col."19";
                $sheet->setCellValue($col."20","=SUM($suma)");
                $sheet->getCell($col."20")->getCalculatedValue();
            }

            $sheet->mergeCells("A20:B20");
            $sheet->getStyle($LI."7:".$LF."20")->applyFromArray($arrStyleBodySectores);
            $sheet->getStyle($LI."20:".$LF."20")->applyFromArray($arrStyleBodySectoresTotal);

            $sheet->setCellValue("A20","Total");

        }
    }
    

    public function c_reportes_indices_footer($sheet) {
        if($sheet){
            $arrStyleTableIndices = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 10
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

            $sheet->mergeCells("A22:C22");
            $sheet->mergeCells("A23:B23");
            $sheet->mergeCells("A24:B24");
            $sheet->mergeCells("A25:B25");
            $sheet->getStyle("A22:C25")->applyFromArray($arrStyleTableIndices);
            $sheet->getStyle("A22")->getFont()->setBold(true);
            $sheet->getStyle("A23")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A24")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A25")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('A22', 'ÍNDICE');
            $sheet->setCellValue('C22', '%');
            $sheet->setCellValue('A23', 'Aedico');
            $sheet->setCellValue('A24', 'Recipientes');
            $sheet->setCellValue('A25', 'Bretau');

            $sheet->setCellValue('C23', "=(AV20)");
            $sheet->setCellValue('C24', "=(AW20)");
            $sheet->setCellValue('C25', "=(AX20)");
        }
    }


// **
}
?>