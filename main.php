<?php
include 'include/generic_validate_session.php';
?>
<!DOCTYPE html>
<html>
    <head>
	<?php include 'include/generic_head.php'; ?>
    </head>
    <body>
        <header>
	    <?php
        $_ACTIVE_SIDEBAR = 'inicio';
        include 'include/generic_header.php';
	    ?>
        </header>
        <section id="section_wrap">
            <div class="container">
            </div>
	    <div class="container" style="height: 300px; margin: 0 auto !important; text-align: center;">
		<br><br>
		<h1>BIENVENIDO AL SISTEMA DE INFORMACIÓN 1MBIOMÉDICA</h1>
		<?php 
                //print_r($_SESSION['usuario']) 
                ?>
	    </div>	    
	</section>
	<footer id="footer_wrap">
	<?php include 'include/generic_footer.php'; ?>

	</footer>
        <?php include 'include/FormInicio.php';?>
        <?php include 'include/generic_script.php'; ?>
        <script type="text/javascript" src="js/registro.js"></script>
        <script type="text/javascript" src="js/InicioSesion.js"></script>
    </body>
</html>