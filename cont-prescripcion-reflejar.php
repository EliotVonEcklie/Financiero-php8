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
<title>:: SPID - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script src="css/programas.js"></script>
		<script src="css/calendario.js"></script>
<script language="JavaScript1.2">
function validar()
{
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

function atrasc(id){
	var id=document.form2.idpres.value-1;
	if (id!=0) {
		document.form2.action="cont-prescripcion-reflejar.php?idpres="+id;
		document.form2.submit();
	}
}

function adelente(){
	var id=parseFloat(document.form2.idpres.value)+1;
	if (id<=document.form2.maximo.value){
		document.form2.action="cont-prescripcion-reflejar.php?idpres="+id;
		document.form2.submit();
	}

}
function guardar()
{

if (document.form2.fecha.value!='' && document.form2.tercero.value!='' && document.form2.banco.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
function guardar(){
	if (document.form2.idpres.value!='' && document.form2.codcat.value!=''){
		if (confirm("Esta Seguro de Guardar"))
		{
			document.form2.oculto.value=2;
			document.form2.submit();
		}
	}
	else{
		alert('Faltan datos para completar el registro');
		document.form2.idpres.focus();
		document.form2.codcat.select();
	}	
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
			<a href="" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a> 
			<a href="teso-buscaprescripcion-reflejar.php" onClick="'" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
			<a href="#" class="mgbt" onClick="guardar()"><img src="imagenes/reflejar1.png" title="Reflejar" style="width:24px;" /></a>
			<a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" title="Imprimir" /></a> 
			<a href="cont-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>		  
</table>
	<tr>
		<td colspan="3" class="tablaprin" align="center"> 
<?php
	$vigencia=date(Y);
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	$vigencia=$vigusu;
?>	
   
<?php
	$linkbd=conectar_bd();
	$idpred=$_GET[idpres];
	
	if($idpred==''){
		$sqlr="SELECT max(id) from tesoprescripciones";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_fetch_row($resp);
		$idpred=$ntr[0];
	}
	// echo $idpred;
	//$_POST[codcat]=$_GET[idpredial];
	$_POST[idpres]=$idpred;
	$_POST[dcuentas]=array();
	$_POST[dncuentas]=array();
	$_POST[dtcuentas]=array();		 
	$_POST[dvalores]=array();

	 

	 $sqlr="SELECT max(id) from tesoprescripciones";
	 $res=mysql_query($sqlr,$linkbd);
	 $row=mysql_fetch_row($res);
	 $_POST[maximo]=$row[0];

	 $sqlr="select *from tesoprescripciones where id=".$_POST[idpres]." ";
	 $res=mysql_query($sqlr,$linkbd);
	 $row=mysql_fetch_row($res);
	 //echo "s:$sqlr";
	 
	 $_POST[idpres]=$row[0];
	 $_POST[fecha]=$row[1];
	 $_POST[nresol]=$row[2];
	 $_POST[codcat]=$row[3];
	 $sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." ";
	 //echo "s:$sqlr";
	 $res=mysql_query($sqlr,$linkbd);
	 while($row=mysql_fetch_row($res))
	  {
		  //$_POST[vigencia]=$row[0];
		  $_POST[catastral]=$row[0];
		  $_POST[propietario]=$row[6];
		  $_POST[documento]=$row[5];
		  $_POST[direccion]=$row[7];
		  $_POST[ha]=$row[8];
		  $_POST[mt2]=$row[9];
		  $_POST[areac]=$row[10];
		  $_POST[avaluo]=number_format($row[11],2);
		  $_POST[tipop]=$row[14];
		  if($_POST[tipop]=='urbano')
			$_POST[estrato]=$row[15];
			else
			$_POST[rangos]=$row[15];
				// $_POST[dcuentas][]=$_POST[estrato];		
		 $_POST[dtcuentas][]=$row[1];		 
		 $_POST[dvalores][]=$row[5];
		 $_POST[buscav]="";
	  }
	  
	
?>

<form  name="form2" method="post" action="">
<input type="hidden" name="maximo" value="<?php echo $_POST[maximo] ?>" >
	<table class="inicio" align="center" >
		<tr >
			<td class="titulos" colspan="6">.: Prescripcion Predial</td><td width="72" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
		</tr>     
		<tr> 
			<td class="saludo1">No Prescripcion:</td>
			<td style="width:12%;">
				<a href="#" onclick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
				<input style="width:65%;" name="idpres" type="text" id="idpres"  onClick="document.getElementById('idpres').focus();document.getElementById('idpres').select();" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[idpres]?>" readonly >
				<a href="#" onclick="adelente()"><img src="imagenes/next.png" alt="anterior" align="absmiddle"></a>
			</td>
			<td  class="saludo1" style="width:10%;">C&oacute;digo Catastral:</td>
			<td >
				<input name="tesorero" type="hidden" value="<?php echo $_POST[tesorero] ?>">
				<input id="codcat" type="text" name="codcat" style="width:18%;"onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" readonly> 
				
				<input type="hidden" value="0" name="bt"> <input type="hidden" name="chacuerdo" value="1">
				<input type="hidden" value="1" name="oculto" id="oculto"> 
			</td>
		</tr>
        <tr>
			<td class="saludo1" style="width:10%;">No Resoluci&oacute;n:</td>
			<td style="width:10%;">
				<input name="nresol" type="text" id="nresol"  onClick="document.getElementById('nresol').focus();document.getElementById('nresol').select();" onKeyUp="return tabular(event,this)" style="width:100%;" value="<?php echo $_POST[nresol]?>" readonly></td>
			<td class="saludo1">Fecha: </td>
			<td >
				<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly> 
				   
			</td>
		</tr>
	</table>
	<table class="inicio">
		<tr>
			<td class="titulos" colspan="8">Informaci&oacute;n Predio</td>
		</tr>
		<tr>
			<td width="119" class="saludo1">C&oacute;digo Catastral:</td>
			<td width="202" >
				<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
				<input name="catastral" type="text" id="catastral" onBlur="buscater(event)" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>" size="20" readonly>
			</td>
			<td width="82" class="saludo1">Avaluo:</td>
			<td colspan="5">
				<input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" size="20" readonly>
			</td>
		</tr>
		<tr>	    
			<td width="82" class="saludo1">Documento:</td>         
			<td>
				<input name="documento" type="text" id="documento" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[documento]?>" size="20" readonly>
			</td>
			<td width="119" class="saludo1">Propietario:</td>
			<td width="202" >
				<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
				<input name="propietario" type="text" id="propietario" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[propietario]?>" size="40" readonly>
			</td>
		</tr>
		<tr>
			<td width="119" class="saludo1">Direcci&oacute;n:</td>
			<td width="202" >
				<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
				<input type="hidden" value="<?php echo $_POST[tercero]?>" name="tercero" id="tercero"> 
				<input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" size="40" readonly>
			</td>
			<td width="82" class="saludo1">Ha:</td>
			<td >
				<input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" size="6" readonly>
			</td>
			<td  class="saludo1">Mt2:</td>
			<td width="144">
				<input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" size="6" readonly>
			</td>
			<td class="saludo1">Area Cons:</td>
			<td width="206"><input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" size="6" readonly></td>
		</tr>
		<tr>
			<td width="119" class="saludo1">Tipo:</td>
			<td width="202">
				<input type="hidden" value="<?php echo $_POST[tipopn]?>" name="tipopn" id="tipopn">
				<select name="tipop" onChange="validar();" disabled>
					<option value="">Seleccione ...</option>
					<option value="urbano" <?php if($_POST[tipop]=='urbano') echo "SELECTED" ?>>Urbano</option>
					<option value="rural" <?php if($_POST[tipop]=='rural') echo "SELECTED" ?>>Rural</option>
				</select>
			</td>
			<?php
				if($_POST[tipop]=='urbano')
				{
					$_POST[tipopn]='2';
			?> 
			<td class="saludo1">Estratos:</td><td>
				<select name="estrato" disabled>
					<option value="">Seleccione ...</option>
					<?php
						$linkbd=conectar_bd();
						$sqlr="select *from estratos where estado='S'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							echo "<option value=$row[0] ";
							$i=$row[0];
							if($i==$_POST[estrato])
							{
								echo "SELECTED";
								$_POST[nestrato]=$row[1];
							}
							echo ">".$row[1]."</option>";	 	 
						}	 	
					?>            
				</select>  
				<input type="hidden" value="<?php echo $_POST[nestrato]?>" name="nestrato">
			</td>  
			<?php
				}
				else
				{
					$_POST[tipopn]='1';
			?>  
			<td class="saludo1">Rango Avaluo:</td>
			<td>
				<select name="rangos" disabled>
					<option value="">Seleccione ...</option>
					<?php
						$linkbd=conectar_bd();
						$sqlr="select *from rangoavaluos where estado='S'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							echo "<option value=$row[0] ";
							$i=$row[0];
							if($i==$_POST[rangos])
							{
								echo "SELECTED";
								$_POST[nrango]=$row[1]." - ".$row[2]." SMMLV";
							}
							echo ">Entre ".$row[1]." - ".$row[2]." SMMLV</option>";	 	 
						}	 	
					?>            
				</select>
				<input type="hidden" value="<?php echo $_POST[nrango]?>" name="nrango">            
				<input type="hidden" value="0" name="agregadet">
			</td>
			<?php
				}
			?> 
		</tr> 
	</table>
    <div class="subpantallac4">
		<table  class="inicio" >
			<tr>
				<td colspan="12" class="titulos">.: Detalles</td>
			</tr> 
			<tr>
				<td class="titulos2">Vigencia</td>
				<td class="titulos2">Avaluo</td>
				

				</tr>          
				<?php
					$sqlr="Select * from tesoprescripciones_det where id=$_POST[idpres]";
					// echo $sqlr;
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{
					
					$sqlrAvaluo="SELECT avaluo from tesoprediosavaluos where codigocatastral=$_POST[codcat] AND vigencia='$r[1]'";
					$resAvaluo=mysql_query($sqlrAvaluo,$linkbd);
					$rowAvaluo=mysql_fetch_row($resAvaluo);
					echo "<tr>
							<td class='saludo1'>
								<input type='hidden' name='pvigencias[]' id='pvigencias[]' value='".$r[1]."'>
								$r[1]
							</td>
							<td class='saludo1'>
							<input type='hidden' name='pavaluo[]' id='pavaluo[]' value='".$rowAvaluo[0]."'>
								".number_format($rowAvaluo[0],2)."
							</td>
						</tr>";
					}
				?>		
				<?php
				if($_POST[oculto]=='2')
				{
					$linkbd=conectar_bd();	
					//preg_match("/([0-9]{2})/([0-9]{2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$_POST[fecha];
					$nid=$_POST[idpres];
					$sql="DELETE FROM comprobante_cab WHERE numerotipo='$_POST[idpres]' AND  tipo_comp='18' ";
					mysql_query($sql,$linkbd);
					$sql="DELETE FROM comprobante_det WHERE id_comp='18 $_POST[idpres]'";
					mysql_query($sql,$linkbd);
					$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($nid,18,'$fechaf','PRESCRIPCION PREDIAL COD CAT: $_POST[catastral]',0,0,0,0,'1')";
					//echo $sqlr;
					mysql_query($sqlr,$linkbd);
					
					if($_POST[tipop]=='urbano'){$esra=$_POST[estrato];}
					else{$esra=$_POST[rangos];}

					$tam=count($_POST[pvigencias]);
					//************** modificacion del presupuesto **************
					for($x=0;$x<$tam;$x++)
					{
						echo "<input name='pvigencias[]' type='hidden' value='".$_POST[pvigencias][$x]."'>"; 
						echo "<input name='pavaluo[]' type='hidden' value='".$_POST[pavaluo][$x]."'>"; 		  
						$vig= $_POST[pvigencias][$x];
						
						//*********COMPROBANTE CONTABLE - CONFIGURACIONES CONTABLES ******
						//	$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$_POST[tipopn]' and estratos=$esra";
						$sqlr2="select IF(tasa='-1',0,tasa) from tesoprediosavaluos where vigencia='".$_POST[pvigencias][$x]."' and codigocatastral='".$_POST[catastral]."' "; 
						$res2=mysql_query($sqlr2,$linkbd);
						$row2=mysql_fetch_row($res2);
						$base=$_POST[pavaluo][$x];
						$predial=$base*($row2[0]/1000);
						
						$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and concepto='03' order by concepto";
						$res3=mysql_query($sqlr2,$linkbd);
						$r3=mysql_fetch_row($res3);
						$bomberil=ceil($predial*($r3[5]/100));
						
						$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and concepto='02' order by concepto";
						$res3=mysql_query($sqlr2,$linkbd);
						$r3=mysql_fetch_row($res3);
						$ambiental=ceil($predial*($r3[5]/100));
						//*** conceptos contables ***
						//***BOMBERIL
						$sq="select fechainicial from conceptoscontables_det where codigo='01' and modulo='4' and tipo='PR' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
						$re=mysql_query($sq,$linkbd);
						while($ro=mysql_fetch_assoc($re))
						{
							$_POST[fechacausa]=$ro["fechainicial"];
						}
						$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='02' and tipo='PR' and fechainicial='".$_POST[fechacausa]."'";
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
						$sq="select fechainicial from conceptoscontables_det where codigo='01' and modulo='4' and tipo='PR' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
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
						echo "<script>
							despliegamodalm('visible','1','Vigencia Exonerada con Exito $vig ');
							document.form2.vguardar.value='1';
						</script>";
						?>
						<script>
							document.form2.tercero.value="";
							document.form2.ntercero.value="";
						</script>
						<?php	  
					}
				}
			  ?>
		</table>
    </div>
	
</form>
</table>
</body>
</html>