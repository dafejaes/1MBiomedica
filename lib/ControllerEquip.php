<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 * @author Daniel Felipe Jaramillo
 */

class ControllerEquip
{
    private $conexion, $CDB, $op, $id, $euid, $sdid;
    private $UTILITY;
    private $response;

    function __construct()
    {
        $this->CDB = new ConectionDb();
        $this->UTILITY = new Util();
        $this->conexion = $this->CDB->openConect();
        $rqst = $_REQUEST;
        $this->op = isset($rqst['op']) ? $rqst['op'] : '';
        $this->id = isset($rqst['id']) ? intval($rqst['id']) : 0;
        $this->ke = isset($rqst['ke']) ? $rqst['ke'] : '';
        $this->lu = isset($rqst['lu']) ? $rqst['lu'] : '';
        $this->ti = isset($rqst['ti']) ? $rqst['ti'] : '';
        if($this->op == 'equipsave'){
            $this->id2 = isset($rqst['id2']) ? $rqst['id2'] : '';
            $this->bodega = isset($rqst['bodega']) ? $rqst['bodega'] : '';
            $this->serie = isset($rqst['serie']) ? $rqst['serie'] : '';
            $this->placa = isset($rqst['placa']) ? $rqst['placa'] : '';
            $this->codigo = isset($rqst['codigo']) ? $rqst['codigo'] : '';
            $this->registroINVIMA = isset($rqst['registroINVIMA']) ? $rqst['registroINVIMA'] : '';
            $this->equipsave();
        }else if ($this->op == 'equipget'){
            $this->equipget();
        }else if ($this->op == 'equipfromtypedelete'){
            $this->idtype = isset($rqst['idtype']) ? intval($rqst['idtype']) : 0;
            $this->equipfromtypedelete();
        }else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else if ($this->op == 'equipdelete'){
            $this->equipdelete();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
    }

    public function purchasereferenceget($idcompra){
        $q = "SELECT compras_referencia FROM biome1m_compras WHERE compras_id = " . $idcompra . " AND compras_borrado = 0";
        $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);
        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'referencia' => $obj->compras_referencia);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    public function equipdelete(){
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "UPDATE biome1m_equipos SET eq_borrado = 1 WHERE eq_id = " . $this->id;
            mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
        } else {
            $arrjson = $this->UTILITY->error_missing_data();
        }
        $this->response = ($arrjson);
    }

    public function equipsave(){
        $id = 0;
        $resultado = 0;
        if ($this->id > 0 ){
            //Se verifica si ya existe el ID2
            $q = "SELECT eqt_id FROM biome1m_tipoequipos WHERE eqt_ID2 = " . $this->id2;
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
            $resultado = mysqli_num_rows($con);
            if($resultado == 1){
                $obj = mysqli_fetch_object($con);
                $id2 = $obj->eqt_id;
                //actualiza la informacion
                $q = "SELECT eq_id FROM biome1m_equipos WHERE eq_id = " . $this->id;
                $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
                while ($obj = mysqli_fetch_object($con)) {
                    $id = $obj->eq_id;
                    $table = "biome1m_equipos";
                    $arrfieldscomma = array(
                        'biome1m_tipoequipos_eqt_id' => $id2,
                        'eq_bodega' => $this->bodega,
                        'eq_serie' => $this->serie,
                        'eq_placa' => $this->placa,
                        'eq_codigo' => $this->codigo,
                        'eq_registroINVIMA' => $this->registroINVIMA);
                    $arrfieldsnocomma = array('eq_actualizado' => $this->UTILITY->date_now_server());
                    $q = $this->UTILITY->make_query_update($table, "eq_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                    mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
                    $arrjson = array('output' => array('valid' => true, 'id' => $id));
                }
            }else{
                $arrjson = $this->UTILITY->error_ID_dosent_exist();
            }
        }else{
            //Se verifica si ya existe el ID2
            $q = "SELECT eqt_id FROM biome1m_tipoequipos WHERE eqt_ID2 = " . $this->id2;
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
            $resultado = mysqli_num_rows($con);
            if($resultado == 1){
                $obj = mysqli_fetch_object($con);
                $id2 = $obj->eqt_id;
                $q = "INSERT INTO biome1m_equipos (biome1m_tipoequipos_eqt_id, eq_bodega, eq_serie, eq_placa, eq_codigo, eq_registroINVIMA, eq_actualizado, eq_borrado, eq_vendido) 
                      VALUES (" . $id2 . ",'" . $this->bodega . "','" . $this->serie . "','" . $this->placa . "','" . $this->codigo . "','" . $this->registroINVIMA . "'," . $this->UTILITY->date_now_server() . "," . 0 . "," . 0 . ")";
                mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                $id = mysqli_insert_id($this->conexion);
                $arrjson = array('output' => array('valid' => true, 'id' => $id));
            }else{
                $arrjson = $this->UTILITY->error_ID_already_exist();
            }
        }
        $this->response = ($arrjson);
    }

    public function equipfromtypedelete(){
        if ($this->idtype > 0) {
            //actualiza la informacion
            $q = "UPDATE biome1m_equipos SET eq_borrado = 1 WHERE biome1m_tipoequipos_eqt_id = " . $this->idtype;
            mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
        } else {
            $arrjson = $this->UTILITY->error_missing_data();
        }
        $this->response = ($arrjson);
    }

    public function equipget(){
        $q = "SELECT * FROM biome1m_equipos, biome1m_tipoequipos WHERE eq_borrado = 0 AND biome1m_tipoequipos_eqt_id = eqt_id ORDER BY eq_bodega ASC";
        if ($this->id > 0) {
            $q = "SELECT * FROM biome1m_equipos, biome1m_tipoequipos WHERE eq_borrado = 0 AND biome1m_tipoequipos_eqt_id = eqt_id AND eq_id = " . $this->id;
        }
        $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);
        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->eq_id,
                'ID2' => $obj->eqt_ID2,
                'idcompra' => $obj->biome1m_compras_compras_id,
                'alias' => $obj->eqt_alias,
                'idtipoequipo' => ($obj->biome1m_tipoequipos_eqt_id),
                'bodega' => ($obj->eq_bodega),
                'serie' => ($obj->eq_serie),
                'placa' => ($obj->eq_placa),
                'codigo' => ($obj->eq_codigo),
                'registroINVIMA' => ($obj->eq_registroINVIMA),
                'actualizado' => ($obj->eq_actualizado),
                'vendido' => ($obj->eq_vendido));
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    public function getResponse() {
        $this->CDB->closeConect();
        return $this->response;
    }

    public function getResponseJSON() {
        $this->CDB->closeConect();
        return json_encode($this->response);
    }

    public function setId($_id) {
        $this->id = $_id;
    }
}
?>