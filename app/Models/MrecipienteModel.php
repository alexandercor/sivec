<?php

namespace App\Models;

use CodeIgniter\Model;

class MrecipienteModel extends Model{

    public function m_recipientes_list(string $rec): array {
        $sql = "
            SELECT 
                `tb_depositos`.`id_deposito` key_dep_tip,
                `tb_depositos`.`nombre_deposito` depo,
                `tb_capacidad`.`id_capacidad` key_capacidad,
                `tb_capacidad`.`nombre_capacidad` capacidad
            FROM
                `tb_capacidad`
                INNER JOIN `tb_depositos` ON (`tb_capacidad`.`id_capacidad` = `tb_depositos`.`id_capacidad`)
            WHERE
                `tb_depositos`.`nombre_deposito` LIKE ? AND
                `tb_depositos`.`fdelete` = 1
            ORDER BY
                `tb_depositos`.`nombre_deposito`
        ";
        $response = $this->db->query($sql, $rec);
        return $response->getResult();
    }

    public function m_rec_insert(array $data): int {
        $sql = '
            INSERT INTO `tb_depositos`
                (`nombre_deposito`, `id_capacidad`) 
            VALUES (?,?)
        ';
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1 : 2;
    }

    public function m_rec_update(array $data): int {
        $sql = '
            UPDATE 
                `tb_depositos`  
            SET 
                `nombre_deposito` = ?,
                `id_capacidad` = ?
            WHERE 
                `id_deposito` = ?;
        ';
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1 : 2;
    }
    
    public function c_recipiente_del($keyRec): int {
        $sql = '
            UPDATE 
                `tb_depositos`  
            SET 
                `tb_depositos`.`fdelete` = 2
            WHERE 
                `id_deposito` = ?
        ';
        $this->db->query($sql, $keyRec);
        return ($this->db->affectedRows() >= 1)? 1 : 2;
    }

// **
}
?>