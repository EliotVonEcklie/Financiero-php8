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
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script src="css/programas.js"></script>
        <script>
			function pdf()
			{
				document.form2.action="teso-estratificacionpdf.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="teso-estratificacionexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
            <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>
            <tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
				<a href="teso-estratificacion.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
				<a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a>
				<a href="#"  onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a></td>
			</tr>
		</table>
		<form  name="form2" method="post" action="teso-estratificacionbuscar.php">
			<table  class="inicio" align="center">
     			<tr>
                	<td class="titulos" colspan="6" style='width:93%'>:. Buscar Informaci&oacute;n de Predios</td>
                	<td class="cerrar" style='width:7%'><a href="teso-principal.php">Cerrar</a></td>
              	</tr>
              	<tr>
                	<td class="saludo1" style='width:10%'>Codigo Catastral:</td>
                	<td style='width:20%'><input type="text" name="codigoc" value="" style="width:95%"></td>
                    <td class="saludo1" style='width:10%'>Propietario:</td>
                	<td style='width:20%'><input type="text" name="propietc" value="" style="width:95%"></td>
                    <td class="saludo1" style='width:10%'>Tipo:</td>
                	<td>
                    <select name="tipop"  id="tipop" value="<?php echo $_POST[tipop]; ?>">
			          <option value="">Seleccione ...</option>
				        <?php
						$linkbd=conectar_bd();
						$sql="SELECT codigo,nombre FROM teso_clasificapredios GROUP BY codigo,nombre";
						//ECHO "hola".$sql;
						$result=mysql_query($sql,$linkbd);
						$check="";
						if(isset($_POST[codigo])){
							if(!empty($_POST[codigo])){
							$check="SELECTED";
							}
						}
						while($row = mysql_fetch_array($result)){
							if(!empty($check)){
								if($row[0]==$_POST[codigo]){
									echo "<option value='$row[0]' $check >$row[1]</option>";
								}else{
									echo "<option value='$row[0]'>$row[1]</option>";
								}
							}else{
								echo "<option value='$row[0]'>$row[1]</option>";
							}
						}

					?>
				</select>
				<input type="hidden" name='codigo' id="codigo" value="<?php echo $_POST[codigo]; ?>" />
                    </td>
                  	<input name="oculto" type="hidden" value="1">
                </tr>
    		</table>
			<div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
            <?php
			function obtenerNombre($codigo,$tipo){
					global $linkbd;
					$sql="SELECT nombre,nom_rango FROM teso_clasificapredios WHERE codigo=$codigo LIMIT 0,1";
					$res=mysql_query($sql,$linkbd);
					$row = mysql_fetch_row($res);
					if($tipo==0){
						return $row[0];
					}else{
						return $row[1];
					}

				}

				if($_POST[oculto])
				{
					$crit1=" ";
					$crit2=" ";
					$crit3=" ";
					if ($_POST[codigoc]!=""){$crit1="WHERE cedulacatastral like '%".$_POST[codigoc]."%' ";}
					if ($_POST[propietc]!="")
					{
						if ($_POST[codigoc]!=""){$crit2="AND nombrepropietario like '%".$_POST[propietc]."%' ";}
						else {$crit2="WHERE nombrepropietario like '%".$_POST[propietc]."%' ";}
					}
					if ($_POST[tipop]!="")
					{
						if (($_POST[codigoc]!="")||($_POST[propietc]!="")){$crit3="AND clasifica='$_POST[tipop]' ";}
						else {$crit3="WHERE clasifica='$_POST[tipop]' ";}
					}
					$sqlr="SELECT * FROM tesopredios $crit1 $crit2 $crit3 ORDER BY cedulacatastral DESC";
					// echo $sqlr. "<br>";
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$con=1;
					$iter='saludo1a';
					$iter2='saludo2';
					echo "
					<table class='inicio'>
						<tr><td colspan='11' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='11'>Informaci&oacute;n de Predios Encontrados: $ntr</td></tr>
						<tr>
							<td class='titulos2'>Item</td>
							<td class='titulos2'>Codigo Catastral</td>
							<td class='titulos2'>Avaluo</td>
							<td class='titulos2'>Propietario</td>
							<td class='titulos2'>Direcci&oacute;n</td>
							<td class='titulos2'>Ha</td>
							<td class='titulos2'>Mt&sup2;</td>
							<td class='titulos2'>Area Cons</td>
							<td class='titulos2'>Tipo</td>
							<td class='titulos2'>Estratos o Rangos Avaluo</td>
							<td class='titulos2'>Clasificacion</td>
						</tr>";
					while ($row =mysql_fetch_row($resp))
					{
						if($row[15]=="rural")
						{
							$sqlm="select inicial,final from rangoavaluos where id='$row[16]'";
							$rowm =mysql_fetch_row(mysql_query($sqlm,$linkbd));
							$estrato="Entre $rowm[0] - $rowm[1] SMMLV";
						}
						else{$estrato=$row[16];}
					 	echo "
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
							<td>$con</td>
							<td>$row[0]</td>
							<td>$row[11]</td>
							<td>$row[6]</td>
							<td>$row[7]</td>
							<td>$row[8]</td>
							<td>$row[9]</td>
							<td>$row[10]</td>
							<td>".obtenerNombre($row[15],0)."</td>
							<td>".obtenerNombre($estrato,1)."</td>
							<td>$row[14]</td>
						</tr>
						<input type='hidden' name='codcath[]' value='$row[0]'>
						<input type='hidden' name='avaluoh[]' value='$row[11]'>
						<input type='hidden' name='documeh[]' value='$row[5]'>
						<input type='hidden' name='propieh[]' value='$row[6]'>
						<input type='hidden' name='direcch[]' value='$row[7]'>
						<input type='hidden' name='hah[]' value='$row[8]'>
						<input type='hidden' name='mt2h[]' value='$row[9]'>
						<input type='hidden' name='areconh[]' value='$row[10]'>
						<input type='hidden' name='tipoh[]' value='$row[15]'>
						<input type='hidden' name='estrath[]' value='$estrato'>
						";
						$con+=1;
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;

					}
				}
			?>
			</div>
		</form>
</body>
</html>