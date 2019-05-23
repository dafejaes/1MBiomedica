$(document).on('ready', initusuario);
var q, estado, allFields, tips, nombre, apellido, contrasena1, contrasena2, ciudad, departamento, direccion, lineaco;
var bValid = true;
/**
 * se activa para inicializar el documento
 */
function initusuario() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    nombre = $("#nombre");
    allFields = $([]).add(nombre);
    tips = $(".validateTips");

    $('#dynamictable').dataTable({
		"sPaginationType": "full_numbers"
    });

    $("#crearusuario").button().click(function() {
		q.id = 0;
		nombre = $("#nombre");
		apellido = $("#apellido");
		contrasena1 = $("#password2");
		contrasena2 = $("#password3");
		ciudad = $("#ciudad");
		departamento = $("#departamento");
		direccion = $("#direccion");
		$("#form_crearusuario").dialog("open");
    });

    $("#form_crearusuario").dialog({
		autoOpen: false,
		height: 600,
		width: 450,
		modal: true,
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
										USUARIO.savedata();
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

    

var USUARIO = {
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
		q.op = 'usrsavegeneral';
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
		q.ingeniero1 = $('#ing').prop('checked');
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
		if(q.ingeniero1){
			q.ingeniero=1;
		}else{
			q.ingeniero=0;
		}
		UTIL.callAjaxRqst(q, this.savedatahandler);
		},
		savedatahandler: function(data) {
		UTIL.cursorNormal();
		if (data.output.valid) {
			updateTips('Información guardada correctamente');
			window.location = 'usuario.php';
		} else {
			updateTips('Error: ' + data.output.response.content);
		}
    }
}
