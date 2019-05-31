<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 * @author Daniel Felipe Jaramillo
 */

class ControllerSoftware
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
        if($this->op == 'softwsave'){
            $this->nombre = isset($rqst['nombre']) ? $rqst['nombre'] : '';
            $this->archivo = isset($rqst['archivo']) ? $rqst['archivo'] : '';
            $this->softwsave();
        }else if ($this->op == 'softwget'){
            $this->softwareget();
        }else if ($this->op == 'softwdelete'){
            $this->softwdelete();
        }else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method2_called();
        }
    }

    public function softwareget(){
        $q = "SELECT * FROM biome1m_software WHERE softw_borrado = 0 ORDER BY softw_nombre ASC";
        if ($this->id > 0) {
            $q = "SELECT * FROM biome1m_software WHERE softw_borrado = 0 AND softw_id = " . $this->id;
        }
        $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);
        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->softw_id,
                'nombre' => $obj->softw_nombre,
                'archivo' => $obj->softw_archivo);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    public function softwsave(){
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
            //Se verifica si ya existe el nombre
            $q = "SELECT softw_id FROM biome1m_software WHERE softw_nombre = '" . $this->nombre . "'";
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
            $resultado = mysqli_num_rows($con);
            if($resultado == 0){
                $q = "INSERT INTO biome1m_software(softw_nombre, softw_archivo, softw_actualizado, softw_borrado) 
                      VALUES ('" . $this->nombre . "','" . $this->archivo . "'," . $this->UTILITY->date_now_server() . "," . 0 . ")";
                mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                $id = mysqli_insert_id($this->conexion);
                $arrjson = array('output' => array('valid' => true, 'id' => $id));
            }else{
                $arrjson = $this->UTILITY->error_name_already_exist();
            }
        }
        $this->response = ($arrjson);

    }

    public function nummsgsoftw($id){
        $q = "SELECT msgsoftw_id FROM biome1m_msgsoftw WHERE biome1m_software_softw_id = " . $id;
        $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);
        $arr[0] = array(
            'nummsg' => $resultado);
        $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        $this->response = ($arrjson);
    }

    public function softwdelete(){
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "UPDATE biome1m_software SET softw_borrado = 1 WHERE softw_id = " . $this->id;
            mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
        } else {
            $arrjson = $this->UTILITY->error_missing_data();
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