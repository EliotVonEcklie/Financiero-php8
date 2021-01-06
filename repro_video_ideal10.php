<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	sesion();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	if(@ $_POST['oculto']=="")
	{
		$_POST['codid']=$_GET['cod'];
		$sqlarc="SELECT nomarchivo FROM adm_ayuda_det WHERE estado='S' AND tipo='V' AND idayuda='".$_POST['codid']."'";
		$resarc = mysqli_query($linkbd,$sqlarc);
		$rowarc = mysqli_fetch_row($resarc);
		$_POST['archivid']="informacion/ayudas/fijo/".$rowarc[0];
	}
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>Reproductor de Video</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<input type="hidden" name="codid" id="codid" value="<?php echo $_POST['codid'];?>"/>
		<input type="hidden" name="archivid" id="archivid" value="<?php echo $_POST['archivid'];?>"/>
		<input type="hidden" name="oculto" id="oculto" value="1"/>
		<section id="reproductor">
			<video id="medio" style="width:850;height: 450;"  controls>
				<source src="<?php echo $_POST['archivid'];?>"/>
			</video>
		</section>
		<script type='text/javascript'>
			document.oncontextmenu = function(){return false}
		</script>
	</body>
</html>