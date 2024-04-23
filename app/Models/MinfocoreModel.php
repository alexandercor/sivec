<?php

namespace App\Models;

use CodeIgniter\Model;

class MinfocoreModel extends Model{

    public function m_departamentos($codReg): array{
        $sql = '
            SELECT 
                `tb_departamento`.`id_departamento` key_dep,
                `tb_departamento`.`nombre_departamento` depar
            FROM
                `tb_departamento`
                INNER JOIN `tb_region` ON (`tb_departamento`.`id_region` = `tb_region`.`id_region`)
            WHERE
                `tb_region`.`id_region` = ?
            ORDER BY
                `tb_departamento`.`nombre_departamento`
        ';
        $response = $this->db->query($sql, $codReg);
        return $response->getResult();
    }

    public function m_provincias($codDep): array{
        $sql = '
            SELECT 
                `tb_provincia`.`id_provincia` key_prov,
                `tb_provincia`.`nombre_provincia` provincia
            FROM
                `tb_departamento`
                INNER JOIN `tb_provincia` ON (`tb_departamento`.`id_departamento` = `tb_provincia`.`id_departamento`)
            WHERE 
                `tb_departamento`.`id_departamento` = ?
            ORDER BY
                `tb_provincia`.`nombre_provincia`
        ';
        $response = $this->db->query($sql, $codDep);
        return $response->getResult();
    }

    public function m_distritos($codPro): array{
        $sql = '
            SELECT 
                `tb_distrito`.`id_distrito` key_distrito,
                `tb_distrito`.`nombre_distrito` distrito
            FROM
                `tb_provincia`
                INNER JOIN `tb_distrito` ON (`tb_provincia`.`id_provincia` = `tb_distrito`.`id_provincia`)
            WHERE
                `tb_provincia`.`id_provincia` = ?
            ORDER BY
                `tb_distrito`.`nombre_distrito`
        ';
        $response = $this->db->query($sql, $codPro);
        return $response->getResult();
    }

    public function m_localidad($codDis): array{
        $sql = '
            SELECT 
                `tb_localidad`.`id_localidad` key_localidad,
                `tb_localidad`.`nombre_localidad` localidad
            FROM
                `tb_distrito`
                INNER JOIN `tb_localidad` ON (`tb_distrito`.`id_distrito` = `tb_localidad`.`id_distrito`)
            WHERE
                `tb_distrito`.`id_distrito` = ?
            ORDER BY
                `tb_localidad`.`nombre_localidad`
        ';
        $response = $this->db->query($sql, $codDis);
        return $response->getResult();
    }
    public function m_sector($codLoc): array{
        $sql = '
            SELECT 
                `tb_sector`.`id_sector` key_sector,
                `tb_sector`.`nombre_sector` sector
            FROM
                `tb_sector`
                INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`)
            WHERE
                `tb_localidad`.`id_localidad` = ?
            ORDER BY
                `tb_sector`.`nombre_sector`
        ';
        $response = $this->db->query($sql, $codLoc);
        return $response->getResult();
    }

    public function m_recipientemedidas(): array{
        $sql = '
            SELECT 
                `tb_capacidad`.`id_capacidad` key_medi,
                `tb_capacidad`.`nombre_capacidad` medida
            FROM
                `tb_capacidad`
            ORDER BY
                `tb_capacidad`.`nombre_capacidad`
        ';
        $response = $this->db->query($sql);
        return $response->getResult();
    }
    
// ***
}