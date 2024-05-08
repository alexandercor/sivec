<?php

namespace App\Controllers;
use App\Models\MessaludModel;
use App\Models\MinfocoreModel;

use Config\Services;
use CodeIgniter\Controller;

class Essalud extends BaseController
{   
    protected $messalud;
    protected $minfocore;
    protected $helpers = ['form', 'fn_helper'];
    protected $validacion;

    public function __construct()
    {
        $this->messalud = new MessaludModel();
        $this->minfocore = new MinfocoreModel();
        $this->validacion = Services::validation();
    }

    public function index(){
        $data['dataRegiones'] = $this->minfocore->m_regiones();
        return view('admin/mantenimiento/vessalud', $data);
    }

    public function c_essalud_list() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $codSec = $this->request->getPost('codSec');
            $codSec = (!empty($codSec))? bs64url_dec($codSec): '%';

            if(isset($codSec) && !empty($codSec)){
                $dataEssalud = $this->messalud->m_essalud_list($codSec);

                $tabla = "";
                if(is_array($dataEssalud) && !empty($dataEssalud)){
                    foreach($dataEssalud as $key => $ess){
                        $count = ++$key;
                        $keyEss = bs64url_enc($ess->key_ess);
                        $eess   = esc($ess->ess);
                        $keySec = bs64url_enc($ess->key_sec);
                        $sec    = esc($ess->sec);
                        $loc    = esc($ess->loca);
                        $dis    = esc($ess->dis);
                        $pro    = esc($ess->prov);
                        $dep    = esc($ess->dep);
                        $reg    = esc($ess->reg);

                        $tabla .= "
                            <tr>
                                <td class='font-weight-bolder'>$count</td>
                                <td>
                                    $eess
                                </td>
                                <td>
                                    <i class='fas fa-map-signs text-primary fa-sm'></i> 
                                    $sec
                                </td>
                                <td> $loc </td>
                                <td> $dis </td>
                                <td> $pro </td>
                                <td> $dep </td>
                                <td> $reg </td>
                                <td>
                                    <button type='button' class='btn btn-warning btn-sm btn_eess_edit' data-keyest='Mg--' data-keyeess='$keyEss' data-eess='$eess' data-keysec='$keySec'>
                                        <i class='far fa-edit'></i> 
                                        Editar
                                    </button>

                                    <button type='button' class='btn btn-danger btn-sm btn_eess_del' data-keyeess='$keyEss'>
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
                $data['dataEssalud'] = $tabla;
            }
        }
        return $this->response->setJSON($data);
    }

    public function c_essalud_crud() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){

            $rules = [
                'sle_esscrud_sector' => [
                    'label' => 'Sector',
                    'rules' => 'required'
                ],
                'txt_esscrud_eess' => [
                    'label' => 'Centro de Salud',
                    'rules' => 'required|min_length[3]'
                ],
            ];

            $this->validacion->setRules($rules);

            if($this->validacion->withRequest($this->request)->run()){

                $est = (int) bs64url_dec($this->request->getPost('txt_esscrud_esta'));
                $keyEess = (int) bs64url_dec($this->request->getPost('txt_esscrud_keyeess'));
                $eess    = mb_strtoupper($this->request->getPost('txt_esscrud_eess'));
                $keySec  = bs64url_dec($this->request->getPost('sle_esscrud_sector'));
                
                if( (isset($est) && !empty($est)) && (isset($keySec) && !empty        ($keySec)) && (isset($eess) && !empty($eess)) ){

                    if($est === 1){
                        $resInsetAct = $this->messalud->m_essalud_insert([$eess, $keySec]);
                        $messaSucess = $this->msgsuccess;
                        $messaError  = $this->msgerror;
                    }else if($est === 2 && (isset($keyEess) && !empty($keyEess))){
                        $resInsetAct = $this->messalud->m_essalud_update([$eess, $keySec, $keyEess]);
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

    public function c_essalud_del(){
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $keyEess = bs64url_dec($this->request->getPost('keyEess'));
            if(isset($keyEess) && !empty($keyEess)){
                $resDel = $this->messalud->m_essalud_del($keyEess);
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