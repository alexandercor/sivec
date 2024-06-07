<?php

namespace App\Models\Reportes;

use CodeIgniter\Model;

class MreportesConsolidadoModel extends Model{

    public function m_reporte_consolidado_inspectores($params): object {
        $sql =
        'SELECT 
            `tb_persona`.`apellidos_nombres` inspector
            FROM
            `tb_colaborador`
            INNER JOIN `tb_control` ON (`tb_colaborador`.`id_colaborador` = `tb_control`.`id_colaborador`)
            INNER JOIN `tb_persona` ON (`tb_colaborador`.`id_persona` = `tb_persona`.`id_persona`)
            INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
        WHERE
            `tb_control`.`fecha_control` BETWEEN ? AND ? AND
            `tb_colaborador`.`tipo_col` = 2
        GROUP BY
            `tb_persona`.`apellidos_nombres`
        ';
        $response = $this->db->query($sql, $params);
        return $response->getResult();
    }

    public function m_reporte_consolidado_viviendas_totales($params): object {
        $sql =
        'SELECT 
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 1 THEN 1 ELSE 0 END) AS `cerrada`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 2 THEN 1 ELSE 0 END) AS `renuente`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 3 THEN 1 ELSE 0 END) AS `deshabitada`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 4 THEN 1 ELSE 0 END) AS `otros`
        FROM
            `tb_colaborador`
            INNER JOIN `tb_control` ON (`tb_colaborador`.`id_colaborador` = `tb_control`.`id_colaborador`)
            INNER JOIN `tb_persona` ON (`tb_colaborador`.`id_persona` = `tb_persona`.`id_persona`)
            INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
            INNER JOIN `tb_situacion_viv` ON (`tb_det_control`.`id_situacion_vivienda` = `tb_situacion_viv`.`id_situacion_vivienda`)
        WHERE
            `tb_control`.`fecha_control` BETWEEN ? AND ? AND 
            `tb_persona`.`id_persona` = ? AND
            `tb_colaborador`.`tipo_col` = 2
        ';
        $response = $this->db->query($sql, $params);
        return $response->getRow();
    }

    // ***
}
?>