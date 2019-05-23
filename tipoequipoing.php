<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerTypeEquip.php';
/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(6)){
    header('Location: main.php');
}
$create = $SESSION_DATA->getPermission(7);
$edit = $SESSION_DATA->getPermission(8);
$delete = $SESSION_DATA->getPermission(9);
/**
 * se cargan datos
 */
$TYPEEQUIP = new ControllerTypeEquip();
$TYPEEQUIP->typeequipget();
$arrustypeequip = $TYPEEQUIP->getResponse();
$isvalid = $arrustypeequip['output']['valid'];
$arrustypeequip = $arrustypeequip['output']['response'];
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'include/generic_head.php'; ?>
</head>
<body>
<header>
    <?php
    $_ACTIVE_SIDEBAR = 'tipoequipo';
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
            <a href="#" id="creartipoequipo" class="btn btn-info botoncrear">Crear</a>
            <?php
        }
        ?>
        <div>
            <table class="table table-hover dyntable" id="dynamictable">
                <thead>
                <tr>
                    <th class="head0" style="width: 70px;">Acciones</th>
                    <th class="head1">ID</th>
                    <th class="head0">Clase</th>
                    <th class="head1">Alias</th>
                    <th class="head0">Marca</th>
                    <th class="head1">Modelo</th>
                    <th class="head0">Clasificacion</th>
                    <th class="head1">Tipo</th>
                    <th class="head0">Precio</th>
                    <th class="head1">Reseña</th>
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
                    <col class="con1" />
                    <col class="con0" />
                </colgroup>
                <!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                <tbody>
                <?php
                $c = count($arrustypeequip);
                if ($isvalid) {
                    for ($i = 0; $i < $c; $i++) {
                        ?>
                        <tr class="gradeC">
                            <td class="con0">
                                <?php
                                if ($delete) {
                                    ?>
                                    <a href="#" onclick="TIPOEQUIP.editdata(<?php echo $arrustypeequip[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                if ($edit) {
                                    ?>
                                    <a href="#" onclick="TIPOEQUIP.deletedata(<?php echo $arrustypeequip[$i]['id']; ?>);"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td class="con1"><?php echo $arrustypeequip[$i]['ID2']; ?></td>
                            <td class="con0"><?php echo $arrustypeequip[$i]['clase']; ?></td>
                            <td class="con1"><?php echo $arrustypeequip[$i]['alias']; ?></td>
                            <td class="con0"><?php echo $arrustypeequip[$i]['marca']; ?></td>
                            <td class="con1"><?php echo $arrustypeequip[$i]['modelo']; ?></td>
                            <td class="con0"><?php echo $arrustypeequip[$i]['clasificacion']?></td>
                            <td class="con1"><?php echo $arrustypeequip[$i]['tipo'];?></td>
                            <td class="con0"><?php echo $arrustypeequip[$i]['precio']?></td>
                            <td class="con1"><a href="#" onclick="TIPOEQUIP.MostrarResena(<?php echo $arrustypeequip[$i]['id']; ?>);"><span class="icon-book"></span></a></td>
                            <td class="con0"><a href="#" onclick="TIPOEQUIP.MostrarFoto(<?php echo $arrustypeequip[$i]['id']; ?>);"><span class="icon-camera"></span></a></td>

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
<div id="form_creartipoequipo" title="Registro de Tipo de Equipo" style="display: none;">
    <p class="validateTips"></p>
    <form class="form-horizontal" id="formcreate">
        <div class="control-group">
            <label class="control-label">ID*</label>
            <div class="controls"><input type="text" name="id" id="id" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Clase*</label>
            <div class="controls"><input type="text" name="clase" id="clase" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Alias*</label>
            <div class="controls"><input type="text" name="alias" id="alias" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Marca*</label>
            <div class="controls"><input type="text" name="marca" id="marca" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Modelo*</label>
            <div class="controls"><input type="text" name="modelo" id="modelo" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Clasificacion*</label>
            <div class="controls"><input type="text" name="clasificacion" id="clasificacion" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Tipo*</label>
            <div class="controls"><input type="text" name="tipo" id="tipo" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Precio*</label>
            <div class="controls"><input type="text" name="precio" id="precio" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Reseña*</label>
            <div class="controls"><textarea  name="resena" id="resena" rows="5" class="text ui-widget-content ui-corner-all" ></textarea></div>
        </div>
        <div class="control-group">
            <label class="control-label">Foto</label>
            <div class="controls"><input type="file" name="foto" id="foto" accept="image/" onchange="TIPOEQUIP.mostrarfoto()" class="text ui-widget-content ui-corner-all" /><img id="img"/></div>
        </div>
    </form>
</div>
<div id="form_mostrarResena" title="Reseña" style="display: none;">
    <p class="validateTips"></p>
    <form class="form-horizontal" id="formcreate2">
        <div class="control-group">
            <label class="control-label">Reseña</label>
            <div class="controls"><textarea  name="resena2" id="resena2" rows="10" readonly="true"  ></textarea></div>
        </div>
    </form>
</div>

<?php include 'include/generic_script.php'; ?>
<link rel="stylesheet" media="screen" href="css/dynamictable.css" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
<script type="text/javascript" src="js/lib/data-sha1.js"></script>
<script type="text/javascript" src="js/tipoequipo.js"></script>
<script type="text/javascript" src="js/registro.js"></script>
</body>
</html>