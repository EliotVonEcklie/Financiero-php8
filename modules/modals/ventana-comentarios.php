<?php //V 1000 12/12/16 ?> 
<?php 
	require "comun.inc";
	require"funciones.inc";
	//session_start();
	$linkbd=conectar_bd();	
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<script>
			function continuar_p()
			{
				if((document.getElementById('comentario').value!="")&&(document.getElementById('comentario').value!="Escribe aquí la Justificación"))
				{document.form1.oculto.value=2;document.form1.submit();}
				else
				{alert("Escriba la Justificacion");}
			}
        	function salirv(){parent.document.form2.submit();parent.despliegamodalm("hidden");}
			function borrarinicio()
			{
				if(document.getElementById('comentario').value=="Escribe aquí el comentario")
				document.getElementById('comentario').value="";
			}
        </script>
	</head>
	<body style="overflow:hidden">
    	<form name="form1" id="form1" method="post">
        	<?php
				if($_POST[oculto]=="")
				{
					$_POST[comentario]="Escribe aqu&iacute; la Justificaci&oacute;n";
					$_POST[informa]=$_GET[infor];
					$_POST[tabla]=$_GET[tabl];
					$_POST[tipoan]=$_GET[tipo];
					$_POST[idanul]=$_GET[idr];
					$_POST[vigenciau]=vigencia_usuarios($_SESSION[cedulausu]);
					$_POST[fecha]=date("Y-m-d");
				}
			?>
 	 		<table id='ventanamensaje1' class='inicio'>
            <tr>
            	<td style='text-align:center;'>
                <?php echo $_POST[informa];?>
                </td>
            </tr>
            <tr>
                <td class="saludo1"><textarea name="comentario" id="comentario" style="width:100%; height:60px" onClick="borrarinicio();"><?php echo $_POST[comentario];?></textarea>
               </td>
            </tr>
  			</table>
  			<table>
            <tr>
                <td style="text-align:center"><input type="button" name="continuar" id="continuar" value="   Continuar   " onClick="continuar_p();" ></td>
            </tr>
  		</table>
        <input type="hidden" name="vigenciau" id="vigenciau" value="<?php echo $_POST[vigenciau];?>">
      	<input type="hidden" name="informa" id="informa" value="<?php echo $_POST[informa];?>">
      	<input type="hidden" name="tabla" id="tabla" value="<?php echo $_POST[tabla];?>">
        <input type="hidden" name="tipoan" id="tipoan" value="<?php echo $_POST[tipoan];?>">
        <input type="hidden" name="idanul" id="idanul" value="<?php echo $_POST[idanul];?>">
        <input type="hidden" name="fecha" id="fecha" value="<?php echo $_POST[fecha];?>">
      	<input type="hidden" name="oculto" id="oculto" value="1">
        <?php
        	if($_POST[oculto]==2)
			{
				$sqlr="INSERT INTO $_POST[tabla] (vigencia,consvigencia,tipo,justificacion,usuario,fecha) VALUES ('$_POST[vigenciau]','$_POST[idanul]', '$_POST[tipoan]','$_POST[comentario]','$_SESSION[cedulausu]','$_POST[fecha]')";
				mysql_query($sqlr,$linkbd);
				echo"<script>salirv();</script>";
			}
		?>	
  </form>
</body>
</html>
