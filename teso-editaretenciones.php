<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>
<script>
	function buscacta(e){
		if (document.form2.cuenta.value!=""){
			document.form2.bc.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}

	function buscactac(e){
		if (document.form2.cuentac.value!=""){
			document.form2.bcc.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}

	function buscactap(e){
		if (document.form2.cuentap.value!=""){
			document.form2.bcp.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
		else
		{
			document.form2.bcp1.value='1';
			document.form2.submit();
		}
	}

	function validar(){
		document.getElementById('oculto').value='7';
		document.form2.submit();
	}

//GUARDAR, ADICIONAR Y ELIMINAR
	function guardar(){
		if (document.form2.nombre.value!=''&& document.form2.tipo.value!=''  && document.form2.codigo.value!=''){
			despliegamodalm('visible','4','Esta Seguro de Guardar los Cambios','1');
		}
		else{
			despliegamodalm('visible','2','Faltan datos para Modificar los Datos');
			document.form2.nombre.focus();document.form2.nombre.select();
		}
	}

	function agregardetalle(){
		if(document.form2.valor.value!=""){
			document.form2.agregadet.value=1;
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
		else {despliegamodalm('visible','2','Faltan datos para Agregar el Registro');}
	}

	function eliminar(variable){
		document.getElementById('elimina').value=variable;
		despliegamodalm('visible','4','Esta Seguro de Eliminar el Registro','2');
	}

	function despliegamodalm(_valor,_tip,mensa,pregunta){
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden"){document.getElementById('ventanam').src="";}
		else{
			switch(_tip){
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

	function funcionmensaje(){}
	function respuestaconsulta(pregunta){
		switch(pregunta){
			case "1":	document.getElementById('oculto').value='2';document.form2.submit();break;
			case "2":	document.getElementById('oculto').value='6';
						document.form2.submit();
						break;
		}
	}
	function buscacuentap()
	{
		document.form2.buscap.value='1';
		document.form2.oculto.value='7';
		document.form2.submit();
	}
</script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('ids').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('ids').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="teso-editaretenciones.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('ids').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('ids').value=prev;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="teso-editaretenciones.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="teso-buscaretenciones.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
		<tr>
			<script>barra_imagenes("teso");</script>
			<?php cuadro_titulos();?>
		</tr>	 
		<tr>
			<?php menu_desplegable("teso");?>
		</tr>
		<tr>
  			<td colspan="3" class="cinta">
				<a href="teso-retenciones.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
				<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
				<a href="teso-buscaretenciones.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a>
				<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" class="mgbt" title="Nueva ventana"></a>
				<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" class="mgbt"></a>
			</td>
		</tr>		  
	</table>
		<tr>
			<td colspan="3" class="tablaprin" align="center"> 
				<?php
					$vigencia=date(Y);
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$linkbd=conectar_bd();
				?>	
				<?php
					if ($_GET[is]!=""){echo "<script>document.getElementById('codrec').value=$_GET[is];</script>";}
					$sqlr="select MIN(id), MAX(id) from tesoretenciones ORDER BY id";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$_POST[minimo]=$r[0];
					$_POST[maximo]=$r[1];
					if($_POST[oculto]=="")
					{
						if ($_POST[codrec]!="" || $_GET[is]!="")
						{
							if($_POST[codrec]!=""){$sqlr="select *from tesoretenciones where id='$_POST[codrec]'";}
							else {$sqlr="select *from tesoretenciones where id ='$_GET[is]'";}
						}
						else{$sqlr="select * from  tesoretenciones ORDER BY id DESC";}
						$res=mysql_query($sqlr,$linkbd);
						$row=mysql_fetch_row($res);
						$_POST[ids]=$row[0];
					}
					
					function buscaDestino($destino)
					{
						switch($destino)
						{
							case "N":
							{
								return 'Nacional';
							}
							case 'M':
							{
								return 'Municipal';
							}
							case 'D':
							{
								return 'Departamental';
							}
						}
					}

		 			if(($_POST[oculto]!="2")&&($_POST[oculto]!="6")&&($_POST[oculto]!="7"))
					{
						unset($_POST[dconceptos]);	 		 		 		 		 
						unset($_POST[dnconceptos]);	
						$_POST[dconceptos]=array();		 		 		 		 		 
						$_POST[dnconceptos]=array();
						$_POST[conceptocausa]="";
						$_POST[nconceptocausa]="";
						$_POST[conceptoingreso]="";
						$_POST[nconceptoingreso]="";
						$_POST[conceptosgr]="";
						$_POST[nconceptosgr]="";
						$_POST[cuentap]="";
						$_POST[ncuentap]="";
						
						$sqlr="select *from tesoretenciones,tesoretenciones_det where  tesoretenciones.id=tesoretenciones_det.codigo and tesoretenciones.id=$_POST[ids]";
		 				$cont=0;
		 				$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_assoc($resp))
						{
							$sqlr3="SELECT *FROM tesoretenciones_det_presu WHERE cod_presu='".$row["cod_presu"]."' AND vigencia='$vigusu'";
							$res3=mysql_query($sqlr3,$linkbd);
							$row3=mysql_fetch_assoc($res3);
							$_POST[codigo]=$row["codigo"];
				 			$_POST[nombre]=$row["nombre"]; 	
		 	 	 			$_POST[tipo]=$row["tipo"];
				 			$_POST[retencion]=$row["retencion"];
				 			$_POST[terceros]=$row["terceros"];
				  			$_POST[iva]=$row["iva"];
		  		  			$_POST[tiporet]=$row["destino"];
							$_POST[nomina]=$row["nomina"];
							$sqlr1="Select * from conceptoscontables  where modulo='4' and tipo='RE' and codigo ='".$row["conceptocausa"]."' ";
							$resp1 = mysql_query($sqlr1,$linkbd);
							$row1 =mysql_fetch_assoc($resp1);
							$sqlr2="Select * from conceptoscontables  where modulo='4' and tipo='RI' and codigo ='".$row["conceptoingreso"]."' ";
							$resp2 = mysql_query($sqlr2,$linkbd);
							$row2 =mysql_fetch_assoc($resp2);
							$sqlr4 = "Select * from conceptoscontables  where modulo='4' and tipo='SR' and codigo ='".$row["conceptosgr"]."' ";
							$resp4 = mysql_query($sqlr4,$linkbd);
							$row4 =mysql_fetch_assoc($resp4);
				 			if($row["tipo"]=='C')
							{
								$_POST[dconceptocausa][$cont]=$row["conceptocausa"];
								$_POST[dnconceptocausa][$cont]=$row1["codigo"]." ".$row1["nombre"];
								$_POST[dconceptoingreso][$cont]=$row["conceptoingreso"];
								$_POST[dnconceptoingreso][$cont]=$row2["codigo"]." ".$row2["nombre"];
								$_POST[dconceptosgr][$cont]=$row["conceptosgr"];
								$_POST[dnconceptosgr][$cont]=$row4["codigo"]." ".$row4["nombre"];
							  	$_POST[dvalores][$cont]=$row["porcentaje"];	
							  	$_POST[tcuentas][$cont]='N';
								$_POST[dcuentasp][$cont]=$row3["cuentapres"];
								$_POST[dncuentasp][$cont]=buscacuentapres($row3["cuentapres"],1);
								$_POST[destinoRetencion][$cont]=buscaDestino($row["destino"]);
				 			}
							if($row["tipo"]=='S')
							{
				 				$_POST[conceptocausa]=$row["conceptocausa"];
				 				$_POST[nconceptocausa]=$row1["codigo"]." ".$row1["nombre"];
								$_POST[conceptoingreso]=$row["conceptoingreso"];
								$_POST[nconceptoingreso]=$row2["codigo"]." ".$row2["nombre"];
								$_POST[cuentap]=$row3["cuentapres"];	 		  			 
								$_POST[ncuentap]=buscacuentapres($row3["cuentapres"],1);
								$_POST[conceptosgr]=$row["conceptosgr"];
								$_POST[nconceptosgr]=$row4["codigo"]." ".$row4["nombre"];
				 			}
							$cont=$cont+1;
		   				}

		   				$sqlr="select *from tesoretenciones where tesoretenciones.id=$_POST[ids]";
		 				$cont=0;
		 				$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp))
						{
							$_POST[codigo]=$row[1];
				 			$_POST[nombre]=$row[2]; 	
		 	 	 			$_POST[tipo]=$row[3];
				 			$_POST[retencion]=$row[5];	 
				 			$_POST[terceros]=$row[6];	 
				 			$_POST[iva]=$row[7];	 
		 		  			$_POST[tiporet]=$row[8];
							$_POST[nomina]=$row[9];
		   				}
					}
					//NEXT
					$sqln="select *from tesoretenciones WHERE codigo > '$_POST[codigo]' ORDER BY codigo ASC LIMIT 1";
					$resn=mysql_query($sqln,$linkbd);
					$row=mysql_fetch_row($resn);
					$next="'".$row[0]."'";
					//PREV
					$sqlp="select *from tesoretenciones WHERE codigo < '$_POST[codigo]' ORDER BY codigo DESC LIMIT 1";
					$resp=mysql_query($sqlp,$linkbd);
					$row=mysql_fetch_row($resp);
					$prev="'".$row[0]."'";

				?>
				
				<div id="bgventanamodalm" class="bgventanamodalm">
					<div id="ventanamodalm" class="ventanamodalm">
						<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
						</IFRAME>
					</div>
				</div>
				
				
 				<form name="form2" method="post" action="">
					<?php //**** busca cuentas
			  			if($_POST[bcp]!='')
						{
							$nresul=buscacuentapres($_POST[cuentap],1);		
							if($nresul!='')	
							{
								$_POST[ncuentap]=$nresul;
							}
							else 
							{
								$_POST[ncuentap]="";
							}
						}
						if($_POST[bcp1]!='')
						{
							$_POST[ncuentap]="";
							$_POST[cuentap]="";
						}
						if($_POST[bc]!='')
						{
						  	$nresul=buscacuenta($_POST[cuenta]);			
						  	if($nresul!='')	{$_POST[ncuenta]=$nresul;}
						  	else {$_POST[ncuenta]="";}
						}
						if($_POST[bcc]!='')
						{
							$nresul=buscacuenta($_POST[cuentac]);		
						   	//echo "bbbb".$_POST[cuentac];	
						  	if($nresul!='')	{$_POST[ncuentac]=$nresul;	}
						  	else {$_POST[ncuentac]="";}
						}
					?>
 
    				<table class="inicio" align="center" >
      					<tr >
				        	<td class="titulos" colspan="14">Editar Retenciones Pagos</td>
				        	<td style="width:7%" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
				      	</tr>
      					<tr  >
					  		<td style="width:2.5cm" class="saludo1">Codigo:</td>
					        <td style="width:6%" >
					   	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)">
					   	    		<img src="imagenes/back.png" alt="anterior" align="absmiddle">
					   	    	</a> 
					        	<input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" style="width:30%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">        
						    	<a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)">
						    		<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
						    	</a> 
								<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
								<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
								<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
					            <input type='hidden' name='ids' id='ids' value= "<?php echo $_POST[ids]?>">
					      	</td>
					        <td style="width:2.5cm" class="saludo1">Nombre:</td>
					        <td colspan="7"><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" style="width:100%" onKeyUp="return tabular(event,this)"/></td>
					        <td style="width:3.5cm" class="saludo1">Valor Retencion </td>
					        <td style="width:10%">
					        	<input name="retencion" type="text" id="retencion" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[retencion]?>" style="width:70%" maxlength="5">%
					       	</td>
                    	</tr>
                        <tr>
					        <td class="saludo1">Tipo:</td>
					        <td>
					        	<select name="tipo" id="tipo" onChange="validar()" >
									<option value="S" <?php if($_POST[tipo]=='S') echo "SELECTED"?>>Simple</option>
						  			<option value="C" <?php if($_POST[tipo]=='C') echo "SELECTED"?>>Compuesto</option>
								</select>
								<input name="oculto" id="oculto" type="hidden" value="1">		  
                         	</td>
					        <td class="saludo1">Terceros:</td>
					        <td>
					        	<?php
									if ($_POST[terceros]=='1'){$chk='checked';}
									else {$chk='';}
								?>
        						<input name="terceros" type="checkbox" value="1" onClick="validar();" <?php echo $chk ?> >		  
        					</td> 
        					<td class="saludo1" style="width:2.5cm">IVA:</td>
        					<td>
        						<?php
									if ($_POST[iva]=='1'){$chk2='checked';}
									else {$chk2='';}
								?>
        						<input name="iva" type="checkbox" value="1" <?php echo $chk2 ?>>		  
        					</td>
                            <td class="saludo1" style="width:2.5cm">Nomina:</td>
        					<td>
        						<?php
									if ($_POST[nomina]=='1'){$chk3='checked';}
									else {$chk3='';}
								?>
        						<input type="checkbox" name="nomina" value="1" <?php echo $chk3 ?>>		  
        					</td>
                			<td class="saludo1">Destino:</td>
							<td>
								<select name="tiporet" id="tiporet" onChange="validar()" >
									<option value="" >Seleccione...</option>
									<option value="N" <?php if($_POST[tiporet]=='N') echo "SELECTED"?>>Nacional</option>
									<option value="D" <?php if($_POST[tiporet]=='D') echo "SELECTED"?>>Departamental</option>
									<option value="M" <?php if($_POST[tiporet]=='M') echo "SELECTED"?>>Municipal</option>            
								</select>        
							</td>
       					</tr> 
	   				</table>
	   <?php
	   		if($_POST[tipo]=='S') //***** SIMPLE
	   		{
	   ?>
	   		<table class="inicio">
	   			<tr>
	   				<td colspan="6" class="titulos">Detalle Retencion Pago</td>
	   			</tr>                  
	  			<tr>
					<td style="width:15%;" class="saludo1">Concepto Contable Causacion:</td>
					<td style="width:25%;">
						<select name="conceptocausa" id="conceptocausa" style="width:100%;">
							<option value="-1">Seleccione ....</option>
								<?php
									$sqlr="Select * from conceptoscontables where modulo='4' and tipo='RE' order by codigo";
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										$i=$row[0];
										echo "<option value=$row[0] ";
										if($i==$_POST[conceptocausa])
										{
											echo "SELECTED";
											$_POST[nconceptocausa]=$row[0]." - ".$row[3]." - ".$row[1];
										}
										echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
									}			
								?>
						</select>
						<input id="nconceptocausa" name="nconceptocausa" type="hidden" value="<?php echo $_POST[nconceptocausa]?>" >
					</td>
					<td></td>
					<td></td>
				</tr>                 
	  			<tr>
					<td style="width:15%;" class="saludo1">Concepto Contable Ingresos:</td>
					<td style="width:25%;">
						<select name="conceptoingreso" id="conceptoingreso" style="width:100%;">
							<option value="-1">Seleccione ....</option>
								<?php
									$sqlr="Select * from conceptoscontables where modulo='4' and tipo='RI' order by codigo";
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										$i=$row[0];
										echo "<option value=$row[0] ";
										if($i==$_POST[conceptoingreso])
										{
											echo "SELECTED";
											$_POST[nconceptoingreso]=$row[0]." - ".$row[3]." - ".$row[1];
										}
										echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
									}			
								?>
						</select>
						<input id="nconceptoingreso" name="nconceptoingreso" type="hidden" value="<?php echo $_POST[nconceptoingreso]?>" >
					</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td style="width:15%;" class="saludo1">Concepto Contable SGR:</td>
					<td style="width:25%;">
						<select name="conceptosgr" id="conceptosgr" style="width:100%;">
							<option value="-1">Seleccione ....</option>
								<?php
									$sqlr="Select * from conceptoscontables where modulo='4' and tipo='SR' order by codigo";
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										$i=$row[0];
										echo "<option value=$row[0] ";
										if($i==$_POST[conceptosgr])
										{
											echo "SELECTED";
											$_POST[nconceptosgr]=$row[0]." - ".$row[3]." - ".$row[1];
										}
										echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
									}			
								?>
						</select>
						<input id="nconceptosgr" name="nconceptosgr" type="hidden" value="<?php echo $_POST[nconceptosgr]?>" >
					</td>
					<td></td>
					<td></td>
				</tr>
			 	<tr>
			 		<td style="width:10%;" class="saludo1">Cuenta presupuestal: </td> 
					<td style="width:50%;" colspan="3" valign="middle" >
          				<input type="text" id="cuentap" name="cuentap" style="width:10%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactap(event)" value="<?php echo $_POST[cuentap]?>" onClick="document.getElementById('cuentap').focus();document.getElementById('cuentap').select();">
          				<input type="hidden" value="" name="bcp" id="bcp">
						<input type="hidden" value="" name="bcp1" id="bcp1">
          				<a href="#" onClick="mypop=window.open('scuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px'); mypop.focus();">
          					<img src="imagenes/buscarep.png" align="absmiddle" border="0">
          				</a>
						<input name="ncuentap" type="text" style="width:60%;" value="<?php echo $_POST[ncuentap]?>" readonly>
          			</td>
					<td></td>
					<td></td>		
	    		</tr> 
    		</table>
		<?php
			}
			if($_POST[tipo]=='C') //**** COMPUESTO
	   		{
	   	?>
	    	<table class="inicio">
	   			<tr>
	   				<td colspan="4" class="titulos">Agregar Detalle Retencion Pago</td>
	   			</tr>  
				<tr>
					<td style="width:15%;" class="saludo1">Concepto Contable Causacion:</td>
					<td style="width:40%;" colspan="2">
						<select name="conceptocausa" id="conceptocausa" style="width:100%;">
							<option value="-1">Seleccione ....</option>
								<?php
									$sqlr="Select * from conceptoscontables where modulo='4' and tipo='RE' order by codigo";
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										$i=$row[0];
										echo "<option value=$row[0] ";
										if($i==$_POST[conceptocausa])
										{
											echo "SELECTED";
											$_POST[nconceptocausa]=$row[0]." - ".$row[3]." - ".$row[1];
										}
										echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
									}			
								?>
						</select>
						<input id="nconceptocausa" name="nconceptocausa" type="hidden" value="<?php echo $_POST[nconceptocausa]?>" >
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="saludo1">Concepto Contable Ingresos:</td>
					<td style="width:40%;" colspan="2">
						<select name="conceptoingreso" id="conceptoingreso" style="width:100%;">
							<option value="-1">Seleccione ....</option>
								<?php
									$sqlr="Select * from conceptoscontables where modulo='4' and tipo='RI' order by codigo";
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										$i=$row[0];
										echo "<option value=$row[0] ";
										if($i==$_POST[conceptoingreso])
										{
											echo "SELECTED";
											$_POST[nconceptoingreso]=$row[0]." - ".$row[3]." - ".$row[1];
										}
										echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
									}			
								?>
						</select>
						<input id="nconceptoingreso" name="nconceptoingreso" type="hidden" value="<?php echo $_POST[nconceptoingreso]?>" >
					</td>
					<td></td>
				</tr>
					<tr>
						<td class="saludo1">Concepto Contable SGR:</td>
						<td style="width:40%;" colspan="2">
							<select name="conceptosgr" id="conceptosgr" style="width:100%;">
								<option value="-1">Seleccione ....</option>
									<?php
										$sqlr="Select * from conceptoscontables where modulo='4' and tipo='SR' order by codigo";
										$resp = mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($resp)) 
										{
											$i=$row[0];
											echo "<option value=$row[0] ";
											if($i==$_POST[conceptosgr])
											{
												echo "SELECTED";
												$_POST[nconceptosgr]=$row[0]." - ".$row[3]." - ".$row[1];
											}
											echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
										}			
									?>
							</select>
							<input id="nconceptosgr" name="nconceptosgr" type="hidden" value="<?php echo $_POST[nconceptosgr]?>" >
						</td>
						<td></td>
					</tr>
				<tr>
					<td class="saludo1">Cuenta presupuestal: </td>
          			<td valign="middle" style="width:10%;">
          				<input type="text" style="width:80%;" id="cuentap" name="cuentap" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactap(event)" value="<?php echo $_POST[cuentap]?>" onClick="document.getElementById('cuentap').focus();document.getElementById('cuentap').select();">
          				<input type="hidden" value="" name="bcp" id="bcp">
						<input type="hidden" value="" name="bcp1" id="bcp1">
          				<a href="#" onClick="mypop=window.open('scuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px'); mypop.focus();">
          					<img src="imagenes/buscarep.png" align="absmiddle" border="0">
          				</a>
          			</td>
					<td valign="middle">
						<input name="ncuentap" style="width:100%;" type="text" value="<?php echo $_POST[ncuentap]?>" readonly>
					</td>
				</tr>
				<tr>
					<td class="saludo1">Division Retencion:</td>
					<td style="width:10%;">
						<input id="valor" style="width:80%;" name="valor" type="text" value="<?php echo $_POST[valor]?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" > % 
						
						<input type="hidden" value="0" name="agregadet">
						<input type="hidden" value="<?php echo $_POST[id]?>" name="id">
						<input type="hidden" value="0" name="buscap">
					</td>
					<td>
						<select name="tiporet" id="tiporet" onChange="validar()" >
							<option value="" >Seleccione...</option>        
							<option value="N" <?php if($_POST[tiporet]=='N') echo "SELECTED"?>>Nacional</option>
							<option value="D" <?php if($_POST[tiporet]=='D') echo "SELECTED"?>>Departamental</option>
							<option value="M" <?php if($_POST[tiporet]=='M') echo "SELECTED"?>>Municipal</option>            
						</select>
						<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
					</td>
	    		</tr> 
    		</table>
	 	<?php
			//**** busca cuenta
			if($_POST[bc]!='')
			{
			  	$nresul=buscacuenta($_POST[cuenta]);
			  	if($nresul!='')
			   	{
			  		$_POST[ncuenta]=$nresul;
  					echo"
					<script>
						document.getElementById('cuentap').focus();
						document.getElementById('cuentap').select();
						document.getElementById('bc').value='';
					</script>";
			  	}
			 	else
			 	{
			  		$_POST[ncuenta]="";
					echo"<script>alert('Cuenta Incorrecta');document.form2.cuenta.focus();</script>";
			  	}
			}
			if($_POST[bcc]!='')
			{
			  	$nresul=buscacuenta($_POST[cuentac]);
			  	if($nresul!='')
			   	{
			  		$_POST[ncuentac]=$nresul;
  					echo"
					<script>
						document.getElementById('cuenta').focus();
						document.getElementById('cuenta').select();
						document.getElementById('bcc').value='';
					</script>";
			  	}
			 	else
			 	{
			  		$_POST[ncuentac]="";
					echo"<script>alert('Cuenta Incorrecta');document.form2.cuentac.focus();</script>";
			  	}
			} 
			//**** busca cuenta
			if($_POST[bcp]!='')
			{
			  	$nresul=buscacuentapres($_POST[cuentap],1);
			  	if($nresul!='')
			   	{
			  		$_POST[ncuentap]=$nresul;
  					echo"
					<script>
						document.getElementById('codigo').focus();
						document.getElementById('codigo').select();
						document.getElementById('bcp').value='';
					</script>";
			  	}
				else
				{
					$_POST[ncuentap]="";
					echo"
					<script>
						alert('Cuenta Incorrecta');
						document.form2.cuentap.focus();
						document.form2.cuentap.select();
					</script>";
				}
			}
		?>
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="8">Detalle Retencion Pago</td>
				</tr>
				<tr>
					<td class="titulos2">Concepto Contable Causacion</td>
					<td class="titulos2">Concepto Contable Ingreso</td>
					<td class="titulos2">Concepto Contable SGR:</td>
					<td class="titulos2">Cta Pres</td>
					<td class="titulos2">Nombre Cta Pres</td>
					<td class="titulos2">Destino</td>
					<td class="titulos2">%</td>
					<td class="titulos2">
						<img src="imagenes/del.png" >
						<input type='hidden' name='elimina' id='elimina'>
					</td>
				</tr>
		<?php
		if ($_POST[elimina]!='')
		{
			$posi=$_POST[elimina];	
			unset($_POST[tcuentas][$posi]);
			unset($_POST[dconceptocausa][$posi]);
			unset($_POST[dnconceptocausa][$posi]);
			unset($_POST[dconceptoingreso][$posi]);
			unset($_POST[dnconceptoingreso][$posi]);
			unset($_POST[dconceptosgr][$posi]);
			unset($_POST[dnconceptosgr][$posi]);	 
			unset($_POST[dcuentasp][$posi]);
			unset($_POST[dncuentasp][$posi]);		 
			unset($_POST[dvalores][$posi]);
			unset($_POST[destinoRetencion][$posi]);
			$_POST[tcuentas]= array_values($_POST[tcuentas]); 
			$_POST[dconceptocausa]= array_values($_POST[dconceptocausa]); 
			$_POST[dnconceptocausa]= array_values($_POST[dnconceptocausa]); 		 		 
			$_POST[dconceptoingreso]= array_values($_POST[dconceptoingreso]); 
			$_POST[dnconceptoingreso]= array_values($_POST[dnconceptoingreso]);
			$_POST[dconceptosgr]= array_values($_POST[dconceptosgr]); 
			$_POST[dnconceptosgr]= array_values($_POST[dnconceptosgr]); 	 		 
			$_POST[dcuentasp]= array_values($_POST[dcuentasp]); 
			$_POST[dncuentasp]= array_values($_POST[dncuentasp]); 		 		 
			$_POST[dvalores]= array_values($_POST[dvalores]);
			$_POST[destinoRetencion]= array_values($_POST[destinoRetencion]); 		 		 		 
		}
		if ($_POST[agregadet]=='1')
		{
			$cuentacred=0;
		  	$cuentadeb=0;
		  	$diferencia=0;
			$_POST[tcuentas][]='N';
			$_POST[dconceptocausa][]=$_POST[conceptocausa];
			$_POST[dnconceptocausa][]=$_POST[nconceptocausa];
			$_POST[dconceptoingreso][]=$_POST[conceptoingreso];
			$_POST[dnconceptoingreso][]=$_POST[nconceptoingreso];
			$_POST[dconceptosgr][]=$_POST[conceptosgr];
			$_POST[dnconceptosgr][]=$_POST[nconceptosgr];
			$_POST[dcuentasp][]=$_POST[cuentap];
			$_POST[dncuentasp][]=$_POST[ncuentap];		 
			$_POST[dvalores][]=$_POST[valor];
			$_POST[destinoRetencion][]=buscaDestino($_POST[tiporet]);
			$_POST[agregadet]=0;
			echo"
			<script>
				document.form2.conceptocausa.value='';
				document.form2.nconceptocausa.value='';
				document.form2.conceptoingreso.value='';
				document.form2.nconceptoingreso.value='';
				document.form2.conceptosgr.value='';
				document.form2.nconceptosgr.value='';
				document.form2.ncuentac.value='';				
				document.form2.ncuentap.value='';
				document.form2.valor.value='';
				document.form2.tiporet.value='';
				document.form2.submit();
			</script>";
		 }
		 if($_POST[buscap]=='1')
		 {
			for($x=0;$x<count($_POST[dcuentasp]);$x++)
			{
				$sqlr="SELECT nombre FROM pptocuentas WHERE cuenta='".$_POST[dcuentasp][$x]."' AND vigencia='$vigusu'";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[dncuentasp][$x]=$row[0];
			}
		 }
		 for ($x=0;$x< count($_POST[dconceptocausa]);$x++)
		 {
			 echo "<tr>
					<td class='saludo2' style='width:20%;'>
						<input name='dconceptocausa[]' value='".$_POST[dconceptocausa][$x]."' type='hidden' style='width:100%;' readonly>
						<input name='dnconceptocausa[]' value='".$_POST[dnconceptocausa][$x]."' type='text' style='width:100%;' readonly>
					</td>
					<td class='saludo2'style='width:20%;'>
						<input name='dconceptoingreso[]' value='".$_POST[dconceptoingreso][$x]."' type='hidden' style='width:100%;' readonly>
						<input name='dconceptosgr[]' value='".$_POST[dconceptosgr][$x]."' type='hidden' style='width:100%;' readonly>
						<input name='dnconceptoingreso[]' value='".$_POST[dnconceptoingreso][$x]."' type='text' style='width:100%;' readonly>
					</td>
					<td class='saludo2'style='width:20%;'>
						<input name='dnconceptosgr[]' value='".$_POST[dnconceptosgr][$x]."' type='text' style='width:100%;' readonly>
					</td>
					<td class='saludo2' style='width:5%;'>
						<input name='dcuentasp[]' value='".$_POST[dcuentasp][$x]."' type='text' style='width:100%;' onDblClick='llamarventanadeb(this,$x)' onBlur='buscacuentap()'>
					</td>
					<td class='saludo2' style='width:20%;'>
						<input name='dncuentasp[]' value='".$_POST[dncuentasp][$x]."' type='text' style='width:100%;' onDblClick='llamarventanacred(this,$x)' readonly>
					</td>
					<td class='saludo2' style='width:10%;'>
						<input name='destinoRetencion[]' value='".$_POST[destinoRetencion][$x]."' type='text' style='width:100%;' readonly>
					</td>
					<td class='saludo2' style='width:3%;'>
						<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' style='width:100%;' onDblClick='llamarventanadeb(this,$x)' readonly>
					</td>
					<td class='saludo2' style='width:1%;'>
						<a href='#' onclick='eliminar($x)'>
							<img src='imagenes/del.png'>
						</a>
					</td>
				</tr>";
		 }	 
		 ?>
	<tr></tr>
	</table>	
	   <?php
	   }
		?>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
	$sumaTotal = 0;
	$evaluar = 0;
	for ($x=0;$x< count($_POST[dconceptocausa]);$x++)
	{
		$sumaCausa = 0;
		$sumaSgr = 0;
		$valorRete = $_POST[dvalores][$x];
		if($_POST[dconceptocausa][$x]!='-1')
		{
			$sumaCausa += $valorRete;
			$valorRete=0;
		}
		if($_POST[dconceptosgr][$x]!='-1')
		{
			$sumaSgr += $valorRete;
			$valorRete=0;
			$evaluar=1;
		}
		$sumaTotal += $sumaCausa + $valorRete;
		$sumaTotalSgr += $sumaSgr + $valorRete;
	}
	$sumaT = 0;
	if($evaluar==1)
	{
		$sumaT = $sumaTotalSgr;
	}
	else
	{
		$sumaT = 100;
	}
	if($_POST[tipo]=='S') //**** simple
	{
		$sumaTotal='100';
		$sumaT='100';
	}
	if ($sumaTotal=='100')
	{
		$linkbd=conectar_bd();
		if ($_POST[nombre]!="")
		{
			$nr="1";
			$sqlr="update tesoretenciones set codigo='$_POST[codigo]',nombre='".utf8_decode($_POST[nombre])."',tipo='$_POST[tipo]',estado='S', retencion='$_POST[retencion]',terceros='$_POST[terceros]',iva='$_POST[iva]',destino='$_POST[tiporet]',nomina='$_POST[nomina]' where tesoretenciones.id ='$_POST[ids]'";
			if (!mysql_query($sqlr,$linkbd))
			{
				echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
				echo "Ocurri� el siguiente problema:<br>";
				echo "<pre>";
				echo "</pre></center></td></tr></table>";
			}
			else
			{
				$sq="SELECT max(cod_presu) FROM tesoretenciones_det";
				$rs=mysql_query($sq,$linkbd);
				$rw=mysql_fetch_row($rs);
				echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Ingreso con Exito</center></td></tr></table>";
				if($_POST[tipo]=='S') //**** simple
				{
					$rw[0]+=1;
					$sqlr="delete from tesoretenciones_det where tesoretenciones_det.codigo='$_POST[ids]'"; 
					mysql_query($sqlr,$linkbd);
					$sqlr="delete from tesoretenciones_det_presu where tesoretenciones_det_presu.codigo='$_POST[ids]' and vigencia='$vigusu'";
					mysql_query($sqlr,$linkbd);
					$sqlr="INSERT INTO tesoretenciones_det (codigo,cod_presu,conceptocausa,conceptoingreso,modulo,tipoconce,porcentaje,estado,conceptosgr)VALUES ('$_POST[ids]','$rw[0]','".$_POST[conceptocausa]."','".$_POST[conceptoingreso]."','4','RE-RI','100','S','".$_POST[conceptosgr]."')";
					if (!mysql_query($sqlr,$linkbd))
					{
						echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
						echo "Ocurri� el siguiente problema:<br>";
						echo "<pre>";
						echo "</pre></center></td></tr></table>";
					}
					$id=mysql_insert_id();
					if($_POST[cuentap]!="")
					{
						$sqlr="INSERT INTO tesoretenciones_det_presu (id_retencion,codigo,cod_presu,cuentapres,vigencia)VALUES ('$id','$_POST[ids]','$rw[0]','".$_POST[cuentap]."','$vigusu')";
						if (!mysql_query($sqlr,$linkbd))
						{
							echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
							echo "Ocurri� el siguiente problema:<br>";
							echo "<pre>";
							echo "</pre></center></td></tr></table>";
						}
						else
						{
							echo "<script>despliegamodalm('visible','1','Se ha almacenado el Detalle de la Retencion con Exito','1');</script>";
						}
					}
					
				}
				//****COMPUESTO	
				if($_POST[tipo]=='C') //**** COMPUESTO
				{
					$sqlr="delete from tesoretenciones_det where tesoretenciones_det.codigo='$_POST[ids]'";
					if (!mysql_query($sqlr,$linkbd))
					{
						echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
						echo "Ocurri� el siguiente problema:<br>";
						echo "<pre>";
						echo "</pre></center></td></tr></table>";
					}
					$sqlr="delete from tesoretenciones_det_presu where tesoretenciones_det_presu.codigo='$_POST[ids]' and vigencia='$vigusu'";
					if (!mysql_query($sqlr,$linkbd))
					{
						echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
						echo "Ocurri� el siguiente problema:<br>";
						echo "<pre>";
						echo "</pre></center></td></tr></table>";
					}
					else
					{
						for($x=0;$x<count($_POST[dconceptocausa]);$x++)
						{
							$rw[0]+=1;
							$sqlr="INSERT INTO tesoretenciones_det (codigo,cod_presu,conceptocausa,conceptoingreso,modulo,tipoconce,porcentaje,estado,conceptosgr,destino)VALUES ('$_POST[ids]','$rw[0]','".$_POST[dconceptocausa][$x]."','".$_POST[dconceptoingreso][$x]."','4','RE-RI','".$_POST[dvalores][$x]."','S','".$_POST[dconceptosgr][$x]."','".$_POST[destinoRetencion][$x]."')";
							if (!mysql_query($sqlr,$linkbd))
							{
								echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
								echo "Ocurri� el siguiente problema:<br>";
								echo "<pre>";
								echo "</pre></center></td></tr></table>";
							}
							$id=mysql_insert_id();
							if($_POST[dcuentasp][$x]!="")
							{
								$sqlr="INSERT INTO tesoretenciones_det_presu (id_retencion,codigo,cod_presu,cuentapres,vigencia)VALUES ('$id','$_POST[ids]','$rw[0]','".$_POST[dcuentasp][$x]."','$vigusu')";
								if (!mysql_query($sqlr,$linkbd))
								{
									echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
									echo "Ocurri� el siguiente problema:<br>";
									echo "<pre>";
									echo "</pre></center></td></tr></table>";
								}
								else
								{
									echo "<script>despliegamodalm('visible','1','Se ha almacenado el Detalle de la Retencion con Exito','1');</script>";
			
								}
							}
							else
							{
								$sql="UPDATE tesoretenciones_det_presu SET cod_presu='$rw[0]' WHERE ";
							}
						}//***** fin del for	
					}
				}
			}
		}
		else
		{
			echo "<table class='incio'><tr><td class='saludo1'><center>Falta informacion para Crear el Centro Costo</center></td></tr></table>";
		}
	}
	else
	{
		echo "<script>despliegamodalm('visible','2','No cumple con la division de la retencion','1');</script>";
	}
}
?> </td></tr>
     
</table>
    </form>

</body>
</html>