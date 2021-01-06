    <?php //IDEAL10 13/12/19 DD
	require 'comun.inc';
	require 'funciones.inc';
	session_start();
	header("Cache-control: private");
	header("Content-Type: text/html;charset=utf8");
	date_default_timezone_set("America/Bogota");
?>

<!DOCTYPE html5>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>:: IDEAL10 - Presupuesto</title>

    <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/estilos.css">
    <link rel="stylesheet" href="bootstrap/fontawesome.5.11.2/css/all.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="bootstrap/datatables/dataTables.min.css">

    <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
    <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
    <script type="text/javascript" src="ajax/funcionesPresupuesto.js"></script>

    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
    <script type="text/javascript" src="css/sweetalert.js"></script>
    <script type="text/javascript" src="bootstrap/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="bootstrap/datatables/dataTables.bootstrap4.min.js"></script>
    <?php titlepag();?>
</head>

<body>
    <div class="container-fluid">
        <table>
            <tr>
                <script>
                barra_imagenes("presu");
                </script><?php cuadro_titulos();?>
            </tr>
            <tr><?php menu_desplegable("presu");?></tr>
            <tr>
                <td colspan="3" class="cinta">
                    <a href="presu-acuerdos.php" class="mgbt">
                        <img src="imagenes/add.png" title="Nuevo" />
                    </a>
                    <a href="#" class="mgbt">
                        <img src="imagenes/guardad.png" title="Guardar" />
                    </a>
                    <a href="presu-buscaracuerdos.php" class="mgbt">
                        <img src="imagenes/busca.png" title="Buscar" />
                    </a>
                    <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img
                            src="imagenes/agenda1.png" title="Agenda" />
                    </a>
                    <a href="#" class="mgbt"
                        onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img
                            src="imagenes/nv.png" title="Nueva Ventana">
                    </a>
                </td>
            </tr>
        </table>
        <section class="section-header-gb mb-1">
            <div class="card">
                <div class="row my-1 mx-1 titulo-gb">
                    <div class="col-md-10 col-sm-10 col-10 pt-1">
                        <span class="pl-1 text-white">:: Buscar .: Actos Administraticos</span>
                    </div>
                    <div class="col-md-2 col-sm-2 col-2 text-right p-0">
                        <a href="presu-principal.php">
                            <button type="button" class="btn btn-sm btn-outline-light font-weight-bolder">
                                <i class="fas fa-times-circle"></i>
                                <span class="ml-1">Cerrar</span>
                            </button>
                        </a>
                    </div>
                </div>
                <form class="mb-1" onsubmit="return false;">
                    <div class="form-inline mb-1">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Número:</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-0">
                            <input class="form-control" type="text" id="numero" value="<?php echo $_POST['numero']?>">
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Fecha inicial:</label>
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
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Fecha final:</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-0">
                            <input type="text" name="fecha" value="<?php echo @$_POST['fecha']; ?>"
                                class="form-control imput--fecha" aria-describedby="basic-addon1"
                                onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"
                                id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY"
                                placeholder="DD/MM/YYYY">
                            <a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img
                                    src="imagenes/calendario04.png" style="width:20px;" /></a>
                        </div>
                    </div>
                    <div class="form-inline">
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Tipo acto:</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-1">
                            <select class="form-control" id="tipo_acto_adm">
                                <option value="0" <?php if($_POST['tipo_acto_adm']=="0"){echo "selected"; }?>>
                                    Seleccione...</option>
                                <option value="1" <?php if($_POST['tipo_acto_adm']=="1"){echo "selected"; }?>>Por
                                    acuerdo</option>
                                <option value="2" <?php if($_POST['tipo_acto_adm']=="2"){echo "selected"; }?>>Por
                                    resolución</option>
                            </select>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1">
                            <label class="etiqueta-gb py-1">Tipo acuerdo:</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-0">
                            <select class="form-control" id="tipo_acuerdo">
                                <option value="" <?php if($_POST['tipo_acuerdo']==""){echo "selected"; }?>>
                                    Seleccione...</option>
                                <option value="I" <?php if($_POST['tipo_acuerdo']=="I"){echo "selected"; }?>>
                                    Inicial</option>
                                <option value="M" <?php if($_POST['tipo_acuerdo']=="M"){echo "selected"; }?>>
                                    Modificación</option>
                            </select>
                        </div>
                        <div class="col-md-1 col-sm-1 col-1 px-1 offset-1">
                            <label class="etiqueta-gb py-1">Acto Adtvo:</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2 px-0">
                            <input class="form-control w-100" type="text" id="acuerdo"
                                value="<?php echo $_POST['acuerdo']?>">
                        </div>
                        <div class="col-md-2 col-xs-2 col-2">
                            <button class="btn btn-primary w-100" onClick="filtrarAcuerdos(cargarDatosTabla)">
                                <i class="fas fa-search"></i>
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>
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
                            <span class="">Acuerdos Administrativos Encontrados:</span>
                            <span id="total_acuerdos"></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">Vigencia</th>
                                    <th scope="col">Numero</th>
                                    <th scope="col">Acto administrativo</th>
                                    <th scope="col">Valor inicial</th>
                                    <th scope="col">Adición</th>
                                    <th scope="col">Reducción</th>
                                    <th scope="col">Traslado</th>
                                    <th scope="col">Fecha acuerdo</th>
                                    <th scope="col">Tipo acuerdo</th>
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

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    buscarAcuerdos({
        consecutivo: -1
    }, cargarDatosTabla);
});

