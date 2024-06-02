<?php

namespace App\Controllers;
use App\Models\MseguimientoModel;

use Config\Services;
use CodeIgniter\Controller;
use DateTime;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;

class Seguimiento extends BaseController
{   
    public $mseguimiento;

    public function __construct()
    {
        $this->mseguimiento = new MseguimientoModel();
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
                }
                return $this->response->setJSON($data);
            }else{
                $data['msg'] = 'Sin resultados';
            }
        }
        return $this->response->setJSON($data);
    }
// ***
}
?>