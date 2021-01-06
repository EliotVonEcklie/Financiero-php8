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
        <title>:: SieS - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
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
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
				<a href="presu-importacuentas.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
				<a class="mgbt"><img src="imagenes/buscad.png"/></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
    		</tr>
        </table>
 <form action="presu-importacuentas.php" method="post" enctype="multipart/form-data" name="form2">
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="6">.: Importar Plan de Cuentas Presupuestales</td><td width="70" class="cerrar"><a href="presu-principal.php"> Cerrar</a></td>
      </tr>   
       <tr> <td width="142"  class="saludo1">Seleccione Archivo: </td>
        <td width="273" >
          <input type="file" name="archivotexto" id="archivotexto"></td>
        
        <td width="100" class="saludo1" >Vigencia:</td>
        <td width="453" ><input name="vigencia" type="text" size="4" maxlength="4" value="<?php echo $_POST[vigencia]?>" onKeyUp="return tabular(event,this) " onKeyPress="javascript:return solonumeros(event)" >          <input type="button" name="generar" value="Cargar" onClick="document.form2.submit()">
          <input name="oculto" type="hidden" value="1"></td>
       </tr>  
	   <tr><td></td></tr>                  
    </table>
    
	<div class="subpantalla" style="height:67.1%; width:99.6%; overflow-x:hidden;">
  <?php
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
	if(is_uploaded_file($_FILES['archivotexto']['tmp_name']))
	{
	 $archivo = $_FILES['archivotexto']['name'];
	$archivoF = "./archivos/$archivo";
	if(move_uploaded_file($_FILES['archivotexto']['tmp_name'],$archivoF))
		 {
		 //echo "El archivo se subio correctamente";
		 }
	}
$linkbd=conectar_bd();
//Borrar el balance de prueba anterior
$sqlr="Delete from pptocuentas where vigencia='$_POST[vigencia]'";
//echo $sqlr;
mysql_query($sqlr,$linkbd);
$fich=$archivoF;
//echo "Archivo: $fich <br>";
$contenido = fopen($fich,"r+"); 
$exito=0;
$errores=0;
echo "<table class='inicio'>";
 while(!feof($contenido))
 { 
 $buffer = fgets($contenido,4096);
 $datos = explode(";",$buffer);
//echo "<br>Linea ".trim($datos[0])." ".trim($datos[1])." ".trim($datos[2])." ".trim($datos[3])." " ;
//$arrayDatos = explode(",", $linea); 
//echo "<br>Linea ".implode(',', trim($datos)) ;
//echo "Campos=".count($datos)."<br>";
$tama=count($datos);
//echo "$tama=='5' && 1==".is_numeric($datos[0])." && $_POST[vigencia]==$datos[4]";
if($tama=='5' && true==is_numeric($datos[0]))
{
$consulta = "INSERT INTO pptocuentas (cuenta,nombre,tipo,estado,vigencia) VALUES ('".trim($datos[0])."','".trim(ucfirst(strtolower($datos[1])))."','".ucfirst(trim(strtolower($datos[2])))."','S','".trim(strtoupper($datos[4]))."')"; 
//implode("','", $arrayDatos) ."')"; 
if (!mysql_query($consulta,$linkbd))
				{
			echo "<tr><td class='saludo1'>".$consulta ."<center> Error en la Insercion <img src='imagenes/alert.png' ></center></td></tr>"; 
			$errores+=1;
			}
			else
			{
				 //echo "<tr><td class='saludo1'><center>Se ha Insertado con Exito: $exito <img src='imagenes/confirm.png' ></center></td></tr>"; 
				$exito+=1;
			}
	}
	else
	{
	 $errores+=1;
	 echo "<tr><td class='saludo1'><center>'".$datos[0].', '.$datos[1].', '.$datos[2].', '.$datos[4]."-".is_numeric($datos[0])." tam=$tama' Error en la Insercion <img src='imagenes/alert.png' ></center></td></tr>";
	}
//if(mysql_error()) { 
//echo mysql_error() ."<br>\n"; 
//} 
 }
 echo "<tr><td class='saludo1'><center>Se han Insertado con Exito: $exito <img src='imagenes/confirm.png' ></center></td></tr>"; 
 echo "<tr><td class='saludo1'><center>Errores: $errores <img src='imagenes/alert.png' ></center></td></tr>"; 
 echo "</table>"; 
}
?> 
</div></form></td></tr>
<tr><td></td></tr>      
</table>

</body>
</html>