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
<title>:: SieS - Tesoreria</title>

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
document.form2.action="teso-pdfconsignaciones.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script src="css/programas.js"></script>
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
  <td colspan="3" class="cinta"><a href="teso-consignaciones.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#"  onClick="guardar();"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscaconsignaciones.php"> <img src="imagenes/busca.png"  alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> <a href="#" onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a></td>
</tr>	</table>	  
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
$linkbd=conectar_bd();
	$sqlr="select *from cuentacaja where estado='S' and vigencia=".$_SESSION["vigencia"];
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[1];
	}
	$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='8' and EXTRACT(YEAR FROM fecha)=".$_SESSION["vigencia"];
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
?>
 <form name="form2" method="post" action=""> 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="7">Liquidar Predial </td>
        <td width="119" class="cerrar" ><a href="teso-principal.php">X Cerrar</a></td>
      </tr>
      <tr  ><td width="141" class="saludo1" >Numero Comp:</td>
        <td width="199" ><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>"></td>
	  <td width="97"  class="saludo1">Fecha:        </td>
        <td colspan="3" ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">        </td>        
        </tr><tr>
        <td  class="saludo1">Codigo Catastral:        </td>
        <td ><input name="numero" type="text" value="<?php echo $_POST[numero]?>" size="20" onKeyUp="return tabular(event,this)">
          <a href="#" onClick="mypop=window.open('predial-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
			  <td width="137" class="saludo1">Propietario:</td>
	  <td width="549" ><input type="text" id="cedulanit" name="cedulanit" value="<?php echo $_POST[cedulanit]?>" size="30" readonly><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	    <input type="button" name="agregar" id="agregar" value="Liquidar Predial" onClick="agregardetalle()" >
	    <input type="hidden" value="0" name="agregadet">
	    <input type="hidden" value="1" name="oculto">
	    <input type="hidden" value="<?php echo $_POST[cuentacaja] ?>" name="cuentacaja"></td>

       </tr> 
	  </table>
	  <div class="subpantalla">
      <table class="inicio">
	   	   <tr>
	   	     <td colspan="5" class="titulos">Detalle Predial </td>
	   	   </tr>                  
		<tr>
		  <td class="titulos2">Vigencia</td>
		  <td class="titulos2">Codigo Catastral</td>
		  <td class="titulos2">Propietario</td>
		  <td class="titulos2">Valor</td>
		  <td class="titulos2">Sel
		    <input type='hidden' name='elimina' id='elimina'></td></tr>
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
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr><td colspan='2'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td colspan='4'>Son: <input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?> 
      </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$consec=0;
	$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='8' and EXTRACT(YEAR FROM fecha)=".$_SESSION["vigencia"];
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;
//***cabecera comprobante
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,8,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);
	$idcomp=mysql_insert_id();
	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dbancos]);$x++)
	 {
	    //**** consignacion  BANCARIA*****
	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado) values ('8 $consec','".$_POST[dbancos][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Consignacion ".$_POST[dconsig][$x]." ".$_POST[dnbancos][$x]."','',".$_POST[dvalores][$x].",0,'1')";
	echo "$sqlr <br>";
	mysql_query($sqlr,$linkbd);
		//*** Cuenta CAJA **
	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado) values ('8 $consec','".$_POST[cuentacaja]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Consignacion ".$_POST[dconsig][$x]." ".$_POST[dnbancos][$x]."','',0,".$_POST[dvalores][$x].",'1')";
	mysql_query($sqlr,$linkbd);
	echo "$sqlr <br>";
	}	
	//************ insercion de cabecera consignaciones ************
	$sqlr="insert into tesoconsignaciones_cab (id_comp,fecha,vigencia,estado,concepto) values($idcomp,'$fechaf',".$_SESSION["vigencia"].",'S','$_POST[concepto]')";	  
	mysql_query($sqlr,$linkbd);
	$idconsig=mysql_insert_id();
	//************** insercion de consignaciones **************
	for($x=0;$x<count($_POST[dbancos]);$x++)
	 {
	$sqlr="insert into tesoconsignaciones (id_consignacioncab,fecha,ntransaccion,cc,ncuentaban,tercero,tpago,cheque,valor,estado,concepto) values($idconsig,'$fechaf','".$_POST[dconsig][$x]."','".$_POST[dccs][$x]."','".$_POST[dcbs][$x]."','".$_POST[dcts][$x]."','E','',".$_POST[dvalores][$x].",'S','$_POST[concepto]')";	  
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Consignacion con Exito</center></td></tr></table>";
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php
		  }
	}	  
}
?>	
</form>
 </td></tr>
</table>
</body>
</html>