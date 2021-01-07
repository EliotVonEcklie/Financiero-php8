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
        <meta http-equiv="Content-Type" content="text/html" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<?php titlepag();?>
		<script>
		$(window).load(function () { $('#cargando').hide();});
		function generar()
		{
			document.form2.genbal.value=1;
			//document.form2.gbalance.value=0;
			document.form2.submit();
		}
		function eliminar(variable)
		{
			if (confirm("Esta Seguro de Eliminar"))
			{
				document.form2.elimina.value=variable;
				document.form2.submit();
			}
		}

		function agregardetalle()
		{
			if(document.form2.cuenta.value!="")
			{
				var cuentasAgregadas = document.getElementsByClassName("dcuentas");
				console.log(cuentasAgregadas);

				document.form2.agregadet.value=1;
				document.form2.oculto.value=9;
				//document.form2.submit();
			}
			else 
			{
				alert("Falta informacion para poder Agregar");
			}
		}

		function despliegamodal2(_valor,v)
		{
			document.getElementById("bgventanamodal2").style.visibility=_valor;
			if(_valor=="hidden"){
				document.getElementById('ventana2').src="";
				document.form2.submit();
			}
			else {
				
				if(v==1){
					document.getElementById('ventana2').src="cuentasin-ventana1.php";
				}
				else if(v==2)
				{
					document.getElementById('ventana2').src="cuentas-ventana2.php?fecha="+document.form2.fecha1.value;
				}
				else if(v==3)
				{
					document.getElementById('ventana2').src="cuentas-ventana3.php?fecha="+document.form2.fecha1.value;
				}
				else if(v==4)
				{
					document.getElementById('ventana2').src="cuentas-ventana4.php?fecha="+document.form2.fecha1.value;
				}
			}
		}

		function validar3(formulario)
		{
			if(document.form2.cuenta.value!="")
			{
				document.form2.action="cont-marcarcuentasreciprocas.php";
				document.form2.ncuen.value=1;
				document.form2.defecto.value='1';
				document.form2.submit();
			}
		}

		function guardar()
		{
			if (confirm("Esta Seguro de Guardar"))
			{
				document.form2.oculto.value=2;
				document.form2.submit();
			}
		}
		</script>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a onClick="location.href='#'" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
					<a onClick="location.href='#'" class="mgbt"><img src="imagenes/buscad.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a onClick="location.href='cont-gestioninformecgr.php'" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>		  
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" action="cont-marcarcuentasreciprocas.php"  method="post" enctype="multipart/form-data" >
			<div class="loading" id="divcarga"><span>Cargando...</span></div>
 			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				if($_POST[reglas]==1){$chkchip=" checked";}
 				else {$chkchip=" ";}
				if(!$_POST[oculto])
				{
					$_POST[oculto]=1;
					echo"<script>document.getElementById('divcarga').style.display='none';</script>";
				}
				if($_POST[oculto] == 1)
				{
					echo"<script>document.getElementById('divcarga').style.display='none';</script>";
				}
   				$vact=$vigusu;  
	  			//*** PASO 2		  
				$sqlr="select *from configbasica where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
	 			{
  					$_POST[nitentidad]=$row[0];
  					$_POST[entidad]=$row[1];
					$_POST[codent]=$row[8];
				 }
				if($_POST[ncuen]==1)
				{
					if(!empty($_POST[cuenta]))
					{
						$sqlr="SELECT distinct nombre from cuentasnicsp where  cuenta like'%".$_POST[cuenta]."%' order by cuenta";
						$res=mysql_query($sqlr,$linkbd);
						$row = mysql_fetch_row($res);
						$_POST[ncuenta]=$row[0];
					}
					else
					{
						$_POST[ncuenta]="";
					}
				
				}
				if(($_POST[oculto]!="2")&&($_POST[oculto]!="9"))
				{
					unset($_POST[dcuentas]);
					unset($_POST[dncuentas]);
					$sqlr="SELECT cuenta FROM  cuentasreciprocas  WHERE estado='S' ORDER BY id desc";
					$res=mysql_query($sqlr,$linkbd); 
					$cont=0;
					while ($row=mysql_fetch_assoc($res)) 
					{
						$_POST[dcuentas][$cont]=$row["cuenta"];
						$_POST[dncuentas][$cont]=buscacuenta($row["cuenta"]);
						$cont=$cont+1;
					}
				}
	 		?> 
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto] ?>">
            <input type="hidden" name="periodo" id="periodo" value="<?php echo $_POST[periodo] ?>"> 
			<table class="inicio" align="center">
				<tr>
					<td class="titulos" colspan="10">Marcar cuentas reciprocas</td>
					<td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
				</tr>
				<tr>
					<td class="saludo1" style="width:8%">Cuenta: </td>
          			<td style="width:15%" valign="middle" >
						<input name="cuenta" id="cuenta" type="text"  value="<?php echo $_POST[cuenta]?>" onKeyUp="return tabular(event,this) " style="width:75%;" onBlur="validar3()" ondblclick="despliegamodal2('visible',1);">
						<input name="cuenta_" type="hidden" value="<?php echo $_POST[cuenta_]?>" >
						<input type="hidden" name="ncuen" value="<?php echo $_POST[ncuen]; ?>" />
					</td>
					<td>
						<input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" style="width:76%" readonly>
						<input name="defecto" type="hidden" value="<?php echo $_POST[defecto]?>">
					</td>
					<td><input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet">
				</tr>
			</table>
			<div class="subpantallap" style="height:60%; width:99.6%; overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="7">Detalle Cuentas reciprocas agregadas</td></tr>
					<tr>
						<td class="titulos2">Cuenta</td>
						<td class="titulos2">Nombre Cuenta</td>
						<td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
					</tr>
					<?php
					
					if ($_POST[elimina]!='')
		 			{ 
						$posi=$_POST[elimina];
						unset($_POST[dcuentas][$posi]);
						unset($_POST[dncuentas][$posi]);	 
						$_POST[dcuentas]= array_values($_POST[dcuentas]); 
						$_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 		 		 
		 			}
	
					if ($_POST[agregadet]=='1')
		 			{
						$_POST[dcuentas][]=$_POST[cuenta];
						$_POST[dncuentas][]=$_POST[ncuenta];
						echo "
							<script>
								document.form2.cuenta.value='';
								document.form2.ncuenta.value='';
							</script>";
		 				$_POST[agregadet]=0;
		 			}
		 			$iter='saludo1a';
		 			$iter2='saludo2';
		 			for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 			{
						echo "<tr class='$iter'>
							<td><input name='dcuentas[]' id='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='8' readonly class='inpnovisibles'></td>
							<td><input name='dncuentas[]' id='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='70' readonly class='inpnovisibles'></td>
							<td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
		 			}	 
		 			?>
				</table>
			</div>
			<?php
				echo "<script>document.getElementById('divcarga').style.display='none';</script>";
			?>
		</form>
		<?php 
		//********** GUARDAR EL COMPROBANTE ***********
		if($_POST[oculto]=='2')	
		{
			//rutina de guardado cabecera
			$linkbd=conectar_bd();
			$sql = "DELETE FROM cuentasreciprocas WHERE estado='S'";
			mysql_query($sql,$linkbd);
			//**** crear el detalle del concepto
			for($x=0;$x<count($_POST[dcuentas]);$x++) 
			{
				$sqlr="INSERT INTO cuentasreciprocas (cuenta,estado) VALUES ('".$_POST[dcuentas][$x]."','S')";
				$res=mysql_query($sqlr,$linkbd);
			}
			echo "<table class='inicio'><tr><td class='saludo1a'><center>Se ha Almacenado con Exito Las Cuenas Reciprocas</center></td></tr></table>";
			echo "<script>document.form2.oculto.value='';</script>";
	   }
	?>	
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
				</IFRAME>
			</div>
		</div>
	</body>