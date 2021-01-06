<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
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
//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.vigencia.value!='' && document.form2.valorunidad.value!='' && document.form2.unidad.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
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
  <td colspan="3" class="cinta">
	<a href="teso-unidad.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
	<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
	<a href="teso-buscaunidad.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a>
	<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
  </td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 		 $fec=date("d/m/Y");
		 $_POST[vigencia]=$vigusu;
		 $_POST[fecha]=$fec; 		 		  			 
}
?>
 <form name="form2" method="post" action="">
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="9">Parametrizacion Unidad Predial</td>
        <td width="80" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
	  <td width="10%"  class="saludo1">Tipo unidad: </td>
        <td width="15%" ><select name="unidad" id="unidad"> <option value="">Seleccione el valor..</option> <option value="uvt">UVT</option><option value="uvt">SMMLV</option></select> </td><td width="10%" class="saludo1">Valor:</td>
        <td width="15%" ><input name="valorunidad" type="text" value="<?php echo $_POST[valorunidad]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="text-align: right; "> </td> <td width="10%" class="saludo1">Vigencia:</td>
        <td width="25%" ><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="4" size="4" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"> </td>
       </tr> 
      </table>
	<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]; ?>" />
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	$sqlr="select *from tesounidadpred where vigencia=$_POST[vigencia]";
	$resp=(mysql_query($sqlr,$linkbd));
	$ntr = mysql_num_rows($resp);
 
	if ($ntr>0)
 	{
		?>
		<script>
		alert("Ya existe parametrizacion para esta vigencia");
		</script>
	<?php
	}	
 	
	else	
 	{
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//************** modificacion del presupuesto **************
	
	$sqlr="insert into tesounidadpred (tipo,valor,vigencia) values ('$_POST[unidad]',$_POST[valorunidad],'$_POST[vigencia]')";	  
	
	
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 echo "<pre>";
     echo "</pre></center></td></tr></table>";
	}
  		else
  		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la parametrizacion con Exito</center></td></tr></table>";
		  ?>
		  <script>
		  </script>
		  <?php
		  }
	}	  
}
?>	
    </form> 
</table>
</body>
</html>