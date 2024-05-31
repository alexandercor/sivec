<?php

namespace App\Models\Reportes;

use CodeIgniter\Model;

class MreportesInspeccionModel extends Model{

    public function mreporte_inspecciones_inspeccion_head($codInspector): object {
        $sql = "
            SELECT 
                `tb_control`.`id_control` key_control,
                `tb_persona`.`apellidos_nombres` inspecctor,
                `tb_control`.`fecha_control` fecha_reg,
                `tb_actividadtipo`.`nombre_actividadtipo` actividad,
                `tb_eess`.`nombre_eess` eess,
                `tb_sector`.`nombre_sector` sector
            FROM
                `tb_colaborador`
                INNER JOIN `tb_control` ON (`tb_colaborador`.`id_colaborador` = `tb_control`.`id_colaborador`)
                INNER JOIN `tb_persona` ON (`tb_colaborador`.`id_persona` = `tb_persona`.`id_persona`)
                INNER JOIN `tb_actividadtipo` ON (`tb_control`.`id_actividadtipo` = `tb_actividadtipo`.`id_actividadtipo`)
                INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
                INNER JOIN `tb_eess` ON (`tb_control`.`id_eess` = `tb_eess`.`id_eess`)
            WHERE
                `tb_control`.`id_control` = ?
        ";
        $response = $this->db->query($sql, $codInspector);
        return $response->getRow();
    }

    public function mreporte_inspeccion_inspeccionados_detalle_lista($codControl): array {
        $sql = '
            SELECT 
                `tb_det_control`.`id_detalle_control` key_detalle_control,
                `tb_det_control`.`codigo_manzana` cod_manzan,
                `tb_det_control`.`direccion` direcc,
                `tb_det_control`.`nombre_persona_at` per_aten,
                `tb_det_control`.`cant_residentes` n_resid,
                `tb_det_control`.`consumo_larvicida_gr` cons_larvi,
                `tb_situacion_viv`.`nombre_situacion_v` sit_viv,
                `tb_estado_control`.`nombre_estado_control` esta_con
            
            FROM
                `tb_control`
                INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
                INNER JOIN `tb_situacion_viv` ON (`tb_det_control`.`id_situacion_vivienda` = `tb_situacion_viv`.`id_situacion_vivienda`)
                INNER JOIN `tb_estado_control` ON (`tb_det_control`.`id_estado_control` = `tb_estado_control`.`id_estado_control`)
            WHERE
                `tb_control`.`id_control` = ?
        ';
        $response = $this->db->query($sql, $codControl);
        return $response->getResult();
    }

    public function mreporte_inspeccion_inspeccionados_depositos_tipos($codDetalleControl): array {
        $sql = '
            SELECT 
                `tb_depositos`.`id_deposito` key_deposito,
                `tb_depositos`.`nombre_deposito` depo,
                `tb_depositos_tipos`.`id_depositotipo` key_dep_tipo,
                `tb_depositos_tipos`.`denominacion` depo_tip,
                `tb_depositos_tipos`.`sigla` depo_tip_sigla,
                `tb_det_control_depositos`.`det_cantidad` cantidad
            FROM
                `tb_det_control_depositos`
                INNER JOIN `tb_det_control` ON (`tb_det_control_depositos`.`id_detalle_control` = `tb_det_control`.`id_detalle_control`)
                INNER JOIN `tb_depositos` ON (`tb_det_control_depositos`.`id_deposito` = `tb_depositos`.`id_deposito`)
                INNER JOIN `tb_depositos_tipos` ON (`tb_det_control_depositos`.`id_depositotipo` = `tb_depositos_tipos`.`id_depositotipo`)
            WHERE
                `tb_det_control`.`id_detalle_control` = ?
        ';
        $response = $this->db->query($sql, $codDetalleControl);
        return $response->getResult();
    }

    public function mreporte_inspeccion_inspeccionados_depositos_tipos_total($codControl): object {
        $sql = "SELECT 
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 1 AND `tb_depositos_tipos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `tanque_elevado_I`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 1 AND `tb_depositos_tipos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `tanque_elevado_P`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 1 AND `tb_depositos_tipos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE ' ' END) AS `tanque_elevado_TQ`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 1 AND `tb_depositos_tipos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `tanque_elevado_TH`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 2 AND `tb_depositos_tipos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `tanque_bajo_I`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 2 AND `tb_depositos_tipos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `tanque_bajo_P`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 2 AND `tb_depositos_tipos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `tanque_bajo_TQ`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 2 AND `tb_depositos_tipos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `tanque_bajo_TH`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 3 AND `tb_depositos_tipos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `barril_I`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 3 AND `tb_depositos_tipos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `barril_P`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 3 AND `tb_depositos_tipos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `barril_TQ`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 3 AND `tb_depositos_tipos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `barril_TH`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 4 AND `tb_depositos_tipos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `sanzon_I`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 4 AND `tb_depositos_tipos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `sanzon_P`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 4 AND `tb_depositos_tipos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `sanzon_TQ`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 4 AND `tb_depositos_tipos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `sanzon_TH`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 5 AND `tb_depositos_tipos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `balde_I`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 5 AND `tb_depositos_tipos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `balde_P`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 5 AND `tb_depositos_tipos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `balde_TQ`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 5 AND `tb_depositos_tipos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `balde_TH`
        FROM
            `tb_det_control`
            INNER JOIN `tb_control` ON (`tb_det_control`.`id_control` = `tb_control`.`id_control`)
            INNER JOIN `tb_det_control_depositos` ON (`tb_det_control`.`id_detalle_control` = `tb_det_control_depositos`.`id_detalle_control`)
            RIGHT OUTER JOIN `tb_depositos` ON (`tb_det_control_depositos`.`id_deposito` = `tb_depositos`.`id_deposito`)
            INNER JOIN `tb_depositos_tipos` ON (`tb_det_control_depositos`.`id_depositotipo` = `tb_depositos_tipos`.`id_depositotipo`)
        WHERE
            `tb_control`.`id_control` = ?
        ";
        $response = $this->db->query($sql, $codControl);
        return $response->getRow();
    }

    public function mreporte_inspeccion_inspeccionados_depositos_re($params): object {
        $sql = 
        "SELECT 
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = ? AND `tb_depositos_tipos`.`id_depositotipo` = ? THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) AS `total`
        FROM
            `tb_det_control`
            INNER JOIN `tb_control` ON (`tb_det_control`.`id_control` = `tb_control`.`id_control`)
            INNER JOIN `tb_det_control_depositos` ON (`tb_det_control`.`id_detalle_control` = `tb_det_control_depositos`.`id_detalle_control`)
            RIGHT OUTER JOIN `tb_depositos` ON (`tb_det_control_depositos`.`id_deposito` = `tb_depositos`.`id_deposito`)
            INNER JOIN `tb_depositos_tipos` ON (`tb_det_control_depositos`.`id_depositotipo` = `tb_depositos_tipos`.`id_depositotipo`)
        WHERE
            `tb_control`.`id_control` = ?
        ";
        $response = $this->db->query($sql, $params);
        return $response->getRow();
    }

    // ***
}
?>