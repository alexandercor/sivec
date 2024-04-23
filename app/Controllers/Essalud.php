<?php

namespace App\Controllers;
use App\Models\MessaludModel;

use CodeIgniter\Controller;

class Essalud extends BaseController
{   
    protected $messalud;
    protected $helpers = ['form', 'fn_helper'];

    public function __construct()
    {
        $this->messalud = new MessaludModel();
    }

    public function index(){
        return view('admin/mantenimiento/vessalud');
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
                        $tabla .= "
                            <tr>
                                <td class='font-weight-bolder'>$count</td>
                                <td>
                                    <input type='text' value='$keyEss'>
                                    $ess->ess
                                </td>
                                <td>
                                    $ess->sec
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
                $data['dataEssalud'] = $tabla;
            }
        }
        return $this->response->setJSON($data);
    }

// ****
}
?>