<?php //V 1000 12/12/16 ?> 
<?php 
require "comun.inc";
require"funciones.inc";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <script>
			function continuar(){parent.despliegamodalm("hidden");}
			var tecla01 = 13;
			$(document).keydown(function(e){if (e.keyCode == tecla01){continuar();}})
		</script>
	</head>
	<body style="overflow:hidden;">
		<div style="height:77%; width:99.6%; overflow-x:hidden;">
      		<table id='ventanamensaje1' class='inicio'>
        		<tr>
                    <td class='saludo1'><p >
                        <?php 
                            $partes = explode("--", $_GET[titulos]);
                            $cpartes=count($partes);
                            for($xx=0;$xx<=count($partes);$xx++)
                            {
								if ( substr($partes[$xx],0,1)=="-")
								{echo "<p style='height:5; font-weight:normal;'>".$partes[$xx]."</p>";}
								else {echo "<p style='height:8;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;'>".$partes[$xx]."</p>";}
							}
                        ?>
                    </td>
        		</tr>
      		</table>
  		</div>
      	<table>
            <tr>
                <td style="text-align:center"><input type="button" name="continuar" id="continuar" value="   Continuar   " onClick="continuar()" ></td>
            </tr>
      	</table>
</body>
<script>document.getElementById('continuar').focus();</script>
</html>
