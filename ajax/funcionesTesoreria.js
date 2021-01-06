var contador = 0;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////// INICIO DE GASTOS BANCARIOS////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function agregarDetalleGastoBancario()
{
	contador++;
	var centroCosto = document.getElementById("cc").value;
	var docBanco = document.getElementById("docBanco").value;
	var banco = document.getElementById("cuentaBancaria").value;
	var gastoBancario = document.getElementById("gastoBancario").value;
	var valor = document.getElementById("valor").value;
	
	if(centroCosto=='-1')
    {
        swal("IDEAL","Falta seleccionar el centro costo", "error","ffff");
    }
    else if(docBanco=='')
    {
        swal("IDEAL","Falta digitar el documento banco.", "error","ffff");
	}
	else if(banco=='')
    {
        swal("IDEAL","Falta seleccionar el banco banco.", "error","ffff");
	}
	else if(gastoBancario=='-1')
    {
        swal("IDEAL","Falta seleccionar el gasto bancario.", "error","ffff");
	}
	else if(valor=='')
    {
        swal("IDEAL","Falta digitar el valor.", "error","ffff");
	}
	else
	{
		document.getElementById("tablaGastosBancariosBody").innerHTML += `
		<tr class="font-weight-normal" id="` + contador + `">
			<td id="idTabla">`+contador+`</td>
			<td id="idcentroCosto">`+centroCosto+`</td>
			<td id="iddocBanco">`+docBanco+`</td>
			<td id="idbanco">`+banco+`</td>
			<td id="idgastoBancario">`+gastoBancario+`</td>
			<td id="idvalor">`+valor+`</td>
			<td>` + `<button type="button" class="btn btn-primary" name="eliminar" id="eliminar" onClick="eliminarFila(` + contador + `)"><i class="fas fa-trash-alt"></i></button>` + `</td>
		</tr>
		`;
		reordenarGastosBancarios();
		habilitarDeshabilitarBuscaCuentaBanco();
	}
}

function habilitarDeshabilitarBuscaCuentaBanco()
{
	var cantFilas = document.getElementById("tablaGastosBancarios").rows.length;
	if(cantFilas>1)
	{
		document.getElementById('buscaCuenta').style.display = 'none';
	}
	else
	{
		document.getElementById('buscaCuenta').style.display = 'block';
	}
}

function reordenarGastosBancarios()
{
    var num = 1;
    $('#tablaGastosBancarios tbody tr').each(function(){
        $(this).find('td').eq(0).text(num);
        num++;
	});
}

function eliminarFila(codigoFila)
{
	$('#tablaGastosBancarios tr#' + codigoFila).remove();
    /*reordenar();
	alert(codigoFila);
	var table = document.getElementById("tablaGastosBancarios");
	table.deleteRow(codigoFila);*/
	reordenarGastosBancarios();
	habilitarDeshabilitarBuscaCuentaBanco();
}

function guardarGastoBancario()
{
	var cantFilas = document.getElementById("tablaGastosBancarios").rows.length;
	var datoCeldas = [];
	for(var i=1;i<cantFilas;i++)
	{
		var datoCeldaPorCiclo = [];
		for(var j=0; j<6;j++)
		{
			datoCelda = document.getElementById("tablaGastosBancarios").rows[i].cells[j].innerText;
			datoCeldaPorCiclo.push(datoCelda);
		}
		datoCeldas.push(datoCeldaPorCiclo);
	}

	var numeroNota = document.getElementById("numeroNota").value;
	var fecha = document.getElementById("fc_1198971545").value;
	var concepto = document.getElementById("concepto").value;
	var tipoMovimiento = document.getElementById("tipoMovimiento").value;
	var nickusu = document.getElementById("nickusu").value;
	var terceroBanco = document.getElementById("tccuenta_banca").value;
	var cuentaContable = document.getElementById("ccuenta_banca").value;
    if(fecha=='')
    {
		swal("IDEAL","Falta escoger una fecha.", "error","ffff");
	}
	else if(concepto=='')
    {
		swal("IDEAL","Falta digitar un concepto para la nota.", "error","ffff");
	}
	else if(cantFilas=='1')
	{
		swal("IDEAL","Falta informacion para guardar la nota", "error","ffff");
	}
	else
	{
		var parametros = {
			"proceso": "GUARDAR_GASTO_BANCARIO",
			"numeroNota": numeroNota,
			"fecha": fecha,
			"concepto": concepto,
			"tipoMovimiento": tipoMovimiento,
			"nickusu": nickusu,
			"terceroBanco": terceroBanco,
			"cuentaContable": cuentaContable,
			"detalle": datoCeldas
		};
	
		swal({ title: "Estas Seguro de Guardar?",
			text: "Se guradara una nota bancaria!",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: 'Si, Estoy Seguro!',
			cancelButtonText: "No, Cancelar!",
			closeOnCancel: true },
			function (isConfirm) {
				if (isConfirm)
				$.ajax({
					data: parametros,
					type: 'POST',
					url: 'FunctionsAux/teso-funciones.php',
					success: function (response) {
						console.log(response);
						if(response)
							swal({
								title: "IDEAL10",
								text: "Transacción exitosa, la nota bancaria se guardo.",
								type: "success"
							}, function (isConfirm) {
								document.location.href = "teso-editarnotasbancarias.php?idr="+numeroNota;
							});
						else {
							swal("IDEAL10","No se pudo realizar la operacion.", "error");
						}
					}
				});
			}
		);
		//var miDato = idTable.firstChild.nodeValue;
	}
}


