/**
 * Función para guardar los datos desde archivo excel y cargados en la tabla.
 * Se realiza validación si existe la fecha.
 * Se realiza validación si existe información en el parámetro cuentas.
 * Se utiliza librería SweetAlert de confirmación.
 * Se envía información a través de Ajax método post a la función PHP y este a su vez al controlador.
 */
function guardarImportaCuentas() {
    if ($('#fc_1198971545').val() == "" || $('#fc_1198971545').val() == undefined)
        swal("IDEAL 10", "Falta seleccionar fecha", "error", "ffff");
    else if (!validateValues($('input[name="cuenta[]"]')))
        swal("IDEAL 10", "Falta cargar información", "error", "ffff");
    else {
		var arrayData = {};
		arrayData['proceso'] = 'PPTOCUENTAS_GUARDAR';
        arrayData['entidad'] = ($('#entidades').val() == 1)? 'interna':($('#entidades').val() == 2)?'externa': '';
        arrayData['fecha'] = $('#fc_1198971545').val();
        arrayData['cuenta'] = inputsValues($('input[name="cuenta[]"]'));
        arrayData['nombre'] = inputsValues($('input[name="nombre[]"]'));
		arrayData['tipo'] = inputsValues($('input[name="tipo[]"]'));
		arrayData['regalias'] = inputsValues($('input[name="regalias[]"]'));
        arrayData['clasificacion'] = inputsValues($('input[name="clasificacion[]"]'));
        arrayData['causacion'] = inputsValues($('input[name="causacion[]"]'));
        arrayData['fuente'] = inputsValues($('input[name="fuente[]"]'));
		arrayData['posicion'] = inputsValues($('input[name="posicion[]"]'));

		swal({ title: "¿Estas Seguro de Guardar?",
    		text: "Se importara un nuevo plan de cuentas!",
    		type: "warning",
    		showCancelButton: true,
			confirmButtonText: 'Si, Estoy Seguro!',
			cancelButtonText: "No, Cancelar!",
			closeOnCancel: true },
			function(isConfirm){
				if (isConfirm)
				$.ajax({
					data: arrayData,
					type: 'POST',
					url: 'FunctionsAux/presu-funciones.php',
					success: function (response) {
						if (response == 0)
							swal({
								title: "IDEAL10",
								text: "Transacción exitosa, importación de cuentas completada.",
								type: "success"
							}, function (isConfirm) {
									location.reload();
							});
						else if (response == 1)
							swal({
								title: "IDEAL10",
								text: "Transacción exitosa, se encontraron cuentas ya importadas.",
								type: "warning"
							}, function (isConfirm) {
									location.reload();
							});
						else{
							console.log(response);
							swal("IDEAL10","No se pudo realizar la importación, comuníquese a soporte.", "error","ffff");
						}
					}
				});
			}
		);
	}
}

/**
 * Función para obtener la propiedad value de un elemento Input HTML.
 * Retorna un array con los valores
 * @param {HTMLInputElement} elements
 * @return {Array}
 */
function inputsValues(elements) {
    var data = [];
    for (let i = 0; i < elements.length; i++)
        data[i] = elements[i].value;
    return data;
}

/**
 * Función para validar la existencia de valores en los elementos Input HTML.
 * Retorna un boolean falso si existe un valor no valido.
 * @param {HTMLInputElement} elements
 * @return {boolean}
 */
function validateValues(elements) {
	if(elements.length == 0 || elements ==  null || elements == undefined) return false;
    var filtered = elements.filter(function(i) {
		var reg = /\s/;
		return !reg.test(elements[i].value) && elements[i].value != null &&
		elements[i].value != undefined && elements[i].value != "" ? elements[i] : null;
	});
    return elements.length == filtered.length ? true : false;
}

function buscarAcuerdos(...args) {
	var argument = args[0];
	var callback = args[1];
	if (argument['consecutivo'] != '' && argument['consecutivo'] != null) {
		var arrayData = {};
		arrayData['proceso'] = 'PPTOACUERDOS_BUSCAR';
		if (argument['consecutivo'] != -1) { //busqueda solo si existe al crear
			arrayData['consecutivo'] = parseInt(argument['consecutivo']);
			arrayData['tipo_acto_adm'] = parseInt(argument['tipo_acto']);
			arrayData['vigencia'] = argument['fecha'];
		} else if (argument['id_acuerdo']) { //busqueda para los exitentes al editar
			arrayData['id_acuerdo'] = parseInt(argument['id_acuerdo']);
			arrayData['tipo_acto_adm'] = parseInt(argument['tipo_acto']);
			arrayData['vigencia'] = argument['fecha'];
		} else if (argument['consecutivo'] == -1) //busqueda todos los registros tabla busqueda
			arrayData['consecutivo'] = parseInt(argument['consecutivo']);

		$.ajax({
			data: arrayData,
			type: 'POST',
			url: 'FunctionsAux/presu-funciones.php',
			success: function (response) {
				try {
					arrayResult = JSON.parse(response);
					if (arrayResult.length == 1) {
						if(arrayData['consecutivo'])
							swal("IDEAL10", "Acto administrativo ya existente.", "warning", "Excelente");
						if(typeof(callback) == 'function')
							callback(arrayResult);
					} else if (arrayResult.length > 1 && typeof(callback) == 'function') {
						callback(arrayResult);
					}
				} catch (e) {
					console.log(e);
					console.log(response);
					swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
				}
			}
		});
	}
}

