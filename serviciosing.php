<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerServices.php';
/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(18)){
    header('Location: main.php');
}
$create = $SESSION_DATA->getPermission(19);
$edit = $SESSION_DATA->getPermission(20);
$delete = $SESSION_DATA->getPermission(21);
/**
 * se cargan datos
 */
$SERVICES = new ControllerServices();
$SERVICES->servicesget();
$arrservices = $SERVICES->getResponse();
$isvalid = $arrservices['output']['valid'];
$arrservices = $arrservices['output']['response'];

$MENSAJES = new ControllerServices();
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'include/generic_head.php'; ?>
</head>
<body>
<header>
    <?php
    $_ACTIVE_SIDEBAR = 'servicio';
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
            <a href="#" id="crearservice" class="btn btn-info botoncrear">Crear</a>
            <?php
        }
        ?>
        <div>
            <table class="table table-hover dyntable" id="dynamictable">
                <thead>
                <tr>
                    <th class="head0" style="width: 70px;">Acciones</th>
                    <th class="head1">Nombre</th>
                    <th class="head0">Archivo</th>
                    <th class="head1">Mensajes pendientes</th>
                    <th class="head0">Ver mensajes</th>
                </tr>
                </thead>
                <colgroup>
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />
                </colgroup>
                <!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                <tbody>
                <?php
                $c = count($arrservices);
                if ($isvalid) {
                    for ($i = 0; $i < $c; $i++) {
                        ?>
                        <tr class="gradeC">
                            <td class="con0">
                                <?php
                                if ($delete) {
                                    ?>
                                    <a href="#" onclick="SERVICE.editdata(<?php echo $arrservices[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                if ($edit) {
                                    ?>
                                    <a href="#" onclick="SERVICE.deletedata(<?php echo $arrservices[$i]['id']; ?>);"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td class="con1"><?php echo $arrservices[$i]['nombre'] ?></td>
                            <td class="con0"><?php echo $arrservices[$i]['archivo']; ?></td>
                            <td class="con1"><?php $MENSAJES->nummsgserv($arrservices[$i]['id']); $arr = $MENSAJES->getResponse(); $arr = $arr['output']['response']; echo $arr[0]['nummsg']; ?></td>
                            <td class="con0"><a href="#" onclick="SERVICE.vermsgsoftw(<?php echo $arrservices[$i]['id']; ?>);"><span class="icon-folder-close"></span></a></td>

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
<div id="form_crearservicio" title="Registro del Servicio" style="display: none;">
    <p class="validateTips"></p>
    <form class="form-horizontal" id="formcreate">
        <div class="control-group">
            <label class="control-label">Nombre*</label>
            <div class="controls">
                <input type="text" name="nombre" id="nombre" class="text ui-widget-content ui-corner-all" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Archivo*</label>
            <div class="controls"><input type="text" name="archivo" id="archivo" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Imagen</label>
            <div class="controls"><input type="file" name="imagen" id="imagen" accept="image/" onchange="SERVICE.mostrarfoto()" class="text ui-widget-content ui-corner-all" /><img id="img"/></div>
        </div>
    </form>
</div>

<?php include 'include/generic_script.php'; ?>
<link rel="stylesheet" media="screen" href="css/dynamictable.css" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
<script type="text/javascript" src="js/lib/data-sha1.js"></script>
<script type="text/javascript" src="js/service.js"></script>
</body>
</html>