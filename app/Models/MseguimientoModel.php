<?php

namespace App\Models;

use CodeIgniter\Model;

class MseguimientoModel extends Model{

    public function m_seguimiento_listar_coordenadas(): array {
        $sql = "
            SELECT 
                `tb_registro_gps`.`ejex` ejex,
                `tb_registro_gps`.`ejey` ejey,
                `tb_persona`.`apellidos_nombres` supervisor
            FROM
                `tb_colaborador`
                INNER JOIN `tb_registro_gps` ON (`tb_colaborador`.`id_colaborador` = `tb_registro_gps`.`id_colaborador`)
                INNER JOIN `tb_persona` ON (`tb_colaborador`.`id_persona` = `tb_persona`.`id_persona`)
        ";
        $response = $this->db->query($sql);
        return $response->getResult();
    }

    public function m_seguimiento_sospechosos_listar(): array {
        $sql = "
            SELECT 
                `tb_det_sospechoso`.`id_sospechoso` key_sos,
                `tb_persona`.`id_persona` key_per,
                `tb_persona`.`apellidos_nombres` per
            FROM
                `tb_persona`
                INNER JOIN `tb_det_sospechoso` ON (`tb_persona`.`id_persona` = `tb_det_sospechoso`.`id_persona`)
        ";
        $response = $this->db->query($sql);
        return $response->getResult();
    }

    public function m_seguimiento_sospechosos_referencias_coordenadas($codSos): array {
        $sql = "
            SELECT 
                `tb_det_sospechoso`.`id_sospechoso` key_sos,
                `tb_det_sospechoso_referencias`.`eje_x`,
                `tb_det_sospechoso_referencias`.`eje_y`
            FROM
                `tb_persona`
                INNER JOIN `tb_det_sospechoso` ON (`tb_persona`.`id_persona` = `tb_det_sospechoso`.`id_persona`)
                INNER JOIN `tb_det_sospechoso_referencias` ON (`tb_det_sospechoso`.`id_sospechoso` = `tb_det_sospechoso_referencias`.`id_sospechoso`)
            WHERE
                `tb_det_sospechoso`.`id_sospechoso` = ?
        ";
        $response = $this->db->query($sql, $codSos);
        return $response->getResult();
    }

    // **
}
?>