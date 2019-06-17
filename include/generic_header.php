<div align="left" style="color: ">
    <table width="1365px">
        <tr>
            <td rowspan="2" width="685px" bgcolor="#add8e6">
                <img src="images/cabezote.jpg" width="90px" alt="1mbiomedica"/>
            </td>
            <td bgcolor="#add8e6" align="right">
                <?php
                if (isset($_SESSION['usuario'])){
                    ?>
                    <img src="images/64572.png" width="50px" alt="FueraDeSesion"/>
                    <select name="informacion" id="informacion" class="text ui-widget-content ui-corner-all" onchange="INICIO.opciones(<?php echo $_SESSION['usuario']['id']; ?>);">
                        <option value="1"><?php echo $_SESSION['usuario']['nombres'] . " " .  $_SESSION['usuario']['apellidos']?></option>
                        <option value="2">Actualizar datos</option>
                        <option value="3">Salir</option>
                    </select>
                    <?php
                }
                else {
                    ?>
                    <img src="images/64572.png" width="50px" alt="FueraDeSesion"/>
                    <a href="#" id="iniciosesion" class="btn btn-info botoncrear">Iniciar Sesión</a>
                <?php
                }
                ?>

            </td>
        </tr>
        <tr>
            <td bgcolor="#add8e6">
                <div id="header2">
                    <ul class="navi">
                        <?php
                        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['ingeniero'] == 1) {
                            if($SESSION_DATA->getPermission(1)){
                                ?>
                                <li <?php if ($_ACTIVE_SIDEBAR == "usuario") echo 'class="active"'; ?>><a href="usuario.php">Usuarios</a></li>
                                <?php
                            }
                            if($SESSION_DATA->getPermission(6)){
                                ?>
                                <li <?php if ($_ACTIVE_SIDEBAR == "tipoequipo") echo 'class="active"'; ?>><a href="tipoequipoing.php">Tipo Equipo</a></li>
                                <?php
                            }
                            if($SESSION_DATA->getPermission(10)){
                                ?>
                                <li <?php if ($_ACTIVE_SIDEBAR == "equipo") echo 'class="active"'; ?>><a href="Equipoing.php">Equipo</a></li>
                                <?php
                            }
                            if($SESSION_DATA->getPermission(14)){
                                ?>
                                <li <?php if ($_ACTIVE_SIDEBAR == "software") echo 'class="active"'; ?>><a href="softwareing.php">Software</a></li>
                                <?php
                            }
                            if($SESSION_DATA->getPermission(18)){
                                ?>
                                <li <?php if ($_ACTIVE_SIDEBAR == "servicio") echo 'class="active"'; ?>><a href="serviciosing.php">Servicios</a></li>
                                <?php
                            }
                        }else{
                            ?>
                            <li <?php if ($_ACTIVE_SIDEBAR == "inicio") echo 'class="active"'; ?>><a href="index.php">Inicio</a></li>
                            <li <?php if ($_ACTIVE_SIDEBAR == "equiposgeneral") echo 'class="active"'; ?>><a href="">Equipos</a>
                                <ul>
                                    <li><a href="todosequipos.php">Todos los productos</a></li>
                                    <li><a href="informacion.php">Informacion de compra</a></li>
                                    <li><a href="contactenos.php">Contáctenos</a></li>
                                </ul>
                            </li>
                            <li <?php if ($_ACTIVE_SIDEBAR == "softwaregeneral") echo 'class="active"'; ?>><a href="softwaregeneral.php">Software</a></li>
                            <li <?php if ($_ACTIVE_SIDEBAR == "serviciosgeneral") echo 'class="active"'; ?>><a href="serviciosgeneral.php">Servicios</a></li>
                            <li <?php if ($_ACTIVE_SIDEBAR == "informaciongeneral") echo 'class="active"'; ?>><a href="informaciongeneral.php">Información</a></li>
                            <li <?php if ($_ACTIVE_SIDEBAR == "novedadesgeneral") echo 'class="active"'; ?>><a href="novedadesgeneral.php">Novedades</a></li>
                            <?php
                        }
                            ?>
                    </ul>
                        <!-- <ul class="nav pull-right">
                            <li><a href="logout.php">Salir</a></li>
                            <li class="divider-vertical"></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mi cuenta <b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Editar cuenta</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Cerrar Sesión</a></li>
                                            </ul>
                                        </li>-->
                    <!--    <ul class="breadcrumb">
                            <li><a href="clientes.php">Franquicias</a> <span class="divider">/</span></li>
                            <li class="active">Ver</li>
                        </ul>-->
                </div>
            </td>
        </tr>
    </table>

</div>
