<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	require 'conversor.php';
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota"); 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>:: SPID - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script >
			function validar(){document.form2.submit();}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden") {document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.form2.oculto.value=2;
						document.form2.submit();
					break;
				}
			}
			function funcionmensaje(){}
			function guardar()
			{
				if (document.form2.fecha.value!=''){despliegamodalm('visible','4','Esta Seguro de Reflejar','1');}
				else{despliegamodalm('visible','2','Faltan datos para poder Reflejar');}
			}
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					document.form2.action="cont-industriaver-reflejar.php";
					document.form2.submit();
				}
			}
			function atrasc()
			{
				if(document.form2.ncomp.value>1)
 				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					document.form2.action="cont-industriaver-reflejar.php";
					document.form2.submit();
 				}
			}
			function validar2()
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.idcomp.value;
				document.form2.action="cont-industriaver-reflejar.php";
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
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='cont-buscaindustria-reflejar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/reflejar1.png" onClick="guardar()" class="mgbt"  title="Reflejar"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='cont-reflejardocs.php'" class="mgbt"></td>
			</tr>
		</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			$sqlr="SELECT * FROM admbloqueoanio";
			$res=mysql_query($sqlr,$linkbd);
			$_POST['anio']=array();
			$_POST['bloqueo']=array();
			while ($row =mysql_fetch_row($res))
			{
				$_POST['anio'][]=$row[0];
				$_POST['bloqueo'][]=$row[1];
			}
			 //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
			if($_GET['consecutivo']!=""){echo "<script>document.getElementById('codrec').value='".$_GET['consecutivo']."';</script>";}
			if($_POST['oculto']=="")
			{
				$sqlr="SELECT tmindustria,desindustria,desavisos,desbomberil,intindustria,intavisos,intbomberil FROM tesoparametros";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res))
				{
					$_POST['salariomin']=$row[0];
					$_POST['descunidos']="$row[1]$row[2]$row[3]";
					$_POST['intecunidos']="$row[4]$row[5]$row[6]";
				}
				$sqlr="SELECT max(id_industria) FROM tesoindustria ";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				$r=mysql_fetch_row($res);
				$_POST['maximo']=$r[0];
				if ($_POST['codrec']!="" || $_GET['consecutivo']!="")
				{
					if($_POST['codrec']!=""){$sqlr="SELECT * FROM tesoindustria WHERE id_industria='".$_POST['codrec']."'";}
					else{$sqlr="SELECT * FROM tesoindustria WHERE id_industria='".$_GET['consecutivo']."'";}
				}
				else{$sqlr="SELECT max(id_industria) FROM tesoindustria";}
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				$_POST['idcomp']=$r[0];
				$_POST['ncomp']=$r[0];
				$check1="checked";
				$_POST['valor']=0;
			}
			$sqlr="SELECT * FROM tesoindustria WHERE id_industria='".$_POST['idcomp']."'";
			$res=mysql_query($sqlr,$linkbd);
			$consec=0;
			while($r=mysql_fetch_row($res))
			{
				$_POST['vigencia']=$r[2];
				$_POST['fecha']=$r[1];
				$_POST['idcomp']=$r[0];
				$_POST['ageliquida']=$r[3];
				$_POST['tipomov']=$r[4];
				$_POST['tercero']=$r[5];
				$_POST['ntercero']=buscatercero($r[5]);	
				if($r[7]=='N'){$_POST['estadoc']="ANULADO";}
				if($r[7]=='P'){$_POST['estadoc']="PAGO";}	
				if($r[7]=='S'){$_POST['estadoc']="ACTIVO";}
				$sqlr="select * from tesoindustria_det where id_industria='".$_POST['idcomp']."'";
				$res2=mysql_query($sqlr,$linkbd);
				while($r2=mysql_fetch_row($res2))
				{	
					$_POST['industria']=$r2[1];
					$_POST['avisos']=$r2[2];
					$_POST['sanciones']=$r2[5];
					$_POST['retenciones']=$r2[4];
					$_POST['bomberil']=$r2[3];
					$_POST['valortotal']=$r2[7];
					$_POST['intereses']=$r2[25];
					$_POST['interesesind']=$r2[26];
					$_POST['interesesavi']=$r2[27];
					$_POST['interesesbom']=$r2[28];
					$_POST['antivigant']=$r2[10];
					$_POST['antivigact']=$r2[11];
					$_POST['saldopagar']=$r2[8];
					$_POST['descuenindus']=$r2[22];
					$_POST['descuenaviso']=$r2[23];
					$_POST['descuenbombe']=$r2[24];
					if(($r2[22]+$r2[23]+$r2[24])>0)
					{
						$_POST['descuenindus']=$r2[22];//descuento industria
						$_POST['descuenaviso']=$r2[23];//descuento avisos
						$_POST['descuenbombe']=$r2[24];//descuento bomberil
					}
					else
					{
						if($r2[13]>0)
						{
							if(buscaconcontalbles('02','P14',$vigusu)>0)
							{
								if(substr($_POST['descunidos'], -3, 1)=='S')
								{
									if($row[22]>0){$_POST['descuenindus']=$row[22];}
									else {$_POST['descuenindus']=$r2[1]*($r2[13]/100);}
								}
								else{$_POST['descuenindus']=0;}
							}
							else {$_POST['descuenindus']=0;}
							if(buscaconcontalbles('02','P15',$vigusu)>0)
							{
								if(substr($_POST['descunidos'], -2, 1)=='S')
								{
									if($row[23]>0){$_POST['descuenaviso']=$row[23];}
									else{$_POST['descuenaviso']=$r2[2]*($r2[13]/100);}
								}
								else {$_POST['descuenaviso']=0;}
							}
							else {$_POST['descuenaviso']=0;}
							if(buscaconcontalbles('02','P10',$vigusu)>0)
							{	
								if(substr($_POST['descunidos'], -1, 1)=='S')
								{
									if($row[24]>0){$_POST['descuenbombe']=$row[24];}
									else {$_POST['descuenbombe']=$r2[3]*($r2[13]/100);}
								}
								else{$_POST['descuenbombe']=0;}
							}
							else{$_POST['descuenbombe']=0;}
						}
					}
				}
			}
			switch($_POST['tabgroup1'])
			{
				case 1:	$check1='checked';break;
				case 2:	$check2='checked';break;
				case 3:	$check3='checked';
			}
		?>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action=""> 
			<input type="hidden" name="anio[]" id="anio[]" value="<?php echo @$_POST['anio'] ?>">
			<input type="hidden" name="anioact" id="anioact" value="<?php echo @$_POST['anioact'] ?>">
			<input type="hidden" name="bloqueo[]" id="bloqueo[]" value="<?php echo @$_POST['bloqueo'] ?>">
			<div class="tabsic">
				<div class="tab">
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo @$check1;?> >
					<label for="tab-1">Base</label>
					<div class="content">
						<table class="inicio" align="center" >
							<tr>
								<td class="titulos" colspan="8">Liquidar Industria y Comercio</td>
								<td style="width:7%" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
							</tr>
							<tr>
								<td style="width:2.5cm" class="saludo1" >N&uacute;mero Comp:</td>
								<td style="width:10%">
									<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
									<input type="text" name="idcomp" style="width:50%;" value="<?php echo @$_POST['idcomp']?>" onKeyUp="return tabular(event,this)"  onKeyUp="return tabular(event,this)" onBlur="validar2();"/> 
									<input name="ncomp" type="hidden" value="<?php echo @$_POST['ncomp']?>"/>
									<a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
									<input type="hidden" value="a" name="atras"/>
									<input type="hidden" value="s" name="siguiente"/>
									<input type="hidden" value="<?php echo @$_POST['maximo']?>" name="maximo"/>
									<input type="hidden" value="<?php echo @$_POST['codrec']?>" name="codrec" id="codrec"/>
								</td>
								<td style="width:2.5cm" class="saludo1">Fecha:</td>
								<td style="width:30%" >
									<input name="fecha" type="text" value="<?php echo @$_POST['fecha']?>"  style="width:30%" onKeyUp="return tabular(event,this)" readonly/>
									<?php 
										if(@$_POST['estadoc']=="ACTIVO")
										{
											$valuees="ACTIVO";
											$stylest="width:30%; background-color:#0CD02A; color:white; text-align:center;";
										}
										else if(@$_POST['estadoc']=="ANULADO")
										{
											$valuees="ANULADO";
											$stylest="width:30%; background-color:#FF0000; color:white; text-align:center;";
										}
										else if(@$_POST['estadoc']=="PAGO")
										{
											$valuees="PAGO";
											$stylest="width:30%; background-color:#0404B4; color:white; text-align:center;";
										}
										echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
									?>
									<input name="estadoc" type="hidden" id="estadoc" value="<?php echo @$_POST['estadoc'] ?>"  style="width:30%" readonly/>
								</td>
								<td style="width:4cm" class="saludo1" >Tipo:</td>
								<td style="width:10%" >
									<select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" >
										<?php
											if($_POST['tipomov']=='2'){echo'<option value="2" selected>Normal</option>';}
											if($_POST['tipomov']=='3'){echo'<option value="3" selected>Correccion</option>';}
											if($_POST['tipomov']=='4'){echo'<option value="4" selected>Clausura</option>';}
											if($_POST['tipomov']=='5'){echo'<option value="5" selected>Vigencia Anterior</option>';}
										?>
									</select>
								</td>  
								<td style="width:4cm" class="saludo1">A&ntilde;o Liquidar:</td>
								<td style="width:10%">
									<input type="text" id="ageliquida" name="ageliquida"  style="width:100%; text-align:center"  value="<?php echo @$_POST['ageliquida']?>" readonly/>
									<input type="hidden" id="vigencia" name="vigencia" value="<?php echo @$_POST['vigencia']?>"/>
								</td>
							</tr>
							<tr>
								<td class="saludo1">NIT/Cedula: </td>
								<td>
									<input id="tercero" type="text" name="tercero" style="width:100%" value="<?php echo @$_POST['tercero']?>" readonly>
								</td>
								<td class="saludo1">Contribuyente:</td>
								<td >
									<input type="text" id="ntercero" name="ntercero" value="<?php echo @$_POST['ntercero']?>" size="50" onKeyUp="return tabular(event,this) " readonly/>
									<input type="hidden" value="0" name="bt"/>
									<input type="hidden" id="cb" name="cb" value="<?php echo @$_POST['cb']?>"/>
									<input type="hidden" id="ct" name="ct" value="<?php echo @$_POST['ct']?>"/>
									<input type="hidden" value="1" name="oculto"/>
								</td>
							</tr>
						</table>
						<table class="inicio">
							<tr>
								<td class="titulos2">C&oacute;digo</td>
								<td class="titulos2">Actividad</td>
								<td class="titulos2">Ingreso Actividad</td>
								<td class="titulos2">Tarifa x mil</td>
								<td class="titulos2">Valor</td>
							</tr>
							<?php
							$totaldes=0;
							$sqlr="SELECT * FROM tesoindustria_ciiu WHERE id_industria='".$_POST['idcomp']."'";
							$iter='saludo1a';
							$iter2='saludo2';
							$res=mysql_query($sqlr,$linkbd);
							while($row=mysql_fetch_row($res))
							{
								$nomciiu=buscacodigociiu($row[1]);
								echo "<tr class='$iter'>
									<td class='icoop' style='width:10%'>$row[1]</td>
									<td class='icoop'>$nomciiu</td>
									<td class='icoop' style='width:10%' align='right'>".number_format($row[3],2,',','.')."</td>
									<td class='icoop' style='width:10%' align='center'>$row[2]</td>
									<td class='icoop' style='width:10%' align='right'>".number_format($row[4],2,',','.')."</td>
								</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$totaldes=$totaldes+($row[4]);
							}
							?>
						</table>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo @$check2;?> >
					<label for="tab-2">Sanciones</label>
					<div class="content"> 
						<table class="inicio" align="center">
							<tr>
								<td class="titulos" colspan="8">Sanciones</td>
								<td style="width:7%" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
							</tr>
							<tr>
								<td class="titulos2">Sancion</td>
								<td class="titulos2">%</td>
								<td class="titulos2">Valor</td>
							</tr>
							<?php
								$totaldes=0;
								for ($x=0;$x<count($_POST['ddescuentos']);$x++)
								{
									echo "<tr>
										<td class='saludo2'>
											<input name='dndescuentos[]' value='".$_POST['dndescuentos'][$x]."' type='text' size='100' readonly>
											<input name='ddescuentos[]' value='".$_POST['ddescuentos'][$x]."' type='hidden'>
										</td>
									</tr>";
								}
							?>
						</table>
					</div>
				</div>
			</div>
			<div class="subpantallac">
				<table class="inicio">
					<tr>
						<td colspan="2" class="titulos">Liquidaci&oacute;n Privada</td>
					</tr>
					<tr>
						<td width="21%" class="saludo1">Industria y Comercio</td>
						<td class="saludo2" width="79%">
							<input id="industria" name="industria" type="text" value="<?php echo number_format($_POST['industria'],2,',','.') ?>" style="text-align:right;" readonly>
						</td>
					</tr>
					<tr>
						<td class="saludo1">Avisos y Tableros</td>
						<td class="saludo2">
							<input id="avisos" name="avisos" type="text"  value="<?php echo number_format($_POST['avisos'],2,',','.')?>" style="text-align:right;" readonly>
						</td>
					</tr>		 
					<tr>
						<td class="saludo1">Anticipo Vigencia Actual</td>
						<td class="saludo2">
							<input id="antivigact" name="antivigact" type="text"  value="<?php echo number_format($_POST['antivigact'],2,',','.')?>" style="text-align:right;" readonly >
						</td>
					</tr>
					<tr>
						<td class="saludo1">Anticipo Vigencia Anterior</td>
						<td class="saludo2">
							<input id="antivigant" name="antivigant" type="text" value="<?php echo number_format($_POST['antivigant'],2,',','.')?>" style="text-align:right;" readonly >
						</td>
					</tr>
					<tr>
						<td class="saludo1">Retenciones</td>
						<td class="saludo2">
							<input id="retenciones" name="retenciones" type="text"  value="<?php echo number_format($_POST['retenciones'],2,',','.')?>" style="text-align:right;" readonly>
						</td>
					</tr>
					<tr>
						<td class="saludo1">Sanciones</td>
						<td class="saludo2">
							<input type="text" id="sanciones" name="sanciones" value="<?php echo number_format($_POST['sanciones'],2,',','.')?>"  style="text-align:right;" readonly>
						</td>
					</tr>
					<tr>
						<td class="saludo1">Recargo Bomberil</td>
						<td class="saludo2">
							<input id="bomberil" name="bomberil" type="text"  value="<?php echo number_format($_POST['bomberil'],2,',','.')?>" style="text-align:right;" readonly>
						</td>
					</tr>
					<tr>
						<td class="saludo1">Valor Total</td>
						<td class="saludo2">
							<input id="valortotal" name="valortotal" type="text"  value="<?php echo number_format($_POST['valortotal'],2,',','.')?>" style="text-align:right;" readonly>
						</td>
					</tr>
					<tr>
						<td class="saludo1">Intereses</td>
						<td class="saludo2">
							<input type="text" id="intereses" name="intereses" value="<?php echo number_format($_POST['intereses'],2,',','.')?>"  style="text-align:right;" readonly>
						</td>
					</tr>
					<tr>
						<td class="saludo1">Saldo a Pagar</td>
						<td class="saludo2">
							<input id="saldopagar" name="saldopagar" type="text"  value="<?php echo number_format($_POST['saldopagar'],2,',','.')?>" style="text-align:right;" readonly>
						</td>
					</tr>
					<input type="hidden" name="descuenindus" id="descuenindus" value="<?php echo @$_POST['descuenindus']?>"/>
					<input type="hidden" name="descuenaviso" id="descuenaviso" value="<?php echo @$_POST['descuenaviso']?>"/>
					<input type="hidden" name="descuenbombe" id="descuenbombe" value="<?php echo @$_POST['descuenbombe']?>"/>
					<input type="hidden" name="interesesind" id="interesesind" value="<?php echo @$_POST['interesesind'];?>"/>
					<input type="hidden" name="interesesavi" id="interesesavi" value="<?php echo @$_POST['interesesavi'];?>"/>
					<input type="hidden" name="interesesbom" id="interesesbom" value="<?php echo @$_POST['interesesbom'];?>"/>
					<?php
  						$_POST['totalc']=0;
						for ($x=0;$x<count($_POST['dbancos']);$x++)
						{		 
							echo "
							<tr>
								<td class='saludo2'>
									<input name='dccs[]' value='".$_POST['dccs'][$x]."' type='text' size='4' readonly>
								</td>
								<td class='saludo2'>
									<input name='dconsig[]' value='".$_POST['dconsig'][$x]."' type='text' >
								</td>
								<td class='saludo2'>
									<input name='dcts[]' value='".@$_POST['dcts'][$x]."' type='hidden' >
									<input name='dbancos[]' value='".@$_POST['dbancos'][$x]."' type='hidden' >
									<input name='dcbs[]' value='".@$_POST['dcbs'][$x]."' type='text' size='45'>
								</td>
								<td class='saludo2'>
									<input name='dnbancos[]' value='".@$_POST['dnbancos'][$x]."' type='text' size='50'>
								</td>
								<td class='saludo2'>
									<input name='dvalores[]' value='".@$_POST['dvalores'][$x]."' type='text' size='15'>
								</td>
								<td class='saludo2'>
									<input type='checkbox' name='liquidaciones' value='1'>
								</td>
							</tr>";
							$_POST['totalc']=$_POST['totalc']+$_POST['dvalores'][$x];
							$_POST['totalcf']=number_format($_POST['totalc'],2,".",",");
						}
 						$resultado = convertir($_POST['saldopagar']);
						$_POST['letras']="$resultado PESOS M/CTE";
						echo "
						<tr>
							<td class='saludo2'  >Son: </td>
							<td><input name='letras' type='text' value='".@$_POST['letras']."' size='90' readonly></td>
						</tr>";
					?> 
				</table>
			</div>
			<input type="hidden" name="descunidos" id="descunidos" value="<?php echo @$_POST['descunidos'];?>"/>
			<input type="hidden" name="intecunidos" id="intecunidos" value="<?php echo @$_POST['intecunidos'];?>"/>
			<?php
				if(@$_POST['oculto']=='2')
				{
 					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST['fecha'],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$anioact=split("-", $_POST['fecha']);
					$_POST['anioact']=$anioact[0];
					for($x=0;$x<count($_POST['anio']);$x++)
					{
						if($_POST['anioact']==$_POST['anio'][$x])
						{
							if($_POST['bloqueo'][$x]=='S'){$bloquear="S";}
							else {$bloquear="N";}
						}
					}
					if($bloquear=="N")
					{
						//*********************CREACION DE LA LIQUIDACION ***************************
						if (@$_POST['estadoc']=='ANULADO')
						{
							$sqlr="update comprobante_cab set estado=0 where tipo_comp=3 and numerotipo='".$_POST['idcomp']."'";
							mysql_query($sqlr,$linkbd);
							$sqlr="update comprobante_det set valcredito=0, valcredito=0 where tipo_comp=3 and numerotipo='".$_POST['idcomp']."'";
							mysql_query($sqlr,$linkbd);
						}
						else
						{
							$sumtop= $_POST['industria']+$_POST['avisos']+$_POST['bomberil']-$_POST['descuenindus']- $_POST['descuenaviso']- $_POST['descuenbombe']-$_POST['antivigant']-$_POST['retenciones']+ $_POST['sanciones'];
							$totalica=$_POST['industria']+$_POST['antivigact']-$_POST['descuenindus'];
							$totalbombe=$_POST['bomberil']-$_POST['descuenbombe'];
							$totalavisos=$_POST['avisos']-$_POST['descuenaviso'];
							$totalretencionica=$totalretencionavisos=$totalretencionbomberil=0;
							$restem1=$totalica-$_POST['retenciones'];
							//echo "$sumtop=".$_POST['industria']."+".$_POST['avisos']."+".$_POST['bomberil']."-".$_POST['descuenindus']."-".$_POST['descuenaviso']."-".$_POST['descuenbombe']."-".$_POST['antivigant']."-".$_POST['retenciones']."+".$_POST['sanciones'].";";
							//echo "$sumtop $totalica $totalbombe $totalavisos $restem1";
							if ($restem1>=0)
							{
								//$totalica=$restem1;
								$totalretencionica=$_POST['retenciones'];
							}
							else
							{
								//$totalica=0;
								$totalretencionica=$totalica;
								if($totalavisos>0)
								{
									//$restem2=$totalavisos+$totalica-$_POST['retenciones'];
									$restem2=$totalavisos+$restem1;
									if($restem2>=0)
									{
										$totalavisos=$restem2;
										$totalretencionavisos=$_POST['retenciones']-$totalica;
									}
									else
									{
										//$totalavisos=0;
										$totalretencionavisos=$totalica+$totalavisos;
										if($totalbombe>0)
										{
											//$restem3=$totalbombe+$totalavisos+$totalica-$_POST['retenciones'];
											$restem3=$totalbombe+$restem2;
											if($restem3>0)
											{
												$totalbombe=$restem3;
												$totalretencionbomberil=$_POST['retenciones']-$totalica-$totalavisos;
											}
											else{$totalbombe=0;}
										}
									}
								}
							}
							$desindustriant=$desavisosant=$desbomberilant=0;
							if ($_POST['antivigant']>0 && $sumtop>=0)
							{
								$desindustriant=$_POST['industria']-$_POST['antivigant'];
								if ($desindustriant<0)
								{
									$desindustriant=$_POST[industria];
									$desavisosant=$desindustriant+$_POST['avisos']-$_POST['antivigant'];
									if($desavisosant<0)
									{
										$desavisosant=$_POST['avisos'];
										$desbomberilant=$desindustriant+$desavisosant+$_POST['bomberil']-$_POST['antivigant'];
										if($desbomberilant<0){$desbomberilant=0;}
										else{$desbomberilant=$_POST['antivigant']-$_POST['industria']-$_POST['avisos'];}
									}
									else{$desavisosant=$_POST['antivigant']-$_POST['industria'];}
								}
								else {$desindustriant=$_POST['antivigant'];}
							}
							$sqlr="update comprobante_cab set estado=1 where tipo_comp=3 and numerotipo='".$_POST['idcomp']."'";
							mysql_query($sqlr,$linkbd);
							$sqlr="delete from comprobante_det where id_comp='3 ".$_POST['idcomp']."'";
							mysql_query($sqlr,$linkbd);
			 				$nter=buscatercero($_POST['tercero']);
							if((float)$_POST['intereses']>0)
							{
								$intetodos=(float)$_POST['interesesind']+(float)$_POST['interesesavi']+(float)$_POST['interesesbom'];
								if($intetodos>0)
								{
									$indinteres=(float)$_POST['interesesind'];
									$aviinteres=(float)$_POST['interesesavi'];
									$bominteres=(float)$_POST['interesesbom'];
								}
								else
								{
									$indinteres=(float)$_POST['intereses'];
									$aviinteres=0;
									$bominteres=0;
								}
							}
							//*********************CREACION DEL COMPROBANTE CONTABLE ***************************		  
							//*******************DETALLE DEL COMPROBANTE CONTABLE *****************************
			 				//*************BUSCAR EL CONCEPTO CONTABLE DEL INGRESO INDUSTRIA Y COMERCIO *****************
			 				$sqlr="SELECT * FROM tesoingresos_det WHERE codigo='02' AND VIGENCIA='$vigusu' order by concepto";
			 				$res=mysql_query($sqlr,$linkbd);
							while($row=mysql_fetch_row($res))
							{
								switch($row[2])
								{
									case '00': //************Sanciones
									{
										if(@$_POST['sanciones']>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='00' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='00' AND tipo='C' AND fechainicial<='".$_POST['fecha']."')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='S')
													{
														$valordeb=$_POST['sanciones'];
														$valorcred=0;
													}
													else
													{
														$valorcred=$_POST['sanciones'];
														$valordeb=0;
													}
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 ".$_POST['idcomp']."', '$row2[4]','".$_POST['tercero']."','$row2[5]','Sanciones Industria Y Comercio ".$_POST['ageliquida']."','','$valordeb', '$valorcred','1','".$_POST['vigencia']."')";
													mysql_query($sqlr,$linkbd);
												}
											}
										}
									}break;
									case '04'://*****industria
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='04' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='04' AND tipo='C' AND fechainicial<='".$_POST['fecha']."')";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{
												if($row2[6]=='S')
												{
													$valordeb=$_POST['industria'];
													//$valordeb=$totalica;
													$valorcred=0;
													$cuentaindustria=$row2[4];
												}
												else
												{
													$valorcred=$_POST['industria'];
													//$valorcred=$totalica;
													$valordeb=0;
												}
												$sqlr="INSERT INTO comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) VALUES ('3 ".$_POST['idcomp']."', '$row2[4]','".$_POST['tercero']."', '$row2[5]','Industria y Comercio ".$_POST['ageliquida']."','','$valordeb', '$valorcred','1','".$_POST['vigencia']."')";
												mysql_query($sqlr,$linkbd);
												if($row2[6]=='S')
												{
													if(@$_POST['antivigact']>0)//anticipo vigencia actual
													{$cuenta_antivigact=$row2[4];}
													if(@$_POST['antivigant']>0)//anticipo vigencia Anterior
													{
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito, estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$row2[4]','".$_POST['tercero']."', '$row2[5]','Anticipo vigencia Anterior','','0','$desindustriant','1','".$_POST['vigencia']."')";
														mysql_query($sqlr,$linkbd);	 
													}
													if($totalretencionica>0)//retenciones
													{$cuenta_retencionica=$row2[4];}
												}
											}
										}
									}break;
									case '05'://************avisos
									{
										if(@$_POST['avisos']>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='05' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='05' AND tipo='C' AND fechainicial <= '".$_POST['fecha']."')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='S')
													{
														$valordeb=$_POST['avisos'];
														$valorcred=0;
														$cuentaavisos=$row2[4];
													}
													else
													{
														$valorcred=$_POST['avisos'];
														$valordeb=0;
													}
													$sqlr="INSERT INTO comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) VALUES ('3 ".$_POST['idcomp']."', '$row2[4]','".$_POST['tercero']."','$row2[5]','Avisos y Tableros ".$_POST['ageliquida']."','','$valordeb', '$valorcred','1', '".$_POST['vigencia']."')";
													mysql_query($sqlr,$linkbd);
													if($row2[6]=='S')
													{

														if($totalretencionavisos>0)//retenciones
														{$cuenta_retencionavisos=$row2[4];}
													}
												}
											}
										}
									}break;
									case '06'://*********bomberil ********
									{
										if(@$_POST['bomberil']>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='06' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='06' AND tipo='C' AND fechainicial <= '".$_POST['fecha']."')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='S')
													{
														$valordeb=$_POST['bomberil'];
														$valorcred=0;
														$cuentabomberil=$row2[4];
													}
													else
													{
														$valorcred=$_POST['bomberil'];
														$valordeb=0;
													}
													$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$row2[4]','".$_POST['tercero']."','$row2[5]','Bomberil ".$_POST['ageliquida']."', '','$valordeb', '$valorcred','1','".$_POST['vigencia']."')";
													mysql_query($sqlr,$linkbd);
													if($row2[6]=='S')
													{

														if($totalretencionbomberil>0)//retenciones
														{$cuenta_retencionbomberil=$row2[4];}
													}
												}
											}
										}
									}break;
									case 'P04'://*****INTERESES BOMBERIL
									{
										if($bominteres>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P04' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P04' AND tipo='C' AND fechainicial<='$_POST[fecha]')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='S')
													{
														$valordeb=$bominteres;
														$valorcred=0;
													}
													else
													{
														$valorcred=$bominteres;
														$valordeb=0;
													}
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $_POST[idcomp]', '$row2[4]','$_POST[tercero]', '$row2[5]','Intereses Bomberil $_POST[ageliquida]','','$valordeb', '$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);	
												}
											}
										}
									}break;
									/*case 'P10'://descuentos sobretasa bomberil
									{
										if(@ $_POST['descuenbombe']>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P10' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P10' AND tipo='C' AND fechainicial<='$_POST[fecha]')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='S')
													{				 
														$valordeb=$_POST['descuenbombe'];
														$valorcred=0;
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado,vigencia) VALUES ('3 ".$_POST['idcomp']."','$row2[4]','".$_POST['tercero']."','$row2[5]','Descuentos Bomberil ".$_POST['ageliquida']."','','$valordeb', '$valorcred','1','".$_POST['vigencia']."')";
														mysql_query($sqlr,$linkbd);
														$valordeb=0;
														$valorcred=$_POST['descuenbombe'];
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('3 ".$_POST['idcomp']."','$cuentabomberil','".$_POST['tercero']."','$row2[5]', 'Descuentos Bomberil ".$_POST['ageliquida']."', '','$valordeb','$valorcred','1', '".$_POST['vigencia']."')";
														mysql_query($sqlr,$linkbd);
													}
												}
											}
										}
									}break; */
									case 'P11'://RETENCIONES INDUSTRIA Y COMERCIO 
									{ 
										if(@$_POST['retenciones']>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P11' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P11' AND tipo='C' AND fechainicial<='".$_POST['fecha']."')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='S')
													{
														if($totalretencionica>0)
														{
															$valordeb=$totalretencionica;
															$valorcred=0;
															$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$row2[4]','".$_POST['tercero']."','$row2[5]','Retenciones Industria y Comercio','','$valordeb','$valorcred', '1', '".$_POST['vigencia']."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=0;
															$valorcred=$totalretencionica;
															$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$cuenta_retencionica','".$_POST['tercero']."','$row2[5]','Retenciones Industria y Comercio','','$valordeb','$valorcred', '1', '".$_POST['vigencia']."')";
															mysql_query($sqlr,$linkbd);
														}
														if($totalretencionavisos>0)
														{
															$valordeb=$totalretencionavisos;
															$valorcred=0;
															$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$row2[4]','".$_POST['tercero']."','$row2[5]','Retenciones Avisos y Tableros','','$valordeb','$valorcred', '1', '".$_POST['vigencia']."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=0;
															$valorcred=$totalretencionavisos;
															$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$cuenta_retencionavisos','".$_POST['tercero']."','$row2[5]','Retenciones Avisos y Tableros','','$valordeb','$valorcred', '1', '".$_POST['vigencia']."')";
															mysql_query($sqlr,$linkbd);
														}
														if($totalretencionbomberil>0)
														{
															$valordeb=$totalretencionbomberil;
															$valorcred=0;
															$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$row2[4]','".$_POST['tercero']."','$row2[5]','Retenciones bomberil','','$valordeb','$valorcred', '1', '".$_POST['vigencia']."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=0;
															$valorcred=$totalretencionbomberil;
															$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$cuenta_retencionbomberil','".$_POST['tercero']."','$row2[5]','Retenciones Bomberil','','$valordeb','$valorcred', '1', '".$_POST['vigencia']."')";
															mysql_query($sqlr,$linkbd);
														}
													}
													
												}
											}
										}
									} break;
									case 'P12'://Anticipo vigencia Actual
									{
										if($_POST[antivigact]>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P12' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P12' AND tipo='C' AND fechainicial<='".$_POST['fecha']."')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='N')
													{
														$valordeb=0;
														$valorcred=$_POST['antivigact'];
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito, estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$row2[4]','".$_POST['tercero']."','$row2[5]','Anticipo vigencia Actual','', '$valordeb','$valorcred','1','".$_POST['vigencia']."')";
														mysql_query($sqlr,$linkbd);
														$valordeb=$_POST['antivigact'];
														$valorcred=0;
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito, estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$cuenta_antivigact','".$_POST['tercero']."','$row2[5]','Anticipo vigencia Actual','', '$valordeb','$valorcred','1','".$_POST['vigencia']."')";
														mysql_query($sqlr,$linkbd);
														
													}
													
												}
											}
										}
									}break;
									case 'P13'://Anticipo vigencia Anterior
									{
										if($_POST[antivigant]>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P13' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P13' AND tipo='C' AND fechainicial<='$_POST[fecha]')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='N')
													{
														if($sumtop<0)//si el total es negativo
														{
															if($_POST[industria]>0)
															{
																$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $_POST[idcomp]','$row2[4]','$_POST[tercero]','$row2[5]','Cruce  ICA con el saldo del contribuyente', '','$totalica','0','1', '$_POST[vigencia]')";
																mysql_query($sqlry,$linkbd);
															}
															if($_POST[bomberil]>0)
															{
																$sqlry="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $_POST[idcomp]', '$row2[4]','$_POST[tercero]', '$row2[5]','Cruce Bomberil con el saldo del contribuyente','','$totalbombe','0','1', '$_POST[vigencia]')";
																mysql_query($sqlry,$linkbd);	
															}
															if($_POST[avisos]>0)
															{
																$sqlry="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $_POST[idcomp]', '$row2[4]','$_POST[tercero]', '$row2[5]','Cruce Avisos con el saldo del contribuyente','','$totalavisos','0','1', '$_POST[vigencia]')";
																mysql_query($sqlry,$linkbd);	
															}
														}
														else
														{
															$valordeb=$_POST[antivigant];
															$valorcred=0;
															$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $_POST[idcomp]','$row2[4]','$_POST[tercero]', '$row2[5]','Anticipo vigencia Anterior','', '$valordeb','$valorcred','1', '$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
														}
													}
												}
											}
										}
									}break;
									/*case 'P14'://descuento industria y comercio
									{
										if($_POST['descuenindus']>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P14' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P14' AND tipo='C' AND fechainicial<='$_POST[fecha]')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='S')
													{
														$valordeb=$_POST['descuenindus'];
														$valorcred=0;
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) VALUES ('3 ".$_POST['idcomp']."','$row2[4]', '".$_POST['tercero']."','$row2[5]','Descuento Industria y Comercio ".$_POST['ageliquida']."','', '$valordeb','$valorcred','1', '".$_POST['vigencia']."')";
														mysql_query($sqlr,$linkbd);
														$valordeb=0;
														$valorcred=$_POST['descuenindus'];
														$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$cuentaindustria','".$_POST['tercero']."','$row2[5]','Descuento Industria y Comercio ".$_POST['ageliquida']."','','$valordeb','$valorcred','1', '".$_POST['vigencia']."')";
														mysql_query($sqlry,$linkbd);
													}
												}
											}
										}
									}break;*/
									case 'P15'://descuento avisos y tableros
									{
										if(@ $_POST['descuenaviso']>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P15' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P15' AND tipo='C' AND fechainicial<='$_POST[fecha]')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='S')
													{
														$valordeb=$_POST['descuenaviso'];
														$valorcred=0;
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('3 ".$_POST['idcomp']."','$row2[4]','".$_POST['tercero']."','$row2[5]','Descuento Avisos y Tableros ".$_POST['ageliquida']."','','$valordeb', '$valorcred','1', '".$_POST['vigencia']."')";
														mysql_query($sqlr,$linkbd);
														$valordeb=0;
														$valorcred=$_POST['descuenaviso'];
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('3 ".$_POST['idcomp']."', '$cuentaavisos','".$_POST['tercero']."', '$row2[5]', 'Descuento Avisos y Tableros ".$_POST['ageliquida']."','','$valordeb', '$valorcred','1', '".$_POST['vigencia']."')";
														mysql_query($sqlr,$linkbd);
													}
												}
											}
										}
									}break;
									case 'P16'://*****INTERESES INDUSTRIA
									{
										if($indinteres>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P16' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P16' AND tipo='C' AND fechainicial<='".$_POST['fecha']."')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='S')
													{
														$valordeb=$indinteres;
														$valorcred=0;
													}
													else
													{
														$valorcred=$indinteres;
														$valordeb=0;
													}
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 ".$_POST['idcomp']."', '$row2[4]','".$_POST['tercero']."', '$row2[5]','Intereses Industria y Comercio ".$_POST['ageliquida']."','','$valordeb','$valorcred','1', '".$_POST['vigencia']."')";
													mysql_query($sqlr,$linkbd);	
												}
											}
										}
									}break;
									case 'P17'://*****INTERESES AVISOS Y TABLEROS
									{
										if($aviinteres>0)
										{
											$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P17' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P17' AND tipo='C' AND fechainicial<='$_POST[fecha]')";
											$res2=mysql_query($sqlr2,$linkbd);
											while($row2=mysql_fetch_row($res2))
											{
												if($row2[3]=='N')
												{
													if($row2[6]=='S')
													{				 
														$valordeb=$aviinteres;
														$valorcred=0;
													}
													else
													{
														$valorcred=$aviinteres;
														$valordeb=0;
													}
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $_POST[idcomp]', '$row2[4]','$_POST[tercero]', '$row2[5]','Intereses Avisos y Tableros $_POST[ageliquida]','','$valordeb', '$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);	
												}
											}
										}
									}break;
								}
							}	
			  				echo "<script>despliegamodalm('visible','1','Se ha almacenado la liquidacion con Exito');</script>";
							//**********************
			 			}//**** FIN DEL ELSE DE PRIMERA SQL GUARDA LIQUIDACION ***********************
					}
					else {echo"<script>despliegamodalm('visible','2','No se puede reflejar por Cierre de A�o');</script>";}
				}
			?>	
		</form>
	</body>
</html>