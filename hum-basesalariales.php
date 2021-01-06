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
				document.form2.agregadet.value=1;
				// alert("Falta informacion para poder Agregar");
	//			document.form2.chacuerdo.vavlue=2;
				document.form2.submit();
}

function agregarvar()
{
	document.form2.agregavar.value=1;
				// alert("Falta informacion para poder Agregar");
	//			document.form2.chacuerdo.vavlue=2;
				document.form2.submit();		
}

function agregarcte()
{
	//alert("Falta informacion para poder Agregar");
consta= document.getElementById("constante").value	
document.getElementById("ultimoadd").value=	consta;
 document.getElementById("formula").value= document.getElementById("formula").value+consta;				
}

function agregardatos(caracter)
{
	//alert("Falta informacion para poder Agregar");
//consta= document.getElementById("constante").value
document.getElementById("ultimoadd").value=	caracter;	
 document.getElementById("formula").value= document.getElementById("formula").value+caracter;				
}

function borrarf()
{
//	alert("Falta informacion para poder Agregar");
 document.getElementById("formula").value= "";				
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
if (document.form2.codprovision.value!='' && document.form2.nombre.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
 else{
  alert('Faltan datos para completar el registro');
  	document.form2.codprovision.focus();
  	document.form2.codprovision.select();
  }
 }
</script>
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
  <td colspan="3" class="cinta"><a href="hum-basesalariales.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"  border="0" /></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="hum-buscabasesalariales.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
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
 	
}
?>

 <form name="form2" method="post" action="">
<?php //**** busca cuentas
  			if($_POST[bcp]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap],2);			
			  if($nresul!='')
			   {
			  $_POST[ncuentap]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentap]="";	
			   }
			 }
			 if($_POST[bc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuenta],1);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
			 
			 ?>
 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="8">.: Agregar Base Salarial</td><td width="112" class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td class="saludo1">Codigo:s</td>
        <td ><select name="codprovision"  onChange="validar()" onKeyUp="return tabular(event,this)">
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from humvariables where estado='S' and provision='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[codprovision])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
	?>
   </select>  </td>           
       </tr> 
      </table>
	
			    <table class="inicio">
	   <tr><td colspan="7" class="titulos">Detalle Base Salarial</td></tr>                  
	  		  <tr> <td  class="saludo1">Variable Pago:</td><td >
	<select name="variablespago"  onChange="validar()" onKeyUp="return tabular(event,this)">
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from humvariables where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[variablespago])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
	?>
   </select>
    <?php
			//**** busca cuenta
		if ($_POST[agregadet]=='1')
		 {
		  $_POST[formula]=$_POST[formula]."C".$_POST[variablespago];	 
		 $_POST[ultimoadd]="C".$_POST[variablespago];
		 }
		if ($_POST[agregavar]=='1')
		 {
		  $_POST[formula]=$_POST[formula]."".$_POST[variables];	 
		 $_POST[ultimoadd]="V".$_POST[variables];
		 } 
		?>
	<input type="button" name="agregar" id="agregar" value=" Agregar " onClick="agregardetalle()" >
	<input type="button" name="parizq" id="parizq" value=" ( " onClick="agregardatos('(')">
	<input type="button" name="parder" id="parder" value=" ) " onClick="agregardatos(')')">
	<input type="button" name="divi" id="divi" value=" / " onClick="agregardatos('/')">
	<input type="button" name="multi" id="multi" value=" * " onClick="agregardatos('*')">
	<input type="button" name="resta" id="resta" value=" - " onClick="agregardatos('-')">
	<input type="button" name="suma" id="suma" value=" + " onClick="agregardatos('+')">
	<input name="constante" type="text" id="constante" size="10" maxlength="10" onKeyPress="javascript:return solonumeros(event)" value="0" >
	<input type="button" name="bconsta" id="bconsta" value="Cte" onClick="agregarcte()"> 
       <input type="text" name="ultimoadd" id="ultimoadd" value="<?php echo $_POST[ultimoadd]?>" size="8" readonly>
    <input type="button" name="borrar" id="borrar" value="Limpiar" onClick="borrarf()"></td> 	<td><input type="hidden" value="0" name="agregadet"><input type="hidden" value="0" name="agregavar"></td>
    
       </tr>
       <tr><td class="saludo1">Formula:</td><td colspan="2"><textarea id="formula" name="formula" cols="100" rows="5" readonly><?php echo $_POST[formula]?></textarea></td></tr>
    </table>
	

	 <?php
			//**** busca cuenta
			if($_POST[bcp]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap],2);
			  if($nresul!='')
			   {
			  $_POST[ncuentap]=$nresul;
  			  ?>
<script>
			  document.getElementById('codigo').focus();
			  document.getElementById('codigo').select();
			  document.getElementById('bcp').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentap]="";
			  ?>
	  <script>alert("Cuenta Incorrecta");
			  document.form2.cuentap.focus();
			  document.form2.cuentap.select();
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
 $nr="1";
 $sqlr="INSERT INTO humbasesprovisiones (codigo,descripcion,formula,estado)VALUES ('$_POST[codprovision]','".($_POST[nombre])."','$_POST[formula]','S')";
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
}
?> </td></tr>
     
</table>
</body>
</html>