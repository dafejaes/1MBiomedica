<?php
    $nombre_temporal = $_FILES['foto']['tmp_name'];
    $nombre = $_FILES['foto']['name'];
    move_uploaded_file($nombre_temporal, 'images/imagesusr/'. $nombre);
?>
