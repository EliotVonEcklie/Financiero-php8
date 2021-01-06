<?php //IDEAL10 30/01/2020 DD
/**
 * Vista Tesoreria para buscar notas bancarias
 */
	require 'comun.inc';
	require 'funciones.inc';
	sesion();
	header("Cache-control: private");
	header("Content-Type: text/html;charset=utf8");
	date_default_timezone_set("America/Bogota");
	@$_POST['fecha'] = date("d/m/Y");
?>

<!DOCTYPE html5>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>:: IDEAL10 - Tesoreria</title>

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
    <script type="text/javascript" src="ajax/funcionesTesoreria.js"></script>

    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
    <script type="text/javascript" src="bootstrap/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="bootstrap/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="css/sweetalert.js"></script>
    <?php titlepag();?>
</head>

<body>
    <div class="container-fluid">
        <table>
            <tr>
                <script>
                barra_imagenes("teso");
                </script>
                <?php cuadro_titulos();?>
            </tr>
            <tr><?php menu_desplegable("teso");?></tr>
            <tr>
                <td colspan="3" class="cinta">
                    <a href="teso-notasbancarias.php" class="mgbt">
                        <img src="imagenes/add.png" title="Nuevo" />
                    </a>
                    <img src="imagenes/guardad.png" title="Guardar" class="mgbt" />
                    <a class="mgbt" href='teso-buscarnotasbancarias.php'>
                        <img src="imagenes/busca.png" title="Buscar">
                    </a>
                    <a class="mgbt" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();">
                        <img src="imagenes/nv.png" title="Nueva Ventana">
                    </a>
                    <a class="mgbt" href='teso-notasbancarias.php'>
                        <img src="imagenes/iratras.png" title="Atras">
                    </a>
                </td>
            </tr>
        </table>
        <section class="section-header-gb">
            <div class="card">
                <div class="row my-1 mx-1 titulo-gb">
                    <div class="col-md-10 col-sm-10 col-10 pt-1">
                        <span class="pl-1 text-white">:: Buscar .: Notas Bancarias</span>
                    </div>
                    <div class="col-md-2 col-sm-2 col-2 text-right p-0">
                        <a href="teso-principal.php">
                            <button type="button" class="btn btn-sm btn-outline-light font-weight-bolder">
                                <i class="fas fa-times-circle"></i>
                                <span class="ml-1">Cerrar</span>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="form-inline mb-1">
                    <div class="col-md-1 col-sm-1 col-1 px-1">
                        <label class="etiqueta-gb py-1">Número:</label>
                    </div>
                    <div class="col-md-1 col-sm-1 col-1 px-0">
                        <input class="form-control w-75" type="text" id="numero">
                    </div>
                    <div class="col-md-1 col-sm-1 col-1 px-1">
                        <label class="etiqueta-gb py-1">Fecha inicial:</label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-3 px-0">
                        <input type="text" name="fecha" class="form-control imput--fecha"
                            aria-describedby="basic-addon1" onKeyPress="javascript:return solonumeros(event)"
                            onKeyUp="return tabular(event,this)" id="fc_1198971545"
                            onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" placeholder="DD/MM/YYYY">
                        <a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img
                                src="imagenes/calendario04.png" style="width:20px;" /></a>
                    </div>
                    <div class="col-md-1 col-sm-1 col-1 px-1">
                        <label class="etiqueta-gb py-1">Fecha final:</label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-3 px-0">
                        <input type="text" name="fecha" class="form-control imput--fecha"
                            aria-describedby="basic-addon1" onKeyPress="javascript:return solonumeros(event)"
                            onKeyUp="return tabular(event,this)" id="fc_1198971546"
                            onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" placeholder="DD/MM/YYYY">
                        <a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img
                                src="imagenes/calendario04.png" style="width:20px;" /></a>
                    </div>
                    <div class="col-md-2 col-xs-2 col-2">
                        <button class="btn btn-primary w-100" onClick="filtrarNotas(cargarDatosTabla)">
                            <i class="fas fa-search"></i>
                            Filtrar
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-header-gb">
            <div class="card">
                <div class="row my-1 mx-1 titulo-gb">
                    <div class="col-md-12 col-sm-12 col-12 d-inline-flex px-0 text-white font-weight-bolder">
                        <div class="col-md-6 col-sm-6 col-6">
                            <span>.: Resultadoes de busqueda</span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6 text-right">
                            <span class="">Notas Bancarias Encontradas:</span>
                            <span id="total_notas"></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Concepto nota bancaria</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody class="font-weight-normal"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
<script>
var dataTable = null;

/**@abstract
 * Función de carga automatica
 * Busca el historial de los traslado de detalles
 */
$(document).ready(function() {
    buscarHistorialNotas({}, cargarDatosTabla);
});

/**@abstract
 * Función para cargar información el tabla de historial
 */
var cargarDatosTabla = function(datos) {
    if (dataTable) {
        dataTable.destroy();
        $('#dataTable > tbody').empty();
    }

    $('#total_notas').html(datos.length);
    dataTable = $('#dataTable').DataTable({
        data: datos,
        select: true,
        scrollY: '225px',
        scrollCollapse: true,
        bFilter: false,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        order: [
            [0, "desc"]
        ],
        language: {
            "emptyTable": "No hay datos disponibles en la tabla.",
            "info": "Del _START_ al _END_ de _TOTAL_ ",
            "infoEmpty": "Mostrando 0 registros de un total de 0 ",
            "infoFiltered": "(filtrados de un total de _MAX_ registros)",
            "infoPostFix": "(Notas)",
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
                data: 'id_notaban',
            },
            {
                targets: 1,
                data: 'fecha'
            },
            {
                targets: 2,
                data: 'concepto'
            },
            {
                targets: 3,
                data: 'valor',
                render: $.fn.dataTable.render.number(',', '.', 2, '$')
            },
            {
                targets: 4,
                data: 'estado',
                orderable: false,
                render: function(data, type, row, meta) {
                    if (data == 'S')
                        return `<button type="button" class="btn btn-circle btn-success " data-toggle="tooltip" data-placement="bottom" title="Activo">
								<i class="fas fa-circle"></i>
							</button>`
                    else
                        return `<button type="button" class="btn btn-circle btn-danger " data-toggle="tooltip" data-placement="bottom" title="Inactivo">
								<i class="fas fa-circle"></i>
							</button>`;
                }
            },
            {
                targets: 5,
                data: 'id_notaban',
                orderable: false,
                render: function(data, type, row, meta) {
                    type = (row['estado'] == 'S') ? 'btn-group' : 'd-none';
                    return `<div class="` + type + `" role="group">
									<a href="teso-notasbancarias.php?type=edit&id=` + data + `&active=` + row['estado'] + `" target="_self">
										<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Editar">
											<i class="fas fa-edit"></i>
										</button>
									</a>
								</div>`;
                }
            },
        ]
    });
    $('#dataTable tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            dataTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    $('#dataTable tbody').on('dblclick', 'tr', function() {
        $(this.lastChild.firstChild.firstElementChild).get(0).click();
    });
}
</script>

</html>