function guardarAcuerdos() { //Evaluar tipo para saber Crear o Editar
	if ($('#fc_1198971545').val() == "" || $('#fc_1198971545').val() == null)
		swal("IDEAL 10", "Falta seleccionar fecha.", "error", "ffff");
	else if ($('#numero').val() == "" || $('#numero').val() == null || $('#acuerdo').val() == "" || $('#acuerdo').val() == null || $('#tipo_acto_adm').val() == 0)
		swal("IDEAL 10", "Falta información del acuerdo.", "error", "ffff");
	else {
		var arrayData = {};
		if(type_get == 'edit')
			arrayData['proceso'] = 'PPTOACUERDOS_EDITAR';
		else
			arrayData['proceso'] = 'PPTOACUERDOS_GUARDAR';

		arrayData['id_acuerdo'] = id_get;
		arrayData['tipo_acto_adm'] = $('#tipo_acto_adm').val();
		arrayData['consecutivo'] = $('#numero').val();
		arrayData['acuerdo'] = $('#acuerdo').val();
		arrayData['fecha'] = $('#fc_1198971545').val();
		arrayData['estado'] = 'S';
		arrayData['tipo'] = $('#tipo_acuerdo').val();

		if ($('#tipo_acuerdo').val() == 'I') {
			arrayData['valor_inicial'] = parseFloat($('#valor_inicial').val());
			arrayData['valor_adicion'] = 0;
			arrayData['valor_reduccion'] = 0;
			arrayData['valor_traslado'] = 0;
		} else {
			arrayData['valor_inicial'] = 0;
			arrayData['valor_adicion'] = parseFloat($('#valor_adicion').val());
			arrayData['valor_reduccion'] = parseFloat($('#valor_reduccion').val());
			arrayData['valor_traslado'] = parseFloat($('#valor_traslado').val());
		}

		swal({ title: "¿Estas Seguro de Guardar?",
    		text: "Se guarda datos del acuerdo!",
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
					url: 'FunctionsAux/presu-funciones.php',
					success: function (response) {
						if(response == 0)
							swal({
								title: "IDEAL10",
								text: "Transacción exitosa, se guardo acuerdo.",
								type: "success"
							}, function (isConfirm) {
									location.reload();
							});
						else {
							console.log(response);
							swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error","ffff");
						}
					}
				});
			}
		);
	}
}

function anularAcuerdo(...args) {
	var dataElement = args[0]['id'].split('_');
	var id = dataElement[1];

	if (dataElement[0] == 'cancel') {
		var arrayData = {};
		arrayData['proceso'] = 'PPTOACUERDOS_ANULAR';
		arrayData['id_acuerdo'] = id;
		arrayData['estado'] = 'N';

		swal({ title: "¿Estas Seguro de Anular?",
    		text: "Se anulara el acuerdo!",
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
					url: 'FunctionsAux/presu-funciones.php',
					success: function (response) {
						if (response == 0) {
							swal({
								title: "IDEAL10",
								text: "Transacción exitosa, se anulo el acuerdo.",
								type: "success"
							},function (isConfirm) {
								location.reload();
							});
						}else {
							console.log(response);
							swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error","ffff");
						}
					}
				});
			}
		);
    }
}

function filtrarAcuerdos(...args) {
	var arrayData = {};
	var parameter = null;
	var callback = args[0];
	arrayData['proceso'] = 'PPTOACUERDOS_FILTRAR';

	//Filtro por numero
	parameter = $("#numero").val();
	if (parameter != null && parameter != '')
		arrayData['consecutivo'] = parameter;

	//Filtro por tipo acto
	parameter = $("#tipo_acto_adm").val();
	if (parameter != null && parameter != '0')
		arrayData['tipo_acto_adm'] = parameter;

	//Filtro por tipo acuerdo
	parameter = $("#tipo_acuerdo").val();
	if (parameter != null && parameter != '')
		arrayData['tipo'] = parameter;

	//Filtro acto adtvo
	parameter = $("#acuerdo").val();
	if (parameter != null && parameter != '')
		arrayData['sql_like'] = 'numero_acuerdo='+parameter

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
			url: 'FunctionsAux/presu-funciones.php',
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
 * Función para buscar RPS con saldo
 * Se retorna datos de los RPS
 */
function buscarRPS(...args) {
	var callback = args[0];

	arrayData = {};
	arrayData['proceso'] = 'PPTORPS_BUSCAR';

	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/presu-funciones.php',
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
