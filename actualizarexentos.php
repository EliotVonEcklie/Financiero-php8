<?php //V 1000 12/12/16 ?> 
<?php 
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$sqlr1="select fecha,cedulacatastral from tesoexentos";
	$res1=mysql_query($sqlr1,$linkbd);
	while ($row=mysql_fetch_row($res1)) {
		$sqlr="select * from tesoprediosavaluos where codigocatastral='".$row[1]."'";
		$res=mysql_query($sqlr,$linkbd);
		$x=1;
		while($rowi=mysql_fetch_row($res))
		{
			$sqlr1="insert  into tesoexentos_det(fecha,cedulacatastral,estado,vigencia,detalle,valor) values('".$row[0]."','".$rowi[1]."','S','".$rowi[0]."','EXENTO PREDIAL','0') ";
			echo $sqlr1."<br>";
			mysql_query($sqlr1,$linkbd);
			$x+=1;
		}
	}
?>
