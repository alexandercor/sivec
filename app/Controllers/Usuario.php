<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Usuario extends BaseController
{
    public function index(): string {
        return view('admin/vlogin');
    }

    public function c_login_in() {
        $data['status'] = false;
        $data['msg'] = 'fail';

        if($this->request->isAJAX()){

            $usuNombre   = $this->request->getPost('txtnombre');
            $usuPassword = $this->request->getPost('txtpassword');

            if( (isset($usuNombre) && !empty($usuNombre)) && (isset($usuPassword) && !empty($usuPassword))){

                $resDataUser = $this->musuario->m_login_in([$usuNombre, $usuPassword]);

                if(!empty($resDataUser)){

                }
            }
        }

        return $this->response->setJSON($data);
    }
}

?>