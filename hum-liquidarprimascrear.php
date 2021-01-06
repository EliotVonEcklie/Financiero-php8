<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=utf-8");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gesti&oacute;n Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("hum");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><img src="imagenes/add.png"  onClick="location.href='hum-liquidarprimascrear.php'" class="mgbt"/><img src="imagenes/guarda.png"  onClick="fguardar()" class="mgbt"/><img src="imagenes/buscad.png" class="mgbt1"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
    		<table  class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="8">:: Liquidar Primas</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
      			</tr>
      			<tr>
                	<td class="saludo1" style="width:3cm;">No Liquidaci&oacute;n:</td>
                    <td style="width:10%"><input type="text" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" style="width:98%" readonly/></td>
                   	<td class="saludo1" style="width:3cm;">Fecha:</td>
                    <td style="width:15%"><input type="text" name="fecha" value="<?php echo $_POST[fecha]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" title="Calendario" class="icobut"/></td>
                    <td class="saludo1" style="width:3cm;">Vigencia:</td> 
                    <td style="width:10%"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]?>" style="width:98%" readonly></td>
                    <td class="saludo1" style="width:3cm;">No Preliquidaci&oacute;n:</td> 
	    			<td>
                    	<select name="idpreli" id="idpreli" onChange="document.form2.submit();">
							<option value="-1">Sel ...</option>
                            <?php
                          		$sqlr="SELECT T1.codigo,T1.mes,T1.vigencia FROM hum_prenomina T1,hum_prenomina_tipos T2 WHERE T1.estado='S' AND T1.num_liq=0 AND T1.codigo=T2.num_nomi AND T2.tipo_prenom='01' AND T2.estado_tipo='S'";
                                $resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[idpreli]) 
									{
										echo "<option value='$row[0]' SELECTED>$row[0] - ".mesletras($row[1])." $row[2]</option>";
									}
									else {echo "<option value='$row[0]'>$row[0] - ".mesletras($row[1])." $row[2]</option>";}
								}   
							?>
                        </select>
                   	</td>
       			</tr>                       
    		</table> 
		</form>
	</body>
</html>