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
if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
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
ingresos2=document.getElementsByName('dcoding[]');
if (document.form2.fecha.value!='' && ingresos2.length>0)
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
function pdf()
{
document.form2.action="teso-pdfrecaudostrans.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
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
function buscaing(e)
 {
if (document.form2.codingreso.value!="")
{
 document.form2.bin.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function adelante()
{
   //alert("adelante"+document.form2.ncomp.value);
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="cont-recaudotransferencialiquidar-reflejar.php";
document.form2.submit();
}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{
	   //alert("atras"+document.form2.ncomp.value);
//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.idcomp.value=document.form2.idcomp.value-1;
document.form2.action="cont-recaudotransferencialiquidar-reflejar.php";
document.form2.submit();
 }
}
</script>
<script language="JavaScript1.2">
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.idcomp.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="cont-recaudotransferencialiquidar-reflejar.php";
document.form2.submit();
}
	function iratras()
	{
		var idcomp=document.form2.idcomp.value;
		location.href="cont-reflejardocs.php";
	}
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
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
			<a href="#" class="mgbt" ><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a>
			<a href="#" class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" /></a>
			<a href="#" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
			<a href="#" class="mgbt" onclick="guardar()"><img src="imagenes/reflejar1.png"  alt="Guardar" style='width: 25px;' /></a>
			<a href="#" class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" /></a>
			<a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>

</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$linkbd=conectar_bd();
if(!$_POST[oculto])
{
	$sqlr="SELECT * FROM tesorecaudotransferencialiquidar WHERE 1 ORDER BY id_recaudo DESC";	
	$res=mysql_query($sqlr,$linkbd);
	$row =mysql_fetch_row($res);
	$_POST[idcomp]=$row[0];
	if($_GET[consecutivo]!='')
		$_GET[idrecaudo]=$_GET[consecutivo];
	else
		$_GET[idrecaudo]=$row[0];
	//echo $_POST[idcomp];
}


$linkbd=conectar_bd();


	//$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	//$vigencia=$vigusu;
	//$_POST[vigencia]=$vigencia;
	$sqlr="select max(id_recaudo) from tesorecaudotransferencialiquidar ";
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $_POST[maximo]=$r[0];	  
	 }
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones

if($_POST[oculto]=="")
{
$linkbd=conectar_bd();


	$sqlr="select distinct *from tesorecaudotransferencialiquidar, tesorecaudotransferencialiquidar_det   where	  tesorecaudotransferencialiquidar.id_recaudo=$_GET[idrecaudo]  AND tesorecaudotransferencialiquidar.ID_recaudo=tesorecaudotransferencialiquidar_det.ID_recaudo and tesorecaudotransferencialiquidar_det.id_recaudo=$_GET[idrecaudo]";	
	$res=mysql_query($sqlr,$linkbd);
	$cont=0;
	
	$_POST[idcomp]=$_GET[idrecaudo];	
	 $_POST[ncomp]=$_POST[idcomp];
	$total=0;
	while ($row =mysql_fetch_row($res)) 
	{	$p1=substr($row[2],0,4);
		$p2=substr($row[2],5,2);
		$p3=substr($row[2],8,2);
		$_POST[fecha]=$p3."/".$p2."/".$p1;
		$_POST[cc]=$row[8];
		$_POST[dcoding][$cont]=$row[14];		 
		$_POST[banco]=$row[17];
		$_POST[dnbanco]=buscatercero($row[4]);		 
		$_POST[dncoding][$cont]=buscaingreso($row[14]);
		$_POST[tercero]=$row[7];
		$_POST[ntercero]=buscatercero($row[7]);
		$_POST[concepto]=$row[6];
		$total=$total+$row[16]; 
		$_POST[totalc]=$total;
		$_POST[dvalores][$cont]=$row[15];
		$_POST[medioDePago]=$row[11];
		$cont=$cont+1;		
	}		
	
		
}		 
 		 $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 		 
		 $_POST[dvalores]= array(); 
