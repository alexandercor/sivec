<?php

namespace App\Controllers;
use App\Models\MactividadModel;
use CodeIgniter\Controller;

class Actividades extends BaseController
{   
    protected $mactividad;

    public function __construct()
    {
        $this->mactividad = new MactividadModel();
        // $this->validation = \Config\Services::validation();
        helper('fn_helper');
    }

    public function index() {
        return view('admin/mantenimiento/vactividades');
    }

    public function c_actividades_list() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $actividad = $this->request->getPost('actividad');
            $actividad = (!empty($actividad))? "$actividad%": '%';

            if(isset($actividad) && !empty($actividad)){
                $dataActi = $this->mactividad->m_actividades_list($actividad);

                $tabla = "";
                if(is_array($dataActi) && !empty($dataActi)){
                    foreach($dataActi as $key => $act){
                        $count = ++$key;
                        $keyActiv = bs64url_enc($act->key_act);
                        $activi   = $act->activi;

                        $tabla .= "
                            <tr>
                                <td class='font-weight-bolder'>$count</td>
                                <td>
                                    $act->activi
                                </td>
                                <td>
                                    <button type='button' class='btn btn-warning btn-sm btn_act_edit' data-keyest='Mg--' data-keyact='$keyActiv' data-act='$activi'><i class='far fa-edit'></i> Editar</button>
                                    <button type='button' class='btn btn-danger btn-sm btn_act_del' data-keyact='$keyActiv'><i class='far fa-trash-alt'></i> Eliminar</button>
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
                $data['dataActividad'] = $tabla;
            }
        }
        return $this->response->setJSON($data);
    }

    public function c_actividades_crud() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){

            $est = (int) bs64url_dec($this->request->getPost('txt_crudact_esta'));
            $keyAct = bs64url_dec($this->request->getPost('txt_crudact_keyact'));
            $actividad = $this->request->getPost('txt_crudact_activ');

            if( isset($actividad) && !empty($actividad) ){
                if($est === 1){
                    $resInsetAct = $this->mactividad->m_actividades_insert($actividad);
                    $messaSucess = $this->msgsuccess;
                    $messaError  = $this->msgerror;
                }else if($est === 2 && (isset($keyAct) && !empty($keyAct))){
                     $resInsetAct = $this->mactividad->m_actividades_update([$actividad, $keyAct]);
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

    public function c_actividad_del(){
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $keyAct = bs64url_dec($this->request->getPost('keyAct'));
            if(isset($keyAct) && !empty($keyAct)){
                $resDel = $this->mactividad->m_actividad_del($keyAct);
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

// ***
}
?>