<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
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
		<title>:: SieS - Presupuesto</title>
       	<link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
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
//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.acuerdo.value!='')
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
function clasifica(formulario)
{
//document.form2.action="presu-recursos.php";
document.form2.submit();
}
</script>
		<?php titlepag();?>
    </head>
    <body>
    <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
    <span id="todastablas2"></span>
    <table>
        <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
        <tr><?php menu_desplegable("presu");?></tr>
    	<tr>
      		<td colspan="3" class="cinta">
            <a class="mgbt"><img src="imagenes/add2.png" /></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guardad.png"/></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" class="mgbt" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
    </tr></table>
<?php
$vigencia=date(Y);
$linkbd=conectar_bd();
 ?>	
<?php
if(!$_POST[oculto])
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[vigencia]=$vigencia;
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		 
}
?>
 <form name="form2" method="post" action="">
    <table class="inicio" align="center" width="80%" >
      <tr >
        <td class="titulos" colspan="1">.: Reportes Presupuesto</td>
        <td width="61" class="cerrar" ><a href="presu-principal.php"> Cerrar</a></td>
      </tr>    
	 <tr>
 	 <td class="saludo1" colspan="2"><a href="presu-concecontablespag.php">Re</a></td>
	 </tr>
	 <tr>
 	 <td class="saludo1" colspan="2"><a href="presu-concecontablesconpes.php">Conceptos Contables Conpes</a></td>
	 </tr>
    </table>
</form>
</table>
</body>
</html>