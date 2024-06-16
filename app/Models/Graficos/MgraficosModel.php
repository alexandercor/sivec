<?php

namespace App\Models\Graficos;

use CodeIgniter\Model;

class MgraficosModel extends Model{

    public function m_graficos_sector_totales($parans): object {
        $sql =
        "SELECT 
            SUM(CASE WHEN `tb_actividadtipo`.`id_actividadtipo` = 1 THEN 1 ELSE 0 END) AS `control_focal`,
            SUM(CASE WHEN `tb_actividadtipo`.`id_actividadtipo` = 2 THEN 1 ELSE 0 END) AS `vigilancia`,
            SUM(CASE WHEN `tb_actividadtipo`.`id_actividadtipo` = 3 THEN 1 ELSE 0 END) AS `recuperacion`,
            SUM(CASE WHEN `tb_actividadtipo`.`id_actividadtipo` = 4 THEN 1 ELSE 0 END) AS `barridofocal`,
            SUM(CASE WHEN `tb_actividadtipo`.`id_actividadtipo` = 5 THEN 1 ELSE 0 END) AS `otras`
        FROM
            `tb_control`
            INNER JOIN `tb_actividadtipo` ON (`tb_control`.`id_actividadtipo` = `tb_actividadtipo`.`id_actividadtipo`)
            INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
        WHERE
            `tb_sector`.`id_sector` = ? AND
            `tb_control`.`fecha_control` BETWEEN ? AND ?
        ";
        $response = $this->db->query($sql, $parans);
        return $response->getRow();
    }

// ***
}
?>