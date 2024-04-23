<?php

namespace App\Models;

use CodeIgniter\Model;

class MactividadModel extends Model{

    public function m_actividades_list(string $acti): array {
        $sql = "
            SELECT 
                `tb_actividadtipo`.`id_actividadtipo` key_tipo,
                `tb_actividadtipo`.`nombre_actividadtipo` activi
            FROM
                `tb_actividadtipo`
            WHERE
                `tb_actividadtipo`.`nombre_actividadtipo` LIKE ?
        ";
        $response = $this->db->query($sql, $acti);
        return $response->getResult();
    }

    public function m_actividades_insert($acti): int{
        $sql = "
            INSERT INTO `tb_actividadtipo`(`nombre_actividadtipo`) VALUE (?)
        ";
        $this->db->query($sql, $acti);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

// ***
}
?>