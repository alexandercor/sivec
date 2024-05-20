<?php

namespace App\Models;

use CodeIgniter\Model;

class MpersonaModel extends Model{

    public function m_personas_list($persona): array {
        $sql = "
        SELECT 
            `tb_persona`.`id_persona` key_per,
            `tb_persona`.`dni` dni,
            `tb_persona`.`apellidos_nombres` persona,
            `tb_persona`.`fecha_nacimiento` fech_nac,
            `tb_persona`.`celular1` celular,
            `tb_persona`.`celular2` celular2,
            `tb_persona`.`email` email,
            `tb_persona`.`fecha_registro` fecha_reg,
            `tb_colaborador`.`id_colaborador` key_col,
            `tb_colaborador`.`tipo_col` tipo_colaborador
        FROM
            `tb_colaborador`
            INNER JOIN `tb_persona` ON (`tb_colaborador`.`id_persona` = `tb_persona`.`id_persona`)
        WHERE
            `tb_persona`.`apellidos_nombres` LIKE ? AND 
            `tb_persona`.`fdelete` = 1
        ORDER BY
            `tb_persona`.`apellidos_nombres`
        ";
        $response = $this->db->query($sql, $persona);
        return $response->getResult();
    }

    public function m_persona_insert(array $data){
        $sql = "
        INSERT INTO `tb_persona`
            (`dni`,`apellidos_nombres`,`fecha_nacimiento`,`celular1`,`celular2`,
            `email`) 
        VALUE (?,?,?,?,?,?)
        ";
        $this->db->query($sql, $data);

        if($this->db->affectedRows() >= 1){
            $ultimoId = $this->db->insertID();
            return [1, $ultimoId];
        }else{
            return 2;
        }
        
    }

    public function m_persona_update(array $data): int{
        $sql = "
            UPDATE 
                `tb_persona`  
            SET 
                `dni` = ?,
                `apellidos_nombres` = ?,
                `fecha_nacimiento` = ?,
                `celular1` = ?,
                `celular2` = ?,
                `email` = ?
            WHERE 
                `id_persona` = ?
        ";
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_persona_del($keyPer): int{
        $sql = "
            UPDATE 
                `tb_persona`  
            SET 
                `fdelete` = 2
            WHERE 
                `id_persona` = ?
        ";
        $this->db->query($sql, $keyPer);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }

    public function m_col_tipo($data): int{
        $sql = "
            INSERT INTO `tb_colaborador` (`tipo_col`,`id_persona`) VALUE (?, ?)
        ";
        $this->db->query($sql, $data);
        return ($this->db->affectedRows() >= 1)? 1: 2;
    }


    // ***
}
?>