<?php //V 1000 12/12/16 ?> 
<?php 
	require "comun.inc";
	require"funciones.inc";
	header("Content-Type: text/html;charset=utf-8");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<title>:: Spid</title>
<script>
function continuar()
{parent.funcionmensaje(); parent.despliegamodalm("hidden");}
var tecla01 = 13;
$(document).keydown(function(e){if (e.keyCode == tecla01){continuar();}})
</script>

<link href="css/css2.css" rel="stylesheet" type="text/css" />
</head>
<body style="overflow:hidden"></br></br>
  <table id='ventanamensaje1' class='inicio'>
  	<tr>
    	<td class='saludo1'><center><?php echo $_GET[titulos];?><img src='imagenes\confirm.png'></center></td>
    </tr>
  </table>
  <table>
  	<tr>
    	<td style="text-align:center"><input type="button" name="continuar" id="continuar" value="   Continuar   " onClick="continuar()"></td>
    </tr>
  </table>
</body>
<script>document.getElementById('continuar').focus();</script>
</html>
