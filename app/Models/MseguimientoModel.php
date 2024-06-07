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

    public function m_seguimiento_sospechosos_listar($codLoc): array {
        $sql = 
            "SELECT 
                `tb_det_sospechoso`.`id_sospechoso` key_sos,
                `tb_persona`.`id_persona` key_per,
                `tb_persona`.`apellidos_nombres` per
            FROM
                `tb_persona`
                INNER JOIN `tb_det_sospechoso` ON (`tb_persona`.`id_persona` = `tb_det_sospechoso`.`id_persona`)
                INNER JOIN `tb_localidad` ON (`tb_det_sospechoso`.`id_localidad` = `tb_localidad`.`id_localidad`)
            WHERE
                `tb_localidad`.`id_localidad` = ?
        ";
        $response = $this->db->query($sql, $codLoc);
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

    public function m_seguimiento_sospechosos_localidad($codLoc): object{
        $sql = 
        'SELECT 
            `tb_localidad`.`id_localidad` key_loc,
            `tb_localidad`.`nombre_localidad` loca,
            `tb_localidad`.`eje_x`,
            `tb_localidad`.`eje_y`
        FROM
            `tb_localidad`
        WHERE
            `tb_localidad`.`id_localidad` = ?
        ';
        $response = $this->db->query($sql, $codLoc);
        return $response->getRow();
    }

    public function m_seguimiento_sospechosos_listar_descarga(): array {
        $sql = 
        "SELECT 
            `tb_det_control`.`id_detalle_control` key_control_det,
            `tb_persona`.`apellidos_nombres` sospechoso,
            `tb_det_sospechoso`.`id_sospechoso` key_sospechoso,
            `tb_det_control`.`eje_x`,
            `tb_det_control`.`eje_y`,
            `tb_det_sospechoso`.`sos_descarga_estate` estado_des
        FROM
            `tb_det_control`
            INNER JOIN `tb_det_sospechoso` ON (`tb_det_control`.`id_detalle_control` = `tb_det_sospechoso`.`id_detalle_control`)
            INNER JOIN `tb_persona` ON (`tb_det_sospechoso`.`id_persona` = `tb_persona`.`id_persona`)
        WHERE 
            `tb_det_sospechoso`.`sos_descarga_estate` = 2
        ";
        $response = $this->db->query($sql);
        return $response->getResult();
    }

    public function m_seguimiento_sospechosos_referencias_insert(array $params): int {
        $sql = 
        "INSERT INTO `tb_det_sospechoso_referencias` (`eje_x`, `eje_y`, `id_sospechoso`) 
        VALUE (?, ?, ?)
        ";
        $this->db->query($sql, $params);
        return ($this->db->affectedRows() === 1) ? 1 : 2;
    }

    public function m_seguimiento_sospechosos_estado_descarga_update($codSos): int {
        $sql = 
        "UPDATE
            `tb_det_sospechoso`
        SET
            `tb_det_sospechoso`.`sos_descarga_estate` = 1
        WHERE
            `tb_det_sospechoso`.`id_sospechoso` = ?
        ";
        $this->db->query($sql, $codSos);
        return ($this->db->affectedRows() === 1) ? 1 : 2;
    }

    // **
}
?>