<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	  <meta http-equiv="Content-Type" content="text/html" />
	  <meta http-equiv="X-UA-Compatible" content="IE=9" />
	  <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
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
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
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
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.fechac.value!='')
  {
	despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  }
  else{
	despliegamodalm('visible','2','Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
function despliegamodal2(_valor)
		{
			document.getElementById("bgventanamodal2").style.visibility=_valor;
			if(_valor=="hidden"){document.getElementById('ventana2').src="";}
			else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
		}

		function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
		{
			document.getElementById("bgventanamodalm").style.visibility=_valor;
			if(_valor=="hidden"){document.getElementById('ventanam').src="";}
			else
			{
				switch(_tip)
				{
					case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
					case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
					case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
					case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
				}
			}
		}

		function respuestaconsulta(pregunta, variable)
		{
			switch(pregunta)
			{
				case "1":	document.getElementById('oculto').value="2";
							document.form2.submit();break;
				case "2":
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
					break;
			}
		}

		function funcionmensaje(){document.location.href = "teso-cierrecaja.php";}
</script>
<script>
function pdf()
{
document.form2.action="pdfcierrecaja.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script>
function recalculando()
 {
// alert('ssas');
  monedas=0;
  billetes=0;
  cheques=0;	 
  consignaciones=0;
  totalconteo=0;
  if (document.form2.monedas.value=='') {
    monedas=0;
  }else{
	monedas=document.form2.monedas.value;
  }
  if (document.form2.billetes.value=='') {
    billetes=0;
  }else{
	billetes=document.form2.billetes.value;
  }
  if (document.form2.consignaciones.value=='') {
    consignaciones=0;
  }else{
	consignaciones=document.form2.consignaciones.value;
  }
  if(document.form2.cheques.value==''){
	cheques=0;
  }else{
	cheques=document.form2.cheques.value;
  }
  totalconteo=parseFloat(monedas)+parseFloat(billetes)+parseFloat(cheques)+parseFloat(consignaciones);
  document.form2.totconteo.value=totalconteo;
 }
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
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
	  <a href="teso-cierrecaja.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"  border="0" /></a>
	  <a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
	  <a href="teso-cierrecajaver.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
	  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" Title="Nueva Ventana"></a>
	  <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  title="Imprimir" /></a></td>
</tr>		  
</table>
<tr>
<?php
$vigencia=date(Y);
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
	
	$fec=date("d/m/Y");
	$_POST[vigencia]=$vigencia;
	$linkbd=conectar_bd();
	$sqlr="select *from cuentacaja where estado='S' and vigencia=".$_SESSION["vigencia"];
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[1];
	}
	$sqlr="select count(fechacierre) from tesocierrecaja";
	
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];
		
	 }
	 $consec+=1;
	 $_POST[idcomp]=$consec;		
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 		 		  			 
		 $_POST[valor]=0;		 
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
    <table class="inicio" align="center" >
      	<tr >
        	<td style="width:95%;" class="titulos" colspan="2">Cierre de Caja</td>
        	<td style="width:5%;" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
      		<td>
      			<table>
      				<tr  >
						<td width="158"  class="saludo1" >No Cierre:</td>
						<td  >
							<input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  readonly>
						</td>
						<td width="105"   class="saludo1">Fecha:        </td>
						<td width="197" >
							<input name="fecha" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
						</td>
						<td width="121" class="saludo1">Vigencia:</td>
						<td width="87">
							<input type="text" id="vigencia" name="vigencia" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>      
						</td>
			        </tr>
			      	<tr>
						<td class="saludo1">Dia de Cierre:</td>
						<td width="142" >
						 	<input name="fechac" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechac]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         
						 	<a href="#" onClick="displayCalendarFor('fc_1198971545');">
						 		<img src="imagenes/buscarep.png" align="absmiddle" border="0">
						 	</a>
						</td>
						<td class="saludo1">Conteo Billetes:</td>
						<td>
							<input name="billetes" id="billetes" type="text" size="10"  value="<?php echo $_POST[billetes]?>" onKeyUp="return tabular(event,this) " onBlur="recalculando()">
						</td>
						<td class="saludo1">Conteo Monedas:</td>
						<td>
							<input name="monedas" id="monedas" type="text" size="10" value="<?php echo $_POST[monedas]?>" onKeyUp="return tabular(event,this) "  onBlur="recalculando()">
						</td>
					</tr>
				  	<tr>
						<td width="158" class="saludo1">Conteo Consignaciones:</td>
						<td width="142">
							<input name="consignaciones" id="consignaciones" type="text" size="10" value="<?php echo $_POST[consignaciones]?>" onKeyUp="return tabular(event,this) "  onBlur="recalculando()">
						</td>
						<td width="119" class="saludo1">Conteo Cheques:</td>
						<td width="113">
							<input name="cheques" id="cheques" type="text" size="10" value="<?php echo $_POST[cheques]?>" onKeyUp="return tabular(event,this) "  onBlur="recalculando()">
						</td>
						<td width="105" class="saludo1">Total Conteo:</td>
						<td width="110">
							<input name="totconteo" id="totconteo" type="text" size="10" value="<?php echo $_POST[totconteo]?>" onKeyUp="return tabular(event,this) " readonly  >
						</td>
						<td colspan="2">
							<input  type="button" name="agregact" value="Generar Resumen" onClick="document.form2.submit()">
							<input type="hidden" value="0" name="oculto" id="oculto">
						</td>
					</tr>
      			</table>
      		</td>
      		<td  colspan="2" style="width:25%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>  
      	</tr>
    </table>
