<?php

namespace App\Controllers\Reportes;
use App\Controllers\BaseController;
use App\Models\Reportes\MreportesSectorModel;

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


class ReporteSector extends BaseController
{   
    protected $mreportes;
    protected $styleFontName;
    protected $configLetterInicia;
    protected $configLetterFin;

    public function __construct()
    {
        $this->mreportes = new MreportesSectorModel();
        $this->styleFontName      = 'calibri';
        $this->configLetterInicia = 'A';
        $this->configLetterFin    = 'AW';
        helper('fn_helper');
    }

    public function c_reportes_sector($codLoc) {

        $codLoc = bs64url_dec($codLoc);

        if(isset($codLoc) && !empty($codLoc)){
        
            $resDataSecLocHeader = $this->mreportes->mreporte_sector_localidad_head($codLoc);

            if(empty($resDataSecLocHeader)){

                // $resDataSectores = $this->mreportes->mreporte_sector_lista_sectores($codLoc);

                $objSheet = new Spreadsheet();
                $sheet = $objSheet->getActiveSheet();
                $sheet->setTitle('Reporte Ispeccion');
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setHorizontalCentered(true);
                $sheet->getPageSetup()->setScale(90);
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageMargins()->setLeft(0.472441);
                $sheet->getPageMargins()->setRight(0.393701);

                $this->c_reportes_inspeccion_header($sheet, $codLoc, $resDataSecLocHeader);
                $this->c_reportes_inspeccion_body($sheet, $codLoc);
                $this->c_reportes_inspeccion_footer($sheet);

                $writer = new Xlsx($objSheet);
                $filePath = "Reporte por Sector.xlsx";
                $writer->save($filePath);

                $response = service('response');
                $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                $response->setHeader('Content-Disposition', 'attachment; filename="'.$filePath.'"');
                $response->setBody(file_get_contents($filePath));

                return $response;

            }else{
                return redirect()->to(base_url('reportes-sector'));
            }
        } else{
            return redirect()->to(base_url('reportes-sector'));
        }
    }

    public function c_reportes_inspeccion_header($sheet, $codLoc, $resDataSecLocHeader) {

        if($sheet){
            $LI = $this->configLetterInicia;
            $LF = $this->configLetterFin;
            
            $localidad = $resDataSecLocHeader->localidad ?? '';

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
            $sheet->setCellValue($LI."2",'FORMATO - RESUMEN DE TRABAJO DIARIO EN VIGILANCIA Y CONTROL DEL AEDES AEGYPTI');//44

            $sheet->getStyle($LI."1")->applyFromArray($headTitleA1);
            $sheet->getStyle($LI."2")->applyFromArray($headTitleA1);
            $sheet->getRowDimension(2)->setRowHeight(25);

            $row4 = 4;
            $sheet->mergeCells("A$row4:"."B".$row4);
            $sheet->mergeCells("C$row4:"."M".$row4);
            $sheet->mergeCells("O$row4:"."S".$row4);
            $sheet->mergeCells("U$row4:"."AA".$row4);

            $sheet->setCellValue("A$row4", 'Responsable');
            $sheet->setCellValue("O$row4", 'Localidad');

            $sheet->getStyle("A$row4")->getFont()->setBold(true);
            $sheet->getStyle("O$row4")->getFont()->setBold(true);

            $sheet->getStyle("C".$row4.":M".$row4)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("U".$row4.":AA".$row4)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

            $sheet->setCellValue("U".$row4, $localidad);
            $row5 = 5;
            $sheet->mergeCells($LI.$row5.":".$LF.$row5);

        }
    }
    
