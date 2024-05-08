<?php

namespace App\Models;

use CodeIgniter\Model;

class MseguimientoModel extends Model{

    public function m_seguimiento_listar_coordenadas(): array {
        $sql = "
            SELECT 
                `tb_registro_gps`.`ejex` ejex,
                `tb_registro_gps`.`ejey` ejey,
                `tb_persona`.`apellidos_nombres` supervisor
            FROM
                `tb_colaborador`
                INNER JOIN `tb_registro_gps` ON (`tb_colaborador`.`id_colaborador` = `tb_registro_gps`.`id_colaborador`)
                INNER JOIN `tb_persona` ON (`tb_colaborador`.`id_persona` = `tb_persona`.`id_persona`)
        ";
        $response = $this->db->query($sql);
        return $response->getResult();
    }
    // **
}
?>