<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<title>:: SPID - Tesoreria</title>
	<script>
		function buscacta(e)
 		{
			if (document.form2.cuenta.value!="")
			{
 				document.form2.bc.value='1';
 				document.form2.submit();
 			}
 		}
	</script>
	<script language="JavaScript1.2">
		function validar()
		{
			document.form2.submit();
		}
		function agregardetalle()
		{
			if(document.form2.banco.value!="" &&  document.form2.cb.value!=""  )
			{ 
				document.form2.agregadet.value=1;
				//document.form2.chacuerdo.value=2;
				document.form2.submit();
 			}
 			else 
			{
 				alert("Falta informacion para poder Agregar");
 			}
		}
		function eliminar(variable)
		{
			if (confirm("Esta Seguro de Eliminar"))
  			{
				document.form2.elimina.value=variable;
				//eli=document.getElementById(elimina);
				vvend=document.getElementById('elimina');
				//eli.value=elimina;
				vvend.value=variable;
				document.form2.submit();
			}
		}
		//************* genera reporte ************
		//***************************************
		function guardar()
		{
			if (document.form2.tipop.value!='')
  			{
				if (confirm("Esta Seguro de Guardar"))
				{
					document.form2.oculto.value=2;
					document.form2.submit();
					//document.form2.action="pdfcdp.php";
				}
  			}
  			else
			{
  				alert('Faltan datos para completar el registro');
				document.form2.tercero.focus();
				document.form2.tercero.select();
  			}
		}
		function buscater(e)
 		{
			if (document.form2.tercero.value!="")
			{
 				document.form2.bt.value='1';
 				document.form2.submit();
 			}
 		}
		function buscar()
 		{
			// alert("dsdd");
 			document.form2.buscav.value='1';
 			document.form2.submit();
 		}
		function pdf()
		{
			document.form2.action="pdfpredialprescripcion.php";
			document.form2.target="_BLANK";
			document.form2.submit(); 
			document.form2.action="";
			document.form2.target="";
		}
	</script>
	<script src="css/programas.js"></script>
	<script src="css/calendario.js"></script>
	<link href="css/css2.css" rel="stylesheet" type="text/css" />
	<link href="css/css3.css" rel="stylesheet" type="text/css" />
	<?php titlepag();?>