    public function c_reportes_inspeccion_body($sheet, $codLoc) {

        if($sheet){
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
            $sheet->getStyle($LI."6:".$LF."9")->applyFromArray($styleTableHead);
            $sheet->getStyle($LI."10:".$LF."43")->applyFromArray($styleTableLista);

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
            $sheet->getStyle("A6:AW9")->applyFromArray($styleHeadTableTexHorizontal);

            $row6 = 6;
            $row7 = 7;
            $row8 = 8;
            $row9 = 9;

            $sheet->mergeCells($LI.$row6.":".$LI.$row9);
            $sheet->mergeCells("B".$row6.":"."B".$row9);
            $sheet->mergeCells("C".$row7.":"."C".$row9);
            $sheet->mergeCells("D".$row7.":"."D".$row9);
            $sheet->mergeCells("E".$row7.":"."E".$row9);
            $sheet->mergeCells("F".$row7.":"."F".$row9);
            $sheet->mergeCells("G".$row7.":"."G".$row9);
            $sheet->mergeCells("H".$row7.":"."H".$row9);
            $sheet->mergeCells("I".$row7.":"."I".$row9);
            $sheet->mergeCells("AT".$row6.":"."AV".$row8);
            $sheet->mergeCells("AW".$row6.":"."AW".$row8);

            $sheet->setCellValue($LI.$row6,'N°');
            $sheet->setCellValue("B".$row6,'Sector');
            $sheet->setCellValue("C".$row7,'Visitadas');
            $sheet->setCellValue("D".$row7,'Inspeccionadas');
            $sheet->setCellValue("E".$row7,'Cerradas');
            $sheet->setCellValue("F".$row7,'Deshabitadas');
            $sheet->setCellValue("G".$row7,'Renuentes');
            $sheet->setCellValue("H".$row7,'Positivos');
            $sheet->setCellValue("I".$row7,'Tratadas');
            $sheet->setCellValue("AT".$row6,'Totales');
            $sheet->setCellValue("AW".$row6,'Total Gasto IGR');

            $arrColTextVert = ['C','D','E','F','G','H','I','AT','AW'];
            foreach ($arrColTextVert as $key => $cel) {
                $sheet->getStyle($cel.$row7)->applyFromArray($styleHeadTableTexVertical);
            }
            $arrColTextHori = ['A','B'];
            foreach ($arrColTextHori as $key => $cel) {
                $sheet->getStyle($cel.$row7)->applyFromArray($styleHeadTableTexHorizontal);
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
            $sheet->getColumnDimension("AT")->setWidth(6);
            $sheet->getColumnDimension("AU")->setWidth(6);
            $sheet->getColumnDimension("AV")->setWidth(6);
            $sheet->getColumnDimension("AW")->setWidth(6);

            /** */
            $row6= 6;
            $sheet->mergeCells("C$row6:I$row6");
            $sheet->setCellValue("C$row6",'Viviendas');
            $sheet->mergeCells("J$row6:AS$row6");
            $sheet->setCellValue("J$row6",'Depósitos');

            // ***
            $row7 = 7;
            $arrDepositosCol = ['J,L', 'M,O', 'P,R', 'S,U', 'V,X', 'Y,AA', 'AB,AD', 'AE,AG', 'AH,AJ', 'AK,AM', 'AN,AP', 'AQ,AS'];
            foreach ($arrDepositosCol as $key => $dep) {
                $arrLetter = explode(',', $dep);
                [$colIni, $colFin] = $arrLetter;
                $sheet->mergeCells("$colIni$row7:$colFin$row8");  
            }

            $sheet->getRowDimension($row7)->setRowHeight(40);

            $sheet->setCellValue("J".$row7, "Tanque alto");
            $sheet->setCellValue("M".$row7, "Tanque bajo");
            $sheet->setCellValue("P".$row7, "Cilindro");
            $sheet->setCellValue("S".$row7, "Sansón");
            $sheet->setCellValue("V".$row7, "Tinajas");
            $sheet->setCellValue("Y".$row7, "Llantas");
            $sheet->setCellValue("AB".$row7, "Floreros");
            $sheet->setCellValue("AE".$row7, "Baldes");
            $sheet->setCellValue("AH".$row7, "Baldes");
            $sheet->setCellValue("AK".$row7, "Bidones Galoneras");
            $sheet->setCellValue("AN".$row7, "Otros");
            $sheet->setCellValue("AQ".$row7, "Inservibles");

            //** Row 8*/
            $row8 = 8;
            $arrDepositosColLetter = 
            [
                ['J','K','L'],
                ['M','N','O'],
                ['P','Q','R'],
                ['S','T','U'],
                ['V','W','X'],
                ['Y','Z','AA'],
                ['AB','AC','AD'],
                ['AE','AF','AG'],
                ['AH','AI','AJ'],
                ['AK','AL','AM'],
                ['AN','AO','AP'],
                ['AQ','AR','AS'],
            ];
            $arrDepositoTipo = ['I','+','T'];

            foreach ($arrDepositosColLetter as $key => $col) {
                foreach ($col as $key => $let) {
                    $depTipo = $arrDepositoTipo[$key];
                    $sheet->setCellValue($let.$row9,$depTipo);
                    $sheet->getColumnDimension($let)->setWidth(4);
                }
            }

            $sheet->setCellValue("AT".$row9,"I");
            $sheet->setCellValue("AU".$row9,"(+)");
            $sheet->setCellValue("AV".$row9,"T");
            $sheet->setCellValue("AW".$row9,"gr");

            $styleSectoresLista = [
                'font' => [
                    'name' => $this->styleFontName,
                    'size' => 10
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'wrapText'    => true,    
                ]
            ];

            $count = 10;
            $dataSectores = $this->mreportes->mreporte_sector_lista_sectores($codLoc);

            foreach ($dataSectores as $key => $sec) {
                $keySec = $sec->key_sect;
                $sector = $sec->sector;
                $sheet->setCellValue("A".$count, ++$key);
                $sheet->setCellValue("B".$count, $sector);

                $totalesXSector = $this->mreportes->mreporte_sector_totales_viviendas($keySec);
                
                $colEstadoViv = ['C','D','E','F','G','H','I'];

                $vivIns = $totalesXSector->inspeccionada;
                $vivRen = $totalesXSector->renuente;
                $vivDes = $totalesXSector->deshabitada;
                $vivCerr = $totalesXSector->cerrada;
                $vivTra = $totalesXSector->tratada;
                $vivPos = $totalesXSector->positivos;
                $vivOtr = $totalesXSector->otros;

                $sheet->setCellValue("C".$count, $vivIns);
                $sheet->setCellValue("D".$count, $vivRen);
                $sheet->setCellValue("E".$count, $vivDes);
                $sheet->setCellValue("F".$count, $vivCerr);
                $sheet->setCellValue("G".$count, $vivTra);
                $sheet->setCellValue("H".$count, $vivRen);
                $sheet->setCellValue("I".$count, $vivPos);
                $sheet->setCellValue("F".$count, $vivOtr);




                $sheet->setCellValue("AT".$count,"=SUM(J$count:AS$count)");
                $sheet->getCell("AT".$count)->getCalculatedValue();
                $sheet->setCellValue("AU".$count,"=SUM(J$count:AS$count)");
                $sheet->getCell("AU".$count)->getCalculatedValue();
                $sheet->setCellValue("AV".$count,"=SUM(J$count:AS$count)");
                $sheet->getCell("AV".$count)->getCalculatedValue();

                $sheet->getStyle($LI.$count.":".$LF.$count)->applyFromArray($styleSectoresLista);
                $count++;
            }
        }
    }

    public function c_reportes_inspeccion_footer($sheet) {
        if($sheet){
            
        }
    }

}
?>