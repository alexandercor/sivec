<?php

namespace App\Models\Graficos;

use CodeIgniter\Model;

class MgraficosModel extends Model{

    public function m_graficos_sector_totales($parans) {
        $sql =
        "SELECT 
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 1 THEN 1 ELSE 0 END) AS `tanque_ele`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 2 THEN 1 ELSE 0 END) AS `tanque_bajo`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 3 THEN 1 ELSE 0 END) AS `cilindros`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 4 THEN 1 ELSE 0 END) AS `sansom`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 5 THEN 1 ELSE 0 END) AS `tinajas`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 6 THEN 1 ELSE 0 END) AS `llantas`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 7 THEN 1 ELSE 0 END) AS `floreros`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 16 THEN 1 ELSE 0 END) AS `baldes`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 11 THEN 1 ELSE 0 END) AS `bidones_galoneras`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 9 THEN 1 ELSE 0 END) AS `otros`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 12 THEN 1 ELSE 0 END) AS `inservibles`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 17 THEN 1 ELSE 0 END) AS `ollas`
            FROM
            `tb_control`
            INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
            INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
            INNER JOIN `tb_det_control_depositos` ON (`tb_det_control`.`id_detalle_control` = `tb_det_control_depositos`.`id_detalle_control`)
            INNER JOIN `tb_depositos` ON (`tb_det_control_depositos`.`id_deposito` = `tb_depositos`.`id_deposito`)
            WHERE
            `tb_sector`.`id_sector` = ? AND
            `tb_control`.`fecha_control` BETWEEN ? AND ?
        ";
        $response = $this->db->query($sql, $parans);
        $response = $response->getRow();
        return (!empty($response))? $response : '';
    }

    public function m_graficos_localidad_totales($parans) {
        $sql =
        "SELECT 
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 1 THEN 1 ELSE 0 END) AS `tanque_ele`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 2 THEN 1 ELSE 0 END) AS `tanque_bajo`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 3 THEN 1 ELSE 0 END) AS `cilindros`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 4 THEN 1 ELSE 0 END) AS `sansom`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 5 THEN 1 ELSE 0 END) AS `tinajas`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 6 THEN 1 ELSE 0 END) AS `llantas`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 7 THEN 1 ELSE 0 END) AS `floreros`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 16 THEN 1 ELSE 0 END) AS `baldes`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 11 THEN 1 ELSE 0 END) AS `bidones_galoneras`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 9 THEN 1 ELSE 0 END) AS `otros`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 12 THEN 1 ELSE 0 END) AS `inservibles`,
            SUM(CASE WHEN `tb_depositos`.`id_deposito` = 17 THEN 1 ELSE 0 END) AS `ollas`
        FROM
            `tb_control`
            INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
            INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
            INNER JOIN `tb_det_control_depositos` ON (`tb_det_control`.`id_detalle_control` = `tb_det_control_depositos`.`id_detalle_control`)
            INNER JOIN `tb_depositos` ON (`tb_det_control_depositos`.`id_deposito` = `tb_depositos`.`id_deposito`)
            INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`)
        WHERE
            `tb_localidad`.`id_localidad` = ? AND
            `tb_control`.`fecha_control` BETWEEN ? AND ?
        ";
        $response = $this->db->query($sql, $parans);
        $response = $response->getRow();
        return (!empty($response))? $response : '';
    }


// ***
}
?>