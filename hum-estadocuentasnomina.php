<?php
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
        <script>
			function procesos(){document.form2.oculto.value='2';document.form2.submit();}
		</script>
		<?php titlepag(); ?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("hum");?></tr>
		</table>
		<form name="form2" method="post" action="">
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="7">ARREGLO CACHARROS VARIOS</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
			</table>
            <div class="tabscontra" style="height:63.5%; width:99.6%;">
			<table class="inicio">
				<tr>
					<td class="titulos" style='width:12%'>Cuenta</td>
                    <td class="titulos">Descripci&oacute;n</td>
					<td class="titulos" style='width:12%'>Tipos</td>
					<td class="titulos" style='width:5%'>CC</td>
					<td class="titulos" style='width:12%'>Valor Egresos</td>
                    <td class="titulos" style='width:12%'>Saldo Presupuesto</td>
				</tr>
				<?php
					$iter="zebra1";
					$iter2="zebra2";
					$sqlr="SELECT T1.cuentap,GROUP_CONCAT(DISTINCT T1.tipo ORDER BY T1.tipo ASC SEPARATOR '-'),GROUP_CONCAT(DISTINCT T1.cc ORDER BY T1.cc ASC SEPARATOR '-'),SUM( T1.valor ) FROM tesoegresosnomina_det T1 INNER JOIN tesoegresosnomina T2 ON T1.id_egreso = T2.id_egreso
AND T2.estado =  'S' AND T2.vigencia='2018' GROUP BY T1.cuentap"; 
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$vsal=generaSaldo($row[0],'2018','2018');
						$ncta=existecuentain($row[0]);
						if($vsal<0){$estilo='background-color:#FF9'; }
						else {$estilo='';}
						echo"
						<tr class='$iter' style='text-transform:uppercase; $estilo'>
							<td>$row[0]</td>
							<td>$ncta</td>
							<td>$row[1]</td>
							<td>$row[2]</td>
							<td style='text-align:right;'>$".number_format($row[3],0,',','.')."</td>
							<td style='text-align:right;'>$".number_format($vsal,0,',','.')."</td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
					}
				?>
			</table>
            </div>
			<input type="hidden" name="oculto" id="oculto" value="1"/> 
           
		</form>
	</body>
</html>