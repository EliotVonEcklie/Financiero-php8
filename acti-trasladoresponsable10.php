<?php //IDEAL10 17/12/19 DD
	/**
	 * Vista Control de activos para el traslado de responsable del activo físico
	 * Se define fecha actual
	 * Se realiza busqueda del consecutivo del traslado
	 */
	require 'comun.inc';
	require 'funciones.inc';
	session_start();
	header("Cache-control: private");
	date_default_timezone_set("America/Bogota");

	@$_POST['fecha'] = date("d/m/Y");
	@$_POST['num_comp'] = selconsecutivo('actitraslados_resp','id');
?>
<!DOCTYPE html5>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>:: IDEAL10 - Activos Fijos</title>

    <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/estilos.css">
    <link rel="stylesheet" href="bootstrap/fontawesome.5.11.2/css/all.css">
    <link rel="stylesheet" href="bootstrap/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
    <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>

    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
    <script type="text/javascript" src="bootstrap/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="bootstrap/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="css/sweetalert.js"></script>
    <script type="text/javascript" src="ajax/funcionesControlActivos.js"></script>
    <?php titlepag();?>
</head>

<body>
    <div class="container-fluid">
        <table>
            <tr>
                <script>
                barra_imagenes("acti");
                </script>
                <?php cuadro_titulos();?>
            </tr>
            <tr><?php menu_desplegable("acti");?></tr>
            <tr>
                <td colspan="3" class="cinta">
                    <img src="imagenes/add.png" title="Nuevo" class="mgbt"
                        onClick="location.href='acti-trasladoresponsable10.php'" />
                    <img src="imagenes/guarda.png" title="Guardar" class="mgbt"
                        onClick="guardarTrasladoResponsable()" />
                    <img src="imagenes/buscad.png" title="Buscar" class="mgbt" />
                    <a class="mgbt" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();">
                        <img src="imagenes/nv.png" title="Nueva Ventana">
                    </a>
                    <a class="mgbt" href='acti-gestiondelosactivos.php'><img src="imagenes/iratras.png"
                            title="Atras"></a>
                </td>
            </tr>
        </table>
        <section class="section-header-gb mb-1">
            <div class="card">
                <div class="row my-1 mx-1 titulo-gb">
                    <div class="col-md-10 col-sm-10 col-10 pt-1">
                        <span class="pl-1 text-white">.: Agregar Traslado de Responsable </span>
                    </div>
                    <div class="col-md-2 col-sm-2 col-2 text-right p-0">
                        <a href="acti-principal.php">
                            <button type="button" class="btn btn-sm btn-outline-light font-weight-bolder">

                                <i class="fas fa-times-circle"></i>
                                <span class="ml-1">Cerrar</span>
                            </button>
                        </a>
                    </div>
                </div>
                <form class="mb-1" onsubmit="return false;">
                    <div class="form-inline mb-2">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Comprobante</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-0">
                            <input class="form-control" type="text" id="num_comp"
                                value="<?php echo @$_POST['num_comp']?>"
                                onKeyPress="javascript:return solonumeros(event)" disabled>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Fecha:</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-0">
                            <input type="text" name="fecha" value="<?php echo @$_POST['fecha']; ?>"
                                class="form-control imput--fecha" aria-describedby="basic-addon1"
                                onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"
                                id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY"
                                placeholder="DD/MM/YYYY">
                            <a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img
                                    src="imagenes/calendario04.png" style="width:20px;" /></a>
                        </div>
                    </div>
                    <div class="form-inline mb-1">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Número activo</label>
                        </div>
                        <div class="col-md-3-col-sm-3 col-3 px-1">
                            <div class="input-group">
                                <input class="form-control" type="text" id="num_act" name="num_act"
                                    value="<?php echo @$_POST['num_act']?>" onblur="buscarDatosActivo(this)">
                                <div class=" input-group-append">
                                    <button class="btn btn-primary" onClick="despliegamodal2('visible','1');">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Descripción</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="desc_act" name="desc_act"
                                value="<?php echo @$_POST['desc_act']?>" disabled>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Centro costo</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="ccosto_act" name="ccosto_act"
                                value="<?php echo @$_POST['ccosto_act']?>" disabled>
                        </div>
                    </div>
                    <div class="form-inline mb-1">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Origen</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="resp_act"
                                value="<?php echo @$_POST['resp_act']?>" disabled>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Nombre</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="nom_resp_act" disabled>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Estado actual</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="estado_act">
                        </div>
                    </div>

                    <div class="form-inline mb-1">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Destino</label>
                        </div>
                        <div class="col-md-3-col-sm-3 col-3 px-1">
                            <div class="input-group">
                                <input class="form-control" type="text" id="tercero" name="tercero"
                                    value="<?php echo @$_POST['tercero']?>" disabled>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" onClick="despliegamodal2('visible','2');">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Nombre</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="ntercero" name="ntercero" disabled>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Motivo</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="motivo_act">
                        </div>
                    </div>
                </form>
            </div>
            <input type="hidden" name="codfun" id="codfun" value="<?php echo $_POST['codfun']?>" />
            <form id="formPDF" method="POST" action="pdfactitraslado.php" target="_BLANK" hidden>
                <input type="hidden" name="codusu" id="codusu" value="<?php echo $_SESSION['cedulausu']?>" />
                <input type="hidden" name="idtras" id="idtras" />
            </form>
        </section>
        <section class="section-header-gb" id="section_history">
            <div class="card">
                <div class="row my-1 mx-1 titulo-gb">
                    <div class="col-md-12 col-sm-12 col-12 d-inline-flex text-white font-weight-bolder">
                        <span class="pl-1">.: Historial del activo</span>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <table class="table table-sm table-hover" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Activo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Elaborador</th>
                                    <th scope="col">Origen</th>
                                    <th scope="col">Destino</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Motivo</th>
                                    <th scope="col">Operaciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="bgventanamodal2">
        <div id="ventanamodal2">
            <IFRAME src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0
                style="left:500px; width:880px; height:480px; top:200;"></IFRAME>
        </div>
    </div>
