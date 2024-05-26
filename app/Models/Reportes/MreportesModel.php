<?php

namespace App\Models\Reportes;

use CodeIgniter\Model;

class MreportesModel extends Model{

    public function cdato(): object {
        $sql = "
        SELECT 
            `id_distrito`,
            `nombre_distrito`,
            `id_provincia`,
            `lupdate`
        FROM 
            `tb_distrito`
        WHERE
        id_distrito = 1
        ";
        $response = $this->db->query($sql);
        return $response->getRow();
    }
    // ***
}
?>