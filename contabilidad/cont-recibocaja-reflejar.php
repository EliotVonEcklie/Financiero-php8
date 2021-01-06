<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota"); 
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				if (document.form2.fecha.value!='' && ((document.form2.modorec.value=='banco' && document.form2.banco.value!='') || (document.form2.modorec.value=='caja') || (document.form2.cuentaPuente.value!='')))
				{
					if (confirm("Esta Seguro de Guardar"))
					{
						document.form2.oculto.value=2;
						document.form2.ncomp.value=document.form2.idcomp.value;
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
			function verUltimaPos(idcta)
			{
				window.open("teso-editaingresos.php?idr="+idcta);
			}
			function pdf()
			{
				document.form2.action="teso-pdfrecaja.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target=""; 
			}
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
				{
					document.form2.oculto.value=1;
					if(document.getElementById('codrec').value!="")
					{document.getElementById('codrec').value=""}
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					document.form2.action="cont-recibocaja-reflejar.php";
					document.form2.submit();
				}
			}
			function atrasc()
			{
				if(document.form2.ncomp.value>1)
				{
					document.form2.oculto.value=1;
					if(document.getElementById('codrec').value!="")
					{document.getElementById('codrec').value=""}
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					document.form2.action="cont-recibocaja-reflejar.php";
					document.form2.submit();
				}
			}
			function validar2()
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.idcomp.value;
				document.form2.action="cont-recibocaja-reflejar.php";
				document.form2.submit();
			}
		</script>
		<?php 
			titlepag();
			function buscanumcuenta($ncod,$fechaf)
			{
				$linkbd=conectar_bd();
				$sqlr="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$ncod' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$ncod' AND tipo='C' AND fechainicial<='$fechaf')";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
				{
					if($row[3]=='N')
					{
						if($row[7]=='N'){$cuenta=$row[4];}
					}
				}
				return $cuenta;
			}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='cont-buscarecibocaja-reflejar.php'" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/reflejar1.png" title="Reflejar" style="width:24px;"  onClick="guardar();" class="mgbt"/><img src="imagenes/print.png"  title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/iratras.png" title="Retornar" onClick="location.href='cont-reflejardocs.php'" class="mgbt"/></td>
			</tr>
		</table>
		<form name="form2" method="post" action="">
			<input type="hidden" name="codrec" id="codrec" value="<?php echo $_POST[codrec];?>" />
			<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$vigencia=$vigusu;
				$sqlr="select cuentacaja from tesoparametros";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[0];}
				if(!$_POST[oculto])
				{
					$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and tipo='S'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res))
					{
						$_POST[cobrorecibo]=$row[0];
						$_POST[vcobrorecibo]=$row[1];
						$_POST[tcobrorecibo]=$row[2];
					}
				}
				//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
				if ($_GET[consecutivo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[consecutivo];</script>";}
				{$sqlr="select id_recibos,id_recaudo from tesoreciboscaja ORDER BY id_recibos DESC";}
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				$_POST[maximo]=$r[0];
				if(!$_POST[oculto])
				{
					$fec=date("d/m/Y");
					$_POST[vigencia]=$vigencia;
					if ($_POST[codrec]!="" || $_GET[consecutivo]!="")
						if($_POST[codrec]!="")
						{$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja where id_recibos='$_POST[codrec]'";}
						else 
						{$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja where id_recibos='$_GET[consecutivo]'";}
					else
					{$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja ORDER BY id_recibos DESC";}
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$_POST[ncomp]=$r[0];
					$_POST[idcomp]=$r[0];
					$_POST[idrecaudo]=$r[1];
				}
				if ($_POST[codrec]!="")
				{$sqlr="select * from tesoreciboscaja where id_recibos='$_POST[codrec]'";}
				else
				{$sqlr="select * from tesoreciboscaja where id_recibos='$_POST[idcomp]'";}
				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res))
				{
					$_POST[tiporec]=$r[10];
					$_POST[idrecaudo]=$r[4];
					$_POST[ncomp]=$r[0];
					$_POST[modorec]=$r[5];	
					$_POST[vigencia]=$r[3];
					$_POST['cuentabanco']=$r[7];
				}
			?>
			<input type="hidden" name="cobrorecibo" value="<?php echo $_POST[cobrorecibo]?>" >
			<input type="hidden" name="vcobrorecibo" value="<?php echo $_POST[vcobrorecibo]?>" >
			<input type="hidden" name="tcobrorecibo" value="<?php echo $_POST[tcobrorecibo]?>" > 
			<input type="hidden" name="encontro"  value="<?php echo $_POST[encontro]?>" >
			<input type="hidden" name="codcatastral"  value="<?php echo $_POST[codcatastral]?>" >
			 <?php 
				switch($_POST[tiporec])
				{
					case 1: //Predial
					{
						$sql="SELECT FIND_IN_SET($_POST[idcomp],recibo),idacuerdo FROM tesoacuerdopredial ";
						$result=mysql_query($sql,$linkbd);
						$val=0;
						$compro=0;
						while($fila = mysql_fetch_row($result))
						{
							if($fila[0]!=0)
							{
								$val=$fila[0];
								$compro=$fila[1];
								break;
							}
						}
						if($val>0)
						{
							$_POST[tipo]="1";
							$_POST[idrecaudo]=$compro;		
							$sqlr="select vigencia from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo]  ";
							$res=mysql_query($sqlr,$linkbd);
							$vigencias="";
							while($row = mysql_fetch_row($res)){$vigencias.=($row[0]."-");}
							$vigencias=utf8_decode("Aï¿½os liquidados: ".substr($vigencias,0,-1));
							$sql="select * from tesoacuerdopredial where tesoacuerdopredial.idacuerdo=$_POST[idrecaudo] and (estado='S' or estado='P') ";
							$result=mysql_query($sql,$linkbd);
							$_POST[encontro]="";
							while($row = mysql_fetch_row($result))
							{
									$_POST[cuotas]=$row[10]+1;
									$_POST[tcuotas]=$row[4];
									$_POST[codcatastral]=$row[1];	
									$_POST[concepto]=$vigencias.' Cod Catastral No '.$row[1];	
									$_POST[valorecaudo]=$row[7];
									$_POST[totalc]=$row[7];	
									$_POST[tercero]=$row[13];										
									$_POST[encontro]=1;
							}
							$sqlr1="select nombrepropietario from tesopredios where cedulacatastral='$_POST[codcatastral]' and estado='S'";
							$resul=mysql_query($sqlr1,$linkbd);
							$row1 =mysql_fetch_row($resul);
							$_POST[ntercero]=$row1[0];
							if ($_POST[ntercero]=='')
							{
								$sqlr2="select *from tesopredios where cedulacatastral='$row[1]' ";
								$resc=mysql_query($sqlr2,$linkbd);
								$rowc =mysql_fetch_row($resc);
								$_POST[ntercero]=$rowc[6];
							}	
						}
						else
						{
							$_POST[tipo]="2";
							$sqlr="select *from tesoliquidapredial, tesoreciboscaja where tesoliquidapredial.idpredial=tesoreciboscaja.id_recaudo and tesoreciboscaja.estado !=''  and tesoreciboscaja.id_recibos='$_POST[idcomp]'";
							$_POST[encontro]="";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",$row[23],$fecha);
								$_POST[fecha]="$fecha[3]/$fecha[2]/$fecha[1]";
								$_POST[codcatastral]=$row[1];
								$_POST[idrecaudo]=$row[25];	
								$_POST[vigencia]=$row[3];			
								$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1];	
								$_POST[valorecaudo]=$row[8];		
								$_POST[totalc]=$row[8];	
								$_POST[tercero]=$row[4];		
								$_POST[modorec]=$row[24];
								$_POST[banco]=$row[25];
								if($row[28]=='S') {$_POST[estadoc]='ACTIVO';} 	 				  
								if($row[28]=='N'){$_POST[estadoc]='ANULADO';} 	
								$sqlr1="select nombrepropietario from tesopredios where cedulacatastral='$_POST[codcatastral]' and estado='S'";
								$resul=mysql_query($sqlr1,$linkbd);
								$row1 =mysql_fetch_row($resul);
								$_POST[ntercero]=$row1[0];
								if ($_POST[ntercero]=='')
								{
									$sqlr2="select *from tesopredios where cedulacatastral='".$row[1]."' ";
									$resc=mysql_query($sqlr2,$linkbd);
									$rowc =mysql_fetch_row($resc);
									$_POST[ntercero]=$rowc[6];
								}			
								$_POST[encontro]=1;
							}
						}	  				
						$sqlr="select *from tesoreciboscaja where tipo='1' and id_recaudo=$_POST[idrecaudo] and id_recibos=$_POST[idcomp]";
						$res=mysql_query($sqlr,$linkbd);
						$row =mysql_fetch_row($res); 
						$_POST[estadoc]=$row[9];
						if ($_POST[estadoc]=='N') {$_POST[estado]="ANULADO";}
						else {$_POST[estado]="ACTIVO";}
						$_POST[modorec]=$row[5];
						$_POST[banco]=$row[7];
						preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",$row[2],$fecha);
						$_POST[fecha]="$fecha[3]/$fecha[2]/$fecha[1]";
						
					}break;
					case 2:	// Industria y Comercio
					{
						$sqlr="SELECT * FROM tesoindustria WHERE id_industria=$_POST[idrecaudo] AND 2=$_POST[tiporec]";
						$_POST[encontro]="";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - $row[3]";	
							$_POST[valorecaudo]=$row[6];
							$_POST[totalc]=$row[6];	
							$_POST[tercero]=$row[5];
							$_POST[ntercero]=buscatercero($row[5]);	
							$_POST[encontro]=1;
						}
						$sqlr="select *from tesoreciboscaja where  id_recibos='$_POST[idcomp]' ";
						$res=mysql_query($sqlr,$linkbd);
						$row =mysql_fetch_row($res); 
						//$_POST[fecha]=$row[2];
						$_POST[estadoc]=$row[9];
						if ($row[9]=='N')
						{
							$_POST[estado]="ANULADO";
							$_POST[estadoc]='0';
						}
						else
						{
							$_POST[estadoc]='1';
							$_POST[estado]="ACTIVO";
						}
						preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",$row[2],$fecha);
						$_POST[fecha]="$fecha[3]/$fecha[2]/$fecha[1]";
						$_POST[modorec]=$row[5];
						$_POST[banco]=$row[7];
					}break;
					case 3:	//Otros Recaudos
					{
						$sqlr="SELECT * FROM tesorecaudos where tesorecaudos.id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
						$_POST[encontro]="";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res))
						{
							$_POST[concepto]=$row[6];
							$_POST[valorecaudo]=$row[5];
							$_POST[totalc]=$row[5];
							$_POST[tercero]=$row[4];
							$_POST[ntercero]=buscatercero($row[4]);
							$_POST[encontro]=1;
						}
						$sqlr="select *from tesoreciboscaja where  id_recibos=$_POST[idcomp] ";
						$res=mysql_query($sqlr,$linkbd);
						$row =mysql_fetch_row($res); 
						preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/", $row[2],$fecha);
						$_POST[fecha]="$fecha[3]/$fecha[2]/$fecha[1]";
						$_POST[estadoc]=$row[9];
						if ($row[9]=='N')
						{
							$_POST[estado]="ANULADO";
							$_POST[estadoc]='0';
						}
						else
						{
							$_POST[estadoc]='1';
							$_POST[estado]="ACTIVO";
						}
						$_POST[modorec]=$row[5];
						$_POST[banco]=$row[7];
					}break;
				}
 			?>
			<table class="inicio" style="width:99.7%;">
				<tr>
					<td class="titulos" colspan="9">Reflejar Recibo de Caja</td>
					<td class="cerrar" style="width:7%" onClick="location.href='cont-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2cm;">No Recibo:</td>
					<td style="width:20%;" colspan="<?php if($_POST[tiporec]=='1'){echo '3'; }else{echo '1';}?>"> 
						<a href="#" onClick="atrasc()"><img src="imagenes/back.png" title="anterior" align="absmiddle"/></a> 
						<input type="hidden" name="cuentacaja" value="<?php echo $_POST[cuentacaja]?>" />
						<input type="text" name="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  style="width:50%;" />
						<input type="hidden" name="ncomp" id="ncomp" value="<?php echo $_POST[ncomp]?>"/>
						<a href="#" onClick="adelante()"><img src="imagenes/next.png" title="siguiente" align="absmiddle"/></a> 
						<input type="hidden" value="a" name="atras"/>
						<input type="hidden" value="s" name="siguiente"/>
						<input type="hidden" name="maximo" value="<?php echo $_POST[maximo]?>" />
					</td>
					<td class="saludo1" style="width:2.3cm;">Fecha:</td>
					<td style="width:18%;"><input type="text" name="fecha"  value="<?php echo $_POST[fecha]?>"  onKeyUp="return tabular(event,this)" style="width:45%;" readonly />
					<?php 
							if($_POST[estado]=='ACTIVO')
							{
								echo "<input name='estado' type='text' value='ACTIVO' size='5' style='width:52%; background-color:#0CD02A; color:white; text-align:center;' readonly >";
							}
							else
							{
								echo "<input name='estado' type='text' value='ANULADO' size='5' style='width:40%; background-color:#FF0000; color:white; text-align:center;' readonly >";
							}
						?>
					</td>
					<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
					<td style="width:12%;">
						<input type="text" id="vigencia" name="vigencia" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" readonly>
					</td>
					<td rowspan="6" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>     
				</tr>
				<tr>
					<td class="saludo1"> Recaudo:</td>
					<td> 
						<select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)"  style="width:100%;">
							<?php
								switch($_POST[tiporec])
								{
									case "1":	echo"<option value='1' SELECTED>Predial</option>";break;
									case "2":	echo"<option value='2' SELECTED>Industria y Comercio</option>";break;
									case "3":	echo"<option value='3' SELECTED>Otros Recaudos</option>";break;
								}
							?>
						</select>
					</td>
					<?php 
						if($_POST[tiporec]=='1')
						{
							echo"
							<td class='saludo1'> Tipo:</td>
							<td>
								<select name='tipo' id='tipo' style='width:100%;'>";
								if(@ $_POST['tipo']==''){echo"<option value='' 'SELECTED'> Sin Especificar</option>";}
								if(@ $_POST['tipo']=='1'){echo "<option value='1' 'SELECTED'>Por Acuerdo</option>";}
								if(@ $_POST['tipo']=='2'){echo "<option value='2' 'SELECTED'>Por Liquidacion</option>";}
								echo "</select>
							</td>";
						}
						if(@ $_POST['tipo']=='1'){echo"<td class='saludo1'>No. Acuerdo:</td>";}
						elseif(@ $_POST['tipo']=='2'){echo "<td class='saludo1'>No Liquidaci&oacute;n:</td>"; }
					?>
					<td><input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:100%;" readonly></td>
					<?php
						
						if($_POST[tipo]=='2')
						{
							$sqlrAbono = "SELECT * FROM tesoabono WHERE cierre='$_POST[idrecaudo]'";
							$rowAbono = view($sqlrAbono);
						}
						if($rowAbono==NULL)
						{
							$_POST[cuentaPuente]='';
							echo"
							<td class='saludo1'>Recaudado en:</td>
							<td> 
								<select name='modorec' id='modorec' style='width:100%;'>";
							if(@ $_POST['modorec']=='banco'){echo"<option value='banco' SELECTED>Banco</option>";}
							else{echo"<option value='caja' SELECTED>Caja</option>";}
							echo"
								</select>
							</td>";
						}
						else
						{
							if($_POST[idrecaudo]!='')
							{
								$_POST[modorec]=NULL;
								
								$sqCuentaPuente = "select cuentapuente from tesoparametros";
								$rowCuentaPuente = view($sqCuentaPuente);
								echo"
								<td class='saludo1'>Cuenta Puente:</td>
								<td> 
									<input type='text' name='cuentaPuente' id='cuentaPuente' value='".$rowCuentaPuente[0]['cuentapuente']."' readonly/>
									<input type='hidden' name='modorec' id='modorec' value='".$_POST['modorec']."'/>
								</td>";
							}
						}
						?>
				</tr>
				<?php 
					if ($_POST[modorec]=='banco' && $_POST[cuentaPuente]=='')
					{
						echo"
						<tr>
							<td class='saludo1'>Cuenta:</td>
							<td>
								<select id='banco' name='banco' onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%'>
									<option value=''>Seleccione....</option>";
						$sqlr="select TB1.estado,TB1.cuenta,TB1.ncuentaban,TB1.tipo,TB2.razonsocial,TB1.tercero from tesobancosctas TB1,terceros TB2 where TB1.tercero=TB2.cedulanit and TB1.estado='S' ";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							if("$row[1]"==$_POST[banco])
							{
								echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
								$_POST[nbanco]=$row[4];
								$_POST[ter]=$row[5];
								$_POST[cb]=$row[2];
							}
							else{echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";}
						}	 	
						echo"
								</select>
							</td>
							<input type='hidden' name='cb' value='$_POST[cb]'/>
							<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/></td>
							<td class='saludo1'>Banco:</td>
							<td colspan='3'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%;' readonly></td>
							<input type='hidden' id='cuentabanco' name='cuentabanco' value='".$_POST['cuentabanco']."'/>
						</tr>";
					}
					
					$sqlr="select nota from teso_notasrevelaciones where modulo='teso' and tipo_documento='5' and numero_documento='$_POST[idcomp]'";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[notaf]=$row[0];
				?> 
				<tr>
					<td class="saludo1">Concepto:</td>
					<td colspan="<?php if($_POST[tiporec]==2){echo '3';}else{echo'5';}?>">
						<input name="concepto" type="text" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)" style="width:95%;" readonly>
						<input type="hidden" name="notaf" id="notaf" value="<?php echo $_POST[notaf]?>" >
						<?php 
							if($_POST[notaf]=='')
							{echo"<img src='imagenes/notad.png' class='icobut' onClick=\"despliegamodal2('visible',2);\" title='Notas'>";}
							else {echo"<img src='imagenes/notaf.png' class='icobut' onClick=\"despliegamodal2('visible',2);\" title='Notas'>";}
						?>
					</td>
				</tr>
				<tr>
					<td  class="saludo1"  >Documento: </td>
					<td colspan="<?php if($_POST[tiporec]=='1'){echo '3'; }else{echo '1';}?>"><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
					<td class="saludo1">Contribuyente:</td>
					<td colspan="3">
						<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>"  onKeyUp="return tabular(event,this) " style="width:100%;" readonly>
						<input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
						<input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
					</td>
				</tr>
				<tr>
					<td class="saludo1" >Valor:</td>
					<td colspan="<?php if($_POST[tiporec]=='1'){echo '3'; }else{echo '1';}?>"><input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly /></td>

				</tr>
				<?php if ($_POST[modorec]!='banco'){echo"<tr style='height:20;'><tr>";}?>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
			<input type="hidden" value="0" name="agregadet">
			<div class="subpantalla" style="height:40.2%; width:99.6%; overflow-x:hidden;">
				<?php 
					function obtenerTipoPredio($catastral)
					{
						$tipo="";
						$linkbd=conectar_bd();
						$sqlr="SELECT tipopredio FROM tesopredios WHERE cedulacatastral='$catastral'";
						$res=mysql_query($sqlr,$linkbd);
						$r=mysql_fetch_row($res);
						$tipo=$r[0];
						/*$digitos=substr($catastral,5,2);echo $digitos;
						if($digitos=="00"){$tipo="rural";}
						else {$tipo="urbano";}*/
						return $tipo;
					}
					if($_POST[oculto] && $_POST[encontro]=='1')
					{
						switch($_POST[tiporec]) 
						{
							case 1: //********PREDIAL
							{
								unset($_POST[dcoding]);
								unset($_POST[dncoding]);
								unset($_POST[dvalores]);
								$_POST[dcoding]= array();
								$_POST[dncoding]= array();
								$_POST[dvalores]= array();
								if($_POST[tcobrorecibo]=='S')
								{	 
									$_POST[dcoding][]=$_POST[cobrorecibo];
									$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;
									$_POST[dvalores][]=$_POST[vcobrorecibo];
								}
		 						$_POST[trec]='PREDIAL';
 	 							if($_POST[tipo]=='1')
								{
									$sqlr="select * from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo] ";
									$res=mysql_query($sqlr,$linkbd);
									//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
									while ($row =mysql_fetch_row($res)) 
									{
										$vig=$row[13];
										if($vig==$vigusu)
										{
											$sqlr2="select * from tesoingresos where codigo='01'";
											$res2=mysql_query($sqlr2,$linkbd);
											$row2 =mysql_fetch_row($res2); 
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;
											$_POST[dvalores][]=($row[10]/$_POST[tcuotas]);
										}
										else
										{
											$sqlr2="select * from tesoingresos where codigo='03'";
											$res2=mysql_query($sqlr2,$linkbd);
											$row2 =mysql_fetch_row($res2); 
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;
											$_POST[dvalores][]=($row[10]/$_POST[tcuotas]);
										}
									}
								}
								else
								{
									$sqlr="select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
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
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;
											$_POST[dvalores][]=$row[11];
										}
										else
										{	
											$sqlr2="select * from tesoingresos where codigo='03'";
											$res2=mysql_query($sqlr2,$linkbd);
											$row2 =mysql_fetch_row($res2); 
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;
											$_POST[dvalores][]=$row[11];
										}
									}
							
								}
							}break;
							case 2:	//***********INDUSTRIA Y COMERCIO
							{
								$_POST[dcoding]= array();
								$_POST[dncoding]= array();
								$_POST[dvalores]= array();
								$_POST[trec]='INDUSTRIA Y COMERCIO';
								if($_POST[tcobrorecibo]=='S')
								{	 
									$_POST[dcoding][]=$_POST[cobrorecibo];
									$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;
									$_POST[dvalores][]=$_POST[vcobrorecibo];
								}
								$sqlr="SELECT * FROM tesoindustria WHERE id_industria='$_POST[idrecaudo]' AND  2='$_POST[tiporec]'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res))
								{
									$sqlr2="SELECT * FROM tesoingresos WHERE codigo='02'";
									$res2=mysql_query($sqlr2,$linkbd);
									$row2 =mysql_fetch_row($res2);
									$_POST[dcoding][]=$row2[0];
									$_POST[dncoding][]=$row2[1];
									if($row[8]>1){$_POST[dvalores][]=$row[6]/$row[8];}
									else{$_POST[dvalores][]=$row[6];}
								}
							}break;
							case 3:	//*****************otros recaudos *******************
							{
								$_POST[trec]='OTROS RECAUDOS';
								$sqlr="select *from tesorecaudos_det where id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
								$_POST[dcoding]= array();
								$_POST[dncoding]= array();
								$_POST[dvalores]= array();
								if($_POST[tcobrorecibo]=='S')
								{
									$_POST[dcoding][]=$_POST[cobrorecibo];
									$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;
									$_POST[dvalores][]=$_POST[vcobrorecibo];
								}
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res))
								{
									$_POST[dcoding][]=$row[2];
									$sqlr2="select nombre from tesoingresos where codigo='".$row[2]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									$row2 =mysql_fetch_row($res2); 
									$_POST[dncoding][]=$row2[0];
									$_POST[dvalores][]=$row[3];
								}
							}break;
						}
					}
				?>
				<table class="inicio">
					<tr><td colspan="4" class="titulos">Detalle Recibo de Caja</td></tr>
					<tr>
						<td class="titulos2">Codigo</td>
						<td class="titulos2">Ingreso</td>
						<td class="titulos2">Valor</td>
					</tr>
					<?php
						$_POST[totalc]=0;
						$iter='saludo1a';
						$iter2='saludo2';
						for ($x=0;$x<count($_POST[dcoding]);$x++)
						{
							$idcta=$_POST[dcoding][$x];
							echo "
							<tr class='$iter' onDblClick=\"verUltimaPos($idcta)\">
								<td style='width:10%;'><input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."'>".$_POST[dcoding][$x]."</td>
								<td><input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."'>".$_POST[dncoding][$x]."</td>
								<td style='width:20%;text-align:right;'><input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."' style='width:100%;'>$ ".number_format($_POST[dvalores][$x],2,',','.')."</td>
							</tr>";
							$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
							$_POST[totalcf]=number_format($_POST[totalc],2);
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
						$resultado = convertir($_POST[totalc]);
						$_POST[letras]="$resultado PESOS M/CTE";
						echo "
						<tr class='$iter' >
							<td style='text-align:right;' colspan='2'>Total:</td>
							<td style='text-align:right;'>
								<input type='hidden' name='totalcf' value='$_POST[totalcf]'>
								<input name='totalc' type='hidden' value='$_POST[totalc]'>$ ".number_format($_POST[totalc],2,',','.')."
							</td>
						</tr>
						<tr class='titulos2'>
							<td>Son:</td>
							<td colspan='5'><input type='hidden' name='letras' value='$_POST[letras]'>$_POST[letras]</td>
						</tr>";
					?>
				</table>
			</div>
		<?php
		if($_POST[oculto]=='2')
		{
			if(strpos($_POST[fecha],"-")===false)
			{
				preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
				$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
			}
			else{$fechaf=$_POST[fecha];}
			
			$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
			if($bloq>=1)
			{
				//************VALIDAR SI YA FUE GUARDADO ************************
				switch($_POST[tiporec]) 
				{
					case 1://***** PREDIAL *****************************************
					{
						$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='1' ";
						$res=mysql_query($sqlr,$linkbd);
						while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
						if($numerorecaudos>=0)
						{
							$sql="DELETE FROM comprobante_cab WHERE numerotipo='$_POST[idcomp]' AND  tipo_comp='5' ";
							mysql_query($sql,$linkbd);
							$sql="DELETE FROM comprobante_det WHERE numerotipo='$_POST[idcomp]' AND  tipo_comp='5' ";
							mysql_query($sql,$linkbd);
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
							if($_POST[cuentaPuente]!='')
							{
								$cuentacb=$_POST[cuentaPuente];
								$cajas="";
								$cbancos=buscabanco($_POST[cuentaPuente]);
							}
							$concecc=$_POST[idcomp];
							if(strpos($_POST[fecha],"-")===false)
							{
								preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
								$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
							}
							else{$fechaf=$_POST[fecha];}
							//************ insercion de cabecera recaudos ************
							echo "
							<input type='hidden' name='concec' value='$concecc'>
							<script>
								despliegamodalm('visible','1','>Se ha almacenado el Recibo de Caja con Exito');
								document.form2.vguardar.value='1';
								document.form2.numero.value='';
								document.form2.valor.value=0;
							</script>";
							//**********************CREANDO COMPROBANTE CONTABLE ********************************	 
							if($_POST[estado]=='ACTIVO')
							{
								$estado=1;
							}
							else
							{
								$estado=0;
							}
							$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'$estado')";
							mysql_query($sqlr,$linkbd);
							//******parte para el recaudo del cobro por recibo de caja
							for($x=0;$x<count($_POST[dcoding]);$x++)
							{
								if($_POST[dcoding][$x]==$_POST[cobrorecibo])
								{
									//***** BUSQUEDA INGRESO ********
									$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
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
													//****creacion documento presupuesto ingresos
													//$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]', $concecc,$vi, '$vigusu')";
													//mysql_query($sqlr,$linkbd);	
													//************ FIN MODIFICACION PPTAL
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]', '$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
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
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
												}
											}
										}
									}
								}
							}
							//*************** fin de cobro de recibo
							$sql="select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]";
							$resul=mysql_query($sql,$linkbd);
							$rowcod=mysql_fetch_row($resul);
							$tipopre=obtenerTipoPredio($rowcod[0]);
							if($_POST[tipo]=='1')
							{
								$sqlrs="select * from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo] ";
								$res=mysql_query($sqlrs,$linkbd);
								$rowd==mysql_fetch_row($res);
								$tasadesc=(($rowd[5]/$_POST[tcuotas])/100);
								$sqlr="select *from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo]";
							}
							else
							{
								$sqlrs="select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
								$res=mysql_query($sqlrs,$linkbd);
								$rowd==mysql_fetch_row($res);
								$tasadesc=($rowd[6]/100);
								$sqlr="select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo] and estado ='S' and 1=$_POST[tiporec]";
							}
							$res=mysql_query($sqlr,$linkbd);
							//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
							while ($row =mysql_fetch_row($res)) 
							{
								if($_POST[tipo]=='1')
								{
									$vig=$row[13];
									$vlrdesc=($row[9]/$_POST[tcuotas]);
								}
								else
								{
									$vig=$row[1];
									$vlrdesc=$row[10];	
								}
								if($vig==$vigusu) //*************VIGENCIA ACTUAL *****************
								{
									$idcomp=$_POST[idcomp];
									$sqlr2="select * from tesoingresos_det where codigo='01' AND modulo='4' and vigencia=$vigusu group by concepto";
									$res2=mysql_query($sqlr2,$linkbd);
									//****** $cuentacb   ES LA CUENTA CAJA O BANCO
									while($rowi =mysql_fetch_row($res2))
									{
										switch($rowi[2])
										{
											case '01': //Impuesto Predial Vigente
											{
												$sqlrds="select * from tesoingresos_det where codigo='01' and concepto='P01' AND modulo='4' and vigencia=$vigusu";
												$resds=mysql_query($sqlrds,$linkbd);
												while($rowds =mysql_fetch_row($resds)){$descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);}
												$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
												$re=mysql_query($sq,$linkbd);
												while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
												$resc=mysql_query($sqlrc,$linkbd);
												while($rowc=mysql_fetch_row($resc))
												{
													$porce=$rowi[5];
													if($rowc[6]=='S')
													{	
														if($_POST[tipo]=='1'){$valorcred=($row[2]/$_POST[tcuotas]);}
														else{$valorcred=$row[4];}
														$valordeb=0;
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
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL		
															}
														}
													}
												}
											}break;
											case '02': //Ingreso Sobretasa Ambiental echo 
											{
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
														if($_POST[tipo]=='1'){$valorcred=($row[7]/$_POST[tcuotas]);}
														else{$valorcred=$row[8];}
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
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL			
															}
														}
													}
												}
											}break;  
											case '03': //Ingreso Sobretasa Bomberil
											{
												$sqlrds="select * from tesoingresos_det where codigo='01' and concepto='P10' AND modulo='4' and vigencia='$vigusu'";
												$resds=mysql_query($sqlrds,$linkbd);
												while($rowds =mysql_fetch_row($resds)){$descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);}
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
														if($_POST[tipo]=='1'){$valorcred=($row[5]/$_POST[tcuotas]);}
														else{$valorcred=$row[6];}
														$valordeb=0;
														if($rowc[3]=='N')
														{
															if($valorcred>0)
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]', '$rowc[5]','Ingreso Sobretasa Bomberil $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$valordeb=round($valorcred-$descpredial,2);
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Bomberil $vig','', '".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																//*********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																$respto=mysql_query($sqlrpto,$linkbd);
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL
															}
														}
													}
												}
											}break;
											case 'P10': //Descuento Pronto Pago Bomberil
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
														if($_POST[tipo]=='1'){$valordeb=round(($row[9]/$_POST[tcuotas])*round(($porce/100),2),2);}
														else{$valordeb=round($row[10]*round(($porce/100),2),2);}
														$valorcred=0;
														if($rowc[3]=='N')
														{
															if($valordeb>0)
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Descuento Pronto Pago Bomberil $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																//********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
																$respto=mysql_query($sqlrpto,$linkbd);	  
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL	
															}
														}
													}
												}
											}break;
											case 'P01': //Descuento Pronto Pago Predial
											{
												$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
												$re=mysql_query($sq,$linkbd);
												while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
												$resc=mysql_query($sqlrc,$linkbd);
												while($rowc=mysql_fetch_row($resc))
												{
													$porce=$rowi[5];
													if($rowc[6]=='S')
													{
														if($_POST[tipo]=='1'){$valordeb=round(($row[9]/$_POST[tcuotas])*round(($porce/100),2),2);}
														else{$valordeb=round($row[10]*round($porce/100,2),2);}
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
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL	
															}
														}
													}
												}
											}break;
											case 'P02': //Intereses Predial
											{
												$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
												$re=mysql_query($sq,$linkbd);
												while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
												$resc=mysql_query($sqlrc,$linkbd);	  
												while($rowc=mysql_fetch_row($resc))
												{
													$porce=$rowi[5];
													if($rowc[6]=='S')
													{	
														if($_POST[tipo]=='1'){$valorcred=($row[3]/$_POST[tcuotas]);}
														else{$valorcred=$row[5];}
														$valordeb=0;
														if($rowc[3]=='N')
														{
															if($valorcred>0)
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','".round($valordeb,0)."', '".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$valordeb=$valorcred;
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','".round($valordeb,2)."', '0','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
																$respto=mysql_query($sqlrpto,$linkbd);	  
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL	
															}
														}
													}
													else
													{
														if($_POST[tipo]=='1'){$valorcred=($row[3]/$_POST[tcuotas]);}
														else{$valorcred=$row[5];}
														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);
													}
												}
											}break;
											case 'P04': //Intereses Sobretasa Bomberil
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
														if($_POST[tipo]=='1'){$valorcred=($row[6]/$_POST[tcuotas]);}
														else{$valorcred=$row[7];}
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
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																$respto=mysql_query($sqlrpto,$linkbd);
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL
															}
														}
													}
													else
													{
														if($_POST[tipo]=='1'){$valorcred=($row[6]/$_POST[tcuotas]);}
														else{$valorcred=$row[7];}
														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);
													}
												}
											}break;
											case 'P05': //Ingreso Sobtretasa Bomberil
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
														if($_POST[tipo]=='1'){$valorcred=($row[5]/$_POST[tcuotas]);}
														else{$valorcred=$row[6];}
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
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL	
															}
														}
													}
												}
											}break;
											case 'P07': //Intereses Sobtretasa Ambiental
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
														if($_POST[tipo]=='1'){$valorcred=($row[8]/$_POST[tcuotas]);}
														else{$valorcred=$row[9];}
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
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
																$respto=mysql_query($sqlrpto,$linkbd);	  
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL	
															}
														}
													}
												}
											}break;
											case 'P08': //Sobtretasa Ambiental
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
														if($_POST[tipo]=='1'){$valordeb=($row[7]/$_POST[tcuotas]);}
														else{$valordeb=$row[8];}			  
													}
													if($rowc[6]=='N')
													{				 
														$valordeb=0;
														if($_POST[tipo]=='1'){$valorcred=($row[7]/$_POST[tcuotas]);}
														else{$valorcred=$row[8];}					
													}
													if($rowc[3]=='N')
													{
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Sobtretasa Ambiental $vig','','".round($valordeb,0)."', '".round($valorcred,0)."', '1','$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);					
													}
												}
											}break;
											case 'P18': //***
											{
												$sqlca="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='COBRO_ALUMBRADO' AND tipo='S'";
												$resca=mysql_query($sqlca,$linkbd);
												while ($rowca =mysql_fetch_row($resca)) 
												{
													$cobroalumbrado=$rowca[0];
													$vcobroalumbrado=$rowca[1];
													$tcobroalumbrado=$rowca[2];
												}
												if($tcobroalumbrado=='S' && $tipopre=='rural')
												{
													$rowcAlumbrado = 0;
													//$valorAlumbrado=round($row[2]*($vcobroalumbrado/1000),0);
													$sqlrAlumbrado = "SELECT val_alumbrado FROM tesoliquidapredial_desc WHERE id_predial='".$_POST[idrecaudo]."'";
													$rescAlumbrado = mysql_query($sqlrAlumbrado,$linkbd);	  
													$rowcAlumbrado = mysql_fetch_row($rescAlumbrado);
													$valorAlumbrado = $rowcAlumbrado[0];

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
															$valorcred=$valorAlumbrado;
															$valordeb=0;
															if($rowc[3]=='N')
															{
																if($valorcred>0)
																{
																	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero, centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]', 'Ingreso Impuesto sobre el Servicio de Alumbrado Pï¿½blico $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	$valordeb=$valorcred;
																	$sqlr="insert into comprobante_det (id_comp, cuenta,tercero, centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]', 'Ingreso Impuesto sobre el Servicio de Alumbrado Pï¿½blico $vig','', '".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	//*******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *******
																	$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																	$respto=mysql_query($sqlrpto,$linkbd);	  
																	$rowpto=mysql_fetch_row($respto);
																	$vi=$valordeb;
																	//****creacion documento presupuesto ingresos
																	//************ FIN MODIFICACION PPTAL			
																}
															}
														}
													}
												}
											}break;  
										} 
		 							}
									$_POST[dcoding][]=$row2[0];
									$_POST[dncoding][]=$row2[1]." ".$vig;
									if($_POST[tipo]=='1'){$_POST[dvalores][]=($row[10]/$_POST[tcuotas]);}
									else{$_POST[dvalores][]=$row[11];}
	 							}
		 						else  ///***********OTRAS VIGENCIAS ***********
	   	 						{	
									$tasadesc=$row[10];
									$idcomp=$_POST[idcomp];	
		  							$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
		  							mysql_query($sqlr,$linkbd);
									$sqlr2="select * from tesoingresos_det where codigo='03' AND MODULO='4' and vigencia=$vigusu GROUP BY concepto";
									$res2=mysql_query($sqlr2,$linkbd);
				 					//****** $cuentacb   ES LA CUENTA CAJA O BANCO
									while($rowi =mysql_fetch_row($res2))
		 							{
		  								switch($rowi[2])
		   								{
											case 'P03': //Ingreso Impuesto Predial Otras Vigencias
											{
												$sq="select fechainicial from conceptoscontables_det where codigo='".$rowi[2]."' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
												$re=mysql_query($sq,$linkbd);
												while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
				 								$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
	 			 								$resc=mysql_query($sqlrc,$linkbd);	  
						 						while($rowc=mysql_fetch_row($resc))
				 								{
													if($rowc[6]=='S')
			 	  									{	
														if($_POST[tipo]=='1')
														{
															$valorcred=($row[2]/$_POST[tcuotas]);
															
														}
														else{$valorcred=$row[4];}
														$valordeb=0;					
														if($rowc[3]=='N')
				    									{
				 	 										if($valorcred>0)
					  										{						
				 												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Impuesto Predial Otras Vigencias $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$valordeb=$valorcred-$tasadesc;
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Impuesto Predial Otras Vigencias $vig','','".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$sq="select fechainicial from conceptoscontables_det where codigo='P01' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
																$re=mysql_query($sq,$linkbd);
																while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
																$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = 'P01' and tipo='C' and fechainicial='$_POST[fechacausa]'";
																$resc=mysql_query($sqlrc,$linkbd);	  
																while($rowc=mysql_fetch_row($resc))
																{
																	$sqlrdes="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Descuento Pago Predial $vig','', '".round($desc,0)."','0','1','$_POST[vigencia]')";
																	mysql_query($sqlrdes,$linkbd);
																}
						  										//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																$respto=mysql_query($sqlrpto,$linkbd);	  
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
			  													//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL		
					  										}
														}
				  									}
				 								}
											}break;  
											case 'P06': //Ingreso Sobretasa Ambiental
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
														if($_POST[tipo]=='1'){$valorcred=($row[7]/$_POST[tcuotas]);}
														else{$valorcred=$row[8];}
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
							  									//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 													$respto=mysql_query($sqlrpto,$linkbd);	  
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL	
					  										}
														}
				  									}
												}
											}break;  
											case '03': //Ingreso Sobretasa Bomberil
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
														if($_POST[tipo]=='1'){$valorcred=($row[5]/$_POST[tcuotas]);}
														else{$valorcred=$row[6];}
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
							 									//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 													$respto=mysql_query($sqlrpto,$linkbd);	  
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
			  													//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL	
					  										}
														}
				 									}
				 								}
											}break;  
											case 'P01': //Descuento Pronto Pago
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
														if($_POST[tipo]=='1'){$valordeb=($row[9]/$_POST[tcuotas]);}
														else{$valordeb=$row[10];}
														$valorcred=0;
														if($rowc[3]=='N')
														{
															if($valordeb>0)
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Descuento Pronto Pago $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
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
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='$_POST[fechacausa]'";
	 			 								
												$resc=mysql_query($sqlrc,$linkbd);	  
				 								while($rowc=mysql_fetch_row($resc))
				 								{
			  										$porce=$rowi[5];
													$valdescuento=0;
													
													if($rowc[6]=='S')
			 	  									{	
														if($_POST[tipo]=='1'){
															$valdescuento = ($row[4]/$_POST[tcuotas]);
															$valorcred=($row[3]/$_POST[tcuotas])-$valdescuento;;
														}
														else {$valorcred=$row[5];}
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
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL	
															}
				   										}
				  									}
													else
													{
														if($_POST[tipo]=='1'){
															$valdescuento = ($row[4]/$_POST[tcuotas]);
															$valorcred=($row[3]/$_POST[tcuotas])-$valdescuento;;
														}
														else {$valorcred=$row[5];}
														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
														//echo $sqlr."<br>";
														mysql_query($sqlr,$linkbd);
													}
				 								}
											}break;  
											case 'P04': //Intereses Sobretasa Bomberil
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
														if($_POST[tipo]=='1'){$valorcred=($row[6]/$_POST[tcuotas]);}
														else{$valorcred=$row[7];}
														$valordeb=0;					
														if($rowc[3]=='N')
				    									{
															if($valorcred>0)
															{						
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Sobretasa Bomberil $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$valordeb=$valorcred;
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Sobretasa Bomberil $vig','','".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																$respto=mysql_query($sqlrpto,$linkbd);	  
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
			  													//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL	
					  										}
														}
				  									}
													else
													{
														if($_POST[tipo]=='1'){$valorcred=($row[6]/$_POST[tcuotas]);}
														else{$valorcred=$row[7];}
														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);
													}
				 								}
											}break;  
											case 'P05': //Ingreso Sobtretasa Bomberil Otras Vigencias
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
														if($_POST[tipo]=='1'){$valorcred=($row[5]/$_POST[tcuotas]);}
														else{$valorcred=$row[6];}
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
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																$respto=mysql_query($sqlrpto,$linkbd);	  
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
													
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL	
					 										}
														}
				  									}
				 								}
											}break;  
											case 'P07': //Intereses Sobtretasa Ambiental
											{
												$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
												$re=mysql_query($sq,$linkbd);
												while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
												$resc=mysql_query($sqlrc,$linkbd);	  
												while($rowc=mysql_fetch_row($resc))
												{
													$porce=$rowi[5];
													if($rowc[6]=='S')
													{	
														if($_POST[tipo]=='1'){$valorcred=($row[8]/$_POST[tcuotas]);}
														else {$valorcred=$row[9];}
														$valordeb=0;					
														if($rowc[3]=='N')
														{
															if($valorcred>0)
															{						
				 												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Sobtretasa Ambiental $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$valordeb=$valorcred;
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Sobtretasa Ambiental $vig','','".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																$respto=mysql_query($sqlrpto,$linkbd);	  
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL	
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
													if($_POST[tipo]=='1'){$valnu=($row[7]/$_POST[tcuotas]);}
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
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Sobtretasa Ambiental $vig','','".round($valordeb,0)."', '$valorcred','1','$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);						
													}
				 								}
											}break;  
											case 'P18': //***
											{
												$sqlca="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='COBRO_ALUMBRADO' AND tipo='S'";
												$resca=mysql_query($sqlca,$linkbd);
												while ($rowca =mysql_fetch_row($resca)) 
												{
													$cobroalumbrado=$rowca[0];
													$vcobroalumbrado=$rowca[1];
													$tcobroalumbrado=$rowca[2];
												}
												if($tcobroalumbrado=='S' && $tipopre=='rural')
												{
													$rowcAlumbrado = 0;
													//$valorAlumbrado=round($row[2]*($vcobroalumbrado/1000),0);
													$sqlrAlumbrado = "SELECT val_alumbrado FROM tesoliquidapredial_desc WHERE id_predial='".$_POST[idrecaudo]."'";
													$rescAlumbrado = mysql_query($sqlrAlumbrado,$linkbd);	  
													$rowcAlumbrado = mysql_fetch_row($rescAlumbrado);
													$valorAlumbrado = $rowcAlumbrado[0];
													
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
															$valorcred=$valorAlumbrado;
															$valordeb=0;
															if($rowc[3]=='N')
															{
																if($valorcred>0)
																{
																	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Impuesto sobre el Servicio de Alumbrado Pï¿½blico $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	$valordeb=$valorcred;
																	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Impuesto sobre el Servicio de Alumbrado Pï¿½blico $vig','', '".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																	$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																	$respto=mysql_query($sqlrpto,$linkbd);	  
																	$rowpto=mysql_fetch_row($respto);
																	$vi=$valordeb;
																	//****creacion documento presupuesto ingresos
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
							//*******************  
							if($_POST[tipo]=='1')
							{
								$sqlr="Select *from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo]";
		  						$resp=mysql_query($sqlr,$linkbd);
		 						while($row=mysql_fetch_row($resp,$linkbd))
								{
									$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[13]";
									mysql_query($sqlr2,$linkbd);
								}
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
	 						echo "<table class='inicio'><tr><td class='saludo1'><center>Se Reflejo de Manera Correcta el Recibo de Caja <img src='imagenes/confirm.png'></center></td></tr></table>"; 	 	  
   	 					} //fin de la verificacion
	 					else
	 					{echo"<script>despliegamodalm('visible','2','Ya Existe un Recibo de Caja para esta Liquidacion Predial');</script>";}
			 			//***FIN DE LA VERIFICACION
					}break;
					case 2:  //********** INDUSTRIA Y COMERCIO
					{
						$valorcuentabanco=0;
						$sqlr="SELECT tmindustria,desindustria,desavisos,desbomberil,intindustria,intavisos,intbomberil FROM tesoparametros";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res))
						{
							$descunidos="$row[1]$row[2]$row[3]";
							$intecunidos="$row[4]$row[5]$row[6]";
						}
						if(strpos($_POST[fecha],"-")===false)
						{
							preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
							$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
						}
						else{$fechaf=$_POST[fecha];}
						$sqlr="SELECT count(*) FROM tesoreciboscaja WHERE id_recaudo='$_POST[idrecaudo]' and tipo='2'";
						$res=mysql_query($sqlr,$linkbd);
						while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0]; }
						if($numerorecaudos>=0)
						{
							$sqlr="delete from comprobante_cab where numerotipo='$_POST[idcomp]' and tipo_comp='5'";
							mysql_query($sqlr,$linkbd);
							$sqlr="delete from comprobante_det where id_comp='5 $_POST[idcomp]'";
							mysql_query($sqlr,$linkbd);
							if (!mysql_query($sqlr,$linkbd))
							{
								echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la peticiï¿½n: <br><font color=red><b>$sqlr</b></font></p>Ocurriï¿½ el siguiente problema:<br><pre></pre></center></td></tr></table>";
							}
							else
  						 	{
								echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>"; 
								$concecc=$_POST[idcomp]; 
								//*************COMPROBANTE CONTABLE INDUSTRIA
								$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito, diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,'$_POST[totalc]','$_POST[totalc]',0,'$_POST[estadoc]')";
								mysql_query($sqlr,$linkbd);
								$idcomp=$_POST[idcomp];
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
								//******parte para el recaudo del cobro por recibo de caja
								for($x=0;$x<count($_POST[dcoding]);$x++)
								{
									if($_POST[dcoding][$x]==$_POST[cobrorecibo])
									{
										//***** BUSQUEDA INGRESO ********
										$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
										$resi=mysql_query($sqlri,$linkbd);
										while($rowi=mysql_fetch_row($resi))
										{
											//**** busqueda cuenta presupuestal*****
											//busqueda concepto contable
											$sqlrc="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$rowi[2]' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$rowi[2]' AND tipo='C' AND fechainicial<='$fechaf')";
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
														$sqlrpto="SELECT * FROM pptocuentas WHERE estado='S' AND cuenta='$rowi[6]' AND vigencia = '$vigusu'";
														$respto=mysql_query($sqlrpto,$linkbd);	  
														$rowpto=mysql_fetch_row($respto);
														$vi=$_POST[dvalores][$x]*($porce/100);
														//****creacion documento presupuesto ingresos
														//************ FIN MODIFICACION PPTAL
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','$valordeb','$valorcred','1','$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);
														if($_POST['cuentabanco']==$rowc[4])
														{
															$valorcuentabanco=$valorcuentabanco+($valordeb-$valorcred);
														}
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
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','$valorcred',0,'1','$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);
														if($_POST['cuentabanco']==$cuentacb)
														{
															$valorcuentabanco=$valorcuentabanco+$valorcred;
														}
													}
			 									}
											}
		 								}
	  								}
								}
	 							//*************** fin de cobro de recibo
								for($x=0;$x<count($_POST[dcoding]);$x++)
	 							{
									//***** BUSQUEDA INGRESO ********
									$sqlr="SELECT ncuotas FROM tesoindustria WHERE id_industria='$_POST[idrecaudo]'";
									$res=mysql_query($sqlr,$linkbd);
									$row=mysql_fetch_row($res);
									$ncuotas=$row[0];
									$sqlr="SELECT * FROM tesoindustria_det WHERE id_industria='$_POST[idrecaudo]'";
									$res=mysql_query($sqlr,$linkbd);
									$row=mysql_fetch_row($res);
									$industria=$row[1];
									$avisos=$row[2];
									$bomberil=$row[3];
									$retenciones=$row[4];
									$saldoafavor=$row[20];
									$sanciones=$row[5];
									$intereses=$row[25];
									$interesesind=$row[26];
									$interesesavi=$row[27];
									$interesesbom=$row[28];
									$antivigact=$row[11];
									$antivigant=$row[10];
									$saldopagar=$row[8];
									$exoneracion=$row[18];
									if((float)$intereses>0)//intereses
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
									if(($row[21]>0)|| ($row[13]>0))//descuentos
									{
										if(($row[22]+$row[23]+$row[24])>0)
										{
											$descuenindus=$row[22];//descuento industria
											$descuenaviso=$row[23];//descuento avisos
											$descuenbombe=$row[24];//descuento bomberil
										}
										else
										{
											if(substr($descunidos, -3, 1)=='S')//descuento industria
											{$descuenindus=$row[1]*($row[13]/100);}
											else{$descuenindus=0;}
											if(substr($descunidos, -2, 1)=='S')//descuento avisos
											{$descuenaviso=$row[2]*($row[13]/100);}
											else {$descuenaviso=0;}
											if(substr($descunidos, -1, 1)=='S')//descuento bomberil
											{$descuenbombe=$row[3]*($row[13]/100);}
											else{$descuenbombe=0;}
										}
									}
									//$totalica01=$industria+$indinteres+$sanciones-$descuenindus;
									$totalica01=$industria+$indinteres+$sanciones;
									$totalica=$industria+$indinteres+$sanciones-$descuenindus-$retenciones-$antivigant-$saldoafavor-$exoneracion;
									$totalbombe=$bomberil+$interesesbom;
									$totalbombe01=$bomberil+$interesesbom-$descuenbombe;
									$totalavisos=$avisos+$interesesavi;
									$totalavisos01=$avisos+$interesesavi-$descuenaviso;
									if($ncuotas>1)
									{
										$totalica=$totalica/$ncuotas;
										$totalbombe=$totalbombe/$ncuotas;
										$totalavisos=$totalavisos/$ncuotas;
									}
									$valorcred=$valordeb=$saldo01=$auxreten=$auxsaldoafavor=$auxantivigant=0;
									$numcc='';
									$restem1=$restem2=$restem3=0;
									$sqlri="SELECT * FROM tesoingresos_det WHERE codigo='".$_POST[dcoding][$x]."' AND vigencia='$vigusu' ORDER BY concepto ASC";
									$res=mysql_query($sqlri,$linkbd);
									while($row=mysql_fetch_row($res))
									{
										switch($row[2])
										{
											case '04': //*****industria
											{
												$restem1=$totalica01-$retenciones;
												if($restem1>0)
												{
													$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='04' AND tipo='C' AND tipocuenta='N' AND debito='S' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='04' AND tipo='C' AND tipocuenta='N' AND debito='S' AND fechainicial<='$fechaf')";
													$res2=mysql_query($sqlr2,$linkbd);
													while($row2=mysql_fetch_row($res2))
													{
														if($numcc==''){$numcc=$row2[5];}
														//$valorcred=$totalica01;
														$valorcred=$restem1;
														$cuentaica=$row2[4];
														$cuentaindustria=$row2[4];
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','Industria y Comercio $_POST[ageliquida]','',0, '$valorcred','1', '$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);
														if($_POST['cuentabanco']==$row2[4])
														{
															$valorcuentabanco=$valorcuentabanco+(0-$valorcred);
														}
														//********** CAJA O BANCO
														//$auxica=$totalica01;
														$auxica=$totalica;
														if($saldoafavor>0 && $auxica>0)//si hay saldo a favor
														{
															$cuentacbr=buscanumcuenta('P13',$fechaf);
															//$auxica=$auxica-$saldoafavor;
															if($auxica>=0){$valordeb=$saldoafavor;$auxsaldoafavor=0;}
															else{$valordeb=$saldoafavor+$auxica;$auxsaldoafavor=abs($auxica);}
															$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle ,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Industria y Comercio $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
															if($_POST['cuentabanco']==$cuentacbr)
															{
																$valorcuentabanco=$valorcuentabanco+($valordeb-0);
															}
														}
														if($antivigant>0 && $auxica>0)//si hay saldo vigencia Anterior
														{
															$cuentacbr=buscanumcuenta('P13',$fechaf);
															//$auxica=$auxica-$antivigant;
															if($auxica>=0){$valordeb=$antivigant;$auxantivigant=0;}
															else{$valordeb=$antivigant+$auxica;$auxantivigant=abs($auxica);}
															$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle ,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Industria y Comercio $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
															if($_POST['cuentabanco']==$cuentacbr)
															{
																$valorcuentabanco=$valorcuentabanco+($valordeb-0);
															}
														}
														if($auxica>0)//si queda saldo ICA lo toma del banco
														{
															$valordeb=$auxica;
															$cuentacbr=$cuentacb;
															$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Industria y Comercio $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
															if($_POST['cuentabanco']==$cuentacbr)
															{
																$valorcuentabanco=$valorcuentabanco+($valordeb-0);
															}
														}
													}
												}
											}break;
											case '05'://************avisos
											{
												if($restem1<0)
												{
													$restem2=$totalavisos+$restem1;
													if($restem2>0){$avisosaux=$restem2;}
													else{$avisosaux=0;}
												}
												else{$avisosaux=$totalavisos;}
												if($avisosaux>0)
												{
													$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='05' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='05' AND tipo='C' AND fechainicial<='$fechaf')";
													$res2=mysql_query($sqlr2,$linkbd);
													while($row2=mysql_fetch_row($res2))
													{
														if($numcc==''){$numcc=$row2[5];}
														if($row2[3]=='N')
														{
															if($row2[6]=='S')
															{
																$valordeb=0;
																$valorcred=$avisosaux;
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','".$_POST['tercero']."','$row2[5]','Avisos y Tableros ".$_POST['ageliquida']."','','0', '$valorcred','1', '".$_POST['vigencia']."')";
																mysql_query($sqlr,$linkbd);
																if($_POST['cuentabanco']==$row2[4])
																{
																	$valorcuentabanco=$valorcuentabanco+(0-$valorcred);
																}
																//********** CAJA O BANCO
																//$auxavisos=$avisosaux;
																$auxavisos=$totalavisos01;
																if($saldoafavor>0 && $auxavisos>0 && $auxsaldoafavor>0)//si hay saldo a favor
																{
																	$salfaavi=$auxsaldoafavor;
																	$cuentacbr=buscanumcuenta('P13',$fechaf);
																	$auxavisos=$auxavisos-$salfaavi;
																	if($auxavisos>=0){$valordeb=$salfaavi;$auxsaldoafavor=0;}
																	else
																	{
																		$valordeb=$salfaavi+$auxavisos;
																		$auxsaldoafavor=abs($auxavisos);
																	}
																	$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Avisos y Tableros $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	if($_POST['cuentabanco']==$cuentacbr)
																	{
																		$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																	}
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
																	if($_POST['cuentabanco']==$cuentacbr)
																	{
																		$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																	}
																}
																if($auxavisos>0)//si queda saldo avisos lo toma del banco
																{
																	$valordeb=$auxavisos;
																	$cuentacbr=$cuentacb;
																	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','Avisos y Tableros $_POST[modorec]','', '$valordeb','0','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	if($_POST['cuentabanco']==$cuentacbr)
																	{
																		$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																	}
																}
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
														if($numcc==''){$numcc=$row2[5];}
														if($row2[3]=='N')
														{
															if($row2[6]=='S')
															{
																$valordeb=0;
																$valorcred=$totalbombe;
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','Bomberil $_POST[ageliquida]', '','$valordeb', '$valorcred','1', '$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																if($_POST['cuentabanco']==$row2[4])
																{
																	$valorcuentabanco=$valorcuentabanco+($valordeb-$valorcred);
																}
																//********** CAJA O BANCO
																//$auxbombe=$totalbombe;
																$auxbombe=$totalbombe01;
																if($saldoafavor>0 && $auxbombe>0 && $auxsaldoafavor>0)//si hay saldo a favor
																{
																	$salfabombe=$auxsaldoafavor;
																	$cuentacbr=buscanumcuenta('P13',$fechaf);
																	$auxbombe=$auxbombe-$salfabombe;
																	if($auxbombe>=0)
																	{
																		$valordeb=$salfabombe;
																		$auxsaldoafavor=0;
																	}
																	else
																	{
																		$valordeb=$salfabombe+$auxbombe;
																		$auxsaldoafavor=abs($auxbombe);
																	}
																	$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Bomberil $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	if($_POST['cuentabanco']==$cuentacbr)
																	{
																		$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																	}
																}
																if($antivigant>0 && $auxbombe>0 && $auxantivigant>0)//saldo vigencia Anterio
																{
																	$svantbombe=$auxantivigant;
																	$cuentacbr=buscanumcuenta('P13',$fechaf);
																	$auxbombe=$auxbombe-$svantbombe;
																	if($auxbombe>=0)
																	{
																		$valordeb=$svantbombe;
																		$auxantivigant=0;
																	}
																	else{$valordeb=$svantbombe+$auxbombe;$auxantivigant=abs($auxbombe);}
																	$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a vigencia Anterior Avisos y tableros $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	if($_POST['cuentabanco']==$cuentacbr)
																	{
																		$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																	}
																}
																if($auxbombe>0)//si queda saldo bomberil lo toma del banco
																{
																	$valordeb=$auxbombe;
																	$cuentacbr=$cuentacb;
																	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito, estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','Bomberil $_POST[modorec]', '','$valordeb','0', '1','$_POST[vigencia]' )";
																	mysql_query($sqlr,$linkbd);
																	if($_POST['cuentabanco']==$cuentacbr)
																	{
																		$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																	}
																}
															}
														}
													}
												}
											}break;
											case 'P10'://descuentos sobretasa bomberil
											{
												if($descuenbombe>0)
												{
													$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P10' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P10' AND tipo='C' AND fechainicial<='$fechaf')";
													$res2=mysql_query($sqlr2,$linkbd);
													while($row2=mysql_fetch_row($res2))
													{
														if($row2[3]=='N')
														{
															if($row2[6]=='S')
															{
																$valordeb=$descuenbombe;
																$valorcred=0;
																$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado,vigencia) VALUES ('5 $concecc','$row2[4]', '".$_POST['tercero']."','$row2[5]','Descuentos Bomberil ".$_POST['ageliquida']."','','$valordeb', '$valorcred','1','".$_POST['vigencia']."')";
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
																if($_POST['cuentabanco']==$cuentaica)
																{
																	$valorcuentabanco=$valorcuentabanco+(0-$valorcred);
																}
																//********** CAJA O BANCO
																$auxantivigact=$antivigact;
																if($retenciones>0 && $auxreten>0)//si hay retencion 
																{
																	$retevigact=$auxreten;
																	$cuentacbr=buscanumcuenta('P11',$fechaf);
																	$auxantivigact=$auxantivigact-$retevigact;
																	if($auxantivigact>=0){$valordeb=$retevigact;$auxreten=0;}
																	else{$valordeb=$retevigact+$auxantivigact;$auxreten=abs($auxantivigact);}
																	$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Retenciï¿½n Anticipo vigencia Actual $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	if($_POST['cuentabanco']==$cuentacbr)
																	{
																		$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																	}
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
																	if($_POST['cuentabanco']==$cuentacbr)
																	{
																		$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																	}
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
																	if($_POST['cuentabanco']==$cuentacbr)
																	{
																		$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																	}
																}
																if($auxantivigact>0)//si queda saldo avisos lo toma del banco
																{
																	$valordeb=$auxantivigact;
																	$cuentacbr=$cuentacb;
																	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','Anticipo vigencia Actual $_POST[modorec]','', '$valordeb','0','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	if($_POST['cuentabanco']==$cuentacbr)
																	{
																		$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																	}
																}
															}
														}
													}
												}
											}break;
											case 'P14'://descuento industria y comercio
											{
												if($descuenindus>0)
												{
													$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P14' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P14' AND tipo='C' AND fechainicial<='$fechaf')";
													$res2=mysql_query($sqlr2,$linkbd);
													while($row2=mysql_fetch_row($res2))
													{
														if($row2[3]=='N')
														{
															if($row2[6]=='S')
															{
																$valordeb=$descuenindus;
																$valorcred=0;
																$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) VALUES ('5 $concecc','$row2[4]', '".$_POST['tercero']."','$row2[5]','Descuento Industria y Comercio ".$_POST['ageliquida']."','', '$valordeb','$valorcred','1', '".$_POST['vigencia']."')";
																mysql_query($sqlr,$linkbd);
															}
														}
													}
												}
												if($exoneracion>0)
												{
													$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P14' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P14' AND tipo='C' AND fechainicial<='$fechaf')";
													$res2=mysql_query($sqlr2,$linkbd);
													while($row2=mysql_fetch_row($res2))
													{
														if($row2[3]=='N')
														{
															if($row2[6]=='S')
															{
																$valordeb=$exoneracion;
																$valorcred=0;
																$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) VALUES ('5 $concecc','$row2[4]', '".$_POST['tercero']."','$row2[5]','Exoneración Industria y Comercio ".$_POST['ageliquida']."','', '$valordeb','$valorcred','1', '".$_POST['vigencia']."')";
																mysql_query($sqlr,$linkbd);
															}
														}
													}
												}
											}break;
											case 'P15'://descuento avisos y tableros
											{
												if($descuenaviso>0)
												{
													$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P15' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P15' AND tipo='C' AND fechainicial<='$fechaf')";
													$res2=mysql_query($sqlr2,$linkbd);
													while($row2=mysql_fetch_row($res2))
													{
														if($row2[3]=='N')
														{
															if($row2[6]=='S')
															{
																$valordeb=$descuenaviso;
																$valorcred=0;
																$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('5 $concecc','$row2[4]', '".$_POST['tercero']."','$row2[5]','Descuento Avisos y Tableros ".$_POST['ageliquida']."','','$valordeb', '$valorcred','1', '".$_POST['vigencia']."')";
																mysql_query($sqlr,$linkbd);
															}
														}
													}
												}
											}break;
										}
									}
								}
								//**************Ajuste de redondeo******************
								$diferenciatotal=$_POST['valorecaudo']-$valorcuentabanco;
								if($diferenciatotal!=0)
								{
									$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_MILES'";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)){$cuentaredondeos=$row[0];}
									if($diferenciatotal>0)
									{
										$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','".$_POST['cuentabanco']."','".$_POST['tercero']."','$numcc','AJUSTE DE REDONDEO','0',$diferenciatotal,'0','1', '".$_POST['vigencia']."')";
										mysql_query($sqlr,$linkbd);
										$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentaredondeos','".$_POST['tercero']."','$numcc','AJUSTE DE REDONDEO','0','0',$diferenciatotal,'1', '".$_POST['vigencia']."')";
										mysql_query($sqlr,$linkbd);
									}
									else
									{
										$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','".$_POST['cuentabanco']."','".$_POST['tercero']."','$numcc','AJUSTE DE REDONDEO','0','0',".abs($diferenciatotal).",'1', '".$_POST['vigencia']."')";
										mysql_query($sqlr,$linkbd);
										$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentaredondeos','".$_POST['tercero']."','$numcc','AJUSTE DE REDONDEO','0',".abs($diferenciatotal).",'0','1', '".$_POST['vigencia']."')";
										mysql_query($sqlr,$linkbd);
									}
								}
							}
							echo "<table class='inicio'><tr><td class='saludo1'><center>Se Reflejo de Manera Correcta el Recibo de Caja <img src='imagenes/confirm.png'></center></td></tr></table>";
   						}
						else
	 					{
	  						echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion <img src='imagenes/alert.png'></center></td></tr></table>";
	 					}
					}break; 
					case 3: //**************OTROS RECAUDOS
					{
    					$sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='5'";
	 					mysql_query($sqlr,$linkbd);
	  				 	$sqlr="delete from comprobante_det where  numerotipo=$_POST[idcomp] and tipo_comp='5'";
						mysql_query($sqlr,$linkbd);
 						if(strpos($_POST[fecha],"-")===false)
						{
							preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
							$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
						}
						else{$fechaf=$_POST[fecha];}
						//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
						//***busca el consecutivo del comprobante contable
						$consec=$_POST[idcomp];
						//***cabecera comprobante
						$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito, diferencia,estado) values ($consec,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estadoc]')";
						mysql_query($sqlr,$linkbd);
						$idcomp=mysql_insert_id();
						//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
						for($x=0;$x<count($_POST[dcoding]);$x++)
						{
		 					//***** BUSQUEDA INGRESO ********
							$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
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
									if($rowc[6]=='S' and $_POST[dcoding][$x]!=$_POST[cobrorecibo])
			  						{				 			  
			  							$cuenta=$rowc[4];
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
			  								//****creacion documento presupuesto ingresos
											$sql="SELECT terceros FROM tesoingresos WHERE codigo=".$_POST[dcoding][$x] ;
											$res=mysql_query($sql,$linkbd);
											$row= mysql_fetch_row($res);
											//************ FIN MODIFICACION PPTAL
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $consec','$cuenta','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','', '$valordeb.','$valorcred','1','$_POST[vigencia]')";
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
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $consec','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','', '$valorcred',0,'1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);
										}
									}
			 						if($_POST[dcoding][$x]==$_POST[cobrorecibo] and $rowc[7]=='S')
			  						{
										$cuenta=$rowc[4];
										$valorcred=$_POST[dvalores][$x]*($porce/100);
										$valordeb=0;
										if($rowc[3]=='N')
										{
											//*****inserta del concepto contable  
											//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
											$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
											$respto=mysql_query($sqlrpto,$linkbd);	  
											$rowpto=mysql_fetch_row($respto);
											$vi=$_POST[dvalores][$x]*($porce/100);
											$sql="SELECT terceros FROM tesoingresos WHERE codigo='".$_POST[dcoding][$x]."'";
											$res=mysql_query($sql,$linkbd);
											$row= mysql_fetch_row($res);
											//****creacion documento presupuesto ingresos
											//************ FIN MODIFICACION PPTAL
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $consec','$cuenta','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','', '$valordeb','$valorcred','1','$_POST[vigencia]')";
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
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $consec','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','', '$valorcred',0,'1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);
										}			  
			 						}		
		 						}
		 					}
						}	
						echo "<table class='inicio'><tr><td class='saludo1'><center>Se Reflejo de Manera Correcta el Recibo de Caja <img src='imagenes/confirm.png'></center></td></tr></table>"; 
					}break;
				} //*****fin del switch
			}//***bloqueo
			else
			{
				echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
			}
		}//**fin del oculto 
		?>	
		</form><?php if($_POST[oculto]==""){echo"<script>validar2();</script>";}?>
	</body>
</html>