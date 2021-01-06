/**
 * Función para buscar el tercero resposable asignado al activo
 * Se llama función para retornar datos
 * @param  {...any} args - (id,Función de llamado al finalizar)
 */
function buscarTerceroActivo(...args) {
	var argument = args[0];
	var callback = args[1];
	var arrayData = {};
	arrayData['proceso'] = 'ACTIACTIVOSFISICOS_BUSCARACTIVO_RESPONSABLE';
	arrayData['placa'] = argument['id'];
	arrayData['estado'] = 'S';
	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/acti-funciones.php',
		success: function (response) {
			try {
				callback(response);
			} catch (e) {
				console.log(e);
				console.log(response);
				swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
			}
		}
	});
}

/**
 * Función para buscar el historial del activo responsable
 * Se llama función para retornar datos
 * @param  {...any} args - (id,Función de llamado al finalizar)
 */
function buscarHistorialActivo(...args) {
	var argument = args[0];
	var callback = args[1];
	var arrayData = {};
	arrayData['proceso'] = 'ACTIACTIVOSFISICOS_HISTORIALTRASLADO_RESPONSABLE';
	arrayData['activo'] = argument['id'];
	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/acti-funciones.php',
		success: function (response) {
			try {
				callback(response);
			} catch (e) {
				console.log(e);
				console.log(response);
				swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
			}
		}
	});
}

/**
 * Funcion para guardar traslado de responsable del activo
 * Se evalua la carga de la información
 * Se realiza el envió y guardado de la información del activo
 */
function guardarTrasladoResponsable() {
	if ($('#fc_1198971545').val() == "" || $('#fc_1198971545').val() == null)
		swal("IDEAL 10", "Falta seleccionar fecha.", "error");
	else if (($('#num_act').val() == "" || $('#num_act').val() == null) ||
		($('#tercero').val() == "" || $('#tercero').val() == null) ||
		($('#estado_act').val() == "" || $('#estado_act').val() == null) ||
		($('#motivo_act').val() == "" || $('#motivo_act').val() == null))
		swal("IDEAL 10", "Falta información para realizar el traslado.", "error");
	else {
		var arrayData = {};
		arrayData['proceso'] = 'ACTIACTIVOSFISICOS_GUARDARTRASLADO_RESPONSABLE';
		arrayData['fecha'] = $('#fc_1198971545').val();
		arrayData['activo'] = $('#num_act').val();
		arrayData['elaborado'] = datos_almacenista['cc_almacenista'];
		arrayData['origen'] = $('#resp_act').val();
		arrayData['destino'] = $('#tercero').val();
		arrayData['estado'] = $('#estado_act').val();
		arrayData['motivo'] = $('#motivo_act').val();

		swal({ title: "¿Estas Seguro de Guardar?",
    		text: "Se trasladara el activo!",
    		type: "warning",
    		showCancelButton: true,
			confirmButtonText: 'Si, Estoy Seguro!',
			cancelButtonText: "No, Cancelar!",
			closeOnCancel: true },
			function (isConfirm) {
				if (isConfirm)
				$.ajax({
					data: arrayData,
					type: 'POST',
					url: 'FunctionsAux/acti-funciones.php',
					success: function (response) {
						if(response == 0)
							swal({
								title: "IDEAL10",
								text: "Transacción exitosa, traslado de activo.",
								type: "success"
							}, function (isConfirm) {
									location.reload();
							});
						else {
							console.log(response);
							swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
						}
					}
				});
			}
		);
	}
}

/**
 * Función para buscar los parametros estandares
 * * Se llama función para retornar datos
 * @param  {...any} args ()
 */
function buscarParametrosControlActivos(...args) {
	var callback = args[0];
	var arrayData = {};
	arrayData['proceso'] = 'ACTIACTIVOSFISICOS_BUSCARPARAMETROS';
	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/acti-funciones.php',
		success: function (response) {
			try {
				arrayResult = JSON.parse(response);
				if(typeof(callback) == 'function')
					callback(arrayResult);
			} catch (e) {
				console.log(e);
				console.log(response);
				swal("IDEAL10","No se pudo realizar la operación, Falta parametrizar control de activos, comuníquese a soporte.", "warning");
			}
		}
	});
}

/**
 * Función para guardar parametros estandares de control de activos
 * Se evalua la carga de la información
 * Se realiza el envió y guardado de la información de los parametros
 */
