<?php

namespace App\Controllers;
use App\Models\MrecipienteModel;
use App\Models\MinfocoreModel;
use CodeIgniter\Controller;

class Recipientes extends BaseController
{   
    public $mrecipiente;
    public $minfocore;
    public function __construct()
    {
        $this->mrecipiente = new MrecipienteModel();
        $this->minfocore = new MinfocoreModel();
        helper('fn_helper');
    }

    public function index() {
        $data['mediadReci'] = $this->minfocore->m_recipientemedidas();
        return view('admin/mantenimiento/vrecipientes', $data);
    }

    public function c_recipiente_list() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $rec = $this->request->getPost('rec');
            $rec = (!empty($rec))? "$rec%": '%';

            if(isset($rec) && !empty($rec)){
                $dataRec = $this->mrecipiente->m_recipientes_list($rec);

                $tabla = "";
                if(is_array($dataRec) && !empty($dataRec)){
                    foreach($dataRec as $key => $rec){
                        $count = ++$key;

                        $keyRec    = $rec->key_dep_tip;
                        $keyRecEnc = bs64url_enc($rec->key_dep_tip);
                        $recNomb   = $rec->depo;
                        $keyCapEnc = bs64url_enc($rec->key_capacidad);

                        $tabla .= "
                            <tr>
                                <td class='font-weight-bolder'>$count</td>
                                <td>
                                    $rec->depo
                                </td>
                                <td>
                                    $rec->capacidad
                                </td>
                                <td>
                                    <button type='button' class='btn btn-warning btn-sm btn_rec_edit' data-codestado='Mg--' data-keyrec='$keyRecEnc' data-reci='$recNomb' data-keycapa='$keyCapEnc'><i class='far fa-edit'></i> Editar</button>
                                    <button type='button' class='btn btn-danger btn-sm btn_rec_dele' data-key='$keyRecEnc'><i class='far fa-edit'></i> Eliminar</button>
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
                $data['dataRecipiente'] = $tabla;
            }
        }
        return $this->response->setJSON($data);
    }

    public function c_recipiente_crud() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $est    = intval(bs64url_dec($this->request->getPost('txt_mdlcrudrec_est')));
            $keyRec = bs64url_dec($this->request->getPost('txt_mdlcrudrec_keyrec'));
            $rec    = $this->request->getPost('txt_mdlcrudrec_rec');
            $codMed = bs64url_dec($this->request->getPost('sle_mdlcrudviewmed_medida'));

            if( (isset($rec) && !empty($rec)) && (isset($codMed) && !empty($codMed)) ){
                if($est === 1){
                    $resInsetRec = $this->mrecipiente->m_rec_insert([$rec, $codMed]);
                    $messaSucess = $this->msgsuccess;
                    $messaError  = $this->msgerror;
                }else if($est === 2 && (isset($keyRec) && !empty($keyRec))){
                    $resInsetRec = $this->mrecipiente->m_rec_update([$rec, $codMed, $keyRec]);
                    $messaSucess = $this->msgsuccess;
                    $messaError  = $this->msgerror;
                }

                if((int) $resInsetRec === 1){
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

    public function c_recipiente_del(){
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $keyRec = bs64url_dec($this->request->getPost('key'));
            if(isset($keyRec) && !empty($keyRec)){
                $resDel = $this->mrecipiente->c_recipiente_del($keyRec);
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