$(document).on('ready', initservice);
var q, allFields, tips, nombre, archivo;
var bValid = true;
/**
 * se activa para inicializar el documento
 */
function initservice() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    tips = $(".validateTips");

    $('#dynamictable').dataTable({
        "sPaginationType": "full_numbers"
    });

    $("#crearservice").button().click(function() {
        q.id = 0;
        nombre = $("#nombre");
        archivo = $("#archivo");
        UTIL.clearForm('formcreate');
        $("#form_crearservicio").dialog("open");
    });

    $("#form_crearservicio").dialog({
        autoOpen: false,
        height: 400,
        width: 600,
        modal: true,
        buttons: {
            "Guardar": function() {
                nombre = $("#nombre");
                archivo = $("#archivo");
                updateTips('');
                bValid = true;
                bValid = bValid && checkLength(nombre, 'nombre', 3, 30);
                if (bValid) {
                    bValid = bValid && checkLength(archivo, "archivo", 3, 30);
                    if (bValid) {
                        SERVICE.savedata();
                    }

                }
            }
        },
        close: function() {
            UTIL.clearForm('formcreate');
            updateTips('');
        }
    });

}



var SERVICE = {
    mostrarfoto: function () {
        var archivo = document.getElementById("imagen").files[0];
        var reader = new FileReader();
        if (imagen) {
            reader.readAsDataURL(archivo );
            reader.onloadend = function () {
                document.getElementById("img").src = reader.result;
            }
        }
    },
    savedata: function () {
        q.op = 'servsave';
        q.nombre = $('#nombre').val();
        q.archivo = $('#archivo').val();
        UTIL.callAjaxRqst(q, this.savedataHandler);
    },
    savedataHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            updateTips('Información guardada correctamente');
            window.location = 'serviciosing.php';
        }else{
            alert('Error: ' + data.output.response.content);
        }
    },
    editdata: function(id){
        q.id = id;
        q.op = 'servget';
        UTIL.callAjaxRqst(q, this.editdataHandler);
    },
    editdataHandler: function(data){
        UTIL.cursorNormal();
        if(data.output.valid){
            var res = data.output.response[0];

            $('#nombre').val(res.nombre);
            $('#archivo').val(res.archivo);
            $('#form_crearservicio').dialog('open');
        }else{
            alert('Error: ' + data.output.response.content);

        }
    },
    deletedata: function(id){
        var continuar = confirm('Va a eliminar información de forma irreversible.\n¿Desea continuar?');
        if(continuar) {
            q.id = id;
            q.op = 'servdelete';
            UTIL.callAjaxRqst(q, this.deletedataHandler);
        }
    },
    deletedataHandler: function(data){
        UTIL.cursorNormal();
        if(data.output.valid){
            window.location = 'serviciosing.php';
        }else{
            alert('Error: ' + data.output.response.content);
        }
    },
    vermsgsoftw: function(){

    }
}
