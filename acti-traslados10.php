<?php //IDEAL10 04/01/20 DD
/**
 * Vista Control de activos para el traslado del activo físico
 * Se define fecha actual
 * Se realiza busqueda del consecutivo del traslado
 */
require 'comun.inc';
require 'funciones.inc';
session_start();
header("Cache-control: private");
header("Content-Type: text/html;charset=utf8");
date_default_timezone_set("America/Bogota");

@$_POST['fecha'] = date("d/m/Y");
@$_POST['num_comp'] = selconsecutivo('actitraslados','id');
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
                        onClick="location.href='acti-traslados10.php'" />
                    <img src="imagenes/guarda.png" title="Guardar" class="mgbt" onClick="guardarTrasladoDetalles()" />
                    <a class="mgbt" href='acti-buscatraslados10.php'>
                        <img src="imagenes/busca.png" title="Buscar">
                    </a>
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
                        <span class="pl-1 text-white">.: Agregar Traslado de Activo </span>
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
                <div class="form mb-1">
                    <div class="form-inline mb-2">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Número activo</label>
                        </div>
                        <div class="col-md-3-col-sm-3 col-3 px-1">
                            <div class="input-group">
                                <input class="form-control" type="text" id="num_act" name="num_act"
                                    value="<?php echo @$_POST['num_act']?>" readonly>
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
                            <label class="etiqueta-gb py-1">Comprobante</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-0">
                            <input class="form-control" type="text" id="num_comp"
                                value="<?php echo @$_POST['num_comp']?>" disabled>
                        </div>
                    </div>
                    <div class="form-inline mb-2">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Motivo</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="motivo_act">
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Estado actual</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control w-100" type="text" id="estado_act">
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
                </div>
            </div>
            <div class="card">
                <div class="card-header py-0 my-1 mx-1 titulo-gb">
                    <span class="pl-1 text-white">Detalles primarios</span>
                </div>
                <div class="form-inline mb-1">
                    <div class="col-md-1 col-sm-1 col-1 px-1">
                        <label class="etiqueta-gb py-1">CC</label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-3 px-1">
                        <select class="form-control w-100" id="ccosto_act" name="ccosto_act"></select>
                    </div>
                    <div class="col-md-1 col-sm-1 col-1 px-1">
                        <label class="etiqueta-gb py-1 text-center">Disposición</label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-3 px-1">
                        <select class="form-control w-100" id="dispactivos_act"></select>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header py-0 my-1 mx-1 titulo-gb">
                    <span class="pl-1 text-white">Detalles secundarios</span>
                </div>
                <div class="form-inline mb-1">
                    <div class="col-md-1 col-sm-1 col-1 px-1">
                        <label class="etiqueta-gb py-1">Ubicación</label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-3 px-1">
                        <select class="form-control w-100" id="ubicacion_act"></select>
                    </div>
                    <div class="col-md-1 col-sm-1 col-1 px-1">
                        <label class="etiqueta-gb py-1">Área</label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-3 px-1">
                        <select class="form-control w-100" id="planacareas_act"></select>
                    </div>
                    <div class="col-md-1 col-sm-1 col-1 px-1">
                        <label class="etiqueta-gb py-1">Prototipo</label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-3 px-1">
                        <select class="form-control w-100" id="prototipo_act"></select>
                    </div>
                </div>
            </div>
            <form id="formPDF" method="POST" action="pdfactitrasladodeta.php" target="_BLANK" hidden>
                <input type="hidden" name="idtras" id="idtras" />
            </form>
        </section>
        <!--section class="section-header-gb" id="section_history">
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
                                    <th scope="col">Estado</th>
                                    <th scope="col">Motivo</th>
                                    <th scope="col">Operaciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section-->
    </div>
    <div id="bgventanamodal2">
        <div id="ventanamodal2">
            <IFRAME src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0
                style="left:500px; width:880px; height:480px; top:200;"></IFRAME>
        </div>
    </div>
</body>

<script type="text/javascript">
/**@abstract
 * Función de carga automatica
 * Carga de detalles de control de activos
 */
var arrayDetails = ['dispactivos_act', 'ccosto_act', 'ubicacion_act', 'planacareas_act', 'prototipo_act'];
var datos_activo = null;
$(document).ready(function() {
    buscarDetallesControlActivos(arrayDetails, llenarDetalles);
    $('#num_act').blur(function(event) {
        buscarDatosActivos({
            placa: this.value
        }, llenarDatosActivos);
        buscarHistorialActivoDeta({
            id: this.value
        }, cargarDatosTabla);
    });
});

/**@abstract
 * Función para obtener parametro de la URL
 */
var getParameters = function() {
    var $_GET = {};
    var args = location.search.substr(1).split(/&/);
    for (var i = 0; i < args.length; ++i) {
        var tmp = args[i].split(/=/);
        if (tmp[0] != "")
            $_GET[decodeURIComponent(tmp[0])] = decodeURIComponent(tmp.slice(1).join("").replace("+", " "));
    }
    return $_GET;
}

/**@abstract
 * Función para llenar datos del activo
 */
var llenarDatosActivos = function(datos) {
    if (datos[0]['codigo']) {
        datos_activo = datos[0];
        $('#ccosto_act').val(datos_activo['cc'] || 0);
        $('#dispactivos_act').val(datos_activo['dispoact'] || 0);
        $('#ubicacion_act').val(datos_activo['ubicacion'] || 0);
        $('#planacareas_act').val(datos_activo['area'] || 0);
        $('#prototipo_act').val(datos_activo['prototipo'] || 0);
    } else if (datos[0]['id']) {
        datos_activo = datos[0];
        $('#num_act').val(datos_activo['activo']);
        $('#estado_act').val(datos_activo['estado'])
        $('#motivo_act').val(datos_activo['motivo']);
        $('#fc_1198971545').val(datos_activo['fecha']);
        $('#ccosto_act').val(datos_activo['cc_des'] || 0);
        $('#dispactivos_act').val(datos_activo['dispoactivo_des'] || 0);
        $('#ubicacion_act').val(datos_activo['ubicacion_des'] || 0);
        $('#planacareas_act').val(datos_activo['area_des'] || 0);
        $('#prototipo_act').val(datos_activo['prototipo_des'] || 0);

    }

}

/**@abstract
 * Función para llenar select con detalles de los activos
 */
var llenarDetalles = function(datos) {
    for (const details in datos) {
        if (arrayDetails.indexOf(details) > -1) {
            for (const detail of datos[details]) {
                let $option = $('<option />', {
                    text: detail['nombre'] || detail['nombrearea'],
                    value: detail['id'] || detail['id_cc'] || detail['codarea'],
                });

                $('#' + details).append($option);
            }
            $('#' + details).prepend($('<option />', {
                text: 'Seleccione',
                value: 0,
                selected: true
            }));
        }
    }
    var parameters = getParameters();
    if (parameters['type'] == 'edit' || parameters['type'] == 'view') {
        buscarHistorialActivoDeta({
            id: parameters['id'],
            activo: parameters['active']
        }, llenarDatosActivos);
    }
}

/**@abstract
 * Despliega ventana emergente heredada
 * Se despliega ventana de activos
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
        }
    }
}

/**@abstract
 * Función para cargar información el tabla de historial
 */
var dataTable = null;
var cargarDatosTabla = function(argument) {
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
                [1, "asc"]
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
                    data: 'estado'
                },
                {
                    targets: 4,
                    data: 'motivo'
                },
                {
                    targets: 5,
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