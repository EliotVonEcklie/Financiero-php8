<?php //IDEAL10 02/01/2020
/**
 * Vista Presupuesto para consultar reportes RPS con saldo
 */
	require 'comun.inc';
	require 'funciones.inc';
	session_start();
	header("Cache-control: private");
	date_default_timezone_set("America/Bogota");
	ini_set('memory_limit', '-1');
?>

<!DOCTYPE html5>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>:: IDEAL10 - Presupuesto</title>

    <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s'); ?>" rel="stylesheet" type="text/css" />
    <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s'); ?>" rel="stylesheet" type="text/css" />
    <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s'); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/estilos.css">
    <link rel="stylesheet" href="bootstrap/fontawesome.5.11.2/css/all.css">
    <link rel="stylesheet" href="bootstrap/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap4.min.css">

    <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s'); ?>"></script>
    <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s'); ?>"></script>
    <script type="text/javascript" src="ajax/funcionesPresupuesto.js"></script>

    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
    <script type="text/javascript" src="bootstrap/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="bootstrap/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="css/sweetalert.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <?php titlepag(); ?>
</head>

<body>
    <div class="container-fluid">
        <table>
            <tr>
                <script>
                barra_imagenes("presu");
                </script><?php cuadro_titulos(); ?>
            </tr>
            <tr><?php menu_desplegable("presu"); ?></tr>
            <tr>
                <td colspan="3" class="cinta">
                    <a href="presu-reportesrps.php" class="mgbt">
                        <img src="imagenes/add.png" title="Nuevo" />
                    </a>
                    <a href="#" class="mgbt">
                        <img src="imagenes/guardad.png" title="Guardar" />
                    </a>
                    <a class="mgbt">
                        <img src="imagenes/buscad.png" title="Buscar" />
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
        <section class="section-header-gb">
            <div class="card">
                <div class="row my-1 mx-1 titulo-gb">
                    <div class="col-md-10 col-sm-10 col-10 pt-1">
                        <span class="pl-1 text-white">.: Reporte RPS</span>
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">Vigencia</th>
                                    <th scope="col">#RP</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Saldo</th>
                                    <th scope="col">Tercero</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="font-weight-normal">
                            </tbody>
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
    buscarRPS(cargarDatosTabla);
});

var cargarDatosTabla = function(datos) {
    if (dataTable) {
        dataTable.destroy();
        $('#dataTable > tbody').empty();
    }

    dataTable = $('#dataTable').DataTable({
        data: datos,
        select: true,
        scrollY: '350px',
        scrollCollapse: true,
        bFilter: false,
        order: [
            [0, "asc"]
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf'
        ],
        language: {
            "lengthMenu": "Mostrar _MENU_ datos por Pag.",
            "zeroRecords": "No se encontro información",
            "info": "Pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles'",
            "infoFiltered": "(Filtrados de _MAX_ total registro)"
        },
        columnDefs: [{
                targets: 0,
                data: 'vigencia',
            },
            {
                targets: 1,
                data: 'consvigencia'
            },
            {
                targets: 2,
                data: 'objeto'
            },
            {
                targets: 3,
                data: 'valor'
            },
            {
                targets: 4,
                data: 'saldo'
            },
            {
                targets: 5,
                data: 'tercero'
            },
            {
                targets: 6,
                data: 'estado'
            }
        ]
    });
}
</script>


</html>