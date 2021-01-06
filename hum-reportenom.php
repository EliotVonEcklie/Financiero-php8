<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function validar(formulario)
			{
				if(document.form2.nnomina.value=="")
				{
					document.form2.oculto2.value = '1';
					document.form2.action="hum-reportenom.php";
					document.form2.submit();
				}
				if(document.form2.nnomina.value!="")
				{
					document.form2.oculto.value = '1';
					document.form2.action="hum-reportenom.php";
					document.form2.submit();
				}
			}
			function excell()
			{
				document.form2.action="hum-reportenominaexcel2.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function pdf()
			{
				document.form2.action="pdfreportennom.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="hum-nnomina.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta, variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;
					}
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr>
				<script>barra_imagenes("hum");</script>
				<?php cuadro_titulos();?>
			</tr>
			<tr>
				<?php menu_desplegable("hum");?>
			</tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" title="Nuevo" class="mgbt1"/><img src="imagenes/guardad.png" title="Guardar" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick='validar()' class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"\></td>
			</tr>	
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="">
			<table  class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="8">:: Buscar Nomina</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style='width:10%'>No Liquidacion:</td>
					<td style='width:10%'><input type="text" name="nnomina" id="nnomina" value="<?php echo @$_POST['nnomina']?>" onBlur="validar()" style='width:60%'>&nbsp;<img class="icobut" src="imagenes/find02.png" onClick="despliegamodal2('visible');" title="Listado de Nominas"/></td>
					<td class="saludo1" style='width:1%'>Vigencia:</td> 
					<td><input type="text" name="vigencias" id="vigencias" value="<?php echo @$_POST['vigencias']?>" readonly/></td>
					<input name="oculto" type="hidden" value="0">
					<input name="oculto2" type="hidden" value="0">
				</tr>
			</table>
			
			<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden">
				<?php
					
					if(@ $_POST['oculto'] == '1')
					{
						$sqlfc="SELECT fecha FROM humnomina WHERE id_nom = '".$_POST['nnomina']."'";
						$rowfc =mysqli_fetch_row(mysqli_query($linkbd,$sqlfc));
						$fecha=$rowfc[0];
						echo "<input type='hidden' name='fecha' value='$rowfc[0]'/>";
						$con=1;
						$iter='zebra1';
						$iter2='zebra2';
						$_POST['totaldevini']=$_POST['totalauxalim']=$_POST['totalauxtra']=$_POST['totalhorex']= $_POST['totaldevtot']=0;
						$_POST['totalsalud']=$_POST['totalpension']= $_POST['totalfondosolida']=$_POST['totalotrasreducciones']=0;
						$_POST['totaldeductot']=$_POST['totalnetopago']=$_POST['totalretef']=0;
						$sqlr="SELECT * FROM humnomina WHERE id_nom = ".$_POST['nnomina']."";
						$resp = mysqli_query($linkbd,$sqlr);
						while ($row1 =mysqli_fetch_row($resp))
						{echo "<script> document.form2.vigencias.value = $row1[7]; </script>";}
						$sqlrt="SELECT id_nom,cedulanit,salbas,diaslab,SUM(devendias),SUM(ibc),SUM(auxalim),SUM(auxtran),SUM(valhorex), SUM(totaldev),SUM(salud),SUM(saludemp),SUM(pension),SUM(pensionemp),SUM(fondosolid),SUM(retefte),SUM(otrasdeduc),SUM(totaldeduc),SUM(netopagar), idfuncionario FROM humnomina_det WHERE id_nom = '".$_POST['nnomina']."' GROUP BY idfuncionario ";
						$respt = mysqli_query($linkbd,$sqlrt);
						$ntr=mysqli_num_rows($respt);
						echo "
						<table class='inicio' align='center' width='99%'>
							<tr><td colspan='19' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr>
							<tr>
								<td class='titulos2'>Id</td>
								<td class='titulos2'>SECTOR</td>
								<td class='titulos2' >EMPLEADO</td>
								<td class='titulos2'>Doc Id</td>
								<td class='titulos2' >SAL BAS</td>
								<td class='titulos2' >DIAS LIQ</td>
								<td class='titulos2' >Dias Novedad</td>
								<td class='titulos2' >DEVENGADO</td>
								<td class='titulos2' >AUX ALIM</td>
								<td class='titulos2' >AUX TRAN</td>
								<td class='titulos2' >Otros Pagos</td>
								<td class='titulos2' >TOT DEV</td>
								<td class='titulos2' >SALUD</td>
								<td class='titulos2' >PENSION</td>
								<td class='titulos2' >F SOLIDA</td>
								<td class='titulos2' >RETE FTE</td>
								<td class='titulos2' >OTRAS DEDUC</td>
								<td class='titulos2' >TOT DEDUC</td>
								<td class='titulos2' >NETO PAG</td>
							</tr>";
						while ($rowt =mysqli_fetch_row($respt))
						{
							$empleado=buscatercero($rowt[1]);
							$diasla=$diasnov=$pagosubali=0;
							$devenfun=$rowt[4];
							$sqldl="SELECT diaslab,detalle FROM humnomina_det WHERE id_nom = '".$_POST['nnomina']."' AND idfuncionario='$rowt[19]' AND tipopago='01'";
							$resdl = mysqli_query($linkbd,$sqldl);
							while ($rowdl =mysqli_fetch_row($resdl))
							{
								if($rowdl[1]=='nomina'){$diasla=$diasla+$rowdl[0];}
								else{$diasnov=$diasnov+$rowdl[0];}
							}
							$sqlsub="SELECT totaldev FROM humnomina_det WHERE id_nom = '".$_POST['nnomina']."' AND idfuncionario = '$rowt[19]' AND tipopago='07'";
							$ressub = mysqli_query($linkbd,$sqlsub);
							$rowsub =mysqli_fetch_row($ressub);
							if(@ $rowsub[0]!='')
							{
								$pagosubali=$rowsub[0];
								$devenfun=$devenfun-$rowsub[0]; 
							}
							else
							{
								$pagosubali=$rowt[6];
							}
							$sqlsub="SELECT totaldev FROM humnomina_det WHERE id_nom = '".$_POST['nnomina']."' AND idfuncionario = '$rowt[19]' AND tipopago='08'";
							$ressub = mysqli_query($linkbd,$sqlsub);
							$rowsub =mysqli_fetch_row($ressub);
							if(@ $rowsub[0]!='')
							{
								$pagosubtrans=$rowsub[0];
								$devenfun=$devenfun-$rowsub[0];
							}
							else
							{
								$pagosubtrans=$rowt[6];
							}
							$sqlsub="SELECT SUM(totaldev) FROM humnomina_det WHERE id_nom = '".$_POST['nnomina']."' AND idfuncionario = '$rowt[19]' AND tipopago <> '01' AND tipopago <> '07' AND tipopago <> '08'" ;
							$ressub = mysqli_query($linkbd,$sqlsub);
							$rowsub =mysqli_fetch_row($ressub2);
							if(@ $rowsub[0]!='')
							{
								$pagosotros=$rowsub[0];
								$devenfun=$devenfun-$rowsub[0];
							}
							else
							{
								$pagosotros=$rowt[6];
							}
							$sqlrn="select fondopensionestipo from terceros_nomina where cedulanit='$rowt[1]' ";
							$rown =mysqli_fetch_row(mysqli_query($linkbd,$sqlrn));
							$tipofondopension=$rown[0];
							echo "
							<tr  class='$iter' style='text-transform:uppercase'>
								<td style='font-size:10px;'>$con</td>
								<td style='font-size:10px;'>$tipofondopension</td>
								<td style='font-size:10px;'>$empleado</td>
								<td style='font-size:10px;'>$rowt[1]</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($rowt[2],0)." </td>
								<td style='font-size:10px;'>$diasla</td>
								<td style='font-size:10px;'>$diasnov</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($devenfun,0)."</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($pagosubali,0)."</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($pagosubtrans,0)."</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($pagosotros,0)."</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($rowt[9],0)."</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($rowt[10],0)."</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($rowt[12],0)."</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($rowt[14],0)."</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($rowt[15],0)."</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($rowt[16],0)."</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($rowt[17],0)."</td>
								<td style='text-align:right;font-size:10px;'>$".number_format($rowt[18],0)."</td>
								<input type='hidden' name='cont[]' value='$con'/>
								<input type='hidden' name='empleados[]' value='$empleado'/>
								<input type='hidden' name='docempleados[]' value='$rowt[1]'/>
								<input type='hidden' name='dias[]' value='$diasla'/>
								<input type='hidden' name='diasn[]' value='$diasnov'/>
								<input type='hidden' name='basico[]' value='".$rowt[2]."'/>
								<input type='hidden' name='deveng[]' value='$devenfun'/>
								<input type='hidden' name='auxali[]' value='$pagosubali'/>
								<input type='hidden' name='auxtrans[]' value='$pagosubtrans'/>
								<input type='hidden' name='horas_ex[]' value='$pagosotros'/>
								<input type='hidden' name='totaldev[]' value='".$rowt[9]."'/>
								<input type='hidden' name='ibc[]' value='".$rowt[5]."'/>
								<input type='hidden' name='salud[]' value='".$rowt[10]."'/>
								<input type='hidden' name='pension[]' value='".$rowt[12]."'/>
								<input type='hidden' name='fsoli[]' value='".$rowt[14]."'/>
								<input type='hidden' name='retefuen[]' value='".$rowt[15]."'/>
								<input type='hidden' name='otrasded[]' value='".$rowt[16]."'/>
								<input type='hidden' name='totalded[]' value='".$rowt[17]."'/>
								<input type='hidden' name='netopag[]' value='$rowt[18]'/>
							</tr>
							";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$_POST['totaldevini']=@$_POST['totaldevini']+$devenfun;
							$_POST['totalauxalim']=@$_POST['totalauxalim']+$pagosubali;
							$_POST['totalauxtra']=@$_POST['totalauxtra']+$rowt[7];
							$_POST['totalhorex']=@$_POST['totalhorex']+$rowt[8];
							$_POST['totaldevtot']=@$_POST['totaldevtot']+$rowt[9];
							$_POST['totalibc']=@$_POST['totalibc']+$rowt[5];
							$_POST['totalsalud']=@$_POST['totalsalud']+$rowt[10];
							$_POST['totalpension']=@$_POST['totalpension']+$rowt[12];
							$_POST['totalfondosolida']=@$_POST['totalfondosolida']+$rowt[14];
							$_POST['totalretef']=@$_POST['totalretef']+$rowt[15];
							$_POST['totalotrasreducciones']=@$_POST['totalotrasreducciones']+$rowt[16];
							$_POST['totaldeductot']=@$_POST['totaldeductot']+$rowt[17];
							$_POST['totalnetopago']=@$_POST['totalnetopago']+$rowt[18];
						}
						echo "
						<tr class='saludo3'>
							<td colspan='7'></td>
							<td style='text-align:right;'>$".number_format($_POST['totaldevini'],0)."</td>
							<td style='text-align:right;'>$".number_format($_POST['totalauxalim'],0)."</td>
							<td style='text-align:right;'>$".number_format($_POST['totalauxtra'],0)."</td>
							<td style='text-align:right;'>$".number_format($_POST['totalhorex'],0)."</td>
							<td style='text-align:right;'>$".number_format($_POST['totaldevtot'],0)."</td>
							<td style='text-align:right;'>$".number_format($_POST['totalsalud'],0)."</td>
							<td style='text-align:right;'>$".number_format($_POST['totalpension'],0)."</td>
							<td style='text-align:right;'>$".number_format($_POST['totalfondosolida'],0)."</td>
							<td style='text-align:right;'>$".number_format($_POST['totalretef'],0)."</td>
							<td style='text-align:right;'>$".number_format($_POST['totalotrasreducciones'],0)."</td>
							<td style='text-align:right;'>$".number_format($_POST['totaldeductot'],0)."</td>
							<td style='text-align:right;'>$".number_format($_POST['totalnetopago'],0)."</td>
							<input type='hidden' name='totaldevini' value='".@$_POST['totaldevini']."'>
							<input type='hidden' name='totalauxalim' value='".@$_POST['totalauxalim']."'>
							<input type='hidden' name='totalauxtra' value='".@$_POST['totalauxtra']."'>
							<input type='hidden' name='totalhorex' value='".@$_POST['totalhorex']."'>
							<input type='hidden' name='totaldevtot' value='".@$_POST['totaldevtot']."'>
							<input type='hidden' name='totalibc' value='".@$_POST['totalibc']."'>
							<input type='hidden' name='totalsalud' value='".@$_POST['totalsalud']."'>
							<input type='hidden' name='totalpension' value='".@$_POST['totalpension']."'>
							<input type='hidden' name='totalfondosolida' value='".@$_POST['totalfondosolida']."'>
							<input type='hidden' name='totalretef' value='".@$_POST['totalretef']."'>
							<input type='hidden' name='totalotrasreducciones' value='".@$_POST['totalotrasreducciones']."'>
							<input type='hidden' name='totaldeductot' value='".@$_POST['totaldeductot']."'>
							<input type='hidden' name='totalnetopago' value='".@$_POST['totalnetopago']."'>
						</tr>";
 						echo"</table>";
					}
				?>
			</div>
			<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
				</div>
			</div>
		</form>
	</body>
</html>