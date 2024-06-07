<?php

namespace App\Controllers;
use App\Models\MseguimientoModel;
use App\Models\MinfocoreModel;

use Config\Services;
use CodeIgniter\Controller;
use DateTime;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;

class Seguimiento extends BaseController
{   
    public $mseguimiento;
    public $minfocore;

    public function __construct()
    {
        $this->mseguimiento = new MseguimientoModel();
        $this->minfocore = new MinfocoreModel();
        helper('fn_helper');
    }
    public function index(){
        return view('admin/vseguimiento');
    }

    public function c_seguimiento_listar_coordenadas() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){

            $currentFecha = date('Y-m-d');
            if(!empty($currentFecha)){

                $dataCoordenadas = $this->mseguimiento->m_seguimiento_listar_coordenadas($currentFecha);

                $arrCoordenadas = [];
                if(is_array($dataCoordenadas) && !empty($dataCoordenadas)){


                    foreach($dataCoordenadas as $cor){
                        $keyPer = (int) $cor->key_per;

                        $dataCoordenadasXinsp = $this->mseguimiento->m_seguimiento_listar_coordenadas_x_inspector($keyPer);

                        if(!empty($dataCoordenadasXinsp)){
                            $ejex = $dataCoordenadasXinsp->ejex;
                            $ejey = $dataCoordenadasXinsp->ejey;
                            $insp = $dataCoordenadasXinsp->inspector;
                            $coordenadas = [$ejex,$ejey, $insp];
                            array_push($arrCoordenadas, $coordenadas);
                        }
                    }
                    
                }else{
                    $data['msg']    = 'Sin datos';
                }
                $data['status'] = true;
                $data['msg']    = 'ok';
                $data['dataCoordenadas'] = $arrCoordenadas;

            }
        }
        return $this->response->setJSON($data);
    }

    public function csospechoso_index(){
        $data['dataRegiones'] = $this->minfocore->m_regiones();
        $this->c_sospechosos_descargar();
        return view('admin/maps/vseguimientoSospechosos', $data);
    }

    public function c_sospechosos_descargar(){
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        $dataSospechososNuevos = $this->mseguimiento->m_seguimiento_sospechosos_listar_descarga();

        $dataNuevoSospechoso = [];
        if(is_array($dataSospechososNuevos) && !empty($dataSospechososNuevos)){
            foreach ($dataSospechososNuevos as $key => $snu) {
                $keySospechoso = $snu->key_sospechoso;
                $ejex = $snu->eje_x;    
                $ejey = $snu->eje_y;

                $dataNuevoSospechoso = [$ejex, $ejey, $keySospechoso];

                $resInsertRef = (int)   $this->mseguimiento->m_seguimiento_sospechosos_referencias_insert($dataNuevoSospechoso);

                if($resInsertRef === 1){
                    $this->mseguimiento->m_seguimiento_sospechosos_estado_descarga_update($keySospechoso);
                }
            }
        }
    }

    public function c_seguimiento_sospechosos() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){

            
            $codLoc = $this->request->getPost('codLoc');
            $codLoc = (!empty($codLoc))? bs64url_dec($codLoc) : 18707;

            if (isset($codLoc) && !empty($codLoc)) {

                $resSospechosos = $this->mseguimiento->m_seguimiento_sospechosos_listar($codLoc);
                $dataLoca = $this->mseguimiento->m_seguimiento_sospechosos_localidad($codLoc);
                
                if(!empty($dataLoca)){
                    $mapLoca = [$dataLoca->eje_x, $dataLoca->eje_y];
                }else{
                    $mapLoca = [-5.557222222, -80.82222222];
                }

                if((is_array($resSospechosos) && !empty($resSospechosos)) && !empty($dataLoca) ){

                    $dataSosReferencias = [];
                    foreach ($resSospechosos as $key => $sos) {
                        $keySos = $sos->key_sos;
                        if(isset($keySos) && !empty($keySos)){
                            $resSosRef = $this->mseguimiento->m_seguimiento_sospechosos_referencias_coordenadas($keySos);
                            
                            $dataReferenciasXSos = [];
                            if(is_array($resSosRef) && !empty($resSosRef)){
                                foreach ($resSosRef as $key => $ref) {
                                    $dataReferenciasXSos[] = $ref;
                                    $ref->key_sos = bs64url_enc($ref->key_sos);
                                }
                            }else{
                                $data['msg']  = 'Sin referencias!!!';
                            }
                            $dataSosReferencias[] = $dataReferenciasXSos;
                        }
                    }

                    if( is_array($dataReferenciasXSos)){
                        $data['status']  = true;
                        $data['msg']  = 'Ok';
                        $data['dataSospechosoRef']  = $dataSosReferencias;
                        $data['mapLoc'] = $mapLoca;
                    }
                    return $this->response->setJSON($data);
                }else{
                    $data['msg'] = 'No hay resultados!!!';
                }
            }
        }
        return $this->response->setJSON($data);
    }

// ***
}
?>