function guardarParametrosControlActivos() {
	if ($('#tercero').val() == "" || $('#tercero').val() == null || $('#ntercero').val() == "" || $('#vlr_menor_ctia').val() == "" || $('#vlr_menor_ctia').val() == null)
		swal("IDEAL 10", "Falta seleccionar datos.", "error");

	var arrayData = {};
	arrayData['proceso'] = 'ACTIACTIVOSFISICOS_GUARDARPARAMETROS';
	arrayData['id'] = 1;
	arrayData['cc_almacenista'] = $('#tercero').val();
	arrayData['nom_almacenista'] = $('#ntercero').val();
	arrayData['valor_menor_cuantia'] = $('#vlr_menor_ctia').val();

	swal({ title: "¿Estas Seguro de Guardar?",
		text: "Se guradara parametros!",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: 'Si, Estoy Seguro!',
		cancelButtonText: "No, Cancelar!",
		closeOnCancel: true },
		function (isConfirm) {
			if (isConfirm)
			$.ajax({
				data: arrayData,
				type: 'POST',
				url: 'FunctionsAux/acti-funciones.php',
				success: function (response) {
					if(response == 0)
						swal({
							title: "IDEAL10",
							text: "Transacción exitosa, paramteros actualizados.",
							type: "success"
						});
					else {
						console.log(response);
						swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
					}
				}
			});
		}
	);
}

/**
 * Función para buscar los detalles de los activos
 * Disposción, CC, Ubicación, Área, Prototipo
 * Se llama función para retornar datos
 * @param  {...any} args ()
 */
function buscarDetallesControlActivos(...args) {
	var callback = args[1];
	var arrayData = {};
	arrayData['proceso'] = 'ACTIACTIVOSFISICOS_BUSCARDETALLES';
	arrayData['detalles'] = args[0];

	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/acti-funciones.php',
		success: function (response) {
			try {
				arrayResult = JSON.parse(response);
				if(typeof(callback) == 'function')
					callback(arrayResult);
			} catch (e) {
				console.log(e);
				console.log(response);
				swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
			}
		}
	});
}

/**
 * Función para buscar los parametros estandares
 * * Se llama función para retornar datos
 * @param  {...any} args ()
 */
function buscarDatosActivos(...args) {
	var callback = args[1];
	var arrayData = {};
	arrayData['proceso'] = 'ACTIACTIVOSFISICOS_BUSCARACTIVO';
	for (const field in args[0])
		arrayData[field] = args[0][field];

	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/acti-funciones.php',
		success: function (response) {
			try {
				arrayResult = JSON.parse(response);
				if(typeof(callback) == 'function')
					callback(arrayResult);
			} catch (e) {
				console.log(e);
				console.log(response);
				swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
			}
		}
	});
}

/**
 * Función para buscar el historial del activo detalles
 * Se llama función para retornar datos
 * @param  {...any} args - (id,Función de llamado al finalizar)
 */
function buscarHistorialActivoDeta(...args) {
	var callback = args[1];
	var arrayData = {};
	arrayData['proceso'] = 'ACTIACTIVOSFISICOS_HISTORIALTRASLADO_DETALLES';
	for (const field in args[0])
		arrayData[field] = args[0][field];

	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/acti-funciones.php',
		success: function (response) {
			try {
				arrayResult = JSON.parse(response);
				if(typeof(callback) == 'function')
					callback(arrayResult);
			} catch (e) {
				console.log(e);
				console.log(response);
				swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
			}
		}
	});
}

/**
 * Funcion para guardar traslado detalles del activo
 * Se evalua la carga de la información
 * Se realiza el envió y guardado de la información del activo
 */
