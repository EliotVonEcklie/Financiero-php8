<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
<script>
//************* ver reporte *************
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
document.form2.action="pdfpagotercerosreporte.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
function buscater(e)
 {
	//  alert('rrrr');
if (document.form2.tercero.value!="")
{
//	 alert('ffff');
 document.form2.bt.value='1';
// alert('rrrr');
 document.form2.submit();
 }
 }
function excell()
{
document.form2.action="teso-pagotercerosdetalleexcel.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
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
  <a href="teso-conciliacionpptocon.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
  <a class="mgbt"><img src="imagenes/guardad.png" /></a>
  <a href="#" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
  <a href="#" class="mgbt" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Buscar" /></a>
  <a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a></td>
</tr>		  
</table>
<?php
$vigencia=date(Y);
 ?>	
<?php
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
		 $_POST[vigencia]=$_SESSION[vigencia]; 		
		 $sqlr="select max(id_pago) from tesopagoterceros";
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

 <form name="form2" method="post" action=""> 
 <?php
 $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
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
 
 ?>
	   <table class="inicio" align="center" >
       
	   <tr>
	     <td colspan="6" class="titulos">Conciliacion Presupuesto/Contabilidad</td><td width="68" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td></tr>
       <tr>

	  <td  class="saludo1" style="width:10%;">Fecha: </td>
        <td style="width:10%;"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:65%;">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px"  align="absmiddle" border="0"></a>     </td>
	  <td   class="saludo1">Vigencia: </td>
        <td><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" style="width:27%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> </td></tr>
       <tr>
       <td class="saludo1">Mes:</td>
       <td >
       <select name="mes" onChange="validar()">
       <option value="">Seleccione ...</option>
         <?php
		   for($x=1;$x<=12;$x++)
		    {
		 ?>
			<option value="<?php  echo $x ?>" <?php if($_POST[mes]==$x) echo "  SELECTED"?>><?php echo $meses[$x] ?></option>
           <?php       
			}
		   ?>  
          	</select> 
          </td>           
         <td  class="saludo1">Tercero:</td>
          <td colspan="2">
		  <input id="tercero" type="text" name="tercero"  onKeyUp="return tabular(event,this)" style="width:16%;" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" ><a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          
		  <input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:50%;" readonly>
		  <input type="hidden" value="0" name="bt"></td>    </tr>
          <tr>                
          	  <td class="saludo1" style="width:8%;">Valor a Pagar:</td>
			  <td>
				<input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valorpagar]?>" readonly></td>	
      <td class="saludo1" style="width:15%;">Retenciones e Ingresos:</td>
		<td style="width:35%;">
        <?php
		$reten=array();
		$nreten=array();		
		?>
		<select name="retencion" style="width:100%;" onChange="validar()" onKeyUp="return tabular(event,this)">
		<option value="" >Seleccione ...</option>
        <option value="t"  <?php if($_POST[retencion]=='t') echo "  SELECTED"?>>Todos</option>
	<?php
	//PARA LA PARTE CONTABLE SE TOMA DEL DETALLE DE LA PARAMETRIZACION LAS CUENTAS QUE INICIAN EN 2**********************	
	$linkbd=conectar_bd();
	$sqlr="select *from tesoretenciones where estado='S' order by codigo";
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
					  $reten[]= 'R-'.$row[0]; 
					  $nreten[]= 'R - '.$row[1]." - ".$row[2];
					}	 	
	$sqlr="select *from tesoingresos where estado='S'  order by codigo";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value='I-$row[0]' ";
					$i=$row[0];
		
					 if('I-'.$i==$_POST[retencion])
			 			{
						 echo "SELECTED";
						  $_POST[nretencion]='I - '.$row[1]." - ".$row[2];
						 }
					  echo ">I - $row[0] - ".$row[1]." - ".$row[2]."</option>";	 	
					   $reten[]= 'I-'.$row[0]; 
					  $nreten[]= 'I - '.$row[1]." - ".$row[2]; 
					}	 	
	?>
   </select>
		<input type="hidden" value="<?php echo $_POST[nretencion]?>" name="nretencion">
		<input type="hidden" value="<?php echo $_POST[oculto]?>" name="oculto"></td><td>
		<input type="button" name="agregard" id="agregard" value="   Agregar   " onClick="agregardetalled()" ><input type="hidden" value="0" name="agregadetdes"></td>  
		</tr>	
      </table>
      <div class="subpantallac4" style="height:25.5%; width:99.6%; overflow-x:hidden;">
       <table class="inicio" style="overflow:scroll">
       <?php 	
		if ($_POST[eliminad]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[eliminad];
		 unset($_POST[ddescuentos][$posi]);
		 unset($_POST[dndescuentos][$posi]);
		 $_POST[ddescuentos]= array_values($_POST[ddescuentos]); 
		 $_POST[dndescuentos]= array_values($_POST[dndescuentos]); 
		 }	 
		 if ($_POST[agregadetdes]=='1')
		 {
		  if($_POST[retencion]=='t')
		  {
			  //echo "DDDDD".count($_POST[retencion]);
			  for($x=0;$x<count($reten);$x++)
		  	 {
				// echo "f:".$k;
			 $_POST[ddescuentos][]=$reten[$x];
			 $_POST[dndescuentos][]=$nreten[$x];		 
			 }
			 		 $_POST[agregadetdes]='0';
		 }
		 else{
		 $_POST[ddescuentos][]=$_POST[retencion];
		 $_POST[dndescuentos][]=$_POST[nretencion];
		 $_POST[agregadetdes]='0';
		 ?>
		 <script>
        document.form2.porcentaje.value=0;
        document.form2.vporcentaje.value=0;	
		document.form2.retencion.value='';	
        </script>
		<?php
		 }
		 }
		  ?>
        
        <tr><td class="titulos">Retenciones e Ingresos</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='eliminad' id='eliminad'></td></tr>
      	<?php
		$totaldes=0;
