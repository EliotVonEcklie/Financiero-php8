<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<title>:: SPID - Tesoreria</title>

	<script>
		//************* ver reporte ************
		//***************************************
		function verep(idfac)
		{
			document.form1.oculto.value=idfac;
			document.form1.submit();
		}
	</script>
	<script>
		//************* genera reporte ************
		//***************************************
		function genrep(idfac)
		{
			document.form2.oculto.value=idfac;
			document.form2.submit();
		}
	</script>
	<script>
		function buscacta(e)
		{
			if (document.form2.cuenta.value!="")
			{
				document.form2.bc.value='1';
				document.form2.submit();
			}
		}
	</script>
	<script language="JavaScript1.2">
		function validar()
		{
			document.form2.submit();
		}
	</script>
	<script>
		function buscatercero(e)
		{
			if (document.form2.tercero.value!="")
			{
				document.form2.bc.value='1';
				document.form2.submit();
			}
		}
	</script>
	<script>
		function agregardetalle()
		{
			if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
			{ 
				document.form2.agregadet.value=1;
				//document.form2.chacuerdo.value=2;
				document.form2.submit();
			}
			else 
			{
				alert("Falta informacion para poder Agregar");
			}
		}
	</script>
	<script>
		//************* genera reporte ************
		//***************************************
		function eliminar(idr)
		{
			if (confirm("Esta Seguro de Eliminar El Egreso No "+idr))
			{
				document.form2.oculto.value=2;
				document.form2.var1.value=idr;
				document.form2.submit();
			}
		}
	</script>
	<script>
		//************* genera reporte ************
		//***************************************
		function guardar()
		{
			if (document.form2.fecha.value!='')
			{
				if (confirm("Esta Seguro de Guardar"))
				{
					document.form2.oculto.value=2;
					document.form2.submit();
				}
			}
			else
			{
				alert('Faltan datos para completar el registro');
				document.form2.fecha.focus();
				document.form2.fecha.select();
			}
		}
	</script>
	<script>
		function pdf()
		{
			document.form2.action="pdfreporegresos.php";
			document.form2.target="_BLANK";
			document.form2.submit(); 
			document.form2.action="";
			document.form2.target="";
		}
	</script>
	<script src="css/programas.js"></script>
	<script src="css/calendario.js"></script>
	<link href="css/css2.css" rel="stylesheet" type="text/css" />
	<link href="css/css3.css" rel="stylesheet" type="text/css" />
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
				<a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo" /></a>
				<a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" /></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
				<a href="teso-reportenotasbancariasexcell.php?notaban=<?php echo $_POST[nbancarias]?>&fecha1=<?php echo $_POST[fecha1]?>&fecha2=<?php echo $_POST[fecha2]?>" target="_blank"><img src="imagenes/excel.png"  class="mgbt" alt="excel"></a>
				<a href="teso-informestesoreria.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
			</td>
		</tr>	
	</table>
	<tr><td colspan="3" class="tablaprin"> 
	<form name="form2" method="post" action="teso-reportenotasbancarias.php">
		<?php
		if($_POST[bc]=='1')
		{
			$nresul=buscatercero($_POST[tercero]);
			if($nresul!='')
			{
				$_POST[ntercero]=$nresul;
			}
			else
			{
				$_POST[ntercero]="";
			}
		}
		?>
		<table  class="inicio" align="center" >
			<tr >
				<td class="titulos" colspan="8">:. Buscar Pagos</td>
				<td width="139" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
			</tr>
			<tr>      
				<td class="saludo1">Notas Bancarias:</td>
				<td style="width:25%;" >
					<select name="nbancarias" style="width:100%;" onKeyUp='return tabular(event,this)'>
						<option value="">Seleccion Nota Bancarias</option>	  
						<?php
							$link=conectar_bd();
							$sqlr="Select * from tesogastosbancarios  where estado='S' order by codigo";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								$i=$row[0];
								echo "<option value=$row[0] ";
								if($i==$_POST[nbancarias])
								{
									$_POST[ntipocomp]=$row[1];
									echo "SELECTED";
								}
								echo " >".$row[0]." - ".$row[1]."</option>";	  
							}								
						?>
					</select>
					<input name="clasecomp" type="hidden" value="<?php echo $_POST[clasecomp]?>">
				</td>
				<td  class="saludo1">Fecha Inicial:</td>
				<td><input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias">
				<input name="fecha1" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>        </td>
				<td class="saludo1">Fecha Final: </td>
				<td ><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>  <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto"></td>
			</tr>                    
			<?php 
			if($_POST[bc]=='1')
			{
				$nresul=buscatercero($_POST[tercero]);
				if($nresul!='')
				{
					$_POST[ntercero]=$nresul;
					?>
					<script>
						document.form2.fecha.focus();document.form2.fecha.select();
					</script>
					<?php
				}
				else
				{
					$_POST[ntercero]="";
					?>
					<script>
						alert("Tercero Incorrecta");document.form2.tercero.focus();
					</script>
					<?php
				}
			}
			?>
		</table>  
		<div class="subpantallap">
			<?php	  
			$oculto=$_POST['oculto'];
			if($_POST[oculto])
			{
				$linkbd=conectar_bd();
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha1],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
				$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
				$crit1=" ";
				$crit2=" ";
				$crit20="";
				$crit21="";
				if ($_POST[nbancarias]!="")
				{
					$crit1=" and tesonotasbancarias_det.gastoban like '%".$_POST[nbancarias]."%' ";
				}
				if($_POST[fecha1]!="" && $_POST[fecha2]!="")
				{
					$crit2=" and tesonotasbancarias_cab.fecha between '$fechaf' AND '$fechaf2'";
				}
				//sacar el consecutivo 
				$sqlr="select *from tesonotasbancarias_cab,tesonotasbancarias_det where tesonotasbancarias_cab.id_notaban=tesonotasbancarias_det.id_notabancab and tesonotasbancarias_cab.estado<>'' ".$crit1.$crit2." order by tesonotasbancarias_cab.id_notaban DESC";
				//echo "<div><div>sqlr:".$sqlr."</div></div>";
				$resp = mysql_query($sqlr,$linkbd);
				$ntr = mysql_num_rows($resp);
				$con=1;
				echo "
					<table class='inicio' align='center' >
						<tr>
							<td colspan='11' class='titulos'>.: Resultados Busqueda:</td>
						</tr>
						<tr>
							<td colspan='11' class='saludo3'>Pagos Encontrados: ".($ntr+$ntr2+$ntr3+$ntr4)."</td>
						</tr>
						<tr>
							<td class='titulos2'>No Nota Bancaria</td>
							<td class='titulos2'>Fecha</td>
							<td class='titulos2'>Concepto Nota Bancaria</td>
							<td class='titulos2'>Valor</td>
							<td class='titulos2'>Cuenta bancaria</td>
							<td class='titulos2'>Nombre cuenta</td>
							<td class='titulos2' width='3%'><center>Estado</td>
						</tr>";	
						//echo "nr:".$nr;
						$iter='saludo1';
						$iter2='saludo2';
						while ($row =mysql_fetch_row($resp)) 
						{
							if($row[4]=='S')
								$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'"; 	 				  
							if($row[4]=='N')
								$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";
							$sqlr="Select sum(valor),ncuentaban from tesonotasbancarias_det where id_notabancab=$row[0]";
							$resn=mysql_query($sqlr,$linkbd);
							$rn=mysql_fetch_row($resn);
							$sqlr1="select *from tesobancosctas tb1,cuentas tb2 where tb1.cuenta=tb2.cuenta and tb1.ncuentaban='$rn[1]'";
							$res1=mysql_query($sqlr1,$linkbd);
							$rn1=mysql_fetch_assoc($res1);
							echo "
								<tr class='$iter'>
									<td >
										<input type='hidden' name='idnota[]' value='$row[0]'>$row[0]
									</td>
									<td >
										<input type='hidden' name='fecha[]' value='$row[2]'>$row[2]
									</td>
									<td >
										<input type='hidden' name='concepto[]' value='$row[5]'>$row[5]
									</td>
									<td >
										<input type='hidden' name='valor[]' value='$rn[0]'>".number_format($rn[0],0)."
									</td>
									<td >
										<input type='hidden' name='banco[]' value='".$rn1["ncuentaban"]."'>".$rn1["ncuentaban"]."
									</td>
									<td >
										<input type='hidden' name='nbanco[]' value='".$rn1["nombre"]."'>".$rn1["nombre"]."
									</td>
									<td style='text-align:center;'><img $imgsem style='width:18px' ></td>
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
	</form>
	</td></tr>   
</body>
</html>