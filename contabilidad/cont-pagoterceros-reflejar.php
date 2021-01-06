<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
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
				if (document.form2.fecha.value!='' && document.form2.tercero.value!='' )
				{
					// if(confirm("Esta Seguro de Guardar")){
						// document.form2.oculto.value=2;
						// document.form2.submit();
					// }
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else
				{
					// alert('Faltan datos para completar el registro');
					// document.form2.fecha.focus();
					// document.form2.fecha.select();
					despliegamodalm('visible','2','Faltan datos para completar el registro');
				}
			}
			function adelante()
			{
				if(parseFloat(document.form2.idcomp.value)<parseFloat(document.form2.maximo.value)){
					document.form2.oculto.value=1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					document.form2.action="cont-pagoterceros-reflejar.php";
					document.form2.submit();
				}
			}
			function atrasc()
			{
				if(document.form2.idcomp.value>1){
					document.form2.oculto.value=1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					document.form2.action="cont-pagoterceros-reflejar.php";
					document.form2.submit();
				}
			}
			function validar2()
			{
				document.form2.oculto.value=1;
		//		document.form2.ncomp.value=document.form2.idcomp.value;
				document.form2.action="cont-pagoterceros-reflejar.php";
				document.form2.submit();
			}
			function pdf()
			{
				document.form2.action="pdfpagoterceros.php";
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
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
				<td colspan="3" class="cinta">
					<a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a>
					<a href="#" class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" /></a>
					<a href="cont-buscapagoterceros-reflejar.php" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" border="0" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/reflejar1.png"  alt="Reflejar" title="Reflejar" style="width:24px;" /> 
					<a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="Imprimir" title="Imprimir"/></a>
					<a href="cont-reflejardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana" title="Nueva Ventana"></a>
				</td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action=""> 
			<input type="hidden" name="anio[]" id="anio[]" value="<?php echo $_POST[anio] ?>">
			<input type="hidden" name="anioact" id="anioact" value="<?php echo $_POST[anioact] ?>">
			<input type="hidden" name="bloqueo[]" id="bloqueo[]" value="<?php echo $_POST[bloqueo] ?>">
			<?php
				$vigencia=date(Y);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				
				$sqlr="select * from admbloqueoanio";
				$res=mysql_query($sqlr,$linkbd);
				$_POST[anio]=array();
				$_POST[bloqueo]=array();
				while ($row =mysql_fetch_row($res))
				{
					$_POST[anio][]=$row[0];
					$_POST[bloqueo][]=$row[1];
				}
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_MILES'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){$_POST[cuentamiles]=$row[0];}
				//*********** cuenta origen va al credito y la destino al debito
				if($_GET[consecutivo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[consecutivo];</script>";}
				if(!$_POST[oculto])
				{
					$sqlr="select *from cuentapagar where estado='S' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res))
					{
						$_POST[cuentapagar]=$row[1];
					}
					$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_MILES'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentamiles]=$row[0];}
					/*$sqlr="select *from cuentamiles where estado='S' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res))
					{$_POST[cuentamiles]=$row[1];}*/
					$sqlr="select max(id_pago) from tesopagoterceros";
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					$r=mysql_fetch_row($res);
					$_POST[maximo]=$r[0];
					if ($_POST[codrec]!="" || $_GET[consecutivo]!="")
					{
						if($_POST[codrec]!="")
						{
							$sqlr="select * from tesopagoterceros where id_pago='$_POST[codrec]'";
						}
						else
						{
							$sqlr="select * from tesopagoterceros where id_pago='$_GET[consecutivo]'";
						}
					}
					else
					{
						$sqlr="select max(id_pago) from tesopagoterceros";
					}
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$_POST[idcomp]=$r[0];
					$check1="checked";
				}
				$sqlr="select * from tesopagoterceros where id_pago=$_POST[idcomp]";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res))
				{
					$consec=$r[0];
					$fec=$r[10];
					$_POST[fecha]=$fec;
					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
					$_POST[fecha]=$fechaf;
					$_POST[vigencia]=$fecha[1];
					if ($r[3]!='')
					{
						$_POST[tipop]="cheque";
						$_POST[ncheque]=$r[3];
					}
					if($r[4]!='')
					{
						$_POST[tipop]="transferencia";
						$_POST[ntransfe]=$r[4];
					}
					$_POST[mes]=$r[6];
					$_POST[banco]=$r[2];
					$_POST[tercero]=$r[1];
					$_POST[ntercero]=buscatercero($r[1]);
					$_POST[cc]=$r[8];
					$_POST[concepto]=$r[7];
					$_POST[valorpagar]=$r[5];
					$_POST[estado]=$r[9];
					$_POST[ajuste]=$r[11];
					if($r[11]==1)
					{
						$_POST[valorpagarmil]=round($_POST[valorpagar]/1000)*1000;
						$_POST[diferencia]=$_POST[valorpagarmil]-$_POST[valorpagar];
					}
					else
					{
						$_POST[valorpagarmil]=$_POST[valorpagar];
						$_POST[diferencia]=0;
					}
				}
				$sqlr="select * from tesopagoterceros_det where id_pago=$_POST[idcomp]";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				$_POST[mddescuentos]=array();
				$_POST[mtdescuentos]=array();
				$_POST[mddesvalores]=array();
				$_POST[mddesvalores2]=array();
				$_POST[mdndescuentos]=array();
				$_POST[mdctas]=array();
				while($r=mysql_fetch_row($res))
				{
					$_POST[ddescuentos][]=$r[1];
					$_POST[dndescuentos][]=$r[2].'-'.$r[1];
					$_POST[mtdescuentos][]=$r[2];
					if($r[2]=='I'){$_POST[mdndescuentos][]=buscaingreso($r[1]);}
					else{$_POST[mdndescuentos][]=buscaretencion($r[1]);}
					$_POST[mddesvalores][]=$r[3];
					$_POST[mddesvalores2][]=$r[3];
					$_POST[mddescuentos][]=$r[1];
					$_POST[mdctas][]=$r[4];
				}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';
				}
				$meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre', 'Noviembre','Diciembre');
			?>
			<table class="inicio" align="center" >
				<tr>
					<td colspan="6" class="titulos">Pago Terceros - Otros Pagos</td>
					<td style="width:7%" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
				</tr>
				<tr> 
					<td style="width:4cm" class="saludo1" >N&uacute;mero Pago:</td>
					<td style="width:10%" >
						<input name="cuentamiles" type="hidden"  value="<?php echo $_POST[cuentamiles]?>" >
						<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
						<input name="idcomp" type="text"  style="width:50%; text-align:center;" value="<?php echo $_POST[idcomp]?>" onBlur="validar2()" >
						<a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
						<input type="hidden" value="<?php echo $_POST[oculto]?>" name="oculto" id="oculto">
					</td>
					<td style="width:1.5cm" class="saludo1">Fecha: </td>
					<td style="width:25%" >
						<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" style="width:50%" onKeyUp="return tabular(event,this)" readonly>   
					</td>
					<td style="width:2.5cm%" class="saludo1">Vigencia: </td>
					<td style="width:30%" >
						<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" style="width:30%" onKeyUp="return tabular(event,this)" readonly>
						Estado:
						<?php 
							if($_POST[estado]=="S"){
								$valuees="ACTIVO";
								$stylest="width:30%; background-color:#0CD02A; color:white; text-align:center;";
							}else if($_POST[estado]=="N"){
								$valuees="ANULADO";
								$stylest="width:30%; background-color:#FF0000; color:white; text-align:center;";
							}else if($_POST[estadoc]=="P"){
								$valuees="PAGO";
								$stylest="width:30%; background-color:#0404B4; color:white; text-align:center;";
							}

							echo "<input type='text' name='estadoc' id='estadoc' value='$valuees' style='$stylest' readonly />";
						?>
						<input name="estado" type="hidden" value="<?php echo $_POST[estado]?>" style="width:30%" onKeyUp="return tabular(event,this)" readonly> 
					</td>
				</tr>
				<tr>
					<td class="saludo1">Forma de Pago:</td>
					<td >
						<select name="tipop">
							<?php
								if($_POST[tipop]=='cheque')
									echo'<option value="cheque" selected>Cheque</option>';
								if($_POST[tipop]=='transferencia')
									echo'<option value="transferencia" selected>Transferencia</option>';
							?>
						</select>
					</td>
					<td class="saludo1">Mes:</td>
					<td >
						<select name="mes">
							<?php
							echo'<option value="'.$_POST[mes].'" selected>'.$meses[$_POST[mes]].'</option>';
							?>
						</select> 
					</td>           
				</tr>
				<?php
					if($_POST[tipop]=='cheque')//**** if del cheques
					{
						echo"
						<tr>
							<td class='saludo1'>Cuenta Bancaria:</td>
							<td colspan='3'>
								<select id='banco' name='banco' onKeyUp='return tabular(event,this)'>";
						$sqlr="SELECT T1.estado,T1.cuenta,T1.ncuentaban,T1.tipo,T2.razonsocial,T1.tercero FROM tesobancosctas AS T1, terceros AS T2 WHERE T1.tercero=T2.cedulanit ABD T1.estado='S' ";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res))
						{
							if($row[1]==$_POST[banco])
							{
								echo "<option value=$row[1] SELECTED>".$row[2]." - Cuenta ".$row[3]." - ".$row[4]."</option>";
								$_POST[nbanco]=$row[4];
								$_POST[ter]=$row[5];
								$_POST[cb]=$row[2];
							}
						}
						echo"
								</select>
								<input type='hidden' name='cb' value='".$_POST[cb]."'/>
								<input type='hidden' id='ter' name='ter' value='".$_POST[ter]."'/>
								<input type='hidden 'id='nbanco' name='nbanco' value='".$_POST[nbanco]."'/>
							</td>
							<td class='saludo1'>Cheque:</td>
							<td><input type='text' id='ncheque' name='ncheque' value='".$_POST[ncheque]."' style='width:100%'/></td>
						</tr>";
					}//cie	rre del if de cheques
					if($_POST[tipop]=='transferencia')//**** if del transferencias
					{
						echo"
						<tr>
							<td class='saludo1'>Cuenta Bancaria:</td>
							<td colspan='3'>
								<select id='banco' name='banco' onKeyUp='return tabular(event,this)'>";
						$sqlr="SELECT T1.estado,T1.cuenta,T1.ncuentaban,T1.tipo,T2.razonsocial,T1.tercero from tesobancosctas AS T1,terceros AS T2 where T1.tercero=T2.cedulanit and T1.estado='S'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res))
						{
							if($row[1]==$_POST[banco])
							{
								echo "<option value=$row[1] SELECTED>".$row[2]." - Cuenta ".$row[3]." - ".$row[4]."</option>";
								$_POST[nbanco]=$row[4];
								$_POST[ter]=$row[5];
								$_POST[cb]=$row[2];
							}
						}
						echo"
								</select>
							</td>
							<input type='hidden' name='cb' value='".$_POST[cb]."'/>
							<input type='hidden' id='ter' name='ter' value='".$_POST[ter]."'/>
							<input type='hidden' id='nbanco' name='nbanco' value='".$_POST[nbanco]."'/>
							<td class='saludo1'>No Transferencia:</td>
							<td><input type='text' id='ntransfe' name='ntransfe' value='".$_POST[ntransfe]."' style='width:100%'></td>
						</tr>";
					}//cierre del if de cheques   
				?> 
				<tr>
					<td  class="saludo1">Tercero:</td>
					<td><input id="tercero" type="text" name="tercero" style="width:100%" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>"/></td>
					<td colspan="2"><input type="text" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly/></td>
					<input type="hidden" name="bt" value="0"/>
					<td class="saludo1">Centro Costo:</td>
					<td colspan="3">
						<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
						<?php
							$sqlr="select *from centrocosto where estado='S'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res))
							{
								if($row[0]==$_POST[cc])
								{
									echo "<option value=$row[0] SELECTED>".$row[0]." - ".$row[1]."</option>";
								}
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1">Concepto</td>
					<td colspan="3"><input type="text" name="concepto" value="<?php echo $_POST[concepto]?>" style="width:100%"></td>
					<td class="saludo1">Valor a Pagar:</td>
					<td><input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo number_format($_POST[valorpagar],0,',','.') ?>" style="width:50%; text-align:right" readonly/></td>
				</tr>
				<tr>
					<td class="saludo1">Ajuste Miles: <input type="checkbox" name="ajuste" id="ajuste"  value="1" onClick="document.form2.submit()" <?php if($_POST[ajuste]==1) echo "checked"; ?>/></td>
					<td><input name="valorpagarmil" type="text" id="valorpagarmil" onKeyUp="return tabular(event,this)" value="<?php echo number_format($_POST[valorpagarmil],0,',','.') ?>" style="width:60%; text-align:right" readonly/>
					<input name="diferencia" type="text" id="diferencia" onKeyUp="return tabular(event,this)" value="<?php echo round($_POST[diferencia],0) ?>" style="width:20%; text-align:center" readonly></td>
				</tr>
			</table>
			<div class="subpantallac4">
				<table class="inicio" >
					<tr>
						<td class="titulos">Retenciones / Ingresos</td>
						<td class="titulos">Contabilidad</td>
						<td class="titulos">Valor</td>
					</tr>
					<?php
						$totalpagar=0;
						//**** buscar movimientos
						$iter='saludo1a';
						$iter2='saludo2';
						for ($x=0;$x<count($_POST[mddescuentos]);$x++)
						{
							echo"
							<tr class='$iter'>
								<td>
									<input name='mdndescuentos[]' value='".$_POST[mdndescuentos][$x]."' type='hidden'>".$_POST[mdndescuentos][$x]."
									<input name='mddescuentos[]' value='".$_POST[mddescuentos][$x]."' type='hidden'>
									<input name='mtdescuentos[]' value='".$_POST[mtdescuentos][$x]."' type='hidden'>
								</td>
								<td><input name='mdctas[]' value='".$_POST[mdctas][$x]."' type='hidden'>".$_POST[mdctas][$x]."</td>
								<td align='right'>
									<input name='mddesvalores[]' value='".round($_POST[mddesvalores][$x],0)."' type='hidden'>
									<input name='mddesvalores2[]' value='".($_POST[mddesvalores2][$x])."' type='hidden'>".number_format($_POST[mddesvalores2][$x],0,',','.')."
								</td>
							</tr>";
						}
						$vmil=0;
						if($_POST[ajuste]=='1') {$vmil=round(array_sum($_POST[mddesvalores]),-3);}
						else {$vmil=array_sum($_POST[mddesvalores]);}
						$resultado = convertir(round($vmil,0));
						$_POST[letras]=$resultado." PESOS M/CTE";
						echo"
						<tr class='titulos2'>
							<td></td>
							<td>Total:</td>
							<td align='right'>
								<input type='hidden' name='totalpago2' value='".round(array_sum($_POST[mddesvalores]),0)."' >
								<input type='hidden' name='totalpago' value='".number_format(array_sum($_POST[mddesvalores]),0)."'>".number_format(array_sum($_POST[mddesvalores]),0,',','.')."
							</td>
						</tr>
						<tr class='titulos2'>
							<td colspan='3'><input name='letras' type='hidden' value='$_POST[letras]'>Son: ".$_POST[letras]."</td>
						</tr>";
						$dif=$vmil-array_sum($_POST[mddesvalores]);
					?>
				</table>
			</div>
			<?php
				if($_POST[oculto]=='2')
				{
					$p1=substr($_POST[fecha],0,2);
					$p2=substr($_POST[fecha],3,2);
					$p3=substr($_POST[fecha],6,4);
					$fechaf=$p3."-".$p2."-".$p1;
					$anioact=split("/", $_POST[fecha]);
					$_POST[anioact]=$anioact[2];
					for($x=0;$x<count($_POST[anio]);$x++)
					{
						if($_POST[anioact]==$_POST[anio][$x])
						{
							if($_POST[bloqueo][$x]=='S')
							{
								$bloquear="S";
							}else
							{
								$bloquear="N";
							}
						}
					}
					if($bloquear=="N")
					{
						$bloq=bloqueos($_SESSION[cedulausu],$fechaf);
						if($bloq>=1)
						{
							$sqlr="DELETE FROM comprobante_cab WHERE numerotipo=$_POST[idcomp] AND tipo_comp=12";	
							mysql_query($sqlr,$linkbd);
							$sqlr="DELETE FROM comprobante_det WHERE numerotipo=$_POST[idcomp] AND tipo_comp=12";	
							mysql_query($sqlr,$linkbd);
							//************CREACION DEL COMPROBANTE CONTABLE ************************
							//***busca el consecutivo del comprobante contable
							$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito, diferencia,estado) VALUES ($_POST[idcomp] ,12,'$fechaf','$_POST[concepto]',0,$totalpagar,$totalpagar,0,'1')";
							mysql_query($sqlr,$linkbd);
							for ($x=0;$x<count($_POST[mddescuentos]);$x++)
							{
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) VALUES ('12 $_POST[idcomp]','".$_POST[mdctas][$x]."', '".$_POST[tercero]."', '".$_POST[cc]."','PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]', ".$_POST[mddesvalores][$x].",0,'1','". $_POST[vigencia]."')";
								mysql_query($sqlr,$linkbd);
								//*** Cuenta BANCO **
								$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) VALUES ('12 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."', 'PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',0, ".$_POST[mddesvalores][$x].",'1','". $_POST[vigencia]."')";
								mysql_query($sqlr,$linkbd);
							}
							if($_POST[diferencia]<>0)
							{
								if($_POST[diferencia]>0)
								{
									$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('12 $_POST[idcomp]','".$_POST[cuentamiles]."', '".$_POST[tercero]."','".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."', '$_POST[ncheque]$_POST[ntransfe]',".$_POST[diferencia].",0,'1','".$_POST[vigencia]."')";
									mysql_query($sqlr,$linkbd);  
									//*** Cuenta BANCO **
									$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('12 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."', '".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."', '$_POST[ncheque]$_POST[ntransfe]',0,".abs($_POST[diferencia]).", '1','". $_POST[vigencia]."')";
									mysql_query($sqlr,$linkbd);
								}
								if($_POST[diferencia]<0)
								{
									$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('12 $_POST[idcomp]','".$_POST[cuentamiles]."', '".$_POST[tercero]."','".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."', '$_POST[ncheque]$_POST[ntransfe]',0,".abs($_POST[diferencia]).",'1','". $_POST[vigencia]."')";
									mysql_query($sqlr,$linkbd);
									//*** Cuenta BANCO **
									$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('12 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."', '".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."', '$_POST[ncheque]$_POST[ntransfe]',".abs($_POST[diferencia]).",0,'1','". $_POST[vigencia]."')";
									mysql_query($sqlr,$linkbd); 
								}
							}
							echo"<script>despliegamodalm('visible','1','Se ha almacenado el Recaudo a Terceros con Exito');</script>";
						}//*** if de guardado
						else {echo"<script>despliegamodalm('visible','2','No tiene los privilegios suficientes');</script>";}
					}
					else {echo"<script>despliegamodalm('visible','2','No se puede reflejar por Cierre de Año');</script>";}
				}
			?>
		</form>
	</body>
</html>