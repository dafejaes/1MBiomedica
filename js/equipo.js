$(document).on('ready', initequip);
var q, allFields, tips, id2, bodega, serie, placa, codigo, registroINVIMA;
var bValid = true;
/**
 * se activa para inicializar el documento
 */
function initequip() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    tips = $(".validateTips");

    $('#dynamictable').dataTable({
        "sPaginationType": "full_numbers"
    });

    $("#crearequipo").button().click(function() {
        q.id = 0;
        id2 = $("#id");
        bodega = $("#bodega");
        serie = $("#serie");
        placa = $("#placa");
        codigo = $("#codigo");
        registroINVIMA = $("#registroINVIMA");
        UTIL.clearForm('formcreate');
        $("#form_crearequipo").dialog("open");
    });

    $("#form_crearequipo").dialog({
        autoOpen: false,
        height: 500,
        width: 500,
        modal: true,
        buttons: {
            "Guardar": function() {
                id2 = $("#id");
                bodega = $("#bodega");
                serie = $("#serie");
                placa = $("#placa");
                codigo = $("#codigo");
                updateTips('');
                bValid = true;
                registroINVIMA = $("#registroINVIMA");
                bValid = bValid && EQUIP.validateid2(id2.val());
                if (bValid) {
                    bValid = bValid && checkLength(bodega, "bodega", 3, 30);
                    if (bValid) {
                        bValid = bValid && checkLength(serie, "serie", 3, 30);
                        if(bValid){
                            bValid = bValid && checkLength(placa, "placa", 3, 30);
                            if(bValid){
                                bValid = bValid && checkLength(codigo, "codigo", 3, 30);
                                if(bValid) {
                                    EQUIP.savedata();
                                }
                            }
                        }
                    }

                }else{
                    updateTips('ID no existe');
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

    EQUIP.gettypeequip();
}



var EQUIP = {
    gettypeequip: function () {
        q.op = 'typeequipget';
        UTIL.callAjaxRqst(q, this.gettypeequipHandler);
    },
    gettypeequipHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            var res = data.output.response;
            var option = '';
            for (var i in res){
                option += '<option value="'+res[i].ID2+'"></option>';
            }
            $('#listaids').empty();
            $('#listaids').append(option);
            q.res = res;
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    validateid2: function (id2) {
        for( var i in q.res){
            if(q.res[i].ID2 == id2){
                return true;
            }
        }
        return false;
    },
    savedata: function () {
        q.op = 'equipsave';
        q.id2 = $('#id').val();
        q.bodega = $('#bodega').val();
        q.serie = $('#serie').val();
        q.placa = $('#placa').val();
        q.codigo = $('#codigo').val();
        q.registroINVIMA = $('#registroINVIMA').val();
        UTIL.callAjaxRqst(q, this.savedataHandler);
    },
    savedataHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            updateTips('Información guardada correctamente');
            window.location = 'Equipoing.php';
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    editdata: function (id) {
        q.id = id;
        q.op = 'equipget';
        UTIL.callAjaxRqst(q, this.editdataHandler);
    },
    editdataHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.response){
            var res = data.output.response[0];

            $('#id').val(res.ID2);
            $('#bodega').val(res.bodega);
            $('#serie').val(res.bodega);
            $('#placa').val(res.placa);
            $('#codigo').val(res.codigo);
            $('#registroINVIMA').val(res.registroINVIMA);
            $("#form_crearequipo").dialog("open");

        }else{
            alert('Error: ' + data.output.response.content);
        }
    },
    deletedata: function (id) {
        var continuar = confirm('Va a eliminar información de forma irreversible.\n¿Desea continuar?');
        if (continuar) {
            q.op = 'equipdelete';
            q.id = id;
            UTIL.callAjaxRqst(q, this.deletedataHandler);
        }

    },
    deletedataHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            window.location = 'equipoing.php';
        } else{
            alert('Error: ' + data.output.response.content);
        }
    }
}
