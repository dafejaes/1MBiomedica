$(document).on('ready', registro);
var q, estado, allFields, tips, nombre, apellido, contrasena1, contrasena2, ciudad, departamento, direccion, lineaco;

/**
 * se activa para inicializar el documento
 */
function registro() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    var bValid = true;

    tips = $(".validateTips");


    UTIL.applyDatepicker('fechanacimiento');

    $("#iniciosesion").button().click(function() {
        q.id = 0;
        nombre = $("#nombre");
        apellido = $("#apellido");
        contrasena1 = $("#password2");
        contrasena2 = $("#password3");
        ciudad = $("#ciudad");
        departamento = $("#departamento");
        direccion = $("#direccion");
        $("#Inicio_Sesion").dialog("open");
    });
    $("#Inicio_Sesion").dialog({
        autoOpen: false, height: 400, width: 450, modal: true,
        buttons: {

            "Cancelar": function() {
                $(this).dialog("close");
                UTIL.clearForm('formcreate');
                updateTips('');
            }
        },
        close: function() {
            UTIL.clearForm('formcreate');
        }
    });
}

var INICIO = {
    savedata: function() {
        q.op = 'usrsavegeneral';
        q.id = 0;
        q.nombre = $("#nombre").val();
        q.apellido = $("#apellido").val();
        q.cedula = $("#cedula").val();
        q.email = $("#email2").val();
        q.pass = $("#password2").val();
        q.fechanaci = $("#fechanacimiento").val();
        q.ciudad = $("#ciudad").val();
        q.departamento = $("#departamento").val();
        q.direccion = $("#direccion").val();
        q.lineacorreo1 = $('#lineacorreo').prop('checked');
        q.especialco1 = $('#especialco').prop('checked');
        if(q.lineacorreo1){
            q.lineacorreo = 1;
        }else{
            q.lineacorreo = 0;
        }
        if(q.especialco1){
            q.especialco = 1;
        }else{
            q.especialco = 0;
        }
        q.igeniero = 0;
        UTIL.callAjaxRqst(q, this.savedatahandler);
    },
    savedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            updateTips('Información guardada correctamente');
            window.location = 'index.php';
        } else {
            updateTips('Error: ' + data.output.response.content);
        }
    }
}
