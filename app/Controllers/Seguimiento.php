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
    // ***
}
?>