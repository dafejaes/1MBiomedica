<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 * @author Daniel Felipe Jaramillo
 */
class ControllerTypeEquip {

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

        if($this->op == 'typeequipsave'){
            $this->id2 = isset($rqst['id2']) ? $rqst['id2'] : '';
            $this->clase = isset($rqst['clase']) ? $rqst['clase'] : '';
            $this->alias = isset($rqst['alias']) ? $rqst['alias'] : '';
            $this->marca = isset($rqst['marca']) ? $rqst['marca'] : '';
            $this->modelo = isset($rqst['modelo']) ? $rqst['modelo'] : '';
            $this->clasificacion = isset($rqst['clasificacion']) ? $rqst['clasificacion'] : '';
            $this->tipo = isset($rqst['tipo']) ? $rqst['tipo'] : '';
            $this->precio = isset($rqst['precio']) ? $rqst['precio'] : '';
            $this->resena = isset($rqst['resena']) ? $rqst['resena'] : '';
            $this->typeequipsave();
        }
    }

    public function typeequipsave(){
        $id = 0;
        $resultado = 0;
        if ($this->id > 0 ){

        }else{
            //Se verifica si ya existe el ID
            $q = "SELECT eqt_id FROM biome1m_tipoequipos WHERE eqt_ID2 = " . $this->id2;
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
            $resultado = mysqli_num_rows($con);
            if($resultado == 0){
                $q = "INSERT INTO biome1m_tipoequipos (eqt_clase, eqt_alias, eqt_marca, eqt_modelo, eqt_clasificacion, eqt_tipo, eqt_ID2, eqt_precio, eqt_actualizado, eqt_borrado, eqt_resena) 
                      VALUES ('" . $this->clase . "','" . $this->alias . "','" . $this->marca . "','" . $this->modelo . "','" . $this->clasificacion . "','" . $this->tipo . "','" . $this->id2 . "','" . $this->precio . "'," . $this->UTILITY->date_now_server() . ",0,'" . $this->resena . "')";
                mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                $id = mysqli_insert_id($this->conexion);
                $arrjson = array('output' => array('valid' => true, 'id' => $id));
            }else{
                $arrjson = $this->UTILITY->error_ID_already_exist();
            }
        }
        $this->response = ($arrjson);
    }

    public function typeequipget() {
        $q = "SELECT * FROM biome1m_tipoequipos WHERE eqt_borrado = 0 ORDER BY eqt_alias ASC";
        if ($this->id > 0) {
            $q = "SELECT * FROM biome1m_tipoequipos WHERE eqt_borrado = 0 AND eqt_id = " . $this->id;
        }
        //if ($this->sdid > 0) {
        //    $q = "SELECT * FROM fir_usuario WHERE fir_sede_sde_id = " . $this->sdid;
        //}
        //if ($this->euid > 0) {
        //    $q = "SELECT * FROM fir_usuario WHERE fir_empresa_emp_id = " . $this->euid;
        //}
        $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);
        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->eqt_id,
                'clase' => $obj->eqt_clase,
                'alias' => ($obj->eqt_alias),
                'marca' => ($obj->eqt_marca),
                'modelo' => ($obj->eqt_modelo),
                'clasificacion' => ($obj->eqt_clasificacion),
                'tipo' => ($obj->eqt_tipo),
                'ID2' => ($obj->eqt_ID2),
                'precio' => ($obj->eqt_precio),
                'actualizado' => ($obj->eqt_actualizado),
                'resena' => ($obj->eqt_resena));
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

    public function extraLogin($email, $pass) {
        $this->email = $email;
        $this->pass = $pass;
        $this->usrlogin();
    }

}

?>