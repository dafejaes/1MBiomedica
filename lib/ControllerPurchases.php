<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 * @author Daniel Felipe Jaramillo
 */

class ControllerPurchases
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
        }else if ($this->op == 'typeequipget'){
            $this->typeequipget();
        }else if ($this->op == 'equipfromtypedelete'){
            $this->idtype = isset($rqst['idtype']) ? intval($rqst['idtype']) : 0;
            $this->equipfromtypedelete();
        }else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
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
