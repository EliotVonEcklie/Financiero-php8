<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require"funciones.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<?php titlepag();?>
</head>

<body>
<?php
$link=conectar_bd();
$Descriptor1 = fopen("cuentasbase.csv","r"); 
$i=1;
 while(!feof($Descriptor1))
   //$pdf->Cell(25);
	{
	 $buffer = fgets($Descriptor1,4096);
	 $datos = explode(",",$buffer);
 	 $sqlr="INSERT INTO cuentas (cuenta,nombre,naturaleza,centrocosto,tercero,tipo,estado)VALUES ('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]')";
	 echo "<br>$sqlr";
	 $res=mysql_query($sqlr,$link);
	 }
?>
</body>
</html>
