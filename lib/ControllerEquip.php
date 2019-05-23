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