</body>
<script>
/**@abstract
 * Función de carga automatica
 * Carga de parametros de control
 */
$(document).ready(function() {
    buscarParametrosControlActivos(llenarParametros);
});

/**@abstract
 * Función para llenar parametros del almacenista
 */
var datos_almacenista = null;
var llenarParametros = function(datos) {
    if (datos['id'])
        datos_almacenista = datos;
}

/**@abstract
 * Despliega ventana emergente heredada
 * Se despliega ventana de activos
 * Se despliega ventana de funcionarios
 */
var despliegamodal2 = function(_valor, _num) {
    document.getElementById("bgventanamodal2").style.visibility = _valor;
    if (_valor == "hidden") {
        document.getElementById('ventana2').src = "";
    } else {
        switch (_num) {
            case '1':
                document.getElementById('ventana2').src =
                    "cargaactivos-ventana01.php?iPlaca=num_act&iNombre=desc_act&iCCosto=ccosto_act";
                break;
            case '2':
                document.getElementById('ventana2').src =
                    "cargafuncionarios-ventana04.php?objeto=tercero&vcodfun=codfun&ntobjeto=ntercero";
                break;
        }
    }
}

/**@abstract
 * Función para buscar datos del activo
 * Se realiza busqueda del tercero asignado
 * Se realiza busqueda del historial del activo físico
 */
var buscarDatosActivo = function(element) {
    buscarTerceroActivo({
        id: element.value
    }, asignarTerceroActivo);
    buscarHistorialActivo({
        id: element.value
    }, cargarDatosTabla);
}

/**@abstract
 * Función para asignar responsable
 * Se evaluar, si existe registro del responsable se asigna
 * En caso contrario se asigna el almacenista por defecto
 */
var asignarTerceroActivo = function(...args) {
    var argument = JSON.parse(args[0]);
    if (argument) {
        $("#resp_act").val(argument['codter']);
        $("#nom_resp_act").val(argument['nomter']);
        $("#codfun").val(argument['codfun']);
    } else if (datos_almacenista) {
        $("#resp_act").val(datos_almacenista['cc_almacenista']);
        $("#nom_resp_act").val(datos_almacenista['nom_almacenista']);
    }
}

/**@abstract
 * Función para cargar información el tabla de historial
 */
var dataTable = null;
var cargarDatosTabla = function(...args) {
    var argument = JSON.parse(args);
    if (argument.length == 0 && dataTable) {
        dataTable.destroy();
        $('#dataTable > tbody').empty();
    } else if (argument.length) {
        dataTable = $('#dataTable').DataTable({
            data: argument,
            paging: false,
            scrollY: '155px',
            scrollCollapse: true,
            bFilter: false,
            order: [
                [2, "asc"]
            ],
            language: {
                "emptyTable": "No hay datos disponibles en la tabla.",
                "info": "Del _START_ al _END_ de _TOTAL_ ",
                "infoEmpty": "Mostrando 0 registros de un total de 0.",
                "infoFiltered": "(filtrados de un total de _MAX_ registros)",
                "infoPostFix": "(traslados)",
                "lengthMenu": "Mostrar _MENU_ registros",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "searchPlaceholder": "Dato para buscar",
                "zeroRecords": "No se han encontrado coincidencias.",
                "paginate": {
                    "first": "Primera",
                    "last": "Última",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": "Ordenación ascendente",
                    "sortDescending": "Ordenación descendente"
                }
            },
            columnDefs: [{
                    targets: 0,
                    data: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    targets: 1,
                    data: 'activo'
                },
                {
                    targets: 2,
                    data: 'fecha'
                },
                {
                    targets: 3,
                    data: 'elaborado'
                },
                {
                    targets: 4,
                    data: 'origen'
                },
                {
                    targets: 5,
                    data: 'destino'
                },
                {
                    targets: 6,
                    data: 'estado'
                },
                {
                    targets: 7,
                    data: 'motivo'
                },
                {
                    targets: 8,
                    data: 'id',
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return `<button type="button" class="btn btn-primary" id="print_` + data + `" onClick="generarPDF(this)">
									<i class="fas fa-print"></i>
    							</button>`
                    }
                }
            ]
        });
        $("#section_history").attr('hidden', false);
    }
}

/**@abstract
 * Función para generar soporte del traslado en formato Pdf
 */
var generarPDF = function(element) {
    $("#idtras").val(element.id.split('_')[1]);
    $("#formPDF").submit();
}
</script>

</html>