$sqlr="select distinct *from tesorecaudotransferencialiquidar, tesorecaudotransferencialiquidar_det   where	  tesorecaudotransferencialiquidar.id_recaudo=$_POST[idcomp]  AND tesorecaudotransferencialiquidar.ID_recaudo=tesorecaudotransferencialiquidar_det.ID_recaudo and tesorecaudotransferencialiquidar_det.id_recaudo=$_POST[idcomp]";	
	$res=mysql_query($sqlr,$linkbd);
	$cont=0;
	//echo $sqlr;
	//$_POST[idcomp]=$_GET[idrecaudo];	
	$total=0;
	while ($row =mysql_fetch_row($res)) 
	{	$p1=substr($row[2],0,4);
		$p2=substr($row[2],5,2);
		$p3=substr($row[2],8,2);
		$_POST[vigencia]=$row[3];
		$_POST[fecha]=$p3."/".$p2."/".$p1;	
		$_POST[cc]=$row[8];
		$_POST[dcoding][$cont]=$row[14];			 
		$_POST[banco]=$row[17];		 
		$_POST[dnbanco]=buscatercero($row[4]);		 
		$_POST[dncoding][$cont]=buscaingreso($row[14]);
		$_POST[tercero]=$row[7];
		$_POST[ntercero]=buscatercero($row[7]);
		$_POST[concepto]=$row[6];
		$total=$total+$row[16]; 
		$_POST[totalc]=$total;
		$_POST[dvalores][$cont]=$row[15];
		$_POST[medioDePago]=$row[11];
		$cont=$cont+1;		
	}	
	
	if(!$_POST[oculto])
	{
	$check1="checked";
	$fec=date("d/m/Y");
	
	$sqlr="select *from cuentacaja where estado='S' and vigencia=$_POST[vigencia]";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[1];
	}
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
 //***** busca tercero
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
//******** busca ingreso *****
//***** busca tercero
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingreso($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ningreso]="";
			  }
			 }
			 
 ?>
 

    <table class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="10">Liquidar Recaudos Transferencias</td>
        	<td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr  >
        	<td  class="saludo1" >Numero Recaudo:</td>
        	<td  style="width:10%;">
        		<a href="#" onClick="atrasc()">
        			<img src="imagenes/back.png" alt="anterior" align="absmiddle">
        		</a>
        		<input name="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this)" style="width:50%;" onBlur='validar2()' >
        		<input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
        		<a href="#" onClick="adelante()">
        			<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
        		</a>
        		<input type="hidden" value="a" name="atras" >
        		<input type="hidden" value="s" name="siguiente" >
        		<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
        	</td>
	  		<td  class="saludo1">Fecha:        </td>
        	<td style="width:10%;" >
        		<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:80%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly> 
        		         
        	</td>
         	<td  class="saludo1">Vigencia:</td>
		  	<td style="width:15%;">
		  		<input type="text" id="vigencia" name="vigencia" style="width:30%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly> 
		  	</td>
		   	<td style="width:10%;" class="saludo1">Causacion Contable:</td>
		   	<td>
		   		<select name="causacion" id="causacion" onKeyUp="return tabular(event,this)"  >
         			<option value="1" <?php if($_POST[causacion]=='1') echo "SELECTED"; ?>>Si</option>
          			<option value="2" <?php if($_POST[causacion]=='2') echo "SELECTED"; ?>>No</option>         
        		</select>
        	</td>
			<td class="saludo1" style="width:3cm;">Medio de pago: </td>
			<td style="width:14%;">
				<select name="medioDePago" id="medioDePago" onKeyUp="return tabular(event,this)" style="width:80%" disabled>
					<option value="1" <?php if(($_POST[medioDePago]=='1')) echo "SELECTED"; ?>>Con SF</option>
					<option value="2" <?php if($_POST[medioDePago]=='2') echo "SELECTED"; ?>>Sin SF</option>         
				</select>
				<input type="hidden" name="vigencia"  value="<?php echo $_POST[vigencia]?>" onKeyUp="return tabular(event,this)" readonly/>
			</td>          
        </tr>
        <tr>
        	<td  class="saludo1">Concepto Recaudo:</td>
        	<td colspan="7" >
        		<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%;" onKeyUp="return tabular(event,this)" readonly>
        	</td>
        </tr>  
      	<tr>
        	<td  class="saludo1">NIT: </td>
        	<td style="width:10%;">
        		<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" style="width:70%;" onBlur="buscater(event)" readonly>
          		
          	</td>
			<td class="saludo1">Contribuyente:</td>
	  		<td colspan="5"  >
	  			<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%;" onKeyUp="return tabular(event,this) "  readonly>
	  			<input type="hidden" value="0" name="bt">
	  			<input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
	  			<input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  			<input type="hidden" value="1" name="oculto">
	  		</td>
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
			  document.getElementById('codingreso').focus();document.getElementById('codingreso').select();</script>
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
			 //*** ingreso
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingreso($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('valor').focus();document.getElementById('valor').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[codingreso]="";
			  ?>
			  <script>alert("Codigo Ingresos Incorrecto");document.form2.codingreso.focus();</script>
			  <?php
			  }
			 }
			 ?>
      
     <div class="subpantalla">
	   	<table class="inicio">
	   	   	<tr>
   	      		<td colspan="4" class="titulos">Detalle  Liquidar Recaudos Transferencia</td>
   	      	</tr>                  
			<tr>
				<td class="titulos2" style='width:5%;'>Codigo</td>
				<td class="titulos2" style='width:80%;'>Ingreso</td>
				<td class="titulos2" style='width:10%;'>Valor</td>
			</tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		  
 		 unset($_POST[dcoding][$posi]);	
 		 unset($_POST[dncoding][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  		 
		 $_POST[dcoding]= array_values($_POST[dcoding]); 		 
		 $_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcoding][]=$_POST[codingreso];
		 $_POST[dncoding][]=$_POST[ningreso];			 		
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.codingreso.value="";
				document.form2.valor.value="";	
				document.form2.ningreso.value="";				
				document.form2.codingreso.select();
		  		document.form2.codingreso.focus();	
		 </script>
         
         
		  <?php
		  }
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcoding]);$x++)
		 {		 
		 echo "<tr>
		 		<td class='saludo1'>
		 			<input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' style='width:100%;'>
		 		</td>
		 		<td class='saludo1'>
		 			<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' style='width:100%;'>
		 		</td>
		 		<td class='saludo1'>
		 			<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' style='width:100%;'>
		 		</td>
		 	</tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2);
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr>
		 		<td>
		 			</td>
		 			<td class='saludo2'>Total</td>
		 			<td class='saludo1'>
		 				<input name='totalcf' type='text' value='$_POST[totalcf]' style='width:100%;'>
		 				<input name='totalc' type='hidden' value='$_POST[totalc]' style='width:100%;'>
		 			</td>
		 		</tr>
		 		<tr>
		 			<td class='saludo1'>Son:</td>
		 			<td  >
		 				<input name='letras' type='text' value='$_POST[letras]' style='width:100%;'>
		 			</td>
		 		</tr>";
		?> 
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{

	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
	$sqlr="delete from comprobante_cab where numerotipo='$_POST[idcomp]' and tipo_comp='28'";
	//echo $sqlr.'</br>';
	mysql_query($sqlr,$linkbd);
	$sqlr="delete from comprobante_det where numerotipo='$_POST[idcomp]' and tipo_comp='28'";
	//echo $sqlr.'</br>';
	mysql_query($sqlr,$linkbd);
//***busca el consecutivo del comprobante contable
	$consec=$_POST[idcomp];	
	//echo  "Ca:".$_POST[causacion];
	if($_POST[causacion]=='2')
	{$_POST[concepto]="ESTE DOCUMENTO NO REQUIERE CAUSACION CONTABLE - ".$_POST[concepto];}
//***cabecera comprobante
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,28,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'1')";
//	echo $sqlr.'</br>';
	if(mysql_query($sqlr,$linkbd))	
	{//echo "$sqlr <br>";	
	}
	else
	{echo "error:".mysql_error($linkbd);	}
	$idcomp=mysql_insert_id();
