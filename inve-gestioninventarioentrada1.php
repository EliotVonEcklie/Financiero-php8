<?php

require_once ('Models/almginventario.php');
require_once ('/conexion.php');
require_once ('/Controllers/EntradaController.php');
require_once ('/Controllers/TipoMovimientoController.php');
require_once ('/Controllers/AlmginventarioController.php');
require 'comun.inc';
require 'funciones.inc';

?>
<!DOCTYPE html5>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>:: SPID - Almacen</title>
    <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <script src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
    <script src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
    <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
    <script src="javaScript/funciones.js"></script>
    <?php titlepag();?>
</head>
<body>
    <table>
        <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
        <tr><?php menu_desplegable("inve");?></tr>
        <tr>
            <td colspan="3" class="cinta">
                <a href="inve-gestioninventarioentrada1.php" accesskey="n" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
                <a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
                <a onClick="visualizar()" accesskey="b" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
                <a onClick="mypop=window.open('inve-principal.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
                <a href="#" class="mgbt" onClick="<?php echo paginasnuevas("inve");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
                <a href="inve-menuinventario.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
            </td>
		</tr>
    </table>
    <form name="form2" method="post" action="">
        <table class="inicio">
            <tr>
                <td class="titulos" width="100%">.: Gesti&oacute;n de Inventarios </td>
                <td class="boton02" onClick="location.href='inve-principal.php'">Cerrar</td>
            </tr>
        </table>
        <?php
            //inicializa entrada controller
            $tipoMovimiento = new EntradaController(@$_POST[tipomov]);
            $tipoMovimiento->inicializar();
            @$_POST[tipomov]=$tipoMovimiento->tipoMovimiento;

            //SE LLAMA LA CLASE TipoMovimientoController Y SE GENERA LOS TIPOS DE ENTRADA SEGUN EL TIPO DE MOVIMIENTO
            $tipoEntrada = new TipoMovimientoController(@$_POST[tipomov]);
            $tipoEntrada->generarTiposDeEntrada();
            $tipoEntradaTabla = $tipoEntrada->tipoMov;

            //se instancia la clase que genera el CRUD para almginventario1
            $almginventario = new AlmginventarioController();
            //si el consecutivo y el tipo de entrada no exite, se hace el llamado al metodo generarConsecutivo
            if(@$_POST[numero]=='' && @$_POST[tipoentra]!='')
            {
                //Generar consecutivo
                $almginventario->generarConsecutivo(@$_POST[tipomov],@$_POST[tipoentra]);
                @$_POST[numero] = $almginventario->consecutivo + 1;
            }
            
        ?>
        <table class="inicio" >
            <tr>
                <td class="saludo1" style="width:10%">Tipo de Movimiento: </td>
                <td style="width:15%">
                    <select name="tipomov" id="tipomov" onChange="document.form2.submit()"  style="width:100%;" >
                        <option value="-1">Seleccione ....</option>
                        <option value="1" <?php if(@$_POST[tipomov]=='1') echo "SELECTED"; ?>>1 - Entrada</option>
                        <option value="3" <?php if(@$_POST[tipomov]=='3') echo "SELECTED"; ?>>2 - Reversi&oacute;n de Entrada</option>
                    </select>
                </td>
                <?php
                    if(@$_POST[tipomov]==1)
                    {
                        ?>
                        <td class="saludo1" style="width:10%">Tipo Entrada:</td>
                        <td style="width:15%">
                            <select name="tipoentra" id="tipoentra" onChange="cambiarEntradaAlmacen()" style="width:100%;">
                                <option value="-1">..Seleccione</option>
                                <?php
                                for($x=0; $x<count($tipoEntradaTabla); $x++)
                                {
                                    if($tipoEntradaTabla[$x]['codigo']==@$_POST[tipoentra])
                                    {
                                        echo "<option value='".$tipoEntradaTabla[$x]['codigo']."' SELECTED>".$tipoEntradaTabla[$x]['tipom']."".$tipoEntradaTabla[$x]['codigo']." - ".$tipoEntradaTabla[$x]['nombre']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='".$tipoEntradaTabla[$x]['codigo']."'>".$tipoEntradaTabla[$x]['tipom']."".$tipoEntradaTabla[$x]['codigo']." - ".$tipoEntradaTabla[$x]['nombre']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                        <td class="saludo1" style="10%">Consecutivo:</td>
                        <td style="width:5%">
                            <input type="text" id="numero" name="numero"  style="width:60%; text-align:center" value="<?php echo @$_POST[numero] ?>" readonly>
                        </td>
                        <td class="saludo1" style="width:10%;">Fecha Registro:</td>
                        <td style="width:10%">
                            <input type="text" name="fecha" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo @$_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width: 100%"/>&nbsp;<img src="imagenes/calendario04.png" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut" />
                        </td>
                        <td style="width:20%"></td>
                        <?php
                    }
                ?>
            </tr>
            <tr>
                <td class="saludo1">Descripci&oacute;n:</td>
          		<td colspan="7">
                    <textarea name="nombre" rows="2"  style="width:100%;"><?php echo @$_POST[nombre]?></textarea>
                </td>
            </tr>
        </table>
        <table class='inicio ancho'>
            <tr>
                <td colspan="2" class='titulos2'>Gesti&oacute;n Inventario - Entrada</td>
            </tr>
            <?php
            switch(@$_POST[tipoentra])
            {
                case '01':
                    ?>
                    <tr>
                        <td class='saludo1' style='width:6%'>Consecutivo De Contrato:</td>
                        <td style='width:6%'>
                            <input type="text" id="documento" name="documento" onBlur="buscar();">
                        </td>
                    </tr>
                    <?php
                break;
            }
            ?>
            
        </table>
    </form>
</body>
</html>