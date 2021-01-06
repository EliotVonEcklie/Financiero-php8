<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
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
</script>
<script>
function buscaop(e)
 {
if (document.form2.orden.value!="")
{
 document.form2.bop.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
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
</script>
<script>
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
</script>
<script>
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
</script>
<script>
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
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.fecha.value!='')
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
</script>
<script>
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
</script>
<script>
function pdf()
{
document.form2.action="pdfegresonomina.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script language="JavaScript1.2">
function adelante()
{

//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.egreso.value=parseFloat(document.form2.egreso.value)+1;
document.form2.action="teso-pagonominaver-regrabar.php";
document.form2.submit();
}
else
{
	  // alert("Balance Descuadrado"+parseFloat(document.form2.maximo.value));
	}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{

//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {

document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.egreso.value=document.form2.egreso.value-1;
document.form2.action="teso-pagonominaver-regrabar.php";
document.form2.submit();
 }
}
</script>
<script language="JavaScript1.2">
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.egreso.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="teso-pagonominaver-regrabar.php";
document.form2.submit();
}
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />

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
  <td colspan="3" class="cinta"><a href="teso-pagonomina.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#"  onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscapagonomina.php"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>  <a href="#" onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a><a href="teso-actualizardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
		$linkbd=conectar_bd();
	$sqlr="select *from cuentapagar where estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentapagar]=$row[1];
	}
		$sqlr="select sueldo, cajacompensacion,icbf,sena,iti,esap,arp,salud_empleador,salud_empleado,pension_empleador,pension_empleado,sub_alimentacion,aux_transporte,prima_navidad  from humparametrosliquida ";
		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{					 
					 $_POST[salmin]=$row[0];
					 $_POST[tprimanav]=$row[13];
					 $_POST[cajacomp]=$row[1];
					 $_POST[icbf]=$row[2];
					 $_POST[sena]=$row[3];
					 $_POST[iti]=$row[4];
					 $_POST[esap]=$row[5];					 					 					 					 					 		 			
					 $_POST[arp]=$row[6];					 					 					 					 					 		 			
					 $_POST[salud_empleador]=$row[7];		
					 $_POST[salud_empleado]=$row[8];
					 $_POST[pension_empleador]=$row[9];
					 $_POST[pension_empleado]=$row[10];
					 $_POST[auxtran]=$row[12];
					 $_POST[auxalim]=$row[11];					 
					 }
 ?>	
<?php
//echo "ov:".$_POST[oculto];
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$sqlr="select count(*) from tesoegresosnomina where id_egreso=$_POST[egreso] and estado ='S'";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
$row=mysql_fetch_row($res);
		  //***********crear el contabilidad
		  $ideg=$_POST[egreso];
		  $sqlr="delete from comprobante_cab where numerotipo=$ideg and tipo_comp=17";
		   mysql_query($sqlr,$linkbd);
		  $sqlr="delete from comprobante_det where id_comp='17 $ideg' ";
		   mysql_query($sqlr,$linkbd);
