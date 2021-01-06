<?php 
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require "comun.inc";
	require"funciones.inc";
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<title>:: Spid</title>
		<script>
			function continuar(){parent.despliegamodalm("hidden");}
			var tecla01 = 13;
			$(document).keydown(function(e){if (e.keyCode == tecla01){continuar();}})
		</script>
	</head>
	<?php 
		$frase = explode("TsaltoT", $_GET['titulos']);
		$nlineas=count($frase);
		if ($nlineas<=2){echo"<body style='overflow:hidden'></br></br>";}
		else{echo"<body style='overflow-x:hidden'>";}
		echo "
			<table class='inicio'>
				<tr>
					<td class='saludo1' style='text-align:center;'><img src='imagenes\alert.png' style='width:25px'>$frase[0]<img src='imagenes\alert.png' style='width:25px'></td>
			</tr>";
		if ($nlineas!=1) {for ($x=1;$x<$nlineas;$x++){echo"<tr><td style='text-align:center;font-size:8pt'>$frase[$x]</td></tr>";}}
		echo"
			</table>
			<table>
				<tr style='height:35px;'>
					<td style='padding-bottom:5px;text-align:center'><em class='botonflecha' onClick='continuar();''>Continuar</em></td>
				</tr>
			</table>
		</body>";
	?>
		<script>document.getElementById('continuar').focus();</script>
</html>