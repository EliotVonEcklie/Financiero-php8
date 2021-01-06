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
        <title>:: SPID - Administracion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script>
		//************* ver reporte ************
		//***************************************
		function guardar(idfac)
		{
		if (document.form2.ages.value!='')
		  {
			if (confirm("Esta Seguro de Guardar"))
			{
			document.form2.oculto.value=2;
			document.form2.submit();
			}
		  }
		  else
		  {
			alert("No hay vigencia nueva seleccionada");
		  }
		}
		//************* genera reporte ************
		//***************************************
		function genrep(idfac)
		{
		  document.form2.oculto.value=idfac;
		  document.form2.submit();
		  }
		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
            <tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>
            <tr><?php menu_desplegable("adm");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="adm-iniciage.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
         	</tr>
  		</table>
		<?php
			if(!$_POST[oculto])
			{
 				$sqlr="select *from parametros where estado='S'";
 				$res=mysql_query($sqlr,$linkbd);
 				while($r=mysql_fetch_row($res)){$_POST[vigenciaact]=$r[1];}
			}
		?>
 		<form name="form2" method="post" action="">
  			<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="2">Informacion Vigencia </td>
                    <td style='width:7%' class="cerrar" ><a href="adm-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                    <td width="109" class="saludo1" >Vigencia Actual :</td>
                    <td width="343" ><input name="vigenciaact" type="text" id="vigenciaact" size="5" value="<?php echo $_POST[vigenciaact]?>" readonly> <input name="oculto" type="hidden" id="oculto" value="1"> </td>
                </tr>
         		<tr>
      				<td width="109" class="saludo1" >Crear Vigencia:</td>
      				<td width="343" >
                    	<select name="ages">
      						<option value="">Seleccione...</option>
      						<?php
										$x=$_POST[vigenciaact]+1;
      							echo "<option value='$x' >$x</option>";
      						?>
      					</select>
                	</td>
    			</tr>
  			</table>
		</form>
		<?php
			$oculto=$_POST['oculto'];
			if($_POST[oculto])
			{
				$sqlr="select count(*) from parametros where vigencia='".$_POST[ages]."'";
				$resp=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($resp);
				$ntr=$r[0];
				$sqlr="update parametros set estado='N' where vigencia='$_POST[vigenciaact]'";
				mysql_query($sqlr,$linkbd);
				if ($ntr>0){$sqlr="update parametros set estado='S' where vigencia='$_POST[ages]'";}
				else{$sqlr="insert into parametros (vigencia,estado) values ('$_POST[ages]','S')";}
				if(!mysql_query($sqlr,$linkbd))
  				{
	  				echo "<table class='inicio'><tr><td class='saludo1'><img src='imagenes\alert.png'> Error no se pudo actualizar $sqlr</td></tr></table>";
  				}
  				else
  				{
					  echo "<table class='inicio'><tr><td class='saludo1'>Se ha Actualizado con Exito: Vigencia $_POST[ages]  <img src='imagenes\confirm.png'></td></tr></table>";
					  //**** parametriza los ingresos en la nueva vigencia */
					  $sqlrin="select *from tesoingresos INNER JOIN tesoingresos_det ON tesoingresos.codigo=tesoingresos_det.codigo where   tesoingresos_det.modulo=4 and vigencia='$_POST[ages]' ORDER BY  tesoingresos_det.cuentapres";
					//   echo $sqlrin;
					  $cont=0;
					  //echo "v:".count($_POST[dcuentas]);
					  $resp = mysql_query($sqlrin,$linkbd);
					  if(mysql_affected_rows()<=0)
					  {
					   $sqlri="insert into tesoingresos_det (codigo,concepto,modulo,tipoconce,porcentaje,estado,vigencia)  select distinct codigo,concepto,modulo,tipoconce,porcentaje,estado,'$_POST[ages]' from tesoingresos_det where   vigencia='$_POST[vigenciaact]' order by vigencia desc ";
					    // echo $sqlri;
					   mysql_query($sqlri,$linkbd);
					//    $sqlr="select *from tesoingresos INNER JOIN tesoingresos_det ON tesoingresos.codigo=tesoingresos_det.codigo where   tesoingresos_det.modulo=4 and tesoingresos.codigo='$_POST[codigo]' and vigencia='$vigusu' ORDER BY  tesoingresos_det.cuentapres";
					//    $resp = mysql_query($sqlr,$linkbd);
					  }
					  //****** fin parametrizacion */



  				}
			}
		?>
	</body>
</html>