<div class="subpantallac4">
   	<table class="inicio">
	   	  <tr>
   	      <td colspan="7" class="titulos">Detalle Cierre de Caja</td></tr>                  
		<tr>
		  <td class="titulos2">N�Recibo</td><td class='titulos2'>Fecha</td>
		  <td class='titulos2'>N�Liqui.</td><td class='titulos2'>Detalle</td>
		  <td class='titulos2'>Valor</td><td class='titulos2'>Tipo</td>
		  <td class='titulos2'>Forma de Pago</td></tr>
<?php
$oculto=$_POST['oculto'];
$linkbd=conectar_bd();
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
if($_POST[oculto]==0 && $_POST[fechac]!='')
{
$crit1=" ";
$crit2=" ";
if ($_POST[fechac]!="")
{
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechac],$fecha);
$fechab=$fecha[3]."-".$fecha[2]."-".$fecha[1];					
$crit1=" and tesoreciboscaja.fecha = '".$fechab."' ";
}
if ($_POST[nombre]!="")
{//$crit2=" and tesorecaudos.concepto like '%".$_POST[nombre]."%'  ";}
}
$cd=0;
 $cuentaefe=0;
 		 $cuentaban=0;
 		 $cuentaefep=0;
 		 $cuentabanp=0;
 		 $cuentaefeic=0;
 		 $cuentabanic=0;
 		 $cuentaefeor=0;
 		 $cuentabanor=0;
 		 $totalp=0;	
  		 $totalic=0;	
 		 $totalor=0;			 
 		 $totalr=0;
		 $vrec=0;	
