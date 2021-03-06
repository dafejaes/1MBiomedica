<?php

/**
 * en este archivo se atienden todas las peticiones AJAX
 */
$rqst = $_REQUEST;
$op = isset($rqst['op']) ? $rqst['op'] : '';
header("Content-type: application/javascript; charset=utf-8");
header("Cache-Control: max-age=15, must-revalidate");
header('Access-Control-Allow-Origin: *');
if ($op == 'clisave') {
    include '../lib/ControllerCustomer.php';
    $CONTROL = new ControllerCustomer();
    echo $CONTROL->getResponseJSON();
} else if ($op == 'usrsavegeneral' || $op == 'usrget' || $op == "usrdelete" || $op == 'usrprfget' || $op == 'usrprfsave') {
    include '../lib/ControllerUser.php';
    $CONTROL = new ControllerUser();
    echo $CONTROL->getResponseJSON();
} else if ($op == 'typeequipsave' || $op == 'typeequipget' || $op == 'typeequipdelete'){
    include '../lib/ControllerTypeEquip.php';
    $CONTROL = new ControllerTypeEquip();
    echo $CONTROL->getResponseJSON();
} else if ($op == 'equipfromtypedelete' || $op == 'equipsave' || $op == 'equipget' || $op == 'equipdelete'){
    include '../lib/ControllerEquip.php';
    $CONTROL = new ControllerEquip();
    echo $CONTROL->getResponseJSON();
} else if ($op == 'softwsave' || $op == 'softwget' || $op == 'softwdelete'){
    include '../lib/ControllerSoftware.php';
    $CONTROL = new ControllerSoftware();
    echo $CONTROL->getResponseJSON();
} else if ($op == 'servsave' || $op == 'servget' || $op == 'servdelete'){
    include '../lib/ControllerServices.php';
    $CONTROL = new ControllerServices();
    echo $CONTROL->getResponseJSON();
} else {
    echo 'OPERACION NO DISPONIBLE';
}
?>
