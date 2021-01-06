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
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
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
function pdf()
{
document.form2.action="teso-pdfconsignaciones.php";
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
  <td colspan="3" class="cinta"><a href="teso-consignaciones.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a href="teso-buscaconsignaciones.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a><a href="#" class="mgbt" onClick="pdf()"><img src="imagenes/print.png"  title="Imprimir" /></a></td>
</tr>		  
</table>
<?php

if(!$_POST[oculto])
{
	$linkbd=conectar_bd();
	$sqlr="select DISTINCT *from tesoconsignaciones_cab, tesoconsignaciones,terceros,tesobancosctas   where 	tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban= tesoconsignaciones.ncuentaban and tesobancosctas.estado='S'
 and tesoconsignaciones_cab.id_comp=$_GET[idr] AND tesoconsignaciones_cab.ID_CONSIGNACION=tesoconsignaciones.ID_CONSIGNACIONCAB GROUP BY tesoconsignaciones_cab.ID_CONSIGNACION";
	
	$res=mysql_query($sqlr,$linkbd);
	$cont=0;
	$_POST[numero]=$_GET[dc];
	$_POST[ncomp]=$_GET[dc];
	$total=0;
	while ($row =mysql_fetch_row($res)) 
	{	$p1=substr($row[2],0,4);
		$p2=substr($row[2],5,2);
		$p3=substr($row[2],8,2);
		$_POST[fecha]=$p3."-".$p2."-".$p1;	
		$_POST[dccs][$cont]=$row[10];
		$_POST[dconsig][$cont]=$row[9];			 
		$_POST[dbancos][$cont]=$row[11];		 
		$_POST[dnbancos][$cont]=$row[22];		 
		$_POST[dcbs][$cont]=$row[11];
		$_POST[concepto]=$row[5];
		$total=$total+$row[15]; 
		$_POST[totalc]=$total;
		$_POST[dvalores][$cont]=$row[15];
		$cont=$cont+1;
	
	}
		
}
?>
 <form name="form2" method="post" action=""> 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">.: Ver Consignaciones</td>
        <td width="126" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td  class="saludo1">Fecha:        </td>
        <td ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>        </td>
        <td  class="saludo1">Numero Comprobante:        </td>
        <td><input name="numero" type="text" value="<?php echo $_POST[numero]?>" size="50" onKeyUp="return tabular(event,this)" readonly>        </td>
       <td  class="saludo1">Concepto Consignación:        </td>
	  	
	  <td ><input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" onKeyUp="return tabular(event,this)"  size="50" readonly><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" ></td>
	  </tr> 
	  <tr>
	 <td><input type="hidden" value="0" name="agregadet"><input type="hidden" value="1" name="oculto"><input type="hidden" value="<?php echo $_POST[cuentacaja] ?>" name="cuentacaja">	</td>
	  </tr>
      </table>
	  <div class="subpantallac" style="height:67.3%; width:99.6%; overflow-x:hidden;">
	   <table class="inicio">
	   	   <tr><td colspan="6" class="titulos">Detalle Consignaciones</td></tr>                  
		<tr><td class="titulos2">CC</td><td class="titulos2">Consignacion</td><td class="titulos2">Cuenta Bancaria</td><td class="titulos2">Banco</td><td class="titulos2">Valor <input type='hidden' name='elimina' id='elimina'><input name='ncomp' type="hidden" value="<?php echo $_POST[ncomp] ?>"></td>
</tr>		
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
		 echo "<tr><td class='saludo2'><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='4' readonly></td><td class='saludo2'><input name='dconsig[]' value='".$_POST[dconsig][$x]."' type='text' readonly></td><td class='saludo2'><input name='dcts[]' value='".$_POST[dcts][$x]."' type='hidden' readonly><input name='dbancos[]' value='".$_POST[dbancos][$x]."' type='hidden' ><input name='dcbs[]' value='".$_POST[dcbs][$x]."' type='text' size='45'></td><td class='saludo2'><input name='dnbancos[]' value='".$_POST[dnbancos][$x]."' type='text' size='50' readonly></td><td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15' readonly></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." PESOS";
		 echo "<tr><td colspan='3'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td colspan='5'>Son: <input name='letras' size='100' type='text' value='$_POST[letras]'></td></tr>";
		?> 
	   </table></div>
</form>
 </td></tr>
</table>
</body>
</html>