<?php //V 1000 12/12/16 ?>  
<?php 
require "comun.inc";
require"funciones.inc";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>:: Spid</title>
		<script>
        	function modificarf(){document.getElementById('oculto').value="1";document.fmodificar.submit();}
			function modificado()
			{
				parent.despliegamodalm("hidden");
				parent.document.getElementById('oculto').value="4"
				parent.document.form2.submit();
			}
			function salir(){parent.despliegamodalm("hidden");}
		</script>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
	</head>
	<body style="overflow:hidden"></br></br>
    	<form name="fmodificar" id="fmodificar" method="post">
        	 <?php
				if($_POST[oculto]=="")
				{
					$div = explode('-', $_GET[codigo]);
					$linkbd=conectar_bd();
					$sqlr="SELECT nombre,tipo,deprecia FROM actipo WHERE codigo='$div[0]' and niveluno='$div[1]' and niveldos = '$div[2]'";
					$row=mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$_POST[descrip]=$row[0];
					$_POST[deprecia]=$row[2];
					$_POST[oculto]="0";
					$width=85;
					$cadena = '';
					$colspan = 2;
					if ($row[1]==3) {
						$colspan = 5;
						$width=35;
						$cadena = '<td class="saludo1" style="width:15%">Deprecia:</td><td style="width:25%"><input type="text" name="deprecia" id="deprecia" value="'.$_POST[deprecia].'" style="width:100%"></td><td style="width:10%">(Meses)</td>';
					}
				}
			?>
            <table id='sa' class='inicio'>
                <tr>
                    <td class="titulos" colspan="<?php echo $colspan; ?>" style="width:80%">:: Modificar <?php echo $_GET[clase];?></td>
                </tr>
                <tr>
                    <td class='saludo1' style="width:15%">Nombre:</td>
                    <?php
                    	echo '<td style="width:'.$width.'%"><input type="text" name="descrip" id="descrip" value="'.$_POST[descrip].'" style="width:100%"></td>'.$cadena ;
                    ?>
                </tr>
            </table>
            <table>
                <tr>
                	<td style="width:35%"></td>
                    <td style="text-align:center"><input type="button" name="modificar" id="modificar" value="   Modificar   " onClick="modificarf();" ></td>
                    <td style="text-align:center"><input type="button" name="cancelar" id="cancelar" value="   Cancelar   " onClick="salir();" ></td>
                    <td style="width:35%"></td>
                </tr>
            </table>
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]?>">
           <?php
				if($_POST[oculto]=="1")
				{
					$div = explode('-', $_GET[codigo]);
					$linkbd=conectar_bd();
					$sqlm="UPDATE actipo SET nombre='$_POST[descrip]',deprecia='$_POST[deprecia]' WHERE codigo='$div[0]' and niveluno='$div[1]' and niveldos = '$div[2]'";
					$rowm=mysql_fetch_row(mysql_query($sqlm,$linkbd));
					$_POST[oculto]="0";
					?><script>modificado();</script><?php
				}
			?>
    	</form>
	</body>
</html>
