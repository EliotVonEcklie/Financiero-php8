<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID- Tesoreria</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }

//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }

function generar()
 {
 document.form2.oculto.value='1';
 document.form2.submit();
 }

function validar()
{

document.form2.submit();
}

function buscarp(e)
 {
if (document.form2.rp.value!="")
{
 document.form2.brp.value='1';
 document.form2.submit();
 }
 }

function agregardetalle()
{
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}

function agregardetalled()
{
if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
{ 
				document.form2.agregadetdes.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}

function eliminar(variable)
{
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}

function eliminard(variable)
{
document.form2.eliminad.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('eliminad');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}

//************* genera reporte ************
//***************************************
function guardar()
{
	if (document.form2.fecha.value!='' && document.form2.cc.value!=''  && document.form2.tipop.value!='' && document.form2.tercero.value!='')
	{
		// if (confirm("Esta Seguro de Guardar"))
		// {
		// document.form2.oculto.value=2;
		// document.form2.submit();
		// }
		despliegamodalm('visible','4','Esta Seguro de Guardar','2');
	}
	else
	{
	  // alert('Faltan datos para completar el registro');
		// document.form2.fecha.focus();
		// document.form2.fecha.select();
		despliegamodalm('visible','2','Faltan datos para completar el registro');
	}
}

function calcularpago()
 {
	//alert("dddadadad");
	valorp=document.form2.valor.value;
	descuentos=document.form2.totaldes.value;
	valorc=valorp-descuentos;
	document.form2.valorcheque.value=valorc;
	document.form2.valoregreso.value=valorp;
	document.form2.valorretencion.value=descuentos;
	
 }

function agregardetalled()
{
if(document.form2.retencion.value!="" )
{ 
				document.form2.agregadetdes.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Seleccione una retencion");
 }
}

function eliminard(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.eliminad.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('eliminad');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}

function pdf()
{
document.form2.action="pdfpagotercerosvigant.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
function despliegamodal2(_valor,scr)
{
	//alert("Hola"+scr);
	if(scr=="1"){
		var url="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
	}
	if(scr=="2"){
		var url="cuentasbancarias-ventana02.php?tipoc=C&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
	}
	if(scr=="3"){
		var url="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=cc";
	}
	document.getElementById("bgventanamodal2").style.visibility=_valor;
	if(_valor=="hidden")
	{
		document.getElementById('ventana2').src="";
	}
	else 
	{
		document.getElementById('ventana2').src=url;
	}
}
function despliegamodalm(_valor,_tip,mensa,pregunta)
{
	document.getElementById("bgventanamodalm").style.visibility=_valor;
	if(_valor=="hidden")
	{
		document.getElementById('ventanam').src="";
		switch(document.getElementById('valfocus').value)
		{
			case "1":	document.getElementById('valfocus').value='';
						document.getElementById('tercero').focus();
						document.getElementById('tercero').select();
						break;
			case "2":	document.getElementById('valfocus').value='';
						document.getElementById('banco').value='';
						document.getElementById('banco').focus();
						document.getElementById('banco').select();
		}
	}
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
function funcionmensaje()
{
	var numdocar=document.getElementById('idcomp').value;
	document.location.href = "teso-editapagoterceros.php?idpago="+numdocar;
}
function respuestaconsulta(pregunta)
{
	switch(pregunta)
	{
		case "1":	document.form2.oculto.value='3';
					document.form2.submit();
					break;
		case "2":	document.form2.oculto.value='2';
					document.form2.submit();
					break;
	}
}
</script>
<script src="css/calendario.js"></script><script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
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
			<a href="teso-pagoterceros-vigant.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> 
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a>
			<a href="teso-buscapagoterceros-vigant.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> 
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>  
			
		</td>
	</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 $_POST[vigencia]=$vigusu; 	
 $vigencia=$vigusu;
 ?>	
<?php
$linkbd=conectar_bd();
 $sqlr="select max(id_pago) from tesopagotercerosvigant";
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		  $consec=$r[0];	  
	 	}
	 	$consec+=1;
	 	$_POST[idcomp]=$consec;	
	  //*********** cuenta origen va al credito y la destino al debito
if(!$_POST[oculto])
{
	$linkbd=conectar_bd();
	$sqlr="select *from cuentapagar where estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentapagar]=$row[1];
	}
		$check1="checked";
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 		 		  			 
		//$_POST[valor]=0;
		//$_POST[valorcheque]=0;
		//$_POST[valorretencion]=0;
		//$_POST[valoregreso]=0;
		//$_POST[totaldes]=0;
		 $_POST[vigencia]=$vigusu; 		
		 $sqlr="select max(id_pago) from tesopagotercerosvigant";
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		  $consec=$r[0];	  
	 	}
	 	$consec+=1;
	 	$_POST[idcomp]=$consec;		 
}
switch($_POST[tabgroup1])
{
case 1:
$check1='checked';
break;
case 2:
$check2='checked';
break;
case 3:
$check3='checked';
}
?>
<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 <form name="form2" method="post" action=""> 
 <?php
 $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
 ?>

 	<div class="container">
 		<table class="inicio" align="center" >
       		<tr>
	     		<td style="width:95%;" colspan="2" class="titulos">Otros Egresos</td>
	     		<td style="width:5%;" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
	    	</tr>
	    	<tr>
	    		<td style="width:80%;">
	    			<table>
	    				<tr > 
				       		<td  class="saludo1" style="width:15%;">Numero Pago:</td>
				       		<td style="width:10%;">	
				       			<input name="idcomp" type="text" style="width:100%;" value="<?php echo $_POST[idcomp]?>" readonly>
				       		</td>
							<td  style="width:1cm;" class="saludo1">Fecha: </td>
				        	<td style="width:7%">
				        		<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:30%" title="DD/MM/YYYY">   
				        		<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>     
				        	</td>
				        	<td style="width:10%;"  class="saludo1">Vigencia: </td>
				        	<td style="width:15%;">
				        		<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" size="5" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> 
				        	</td>
				       	</tr>
				       	<tr>
				       		<td class="saludo1">Forma de Pago:</td>
				       		<td style="width:15%;">
				       			<select name="tipop" onChange="validar();" style="width:100%;">
				       				<option value="">Seleccione ...</option>
								  	<option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
				  				  	<option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
								</select>
				          	</td>
				        </tr>
				         <?php 
						  //**** if del cheques
						  if($_POST[tipop]=='cheque')
						    {
						  ?>    
				        <!--<tr>
					  		<td class="saludo1">Cuenta Bancaria:</td>
					  		<td style="width:14%;">
					     		<select id="banco" style="width:100%;" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
					      			<option value="">Seleccione....</option>
									  // <?php
										// $linkbd=conectar_bd();
										// $sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
										// $res=mysql_query($sqlr,$linkbd);
										// while ($row =mysql_fetch_row($res)) 
													    // {
														// echo "<option value=$row[1] ";
														// $i=$row[1];
														 // if($i==$_POST[banco])
												 			// {
															 // echo "SELECTED";
															 // $_POST[nbanco]=$row[4];
															  // $_POST[ter]=$row[5];
															 // $_POST[cb]=$row[2];
															 // }
														  // echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
														// }	 	
										// ?>
				            	</select> -->
									<?php 
									echo "<tr>
					  				<td class='saludo1'>Cuenta :</td>
				                    <td style='width:20%;'>
				                    	<input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%;'/>&nbsp;
				                    	<a onClick=\"despliegamodal2('visible','2');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'>	
				                    		<img src='imagenes/find02.png' style='width:20px;'/>
				                    	</a>
				                    </td>
				                    <td colspan='2'>
				        					<input type='text' id='nbanco' name='nbanco' style='width:100%;' value='$_POST[nbanco]'  readonly>
				      				</td>
									<td class='saludo1'>Cheque:</td>
									<td>
										<input type='text' id='ncheque' name='ncheque' value='$_POST[ncheque]' style='width:100%;'>
									</td>
										<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
										<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/>
									</tr>";
									
									$sqlr="select count(*) from tesochequeras where banco=$_POST[ter] and cuentabancaria='$_POST[cb]' and estado='S' ";
									$res2=mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($res2);
									// if($row2[0]<=0 && $_POST[oculto]!='')
									  // {
									   // echo "<script>alert('No existe una chequera activa para esta Cuenta');document.form2.banco.value=''; document.form2.banco.focus();</script>";
									  // $_POST[nbanco]="";
									  // $_POST[ncheque]="";
									  // }
									  // else
									   // {
									    // $sqlr="select * from tesochequeras where banco=$_POST[ter] and cuentabancaria='$_POST[cb]' and estado='S' ";
										// $res2=mysql_query($sqlr,$linkbd);
										// $row2 =mysql_fetch_row($res2);
									   // //$_POST[ncheque]=$row2[6];
									   
									   // }
									 ?>
								<!--<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
								<input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
							</td>
							<td colspan="2">
								<input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="50" readonly>
							</td>
							<td  class="saludo1" style="width:6%;">Cheque:</td>
							<td  style="width:8%;">
								<input style="width:100%;" type="text" id="ncheque" name="ncheque" value="<?php echo $_POST[ncheque]?>"  >
							</td>-->
					  	</tr>
					      <?php
							if($_POST[cb]!=''){
									
								}	
						     }//cierre del if de cheques
					      ?> 
					       <?php 
						  //**** if del transferencias
						  if($_POST[tipop]=='transferencia')
						    {
								echo "<tr>
					  				<td class='saludo1'>Cuenta :</td>
				                    <td style='width:20%;'>
				                    	<input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%;'/>&nbsp;
				                    	<a onClick=\"despliegamodal2('visible','1');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'>	
				                    		<img src='imagenes/find02.png' style='width:20px;'/>
				                    	</a>
				                    </td>
				                    <td colspan='2'>
				        					<input type='text' id='nbanco' name='nbanco' style='width:100%;' value='$_POST[nbanco]'  readonly>
				      				<td class='saludo1'>No Transferencia:</td>
									<td >
										<input type='text' id='ntransfe' name='ntransfe' value='$_POST[ntransfe]' style='width:100%;'>
									</td>
										<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
										<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/>
									</tr>";
						  ?> 
					    <!--<tr>
						  	<td class="saludo1">Cuenta Bancaria:</td>
						  	<td >
						     	<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
						      		<option value="">Seleccione....</option>
							  		// <?php
										// $linkbd=conectar_bd();
										// $sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
										// $res=mysql_query($sqlr,$linkbd);
										// while ($row =mysql_fetch_row($res)) 
									    // {
											// echo "<option value=$row[1] ";
											// $i=$row[1];
										 	// if($i==$_POST[banco])
								 			// {
											 	// echo "SELECTED";
											 	// $_POST[nbanco]=$row[4];
											  	// $_POST[ter]=$row[5];
											 	// $_POST[cb]=$row[2];
											// }
										  	// echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
										// }	 	
									// ?>
				            	</select> -->
								<?php 
								/*	$sqlr="select count(*) from tesochequeras where banco=$_POST[ter] and cuentabancaria=$_POST[cb] and estado='S' ";
									$res2=mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($res2);
									if($row2[0]<=0 && $_POST[oculto]!='')
									  {
									   echo "<script>alert('No existe una chequera activa para esta Cuenta');document.form2.banco.value=''; document.form2.banco.focus();</script>";
									  $_POST[nbanco]="";
									  $_POST[ncheque]="";
									  }
									  else
									   {
									    $sqlr="select * from tesochequeras where banco=$_POST[ter] and cuentabancaria='$_POST[cb]' and estado='S' ";
										$res2=mysql_query($sqlr,$linkbd);
										$row2 =mysql_fetch_row($res2);
									   //$_POST[ncheque]=$row2[6];			   
									   }*/
									 ?>
								<!--<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
								<input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
							</td>
							<td colspan="2">
								<input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="50" readonly>
							</td>
							<td class="saludo1">No Transferencia:</td>
							<td style="width:8%;">
								<input type="text" style="width:100%;" id="ntransfe" name="ntransfe" value="<?php echo $_POST[ntransfe]?>">
							</td>-->
					  	</tr>
				      <?php
					     }//cierre del if de cheques
				      ?> 
						<tr> 
				      		<td  class="saludo1" >Tercero:</td>
				          	<td   >
								<input id="tercero" type="text" name="tercero" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" >
								<a onClick="despliegamodal2('visible','3');"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"></a>
				          		
				          	</a>
				        </td>
						<td colspan="2">
						   	<input name="ntercero" type="text" id="ntercero" value="<?php echo $_POST[ntercero]?>" size="70" readonly>
							<input type="hidden" value="0" name="bt">
						</td>
						<td class="saludo1" style="width:8%;">Centro Costo:</td>
						<td colspan="2">
							<select name="cc" style="width:100%;" onChange="validar()" onKeyUp="return tabular(event,this)">
								<option value="">Seleccione ...</option>
								  <?php
								  $linkbd=conectar_bd();
								  $sqlr="select *from centrocosto where estado='S'";
								  $res=mysql_query($sqlr,$linkbd);
								  while ($row =mysql_fetch_row($res)) 
												  {
												  echo "<option value=$row[0] ";
												  $i=$row[0];
									  
												   if($i==$_POST[cc])
													  {
													   echo "SELECTED";
													   }
													echo ">".$row[0]." - ".$row[1]."</option>";	 	 
												  }	 	
								  ?>
							</select>
					 	</td>
					</tr>
				    <tr>
				    	<td class="saludo1">Concepto</td>
				        <td colspan="3">
				        	<input type="hidden" value="<?php echo "1"?>" name="oculto">
				        	<input type="text" name="concepto" value="<?php echo $_POST[concepto]?>" style="width:100%;">
				        </td> 
				        <td class="saludo1" style="width:8%;">Valor a Pagar:</td>
				        <td colspan="2">
				        	<input name="valorpagar" style="width:100%;" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valorpagar]?>" size="20" readonly>
				        </td>
				    </tr>
				    <tr> 
				    	<td class="saludo1">Retenciones e Ingresos:</td>
						<td colspan="3">
							<select name="retencion"  style="width:100%;" onChange="validar()" onKeyUp="return tabular(event,this)">
								<option value="">Seleccione ...</option>
								<?php
								//PARA LA PARTE CONTABLE SE TOMA DEL DETALLE DE LA PARAMETRIZACION LAS CUENTAS QUE INICIAN EN 2**********************

								$linkbd=conectar_bd();
								$sqlr="select *from tesoretenciones where estado='S' and terceros='1'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
											    {
												echo "<option value='R-$row[0]' ";
												$i=$row[0];
									
												 if('R-'.$i==$_POST[retencion])
										 			{
													 echo "SELECTED";
													  $_POST[nretencion]='R - '.$row[1]." - ".$row[2];
													 }
												  echo ">R - ".$row[1]." - ".$row[2]."</option>";	 	 
												}	 	
								$sqlr="select *from tesoingresos where estado='S' and terceros!=''";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
											    {
												echo "<option value='I-$row[0]' ";
												$i=$row[0];
									
												 if('I-'.$i==$_POST[retencion])
										 			{
													 echo "SELECTED";
													  $_POST[nretencion]='I - '.$row[0]." - ".$row[1];
													 }
												  echo ">I - ".$row[0]." - ".$row[1]."</option>";	 	 
												}	 	
								?>
				   			</select>
						</td>
						<td class="saludo1" style="width:8%;">Valor:</td>
						<td style="width:8%;">
							<input name="valor" style="width:100%;" type="text" id="valor" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valor]?>" >
						</td> 
						<td style="width:10%;">
							<input  type="hidden" value="<?php echo $_POST[nretencion]?>" name="nretencion">
							<input type="button" name="agregard" id="agregard" value="   Agregar   " onClick="agregardetalled()" style="width:100%;">
							<input type="hidden" value="0" name="agregadetdes">
						</td>  
					</tr>
	    			</table>
	    		</td>
	    		<td colspan="3" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td> 
	    	</tr>	
    </table>
      <div class="subpantallac6" style="width:99.6%; height:52%; overflow-x:hidden;">
      	<table class="inicio" style="overflow:scroll">
       <?php 	
		if ($_POST[eliminad]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[eliminad];
		 unset($_POST[dcontable][$posi]); 
		 unset($_POST[ddescuentos][$posi]);
		  unset($_POST[dtdescuentos][$posi]);
		 unset($_POST[dndescuentos][$posi]);
		  unset($_POST[dfvalores][$posi]);
		 unset($_POST[dvalores][$posi]);
		 $_POST[dcontable]= array_values($_POST[dcontable]); 		 
		 $_POST[dtdescuentos]= array_values($_POST[dtdescuentos]); 		 
		 $_POST[ddescuentos]= array_values($_POST[ddescuentos]); 
		 $_POST[dndescuentos]= array_values($_POST[dndescuentos]); 
		  $_POST[dfvalores]= array_values($_POST[dfvalores]); 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 
		 }	 
		 if ($_POST[agregadetdes]=='1')
		 {
		 $_POST[dtdescuentos][]=substr($_POST[retencion],0,1);
		 $_POST[ddescuentos][]=$_POST[retencion];
		 $_POST[dndescuentos][]=$_POST[nretencion];
		 $_POST[dvalores][]=$_POST[valor];
		 $_POST[dfvalores][]=number_format($_POST[valor],2);
		 $_POST[agregadetdes]='0';
		 ?>
		 <script>
        document.form2.porcentaje.value=0;
        document.form2.vporcentaje.value=0;	
		document.form2.retencion.value='';
		document.form2.valor.value='';			
        </script>
		<?php
		 }
		  ?>
        <tr><td class="titulos">Retenciones e Ingresos</td><td class="titulos">Contable</td><td class="titulos">Valor</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='eliminad' id='eliminad'></td></tr>
      	<?php
	$totalpagar=0;