//************CREACION DEL COMPROBANTE CONTABLE ************************
$sqlr="select count(*) from tesoegresosnomina where id_egreso=$_POST[egreso] and estado ='S'";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
$row=mysql_fetch_row($res);
$nreg=$row[0];
	if ($nreg>=0)
	 {
	 $sqlr="Select count(*) from  humnomina_prima where id_nom=$_POST[orden]";
		$resp=mysql_query($sqlr,$linkbd);
		$row=mysql_fetch_row($resp);
		$prima=$row[0];
		 	//$ideg=mysql_insert_id();
				//$_POST[egreso]=$ideg;
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Egreso con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";		 
		 // $sqlr="update tesoegresosnominachequeras set consecutivo=consecutivo+1 where cuentabancaria='$_POST[cb]'  and estado='S'";	  
		//   echo $sqlr;
		  //mysql_query($sqlr,$linkbd);		  
		  $sqlr="insert into tesoegresosnomina_cheque (id_cheque,id_egreso,estado,motivo) values ('$_POST[ncheque]',$ideg,'S','')";
		  mysql_query($sqlr,$linkbd);
		 // $sqlr="delete from pptorecibopagoegresoppto where idrecibo=$ideg and vigencia='".$vigusu."'";
		//		 mysql_query($sqlr,$linkbd);				 
	//	  echo $sqlr;
		  //$sqlr="update tesoordenpago set estado='P' where id_orden=$_POST[orden] and estado='S'";
	//	  echo $sqlr;
		  //mysql_query($sqlr,$linkbd);		  
		  //*****hacer la afectacion presupuestal
		  //$sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] ";
			//	$resp2 = mysql_query($sqlr,$linkbd);
				//while($row2=mysql_fetch_row($resp2))
	
		  //***********crear el contabilidad
		  	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values 		($ideg,17,'$fechaf','$_POST[concepto]',0,$_POST[valorpagar],$_POST[valorpagar],0,'1')";
			 mysql_query($sqlr,$linkbd);
				$idcomp=mysql_insert_id();
			//echo $sqlr;
				//$sqlr="update tesoegresosnomina set id_comp=$idcomp where id_egreso=$ideg ";			 			 
			// mysql_query($sqlr,$linkbd);
		 // $sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] ";
			//	$resp2 = mysql_query($sqlr,$linkbd);
				//while($row2=mysql_fetch_row($resp2))
				for($y=0;$y<count($_POST[tedet]);$y++)				
				 {					
//********************** TIPO N NOMINA **************************************
					if($_POST[tedet][$y]=='N')
					 { 					 
					//*** BUSCAR NOMINA
						$vnom=0;
						$vauxali=0;
						$vauxtra=0;	
						
					if($prima==1)
					{
					 $vauxali=0;
					 $vauxtra=0;
					}
					else
					{	
					$sqlrnom="Select auxalim, auxtran from humnomina_det where id_nom=$_POST[orden] and cedulanit='".$_POST[decuentas][$y]."' ";
					$resn = mysql_query($sqlrnom,$linkbd);
					//echo "<br>".$_POST[decuentas][$y]."  $sqlrnom";
					while($rown=mysql_fetch_row($resn))
					{
						$vauxali=$rown[0];
						$vauxtra=$rown[1];						
					//	echo "<br>  $sqlrnom";
					}
					}					
					$vnom=$_POST[devalores][$y]-$vauxali-$vauxtra;
									
					if($vnom>0)
					 {
					//$parametro=buscaparanom($_POST[salmin]); 				 
					if($prima==1)
					{
					//echo "primaSI:$prima";	
					 $concepto=buscapptovarnom($_POST[tprimanav], $_POST[tedet][$y],$vigusu); 					 			  
					}
					else
					{
				 	$concepto=buscapptovarnom($_POST[salmin], $_POST[tedet][$y],$vigusu); 					 			  
					}
					$sqlr="select * from conceptoscontables_det where codigo='$concepto' and modulo='2' and cc='".$_POST[deccs][$y]."' and tipo='H'";	  
					$resc = mysql_query($sqlr,$linkbd);
					//echo "<br>".$_POST[tedet][$y]."  $sqlr";
					while($rowc=mysql_fetch_row($resc))
					{
					 if($rowc[3]=='N')
					   {
					   if($rowc[7]=='S')
					   {
						$ncppto=buscacuentapres($_POST[decuentas][$y],2);
	 					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$rowc[4]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago ".$ncppto."','',".$vnom.",0,'1' ,'".$vigusu."')";
						mysql_query($sqlr,$linkbd);
					 //echo "<br>".$sqlr;
//***************************
						if($rowc[3]=='N')
						   {
								$valorp=$_POST[devalores][$y];
								//***buscar retenciones
							//	echo "<br>c:".count($_POST[ddescuentos]);																
							 //INCLUYE EL CHEQUE
	 						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$vnom.",'1' ,'".$vigusu."')";					
							mysql_query($sqlr,$linkbd);
						//echo "<br>".$sqlr;
						   }	
						}
//*************************
						}
						}
					 }	
						//*****aux alimentacion
					//	echo "<br>subalim:  $vauxali";
					if($vauxali>0)
					 {				 
					//$parametro=buscaparanom($_POST[auxali]); 				 
				 	$concepto=buscapptovarnom($_POST[auxalim], $_POST[tedet][$y],$vigusu); 					 			  
					$sqlr="select * from conceptoscontables_det where codigo='$concepto' and modulo='2' and cc='".$_POST[deccs][$y]."' and tipo='H'";	  
					$resc = mysql_query($sqlr,$linkbd);
					//	echo "<br>".$_POST[tedet][$y]."  $sqlr";
					while($rowc=mysql_fetch_row($resc))
					{
					 if($rowc[3]=='N')
					   {
					   if($rowc[7]=='S')
					   {
						$ncppto=buscacuentapres($_POST[decuentas][$y],2);
	 					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$rowc[4]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago ".$ncppto."','',".$vauxali.",0,'1' ,'".$vigusu."')";
						mysql_query($sqlr,$linkbd);
					// echo "<br>".$sqlr;
//***************************
						if($rowc[3]=='N')
						   {
								$valorp=$_POST[devalores][$y];
								//***buscar retenciones
							//	echo "<br>c:".count($_POST[ddescuentos]);																
							 //INCLUYE EL CHEQUE
	 						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$vauxali.",'1' ,'".$vigusu."')";					
							mysql_query($sqlr,$linkbd);
						//echo "<br>".$sqlr;
						   }	
						}
//*************************
						}
						}
					   }	
						//******aux trans
					if($vauxtra>0)
					 {				 
					//$parametro=buscaparanom($_POST[auxtran]); 				 					 
				 	$concepto=buscapptovarnom($_POST[auxtran], $_POST[tedet][$y],$vigusu); 					 			  					
					$sqlr="select * from conceptoscontables_det where codigo='$concepto' and modulo='2' and cc='".$_POST[deccs][$y]."' and tipo='H'";	  
					$resc = mysql_query($sqlr,$linkbd);
				//		echo "<br>".$_POST[tedet][$y]."  $sqlr";
						while($rowc=mysql_fetch_row($resc))
						{
					 	if($rowc[3]=='N')
					   	 {
					   	if($rowc[7]=='S')
					  	 	{
							$ncppto=buscacuentapres($_POST[decuentas][$y],2);
	 						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$rowc[4]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago ".$ncppto."','',".$auxtra.",0,'1' ,'".$vigusu."')";
							mysql_query($sqlr,$linkbd);
					// echo "<br>".$sqlr;
//***************************
							 if($rowc[3]=='N')
						   	  {
								$valorp=$_POST[devalores][$y];
								//***buscar retenciones
							//	echo "<br>c:".count($_POST[ddescuentos]);																
							 //INCLUYE EL CHEQUE
	 						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$auxtra.",'1' ,'".$vigusu."')";					
							mysql_query($sqlr,$linkbd);
						//echo "<br>".$sqlr;
						       }	
						     }
						  }
					     }																 
					   }	  
			 }//**********fin de tipo N nomina					
					  if($_POST[tedet][$y]=='SR')
						 { 
					
					  	 $codigo=buscapptovarnom($_POST[derecursos][$y], $_POST[tedet][$y],$vigusu); 	
						 $sqlr="select concepto from humparafiscales,humparafiscales_det where humparafiscales.codigo='$_POST[salud_empleador]' and humparafiscales.codigo=humparafiscales_det.codigo and humparafiscales_det.cc='".$_POST[deccs][$y]."'  AND humparafiscales_det.VIGENCIA='$vigusu'";
						 $respr=mysql_query($sqlr,$linkbd);
						 $rowc=mysql_fetch_row($respr);
						 $concepto=$rowc[0];
				//echo "<br>$sqlr";		
					  	 $cuentas=concepto_cuentas($concepto,'H',2,$_POST[deccs][$y]);								
						 $tam=count($cuentas);
						  for ($zt=0;$zt<$tam;$zt++) 
  							{						
							  $ctacont=$cuentas[$zt][0];	 
							 if('S'==$cuentas[$zt][3])
				  				{
								$debito=$valorlibranza;
								$credito=0;
								$ncppto=buscacuentapres($_POST[decuentas][$y],2);
	 							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$ctacont."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Salud Empleador".$ncppto."','',".$_POST[devalores][$y].",0,'1' ,'".$vigusu."')";
								mysql_query($sqlr,$linkbd);
				  //echo "<br>".$sqlr;
								 }
						 	 if('S'==$cuentas[$zt][2])
						   		{
								$valorp=$_POST[devalores][$y];
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$valorp.",'1' ,'".$vigusu."')";					
								mysql_query($sqlr,$linkbd);
								}				 				 						
				//echo "<br>$sqlr";
							}					 					   
				    		$sqlr="update `humnomina_saludpension` set estado='P' WHERE id='".$_POST[idedescuento][$y]."' and id_nom='$_POST[orden]'";
						 //$respr=mysql_query($sqlr,$linkbd);
						  }//***fin if SE O PE
					 
					 
					 if($_POST[tedet][$y]=='SE')
					 { 
					 //   $sqlr="SELECT `id_retencion` FROM `humparafiscales` WHERE CODIGO='08' ";
					 //$respr=mysql_query($sqlr,$linkbd);					 
					 //$rret=mysql_fetch_row($respr);
					 //$codigo=buscaparanom('salud_empleado');
				  	 $codigo=buscapptovarnom($_POST[derecursos][$y], $_POST[tedet][$y],$vigusu); 	
					 $sqlr="select concepto from humparafiscales,humparafiscales_det where humparafiscales.codigo='$_POST[salud_empleado]' and humparafiscales.codigo=humparafiscales_det.codigo and humparafiscales_det.cc='".$_POST[deccs][$y]."'  AND humparafiscales_det.VIGENCIA='$vigusu'";
					 $respr=mysql_query($sqlr,$linkbd);
					 $rowc=mysql_fetch_row($respr);
					 $concepto=$rowc[0];
				//echo "<br>$sqlr";					
				$sqlr="select * from conceptoscontables_det where codigo='$concepto' and modulo='2' and cc='".$_POST[deccs][$y]."' and tipo='H'";	  
				$respc = mysql_query($sqlr,$linkbd);
				while ($rowr=mysql_fetch_row($respc)) 
					{						
					  $ctacont=$rowr[4];	 
					 if('S'==$rowr[7])
				  		{
						$debito=$valorlibranza;
						$credito=0;
						$ncppto=buscacuentapres($_POST[decuentas][$y],2);
	 					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$rowr[4]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Salud Empleado".$ncppto."','',".$_POST[devalores][$y].",0,'1' ,'".$vigusu."')";
					mysql_query($sqlr,$linkbd);
				 // echo "<br>".$sqlret;
						 }
				 	 if('S'==$rowr[6])
				   		{
						$valorp=$_POST[devalores][$y];
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$valorp.",'1' ,'".$vigusu."')";					
						mysql_query($sqlr,$linkbd);
						}				 				 						
				//echo "<br>$sqlr";
					}					 					   
				    $sqlr="update `humnomina_saludpension` set estado='P' WHERE id='".$_POST[idedescuento][$y]."' and id_nom='$_POST[orden]'";
					 //$respr=mysql_query($sqlr,$linkbd);
					 }//***fin if SE O PE
					 //idedescuento  
					 if($_POST[tedet][$y]=='PE')
					 { 
					 //$sqlr="SELECT `id_retencion` FROM `humparafiscales` WHERE CODIGO='08' ";
					 //$respr=mysql_query($sqlr,$linkbd);					 
					 //$rret=mysql_fetch_row($respr);
					// $sqlr="select distinct *from humparafiscales,humparafiscales_det where humparafiscales.codigo='10' and humparafiscales.codigo=humparafiscales_det.codigo and humparafiscales_det.cc='".$_POST[deccs][$y]."' and humparafiscales_det.vigencia='$vigusu'";
					// $respr=mysql_query($sqlr,$linkbd);					 
					 $codigo=buscaparanom('pension_empleado');
					 $sqlr="select concepto from humparafiscales,humparafiscales_det where humparafiscales.codigo='$_POST[pension_empleado]' and humparafiscales.codigo=humparafiscales_det.codigo and humparafiscales_det.cc='".$_POST[deccs][$y]."'  AND humparafiscales_det.VIGENCIA='$vigusu'";
					 $respr=mysql_query($sqlr,$linkbd);
					 $rowc=mysql_fetch_row($respr);
					 $concepto=$rowc[0];
					 $sqlr="select * from conceptoscontables_det where codigo='$concepto' and modulo='2' and cc='".$_POST[deccs][$y]."' and tipo='H'";	
					 $respc = mysql_query($sqlr,$linkbd);
				while ($rowr=mysql_fetch_row($respc)) 
					{						
					  $ctacont=$rowr[4];	 
					 if('S'==$rowr[7])
				  		{
						$debito=$valorlibranza;
						$credito=0;
						$ncppto=buscacuentapres($_POST[decuentas][$y],2);
	 					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$rowr[4]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Pension Empleado".$ncppto."','',".$_POST[devalores][$y].",0,'1' ,'".$vigusu."')";
						mysql_query($sqlr,$linkbd);
				 // echo "<br>".$sqlret;
						 }
				 	 if('S'==$rowr[6])
				   		{
							$valorp=$_POST[devalores][$y];
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$valorp.",'1' ,'".$vigusu."')";					
							mysql_query($sqlr,$linkbd);
						}				 				 						
				//echo "<br>$sqlr";
					 }
					 $sqlr="update `humnomina_saludpension` set estado='P' WHERE id='".$_POST[idedescuento][$y]."' and id_nom='$_POST[orden]'";	
					}				 					   
					
					
					if($_POST[tedet][$y]=='F')
					 { 
					 //$sqlr="SELECT `id_retencion` FROM `humparafiscales` WHERE CODIGO='08' ";
					 //$respr=mysql_query($sqlr,$linkbd);					 
					 //$rret=mysql_fetch_row($respr);
					// $sqlr="select distinct *from humparafiscales,humparafiscales_det where humparafiscales.codigo='10' and humparafiscales.codigo=humparafiscales_det.codigo and humparafiscales_det.cc='".$_POST[deccs][$y]."' and humparafiscales_det.vigencia='$vigusu'";
					// $respr=mysql_query($sqlr,$linkbd);					 
					// $codigo=buscaparanom('pension_empleado');
					 $sqlr="select concepto from humparafiscales,humparafiscales_det where humparafiscales_det.cuentapres='".$_POST[derecursos][$y]."' and humparafiscales.codigo=humparafiscales_det.codigo and humparafiscales_det.cc='".$_POST[deccs][$y]."'  AND humparafiscales_det.VIGENCIA='$vigusu'";
					 $respr=mysql_query($sqlr,$linkbd);
					 $rowc=mysql_fetch_row($respr);
					 $concepto=$rowc[0];
					 $cuentas=concepto_cuentas($concepto,'H',2,$_POST[deccs][$y]);								
						 $tam=count($cuentas);
					  for ($zt=0;$zt<$tam;$zt++) 
  						{						
						  $ctacont=$cuentas[$zt][0];	 
						 if('S'==$cuentas[$zt][3])
				  		{
						$debito=$valorlibranza;
						$credito=0;
						$ncppto=buscacuentapres($_POST[derecursos][$y],2);
	 					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg', '".$ctacont."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago parafiscales".$ncppto."','',".$_POST[devalores][$y].",0,'1' ,'".$vigusu."')";
						mysql_query($sqlr,$linkbd);
				// echo "<br>".$sqlr;
						 }
				 	 if('S'==$cuentas[$zt][2])
				   		{
							$valorp=$_POST[devalores][$y];
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$valorp.",'1' ,'".$vigusu."')";					
							mysql_query($sqlr,$linkbd);
						}				 				 						
				//echo "<br>$sqlr";
					 }
					// $sqlr="update `humnomina_saludpension` set estado='P' WHERE id='".$_POST[idedescuento][$y]."' and id_nom='$_POST[orden]'";	
					}				 					   
					
					
					
					
					
				     
					 //$respr=mysql_query($sqlr,$linkbd);
					 // echo "(PRD ".$_POST[tedet][$y].")";	
					 if($_POST[tedet][$y]=='PR')
					 { 					
					 // echo "PRe ".$_POST[tedet][$y];		 
					 //$codigo=buscaparanom('pension_empleador');
					  $concepto=buscapptovarnom($_POST[pension_empleador],"PR",$vigusu);
					/* $sqlr="select concepto from humparafiscales,humparafiscales_det where humparafiscales.codigo='$codigo' and humparafiscales.codigo=humparafiscales_det.codigo and humparafiscales_det.cc='".$_POST[deccs][$y]."'  AND humparafiscales_det.VIGENCIA='$vigusu'";
					 $respr=mysql_query($sqlr,$linkbd);
					 $rowc=mysql_fetch_row($respr);
					 echo "<br>".$sqlr;
					 $concepto=$rowc[0];*/
					//  echo "<br>".$concepto;
					  $cuentas=concepto_cuentas($concepto,'H',2,$_POST[deccs][$y]);								
				$tam=count($cuentas);
				//echo "<br>tam:".$tam." Cta".$cuentas[0][0];
				for ($zt=0;$zt<$tam;$zt++) 
					{						
					  $ctacont=$cuentas[$zt][0];	 
					 if('S'==$cuentas[$zt][3])
				  		{
						$debito=$valorlibranza;
						$credito=0;
						$ncppto=buscacuentapres($_POST[decuentas][$y],2);
	 					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$ctacont."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Pension Empleador".$ncppto."','',".$_POST[devalores][$y].",0,'1' ,'".$vigusu."')";
						mysql_query($sqlr,$linkbd);
				 // echo "<br>".$sqlr;
						 }
				 	 if('S'==$cuentas[$zt][2])
				   		{
							$valorp=$_POST[devalores][$y];
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$valorp.",'1' ,'".$vigusu."')";					
							mysql_query($sqlr,$linkbd);
						}				 				 						
				//echo "<br>$sqlr";
					}					 					   
				     $sqlr="update `humnomina_saludpension` set estado='P' WHERE id='".$_POST[idedescuento][$y]."' and id_nom='$_POST[orden]'";					 					 					 }//***fin if SE O PE
					  if($_POST[tedet][$y]=='D') //***DESCUENTOS
					 {
					 $sqlr="SELECT `id_retencion` FROM `humretenempleados` WHERE `id`='".$_POST[idedescuento][$y]."'";
					 $respr=mysql_query($sqlr,$linkbd);					 
					 $rret=mysql_fetch_row($respr);
					 //$rret=$_POST[idedescuento][$y];
					 	//	echo "<br>$sqlr";
					 $sqlr="select distinct *from humvariablesretenciones,humvariablesretenciones_det where humvariablesretenciones.codigo='".$rret[0]."' and humvariablesretenciones.codigo=humvariablesretenciones_det.codigo  ";
					 $respr=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
				while ($rowr=mysql_fetch_row($respr)) 
					{						
					  $ctacont=$rowr[8];	 
					 if('S'==$rowr[10])
				  		{
						$debito=$valorlibranza;
						$credito=0;
						$ncppto=buscacuentapres($_POST[derecursos][$y],2);
	 					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$rowr[8]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago ".$ncppto."','',".$_POST[devalores][$y].",0,'1' ,'".$vigusu."')";
							mysql_query($sqlr,$linkbd);
				  //echo "<br>".$sqlr;
						 }
				 	 if('S'==$rowr[9])
				   		{
							$valorp=$_POST[devalores][$y];
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$_POST[deccs][$y]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$valorp.",'1' ,'".$vigusu."')";					
							mysql_query($sqlr,$linkbd);
						}				 				 						
				//echo "<br>$sqlr";
					}			
					
					$sqlr="update `humnominaretenemp` CASE WHEN valor<=0 THEN SET estado = 'P' END  WHERE `id`='".$_POST[decuentas][$y]."' and id_nom='$_POST[orden]'";
					 $respr=mysql_query($sqlr,$linkbd);		 					   
				    //$sqlr="update `humnominaretenemp` set estado='P' WHERE `id`='".$_POST[decuentas][$y]."' and id_nom='$_POST[orden]'";
					 //$respr=mysql_query($sqlr,$linkbd);
				   }
				 }//**FIN ELSE DESCUENTOS				 					 	 
 }
  else
   {
 	echo "<table class='inicio'><tr><td class='saludo1'><center>No se puede almacenar, ya existe un egreso para esta orden <img src='imagenes\alert.png'></center></td></tr></table>";
   }
}//************ FIN DE IF OCULTO************
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
$sqlr="select * from tesoegresosnomina ORDER BY id_EGRESO DESC";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
	 $_POST[ncomp]=$_POST[maximo];
	 $_POST[egreso]=$_POST[maximo];
		$check1="checked";
 		// $fec=date("d/m/Y");
		 //$_POST[fecha]=$fec; 		 		  			 
		//$_POST[valor]=0;
		//$_POST[valorcheque]=0;
		//$_POST[valorretencion]=0;
		//$_POST[valoregreso]=0;
		//$_POST[totaldes]=0;
}
		 $_POST[vigencia]=$vigusu; 		
		 