</head>
<body>
	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
	<span id="todastablas2"></span>
	<table>
		<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("teso");?></tr>
		<tr>
			<td colspan="3" class="cinta">
				<a href="teso-prescripciones.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
				<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a> 
				<a href="#" onClick="location.href='teso-buscaprescripciones.php'" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>  
				<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" class="mgbt"<?php } ?>> <img src="imagenes/print.png"  alt="Buscar" title="Imprimir" /></a> 
				<a href="teso-gestionpredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
			</td>
		</tr>		  
	</table>
	<tr>
		<td colspan="3" class="tablaprin" align="center"> 
			<?php
			$vigencia=date(Y);
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			if(!$_POST[oculto])
			{
				$linkbd=conectar_bd();	 	 	
				$sqlr="select *from  tesoparametros where estado='S' ";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
				{
					$_POST[agespre]=$row[2];
					$_POST[tesorero]=buscatercero($row[1]);
				}
				$_POST[agepar]=$vigusu-$_POST[agespre];
				$fec=date("d/m/Y");
				$_POST[fecha]=$fec; 	
				$_POST[valoradicion]=0;
				$_POST[valorreduccion]=0;
				$_POST[valortraslados]=0;		 		  			 
				$_POST[valor]=0;	
				$sqlr="select max(id) from tesoprescripciones";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res))
				{
					$consec=$r[0];
				}
				$consec+=1;
				$_POST[idpres]=$consec;
						
			}
			if ($_POST[chacuerdo]=='2')
			{
				$_POST[dcuentas]=array();
				$_POST[dncuetas]=array();
				$_POST[dingresos]=array();
				$_POST[dgastos]=array();
				$_POST[diferencia]=0;
				$_POST[cuentagas]=0;
				$_POST[cuentaing]=0;																			
			}
			?>

			<form  name="form2" method="post" action="">
 			<?php
			if($_POST[oculto]=='2')
			{
				$linkbd=conectar_bd();	
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$sqlr="insert into tesoprescripciones (fecha, resolucion, cedulacatastral, estado) values ('$fechaf','$_POST[nresol]','$_POST[catastral]','S')";
				mysql_query($sqlr,$linkbd);
				$nid=mysql_insert_id();
				$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($nid,18,'$fechaf','PRESCRIPCION COD CAT: $_POST[catastral]',0,0,0,0,'1')";
				//Siga trabajando--voy a estar revisando el estado
				mysql_query($sqlr,$linkbd);
				
				$tam=count($_POST[vigencias]);
				$tam2=count($_POST[dselvigencias]);
				//************** modificacion del presupuesto **************
				for($x=0;$x<$tam;$x++)
				{
	 				for($y=0;$y<$tam2;$y++)
	 				{
	  					if($_POST[vigencias][$x]==$_POST[dselvigencias][$y])
	   					{
		  					echo "<input name='pvigencias[]' type='hidden' value='".$_POST[dselvigencias][$y]."'>"; 
		  					echo "<input name='pavaluo[]' type='hidden' value='".$_POST[avaluosh][$x]."'>"; 		  
		  					$vig= $_POST[dselvigencias][$y];
	  						$sqlr="update tesoprediosavaluos set pago='P'  where codigocatastral=".$_POST[catastral]." and vigencia='".$_POST[dselvigencias][$y]."' and pago='N'";	  
  	  						if (!mysql_query($sqlr,$linkbd))
	  						{
	 							echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
								//$e =mysql_error($respquery);
	 							echo "Ocurri� el siguiente problema:<br>";
  	 							//echo htmlentities($e['message']);
  	 							echo "<pre>";
     							///echo htmlentities($e['sqltext']);
    							// printf("\n%".($e['offset']+1)."s", "^");
     							echo "</pre></center></td></tr></table>";
							}
  							else
  		 					{
		 						$sqlr="insert into tesoprescripciones_det (`id`, `vigencia`, `avaluo`, `estado`) values ($nid,'$vig','".$_POST[avaluosh][$x]."','S')";
		 						mysql_query($sqlr,$linkbd);
		 						//*********COMPROBANTE CONTABLE - CONFIGURACIONES CONTABLES ******
								$sqlr2="select IF(tasa='-1',0,tasa) from tesoprediosavaluos where vigencia='".$_POST[dselvigencias][$y]."' and codigocatastral='".$_POST[catastral]."' "; 
								$res2=mysql_query($sqlr2,$linkbd);
								$row2=mysql_fetch_row($res2);
								$base=$_POST[avaluosh][$x];
								$predial=$base*($row2[0]/1000);
								$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and concepto='03' order by concepto";
								//echo $sqlr2;
								$res3=mysql_query($sqlr2,$linkbd);
								$r3=mysql_fetch_row($res3);
								$bomberil=ceil($predial*($r3[5]/100));
								
								$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and concepto='02' order by concepto";
								//echo $sqlr2;
								$res3=mysql_query($sqlr2,$linkbd);
								$r3=mysql_fetch_row($res3);
								$ambiental=ceil($predial*($r3[5]/100));
								//*** conceptos contables ***
								//***BOMBERIL
								$sq="select fechainicial from conceptoscontables_det where codigo='02' and modulo='4' and tipo='PR' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
								$re=mysql_query($sq,$linkbd);
								while($ro=mysql_fetch_assoc($re))
								{
									$_POST[fechacausa]=$ro["fechainicial"];
								}
								$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='02' and tipo='PR' AND fechainicial='".$_POST[fechacausa]."'";
								$res2=mysql_query($sqlr2,$linkbd);
					 			while($row2=mysql_fetch_row($res2))
					  			{
					   				if($row2[3]=='N')
									{				 					  		
					   					if($row2[6]=='S')
					    				{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('18 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','PRESCRIPCION BOMBERIL COD CAT $_POST[catastral] - $vig','',".$bomberil.",0,'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
					    				}
										if($row2[6]=='N')
					    				{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('18 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','PRESCRIPCION BOMBERIL COD CAT $_POST[catastral] - $vig','',0,".$bomberil.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
					    				}				
					   				}
				 	 			}
								//*****AMBIENTAL
								$sq="select fechainicial from conceptoscontables_det where codigo='03' and modulo='4' and tipo='PR' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
								$re=mysql_query($sq,$linkbd);
								while($ro=mysql_fetch_assoc($re))
								{
									$_POST[fechacausa]=$ro["fechainicial"];
								}
								$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='03' and tipo='PR' and fechainicial='".$_POST[fechacausa]."'";
								$res2=mysql_query($sqlr2,$linkbd);
					 			while($row2=mysql_fetch_row($res2))
					  			{
					   				if($row2[3]=='N')
									{				 					  		
					   					if($row2[6]=='S')
					    				{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('18 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','PRESCRIPCION SOBRETASA AMBIENTAL COD CAT $_POST[catastral] - $vig','',".$ambiental.",0,'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
					    				}
										if($row2[6]=='N')
					    				{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('18 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','PRESCRIPCION SOBRETASA AMBIENTAL COD CAT $_POST[catastral] - $vig','',0,".$ambiental.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
					    				}				
					   				}
				 	 			}
								//****** PREDIAL ***
								$sq="select fechainicial from conceptoscontables_det where codigo='01' and modulo='4' and tipo='PR' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
								$re=mysql_query($sq,$linkbd);
								while($ro=mysql_fetch_assoc($re))
								{
									$_POST[fechacausa]=$ro["fechainicial"];
								}
					 			$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='01' and tipo='PR' and fechainicial='".$_POST[fechacausa]."'";
								$res2=mysql_query($sqlr2,$linkbd);
					 			while($row2=mysql_fetch_row($res2))
					  			{
					   				if($row2[3]=='N')
									{				 					  		
					   					if($row2[6]=='S')
					    				{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('18 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','PRESCRIPCION PREDIAL COD CAT $_POST[catastral] - $vig','',".$predial.",0,'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
					    				}
										if($row2[6]=='N')
					    				{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('18 $nid','".$row2[4]."','".$_POST[documento]."','".$row2[5]."','PRESCRIPCION PREDIAL COD CAT $_POST[catastral] - $vig','',0,".$predial.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
					    				}				
					  				}
				 	 			}
								//****FIN CONTABLE		 
		  						echo "<table class='inicio'><tr><td class='saludo1'><center>Vigencia Prescrita con Exito $vig <img src='imagenes\confirm.png'></center></td></tr></table>";
		  						?>
								<script>
		  							document.form2.tercero.value="";
		  							document.form2.ntercero.value="";
		  						</script>
		  						<?php
		  					}	  
	    				}
	   				}
				}
			}
			?>	
			<?php 
			if($_POST[bt]=='1')
			{
			  	$nresul=buscatercero($_POST[tercero]);
			  	if($nresul!='')
			   	{
			  		$_POST[ntercero]=$nresul;
			  	}
			 	else
			 	{
			  		$_POST[ntercero]="";
			  	}
			}
			if($_POST[buscav]=='1')
 			{
	 			$_POST[dcuentas]=array();
	 			$_POST[dncuentas]=array();
	 			$_POST[dtcuentas]=array();		 
	 			$_POST[dvalores]=array();

	 			$linkbd=conectar_bd();
	 			$sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." ";
	 			//echo "s:$sqlr";
	 			$res=mysql_query($sqlr,$linkbd);
	 			while($row=mysql_fetch_row($res))
	  			{
					$_POST[catastral]=$row[0];
					$_POST[propietario]=$row[6];
					$_POST[documento]=$row[5];
					$_POST[direccion]=$row[7];
					$_POST[ha]=$row[8];
					$_POST[mt2]=$row[9];
					$_POST[areac]=$row[10];
					$_POST[avaluo]=number_format($row[11],2);
					$_POST[codigo]=$row[15];
					$_POST[tipop]=$row[15];
					$_POST[nestrato]=$row[16];
					if($_POST[tipop]=='urbano'){$_POST[estrato]=$row[16];}
					else{$_POST[rangos]=$row[16];}
					$_POST[dtcuentas][]=$row[1];		 
					$_POST[dvalores][]=$row[5];
					$_POST[buscav]="";
					$_POST[vigencia]=$row[12];
	  			}
	  	 		// echo "dc:".$_POST[dcuentas];
  			}
			?>
    		<table class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="6">.: Prescripci&oacute;n Predios</td><td width="72" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      			</tr>     
	  			<tr> <td  class="saludo1" style="width:10%;">C&oacute;digo Catastral:</td>
          			<td ><input name="tesorero" type="hidden" value="<?php echo $_POST[tesorero] ?>">
		  			<input id="codcat" type="text" name="codcat" style="width:82%;"onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();"> <a href="#" onClick="mypop=window.open('catastral-ventana2.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a><input type="hidden" value="0" name="bt"> <input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto"> </td>
					<td>
						<input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav"><input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar()" >
					</td>
        		</tr>
        		<tr>
					<td class="saludo1">No Prescripci&oacute;n:</td>
					<td style="width:12%;">
						<input name="idpres" type="text" id="idpres"  onClick="document.getElementById('idpres').focus();document.getElementById('idpres').select();" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[idpres]?>" readonly >
					</td>
					<td class="saludo1" style="width:10%;">No Resoluci&oacute;n:</td>
					<td style="width:10%;">
						<input name="nresol" type="text" id="nresol"  onClick="document.getElementById('nresol').focus();document.getElementById('nresol').select();" onKeyUp="return tabular(event,this)" style="width:100%;" value="<?php echo $_POST[nresol]?>"></td>
					<td class="saludo1">Fecha: </td>
        			<td ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY"> <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a> </td>
				</tr>
	  		</table>
	  		<table class="inicio">
				<tr>
					<td class="titulos" colspan="8">Informaci&oacute;n Predio</td>
				</tr>
				<tr>
					<td width="119" class="saludo1">C&oacute;digo Catastral:</td>
					<td width="202" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="catastral" type="text" id="catastral" onBlur="buscater(event)" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>" size="20" readonly></td>
				
					<td width="82" class="saludo1">Avaluo:</td>
					<td colspan="5"><input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" size="20" readonly>
					</td>
				</tr>
      			<tr>	    
		 			<td width="82" class="saludo1">Documento:</td>         
	  				<td><input name="documento" type="text" id="documento" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[documento]?>" size="20" readonly>
	  				</td>
      				<td width="119" class="saludo1">Propietario:</td>
	  				<td width="202" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="propietario" type="text" id="propietario" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[propietario]?>" size="40" readonly></td>
      			</tr>
      			<tr>
	  				<td width="119" class="saludo1">Direcci&oacute;n:</td>
	  				<td width="202" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" size="40" readonly></td>
		 			<td width="82" class="saludo1">Ha:</td>
	  				<td ><input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" size="6" readonly>
	  				</td>
	  				<td  class="saludo1">Mt2:</td>
	  				<td width="144"><input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" size="6" readonly></td>
	  				<td class="saludo1">Area Cons:</td>
	  				<td width="206"><input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" size="6" readonly></td>
      			</tr>
	  			<tr>
	     			<td width="119" class="saludo1">Tipo:</td><td width="202">
						<select name="tipop" onChange="validar();" id="tipop" >
							<option value="">Seleccione ...</option>
							<?php
								$ano=date("Y");
								$linkbd=conectar_bd();
								$sql="SELECT codigo,nombre FROM teso_clasificapredios WHERE vigencia='$ano' GROUP BY codigo,nombre";
								$result=mysql_query($sql,$linkbd);
								while($row = mysql_fetch_array($result))
								{
									if($row[0]==$_POST[tipop])
									{
										echo "<option value='$row[0]' SELECTED >$row[1]</option>";
									}
									else
									{
										echo "<option value='$row[0]'>$row[1]</option>";
									}
								}
							?>
						</select>
						<input type="hidden" name='codigo' id="codigo" value="<?php echo $_POST[codigo]; ?>" />
					</td>
        		</tr> 
      		</table>
      		<div class="subpantallac4">
	   			<table  class="inicio" style="width:45%" >
					<tr>
						<td colspan="12" class="titulos">Periodos a Prescribir</td>
					</tr> 
					<tr>
						<td colspan="12" class="saludo1">No A&ntilde;os despues de la Vigencia para Prescripciones: <input name="agespre" type="text" size="2" value="<?php echo $_POST[agespre]?>" readonly> - Antes de: <input name="agepar" type="text" size="4" value="<?php echo $_POST[agepar]?>" readonly></td>
					</tr>                   
					<tr>
						<td class="titulos2">Vigencia</td><td class="titulos2">Avaluo</td><td class="titulos2"> - </td>
					</tr>          
					<?php
					$sqlr="Select *from tesoprediosavaluos,tesopredios where tesoprediosavaluos.codigocatastral=$_POST[codcat] and   tesoprediosavaluos.estado='S' and tesoprediosavaluos.vigencia<='$_POST[agepar]' and tesoprediosavaluos.pago='N' and tesoprediosavaluos.codigocatastral=tesopredios.cedulacatastral and tesopredios.vigencia='$vigusu' and tesopredios.ord='001' order by tesoprediosavaluos.vigencia ASC ";		
					$res=mysql_query($sqlr,$linkbd);
					$cuentavigencias = mysql_num_rows($res);
					$cv=0;
					while($r=mysql_fetch_row($res))
					{
						echo "<tr><td class='saludo1'><input name='vigencias[]' type='text' value='$r[0]' size='4' readonly></td><td class='saludo1'><input name='avaluos[]' type='text' value='".number_format($r[2],0)."' readonly><input name='avaluosh[]' type='hidden' value='".$r[2]."' ></td><td class='saludo1'><input type='checkbox' name='dselvigencias[]' value='$r[0]' onClick='buscavigencias(this)' $chk></td></tr>";
					}
					?>			
       			</table>
       		</div>
   		</form>
	</table>
</body>
</html>