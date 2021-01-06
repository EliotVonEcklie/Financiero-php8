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
  <td colspan="3" class="cinta"><a href="hum-descuentosnom.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"  border="0" /></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="hum-buscadescuentosnom.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$linkbd=conectar_bd();
 ?>	
<?php
if(!$_POST[oculto])
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[tipo]='S';
		 $_POST[deuda]=0;
		 $_POST[cuotas]=0;
		 $_POST[vcuotas]=0;		 		  			 
		 $_POST[valor]=0;	
		  $sqlr="select  MAX(id) from humretenempleados  order by id Desc";
		 //echo $sqlr;
		  $res=mysql_query($sqlr,$linkbd);
		  $row=mysql_fetch_row($res);
		  $_POST[codigo]=$row[0]+1;
		  if(strlen($_POST[codigo])==1)
		   {
			   $_POST[codigo]='0'.$_POST[codigo];
			}	 
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
			 ?>
 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="8">.: Agregar Descuentos de Nomina</td><td class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td  class="saludo1">Codigo:        </td>
        <td ><input name="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>        </td>
        <td class="saludo1">Fecha:</td><td ><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          </td>
        <td  class="saludo1">Descripcion:        </td>
        <td ><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="80" onKeyUp="return tabular(event,this)">        <input name="oculto" type="hidden" value="1">		  </td>
       </tr> 
      </table>
	   <?php
	   $linkbd=conectar_bd();
	   ?>
	    <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Descuento de Nomina</td></tr>                  
	  		  <tr><td width="73" class="saludo1">Tercero:          </td>
          <td width="62"  ><input id="tercero" type="text" name="tercero" size="12" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();"><input type="hidden" value="0" name="bt">
            <a href="#" onClick="mypop=window.open('tercerosnom-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
          <td colspan="4" ><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="100" readonly></td></tr>
          <tr>	       
	  <td width="73"  class="saludo1">Retencion:</td>
	  <td colspan="5"><select name="retencion" id="retencion" >
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from humvariablesretenciones  where estado='S' order by codigo";
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[retencion])
			 	{
				 echo "SELECTED";
				 $_POST[retencionom]=$row[0]." - ".$row[3]." - ".$row[1];
				 }
				echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
			     }   
				?>
		  </select><input id="retencionom" name="retencionom" type="hidden" value="<?php echo $_POST[retencionom]?>" ></td></tr><tr>
		  <td width="73"  class="saludo1">Deuda:</td><td width="62" ><input type="text" name="deuda" value="<?php echo $_POST[deuda]?>" size="12" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"></td>
             <td width="59" class="saludo1">Cuotas:</td><td width="40"><input type="text" name="cuotas" value="<?php echo $_POST[cuotas]?>" size="3" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"></td>
          <td width="56" class="saludo1">Valor Cuota:</td><td width="335"><input type="text" name="vcuotas" value="<?php echo $_POST[vcuotas]?>" size="12" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"></td>
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
    
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$linkbd=conectar_bd();
if ($_POST[nombre]!="")
 {
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];	 
 $nr="1";
 $sqlr="INSERT INTO humretenempleados (id,descripcion,id_retencion,fecha,empleado,deuda,ncuotas,sncuotas,valorcuota,estado)VALUES ('$_POST[codigo]','".$_POST[nombre]."','$_POST[retencion]','$fechaf','$_POST[tercero]',$_POST[deuda],$_POST[cuotas],$_POST[cuotas],$_POST[vcuotas],'S')";
 //echo "sqlr:".$sqlr;
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png' > Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  else
  {
  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Variable con Exito <img src='imagenes/confirm.png' ></center></td></tr></table>";
  }	
 }
else
 {
  echo "<table class='inicio'><tr><td class='saludo1'><center>Falta informacion para Crear la Variable <img src='imagenes/confirm.png' ></center></td></tr></table>";
 }
}
?> </td></tr>
     
</table>
</body>
</html>