function editarNotasDetalles()
{
	var numeroNota = document.getElementById("numeroNota").value;
	var parametros = {
		"proceso": "DETALLES_GASTO_BANCARIO",
		"numeroNota": numeroNota
	};
	$.ajax({
		data: parametros,
		type: 'POST',
		url: 'FunctionsAux/teso-funciones.php',
		success: function (response) {
			if(response)
				llenarTablaDetallesNotaBancaroa(response);
			else {
				swal("IDEAL10","No se pudo realizar la operación.", "error");
			}
		}
	});
}

function llenarTablaDetallesNotaBancaroa(dataDetalleNota)
{
	arrayResult = JSON.parse(dataDetalleNota);
	console.log(arrayResult);
	var cantidad = arrayResult.length-1;

	for(var j=0; j<cantidad; j++)
	{
		contador++;
		document.getElementById("tablaGastosBancariosBody").innerHTML += `
		<tr class="font-weight-normal" id="` + contador + `">
			<td id="idTabla">`+contador+`</td>
			<td id="idcentroCosto">`+arrayResult[j]['cc']+`</td>
			<td id="iddocBanco">`+arrayResult[j]['gastoban']+`</td>
			<td id="idbanco">`+arrayResult[j]['ncuentaban']+`</td>
			<td id="idgastoBancario">`+arrayResult[j]['gastoban']+`</td>
			<td id="idvalor">`+arrayResult[j]['valor']+`</td>
			<td>` + `<button type="button" class="btn btn-primary" name="eliminar" id="eliminar" onClick="eliminarFila(` + contador + `)"><i class="fas fa-trash-alt"></i></button>` + `</td>
		</tr>
		`;
		reordenarGastosBancarios();
		habilitarDeshabilitarBuscaCuentaBanco();
	}
	document.getElementById("tccuenta_banca").value = arrayResult[0]['tercero'];
	document.getElementById("cuentaBancaria").value = arrayResult[0]['ncuentaban'];
	document.getElementById("ccuenta_banca").value = arrayResult[cantidad]['cuenta'];
	document.getElementById("nbanco").value = arrayResult[cantidad]['razonsocial'];
}

