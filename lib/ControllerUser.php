<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 * @author Daniel Felipe Jaramillo
 */
class ControllerUser {

    private $conexion, $CDB, $op, $id, $euid, $sdid;
    private $UTILITY;
    private $response;

    function __construct() {
        $this->CDB = new ConectionDb();
        $this->UTILITY = new Util();
        $this->conexion = $this->CDB->openConect();
        $rqst = $_REQUEST;
        $this->op = isset($rqst['op']) ? $rqst['op'] : '';
        $this->id = isset($rqst['id']) ? intval($rqst['id']) : 0;
        $this->ke = isset($rqst['ke']) ? $rqst['ke'] : '';
        $this->lu = isset($rqst['lu']) ? $rqst['lu'] : '';
        $this->ti = isset($rqst['ti']) ? $rqst['ti'] : '';

        if ($this->op == 'usrsavegeneral') {
            $this->nombre = isset($rqst['nombre']) ? $rqst['nombre'] : '';
            $this->apellido = isset($rqst['apellido']) ? $rqst['apellido'] : '';
            $this->identificacion = isset($rqst['cedula']) ? $rqst['cedula'] : '';
            $this->email = isset($rqst['email']) ? $rqst['email'] : '';
            $this->pass = isset($rqst['pass']) ? $rqst['pass'] : '';
            $this->fechanaci = isset($rqst['fechanaci']) ? $rqst['fechanaci'] : '';
            $this->ciudad = isset($rqst['ciudad']) ? $rqst['ciudad'] : '';
            $this->departamento = isset($rqst['departamento']) ? $rqst['departamento'] : '';
            $this->direccion = isset($rqst['direccion']) ? $rqst['direccion'] : '';
            $this->lineacorreo = isset($rqst['lineacorreo']) ? $rqst['lineacorreo'] : 0;
            $this->especialco = isset($rqst['especialco']) ? $rqst['especialco'] : 0;
            $this->ingeniero = isset($rqst['ingeniero']) ? $rqst['ingeniero'] : 0;
            $this->usrsavegeneral();
        }else if ($this->op == 'usrlogin2') {
            $this->email = isset($rqst['email']) ? $rqst['email'] : '';
            $this->pass = isset($rqst['pass']) ? $rqst['pass'] : '';
            $this->usrlogin();
        } else if ($this->op == 'usrget') {
            $this->usrget();
        } else if ($this->op == 'usrprfget') {
            $this->usrprfget();
        } else if ($this->op == 'usrprfsave') {
            $this->chk = isset($rqst['chk']) ? $rqst['chk'] : '';
            $this->usrprfsave();
        } else if ($this->op == 'usrdelete') {
            $this->usrdelete();
        } else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
        //$this->CDB->closeConect();
    }

