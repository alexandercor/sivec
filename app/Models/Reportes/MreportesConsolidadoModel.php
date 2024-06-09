<?php

namespace App\Models\Reportes;

use CodeIgniter\Model;

class MreportesConsolidadoModel extends Model{

    public function m_reporte_consolidado_inspectores($params): array {
        $sql =
        'SELECT 
            `tb_persona`.`id_persona` key_persona,
            `tb_persona`.`apellidos_nombres` inspector,
            `tb_det_control`.`cant_residentes` cant_resi,
            `tb_det_control`.`consumo_larvicida_gr` con_ler
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
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 1 THEN 1 ELSE 0 END) AS `inspeccionada`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 2 THEN 1 ELSE 0 END) AS `renuente`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 3 THEN 1 ELSE 0 END) AS `deshabitada`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 4 THEN 1 ELSE 0 END) AS `cerrada`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 5 THEN 1 ELSE 0 END) AS `tratada`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 6 THEN 1 ELSE 0 END) AS `positivos`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 7 THEN 1 ELSE 0 END) AS `otros`
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

    public function m_reporte_consolidado_totales_X_deposito_tipo_X_inspector($params): object {
        $sql =
        'SELECT
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = ? AND `tb_depositos_tipos`.`id_depositotipo` = ? THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS total

            FROM
            `tb_det_control`
            INNER JOIN `tb_control` ON (`tb_det_control`.`id_control` = `tb_control`.`id_control`)
            INNER JOIN `tb_det_control_depositos` ON (`tb_det_control_depositos`.`id_detalle_control` = `tb_det_control`.`id_detalle_control`)
            INNER JOIN `tb_depositos` ON (`tb_depositos`.`id_deposito` = `tb_det_control_depositos`.`id_deposito`)
            INNER JOIN `tb_depositos_tipos` ON (`tb_det_control_depositos`.`id_depositotipo` = `tb_depositos_tipos`.`id_depositotipo`)
            INNER JOIN `tb_colaborador` ON (`tb_colaborador`.`id_colaborador` = `tb_control`.`id_colaborador`)
            INNER JOIN `tb_persona` ON (`tb_persona`.`id_persona` = `tb_colaborador`.`id_persona`)
            WHERE
            `tb_persona`.`id_persona` = ?
        ';
        $response = $this->db->query($sql, $params);
        return $response->getRow();
    }

    
    // ***
}
?>