//		echo "v:".$_POST[valor];
		for ($x=0;$x<count($_POST[ddescuentos]);$x++)
		 {		 
		 echo "<trclass='saludo2'><td><input name='dndescuentos[]' value='".$_POST[dndescuentos][$x]."' type='text' size='100' readonly><input name='ddescuentos[]' value='".$_POST[ddescuentos][$x]."' type='hidden'></td>";		
		 echo "<td><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";	
		 }		 
		$_POST[valorretencion]=$totaldes;

		?>
        <script>
        document.form2.totaldes.value=<?php echo $totaldes;?>;		
//	calcularpago();
       document.form2.valorretencion.value=<?php echo $totaldes;?>;
        </script>
        <?php
		$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
		?>
        
        </table>
        
        <?php
           //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
			  <script>
			  document.getElementById('retencion').focus();document.getElementById('retencion').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				alert("Tercero Incorrecto o no Existe")				   		  	
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
			 ?>    
       </div>    
	  <div class="subpantallac4" style="height:32.5%; width:99.6%; overflow-x:hidden;">
       <table class="inicio" >
        <tr><td class="titulos">Retenciones / Ingresos</td><td class="titulos">Banco</td><td class="titulos">Cuenta Bancaria</td><td class="titulos">Contabilidad</td><td class="titulos">Presupuesto</td><td class="titulos">Valor</td></tr>        
      	<?php
			$linkbd=conectar_bd();
		$_POST[mddescuentos]=array();
		$_POST[mnbancos]=array();	
		$_POST[mctanbancos]=array();				
		$_POST[mtdescuentos]=array();		
		$_POST[mddesvalores]=array();
		$_POST[mddesvalores2]=array();		
		$_POST[mdndescuentos]=array();
		$_POST[mdctas]=array();	
		$_POST[mdctasp]=array();		
		$totalpagar=0;
		//**** buscar movimientos
		for ($x=0;$x<count($_POST[ddescuentos]);$x++)
		 {	
		 $tm=strlen($_POST[ddescuentos][$x]);
		//********** RETENCIONES *********
		if(substr($_POST[ddescuentos][$x],0,1)=='R')
		  {
		$sqlr="select distinct tesoordenpago_retenciones.id_retencion, sum(tesoordenpago_retenciones.valor), tesoegresos.banco, tesoegresos.cuentabanco from tesoordenpago, tesoordenpago_retenciones,tesoegresos where tesoegresos.id_orden=tesoordenpago.id_orden and tesoegresos.estado='S' and MONTH(tesoegresos.fecha)='$_POST[mes]' and tesoordenpago.vigencia='".$_SESSION[vigencia]."' and tesoordenpago_retenciones.id_retencion='".substr($_POST[ddescuentos][$x],2,$tm-2)."' and tesoordenpago.id_orden=tesoordenpago_retenciones.id_orden GROUP BY tesoegresos.banco, tesoegresos.cuentabanco";	  		
		 $res=mysql_query($sqlr,$linkbd);		 
	// echo "<br> - ".$sqlr;  		
		while ($row =mysql_fetch_row($res)) 
	    {
		 $sqlr="select *from tesoretenciones_det where codigo='$row[0]' and cuentapres<>'' ";
		  $res2=mysql_query($sqlr,$linkbd);	
		  //echo "<br>$row[0] - ".$sqlr;
		  while($row2=mysql_fetch_row($res2))
		   {		   
		   //echo "<br>".substr($row2[2],0,1);
		  		   $vpor=$row2[4];
	   	   $_POST[mtdescuentos][]='R';
		   $_POST[mddesvalores][]=$row[1]*($vpor/100);
	   	   $_POST[mddesvalores2][]=$row[1]*($vpor/100);		   
		   $_POST[mddescuentos][]=$row[0];
		   $_POST[mdctas][]=$row2[2];
		   $_POST[mdctasp][]=$row2[3];	
		   $_POST[mnbancos][]=buscatercero(buscabanco($row[2]));	
		   $_POST[mctanbancos][]=$row[3];			   	   
		   $_POST[mdndescuentos][]=buscaretencion($row[0]);
		   $totalpagar+=$row[1]*($vpor/100);
		   //echo "<br>".$row2[2];
			//	echo "<br>ddddd".substr($row2[2],0,1);	
		   }
		 }
		}
					// echo "<br>cccc".count($_POST[mddescuentos]);		 
		//****** INGRESOS *******
		if(substr($_POST[ddescuentos][$x],0,1)=='I')
		  {
		  $sqlr="select distinct tesorecaudos_det.ingreso, sum(tesorecaudos_det.valor), tesoreciboscaja.cuentabanco,tesoreciboscaja.cuentacaja from tesorecaudos, tesorecaudos_det,tesoreciboscaja where tesorecaudos.estado='P' and MONTH(tesoreciboscaja.fecha)='$_POST[mes]' and tesorecaudos.vigencia='".$_SESSION[vigencia]."' and tesorecaudos_det.ingreso='".substr($_POST[ddescuentos][$x],2,$tm-2)."' and tesorecaudos.id_recaudo=tesorecaudos_det.id_recaudo and tesorecaudos.id_recaudo=tesoreciboscaja.id_recaudo and tesoreciboscaja.tipo=3";
		 $res=mysql_query($sqlr,$linkbd);		 
		// echo "<br> - ".$sqlr;
		while ($row =mysql_fetch_row($res)) 
	    {
		 $sqlr="select *from  tesoingresos_det where codigo='$row[0]' and cuentapres<>'' ";
		  $res2=mysql_query($sqlr,$linkbd);	
		  //echo "$row[0] - ".$sqlr;
		  while($row2 =mysql_fetch_row($res2))
		   {
		   $sqlr="select *from  conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' and credito='S' ";
		  $res3=mysql_query($sqlr,$linkbd);	
		 // echo "$row2[1] - ".$sqlr;
		   while($row3 =mysql_fetch_row($res3))
		   {	   
		   $vpor=$row2[5];
		   $_POST[mtdescuentos][]='I';
	   	   $_POST[mddesvalores][]=$row[1]*($vpor/100);
		   $_POST[mddesvalores2][]=$row[1]*($vpor/100);		   
		   $_POST[mddescuentos][]=$row[0];
		   $_POST[mdctas][]=$row3[4];
		   $_POST[mdctasp][]=$row2[6];
		   $_POST[mdndescuentos][]=buscaingreso($row[0]);
		   if($row[2]!='')
		   {
		   $_POST[mnbancos][]=buscatercero(buscabanco($row[2]));	
		   $_POST[mctanbancos][]=$row[3];			   
		   }
		   if($row[2]=='')
		   {
		   $_POST[mnbancos][]=buscacuenta($row[3]);	
		   $_POST[mctanbancos][]="";			   
		   }
		   $totalpagar+=$row[1]*($vpor/100);		   
		   //$nv=buscaingreso($row[0]);
		   //echo "ing:$nv";
		   }
		  }
		 }
		}
		//********************************
		}
			// echo "<br>c...".count($_POST[mddescuentos]);		 
		for ($x=0;$x<count($_POST[mddescuentos]);$x++)
		 {
			 $valorp=pptovalor($_POST[mdctasp][$x],$_POST[mes],$_SESSION[vigencia]);
			// echo "<br>".count($_POST[mddescuentos]);		 
		 echo "<tr class='saludo2'><td><input name='mdndescuentos[]' value='".$_POST[mdndescuentos][$x]."' type='text' size='100' readonly><input name='mddescuentos[]' value='".$_POST[mddescuentos][$x]."' type='hidden'><input name='mtdescuentos[]' value='".$_POST[mtdescuentos][$x]."' type='hidden'></td><td><input name='mnbancos[]' value='".$_POST[mnbancos][$x]."' type='text' size='50' readonly></td><td><input name='mctanbancos[]' value='".$_POST[mctanbancos][$x]."' type='text' size='15' readonly></td><td><input name='mdctas[]' value='".$_POST[mdctas][$x]."' type='text' size='15' readonly></td><td><input name='mdctasp[]' value='".$_POST[mdctasp][$x]."' type='text' size='15' readonly>$valorp</td>";
		 		 echo "<td><input name='mddesvalores[]' value='".round($_POST[mddesvalores][$x],0)."' type='hidden'><input name='mddesvalores2[]' value='".number_format($_POST[mddesvalores2][$x],0)."' type='text' size='15' readonly></td></tr>";
		 }		 
		$resultado = convertir($totalpagar);
		$_POST[letras]=$resultado." PESOS M/CTE";
		 echo "<tr><td></td><td></td><td></td><td>Total:</td><td><input type='hidden' name='totalpago2' value='".round($totalpagar,0)."' ><input type='text' name='totalpago' value='".number_format($totalpagar,0)."' size='15' readonly></td></tr>";	
		 echo "<tr><td colspan='3'><input name='letras' type='text' value='$_POST[letras]' size='150' ></td>";
		?>
        <script>
        document.form2.valorpagar.value=<?php echo round($totalpagar,0);?>;	
		//calcularpago();
        </script>
        </table>
	   </div>              
