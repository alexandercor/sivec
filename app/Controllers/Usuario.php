<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Usuario extends BaseController
{
    public function index() {
        $data = ['miUrlBase' => 'resources/adle'];
        return view('admin/vlogin', $data);
    }

    public function c_login_in() {
        $data['status'] = false;
        $data['msg']    = 'fail';

        if($this->request->isAJAX()){

            $usuNombre   = $this->request->getPost('txtLogSendUsu');
            $usuPassword = $this->request->getPost('txtLogSendPas');

            if( (isset($usuNombre) && !empty($usuNombre)) && (isset($usuPassword) && !empty($usuPassword))){

                $usuBBDD = 'alex';
                $pasBBDD = 'alex';

                if(($usuNombre === $usuBBDD) && ($usuPassword === $pasBBDD)){
                    $data['status'] = true;
                    $data['msg']    = 'Correcto';
                    $data['urlDestino'] = base_url('/home');
                }else{
                    // return $this->response->redirect('login');
                }
            }
        }
        return $this->response->setJSON($data);
    }
}

?>