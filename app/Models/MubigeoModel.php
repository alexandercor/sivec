<?php

namespace App\Models;

use CodeIgniter\Model;
use stdClass;

class MubigeoModel extends Model{

    public function m_ubigeo_sector(string $codSec): object {
        helper('fn_helper');
        $sql = "
            SELECT 
                `tb_region`.`id_region` key_reg,
                `tb_region`.`nombre_region` reg,
                `tb_departamento`.`id_departamento` key_dep,
                `tb_departamento`.`nombre_departamento` dep,
                `tb_provincia`.`id_provincia` key_pro,
                `tb_provincia`.`nombre_provincia` pro,
                `tb_distrito`.`id_distrito` key_dis,
                `tb_distrito`.`nombre_distrito` dis,
                `tb_localidad`.`id_localidad` key_loc,
                `tb_localidad`.`nombre_localidad` loca,
                `tb_sector`.`id_sector` key_sec,
                `tb_sector`.`nombre_sector` sec
            FROM
                `tb_departamento`
                INNER JOIN `tb_region` ON (`tb_departamento`.`id_region` = `tb_region`.`id_region`)
                INNER JOIN `tb_provincia` ON (`tb_departamento`.`id_departamento` = `tb_provincia`.`id_departamento`)
                INNER JOIN `tb_distrito` ON (`tb_provincia`.`id_provincia` = `tb_distrito`.`id_provincia`)
                INNER JOIN `tb_localidad` ON (`tb_distrito`.`id_distrito` = `tb_localidad`.`id_distrito`)
                INNER JOIN `tb_sector` ON (`tb_localidad`.`id_localidad` = `tb_sector`.`id_localidad`)
            WHERE
                `tb_sector`.`id_sector` = ?
        ";
        $response = $this->db->query($sql, $codSec);
        $row = $response->getRow();

        $objData = new stdClass();
        $objData->key_reg = bs64url_enc($row->key_reg);
        $objData->key_dep = bs64url_enc($row->key_dep);
        $objData->key_pro = bs64url_enc($row->key_pro);

        return $objData;
    }

    // ***
}
?>