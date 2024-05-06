<?php

namespace App\Controllers;
use App\Models\MlocalidadModel;
use App\Models\MinfocoreModel;
use CodeIgniter\Controller;
use Config\Services;

class Localidad extends BaseController
{   
    protected $mlocalidad;
    protected $minfocore;
    protected $validacion;

    public function __construct()
    {
        $this->mlocalidad = new MlocalidadModel();
        $this->minfocore = new MinfocoreModel();
        $this->validacion = Services::validation();
        helper('fn_helper');
    }

    public function index() {
        $data['dataRegiones'] = $this->minfocore->m_regiones();
        return view('admin/mantenimiento/vlocalidad', $data);
    }

    public function c_localidad_list() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $codDis = $this->request->getPost('codDis');
            $localidad = $this->request->getPost('localidad');

            $codDis = (!empty($codDis))? bs64url_dec($codDis): '%';
            $localidad = (!empty($localidad))? $localidad."%": '%';

            if(isset($codDis) && !empty($codDis)){
                $dataLocalidad = $this->mlocalidad->m_localidad_list([$localidad, $codDis]);

                $tabla = "";
                if(is_array($dataLocalidad) && !empty($dataLocalidad)){
                    foreach($dataLocalidad as $key => $loc){
                        $count = ++$key;
                        $keyLoc = bs64url_enc($loc->key_loca);
                        $local  = esc($loc->loca);
                        $keyDis = bs64url_enc($loc->key_dis);
                        $dis    = esc($loc->dis);

                        $tabla .= "
                            <tr>
                                <td class='font-weight-bolder'>$count</td>
                                <td>
                                    $local
                                </td>
                                <td>
                                    <i class='fas fa-map-signs text-primary fa-sm'></i> 
                                    $dis
                                </td>
                                <td>
                                    <button type='button' class='btn btn-warning btn-sm btn_loca_edit' data-keyest='Mg--' data-keyloc='$keyLoc' data-loc='$local' data-keydis='$keyDis'>
                                        <i class='far fa-edit'></i> 
                                        Editar
                                    </button>

                                    <button type='button' class='btn btn-danger btn-sm btn_loca_del' data-keyloc='$keyLoc'>
                                        <i class='far fa-trash-alt'></i> 
                                        Eliminar
                                    </button>
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
                $data['dataLocalidad'] = $tabla;
            }
        }
        return $this->response->setJSON($data);
    }

    public function c_localidad_crud() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){

            $rules = [
                'sle_loccrud_distr' => [
                    'label' => 'Distrito',
                    'rules' => 'required'
                ],
                'txt_loccrud_loc' => [
                    'label' => 'Localidad',
                    'rules' => 'required|min_length[3]'
                ],
            ];

            $this->validacion->setRules($rules);

            if($this->validacion->withRequest($this->request)->run()){

                $est     = (int) bs64url_dec($this->request->getPost('txt_loccrud_esta'));
                $keyLoc  = (int) bs64url_dec($this->request->getPost('txt_loccrud_keyloca'));
                $loca    = mb_strtoupper($this->request->getPost('txt_loccrud_loc'));
                $keyDis  = bs64url_dec($this->request->getPost('sle_loccrud_distr'));
                
                if( (isset($est) && !empty($est)) && (isset($loca) && !empty        ($loca)) && (isset($keyDis) && !empty($keyDis)) ){

                    if($est === 1){
                        $resInsetAct = $this->mlocalidad->m_localidad_insert([$loca, $keyDis]);
                        $messaSucess = $this->msgsuccess;
                        $messaError  = $this->msgerror;
                    }else if($est === 2 && (isset($keyLoc) && !empty($keyLoc))){
                        $resInsetAct = $this->mlocalidad->m_localidad_update([$loca, $keyDis, $keyLoc]);
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
            }else{
                $data['errors'] = $this->validacion->getErrors();
            }
        }
        return $this->response->setJSON($data);
    }

    public function c_localidad_del(){
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $keyLoc = bs64url_dec($this->request->getPost('keyLoc'));
            if(isset($keyLoc) && !empty($keyLoc)){
                $resDel = $this->mlocalidad->m_localidad_del($keyLoc);
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