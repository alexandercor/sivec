<?php

namespace App\Models;

use CodeIgniter\Model;

class MusuarioModel extends Model{

    public function m_usuario_buscar($usuNombre) {
        $sql = "
            SELECT 
                `tb_usuario`.`usu_usuario` usuario,
                `tb_usuario`.`usu_contrasena_encrypt` pass_hash,
                `tb_usuario`.`id_persona` key_per
            FROM
                `tb_usuario`
            WHERE
                `tb_usuario`.`usu_usuario` = ? AND
                `tb_usuario`.`usu_estado_habilitado` = 1 AND
                `tb_usuario`.`usu_nivel` <> 2
        ";
        $response = $this->db->query($sql, $usuNombre);
        return ($response->getNumRows() === 1)? $response->getRow() : 0;
    }

    public function m_usuario_persona($keyPer): object {
        $sql = "
            SELECT 
                `tb_persona`.`dni` dni,
                `tb_persona`.`apellidos_nombres` persona,
                `tb_persona`.`email` email,
                `tb_usuario`.`usu_nivel` key_nive
            FROM
                `tb_usuario`
                INNER JOIN `tb_persona` ON (`tb_usuario`.`id_persona` = `tb_persona`.`id_persona`)
            WHERE
                `tb_persona`.`id_persona` = ?
        ";
        $response = $this->db->query($sql, $keyPer);
        return $response->getRow();
    }

    public function m_usuario_list($per): array {
        $sql = "
            SELECT 
                `tb_usuario`.`id_usuario` key_usu,
                `tb_usuario`.`usu_usuario` usuario,
                `tb_usuario`.`usu_nivel` key_nivel,
                `tb_usuario`.`usu_estado_habilitado` est_habi,
                `tb_persona`.`apellidos_nombres` persona
            FROM
                `tb_usuario`
                INNER JOIN `tb_persona` ON (`tb_usuario`.`id_persona` = `tb_persona`.`id_persona`)
            WHERE
                `tb_persona`.`apellidos_nombres` LIKE ?
            ORDER BY
                `tb_persona`.`apellidos_nombres`
        ";
        $response = $this->db->query($sql, $per);
        return $response->getResult();
    }

    public function m_usuario_update($keyAct): int{
        $sql = "
            UPDATE 
                `tb_usuario`  
            SET 
                `usu_contrasena_encrypt` = ?,
                `usu_nivel` = ?
            WHERE 
                `id_usuario` = ?
        ";
        $this->db->query($sql, $keyAct);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_usuario_update_nivel($keyAct): int{
        $sql = "
            UPDATE 
                `tb_usuario`  
            SET 
                `usu_nivel` = ?
            WHERE 
                `id_usuario` = ?
        ";
        $this->db->query($sql, $keyAct);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_usuario_insert(array $data): int{
        $sql = "
        INSERT INTO `tb_usuario`
            (`usu_usuario`, `usu_contrasena_encrypt`, `usu_nivel`, `id_persona`) 
        VALUES (?,?,?,?)
        ";
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_usuario_update_habilitado(array $params): int{
        $sql = 
        "UPDATE 
            `tb_usuario`  
        SET 
            `usu_estado_habilitado` = ?
        WHERE 
            `id_usuario` = ?;
        ";
        $this->db->query($sql, $params);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    // ***
}
?>