<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID- Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function validar(){document.form2.submit();}
			function guardar()
			{
				var vg="<?php
					$sqlr="SELECT * FROM tesoreciboscaja WHERE id_recibos=$_POST[idcomp]";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					if($r[0]==""){echo "S";}
					else{echo "N";}
					?>";
				if(vg=="S")
				{
					if(!document.form2.modorec){var banco = '';}
					else {var banco = document.form2.modorec.value;}
					
					if(!document.form2.cuentaPuente){var CPuente = '';}
					else {var CPuente = document.form2.cuentaPuente.value;}
					if(banco == 'banco')
					{
						var cuentaBancoCaja = document.form2.cb.value;
					}
					else if(banco == 'caja')
					{
						var cuentaBancoCaja = 'cuentaCaja';
					}
					else
					{
						var cuentaBancoCaja = 'cuentaPuente';
					}
					if (document.form2.fecha.value!='' && (banco!='' || CPuente!='') && cuentaBancoCaja !='' && document.form2.tiporec.value!='' )
					{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else
					{
						despliegamodalm('visible','2','Faltan datos para completar el registro');
						document.form2.fecha.focus();
						document.form2.fecha.select();
					}
				}
				else
				{
					var id="<?php 
						$sqlr="select id_recibos from tesoreciboscaja order by id_recibos desc";
						$res=mysql_query($sqlr,$linkbd);
						$r=mysql_fetch_row($res); 
						$_POST[idcomp]=$r[0]+1;
						echo $r[0];
						?>"
					document.form2.idcomp.value=id;
				}
			}
			function pdf()
			{
				document.form2.action="teso-pdfrecaja.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
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
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje()
			{
				var numdocar=document.getElementById('idcomp').value;
				document.location.href = "teso-recibocajaver.php?idrecibo="+numdocar;
			}
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.form2.oculto.value=2;
									document.form2.submit();
									break;
						case "2":	var fechast=document.form2.fecha.value.split('/');
									document.form2.vigencia.value=document.form2.vigesistem.value=fechast[2];
									break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	break;
						case "2":	var fechast=document.form2.fecha.value.split('/');
									document.form2.vigesistem.value=fechast[2];
									break;
					}
				}
				document.form2.submit();
			}
			function despliegamodal2(_valor,v)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					if(v==1){
						document.getElementById('ventana2').src="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
					}else{
						document.getElementById('ventana2').src="notaspararevelacion.php?nota="+document.form2.notaf.value;
					}
				}
			}
			function verificarfecha()
			{
				despliegamodalm('visible','4','La fecha asignada tiene una vigencia diferente a la del sistema, �desea trabajar con esta vigencia?','2');
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-recibocaja.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar" class="mgbt" onClick="location.href='teso-buscarecibocaja.php'"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"/><img src="imagenes/printd.png" style="width:29px;height:25px;"  class="mgbt1"/>
				</td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<?php
			function obtenerTipoPredio($catastral)
			{
				$tipo="";
				$digitos=substr($catastral,5,2);
				if($digitos=="00"){$tipo="rural";}
				else{$tipo="urbano";}
				return $tipo;
			} 
			$sqlr="select cuentacaja from tesoparametros";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)){ $_POST['cuentacaja']=$row[0];}
			//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
			if(!$_POST['oculto'])
			{
				$check1="checked";
				$fec=date("d/m/Y");
				$_POST['fecha']=$fec; 
				$_POST['vigesistem']=$_POST[vigencia]=date("Y");
				$sqlr="select cuentacaja from tesoparametros";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) {$_POST['cuentacaja']=$row[0];}
				$sqlr="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='COBRO_RECIBOS' AND descripcion_valor= '".$_POST['vigencia']."' AND  tipo='S'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
					$_POST['cobrorecibo']=$row[0];
					$_POST['vcobrorecibo']=$row[1];
					$_POST['tcobrorecibo']=$row[2];
				}
				$consec=selconsecutivo("tesoreciboscaja","id_recibos");
				$_POST['idcomp']=$consec;	
				$_POST['valor']=0;
				$sqlr="SELECT tmindustria,desindustria,desavisos,desbomberil,intindustria,intavisos,intbomberil FROM tesoparametros";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res))
				{
					$_POST['salariomin']=$row[0];
					$_POST['descunidos']="$row[1]$row[2]$row[3]";
					$_POST['intecunidos']="$row[4]$row[5]$row[6]";
				}		 
			}
			preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$vigensistem);
			if($vigensistem[3]!=$_POST['vigesistem'])
			{
				echo "<script>verificarfecha();</script>";
			}
			$vigencia=$vigusu=$_POST['vigencia'];
		?>
 		<form name="form2" method="post" action="">
			<input type="hidden" name="vguardar" id="vguardar" value="">
			<input name="encontro" type="hidden" value="<?php echo @ $_POST['encontro']?>" >
			<input name="cobrorecibo" type="hidden" value="<?php echo @ $_POST['cobrorecibo']?>" >
			<input name="vcobrorecibo" type="hidden" value="<?php echo @ $_POST['vcobrorecibo']?>" >
			<input name="tcobrorecibo" type="hidden" value="<?php echo @ $_POST['tcobrorecibo']?>" > 
			<input name="codcatastral" type="hidden" value="<?php echo @ $_POST['codcatastral']?>" >
 			<?php 
 				if(@ $_POST['oculto'])
				{
					switch(@ $_POST['tiporec'])
					{
						case 1:	//RECAUDO PREDIAL
						{
							if($_POST[tipo]=='1')
							{
								$sqlr="SELECT T1.vigencia FROM tesoacuerdopredial_det T1,tesoacuerdopredial T2 WHERE T1.idacuerdo = '$_POST[idrecaudo]' AND T2.idacuerdo = T1.idacuerdo AND T2.estado = 'S' ";
								$res=mysql_query($sqlr,$linkbd);
								$vigencias="";
								while($row = mysql_fetch_row($res)){$vigencias.=($row[0]."-");}
								$vigencias=utf8_decode("A�os liquidados: ".substr($vigencias,0,-1));
								$sql="SELECT * FROM tesoacuerdopredial WHERE idacuerdo = '".$_POST['idrecaudo']."' AND estado='S' AND (cuotas-cuota_pagada) > 0";
								$result=mysql_query($sql,$linkbd);
								$_POST[encontro]="";
								while($row = mysql_fetch_row($result))
								{
									$_POST['cuotas']=$row[10]+1;
									$_POST['tcuotas']=$row[4];
									$_POST['codcatastral']=$row[1];
									if($_POST['concepto']==""){$_POST['concepto']="$vigencias Cod Catastral No $row[1]";}
									$_POST['valorecaudo']=$row[7];
									$_POST['totalc']=$row[7];
									$_POST['tercero']=$row[13];
									$sqlr1="SELECT nombrepropietario FROM tesopredios WHERE cedulacatastral= '".$_POST['codcatastral']."' AND estado='S'";
									$resul=mysql_query($sqlr1,$linkbd);
									$row1 =mysql_fetch_row($resul);
									$_POST['ntercero']=$row1[0];
									if ($_POST['ntercero']=='')
									{
										$sqlr2="SELECT * FROM tesopredios WHERE cedulacatastral='$row[1]' AND ord='$row[11]' AND tot='$row[12]'";
										$resc=mysql_query($sqlr2,$linkbd);
										$rowc =mysql_fetch_row($resc);
										$_POST['ntercero']=$rowc[6];
									}
									$_POST['encontro']=1;
								}
							}
							else
							{
								$_POST['cuotas']="1";
								$_POST['tcuotas']="1";
								$sqlr="SELECT * FROM tesoliquidapredial WHERE idpredial='".$_POST['idrecaudo']."' AND estado ='S' AND 1=".$_POST['tiporec'];
								$_POST['encontro']="";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res))
	 							{
									$_POST['codcatastral']=$row[1];
									if($_POST['concepto']==""){$_POST['concepto']="$row[17] Cod Catastral No $row[1] $row[19] $row[20]";}
									$_POST['valorecaudo']=$row[8];
									$_POST['totalc']=$row[8];
									$_POST['tercero']=$row[4];
									$sqlr1="select nombrepropietario from tesopredios where cedulacatastral = '".$_POST['codcatastral']."' and estado='S'";
									$resul=mysql_query($sqlr1,$linkbd);
									$row1 =mysql_fetch_row($resul);
									$_POST['ntercero']=$row1[0];
									if ($_POST['ntercero']=='')
									{
										$sqlr2="select *from tesopredios where cedulacatastral='$row[1]' and ord='$row[19]' and tot='$row[20]'";
										$resc=mysql_query($sqlr2,$linkbd);
										$rowc =mysql_fetch_row($resc);
										$_POST['ntercero']=$rowc[6];
									}	
									$_POST['encontro']=1;
								}
							}
						}break;
						case 2:	//RECAUDO INDUSTRIA Y COMERCIO
						{
							$sqlr="SELECT * FROM tesoindustria WHERE id_industria='$_POST[idrecaudo]' AND estado ='S' AND 2='$_POST[tiporec]'";
							$_POST[encontro]="";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								if($_POST[concepto]==""){$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - $row[3]";}	
								$_POST[valorecaudo]=$row[6];		
								$_POST[totalc]=$row[6];	
								$_POST[tercero]=$row[5];	
								$_POST[ntercero]=buscatercero($row[5]);	
								$_POST[encontro]=1;
								$_POST[cuotas]=$row[9]+1;
								$_POST[tcuotas]=$row[8];
							}
						}break;
						case 3:	//OTROS RECAUDOS
						{
							$sqlr="select *from tesorecaudos where tesorecaudos.id_recaudo=$_POST[idrecaudo] and estado ='S' and 3=$_POST[tiporec]";
							$_POST[encontro]="";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								if($_POST[concepto]==""){$_POST[concepto]=$row[6];	}
								$_POST[valorecaudo]=$row[5];		
								$_POST[totalc]=$row[5];	
								$_POST[tercero]=$row[4];	
								$_POST[ntercero]=buscatercero($row[4]);	
								$_POST[encontro]=1;
							}
						}break;
					}
				}
			?>
			<table class="inicio" style="width:99.7%;">
				<tr >
					<td class="titulos" colspan="9">Recibo de Caja</td>
					<td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2cm;" >No Recibo:</td>
					<td style="width:20%;" colspan="<?php if(@ $_POST['tiporec'] == '1'){echo '3'; }else{echo '1';}?>" >
						<input type="hidden" name="cuentacaja"  value="<?php echo @ $_POST['cuentacaja']?>"/>
						<input type="text" name="idcomp" id="idcomp" value="<?php echo @ $_POST['idcomp']?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly/>
					</td>
					<td class="saludo1" style="width:2.3cm;">Fecha: </td>
					<td style="width:18%;"><input type="text" name="fecha" value="<?php echo @ $_POST['fecha']?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;" onChange="verificarfecha();"/>&nbsp;<img src="imagenes/calendario04.png"  class="icobut" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"/></td>
					<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
					<td style="width:12%;"><input type="text" id="vigencia" name="vigencia" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo @ $_POST['vigencia']?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" style="width:100%;" readonly></td>
					<input type="hidden" name="vigesistem" id="vigesistem" value="<?php echo $_POST[vigesistem]?>"/>
					<td rowspan="6" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;"></td>
				</tr>
				<tr>
					<td class="saludo1"> Recaudo:</td>
					<td>
						<select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:100%;">
							<option value=""> Seleccione ...</option>
							<option value="1" <?php if($_POST['tiporec']=='1') echo "SELECTED"; ?>>Predial</option>
							<option value="2" <?php if($_POST['tiporec']=='2') echo "SELECTED"; ?>>Industria y Comercio</option>
							<option value="3" <?php if($_POST['tiporec']=='3') echo "SELECTED"; ?>>Otros Recaudos</option>
						</select>
					</td>
					<?php 
						if($_POST['tiporec']=='1')
						{
							$_POST['tipo']=='2';
							
							echo "
								<td class='saludo1'> Tipo:</td>
								<td>
									<select name='tipo' id='tipo' onKeyUp='return tabular(event,this)' style='width:100%;' disabled>
										<option value='2' ";
							if($_POST['tipo']=='2'){echo 'SELECTED';}
							echo">Por Liquidacion</option>
									</select>
								</td>";
						
						}
					?>
					<td class="saludo1"><?php if($_POST['tipo']=='1') {echo 'No. Acuerdo:'; }else{echo 'No Liquidaci&oacute;n:'; } ?></td>
					<td><input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo @ $_POST['idrecaudo']?>"  onKeyUp="return tabular(event,this)" onChange="validar()" style="width:80%;"></td>
					<?php
						if($_POST['tipo']=='2')
						{
							$sqlrAbono = "SELECT * FROM tesoabono WHERE cierre='".$_POST['idrecaudo']."'";
							$rowAbono = view($sqlrAbono);
						}
						if($rowAbono==NULL)
						{
					?>
							<td class="saludo1">Recaudado en:</td>
							<td> 
								<select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:100%;">
									<option value="">Seleccione ...</option>
									<option value="banco" <?php if($_POST[modorec]=='banco') echo "SELECTED"; ?>>Banco</option>
									<option value="caja" <?php if($_POST[modorec]=='caja') echo "SELECTED"; ?>>Caja</option>         
								</select>
							</td>
						<?php
						}
						else
						{
							if($_POST[idrecaudo]!='')
							{
								$sqCuentaPuente = "select cuentapuente from tesoparametros";
								$rowCuentaPuente = view($sqCuentaPuente);
								?>
								<td class="saludo1">Cuenta Puente:</td>
									<td> 
										<input type="text" name="cuentaPuente" id="cuentaPuente" value="<?php echo $rowCuentaPuente[0]['cuentapuente'] ?>" readonly>
									</td>
								<?php
							}
						}
						?>
				</tr>
				<?php
					if ($_POST['modorec']=='banco')
					{
						echo"
						<tr>
							<td class='saludo1'>Cuenta :</td>
							<td>
								<input type='text' name='cb' id='cb' value='".$_POST['cb']."' style='width:80%;'/>&nbsp;
								<a onClick=\"despliegamodal2('visible',1);\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'>	
									<img src='imagenes/find02.png' style='width:20px;'/>
								</a>
							</td>
							<td colspan='4'>
									<input type='text' id='nbanco' name='nbanco' style='width:100%;' value='".$_POST['nbanco']."' readonly>
							</td>
									<input type='hidden' name='banco' id='banco' value='".$_POST['banco']."'/>
									<input type='hidden' id='ter' name='ter' value='".$_POST['ter']."'/></td>
						</tr>";
					}
				?>
				<tr>
					<td class="saludo1">Concepto:</td>
					<td colspan="<?php if($_POST['tiporec']==2 ){echo '3';}else{echo'5';}?>">
						<input type="text" name="concepto" value="<?php echo @ $_POST['concepto'] ?>" onKeyUp="return tabular(event,this)" style="width:95%;">
						<input type="hidden" name="notaf" id="notaf" value="<?php echo @ $_POST['notaf']?>" >&nbsp;<img src="imagenes/notaf.png" class="icobut" onClick="despliegamodal2('visible',2);" title="Notas"/>
					</td>
					<?php
						if((@ $_POST['tiporec']==2) || (@ $_POST['tiporec']==1))
						{
							echo" 
							<td class='saludo1'>No Cuota:</td>
							<td><input type='text' name='cuotas' size='1' value='".$_POST['cuotas']."' readonly>/<input type='text' id='tcuotas' name='tcuotas' value='".$_POST['tcuotas']."' size='1' readonly ></td>";
						}
					?>
				</tr>
				<tr>
					<td  class="saludo1">Documento: </td>
					<td colspan="<?php if($_POST['tiporec']=='1'){echo '3'; }else{echo '1';}?>" ><input type="text" name="tercero" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
					<td class="saludo1">Contribuyente:</td>
					<td colspan="3"><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST['ntercero']?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
				</tr>
				<tr>
					<td class="saludo1">Valor:</td>
					<td colspan="<?php if($_POST['tiporec']=='1'){echo '3'; }else{echo '1';}?>">
						<input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST['valorecaudo']?>" onKeyUp="return tabular(event,this)" style="width:90%;" readonly >
					</td>
				</tr>
				<?php if ($_POST['modorec']!='banco'){echo"<tr style='height:20;'><tr>";}?>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="trec" value="<?php echo $_POST[trec]?>"/>
			<div class="subpantallac7"  style="height:49.3%; width:99.6%; overflow-x:hidden;" id="divdet">
			<?php 
				if($_POST['oculto'] && $_POST['encontro']=='1')
				{
					switch($_POST['tiporec']) 
					{
						case 1: //********PREDIAL
						{
							$_POST['dcoding']= array();
							$_POST['dncoding']= array();
							$_POST['dvalores']= array();
							if(@ $_POST['tcobrorecibo']=='S')
							{	 
								$_POST['dcoding'][]=$_POST['cobrorecibo'];
								$_POST['dncoding'][]=buscaingreso($_POST['cobrorecibo'])." ".$vigusu;
								$_POST['dvalores'][]=$_POST['vcobrorecibo'];
							}
							$_POST['trec']='PREDIAL';
								$sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial = ".$_POST['idrecaudo']." and estado ='S'  and 1=".$_POST['tiporec'];
								$res=mysql_query($sqlr,$linkbd);
								//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
								while ($row =mysql_fetch_row($res)) 
								{
									$vig=$row[1];
									if($vig==$vigusu)
									{
										$sqlr2="select * from tesoingresos where codigo='01'";
										$res2=mysql_query($sqlr2,$linkbd);
										$row2 =mysql_fetch_row($res2);
										$_POST['dcoding'][]=$row2[0];
										$_POST['dncoding'][]=$row2[1]." ".$vig;
										$_POST['dvalores'][]=$row[11];		 
									}
									else
									{	
										$sqlr2="select * from tesoingresos where codigo='03'";
										$res2=mysql_query($sqlr2,$linkbd);
										$row2 =mysql_fetch_row($res2); 
										$_POST['dcoding'][]=$row2[0];
										$_POST['dncoding'][]=$row2[1]." ".$vig;
										$_POST['dvalores'][]=$row[11];
									}
								}
							
						}break;
						case 2: //***********INDUSTRIA Y COMERCIO
						{
							$_POST['dcoding']= array();
							$_POST['dncoding']= array();
							$_POST['dvalores']= array();
							$_POST['trec']='INDUSTRIA Y COMERCIO';
							if(@ $_POST['tcobrorecibo']=='S')
							{
								$_POST['dcoding'][]=$_POST['cobrorecibo'];
								$_POST['dncoding'][]=buscaingreso($_POST['cobrorecibo'])." ".$vigusu;
								$_POST['dvalores'][]=$_POST['vcobrorecibo'];
							}
							$sqlr="select *from tesoindustria where tesoindustria.id_industria=".$_POST['idrecaudo']." and estado ='S' and 2=".$_POST['tiporec'];
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								$sqlr2="select * from tesoingresos where codigo='02' ";
								$res2=mysql_query($sqlr2,$linkbd);
								$row2 =mysql_fetch_row($res2);
								$_POST['dcoding'][]=$row2[0];
								$_POST['dncoding'][]=$row2[1];
								$_POST['dvalores'][]=$row[6]/$_POST['tcuotas'];
							}
						}break;
						case 3: ///*****************otros recaudos *******************
						{
							$_POST['trec']='OTROS RECAUDOS';
							$_POST['dcoding']= array();
							$_POST['dncoding']= array();
							$_POST['dvalores']= array();
							if(@ $_POST['tcobrorecibo']=='S')
							{
								$_POST['dcoding'][]=$_POST['cobrorecibo'];
								$_POST['dncoding'][]=buscaingreso($_POST['cobrorecibo'])." ".$vigusu;
								$_POST['dvalores'][]=$_POST['vcobrorecibo'];
							}
							$sqlr="select *from tesorecaudos_det where tesorecaudos_det.id_recaudo=".$_POST['idrecaudo']." and estado ='S'  and 3=".$_POST['tiporec'];
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								$_POST['dcoding'][]=$row[2];
								$sqlr2="select nombre from tesoingresos where codigo='".$row[2]."'";
								$res2=mysql_query($sqlr2,$linkbd);
								$row2 =mysql_fetch_row($res2);
								$_POST['dncoding'][]=$row2[0];
								$_POST['dvalores'][]=$row[3];
							}
						}break;
					}
				}
				?>
				<table class="inicio">
					<tr><td colspan="4" class="titulos">Detalle Recibo de Caja</td></tr>
					<tr>
						<td class="titulos2" style="width:15%;">Codigo</td>
						<td class="titulos2">Ingreso</td>
						<td class="titulos2" style="width:20%;">Valor</td>
					</tr>
					<?php
						$_POST['totalc']=0;
						$co="saludo1a";
						$co2="saludo2";
						for ($x=0;$x<count($_POST['dcoding']);$x++)
						{
							echo "
							<input type='hidden' name='dcoding[]' value='".$_POST['dcoding'][$x]."'>
							<input type='hidden' name='dncoding[]' value='".$_POST['dncoding'][$x]."'>
							<input type='hidden' name='dvalores[]' value='".$_POST['dvalores'][$x]."'>
							<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								<td>".$_POST['dcoding'][$x]."</td>
								<td>".$_POST['dncoding'][$x]."</td>
								<td style='text-align:right;'>$ ".number_format($_POST['dvalores'][$x],2)."</td>
							</tr>";
							$_POST['totalc']=$_POST['totalc']+$_POST['dvalores'][$x];
							$_POST['totalcf']=number_format($_POST['totalc'],2);
							$totalg=number_format($_POST['totalc'],2,'.','');
							$aux=$co;
							$co=$co2;
							$co2=$aux;
						}
						if ($_POST['totalc']!='' && $_POST['totalc']!=0){$_POST['letras'] = convertirdecimal($totalg,'.');}
						else{$_POST['letras']=''; $_POST['totalcf']=0;}
						echo "
						<input type='hidden' name='totalcf' value='".$_POST['totalcf']."'>
						<input type='hidden' name='totalc' value='".$_POST['totalc']."'>
						<input type='hidden' name='letras' value='".$_POST['letras']."'>
						<tr class='$co' style='text-align:right;'>
							<td colspan='2'>Total</td>
							<td>$ ".$_POST['totalcf']."</td>
						</tr>
						<tr class='titulos2'>
							<td>Son:</td>
							<td colspan='2'>".$_POST['letras']."</td>
						</tr>";
					?> 
				</table>
			</div>
			<?php 
				if($_POST['oculto']=='2')
				{
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					$bloq=bloqueos($_SESSION['cedulausu'],$fechaf);	
					if($_POST['modorec']=='caja')
					{
						$cuentacb=$_POST['cuentacaja'];
						$cajas=$_POST['cuentacaja'];
						$cbancos="";
					}
					if($_POST['modorec']=='banco')
					{
						$cuentacb=$_POST['banco'];
						$cajas="";
						$cbancos=$_POST['banco'];
					}
					if($bloq>=1)
					{
						//************VALIDAR SI YA FUE GUARDADO ************************
						switch($_POST['tiporec']) 
						{
							case 1://***** PREDIAL *****************************************
							{
								$var01=$var02=0;
								$sqlr="select count(*) from tesoreciboscaja where id_recaudo=".$_POST['idrecaudo']." and tipo='1' AND estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
								if($numerorecaudos==0)
								{
									if(@ $_POST['modorec']=='caja')
									{
										$cuentacb=$_POST['cuentacaja'];
										$cajas=$_POST['cuentacaja'];
										$cbancos="";
									}
									if(@ $_POST['modorec']=='banco')
									{
										$cuentacb=$_POST['banco'];
										$cajas="";
										$cbancos=$_POST['banco'];
									}
									if(@ $_POST['cuentaPuente']!='')
									{
										$cuentacb=$_POST['cuentaPuente'];
										$cajas="";
										$cbancos=$_POST['bacuentaPuentenco'];
									}
									$user=$_SESSION['nickusu'];
									$sqlr="insert into tesoreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco, valor,estado,tipo,descripcion,usuario) values('0','$fechaf','$vigusu', '".$_POST['idrecaudo']."','".$_POST['modorec']."','$cajas','$cbancos', '".$_POST['totalc']."','S','".$_POST['tiporec']."','".$_POST['concepto']."','$user')";
									if (!mysql_query($sqlr,$linkbd))
									{
										$e =mysql_error(mysql_query($sqlr,$linkbd));
										echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n: $e');</script>";
									}
									else
									{
										$concecc=mysql_insert_id();
									}
									//************ insercion de cabecera recaudos ************
									echo "<input type='hidden' name='concec' value='$concecc'>";
									//marca;
									echo "<script>
										despliegamodalm('visible','1','>Se ha almacenado el Recibo de Caja con Exito');
										document.form2.vguardar.value='1';
										
									</script>";
								
									$sqlr="update tesoliquidapredial set estado='P' WHERE idpredial=".$_POST['idrecaudo'];
									mysql_query($sqlr,$linkbd);
									$sqlr="Select *from tesoliquidapredial_det where idpredial=".$_POST['idrecaudo'];
									$resq=mysql_query($sqlr,$linkbd);
									while($rq=mysql_fetch_row($resq))
									{
										$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=".$_POST['idrecaudo'].") AND vigencia=$rq[1]";
										mysql_query($sqlr2,$linkbd);
									}
									
									echo"
									<script>
										document.form2.numero.value='';
										document.form2.valor.value=0;
									</script>";
									//**********************CREANDO COMPROBANTE CONTABLE ********************************	 
									$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito, total_credito, diferencia,estado) values ($concecc,5,'$fechaf','".$_POST['concepto']."',0, ".$_POST['totalc'].",".$_POST['totalc'].",0,'1')";
									mysql_query($sqlr,$linkbd);
									//******parte para el recaudo del cobro por recibo de caja
									for($x=0;$x<count($_POST['dcoding']);$x++)
									{
										if($_POST['dcoding'][$x]==$_POST['cobrorecibo'])
										{
											//***** BUSQUEDA INGRESO ********
											$sqlri="Select * from tesoingresos_det where codigo='".$_POST['dcoding'][$x]."' and vigencia='$vigusu'";
											$resi=mysql_query($sqlri,$linkbd);
											while($rowi=mysql_fetch_row($resi))
											{
												//**** busqueda cuenta presupuestal*****
												//busqueda concepto contable
												$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
												$re=mysql_query($sq,$linkbd);
												while($ro=mysql_fetch_assoc($re)){$_POST['fechacausa']=$ro["fechainicial"];}
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST['fechacausa']."'";
												$resc=mysql_query($sqlrc,$linkbd);
												while($rowc=mysql_fetch_row($resc))
												{
													$porce=$rowi[5];
													if($rowc[7]=='S')
													{
														$valorcred=$_POST['dvalores'][$x]*($porce/100);
														$valordeb=0;
														if($rowc[3]=='N')
														{
															//*****inserta del concepto contable  
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO
															
															$vi=$_POST['dvalores'][$x]*($porce/100);
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]', '".$_POST['tercero']."','$rowc[5]','Ingreso ".strtoupper($_POST['dncoding'][$x])."','','".round($valordeb,0)."','".round($valorcred,0)."','1','".$_POST['vigencia']."')";
															mysql_query($sqlr,$linkbd);
															//***cuenta caja o banco
															if(@ $_POST['modorec']=='caja')
															{
																$cuentacb=$_POST['cuentacaja'];
																$cajas=$_POST['cuentacaja'];
																$cbancos="";
															}
															if(@ $_POST['modorec']=='banco')
															{
																$cuentacb=$_POST['banco'];
																$cajas="";
																$cbancos=$_POST['banco'];
															}
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','".$_POST['tercero']."', '$rowc[5]','Ingreso ".strtoupper($_POST['dncoding'][$x])."','','".round($valorcred,0)."','0','1','".$_POST['vigencia']."')";
															mysql_query($sqlr,$linkbd);
														}
													}
		 										}
		 									}
	 									}
									}
									
	 								//*************** fin de cobro de recibo
									$sql="select codigocatastral from tesoliquidapredial WHERE idpredial=".$_POST['idrecaudo']." and estado !='N'";
									$resul=mysql_query($sql,$linkbd);
									$rowcod=mysql_fetch_row($resul);
									$tipopre=obtenerTipoPredio($rowcod[0]);
									//die();
									$sqlr="select *from tesoliquidapredial_det where idpredial=".$_POST['idrecaudo']." and estado ='S'  and 1=".$_POST['tiporec'];
									$res=mysql_query($sqlr,$linkbd);
									//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
									while ($row =mysql_fetch_row($res)) 
									{
										
										$vig=$row[1];
										$vlrdesc=$row[10];	
										
										if($vig==$vigusu) //*************VIGENCIA ACTUAL *****************
										{
											$idcomp=mysql_insert_id();
											echo "<input type='hidden' id='ncomp' name='ncomp' value='$idcomp'>";
											$sqlr2="select * from tesoingresos_det where codigo='01' AND modulo='4' and vigencia=$vigusu group by concepto";
											$res2=mysql_query($sqlr2,$linkbd);
											//****** $cuentacb   ES LA CUENTA CAJA O BANCO
											while($rowi =mysql_fetch_row($res2))
											{
												switch($rowi[2])
												{
													case '01': //***
														$sqlrds="select * from tesoingresos_det where codigo='01' and concepto='P01' AND modulo='4' and vigencia=$vigusu";
														$resds=mysql_query($sqlrds,$linkbd);
														while($rowds =mysql_fetch_row($resds))
														{$descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);}
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re))
														{$_POST['fechacausa']=$ro["fechainicial"];}
														
														$valorcred=$row[4];
														$valordeb=$row[4];
														
														if($valorcred>0)
														{
															$vi=$row[4]-$descpredial;
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='01' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowp[0]',$concecc,$vi,'$vigusu','N','01')";
																	mysql_query($sqlr,$linkbd);
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','01')";
																	mysql_query($sqlr,$linkbd);
																	$sqlr="";
																}
															}
														}
				 										$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C' and fechainicial='".$_POST['fechacausa']."'";
														$resc=mysql_query($sqlrc,$linkbd);
														while($rowc=mysql_fetch_row($resc))
														{
															$valordeb=0;
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Impuesto Predial Vigente $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=round($valorcred-$descpredial,2);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Impuesto Predial Vigente $vig','','".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO ******
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);	
																		//************ FIN MODIFICACION PPTAL		
																	}
																}
															}
														}
													break;
													case '02': //***
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														if($_POST[tipo]=='1')
														{
															$valorcred=round($row[7]*$dat[0][porcentaje_valor],2);
															$valordeb=round($row[7]*$dat[0][porcentaje_valor],2);
														}
														else
														{
															$valorcred=$row[8];
															$valordeb=$row[8];
														}
														
														if($valorcred>0)
														{
															if($_POST[tipo]=='1'){$vi=$valordeb;}
															else{$vi=$row[8];}
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND  tipo LIKE '%$tipopre%' AND concepto='02' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','02')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','02')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															}
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[7]=='S')
															{	
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Ambiental $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Ingreso Sobretasa Ambiental $vig','','".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
					  													//*******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *******
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);	
			  			
																		//************ FIN MODIFICACION PPTAL
					  												}
																}
				  											}
														}
													}break;
													case '03':
													{
														$sqlrds="select * from tesoingresos_det where codigo='01' and concepto='P10' AND modulo='4' and vigencia='$vigusu'";
														$resds=mysql_query($sqlrds,$linkbd);
														while($rowds =mysql_fetch_row($resds))
		   												{$descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);}
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														
														if($_POST[tipo]=='1')
														{
															$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);
															$valordeb=round($row[5]*$dat[0][porcentaje_valor],2);
														}
														else 
														{
															$valorcred=$row[6];
															$valordeb=$row[6];
														}
														
														if($valorcred>0)
														{
															$vi=$row[6]-$descpredial;
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='03' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
														}
														
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]', '$rowc[5]','Ingreso Sobretasa Bomberil $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=round($valorcred-$descpredial,0);
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Bomberil $vig','', '".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
					  													//*********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);
																		//************ FIN MODIFICACION PPTAL			
																	}
																}
															}
														}
													}break;
													case 'P10':
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														
														if($_POST[tipo]=='1')
														{$valordeb=round(($row[9]*$dat[0][porcentaje_valor])*round(($porce/100),2),2);}
														else{$valordeb=round($row[10]*round(($porce/100),2),2);}
																
														if($valordeb>0){
															$vi=$valordeb;
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P10' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
																//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P10')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P10')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															}
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST['fechacausa']."'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);
				 										while($rowc=mysql_fetch_row($resc))
				 										{
															$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{	
																
																$valorcred=0;
																if($rowc[3]=='N')
				    											{
				 	 												if($valordeb>0)
					  												{
				 														//$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Descuento Pronto Pago Bomberil $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																		//mysql_query($sqlr,$linkbd);
							  											//********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
			 															//echo "con: $sqlrpto <br>";	      
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
																		mysql_query($sqlr,$linkbd);
					  												}
																}
				 											}
				 										}
													}break;
													case 'P01':
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														if($_POST[tipo]=='1')
														{$valordeb=round(($row[9]*$dat[0][porcentaje_valor])*round(($porce/100),2),2);}
														else {$valordeb=round($row[10]*round($porce/100,2),2);}
														
														if($valordeb>0){
															$vi=$valordeb;
															//****creacion documento presupuesto ingresos		
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P01' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P01')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P10')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															}	
															//************ FIN MODIFICACION PPTAL
														}
														
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																// $descpredial=round($vlrdesc*round($rowds[5]/100,2),2);
																$valorcred=0;
																if($rowc[3]=='N')
																{
																	if($valordeb>0)
																	{
				 														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Descuento Pronto Pago Predial $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
																		mysql_query($sqlr,$linkbd);
																	}
																}
															}
														}
													}break;
													case 'P02':
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														
														if($_POST[tipo]=='1'){$valorcred=round($row[3]*$dat[0][porcentaje_valor],2);}
														else{$valorcred=$row[5];}
														$valordeb=$valorcred;
														
														if($valorcred>0){
															if($_POST[tipo]=='1'){
																$vi=$valordeb;
															}else{
																$vi=$row[5];
															}
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P02' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P02')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P02')";
																	mysql_query($sqlr,$linkbd);
																	$sqlr="";
																}
															}
														//************ FIN MODIFICACION PPTAL
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);
				 										while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{	
																
																$valordeb=0;
																if($rowc[3]=='N')
				    											{
				 	 												if($valorcred>0)
					  												{
				 														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','".round($valordeb,0)."', '".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','".round($valordeb,0)."', '0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
							  											//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 																$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
																		mysql_query($sqlr,$linkbd);	
																	}
																}
															}
															else
															{
																if($_POST[tipo]=='1'){$valorcred=round($row[3]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[5];}
																if($valorcred>0)
																{
																	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																}
															}
				 										}
													}break;
													case 'P04':
													{ 
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														if($_POST[tipo]=='1'){$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);}
														else{$valorcred=$row[7];}
														$valordeb=$valorcred;
														
														if($valorcred>0){
															//****creacion documento presupuesto ingresos
			  												if($_POST[tipo]=='1'){
																$vi=$valordeb;
															}else{
																$vi=$row[7];
															}		
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P04' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P04')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P04')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															}
															//************ FIN MODIFICACION PPTAL
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{
																
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Sobretasa Bomberil $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Sobretasa Bomberil $vig','','".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
							  											//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO 
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
																		mysql_query($sqlr,$linkbd);
																	}
																}
															}
															else
															{
																if($_POST[tipo]=='1'){$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[7];}
																if($valorcred>0)
																{
																	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																}
															}
					 									}
													}break;  
													case 'P05':
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														if($_POST[tipo]=='1'){$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);}
														else{$valorcred=$row[6];}
														$valordeb=$valorcred;
														if($valorcred>0){
															$vi=$valordeb;
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND  tipo LIKE '%$tipopre%' AND concepto='P05' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P05')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P05')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															}
															//************ FIN MODIFICACION PPTAL
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{
																
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
				 														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1',''$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta = '$rowi[6]' and vigencia='$vigusu'";
																		mysql_query($sqlr,$linkbd);	
																	}
																}
															}
														}
													}break;
													case 'P07': 
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														if($_POST[tipo]=='1'){$valorcred=round($row[8]*$dat[0][porcentaje_valor],2);}
														else{$valorcred=$row[9];}
														$valordeb=$valorcred;
														
														if($valorcred>0){
															if($_POST[tipo]=='1'){
																$vi=$valordeb;
															}else{
																$vi=$row[9];
															}
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P07' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P07')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P07')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															}
															//************ FIN MODIFICACION PPTAL	
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
				 														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobtretasa Ambiental $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Intereses Sobtretasa Ambiental $vig','','".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
							  											//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);
																	}
																}
															}
														}
													}break;
													case 'P08': 
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
															{
																$valorcred=0;
																if($_POST[tipo]=='1'){$valordeb=round($row[7]*$dat[0][porcentaje_valor],2);}
																else{$valordeb=$row[8];}
															}
															if($rowc[6]=='N')
															{
																$valordeb=0;
																if($_POST[tipo]=='1'){$valorcred=round($row[7]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[8];}
															}	
															if($rowc[3]=='N')
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Sobtretasa Ambiental $vig','','".round($valordeb,0)."', '".round($valorcred,0)."', '1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);	
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																$respto=mysql_query($sqlrpto,$linkbd);
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																mysql_query($sqlr,$linkbd);	
																//****creacion documento presupuesto ingresos
															
																$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P08' AND vigencia=$vigusu";
																$resul=mysql_query($sql,$linkbd);
																$numreg=mysql_num_rows($resul);
																//****creacion documento presupuesto ingresos
																while($rowp = mysql_fetch_row($resul))
																{
																	if($rowp[0]!=$rowi[6] && $vi>0)
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia, tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P08')";
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	}
																}
																if($numreg==0 )
																{
																	if($vi>0 && $rowi[6]!="")
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P08')";
																		//echo $sqlr;
																		mysql_query($sqlr,$linkbd); 
																		$sqlr="";
																	
																	}
																}
															}
				  										}
													}break;
													case 'P18': //***
													{
														$siAlumbrado=0;
														$sqlrDesc = "SELECT val_alumbrado FROM tesoliquidapredial_desc WHERE id_predial='$row[0]' AND vigencia=$vig ORDER BY vigencia ASC";
														$resDesc = mysql_query($sqlrDesc,$linkbd);
														while ($rowDesc =mysql_fetch_assoc($resDesc))
														{
															$siAlumbrado = $rowDesc['val_alumbrado'];
														}
														if($siAlumbrado>0)
														{
															$valorAlumbrado=round($siAlumbrado,0);
															//$valorAlumbrado=round($row[2]*($vcobroalumbrado/1000),0);
															$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
															$re=mysql_query($sq,$linkbd);
															while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
															$valorcred=$valorAlumbrado;
															$valordeb=0;
															if($valorcred>0)
															{
																$vi=$valorcred;
																$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND  tipo LIKE '%$tipopre%' AND concepto='P18' AND vigencia=$vigusu";
																$resul=mysql_query($sql,$linkbd);
																$numreg=mysql_num_rows($resul);
																//****creacion documento presupuesto ingresos
																while($rowp = mysql_fetch_row($resul))
																{
																	if($rowp[0]!="" && $vi>0)
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowp[0]',$concecc,$vi,'$vigusu','N','02')";
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	}
																}
																if($numreg==0 )
																{
																	if($vi>0 && $rowi[6]!="")
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','02')";
																		mysql_query($sqlr,$linkbd); 
																		$sqlr="";
																	}
																}
															}
															$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST['fechacausa']."'";
															$resc=mysql_query($sqlrc,$linkbd);
															while($rowc=mysql_fetch_row($resc))
															{
																$porce=$rowi[5];
																if($rowc[7]=='S')
																{	
																	$valordeb=0;
																	if($rowc[3]=='N')
																	{
																		if($valorcred>0)
																		{
																			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Impuesto sobre el Servicio de Alumbrado P�blico $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			$valordeb=$valorcred;
																			$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','".$_POST['tercero']."', '$rowc[5]','Ingreso Impuesto sobre el Servicio de Alumbrado Publico $vig','','".round($valordeb,0)."','0','1','".$_POST['vigencia']."')";
																			mysql_query($sqlr,$linkbd);
																			//*******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *******
																			$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																			$respto=mysql_query($sqlrpto,$linkbd);	  
																			$rowpto=mysql_fetch_row($respto);
																			$vi=$valordeb;
																			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																			mysql_query($sqlr,$linkbd);	

																			//************ FIN MODIFICACION PPTAL
																		}
																	}
																}
															}
														}
													}break;
												}
											}
											if($_POST[tipo]=='1')
											{
												$_POST[dcoding][]=$row2[0][codigo];
												$_POST[dncoding][]=$row2[0][nombre]." ".$vig;
												$_POST[dvalores][]=$dvalor;	
											}
											else
											{
												$_POST[dcoding][]=$row2[0];
												$_POST[dncoding][]=$row2[1]." ".$vig;
												$_POST[dvalores][]=$row[11];
											}
	 									}
		 								else  ///***********OTRAS VIGENCIAS ***********
	   	 								{	
											//$tasadesc=$row[10]/($row[4]+$row[6]);
											$tasadesc=$row[10];
											$idcomp=mysql_insert_id();
											echo "<input type='hidden' name='ncomp' value='$idcomp'>";	
											$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
											mysql_query($sqlr,$linkbd);
											$sqlr2="select * from tesoingresos_det where codigo='03' AND modulo='4' and vigencia=$vigusu GROUP BY concepto";
											$res2=mysql_query($sqlr2,$linkbd);
											//****** $cuentacb   ES LA CUENTA CAJA O BANCO
											while($rowi =mysql_fetch_row($res2))
											{
												switch($rowi[2])
												{
													case 'P03': //***
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re))
														{
															$_POST['fechacausa']=$ro["fechainicial"];
														}
														$valorcred=$row[4];
														$valordeb=$valorcred;
														
														if($valorcred>0)
														{
															$vi=$row[4]-$tasadesc;
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P03' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P03')";
																	mysql_query($sqlr,$linkbd);
																	$sqlr="";
																}
															}
															//echo "$numreg ";
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P03')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															}
															//************ FIN MODIFICACION PPTAL
														}
														
				 										$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST['fechacausa']."'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
															{
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST['tercero']."','$rowc[5]','Ingreso Impuesto Predial Otras Vigencias $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','".$_POST['vigencia']."')";
																		mysql_query($sqlr,$linkbd);
																		//$valordeb=$valorcred-$tasadesc*$valorcred;
																		$valordeb=$valorcred-$tasadesc;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','".$_POST['tercero']."', '$rowc[5]','Ingreso Impuesto Predial Otras Vigencias $vig','','".round($valordeb,0)."',0,'1','".$_POST['vigencia']."')";
																		mysql_query($sqlr,$linkbd);
						  												//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO 
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);
																	}
																}
															}
														}
													break;
													case 'P06': //***
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
			 											if($_POST[tipo]=='1'){$valorcred=round($row[7]*$dat[0][porcentaje_valor],2);}
														else{$valorcred=$row[8];}
														$valordeb=$valorcred;
														
														if($valorcred>0){
															if($_POST[tipo]=='1'){
															$vi=$valordeb;
															}else{
																$vi=$row[8];
															}
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P06' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P06')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P06')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															}
															//************ FIN MODIFICACION PPTAL
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
				 										while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{		
																
																$valordeb=0;
																if($rowc[3]=='N')
				    											{
				 	 												if($valorcred>0)
					  												{
				 														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Ambiental $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Ambiental $vig','', '".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);	
																			
																	}
																}
															}
														}
													}break;
													case '03':
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														if($_POST[tipo]=='1'){$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);}
														else{$valorcred=$row[6];}
														$valordeb=$valorcred;
														
														if($valorcred>0){
															$vi=$valordeb;
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='03' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','03')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','03')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															}
															//************ FIN MODIFICACION PPTAL
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
				 										while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{	
																
																$valordeb=0;					
																if($rowc[3]=='N')
				    											{
				 	 												if($valorcred>0)
					  												{						
				 														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Bomberil $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred-$tasadesc*$valorcred;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Bomberil $vig','','".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
							 											//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO 
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);	
			  																
					  												}
																}
				 											}
				 										}
													}break;
													case 'P01':
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);		  
				 										while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{		
																if($_POST[tipo]=='1'){$valordeb=round($row[9]*$dat[0][porcentaje_valor],2);}
																else {$valordeb=$row[10];}
																$valorcred=0;
																if($rowc[3]=='N')
																{
																	if($valordeb>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Descuento Pronto Pago $vig','', '".round($valordeb,0)."','".round($valorcred,2)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																	}
																}
				  											}
				 										}
													}break;
													case 'P02': //Intereses Predial
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='".$rowi[2]."' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														if($_POST[tipo]=='1'){$valorcred=round($row[3]*$dat[0][porcentaje_valor],2);}
														else{$valorcred=$row[5];}
														$valordeb=$valorcred;
														
														if($valorcred>0){
															$vi=$valordeb;
															//****creacion documento presupuesto ingresos
																		
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P02' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia, tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P02')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
														   }
														   if($numreg==0 )
														   {
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P02')";
																	//echo $sqlr;
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
														   }
															//************ FIN MODIFICACION PPTAL
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','".round($valordeb,0)."', '".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','".round($valordeb,0)."', 0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);
																	}
																}
																else
																{
																	if($_POST[tipo]=='1'){$valorcred=round($row[3]*$dat[0][porcentaje_valor],2);}
																	else{$valorcred=$row[5];}
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																	}
																}
															}
															else
															{
																if($_POST[tipo]=='1'){$valorcred=round($row[3]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[5];}
																if($valorcred>0)
																{
																	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																}
															}
														}
													}break;
													case 'P04':
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														if($_POST[tipo]=='1'){$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);}
														else{$valorcred=$row[7];}
														$valordeb=$valorcred;
														
														if($valorcred>0){
															$vi=$valordeb;
															//****creacion documento presupuesto ingresos
																		
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P04' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia, tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P04')";
																mysql_query($sqlr,$linkbd);	
																$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P04')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
														   }
															//************ FIN MODIFICACION PPTAL
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																
																$valordeb=0;					
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{						
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Sobretasa Bomberil $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Sobretasa Bomberil $vig','','".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		// echo "<BR>".$sqlr;
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);	
																			
																	}
																}
															}
															else
															{
																if($_POST[tipo]=='1'){$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[7];}
																if($valorcred>0)
																{	
																	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																}
															}
														}
													}break;
													case 'P05':
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														if($_POST[tipo]=='1'){$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);}
														else{$valorcred=$row[6];}
														$valordeb=$valorcred;
														
														
														if($valorcred>0){
															if($_POST[tipo]=='1'){
															$vi=$valordeb;
															}else{
																$vi=$row[6];
															}
															//****creacion documento presupuesto ingresos
																			
															 $sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P05' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia, tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P05')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P05')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
														   }
															//************ FIN MODIFICACION PPTAL
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{		
																
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		// echo "<BR>".$sqlr;
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);	
																	}
																}
															}
														}
													}break;
													case 'P07':
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='".$rowi[2]."' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														if($_POST[tipo]=='1'){$valorcred=round($row[8]*$dat[0][porcentaje_valor],2);}
														else{$valorcred=$row[9];}
														$valordeb=$valorcred;
														
														if($valorcred>0){
															$vi=$valordeb;
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P07' AND vigencia=$vigusu";
															//echo $sql;
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!=$rowi[6] && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P07')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P07')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															}
														//************ FIN MODIFICACION PPTAL
														}	
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
				 										while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{	
																
																$valordeb=0;
																if($rowc[3]=='N')
				    											{
				 	 												if($valorcred>0)
					  												{
				 														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','".$_POST[vigencia]."')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','','".round($valordeb,0)."',0,'1','".$_POST[vigencia]."')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);	
																			
																	}
																}
															}
														}
													}break;
													case 'P08':
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);
														while($rowc=mysql_fetch_row($resc))
														{
			  												$porce=$rowi[5];
															if($_POST[tipo]=='1'){$valnu=round($row[7]*$dat[0][porcentaje_valor],2);}
															else{$valnu=$row[8];}
															if($rowc[6]=='S')
															{
																$valorcred=0;
																$valordeb=$valnu;
															}
															if($rowc[6]=='N')
															{
																$valorcred=$valnu;
																$valordeb=0;
															}
															if($rowc[3]=='N')
															{
				 												$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Sobtretasa Ambiental $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																$respto=mysql_query($sqlrpto,$linkbd);	
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																mysql_query($sqlr,$linkbd);	
			 													//****creacion documento presupuesto ingresos
																$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P08' AND vigencia=$vigusu";
																$resul=mysql_query($sql,$linkbd);
																$numreg=mysql_num_rows($resul);
																//****creacion documento presupuesto ingresos
																while($rowp = mysql_fetch_row($resul))
																{
																	if($rowp[0]!=$rowi[6] && $vi>0)
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','S','P08')";
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	}
																}
																if($numreg==0 )
																{
																	if($vi>0 && $rowi[6]!="")
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','S','P08')";
																		mysql_query($sqlr,$linkbd); 
																		$sqlr="";
																	}
																}
																//************ FIN MODIFICACION PPTAL		
															}
														}
													}break;
													case 'P18': //***
													{
														$siAlumbrado=0;
														$sqlrDesc = "SELECT val_alumbrado FROM tesoliquidapredial_desc WHERE id_predial='$row[0]' AND vigencia=$vig ORDER BY vigencia ASC";
														$resDesc = mysql_query($sqlrDesc,$linkbd);
														while ($rowDesc =mysql_fetch_assoc($resDesc))
														{
															$siAlumbrado = $rowDesc['val_alumbrado'];
														}
														if($siAlumbrado>0)
														{
															$valorAlumbrado=round($siAlumbrado,0);
															//$valorAlumbrado=round($row[2]*($vcobroalumbrado/1000),0);
															$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
															$re=mysql_query($sq,$linkbd);
															while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
															$valorcred=$valorAlumbrado;
															$valordeb=0;
															if($valorcred>0)
															{
																$vi=$valorcred;
																$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P18' AND vigencia=$vigusu";
																$resul=mysql_query($sql,$linkbd);
																$numreg=mysql_num_rows($resul);
																//****creacion documento presupuesto ingresos
																while($rowp = mysql_fetch_row($resul))
																{
																	if($rowp[0]!="" && $vi>0)
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowp[0]',$concecc,$vi,'$vigusu','N','02')";
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	}
																}
																if($numreg==0 )
																{
																	//echo "$vi --> $rowi[6]";
																	if($vi>0 && $rowi[6]!="")
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','02')";
																		mysql_query($sqlr,$linkbd); 
																		$sqlr="";
																	}
																}
															}
															$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST['fechacausa']."'";
															$resc=mysql_query($sqlrc,$linkbd);
															while($rowc=mysql_fetch_row($resc))
															{
																$porce=$rowi[5];
																if($rowc[7]=='S')
																{	
																	$valordeb=0;
																	if($rowc[3]=='N')
																	{
																		if($valorcred>0)
																		{
																			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Impuesto sobre el Servicio de Alumbrado Publico $vig','','".round($valordeb,2)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			$valordeb=$valorcred;
																			$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','".$_POST['tercero']."', '$rowc[5]','Ingreso Impuesto sobre el Servicio de Alumbrado Publico $vig','','".round($valordeb,0)."','0','1','".$_POST['vigencia']."')";
																			mysql_query($sqlr,$linkbd);
																			//*******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *******
																			$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																			$respto=mysql_query($sqlrpto,$linkbd);	  
																			$rowpto=mysql_fetch_row($respto);
																			$vi=$valordeb;
																			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																			mysql_query($sqlr,$linkbd);
																			//************ FIN MODIFICACION PPTAL
																		}
																	}
																}
															}
														}
													}break;
												} 
											}
										}
									}
									if($_POST[tipo]=='1')
									{
										$sqlr="Select *from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo]";
										$resp=mysql_query($sqlr,$linkbd);
										while($row=mysql_fetch_row($resp,$linkbd))
										{
											$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[13]";
											mysql_query($sqlr2,$linkbd);
										}
										//ACTUALIZAR CUOTA PAGADA
										$sql = "UPDATE tesoacuerdopredial_pagos T1 SET T1.estado='N' WHERE T1.idacuerdo=$_POST[idrecaudo] AND T1.cuota=$_POST[cuotas]";
										view($sql);
									}
									else
									{
										$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
										$resp=mysql_query($sqlr,$linkbd);
										while($row=mysql_fetch_row($resp,$linkbd))
										{
											$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[1]";
											mysql_query($sqlr2,$linkbd);
										}
									}
								} //fin de la verificacion
								else
								{
									echo"<script>despliegamodalm('visible','2','Ya Existe un Recibo de Caja para esta Liquidacion Predial');</script>";
								}//***FIN DE LA VERIFICACION
							}break; //**FIN PREDIAL***********
							case 2:  //********** INDUSTRIA Y COMERCIO
							{
								$entra=true;
								$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='2'";
								$res=mysql_query($sqlr,$linkbd);
								while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
								if($numerorecaudos>=0)
								{
									if($_POST['modorec']=='caja')
									{
										$cuentacb=$_POST['cuentacaja'];
										$cajas=$_POST['cuentacaja'];
										$cbancos="";
									}
									if($_POST['modorec']=='banco')
									{
										$cuentacb=$_POST['banco'];
										$cajas="";
										$cbancos=$_POST['banco'];
									}
									$user=$_SESSION['nickusu'];
									$sqlr="insert into tesoreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor, estado,tipo, descripcion,usuario) values(0,'$fechaf','$vigusu',$_POST[idrecaudo],'$_POST[modorec]','$cajas','$cbancos','$_POST[totalc]', 'S','$_POST[tiporec]','$_POST[concepto]','$user')";	
									if (!mysql_query($sqlr,$linkbd))
									{
	 									echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>Ocurri� el siguiente problema:<br><pre></pre></center></td></tr></table>";
									}
  									else
									{
		 								echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>"; 
										$concecc=$_POST[idcomp]; 
		 								//*************COMPROBANTE CONTABLE INDUSTRIA
										$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito, diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";		  
										mysql_query($sqlr,$linkbd);
		 								$idcomp=mysql_insert_id();
	 	 								$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='2'";
		 								mysql_query($sqlr,$linkbd);
  		  								$sqlr="update tesoindustria set estado='P' WHERE id_industria=$_POST[idrecaudo]";
		 								mysql_query($sqlr,$linkbd);
										//******parte para el recaudo del cobro por recibo de caja
										for($x=0;$x<count($_POST[dcoding]);$x++)
		 								{
		 									if($_POST[dcoding][$x]==$_POST[cobrorecibo])
											{
		 										//***** BUSQUEDA INGRESO ********
												$sqlri="Select * from tesoingresos_det where codigo='$_POST[dcoding][$x]' and vigencia='$vigusu'";
	 											$resi=mysql_query($sqlri,$linkbd);
												while($rowi=mysql_fetch_row($resi))
												{
	 												//**** busqueda cuenta presupuestal*****
													//busqueda concepto contable
													$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
													$re=mysql_query($sq,$linkbd);
													while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
													$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
	 	 											$resc=mysql_query($sqlrc,$linkbd);	  
													while($rowc=mysql_fetch_row($resc))
		 											{
			  											$porce=$rowi[5];
														if($rowc[7]=='S')
			  											{				 
															$valorcred=$_POST[dvalores][$x]*($porce/100);
															$valordeb=0;
															if($rowc[3]=='N')
															{
			   													//*****inserta del concepto contable  
			   													//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 														$respto=mysql_query($sqlrpto,$linkbd);	  
																$rowpto=mysql_fetch_row($respto);
																$vi=$_POST[dvalores][$x]*($porce/100);
																$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
																mysql_query($sqlr,$linkbd);	
			  													//****creacion documento presupuesto ingresos
			  													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo) values('$rowi[6]',$concecc,$vi,'$vigusu','N')";
  			  													mysql_query($sqlr,$linkbd);	
																//************ FIN MODIFICACION PPTAL
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','$valordeb','$valorcred','1', '$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																//***cuenta caja o banco
																if($_POST[modorec]=='caja')
																{
																	$cuentacb=$_POST[cuentacaja];
																	$cajas=$_POST[cuentacaja];
																	$cbancos="";
																}
																if($_POST[modorec]=='banco')
																{
																	$cuentacb=$_POST[banco];
																	$cajas="";
																	$cbancos=$_POST[banco];
																}
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','$valorcred',0,'1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
															}
			  											}
													}
												}
	  										}
										}			 	 
	 									//*************** fin de cobro de recibo
										for($x=0;$x<count($_POST[dcoding]);$x++)
	 									{
											$_POST[descunidos]="$row[1]$row[2]$row[3]";
											//***** BUSQUEDA INGRESO ********
											$sqlr="Select * from tesoindustria_det where id_industria='$_POST[idrecaudo]'";
											$res=mysql_query($sqlr,$linkbd);
											$row=mysql_fetch_row($res);
											$industria=$row[1];
											$avisos=$row[2];
											$bomberil=$row[3];
											$retenciones=$row[4]+$row[18];
											$sanciones=$row[5];	
											$saldoafavor=$row[20];
											$intereses=$row[25];
											$interesesind=$row[26];
											$interesesavi=$row[27];
											$interesesbom=$row[28];	
											$antivigact=$row[11];		
											$antivigant=$row[10];
											$saldopagar=$row[8];
											if((float)$intereses>0)
											{
												$intetodos=(float)$interesesind+(float)$interesesavi+(float)$interesesbom;
												if($intetodos>0)
												{
													$indinteres=(float)$interesesind;
													$aviinteres=(float)$interesesavi;
													$bominteres=(float)$interesesbom;
												}
												else
												{
													$indinteres=(float)$intereses;
													$aviinteres=0;
													$bominteres=0;
												}
											}
											if(((float)$row[21]+(float)$row[22]+(float)$row[23])>0)
											{
												$descuenindus=$row[21];//descuento industria
												$descuenaviso=$row[22];//descuento avisos
												$descuenbombe=$row[23];//descuento bomberil
											}
											elseif($row[13]>0)
											{
												if(substr($_POST[descunidos], -3, 1)=='S')//descuento industria
												{$descuenindus=$row[1]*($row[13]/100);}
												else{$descuenindus=0;}
												if(substr($_POST[descunidos], -2, 1)=='S')//descuento avisos
												{$descuenaviso=$row[2]*($row[13]/100);}
												else {$descuenaviso=0;}
												if(substr($_POST[descunidos], -1, 1)=='S')//descuento bomberil
												{$descuenbombe=$row[3]*($row[13]/100);}
												else{$descuenbombe=0;}
											}
											$totalica01=$industria+$indinteres+$sanciones-$descuenindus;
											$totalica=$industria+$interesesind+$sanciones-$descuenindus-$retenciones-$antivigant;
											$totalbombe=$bomberil-$descuenbombe+$interesesbom;
											$totalavisos=$avisos-$descuenaviso+$interesesavi;
											$sqlri="SELECT * FROM tesoingresos_det WHERE codigo='".$_POST[dcoding][$x]."' AND vigencia='$vigusu' ORDER BY concepto ASC";
	 										$res=mysql_query($sqlri,$linkbd);
											while($row=mysql_fetch_row($res))
											{
												switch($row[2])
												{
													case '04': //*****industria
													{
														$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='04' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='04' AND tipo='C' AND fechainicial<='$fechaf')";
														$res2=mysql_query($sqlr2,$linkbd);
														while($row2=mysql_fetch_row($res2))
														{
															if($row2[3]=='N')
															{				 					  		
																if($row2[6]=='S')
																{				 
																	$valorcred=$totalica01;$cuentaica=$row2[4];
																	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','Industria y Comercio $_POST[ageliquida]','',0, '$valorcred','1', '$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);	
																	$auxica=$totalica01;
																	if($retenciones>0)//si hay retencion 
																	{
																		$cuentacbr=buscanumcuenta('P11',$fechaf);
																		$auxica=$auxica-$retenciones;
																		if($auxica>=0){$valordeb=$retenciones;$auxreten=0;}
																		else{$valordeb=$retenciones+$auxica;$auxreten=abs($auxica);}
																		$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Retenci�n Industria y Comercio $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																	}
																	if($saldoafavor>0 && $auxica>0)//si hay saldo a favor
																	{
																		$cuentacbr=buscanumcuenta('P13',$fechaf);
																		$auxica=$auxica-$saldoafavor;
																		if($auxica>=0){$valordeb=$saldoafavor;$auxsaldoafavor=0;}
																		else{$valordeb=$saldoafavor+$auxica;$auxsaldoafavor=abs($auxica);}
																		$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle ,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Industria y Comercio $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																	}
																	if($antivigant>0 && $auxica>0)//si hay saldo vigencia Anterior
																	{
																		$cuentacbr=buscanumcuenta('P13',$fechaf);
																		$auxica=$auxica-$antivigant;
																		if($auxica>=0){$valordeb=$antivigant;$auxantivigant=0;}
																		else{$valordeb=$antivigant+$auxica;$auxantivigant=abs($auxica);}
																		$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle ,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Industria y Comercio $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																	}
																	if($auxica>0)//si queda saldo ICA lo toma del banco
																	{
																		$valordeb=$auxica;
																		$cuentacbr=$cuentacb;
																		$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Industria y Comercio $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																	}
																	$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$industria WHERE cuenta='$row[6]' and vigencia='$vigusu'";
																	mysql_query($sqlr,$linkbd);
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo, ingreso) values('$row[6]','$concecc','$industria','$vigusu','N','04')";
																	mysql_query($sqlr,$linkbd);
																}
															}
														}
													}break;
													case '05'://************avisos
													{
														if($avisos>0)
														{
															$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='05' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='05' AND tipo='C' AND fechainicial<='$fechaf')";
															$res2=mysql_query($sqlr2,$linkbd);
															while($row2=mysql_fetch_row($res2))
															{
																if($row2[3]=='N')
																{
																	if($row2[6]=='S')
																	{
																		$valordeb=0;
																		$valorcred=$totalavisos;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','Avisos y Tableros $_POST[ageliquida]','','0', '$valorcred','1', '$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$auxavisos=$totalavisos;
																		if($retenciones>0 && $auxreten>0)//si hay retencion 
																		{
																			$reteavi=$auxreten;
																			$cuentacbr=buscanumcuenta('P11',$fechaf);
																			$auxavisos=$auxavisos-$reteavi;
																			if($auxavisos>=0){$valordeb=$reteavi;$auxreten=0;}
																			else{$valordeb=$reteavi+$auxavisos;$auxreten=abs($auxavisos);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Retenci�n Avisos y Tableros $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																		}
																		if($saldoafavor>0 && $auxavisos>0 && $auxsaldoafavor>0)//si hay saldo a favor
																		{
																			$salfaavi=$auxsaldoafavor;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxavisos=$auxavisos-$salfaavi;
																			if($auxavisos>=0){$valordeb=$salfaavi;$auxsaldoafavor=0;}
																			else{$valordeb=$salfaavi+$auxavisos;$auxsaldoafavor=abs($auxavisos);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Avisos y Tableros $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																		}
																		if($antivigant>0 && $auxavisos>0 && $auxantivigant>0)//saldo vigencia Anterio
																		{
																			$svantavi=$auxantivigant;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxavisos=$auxavisos-$svantavi;
																			if($auxavisos>=0){$valordeb=$svantavi;$auxantivigant=0;}
																			else{$valordeb=$svantavi+$auxavisos;$auxantivigant=abs($auxavisos);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a vigencia Anterior Avisos y tableros $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																		}
																		if($auxavisos>0)//si queda saldo avisos lo toma del banco
																		{
																			$valordeb=$auxavisos;
																			$cuentacbr=$cuentacb;
																			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','Avisos y Tableros $_POST[modorec]','', '$valordeb','0','1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																		}
																		
																		$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$avisos WHERE cuenta='$row[6]' and vigencia='$vigusu'";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia, tipo,ingreso) values('$row[6]',$concecc,$avisos, '$vigusu','N','05')";
																		mysql_query($sqlr,$linkbd);
																	}
																}
															}
														}
													}break;
						 							case '06': //*********bomberil ********
													{
														if($bomberil>0)
														{
															$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='06' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='06' AND tipo='C' AND fechainicial<='$fechaf')";
															$res2=mysql_query($sqlr2,$linkbd);
															while($row2=mysql_fetch_row($res2))
															{
																if($row2[3]=='N')
																{				 					  		
																	if($row2[6]=='S')
																	{				 
																		$valordeb=0;
																		$valorcred=$totalbombe;					
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','Bomberil $_POST[ageliquida]', '','$valordeb', '$valorcred','1', '$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);	 
																		//********** CAJA O BANCO
																		$auxbombe=$totalbombe;
																		if($retenciones>0 && $auxreten>0)//si hay retencion 
																		{
																			$retebombe=$auxreten;
																			$cuentacbr=buscanumcuenta('P11',$fechaf);
																			$auxbombe=$auxbombe-$retebombe;
																			if($auxbombe>=0){$valordeb=$retebombe;$auxreten=0;}
																			else{$valordeb=$retebombe+$auxbombe;$auxreten=abs($auxbombe);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Retenci�n Bomberil $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																		}
																		if($saldoafavor>0 && $auxbombe>0 && $auxsaldoafavor>0)//si hay saldo a favor
																		{
																			$salfabombe=$auxsaldoafavor;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxbombe=$auxbombe-$salfabombe;
																			if($auxbombe>=0){$valordeb=$salfabombe;$auxsaldoafavor=0;}
																			else{$valordeb=$salfabombe+$auxbombe;$auxsaldoafavor=abs($auxbombe);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Bomberil $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																		}
																		if($antivigant>0 && $auxbombe>0 && $auxantivigant>0)//saldo vigencia Anterio
																		{
																			$svantbombe=$auxantivigant;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxbombe=$auxbombe-$svantbombe;
																			if($auxbombe>=0){$valordeb=$svantbombe;$auxantivigant=0;}
																			else{$valordeb=$svantbombe+$auxbombe;$auxantivigant=abs($auxbombe);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a vigencia Anterior Avisos y tableros $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																		}
																		if($auxbombe>0)//si queda saldo bomberil lo toma del banco
																		{
																			$valordeb=$auxbombe;
																			$cuentacbr=$cuentacb;
																			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito, estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','Bomberil $_POST[modorec]', '','$valordeb','0', '1','$_POST[vigencia]' )";
																			mysql_query($sqlr,$linkbd);
																		}
																		//***MODIFICAR PRESUPUESTO
																		$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$bomberil WHERE cuenta=$row[6] and vigencia='$vigusu'";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia, tipo,ingreso) values('$row[6]','$concecc','$bomberil','$vigusu','N','06')";
																		mysql_query($sqlr,$linkbd);
																	}
																}
															}
														}
													}break;
													case 'P12'://Anticipo vigencia Actual
													{
														if($antivigact>0)
														{
															$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P12' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P12' AND tipo='C' AND fechainicial<='$fechaf')";
															$res2=mysql_query($sqlr2,$linkbd);
															while($row2=mysql_fetch_row($res2))
															{
																if($row2[3]=='N')
																{				 					  		
																	if($row2[6]=='N')
																	{
																		$valorcred=$antivigact;
																		$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentaica','$_POST[tercero]','$row2[5]','Anticipo vigencia Actual $_POST[ageliquida]','',0, '$valorcred','1', '$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//********** CAJA O BANCO
																		$auxantivigact=$antivigact;
																		if($retenciones>0 && $auxreten>0)//si hay retencion 
																		{
																			$retevigact=$auxreten;
																			$cuentacbr=buscanumcuenta('P11',$fechaf);
																			$auxantivigact=$auxantivigact-$retevigact;
																			if($auxantivigact>=0){$valordeb=$retevigact;$auxreten=0;}
																			else{$valordeb=$retevigact+$auxantivigact;$auxreten=abs($auxantivigact);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Retenci�n Anticipo vigencia Actual $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																		}
																		if($saldoafavor>0 && $auxantivigact>0 && $auxsaldoafavor>0)//hay saldo a favor
																		{
																			$salfavigact=$auxsaldoafavor;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxantivigact=$auxantivigact-$salfavigact;
																			if($auxantivigact>=0){$valordeb=$salfavigact;$auxsaldoafavor=0;}
																			else{$valordeb=$salfavigact+$auxantivigact;$auxsaldoafavor=abs($auxantivigact);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Anticipo vigencia Actual $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																		}
																		if($antivigant>0 && $auxantivigact>0 && $auxantivigant>0)//saldo vigencia Anter
																		{
																			$svantvigact=$auxantivigant;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxantivigact=$auxantivigact-$svantvigact;
																			if($auxantivigact>=0){$valordeb=$svantvigact;$auxantivigant=0;}
																			else{$valordeb=$svantvigact+$auxavisos;$auxantivigant=abs($auxantivigact);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a vigencia Anterior Anticipo vigencia Actual $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																		}
																		if($auxantivigact>0)//si queda saldo avisos lo toma del banco
																		{
																			$valordeb=$auxantivigact;
																			$cuentacbr=$cuentacb;
																			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','Anticipo vigencia Actual $_POST[modorec]','', '$valordeb','0','1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																		}
																	}
																}
															}
														}
													}break;
												}
											}
											echo"<script>despliegamodalm('visible','1','Se ha almacenado el Recibo de Caja con Exito');</script>";
										}
									}
								}
								else
								{
									echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion <img src='imagenes/alert.png'></center></td></tr></table>";
								}
							}break;
							case 3: //**************OTROS RECAUDOS
							{
								$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='3' AND ESTADO='S'";
								$res=mysql_query($sqlr,$linkbd);
								while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}		
								if($numerorecaudos==0)
 								{ 
									//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
									//***busca el consecutivo del comprobante contable
									$concecc=0;
									$sqlr="select max(id_recibos ) from tesoreciboscaja  ";
									$res=mysql_query($sqlr,$linkbd);
									while($r=mysql_fetch_row($res)){$concecc=$r[0];}
									$concecc+=1;
									// $consec=$concecc;
									//***cabecera comprobante
									$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
									mysql_query($sqlr,$linkbd);
									$idcomp=mysql_insert_id();
									echo "<input type='hidden' name='ncomp' value='$idcomp'>";
									$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia, estado) values($concecc,16,'$fechaf	','RECIBO DE CAJA',$_POST[vigencia],0,0,0,1)";
									mysql_query($sqlr,$linkbd);	
									//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
									for($x=0;$x<count($_POST[dcoding]);$x++)
	 								{
										//***** BUSQUEDA INGRESO ********
										$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
										$resi=mysql_query($sqlri,$linkbd);
										while($rowi=mysql_fetch_row($resi))
										{
											$porce=$rowi[5];
											if($rowi[6]!="")
											{
												$vi=$_POST[dvalores][$x]*($porce/100);
												//****creacion documento presupuesto ingresos
												$sql="SELECT terceros FROM tesoingresos WHERE codigo=".$_POST[dcoding][$x] ;
												$res=mysql_query($sql,$linkbd);
												$row= mysql_fetch_row($res);
												if($row[0]!="R"){
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'".$vigusu."','N','".$_POST[dcoding][$x]."')";
													mysql_query($sqlr,$linkbd);	
												}else{
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'".$vigusu."','R','".$_POST[dcoding][$x]."')";
													mysql_query($sqlr,$linkbd);	
												}
											}
											//**** busqueda cuenta presupuestal*****
											//busqueda concepto contable
											$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
											$re=mysql_query($sq,$linkbd);
											while($ro=mysql_fetch_assoc($re))
											{
												$_POST[fechacausa]=$ro["fechainicial"];
											}
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												
												if($_POST[dcoding][$x]==$_POST[cobrorecibo])
												{
													if($rowc[7]=='S'){$columna= $rowc[7];}
													else{$columna= 'N';}
													$cuentacont=$rowc[4];
												}
												else
												{
													$columna= $rowc[6];
													$cuentacont=$rowc[4];
												}
												if($columna=='S')
												{
													$valorcred=$_POST[dvalores][$x]*($porce/100);
													$valordeb=0;
													if($rowc[3]=='N')
													{
														//*****inserta del concepto contable
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
														$respto=mysql_query($sqlrpto,$linkbd);
														$rowpto=mysql_fetch_row($respto);
														
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia='$vigusu'";
														mysql_query($sqlr,$linkbd);	
														
														//************ FIN MODIFICACION PPTAL
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito, estado,vigencia) values ('5 $concecc','".$cuentacont."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
														mysql_query($sqlr,$linkbd);
														//***cuenta caja o banco
														if($_POST[modorec]=='caja')
														{
															$cuentacb=$_POST[cuentacaja];
															$cajas=$_POST[cuentacaja];
															$cbancos="";
														}
														if($_POST[modorec]=='banco')
														{
															$cuentacb=$_POST[banco];
															$cajas="";
															$cbancos=$_POST[banco];
														}
														//$valordeb=$_POST[dvalores][$x]*($porce/100);
														//$valorcred=0;
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
														mysql_query($sqlr,$linkbd);
													}
												}
											}
										}
									}
									$user=$_SESSION['nickusu'];
									//************ insercion de cabecera recaudos ************
									$sqlr="insert into tesoreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor, estado,tipo, descripcion,usuario) values($idcomp,'$fechaf','$vigusu',$_POST[idrecaudo],'$_POST[modorec]','$cajas','$cbancos', '$_POST[totalc]', 'S','$_POST[tiporec]', '$_POST[concepto]','$user')";	  
									if (!mysql_query($sqlr,$linkbd))
									{
										$e =mysql_error(mysql_query($sqlr,$linkbd));
										echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n: $e');</script>";
									}
									else
									{
										$sqlr="update tesorecaudos set estado='P' WHERE ID_RECAUDO=$_POST[idrecaudo]";
										mysql_query($sqlr,$linkbd);
										echo"<script>despliegamodalm('visible','1','Se ha almacenado el Recibo de Caja con Exito');</script>";
									}
								} //fin de la verificacion
								else { echo"<script>despliegamodalm('visible','2','Ya Existe un Recibo de Caja para esta Liquidaci�n');</script>";}
							}break;
							//********************* INDUSTRIA Y COMERCIO
						} //*****fin del switch
						$_POST[ncomp]=$concecc;
						//******* GUARDAR DETALLE DEL RECIBO DE CAJA ******	
						for($x=0;$x<count($_POST[dcoding]);$x++)
						{
							$sqlr="insert into tesoreciboscaja_det (id_recibos,ingreso,valor,estado) values($concecc,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	  
							mysql_query($sqlr,$linkbd);  
						}		
						//***** FIN DETALLE RECIBO DE CAJA ***************	
						if($_POST[notaf]!='')
						{
							$date=getdate();
							$h=$date["hours"];
							$min=$date["minutes"];
							$hora=$h.":".$min;
							$sqlr="insert into teso_notasrevelaciones (hora,fecha,usuario,modulo,tipo_documento,numero_documento,valor_total_transaccion,nota) values('$hora','$fechaf','".$_SESSION["usuario"]."','teso','5','$concecc','".$_POST[dvalores][$x]."','$_POST[notaf]')";
							mysql_query($sqlr,$linkbd);
						}
					}
					else {echo"<script>despliegamodalm('visible','2','No Tiene los Permisos para Modificar este Documento');</script>";}
					//****fin if bloqueo  
				}//**fin del oculto 
			?>
			<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
					</IFRAME>
				</div>
			</div>
		</form>
	</body>
</html>