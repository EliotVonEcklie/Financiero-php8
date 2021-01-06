<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
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
        <title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
       
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
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
function validar()
{
document.form2.submit();
}
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
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

if (document.form2.fechac.value!='')
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
function pdf()
{
document.form2.action="pdfcierrecaja.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
function recalculando()
 {
// alert('ssas');
  monedas=0;
  billetes=0;
  cheques=0;	 
  consignaciones=0;
  totalconteo=0;    
  monedas=document.form2.monedas.value;
  billetes=document.form2.billetes.value;
  consignaciones=document.form2.consignaciones.value;
  cheques=document.form2.cheques.value;      
  totalconteo=parseFloat(monedas)+parseFloat(billetes)+parseFloat(cheques)+parseFloat(consignaciones);
  document.form2.totconteo.value=totalconteo;
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
  <td colspan="3" class="cinta">
  <a href="teso-cierrecaja.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
  <a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guardad.png" /></a>
  <a href="teso-cierrecajaver.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  title="Imprimir" /></a></td>
</tr>		  
</table>
<?php
$vigencia=date(Y);
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
	//ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_GET[fc],$fecha);
//$fechab=$fecha[3]."/".$fecha[2]."/".$fecha[1];	
	//$_POST[fechac]=$fechab;
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
$oculto=$_POST['oculto'];
if($_POST[oculto]==0 && $_POST[fechac]!='')
{
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechac],$fecha);
	$fechab=$fecha[3]."-".$fecha[2]."-".$fecha[1];
$linkbd=conectar_bd();
$sqlr="select *from tesocierrecaja where fechacierre='".$fechab."'";
//echo $sqlr;
$resp = mysql_query($sqlr,$linkbd);
$row2 =mysql_fetch_row($resp);
$_POST[billetes]=$row2[3];
$_POST[monedas]=$row2[4];
$_POST[cheques]=$row2[5];
$_POST[consignaciones]=$row2[6];
$_POST[totconteo]=$row2[7];
$_POST[totrecaudo]=$row2[8];
$_POST[totefectivo]=$row2[9];
$_POST[totbancos]=$row2[10];
$_POST[totpredial]=$row2[11];
$_POST[totindustria]=$row2[14];
$_POST[tototros]=$row2[17];
}
?>
 <form name="form2" method="post" action=""> 
    <table class="inicio" align="center" >
      	<tr >
        	<td style="width:95%;" class="titulos" colspan="2">Cierre de Caja</td>
        	<td style="width:5%;" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
      		<td style="width:80%;">
      			<table>
      				<tr >
			        	<td style="width:10%;" class="saludo1" >No Cierre:</td>
			        	<td style="width:20%;">
			        		<input name="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  readonly>
			        	</td>
				  		<td style="width:15%;" class="saludo1">Fecha:        </td>
			        	<td style="width:20%;">
			        		<input name="fecha" type="text" id="fc_1198971546" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
			        	</td>
			         	<td style="width:10%;" class="saludo1">Vigencia:</td>
					  	<td >
					  		<input type="text" id="vigencia" name="vigencia" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>      
					  	</td>
			        </tr>
			     	<tr>
			     		<td style="width:10%;" class="saludo1">Dia de Cierre:</td>
			     		<td style="width:20%;">
			     			<input name="fechac" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fechac]; ?>" style="width:50%;" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         
			     			<a href="#" onClick="displayCalendarFor('fc_1198971545');">
			     				<img src="imagenes/buscarep.png" align="absmiddle" border="0">
				    		</a>
				    		<input  type="button" name="agregact" value="Consultar" onClick="document.form2.submit()">
				  		</td>
				    	<td style="width:15%;" class="saludo1">Conteo Billetes:</td>
				    	<td style="width:20%;">
				    		<input name="billetes" type="text" onBlur="recalculando()" onKeyUp="return tabular(event,this) " value="<?php echo $_POST[billetes]?>" readonly>
				    	</td>
				    	<td style="width:10%;" class="saludo1">Conteo Monedas:</td>
				    	<td>
				    		<input name="monedas" type="text"  onBlur="recalculando()" onKeyUp="return tabular(event,this) " value="<?php echo $_POST[monedas]?>" readonly>
				    	</td>
				    </tr>
				    <tr>
				    	<td style="width:15%;" class="saludo1">Conteo Cheques:</td>
				    	<td style="width:20%;">
				    		<input name="cheques" type="text"  onBlur="recalculando()" onKeyUp="return tabular(event,this) " value="<?php echo $_POST[cheques]?>" readonly>
				    	</td>
				    
				    	<td style="width:10%;" class="saludo1">Conteo Consignaciones:</td>
				    	<td style="width:20%;">
				    		<input name="consignaciones" type="text"  onBlur="recalculando()" onKeyUp="return tabular(event,this) " value="<?php echo $_POST[consignaciones]?>" readonly>
				    	</td>
				    	<td style="width:10%;" class="saludo1">Total Conteo:</td>
				    	<td >
				    		<input name="totconteo" type="text" value="<?php echo $_POST[totconteo]?>" onKeyUp="return tabular(event,this) " readonly  >
				    	</td>
				    	<td colspan="2">
				    		<input type="hidden" value="0" name="oculto">
				    	</td>
				    </tr>
      			</table>
      		</td>
      		<td  colspan="2" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td> 
      	</tr>
    </table>
