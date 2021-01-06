<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
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

if (document.form2.fecha.value!='' && document.form2.tercero.value!='')
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
antvigac=document.getElementById('antivigact').value;
antvigan=document.getElementById('antivigant').value;
//alert('entro1');
acum=parseFloat(indus)+parseFloat(antvigac)-parseFloat(antvigan)+parseFloat(avis)-parseFloat(retencion)+parseFloat(sancion)+parseFloat(bomber)+parseFloat(valtot)+parseFloat(interes);
if(acum<0)
{
//alert('entro1');
document.getElementById('saldopagar').value=0;
document.getElementById('saldofavor').value=(parseFloat(acum)*-1);
//alert('entro11');
}
if(acum>=0)
{
//alert('entro2');
document.getElementById('saldopagar').value=(parseFloat(acum));
//alert('entro22');
document.getElementById('saldofavor').value=0;
}

//alert('entro2');
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
  <td colspan="3" class="cinta"><a href="teso-industria_fijo.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#" onClick="guardar()" ><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscaindustria.php"> <img src="imagenes/busca.png"  alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> <a href="#" onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a></td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
	$check1="checked";
	$chkav=" ";
	$fec=date("d/m/Y");
	$_POST[vigencia]=$vigencia;
	$_POST[ageliquida]=$vigencia;
	$_POST[industria]=0;
	$_POST[avisos]=0;
	$_POST[sanciones]=0;
	$_POST[retenciones]=0;
	$_POST[bomberil]=0;		
	$_POST[valortotal]=0;	
	$_POST[intereses]=0;	
	$_POST[antivigact]=0;
	$_POST[antivigant]=0;
	$_POST[saldopagar]=0;	
	$linkbd=conectar_bd();
	$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[0];
	}
	$sqlr="select salario from admfiscales where vigencia=".$vigusu;
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[salariomin]=$row[0];
	}
	$sqlr="select max(id_industria) from tesoindustria ";
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
if($_POST[sinavisos]==1)
{
 $chkav=" checked ";
}
else
{
 $chkav=" ";
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
			  $sqlr="select *from codigosciiu_fijos where codigosciiu_fijos.codigo='$_POST[ciiu]'";
				//echo $sqlr;
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
        <td  ><input name="salariomin" type="hidden" size="5" value="<?php echo $_POST[salariomin]?>" >
        <input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  readonly></td>
	  <td   class="saludo1">Fecha:        </td>
        <td ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>     </td>
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
        </td><td class="saludo1">Cuotas:</td><td><select name="ncuotas" id="ncuotas" onKeyUp="return tabular(event,this)" >
          <option value="1" <?php if($_POST[ncuotas]=='1') echo "SELECTED"; ?>>1</option>
          <option value="2" <?php if($_POST[ncuotas]=='2') echo "SELECTED"; ?>>2</option> </select></td>
        </tr>
      <tr>
        <td  class="saludo1">NIT/Cedula: </td>
        <td ><input id="tercero" type="text" name="tercero" size="10" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>">
          <a href="#" onClick="mypop=window.open('terceros-ventana.php?','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
			  <td class="saludo1">Contribuyente:</td>
	  <td  ><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" size="35" onKeyUp="return tabular(event,this) "  readonly><input type="hidden" value="0" name="bt"><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  
	    <input type="hidden" value="1" name="oculto"></td>
	 
       <td class="saludo1" width="30px">Ing Gravables:</td><td><input type="text" id="ingreso" name="ingreso" value="<?php echo $_POST[ingreso]?>" size="20" onKeyUp="return tabular(event,this)" ></td><td class="saludo1">Acti Economica:</td><td><input type="text" name="ciiu" value="<?php echo $_POST[ciiu]?>" size="2" onKeyUp="return tabular(event,this) " onBlur="consultaciiu()"><input type="hidden" name="tciiu" value="<?php echo $_POST[tciiu]?>" ><input type="hidden" name="nciiu" value="<?php echo $_POST[nciiu]?>" > <input type="hidden" value="0" name="bci">  <a href="#" onClick="mypop=window.open('ciiu-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
          </td><td colspan="1"><span class="saludo3"><input type="checkbox" name="sinavisos" value="1" <?php echo $chkav;?> onClick="validar()">Sin Avisos</span></td><td colspan="1"><input  type="button" name="agregact" id="agregact" value="Agregar" onClick="agregardetalled()"><input type="hidden" value="0" name="agregadetdes"><input type='hidden' name='eliminadac' id='eliminadac'  ></td></tr>
	  </table>
      
       <?php 	
		if ($_POST[eliminadac]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[eliminadac];
		 unset($_POST[dciiu][$posi]);
		 unset($_POST[dnciiu][$posi]);
		 unset($_POST[dtarifas][$posi]);
		 unset($_POST[dingresoact][$posi]);
		 unset($_POST[dvalores][$posi]);		 
		 $_POST[dciiu]= array_values($_POST[dciiu]); 
		 $_POST[dnciiu]= array_values($_POST[dnciiu]); 
		 $_POST[dtarifas]= array_values($_POST[dtarifas]); 
		 $_POST[dingresoact]= array_values($_POST[dingresoact]); 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 
		 }	 
		 if ($_POST[agregadetdes]=='1')
		 {
		 $_POST[dciiu][]=$_POST[ciiu];
		 $_POST[dnciiu][]=$_POST[nciiu];
		 $_POST[dtarifas][]=0;
		 $_POST[dingresoact][]=$_POST[ingreso];
		 $_POST[dvalores][]=$_POST[tciiu];
		 ?>
		 <script>
        document.form2.tciiu.value=0;
        document.form2.ciiu.value="";	
		document.form2.nciiu.value='';	
		document.form2.ingreso.value=0;			
        </script>
		<?php
		 }
		  ?>
      
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
			  document.getElementById('ingreso').focus();document.getElementById('ingreso').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				 alert("Cuenta Incorrecta");document.form2.tercero.select();
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
			 if($_POST[bci]=='1')
			 {
			  $linkbd=conectar_bd();
			  $sqlr="select *from codigosciiu_fijos where codigosciiu_fijos.codigo='$_POST[ciiu]'";
		//		echo $sqlr;
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			  $nresul=$row[1];			  	  
			  if($nresul!='')
			   {
			  $_POST[nciiu]=$nresul;
			  $_POST[tciiu]=$row[2];			  
  				?>
				<script>
				document.form2.nciiu.value=<?php echo $nresul; ?>
				document.form2.tciiu.value=<?php echo $row[2]; ?>
			  document.getElementById('agregact').focus();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[nciiu]="";
			  ?>
			  <script>
				 alert("Codigo Ciiu Incorrecto1");document.form2.ciiu.select();
		  		//document.form2.ciiu.focus();	
			  </script>
			  <?php
			  }
			 }
			 
			?>
      
      <table class="inicio">
      <tr><td class="titulos2">Codigo</td><td class="titulos2">Actividad</td><td class="titulos2">Ingreso Actividad</td><td class="titulos2">Tarifa x mil</td><td class="titulos2">Valor</td><td class="titulos2"><img src="imagenes/del.png" ></td></tr>
    <?php
		$totaldes=0;
		for ($x=0;$x<count($_POST[dciiu]);$x++)
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
		 $_POST[industria]=(round((ceil(($totaldes)))/1000,0)*1000);
		 $minima=0;
//		 echo "salmin:".(($_POST[salariomin]/30));
		//****cuando hay valor minimo
		 /*if(($_POST[industria])<=(($_POST[salariomin]/30)*3))
		  {
		   $_POST[industria]=round(ceil((($_POST[salariomin]/30)*3)/1000),0)*1000;
		   $minima=1;
		  }*/
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
        <td class="titulos" colspan="8">Sanciones</td><td width="108" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
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
						  $_POST[porcentaje]=$row[4];
						  $_POST[nretencion]=$row[1]." - ".$row[2];
						  $_POST[vporcentaje]=($_POST[industria]*$_POST[porcentaje])/100;
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
        <?php 		
		if ($_POST[eliminadac]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[eliminadac];
		 unset($_POST[ddescuentos][$posi]);
		 unset($_POST[dndescuentos][$posi]);
		 unset($_POST[dporcentajes][$posi]);
		 unset($_POST[ddesvalores][$posi]);
		 $_POST[ddescuentos]= array_values($_POST[ddescuentos]); 
		 $_POST[dndescuentos]= array_values($_POST[dndescuentos]); 
		 $_POST[dporcentajes]= array_values($_POST[dporcentajes]); 
		 $_POST[ddesvalores]= array_values($_POST[ddesvalores]); 		 
		 }	 
		 if ($_POST[agregadetdes]=='1')
		 {
		 $_POST[ddescuentos][]=$_POST[sancion];
		 $_POST[dndescuentos][]=$_POST[nsancion];
		 $_POST[dporcentajes][]=$_POST[porcentaje];
		 $_POST[ddesvalores][]=$_POST[vporcentaje];
		 $_POST[agregadetdes]='0';
		 ?>
		 <script>
        document.form2.porcentaje.value=0;
        document.form2.vporcentaje.value=0;	
		document.form2.retencion.value='';	
        </script>
		<?php
		 }
		  ?>
      
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
		 $linkbd=conectar_bd();
		 $sqlr="select *from tesoingresos_det where codigo='02' and vigencia='$vigusu'";
		 $res=mysql_query($sqlr,$linkbd);
		 while($row=mysql_fetch_row($res))
		  {
			if($row[2]=='05')
			  {
			   $_POST[avisos]=round((ceil($row[5]*($_POST[industria]/100)))/1000,0)*1000;
//			   $_POST[avisos]=ceil(number_format($_POST[avisos],2,'.',''));
			  }
			if($row[2]=='06')
			  {
			   $_POST[bomberil]=round((ceil($row[5]*($_POST[industria]/100)))/1000,0)*1000;
	//		   $_POST[bomberil]=ceil(number_format($_POST[bomberil],2,'.',''));
			  }  
		  }
		  $limite=($_POST[salariomin]/30)*3;
//			   echo "lim ".$limite." ind ".$_POST[industria];
		  if($_POST[sinavisos]==1 )		 
		   {			   
			   if($minima==1)
			   {
			   $_POST[industria]=$_POST[industria]+$_POST[avisos];
			   $_POST[avisos]=0;
			   }
			   else
			   {
				$_POST[avisos]=0;
			   }
			}
			else
			{
				
			}
			$sumacuenta=0;
		 $sumacuenta=$_POST[industria]+$_POST[antivigact]-$_POST[antivigant]+$_POST[avisos]-$_POST[retenciones]+$_POST[sanciones]+$_POST[bomberil]+$_POST[valortotal]+$_POST[intereses]+$_POST[valortotal];
		 if($sumacuenta<0)
		 {
		 $_POST[saldopagar]=0;
		 $_POST[saldofavor]=abs($sumacuenta);
		 }
		 if($sumacuenta>=0)
		 {
		 $_POST[saldopagar]=abs($sumacuenta);
		 $_POST[saldofavor]=0;
		 }

         ?>          
		<tr>
		
		  <td width="21%" class="saludo1">Industria y Comercio</td><td class="saludo2" width="79%"><input id="industria" onBlur="sumarindustria()" name="industria" type="text" value="<?php echo $_POST[industria]?>" ></td></tr>
		  <tr><td class="saludo1">Avisos y Tableros</td><td class="saludo2"><input id="avisos" name="avisos" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[avisos]?>"></td></tr>		
		  <tr><td class="saludo1">Anticipo Vigencia Actual</td><td class="saludo2"><input id="antivigact" name="antivigact" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[antivigact]?>" ></td></tr>
		    <tr><td class="saludo1">Anticipo Vigencia Anterior</td><td class="saludo2"><input id="antivigant" name="antivigant" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[antivigant]?>" ></td></tr>
		  <tr><td class="saludo1">Retenciones</td><td class="saludo2"><input id="retenciones" name="retenciones" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[retenciones]?>" ></td></tr>		  
		  <tr><td class="saludo1">Sanciones</td><td class="saludo2"><input type="text" id="sanciones" name="sanciones" value="<?php echo $_POST[sanciones]?>" onBlur="sumarindustria()"></td></tr>
		  <tr><td class="saludo1">Recargo Bomberil</td><td class="saludo2"><input id="bomberil" name="bomberil" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[bomberil]?>" ></td></tr>
		  <tr><td class="saludo1">Valor Total</td><td class="saludo2"><input id="valortotal" name="valortotal" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[valortotal]?>" readonly></td></tr>
		  <tr><td class="saludo1">Intereses</td><td class="saludo2"><input type="text" id="intereses" name="intereses" value="<?php echo $_POST[intereses]?>" onBlur="sumarindustria()"></td></tr>
		  <tr><td class="saludo1">Saldo a Pagar</td><td class="saludo2"><input id="saldopagar" name="saldopagar" type="text" onBlur="sumarindustria()" value="<?php echo number_format($_POST[saldopagar],2,'.','')?>" readonly></td>
		  </tr>
		  <tr><td class="saludo1">Saldo a Favor</td><td class="saludo2"><input id="saldofavor" name="saldofavor" type="text" onBlur="sumarindustria()" value="<?php echo number_format($_POST[saldofavor],2,'.','')?>" readonly></td>
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
	$sqlr="insert into tesoindustria (fecha,vigencia,ageliquidado,tipo,tercero,valortotal,estado,ncuotas,pagos) values ('$fechaf','".$vigusu."','$_POST[ageliquida]','$_POST[tipomov]','$_POST[tercero]',$_POST[saldopagar],'S',$_POST[ncuotas],0)";
	if (!mysql_query($sqlr,$linkbd))
		{
		 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
		 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     	 echo "</pre></center></td></tr></table>";
		 }
  		else
  		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Liquidacion con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
		//*******************CREACION DEL DETALLE ***************
		$idliquidacion=mysql_insert_id();		
		$_POST[idcomp]=$idliquidacion;
		$sqlr="insert into tesoindustria_det (id_industria,industria,avisos,bomberil,retenciones,sanciones,intereses,valortotal,totalpagar,estado,antivigant,antivigact,saldofavor) values ($idliquidacion, $_POST[industria],$_POST[avisos],$_POST[bomberil],$_POST[retenciones],$_POST[sanciones],$_POST[intereses], $_POST[valortotal],$_POST[saldopagar], 'S',$_POST[antivigant],$_POST[antivigact],$_POST[saldofavor])";
		mysql_query($sqlr,$linkbd);
		//***********ALMACENAMIENTO DE LOS CIIU ************************
		for ($x=0;$x<count($_POST[dciiu]);$x++)
		 {		
		$sqlr="insert into tesoindustria_ciiu(id_industria,codigociiu,tarifa,ingreso,valor,estado) values  ($idliquidacion,'".$_POST[dciiu][$x]."',".$_POST[dtarifas][$x].",".$_POST[dingresoact][$x].",".$_POST[dvalores][$x].",'S')";
		mysql_query($sqlr,$linkbd);
		 }
		 $nter=buscatercero($_POST[tercero]);
		//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
		  $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($idliquidacion,3,'$fechaf','INDUSTRIA Y COMERCIO $_POST[ageliquida] - $nter ',0,$_POST[saldopagar],$_POST[saldopagar],0,'1')";
		  mysql_query($sqlr,$linkbd);
	//echo "<br>$sqlr ";
		//*******************DETALLE DEL COMPROBANTE CONTABLE *****************************
		 //*************BUSCAR EL CONCEPTO CONTABLE DEL INGRESO INDUSTRIA Y COMERCIO *****************
		 $sqlr="select *from tesoingresos_det where codigo='02' and vigencia=$vigusu";
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
						  $valordeb=$_POST[industria]+$_POST[sanciones]-$_POST[retenciones];
						 $valorcred=0;
						 }
					   if($row2[6]=='N')
						 {				 
						 $valorcred=$_POST[industria]+$_POST[sanciones]-$_POST[retenciones];
						 $valordeb=0;
						 }				
						 $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $idliquidacion', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Industria y Comercio $_POST[ageliquida]','',".$valordeb.",$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
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
						 $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $idliquidacion', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Avisos y Tableros $_POST[ageliquida]','',".$valordeb.",$valorcred,'1','".$_POST[vigencia]."')";
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
						 $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $idliquidacion', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Bomberil $_POST[ageliquida]','',".$valordeb.",$valorcred,'1','".$_POST[vigencia]."')";
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