//		echo "v:".$_POST[valor];
		$linkbd=conectar_bd();
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		for ($x=0;$x<count($_POST[ddescuentos]);$x++)
		 {		 
		 $tm=strlen($_POST[ddescuentos][$x]);
 		 if(substr($_POST[ddescuentos][$x],0,1)=='R')
		  {
		 $sqlr="select *from tesoretenciones_det where codigo='".substr($_POST[ddescuentos][$x],2,$tm-2)."' ";
		  $res2=mysql_query($sqlr,$linkbd);	
		//  echo $sqlr;
		  //$row2 =mysql_fetch_row($res2);
		   while($row2=mysql_fetch_row($res2))
		   {
				$rest=substr($row2[6],-2);
				$sq="select fechainicial from conceptoscontables_det where codigo='$row2[4]' and modulo='$row2[5]' and tipo='$rest' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
				$re=mysql_query($sq,$linkbd);
				while($ro=mysql_fetch_assoc($re))
				{
					$_POST[fechacausa]=$ro["fechainicial"];
				}
				$sqlr="select * from conceptoscontables_det where codigo='$row2[4]' and modulo='$row2[5]' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";
				$rst=mysql_query($sqlr,$linkbd);
				$row1=mysql_fetch_assoc($rst);
				if(substr($row1['cuenta'],0,1)==2)
				{ 
					//$vpor=$row2[4];
					$vcont=$row1['cuenta'];
				}
			}
		  }
		  //************
		if(substr($_POST[ddescuentos][$x],0,1)=='I')
		{
			$sqlr="select *from  tesoingresos_det where codigo='".substr($_POST[ddescuentos][$x],2,$tm-2)."'  and vigencia=$vigusu ";
			$res2=mysql_query($sqlr,$linkbd);	
			// echo "<br>$row[0] - ".$sqlr;
			while($row2 =mysql_fetch_row($res2))
			{
				$sq="select fechainicial from conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and 	cuenta!='' order by fechainicial asc";
				$re=mysql_query($sq,$linkbd);
				while($ro=mysql_fetch_assoc($re))
				{
					$_POST[fechacausa]=$ro["fechainicial"];
				}
				$sqlr="select *from  conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
				$res3=mysql_query($sqlr,$linkbd);	
				//echo "<br>$row2[1] - ".$sqlr;
				while($row3 =mysql_fetch_row($res3))
				{
					if(substr($row3[4],0,1)=='2')
					{
						$vpor=$row2[5];
						//$_POST[dtdescuentos][]='I';
						//$_POST[dvalores][]=$row[1]*($vpor/100);
						//$_POST[dfvalores][]=$row[1]*($vpor/100);		   
						//$_POST[ddescuentos][]=$row[0];
						$vcont=$row3[4];
						//$_POST[dndescuentos][]=buscaingreso($row[0]);
						//$totalpagar+=$row[1]*($vpor/100);		   
						//$nv=buscaingreso($row[0]);
						// echo "ing:$row3[4]";
					}
				}
			}
		}
		//**********
		 echo "<tr><td class='saludo2'><input name='dtdescuentos[]' value='".$_POST[dtdescuentos][$x]."' type='hidden'><input name='dndescuentos[]' value='".$_POST[dndescuentos][$x]."' type='text' size='100' readonly><input name='ddescuentos[]' value='".$_POST[ddescuentos][$x]."' type='hidden'></td><td class='saludo2'><input name='dcontable[]' value='".$vcont."' type='text' size='20' readonly></td><td class='saludo2'><input name='dfvalores[]' value='".$_POST[dfvalores][$x]."' type='text' size='20' readonly><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden'></td>";		
		 echo "<td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";	
		  $totalpagar+=$_POST[dvalores][$x];	
		 }		 
		$_POST[valorretencion]=$totaldes;

		?>
        <?php
        $resultado = convertir($totalpagar);
		$_POST[letras]=$resultado." PESOS M/CTE";
		 echo "<tr><td></td><td>Total:</td><td class='saludo2'><input type='hidden' name='totalpago2' value='$totalpagar' ><input type='text' name='totalpago' value='".number_format($totalpagar,2)."' size='20' readonly></td></tr>";
		 echo "<tr><td colspan='3'><input name='letras' type='text' value='$_POST[letras]' size='150' ></td>";
		?>
        <script>
       document.form2.valorpagar.value=<?php echo $totalpagar;?>;	
        </script>
        </table>
      </div>
 	
	   
       
     <?php	  
	//  echo "oculto".$_POST[oculto];
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	
	$sqlr="update tesocheques set estado='P', destino='OTROS_EGRESOS', idcomp='$_POST[idcomp]' where cuentabancaria='$_POST[cb]' and cheque='$_POST[ncheque]'";
	mysql_query($sqlr,$linkbd);
	
	//**verificacion de guardado anteriormente *****
	
	$sqlr="select count(*) from tesopagotercerosvigant where id_pago=$_POST[idcomp] ";
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		while($r=mysql_fetch_row($res))
		 {
			$numerorecaudos=$r[0];
		 }
	if($numerorecaudos==0)
	 {	
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
//************CREACION DEL COMPROBANTE CONTABLE ************************
$sqlr="insert into tesopagotercerosvigant (`id_pago`, `tercero`, `banco`, `cheque`, `transferencia`, `valor`, `mes`, `concepto`, `cc`, `estado`,fecha) values ($_POST[idcomp],'$_POST[tercero]','$_POST[banco]', '$_POST[ncheque]','$_POST[ntransfe]',$totalpagar,'$_POST[mes]' , '$_POST[concepto]','$_POST[cc]','S','$fechaf')";
	mysql_query($sqlr,$linkbd);
	//echo "$sqlr <br>";	
//***busca el consecutivo del comprobante contable
$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($_POST[idcomp] ,15,'$fechaf','$_POST[concepto]',0,$totalpagar,$totalpagar,0,'1')";
	mysql_query($sqlr,$linkbd);
	//echo "<br>C:".count($_POST[mddescuentos]);
	for ($x=0;$x<count($_POST[ddescuentos]);$x++)
	 {		
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('15 $_POST[idcomp]','".$_POST[dcontable][$x]."','".$_POST[tercero]."','".$_POST[cc]."','OTROS EGRESOS MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
		//	echo "$sqlr <br>";
			mysql_query($sqlr,$linkbd);  
		  
		 //*** Cuenta BANCO **
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('15 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
			mysql_query($sqlr,$linkbd);
		//	echo "$sqlr <br>";	
			
			$sqlr="insert into tesopagotercerosvigant_det(`id_pago`, `movimiento`, `tipo`, `valor`, `cuenta`, `estado`) values ($_POST[idcomp],'".substr($_POST[ddescuentos][$x],2,$tm-2)."','".$_POST[dtdescuentos][$x]."',".$_POST[dvalores][$x].",'".$_POST[dcontable][$x]."','S')";
			mysql_query($sqlr,$linkbd);					  
				//	echo "$sqlr <br>";	
	  }
	   echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recaudo a Terceros con Exito <img src='imagenes/confirm.png'><script>pdf()</script></center></td></tr></table>";
	 }//*** if de guardado
	 else
	  {
		echo "<table class='inicio'><tr><td class='saludo1'><center><img src='imagenes/alert.png'>Ya Se ha almacenado un documento con ese consecutivo</center></td></tr></table>";  
	  }		
}
?>	
</div>
<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>	
</form>

 </td></tr>  
</table>
</body>
</html>	 