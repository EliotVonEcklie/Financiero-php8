<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>:: SPID - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function buscactap(e){if (document.form2.cuentap.value!=""){document.form2.bcp.value='1';document.form2.submit();}}
			function validar(){document.form2.submit();}
			function agregardetalle()
			{
				if(document.getElementById('ncuentap').value!="" )
				{document.form2.agregadet.value=1;document.form2.submit();}
 				else {despliegamodalm('visible','2','Falta informaci�n para poder Agregar Detalle');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar Detalle','1');
			}
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if (document.form2.codigo.value!='' && validacion01.trim()!='' && document.getElementById('condeta').value != "0")
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','2')}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{document.getElementById('ventana2').src="contconceptos-ventana01.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if (document.getElementById('valfocus').value!="0")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('cuentap').focus();
						document.getElementById('cuentap').select();
					}
				}
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
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="6";
								document.form2.submit();break;
					case "2":	document.form2.oculto.value=2;
								document.form2.submit();break;
				}
			}
			function adelante(scrtop, numpag, limreg, filtro)
			{
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('idnum').value;
				actual=parseFloat(actual)+1;
				if(actual<=parseFloat(maximo))
				{
					//if(actual<10){actual="0"+actual;}
					location.href="cont-generareporte.php?idr=" +actual+ "&scrtop=" +scrtop+ "&numpag=" +numpag+ "&limreg=" +limreg+ "&filtro=" +filtro;
				}
			}
			function atrasc(scrtop, numpag, limreg, filtro, prev)
			{
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('idnum').value;
				actual=parseFloat(actual)-1;
				if(actual>=parseFloat(minimo))
				{
					//if(actual<10){actual="0"+actual;}
					location.href="cont-generareporte.php?idr=" +actual+ "&scrtop=" +scrtop+ "&numpag=" +numpag+ "&limreg=" +limreg+ "&filtro=" +filtro;
				}
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('idnum').value;
				location.href="cont-generareportebuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<?php
			$numpag=$_GET[numpag];
			$limreg=$_GET[limreg];
			$scrtop=26*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" title="Nuevo" onClick="location.href='#'" class="mgbt"/><img src="imagenes/guarda.png"  title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar"  onClick="location.href='cont-generareportebuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras(<?php echo "$scrtop, $numpag, $limreg, $filtro"; ?>)" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<?php
			if ($_GET['idr']!="")
			{
				$sqlr="SELECT idnum FROM contexoformatos WHERE codigo='".$_GET['idr']."'";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				echo "<script>document.getElementById('codrec').value=$r;</script>";
			}
			$sqlr="SELECT MIN(idnum), MAX(idnum) FROM contexoformatos ORDER BY idnum";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST['minimo']=$r[0];
			$_POST['maximo']=$r[1];
			if($_POST['oculto']=="")
			{
				if ($_POST['codrec']!="" || $_GET['idr']!="")
				{
					if($_POST['codrec']!=""){$sqlr="SELECT * FROM contexoformatos WHERE idnum='".$_POST['codrec']."'";}
					else
					{
						$sqlr="SELECT * FROM contexoformatos WHERE idnum ='".$_GET['idr']."'";
					}
				}
                else
                {
                    $sqlr="SELECT * FROM contexoformatos ORDER BY idnum DESC";
                }
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST['idnum']=$row[0];
				$_POST['codigo']=$row[1];
				$_POST['nombre']=$row[2];
				if(($_POST['oculto']!="2")&&($_POST['oculto']!="6")&&($_POST['oculto']!="7")&&($_POST['oculto']!="1"))
				{
					$sqlr="SELECT * FROM contexoconceptosdian_det WHERE idnum='".$_POST['idnum']."'";
					$cont=0;
					unset($_POST['dcodigo']);
					unset($_POST['dncuentas']);
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$_POST['dcodigo'][$cont]=$row[2];
						$_POST['dncuentas'][$cont]=$row[3];
						$cont=$cont+1;
					}
					$sqlr="SELECT * FROM contexoformatos WHERE idnum='".$_POST['idnum']."'";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$_POST['codigo']=$row[1];
						$_POST['nombre']=$row[2];
					}
				}
			}
		?>
		<form name="form2" method="post" action="">
			<input type="hidden" name="valfocus" id="valfocus" value="1"/>
			<table class="inicio" align="center" >
				<tr >
					<td class="titulos" colspan="4">.: Generar formato</td>
					<td style="width:7%"><label class="boton02" onClick="location.href='cont-principal.php'">Cerrar</label></td>
				</tr>
				<tr style="height: 35px;">
					<td class="tamano01" style="width:2cm;">C&oacute;digo:</td>
					<td style="width:10%;"><img src="imagenes/back.png" onClick="atrasc(<?php echo "$scrtop, $numpag, $limreg, $filtro"; ?>)" class="icobut" title="Anterior"/>&nbsp;<input type="text" name="codigo" id="codigo" value="<?php echo @ $_POST['codigo'];?>" maxlength="5" style="width:35%;height:35px!important;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" class="tamano02" readonly/>&nbsp;<img src="imagenes/next.png" onClick="adelante(<?php echo "$scrtop, $numpag, $limreg, $filtro" ?>);" class="icobut" title="Sigiente"/></td>
					<input type="hidden" name="codrec" id="codrec" value="<?php echo @ $_POST['codrec']?>"/>
					<td class="tamano01" style="width:3cm;">Nombre:</td>
					<td><input type="text" name="nombre" id="nombre" value="<?php echo @ $_POST['nombre'];?>" style="width:100%;height:35px!important;" onKeyUp="return tabular(event,this)" class="tamano02" readonly/></td>
				</tr>
			</table>
			<input type="hidden" name="maximo" id="maximo" value="<?php echo @ $_POST['maximo']?>"/>
			<input type="hidden" name="minimo" id="minimo" value="<?php echo @$_POST['minimo']?>"/>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="idnum" id="idnum" id="" value="<?php echo @ $_POST['idnum'];?>"/>
			<table class="inicio" align="center" >
				<tr style="height: 35px;">
					<td class="saludo1" style="width:10%;">Fecha Inicial:</td>
					<td style="width:10%;">
						<input name="fecha" type="text" id="fc_1198971545" title="YYYY-MM-DD" style="width:80%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"></a>
					</td>
					<td class="saludo1" style="width:10%;">Fecha Final: </td>
					<td style="width:10%;">
						<input name="fecha2" type="text" id="fc_1198971546" title="YYYY-MM-DD"  style="width:80%;" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"><a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario">&nbsp;<img src="imagenes/calendario04.png" style="width:20px;"></a>
					</td>
					
					<td><input type="button" name="generar" value="Generar" onClick="generarbal();">  </td>
				</tr>
			</table>
			<?php
				//**** busca cuenta
				if($_POST[bcp]!='')
				{
					$nresul=buscacuentapres($_POST[cuentap],2);
					if($nresul!='')
					{
						echo"
							<script>
								document.getElementById('bcp').value='';
								document.getElementById('ncuentap').value='$nresul';
								document.getElementById('concecont').focus();
							</script>";
					}
					else
					{
						echo "<script>document.getElementById('valfocus').value='3';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
					}
				}
			?>
			<div class="subpantalla" style="height:60%; width:99.5%;overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="15">Detalle Formato - Concepto</td></tr>
					<tr>
                        <td class='titulos2'>CONCEPTO</td>
						<td class='titulos2'>RUBRO</td>
						<td class='titulos2'>DOC TERCERO</td>
						<td class='titulos2'>TERCERO</td>
						<td class='titulos2'>FECHA</td>

                        <?php
                        $sqlr = "SELECT nombre FROM contexoformatos_det WHERE idnum='".$_POST['idnum']."'";
                        $resp = mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($resp))
                        {
                            echo "<td class='titulos2' style='width:10%;'>$row[0]</td>";
                        }
                        ?>

					</tr>
					<input type='hidden' name='elimina' id='elimina'>
					<?php



						$iter='saludo1a';
						$iter2='saludo2';
						$_POST[fecha]='2019-01-01';
						$_POST[fecha2]='2019-12-31';
						if($_POST[consolidado]=='1'){$critcons=" ";}
						else {$critcons=" and comprobante_det.tipo_comp <> 19 ";}

						$sqlrCuentas = "SELECT cuenta,tipo,concepto,columna FROM contexoconceptos_det WHERE idnum='".$_POST['idnum']."'";
						$respCuentas = mysql_query($sqlrCuentas,$linkbd);
						while ($rowCuentas =mysql_fetch_row($respCuentas))
						{
							$sqlr="select distinct comprobante_det.tercero, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito), comprobante_cab.fecha  from comprobante_cab,comprobante_det where comprobante_det.cuenta = '".$rowCuentas[0]."' and  comprobante_cab.fecha between 	'".$_POST[fecha]."' and '".$_POST[fecha2]."' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' and comprobante_cab.tipo_comp<>'7' ".$critcons." AND comprobante_det.centrocosto like '%$_POST[cc]%' group by comprobante_det.cuenta, comprobante_det.tercero order by comprobante_det.cuenta, comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
							$res=mysql_query($sqlr,$linkbd);
							$cuentainicial='';
							while($row=mysql_fetch_row($res))
							{
								$saldo = 0;
								if($rowCuentas[1] == 'SALDO FINAL')
								{
									$saldo = $row[1] - $row[2];
								}
								else if($rowCuentas[1] == 'DEBITO')
								{
									$saldo = $row[1];
								}
								else
								{
									$saldo = $row[2];
								}
								$nombreTercero ='';

								$nombreTercero = buscatercero($row[0]);
								$sqlrConcepto = "SELECT concepto FROM contexoconceptosdian_det WHERE iddet='".$rowCuentas[2]."'";
								$respConcepto = mysql_query($sqlrConcepto,$linkbd);
								$rowConcepto =mysql_fetch_row($respConcepto);

								echo "
								<tr class='$iter'>
									<td ><input type='text' name='conexogena[]' value='".$rowConcepto[0]."' size='4' readonly></td>
									<td ><input type='hidden' name='rubros[]' value='".$rowCuentas[0]."'>".$rowCuentas[0]."</td>
									<td ><input type='hidden' name='terceros[]' value='".$row[0]."'>".$row[0]."</td>
									<td ><input type='hidden' name='nterceros[]' value='".$nombreTercero."'>".$nombreTercero."</td>
									<td ><input type='hidden' name='fechas[]' value='".$row[3]."'>".$row[3]."</td>";

									$sqlrColumna = "SELECT concepto FROM contexoformatos_det WHERE idnum='".$_POST['idnum']."'";
									$respColumna = mysql_query($sqlrColumna,$linkbd);
									while ($rowColumna =mysql_fetch_row($respColumna))
									{
										if($rowColumna[0] == $rowCuentas[3])
										{
											echo "<td ><input type='hidden' name='valoresb[]' value='".$saldo."'>".number_format($saldo,2)."</td>";
										}
										else
										{
											echo "<td ><input type='hidden' name='valoresb[]' value='0'>".number_format(0,2)."</td>";
										}
									}

									echo "
								</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}
						}

						
					?>
					<tr></tr>
				</table>	
			</div>
			
			<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
					</IFRAME>
				</div>
			</div>
		</form>
	</body>
</html>