var cargarDatosTabla = function(datos) {
    if (dataTable) {
        dataTable.destroy();
        $('#dataTable > tbody').empty();
    }

    $('#total_acuerdos').html(datos.length);
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
            "infoEmpty": "Mostrando 0 registros de un total de 0.",
            "infoFiltered": "(filtrados de un total de _MAX_ registros)",
            "infoPostFix": "(actos adm)",
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
                "targets": 0,
                "data": 'vigencia',
                "render": {}
            },
            {
                "targets": 1,
                "data": 'consecutivo',
            },
            {
                "targets": 2,
                "data": 'numero_acuerdo',
            },
            {
                "targets": 3,
                "data": 'valorinicial',
            },
            {
                "targets": 4,
                "data": 'valoradicion',
            },
            {
                "targets": 5,
                "data": 'valorreduccion',
            },
            {
                "targets": 6,
                "data": 'valortraslado',
            },
            {
                "targets": 7,
                "data": 'fecha',
            },
            {
                "targets": 8,
                "data": 'tipo_acto_adm',
                "render": function(data, type, row, meta) {
                    switch (data) {
                        case 1:
                            return 'Por acuerdo';
                            break;
                        case 2:
                            return 'Por resolución';
                            break;
                        case 3:
                            return 'Por decreto';
                            break;
                        default:
                            return "";
                            break;
                    }
                }
            },
            {
                "targets": 9,
                "data": 'id_acuerdo',
                'orderable': false,
                "render": function(data, type, row, meta) {
                    if (row['estado'] == 'S')
                        return `<div class="btn-group" role="group">
									<a href="presu-acuerdos.php?type=edit&id=` + data + `&type_act=` + row['tipo_acto_adm'] + `&date=` + row[
                            'vigencia'] + `" target="_self">
										<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Editar">
											<i class="fas fa-edit"></i>
										</button>
									</a>
									<button type="button" class="btn btn-success" id="cancel_` + data + `" onClick="anularAcuerdo(this)" data-toggle="tooltip" data-placement="bottom" title="Anular">
										<i class="fas fa-trash-alt"></i>
									</button>
								</div>`;
                    else if (row['estado'] == 'N')
                        return `<div class="btn-group" role="group">
									<a href="presu-acuerdos.php?type=view&id=` + data + `&type_act=` + row['tipo_acto_adm'] + `&date=` + row[
                            'vigencia'] + `" target="_self">
										<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ver">
											<i class="fas fa-search"></i>
										</button>
									</a>
									<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Anulado">
										<i class="fas fa-trash-alt"></i>
									</button>
								</div>`
                    else
                        return `<div class="btn-group" role="group">
									<a href="presu-acuerdos.php?type=view&id=` + data + `&type_act=` + row['tipo_acto_adm'] + `&date=` + row[
                            'vigencia'] + `" target="_self">
										<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Ver">
											<i class="fas fa-search"></i>
										</button>
									</a>
									<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Cerrado">
										<i class="fas fa-lock"></i>
									</button>
								</div>`
                }
            }
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