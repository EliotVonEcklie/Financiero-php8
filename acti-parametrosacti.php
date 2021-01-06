<?php //IDEAL10 28/12/2019 DD
/**
 * Vista Control de activos para defición de parametros estandar
 */
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
    <title>:: IDEAL10 - Activos Fijos</title>

    <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s'); ?>" rel="stylesheet" type="text/css" />
    <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s'); ?>" rel="stylesheet" type="text/css" />
    <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s'); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/estilos.css">
    <link rel="stylesheet" href="bootstrap/fontawesome.5.11.2/css/all.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s'); ?>"></script>
    <script type="text/javascript" src="ajax/funcionesControlActivos.js"></script>

    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
    <script type="text/javascript" src="css/sweetalert.js"></script>
    <?php titlepag(); ?>
</head>

<body>
    <div class="container-fluid">
        <table>
            <tr>
                <script>
                barra_imagenes("acti");
                </script><?php cuadro_titulos(); ?>
            </tr>
            <tr><?php menu_desplegable("acti"); ?></tr>
            <tr>
                <td colspan="3" class="cinta">
                    <a href="acti-parametrosacti.php" class="mgbt">
                        <img src="imagenes/add.png" title="Nuevo" />
                    </a>
                    <a href="#" onClick="guardarParametrosControlActivos()" class="mgbt">
                        <img src="imagenes/guarda.png" title="Guardar" />
                    </a>
                    <a class="mgbt">
                        <img src="imagenes/buscad.png" title="Buscar" />
                    </a>
                    <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img
                            src="imagenes/agenda1.png" title="Agenda" />
                    </a>
                    <a href="#" class="mgbt" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();"><img
                            src="imagenes/nv.png" title="Nueva Ventana">
                    </a>
                </td>
            </tr>
        </table>
        <section class="section-header-gb">
            <div class="card">
                <div class="row my-1 mx-1 titulo-gb">
                    <div class="col-md-10 col-sm-10 col-10 pt-1">
                        <span class="pl-1 text-white">.: Parametrización</span>
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
                        <div class="col-md-2 col-sm-2 col-2 px-1">
                            <label class="etiqueta-gb py-1">Almacenista:</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <div class="input-group">
                                <input class="form-control" type="text" id="tercero" name="tercero"
                                    value="<?php echo @$_POST['tercero'] ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" onClick="despliegamodal2('visible','1');">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 -col-sm-4 col-4 px-1">
                            <input class="form-control w-100" type="text" id="ntercero" name="ntercero"
                                value="<?php echo @$_POST['ntercero'] ?>" disabled>
                        </div>
                    </div>
                    <div class="form-inline mb-2">
                        <div class="col-md-2 col-sm-2 col-2 px-1">
                            <label class="etiqueta-gb py-1">Vlr Menor Cuantia:</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3 px-1">
                            <input class="form-control" type="text" id="vlr_menor_ctia" name="vlr_menor_ctia"
                                value="<?php echo @$_POST['vlr_menor_ctia'] ?>">
                        </div>
                    </div>
                </form>
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
 * Función para llenar parametros del tercero
 */
var llenarParametros = function(datos) {
    if (Object.entries(datos).length !== 0) {
        $("#tercero").val(datos['cc_almacenista']);
        $("#ntercero").val(datos['nom_almacenista']);
        $("#vlr_menor_ctia").val(datos['valor_menor_cuantia']);
    }
}

/**@abstract
 * Despliega ventana emergente de terceros heredada
 */
var despliegamodal2 = function(_valor, _num) {
    document.getElementById("bgventanamodal2").style.visibility = _valor;
    if (_valor == "hidden") {
        document.getElementById('ventana2').src = "";
    } else {
        switch (_num) {
            case '1':
                document.getElementById('ventana2').src =
                    "tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero";
                break;
        }
    }
}
</script>

</html>