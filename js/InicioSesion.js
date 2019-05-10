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
        $("#dialog-form2").dialog("open");
    });
    $("#dialog-form2").dialog({
        autoOpen: false, height: 600, width: 450, modal: true,
        buttons: {
            "Guardar": function() {
                nombre = $("#nombre");
                apellido = $("#apellido");
                contrasena1 = $("#password2");
                contrasena2 = $("#password3");
                ciudad = $("#ciudad");
                departamento = $("#departamento");
                direccion = $("#direccion");
                lineaco = $("#lineacorreo").val();
                bValid = bValid && checkLength(nombre, "nombres", 3, 30);
                UTIL.isEmail($("#email2"));
                if (bValid) {

                    bValid = bValid && checkLength(apellido, "apellidos", 3, 30);

                    if (bValid) {
                        bValid = bValid && checkpass(contrasena1,contrasena2,contrasena1.val(), contrasena2.val());
                        if(bValid){
                            bValid = bValid && checkLength(ciudad, "Ciudad", 3, 30);

                            if(bValid){
                                bValid = bValid && checkLength(departamento, "departamento", 3, 30);

                                if(bValid) {
                                    bValid = bValid && checkLength(direccion, "direccion", 3, 80);
                                    if (bValid) {
                                        INICIO.savedata();
                                    }
                                }
                            }
                        }
                    }

                }
            },
            "Cancelar": function() {
                $(this).dialog("close");
                UTIL.clearForm('formcreate');
                nombre.removeClass("ui-state-error");
                apellido.removeClass("ui-state-error");
                contrasena1.removeClass("ui-state-error");
                contrasena2.removeClass("ui-state-error");
                ciudad.removeClass("ui-state-error");
                departamento.removeClass("ui-state-error");
                direccion.removeClass("ui-state-error");
                $("#email2").removeClass("ui-state-error");
                updateTips('');
            }
        },
        close: function() {
            UTIL.clearForm('formcreate');
            nombre.removeClass("ui-state-error");
            apellido.removeClass("ui-state-error");
            contrasena1.removeClass("ui-state-error");
            contrasena2.removeClass("ui-state-error");
            ciudad.removeClass("ui-state-error");
            departamento.removeClass("ui-state-error");
            direccion.removeClass("ui-state-error");
            $("#email2").removeClass("ui-state-error");
            updateTips('');
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
