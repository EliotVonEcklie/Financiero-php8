<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$_POST[oculto]="2";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>	
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			//************* ver reporte ************
			//***************************************
			$(window).load(function () { $('#cargando').hide();});
		
			function buscar()
			{
				document.form2.submit(); 
			}
	
			function verUltimaPos(idcta){
				location.href="teso-editaidentificar.php?idrecaudo="+idcta+"#";
			}
		</script>
		
		<script type="text/javascript" src="css/calendario.js"></script>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<?php titlepag();
			$gidcta=$_GET['idcta'];
		?>
	</head>
	<body>
	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
	<span id="todastablas2"></span>
	<table>
		<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("teso");?></tr>
		<tr>
	  		<td colspan="3" class="cinta">
	  			<a href="teso-identificar.php" class="mgbt">
					<img src="imagenes/add.png" alt="Nuevo" border="0"/>
				</a>
				<a href="#" class="mgbt1">
					<img src="imagenes/guardad.png"  alt="Guardar" />
				</a>
	  			<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" alt="Buscar" /></a> 
	  			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
	  		</td>
	  	</tr>	
	</table>
	<form name="form2" method="post" action="teso-buscaidentificar.php">
		<div class="loading" id="divcarga"><span>Cargando...</span></div>
		<table  class="inicio" align="center" >
			<tr>
				<td class="titulos" colspan="6">:. Buscar Comprobantes Identificados</td>
				<td width="70" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
			</tr>
			<tr >
				<td width="168" class="saludo1">Numero Ingreso:</td>
				<td width="154" ><input name="numero" type="text" value="" ></td>
				<td width="144" class="saludo1">Concepto Ingreso: </td>
				<td width="498" ><input name="nombre" type="text" value="" size="80" ></td>
				<input name="oculto" type="hidden" value="2">
				<td style=" padding-bottom: 0em"><em class="botonflecha" onClick="buscar()">Buscar</em></td>
			</tr>                       
		</table>    
		<div class="subpantallap">
			<?php
				$oculto=$_POST['oculto'];
				if($_POST[oculto]==2)
				{
					$oculto=$_POST['oculto'];
					$crit1=" ";
					$crit2=" ";
					if ($_POST[numero]!="")
					$crit1=" and tesoidentificar.id  like '%".$_POST[numero]."%' ";
					if ($_POST[nombre]!="")
					$crit2=" and tesoidentificar.concepto like '%".$_POST[nombre]."%'  ";

					$sqlr="select *from tesoidentificar where tesoidentificar.id>-1 ".$crit1.$crit2." group by tesoidentificar.id order by tesoidentificar.id desc";

					// echo "<div><div>sqlr:".$sqlr."</div></div>";
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$con=1;

					echo "<table class='inicio' align='center' >
							<tr>
								<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
							</tr>
							<tr>
								<td colspan='2'>Ingresos Encontrados: $ntr</td>
							</tr>
							<tr>
								<td width='5%' class='titulos2'>Codigo</td>
								<td class='titulos2'>Nombre</td><td class='titulos2'>Fecha</td>
								<td class='titulos2'>Contribuyente</td>
								<td class='titulos2'>Valor</td><td class='titulos2'>Estado</td>
								<td class='titulos2' width='5%'><center>Ver</td>
							</tr>";	
							//echo "nr:".$nr;
							$iter='saludo1a';
							$iter2='saludo2';
							while ($row =mysql_fetch_row($resp)) 
							{
								$nter=buscatercero($row[7]);
								if($row[10]=='S')
									$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'"; 	 				  
								if($row[10]=='N')
                                    $imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";
                                if($row[10]=='R')
									$imgsem="src='imagenes/reversado.png' title='Inactivo'";
								else 
									$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'"; 	 		
								if($gidcta!=""){
									if($gidcta==$row[0]){
										$estilo='background-color:yellow';
									}
									else{
										$estilo="";
									}
								}
								else{
									$estilo="";
								}		 	
								echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\"	onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($row[0])\" style='text-transform:uppercase; $estilo' >
										<td>$row[0]</td>
										<td>$row[6]</td>
										<td>$row[2]</td>
										<td>$nter</td>
										<td>".number_format($row[9],2)."</td>
										<td style='text-align:center;'><img $imgsem style='width:18px' ></td>";
										echo "<td><a href='teso-editaidentificar.php?idrecaudo=$row[0]'><center><img src='imagenes/lupa02.png' style='width:18px;'></center></a></td>
									</tr>";
								 	$con+=1;
								 	$aux=$iter;
								 	$iter=$iter2;
								 	$iter2=$aux;
							}
						 	echo"</table><script>document.getElementById('divcarga').style.display='none';</script>";
				}	
			?>
	    	
		</div>
	</form> 
</body>
</html>