//$cobrorc=array();
$cobrorc=buscaing_cobrorecibo($vigusu);
//echo "RC:".$cobrorc[0];
$detalles=array();
$iter='saludo1';
$iter2='saludo2';
	$sqlr="select tesosinreciboscaja.ID_RECIBOS, tesosinreciboscaja.FECHA, tesosinreciboscaja.ID_RECAUDO,tesosinreciboscaja_DET.INGRESO,tesosinreciboscaja_DET.VALOR, tesosinreciboscaja.RECAUDADO, tesosinrecaudos.CONCEPTO from tesosinreciboscaja, tesosinreciboscaja_det, tesosinrecaudos where tesosinrecaudos.ID_RECAUDO=tesosinreciboscaja.ID_RECAUDO AND  tesosinreciboscaja.id_recibos=tesosinreciboscaja_det.id_recibos and tesosinreciboscaja.estado='S' and tesosinreciboscaja.fecha = '".$fechab."' order by tesosinreciboscaja.id_recibos";
 //echo "<div><div>sqlr:".$sqlr."</div></div>";
	$resp = mysql_query($sqlr,$linkbd);
	$ntr = mysql_num_rows($resp);
	$ti="INGRESOS PROPIOS";
	while ($row =mysql_fetch_row($resp)) 
	 {
		echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[1]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[6]</td><td class='$iter'>".number_format($row[4],2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
		$detalles[$cd][0]=strtoupper($row[3]);
		$detalles[$cd][2]=$row[4];		
		$detalles[$cd][1]=buscaingreso($row[3]);
		$vrec+=$row[4];

		if('banco'==$row[5])
		 {
		 	$totalor+=$row[4];
	 		$cuentabanor+=$row[4];	
			$cuentaban+=$row[4];	   
		 }
		if('caja'==$row[5])
		 {
		 	$totalor+=$row[4];  
	 		$cuentaefeor+=$row[4];
			$cuentaefe+=$row[4];	   
	 	}		
		$cd+=1;		
	 }
	$totalr+=$vrec;
	$vrec=0;
	//echo $totalr;
	$sqlr="select tesoabono.id_abono, tesoabono.fecha, tesoabono.idacuerdo,tesoabono.valortotal,tesoabono.valortotal, tesoabono.concepto from tesoabono where tesoabono.fecha = '".$fechab."' order by tesoabono.id_abono";
	$resp = mysql_query($sqlr,$linkbd);
	$ntr = mysql_num_rows($resp);
	$ti="ABONOS";
	while ($row =mysql_fetch_row($resp)) 
	 {
		$caja="caja";
		echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[1]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[5]</td><td class='$iter'>".number_format($row[4],2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>Banco</td></tr>";
		$detalles[$cd][0]=strtoupper($row[3]);
		$detalles[$cd][2]=$row[4];		
		$detalles[$cd][1]=buscaingreso($row[3]);
		$vrec+=$row[4];

		/*if('banco'==$banco)
		 {
		 	$totalor+=$row[4];
	 		$cuentabanor+=$row[4];	
			$cuentaban+=$row[4];	   
		 }*/
		if('caja'==$caja)
		{
		 	$totalor+=$row[4];  
	 		$cuentaefeor+=$row[4];
			$cuentaefe+=$row[4];	   
	 	}		
		$cd+=1;		
	 }
	$totalr+=$vrec;
	$ti="";
	$sqlr="select MAX(id_recibos), MIN(id_recibos)from tesoreciboscaja where tesoreciboscaja.estado<>'' ".$crit1.$crit2." order by tesoreciboscaja.id_recibos";
	//echo $sqlr;
	$resp = mysql_query($sqlr,$linkbd);
	$row2 =mysql_fetch_row($resp);
	$_POST[inicial]=$row2[0];
	$_POST[inicial2]=$row2[1];	
	$sqlr="select *from tesoreciboscaja where tesoreciboscaja.estado='S' ".$crit1.$crit2." order by tesoreciboscaja.id_recibos";
// echo "<div><div>sqlr:".$sqlr."</div></div>";
	$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
 			 

$tipos=array('Predial','Industria y Comercio','Otros Recaudos');

