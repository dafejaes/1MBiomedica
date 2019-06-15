<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerSoftware.php';
/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(14)){
    header('Location: main.php');
}
$create = $SESSION_DATA->getPermission(15);
$edit = $SESSION_DATA->getPermission(16);
$delete = $SESSION_DATA->getPermission(17);
/**
 * se cargan datos
 */
$SOFTWARE = new ControllerSoftware();
$SOFTWARE->softwareget();
$arrsoftware = $SOFTWARE->getResponse();
$isvalid = $arrsoftware['output']['valid'];
$arrsoftware = $arrsoftware['output']['response'];

$MENSAJES = new ControllerSoftware();
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'include/generic_head.php'; ?>
</head>
<body>
<header>
    <?php
    $_ACTIVE_SIDEBAR = 'software';
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
            <a href="#" id="crearsoftware" class="btn btn-info botoncrear">Crear</a>
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
                $c = count($arrsoftware);
                if ($isvalid) {
                    for ($i = 0; $i < $c; $i++) {
                        ?>
                        <tr class="gradeC">
                            <td class="con0">
                                <?php
                                if ($delete) {
                                    ?>
                                    <a href="#" onclick="SOFTWARE.editdata(<?php echo $arrsoftware[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                if ($edit) {
                                    ?>
                                    <a href="#" onclick="SOFTWARE.deletedata(<?php echo $arrsoftware[$i]['id']; ?>);"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td class="con1"><?php echo $arrsoftware[$i]['nombre'] ?></td>
                            <td class="con0"><?php echo $arrsoftware[$i]['archivo']; ?></td>
                            <td class="con1"><?php $MENSAJES->nummsgsoftw($arrsoftware[$i]['id']); $arr = $MENSAJES->getResponse(); $arr = $arr['output']['response']; echo $arr[0]['nummsg']; ?></td>
                            <td class="con0"><a href="#" onclick="SOFTWARE.vermsgsoftw(<?php echo $arrsoftware[$i]['id']; ?>);"><span class="icon-folder-close"></span></a></td>

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
<div id="form_crearsoftware" title="Registro de Software" style="display: none;">
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
            <div class="controls"><input type="file" name="imagen" id="imagen" accept="image/" onchange="SOFTWARE.mostrarfoto()" class="text ui-widget-content ui-corner-all" /><img id="img"/></div>
        </div>
    </form>
</div>
<?php include 'include/FormInicio.php';?>
<?php include 'include/generic_script.php'; ?>
<link rel="stylesheet" media="screen" href="css/dynamictable.css" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
<script type="text/javascript" src="js/lib/data-sha1.js"></script>
<script type="text/javascript" src="js/software.js"></script>
<script type="text/javascript" src="js/InicioSesion.js"></script>
</body>
</html>