<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
  	require"funciones.inc";
 	session_start(); 
 	$linkbd=conectar_bd();  
 	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
  	header("Cache-control: private"); // Arregla IE 6
  	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
    	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid - Gestion Humana</title>
        <<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
        <script>
			function detalleslibranzas(id, radicado)
			{
				if($('#detalle'+id).css('display')=='none')
				{
					$('#detalle'+id).css('display','block');
					$('#img'+id).attr('src','imagenes/minus.gif');
				}
				else
				{
					$('#detalle'+id).css('display','none');
					$('#img'+id).attr('src','imagenes/plus.gif');
				}
				var toLoad= 'plan-acdetallesdocradi.php';
				$.post(toLoad,{radicado:radicado},function (data){
					$('#detalle'+id).html(data.detalle);
					return false;
				},'json');
			 }
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a class="mgbt1"><img src="imagenes/add2.png" title="Nuevo" /></a><a class="mgbt1"><img src="imagenes/guardad.png" title="Guardar"/></a><a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
          	</tr>	
		</table>
 		<form name="form2" method="post" action="hum-buscalibranzas.php">
			<table  class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="6">:. Buscar Descuentos de Nomina</td>
                    <td width="139" class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                    <td width="162" class="saludo1">CC/NIT:</td>
                    <td><input name="numero" type="text" value="" size="20" ></td>
                    <td width="131" class="saludo1">Nombre Empleado: </td>
                    <td ><input name="nombre" type="text" value="" size="80" ></td>
                    <input name="oculto" type="hidden" value="1">
                </tr>                       
    		</table>    
     	</form> 
        <div class="subpantallac5">
			<?php
				$oculto=$_POST['oculto'];
				if($_POST[oculto])
				{
					$crit1=" ";
					$crit2=" ";
					if ($_POST[numero]!=""){$crit1=" and humretenempleados.empleado like '%$_POST[numero]%' ";}
					if ($_POST[nombre]!=""){$crit2=" and humretenempleados.nombre like '%$_POST[nombre]%'  ";}
					//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
					$sqlr="select *from humretenempleados where humretenempleados.estado<>'' $crit1 $crit2 order by humretenempleados.id";
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$con=1;
					echo "
					<table class='inicio' align='center' >
						<tr><td colspan='12' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='2'>Variables Encontradas: $ntr</td></tr>
						<tr>
							<td class='titulos2'><img src='imagenes/plus.gif'></td>
							<td class='titulos2'>Codigo</td>
							<td class='titulos2'>Descripcion</td>
							<td class='titulos2'>CC/Nit</td>
							<td class='titulos2'>Empleado</td>
							<td class='titulos2'>Fecha</td>
							<td class='titulos2'>Valor</td>
							<td class='titulos2'>Valor Cuota</td>
							<td class='titulos2'>Cuotas Faltantes</td>
							<td class='titulos2'>Total Cuotas</td>
							<td class='titulos2'>HABILITADO</td>
							<td class='titulos2' width='5%'><center>Anular</td>
							<td class='titulos2' width='5%'><center>Editar</td>
						</tr>";	
					//echo "nr:".$nr;<td class='titulos2'>Fecha</td>
					$iter='saludo1a';
					$iter2='saludo2';
 					while ($row =mysql_fetch_row($resp)) 
 					{
	 					$nemp=buscatercero($row[4]);
						echo "
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
							<td class='titulos2'>
								<a onClick='detalleslibranzas($con, $row[0])' style='cursor:pointer;'>
									<img id='img$con' src='imagenes/plus.gif'>
								</a>
							</td>
							<td>$row[0]</td>
							<td>$row[1]</td>
							<td>$row[4]</td>
							<td>$nemp</td>
							<td>$row[3]</td>
							<td>$row[5]</td>
							<td>$row[8]</td>
							<td>$row[7]</td>
							<td>$row[6]</td>
							<td>$row[10]</td>
							<td><a href='#'><center><img src='imagenes/anular.png'></center></a></td>
							<td><a href='hum-editalibranzas.php?idr=$row[0]'><center><img src='imagenes/buscarep.png'></center></a></td>
						</tr>";
	 					$con+=1;
	 					$aux=$iter;
	 					$iter=$iter2;
	 					$iter2=$aux;
 					}
 					echo"</table>";
				}
			?>
        </div>
	</body>
</html>