<?php

namespace App\Controllers;
use App\Models\MubigeoModel;

use CodeIgniter\Controller;

class Ubigeo extends BaseController
{   
    protected $mubigeo;

    public function __construct()
    {
        $this->mubigeo = new MubigeoModel();
        helper('fn_helper');
    }

    public function c_ubigeo_sector() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $keySector = bs64url_dec($this->request->getPost('keySector'));

            if(isset($keySector) && !empty($keySector)){
                $dataSectores = $this->mubigeo->m_ubigeo_sector($keySector);

                if(!empty($dataSectores)){
                    $data['status'] = true;
                    $data['msg'] = 'Ok';
                    $data['dataSectores'] = $dataSectores;
                }
            }
        }
        return $this->response->setJSON($data);
    }
    // ***
}
?>