if($_POST[oculto]=='1' || !$_POST[oculto])
{		 
		 $sqlr="select * from tesoegresosnomina where id_egreso=$_POST[egreso]";
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		  $consec=$r[0];	  
		  $_POST[orden]=$r[2];
		  $_POST[estado]=$r[13];
		  $_POST[tipop]=$r[14];
		  $_POST[banco]=$r[9];
		  $_POST[ncheque]=$r[10];		  		  
			$_POST[cb]=$r[12];		  
		  $_POST[transferencia]=$r[12];
			$_POST[fecha]=$r[3];		  		  		  
	 	}
		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		$_POST[fecha]=$fechaf;
	 	$_POST[egreso]=$consec;		 
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

 <form name="form2" method="post" action=""> 
  <input id="cajacomp" name="cajacomp" type="hidden" value="<?php echo $_POST[cajacomp]?>" >
		<input id="icbf" name="icbf" type="hidden" value="<?php echo $_POST[icbf]?>" >
	    <input id="sena" name="sena" type="hidden" value="<?php echo $_POST[sena]?>" >
    	<input id="esap" name="esap" type="hidden" value="<?php echo $_POST[esap]?>" >
		<input id="iti" name="iti" type="hidden" value="<?php echo $_POST[iti]?>" >           
        <input id="arp" name="arp" type="hidden" value="<?php echo $_POST[arp]?>" >
        <input id="salud_empleador" name="salud_empleador" type="hidden" value="<?php echo $_POST[salud_empleador]?>" >
        <input id="salud_empleado" name="salud_empleado" type="hidden" value="<?php echo $_POST[salud_empleado]?>" >
        <input id="transp" name="transp" type="hidden" value="<?php echo $_POST[transp]?>" >
        <input id="pension_empleador" name="pension_empleador" type="hidden" value="<?php echo $_POST[pension_empleador]?>" >
        <input id="pension_empleado" name="pension_empleado" type="hidden" value="<?php echo $_POST[pension_empleado]?>" >		
		 <input id="salmin" name="salmin" type="hidden" value="<?php echo $_POST[salmin]?>" > 	
		  <input id="tprimanav" name="tprimanav" type="hidden" value="<?php echo $_POST[tprimanav]?>" > 
 <?php
				 if($_POST[orden]!='' )
				 {
			  //*** busca detalle cdp
			  $linkbd=conectar_bd();
  				$sqlr="select *from tesoegresosnomina where id_egreso=$_POST[ncomp] ";
				//echo $sqlr;
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[concepto]=$row[8];
				$_POST[tercero]=$row[11];
				$_POST[ntercero]=buscatercero($_POST[tercero]);
				$_POST[valororden]=$row[7];
				$_POST[retenciones]=0;
				$_POST[totaldes]=number_format($_POST[retenciones],2);
				$_POST[valorpagar]=$_POST[valororden]-$_POST[retenciones];
				$_POST[bop]="";
				
			  }
			 else
			 {
			  $_POST[cdp]="";
			  $_POST[detallecdp]="";
			  $_POST[tercero]="";
			  $_POST[ntercero]="";
			  $_POST[bop]="";
			  }
        ?>

	   <table class="inicio" align="center" >       
	   <tr>
	     <td colspan="8" class="titulos">Comprobante de Egreso Nomina</td><td width="74" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td></tr>
       <tr><td class="saludo1">No Egreso:</td><td><a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a><input name="cuentapagar" type="hidden" value="<?php echo $_POST[cuentapagar]?>" > <input name="egreso" type="text" value="<?php echo $_POST[egreso]?>" size="10" onKeyUp="return tabular(event,this)" onBlur="validar2()"  > <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"><a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"></td>
       	  <td class="saludo1">Fecha: </td>
        <td ><input id="fc_1198971545" name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">    <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>      </td>       
       <td class="saludo1">Forma de Pago:</td>
       <td>
       <select name="tipop" onChange="validar();" ="return tabular(event,this)">
       <option value="">Seleccione ...</option>
				  <option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
  				  <option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
				  </select>
          </td> 
          <td class="saludo1">Estado:</td> <td><input name="estado" type="text" value="<?php echo $_POST[estado]?>" size="5"  readonly ></td>      
       </tr>
