<?php

namespace App\Models\Reportes;

use CodeIgniter\Model;

class MreporteConsolidadoMensualLarvarioModel extends Model{


    public function mreporte_consolidado_mes_larvario_detalle_listav1($codControl): array {
        $sql = '
            SELECT 
                `tb_det_control`.`id_detalle_control` key_detalle_control,
                `tb_det_control`.`codigo_manzana` cod_manzan,
                `tb_det_control`.`direccion` direcc,
                `tb_det_control`.`nombre_persona_at` per_aten,
                `tb_det_control`.`cant_residentes` n_resid,
                `tb_det_control`.`consumo_larvicida_gr` cons_larvi,
                `tb_det_control`.`fecha_hora_inicio` fecinicia,
                `tb_det_control`.`fecha_hora_fin` fecfin,
                `tb_situacion_viv`.`nombre_situacion_v` sit_viv,
                `tb_estado_control`.`nombre_estado_control` esta_con,
                `tb_eess`.`nombre_eess` eess,
                `tb_provincia`.`nombre_provincia` provincia,
                `tb_distrito`.`nombre_distrito` distrito
            
            FROM
                `tb_control`
                INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
                INNER JOIN `tb_situacion_viv` ON (`tb_det_control`.`id_situacion_vivienda` = `tb_situacion_viv`.`id_situacion_vivienda`)
                INNER JOIN `tb_estado_control` ON (`tb_det_control`.`id_estado_control` = `tb_estado_control`.`id_estado_control`)
                INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
                INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`)
                INNER JOIN `tb_distrito` ON (`tb_localidad`.`id_distrito` = `tb_distrito`.`id_distrito`)
                INNER JOIN `tb_provincia` ON (`tb_distrito`.`id_provincia` = `tb_provincia`.`id_provincia`)
                INNER JOIN `tb_eess` ON (`tb_control`.`id_eess` = `tb_eess`.`id_eess`)
            WHERE
                `tb_control`.`fecha_control` BETWEEN ? AND ? AND 
                `tb_localidad`.`id_localidad` = ?
        ';
        $response = $this->db->query($sql, $codControl);
        return $response->getResult();
    }

    public function mreporte_consolidado_mes_larvario_detalle_lista($codControl): array {
        $sql = '
            SELECT 
                `tb_det_control`.`id_detalle_control` key_detalle_control,
                `tb_det_control`.`codigo_manzana` cod_manzan,
                `tb_det_control`.`direccion` direcc,
                `tb_det_control`.`nombre_persona_at` per_aten,
                SUM(`tb_det_control`.`cant_residentes`) n_resid,
                SUM(`tb_det_control`.`consumo_larvicida_gr`) cons_larvi,
                DATE(`tb_det_control`.`fecha_hora_inicio`) fecinicia,
                `tb_det_control`.`fecha_hora_fin` fecfin,
                SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 1 THEN `tb_situacion_viv`.`id_situacion_vivienda` ELSE 0 END) sit_vivIns,
                SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 4 THEN `tb_situacion_viv`.`id_situacion_vivienda` ELSE 0 END) sit_vivCerr,
                SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 2 THEN `tb_situacion_viv`.`id_situacion_vivienda` ELSE 0 END) sit_vivRenu,
                SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 3 THEN `tb_situacion_viv`.`id_situacion_vivienda` ELSE 0 END) sit_vivDesh,
                SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 6 THEN `tb_situacion_viv`.`id_situacion_vivienda` ELSE 0 END) sit_vivPost,
                SUM(CASE WHEN `tb_situacion_viv`.`id_situacion_vivienda` = 5 THEN `tb_situacion_viv`.`id_situacion_vivienda` ELSE 0 END) sit_vivTrat,
                `tb_estado_control`.`nombre_estado_control` esta_con,
                `tb_control`.`id_eess` ideess,
                `tb_eess`.`nombre_eess` eess,
                `tb_provincia`.`nombre_provincia` provincia,
                `tb_distrito`.`nombre_distrito` distrito
            
            FROM
                `tb_control`
                INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
                INNER JOIN `tb_situacion_viv` ON (`tb_det_control`.`id_situacion_vivienda` = `tb_situacion_viv`.`id_situacion_vivienda`)
                INNER JOIN `tb_estado_control` ON (`tb_det_control`.`id_estado_control` = `tb_estado_control`.`id_estado_control`)
                INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
                INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`)
                INNER JOIN `tb_distrito` ON (`tb_localidad`.`id_distrito` = `tb_distrito`.`id_distrito`)
                INNER JOIN `tb_provincia` ON (`tb_distrito`.`id_provincia` = `tb_provincia`.`id_provincia`)
                INNER JOIN `tb_eess` ON (`tb_control`.`id_eess` = `tb_eess`.`id_eess`)
            WHERE
                `tb_control`.`fecha_control` BETWEEN ? AND ? AND 
                `tb_localidad`.`id_localidad` = ?
            GROUP BY
                `tb_control`.`id_eess`,
                DATE(`tb_det_control`.`fecha_hora_inicio`)
        ';
        $response = $this->db->query($sql, $codControl);
        return $response->getResult();
    }

    public function mreporte_consolidado_mensual_larvario_viviendas($codDetalleControl): object {
        $sql = '
            SELECT 
                SUM(CASE WHEN `tb_det_control`.`id_situacion_vivienda` = ? THEN `tb_det_control`.`id_situacion_vivienda` ELSE 0 END) key_vivienda
            FROM
                `tb_det_control`
            WHERE
                `tb_det_control`.`id_detalle_control` = ?
        ';
        $response = $this->db->query($sql, $codDetalleControl);
        // var_dump($response);exit();
        return $response->getRow();
    }

    public function mreporte_consolidado_mensual_larvario_tipos_depositos($codDetalleControl): array {
        $sql = '
            SELECT 
                `tb_det_control`.`id_detalle_control` key_detalle_control,
                DATE(`tb_det_control`.`fecha_hora_inicio`) finicia,
                `tb_control`.`id_eess` ideess,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 1 AND `tb_det_control_depositos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) TAI,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 1 AND `tb_det_control_depositos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) TAP,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 1 AND `tb_det_control_depositos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) TATQ,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 1 AND `tb_det_control_depositos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) TATF,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 2 AND `tb_det_control_depositos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) TBI,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 2 AND `tb_det_control_depositos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) TBP,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 2 AND `tb_det_control_depositos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) TBTQ,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 2 AND `tb_det_control_depositos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) TBTF,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 3 AND `tb_det_control_depositos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) BCI,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 3 AND `tb_det_control_depositos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) BCP,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 3 AND `tb_det_control_depositos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) BCTQ,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 3 AND `tb_det_control_depositos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) BCTF,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 4 AND `tb_det_control_depositos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) SSI,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 4 AND `tb_det_control_depositos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) SSP,
                 SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 4 AND `tb_det_control_depositos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) SSTQ,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 4 AND `tb_det_control_depositos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) SSTF,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 5 AND `tb_det_control_depositos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) BBTI,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 5 AND `tb_det_control_depositos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) BBTP,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 5 AND `tb_det_control_depositos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) BBTTQ,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 5 AND `tb_det_control_depositos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) BBTTF,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 6 AND `tb_det_control_depositos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) LLI,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 6 AND `tb_det_control_depositos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) LLP,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 6 AND `tb_det_control_depositos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) LLTQ,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 6 AND `tb_det_control_depositos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) LLTF,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 7 AND `tb_det_control_depositos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) FLI,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 7 AND `tb_det_control_depositos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) FLP,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 7 AND `tb_det_control_depositos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) FLTQ,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 7 AND `tb_det_control_depositos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) FLTF,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 8 AND `tb_det_control_depositos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) LTI,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 8 AND `tb_det_control_depositos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) LTP,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 8 AND `tb_det_control_depositos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) LTTQ,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 8 AND `tb_det_control_depositos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) LTTF,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 8 AND `tb_det_control_depositos`.`id_depositotipo` = 5 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) LTD,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 9 AND `tb_det_control_depositos`.`id_depositotipo` = 1 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) OTI,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 9 AND `tb_det_control_depositos`.`id_depositotipo` = 2 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) OTP,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 9 AND `tb_det_control_depositos`.`id_depositotipo` = 3 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) OTTQ,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 9 AND `tb_det_control_depositos`.`id_depositotipo` = 4 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) OTTF,
                SUM(CASE WHEN `tb_det_control_depositos`.`id_deposito` = 9 AND `tb_det_control_depositos`.`id_depositotipo` = 5 THEN `tb_det_control_depositos`.`det_cantidad` ELSE 0 END) OTD
            FROM
                `tb_control`
                INNER JOIN `tb_det_control` ON (`tb_control`.`id_control` = `tb_det_control`.`id_control`)
                INNER JOIN `tb_det_control_depositos` ON (`tb_det_control`.`id_detalle_control` = `tb_det_control_depositos`.`id_detalle_control`)
                INNER JOIN `tb_sector` ON (`tb_control`.`id_sector` = `tb_sector`.`id_sector`)
                INNER JOIN `tb_localidad` ON (`tb_sector`.`id_localidad` = `tb_localidad`.`id_localidad`)
            WHERE
                `tb_control`.`fecha_control` BETWEEN ? AND ? AND 
                `tb_localidad`.`id_localidad` = ?
            GROUP BY
                `tb_control`.`id_eess`,
                DATE(`tb_det_control`.`fecha_hora_inicio`)
        ';
        $response = $this->db->query($sql, $codDetalleControl);
        return $response->getResult();
    }

    public function mreporte_consolidado_mensual_larvario_depositos_tipos($codDetalleControl): array {
        $sql = '
            SELECT 
                `tb_depositos`.`id_deposito` key_deposito,
                `tb_depositos`.`nombre_deposito` depo,
                `tb_depositos_tipos`.`id_depositotipo` key_dep_tipo,
                `tb_depositos_tipos`.`denominacion` depo_tip,
                `tb_depositos_tipos`.`sigla` depo_tip_sigla,
                `tb_det_control_depositos`.`det_cantidad` cantidad
            FROM
                `tb_det_control_depositos`
                INNER JOIN `tb_det_control` ON (`tb_det_control_depositos`.`id_detalle_control` = `tb_det_control`.`id_detalle_control`)
                INNER JOIN `tb_depositos` ON (`tb_det_control_depositos`.`id_deposito` = `tb_depositos`.`id_deposito`)
                INNER JOIN `tb_depositos_tipos` ON (`tb_det_control_depositos`.`id_depositotipo` = `tb_depositos_tipos`.`id_depositotipo`)
            WHERE
                `tb_det_control`.`id_detalle_control` = ?
        ';
        $response = $this->db->query($sql, $codDetalleControl);
        return $response->getResult();
    }

    // ***
}
