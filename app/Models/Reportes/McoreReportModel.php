<?php

namespace App\Models\Reportes;

use CodeIgniter\Model;

class McoreReportModel extends Model{

    public function m_inspeccion_inspectores(): array {
        $sql = "
            SELECT 
                `tb_persona`.`id_persona` key_per,
                `tb_persona`.`apellidos_nombres` inspector
            FROM
                `tb_persona`
                INNER JOIN `tb_colaborador` ON (`tb_persona`.`id_persona` = `tb_colaborador`.`id_persona`)
            WHERE
                `tb_colaborador`.`tipo_col` = 2
            ORDER BY
                `tb_persona`.`apellidos_nombres`
        ";
        $response = $this->db->query($sql);
        return $response->getResult();
    }

    public function m_inspeccion_inspeccionados_list(array $params): array {
        $sql = 
            "SELECT 
                `tb_control`.`id_control` AS `key_control`,
                `tb_persona`.`apellidos_nombres` AS `super`,
                `tb_control`.`fecha_control` AS `fech_reg`,
                `tb_actividadtipo`.`nombre_actividadtipo` AS `acti`,
                `tb_eess`.`nombre_eess` AS `eess`,
                `tb_sector`.`nombre_sector` AS `sector`,
                `tb_localidad`.`nombre_localidad` localidad
            FROM
                `tb_colaborador`
                INNER JOIN `tb_control` ON (`tb_colaborador`.`id_colaborador` = `tb_control`.`id_colaborador`)
                INNER JOIN `tb_persona` ON (`tb_colaborador`.`id_persona` = `tb_persona`.`id_persona`)
                INNER JOIN `tb_actividadtipo` ON (`tb_control`.`id_actividadtipo` = `tb_actividadtipo`.`id_actividadtipo`)
                INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
                INNER JOIN `tb_eess` ON (`tb_control`.`id_eess` = `tb_eess`.`id_eess`)
                INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`) 
            WHERE
                `tb_localidad`.`id_localidad` LIKE ? AND
                `tb_persona`.`apellidos_nombres` LIKE ? AND
                DATE(`tb_control`.`fecha_control`) LIKE ?
        ";
        $response = $this->db->query($sql, $params);
        return $response->getResult();
    }

    public function m_control_get_img($codControl) {
        $sql =
        "SELECT 
            `tb_control`.`id_control` key_control,
            `tb_det_fotografias`.`fotografia1` ft1,
            `tb_det_fotografias`.`fotografia2` ft2,
            `tb_det_fotografias`.`fotografia3` ft3,
            `tb_det_fotografias`.`fotografia4` ft4,
            `tb_det_fotografias`.`fotografia5` ft5
        FROM
            `tb_control`
            INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
            INNER JOIN `tb_det_fotografias` ON (`tb_det_control`.`id_detalle_control` = `tb_det_fotografias`.`id_detalle_control`)
        WHERE
            `tb_control`.`id_control` = ?
        ";
        $response = $this->db->query($sql, $codControl);
        $response = $response->getRow();
        return (!empty($response))? $response : '';
    }

    // ** *
}
?>