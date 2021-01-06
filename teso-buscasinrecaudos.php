<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag(@$_GET['codpag'],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
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
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			function verUltimaPos(idcta, filas, filtro){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="teso-editasinrecaudos.php?idrecaudo="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function crearexcel(){
			document.form2.action="teso-buscasinrecaudosexcel.php";
			document.form2.target="_BLANK";
			document.form2.submit();
			document.form2.action="";
			document.form2.target="";
}
			function eliminar(idr){
				if (confirm("Esta Seguro de Eliminar el Recibo de Caja")){
					document.form2.oculto.value=2;
					document.form2.var1.value=idr;
					document.form2.submit();
				}
			}
		</script>
		<?php 
			titlepag();
			$scrtop=@$_GET['scrtop'];
			if($scrtop=="") $scrtop=0;
			echo"<script>
				window.onload=function(){
					$('#divdet').scrollTop(".$scrtop.")
				}
			</script>";
			$gidcta=@$_GET['idcta'];
			if(isset($_GET['filtro']))
				$_POST['nombre']=$_GET['filtro'];
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-sinrecaudos.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" class="mgbt" onClick="document.form2.submit();"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a></td>
			</tr>
		</table>
		<form name="form2" method="post" action="teso-buscasinrecaudos.php">
			<div class="loading" id="divcarga"><span>Cargando...</span></div>
			<?php
				if(@$_GET['numpag']!="")
				{
					if(@$_POST['oculto']!=2)
					{
						$_POST['numres']=$_GET['limreg'];
						$_POST['numpos']=$_GET['limreg']*($_GET['numpag']-1);
						$_POST['nummul']=$_GET['numpag']-1;
					}
				}
				else
				{
					if(@$_POST['nummul']=="")
					{
						$_POST['numres']=10;
						$_POST['numpos']=0;
						$_POST['nummul']=0;
					}
				}
			if(@$_POST['oculto']!=''){echo"<script>document.getElementById('divcarga').style.display='none';</script>";}
			?>
			<input type="hidden" name="numres" id="numres" value="<?php echo @$_POST['numres'];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo @$_POST['numpos'];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo @$_POST['nummul'];?>"/>
			<table  class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="5">:. Buscar Recaudos </td>
					<td style="width:7%"><label class="boton02" onClick="location.href='teso-principal.php'">Cerrar</label></td>
				</tr>
				<tr >
					<td style="width:3.5cm" class="tamano01">Numero o Concepto Liquidaci&oacute;n: </td>
					<td colspan="4">
						<input type="text" name="concepto" value="" style="width:70%"/>
						<input type="hidden" name="oculto" id="oculto" value="1"/>
						<input type="hidden" name="var1" value=<?php echo @$_POST['var1'];?>/>
					</td>
				</tr>
				<tr>
					<td class="tamano01">Fecha Inicial: </td>
					<td style="width:10%"><input type="search" name="fechaini" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo @$_POST['fechaini'];?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width:75%">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" class="icobut" title="Calendario"></td>
					<td class="tamano01" style="width:3.5cm">Fecha Final: </td>
					<td style="width:10%;"><input type="search" name="fechafin" id="fc_1198971546" title="DD/MM/YYYY" value="<?php echo @$_POST['fechafin'];?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width:75%"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971546');" class="icobut" title="Calendario"></td>
					<td style="padding-bottom:1px"><em class="botonflecha" onClick="limbusquedas()">Buscar</em></td>
				</tr>
			</table>
			<div class="subpantallap" style="height:60%; width:99.6%; overflow-x:hidden;">
				<?php
					if(@$_POST['oculto']==2)
					{
					
					
						$sqlr="SELECT * FROM tesosinrecaudos WHERE id_recaudo='".$_POST['var1']."'";
						$resp = mysqli_query($linkbd,$sqlr);
						$row=mysqli_fetch_row($resp);
						//********Comprobante contable en 000000000000
						$sqlr="UPDATE comprobante_cab SET total_debito=0,total_credito=0,estado='0' WHERE tipo_comp='26' AND numerotipo='$row[0]'";
						mysqli_query($linkbd,$sqlr);
						$sqlr="UPDATE comprobante_det SET valdebito=0,valcredito=0 WHERE id_comp='26 $row[0]'";
						mysqli_query($linkbd,$sqlr);
						$sqlr="UPDATE tesosinrecaudos SET estado='N' WHERE id_recaudo=$row[0]";
						mysqli_query($linkbd,$sqlr);
					
					}
					if (@$_POST[concepto] != "" || (@$_POST[fechaini] != "" && @$_POST[fechafin] != ""))
					{
					$oculto=@$_POST['oculto'];
					if (@$_POST['concepto'] != ''){
					$crit1="AND concat_ws(' ', id_recaudo, concepto) LIKE '%".$_POST['concepto']."%'";
					}
					else{$crit1="";}
					if(@$_POST['fechaini']!='')
					{
						preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['fechaini'],$fecha);
						$fechai="$fecha[3]-$fecha[2]-$fecha[1]";
						if(@$_POST['fechafin']!='')
						{
							preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['fechafin'],$fecha);
							$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
							$crit2 = "AND fecha BETWEEN '$fechai' AND '$fechaf'";
						}
						else
						{
							$fechaf=date("Y-m-d");
							$crit2 = "AND fecha BETWEEN '$fechai' AND '$fechaf'";
						}
					}
					else{$crit2='';}
					//sacar el consecutivo 
					$sqlr="SELECT * FROM tesosinrecaudos WHERE id_recaudo >-1 $crit1 $crit2";
					$resp = mysqli_query($linkbd,$sqlr);
					$ntr = mysqli_num_rows($resp);
					$_POST['numtop']=$ntr;
					$nuncilumnas=ceil($_POST['numtop']/$_POST['numres']);
					if (@$_POST['numres']!="-1"){ $cond2="LIMIT ".$_POST['numpos'].", ".$_POST['numres'];}
					else {$cond2="";}
					$sqlr="SELECT * FROM tesosinrecaudos WHERE id_recaudo >-1 $crit1 $crit2 ORDER BY id_recaudo DESC ".$cond2;
					$resp = mysqli_query($linkbd,$sqlr);
					$con=1;
					$numcontrol=$_POST['nummul']+1;
					}
					if((@$nuncilumnas==@$numcontrol)||(@$_POST['numres']=="-1"))
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
					}
					else
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if((@$_POST['numpos']==0)||(@$_POST['numres']=="-1"))
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					$con=1;
					echo "
					<table class='inicio' align='center'>
						<tr>
							<td colspan='6' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if (@$_POST['renumres']=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if (@$_POST['renumres']=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if (@$_POST['renumres']=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if (@$_POST['renumres']=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if (@$_POST['renumres']=='100'){echo 'selected';} echo ">100</option>
									<option value='-1'"; if (@$_POST['renumres']=='-1'){echo 'selected';} echo ">Todos</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan='7'>Recaudos Encontrados: $ntr</td>
						</tr>
						<tr>
							<td width='150' class='titulos2'>Codigo</td>
							<td class='titulos2'>Nombre</td>
							<td class='titulos2'>Fecha</td>
							<td class='titulos2'>Contribuyente</td>
							<td class='titulos2'>Estado</td>
							<td class='titulos2' width='5%'><center>Anular</td>
							<td class='titulos2' width='5%'><center>Ver</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;

					if($_POST['fechaini'] == '' && $_POST['fechafin'] == '')
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%;font-size:25px'>Utilice el filtro de busqueda</td>
							</tr>
						</table>";
					}
					elseif(@mysqli_num_rows($resp) == 0 || @mysqli_num_rows($resp) == '0')
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%;font-size:25px'>No hay resultados de su busqueda.</td>
							</tr>
						</table>";
					}
					else
					{
						while (@$row = mysqli_fetch_row(@$resp))
						{
							if($gidcta!="")
							{
								if($gidcta==$row[0]){$estilo='background-color:#FF9';}
									else {$estilo="";}
							}
							else{$estilo="";}	
							$idcta="'".$row[0]."'";
							$numfil="'".$filas."'";
							$filtro="'".@$_POST['nombre']."'";
							$nombreTercero = buscatercero($row[4]);
						
							echo"
							<tr class='$iter' onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo'>
								<td>$row[0]</td>
								<td>$row[6]</td>
								<td>$row[2]</td>
								<td>$row[4]</td>";
							if ($row[7]=='S'){echo "<td><center><img src='imagenes/confirm.png'></center></td>";}
							if ($row[7]=='N'){echo "<td><center><img src='imagenes/cross.png'></center></td>";}
							if ($row[7]=='P'){echo "<td ><center><img src='imagenes/dinero3.png'></center></td>";}
							if ($row[7]=='S'){echo "<td style='text-align:center;'><a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png'></a></td>";}
							if ($row[7]=='N' || $row[7]=='P'){echo "<td ></td>";}
							if ($row[7]=="P")
							{
								
								$estado='Pago';
							}
							else
							{
								
								$estado='Anulado';
							}
							echo"<td style='text-align:center;'>
									<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'>
										<img src='imagenes/lupa02.png' style='width:18px' title='Ver'>
									</a>
								</td>
								<input type='hidden' name='codigo[]' value='$row[0]'>
								<input type='hidden' name='nom[]' value='$row[6]'>
								<input type='hidden' name='fecha[]' value='$row[2]'>
								<input type='hidden' name='nombreterce[]' value='$nombreTercero'>
								<input type='hidden' name='contri[]' value='$row[4]'>
								<input type='hidden' name='est[]' value='$estado'>
							</tr>";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$filas++;
						}
					}
					
					echo "<script>document.getElementById('divcarga').style.display='none';</script>";
					echo"</table>
					<table class='inicio'>
						<tr>
							<td style='text-align:center;'>
								<a href='#'>$imagensback</a>&nbsp;
								<a href='#'>$imagenback</a>&nbsp;&nbsp;";
								if(@$nuncilumnas<=9){@$numfin=@$nuncilumnas;}
								else{$numfin=9;}
								for($xx = 1; $xx <= $numfin; $xx++){
									if($numcontrol<=9){$numx=$xx;}
									else{$numx=$xx+($numcontrol-9);}
									if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
									else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
								}
								echo "		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
											&nbsp;<a href='#'>$imagensforward</a>
							</td>
							
						</tr>
					</table>";
				?>
			</div>
		</form> 
	</body>
</html>