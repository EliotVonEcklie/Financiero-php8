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
		<title>:: Spid - Tesoreria</title>
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
            <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("teso");?></tr>
        <tr>
          <td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
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
        <td class="titulos" colspan="2">.: Configuracion Contable </td>
        <td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr><td class="titulos2" width="50%">Actualizar Contabilidad</td><td class="titulos2" colspan="2" >Actualizar Presupuesto</td></tr>
     <tr>
	 <td class="saludo1" colspan="1"><a href="teso-recibocaja-regrabar.php">Recibos de Caja </a></td>
     	 <td class="saludo1" colspan="2"><a href="teso-recibocaja-regrabarppto.php">Recibos de Caja </a></td>
	 </tr>
	 <tr>
 	 <td class="saludo1" colspan="1"><a href="teso-sinrecibocaja-regrabar.php">Ingresos Internos</a></td>
      	 <td class="saludo1" colspan="2"><a href="teso-sinrecibocaja-regrabarppto.php">Ingresos Internos</a></td>
	 </tr>
     <tr>
 	 <td class="saludo1" colspan="1"><a href="teso-pagonominaver-regrabar.php">Pagar Nomina</a></td>
 	 <td class="saludo1" colspan="2"><a href="teso-pagonominaver-regrabarppto.php">Pagar Nomina</a></td>     
	 </tr>
     <tr>
 	 <td class="saludo1" colspan="1"><a href="teso-girarcheques-regrabar.php">Egresos</a></td>
  	 <td class="saludo1" colspan="2"><a href="teso-girarcheques-regrabarppto.php">Egresos</a></td>
	 </tr>
      <tr>
 	 <td class="saludo1" colspan="1"><a href="teso-recaudos-regrabar.php">Otros Recaudos</a></td>
  	 <td class="saludo1" colspan="2"><a href="teso-editarecaudotransferenciappto.php">Recaudos Transferencias</a></td>
	 </tr>
     <tr>
 	 <td class="saludo1" colspan="1"><a href="teso-egreso-regrabar.php">Liquidacion Cuentas por Pagar</a></td>
  	 <td class="saludo1" colspan="2"><a href="teso-editanotasbancariasppto.php">Notas Bancarias</a></td>
	 </tr>
     <tr>
 	 <td class="saludo1" colspan="1"><a href="teso-sinrecaudos-regrabar.php">Liquidacion Ingresos Internos</a></td>
  	 <td class="saludo1" colspan="2"><a href="teso-editasinsituacionppto.php">Ingresos SSF</a></td>    
     </tr>
     <tr>
 	 <td class="saludo1" colspan="1"><a href="teso-editasinsituacion.php">Ingresos SSF</a></td>
  	 <td class="saludo1" colspan="2"><a href="teso-editasinsituacionegresoppto.php">Egresos SSF</a></td>    
     </tr>     
     <tr>
 	 <td class="saludo1" colspan="1"><a href="teso-editasinsituacionegreso-regrabar.php">Egresos SSF</a></td>
	 <td class="saludo1" colspan="2"><a href="teso-egreso-regrabarppto.php">Liquidacion Cuentas por Pagar</a></td>
     </tr>     
      <tr>
 	 <td class="saludo1" colspan="1"><a href="teso-industriaver-regrabar.php">Liquidacion Industria y Comercio</a></td>
    </tr>
     <tr>
 	 <td class="saludo1" colspan="1"><a href="teso-editapagoterceros.php">Pago Recaudo Terceros</a></td>
    </tr>
    </table>
</form>
</body>
</html>