<?php	  
	//  echo "oculto".$_POST[oculto];
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	//**verificacion de guardado anteriormente *****
	$sqlr="select count(*) from tesopagoterceros where id_pago=$_POST[idcomp] ";
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
$sqlr="insert into tesopagoterceros (`id_pago`, `tercero`, `banco`, `cheque`, `transferencia`, `valor`, `mes`, `concepto`, `cc`, `estado`,fecha) values ($_POST[idcomp],'$_POST[tercero]','$_POST[banco]', '$_POST[ncheque]','$_POST[ntransfe]',$totalpagar,'$_POST[mes]' , '$_POST[concepto]','$_POST[cc]','S','$fechaf')";
	mysql_query($sqlr,$linkbd);
	//echo "$sqlr <br>";	
//***busca el consecutivo del comprobante contable
$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($_POST[idcomp] ,12,'$fechaf','$_POST[concepto]',0,$totalpagar,$totalpagar,0,'1')";
	mysql_query($sqlr,$linkbd);
	//echo "<br>C:".count($_POST[mddescuentos]);
	for ($x=0;$x<count($_POST[mddescuentos]);$x++)
	 {		
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('12 $_POST[idcomp]','".$_POST[mdctas][$x]."','".$_POST[tercero]."','".$_POST[cc]."','PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',".$_POST[mddesvalores][$x].",0,'1','".$_SESSION[vigencia]."')";
		//	echo "$sqlr <br>";
			mysql_query($sqlr,$linkbd);  
		  
		 //*** Cuenta BANCO **
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('12 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',0,".$_POST[mddesvalores][$x].",'1','".$_SESSION[vigencia]."')";
			mysql_query($sqlr,$linkbd);
			//echo "$sqlr <br>";	
			
			$sqlr="insert into tesopagoterceros_det(`id_pago`, `movimiento`, `tipo`, `valor`, `cuenta`, `estado`) values ($_POST[idcomp],'".$_POST[mddescuentos][$x]."','".$_POST[mtdescuentos][$x]."',".$_POST[mddesvalores][$x].",'".$_POST[mdctas][$x]."','S')";
					mysql_query($sqlr,$linkbd);					  
	  }
	   echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recaudo a Terceros con Exito <img src='imagenes/confirm.png'><script>pdf()</script></center></td></tr></table>";
	 }//*** if de guardado
	 else
	  {
		echo "<table class='inicio'><tr><td class='saludo1'><center><img src='imagenes/alert.png'>Ya Se ha almacenado un documento con ese consecutivo</center></td></tr></table>";  
	  }		
}
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 