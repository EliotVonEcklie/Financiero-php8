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
<title>:: SPID - Tesoreria</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script>
function pdf()
{
document.form2.action="pdfbalance.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script src="css/calendario.js"></script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta">
  <a href="teso-importaciiu.php" class="mgbt"><img src="imagenes/add.png"  alt="Nuevo" title="Nuevo"/></a>
  <a class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" title="Guardar"/> </a>
  <a href="#.php" class="mgbt"> <img src="imagenes/busca.png" alt="Buscar" title="Buscar"/></a> 
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a></td></tr>
</table>
<tr><td colspan="3" class="tablaprin"> 
 <form action="teso-importaciiu.php" method="post" enctype="multipart/form-data" name="form2">
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="5">.: Importar Codigos CIIU</td>
        <td width="72" class="cerrar"><a href="teso-principal.php">Cerrar</a></td>
      </tr>   
       <tr> <td width="142"  class="saludo1">Seleccione Archivo: </td>
        <td width="273" >
          <input type="file" name="archivotexto" id="archivotexto"></td>
        
        <td width="555" ><input type="button" name="generar" value="Cargar" onClick="document.form2.submit()"><input name="oculto" type="hidden" value="1"></td>
       </tr>  
	   <tr><td></td></tr>                  
    </table>
    
	<div class="subpantalla">
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
		 echo "El archivo se subio correctamente";
		 }
	}
$linkbd=conectar_bd();
//Borrar el balance de prueba anterior
$sqlr="Delete from codigosciiu";
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
echo "<br>Linea ".trim($datos[0])." ".trim($datos[1])." ".trim($datos[2])." ".trim($datos[3])." " ;
//$arrayDatos = explode(",", $linea); 
//echo "<br>Linea ".implode(',', trim($datos)) ;
$tama=count($datos);
$consulta = "INSERT INTO codigosciiu (codigo,nombre,porcentaje) VALUES ('".trim($datos[0])."','".trim(ucfirst(strtolower(($datos[1]))))."','".trim(strtoupper($datos[2]))."')"; 
//implode("','", $arrayDatos) ."')"; 
if (!mysql_query($consulta,$linkbd))
				{
			//echo "<tr><td class='saludo1'>".$consulta ."<center> Error en la Insercion <img src='imagenes/alert.png' ></center></td></tr>"; 
			$errores+=1;
			}
			else
			{
				 //echo "<tr><td class='saludo1'><center>Se ha Insertado con Exito: $exito <img src='imagenes/confirm.png' ></center></td></tr>"; 
						$exito+=1;
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