<?php

namespace App\Models;

use CodeIgniter\Model;

class MusuarioModel extends Model{

    public function m_usuario_buscar($usuNombre): object {
        $sql = "
            SELECT 
                `tb_usuario`.`usu_usuario` usuario,
                `tb_usuario`.`usu_contrasena_encrypt` pass_hash,
                `tb_usuario`.`id_persona` key_per
            FROM
                `tb_usuario`
            WHERE
                `tb_usuario`.`usu_usuario` = ? AND
                `tb_usuario`.`usu_estado_habilitado` = 1
        ";
        $response = $this->db->query($sql, $usuNombre);
        return $response->getRow();
    }

    public function m_usuario_persona($keyPer): object {
        $sql = "
            SELECT 
                `tb_persona`.`dni` dni,
                `tb_persona`.`apellidos_nombres` persona,
                `tb_persona`.`email` email
            FROM
                `tb_persona`
            WHERE
                `tb_persona`.`id_persona` = ?
        ";
        $response = $this->db->query($sql, $keyPer);
        return $response->getRow();
    }
}
?>