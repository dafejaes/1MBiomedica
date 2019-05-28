<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerEquip.php';
/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(10)){
    header('Location: main.php');
}
$create = $SESSION_DATA->getPermission(11);
$edit = $SESSION_DATA->getPermission(12);
$delete = $SESSION_DATA->getPermission(13);
/**
 * se cargan datos
 */
$EQUIP = new ControllerEquip();
$EQUIP->equipget();
$arrusequip = $EQUIP->getResponse();
$isvalid = $arrusequip['output']['valid'];
$arrusequip = $arrusequip['output']['response'];

$COMPRAS = new ControllerEquip();
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'include/generic_head.php'; ?>
</head>
<body>
<header>
    <?php
    $_ACTIVE_SIDEBAR = 'equipo';
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
            <a href="#" id="crearequipo" class="btn btn-info botoncrear">Crear</a>
            <?php
        }
        ?>
        <div>
            <table class="table table-hover dyntable" id="dynamictable">
                <thead>
                <tr>
                    <th class="head0" style="width: 70px;">Acciones</th>
                    <th class="head1">Referencia Compra</th>
                    <th class="head0">Alias</th>
                    <th class="head1">Bodega</th>
                    <th class="head0">Serie</th>
                    <th class="head1">Placa</th>
                    <th class="head0">Código</th>
                    <th class="head1">R. INVIMA</th>
                    <th class="head0">¿Vendido?</th>
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
                $c = count($arrusequip);
                if ($isvalid) {
                    for ($i = 0; $i < $c; $i++) {
                        ?>
                        <tr class="gradeC">
                            <td class="con0">
                                <?php
                                if ($delete) {
                                    ?>
                                    <a href="#" onclick="EQUIP.editdata(<?php echo $arrusequip[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                if ($edit) {
                                    ?>
                                    <a href="#" onclick="EQUIP.deletedata(<?php echo $arrusequip[$i]['id']; ?>);"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td class="con1"><?php if($arrusequip[$i]['vendido'] == 0){ echo 'No existe';} else {$COMPRAS->purchasereferenceget($arrusequip[$i]['idcompra']); $arr = $COMPRAS->getResponse(); echo $arr['output']['response'][0];}; ?></td>
                            <td class="con0"><?php echo $arrusequip[$i]['alias']; ?></td>
                            <td class="con1"><?php echo $arrusequip[$i]['bodega']; ?></td>
                            <td class="con0"><?php echo $arrusequip[$i]['serie']; ?></td>
                            <td class="con1"><?php echo $arrusequip[$i]['placa']; ?></td>
                            <td class="con0"><?php echo $arrusequip[$i]['codigo']?></td>
                            <td class="con1"><?php echo $arrusequip[$i]['registroINVIMA'];?></td>
                            <td class="con0"><?php if($arrusequip[$i]['vendido'] == 1){echo 'Sí';}else{echo 'No';}?></td>.

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
<div id="form_crearequipo" title="Registro de Tipo de Equipo" style="display: none;">
    <p class="validateTips"></p>
    <form class="form-horizontal" id="formcreate">
        <div class="control-group">
            <label class="control-label">ID tipo equipo*</label>
            <div class="controls">
                <input type="search" name="id" id="id" list="listaids" class="text ui-widget-content ui-corner-all" />
                <datalist id="listaids">
                </datalist>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">No. Bodega*</label>
            <div class="controls"><input type="text" name="bodega" id="bodega" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Serie*</label>
            <div class="controls"><input type="text" name="serie" id="serie" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Placa*</label>
            <div class="controls"><input type="text" name="placa" id="placa" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Codigo*</label>
            <div class="controls"><input type="text" name="codigo" id="codigo" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Registro INVIMA*</label>
            <div class="controls"><input type="text" name="registroINVIMA" id="registroINVIMA" class="text ui-widget-content ui-corner-all" /></div>
        </div>
    </form>
</div>

<?php include 'include/generic_script.php'; ?>
<link rel="stylesheet" media="screen" href="css/dynamictable.css" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
<script type="text/javascript" src="js/lib/data-sha1.js"></script>
<script type="text/javascript" src="js/equipo.js"></script>
<script type="text/javascript" src="js/registro.js"></script>
</body>
</html>