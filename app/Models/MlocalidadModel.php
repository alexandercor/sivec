<?php

namespace App\Models;

use CodeIgniter\Model;

class MlocalidadModel extends Model{

    public function m_localidad_list(array $parans): array {
        $sql = "
            SELECT 
                `tb_localidad`.`id_localidad` key_loca,
                `tb_localidad`.`nombre_localidad` loca,
                `tb_distrito`.`id_distrito` key_dis,
                `tb_distrito`.`nombre_distrito` dis,
                `tb_provincia`.`nombre_provincia` pro,
                `tb_departamento`.`nombre_departamento` dep,
                `tb_region`.`nombre_region` reg
            FROM
                `tb_distrito`
                INNER JOIN `tb_localidad` ON (`tb_distrito`.`id_distrito` = `tb_localidad`.`id_distrito`)
                INNER JOIN `tb_provincia` ON (`tb_distrito`.`id_provincia` = `tb_provincia`.`id_provincia`)
                INNER JOIN `tb_departamento` ON (`tb_provincia`.`id_departamento` = `tb_departamento`.`id_departamento`)
                INNER JOIN `tb_region` ON (`tb_departamento`.`id_region` = `tb_region`.`id_region`)
            WHERE
                `tb_localidad`.`nombre_localidad` LIKE ? AND 
                `tb_distrito`.`id_distrito` LIKE ? AND 
                `tb_localidad`.`fdele` = 1
            ORDER BY
                `tb_localidad`.`nombre_localidad`
        ";
        $response = $this->db->query($sql, $parans);
        return $response->getResult();
    }

    public function m_localidad_insert(array $data): int{
        $sql = "
            INSERT INTO `tb_localidad` (`nombre_localidad`,`id_distrito`) VALUES (?,?)
        ";
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_localidad_update(array $data): int{
        $sql = "
            UPDATE 
                `tb_localidad`  
            SET 
                `nombre_localidad` = ?,
                `id_distrito` = ?
            WHERE 
                `id_localidad` = ?;
        ";
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_localidad_del(string $keyloca): int{
        $sql = "
            UPDATE 
                `tb_localidad`  
            SET 
                `tb_localidad`.`fdele` = 2
            WHERE 
                `tb_localidad`.`id_localidad` = ?
        ";
        $this->db->query($sql, $keyloca);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    // ***
}
?>