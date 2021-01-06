<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<title>:: SPID - Tesoreria</title>
	
	<script src="JQuery/jquery-2.1.4.min.js"></script>
	<link href="css/css2.css" rel="stylesheet" type="text/css" />
	<link href="css/css3.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="css/programas.js"></script>
    <script type="text/javascript" src="css/calendario.js"></script>
	<?php titlepag();?>
	<script type="text/javascript">
		function buscar() {
		// alert("dsdd");
		document.form2.oculto.value='1';
		document.form2.submit();
		}
		 function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="catastral-ventana01.php";}
			}
	</script>
</head>
	<body>
		
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
				<td colspan="3" class="cinta">
				<a href="teso-predialactualizar.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
				<a href="#"  onClick="guardar();" class="mgbt" ><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a> 
				<a href="#" onClick="buscar()" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
				<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a> 
				<a href="teso-gestionpredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
			</tr>		  
		</table>

		<form  name="form2" method="post" action="">
			<table class="inicio" align="center" >
				<tr >
					<td class="titulos" colspan="6">.: Actualizar Predios</td>
					<td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
				</tr>

				<tr> 
					<td  class="saludo1" style="width:10%;">C&oacute;digo Catastral:</td>
					<td >
						<input id="codcat" type="text" name="codcat"  onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" onClick="document.getElementById('codcat').focus();document.getElementById('codcat').select();">
						<input id="ord" type="hidden" name="ord"   value="<?php echo $_POST[ord]?>" style="width:5%;" readonly>
						<input id="tot" type="hidden" name="tot"  value="<?php echo $_POST[tot]?>" style="width:5%;" readonly> 
						<input type="hidden" value="0" name="oculto" id="oculto"> 
						<a title="Listado de Predios" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"/></a>
						<input type="button" name="buscarb" id="buscarb" value="Buscar" onClick="buscar()" >
					</td>
				</tr>
			</table>
		
		
		<div  class="subpantalla" style="height:55.5%; width:99.6%; ">
			<table class="inicio" id='tablaPropietarios' >
				<tr>
					<td class="titulos" colspan="16">Historial Predio</td>
				</tr>
				<tr>
					<td class="titulos2" style="width:3%">No Resoluci&oacute;n</td>
	            	<td class="titulos2" style="width:8%">Fecha Res</td>
	            	<td class="titulos2" style="width:15%">Detalle</td>
	            	<td class="titulos2" style="width:3%">Tot</td>
	            	<td class="titulos2" style="width:3%">Ord</td>
	            	<td class="titulos2" style="width:3%">Tipo Doc</td>
	            	<td class="titulos2" style="width:8%">Documento</td>
	            	<td class="titulos2" style="width:12%">Nombres Propietarios</td>
	            	<td class="titulos2" style="width:8%">Direccion</td>
	            	<td class="titulos2" style="width:8%">Avaluo</td>
	            	<td class="titulos2" style="width:5%">Area Const.</td>
	            	<td class="titulos2" style="width:5%">Ha.</td>
	            	<td class="titulos2" style="width:5%">Met2.</td>
	            	<td class="titulos2" style="width:3%">Vigencia</td>
	            	<td class="titulos2" style="width:8%">Fecha, hora. Act.</td>
	            	<td class="titulos2">Accion</td>
	          	</tr>
	          	<?php
					$linkbd=conectar_bd();
					if ($_POST[oculto]==1) {					
						$saludo1 = 'saludo1a';
						$saludo2 = 'saludo2';
						$sqlr="SELECT * FROM tesopredioshistorico WHERE cedulacatastral='$_POST[codcat]' order by fecha desc";
						$res = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_array($res)){
							echo '<tr class="'.$saludo1.'">';
							echo '<td style="width:3%">'.$row[numresolucion].'</td>';
							echo '<td style="width:8%">'.$row[fecharesolucion].'</td>';
							echo '<td style="width:15%">'.$row[descripcionreso].'</td>';
							echo '<td style="width:3%">'.$row[tot].'</td>';
							echo '<td style="width:3%">'.$row[ord].'</td>';
							echo '<td style="width:3%">'.$row[d].'</td>';
							echo '<td style="width:8%">'.$row[documento].'</td>';
							echo '<td style="width:12%">'.$row[nombrepropietario].'</td>';					
							echo '<td style="width:8%">'.$row[direccion].'</td>';					
							echo '<td style="width:8%">'.$row[avaluo].'</td>';
							echo '<td style="width:5%">'.$row[areacon].'</td>';
							echo '<td style="width:5%">'.$row[ha].'</td>';
							echo '<td style="width:5%">'.$row[met2].'</td>';
							echo '<td style="width:5%">'.$row[vigencia].'</td>';
							echo '<td style="width:8%">'.$row[fecha].'</td>';
							echo '<td style="width:8%">'.$row[accion].'</td>';
							echo '</tr>';
							$aux=$saludo1;
							$saludo1=$saludo2;
							$saludo2=$aux;	
						}
					}
					
				?>
				
      	</div>
		<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
		</form>
	      	</table>
		
	</body>
</html>