<?php //V 1000 12/12/16 ?> 
<?php
  require"comun.inc";
  require"funciones.inc";
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
<title>:: SieS - Presupuesto</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
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
//************* genera reporte ************
//***************************************
function guardar()
{
  if (document.form2.documento.value!='')
  {
	  if (confirm("Esta Seguro de Guardar"))
    {
  	 document.form2.oculto.value=2;
  	 document.form2.submit();
    }
  }
  else
  {
  alert('Faltan datos para completar el registro');
  }
}

function validar(formulario)
{
  document.form2.action="contra-terceros.php";
  document.form2.submit();
}

function cleanForm()
{
  document.form2.nombre1.value="";
  document.form2.nombre2.value="";
  document.form2.apellido1.value="";
  document.form2.apellido2.value="";
  document.form2.documento.value="";
  document.form2.codver.value="";
  document.form2.telefono.value="";
  document.form2.direccion.value="";
  document.form2.email.value="";
  document.form2.web.value="";
  document.form2.celular.value="";
  document.form2.razonsocial.value="";
}
</script>

<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("contra");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a class="mgbt"><img src="imagenes/add2.png" title="Nuevo" /></a>
			<a class="mgbt"><img src="imagenes/guardad.png" title="Guardar" /></a>
			<a class="mgbt"><img src="imagenes/buscad.png" title="Buscar" border="0" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
		</td>
	</tr>
</table>
<div class="subpantalla">
	<table class="inicio" width="50%">
		<tr>
			<td colspan="2" class="titulos" width="95%">DATOS BASICOS</td><td class="cerrar" ><a href="contra-principal.php">X Cerrar</a></td></tr>
		<tr> 
			<td class="saludo1" width="2%">1</td>
			<td class="saludo1" colspan="2"><a href="presu-recursos.php">MODALIDAD SELECCION DE CONTRATOS >></a></td></tr>
		<tr> 
			<td class="saludo1" width="2%">2</td><td class="saludo1" colspan="2"><a href="contra-buscaclasificacion.php">PROCEDIMIENTO CONTRATACION >></a></td></tr>
		<tr> 
			<td class="saludo1" width="2%">3</td><td class="saludo1" colspan="2"><a href="contra-buscarecurcgs.php">PROCEDIMIENTO CONTRATACION >></a></td></tr>
		<tr> 
			<td class="saludo1" width="2%">4</td><td class="saludo1" colspan="2"><a href="contra-buscaorigen.php">CLASES DE CONTRATOS >></a></td></tr>
		<tr> 
			<td class="saludo1" width="2%">5</td><td class="saludo1" colspan="2"><a href="contra-buscadestinacion.php">TIPOS DE GASTO >></a></td></tr>
		<tr> 
			<td class="saludo1" width="2%">6</td><td class="saludo1" colspan="2"><a href="contra-buscatercgs.php">SECTORES GASTOS >></a></td></tr>
	</table>
</div>  
</body>
</html>