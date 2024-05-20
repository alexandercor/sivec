<?php

namespace App\Controllers;
use App\Models\MpersonaModel;
use App\Models\MusuarioModel;

use Config\Services;
use CodeIgniter\Controller;

class Persona extends BaseController
{   
    public $mpersona;
    public $musuario;
    public $validacion;

    public function __construct()
    {
        $this->mpersona = new MpersonaModel();
        $this->musuario = new MusuarioModel();
        $this->validacion = Services::validation();
        helper('fn_helper');
    }

    public function index() {
        return view('admin/mantenimiento/vpersona');
    }

    public function c_persona_list(){
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $persona = $this->request->getPost('persona');
            $persona = (!empty($persona))? "$persona%": '%';

            if(isset($persona) && !empty($persona)){
                $dataPersona = $this->mpersona->m_personas_list($persona);

                $tabla = "";
                if(is_array($dataPersona) && !empty($dataPersona)){
                    foreach($dataPersona as $key => $per){
                        $count = ++$key;
                        $keyPer   = bs64url_enc($per->key_per);
                        $fech_reg = fdate($per->fecha_reg);
                        $dni      = $per->dni;
                        $pers     = $per->persona;
                        $fech_nac = fdate($per->fech_nac);
                        $fechnac  = $per->fech_nac;
                        $email    = $per->email;
                        $celular  = $per->celular;
                        $celular2 = $per->celular2;

                        $tabla .= "
                            <tr>
                                <td class='font-weight-bolder'>$count</td>
                                <td>$fech_reg</td>
                                <td>$dni</td>
                                <td><i class='fas fa-user-check'></i> $pers</td>
                                <td>$fech_nac</td>
                                <td><i class='fas fa-envelope text-danger'></i> $email</td>
                                <td>$celular</td>
                                <td>
                                    <button type='button' class='btn btn-warning btn-sm btn_per_edit' data-keyest='Mg--' data-keyper='$keyPer' data-dni='$dni' data-per='$pers' data-fechnac='$fechnac' data-email='$email' data-celular='$celular' data-celular2='$celular2'><i class='far fa-edit'></i> Editar</button>
                                    <button type='button' class='btn btn-danger btn-sm btn_per_del' data-keyper='$keyPer'><i class='far fa-edit'></i> Eliminar</button>
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
                $data['dataPersonas'] = $tabla;
            }
        }
        return $this->response->setJSON($data);
    }

    public function c_persona_crud() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){

            $rules = [
                'txt_crudper_dni' => [
                    'label' => 'Dni',
                    'rules'  => 'required|integer|exact_length[8]'
                ],
                'txt_crudper_per' => [
                    'label' => 'Colaborador',
                    'rules'  => 'required'
                ],
                'txt_crudper_fechnac' => [
                    'label' => 'Fecha de Nacimiento',
                    'rules'  => 'required'
                ],
                'txt_crudper_email' => [
                    'label' => 'Email',
                    'rules'  => 'required|valid_email'
                ],
                'txt_crudper_celular' => [
                    'label' => 'Celular',
                    'rules'  => 'required|integer|exact_length[9]'
                ],
                'txt_crudper_usuario' => [
                    'label' => 'Usuario',
                    'rules'  => 'required|alpha'
                ],
                'txt_crudper_contraseña' => [
                    'label' => 'Constraseña',
                    'rules'  => 'required'
                ],
                'sle_percrud_nivel' => [
                    'label' => 'Nivel de usuario',
                    'rules'  => 'required'
                ],
                'sle_percrud_tip_col' => [
                    'label' => 'Tipo de colaborador',
                    'rules'  => 'required'
                ],
            ];

            $this->validacion->setRules($rules);

            if($this->validacion->withRequest($this->request)->run()){

                $keyEst  = (int) bs64url_dec($this->request->getPost('txt_crudper_esta'));
                $keyPer  = bs64url_dec($this->request->getPost('txt_crudper_keyper'));
                $dni     = $this->request->getPost('txt_crudper_dni');
                $per     = esc(mb_strtoupper($this->request->getPost('txt_crudper_per')));
                $fechNac = $this->request->getPost('txt_crudper_fechnac');
                $email   = esc($this->request->getPost('txt_crudper_email'));
                $cel     = $this->request->getPost('txt_crudper_celular');
                $cel2    = $this->request->getPost('txt_crudper_celular2');
                
                $user   = $this->request->getPost('txt_crudper_usuario');
                $pass   = $this->request->getPost('txt_crudper_contraseña');
                $nive   = bs64url_dec($this->request->getPost('sle_percrud_nivel'));
                $codTipoCol = bs64url_dec($this->request->getPost('sle_percrud_tip_col'));

                $dataPer = [$dni, $per, $fechNac, $cel, $cel2, $email];

                
                if( (isset($per) && !empty($per)) && (isset($fechNac) && !empty($fechNac)) && (isset($email) && !empty($email)) && (isset($cel) && !empty($cel)) && isset($cel2) ){
                    if($keyEst === 1){
                        $resInsetAct = $this->mpersona->m_persona_insert($dataPer);
                        [$estadoInsert, $lastId] = $resInsetAct;

                        $estadoInsert = (int) $estadoInsert;
                        if( ($estadoInsert === 1) && (isset($user) && !empty($user)) && (isset($pass) && !empty($pass)) && (isset($nive) && !empty($nive))){

                            $passwordHash = password_hash($pass, PASSWORD_DEFAULT);  
                            
                            $resUserInsert = $this->musuario->m_usuario_insert([$user, $passwordHash, $nive, $lastId]);

                            if((int) $resUserInsert === 1){
                                $resInsertCol = $this->mpersona->m_col_tipo([$codTipoCol, $lastId]);
                                if((int) $resInsertCol === 1){
                                    $data['status'] = true;
                                    $data['msg']    = $this->msgsuccess;
                                }
                            }else{
                                $data['status'] = false;
                                $data['msg']    = $this->msgerror;
                            }
                        }
                    }else if($keyEst === 2 && (isset($keyPer) && !empty($keyPer))){
                        $resInsetAct = $this->mpersona->m_persona_update([$dni, $per, $fechNac, $cel, $cel2, $email, $keyPer]);
                        if((int) $resInsetAct === 1){
                            $data['status'] = true;
                            $data['msg']    = $this->msgsuccess;
                        }else{
                            $data['status'] = false;
                            $data['msg']    = $this->msgerror;
                        }
                    }   
                }
            }else{
                $data['errors'] = $this->validacion->getErrors();
                $data['msg']    = 'Completar datos';
            }
        }
        return $this->response->setJSON($data);
    }

    public function c_persona_del(){
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $keyPerso = bs64url_dec($this->request->getPost('keyPer'));
            if(isset($keyPerso) && !empty($keyPerso)){
                $resDel = $this->mpersona->m_persona_del($keyPerso);
                if((int) $resDel === 1){
                    $data['status'] = true;
                    $data['msg']    = $this->msgdelete;
                }else{
                    $data['status'] = false;
                    $data['msg']    = $this->msgdelerror;
                }
            }
        }
        return $this->response->setJSON($data);
    }

// ****
}
?>