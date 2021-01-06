<!--V 1000 14/12/16 -->
<?php
	require "comun.inc";
	require "funciones.inc";
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
		<title>:: Contabilidad</title>
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
	<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("cont");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a class="mgbt"><img src="imagenes/add2.png"/></a>
			<a class="mgbt"><img src="imagenes/guardad.png" /></a>
			<a class="mgbt"><img src="imagenes/buscad.png"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a class="mgbt" href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="cont-programacioncontable.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>
</table>
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
        <td class="titulos" colspan="1">.: Configuracion Contable </td>
        <td width="61" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>

	 <tr>
	 <td>
		<ol id="lista2">
			<li onclick="location.href='presu-buscaconcecontablespag.php'" style="cursor:pointer;">Conceptos Contables de Pagos</li>
			<li onclick="location.href='presu-buscaconcecontablescausa.php'" style="cursor:pointer;">Conceptos Contables de Gasto</li>	
			<li onclick="location.href='teso-buscaconcecongastosban.php'" style="cursor:pointer;">Parametros Contables Ingresos / Gastos Bancario</li>
			<li onclick="location.href='teso-buscaconcecontablescausa.php'" style="cursor:pointer;">Parametros Contables Ingresos</li>
			<li onclick="location.href='teso-buscaconcecontablespredial.php'" style="cursor:pointer;">Parametros Contables Prescripciones Predial</li>
			<li onclick="location.href='teso-buscaconcecontablesanticipo.php'" style="cursor:pointer;">Parametros Anticipo</li>
			<li onclick="location.href='teso-buscaconceretencion.php'" style="cursor:pointer;">Parametros Retencion Causacion DB</li>
			<li onclick="location.href='teso-buscaconceretencioningresos.php'" style="cursor:pointer;">Parametros Retencion Ingresos CR</li>
			<li onclick="location.href='teso-buscaconceretencionsgr.php'" style="cursor:pointer;">Parametros Retencion SGR</li>		
		</ol>
	</td>
	
	</tr>			
    </table>
</form>
</table>
</body>
</html>