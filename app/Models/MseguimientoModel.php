<?php

namespace App\Models;

use CodeIgniter\Model;

class MseguimientoModel extends Model{

    public function m_seguimiento_listar_coordenadas($fecha): array {
        $sql = 
        "SELECT 
            `tb_persona`.`id_persona` key_per,
            `tb_persona`.`apellidos_nombres` AS `inspector`
        FROM
            `tb_colaborador`
            INNER JOIN `tb_registro_gps` ON (`tb_colaborador`.`id_colaborador` = `tb_registro_gps`.`id_colaborador`)
            INNER JOIN `tb_persona` ON (`tb_colaborador`.`id_persona` = `tb_persona`.`id_persona`)
        WHERE
            DATE(`tb_registro_gps`.`fech_reg`) = ? AND 
            `tb_colaborador`.`tipo_col` = 2
        GROUP BY
            `tb_persona`.`id_persona`,
            `tb_persona`.`apellidos_nombres`
        ORDER BY
            `tb_registro_gps`.`fech_reg` DESC    
        ";
        $response = $this->db->query($sql, $fecha);
        return $response->getResult();
    }

    public function m_seguimiento_listar_coordenadas_x_inspector($codPer): object {
        $sql = 
        "SELECT 
            `tb_registro_gps`.`id_registro_gps`,
            `tb_registro_gps`.`ejex`,
            `tb_registro_gps`.`ejey`,
            `tb_persona`.`id_persona` key_per,
            `tb_persona`.`apellidos_nombres` AS `inspector`,
            `tb_registro_gps`.`fech_reg`,
            `tb_colaborador`.`id_colaborador` key_insp
        FROM
            `tb_colaborador`
            INNER JOIN `tb_registro_gps` ON (`tb_colaborador`.`id_colaborador` = `tb_registro_gps`.`id_colaborador`)
            INNER JOIN `tb_persona` ON (`tb_colaborador`.`id_persona` = `tb_persona`.`id_persona`)
        WHERE
            `tb_persona`.`id_persona` = ? AND 
            `tb_colaborador`.`tipo_col` = 2
        ORDER BY
            `tb_registro_gps`.`fech_reg` DESC
        LIMIT 1
        ";
        $response = $this->db->query($sql, $codPer);
        return $response->getLastRow();
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