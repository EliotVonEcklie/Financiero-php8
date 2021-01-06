<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
require('comun.inc');
require"funciones.inc"; 
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>Documento sin título</title>
<?php titlepag();?>
</head>
<body>
<?php
$linkbd=conectar_bd();
$sqlr="select * from tesoreciboscaja order by ID_RECIBOS DESC";
$res=mysql_query($sqlr,$linkbd);
echo "$sqlr<br>";
while($row=mysql_fetch_row($res))
 {
	$sqlr="select * from comprobante_cab where id_comp=".$row[1];
	$res2=mysql_query($sqlr,$linkbd);
	echo "$sqlr<br>";
	while($row2=mysql_fetch_row($res2))
	 {
		$sqlr2="update comprobante_det  set id_comp='5 ".$row[0]."' where id_comp='5 ".$row2[1]."'";
		$res2=mysql_query($sqlr2,$linkbd); 
		echo "$sqlr2<br>";
	 }
	$sqlr2="update comprobante_cab  set numerotipo =$row[0] where id_comp=".$row[1];
	$res2=mysql_query($sqlr2,$linkbd);
	echo "$sqlr2<br>";
 }
?>
</body>
</html>