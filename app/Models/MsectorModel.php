<?php

namespace App\Models;

use CodeIgniter\Model;

class MsectorModel extends Model{

    public function m_sector_list(array $data): array {
        $sql = "
            SELECT 
                `tb_sector`.`id_sector` key_sec,
                `tb_sector`.`nombre_sector` sec,
                `tb_sector`.`referencia_sector` sec_ref,
                `tb_localidad`.`id_localidad` key_loc,
                `tb_localidad`.`nombre_localidad` loc
            FROM
                `tb_localidad`
                INNER JOIN `tb_sector` ON (`tb_localidad`.`id_localidad` = `tb_sector`.`id_localidad`)
            WHERE
                `tb_sector`.`nombre_sector` LIKE ? AND 
                `tb_localidad`.`id_localidad` LIKE ? AND 
                `tb_sector`.`fdelete` = 1
            ORDER BY
                `tb_sector`.`nombre_sector`
        ";
        $response = $this->db->query($sql, $data);
        return $response->getResult();
    }

    public function m_sector_insert(array $data): int{
        $sql = "
            INSERT INTO `tb_sector` (`nombre_sector`, `referencia_sector`,`id_localidad`) VALUES (?,?,?)
        ";
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_sector_update(array $data): int{
        $sql = "
            UPDATE 
                `tb_sector`  
            SET 
                `nombre_sector` = ?,
                `referencia_sector` = ?,
                `id_localidad` = ?
            WHERE 
                `id_sector` = ?;
        ";
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_sector_del(string $keysec): int{
        $sql = "
            UPDATE 
                `tb_sector`  
            SET 
                `tb_sector`.`fdelete` = 2
            WHERE 
                `tb_sector`.`id_sector` = ?;
        ";
        $this->db->query($sql, $keysec);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }
    // ***
}
?>