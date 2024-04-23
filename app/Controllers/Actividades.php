<?php

namespace App\Controllers;
use App\Models\MactividadModel;
use CodeIgniter\Controller;

class Actividades extends BaseController
{   
    protected $mactividad;
    // protected $validation;

    public function __construct()
    {
        $this->mactividad = new MactividadModel();
        // $this->validation = \Config\Services::validation();
        // helper('form');
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
                        $tabla .= "
                            <tr>
                                <td class='font-weight-bolder'>$count</td>
                                <td>
                                    $act->activi
                                </td>
                                <td>
                                    <button type='button' class='btn btn-warning btn-sm'><i class='far fa-edit'></i> Editar</button>
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
            
            $actividad = $this->request->getPost('txt_mdlviewact_activ');
            if(!empty($actividad) && isset($actividad)){
                $resInsetAct = $this->mactividad->m_actividades_insert($actividad);
                if((int) $resInsetAct === 1){
                    $data['status'] = true;
                    $data['msg']    = 'Datos Guardados correctamente!!';
                }
            }
        }
        return $this->response->setJSON($data);
    }

// ***
}
?>