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
                        $keyRec = bs64url_enc($rec->key_dep_tip);

                        $tabla .= "
                            <tr>
                                <td class='font-weight-bolder'>$count</td>
                                <td>
                                    <input type='text' value='$keyRec'>
                                    $rec->depo
                                </td>
                                <td>
                                    $rec->capacidad
                                </td>
                                <td>
                                    <button type='button' class='btn btn-warning btn-sm'><i class='far fa-edit'></i> Editar</button>
                                    <button type='button' class='btn btn-danger btn-sm btn_rec_dele' data-key='$keyRec'><i class='far fa-edit'></i> Eliminar</button>
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
            
            $rec    = $this->request->getPost('txt_mdlcrudrec_rec');
            $codMed = bs64url_dec($this->request->getPost('sle_mdlcrudviewmed_medida'));

            if( (isset($rec) && !empty($rec)) && (isset($codMed) && !empty($codMed)) ){
                $resInsetRec = $this->mrecipiente->m_rec_insert([$rec, $codMed]);
                if((int) $resInsetRec === 1){
                    $data['status'] = true;
                    $data['msg']    = 'Datos Guardados correctamente!!';
                }else{
                    $data['status'] = true;
                    $data['msg']    = 'Ocurrio un problema al insertar!!';
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
                    $data['msg']    = 'Se elimino correctamente!!';
                }else{
                    $data['status'] = false;
                    $data['msg']    = 'Ocurrio un problema';
                }
            }
        }
        return $this->response->setJSON($data);
    }
// ***
}
?>