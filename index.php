<?php
session_start();
include 'include/SessionData.php';
$SESSION_DATA = new SessionData();
$mensaje = '';
if (isset($_SESSION['usuario'])) {
    echo "main";
    header('Location: main.php');
} else {
    $rqst = $_REQUEST;
    $op = isset($rqst['op']) ? $rqst['op'] : '';
    if ($op == 'usrlogin') {
        include 'lib/ControllerUser.php';
        //$ke = isset($rqst['ke']) ? $rqst['ke'] : '';
        $email = isset($rqst['email']) ? $rqst['email'] : '';
        $pass = isset($rqst['pass']) ? $rqst['pass'] : '';
        //$pass = sha1($pass);
        $USUARIO = new ControllerUser();
        $USUARIO->extraLogin($email, $pass);
        $res = $USUARIO->getResponse();
        $isvalid = $res['output']['valid'];
        if ($isvalid) {
            $_SESSION['usuario'] = $res['output'];
            header('Location: main.php');
        } else {
            $mensaje = $res['output']['response']['content'];
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
	    <?php include 'include/generic_head.php'; ?>
    </head>
    <body>
        <header>
	        <?php
            $_ACTIVE_SIDEBAR="inicio";
	        include 'include/generic_header.php';
            ?>
        </header>
        <table align="center">
            <tr>
                <td>
                    <img src="images/cabezote.jpg" width="300px" alt="1mbiomedica"/>
                </td>
                <td>
                    <?php
                    if (isset($_SESSION['usuario'])) {
                        echo 'Bienvenido';
                    }else{
                    ?>
                        <section id="section_wrap">
                            <form class="form-actions" style="margin: 0 auto !important; width: 220px;" action="index.php" method="POST">
                                <div class="control-group">
                                    <label class="control-label" for="email">Email</label>
                                    <div class="controls">
                                        <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" value="prueba@correo.com">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="pass">Contraseña</label>
                                    <div class="controls">
                                        <input type="password" id="pass" name="pass" placeholder="********" value="prueba">
                                        <input type="hidden" name="op" id="op" value="usrlogin"/>
                                        <input type="hidden" name="ti" id="ti"/>
                                        <input type="hidden" name="ke" id="ke"/>
                                        <input type="hidden" name="fuente" id="fuente" value="franquicias_web"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls" style="color: red !important;">
                                        <?php echo $mensaje ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-info">Ingresar</button>
                                        <a href="#" id="registro" class="btn btn-info botoncrear">Registro</a>
                                    </div>
                                </div>
                            </form>
                        </section>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        </table>
	    <footer id="footer_wrap">
	        <?php include 'include/generic_footer.php'; ?>
	    </footer>
        <div id="dialog-form1" title="Registro de Usuario" style="display: none;">
            <p class="validateTips"></p>
            <form class="form-horizontal" id="formcreate">
                <div class="control-group">
                    <label class="control-label">Nombres*</label>
                    <div class="controls"><input type="text" name="nombre" id="nombre" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Apellidos*</label>
                    <div class="controls"><input type="text" name="apellido" id="apellido" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Cedula</label>
                    <div class="controls"><input type="text" name="cedula" id="cedula" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Email*</label>
                    <div class="controls"><input type="email" name="email2" id="email2" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Contraseña*</label>
                    <div class="controls"><input type="password" name="password2" id="password2" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Repita Contraseña*</label>
                    <div class="controls"><input type="password" name="password3" id="password3" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Fecha Nacimiento</label>
                    <div class="controls"><input type="text" name="fechanacimiento" id="fechanacimiento" readonly="true" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Ciudad*</label>
                    <div class="controls"><input type="text" name="ciudad" id="ciudad" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Departamento*</label>
                    <div class="controls"><input type="text" name="departamento" id="departamento" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dirección*</label>
                    <div class="controls"><input type="text" name="direccion" id="direccion" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">¿Desea inscribirse a nuestra linea de correos?</label>
                    <div class="controls"><input type="checkbox" name="lineacorreo" id="lineacorreo" value = "lineaco" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">¿Desea recibir correos especiales?</label>
                    <div class="controls"><input type="checkbox" name="especialco" id="especialco" value = "especialco" class="text ui-widget-content ui-corner-all" /></div>
                </div>
            </form>
        </div>
        <?php include 'include/FormInicio.php';?>
        <?php include 'include/generic_script.php'; ?>
        <script type="text/javascript" src="js/registro.js"></script>
        <script type="text/javascript" src="js/InicioSesion.js"></script>
    </body>
</html>