function editarGastoBancario()
{
	var cantFilas = document.getElementById("tablaGastosBancarios").rows.length;
	var datoCeldas = [];
	for(var i=1;i<cantFilas;i++)
	{
		var datoCeldaPorCiclo = [];
		for(var j=0; j<6;j++)
		{
			datoCelda = document.getElementById("tablaGastosBancarios").rows[i].cells[j].innerText;
			datoCeldaPorCiclo.push(datoCelda);
		}
		datoCeldas.push(datoCeldaPorCiclo);
	}

	var numeroNota = document.getElementById("numeroNota").value;
	var fecha = document.getElementById("fc_1198971545").value;
	var concepto = document.getElementById("concepto").value;
	var tipoMovimiento = document.getElementById("tipoMovimiento").value;
	var nickusu = document.getElementById("nickusu").value;
	var terceroBanco = document.getElementById("tccuenta_banca").value;
	var cuentaContable = document.getElementById("ccuenta_banca").value;
    if(fecha=='')
    {
		swal("IDEAL","Falta escoger una fecha.", "error","ffff");
	}
	else if(concepto=='')
    {
		swal("IDEAL","Falta digitar un concepto para la nota.", "error","ffff");
	}
	else if(cantFilas=='1')
	{
		swal("IDEAL","Falta informacion para guardar la nota", "error","ffff");
	}
	else
	{
		var parametros = {
			"proceso": "EDITAR_GASTO_BANCARIO",
			"numeroNota": numeroNota,
			"fecha": fecha,
			"concepto": concepto,
			"tipoMovimiento": tipoMovimiento,
			"nickusu": nickusu,
			"terceroBanco": terceroBanco,
			"cuentaContable": cuentaContable,
			"detalle": datoCeldas
		};
	
		swal({ title: "Estas Seguro de Guardar?",
			text: "Se edita la nota bancaria!",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: 'Si, Estoy Seguro!',
			cancelButtonText: "No, Cancelar!",
			closeOnCancel: true },
			function (isConfirm) {
				if (isConfirm)
				$.ajax({
					data: parametros,
					type: 'POST',
					url: 'FunctionsAux/teso-funciones.php',
					success: function (response) {
						console.log(response);
						if(response)
							swal({
								title: "IDEAL10",
								text: "Transacción exitosa, la nota bancaria se edito.",
								type: "success"
							}, function (isConfirm) {
								location.reload();
							});
						else {
							swal("IDEAL10","No se pudo realizar la operacion.", "error");
						}
					}
				});
			}
		);
		//var miDato = idTable.firstChild.nodeValue;
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////// FIN DE GASTOS BANCARIOS////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function agregarDetalleOtrosEgresos()
{
    contador++;
    var retencionIngreso=$("#RetencionIngreso").val();
    var valor=$("#valor").val();
    var cc = $("#cc").val();
    var fecha = $("#fc_1198971545").val();
    if(retencionIngreso=='-1')
    {
        swal("IDEAL","Falta seleccionar retencion o ingreso", "error","ffff");
    }
    else if(valor=='')
    {
        swal("IDEAL","Falta digitar el valor.", "error","ffff");
    }
    else if(fecha=='')
    {
        swal("IDEAL","Falta digitar la Fecha.", "error","ffff");
    }
    else if(cc=='-1')
    {
        swal("IDEAL","Falta seleccionar el centro de costo.", "error","ffff");
    }
    else
    {
        var CuentaContable;
        var arrayData = {};
        arrayData['proceso'] = 'CUENTA_CONTABLE_RETENCION_INGRESOS';
        arrayData['reteIng'] = retencionIngreso.substr(0,1);
        arrayData['numReteIng'] = retencionIngreso.substr(2,3);
        arrayData['cc'] = cc;
        arrayData['fechaInicial'] = fecha;
        var cuentaAjax = $.ajax({
            data: arrayData,
            type: 'POST',
            url: 'teso-funciones.php',
            global: false , 
            async:false,
            success: function (response) {
                //CuentaContable = response;
                return response;
                /*if(response == 0)
                    swal("IDEAL10","Transacción exitosa, importación de cuentas completada.","success","Excelente");
                else if( response == 1)
                    swal("IDEAL10","Transacción exitosa, se encontraron cuentas ya importadas.","warning","Excelente");
                else{
                    
                    swal("IDEAL10","No se pudo realizar la importación, comuníquese a soporte.", "error","ffff");
                }*/
                
            }
            
        }).responseText;

        //console.log(cuentaAjax); // or... return jqxhr; 
        CuentaContable = cuentaAjax;

        var htmlTags = '<tr class="font-weight-normal" id="' + contador + '">' +
                            '<td id="idTabla">' + contador + '</td>'+
                            '<td id="RentencionIngresos">' + retencionIngreso + '</td>'+
                            '<td id="cuentaContable">' + CuentaContable + '</td>'+
                            '<td id="valor">' + valor + '</td>' +
                            '<td>' + '<button type="button" class="btn btn-primary" name="eliminar" id="eliminar" onClick="eliminarDetalleOtrosEgresos(' + contador + ')"><i class="fas fa-trash-alt"></i> Eliminar</button>' + '</td>' +
                        '</tr>';
                $('#tablaOtrosEgresos tbody').append(htmlTags);
        $("#valor").val('');
        reordenar();
    }
}

function eliminarDetalleOtrosEgresos(codigoFila)
{
    $('#tablaOtrosEgresos tr#' + codigoFila).remove();
    reordenar();
}

function reordenar()
{
    var num = 1;
    $('#tablaOtrosEgresos tbody tr').each(function(){
        $(this).find('td').eq(0).text(num);
        num++;
    });
}

/** Agregar ceros a la izq */
Number.prototype.zfill = function(size) {
    var numb = String(this);
    while (numb.length < (size || 2)) {
        numb = '0' + numb;
    }
    return numb;
}

/**
 * Función para buscar los parametros estandares
 * * Se llama función para retornar datos
 * @param  {...any} args ()
 */
function buscarParametrosTesoreria(...args) {
	var callback = args[1];
	var arrayData = {};
	arrayData['proceso'] = 'TESO_BUSCARPARAMETROS';
	arrayData['parametros'] = args[0];

	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/teso-funciones.php',
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
 * Función para buscar cuentas de los parametros
 * * Se llama función para retornar datos
 * @param  {...any} args ()
 */
function buscarCuentasTesoreria(...args) {
	var callback = args[1];
	var arrayData = {};
	arrayData['proceso'] = 'TESO_BUSCARCUENTAS';
	for (const field in args[0])
		arrayData[field] = args[0][field];

	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/teso-funciones.php',
		success: function (response) {
			try {
				arrayResult = JSON.parse(response);
				if(typeof(callback) == 'function')
					callback(arrayResult);
			} catch (e) {
				console.log(e);
				console.log(response);
				swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "warning");
			}
		}
	});
}

