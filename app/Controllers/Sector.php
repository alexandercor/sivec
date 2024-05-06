<?php

namespace App\Controllers;
use App\Models\MsectorModel;
use App\Models\MinfocoreModel;

use CodeIgniter\Controller;
use Config\Services;

class Sector extends BaseController
{   
    protected $msector;
    protected $validacion;
    protected $minfocore;

    public function __construct()
    {
        $this->msector = new MsectorModel();
        $this->minfocore = new MinfocoreModel();
        $this->validacion = Services::validation();
        helper('fn_helper');
    }

    public function index(){
        $data['dataRegiones'] = $this->minfocore->m_regiones();
        return view('admin/mantenimiento/vsector', $data);
    }

    public function c_sector_list() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $sector = $this->request->getPost('sector');
            $codLoc = $this->request->getPost('codLoc');

            $sector = (!empty($sector))? $sector."%": '%';
            $codLoc = (!empty($codLoc))? bs64url_dec($codLoc): '%';

            if( (isset($sector) && !empty($sector)) && (isset($codLoc) && !empty($codLoc)) ){
                $dataSectores = $this->msector->m_sector_list([$sector, $codLoc]);

                $tabla = "";
                if(is_array($dataSectores) && !empty($dataSectores)){
                    foreach($dataSectores as $key => $sec){
                        $count = ++$key;
                        $keyLoc = bs64url_enc($sec->key_loc);
                        $loc    = esc($sec->loc);
                        $keySec = bs64url_enc($sec->key_sec);
                        $secRef = esc($sec->sec_ref);
                        $sec    = esc($sec->sec);

                        $tabla .= "
                            <tr>
                                <td class='font-weight-bolder'>$count</td>
                                <td>
                                    $sec
                                </td>
                                <td>
                                    <i class='fas fa-map-signs text-success fa-sm'></i> 
                                    $loc
                                </td>
                                <td>
                                    <button type='button' class='btn btn-warning btn-sm btn_sec_edit' data-keyest='Mg--' data-keysec='$keySec' data-sec='$sec' data-secref='$secRef' data-keyloc='$keyLoc'>
                                        <i class='far fa-edit'></i> 
                                        Editar
                                    </button>

                                    <button type='button' class='btn btn-danger btn-sm btn_sec_del' data-keysec='$keySec'>
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
                $data['dataSector'] = $tabla;
            }
        }
        return $this->response->setJSON($data);
    }

    public function c_sector_crud() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){

            $rules = [
                'txt_seccrud_esta' => [
                    'label' => 'CodEst',
                    'rules' => 'required'
                ],
                'txt_seccrud_sec' => [
                    'label' => 'Centro de Salud',
                    'rules' => 'required|min_length[3]'
                ],
                'sle_seccrud_locali' => [
                    'label' => 'CodEst',
                    'rules' => 'required'
                ],
            ];

            $this->validacion->setRules($rules);

            if($this->validacion->withRequest($this->request)->run()){

                $est = (int) bs64url_dec($this->request->getPost('txt_seccrud_esta'));
                $keySec = (int) bs64url_dec($this->request->getPost('txt_seccrud_keysec'));
                $sector  = mb_strtoupper($this->request->getPost('txt_seccrud_sec'));
                $secRef  = mb_strtoupper($this->request->getPost('txt_seccrud_sec_ref'));
                $keyLoc  = bs64url_dec($this->request->getPost('sle_seccrud_locali'));
                
                if( (isset($est) && !empty($est)) && (isset($sector) && !empty        ($sector)) && (isset($keyLoc) && !empty($keyLoc)) ){

                    if($est === 1){
                        $resInsetAct = $this->msector->m_sector_insert([$sector, $secRef, $keyLoc]);
                        $messaSucess = $this->msgsuccess;
                        $messaError  = $this->msgerror;
                    }else if($est === 2 && (isset($keySec) && !empty($keySec))){
                        $resInsetAct = $this->msector->m_sector_update([$sector, $secRef, $keyLoc, $keySec]);
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

    public function c_sector_del(){
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $keySec = bs64url_dec($this->request->getPost('keySec'));
            if(isset($keySec) && !empty($keySec)){
                $resDel = $this->msector->m_sector_del($keySec);
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