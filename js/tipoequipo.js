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
            UTIL.clearForm('formcreate');
            updateTips('');
        }
    });

    $('#form_mostrarResena').dialog({
        autoOpen: false,
        height: 320,
        width: 500,
        modal: true,
        close: function () {
            UTIL.clearForm('formcreate2');
            updateTips('');
        }
    });
}



var TIPOEQUIP = {
    deletedata: function(id) {
        var continuar = confirm('Va a eliminar información de forma irreversible.\n¿Desea continuar?');
        if (continuar) {
            q.op = 'typeequipdelete';
            q.id = id;
            UTIL.callAjaxRqst(q, this.deletedatahandler);
        }
    },
    deletedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            TIPOEQUIP.deleteequip();
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    deleteequip: function(){
        q.op =  'equipfromtypedelete';
        q.idtype = q.id;
        UTIL.callAjaxRqst(q,this.deleteequiphandler);
    },
    deleteequiphandler: function(data){
        UTIL.cursorNormal();
        debugger;
        if (data.output.valid) {
            window.location = 'tipoequipoing.php';
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    editdata: function(id) {
        q.op = 'typeequipget';
        q.id = id;
        UTIL.callAjaxRqst(q, this.editdatahandler);
    },
    editdatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response[0];
            $('#id').val(res.ID2);
            $('#clase').val(res.clase);
            $('#alias').val(res.alias);
            $('#marca').val(res.marca);
            $('#modelo').val(res.modelo);
            $('#clasificacion').val(res.clasificacion);
            $('#tipo').val(res.tipo);
            $('#precio').val(res.precio);
            $('#resena').val(res.resena);
            $("#form_creartipoequipo").dialog("open");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    MostrarResena: function(id) {
        q.op = 'typeequipget';
        q.id = id;
        UTIL.callAjaxRqst(q, this.MostrarResenahandler);
    },
    MostrarResenahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response[0];
            $('#resena2').val(res.resena);
            $("#form_mostrarResena").dialog("open");
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
        q.resena = $("#resena").val();
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
