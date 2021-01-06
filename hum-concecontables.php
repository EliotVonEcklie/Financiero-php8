<!--V 1000 14/12/16 -->
<?php
  require "comun.inc";
  require "funciones.inc";
  session_start();
  $linkbd=conectar_bd();  
  cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
  header("Cache-control: private"); // Arregla IE 6
  date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: Contabilidad</title>
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
<script src="css/calendario.js"></script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("cont");?></tr>
<tr>
  <td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png"  title="Nuevo" border="0" /></a><a class="mgbt"><img src="imagenes/guardad.png"  title="Guardar" /></a><a class="mgbt"><img src="imagenes/buscad.png" title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a><a href="cont-programacioncontable.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
</tr></table>
<tr><td colspan="3" class="tablaprin"> 
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
        <td width="61" class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
      </tr>
    <tr>
		<td>
			<ol id="lista2">
        <li onclick="location.href='hum-buscaconcecontablesnomina.php'" style="cursor:pointer;">Parametros Contables Nomina</li>
				<li onclick="location.href='hum-buscavariablesretenciones.php'" style="cursor:pointer;">Concepto contable retencion - tercero</li>
        <li onclick="location.href='hum-buscafuncionamiento.php'" style="cursor:pointer;">Funcionamiento</li>
				<li onclick="location.href='hum-buscafuncionamientotemporal.php'" style="cursor:pointer;">Funcionamiento Temporal</li>
				<li onclick="location.href='hum-buscainversion.php'" style="cursor:pointer;">Inversi&oacute;n</li>
        <li onclick="location.href='hum-buscainversiontemporal.php'" style="cursor:pointer;">Inversi&oacute;n Temporal</li>
			</ol>
		</td>
	 </tr>
    </table>
</form>
</table>
</body>
</html>