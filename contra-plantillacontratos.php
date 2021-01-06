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
<title>:: Spid - Contratacion</title>
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
function guardar()
{
if (document.form1.tituloplantilla.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form1.oculto.value=2;
  	document.form1.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  }
 }

function validar()
{
//document.form2.action="contra-terceros.php";
document.form1.submit();
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

function eliminard(variable)
{
if (confirm("Esta Seguro de Eliminar "+variable))
  {
document.form1.eliminar.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('eliminar');
//eli.value=elimina;
vvend.value=variable;
// alert("Falta informacion para poder Agregar");
document.form1.submit();
}
}

function buscacta(e)
 {
if (document.form1.cuenta.value!="")
{
 document.form1.bc.value='1';
 document.form1.submit();
 }
 }

function agregardetalle()
{
//	 alert("Falta informacion para poder Agregar"+document.form1.nvariable.value);
if(document.form1.nvariable.value!="" )
{ 
				document.form1.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form1.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}

function cargarotro()
{
 document.form1.cargafile.value=1; 
 document.form1.oculto.value=1; 
 document.form1	.submit(); 
}

function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form1.elimina.value=variable;
//eli=document.getElementById(elimina);
document.getElementById('elimina').value=variable;
//eli.value=elimina;
//vvend.value=variable;
document.form1.submit();
}
}

function agregardetallev()
{
	//alert("Falta informacion para poder Agregar");
consta= document.getElementById("listavar").value
//document.getElementById("").value=	caracter;	
 document.getElementById("plantilla").value= document.getElementById("plantilla").value+"@"+consta+"@";				
}
</script>
<script type="text/javascript" src="css/calendario.js"></script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("contra");?></tr>
	<tr> 
		<td colspan="3" class="cinta">
			<a href="contra-plantillacontratos.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a>
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
			<a class="mgbt"><img src="imagenes/buscad.png"  title="Buscar" border="0" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
		</td>
	</tr>
</table>
<tr><td colspan="3" class="tablaprin"> 
<form name="form1" method="post" enctype="multipart/form-data">
<?php 
if($_POST[oculto]!='')
 {
 $_POST[dproductos]=array();
 $_POST[dproductos]=array();
 $_POST[dtipos]=array(); 
 } 
?>
 <table class="inicio" >
 <tr>
 <td colspan="2" class="titulos">Crear Variables</td><td class="cerrar" ><a href="contra-principal.php"> Cerrar</a></td></tr>
 <tr>
 <td class="saludo1">Nombre Variable:</td><td><input id="nvariable" name="nvariable" type="text" size="20" value="<?php echo $_POST[nvariable]; ?>"  onKeyUp="return tabular(event,this)" > <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet">  <input type='hidden' name='elimina' id='elimina'><input type="hidden" value="1" name="oculto"></td>
 </tr>
 </table>
 <?php
 if ($_POST[elimina]!='')
		 { 
		 $posi=$_POST[elimina];
		 unset($_POST[listavariables][$posi]); 				 
		 $_POST[listavariables]= array_values($_POST[listavariables]); 			 	
		 $_POST[elimina]='';	 		 		 		 
		 }
if ($_POST[agregadet]=='1')
		 {
			$ch=esta_en_array($_POST[listavariables],$_POST[nvariable]);
			if($ch!='1')
			 {			 
		 $_POST[listavariables][]=$_POST[nvariable];		
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.nvariable.value="";			
				document.form2.nvariable.select();
		  		document.form2.nvariable.focus();	
		 </script>
		  <?php
			}
			else
			 {
			?>
		 <script>
		  	 alert('Ya existe la Variable');
		</script>
			<?php
			 }
		  }
	//**************AGREGA LA VARIABLE AL TEXTO **********	  
	?> 
 <table class="inicio" >
 <tr><td class="titulos" colspan="2">Lista Variables</td></tr>
 <tr><td class="saludo1">Variables:</td>
 <td><select id="listavar" name="listavar">
 <option value="">Seleccione...</option>
 <?php
 for ($x=0;$x<count($_POST[listavariables]);$x++)
 {
	 echo "<option value=".$_POST[listavariables][$x]." >".$_POST[listavariables][$x]."</option>";
 }
 ?>
 </select> <input type="button" name="agregarv" id="agregarv" value="   Insertar Variable   " onClick="agregardetallev()" ><input type="hidden" value="0" name="agregadetv">
 <?php 
  for ($x=0;$x<count($_POST[listavariables]);$x++)
 {
	 echo "<input type='hidden' name='listavariables[]' value=".$_POST[listavariables][$x]." >";
 }
 ?> </td></tr>
 </table>
 <table class="inicio" >
 <tr>
 <td colspan="6" class="titulos">PLANTILLA</td></tr>
 <tr><td class="saludo1">Nombre Plantilla</td><td><input id="tituloplantilla" name="tituloplantilla" type="text" size="100" value="<?php echo $_POST[tituloplantilla]; ?>"></td></tr>
