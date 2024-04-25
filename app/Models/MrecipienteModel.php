<?php

namespace App\Models;

use CodeIgniter\Model;

class MrecipienteModel extends Model{

    public function m_recipientes_list(string $rec): array {
        $sql = "
            SELECT 
                `tb_depositostipos`.`id_deposito_tipo` key_dep_tip,
                `tb_depositostipos`.`nombre_deposito` depo,
                `tb_capacidad`.`id_capacidad` key_capacidad,
                `tb_capacidad`.`nombre_capacidad` capacidad
            FROM
                `tb_capacidad`
                INNER JOIN `tb_depositostipos` ON (`tb_capacidad`.`id_capacidad` = `tb_depositostipos`.`id_capacidad`)
            WHERE
                `tb_depositostipos`.`nombre_deposito` LIKE ? AND
                `tb_depositostipos`.`fdelete` = 1
            ORDER BY
                `tb_depositostipos`.`nombre_deposito`
        ";
        $response = $this->db->query($sql, $rec);
        return $response->getResult();
    }

    public function m_rec_insert(array $data): int {
        $sql = '
            INSERT INTO `tb_depositostipos`
                (`nombre_deposito`, `id_capacidad`) 
            VALUES (?,?)
        ';
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1 : 2;
    }

    public function m_rec_update(array $data): int {
        $sql = '
            UPDATE 
                `tb_depositostipos`  
            SET 
                `nombre_deposito` = ?,
                `id_capacidad` = ?
            WHERE 
                `id_deposito_tipo` = ?;
        ';
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1 : 2;
    }
    
    public function c_recipiente_del($keyRec): int {
        $sql = '
            UPDATE 
                `tb_depositostipos`  
            SET 
                `tb_depositostipos`.`fdelete` = 2
            WHERE 
                `id_deposito_tipo` = ?
        ';
        $this->db->query($sql, $keyRec);
        return ($this->db->affectedRows() >= 1)? 1 : 2;
    }

// **
}
?>