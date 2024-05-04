<?php

namespace App\Controllers;
use App\Models\MusuarioModel;

use Config\Services;
use CodeIgniter\Controller;

class Usuario extends BaseController
{   
    protected $musuario;
    protected $validation;

    public function __construct()
    {
        $this->musuario = new MusuarioModel();
        $this->validation = Services::validation();
        helper('fn_helper');
    }

    public function index() {
        $data = ['miUrlBase' => 'resources/adle'];
        return view('admin/vlogin', $data);
    }

    public function c_login_in() {
        $data['status'] = false;
        $data['msg']    = 'fail';

        if($this->request->isAJAX()){

            $rules = [
                'txtLogSendUsu' => [
                    'label' => 'Usuario',
                    'rules' => 'required'
                ],
                'txtLogSendPas' => [
                    'label' => 'Contraseña',
                    'rules' => 'required'
                ],
            ];

            $this->validation->setRules($rules);

            if($this->validation->withRequest($this->request)->run()){
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
            }else{
                $data['errors'] = $this->validation->getErrors();
            }
        }
        return $this->response->setJSON($data);
    }
    
    public function c_logout() {
        $this->session->destroy();
        return redirect()->to(base_url('acceso'));
    }

    public function c_usuarios_index() {
        return view('admin/vusuario');
    }

    public function c_usuario_list() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $pers = $this->request->getPost('perso');
            $pers = (!empty($pers))? "$pers%": '%';
            
            if(isset($pers) && !empty($pers)){
                $dataUsuarios = $this->musuario->m_usuario_list($pers);
                
                $tabla = "";
                if(is_array($dataUsuarios) && !empty($dataUsuarios)){
                    
                    foreach($dataUsuarios as $key => $usu){
                        $count = ++$key;
                        $keyUsu = bs64url_enc($usu->key_usu);
                        $usuario = $usu->usuario;
                        $keyNiv = (int) $usu->key_nivel;
                        $keyNivEnc = bs64url_enc($keyNiv);
                        $perso  = $usu->persona;

                        $arrNivel = [
                            1 => 'Administrador',
                            2 => 'Supervisor',
                            3 => 'Brigada',
                        ];

                        if(array_key_exists($keyNiv, $arrNivel)){
                            $nivel = $arrNivel[$keyNiv];
                        }

                        $tabla .= "
                            <tr>
                                <td class='font-weight-bolder'>$count</td>
                                <td>$perso</td>
                                <td><i class='fas fa-user'></i> $usuario</td>
                                <td>$nivel</td>
                                
                                <td>
                                    <button type='button' class='btn bg-teal btn-sm btn_usu_update' data-keyusu='$keyUsu' data-usu='$usuario' data-keynivel='$keyNivEnc' ><i class='far fa-edit'></i> Actualizar</button>
                                </td>
                            </tr>
                        ";
                    }
                }else{
                    $tabla .= "<tr><td colspan='7' class='text-center'><i class='fas fa-ban text-danger'></i> No se encontraron resultados!!!</td></tr>";
				}
				$tabla .= "</tbody></table>";

                $data['status'] = true;
                $data['msg'] = 'ok';
                $data['dataUsuarios'] = $tabla;
            }
        }
        return $this->response->setJSON($data);
    }

    public function c_usuario_update() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){

            $keyUsu = bs64url_dec($this->request->getPost('txt_crudusu_keyusu'));
            $pass   = $this->request->getPost('txt_crudusu_constraseña');
            $keyNiv = bs64url_dec($this->request->getPost('sle_usucrud_nivel')); 

            if( (isset($keyUsu) && !empty($keyUsu)) && (isset($keyNiv) && !empty($keyNiv)) ){
                if(empty($pass)){
                    $resInsetAct = $this->musuario->m_usuario_update_nivel([$keyNiv, $keyUsu]);
                    $messaSucess = $this->msgsuccess;
                    $messaError  = $this->msgerror;
                }else if(!empty($pass)){

                    $pass = password_hash($pass, PASSWORD_DEFAULT);

                    $resInsetAct = $this->musuario->m_usuario_update([$pass, $keyNiv, $keyUsu]);
                    $messaSucess = $this->msgsuccess;
                    $messaError  = $this->msgerror;
                }

                if((int) $resInsetAct === 1){
                    $data['status'] = true;
                    $data['msg']    = $messaSucess;
                }else{
                    $data['status'] = false;
                    $data['msg']    = $messaError;
                }
            }
        }
        return $this->response->setJSON($data);
    }

    // ***
}
?>