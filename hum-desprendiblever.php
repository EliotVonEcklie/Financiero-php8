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
<title>:: SPID - Gestion Humana</title>
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

function buscactap(e)
 {
if (document.form2.cuentap.value!="")
{
 document.form2.bcp.value='1';
 document.form2.submit();
 }
 }

function validar()
{
document.form2.oculto.value=2;	
document.form2.submit();
}

function agregardetalle()
{
if(  document.form2.concecont.value!="")
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.vavlue=2;
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
if (document.form2.codigo.value!='' && document.form2.nombre.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
 else{
  alert('Faltan datos para completar el registro');
  	document.form2.codigo.focus();
  	document.form2.codigo.select();
  }
 }

function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
</script>
<script type="text/javascript" src="css/calendario.js"></script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("hum");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="hum-descuentosnom.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"  border="0" /></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="hum-buscadescuentosnom.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	  $vact=$vigusu;
$linkbd=conectar_bd();
 ?>	
<?php
if(!$_POST[oculto])
{

}
?>

 <form name="form2" method="post" action="">
<?php  //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
	   $linkbd=conectar_bd();
	   ?>
	    <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Descuento de Nomina</td><td class="cerrar" ><a href="hum-principal.php">Cerrar</a></td></tr>                  
	  		  <tr><td width="73" class="saludo1">Tercero:          </td>
          <td   ><input id="tercero" type="text" name="tercero" size="12" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();"><input type="hidden" value="0" name="bt">
            <a href="#" onClick="mypop=window.open('tercerosnom-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
          <td colspan="1" ><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="100" readonly></td>	       
	  <td   class="saludo1">Vigencia:</td>
	  <td >      <select name="vigencias" id="vigencias" 	>
      <option value="">Sel..</option>
	  <?php	  
      for($x=$vact;$x>=$vact-3;$x--)
	   {
		 $i=$x;  
		 echo "<option  value=$x ";
		 if($i==$_POST[vigencias])
			 	{
				 echo " SELECTED";
				 }
		echo " >".$x."</option>";	    
		}
	  ?>
      </select>
</td>
<td class="saludo1" colspan="1">Mes:</td>
          <td ><select name="periodo" id="periodo"  >
				  <option value="">Seleccione ....</option>
					<?php
					 $sqlr="Select * from meses where estado='S' ";
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[periodo])
			 	{
				 echo "SELECTED";
				 $_POST[periodonom]=$row[1];
				 $_POST[periodonom]=$row[2];
				 }
				echo " >".$row[1]."</option>";	  
			     }   
				?>
		  </select> <input name="oculto" type="hidden" value="1"> <input type="button" name="buscar" value="Buscar " onClick="validar()">
          </td>
</tr>
    </table>        
	 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
<script>
			  document.getElementById('cuentap').focus();
			  document.getElementById('cuentap').select();
			  document.getElementById('bc').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			  <?php
			  }
			 }
		?>
	 <?php
			 //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
			  <script>
			  document.getElementById('retencion').focus();document.getElementById('retencion').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				alert("Tercero Incorrecto o no Existe");				  
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
		?>    
    <?php
	if($_POST[oculto]==2 && $_POST[tercero]!='')
	{
	 echo "<table class='inicio'>";
	?>
    <tr><td colspan="10" class="titulos">Nominas Liquidadas</td></tr>
    <tr><td class="titulos2">No Nomina</td><td class="titulos2">Mes</td><td class="titulos2">Vigencia</td><td class="titulos2">Dias Lab</td><td class="titulos2">Devengado</td><td class="titulos2">Aux Alimentacion</td><td class="titulos2">Aux Transporte</td><td class="titulos2">Total Deducciones</td><td class="titulos2">Total Pago</td><td class="titulos2"><center>Ver</center></td></tr>
    <?php
	$criterio="";
	$criterio2="";	
	if($_POST[vigencias]!="")
	 {
	  $criterio=" and vigencia='".$_POST[vigencias]."'";
	 }
	 if($_POST[periodo]!="")
	 {
	  $criterio2=" and mes='".$_POST[periodo]."'";
	 }
	$sqlr="Select humnomina.id_nom, humnomina.mes,humnomina.vigencia,humnomina_det.netopagar,humnomina_det.diaslab,humnomina_det.devendias,humnomina_det.auxalim,humnomina_det.auxtran, humnomina_det.totaldeduc, humnomina_det.netopagar from humnomina,humnomina_det where humnomina.id_nom=humnomina_det.id_nom and humnomina_det.cedulanit='".$_POST[tercero]."' ".$criterio." ".$criterio2. " and humnomina.estado <> 'N' order by humnomina.vigencia,humnomina.mes";
	$resp = mysql_query($sqlr,$linkbd);
$co="saludo1";
$co2="saludo2";
	while ($row =mysql_fetch_row($resp)) 
	{
		$lastday = mktime (0,0,0,$row[1],1,$row[2]);		
	 echo "<tr class='$co'><td>".$row[0]."</td><td>".strtoupper(strftime('%B',$lastday))."</td><td>".$row[2]."</td><td>".$row[4]."</td><td>".number_format($row[5],2,",",".")."</td><td>".number_format($row[6],2,",",".")."</td><td>".number_format($row[7],2,",",".")."</td><td>".number_format($row[8],2,",",".")."</td><td>".number_format($row[3],2,",",".")."</td><td><a href='verdesprendible.php?idnom=".$row[0]."&mes=".$row[1]."&vigencia=".$row[2]."&cedulanit=".$_POST[tercero]."'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";
	 $aux=$co;
	 $co=$co2;
	 $co2=$aux;
	}
	 echo "</table>";	
	}	
	?>
       </form>
 </td></tr>
     
</table>
</body>
</html>