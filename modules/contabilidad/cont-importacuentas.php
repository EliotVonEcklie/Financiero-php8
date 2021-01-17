<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
		<title>:: Ideal</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function pdf()
			{
				document.form2.action="pdfbalance.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}

			function protocolofmt()
			{
				document.form2.action="formatos/FMT_PLAN_DE_CUENTAS_CGR.csv";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}

			function validar()
			{
				document.form2.oculto.value=2;
				document.form2.submit(); 
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
	<span id="todastablas2"></span>
	<table>
		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("cont");?></tr>
		<tr>
			<td colspan="3" class="cinta">
				<a href="cont-importacuentas.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
				<a href="cont-vercuentascgr.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
				<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" style="width:29px;height:25px;" title="Imprimir"></a>
				<a href="<?php echo "formatos/FMT_PLAN_DE_CUENTAS_CGR.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" style="width:29px;height:25px;"   title="csv"></a>
				<a href="cont-gestioninformecgr.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
			</td>
		</tr>
	</table>
	<form action="cont-importacuentas.php" method="post" enctype="multipart/form-data" name="form2">
		<table  align="center" class="inicio" >
			<tr >
				<td class="titulos" colspan="5">.: Importar Cuentas CGN</td>
				<td width="72" class="cerrar"><a href="cont-principal.php">X Cerrar</a></td>
			</tr>   
			<tr> 
				<td width="142"  class="saludo1">Seleccione Archivo: </td>
				<td width="273" >
					<input type="file" name="archivotexto" id="archivotexto">
				</td>
				<td width="555" >
					<input type="button" name="generar" value="Cargar Archivo" onClick="validar()">
					<input name="oculto" type="hidden" value="1">  
					<input type="button" name="protocolo" value="Descargar Protocolo Importacion" onClick="protocolofmt()" >
				</td>
			</tr>                  
		</table>
    	<div class="subpantalla" style="height:63.5%; width:99.6%; overflow-x:hidden;">
			<?php
			//**** para sacar la consulta del balance se necesitan estos datos ********
			//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
			$oculto=$_POST['oculto'];
			echo "<table class='inicio'>
				<tr>
					<td class='titulos2' style='width:5%;'>RESULTADO</td>
					<td class='titulos2' style='width:15%;'>C&Oacute;DIGO</td>
					<td class='titulos2' style='width:80%;'>NOMBRE CUENTA</td>
				</tr>";
				$iter='saludo1a';
				$iter2='saludo2';
				if($_POST[oculto]==2)
				{
					$subio='';
					if(is_uploaded_file($_FILES['archivotexto']['tmp_name']))
					{
						$archivo = $_FILES['archivotexto']['name'];
						$archivoF = "./archivos/$archivo";
						if(move_uploaded_file($_FILES['archivotexto']['tmp_name'],$archivoF))
						{
							//echo "El archivo se subio correctamente";
							$subio=1;
						}
					}
					$linkbd=conectar_bd();
					//$contenido = fopen($fich,"r+"); 
					//Borrar el balance de prueba anterior
					if($archivo)
					{
						$sqlr="Delete from chipcuentas";
						mysql_query($sqlr,$linkbd);
						$fich=$archivoF;
						echo "Archivo: $fich <br>";
						$contenido = fopen($fich,"r+"); 
						$exito=0;
						$errores=0;
						$co='saludo1';
						$co2='saludo2';
						while(!feof($contenido))
						{ 
							$buffer = fgets($contenido,4096);
							$datos = explode(";",$buffer);
							$tama=count($datos);
							if($datos[0]!='' && true==is_numeric($datos[0]) && $tama=='2' && strlen($datos[0])<=6)
							{
								$consulta = "INSERT INTO chipcuentas (cuenta,nombre) VALUES ('".trim($datos[0])."','".trim(ucfirst(strtolower($datos[1])))."')"; 
								if (!mysql_query($consulta,$linkbd))
								{
									$errores+=1;
									echo "<tr class='$co'><td><img src='imagenes\alert.png'></td><td>".trim($datos[0])."</td><td>".trim(ucfirst(strtolower($datos[1])))."</td></tr>"; 
								}
								else
								{
									echo "<tr class='$co'><td><img src='imagenes\confirm.png'></td><td>".trim($datos[0])."</td><td>".trim(ucfirst(strtolower($datos[1])))."</td></tr>";
									$exito+=1;
								}
								$aux=$co;
								$co=$co2;
								$co2=$aux;
							}	
						}
						echo "<tr><td class='saludo1'><center>Se han Insertado con Exito: $exito <img src='imagenes/confirm.png' ></center></td></tr>"; 
						echo "<tr><td class='saludo1'><center>Errores: $errores <img src='imagenes/alert.png' ></center></td></tr>"; 
					}
					else
					{
						echo "<div class='inicio'>NO SE PUDO CARGAR EL ARCHIVO <img src='imagenes\alert.png'></div>";  
					}
				}
				else{
					$sql="select * from chipcuentas order by cuenta";
					$res=mysql_query($sql, $linkbd);
					while($row=mysql_fetch_array($res)){
						echo"<tr  class='$iter'>
							<td style='width:5%;'></td>
							<td style='width:15%;'>".$row[0]."</td>
							<td style='width:40%;'>".$row[1]."</td>
						</tr>";
						$aux=$iter;
                        $iter=$iter2;
                        $iter2=$aux;
					}
				}
			echo "</table>"; 
			?> 
		</div>
	</form>
</body>
</html>