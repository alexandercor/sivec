<?php

namespace App\Controllers\Reportes;
use App\Models\Reportes\McoreReportModel;
use App\Models\MinfocoreModel;
use App\Controllers\BaseController;

class CoreReport extends BaseController
{   
    protected $mcorereport;
    public $minfocore;

    public function __construct()
    {
        $this->mcorereport = new McoreReportModel();
        $this->minfocore = new MinfocoreModel();
        helper('fn_helper');
    }

    public function c_inspeccion_inspeccion_index() {
        $data['inspectores'] = $this->mcorereport->m_inspeccion_inspectores();
        return view('admin/reportes/vinspeccion', $data);
    }

    public function c_inspeccion_inspeccionados_list() {
        $data['status'] = $this->status;
        $data['msg']    = $this->msg;

        if($this->request->isAJAX()){
            $codIns = $this->request->getPost('codIns');
            $codIns = (!empty($codIns))? bs64url_dec($codIns): "%";

            if(isset($codIns) && !empty($codIns)){
                $dataInspecciones = $this->mcorereport->m_inspeccion_inspeccionados_list($codIns);

                $tabla = "";
                if(is_array($dataInspecciones) && !empty($dataInspecciones)){
                    foreach($dataInspecciones as $key => $ins){
                        $count = ++$key;
                        $keyContr = bs64url_enc($ins->key_control);
                        $supervi  = esc($ins->super);
                        $fechRegi = fdate($ins->fech_reg);
                        $actidad  = esc($ins->acti);
                        $eess     = esc($ins->eess);
                        $sector   = esc($ins->sector);

                        $tabla .= "
                            <tr>
                                <td class='font-weight-bolder'>$count</td>
                                <td>
                                    $fechRegi
                                </td>
                                <td>
                                    <i class='far fa-user-circle text-primary'></i> 
                                    $supervi
                                </td>
                                <td>$actidad</td>
                                <td><i class='fas fa-hospital text-danger'></i> $eess</td>
                                <td>$sector</td>
                                <td>
                                    <a href='".base_url()."reportes/inspeccion/xls/".$keyContr."' class='btn btn-success btn-sm'>
                                    <i class='fas fa-file-excel'></i> 
                                        Descargar Reporte
                                    </a>
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
                $data['dataInspecciones'] = $tabla;
            }
        }
        return $this->response->setJSON($data);
    }


    public function c_consolidado_diario_index() {
        // $data['inspectores'] = $this->mcorereport->m_inspeccion_inspectores();
        return view('admin/reportes/vconsolidadoDiario');
    }

    public function c_reporte_sector_index() {
        $data['dataRegiones'] = $this->minfocore->m_regiones();
        return view('admin/reportes/vreporteSector', $data);
    }

    public function c_reporte_inspector_index() {
        // $data['inspectores'] = $this->mcorereport->m_inspeccion_inspectores();
        return view('admin/reportes/vinspector');
    }

// ***
}
?>