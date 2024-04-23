<?php

namespace App\Controllers;
use App\Models\MinfocoreModel;
use CodeIgniter\Controller;
use Config\Services;

class Infocore extends BaseController
{   
    protected $minfocore;
    protected $helpers = ['url', 'form', 'fn_helper'];

    public function __construct()
    {
        $this->minfocore = new MinfocoreModel();
        // $this->validation = \Config\Services::validation();
        // $this->validation = Services::validation();
    }

    public function c_departamentos_list() {
        
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $codReg = bs64url_dec($this->request->getPost('codReg'));
            $options = "";
            if(isset($codReg) && !empty($codReg)){
                $dataDepartementos = $this->minfocore->m_departamentos($codReg);
                if(is_array($dataDepartementos) && !empty($dataDepartementos)){
                    $options .= "<option value='#'>Seleccionar*</option>";
                    foreach($dataDepartementos as $dep){
                        $val = bs64url_enc($dep->key_dep);
                        $options .= "<option value='$val'>".esc($dep->depar)."</option>";
                    }
                }else{
                    $options .= "<option value='#'>No hay resultados</option>";
                }
            }else{
                $options .= "<option value='#'>No hay resultados</option>";
            }
            $data['status'] = true;
            $data['msg'] = 'ok';
            $data['dataDepartamentos'] = $options;
        }
        return $this->response->setJSON($data);
    }

    public function c_provincias_list() {
        
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $codDep = bs64url_dec($this->request->getPost('codDep'));
            $options = "";
            if(isset($codDep) && !empty($codDep)){
                $dataProvincias = $this->minfocore->m_provincias($codDep);
                if(is_array($dataProvincias) && !empty($dataProvincias)){
                    $options .= "<option value='#'>Seleccionar*</option>";
                    foreach($dataProvincias as $pro){
                        $keyPro = bs64url_enc($pro->key_prov);
                        $options .= "<option value='$keyPro'>".esc($pro->provincia)."</option>";
                    }
                }else{
                    $options .= "<option value='#'>No hay resultados</option>";
                }
            }else{
                $options .= "<option value='#'>No hay resultados</option>";
            }
            $data['status'] = true;
            $data['msg'] = 'ok';
            $data['dataProvincias'] = $options;
        }
        return $this->response->setJSON($data);
    }

    public function c_distritos_list() {
        
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $codProv = bs64url_dec($this->request->getPost('codProv'));
            $options = "";
            if(isset($codProv) && !empty($codProv)){
                $dataDistritos = $this->minfocore->m_distritos($codProv);
                if(is_array($dataDistritos) && !empty($dataDistritos)){
                    $options .= "<option value='#'>Seleccionar*</option>";
                    foreach($dataDistritos as $dis){
                        $keyDis = bs64url_enc($dis->key_distrito);
                        $options .= "<option value='$keyDis'>".esc($dis->distrito)."</option>";
                    }
                }else{
                    $options .= "<option value='#'>No hay resultados</option>";
                }
            }else{
                $options .= "<option value='#'>No hay resultados</option>";
            }
            $data['status'] = true;
            $data['msg'] = 'ok';
            $data['dataDistritos'] = $options;
        }
        return $this->response->setJSON($data);
    }

    public function c_localidad_list() {
        
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $codDis = bs64url_dec($this->request->getPost('codDis'));
            $options = "";
            if(isset($codDis) && !empty($codDis)){
                $dataLocalidad = $this->minfocore->m_localidad($codDis);
                if(is_array($dataLocalidad) && !empty($dataLocalidad)){
                    $options .= "<option value='#'>Seleccionar*</option>";
                    foreach($dataLocalidad as $loc){
                        $keyLoc = bs64url_enc($loc->key_localidad);
                        $options .= "<option value='$keyLoc'>".esc($loc->localidad)."</option>";
                    }
                }else{
                    $options .= "<option value='#'>No hay resultados</option>";
                }
            }else{
                $options .= "<option value='#'>No hay resultados</option>";
            }
            $data['status'] = true;
            $data['msg'] = 'ok';
            $data['dataLocalidad'] = $options;
        }
        return $this->response->setJSON($data);
    }

    public function c_sector_list() {
        
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $codLoc = bs64url_dec($this->request->getPost('codLoc'));
            $options = "";
            if(isset($codLoc) && !empty($codLoc)){
                $dataSector = $this->minfocore->m_sector($codLoc);
                if(is_array($dataSector) && !empty($dataSector)){
                    $options .= "<option value='#'>Seleccionar*</option>";
                    foreach($dataSector as $sec){
                        $keySec = bs64url_enc($sec->key_sector);
                        $options .= "<option value='$keySec'>".esc($sec->sector)."</option>";
                    }
                }else{
                    $options .= "<option value='#'>No hay resultados</option>";
                }
            }else{
                $options .= "<option value='#'>No hay resultados</option>";
            }
            $data['status'] = true;
            $data['msg'] = 'ok';
            $data['dataSector'] = $options;
        }
        return $this->response->setJSON($data);
    }

// ***
}
?>