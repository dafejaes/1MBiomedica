$(document).on('ready', inittipoequip);
var q, allFields, tips, id2, clase, alias, marca, modelo, clasificacion, tipo, precio, resena;
var bValid = true;
/**
 * se activa para inicializar el documento
 */
function inittipoequip() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    alias = $("#alias");
    allFields = $([]).add(nombre);
    tips = $(".validateTips");

    $('#dynamictable').dataTable({
        "sPaginationType": "full_numbers"
    });

    $("#creartipoequipo").button().click(function() {
        q.id = 0;
        id2 = $("#id");
        clase = $("#clase");
        alias = $("#alias");
        marca = $("#marca");
        modelo = $("#modelo");
        clasificacion = $("#clasificacion");
        tipo = $("#tipo");
        precio = $("#precio");
        resena = $("#resena");
        $("#form_creartipoequipo").dialog("open");
    });

    $("#form_creartipoequipo").dialog({
        autoOpen: false,
        height: 600,
        width: 500,
        modal: true,
        buttons: {
            "Guardar": function() {
                id2 = $("#id");
                clase = $("#clase");
                alias = $("#alias");
                marca = $("#marca");
                modelo = $("#modelo");
                clasificacion = $("#clasificacion");
                tipo = $("#tipo");
                precio = $("#precio");
                bValid = bValid && checkLength(id2, "ID", 3, 30);
                if (bValid) {
                    bValid = bValid && checkLength(clase, "clase", 3, 30);
                    if (bValid) {
                        bValid = bValid && checkLength(alias, "alias", 3, 30);
                        if(bValid){
                            bValid = bValid && checkLength(marca, "marca", 3, 30);
                            if(bValid){
                                bValid = bValid && checkLength(modelo, "modelo", 3, 30);
                                if(bValid) {
                                    bValid = bValid && checkLength(clasificacion, "clasificación", 3, 30);
                                    if (bValid) {
                                        bValid = bValid && checkLength(tipo, "tipo", 3, 30);
                                        if(bValid){
                                            bValid = bValid && checkLength(precio, "precio", 3, 20);
                                            if(bValid){
                                                TIPOEQUIP.savedata();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                }
            }
        },
        close: function() {
            UTIL.clearForm('formcreate1');
            UTIL.clearForm('formcreate2');
            updateTips('');
        }
    });

    $("#dialog-permission").dialog({
        autoOpen: false,
        height: 530,
        width: 230,
        modal: true,
        buttons: {
            "Guardar": function() {
                var bValid = true;
                allFields.removeClass("ui-state-error");

                if (bValid) {
                    USUARIO.savepermission();
                    //$(this).dialog("close");
                }
            },
            "Cancelar": function() {
                UTIL.clearForm('formpermission');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formpermission');
            updateTips('');
        }
    });
}



var TIPOEQUIP = {
    deletedata: function(id) {
        var continuar = confirm('Va a eliminar información de forma irreversible.\n¿Desea continuar?');
        if (continuar) {
            q.op = 'usrdelete';
            q.id = id;
            UTIL.callAjaxRqst(q, this.deletedatahandler);
        }
    },
    deletedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            window.location = 'usuario.php';
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    editdata: function(id) {
        q.op = 'usrget';
        q.id = id;
        UTIL.callAjaxRqst(q, this.editdatahandler);
    },
    editdatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response[0];
            $('#nombre').val(res.nombres);
            $('#apellido').val(res.apellidos);
            $('#cedula').val(res.cedula);
            $('#email2').val(res.email);
            $('#fechanacimiento').val(res.fnacimiento);
            $('#ciudad').val(res.ciudad);
            $('#departamento').val(res.departamento);
            $('#direccion').val(res.direccion);
            if (res.ing == "1"){
                $('#ing').prop("checked", true);
            }else{
                $('#ing').prop("checked", false);
            }
            if(res.lcorreo == "1"){
                $('#lineacorreo').prop("checked", true);
            }else{
                $('#lineacorreo').prop('checked', false);
            }
            if(res.coespeciales == "1"){
                $('#especialco').prop('checked', true);
            }else{
                $('#especialco').prop('checked', false);
            }
            $("#form_crearusuario").dialog("open");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    editpermission: function(id) {
        q.op = 'usrprfget';
        q.id = id;
        UTIL.callAjaxRqst(q, this.editpermissionhandler);
    },
    editpermissionhandler: function(data) {
        UTIL.cursorNormal();
        debugger;
        if (data.output.valid) {
            var ava = data.output.available;
            var ass = data.output.assigned;
            var chks = '';
            for (var i in ava){
                chks += '<div class="check"><input type="checkbox" name="chk'+ava[i].id+'" id="chk'+ava[i].id+'" value="'+ava[i].id+'" class="text ui-widget-content ui-corner-all" /><span>&nbsp;&nbsp;</span><label>'+ava[i].nombre+'</label></div>';
            }
            $("#formpermission").empty();
            $("#formpermission").append(chks);
            $("#formpermission :input").each(function() {
                var p = $(this).attr('id');
                for (var j in ass){
                    var idchk = 'chk'+ass[j].id;
                    if (p == idchk){
                        $(this).attr('checked', 'true')
                    }
                }
            });
            $("#dialog-permission").dialog("open");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    /*getcustomer:function(){
	q.op = 'cliget';
	UTIL.callAjaxRqst(q, this.getcustomerHandler);
    },
    getcustomerHandler : function(data) {
	UTIL.cursorNormal();
	if (data.output.valid) {
	    var res = data.output.response;
	    var option = '<option value="seleccione">Seleccione...</option>';
	    for (var i in res){
		option += '<option value="'+res[i].id+'">'+res[i].nombre+'</option>';
	    }
	    $("#idcli").empty();
	    $("#idcli").append(option);
	} else {
	    alert('Error: ' + data.output.response.content);
	}
    },
    */savepermission: function() {
        var chk = '';
        var inputs = document.getElementById('formpermission').getElementsByTagName("input"); // get element by tag name
        for (var i in inputs) {
            if (inputs[i].type == "checkbox") {
                if($("#"+inputs[i].id).is(':checked')) {
                    chk += $("#"+inputs[i].id).val()+'-';
                }
            }
        }
        q.op = 'usrprfsave';
        q.chk = chk;
        UTIL.callAjaxRqst(q, this.savepermissionhandler);
    },
    savepermissionhandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            updateTips('Información guardada correctamente');
            $("#dialog-permission").dialog("close");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    savedata: function() {
        q.op = 'typeequipsave';
        q.id2 = $("#id").val();
        q.clase = $("#clase").val();
        q.alias = $("#alias").val();
        q.marca = $("#marca").val();
        q.modelo = $("#modelo").val();
        q.clasificacion = $("#clasificacion").val();
        q.tipo = $("#tipo").val();
        q.precio = $("#precio").val();
        q.resena = $("#direccion").val();
        UTIL.callAjaxRqst(q, this.savedatahandler);
    },
    savedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            updateTips('Información guardada correctamente');
            window.location = 'tipoequipoing.php';
        } else {
            updateTips('Error: ' + data.output.response.content);
        }
    },
    mostrarfoto: function () {
        var archivo = document.getElementById("foto").files[0];
        var reader = new FileReader();
        if (foto) {
            reader.readAsDataURL(archivo );
            reader.onloadend = function () {
                document.getElementById("img").src = reader.result;
            }
        }
    }
}
