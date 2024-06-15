<?php

namespace App\Models\Reportes;

use CodeIgniter\Model;

class MreportesIndicesModel extends Model{

    public function mreporte_indices_head_localidad($codLoca) {
        $sql = 
        'SELECT 
            `tb_localidad`.`id_localidad` AS `key_loca`,
            `tb_localidad`.`nombre_localidad` AS `localidad`
        FROM
            `tb_localidad`
        WHERE
            `tb_localidad`.`id_localidad` = ?
        ';
        $response = $this->db->query($sql, $codLoca);
        $response = $response->getRow();
        return (!empty($response))? $response: '';
    }

    public function mreporte_indices_lista_sectores($parans) {
        $sql = 
        'SELECT 
            `tb_sector`.`id_sector` key_sect,
            `tb_sector`.`nombre_sector` sector,
            `tb_localidad`.`id_localidad` key_loca,
            `tb_localidad`.`nombre_localidad` localidad,
            SUM(`tb_det_control`.`consumo_larvicida_gr`) total_larvida
        FROM
            `tb_control`
            INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
            INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`)
            INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
        WHERE
            `tb_localidad`.`id_localidad` = ? AND
            `tb_control`.`fecha_control` BETWEEN ? AND ?
        GROUP BY 
            `tb_sector`.`id_sector`,
            `tb_sector`.`nombre_sector`,
            `tb_localidad`.`id_localidad`,
            `tb_localidad`.`nombre_localidad`
        ';
        $response = $this->db->query($sql, $parans);
        return $response->getResult();
    }

    public function mreporte_indices_totales_viviendas($codSector) {
        $sql = 
        'SELECT 
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 1 THEN 1 ELSE 0 END) AS `inspeccionada`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 2 THEN 1 ELSE 0 END) AS `renuente`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 3 THEN 1 ELSE 0 END) AS `deshabitada`,
            SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 4 THEN 1 ELSE 0 END) AS `cerrada`
        FROM
            `tb_control`
            INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
            INNER JOIN `tb_situacion_viv` ON (`tb_det_control`.`id_situacion_vivienda` = `tb_situacion_viv`.`id_situacion_vivienda`)
            INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
            INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`)
        WHERE
            `tb_sector`.`id_sector` = ?
        ';
        $response = $this->db->query($sql, $codSector);
        $response = $response->getRow();
        return (!empty($response))? $response : '';
    }

    public function mreporte_indices_totales_tipodeposito_x_sector($params) {
        $sql =
        'SELECT 
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = ? AND `tb_depositos_tipos`.`id_depositotipo` = ? THEN 1 ELSE 0 END ) total

        FROM
            `tb_control`
            INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
            INNER JOIN `tb_det_control_depositos` ON (`tb_det_control`.`id_detalle_control` = `tb_det_control_depositos`.`id_detalle_control`)
            INNER JOIN `tb_depositos` ON (`tb_det_control_depositos`.`id_deposito` = `tb_depositos`.`id_deposito`)
            INNER JOIN `tb_depositos_tipos` ON (`tb_det_control_depositos`.`id_depositotipo` = `tb_depositos_tipos`.`id_depositotipo`)
            INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
        WHERE
            `tb_sector`.`id_sector` = ?
        ';
        $response = $this->db->query($sql, $params);
        $response = $response->getRow();
        return (!empty($response))? $response: '';
    }

    public function mreporte_indices_totales_deposito_x_sector($codSec) {
        $sql =
        'SELECT 
            SUM(CASE WHEN `tb_depositos_tipos`.`id_depositotipo` = 1 THEN 1 ELSE 0 END ) ispeccionado,
            SUM(CASE WHEN `tb_depositos_tipos`.`id_depositotipo` = 2 THEN 1 ELSE 0 END ) positivo,
            SUM(CASE WHEN `tb_depositos_tipos`.`id_depositotipo` = 3 THEN 1 ELSE 0 END ) tratado
        FROM
            `tb_control`
            INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
            INNER JOIN `tb_det_control_depositos` ON (`tb_det_control`.`id_detalle_control` = `tb_det_control_depositos`.`id_detalle_control`)
            INNER JOIN `tb_depositos` ON (`tb_det_control_depositos`.`id_deposito` = `tb_depositos`.`id_deposito`)
            INNER JOIN `tb_depositos_tipos` ON (`tb_det_control_depositos`.`id_depositotipo` = `tb_depositos_tipos`.`id_depositotipo`)
            INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
        WHERE
            `tb_sector`.`id_sector` = ?
        ';
        $response = $this->db->query($sql, $codSec);
        $response = $response->getRow();
        return (!empty($response))? $response: '';
    }

// ***
}
?>