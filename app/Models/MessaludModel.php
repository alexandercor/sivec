<?php

namespace App\Models;

use CodeIgniter\Model;

class MessaludModel extends Model{

    public function m_essalud_list(string $codSec): array {
        $sql = "
            SELECT 
                `tb_eess`.`id_eess` key_ess,
                `tb_eess`.`nombre_eess` ess,
                `tb_sector`.`id_sector` key_sec,
                `tb_sector`.`nombre_sector` sec
            FROM
                `tb_sector`
                INNER JOIN `tb_eess` ON (`tb_sector`.`id_sector` = `tb_eess`.`id_sector`)
            WHERE
                `tb_sector`.`id_sector` LIKE ?
            ORDER BY 
                `tb_eess`.`nombre_eess`
        ";
        $response = $this->db->query($sql, $codSec);
        return $response->getResult();
    }

// ***
}
?>