<tr>  <td class="saludo1">No Orden Pago:</td>
	  <td ><input name="orden" type="text" value="<?php echo $_POST[orden]?>" size="10" onKeyUp="return tabular(event,this)" onBlur="buscaop(event)" readonly ><input type="hidden" value="0" name="bop">  </td>
      <td width="126" class="saludo1">Tercero:</td>
          <td width="144"  ><input id="tercero" type="text" name="tercero" size="20" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" readonly>
           </td><td colspan="2"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="70" readonly></td></tr>
<tr><td class="saludo1">Concepto:</td><td colspan="3"><input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" size="90" readonly></td></tr>           
      <?php 
	  //**** if del cheques
	  if($_POST[tipop]=='cheque')
	    {
	  ?>    
    <tr>
	  <td class="saludo1">Cuenta Bancaria:</td>
	  <td >
	     <select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      <option value="">Seleccione....</option>
		  <?php
	$linkbd=conectar_bd();
	$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S'  and tesobancosctas.tipo='Corriente' ";
	$res=mysql_query($sqlr,$linkbd);

	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[1] ";
					$i=$row[1];
					 if($i==$_POST[banco])
			 			{
						 echo "SELECTED";
						 $_POST[nbanco]=$row[4];
						  $_POST[ter]=$row[5];
						 $_POST[cb]=$row[2];
						 $_POST[tcta]=$row[3];
						 }
					  echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
					}	 	
	?>
            </select>
            <?php
				
		?>
		<input name="tcta" type="hidden" value="<?php echo $_POST[tcta]?>" ><input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" ></td><td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="50" readonly></td>
			<td class="saludo1">Cheque:</td><td ><input type="text" id="ncheque" name="ncheque" value="<?php echo $_POST[ncheque]?>" size="20" readonly></td>
	  </tr>
      <?php
	     }//cierre del if de cheques
      ?> 
       <?php 
	   
	  //**** if del transferencias
	  if($_POST[tipop]=='transferencia')
	    {
	  ?> 
      <tr>
	  <td class="saludo1">Cuenta Bancaria:</td>
	  <td >
	     <select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      <option value="">Seleccione....</option>
		  <?php
	$linkbd=conectar_bd();
	$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[1] ";
					$i=$row[1];
					 if($i==$_POST[banco])
			 			{
						 echo "SELECTED";
						 $_POST[nbanco]=$row[4];
						  $_POST[ter]=$row[5];
						 $_POST[cb]=$row[2];
						 $_POST[tcta]=$row[3];
						 }
					  echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
					}	 	
	?>
            </select>				
		<input name="tcta" type="hidden" value="<?php echo $_POST[tcta]?>" ><input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" ></td><td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="50" readonly></td>
			<td class="saludo1">No Transferencia:</td><td ><input type="text" id="ntransfe" name="ntransfe" value="<?php echo $_POST[ntransfe]?>" size="20" ></td>
	  </tr>
      <?php
	     }//cierre del if de cheques
      ?> 
	  <tr>
	  <td class="saludo1">Valor Orden:</td><td><input name="valororden" type="text" id="valororden" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valororden]?>" size="20" readonly></td>	  <td class="saludo1">Retenciones:</td><td><input name="retenciones" type="text" id="retenciones" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[retenciones]?>" size="20" readonly></td>	  <td class="saludo1">Valor a Pagar:</td><td><input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valorpagar]?>" size="20" readonly> <input type="hidden" value="1" name="oculto"></td></tr>	
      </table>
