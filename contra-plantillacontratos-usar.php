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
document.form1.vreemplaza.value=0;
document.form1.submit();
}

function reemplaza()
{
//document.form2.action="contra-terceros.php";
document.form1.vreemplaza.value=1;
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
 document.getElementById("plantilla").value= document.getElementById("plantilla").value+"["+consta+"]";				
}

function cargarotro()
{
	document.form1.vreemplaza.value=0;
 document.form1.cargafile.value=1; 
 document.form1.oculto.value=1; 
 document.form1	.submit(); 
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
			<a href="contra-plantillacontratos-usar.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a>
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
$linkbd=conectar_bd();
?>
 <table class="inicio" >
 <tr>
 <td colspan="2" class="titulos">Usar Plantilla</td><td class="cerrar" ><a href="contra-principal.php"> Cerrar</a></td></tr>
 <tr>
 <td class="saludo1">Nombre Plantilla:</td><td><select id="listaplantillas" name="listaplantillas" onChange="validar()">
 <option value="">Seleccione...</option>
 <?php
  $sqlr="select *from contraplantillas where estado ='S'";
  $res=mysql_query($sqlr,$linkbd);
  while ($row =mysql_fetch_row($res)) 
  {
	echo "<option value=$row[0] ";
	$i=$row[0];
	 if($i==$_POST[listaplantillas])
			{
			 echo "SELECTED";
			 $_POST[nomarchivo]=$row[3];
			 $_POST[tituarchivo]=$row[2];
			 }
	  echo ">".$row[1]."</option>";	 
  }
 ?>
 </select><input type="text" name="tituarchivo" value="<?php echo $_POST[tituarchivo] ?>"><input type="text" name="nomarchivo" value="<?php echo $_POST[nomarchivo] ?>"><input type="hidden" value="1" name="oculto"></td>
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
  <div class="subpantallac3">  
 <table class="inicio" >
 <tr><td class="titulos" colspan="6">Lista Variables</td></tr> 
 <?php 
  $co=0;
 if ($_POST[vreemplaza]==0)
  {
	  $_POST[tituloplantilla]=$_POST[nomarchivo] ;
  $sqlr="select *from contraplantillas_vars where id_plantilla=$_POST[listaplantillas]";
  $res=mysql_query($sqlr,$linkbd);  
  while ($row =mysql_fetch_row($res)) 
  {
	  if($co==0)
	  {
		echo "<tr>";  
	  }	  
	echo "<td class='saludo1'>".$row[1]."</td><td><input type='text' name='listavariablesv[]' value='".$row[1]."' ><input type='hidden' name='listavariables[]' value='".$row[1]."' ></td>";  
	 $co+=1;
  if($co==3)
	  {
		echo "</tr>";  
		$co=0;
	  } 
  }
  }
  else
  {
  for ($x=0;$x<count($_POST[listavariables]);$x++)
 {
	 if($co==0)
	  {
		echo "<tr>";  
	  }	  
	echo "<td class='saludo1'>".$_POST[listavariables][$x]."</td><td><input type='text' name='listavariablesv[]' value='".$_POST[listavariablesv][$x]."' ><input type='hidden' name='listavariables[]' value='".$_POST[listavariables][$x]."' ></td>";  
	 $co+=1;
  if($co==3)
	  {
		echo "</tr>";  
		$co=0;
	  } 	
	 //echo "<input type='hidden' name='listavariables[]' value=".$_POST[listavariables][$x]." >";
 }
  }
 ?>
 <tr><td><input type="button" name="reemplazar" value="Reemplazar Variables" onClick="reemplaza()"><input type="hidden" value="<?php echo $_POST[vreemplaza] ?>" name="vreemplaza" id="vreemplaza"></td></tr>
 </table>
 </div>
 <table class="inicio" >
 <?php
 if($_POST[nomarchivo]!='')
  {
 $fich=$_POST[nomarchivo];
  $contenido = fopen($fich,"r+"); 
  while(!feof($contenido))
			 { 
 			$buffer .= fgets($contenido,4096);
			 //$datos = explode(";",$buffer);
			 }
$_POST[plantilla]=$buffer;	 
  if($_POST[vreemplaza]==1)
   {
	  // echo "P:".$_POST[plantilla];
	   for ($x=0;$x<count($_POST[listavariables]);$x++)
	   {
		$busca="@".$_POST[listavariables][$x]."@";
		$_POST[plantilla]=preg_replace("/".$busca."/", $_POST[listavariablesv][$x], $_POST[plantilla]);
	   }
    }
  }
 ?>
 <tr> <td colspan="6" class="titulos">PLANTILLA</td></tr>
 <tr><td class="saludo1">Titulo Plantilla</td><td><input id="tituloplantilla" name="tituloplantilla" type="text" size="100" value="<?php echo $_POST[tituloplantilla]; ?>"></td></tr>
<tr><td class="saludo1">Contenido Plantilla</td><td><textarea id="plantilla" name="plantilla" cols="100" rows="20"><?php echo $_POST[plantilla];?></textarea></td></tr>
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
			$plantilla = str_replace('\r','\\r',$plantilla);  
			$plantilla = str_replace('\t','\\t',$plantilla);  
				   echo "P:".count($_POST[listavariables]);
	 		  for ($x=0;$x<count($_POST[listavariables]);$x++)
			   {
				$busca="@".$_POST[listavariables][$x]."@";
				 echo "<br>B:".$busca;
				$plantilla=preg_replace("/".$busca."/", $_POST[listavariablesv][$x], $plantilla);
			   }
    		$nombre_def = "nuevo.DOC"; 
    		$nomnuevo = "nuevoplantilla";  			
			//eval('$rtf = <<<EOF_RTF'.$plantilla.'EOF_RTF;');
			eval( '$rtf = <<<EOF_RTF
' . $plantilla . '
EOF_RTF;
');
			echo "<div>Se copiO ARCHIVO:   ".$nombre_def."</div>";		 			
			file_put_contents("$nomnuevo.rtf",$plantilla);
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
<textarea cols="100" rows="20"><?php echo $plantilla;?>
</textarea><?php 
echo "<a href='$nomnuevo.rtf'>descargar</a>";
?></td></tr>
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