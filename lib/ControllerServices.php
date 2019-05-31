<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 * @author Daniel Felipe Jaramillo
 */

class ControllerServices
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
        if($this->op == 'servsave'){
            $this->nombre = isset($rqst['nombre']) ? $rqst['nombre'] : '';
            $this->archivo = isset($rqst['archivo']) ? $rqst['archivo'] : '';
            $this->servsave();
        }else if ($this->op == 'servget'){
            $this->servicesget();
        }else if ($this->op == 'servdelete'){
            $this->servdelete();
        }else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method2_called();
        }
    }

    public function servicesget(){
        $q = "SELECT * FROM biome1m_servicios WHERE serv_borrado = 0 ORDER BY serv_nombre ASC";
        if ($this->id > 0) {
            $q = "SELECT * FROM biome1m_servicios WHERE serv_borrado = 0 AND serv_id = " . $this->id;
        }
        $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);
        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->serv_id,
                'nombre' => $obj->serv_nombre,
                'archivo' => $obj->serv_archivo);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    public function servsave(){
        $id = 0;
        $resultado = 0;
        if ($this->id > 0 ){
            //Se verifica si ya existe el nombre
            $q = "SELECT serv_id FROM biome1m_servicios WHERE serv_nombre = " . $this->nombre;
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
            $resultado = mysqli_num_rows($con);
            if($resultado == 0){
                $obj = mysqli_fetch_object($con);
                //actualiza la informacion
                $q = "SELECT serv_id FROM biome1m_servicios WHERE serv_id = " . $this->id;
                $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
                while ($obj = mysqli_fetch_object($con)) {
                    $id = $obj->serv_id;
                    $table = "biome1m_servicios";
                    $arrfieldscomma = array(
                        'serv_nombre' => $this->nombre,
                        'serv_archivo' => $this->archivo);
                    $arrfieldsnocomma = array('serv_actualizado' => $this->UTILITY->date_now_server());
                    $q = $this->UTILITY->make_query_update($table, "serv_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                    mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
                    $arrjson = array('output' => array('valid' => true, 'id' => $id));
                }
            }else{
                $arrjson = $this->UTILITY->error_name_already_exist();
            }
        }else{
            //Se verifica si ya existe el nombre
            $q = "SELECT serv_id FROM biome1m_servicios WHERE serv_nombre = '" . $this->nombre . "'";
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
            $resultado = mysqli_num_rows($con);
            if($resultado == 0){
                $q = "INSERT INTO biome1m_servicios(serv_nombre, serv_archivo, serv_actualizado, serv_borrado) 
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

    public function nummsgserv($id){
        $q = "SELECT msgserv_id FROM biome1m_msgserv WHERE biome1m_servicios_serv_id = " . $id;
        $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);
        $arr[0] = array(
            'nummsg' => $resultado);
        $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        $this->response = ($arrjson);
    }

    public function servdelete(){
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "UPDATE biome1m_servicios SET serv_borrado = 1 WHERE serv_id = " . $this->id;
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
