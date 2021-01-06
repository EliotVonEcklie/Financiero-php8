<?php
	//*** Modificacion Causacion Si No
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	require "validaciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function validar(){document.form2.submit();}
			function guardar()
			{
				if (document.form2.fecha.value!='')
				{
					if (confirm("Esta Seguro de Guardar"))
					{
						document.form2.oculto.value=2;
						document.form2.vari.value='3';
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
			function calcularpago()
			{
				valorp=document.form2.valor.value;
				descuentos=document.form2.totaldes.value;
				valorc=valorp-descuentos;
				document.form2.valorcheque.value=valorc;
				document.form2.valoregreso.value=valorp;
				document.form2.valorretencion.value=descuentos;
				document.form2.vari.value='3';
				document.form2.submit();
			}
			function pdf()
			{
				document.form2.action="pdfcxp.php";
				document.form2.target="_BLANK";
				document.form2.vari.value='3';
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					document.form2.action="cont-egreso-reflejar.php";
					//document.form2.vari.value='3';
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
					document.form2.action="cont-egreso-reflejar.php";
					//document.form2.vari.value='3';
					document.form2.submit();
				}
			}
			function checkinicios()
			{
				cali=document.getElementsByName('inicios[]');
				for (var i=0;i < cali.length;i++) 
				{ 
					if (document.getElementById("inicia").checked == true) 
					{
						cali.item(i).checked = true;
						document.getElementById("inicia").value=1;	 
					}
					else
					{
						cali.item(i).checked = false;
						document.getElementById("inicia").value=0;
						document.getElementById("inicia").value=0;
					}
				}
				//document.form2.vari.value='3';
				document.form2.submit();
			}
			function checker()
			{
				document.form2.vari.value='3';
				document.form2.submit();
			} 
			function validar2()
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.idcomp.value;
				document.form2.action="cont-egreso-reflejar.php";
				//document.form2.vari.value='3';
				document.form2.submit();
			}
			function direccionaCuentaGastos(row){window.open("cont-editarcuentagastos.php?idcta="+row);}
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
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='cont-buscaegreso-reflejar.php'" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/reflejar1.png" title="Reflejar" class="mgbt" onClick="guardar()"/><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/iratras.png" title="Menu Reflejar" onClick="location.href='cont-reflejardocs.php'" class="mgbt"></td>
			</tr>		  
		</table>
        <form name="form2" method="post" action=""> 
			<?php
                function generaRetenciones($orden,$valor)
                {
                    $total=0;
                    $sql="SELECT porcentaje FROM tesoordenpago_retenciones WHERE id_orden=$orden AND estado='S' ";
                    $result=mysql_query($sql,$linkbd);
                    $num=mysql_num_rows($result);
                    if($num==0){$total=$valor;}
                    else
                    {
                        while($row = mysql_fetch_row($result)){$total+=($valor*$row[0])/100;}
                    }
                    return $total;
                }
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
                if($_POST[oculto]=='1'){$_POST[causacion]=1;}
                //*********** cuenta origen va al credito y la destino al debito
                if($_GET[consecutivo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[consecutivo];</script>";}
				if(!$_POST[oculto])
				{
					$sqlr="select *from cuentapagar where estado='S' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
					$sqlr="select * from tesoordenpago WHERE tipo_mov='201' ORDER BY id_orden DESC";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$_POST[maximo]=$r[0];
					if ($_POST[codrec]!="" || $_GET[consecutivo]!="")
					{
						if($_POST[codrec]!=""){$sqlr="select * from tesoordenpago WHERE id_orden='$_POST[codrec]' AND tipo_mov='201' ";}
						else{$sqlr="select * from tesoordenpago WHERE id_orden='$_GET[consecutivo]' AND tipo_mov='201'";}
					}
					else{$sqlr="select * from tesoordenpago WHERE tipo_mov='201' ORDER BY id_orden DESC";}
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$_POST[ncomp]=$r[0];
					$check1="checked"; 
					$fec=date("d/m/Y");
					if($_GET[idop]!=""){$_POST[ncomp]=$_GET[idop];}
					$vigusu=$vigusu; 		
					$sqlr="select * from tesoordenpago where tipo_mov='201' AND id_orden='$_POST[ncomp]'";
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					while($r=mysql_fetch_row($res))
					{
						$consec=$r[0];
						preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/", $r[2],$fecha);
 						$_POST[fecha]="$fecha[3]/$fecha[2]/$fecha[1]";
						$_POST[compcont]=$r[1];
						$_POST[rp]=$r[4];
						$_POST[estado]=$r[13];
						$_POST[estadoc]=$r[13];
						$_POST[medioDePago]	= $r[19];
						if($_POST[medioDePago]=='')
							$_POST[medioDePago] = '-1';
					}
					$_POST[idcomp]=$consec;
				}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';
				}
				$sqlr="select * from tesoordenpago where id_orden=$_POST[idcomp] AND tipo_mov='201' ";
				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res))
				{	preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/", $r[2],$fecha);
 					$_POST[fecha]="$fecha[3]/$fecha[2]/$fecha[1]";
					$_POST[vigencia]=$fecha[1];
					$_POST[rp]=$r[4];
					$sql="SELECT destino FROM tesoordenpago_almacen WHERE id_orden='$_POST[idcomp]' ";
					$res=mysql_query($sql,$linkbd);
					$fila=mysql_fetch_row($res);
					$_POST[destino]=$fila[0];
					$sqlr1="select * from tesoordenpago where id_orden=$_POST[idcomp] AND tipo_mov='401' ";
					$res1=mysql_query($sqlr1,$linkbd);
					$cont=mysql_num_rows($res1);
					if($cont>0){$_POST[estado]="R";}
					else{$_POST[estado]=$r[13];}
					$_POST[estadoc]=$r[13];	
					$_POST[medioDePago]	= $r[19];
						if($_POST[medioDePago]=='')
							$_POST[medioDePago] = '-1';
				}
				$nresul=buscaregistro($_POST[rp],$vigusu);
				$_POST[cdp]=$nresul;
				//*** busca detalle cdp
  				$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo, pptorp.tercero,pptocdp.objeto from pptorp,pptocdp where pptorp.estado='S' and pptocdp.consvigencia=$_POST[cdp] and pptorp.idcdp=pptocdp.consvigencia and pptorp.consvigencia='$_POST[rp]' and pptorp.vigencia=$vigusu and pptorp.idcdp=pptocdp.consvigencia and pptocdp.vigencia=$_POST[vigencia] and pptorp.tipo_mov='201' AND pptocdp.tipo_mov='201' order by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[detallecdp]=$row[2];
				$sqlr="Select *from tesoordenpago where tipo_mov='201' and id_orden=".$_POST[idcomp];
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[tercero]=$row[6];
				$_POST[ntercero]=buscatercero($_POST[tercero]);
				$_POST[valorrp]=$row[8];
				$_POST[saldorp]=$row[9];
				$_POST[cdp]=$row[4];
				$_POST[valor]=$row[10];
				$_POST[cc]=$row[5];				
				$_POST[detallegreso]=$row[7];
				$_POST[valoregreso]=$_POST[valor];
				$_POST[valorretencion]=$row[12];
				$_POST[base]=$row[14];
				$_POST[iva]=$row[15];
				$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
 			?>
			<div class="tabsic">
				<div class="tab">
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
					<label for="tab-1">Liquidacion CxP</label>
					<div class="content">
						<table class="inicio" align="center" >
							<tr >
								<td class="titulos" colspan="10">Liquidacion CxP</td>
								<td class="cerrar" style="width:7%" onClick="location.href='cont-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<td style="width:4.5cm" class="saludo1" >Numero CxP:</td>
								<td style="width:6%"> 
									<img src="imagenes/back.png" title="anterior" onClick="atrasc()"  class="icobut"/>&nbsp;<input name="idcomp" type="text" style="width:50%" value="<?php echo $_POST[idcomp]?>" onBlur="validar2()" onKeyUp="return tabular(event,this)"/>&nbsp;<img src="imagenes/next.png" title="siguiente" onClick="adelante()"  class="icobut"/>
								</td>
								<input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
								<input name="compcont" type="hidden" value="<?php echo $_POST[compcont]?>">
								<input type="hidden" value="a" name="atras" >
								<input type="hidden" value="s" name="siguiente" >
								<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
								<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
	  							<td style="width:2.5cm" class="saludo1">Fecha: </td>
								<td style="width:6%"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" style="width:100%" onKeyUp="return tabular(event,this)" readonly/></td>
								<td style="width:2.5cm" class="saludo1">Vigencia: </td>
								<td style="width:10%"><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>"  style="width:40%" onKeyUp="return tabular(event,this)" readonly/>&nbsp;<input name="estadoc" type="text" value="<?php echo $_POST[estadoc]?>" style="width:40%" readonly/></td>
								<input name="estado" type="hidden" value="<?php echo $_POST[estado]?>">
								<td style="width:3.5cm" class="saludo1">Causacion Contable:</td>
								<td style="width:5%">
									<select name="causacion" id="causacion" onKeyUp="return tabular(event,this)">
										<option value="1" <?php if($_POST[causacion]=='1') echo "selected" ?> >Si</option>
										<option value="2" <?php if($_POST[causacion]=='2') echo "selected" ?> >No</option>
									</select>
								</td>
								<td class="saludo1" style="width:10%">Destino de compra:</td>
								<td width="21%"> 
									<select name="destcompra" id="destcompra" style="width: 95%">
										<?php
											if($_POST[oculto]!='2')
											{
												$sq = "SELECT * FROM pptorp_almacen WHERE id_rp='$_POST[rp]' AND vigencia='$_POST[vigencia]'";
												$resalma = mysql_query($sq,$linkbd);
												$rowalma = mysql_fetch_row($resalma);
												$_POST[destcompra] = '';
												if($rowalma[0]!='')
												{
													$_POST[destcompra] =$rowalma[1];
												}
											}
											
											$sql="SELECT * FROM almdestinocompra WHERE estado='S' ORDER BY codigo";
											$result=mysql_query($sql,$linkbd);
											while($row = mysql_fetch_row($result)){
												if($_POST[destcompra]==$row[0]){
													echo "<option value='$row[0]' SELECTED>$row[1]</option>";
												}else{
													echo "<option value='$row[0]'>$row[1]</option>";
												}
												
											}
										?>
									</select>
											
								</td> 
							<tr>
								<td class="saludo1">Registro:</td>
								<td><input name="rp" type="text" value="<?php echo $_POST[rp]?>" style="width:100%" onKeyUp="return tabular(event,this)" readonly/></td>
								<input type="hidden" value="0" name="brp"> 
								<td class="saludo1">CDP:</td>
								<td><input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" style="width:100%" readonly/></td>
								<td class="saludo1">Detalle RP:</td>
								<td colspan="5"><input type="text" id="detallecdp" name="detallecdp" value="<?php echo $_POST[detallecdp]?>" style="width:100%" readonly/></td>
							</tr> 
							<tr>
								<td class="saludo1">Centro Costo:</td>
								<td>
									<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
										<?php
											$sqlr="select *from centrocosto where estado='S'";
											$res=mysql_query($sqlr,$linkbd);
											while ($row =mysql_fetch_row($res))
											{
												if($row[0]==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
											}
										?>
									</select>
								</td>
								<td class="saludo1">Tercero:</td>
								<td><input id="tercero" type="text" name="tercero" style="width:100%" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>" readonly/></td>
								<td colspan="4"><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly/></td>
								<td class="saludo1" style="width:3cm;">Medio de pago: </td>
        						<td style="width:17%;">
									<select name="medioDePago" id="medioDePago" onKeyUp="return tabular(event,this)" disabled style="width:80%">
										<option value="-1" <?php if(($_POST[medioDePago]=='-1')) echo "SELECTED"; ?>>Seleccione...</option>
         								<option value="1" <?php if(($_POST[medioDePago]=='1')) echo "SELECTED"; ?>>Con SF</option>
          								<option value="2" <?php if($_POST[medioDePago]=='2') echo "SELECTED"; ?>>Sin SF</option>
        							</select>
								</td>
							</tr>
							<tr>
								<td class="saludo1">Detalle Orden de Pago:</td>
								<td colspan="9"><input type="text" id="detallegreso" name="detallegreso" value="<?php echo $_POST[detallegreso]?>" style="width:100%"  readonly ></td>
							</tr>
							<tr>
								<td class="saludo1">Valor RP:</td>
								<td><input type="text" id="valorrp" name="valorrp" value="<?php echo number_format($_POST[valorrp],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)" readonly/></td>
								<td class="saludo1">Saldo RP:</td>
								<td><input type="text" id="saldorp" name="saldorp"  value="<?php echo number_format($_POST[saldorp],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)" readonly/></td>
								<td class="saludo1" >Valor a Pagar:</td>
								<td><input type="text" id="valor" name="valor" value="<?php echo number_format($_POST[valor],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)" readonly/></td>
								<input type="hidden" value="1" name="oculto"/>
								<input type="hidden" value="1" name="vari"/>
								<td class="saludo1" >Base:</td>
								<td><input type="text" id="base" name="base" value="<?php echo number_format($_POST[base],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)"  readonly/></td>
								<td class="saludo1" >Iva:</td>
								<td><input type="text" id="iva" name="iva" value="<?php echo number_format($_POST[iva],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)"  readonly/></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
					<label for="tab-2">Retenciones</label>
					<div class="content"> 
						<table class="inicio" style="overflow:scroll">
							<tr>
								<td class="titulos">Descuento</td>
								<td class="titulos">%</td>
								<td class="titulos">Valor</td>
							</tr>
							<?php
							$totaldes=0;
							$sqlr="select *from tesoordenpago_retenciones where id_orden='$_POST[idcomp]'";
							$res=mysql_query($sqlr,$linkbd);
							while($row=mysql_fetch_row($res))
							{		 
								$sqlr="select *from tesoretenciones where id='$row[0]'";
								$res2=mysql_query($sqlr,$linkbd);
								$row2=mysql_fetch_row($res2);
								echo "
								<tr>
									<td class='saludo2'>
										<input name='dndescuentos[]' value='".$row2[2]."' type='hidden'>
										<input name='ddescuentos[]' value='".$row[0]."' type='hidden'>".$row2[2]."
									</td>
									<td class='saludo2'>
										<input name='dporcentajes[]' value='".$row[2]."' type='hidden'>".$row[2]."
									</td>
									<td class='saludo2'>
										<input name='ddesvalores[]' value='".$row[3]."' type='hidden'>".$row[3]."
									</td>
								</tr>";
								$totaldes=$totaldes+$row[3];
							}		 
						?>
						<script>document.form2.totaldes.value=<?php echo $totaldes;?>;</script>
					</table>
				</div>
			</div>
				<div class="tab">
					<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
 					<label for="tab-3">Cuenta por Pagar</label>
					<div class="content"> 
						<table class="inicio" align="center">
							<tr>
								<td colspan="6" class="titulos">Cheque</td>
								<td class="cerrar" style="width:7%" onClick="location.href='cont-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<td style="width:2.5cm" class="saludo1">Cuenta Contable:</td>
								<td style="width:20%"><input name="cuentapagar" type="text" value="<?php echo $_POST[cuentapagar]?>" style="width:100%; text-align:center" readonly/></td>
								<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>"/>
								<input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>"/>
								<td style="width:50%" colspan="4"></td>
							</tr>
							<tr>
								<td class="saludo1">Valor Orden de Pago:</td>
								<td><input type="text" id="valoregreso" name="valoregreso" value="<?php echo number_format($_POST[valoregreso],2,',','.')?>" style="width:100%; text-align:right" readonly/></td>
								<td class="saludo1">Valor Retenciones:</td>
								<td align="right"><input type="text" id="valorretencion" name="valorretencion" value="<?php echo number_format($_POST[valorretencion],2,',','.')?>" style="width:100%; text-align:right" readonly/></td>
								<td class="saludo1">Valor Cta Pagar:</td>
								<td align="right"><input type="text" id="valorcheque" name="valorcheque" value="<?php echo number_format($_POST[valorcheque],2,',','.')?>" style="width:100%; text-align:right" readonly/></td>
							</tr>	
						</table>
					</div>
				</div>
			</div>
			<div class="subpantallac4">
				<?php
					//*** busca contenido del rp
					$_POST[dcuentas]=array();
					$_POST[dncuentas]=array();
					$_POST[dvalores]=array();
					$_POST[rubros]=array();
					if($_POST[vari]!='3')
					{$_POST[inicios]=array();}
					$sqlr="select *from tesoordenpago_det where id_orden=$_POST[idcomp] and tipo_mov='201' ";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{
						//echo "hola".$_POST[vari];
						$consec=$r[0];	  
						$_POST[dcuentas][]=$r[2];
						$_POST[rubros][]=$r[2];
						if($_POST[vari]!='3')
						{$_POST[inicios][]=$r[2];}
						$_POST[dvalores][]=$r[4];
						$_POST[dncuentas][]=buscacuentapres($r[2],2);
					}
				?>
				<table class="inicio">
					<tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>
					<?php
						if($_POST[inicia]==1){$checkint='checked';}
						else {$checkint='';}
					?>
					<tr>
						<td class="titulos2"><input type="checkbox" id="inicia" name="inicia" onClick="checkinicios()" value="<?php echo $_POST[inicia] ?>" <?php echo $checkint ?>/></td>		
						<td class="titulos2">Cuenta</td>
						<td class="titulos2">Nombre Cuenta</td>
						<td class="titulos2">Recurso</td>
						<td class="titulos2">Valor</td>
					</tr>
					<?php
						$_POST[totalc]=0;
						$iter='saludo1a';
						$iter2='saludo2';
						for ($x=0;$x<count($_POST[dcuentas]);$x++)
						{
							$chs='';
							$ck=esta_en_array($_POST[inicios],$_POST[dcuentas][$x]);
							if($ck=='1')
							{
								$chs="checked";
								$_POST[token]=$_POST[token]+$_POST[dvalores][$x];
							}
							$sql1="SELECT regalias FROM pptocuentas WHERE cuenta='".$_POST[dcuentas][$x]."' AND (vigencia='$vigusu' or vigenciaf='$vigusu')";
							$rst1=mysql_query($sql1,$linkbd);
							$ar=mysql_fetch_row($rst1);
							echo "
							<tr class='$iter' style=\"cursor: hand \" ondblclick=\"direccionaCuentaGastos('".$_POST[dcuentas][$x]."')\" onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								<td style='width:3%;'><input type='checkbox' name='inicios[]' value='".$_POST[dcuentas][$x]."' onClick='checker()' $chs></td>
								<td style='width:20%'><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='hidden'><input name='dregalias[]' value='".$ar[0]."' type='hidden'><input name='rubros[]' value='".$_POST[rubros][$x]."' type='hidden'>".$_POST[dcuentas][$x]."</td>
								<td style='width:60%'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='hidden'>".$_POST[dncuentas][$x]."</td>
								<td style='width:10%'><input name='drecursos[]' value='".$_POST[drecursos][$x]."' type='hidden'>".$_POST[drecursos][$x]."</td>
								<td align='right'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden'>".number_format($_POST[dvalores][$x],2,',','.')."</td>
							</tr>";
							$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
							$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;	
						}
						$resultado = convertir($_POST[totalc]);
						$_POST[letras]=$resultado." PESOS M/CTE";
						echo "
						<input name='totalcf' type='hidden' value='$_POST[totalcf]' readonly>
						<input name='totalc' type='hidden' value='$_POST[totalc]'>
						<tr class='titulos2'>
							<td colspan='3'></td>
							<td>Total</td>
							<td align='right'>".number_format($_POST[totalc],2,',','.')."</td>
						</tr>
						<tr class='titulos2'>
							<td>Son:</td> 
							<td colspan='5'><input name='letras' type='hidden' value='$_POST[letras]'>$_POST[letras]</td>
						</tr>";
					?>
				</table>
			</div>
			<?php
			if($_POST[oculto]=='2')
			{
				$query="SELECT conta_pago FROM tesoparametros";
				$resultado=mysql_query($query,$linkbd);
				$arreglo=mysql_fetch_row($resultado);
				$opcion=$arreglo[0];
				$vigencia=$_POST[vigencia];
				if($_POST[causacion]=='2')
				{$_POST[detallegreso]="ESTE DOCUMENTO NO REQUIERE CAUSACION CONTABLE - ".$_POST[detallegreso];}
				$consec=$_POST[idcomp];
				preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
				$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
				if($_POST[estado]=='N' || $_POST[estado]=='R')
				{
					$sqlr="update comprobante_cab  set estado=0 where numerotipo=$_POST[idcomp] and tipo_comp=11";
					mysql_query($sqlr,$linkbd);
				}
				else
				{
					$sqlr="delete from comprobante_cab  where numerotipo='$_POST[idcomp]' and tipo_comp=11";
					mysql_query($sqlr,$linkbd);
					$sqlr="delete from comprobante_det where id_comp='11 $_POST[idcomp]'";
					mysql_query($sqlr,$linkbd);
					echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado la Orden de Pago con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
					//***cabecera comprobante CXP LIQUIDADA
					$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ( $consec,11,'$fechaf','$_POST[detallegreso]',0,0,0,0,'1')";
					mysql_query($sqlr,$linkbd);
					$idcomp=$_POST[idcomp];
					$sqexis = "SELECT * FROM pptorp_almacen WHERE id_rp='$_POST[rp]' AND vigencia='$_POST[vigencia]'";
	 				$resexis = mysql_query($sqexis,$linkbd);
	 				$rowexis = mysql_fetch_row($resexis);
	 				if($rowexis[0]!='')
	 				{
						//	echo "hola".$_POST[destcompra];
		 				$sqlupdate = "UPDATE pptorp_almacen SET destino='$_POST[destcompra]' WHERE id_rp='$_POST[rp]' AND vigencia='$_POST[vigencia]'";
		 				if (!mysql_query($sqlupdate,$linkbd))
		 				{
			 				echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlupdate</b></font></p>";
			 				echo "Ocurri� el siguiente problema:<br>";
			 				echo "<pre>";
			 				echo "</pre></center></td></tr></table>";
		 				}
	 				}
	 				else
	 				{
		 				$sqlrinsert = "insert into pptorp_almacen (id_rp,destino,vigencia) values ('$_POST[rp]','".$_POST[destcompra]."','$_POST[vigencia]')";
		 				if (!mysql_query($sqlrinsert,$linkbd))
		 				{
			 				echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlrinsert</b></font></p>";
			 				echo "Ocurri� el siguiente problema:<br>";
			 				echo "<pre>";
			 				echo "</pre></center></td></tr></table>";
		 				}
	 				}
	 				//********* creacion del cdp ****************
					//*** if de control de guardado
					//******************* DETALLE DEL COMPROBANTE CONTABLE  *********************
					$cc=$_POST[cc];
					$arreglocuenta=Array();
					for($j=0;$j<count($_POST[dvalores]); $j++)
					{
						if($opcion=="1")
						{
							$valneto=0;
							if($_POST[valor]>0)
							{
								for($x=0;$x<count($_POST[dndescuentos]);$x++)
								{	
									$dd=$_POST[ddescuentos][$x];
									$sqlr="select * from tesoretenciones_det,tesoretenciones where tesoretenciones_det.codigo=tesoretenciones.id and tesoretenciones.id='$dd'";
									$resdes=mysql_query($sqlr,$linkbd);
									$valordes=0;
									while($rowdes=mysql_fetch_assoc($resdes))
									{
										$codigoRetencion=0;
										$rest=0;
										$val2=0;
										$codigoCausa=0;
										if ($_POST[medioDePago]!='1' && ($rowdes['terceros']!='1' || $rowdes['tipo']=='C'))
										{
											$codigoRetencion = $rowdes['conceptosgr'];
											$codigoCausa = $rowdes['conceptocausa'];
											if($codigoCausa == '-1' )
											{
												if($codigoRetencion == "-1")
												{
													$rest=substr($rowdes['tipoconce'],-2);
													$codigoRetencion = $rowdes['conceptoingreso'];
													$val2=$rowdes['porcentaje'];
													//echo "$rest - $val2 <br>";
												}
												else
												{
													$rest='SR';
													$codigoRetencion = $rowdes['conceptosgr'];
													$val2=$rowdes['porcentaje'];
												}
											}
											elseif($rowdes['tipo'] == 'S')
											{
												$codigoRetencion = $rowdes['conceptoingreso'];
												$rest=substr($rowdes['tipoconce'],-2);
												$val2=$rowdes['porcentaje'];
											}
											else
											{
												continue;
											}
										}
										else
										{
											$codigoIngreso = $rowdes['conceptoingreso'];
											if($codigoIngreso != "-1")
											{
												$codigoRetencion = $rowdes['conceptoingreso'];
												$rest=substr($rowdes['tipoconce'],-2);
												$val2=$rowdes['porcentaje'];
											}
										}
										$valordes=0;
										
										if($_POST[iva]>0 && $rowdes['terceros']==1)
										{
											$val1=$_POST[dvalores][$j];
											$val3=$_POST[ddesvalores][$x];
											$valordes=round(($val1/$_POST[valor])*($val2/100)*$val3,0);
										}
										else
										{
											$val1=$_POST[dvalores][$j];
											$val3=$_POST[ddesvalores][$x];
											$valordes=round(($val1/$_POST[valor])*($val2/100)*$val3,0);
										}	
										//echo $arreglocuenta[$_POST[dcuentas][$j]]."--".$valordes."<br>";
										$arreglocuenta[$_POST[dcuentas][$j]]+=$valordes;
										$nomDescuento=$_POST[dndescuentos][$x];
										$cc=$_POST[cc];
										$tercero=$_POST[tercero];
										$sq="select fechainicial from conceptoscontables_det where codigo='$codigoRetencion' and modulo='".$rowdes['modulo']."' and tipo='$rest' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
										$re=mysql_query($sq,$linkbd);
										while($ro=mysql_fetch_assoc($re))
										{
											$_POST[fechacausa]=$ro["fechainicial"];
										}
										$sqlr="select * from conceptoscontables_det where codigo='$codigoRetencion' and modulo='".$rowdes['modulo']."' and cc='$cc' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";
										$rst=mysql_query($sqlr,$linkbd);
										$row1=mysql_fetch_assoc($rst);
										//TERMINA BUSQUEDA CUENTA CONTABLE////////////////////////
										if($row1['cuenta']!='' && $valordes>0)
										{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('11 $consec','".$row1['cuenta']."','".$tercero."' ,'".$cc."' , 'Descuento ".$nomDescuento."','',0,".$valordes.",'1' ,'".$vigencia."')";
											$valneto+=$valordes;
											mysql_query($sqlr,$linkbd);
										}
										//cuenta puente
										if($rowdes['conceptocausa']!='-1' && $_POST[medioDePago]=='1')
										{
											//concepto contable //********************************************* */
											$rest=substr($rowdes['tipoconce'],0,2);
											$sq="select fechainicial from conceptoscontables_det where codigo='".$rowdes['conceptocausa']."' and modulo='".$rowdes['modulo']."' and tipo='$rest' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
											
											$re=mysql_query($sq,$linkbd);
											while($ro=mysql_fetch_assoc($re))
											{
												$_POST[fechacausa]=$ro["fechainicial"];
											}
											$sqlr="select * from conceptoscontables_det where codigo='".$rowdes['conceptocausa']."' and modulo='".$rowdes['modulo']."' and cc='$cc' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";
											$rst=mysql_query($sqlr,$linkbd);
											$row1=mysql_fetch_assoc($rst);
											if($row1['cuenta']!='' && $valordes>0)
											{
												$sqlr3="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('11 $consec','".$row1['cuenta']."','".$tercero."' ,'".$cc."' , 'Descuento ".$nomDescuento."','',".$valordes.",0,'1' ,'".$vigencia."')";
												mysql_query($sqlr3,$linkbd);
												$sqlr4="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('11 $consec','".$row1['cuenta']."','".$tercero."' ,'".$cc."' , 'Descuento ".$nomDescuento."','',0,".$valordes.",'1' ,'".$vigencia."')";
												mysql_query($sqlr4,$linkbd);
												$sq="SELECT cuentapres FROM tesoretenciones_det_presu WHERE id_retencion='".$rowdes['id']."'"; 
												$rs=mysql_query($sq,$linkbd);
												while($rw1=mysql_fetch_row($rs))
												{
													$ideg=$_POST[idcomp];
													//*** afectacion pptal DESCUENTOS
													if($rw1[0]!='')
													{
														$sql="insert into pptoretencionpago(cuenta,idrecibo,valor,vigencia,tipo) values ('".$rw1[0]."',$consec,$valordes,'$vigusu','orden')";
														mysql_query($sql,$linkbd);
													}
												}
												
											}
										}
									}
								}
							}
						}
					}
					if($_POST[causacion]!='2')
					{$cuentaResta=0;
						$vigusu=$_POST[vigencia];
						//******************* DETALLE DEL COMPROBANTE CONTABLE  *********************
						for ($y=0;$y<count($_POST[inicios]);$y++)
						{	
							for($x=0;$x<count($_POST[dcuentas]);$x++)
							{
								if(0==strcmp($_POST[dcuentas][$x],$_POST[inicios][$y]))  
								{
									//***BUSCAR CUENTA PPTAL ***************
									if($_POST[dregalias][$x]=='S')
									{$numvigencia="(vigencia='$_POST[vigencia]' OR vigencia='".($_POST[vigencia] - 1)."')";}
									else {$numvigencia="vigencia='$_POST[vigencia]'";}
									$sqlr="select codconcepago,codconcecausa,nomina from pptocuentas where cuenta='".$_POST[dcuentas][$x]."' and $numvigencia";
									$resp=mysql_query($sqlr,$linkbd);
									
									//******ACTUALIZACION DE CUENTA PPTAL CUENTAS X PAGAR ************			
									while($row=mysql_fetch_row($resp))
									{
										$concepto=$row[0];
										$concepto2=$row[1];
										//echo " $concepto - $_POST[cc] - $fechaf <br>";
										$cuentas=concepto_cuentas($concepto,'P',3,$_POST[cc],$fechaf);  				
										$tam=count($cuentas);
										for($cta=0;$cta<$tam;$cta++)
										{   
											$ctacon=$cuentas[$cta][0];
											if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
											{
												$ncuent=buscacuenta($ctacon);								  
												if ($_POST[dvalores][$x]>0 && $ncuent!='')
												{
													if($arreglocuenta[$_POST[dcuentas][$x]]>0)
													{
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('11 $consec','$ctacon','$_POST[tercero]','$_POST[cc]','Causacion ".$_POST[dncuentas][$x]."','','".$arreglocuenta[$_POST[dcuentas][$x]]."','0','1', '$_POST[vigencia]')";
														//echo "<br>".$sqlr;
														mysql_query($sqlr,$linkbd);
													}
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('11 $consec','$ctacon','$_POST[tercero]','$_POST[cc]','Causacion ".$_POST[dncuentas][$x]."','','0','".$_POST[dvalores][$x]."','1', '$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
													
												}
											}		
											if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
											{
												$ncuent=buscacuenta($ctacon);
												if ($_POST[dvalores][$x]>0 && $ncuent!='')
												{					
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('11 $consec','$ctacon','$_POST[tercero]','$_POST[cc]','Causacion ".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",'0','1','$_POST[Vigencia]')";
													mysql_query($sqlr,$linkbd);
												}
											}
										}
										//CONCEPTO DE PAGO******
										$cuentas=array();
										
										if($_POST[destcompra]=='01')
										{
											$sqlrVal = "SELECT SUM(almg_det.valortotal) FROM almginventario almg, almginventario_det almg_det WHERE almg.codmov='$_POST[rp]' AND almg.consec=almg_det.codigo AND almg.tipomov='1'";
											$respaVal=mysql_query($sqlrVal,$linkbd);
											$rowaVal=mysql_fetch_row($respaVal);
											$rr=round(($_POST[dvalores][$x]/$_POST[valor])*$rowaVal[0]);
											$residuoCuentaGasto=$_POST[dvalores][$x]-$rr;
											if($residuoCuentaGasto<0)
											{
												$rr = $_POST[dvalores][$x];
											}

											$sqlr="select ccontable from almdestinocompra_det where codigo='".$_POST[destcompra]."'" ;
											$respa=mysql_query($sqlr,$linkbd);   
											$rowa=mysql_fetch_row($respa);
											//echo $rowa[0];
											$cuentas=concepto_cuentas($rowa[0],'AT',5,$_POST[cc],$fechaf); 
											$tam=count($cuentas);
											for($cta=0;$cta<$tam;$cta++)
											{
												$ctacon=$cuentas[$cta][0];
												if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
												{
													$ncuent=buscacuenta($ctacon);
													if ($rr>0 && $ncuent!='')
													{
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$rr.",0,'1','".$_POST[vigencia]."')";
														mysql_query($sqlr,$linkbd);
													}
												}		
												if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
												{
													$ncuent=buscacuenta($ctacon);
													if ($rr>0 && $ncuent!='')
													{					
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,".$rr.",'1','".$_POST[vigencia]."')";
														mysql_query($sqlr,$linkbd);
													}
												}	
											}
											$cuentas=concepto_cuentas($concepto2,'C',3,$_POST[cc],$fechaf);
											$tam=count($cuentas);
											for($cta=0;$cta<$tam;$cta++)
											{
												$ctacon=$cuentas[$cta][0];
												if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
												{
													$ncuent=buscacuenta($ctacon);
													if ($residuoCuentaGasto>0 && $ncuent!='')
													{
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,".$residuoCuentaGasto.",'1','".$_POST[vigencia]."')";
														mysql_query($sqlr,$linkbd);
													}
												}		
												if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
												{
													$ncuent=buscacuenta($ctacon);
													if ($residuoCuentaGasto>0 && $ncuent!='')
													{					
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$residuoCuentaGasto.",0,'1','".$_POST[vigencia]."')";
														mysql_query($sqlr,$linkbd);
													}
												}	
											}
										}
										elseif($_POST[destcompra]=='02')
										{
											$valorContACtivo = 0; 
											$sqlrVal = "SELECT SUM(act_det.valor) FROM acticrearact act, acticrearact_det act_det WHERE documento='$_POST[rp]' AND act.codigo=act_det.codigo";
											$respaVal=mysql_query($sqlrVal,$linkbd);
											$rowaVal=mysql_fetch_row($respaVal);
											$rr=round(($_POST[dvalores][$x]/$_POST[valor])*$rowaVal[0]);
											$residuoCuentaGasto=$_POST[dvalores][$x]-$rr;
											if($residuoCuentaGasto<0)
											{
												$rr = $_POST[dvalores][$x];
											}
											//$residuoCuentaGasto = $_POST[valor]-$rowaVal[0];
												
												
												$sqlr="select ccontable from almdestinocompra_det where codigo='".$_POST[destcompra]."'" ;
												$respa=mysql_query($sqlr,$linkbd);
												$rowa=mysql_fetch_row($respa);
												$cuentas=concepto_cuentas($rowa[0],'CT',5,$_POST[cc],$fechaf); 
												$tam=count($cuentas);
												for($cta=0;$cta<$tam;$cta++)
												{
													$ctacon=$cuentas[$cta][0];
													if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
													{
														$ncuent=buscacuenta($ctacon);
														if ($rr>0 && $ncuent!='')
														{
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$rr.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);//echo $sqlr."<br>";
														}
													}		
													if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
													{
														$ncuent=buscacuenta($ctacon);
														if ($rr>0 && $ncuent!='')
														{					
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,".$rr.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
														}
													}	
												}
													$cuentas=concepto_cuentas($concepto2,'C',3,$_POST[cc],$fechaf);
													$tam=count($cuentas);
													for($cta=0;$cta<$tam;$cta++)
													{
														$ctacon=$cuentas[$cta][0];
														if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
														{
															$ncuent=buscacuenta($ctacon);
															if ($residuoCuentaGasto>0 && $ncuent!='')
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,".$residuoCuentaGasto.",'1','".$_POST[vigencia]."')";
																mysql_query($sqlr,$linkbd);
															}
														}		
														if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
														{
															$ncuent=buscacuenta($ctacon);
															if ($residuoCuentaGasto>0 && $ncuent!='')
															{					
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$residuoCuentaGasto.",0,'1','".$_POST[vigencia]."')";
																mysql_query($sqlr,$linkbd);
															}
														}	
													}
												
												
											
										}
										else 
										{
											$cuentas=concepto_cuentas($concepto2,'C',3,$_POST[cc],$fechaf);
											$tam=count($cuentas);
											for($cta=0;$cta<$tam;$cta++)
											{
												$ctacon=$cuentas[$cta][0];
												if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
												{
													$ncuent=buscacuenta($ctacon);
													if ($_POST[dvalores][$x]>0 && $ncuent!='')
													{
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$_POST[vigencia]."')";
														mysql_query($sqlr,$linkbd);
													}
												}		
												if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
												{
													$ncuent=buscacuenta($ctacon);
													if ($_POST[dvalores][$x]>0 && $ncuent!='')
													{					
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$_POST[vigencia]."')";
														mysql_query($sqlr,$linkbd);
													}
												}	
											}
										}
									}
								}
							}
						}//**************FIN DE CONTABILIDAD
					}
  				}
					//**************FIN DE CONTABILIDAD	
				//************CREACION DEL COMPROBANTE CONTABLE ************************
				//***busca el consecutivo del comprobante contable
			}//************ FIN DE IF OCULTO************
			?>	
		</form>
	</body>
</html>	 