<div class="subpantallac4">
 <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Egreso Nomina</td></tr>                  
		<tr><td class="titulos2">No</td><td class="titulos2">Nit</td><td class="titulos2">Tercero</td><td class="titulos2">CC</td><td class="titulos2">Cta Presupuestal</td><td class="titulos2">Valor</td></tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		 unset($_POST[dccs][$posi]);
		 unset($_POST[dvalores][$posi]);		 
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dccs][]=$_POST[cc];
		 $_POST[agregadet]='0';
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.banco.value="";
				document.form2.nbanco.value="";
				document.form2.banco2.value="";
				document.form2.nbanco2.value="";
				document.form2.cb.value="";
				document.form2.cb2.value="";
				document.form2.valor.value="";	
				document.form2.numero.value="";	
				document.form2.agregadet.value="0";				
				document.form2.numero.select();
		  		document.form2.numero.focus();	
		 </script>
		  <?php
		  }
		  $_POST[totalc]=0;
		  $sqlr="select *from tesoegresosnomina_DET where id_egreso=$_POST[egreso] and estado='S'";
//				echo $sqlr;
				$dcuentas[]=array();
				$dncuentas[]=array();
				$resp2 = mysql_query($sqlr,$linkbd);
				$iter='zebra1';
				$iter2='zebra2';				
				while($row2=mysql_fetch_row($resp2))
				 {
				  //$_POST[dcuentas][]=$row2[2];
				  $nid=$row2[3];
				  $nombre=buscacuentapres($row2[6],2);
				  $tercero=buscatercero($row2[5]);
				  //$_POST[dvalores][]=$row2[4];				
		echo "<tr class='$iter'><td  ><input type='text' size='1' name='tedet[]' value='".$row2[3]."' readonly></td><td ><input name='decuentas[]' value='".$row2[5]."' type='text' size='20' readonly><input name='ddescuentos[]' value='".$_POST[ddescuentos][$jp]."' type='hidden'><input type='hidden' name='idedescuento[]' value='".$row2[10]."'></td>";
		 echo "<td ><input name='dencuentas[]' value='".$tercero.' '.$row2[5]."' type='text' size='90' readonly></td>";
		 echo "<td ><input name='deccs[]' value='".$row2[7]."' type='text' size='2' readonly></td>";
		 echo "<td ><input name='derecursos[]' value='".$row2[6]."' type='text' readonly></td>";
		 echo "<td ><input name='devalores[]' value='".$row2[8]."' type='text' size='15' readonly></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$row2[8];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 	 $aux=$iter;
			 $iter=$iter2;
			 $iter2=$aux;	
		 }
		$resultado = convertir($_POST[valorpagar]);
		$_POST[letras]=$resultado." PESOS M/CTE";
	    echo "<tr><td colspan='4'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' size='15' value='$_POST[totalcf]' readonly><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td  class='saludo1'>Son:</td> <td colspan='5' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' size='150'></td></tr>";
		?>
        <script>
        document.form2.valor.value=<?php echo $_POST[totalc];?>;
		//calcularpago();
        </script>
	   </table></div>	
        <?php
if($_POST[oculto]=='2')
{
	//$linkbd=conectar_bd();
 	//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	//$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
//************CREACION DEL COMPROBANTE CONTABLE ************************
//$sqlr="update  tesoegresos set fecha='$fechaf' where id_egreso=$_POST[egreso]";
//$res=mysql_query($sqlr,$linkbd);
//$sqlr="update  comprobante_cab set fecha='$fechaf' where 	numerotipo=$_POST[egreso] and tipo_comp=6";
//$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 