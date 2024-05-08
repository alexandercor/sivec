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
                `tb_sector`.`nombre_sector` sec,
                `tb_localidad`.`nombre_localidad` loca,
                `tb_distrito`.`nombre_distrito` dis,
                `tb_provincia`.`nombre_provincia` prov,
                `tb_departamento`.`nombre_departamento` dep,
                `tb_region`.`nombre_region` reg
            FROM
                `tb_sector`
                INNER JOIN `tb_eess` ON (`tb_sector`.`id_sector` = `tb_eess`.`id_sector`)
                INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`)
                INNER JOIN `tb_distrito` ON (`tb_localidad`.`id_distrito` = `tb_distrito`.`id_distrito`)
                INNER JOIN `tb_provincia` ON (`tb_distrito`.`id_provincia` = `tb_provincia`.`id_provincia`)
                INNER JOIN `tb_departamento` ON (`tb_provincia`.`id_departamento` = `tb_departamento`.`id_departamento`)
                INNER JOIN `tb_region` ON (`tb_departamento`.`id_region` = `tb_region`.`id_region`)
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
                `id_eess` = ?
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
                `tb_eess`.`id_eess` = ?
        ";
        $this->db->query($sql, $keyeess);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

// ***
}
?>