<div class="subpantallac" style="height:37%; width:99.6%; overflow-x:hidden;">
  	<table class="inicio">
	   	<tr>
   	      	<td colspan="7" class="titulos">Detalle Cierre de Caja</td>
   	    </tr>                  
		<tr>
			<td class="titulos2">N°Recibo</td>
			<td class='titulos2'>Fecha</td>
			<td class='titulos2'>N°Liqui.</td>
			<td class='titulos2'>Detalle</td>
			<td class='titulos2'>Valor</td>
			<td class='titulos2'>Tipo</td>
			<td class='titulos2'>Forma de Pago</td>
		</tr>
<?php
$oculto=$_POST['oculto'];
$linkbd=conectar_bd();
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
$iter='saludo1a';
$iter2='saludo2';
$tipos=array('Predial','Industria y Comercio','Otros Recaudos');
$detalles=array();
//echo "<br>".$sqlr;
$cd=0;
 while ($row =mysql_fetch_row($resp)) 
 {
	$ti="";
		 //**********discriminando los recibos
	 if('3'==$row[10])
	 {$sqlr2="Select *from tesoingresos,tesorecaudos_det  where tesorecaudos_det.ingreso=tesoingresos.codigo and tesorecaudos_det.id_recaudo=$row[4]";
	 $ti='Otros Recaudos';
	  $res= mysql_query($sqlr2,$linkbd);
	 while ($row2 =mysql_fetch_row($res)) 
 		{					 
	 	echo "<tr class='$iter'><td>$row[0]</td><td>$row[2]</td><td>$row[4]</td><td>$row2[1]</td><td>".number_format($row2[8],2)."</td><td >".$ti."</td><td>".$row[5]."</td></tr>";
		$detalles[$cd][0]=$row2[7];
		$detalles[$cd][2]=$row2[8];		
		$detalles[$cd][1]=buscaingreso($row2[7]);
		$cd+=1;
		}		  
	 }
	  if('2'==$row[10])
	 	{
		 $sqlr2="Select *from tesoingresos_det,tesoindustria_det  where '02'=tesoingresos_det.codigo and tesoindustria_det.id_industria=$row[4]";
		 $ti='Industria y Comercio';
		 $res= mysql_query($sqlr2,$linkbd);
	 while ($row2 =mysql_fetch_row($res)) 
 		{
		 if($row2[2]=='04')
		  {
			 $nvdesc=$row2[9]-$row2[12]+$row2[13];
			 $detalles[$cd][0]='02-04';			 
			$detalles[$cd][2]=$nvdesc;		
			$detalles[$cd][1]="INDUSTRIA Y COMERCIO"; 
			$cd+=1;
			echo "<tr class='$iter'><td>$row[0]</td><td>$row[2]</td><td>$row[4]</td><td>INDUSTRIA Y COMERCIO $row2[8]</td><td >".number_format($nvdesc,2)."</td><td>".$ti."</td><td class='$iter'>".$row[5]."</td></tr>";
		  }
		  if($row2[2]=='05')
		  {
			 $nvdesc=$row2[10];
			 $detalles[$cd][0]='02-05';			 
			$detalles[$cd][2]=$nvdesc;		
			$detalles[$cd][1]="AVISOS Y TABLEROS"; 
			$cd+=1;
			echo "<tr class='$iter'><td>$row[0]</td><td>$row[2]</td><td>$row[4]</td><td>AVISOS Y TABLEROS $row2[8]</td><td>".number_format($nvdesc,2)."</td><td>".$ti."</td><td>".$row[5]."</td></tr>";
		  }
		  if($row2[2]=='06')
		  {
			 $nvdesc=$row2[11];
			 $detalles[$cd][0]='02-06';			 
			$detalles[$cd][2]=$nvdesc;		
			$detalles[$cd][1]="SOBRETASA BOMBERIL - ICA"; 
			$cd+=1;
			echo "<tr class='$iter'><td>$row[0]</td><td>$row[2]</td><td>$row[4]</td><td>SOBRETASA BOMBERIL - ICA $row2[8]</td><td>".number_format($nvdesc,2)."</td><td>".$ti."</td><td>".$row[5]."</td></tr>";
		  }
		}
	    }
	  if('1'==$row[10])
	 	{
		  $ti='Predial';
		 $sqlr2="Select *from tesoingresos_det,tesoliquidapredial_det  where 'P01'=tesoingresos_det.concepto and tesoliquidapredial_det.idpredial=$row[4]";
		// echo "<br>".$sqlr2;
		 $res= mysql_query($sqlr2,$linkbd);
		 while ($row2 =mysql_fetch_row($res)) 
 			{				
		    $vdesc=$row2[18];
			$pdesc=$vdesc/($row2[12]+$row2[14]);
			$nvdesc=$row2[12]-($row2[12]*$pdesc);
		     echo "<tr class='$iter'><td>$row[0]</td><td>$row[2]</td><td>$row[4]</td><td>IMPUESTO PREDIAL $row2[9]</td><td>".number_format($nvdesc,2)."</td><td>".$ti."</td><td>".$row[5]."</td></tr>";
 			$detalles[$cd][0]='01-01';
			$detalles[$cd][2]=$nvdesc;		
			$detalles[$cd][1]="IMPUESTO PREDIAL";
			$cd+=1;
			$nvdesc=$row2[14]-($row2[14]*$pdesc);		
			//$detalles[$row2[2]]=number_format($row2[7],2);
		     echo "<tr class='$iter'><td>$row[0]</td><td>$row[2]</td><td>$row[4]</td><td>SOBRETASA BOMBERIL $row2[9]</td><td>".number_format($nvdesc,2)."</td><td>".$ti."</td><td>".$row[5]."</td></tr>";
			$detalles[$cd][0]='01-02';
			$detalles[$cd][2]=$nvdesc;		
			$detalles[$cd][1]="SOBRETASA BOMBERIL ";
			$cd+=1;

		     echo "<tr class='$iter'><td>$row[0]</td><td>$row[2]</td><td>$row[4]</td><td>SOBRETASA AMBIENTAL $row2[9]</td><td>".number_format($row2[16],2)."</td><td>".$ti."</td><td>".$row[5]."</td></tr>";
			$detalles[$cd][0]='01-03';
			$detalles[$cd][2]=$row2[16];		
			$detalles[$cd][1]="SOBRETASA AMBIENTAL";
			$cd+=1;

			 echo "<tr class='$iter'><td>$row[0]</td><td>$row[2]</td><td>$row[4]</td><td>INTERESES PREDIAL $row2[9]</td><td>".number_format(ceil($row2[13]),2)."</td><td>".$ti."</td><td>".$row[5]."</td></tr>";
 			$detalles[$cd][0]='01-PO2';
			$detalles[$cd][2]=ceil($row2[13]);		
			$detalles[$cd][1]="INTERESES PREDIAL";
			$cd+=1;

			 echo "<tr class='$iter'><td>$row[0]</td><td>$row[2]</td><td>$row[4]</td><td>INTERESES SOBRETASA BOMBERIL $row2[9]</td><td>".number_format(ceil($row2[15]),2)."</td><td>".$ti."</td><td>".$row[5]."</td></tr>";
 			$detalles[$cd][0]='01-PO4';
			$detalles[$cd][2]=ceil($row2[15]);		
			$detalles[$cd][1]="INTERESES SOBRETASA BOMBERIL ";
			$cd+=1;

		     echo "<tr class='$iter'><td>$row[0]</td><td>$row[2]</td><td>$row[4]</td><td>INTERESES SOBRETASA AMBIENTAL $row2[9]</td><td>".number_format(ceil($row2[17]),2)."</td><td>".$ti."</td><td>".$row[5]."</td></tr>";
 			$detalles[$cd][0]='01-PO7';
			$detalles[$cd][2]=ceil($row2[17]);		
			$detalles[$cd][1]="INTERESES SOBRETASA AMBIENTAL";
			$cd+=1;
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
	 echo "<tr><td class='saludo1a'>Total Recaudado:</td><td><input type='hidden' name='totalresumen2' value='$_POST[totalresumen2]' ><input type='text' name='totalresumen' value='$_POST[totalresumen]' ></td><td class='saludo1a'>Total Efectivo:</td><td><input type='hidden' name='totalefec2' value='$_POST[totalefec2]' ><input type='text' name='totalefec' value='$_POST[totalefec]' ></td> <td class='saludo1a'>Total Consignaciones:</td><td><input type='hidden' name='totalban2' value='$_POST[totalban2]' ><input type='text' name='totalban' value='$_POST[totalban]' ></td></tr>";
	 echo "<tr><td class='saludo1a'>Total Predial:</td><td><input type='hidden' name='totalpredial2' value='$_POST[totalpredial2]' ><input type='text' name='totalpredial' value='$_POST[totalpredial]' ></td><td class='saludo1a'>Total Industria y Comercio:</td><td><input type='hidden' name='totalindustria2' value='$_POST[totalindustria2]' ><input type='text' name='totalindustria' value='$_POST[totalindustria]' ></td><td class='saludo1a'>Total Otros:</td><td><input type='hidden' name='totalotros2' value='$_POST[totalotros2]' ><input type='text' name='totalotros' value='$_POST[totalotros]' ></td></tr>";	 
	
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
     <tr><td class="titulos" >Cod</td><td class="titulos">Ingreso</td><td class="titulos">valor</td></tr>
	 <?php	 
	 $sqlr="select *from tesocierrecajadetalle where fecha='$fechab'";
	 $res=mysql_query($sqlr,$linkbd);
	 $y=0;
	 $suming=0;
//	 echo $sqlr;
	 while($row=mysql_fetch_row($res))	 
	 //	  $cv=count($acumula);		  
     //for ($y=0;$y<$cv;$y++)
	 {		
	 
	//  echo "<tr><td class='saludo1'><input name='codigos[]' type='hidden' value='$acumula[$y]'>$acumula[$y]</td><td class='saludo1'><input name='inombres[]' type='hidden' value='$nombresi[$y]'>$nombresi[$y]</td><td class='saludo1'><input type='hidden' name='valoresi[]' value='".number_format($calculando[$y],2)."'>".number_format($calculando[$y],2)."</td></tr>";
	  echo "<tr><td class='saludo1a'><input name='codigos[]' type='hidden' value='$row[1]'>$row[1]</td><td class='saludo1'><input name='inombres[]' type='hidden' value='$row[2]'>$row[2]</td><td class='saludo1'><input type='hidden' name='valoresi[]' value='".number_format($row[3],2)."'>".number_format($row[3],2)."</td></tr>";
	   $suming+=$row[3];
	   $y+=1;
	  }
	  echo "<tr><td></td><td class='saludo1a' align='right' >TOTAL:</td><td class='saludo1a'>".number_format($suming,2)."<input name='itotales' type='hidden' value='$suming'></td></tr>";
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
	$sqlr="insert into tesocierrecaja (fecha, fechacierre, vigencia, billetes, monedas, cheques,	consignaciones,	totalconteo, totrecaudo, totefectivo, totbancos,	totpredial, totpredialefe, totpredialban, totindustria,	totindustriaefe, totindustriaban, tototros, tototrosefe, tototrosban, estado) values ('$fechaf', '$fechac','$_POST[vigencia]', $_POST[billetes],  $_POST[monedas], $_POST[cheques], $_POST[consignaciones],$_POST[totconteo], $_POST[totalresumen2], $_POST[totalefec2], $_POST[totalban2], $_POST[totalpredial2], $_POST[totalpredialefe2], $_POST[totalpredialban2], $_POST[totalindustria2], $_POST[totalindustriaefe2], $_POST[totalindustriaban2], $_POST[totalotros2], $_POST[totalotrosefe2], $_POST[totalotrosban2],'S')";
		if(!mysql_query($sqlr,$linkbd))
	 {
	  echo "<table class='inicio'><tr><td class='saludo1a'>No Se ha podido Realizar el Cierre de Caja <img src='imagenes\alert.png'></td></tr></table>";  
	 }
	  else
	   {
		  echo "<table class='inicio'><tr><td class='saludo1a'><center>Se ha Realizado el Cierre de Caja del Dia $fechac <img src='imagenes\confirm.png'></center></td></tr></table>";	   }
}
?>	<input type="hidden" value="<?php echo $_POST[inicial2]?>" name="inicial2"><input type="hidden" value="<?php echo $_POST[inicial]?>" name="inicial">
</form>
 </td></tr>
</table>
</body>
</html>