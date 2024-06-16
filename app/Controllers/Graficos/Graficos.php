<?php

namespace App\Controllers\Graficos;
use App\Models\Graficos\MgraficosModel;
use App\Models\MinfocoreModel;
use App\Controllers\BaseController;

class Graficos extends BaseController
{   
    protected $mgraficos;
    protected $minfocore;

    public function __construct()
    {
        $this->mgraficos = new MgraficosModel();
        $this->minfocore = new MinfocoreModel();
        helper('fn_helper');
    }

    public function cgraficos_sector_index(){
        $data['dataRegiones'] = $this->minfocore->m_regiones();
        return view('admin/graficos/vgraficosRecSector', $data);
    }

    public function cgraficos_sector_act_totales(){
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $keySec = bs64url_dec($this->request->getPost('codSec'));
            $fini = $this->request->getPost('fini');
            $ffin = $this->request->getPost('ffin');

            if((isset($keySec) && !empty($keySec)) && isset($fini) && !empty($fini) && isset($ffin) && !empty($ffin)){
                $resTotalesAct = $this->mgraficos->m_graficos_sector_totales([$keySec, $fini, $ffin]);
                if(!empty($resTotalesAct)){
                    $data['status'] = true;
                    $data['msg']    = 'Ok';
                    $data['totalesAct'] = $resTotalesAct;
                }

            }
        }
        return $this->response->setJSON($data);
    }

// ***
}
?>