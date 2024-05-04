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
                `tb_sector`.`id_sector` LIKE ? AND 
                `tb_eess`.`fdelete` = 1
            ORDER BY 
                `tb_eess`.`nombre_eess`
        ";
        $response = $this->db->query($sql, $codSec);
        return $response->getResult();
    }

    public function m_essalud_insert(array $data): int{
        $sql = "
            INSERT INTO `tb_eess` (`nombre_eess`, `id_sector`) VALUES (?,?)
        ";
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_essalud_update(array $data): int{
        $sql = "
            UPDATE 
                `tb_eess`  
            SET 
                `nombre_eess` = ?,
                `id_sector` = ?
            WHERE 
                `id_eess` = ?;
        ";
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_essalud_del(string $keyeess): int{
        $sql = "
            UPDATE 
                `tb_eess`  
            SET 
                `tb_eess`.`fdelete` = 2
            WHERE 
                `tb_eess`.`id_eess` = ?;
        ";
        $this->db->query($sql, $keyeess);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

// ***
}
?>