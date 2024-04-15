<?php

namespace App\Controllers;
use App\Models\MusuarioModel;

use CodeIgniter\Controller;

class Usuario extends BaseController
{   
    protected $musuario;
    // protected $session;

    public function __construct()
    {
        $this->musuario = new MusuarioModel();
        // $this->session = \Config\Services::session();;
    }

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

                $resDataUser = $this->musuario->m_usuario_buscar($usuNombre);

                if($resDataUser){
                    $usuBBDD     = $resDataUser->usuario;
                    $pasHashBBDD = $resDataUser->pass_hash;
                    
                    $keyPer = $resDataUser->key_per;

                    if(($usuNombre === $usuBBDD) && (password_verify($usuPassword, $pasHashBBDD))){

                        $resDatPer = $this->musuario->m_usuario_persona($keyPer);
                        if($resDatPer){
                            $data['status'] = true;
                            $data['msg']    = 'Correcto';
                            $data['urlDestino'] = base_url('/home');

                            $this->session->set('dataPer', $resDatPer);
                            $datase = $this->session->get('dataPer');
                            
                            if(!empty($datase)){
                                redirect()->to('/home');
                            }else{
                                redirect()->to('/acceso');
                            }
                        }
                        
                    }
                }else{
                    return redirect()->to(base_url('acceso'));
                }
            }

            if(empty($datase)){
                return redirect()->to(base_url('acceso'));
            }
        }
        return $this->response->setJSON($data);
    }
    
    public function c_logout() {
        $this->session->destroy();
        return redirect()->to(base_url('acceso'));
    }
}

?>