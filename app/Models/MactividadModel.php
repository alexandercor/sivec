<?php

namespace App\Models;

use CodeIgniter\Model;

class MactividadModel extends Model{

    public function m_actividades_list(string $acti): array {
        $sql = "
            SELECT 
                `tb_actividadtipo`.`id_actividadtipo` key_act,
                `tb_actividadtipo`.`nombre_actividadtipo` activi
            FROM
                `tb_actividadtipo`
            WHERE
                `tb_actividadtipo`.`nombre_actividadtipo` LIKE ? AND
                `tb_actividadtipo`.`fdele` = 1
            ORDER BY 
                `tb_actividadtipo`.`nombre_actividadtipo`
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

    public function m_actividades_update($data): int{
        $sql = "
            UPDATE 
                `tb_actividadtipo`  
            SET 
                `nombre_actividadtipo` = ?
            WHERE 
                `id_actividadtipo` = ?
        ";
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_actividad_del($keyAct): int{
        $sql = "
            UPDATE 
                `tb_actividadtipo`  
            SET 
                `fdele` = 2
            WHERE 
                `id_actividadtipo` = ?
        ";
        $this->db->query($sql, $keyAct);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

// ***
}
?>