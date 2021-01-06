<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Spid - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
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
			<a href="#" class="mgbt"><img src="imagenes/add2.png"  alt="Nuevo" border="0" /></a>
			<a href="#" class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" /></a>
			<a href="#" class="mgbt"><img src="imagenes/buscad.png"  alt="Buscar" border="0" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
		</td> 
	</tr>
</table>
<tr><td colspan="3" class="tablaprin"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
$linkbd=conectar_bd();
 if($_POST[consolidado]=='')
 $chkcomp=' ';
 else
 $chkcomp=' checked ';
 if($_POST[cierre]=='')
 {$chkcierre=' ';}
 else
{ $chkcierre	=' checked ';
}
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
	<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Configuracion contable </td>
        			<td class="cerrar" style="width:7%;" ><a href="cont-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
					<td style="background-repeat:no-repeat; background-position:center;">
						<ol id="lista2">
							<li onClick="location.href='cont-mayorybalance.php'" style="cursor:pointer;">Libro Mayor y Balances</li>
                            <li onClick="location.href='cont-librodiario.php'" style="cursor:pointer;">Libro Diario</li>                  
                        </ol>
				</td>                 
				</tr>							
    </table>
   
</form>
</table>
</body>
</html>