<tr><td class="saludo1">Cargar Archivo</td><td><input name="archivotexto" type="file" id="archivotexto" value="<?php echo $_POST[archivotexto] ?>" size="5"><input type="button" name="cargar" value=" Cargar " onClick="cargarotro()"><input name="cargafile" type="hidden" value=" <?php echo $_POST[cargafile]?>"></td></tr>
<tr><td colspan="4">
<?php
if($_POST[cargafile]==1)
{
//echo "<div>mof:   ".$_POST[archivotexto]."</div>";	
//echo "<div>archivo:   ".$_FILES['archivotexto']['tmp_name']."</div>";	
 if($_FILES['archivotexto']['tmp_name'])
 {
 	if(is_uploaded_file($_FILES['archivotexto']['tmp_name']))
		{
		 $archivo = $_FILES['archivotexto']['name'];
		 echo "<div>ARCHIVO:   ".$archivo."</div>";	
		$archivoF = "./archivos/$archivo";
		if(move_uploaded_file($_FILES['archivotexto']['tmp_name'],$archivoF))
		 {	
		   $plantilla = file_get_contents($archivoF);  
// Agregamos los escapes necesarios  
			$plantilla = addslashes($plantilla);  
			$plantilla = str_replace(' ','\r',$plantilla);  
			$plantilla = str_replace(' ','\t',$plantilla);  
			echo "<div>Se copiO ARCHIVO:   ".$archivoF."</div>";		 			
		 }
		 else
		 {
		echo "<div>NO se copio ARCHIVO:   ".$_FILES['archivotexto']['name']."</div>";		 
		 }
		}
		else
		{
		echo "<div>NO CARGO ARCHIVO:   ".$_FILES['archivotexto']['tmp_name']."</div>";	
		}
 }
}
?>
</td></tr>
<tr><td class="saludo1">Contenido Plantilla</td><td><textarea id="plantilla" name="plantilla" cols="100" rows="20"><?php echo $_POST[plantilla];?></textarea></td></tr> 
 </table>
 <?php
 if($_POST[oculto]=='2')
	{
	$namearch="plantillas_contratacion/$_POST[tituloplantilla].txt";	
	$linkbd=conectar_bd();
	$sqlr="insert into contraplantillas (nombre_plantilla,titulo_plantilla,archivo_plantilla,estado) values ('$_POST[tituloplantilla]','$_POST[tituloplantilla]','$namearch','S')";
	if(!mysql_query($sqlr,$linkbd))
	 {
	 echo "<div class='saludo1'>NO SE GUARDO LA PLANTILLA <img src='imagenes\alert.png'> $namearch ".mysql_error($linkbd)."</div>";
	 }
	 else
	 {
	$Descriptor1 = fopen($namearch,"w+"); 
	fputs($Descriptor1,"".strtoupper($_POST[tituloplantilla])."\r\n");
	fputs($Descriptor1,$_POST[plantilla]."\r\n");
	fclose($Descriptor1);
	echo "<div class='saludo1'>PLANTILLA CREADA <img src='imagenes\confirm.png'> <a href='$namearch' target='_BLANK'>$namearch</a></div>";
	$id=mysql_insert_id();
	  for ($x=0;$x<count($_POST[listavariables]);$x++)
 		{
		  $sqlr="insert into contraplantillas_vars (id_plantilla,variable) values ($id,'".$_POST[listavariables][$x]."')";
		  mysql_query($sqlr,$linkbd);		  
	  	}	 
	 }
	} 
 ?>
 </form>
</td></tr>     
</table>
</body>
</html>