/**
 * Función para guardar parametros estandares de tesoreria
 * Se evalua la carga de la información
 * Se realiza el envió y guardado de la información de los parametros
 */
function guardarParametrosTesoreria(...args) {
	var arrayData = {};
	arrayData['proceso'] = 'TESO_GUARDARPARAMETROS';
	arrayData['id'] = 1;
	arrayData['estado'] = 'S';
	for (const field of args[0])
		if (field == 'tmindustria') {
			value = $('#' + field).val()
			arrayData[field] = numeral(value).value() || '';
		} else
			arrayData[field] = $('#' + field).val() || '';

	for (const parametro of args[1])
	switch (parametro) {
		case 'BASE_PREDIAL':
			arrayData[parametro] = $('#basepredial').val() || '';
			break
		case 'BASE_PREDIALAMB':
			arrayData[parametro] = $('#basepredialamb').val() || '';
			break
		case 'CUENTA_TRASLADO':
			arrayData[parametro] = $('#cuentatraslado').val() || '';
			break;
		case 'COBRO_RECIBOS':
			arrayData[parametro] = [$('#ingresos').val() || '', $('#recibovalor').val() || '', $('#cobrorecibo').val() || ''];
			break;
		case 'CUENTA_MILES':
			arrayData[parametro] = [$('#cuentamil').val() || '', $('#ncuentamil').val() || ''];
			break;
		case 'DESC_INTERESES':
			arrayData[parametro] = [$('#vigmaxdescint').val() || '', $('#porcdescint').val() || '', $('#aplicadescint').val() || ''];
			break;
		case 'NORMA_PREDIAL':
			arrayData[parametro] = $('#aplicapredial').val() || '';
			break;
		case 'DESCUENTO_CON_DEUDA':
			arrayData[parametro] = $('#descuento_deuda').val() || '';
			break;
		case 'COBRO_ALUMBRADO':
			arrayData[parametro] = [$('#ingresos_alumbrado').val() || '', $('#valor_alumbrado').val() || '', $('#cobro_alumbrado').val() || ''];
			break;
		}

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
				url: 'FunctionsAux/teso-funciones.php',
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

/**
 * Función para buscar parametros de notas bancarias
 * * Se llama función para retornar datos
 * @param  {...any} args ()
 */
function buscarParametrosNotas(...args) {
	var callback = args[0];
	var arrayData = {};
	arrayData['proceso'] = 'TESO_BUSCARPARAMETROS_NOTAS';

	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/teso-funciones.php',
		success: function (response) {
			try {
				arrayResult = JSON.parse(response);
				if(typeof(callback) == 'function')
					callback(arrayResult);
			} catch (e) {
				console.log(e);
				console.log(response);
				swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "warning");
			}
		}
	});
}

/**
 * Función para buscar detalles del Rp(rubros)
 * * Se llama función para retornar datos
 * @param  {...any} args ()
 */
