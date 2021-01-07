<?php //V 1000 12/12/16 ?> 
<?php 
require "comun.inc";
require"funciones.inc";
//require "encrip.inc";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<link href="css/css2.css" rel="stylesheet" type="text/css" />
</head>
<body style="overflow:hidden"></br></br>
  <table id='ventanamensaje1' class='inicio'>
  	<tr>
    	<td class='saludo1' style="text-align:center;width:100%"><img src='imagenes\intera.jpg' height="16px;"> <?php echo $_GET[titulos];?> <img src='imagenes\interc.jpg' height="16px;"></td>
    </tr>
  </table>
  <table>
  	<tr>
    	<td style="text-align:center">
        	<input type="button" name="aceptar" id="aceptar" value="   Aceptar   " onClick='parent.respuestaconsulta("<?php echo $_GET[idresp];?>", "<?php echo $_GET[variable];?>");parent.despliegamodalm("hidden");' />
        	<input type="button" name="cancelar" id="cancelar" value="   Cancelar   " onClick='parent.despliegamodalm("hidden");' />
     	</td>
    </tr>
  </table>
</body>
</html>
