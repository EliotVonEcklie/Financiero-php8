<?php //V 1000 12/12/16 ?> 
<?php
header('Content-Type: text/html; charset=UTF-8');
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
function consultaciiu(e)
 {
if (document.form2.ciiu.value!="")
{
 document.form2.bci.value='1';
 document.form2.submit();
 }
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
function pdf()
{
document.form2.action="teso-pdfindustria.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script>
function agregardetalled()
{
if(document.form2.ingreso.value!="" &&  document.form2.ciiu.value!=""  )
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
function eliminardact(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.eliminadac.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('eliminadac');
//eli.value=elimina;
//vvend.value=variable;
document.form2.submit();
}
}
</script>

<script>
function sumarindustria()
{
indus=document.getElementById('industria').value;
avis=document.getElementById('avisos').value;
retencion=document.getElementById('retenciones').value;
sancion=document.getElementById('sanciones').value;
bomber=document.getElementById('bomberil').value;
valtot=document.getElementById('valortotal').value;
interes=document.getElementById('intereses').value;
saldopago=document.getElementById('saldopagar').value;
acum=parseFloat(indus)+parseFloat(antvigac)-parseFloat(antvigan)+parseFloat(avis)+parseFloat(retencion)+parseFloat(sancion)+parseFloat(bomber)+parseFloat(valtot)+parseFloat(interes);
document.getElementById('saldopagar').value=acum;
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
<script language="JavaScript1.2">
function adelante()
{
//   alert("Balance Descuadrado");
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="teso-industriaver-regrabar.php";
document.form2.submit();
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
document.form2.idcomp.value=document.form2.idcomp.value-1;
document.form2.action="teso-industriaver-regrabar.php";
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
document.form2.action="teso-industriaver-regrabar.php";
document.form2.submit();
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
  <td colspan="3" class="cinta"><a href="teso-industria.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#" onClick="guardar()" ><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscaindustria.php"> <img src="imagenes/busca.png"  alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> <a href="#" onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a> <a href="teso-actualizardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if($_POST[oculto]=="")
{
	$sqlr="select max(id_industria) from tesoindustria ";
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $_POST[idcomp]=$r[0];
	$_POST[maximo]=$r[0];
	 $_POST[ncomp]=$_POST[maximo];	  
	 }	
	
	$check1="checked";
	
	 //$consec+=1;
	// $_POST[idcomp]=$consec;	
 	//echo $sqlr;
		 $_POST[valor]=0;		 
}
$sqlr="select * from tesoindustria where id_industria=$_POST[idcomp]";
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	 $_POST[fecha]=$r[1]; 		 		  			  	 
	 $_POST[idcomp]=$r[0];			 
	 $_POST[ageliquida]=$r[2];			 	 
	 $_POST[tercero]=$r[5];	
	 if($r[7]=='N')
	 $_POST[estadoc]="ANULADO";	
	 if($r[7]=='P')
	 $_POST[estadoc]="PAGO";	
	 if($r[7]=='S')
 	 $_POST[estadoc]="ACTIVO";	
	 
	 $sqlr="select * from tesoindustria_det where id_industria=$_POST[idcomp]";
	 $res2=mysql_query($sqlr,$linkbd);
	 while($r2=mysql_fetch_row($res2))
		 {		 	 
			$_POST[industria]=$r2[1];
			$_POST[avisos]=$r2[2];
			$_POST[sanciones]=$r2[5];
			$_POST[retenciones]=$r2[4];
			$_POST[bomberil]=$r2[3];		
			$_POST[valortotal]=$r2[7];	
			$_POST[intereses]=$r2[6];	
			$_POST[antivigant]=$r2[10];	
			$_POST[antivigact]=$r2[11];	
			//$_POST[saldopagar]=$r2[1];	
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
			 
			 if($_POST[bci]=='1')
			 {
			  $linkbd=conectar_bd();
			  $sqlr="select *from codigosciiu where codigosciiu.codigo='$_POST[ciiu]'";
	//			echo $sqlr;
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			  $nresul=$row[1];			  	  
			  if($nresul!='')
			   {
			  $_POST[nciiu]=$nresul;
			  $_POST[tciiu]=$row[2];  			
			  }
			 else
			 {
			  $_POST[nciiu]="";
			  $_POST[tciiu]="";
			  }
			 }
			 
 ?>
 <div class="tabsic">
   <div class="tab">
       <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   <label for="tab-1">Base</label>
	   <div class="content">
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="9">Liquidar Industria y Comercio</td>
        <td width="102" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  ><td  class="saludo1" >Numero Comp:</td>
        <td  ><a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onKeyUp="return tabular(event,this)" onBlur="validar2()"> <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"><a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"></td>
	  <td   class="saludo1">Fecha:        </td>
        <td ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a> <input name="estadoc" type="text" id="estadoc" value="<?php echo $_POST[estadoc] ?>" size="15" readonly>    </td>
        <td width="116" class="saludo1" >Tipo:</td>
        <td width="110" >
        <select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" >
          <option value="2" <?php if($_POST[tipomov]=='2') echo "SELECTED"; ?>>Normal</option>
          <option value="3" <?php if($_POST[tipomov]=='3') echo "SELECTED"; ?>>Correccion</option>
          <option value="4" <?php if($_POST[tipomov]=='4') echo "SELECTED"; ?>>Clausura</option>
          <option value="5" <?php if($_POST[tipomov]=='5') echo "SELECTED"; ?>>Vigencia Anterior</option>
        </select>
        </td>  <td width="92" class="saludo1">Año Liquidar:</td>
		  <td width="42"><input type="text" id="ageliquida" name="ageliquida" size="4" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[ageliquida]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" maxlength="4" >      
        <input type="hidden" id="vigencia" name="vigencia" value="<?php echo $_POST[vigencia]?>" >
        
        </tr>
      <tr>
        <td  class="saludo1">NIT/Cedula: </td>
        <td ><input id="tercero" type="text" name="tercero" size="15" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>">
          <a href="#" onClick="mypop=window.open('terceros-ventana.php?','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
			  <td class="saludo1">Contribuyente:</td>
	  <td  ><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" size="50" onKeyUp="return tabular(event,this) "  readonly><input type="hidden" value="0" name="bt"><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  
	    <input type="hidden" value="1" name="oculto"></td>
	 
       <td class="saludo1" width="30px">Ing Gravables:</td><td><input type="text" id="ingreso" name="ingreso" value="<?php echo $_POST[ingreso]?>" size="30" onKeyUp="return tabular(event,this)" ></td><td class="saludo1">Acti Economica:</td><td><input type="text" name="ciiu" value="<?php echo $_POST[ciiu]?>" size="5" onKeyUp="return tabular(event,this) " onBlur="consultaciiu()"><input type="hidden" name="tciiu" value="<?php echo $_POST[tciiu]?>" ><input type="hidden" name="nciiu" value="<?php echo $_POST[nciiu]?>" > <input type="hidden" value="0" name="bci">  <a href="#" onClick="mypop=window.open('ciiu-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
          </td><td colspan="2"><input  type="button" name="agregact" id="agregact" value="Agregar" onClick="agregardetalled()"><input type="hidden" value="0" name="agregadetdes"><input type='hidden' name='eliminadac' id='eliminadac'  ></td></tr>
	  </table>
      
      
      <table class="inicio">
      <tr><td class="titulos2">Codigo</td><td class="titulos2">Actividad</td><td class="titulos2">Ingreso Actividad</td><td class="titulos2">Tarifa x mil</td><td class="titulos2">Valor</td><td class="titulos2"><img src="imagenes/del.png" ></td></tr>
    <?php
		$totaldes=0;
		$sqlr="Select *from tesoindustria_ciiu where id_industria=$_GET[idrecibo]";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
//		for ($x=0;$x<count($_POST[dciiu]);$x++)
		 {		 
		 echo "<tr><td class='saludo2'><input name='dciiu[]' value='".$_POST[dciiu][$x]."' type='text' size='6' readonly></td>";
		 echo "<td class='saludo2'><input name='dnciiu[]' value='".$_POST[dnciiu][$x]."' type='text' size='100' readonly></td>";
		 echo "<td class='saludo2'><input name='dingresoact[]' value='".$_POST[dingresoact][$x]."' type='text' size='15' readonly></td>";
		 echo "<td class='saludo2'><input name='dtarifas[]' value='".$_POST[dtarifas][$x]."' type='text' size='15' readonly></td>";		 
		 echo "<td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15' readonly></td>";		 
		 echo "<td class='saludo2'><a href='#' onclick='eliminardact($x)'><img src='imagenes/del.png'></a></td></tr>";
// 		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".$_POST[ddesvalores][$x]."' type='text' size='15'></td><td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $totaldes=$totaldes+($_POST[dvalores][$x])	;
		 }		 
		// $_POST[industria]=ceil($totaldes);
		?>
      
      </table>
	    </div>
       
       </div>
        <div class="tab">
       <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
	   <label for="tab-2">Sanciones</label>
        <div class="content"> 
	   <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="8">Sanciones</td><td width="108" class="cerrar" ><a href="teso-principal.php">X Cerrar</a></td>
      </tr>
		<tr><td class="saludo1">Sancion:</td>
		<td>
		<select name="sancion"  onChange="validar()" onKeyUp="return tabular(event,this)">
		<option value="">Seleccione ...</option>
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from tesosanciones where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[sancion])
			 			{
						 echo "SELECTED";
						  $_POST[porcentaje]=$row[5];
						  $_POST[nretencion]=$row[1]." - ".$row[2];
						  $_POST[vporcentaje]=($_POST[valor]*$_POST[porcentaje])/100;
						 }
					  echo ">".$row[1]." - ".$row[2]."</option>";	 	 
					}	 	
	?>
   </select><input type="hidden" value="<?php echo $_POST[nsancion]?>" name="nretencion">
		
		</td><td class="saludo1">%</td><td><input id="porcentaje" name="porcentaje" type="text" size="5" value="<?php echo $_POST[porcentaje]?>" readonly> %</td>
		<td class="saludo1">Valor:</td><td><input id="vporcentaje" name="vporcentaje" type="text" size="10" value="<?php echo $_POST[vporcentaje]?>" readonly>
        </td><td class="saludo1">Total Sanciones:</td><td><input id="totaldes" name="totaldes" type="text" size="10" value="<?php echo $_POST[totaldes]?>" readonly>
        <input type="button" name="agregard" id="agregard" value="   Agregar   " onClick="agregardetalled()" ><input type="hidden" value="0" name="agregadetsan"></td>
		</tr>
       
      
         <table class="inicio">
        <tr><td class="titulos">Sancion</td><td class="titulos">%</td><td class="titulos">Valor</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='eliminad' id='eliminad'></td></tr>
      	<?php
		$totaldes=0;
		for ($x=0;$x<count($_POST[ddescuentos]);$x++)
		 {		 
		 echo "<tr><td class='saludo2'><input name='dndescuentos[]' value='".$_POST[dndescuentos][$x]."' type='text' size='100' readonly><input name='ddescuentos[]' value='".$_POST[ddescuentos][$x]."' type='hidden'></td>";
		 echo "<td class='saludo2'><input name='dporcentajes[]' value='".$_POST[dporcentajes][$x]."' type='text' size='5' readonly></td>";
		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".(($_POST[dporcentajes][$x]*$_POST[valor])/100)."' type='text' size='15' readonly></td><td class='saludo2'><a href='#' onclick=' eliminardact($x)'><img src='imagenes/del.png'></a></td></tr>";
// 		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".$_POST[ddesvalores][$x]."' type='text' size='15'></td><td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $totaldes=$totaldes+$_POST[ddesvalores][$x];
		 }		 
		?>
        
        <script>
        document.form2.totaldes.value=<?php echo ceil($totaldes);?>;	
		calcularpago();
        </script>
        </table>
      
      </table>
	   </div>
       </div>       
      </div>
       
     <table class="inicio">
	   	   <tr>
	   	     <td colspan="2" class="titulos">Liquidacion Privada</td>
	   	   </tr>          
         <?php
		 //*************BUSCAR EL CONCEPTO CONTABLE DEL INGRESO INDUSTRIA Y COMERCIO *****************
		 /*$linkbd=conectar_bd();
		 $sqlr="select *from tesoingresos_det where codigo='02'";
		 $res=mysql_query($sqlr,$linkbd);
		 while($row=mysql_fetch_row($res))
		  {
			if($row[2]=='05')
			  {
			   $_POST[avisos]=ceil($row[5]*($_POST[industria]/100));
//			   $_POST[avisos]=ceil(number_format($_POST[avisos],2,'.',''));
			  }
			if($row[2]=='06')
			  {
			   $_POST[bomberil]=ceil($row[5]*($_POST[industria]/100));
	//		   $_POST[bomberil]=ceil(number_format($_POST[bomberil],2,'.',''));
			  }  
		  }*/
		 $_POST[saldopagar]=$_POST[industria]+$_POST[antivigact]-$_POST[antivigant]+$_POST[avisos]+$_POST[retenciones]+$_POST[sanciones]+$_POST[bomberil]+$_POST[valortotal]+$_POST[intereses]+$_POST[valortotal];
         ?>          
		<tr>
		  <td width="21%" class="saludo1">Industria y Comercio</td><td class="saludo2" width="79%"><input id="industria" name="industria" type="text" value="<?php echo $_POST[industria]?>" readonly></td></tr>
		  <tr><td class="saludo1">Avisos y Tableros</td><td class="saludo2"><input id="avisos" name="avisos" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[avisos]?>" readonly></td></tr>		 
		  <tr><td class="saludo1">Anticipo Vigencia Actual</td><td class="saludo2"><input id="antivigact" name="antivigact" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[antivigact]?>" ></td></tr>
		   <tr><td class="saludo1">Anticipo Vigencia Anterior</td><td class="saludo2"><input id="antivigant" name="antivigant" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[antivigant]?>" ></td></tr>
		  <tr><td class="saludo1">Retenciones</td><td class="saludo2"><input id="retenciones" name="retenciones" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[retenciones]?>" readonly></td></tr>
		  <tr><td class="saludo1">Sanciones</td><td class="saludo2"><input type="text" id="sanciones" name="sanciones" value="<?php echo $_POST[sanciones]?>" onBlur="sumarindustria()"></td></tr>
		  <tr><td class="saludo1">Recargo Bomberil</td><td class="saludo2"><input id="bomberil" name="bomberil" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[bomberil]?>" readonly></td></tr>
		  <tr><td class="saludo1">Valor Total</td><td class="saludo2"><input id="valortotal" name="valortotal" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[valortotal]?>" readonly></td></tr>
		  <tr><td class="saludo1">Intereses</td><td class="saludo2"><input type="text" id="intereses" name="intereses" value="<?php echo $_POST[intereses]?>" onBlur="sumarindustria()"></td></tr>
		  <tr><td class="saludo1">Saldo a Pagar</td><td class="saludo2"><input id="saldopagar" name="saldopagar" type="text" onBlur="sumarindustria()" value="<?php echo number_format($_POST[saldopagar],2,'.','')?>" readonly></td>
		  </tr>
            <script>
        sumarindustria();
        </script>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		 unset($_POST[dccs][$posi]);
		 unset($_POST[dconsig][$posi]);
		  unset($_POST[dbancos][$posi]);
		 unset($_POST[dnbancos][$posi]);		 
 		 unset($_POST[dcbs][$posi]);	
 		 unset($_POST[dcts][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 $_POST[dconsig]= array_values($_POST[dconsig]);  
		 $_POST[dbancos]= array_values($_POST[dbancos]); 
  		  $_POST[dnbancos]= array_values($_POST[dnbancos]); 
		 $_POST[dcbs]= array_values($_POST[dcbs]); 		 
		 $_POST[dcts]= array_values($_POST[dcts]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dccs][]=$_POST[cc];
		 $_POST[dconsig][]=$_POST[numero];			 
		 $_POST[dbancos][]=$_POST[banco];		 
		 $_POST[dnbancos][]=$_POST[nbanco];		 
		 $_POST[dcbs][]=$_POST[cb];
		 $_POST[dcts][]=$_POST[ct];
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.banco.value="";
				document.form2.nbanco.value="";
				document.form2.cb.value="";
					document.form2.valor.value="";	
				document.form2.numero.value="";				
				document.form2.numero.select();
		  		document.form2.numero.focus();	
		 </script>
		  <?php
		  }
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dbancos]);$x++)
		 {		 
		 echo "<tr><td class='saludo2'><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='4' readonly></td><td class='saludo2'><input name='dconsig[]' value='".$_POST[dconsig][$x]."' type='text' ></td><td class='saludo2'><input name='dcts[]' value='".$_POST[dcts][$x]."' type='hidden' ><input name='dbancos[]' value='".$_POST[dbancos][$x]."' type='hidden' ><input name='dcbs[]' value='".$_POST[dcbs][$x]."' type='text' size='45'></td><td class='saludo2'><input name='dnbancos[]' value='".$_POST[dnbancos][$x]."' type='text' size='50'></td><td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15'></td><td class='saludo2'><input type='checkbox' name='liquidaciones' value='1'></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 }
 			$resultado = convertir($_POST[saldopagar]);
			$_POST[letras]=$resultado." PESOS M/CTE";
		 echo "<tr><td class='saludo2'  >Son: </td><td><input name='letras' type='text' value='$_POST[letras]' size='90' readonly></td></tr>";
		?> 
      </table>	
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	
	
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DE LA LIQUIDACION ***************************
	if ($_POST[estadoc]=='ANULADO')
	{
	$sqlr="update comprobante_cab set estado=0 where tipo_comp=3 and numerotipo=$_POST[idcomp]";
	mysql_query($sqlr,$linkbd);			
	$sqlr="update comprobante_det set valcredito=0, valcredito=0 where tipo_comp=3 and numerotipo=$_POST[idcomp]";
	mysql_query($sqlr,$linkbd);		
	}
	else
	{
//	$sqlr="update comprobante_det set tercero='$_POST[tercero]' where id_comp='11 $_POST[idcomp]'";
	$sqlr="update comprobante_cab set estado=1 where tipo_comp=3 and numerotipo=$_POST[idcomp]";
	mysql_query($sqlr,$linkbd);			
	$sqlr="delete from comprobante_det where id_comp='3 $_POST[idcomp]'";
	mysql_query($sqlr,$linkbd);

		 $nter=buscatercero($_POST[tercero]);
		//*********************CREACION DEL COMPROBANTE CONTABLE ***************************		  
	//echo "<br>$sqlr ";
		//*******************DETALLE DEL COMPROBANTE CONTABLE *****************************
		 //*************BUSCAR EL CONCEPTO CONTABLE DEL INGRESO INDUSTRIA Y COMERCIO *****************
		 $sqlr="select *from tesoingresos_det where codigo='02' AND VIGENCIA='$vigusu'";
		 $res=mysql_query($sqlr,$linkbd);
		 while($row=mysql_fetch_row($res))
		  {
			if($row[2]=='04') //*****industria
			  {
					$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='04' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						  $valordeb=$_POST[industria]+$_POST[sanciones]+$_POST[intereses];
						 $valorcred=0;
						 }
					   if($row2[6]=='N')
						 {				 
						 $valorcred=$_POST[industria]+$_POST[sanciones]+$_POST[intereses];
						 $valordeb=0;
						 }				
						 $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $_POST[idcomp]', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Industria y Comercio $_POST[ageliquida]','',".$valordeb.",$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
						echo "<br>$sqlr ";
						}
					  }
			  }
			if($row[2]=='05')//************avisos
			  {
				$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='05' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=$_POST[avisos];
						 $valorcred=0;

						 }
					   if($row2[6]=='N')
						 {				 
						 $valorcred=$_POST[avisos];
						 $valordeb=0;

						 }					 
						 $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $_POST[idcomp]', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Avisos y Tableros $_POST[ageliquida]','',".$valordeb.",$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 						
						}						
					  }
			  }
			if($row[2]=='06') //*********bomberil ********
			  {
					$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='06' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=$_POST[bomberil];
						 $valorcred=0;

						 }
					   if($row2[6]=='N')
						 {				 
						 $valorcred=$_POST[bomberil];
						 $valordeb=0;

						 }					 
						 $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $_POST[idcomp]', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Bomberil $_POST[ageliquida]','',".$valordeb.",$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 						
						}						
					  }
			  }  
		  }
		//**********************
		 }//**** FIN DEL ELSE DE PRIMERA SQL GUARDA LIQUIDACION ***********************
	

    
}
?>	
</form>
 </td></tr>
</table>
</body>
</html>