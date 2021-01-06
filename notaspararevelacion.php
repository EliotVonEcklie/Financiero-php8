<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require "comun.inc";
	require"funciones.inc";
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
		<title>:: SieS</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script> 
			function guardar()
			{
				parent.document.form2.notaf.value =document.form2.texta.value;
				parent.despliegamodal2("hidden");
				parent.document.form2.submit();
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body >
  	<form action="" method="post" name="form2">
		<?php $_POST[nota1]=$_GET[nota];?>
		<table  class="inicio" style="width:99.4%;">
  			<tr >
    			<td class="titulos" colspan="2">:. Notas para Revelaciones</td>
				<td style="width:7%" class="cerrar" ><a onClick="parent.despliegamodal2('hidden');" style="cursor:pointer;">Cerrar</a></td>
			</tr>
      	</table> 
		<div class="subpantalla" style="height:86%; width:99%; overflow-x:hidden;">
			<table>
				<tr >
					<td style="width:4.5cm" class="saludo1">:. Nota:</td>
				</tr>
				<tr>
					<td>
						<input type="hidden" name="nota1" id="nota1" value="<?php echo $_POST[nota1]?>">
						<?php echo "<textarea name='texta' id='texta' rows='24' cols='120' >$_POST[nota1]</textarea>";?>
					</td>
				</tr>
				<tr>
					<td><input type="button" value="Guardar" onClick="guardar()"></td>
				</tr>
			</table>
			
		</div>
		<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
</form>
</body>
</html>