function guardarTrasladoDetalles() {
	if ($('#fc_1198971545').val() == "" || $('#fc_1198971545').val() == null)
		swal("IDEAL 10", "Falta seleccionar fecha.", "error");
	else if (($('#num_act').val() == "" || $('#num_act').val() == null) ||
		($('#motivo_act').val() == "" || $('#motivo_act').val() == null) ||
		($('#estado_act').val() == "" || $('#estado_act').val() == null) ||
		($('#ccosto_act').val() == 0 || $('#ccosto_act').val() == null) ||
		($('#dispactivos_act').val() == 0 || $('#dispactivos_act').val() == null) ||
		($('#ubicacion_act').val() == 0 || $('#ubicacion_act').val() == null) ||
		($('#planacareas_act').val() == 0 || $('#planacareas_act').val() == null) ||
		($('#prototipo_act').val() == 0 || $('#prototipo_act').val() == null))
		swal("IDEAL 10", "Falta información para realizar el traslado.", "error");
	else if ((datos_activo['cc'] == $('#ccosto_act').val()) &&
		(datos_activo['area'] == $('#planacareas_act').val()) &&
		(datos_activo['ubicacion'] == $('#ubicacion_act').val()) &&
		(datos_activo['prototipo'] == $('#prototipo_act').val()) &&
		(datos_activo['dispoact'] == $('#dispactivos_act').val()))
		swal("IDEAL 10", "No hay cambios en el registro.", "warning");
	else{
		var arrayData = {};
		arrayData['proceso'] = 'ACTIACTIVOSFISICOS_GUARDARTRASLADO_DETALLES';
		arrayData['fecha'] = $('#fc_1198971545').val();
		arrayData['motivo'] = $('#motivo_act').val();
		arrayData['estado'] = $('#estado_act').val();
		arrayData['activo'] = $('#num_act').val();
		//arrayData['tipomov'] = datos_activo['cc'];
		arrayData['cc_ori'] = datos_activo['cc'];
		arrayData['area_ori'] = datos_activo['area'];
		arrayData['ubicacion_ori'] = datos_activo['ubicacion'];
		arrayData['prototipo_ori'] = datos_activo['prototipo'];
		arrayData['dispoactivo_ori'] = datos_activo['dispoact'];
		arrayData['valor_ori'] = datos_activo['valor'];
		arrayData['cc_des'] = $('#ccosto_act').val();
		arrayData['dispoactivo_des'] = $('#dispactivos_act').val();
		arrayData['ubicacion_des'] = $('#ubicacion_act').val();
		arrayData['area_des'] = $('#planacareas_act').val();
		arrayData['prototipo_des'] = $('#prototipo_act').val();

		swal({ title: "¿Estas Seguro de Guardar?",
    		text: "Se trasladara el activo!",
    		type: "warning",
    		showCancelButton: true,
			confirmButtonText: 'Si, Estoy Seguro!',
			cancelButtonText: "No, Cancelar!",
			closeOnCancel: true },
			function (isConfirm) {
				if (isConfirm)
				$.ajax({
					data: arrayData,
					type: 'POST',
					url: 'FunctionsAux/acti-funciones.php',
					success: function (response) {
						if(response == 0)
							swal({
								title: "IDEAL10",
								text: "Transacción exitosa, traslado de activo.",
								type: "success"
							}, function (isConfirm) {
									location.reload();
							});
						else {
							console.log(response);
							swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
						}
					}
				});
			}
		);
	}
}

/**
 * Función para filtrar el listado de traslado existentes
 * Se evaluar el parametro a filtrar
 * Se enviar los parametros
 * Se retorna la información para renderizar la tabla
 * @param  {...any} args
 */
function filtrarAcuerdos(...args) {
	var arrayData = {};
	var parameter = null;
	var callback = args[0];
	arrayData['proceso'] = 'ACTIACTIVOSFISICOS_FILTRARTRASLADOS_DETALLES';

	//Filtro por numero
	parameter = $("#numero").val();
	if (parameter != null && parameter != '')
		arrayData['id'] = parameter;

	//Filtro por fechas
	if (($("#fc_1198971545").val() != null && $("#fc_1198971545").val() != '') ||
		($("#fc_1198971546").val() != null && $("#fc_1198971546").val() != '')) {
		var fecha_ini = $("#fc_1198971545").val().split('/');
		var fecha_fin = $("#fc_1198971546").val().split('/');
		arrayData['sql_between'] = 'fecha_ini=' + fecha_ini[2] + "-" + fecha_ini[1] + "-" + fecha_ini[0]+ '/' + 'fecha_fin=' + fecha_fin[2] + "-" + fecha_fin[1] + "-" + fecha_fin[0];
	}

	if (Object.entries(arrayData).length !== 0)
		$.ajax({
			data: arrayData,
			type: 'POST',
			url: 'FunctionsAux/acti-funciones.php',
			success: function (response) {
				try {
					arrayResult = JSON.parse(response);
					if(typeof(callback) == 'function')
						callback(arrayResult);
				} catch (e) {
					console.log(e);
					console.log(response);
					swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
				}
			}
		});
}
