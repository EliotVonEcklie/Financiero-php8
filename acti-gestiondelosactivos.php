<?php //V 1001 17/12/2016 ?>
<?php
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <title>:: Spid - Activos Fijos</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="css/programas.js"></script>
    <?php titlepag();?>
</head>
<style>

</style>

<body>
    <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
    <span id="todastablas2"></span>
    <table>
        <tr>
            <script>
            barra_imagenes("acti");
            </script><?php cuadro_titulos();?>
        </tr>
        <tr><?php menu_desplegable("acti");?></tr>
        <tr>
            <td colspan="3" class="cinta">
                <a class="mgbt"><img src="imagenes/add2.png" /></a>
                <a class="mgbt"><img src="imagenes/guardad.png" style="width:24px;" /></a>
                <a class="mgbt"><img src="imagenes/buscad.png" /></a>
                <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img
                        src="imagenes/agenda1.png" title="Agenda" /></a>
                <a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img
                        src="imagenes/nv.png" title="Nueva Ventana"></a>
            </td>
        </tr>
    </table>
    <form name="form2" method="post" action="">
        <table class="inicio">
            <tr>
                <td class="titulos" colspan="2">.: Configuracion Contable</td>
                <td class="cerrar" style="width:7%;"><a href="acti-principal.php">&nbsp;Cerrar</a></td>
            </tr>
            <tr>
                <td style="background-repeat:no-repeat; background-position:center; width:70%">
                    <ol id="lista2">
                        <table>
                            <tr>
                                <td style="width:50%;">
                                    <li onClick="location.href='acti-gestionactivos.php'" style="cursor:pointer;">Orden
                                        de Activaci&oacute;n</li>
                                    <li onClick="location.href='acti-construcciones.php'" style="cursor:pointer;">Orden
                                        de Construcciones en Curso</li>
                                    <li onClick="location.href='acti-montajes.php'" style="cursor:pointer;">Orden de
                                        Maquinaria en Montaje</li>
                                    <li onClick="location.href='acti-donaciones.php'" style="cursor:pointer;">Orden de
                                        Recuperaci&oacute;n</li>
                                    <li onClick="location.href='acti-traslados10.php'" style="cursor:pointer;">
                                        Traslado
                                    </li>
                                    <li onClick="location.href='acti-trasladoresponsable10.php'"
                                        style="cursor:pointer;">Traslado de Responsable</li>
                                    <li onClick="location.href='ayuda.html'" style="cursor:pointer;">Adicionar Al
                                        Principal</li>
                                    <li onClick="location.href='ayuda.html'" style="cursor:pointer;">Retiro</li>
                                </td>
                                <td style="width:50%;">
                                    <li onClick="location.href='acti-depreciaractivos.php'" style="cursor:pointer;">
                                        Depreciacion</li>
                                    <li onClick="location.href='acti-deterioro.php'" style="cursor:pointer;">Deterioro
                                    </li>
                                    <li onClick="location.href='acti-ajustevalor.php'" style="cursor:pointer;">
                                        Correcci&oacute;n a Valor Real</li>
                                    <li onClick="location.href='acti-estadoactivo.php'" style="cursor:pointer;">Estado
                                        de Cuenta del Activo</li>
                                    <li onClick="location.href='acti-depreciarinicial.php'" style="cursor:pointer;">
                                        Depreciacion Inicial</li>
                                    <li onClick="location.href='acti-traslados.php'" style="cursor:pointer;">
                                        Traslado Ant
                                    </li>
                                </td>
                            </tr>
                        </table>
                    </ol>
                </td>
                <td style="width:23%;">
                </td>
            </tr>
        </table>
    </form>
</body>

</html>
