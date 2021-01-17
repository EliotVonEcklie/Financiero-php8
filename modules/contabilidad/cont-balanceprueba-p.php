<?php //V 1000 12/12/16 ?> 
<?php 
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: Spid - Contabilidad</title>
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

function pdf()
{
document.form2.action="pdfbalance.php";
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
		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("cont");?></tr>
		<tr>
			<td colspan="3" class="cinta">
				<a href="cont-tipodoc.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
				<a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
				<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
				<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a>
				<a href="cont-balancepruebaexcel.php" target="_blank" class="mgbt"><img src="imagenes/excel.png" title="excel"></a>
				<a href="<?php echo "archivos/".$_SESSION[usuario]."balanceprueba-nivel$_POST[nivel].csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv"></a>
			</td>
		</tr>
	</table>
 <form name="form2" method="post" action="cont-balanceprueba.php">
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="6" >.: Balance de Prueba</td>
        <td  class="cerrar"><a href="cont-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
        <td class="saludo1">Nivel:</td>
        <td ><select name="nivel" id="nivel">
				   <?php
				   $niveles=array();
		   $link=conectar_bd();
  		   $sqlr="Select * from nivelesctas  where estado='S' order by id_nivel";
			// echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				$niveles[]=$row[4];
				echo "<option value=$row[0] ";
				if($i==$_POST[nivel])
			 	{
				 echo "SELECTED";
				 }
				echo " >".$row[0]."</option>";	  
			     }			
		  ?>
        </select>   <input name="oculto" type="hidden" value="1">     </td>
        <td class="saludo1" >Mes Inicial:</td>
        <td><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
        <td class="saludo1">Mes Final: </td>
        <td><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td></tr>
       <tr> <td class="saludo1" >Cuenta Inicial: </td>
        <td ><input name="cuenta1" type="text" id="cuenta1" size="8" value="<?php echo $_POST[cuenta1]; ?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this) " > <a href="#" onClick="mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
        <td class="saludo1" >Cuenta Final: </td>
		<td ><input name="cuenta2" type="text" id="cuenta2" size="8" value="<?php echo $_POST[cuenta2]; ?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this) "> <a href="#" onClick="mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
        <td ><input type="button" name="generar" value="Generar" onClick="document.form2.submit()"></td>
       </tr>  
	   <tr><td></td></tr>                  
    </table>
    <div class="subpantallap">
    <table>
    <tr><td>cuenta</td><td>debito</td><td>credito</td></tr>
 <?php
 if($_POST[oculto]==1)
{
 ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];

	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
	$f1=$fechafa2;	
	$f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
	
	$fechafa=$_SESSION[vigencia]."-01-01";
	$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
  $link=conectar_bd();
  $sqlr="Select *from vistaprebal where fecha between '$fechaf1' and '$fechaf2'";
  $resp=mysql_query($sqlr,$link);
  if ($resp)
			{
  while($row=mysql_fetch_row($resp))
  { 
   echo "<tr><td>$row[3]</td><td>$row[5]</td><td>$row[6]</td></tr>";
  }
			}
			else
			{
			echo "error:".mysql_error($resp);	
			}
}
?>   </table>
</div> </form></td></tr>
</table>
</body>
</html>