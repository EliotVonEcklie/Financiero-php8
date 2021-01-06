<?php
	ini_set('max_execution_time',3600);
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	error_reporting(0);
	
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Presupuesto</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="JQuery/jquery-1.12.0.min.js"></script> 
		<script>
			$(window).load(function () { $('#cargando').hide();});
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
			function despliegamodal2(_valor,_nomcu)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					document.getElementById('ventana2').src="cuentasgral-ventana03.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto="+_nomcu+"&nobjeto=000";
				}
			}
 			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
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
				case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":
						document.form2.elimina.value=variable;
						//eli=document.getElementById(elimina);
						vvend=document.getElementById('elimina');
						//eli.value=elimina;
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){}
			function pdf()
			{
				document.form2.action="presu-ejecuciongastospdf.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="presu-ejecuciongastosexcel2.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function validar()
			{
				document.getElementById('oculto').value='3';
				document.form2.submit();
			}
			var expanded = false;
			function showCheckboxes()
			{
				var checkboxes = document.getElementById("checkboxes");
				if (!expanded) 
				{
					checkboxes.style.display = "block";
					expanded = true;
				}
				else
				{
					checkboxes.style.display = "none";
					expanded = false;
				}
			}
			var expanded1 = false;
			function showCheckboxes1()
			{
				var checkboxes1 = document.getElementById("checkboxes1");
				if (!expanded1)
				{
					checkboxes1.style.display = "block";
					expanded1 = true;
				}
				else
				{
					checkboxes1.style.display = "none";
					expanded1 = false;
				}
			}
			function direccionaCuentaGastos(row)
			{
				var cell = row.getElementsByTagName("td")[0];
				var id = cell.innerHTML;
				var fechai=document.form2.fecha.value;
				var fechaf=document.form2.fecha2.value;
				window.open("presu-auxiliarcuentagastos.php?cod="+id+"&fechai="+fechai+"&fechaf="+fechaf);
			}
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value=2;
					document.form2.submit();
				}
			}
		</script>
		<style type="text/css">
			.multiselect {width: 200px;}
			.selectBox {position: relative;}
			.selectBox select
			{
				width: 100%;
				font-weight: bold;
			}
			.overSelect
			{
				position: absolute;
				left: 0;
				right: 0;
				top: 0;
				bottom: 0;
			}
			#checkboxes
			{
				display: none;
				border: 1px #dadada solid;
				position: absolute;
				width: 13%;
				overflow-y: scroll;
				z-index: 999999999;
			}
			#checkboxes1
			{
				display: none;
				border: 1px #dadada solid;
				position: absolute;
				width: 13%;
				overflow-y: scroll;
				z-index: 9999;	
			}
			#checkboxes label,#checkboxes1 label
			{
				display: block;
				background: #ECEFF1;
				border-bottom: 1px solid #CFD8DC;
				font-size: 10px;
			}
			#checkboxes label:last-child, #checkboxes1 label:last-child
			{
				display: block;
				background: #ECEFF1;
				border-bottom: none;
			}
			#checkboxes label:hover,#checkboxes1 label:hover
			{
				background-color: #1e90ff;
				cursor:pointer;
			}
		</style>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("presu");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit()" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/print.png" title="imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/excel.png" title="excel" onClick="excell()" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='presu-ejecucionpresupuestal.php'" class="mgbt"><a href="<?php echo "archivos/FORMATO_7_Ejecucion_Presupuestal_de_Gastos.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/sia.png"  title="csv" width="32px" height="32px"></a></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="presu-ejecuciongastos.php">
			<div class="loading" id="divcarga"><span>Cargando...</span></div>
			<input type="hidden" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia];?>" >
			<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$vigencia=$vigusu;
				if($_POST[bc]!='')
				{
					$nresul=buscacuentapres($_POST[cuenta],2);
					if($nresul!=''){$_POST[ncuenta]=$nresul;}
					else {$_POST[ncuenta]="";}
				}
			if($_POST[oculto]==""){echo"<script>document.getElementById('divcarga').style.display='none';</script>";}
			?>
			<!--<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
				<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
			</div>-->
			<table  align="center" class="inicio" >
				<tr>
					<td class="titulos" colspan="13">.: Ejecucion Gastos</td>
					<td width="7%" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
				</tr>
				<tr>
					<td width="15%" class="saludo1">Fecha Inicial:</td>
					<td width="14%"><input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="7" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10">&nbsp;<img src="imagenes/calendario04.png" class="icobut" onClick="displayCalendarFor('fc_1198971545');"/></td>
					<td width="15%" class="saludo1">Fecha Final: </td>
					<td width="14%"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="7" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971546');" class="icobut" /></td>
					<td style="width:5%" class="saludo1">Unidad(es): </td>
					<td style="width:10%">
						<div class="multiselect">
							<div class="selectBox" onclick="showCheckboxes()">
								<select>
									<option id="texto" >Selecciona...</option>
								</select>
								<div class="overSelect"></div>
							</div>
							<div id="checkboxes">
								<?php
									$sql="Select * from pptouniejecu  WHERE estado='S' order by id_cc";
									$query=mysql_query($sql,$linkbd);
									while ($row = mysql_fetch_array($query))
									{
										echo "<label for='".$row[0]."'><input type='checkbox' class='".$row[0]."' id='$row[0]' name='unidad'/>$row[0] - ".utf8_encode($row[1])." </label>";
									}
								?>
							</div>
						</div>
						<input type="hidden" name="filtros" id="filtros" value="">
					</td>
					<td style="width:5%" class="saludo1">Orden: </td>
					<td style="width:7%">
						<select name="orden" id="orden" style="width: 100%">
							<option value="">Seleccione ....</option>
							<option value="ASC" <?php if($_POST[orden]=="ASC"){ echo "selected"; } ?> >Ascendente</option>
							<option value="DESC" <?php if($_POST[orden]=="DESC"){ echo "selected"; } ?> >Descendente</option>
						</select>
					</td>
					<td style="width:5%" class="saludo1">Fuente: </td>
					<td style="width:30%" colspan="3">
						<select name="ffunc" id="ffunc" style="width: 100%">
							<option value="">Seleccione ....</option>
							<?php
								$sql="SELECT codigo,nombre FROM pptofutfuentefunc UNION SELECT codigo,nombre FROM pptofutfuenteinv ORDER BY CAST(codigo AS SIGNED) ASC";
								$result=mysql_query($sql,$linkbd);
								while($row = mysql_fetch_row($result)){echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
							?>
						</select>
					</td>
					<td width="5%">
						<input type="button" name="generar" value="Generar" onClick="validar()"> 
						<input type="hidden" value="<?php echo $_POST[oculto]; ?>" name="oculto" id="oculto">
					</td>
					<td width="33%"></td>
				</tr> 
				<tr> 
					<td class="saludo1" >Cuenta Inicial:</td>
					<td><input type="text" id="cuenta1" name="cuenta1" size="8" onKeyPress="javascript:return solonumeros(event)" 
						onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta1]?>" onClick="document.getElementById('cuenta1').focus();document.getElementById('cuenta1').select();">&nbsp;<img class="icobut" src="imagenes/find02.png" onClick="mypop=window.open('cuentasppto-ventanac1.php?ti=1&c=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"/></td>
					<td class="saludo1" >Cuenta Final:</td>
					<td><input type="text" id="cuenta2" name="cuenta2" size="8" onKeyPress="javascript:return solonumeros(event)" 
						onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta2]?>" onClick="document.getElementById('cuenta2').focus();document.getElementById('cuenta2').select();">&nbsp;<img class="icobut" src="imagenes/find02.png" onClick="mypop=window.open('cuentasppto-ventanac1.php?ti=1&c=2','', 'menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"/></td>
					<td style="width=5%" class="saludo1">Clasificacion: </td>
					<td style="width=10%">
						<div class="multiselect">
							<div class="selectBox" onclick="showCheckboxes1()">
								<select>
									<option id="texto1">Selecciona...</option>
								</select>
								<div class="overSelect"></div>
							</div>
							<div id="checkboxes1">
								<?php
									$contenido="";
									$sql="Select * from dominios where nombre_dominio like 'CLASIFICACION_RUBROS' and TIPO='G' $contenido order by descripcion_valor ASC";

									$query=mysql_query($sql,$linkbd);
									$i=10;
									while ($row = mysql_fetch_array($query))
									{
										echo "<label for='".$i."' style='color:#BDBDBD'>";
										echo "<input type='checkbox' class='".$i."' name='clasifica' id='".$i."' disabled/>$i - ".strtoupper($row[2])." ";
										echo "</label>";
										$i++;
									}
								?>
							</div>
							<input type="hidden" name="filtrosclases" id="filtrosclases" value="">
						</div>
					</td>
					<td style="width=5%" class="saludo1">Sector: </td>
					<td style="width=7%">
						<select name="sectores" id="sectores">
							<option value="">Seleccione ....</option>
							<?php
								$sqlr="Select * from presusectores order by sector ASC";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if(0==strcmp($row[0],$_POST[sectores])){echo "<option value='$row[0]' SELECTED >$row[0]</option>";}
									else {echo "<option value='$row[0]'>$row[0]</option>";}
								}
							?>
						</select>
					</td>
					<td style="width:5%" class="saludo1">Regalias: </td>
					<td style="width:10%; border: 1px dashed gray"><input type="checkbox" name="regalias" id="regalias" <?php if(isset($_POST[regalias])){echo "CHECKED"; }?> /></td>
					<td style="width:5%" class="saludo1">Agregado: </td>
					<td style="width:10%;border: 1px dashed gray"><input type="checkbox" name="agregado" id="agregado" <?php if(isset($_POST[agregado])){echo "CHECKED"; }?> /></td>
				</tr>
			</table>
			<?php
				if($_POST[oculto]==2)
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha1);
					$fechaf=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha2);
					$fechaf2=$fecha2[3]."-".$fecha2[2]."-".$fecha2[1];	
					if($_POST[vereg]=='1')
					{
						if($fecha1[3]==$fecha2[3])
						{
							$correcto=1;
							$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
							$resv=mysql_query($sqlv,$linkbd);
							if(mysql_num_rows($resv)!=0){$todos=1;}
							else {$todos=0;}
						}
						else
						{
							$correcto=0;
							echo "<script>despliegamodalm('visible','1','El Presupuesto General SOLO Aplica para Una Vigencia');</script>";
						}
					}
					elseif($_POST[vereg]=='2')
					{
						if($fecha1[3]==$fecha2[3])
						{
							$correcto=1;
							$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
							$resv=mysql_query($sqlv,$linkbd);
							if(mysql_num_rows($resv)!=0){$todos=1;}
							else {$todos=0;}
						}
						else
						{
							$numvig=$fecha2[3]-$fecha1[3];
							if(($numvig>0)&&($numvig<3))
							{
								$vigenciarg=$fecha1[3].' - '.$fecha2[3];
								$sqlv2="SELECT * FROM pptocuentas WHERE vigenciarg='$vigenciarg'";
								$resv2=mysql_query($sqlv2,$linkbd);
								if(mysql_num_rows($resv2)!=0)
								{
									$correcto=1;
									if($numvig>0){$todos=1;}
									else
									{
										$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
										$resv=mysql_query($sqlv,$linkbd);
										if(mysql_num_rows($resv)!=0){$todos=1;}
										else {$todos=0;}
									}
								}
								else
								{
									$correcto=0;
									echo "<script>despliegamodalm('visible','1','Su Busqueda NO corresponde a una Vigencia del SGR');</script>";
								}
							}
							else
							{
								$correcto=0;
								echo "<script>despliegamodalm('visible','1','La Vigencia para SGR se puede Consultar Maximo por 2 A�os');</script>";
							}
						}
					}
				}
				if($_POST[bc]!='')//**** busca cuenta
				{
					$nresul=buscacuentapres($_POST[cuenta],2);
					if($nresul!='')
					{
						$_POST[ncuenta]=$nresul;
						/*$linkbd=conectar_bd();
						$sqlr="select *from pptocuentas where cuenta=$_POST[cuenta] and vigencia=$vigusu";
						$res=mysql_query($sqlr,$linkbd);
						$row=mysql_fetch_row($res);
						$_POST[valor]=$row[5];
						$_POST[valor2]=$row[5];	*/
						echo"<script>document.form2.fecha.focus();document.form2.fecha.select();</script>";
					}
					else
					{
						$_POST[ncuenta]="";
						echo"<script>alert('Cuenta Incorrecta');document.form2.cuenta.focus();</script>";
					}
				}
			?>
			<table></table>
			<?php
				if ($_POST[oculto]==3)
				{
					//$vigencia=$_SESSION[vigencia];
					$fech1=split("/",$_POST[fecha]);
					$fech2=split("/",$_POST[fecha2]);
					$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
					$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
					$_POST[vigencia]=$fech1[2];
					$cuentaInicial='';
					$cuentaFinal='';
					$iter="zebra1";
					$iter2="zebra2";
					if(isset($_POST['cuenta1']))
					{
						if(!empty($_POST['cuenta1'])){$cuentaInicial=$_POST['cuenta1'];}
					}
					if(isset($_POST['cuenta2']))
					{
						if(!empty($_POST['cuenta2'])){$cuentaFinal=$_POST['cuenta2'];}
					}
					$cuentaPadre=Array();
					$vectorDif=Array();
					cuentasAux();
					$vectorBusqueda=explode("-",$_POST[filtros]);
					echo "
					<div class='subpantallac5' style='height:50%; width:99.6%; margin-top:0px; overflow-x:scroll' id='divdet'>
						<table class='inicio' align='center' id='valores' >
						<tr class='titulos'><td colspan='15'>.: Ejecucion Cuentas</td></tr>
						<tr class='titulos2'>
							<td id='col1' >Cuenta</td>
							<td id='col2' >Nombre</td>
							<td id='col3' >Fuentes</td>
							<td id='col4' >Presupuesto Inicial</td>
							<td id='col5' >Adicion</td>
							<td id='col6' >Reduccion</td>
							<td id='col7' >Credito</td>
							<td id='col8' >Contra Credito</td>
							<td id='col9' >Presupuesto Definitivo</td>
							<td id='col10' >Disponibilidad</td>
							<td id='col11' >Compromisos</td>
							<td id='col12' >Obligaciones</td>
							<td id='col13' >Pagos</td>
							<td id='col14' >Saldo Disponible</td>

						</tr>
						<tbody>";
					$elimina="DELETE FROM pptoejecucionpresu_gastos";
					mysql_query($elimina,$linkbd);
					for ($i=0; $i <sizeof($cuentaPadre) ; $i++) 
					{ 
						buscaCuentasHijo($cuentaPadre[$i]);
					}
					$sqlRep="SELECT * FROM meci_reportepersonalizado WHERE sist_cod='91' ORDER BY id_reporte";
					$resRep=mysql_query($sqlRep,$linkbd);
					$rowRep =mysql_fetch_row($resRep);
					$sqlReporte = $rowRep[5];
					

					$namearch="archivos/FORMATO_7_Ejecucion_Presupuestal_de_Gastos.csv";
					$Descriptor1 = fopen($namearch,"w+"); 
					$totPresuInicial=0;
					foreach ($cuentas as $key => $value) 
					{
						$numeroCuenta=$cuentas[$key]['numCuenta'];
						$nombreCuenta=$cuentas[$key]['nomCuenta'];
						$fuenteCuenta=$cuentas[$key]['fuenCuenta'];
						$presupuestoInicial=$cuentas[$key]['presuInicial'];
						$adicion=$cuentas[$key]['adicion'];
						$reduccion=$cuentas[$key]['reduccion'];
						$credito=$cuentas[$key]['credito'];
						$contracredito=$cuentas[$key]['conCredito'];
						$presupuestoDefinitivo=$cuentas[$key]['presuDefinitivo'];
						$cdp=$cuentas[$key]['cdp'];
						$rp=$cuentas[$key]['rp'];
						$cxp=$cuentas[$key]['cxp'];
						$egreso=$cuentas[$key]['egreso'];
						$saldo=$cuentas[$key]['saldo'];
						$tipo=$cuentas[$key]['tipo'];
						$tasa=$cuentas[$key]['tasa'];
						$entidad=$cuentas[$key]['entidad'];
						$style='';
						if(round($saldo,1)<0 || round($rp,1)>round($cdp,1) || round($egreso,1)>round($cxp,1) || round($cxp,1)>round($rp,1))
						{$style='background: yellow';}
						if($entidad=='externa'){$style='background: #BBDEFB';}
						if(!empty($numeroCuenta))
						{
							if($tipo=='Auxiliar' || $tipo=='auxiliar')
							{
								$totPresuInicial+=$cuentas[$key]['presuInicial'];
								$totAdiciones+=$cuentas[$key]['adicion'];
								$totReducciones+=$cuentas[$key]['reduccion'];
								$totCreditos+=$cuentas[$key]['credito'];
								$totContraCreditos+=$cuentas[$key]['conCredito'];
								$totCdp+=$cuentas[$key]['cdp'];
								$totRp+=$cuentas[$key]['rp'];
								$totCxp+=$cuentas[$key]['cxp'];
								$totEgresos+=$cuentas[$key]['egreso'];
								$totSaldos+=$cuentas[$key]['saldo'];
								$totPresuDefinitivo+=$cuentas[$key]['presuDefinitivo'];
								echo "
								<tr style='font-size:9px; text-rendering: optimizeLegibility;$style' class='$iter' ondblclick='direccionaCuentaGastos(this)'>
									<td id='1' style='width: 5%'>$numeroCuenta</td>
									<td id='2' style='width: 20%'>$nombreCuenta</td>
									<td id='3' style='width: 20%'>$fuenteCuenta</td>
									<td id='4' style='width: 5.5%'>".number_format($presupuestoInicial,2,",",".")."</td>
									<td id='5' style='width: 4.5%'>".number_format($adicion,2,",",".")."</td>
									<td id='6' style='width: 4.5%'>".number_format($reduccion,2,",",".")."</td>
									<td id='7' style='width: 4.5%'>".number_format($credito,2,",",".")."</td>
									<td id='8' style='width: 4.5%'>".number_format($contracredito,2,",",".")."</td>
									<td id='9' style='width: 5%'>".number_format($presupuestoDefinitivo,2,",",".")."</td>
									<td id='10' style='width: 4.5%'>".number_format($cdp,2,",",".")."</td>
									<td id='11' style='width: 4.5%'>".number_format($rp,2,",",".")."</td>
									<td id='12' style='width: 4.5%'>".number_format($cxp,2,",",".")."</td>
									<td id='13' style='width: 4.5%'>".number_format($egreso,2,",",".")."</td>
									<td id='14' style='width: 4.5%'>".number_format($saldo,2,",",".")."</td>
								</tr>";
							}
							else
							{
								echo "
								<tr style='font-weight:bold; font-size:9px; text-rendering: optimizeLegibility' class='$iter'>
									<td id='1' style='width: 5%'>$numeroCuenta</td>
									<td id='2' style='width: 20%'>$nombreCuenta</td>
									<td id='3' style='width: 20%'>$fuenteCuenta</td>
									<td id='4' style='width: 5.5%'>".number_format($presupuestoInicial,2,",",".")."</td>
									<td id='5' style='width: 4.5%'>".number_format($adicion,2,",",".")."</td>
									<td id='6' style='width: 4.5%'>".number_format($reduccion,2,",",".")."</td>
									<td id='7' style='width: 4.5%'>".number_format($credito,2,",",".")."</td>
									<td id='8' style='width: 4.5%'>".number_format($contracredito,2,",",".")."</td>
									<td id='9' style='width: 5%'>".number_format($presupuestoDefinitivo,2,",",".")."</td>
									<td id='10' style='width: 4.5%'>".number_format($cdp,2,",",".")."</td>
									<td id='11' style='width: 4.5%'>".number_format($rp,2,",",".")."</td>
									<td id='12' style='width: 4.5%'>".number_format($cxp,2,",",".")."</td>
									<td id='13' style='width: 4.5%'>".number_format($egreso,2,",",".")."</td>
									<td id='14' style='width: 4.5%'>".number_format($saldo,2,",",".")."</td>
								</tr>";
							}
							$inserta="INSERT INTO pptoejecucionpresu_gastos(cuenta,nombre,pptoinicial,adicion,reduccion,credito, contracredito, pptodefinitivo,cdp,rp,cxp,egreso,saldo_dispo,unidad,vigencia) VALUES ('$numeroCuenta','$nombreCuenta','$presupuestoInicial', '$adicion','$reduccion','$credito','$contracredito','$presupuestoDefinitivo','$cdp','$rp','$cxp','$egreso', '$saldo','central','$_POST[vigencia]')";
							mysql_query($inserta,$linkbd);
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
						echo "<input type='hidden' name='cuenta[]' id='cuenta[]' value='".$numeroCuenta."' />";
						echo "<input type='hidden' name='nombre[]' id='nombre[]' value='".$nombreCuenta."' />";

						echo "<input type='hidden' name='fuente[]' id='fuente[]' value='".$fuenteCuenta."' />";
						echo "<input type='hidden' name='pid[]' id='pid[]' value='".$presupuestoInicial."' />";
						echo "<input type='hidden' name='adc[]' id='adc[]' value='".$adicion."' />";
						echo "<input type='hidden' name='red[]' id='red[]' value='".$reduccion."' />";
						echo "<input type='hidden' name='cred[]' id='cred[]' value='".$credito."' />";
						echo "<input type='hidden' name='contra[]' id='contra[]' value='".$contracredito."' />";
						echo "<input type='hidden' name='ppto[]' id='ppto[]' value='".$presupuestoDefinitivo."' />";
						echo "<input type='hidden' name='cdpd[]' id='cdpd[]' value='".$cdp."' />";
						echo "<input type='hidden' name='rpd[]' id='rpd[]' value='".$rp."' />";
						echo "<input type='hidden' name='cxpd[]' id='cxpd[]' value='".$cxp."' />";
						echo "<input type='hidden' name='egd[]' id='egd[]' value='".$egreso."' />";
						echo "<input type='hidden' name='tipo[]' id='tipo[]' value='".$tipo."' />";
						echo "<input type='hidden' name='saldos[]' id='saldos[]' value='".$saldo."' />";
					}
					$result=mysql_query($sqlReporte,$linkbd);
					while ($row =mysql_fetch_assoc($result)) 
					{
						fputs($Descriptor1,$row['Codigo'].",".$row['Descripcion'].",".$row['FuenteDeRecursos'].",".$row['ApropiacionInicial'].",".$row['Adiciones'].",".$row['Reducciones'].",".$row['Creditos'].",".$row['Contracreditos'].",".$row['ApropiacionDefinitiva'].",".$row['Compromisos'].",".$row['SaldoPorComprometer'].",".$row['Obligaciones'].",".$row['CompromisosPorEjecutar'].",".$row['Pagos'].",".$row['ObligacionesPorPagar']."\r\n");
					}
					fclose($Descriptor1);
					echo "</tbody></table>
					</div>";
					echo "
					<div class='subpantallac5' style='height:20%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>
						<table class='inicio' align='center' id='valores' >
							<tr>
								<td class='saludo1'>Presupueso Inicial</td>
								<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totPresuInicial)."</td>
								<td class='saludo1'>Adiciones</td>
								<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totAdiciones)."</td>
								<td class='saludo1'>Reducciones</td>
								<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totReducciones)."</td>
								<td class='saludo1'>Creditos</td>
								<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totCreditos)."</td>
								<td class='saludo1' colspan='4'>Contracreditos</td>
								<td style='width:6%;border-right: 1px solid gray'>$".number_format($totContraCreditos)."</td>
							</tr>
							<tr>
								<td class='saludo1'>Presupueso Definitivo</td>
								<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totPresuDefinitivo)."</td>
								<td class='saludo1'>CDP</td>
								<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totCdp)."</td>
								<td class='saludo1'>RP</td>
								<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totRp)."</td>
								<td class='saludo1'>CXP</td>
								<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totCxp)."</td>
								<td class='saludo1'>Egresos</td>
								<td style='width:6%;border-right: 1px solid gray'>$".number_format($totEgresos)."</td>
								<td class='saludo1' colspan='2'>Saldo</td>
								<td style='width:6%;border-right: 1px solid gray'>$".number_format($totSaldos)."</td>
							</tr>
						</table>
					</div>
					<script>document.getElementById('divcarga').style.display='none';</script>";
				}
				function generarUnidad($conector,$tabla,$arreglo)
				{
					$resultado="$conector ";
					$tiene=false;
					$unidades="";
					for($i=0;$i<count($arreglo); $i++ )
					{
						$unidades.=($arreglo[$i]).",";
					}
					$unidades=substr($unidades,0,-1);
					$resultado.="$tabla.unidad IN ($unidades)";
					return $resultado;
				}
				function cuentasAux()
				{
					global $cuentas,$linkbd,$vigencia,$f1,$f2,$cuentaPadre,$cuentaInicial,$cuentaFinal,$vectorDif;
					$datosBase=datosiniciales();
					$orden='cuenta';
					$buqueda=" ";
					$vectorBusqueda=explode("-",$_POST[filtros]);
					if($vectorBusqueda[0]==''){unset($vectorBusqueda);}
					$vectorBusquedaClases=explode("-",$_POST[filtrosclases]);
					$tieneAntes=false;
					$sqlunidadext="SELECT * FROM entidadesgastos";
					$tabla2="";
					$bentidades="";
					$condtercero="";
					$tablatercero="";
					$agregado="";
					if(isset($_POST[agregado]))
					{
						$agregado="AND pptocuentas.nomina='S' ";
						if(sizeof($vectorBusqueda)>=1)
						{
							$bentidades="UNION SELECT pptocuentasentidades.cuenta,pptocuentasentidades.nombre,pptocuentasentidades.tipo,pptocuentasentidades.futfuentefunc,pptocuentasentidades.futfuenteinv,SUBSTR(pptocuentasentidades.cuenta,1,1) AS c,pptocuentasentidades.regalias,pptocuentasentidades.vigencia,pptocuentasentidades.vigenciaf,pptocuentas_pos.entidad,pptocuentas_pos.posicion,pptocuentas_pos.cuentapos FROM pptocuentasentidades,pptocuentas_pos WHERE pptocuentasentidades.estado='S' AND pptocuentasentidades.clasificacion NOT LIKE '%ingresos%' AND (pptocuentasentidades.vigencia=$vigencia OR pptocuentasentidades.vigenciaf=$vigencia) AND pptocuentas_pos.cuentapos = pptocuentasentidades.cuenta AND pptocuentas_pos.entidad='externa' AND pptocuentasentidades.tipo='Auxiliar' ".generarUnidad("AND","pptocuentasentidades",$vectorBusqueda);
						}
						else
						{
							$bentidades="UNION SELECT pptocuentasentidades.cuenta,pptocuentasentidades.nombre,pptocuentasentidades.tipo,pptocuentasentidades.futfuentefunc,pptocuentasentidades.futfuenteinv,SUBSTR(pptocuentasentidades.cuenta,1,1) AS c,pptocuentasentidades.regalias,pptocuentasentidades.vigencia,pptocuentasentidades.vigenciaf,pptocuentas_pos.entidad,pptocuentas_pos.posicion,pptocuentas_pos.cuentapos FROM pptocuentasentidades,pptocuentas_pos WHERE pptocuentasentidades.estado='S' AND pptocuentasentidades.clasificacion NOT LIKE '%ingresos%' AND (pptocuentasentidades.vigencia=$vigencia OR pptocuentasentidades.vigenciaf=$vigencia) AND pptocuentas_pos.cuentapos = pptocuentasentidades.cuenta AND pptocuentas_pos.entidad='externa' AND pptocuentasentidades.tipo='Auxiliar' ";
						}
					}
					if(sizeof($vectorBusqueda)>=1)
					{
						if(!$tieneAntes){$buqueda.=generarUnidad("AND","pptocuentas",$vectorBusqueda);}
						else{$buqueda.=generarUnidad("OR","pptocuentas",$vectorBusqueda);}
					}
					$tieneAntes=false;
					$regalias="AND pptocuentas.regalias='N' ";
					for($i=0;$i<sizeof($vectorBusquedaClases); $i++)
					{
						if($vectorBusquedaClases[$i]=='13')
						{
							$regalias="";
							if(!$tieneAntes){$buqueda.=" AND (pptocuentas.clasificacion LIKE '%reservas-gastos%'";}
							else {$buqueda.=" OR pptocuentas.clasificacion LIKE '%reservas-gastos%'";}
							$tieneAntes=true;
						}
						if($vectorBusquedaClases[$i]=='14')
						{
							$regalias="";
							if(!$tieneAntes){$buqueda.=" AND (pptocuentas.clasificacion LIKE '%sgr-gastos%'";}
							else {$buqueda.=" OR pptocuentas.clasificacion LIKE '%sgr-gastos%'";}
							$tieneAntes=true;
						}
						if($vectorBusquedaClases[$i]=='12')
						{
							$regalias="";
							if(!$tieneAntes){$buqueda.=" AND (pptocuentas.clasificacion LIKE '%inversion%'";}
							else {$buqueda.=" OR pptocuentas.clasificacion LIKE '%inversion%'";}
							$tieneAntes=true;
						}
						if($vectorBusquedaClases[$i]=='10')
						{
							$regalias="";
							if(!$tieneAntes){$buqueda.=" AND (pptocuentas.clasificacion LIKE '%deuda%'";}
							else {$buqueda.=" OR pptocuentas.clasificacion LIKE '%deuda%'";}
							$tieneAntes=true;
						}
						if($vectorBusquedaClases[$i]=='11')
						{
							$regalias="";
							if(!$tieneAntes){$buqueda.=" AND (pptocuentas.clasificacion LIKE '%funcionamiento%'";}
							else {$buqueda.=" OR pptocuentas.clasificacion LIKE '%funcionamiento%'";}
							$tieneAntes=true;
						}
					}
					if(isset($_POST[regalias]))
					{
						if(!empty($_POST[regalias])){$regalias="AND pptocuentas.regalias='S' ";}
					}
					$pos=stripos($buqueda,"pptocuentas.clasificacion");
					if($pos!=null){$buqueda.=")";}
					if(isset($_POST[sectores]))
					{
						if(!empty($_POST[sectores]))
						{
							$buqueda.=" AND pptocuentas_sectores.cuenta=pptocuentas.cuenta AND pptocuentas_sectores.sector LIKE '%$_POST[sectores]%' AND (pptocuentas_sectores.vigenciai=$vigencia OR pptocuentas_sectores.vigenciaf=$vigencia)";
							$tabla2=",pptocuentas_sectores";
						}
					}
					if(isset($_POST[ffunc]))
					{
						if(!empty($_POST[ffunc])){$buqueda.="AND (pptocuentas.futfuentefunc=$_POST[ffunc] OR pptocuentas.futfuenteinv=$_POST[ffunc])";}
					}
					if(empty($cuentaInicial) || empty($cuentaFinal))
					{
						$sql="SELECT * FROM (SELECT pptocuentas.cuenta,pptocuentas.nombre,pptocuentas.tipo,pptocuentas.futfuentefunc,pptocuentas.futfuenteinv,SUBSTR(pptocuentas.cuenta,1,1) AS c,pptocuentas.regalias,pptocuentas.vigencia,pptocuentas.vigenciaf,pptocuentas_pos.entidad,pptocuentas_pos.posicion,pptocuentas_pos.cuentapos FROM pptocuentas,pptocuentas_pos $tabla2  WHERE pptocuentas.estado='S' AND pptocuentas.clasificacion NOT LIKE '%ingresos%' $regalias AND (pptocuentas.vigencia=$vigencia OR pptocuentas.vigenciaf=$vigencia) AND pptocuentas_pos.cuentapos = pptocuentas.cuenta AND pptocuentas_pos.tipo='gastos'   AND pptocuentas_pos.entidad='interna' AND pptocuentas_pos.vigencia=$vigencia  $agregado $buqueda $bentidades ) AS tabla ORDER BY posicion,cuentapos,entidad DESC";
					}
					else
					{
						$sql="SELECT * FROM (SELECT pptocuentas.cuenta,pptocuentas.nombre,pptocuentas.tipo,pptocuentas.futfuentefunc,pptocuentas.futfuenteinv,SUBSTR(pptocuentas.cuenta,1,1) AS c,pptocuentas.regalias,pptocuentas.vigencia,pptocuentas.vigenciaf,pptocuentas_pos.entidad,pptocuentas_pos.posicion,pptocuentas_pos.cuentapos FROM pptocuentas,pptocuentas_pos $tabla2  WHERE pptocuentas.estado='S' AND pptocuentas.clasificacion NOT LIKE '%ingresos%' $regalias AND (pptocuentas.vigencia=$vigencia OR pptocuentas.vigenciaf=$vigencia) AND pptocuentas_pos.cuentapos = pptocuentas.cuenta AND pptocuentas_pos.tipo='gastos' AND  pptocuentas_pos.entidad='interna' AND pptocuentas_pos.vigencia=$vigencia  $agregado AND pptocuentas.cuenta between '$cuentaInicial' AND '$cuentaFinal' $buqueda $bentidades) AS tabla ORDER BY posicion,cuentapos,entidad DESC";
					}
					$result=mysql_query($sql,$linkbd);
					while($row = mysql_fetch_array($result))
					{
						if($row[9]=='interna')
						{
							if($row[2]=='Auxiliar' || $row[2]=='auxiliar')
							{
								$arregloCuenta=generaReporteGastos($row[0],$vigencia,$f1,$f2,$row[6],$row[7],$row[8],"N");
								$cuentas[$row[0]]["numCuenta"]=$row[0];
								$cuentas[$row[0]]["nomCuenta"]=$row[1];
								$cuentas[$row[0]]["presuInicial"]=$arregloCuenta[0];
								$cuentas[$row[0]]["fuenCuenta"]=obtenerFuente($row[3],$row[4]);
								$cuentas[$row[0]]["adicion"]=$arregloCuenta[1];
								$cuentas[$row[0]]["reduccion"]=$arregloCuenta[2];
								$cuentas[$row[0]]["credito"]=$arregloCuenta[3];
								$cuentas[$row[0]]["conCredito"]=$arregloCuenta[4];
								$cuentas[$row[0]]["presuDefinitivo"]=$arregloCuenta[5];
								$cuentas[$row[0]]["cdp"]=$arregloCuenta[6];
								$cuentas[$row[0]]["rp"]=$arregloCuenta[7];
								$cuentas[$row[0]]["cxp"]=$arregloCuenta[8];
								$cuentas[$row[0]]["egreso"]=$arregloCuenta[9];
								$cuentas[$row[0]]["saldo"]=$arregloCuenta[10];
								$cuentas[$row[0]]["tipo"]="Auxiliar";
								$cuentas[$row[0]]["entidad"]=$row[9];
							}
							else
							{
								$cuentas[$row[0]]["numCuenta"]=$row[0];
								$cuentas[$row[0]]["nomCuenta"]=$row[1];
								$cuentas[$row[0]]["presuInicial"]=0;
								$cuentas[$row[0]]["fuenCuenta"]=obtenerFuente($row[3],$row[4]);
								$cuentas[$row[0]]["adicion"]=0;
								$cuentas[$row[0]]["reduccion"]=0;
								$cuentas[$row[0]]["credito"]=0;
								$cuentas[$row[0]]["conCredito"]=0;
								$cuentas[$row[0]]["presuDefinitivo"]=0;
								$cuentas[$row[0]]["cdp"]=0;
								$cuentas[$row[0]]["rp"]=0;
								$cuentas[$row[0]]["cxp"]=0;
								$cuentas[$row[0]]["egreso"]=0;
								$cuentas[$row[0]]["saldo"]=0;
								$cuentas[$row[0]]["tipo"]="Mayor";
								$cuentas[$row[0]]["entidad"]=$row[9];
								$cuentaPadre[]=$row[0];
							}
						}
						else
						{
							$vectorcuentas=generaReporteExterno($row[0],$vigencia,$f1,$f2);
							$cuentas[$row[0]]["numCuenta"]=$row[0];
							$cuentas[$row[0]]["nomCuenta"]=$row[1];
							$cuentas[$row[0]]["presuInicial"]=$vectorcuentas[0];
							$cuentas[$row[0]]["fuenCuenta"]=obtenerFuente($row[3],$row[4]);
							$cuentas[$row[0]]["adicion"]=$vectorcuentas[1];
							$cuentas[$row[0]]["reduccion"]=$vectorcuentas[2];
							$cuentas[$row[0]]["credito"]=$vectorcuentas[3];
							$cuentas[$row[0]]["conCredito"]=$vectorcuentas[4];
							$cuentas[$row[0]]["presuDefinitivo"]=$vectorcuentas[5];
							$cuentas[$row[0]]["cdp"]=$vectorcuentas[6];
							$cuentas[$row[0]]["rp"]=$vectorcuentas[7];
							$cuentas[$row[0]]["cxp"]=$vectorcuentas[8];
							$cuentas[$row[0]]["egreso"]=$vectorcuentas[10];
							$cuentas[$row[0]]["saldo"]=$vectorcuentas[11];
							$cuentas[$row[0]]["tipo"]=$row[2];
							$cuentas[$row[0]]["entidad"]=$row[9];
						}
					}
				}
				function cantidadCuentas($cuentas)
				{
					global $linkbd;
					$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '%-$cuenta.%' AND estado='S' AND clasificacion NOT LIKE '%ingresos%' AND vigencia=$vigencia AND (tipo='Auxiliar' OR tipo='auxiliar')";
					$res=mysql_query($sql,$linkbd);
					return mysql_num_rows($res);
				}
				function buscaCuentasHijo($cuenta)
				{
					global $cuentas,$linkbd,$vigencia,$f1,$f2,$cuentaPadre;
					$arreglo=Array('0','1','2','3','4','5','6','7','8','9');
					$numcuenta=strlen($cuenta);
					$cuentaPunto = strpos($cuenta,'.');
					$cuentaGuion = strpos($cuenta,'-');
					if($cuenta=="01-A.1"){$cuenta=$cuenta.".";}
					if($cuenta=="01-A.1.1"){$cuenta=$cuenta.".";}
					if($cuenta=="02-A.1"){$cuenta=$cuenta.".";}
					if($cuenta=="02-A.1.1"){$cuenta=$cuenta.".";}
					//if($cuenta=="02-A.1.1.3.1"){$cuenta=$cuenta.".1.1.";}
					
					//if($cuenta=="4.1"){$cuenta=$cuenta.".";}
					if(($numcuenta==1 || $numcuenta==2) && cantidadCuentas($cuenta)>0)
					{
						$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '%-$cuenta.%' AND estado='S' AND clasificacion NOT LIKE '%ingresos%' AND (vigencia=$vigencia OR vigenciaf=$vigencia) AND (tipo='Auxiliar' OR tipo='auxiliar')";
					}
					else
					{
						if($cuentaPunto==1 && $cuentaGuion==false)
						{
							$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '$cuenta.%' AND estado='S' AND clasificacion NOT LIKE '%ingresos%' AND (vigencia=$vigencia OR vigenciaf=$vigencia) AND (tipo='Auxiliar' OR tipo='auxiliar')";
						}
						else
						{
							$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '$cuenta%' AND estado='S' AND clasificacion NOT LIKE '%ingresos%' AND (vigencia=$vigencia OR vigenciaf=$vigencia) AND (tipo='Auxiliar' OR tipo='auxiliar')";
						}
						
					}
					$result=mysql_query($sql,$linkbd);
					$acumpptoini=0.0;
					$acumadic=0.0;
					$acumredu=0.0;
					$acumcred=0.0;
					$acumcontra=0.0;
					$acumpptodef=0.0;
					$acumcdp=0.0;
					$acumrp=0.0;
					$acumcxp=0.0;
					$acumegreso=0.0;
					$acumsaldo=0.0;
					while($row = mysql_fetch_array($result))
					{
						if($cuentas[$row[0]]["entidad"]=="interna")
						{
							$acumpptoini+=$cuentas[$row[0]]["presuInicial"];
							$acumadic+=$cuentas[$row[0]]["adicion"];
							$acumredu+=$cuentas[$row[0]]["reduccion"];
							$acumcred+=$cuentas[$row[0]]["credito"];
							$acumcontra+=$cuentas[$row[0]]["conCredito"];
							$acumcdp+=$cuentas[$row[0]]["cdp"];
							$acumrp+=$cuentas[$row[0]]["rp"];
							$acumcxp+=$cuentas[$row[0]]["cxp"];
							$acumegreso+=$cuentas[$row[0]]["egreso"];
							$acumsaldo+=$cuentas[$row[0]]["saldo"];
							$acumpptodef+=$cuentas[$row[0]]["presuDefinitivo"];
						}
					}
					$sql="SELECT cuenta FROM pptocuentasentidades WHERE cuenta LIKE '$cuenta%' AND estado='S' AND clasificacion NOT LIKE '%ingresos%' AND vigencia=$vigencia AND (tipo='Auxiliar' OR tipo='auxiliar') ";
					$result=mysql_query($sql,$linkbd);
					while($row = mysql_fetch_array($result))
					{
						if($cuentas[$row[0]]["entidad"]=="externa")
						{
							$acumpptoini+=$cuentas[$row[0]]["presuInicial"];
							$acumadic+=$cuentas[$row[0]]["adicion"];
							$acumredu+=$cuentas[$row[0]]["reduccion"];
							$acumcred+=$cuentas[$row[0]]["credito"];
							$acumcontra+=$cuentas[$row[0]]["conCredito"];
							$acumcdp+=$cuentas[$row[0]]["cdp"];
							$acumrp+=$cuentas[$row[0]]["rp"];
							$acumcxp+=$cuentas[$row[0]]["cxp"];
							$acumegreso+=$cuentas[$row[0]]["egreso"];
							$acumsaldo+=$cuentas[$row[0]]["saldo"];
							$acumpptodef+=$cuentas[$row[0]]["presuDefinitivo"];
						}
					}
					if($cuenta=="01-A.1."){$cuenta=substr($cuenta,0,strlen($cuenta)-1);}
					if($cuenta=="01-A.1.1."){$cuenta=substr($cuenta,0,strlen($cuenta)-1);}
					if($cuenta=="02-A.1."){$cuenta=substr($cuenta,0,strlen($cuenta)-1);}
					if($cuenta=="02-A.1.1."){$cuenta=substr($cuenta,0,strlen($cuenta)-1);}
					if($cuenta=="4.1."){$cuenta=substr($cuenta,0,strlen($cuenta)-1);}
					$cuentas[$cuenta]["presuInicial"]=$acumpptoini;
					$cuentas[$cuenta]["adicion"]=$acumadic;
					$cuentas[$cuenta]["reduccion"]=$acumredu;
					$cuentas[$cuenta]["credito"]=$acumcred;
					$cuentas[$cuenta]["conCredito"]=$acumcontra;
					$cuentas[$cuenta]["cdp"]=$acumcdp;
					$cuentas[$cuenta]["rp"]=$acumrp;
					$cuentas[$cuenta]["cxp"]=$acumcxp;
					$cuentas[$cuenta]["egreso"]=$acumegreso;
					$cuentas[$cuenta]["saldo"]=$acumsaldo;
					$cuentas[$cuenta]["presuDefinitivo"]=$acumpptodef;
				}
				function obtenerFuente($fuenFuncion,$fuenInversion)
				{
					global $linkbd;
					$codigo='';
					$nombre='';
					if(!empty($fuenFuncion) && $fuenFuncion!=null){$sql="SELECT codigo,nombre FROM pptofutfuentefunc WHERE codigo=$fuenFuncion";}
					else{$sql="SELECT codigo,nombre FROM pptofutfuenteinv WHERE codigo=$fuenInversion";}
					$result=mysql_query($sql,$linkbd);
					while($row = mysql_fetch_array($result))
					{
						$codigo = $row[0];
						$nombre = $row[1];
						break;
					}
					return $codigo." - ".$nombre;
				}
				function generaCuenta($cuenta)
				{
					global $cuentas;
					$arreglo=Array($cuentas[$cuenta]['presuInicial'],$cuentas[$cuenta]['adicion'],$cuentas[$cuenta]['reduccion'],$cuentas[$cuenta]['credito'],$cuentas[$cuenta]['conCredito'],$cuentas[$cuenta]['presuDefinitivo'],$cuentas[$cuenta]['cdp'],$cuentas[$cuenta]['rp'],$cuentas[$cuenta]['cxp'],$cuentas[$cuenta]['egreso'],$cuentas[$cuenta]['saldo']);
					return $arreglo;
				}
			?>
			<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
					</IFRAME>
				</div>
			</div>
		</form>
		<script type="text/javascript">
			jQuery(function($)
			{
				if(jQuery)
				{
					var countChecked = function() 
					{
						var texto="";
						$("input[name=unidad]").change(
							function()
							{
								if($(this).attr("class")=="01" && $(this).is(":checked"))
								{
									$('input[name=clasifica]').attr("disabled",false);
									$('input[name=clasifica]').closest('label').css('color','black');
								}
								else if($(this).attr("class")=="01" && !($(this).is(":checked")))
								{
									if($("input[name=unidad][class=02]").is(":checked") || $("input[name=unidad][class=03]").is(":checked"))
									{
										$('input[name=clasifica]').not(document.getElementById( "14" )).attr("disabled",true);
										$('input[name=clasifica]').not(document.getElementById( "14" )).closest('label').css('color','#BDBDBD');
									}
									else
									{
										$('input[name=clasifica]').attr("disabled",true);
										$('input[name=clasifica]').closest('label').css('color','#BDBDBD');
									}
									$('input[name=clasifica]').attr("checked",false);
								}
								if($(this).attr("class")=="02" && $(this).is(":checked"))
								{
									$('input[name=clasifica][id=14]').attr("disabled",false);
									$('input[name=clasifica][id=14]').closest('label').css('color','black');
								}
								else if($(this).attr("class")=="02" && !($(this).is(":checked")))
								{
									if($("input[name=unidad][class=01]").is(":checked") || $("input[name=unidad][class=03]").is(":checked"))
									{
										$('input[name=clasifica][id=14]').attr("disabled",false);
										$('input[name=clasifica][id=14]').closest('label').css('color','black');
									}
									else
									{
										$('input[name=clasifica][id=14]').attr("disabled",true);
										$('input[name=clasifica][id=14]').closest('label').css('color','#BDBDBD');
									}
									$('input[name=clasifica][id=14]').attr("checked",false);
								}
								if($(this).attr("class")=="03" && $(this).is(":checked"))
								{
									$('input[name=clasifica][id=14]').attr("disabled",false);
									$('input[name=clasifica][id=14]').closest('label').css('color','black');
								}
								else if($(this).attr("class")=="03" && !($(this).is(":checked")))
								{
									if($("input[name=unidad][class=01]").is(":checked") || $("input[name=unidad][class=02]").is(":checked"))
									{
										$('input[name=clasifica][id=14]').attr("disabled",false);
										$('input[name=clasifica][id=14]').closest('label').css('color','black');
									}
									else
									{
										$('input[name=clasifica][id=14]').attr("disabled",true);
										$('input[name=clasifica][id=14]').closest('label').css('color','#BDBDBD');
									}
									$('input[name=clasifica][id=14]').attr("checked",false);
								}
							}
						);
						$( "input[name=unidad]:checked" ).each(
							function(){texto+=($(this).attr('class'))+"-";}
						);
						if(texto==''){$( "#texto" ).text("Selecciona...");}
						else
						{
							$( "#texto" ).text(texto.substring(0,texto.length-1));
							$('input[name=filtros]').val(texto.substring(0,texto.length-1));
						}
					};
					var countChecked1 = function() 
					{
						var texto="";
						$( "input[name=clasifica]:checked" ).each(function(){ texto+=($(this).attr('id'))+"-"; });
						if(texto==''){ $( "#texto1" ).text("Selecciona..."); }
						else
						{
							$( "#texto1" ).text(texto.substring(0,texto.length-1));
							$('input[name=filtrosclases]').val(texto.substring(0,texto.length-1));
						}
					};
					countChecked();
					countChecked1();
					$( "input[name=unidad][type=checkbox]" ).on( "click", countChecked );
					$( "input[name=clasifica][type=checkbox]" ).on( "click", countChecked1 );
					$('#valores tbody tr:first-child td').each(
						function(index, el) 
						{
							if($(this).attr('id')=='1'){$('#col1').css('width',$(this).css('width'));}
							if($(this).attr('id')=='2'){$('#col2').css('width',$(this).css('width'));}
							if($(this).attr('id')=='3'){$('#col3').css('width',$(this).css('width'));}
							if($(this).attr('id')=='4'){$('#col4').css('width',$(this).css('width'));}
							if($(this).attr('id')=='5'){$('#col5').css('width',$(this).css('width'));}
							if($(this).attr('id')=='6'){$('#col6').css('width',$(this).css('width'));}
							if($(this).attr('id')=='7'){$('#col7').css('width',$(this).css('width'));}
							if($(this).attr('id')=='8'){$('#col8').css('width',$(this).css('width'));}
							if($(this).attr('id')=='9'){$('#col9').css('width',$(this).css('width'));}
							if($(this).attr('id')=='10'){$('#col10').css('width',$(this).css('width'));}
							if($(this).attr('id')=='11'){$('#col11').css('width',$(this).css('width'));}
							if($(this).attr('id')=='12'){$('#col12').css('width',$(this).css('width'));}
							if($(this).attr('id')=='13'){$('#col13').css('width',$(this).css('width'));}
							if($(this).attr('id')=='14'){$('#col14').css('width',$(this).css('width'));}
							if($(this).attr('id')=='15'){$('#col15').css('width',$(this).css('width'));}
						}
					);
				}
			});	
		</script>
		<script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('¿Realmente desea cambiar la vigencia?');
   if(confirma){
    var anobloqueo=bloqueo.split("-");
    var ano=anobloqueo[0];
    if(valor < ano){
      if(confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar")){
        $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
      }else{
        location.reload();
      }

    }else{
      $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
    }
    
   }else{
   	location.reload();
   }
   
 });

 function updateresponse(data){
  json=eval(data);
  if(json[0].respuesta=='2'){
    alert("Vigencia modificada con exito");
  }else if(json[0].respuesta=='3'){
    alert("Error al modificar la vigencia");
  }
  location.reload();
 }
 function selectresponse(data){ 
  json=eval(data);
  $('#cambioVigencia').val(json[0].vigencia);
  bloqueo=json[0].bloqueo;
 }

 }); 
</script>
</body>
</html>