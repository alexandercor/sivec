<?php

namespace App\Models\Reportes;

use CodeIgniter\Model;

class MreportesSectorModel extends Model{

    public function mreporte_sector_localidad_head($codLoc): object {
        $sql = 
        'SELECT 
            `tb_localidad`.`id_localidad` key_loca,
            `tb_localidad`.`nombre_localidad` localidad
        FROM
            `tb_sector`
            INNER JOIN `tb_control` ON (`tb_sector`.`id_sector` = `tb_control`.`id_sector`)
            INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`)
        WHERE
            `tb_localidad`.`id_localidad` = ?
        GROUP BY
            `tb_localidad`.`id_localidad`,
            `tb_localidad`.`nombre_localidad`
        ';
        $response = $this->db->query($sql, $codLoc);
        return $response->getRow();
    }

    public function mreporte_sector_lista_sectores($codLoc): array {
        $sql = 
        'SELECT 
            `tb_sector`.`id_sector` key_sect,
            `tb_sector`.`nombre_sector` sector,
            `tb_localidad`.`id_localidad` key_loca,
            `tb_localidad`.`nombre_localidad` localidad
        FROM
            `tb_control`
            INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
            INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`)
        WHERE
            `tb_localidad`.`id_localidad` = ?
        GROUP BY 
            `tb_sector`.`id_sector`,
            `tb_sector`.`nombre_sector`,
            `tb_localidad`.`id_localidad`,
            `tb_localidad`.`nombre_localidad`
        ';
        $response = $this->db->query($sql, $codLoc);
        return $response->getResult();
    }

    public function mreporte_sector_totales_viviendas($codLoc): object {
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
            `tb_control`
            INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
            INNER JOIN `tb_situacion_viv` ON (`tb_det_control`.`id_situacion_vivienda` = `tb_situacion_viv`.`id_situacion_vivienda`)
            INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
            INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`)
        WHERE
            `tb_sector`.`id_sector` = ?
        ';
        $response = $this->db->query($sql, $codLoc);
        return $response->getRow();
    }

    public function m_reporte_sector_totales_tipodeposito_x_sector($params): object {
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
        return $response->getRow();
    }

// ***
}
?>