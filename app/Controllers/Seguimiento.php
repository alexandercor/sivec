<?php

namespace App\Controllers;
use App\Models\MseguimientoModel;

use Config\Services;
use CodeIgniter\Controller;

class Seguimiento extends BaseController
{   
    public $mseguimiento;

    public function __construct()
    {
        $this->mseguimiento = new MseguimientoModel();
    }
    public function index(){
        return view('admin/vseguimiento');
    }

    public function c_seguimiento_listar_coordenadas() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $dataCoordenadas = $this->mseguimiento->m_seguimiento_listar_coordenadas();
            $arrCoordenadas = [];
            if(is_array($dataCoordenadas) && !empty($dataCoordenadas)){
                // foreach($dataCoordenadas as $cor){
                //     $ejex = $cor->ejex;
                //     $ejey = $cor->ejey;
                //     $coordenadas = [$ejex,$ejey];
                //     array_push($arrCoordenadas, $coordenadas);
                // }
                $data['status'] = true;
                $data['msg']    = 'ok';
                $data['dataCoordenadas'] = $dataCoordenadas;
            }
            
        }
        return $this->response->setJSON($data);
    }

    public function csospechoso_index(){
        return view('admin/maps/vseguimientoSospechosos');
    }

    public function c_seguimiento_sospechosos() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $resSospechosos = $this->mseguimiento->m_seguimiento_sospechosos_listar();

            if(is_array($resSospechosos) && !empty($resSospechosos)){

                $dataSosReferencias = [];
                foreach ($resSospechosos as $key => $sos) {
                    $keySos = $sos->key_sos;
                    if(isset($keySos) && !empty($keySos)){
                        $resSosRef = $this->mseguimiento->m_seguimiento_sospechosos_referencias_coordenadas($keySos);
                        
                        $dataReferenciasXSos = [];
                        if(is_array($resSosRef) && !empty($resSosRef)){
                            foreach ($resSosRef as $key => $ref) {
                                $dataReferenciasXSos[] = $ref;
                            }
                        }else{
                            $data['msg']  = 'Sin referencias!!!';
                        }
                        $dataSosReferencias[] = $dataReferenciasXSos;
                    }
                }

                if( is_array($dataReferenciasXSos)){
                    $data['status']  = true;
                    $data['dataSospechosoRef']  = $dataSosReferencias;
                }
                return $this->response->setJSON($data);
            }else{
                $data['msg']    = 'Sin resultados';
            }
        }
        return $this->response->setJSON($data);
    }
// ***
}
?>