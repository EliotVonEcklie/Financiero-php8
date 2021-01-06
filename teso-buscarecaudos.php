<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag(@$_GET['codpag'],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Eliminar el Recibo de Caja"))
				{
				document.form2.oculto.value=2;
				document.form2.var1.value=idr;
				document.form2.submit();
				}
			}
			function archivocsv()
			{
				document.form2.action= "archivos/<?php echo $_SESSION['usuario'];?>-reporterecaudos.csv";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function crearexcel()
			{
				document.form2.action="teso-buscarecaudosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function verUltimaPos(idcta){location.href="teso-editarecaudos.php?idrecaudo="+idcta;}
			function generabusqueda()
			{
				document.form2.oculto.value=10;
				document.form2.submit();
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-recaudos.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" class="mgbt" onClick="document.form2.submit();"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"/><img src="imagenes/excel.png" title="Excel"  onclick="crearexcel()" class="mgbt"/></td>
			</tr>
		</table>	
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="teso-buscarecaudos.php">
			<div class="loading" id="divcarga"><span>Cargando...</span></div>
			<?php
				if(@$_POST['oculto']=="")
				{
					$_POST['numres']=10;
					$_POST['numpos']=0;
					$_POST['nummul']=0;
					echo"<script>document.getElementById('divcarga').style.display='none';</script>";
				}
			?>
			<table  class="inicio" style="width:99.7%">
				<tr >
					<td class="titulos" colspan="6">:. Buscar Recaudos </td>
					<td style="width:7%"><label class="boton02" onClick="location.href='teso-principal.php'">Cerrar</label></td>
				</tr>
				<tr>
					<td class="tamano01" style="width:3.6cm;">Numero Liquidaci&oacute;n:</td>
					<td style="width:10%;"><input type="search" name="numero" id="numero" value="<?php echo @$_POST['numero'];?>" style="width:100%;"/></td>
					<td class="tamano01" style="width:3.6cm;">Concepto Liquidaci&oacute;n:</td>
					<td colspan="2"><input type="search" name="nombre" id="nombre" value="<?php echo @$_POST['nombre'];?>" style="width:60%;"/></td>
				</tr>
				<tr>
					<td class="tamano01">Fecha Inicial: </td>
					<td><input type="search" name="fechaini" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo @$_POST['fechaini'];?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width:75%">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" class="icobut" title="Calendario"></td>
                    <td  class="tamano01" >Fecha Final: </td>
                    <td style="width:10%;"><input type="search" name="fechafin"  id="fc_1198971546" title="DD/MM/YYYY"  value="<?php echo @$_POST['fechafin'];?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width:75%"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971546');"  class="icobut" title="Calendario"></td>  
					<td style="padding-bottom:1px"><em class="botonflecha" onClick="generabusqueda();limbusquedas()">Buscar</em></td>
				</tr>
			</table> 
			<input type="hidden" name="oculto" id="oculto"  value="1"/>
			<input type="hidden" name="var1" value="<?php echo $_POST[var1];?>"/>  
			<input type="hidden" name="numres" id="numres" value="<?php echo @$_POST['numres'];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo @$_POST['numpos'];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo @$_POST['nummul'];?>"/>
			<div class="subpantallap" style="height:62%; width:99.6%; overflow-x:hidden;" id="divdet">
				<?php	
					if(@$_POST['oculto']==2)
					{
						$sqlr="SELECT * FROM tesorecaudos WHERE id_recaudo=".$_POST['var1']."";
						$resp = mysqli_query($linkbd,$sqlr);
						$row=mysqli_fetch_row($resp);
						//********Comprobante contable en 000000000000
						$sqlr=" UPDATE comprobante_cab SET total_debito=0,total_credito=0,estado='0' WHERE tipo_comp=2 AND numerotipo=$row[0]";
						mysqli_query($linkbd,$sqlr);
						$sqlr="UPDATE comprobante_det SET valdebito=0,valcredito=0 WHERE id_comp='2 $row[0]'";
						mysqli_query($linkbd,$sqlr);
						$sqlr="UPDATE tesorecaudos SET estado='N' WHERE id_recaudo=$row[0]";
						mysqli_query($linkbd,$sqlr);

						echo "<script>";
					}
					if(@$_POST['oculto']==10)
					{
						if (@$_POST['numero']!=""){$crit1="AND id_recaudo like '%".$_POST['numero']."%'";}
						else {$crit1="";}
						if (@$_POST['nombre']!=""){$crit2="AND concepto like '%".$_POST['nombre']."%'";}
						else {$crit2="";}
						if(@$_POST['fechaini']!='')
						{
							preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['fechaini'],$fecha);
							$fechai="$fecha[3]-$fecha[2]-$fecha[1]";
							if(@$_POST['fechafin']!='')
							{
								preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['fechafin'],$fecha);
								$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
								$crit3 = "AND fecha BETWEEN '$fechai' AND '$fechaf'";
							}
							else
							{
								$fechaf=date("Y-m-d");
								$crit3 = "AND fecha BETWEEN '$fechai' AND '$fechaf'";
							}
						}
						else{$crit3='';}
						//sacar el consecutivo 
						$sqlr="SELECT *FROM tesorecaudos WHERE id_recaudo>-1 $crit1 $crit2 $crit3 ORDER BY id_recaudo DESC";
						$resp = mysqli_query($linkbd,$sqlr);
						$_POST['numtop']=mysqli_num_rows($resp);
						$con=1;
						$namearch="archivos/".$_SESSION['usuario']."-reporterecaudos.csv";
						$Descriptor1 = fopen($namearch,"w+"); 
						$lista = array ('ID_RECAUDO','CONCEPTO','FECHA','DOC TERCERO','TERCERO','VALOR','ESTADO');
						fputcsv($Descriptor1, $lista,";");
						echo "
						<table class='inicio' align='center' >
							<tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr>
							<tr><td colspan='2'>Recaudos Encontrados: ".$_POST['numtop']."</td></tr>
							<tr>
								<td class='titulos2' style='width:7%;'>Codigo</td>
								<td class='titulos2'>Nombre</td>
								<td class='titulos2' style='width:7%;'>Fecha</td>
								<td class='titulos2'  style='width:10%;'>Contribuyente</td>
								<td class='titulos2' style='width:12%;'>Valor</td>
								<td class='titulos2' style='width:5%;text-align:center;'>Estado</td>
								<td class='titulos2' style='width:5%;text-align:center;'>Anular</td>
								<td class='titulos2' style='width:5%;text-align:center;'>Ver</td>
							</tr>";	
						$iter='zebra1';
						$iter2='zebra2';
						while ($row =mysqli_fetch_row($resp)) 
						{
							$ntercero=buscatercero($row[4]);
							unset($lista);
							$lista = array ($row[0],$row[6],$row[2],$row[4],$ntercero,number_format($row[5],2,",",""),$row[7]);
							fputcsv($Descriptor1, $lista,";");
							echo "
							<tr class='$iter' onDblClick=\"verUltimaPos($row[0])\">
								<td >$row[0]</td>
								<td >$row[6]</td>
								<td >$row[2]</td>
								<td >$row[4]</td>
								<td style='text-align:right'>$ ".number_format($row[5],2,".",",")."</td>";
							if ($row[7]=='S')
							echo "<td style='text-align:center;'><img src='imagenes/confirm.png'></center></td><td ><a href='#' onClick=eliminar($row[0])><center><img src='imagenes/anular.png'></a></td>";
							if ($row[7]=='N')
							echo "<td style='text-align:center;'><img src='imagenes/del3.png'></td><td ></td>";	
							if ($row[7]=='P')
							echo "<td style='text-align:center;'><img src='imagenes/dinero3.png'></td><td ></td>";	
							echo "<td style='text-align:center;'><a href='teso-editarecaudos.php?idrecaudo=$row[0]'><img src='imagenes/lupa02.png'  style='width:19px;'></a></td></tr>";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
						fclose($Descriptor1);
						
					}
					echo "<script>document.getElementById('divcarga').style.display='none';</script>";
				?>
			</div>
			<input type="hidden" name="numtop" id="numtop" value="<?php echo @$_POST['numtop'];?>" />
		</form> 
	</body>
</html>