    /**
     * Metodo para guardar y actualizar
     */
    private function usrsavegeneral() {
        $id = 0;
        $resultado = 0;
        $pass = '';
        if ($this->UTILITY->validate_email($this->email)) {
            $arrjson = $this->UTILITY->error_wrong_email();
        } else {
            if ($this->id > 0) {
                //se verifica que el email está disponible
                $q = "SELECT usuarios_id FROM biome1m_usuarios WHERE usuarios_correo = '" . $this->email . "' AND usuarios_id != $this->id ";
                $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
                $resultado = mysqli_num_rows($con);
                if ($resultado == 0) {
                    //actualiza la informacion
                    $q = "SELECT usuarios_id FROM biome1m_usuarios WHERE usuarios_id = " . $this->id;
                    $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
                    while ($obj = mysqli_fetch_object($con)) {
                        $id = $obj->usuarios_id;
                        if (strlen($this->pass) > 2) {
                            $pass = $this->UTILITY->make_hash_pass($this->email, $this->pass);
                        }
                        $table = "biome1m_usuarios";
                        $arrfieldscomma = array(
                            'usuarios_nombres' => $this->nombre,
                            'usuarios_apellidos' => $this->apellido,
                            'usuarios_cedula' => $this->identificacion,
                            'usuarios_contrasena' => $pass,
                            'usuarios_nacimiento' => $this->fechanaci,
                            'usuarios_ciudad' => $this->ciudad,
                            'usuarios_departamento' => $this->departamento,
                            'usuarios_direccion' => $this->direccion,
                            'usuarios_lineacorreo' => $this->lineacorreo,
                            'usuarios_correosespeciales' => $this->especialco,
                            'usuarios_ingeniero' => $this->ingeniero);
                        $arrfieldsnocomma = array('usuarios_fechamodifi' => $this->UTILITY->date_now_server());
                        $q = $this->UTILITY->make_query_update($table, "usuarios_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                        mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
                        $arrjson = array('output' => array('valid' => true, 'id' => $id));
                    }
                } else {
                    $arrjson = $this->UTILITY->error_user_already_exist();
                }
            } else {
                //se verifica que el email está disponible
                $q = "SELECT usuarios_id FROM biome1m_usuarios WHERE usuarios_correo = '" . $this->email . "'";
                $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
                $resultado = mysqli_num_rows($con);
                if ($resultado == 0) {
                    if (strlen($this->pass) > 2) {
                        $pass = $this->UTILITY->make_hash_pass($this->email, $this->pass);
                    }
                    $this->pass = $pass;

                    $q = "INSERT INTO biome1m_usuarios (usuarios_cedula, usuarios_nombres, usuarios_apellidos, usuarios_correo, usuarios_contrasena, usuarios_nacimiento, usuarios_ciudad, usuarios_departamento, usuarios_direccion, usuarios_lineacorreo, usuarios_correosespeciales, usuarios_borrado, usuarios_fechamodifi, usuarios_ingeniero) 
                          VALUES (" . "'$this->identificacion' " . ", '$this->nombre' " . ", '$this->apellido'" . ", '$this->email'" . ", '$this->pass'" . ", '$this->fechanaci'" . ", '$this->ciudad'" . ", '$this->departamento'". ", '$this->direccion'" . ", $this->lineacorreo , $this->especialco , 0 ," . $this->UTILITY->date_now_server() . ",  $this->ingeniero )";
                    mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                    $id = mysqli_insert_id($this->conexion);
                    $arrjson = array('output' => array('valid' => true, 'id' => $id));
                } else {
                    $arrjson = $this->UTILITY->error_user_already_exist();
                }
            }
        }
        $this->response = ($arrjson);
    }

    public function usrget() {
        $q = "SELECT * FROM biome1m_usuarios WHERE usuarios_borrado = 0 ORDER BY usuarios_nombres ASC";
        if ($this->id > 0) {
            $q = "SELECT * FROM biome1m_usuarios WHERE usuarios_borrado = 0 AND usuarios_id = " . $this->id;
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
                'id' => $obj->usuarios_id,
                'cedula' => $obj->usuarios_cedula,
                'nombres' => ($obj->usuarios_nombres),
                'apellidos' => ($obj->usuarios_apellidos),
                'email' => ($obj->usuarios_correo),
                'fnacimiento' => ($obj->usuarios_nacimiento),
                'ciudad' => ($obj->usuarios_ciudad),
                'departamento' => ($obj->usuarios_departamento),
                'direccion' => ($obj->usuarios_direccion),
                'lcorreo' => ($obj->usuarios_lineacorreo),
                'coespeciales' => ($obj->usuarios_correosespeciales),
                'ing' => ($obj->usuarios_ingeniero),
                'dtcreate' => ($obj->usuarios_fechamodifi));
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    private function usrdelete() {
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "UPDATE biome1m_usuarios SET usuarios_borrado = 1 WHERE usuarios_id = " . $this->id;
            mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
        } else {
            $arrjson = $this->UTILITY->error_missing_data();
        }
        $this->response = ($arrjson);
    }

    /**
     * Metodo para loguearse
     */
    private function usrlogin() {
        $resultado = 0;
        if ($this->UTILITY->validate_email($this->email)) {
            $arrjson = $this->UTILITY->error_wrong_email();
        } else {
            if ($this->email == "" || $this->pass == "") {
                $arrjson = $this->UTILITY->error_missing_data();
            } else {
                $pass = $this->UTILITY->make_hash_pass($this->email, $this->pass);
                $q = '';
                $q = "SELECT * FROM biome1m_usuarios WHERE usuarios_correo = '$this->email' AND usuarios_contrasena = '$pass' AND usuarios_borrado = 0";
                $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
                $resultado = mysqli_num_rows($con);
                while ($obj = mysqli_fetch_object($con)) {
                    /*$q2 = "SELECT cli_id, cli_nombre FROM dmt_cliente WHERE cli_id = " . $obj->dmt_cliente_cli_id;
                    $con2 = mysql_query($q2, $this->conexion) or die(mysql_error() . "***ERROR: " . $q2);
                    $cliente = '0';
                    $clientenombre = 'ninguno';
                    while ($obj2 = mysql_fetch_object($con2)) {
                        $cliente = $obj2->cli_id;
                        $clientenombre = $obj2->cli_nombre;
                    }*/

                    //se consultan los perfiles asignados
                    $q3 = "SELECT biome1m_perfiles_perf_id FROM biome1m_usuarios_has_biome1m_perfiles WHERE biome1m_usuarios_usuarios_id = $obj->usuarios_id ORDER BY biome1m_perfiles_perf_id ASC";
                    $con3 = mysqli_query($this->conexion, $q3) or die(mysqli_error($this->conexion) . "***ERROR: " . $q3);
                    $arrassigned = array();
                    while ($obj3 = mysqli_fetch_object($con3)) {
                        $arrassigned[] = ($obj3->biome1m_perfiles_perf_id);
                    }
                    $arrjson = array('output' => array(
                            'valid' => true,
                            'id' => $obj->usuarios_id,
                            'cedula' => $obj->usuarios_cedula,
                            'nombres' => ($obj->usuarios_nombres),
                            'apellidos' => ($obj->usuarios_apellidos),
                            'email' => ($obj->usuarios_correo),
                            'nacimiento' => ($obj->usuarios_nacimiento),
                            'ciudad' => ($obj->usuarios_ciudad),
                            'departamento' => ($obj->usuarios_departamento),
                            'direccion' => ($obj->usuarios_direccion),
                            'ingeniero' => ($obj->usuarios_ingeniero),
                            'dtcreate' => ($obj->usuarios_fechamodifi),
                            'permisos' => $arrassigned));
                }
                if ($resultado == 0) {
                    $arrjson = $this->UTILITY->error_wrong_data_login();
                }
            }
        }
        $this->response = ($arrjson);
    }

    private function usrprfget() {
        //se consultan los perfiles asignados
        $q = "SELECT * FROM biome1m_usuarios_has_biome1m_perfiles WHERE biome1m_usuarios_usuarios_id = $this->id ORDER BY biome1m_perfiles_perf_id ASC";
        $con = mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $arrassigned = array();
        $arravailable = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arrassigned[] = array('id' => $obj->biome1m_perfiles_perf_id);
        }
        //se consultan los perfiles disponibles
        $q = "SELECT * FROM biome1m_perfiles ORDER BY perf_nombre ASC";
        $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
        while ($obj = mysqli_fetch_object($con)) {
            $arravailable[] = array(
                'id' => $obj->perf_id,
                'nombre' => $obj->perf_nombre,
                'descripcion' => $obj->perf_descripcion);
        }

        $arrjson = array('output' => array('valid' => true, 'available' => $arravailable, 'assigned' => $arrassigned));
        $this->response = ($arrjson);
    }

    private function usrprfsave() {
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "DELETE FROM biome1m_usuarios_has_biome1m_perfiles WHERE biome1m_usuarios_usuarios_id = " . $this->id;
            mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
            $arrchk = explode('-', $this->chk);
            for ($i = 0; $i < count($arrchk); $i++) {
                $prf_id = intval($arrchk[$i]);
                if ($prf_id > 0) {
                    $q = "INSERT INTO biome1m_usuarios_has_biome1m_perfiles (biome1m_usuarios_usuarios_id, biome1m_perfiles_perf_id) VALUES (" . $this->id . "," . $prf_id . ")";
                    mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
                }
            }
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

    public function extraLogin($email, $pass) {
        $this->email = $email;
        $this->pass = $pass;
        $this->usrlogin();
    }

}

?>