$sqlr="delete from comprobante_det where id_comp='28 $_POST[idcomp]'";
	//echo $sqlr.'</br>';
	mysql_query($sqlr,$linkbd);	
	echo "<input type='hidden' name='ncomp' value='$consec'>";
	if($_POST[causacion]!='2')
	{
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."'  and vigencia=$_POST[vigencia]";
	//echo $sqlri.'</br>';
	 	$resi=mysql_query($sqlri,$linkbd);
			//echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
	    //**** busqueda concepto contable*****
		$sq="select fechainicial from conceptoscontables_det where codigo='".$rowi[2]."' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
		$re=mysql_query($sq,$linkbd);
		while($ro=mysql_fetch_assoc($re))
		{
			$_POST[fechacausa]=$ro["fechainicial"];
		}
		$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
	//echo $sqlrc.'</br>';
	 	 $resc=mysql_query($sqlrc,$linkbd);	  
		 		//echo "con: $sqlrc <br>";	      
		while($rowc=mysql_fetch_row($resc))
		 {
			  $porce=$rowi[5];
			 if($_POST[cc]==$rowc[5])
			 {
			if($rowc[3]=='N')
			  {				
			   if($rowc[6]=='S')
			   {
				$valordeb=$_POST[dvalores][$x]*($porce/100);
				$valorcred=0;
			   }
			   if($rowc[7]=='S')
			   {
				$valorcred=$_POST[dvalores][$x]*($porce/100);
				$valordeb=0;
			   }
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('28 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";

	//echo $sqlr.'</br>';
	mysql_query($sqlr,$linkbd);			   
			  }			   
			 }
	//echo "Conc: $sqlr <br>";
		 }
		 }
	 }
	}	
	//************ insercion de cabecera recaudos ************

	$sqlr="delete from tesorecaudotransferencialiquidar where id_recaudo='$consec'";

	//echo $sqlr.'</br>';
	mysql_query($sqlr,$linkbd);
	
	$sqlr="delete from tesorecaudotransferencialiquidar_det where id_recaudo='$consec'";

	//echo $sqlr.'</br>';
	mysql_query($sqlr,$linkbd);

			  
	$sqlr="insert into tesorecaudotransferencialiquidar (id_recaudo,idcomp,fecha,vigencia,banco,ncuentaban,concepto,tercero,cc,valortotal,estado,medio_pago) values($consec,$idcomp,'$fechaf','$_POST[vigencia]','$_POST[ter]','$_POST[cb]','".strtoupper($_POST[concepto])."','$_POST[tercero]','$_POST[cc]','$_POST[totalc]','S','$_POST[medioDePago]')";	  
	mysql_query($sqlr,$linkbd);

	//echo $sqlr.'</br>';
	$idrec=mysql_insert_id();
	//echo "Conc: $sqlr <br>";
	//************** insercion de consignaciones **************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
	$sqlr="insert into tesorecaudotransferencialiquidar_det (id_recaudo,ingreso,valor,estado) values($consec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	

	//echo $sqlr.'</br>';  
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table ><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurri� el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  		else
  		 {			 
	  	 echo "<table  class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recaudo con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
		  ?>
		  <script>
		  document.form2.submit();
		  </script>
		  <?php
		  }
	}	 
}
?>	
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