function buscarDetallesRp(...args) {
	var callback = args[1];
	var arrayData = {};
	arrayData['proceso'] = 'TESO_BUSCARDETALLES_RP';
	arrayData['consvigencia'] = args[0];
	arrayData['vigencia'] = 2019;
	arrayData['tipo_mov'] = 201;

	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/teso-funciones.php',
		success: function (response) {
			try {
				arrayResult = JSON.parse(response);
				if(typeof(callback) == 'function')
					callback(arrayResult,'crear');
			} catch (e) {
				console.log(e);
				console.log(response);
				swal("IDEAL10","No se pudo realizar la operación, Falta parametrizar control de activos, comuníquese a soporte.", "warning");
			}
		}
	});
}

/**
 * Función para guardar nota bancaria
 * Se evalua la carga de la información
 * Se realiza el envió y guardado de la información de los parametros
 */
function guardarNotaBancaria(...args) {
	let arrayData = {};
	let valorTotal = 0;
	let arrayDataDetalles = args[0];
	let tipo_mov = args[1];

	if (tipo_mov == '401') {
		arrayData['proceso'] = 'TESO_REVERSAR_NOTAS';
		arrayData['estado'] = 'R';
		arrayData['id_comp'] = $('#nota_banca').val();
		arrayData['fecha'] = $('#fc_1198971545').val();
		arrayData['concepto'] = $('#concepto_nota_rever').val();
		arrayData['tipo_mov'] = tipo_mov;
		arrayData['nickusu'] = $('#nickusu').val();

		swal({ title: "¿Estas Seguro de Guardar?",
			text: "Se reversara la nota bancaria!",
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
					url: 'FunctionsAux/teso-funciones.php',
					success: function (response) {
						setTimeout(function () {
							if (response == 0) {
								swal({
									title: "IDEAL10",
									text: "Transacción exitosa, se reverso la nota bancaria.",
									type: "success"
								},function (isConfirm) {
									location.reload();
								});
							} else {
								console.log(response);
								swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
							}
						}, 100);
					}
				});
			}
		);
	} else if (Object.entries(arrayDataDetalles).length > 0 && tipo_mov == '201') {
		if (validarParametros(arrayData, arrayIdCabecera)) {
			arrayData['proceso'] = (parameters['type'] == 'edit')? 'TESO_EDITAR_NOTAS':'TESO_GUARDAR_NOTAS';
			arrayData['estado'] = 'S';
			arrayDataDetalles.forEach(function (detalle, idx) {
				arrayData[idx] = detalle;
				valorTotal += (detalle['valor']) ? detalle['valor'] : 0;
			});
			arrayData['total'] = valorTotal;

			swal({ title: "¿Estas Seguro de Guardar?",
				text: "Se creara nota bancaria!",
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
						url: 'FunctionsAux/teso-funciones.php',
						success: function (response) {
							setTimeout(function () {
								if (response == 0) {
									swal({
										title: "IDEAL10",
										text: "Transacción exitosa, se creó nota bancaria.",
										type: "success"
									},function (isConfirm) {
										location.reload();
									});
								} else {
									console.log(response);
									swal("IDEAL10","No se pudo realizar la operación, comuníquese a soporte.", "error");
								}
							}, 100);
						}
					});
				}
			);
		}
	} else
	swal("IDEAL10","Falta información para el guardado.", "warning");
}

/**
 * Función para buscar el historial de notas bancarias
 * Se llama función para retornar datos
 * @param  {...any} args - (id,Función de llamado al finalizar)
 */
function buscarHistorialNotas(...args) {
	var callback = args[1];
	var arrayData = {};
	arrayData['proceso'] = 'TESO_HISTORIAL_NOTAS';
	for (const field in args[0])
		arrayData[field] = args[0][field];

	$.ajax({
		data: arrayData,
		type: 'POST',
		url: 'FunctionsAux/teso-funciones.php',
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
 * Función para filtrar el listado de notas bancarias existentes
 * Se evaluar el parametro a filtrar
 * Se enviar los parametros
 * Se retorna la información para renderizar la tabla
 * @param  {...any} args
 */
function filtrarNotas(...args) {
	var arrayData = {};
	var parameter = null;
	var callback = args[0];
	arrayData['proceso'] = 'TESO_FILTRAR_NOTAS';

	//Filtro por numero
	parameter = $("#numero").val();
	if (parameter != null && parameter != '')
		arrayData['id_notaban'] = parameter;

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
			url: 'FunctionsAux/teso-funciones.php',
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