//echo "<br>".$sqlr;
//$cd=0;
 while ($row =mysql_fetch_row($resp)) 
 {
	$ti="";
		 //**********discriminando los recibos
	 if('3'==$row[10])
	 {$sqlr2="Select *from tesoreciboscaja_det where tesoreciboscaja_det.id_recibos=$row[0]  ";
	 $ti='Otros Recaudos';
	// echo "<br>".$sqlr2;		
	//echo "   ".$row[0];
	  $res= mysql_query($sqlr2,$linkbd);
	 while ($row2 =mysql_fetch_row($res)) 
 		{					 
	 	echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>".buscaingreso($row2[2])."</td><td class='$iter'>".number_format($row2[3],2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
		$detalles[$cd][0]=strtoupper($row2[2]);
		$detalles[$cd][2]=$row2[3];		
		$detalles[$cd][1]=buscaingreso($row2[2]);
		$cd+=1;
		}			  
	 }
	  if('2'==$row[10])
	 	{
		 $ti='Industria y Comercio';
		 $ingrc=buscaingreso_recaudo($row[0], $cobrorc[0]);
		 if($ingrc[0]==$cobrorc[0] &&  $ingrc[1]>0)
		 {
			$detalles[$cd][0]=strtoupper($ingrc[0]);			 
			$detalles[$cd][2]=$ingrc[1];		
			$detalles[$cd][1]=buscaingreso($ingrc[0]); 
			echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>".buscaingreso($ingrc[0])."</td><td class='$iter'>".number_format($ingrc[1],2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
			$cd+=1;
		 }
		 $sqlr2="Select *from tesoingresos_det,tesoindustria_det  where '02'=tesoingresos_det.codigo and tesoindustria_det.id_industria=$row[4] and tesoingresos_det.vigencia=$vigusu";
		 $res= mysql_query($sqlr2,$linkbd);
	 while ($row2 =mysql_fetch_row($res)) 
 		{
		 if($row2[2]=='04')
		  {
			$nvdesc=$row2[10]-$row2[13]+$row2[14]+$row2[15];
			$detalles[$cd][0]='02-04';			 
			$detalles[$cd][2]=$nvdesc;		
			$detalles[$cd][1]="INDUSTRIA Y COMERCIO"; 
			$cd+=1;
			echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>INDUSTRIA Y COMERCIO $row2[8]</td><td class='$iter'>".number_format($nvdesc,2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
		  }
		  if($row2[2]=='05')
		  {
			 $nvdesc=$row2[11];
			 $detalles[$cd][0]='02-05';			 
			$detalles[$cd][2]=$nvdesc;		
			$detalles[$cd][1]="AVISOS Y TABLEROS"; 
			$cd+=1;
			echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>AVISOS Y TABLEROS $row2[8]</td><td class='$iter'>".number_format($nvdesc,2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
		  }
		  if($row2[2]=='06')
		  {
			 $nvdesc=$row2[12];
			 $detalles[$cd][0]='02-06';			 
			$detalles[$cd][2]=$nvdesc;		
			$detalles[$cd][1]="SOBRETASA BOMBERIL - ICA"; 
			$cd+=1;
			echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>SOBRETASA BOMBERIL - ICA $row2[8]</td><td class='$iter'>".number_format($nvdesc,2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
		  }
		}
	    }
	  if('1'==$row[10])
	 	{
		 $ti='Predial';
		 $ingrc=buscaingreso_recaudo($row[0], $cobrorc[0]);
		 if($ingrc[0]==$cobrorc[0] &&  $ingrc[1]>0)
		 {
			$detalles[$cd][0]=strtoupper($ingrc[0]);			 
			$detalles[$cd][2]=$ingrc[1];		
			$detalles[$cd][1]=buscaingreso($ingrc[0]); 
//			echo "ing pr:".$ingrc[0];
echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>".buscaingreso($ingrc[0])."</td><td class='$iter'>".number_format($ingrc[1],2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
			$cd+=1;
		 }
		
		$sqlr2="Select *from tesoingresos_det,tesoliquidapredial_det  where 'P01'=tesoingresos_det.concepto and tesoliquidapredial_det.idpredial=$row[4] and tesoingresos_det.vigencia=$vigusu";
		// echo "<br>".$sqlr2;
		$res= mysql_query($sqlr2,$linkbd);
		while ($row2 =mysql_fetch_row($res)) 
 			{
				$sq="SELECT *FROM tesoabono WHERE cierre='$row[4]'";
				$rst=mysql_query($sq,$linkbd);	
				$num=mysql_num_rows($rst);
				if($num=='0')
				{
					$vdesc=$row2[19];
					$pdesc=$vdesc/($row2[13]+$row2[15]);
					$nvdesc=$row2[13]-($row2[13]*$pdesc);
					echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>IMPUESTO PREDIAL $row2[9]</td><td class='$iter'>".number_format($nvdesc,2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
					$detalles[$cd][0]='01-01';
					$detalles[$cd][2]=$nvdesc;		
					$detalles[$cd][1]="IMPUESTO PREDIAL";
					$cd+=1;
					$nvdesc=$row2[15]-($row2[15]*$pdesc);		
					//$detalles[$row2[2]]=number_format($row2[7],2);
					echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>SOBRETASA BOMBERIL $row2[9]</td><td class='$iter'>".number_format($nvdesc,2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
					$detalles[$cd][0]='01-02';
					$detalles[$cd][2]=$nvdesc;		
					$detalles[$cd][1]="SOBRETASA BOMBERIL ";
					$cd+=1;

					echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>SOBRETASA AMBIENTAL $row2[9]</td><td class='$iter'>".number_format($row2[17],2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
					$detalles[$cd][0]='01-03';
					$detalles[$cd][2]=$row2[17];		
					$detalles[$cd][1]="SOBRETASA AMBIENTAL";
				//	echo "<br>Conc ".$detalles[$cd][1]." - vlr".$row2[17]." cod:".$detalles[$cd][0];
					$cd+=1;

					echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>INTERESES PREDIAL $row2[9]</td><td class='$iter'>".number_format(ceil($row2[14]),2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
					$detalles[$cd][0]='01-PO2';
					$detalles[$cd][2]=ceil($row2[14]);		
					$detalles[$cd][1]="INTERESES PREDIAL";
					$cd+=1;

					echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>INTERESES SOBRETASA BOMBERIL $row2[9]</td><td class='$iter'>".number_format(ceil($row2[16]),2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
					$detalles[$cd][0]='01-PO4';
					$detalles[$cd][2]=ceil($row2[16]);		
					$detalles[$cd][1]="INTERESES SOBRETASA BOMBERIL ";
					$cd+=1;

					echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>INTERESES SOBRETASA AMBIENTAL $row2[10]</td><td class='$iter'>".number_format(ceil($row2[18]),2)."</td><td class='$iter'>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
					$detalles[$cd][0]='01-PO7';
					$detalles[$cd][2]=ceil($row2[18]);		
					$detalles[$cd][1]="INTERESES SOBRETASA AMBIENTAL";
					$cd+=1;
				}
				

			 }	 	 
		}
	if('banco'==$row[5])
	 {
		 $cuentaban+=$row[8];
		 if('1'==$row[10])
		  {
   		 	$totalp+=$row[8];
	 		$cuentabanp+=$row[8];	   
		  }
		 if('2'==$row[10])
		  {
   		 	$totalic+=$row[8];
	 		$cuentabanic+=$row[8];	   
		  }
		 if('3'==$row[10])
		  {
   		 	$totalor+=$row[8];
	 		$cuentabanor+=$row[8];	   
		  }
	 }
	 if('caja'==$row[5])
	 {
 		 $cuentaefe+=$row[8];
 		 if('1'==$row[10])
		  {
   		 	$totalp+=$row[8];
	 		$cuentaefep+=$row[8];	   
		  }
		 if('2'==$row[10])
		  {
   		 	$totalic+=$row[8];
	 		$cuentaefeic+=$row[8];	   
		  }
		 if('3'==$row[10])
		  {
   		 	$totalor+=$row[8];
	 		$cuentaefeor+=$row[8];	   
		  }

	 }

	 $totalr+=$row[8];
	 //echo "<br>Tr: ".$totalr."  ".$row[8];
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
  }
 $_POST[totalresumen]=number_format($totalr,2);
  $_POST[totalresumen2]=$totalr;
  $_POST[totalban2]=$cuentaban;
  $_POST[totalban]=number_format($cuentaban,2);
  $_POST[totalefec2]=$cuentaefe;
  $_POST[totalefec]=number_format($cuentaefe,2);  	  
  $_POST[totalpredial2]=$totalp;
  $_POST[totalpredial]=number_format($totalp,2);  	  
  $_POST[totalpredialefe2]=$cuentaefep;
  $_POST[totalpredialefe]=number_format($cuentaefep,2);  	  
  $_POST[totalpredialban2]=$cuentabanp;
  $_POST[totalpredialban]=number_format($cuentabanp,2);  	  
  $_POST[totalindustria2]=$totalic;
  $_POST[totalindustria]=number_format($totalic,2);  	  
  $_POST[totalindustriaefe2]=$cuentaefeic;
  $_POST[totalindustriaefe]=number_format($cuentaefeic,2);  	  
  $_POST[totalindustriaban2]=$cuentaefeic;
  $_POST[totalindustriaban]=number_format($cuentaefeic,2);  	  

  $_POST[totalotros2]=$totalor;
  $_POST[totalotros]=number_format($totalor,2);  	  
  $_POST[totalotrosefe2]=$cuentaefeor;
  $_POST[totalotrosefe]=number_format($cuentaefeor,2);  	  
  $_POST[totalotrosban2]=$cuentabanor;
  $_POST[totalotrosban]=number_format($cuentabanor,2);  	  

 }
 ?>
	   </table></div>
	  <?php
	 echo "<table class='inicio'><tr><td colspan='6' class='titulos'>Resumen:</td></tr>";  
	 echo "<tr><td class='saludo1'>Total Recaudado:</td><td><input type='hidden' name='totalresumen2' value='$_POST[totalresumen2]' ><input type='text' name='totalresumen' value='$_POST[totalresumen]' ></td><td class='saludo1'>Total Efectivo:</td><td><input type='hidden' name='totalefec2' value='$_POST[totalefec2]' ><input type='text' name='totalefec' value='$_POST[totalefec]' ></td> <td class='saludo1'>Total Consignaciones:</td><td><input type='hidden' name='totalban2' value='$_POST[totalban2]' ><input type='text' name='totalban' value='$_POST[totalban]' ></td></tr>";
	 echo "<tr><td class='saludo1'>Total Predial:</td><td><input type='hidden' name='totalpredial2' value='$_POST[totalpredial2]' ><input type='text' name='totalpredial' value='$_POST[totalpredial]' ></td><td class='saludo1'>Total Industria y Comercio:</td><td><input type='hidden' name='totalindustria2' value='$_POST[totalindustria2]' ><input type='text' name='totalindustria' value='$_POST[totalindustria]' ></td><td class='saludo1'>Total Otros:</td><td><input type='hidden' name='totalotros2' value='$_POST[totalotros2]' ><input type='text' name='totalotros' value='$_POST[totalotros]' ></td></tr>";	 
	
	 echo "</table>";
	 ?>
     <?php
	  $cv=count($detalles);
	  $acumula=array();
	  $nombresi=array();	  
	  $calculando=array();
	 for ($y=0;$y<$cv;$y++)
	 {		
	  $compara=$detalles[$y][0];
	  if(!esta_en_array($acumula, $compara))
	    {
			$acumula[]=$detalles[$y][0];
			$nombresi[]=$detalles[$y][1];			
			$calculando[]=$detalles[$y][2];
//			$acumula[current($acumula)];
		}
		else
		{
		$posicion=pos_en_array($acumula, $compara);	
//		$acumula[$posicion]=$detalles[$y][0];
		$calculando[$posicion]+=$detalles[$y][2];
		}
		
	 }
	 ?>
	 <table class="inicio">
     <tr><td class="titulos"  >Cod</td><td class="titulos">Ingreso</td><td class="titulos">valor</td></tr>
	 <?php
	 	  $cv=count($acumula);
		  $suming=0;
     for ($y=0;$y<$cv;$y++)
	 {		
	  echo "<tr><td class='saludo1'><input name='codigos[]' type='hidden' value='$acumula[$y]'>$acumula[$y]</td><td class='saludo1'><input name='inombres[]' type='hidden' value='$nombresi[$y]'>$nombresi[$y]</td><td class='saludo1' align='right' ><input type='hidden' name='valoresi[]' value='".round($calculando[$y],2)."'>".number_format($calculando[$y],2,",",".")."</td></tr>";
	  $suming+=$calculando[$y];
	  }
	  echo "<tr><td></td><td class='saludo1' >TOTAL:</td><td class='saludo1' align='right' >".number_format($suming,2,".",",")."<input name='itotales' type='hidden' value='$suming'></td></tr>";
	?>
     </table>
	 <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechac],$fecha);
	$fechac=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$sqlr="insert into tesocierrecaja (fecha, fechacierre, vigencia, billetes, monedas, cheques,	consignaciones,	totalconteo, totrecaudo, totefectivo, totbancos,	totpredial, totpredialefe, totpredialban, totindustria,	totindustriaefe, totindustriaban, tototros, tototrosefe, tototrosban, estado) values ('$fechaf', '$fechac','$_POST[vigencia]', $_POST[billetes],  $_POST[monedas], $_POST[cheques], $_POST[consignaciones],$_POST[totconteo], $_POST[totalresumen2], $_POST[totalefec2], $_POST[totalban2], $_POST[totalpredial2], 0, 0, $_POST[totalindustria2],0,0, $_POST[totalotros2], 0,0,'S')";
		if(!mysql_query($sqlr,$linkbd))
	 {
	  
	  echo "
									<script>
										despliegamodalm('visible','2','No Se ha podido Realizar el Cierre de Caja');
										document.getElementById('valfocus').value='2';
									</script>";	
	 }
	  else
	   {
		  echo "<script>despliegamodalm('visible','1','Se ha Realizado el Cierre de Caja del Dia');</script>";
        for($x=0;$x<count($_POST[codigos]);$x++)
	 	{
		 $sqlr2="insert	into tesocierrecajadetalle (fecha,ingreso,nombreingreso,valor) values ('$fechac','".$_POST[codigos][$x]."','".$_POST[inombres][$x]."','".$_POST[valoresi][$x]."')";
		 mysql_query($sqlr2,$linkbd);
		}
	   }
}
?>	<input type="hidden" value="<?php echo $_POST[inicial2]?>" name="inicial2"><input type="hidden" value="<?php echo $_POST[inicial]?>" name="inicial">
	   <script type="text/javascript">$('#billetes, #monedas,#consignaciones,#cheques').alphanum({ allowSpace: false,allowLatin: false});</script>
</form>
 </td></tr>
</table>
</body>
</html>