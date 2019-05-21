<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerUser.php';
/**
 * se cargan los permisos 
 */
if (!$SESSION_DATA->getPermission(1)){
    header('Location: main.php');
}
$create = $SESSION_DATA->getPermission(2);
$edit = $SESSION_DATA->getPermission(3);
$delete = $SESSION_DATA->getPermission(4);
$editpermission = $SESSION_DATA->getPermission(5);
/**
 * se cargan datos
 */
$USUARIO = new ControllerUser();
$USUARIO->usrget();
$arrusuarios = $USUARIO->getResponse();
$isvalid = $arrusuarios['output']['valid'];
$arrusuarios = $arrusuarios['output']['response'];
?>
<!DOCTYPE html>
<html>
    <head>
	<?php include 'include/generic_head.php'; ?>
    </head>
    <body>
        <header>
	        <?php
            $_ACTIVE_SIDEBAR = 'usuario';
            include 'include/generic_header.php';
            ?>
        </header>
        <section id="section_wrap">
            <div class="container">
            </div>
            <div class="container">
		        <?php
		            if ($create) {
		        ?>
                        <a href="#" id="crearusuario" class="btn btn-info botoncrear">Crear</a>
		        <?php
		            }
		        ?>
                <div>
                    <table class="table table-hover dyntable" id="dynamictable">
                        <thead>
                            <tr>
                                <th class="head0" style="width: 70px;">Acciones</th>
                                <th class="head1">Cedula</th>
                                <th class="head0">Nombre Completo</th>
                                <th class="head1">Email</th>
                                <th class="head0">F. Nacimiento</th>
                                <th class="head1">Ciudad</th>
                                <th class="head0">Direccion</th>
                                <th class="head1">¿Ingeniero?</th>
                                <th class="head0">Foto</th>
                            </tr>
                        </thead>
                        <colgroup>
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                        </colgroup>
<!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                        <tbody>
			                <?php
			                    $c = count($arrusuarios);
			                    if ($isvalid) {
				                    for ($i = 0; $i < $c; $i++) {
				            ?>
				            <tr class="gradeC">
					            <td class="con0">
					        <?php
					                    if ($delete) {
						    ?>
	    				            <a href="#" onclick="USUARIO.editdata(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
						    <?php
					                    }
					                    if ($edit) {
						    ?>
	    				            <a href="#" onclick="USUARIO.deletedata(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>
						    <?php
					                    }
					                    if ($editpermission && $arrusuarios[$i]['ing']) {
						    ?>
	    				            <a href="#" onclick="USUARIO.editpermission(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-ban-circle"></span></a>
						    <?php
					                    }
					        ?>
					            </td>
					            <td class="con1"><?php echo $arrusuarios[$i]['cedula']; ?></td>
					            <td class="con0"><?php echo $arrusuarios[$i]['nombres'] . ' ' . $arrusuarios[$i]['apellidos']; ?></td>
					            <td class="con1"><?php echo $arrusuarios[$i]['email']; ?></td>
					            <td class="con0"><?php echo $arrusuarios[$i]['fnacimiento']; ?></td>
                                <td class="con1"><?php echo $arrusuarios[$i]['ciudad'] . '-' . $arrusuarios[$i]['departamento']?></td>
                                <td class="con0"><?php echo $arrusuarios[$i]['direccion']?></td>
                                <td class="con1"><?php if($arrusuarios[$i]['ing'] == 1){echo 'Sí';}else{echo 'No';};?></td>
                                <td class="con0"><a href="#" onclick="USUARIO.editpermission(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-camera"></span></a></td>
                            </tr>
				            <?php
				                    }
			                    }
			                ?>
                        </tbody>
                    </table>
                </div>
            </div>	    
        </section>
        <footer id="footer_wrap">
	    <?php include 'include/generic_footer.php'; ?>
        </footer>
        <div id="form_crearusuario" title="Registro de Usuario" style="display: none;">
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
                    <label class="control-label">¿El usuario es ingeniero?</label>
                    <div class="controls"><input type="checkbox" name="ing" id="ing" value = "ing" class="text ui-widget-content ui-corner-all" /></div>
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
	<div id="dialog-permission" title="Permisos">
            <p class="validateTips"></p>
            <form class="form-horizontal" id="formpermission">
                <div class="check"><input type="checkbox" checked="true" name="chk1" id="chk1" class="text ui-widget-content ui-corner-all" /><span>&nbsp;&nbsp;</span><label>Franquicia</label></div>
            </form>
        </div>
	<?php include 'include/generic_script.php'; ?>
        <link rel="stylesheet" media="screen" href="css/dynamictable.css" type="text/css" />
        <script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
        <script type="text/javascript" src="js/lib/data-sha1.js"></script>
        <script type="text/javascript" src="js/usuario.js"></script>
        <script type="text/javascript" src="js/registro.js"></script>
    </body>
</html>