<?php
	require "comun.inc";
	require"funciones.inc";
    require "conversor.php";
	$linkbd=conectar_bd();
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			var anterior;
			
			function salir(){
				var arreglo=document.getElementsByName("fecha[]");
				var arreglo2=document.getElementsByName("valor_cuota[]");
				var fechas=parent.document.getElementsByName("arreglofechas[]");
				var valor_cuota=parent.document.getElementsByName("arreglovalor_cuota[]");
				for(var i=0;i<arreglo.length;i++){
					fechas.item(i).value=arreglo.item(i).value;
					valor_cuota.item(i).value=arreglo2.item(i).value;
				}
				parent.despliegamodal2("hidden");	
				parent.document.form2.submit();
			}
			function cargardatos(){ 
				var arreglo=document.getElementsByName("fecha[]");
				var arreglo2=document.getElementsByName("valor_cuota[]");
				var fechas=parent.document.getElementsByName("arreglofechas[]");
				var valor_cuota=parent.document.getElementsByName("arreglovalor_cuota[]");
				for(var i=0;i<fechas.length;i++){
					var valor=fechas.item(i).value;
					arreglo.item(i).value=valor;
					arreglo2.item(i).value=valor_cuota.item(i).value;
				}

			}
		</script> 
		<?php titlepag();?>
		<style>
		.fc_main{
			top:0 !important;
		}
		</style>
	</head>
	<body style=" overflow-y:scroll; max-height:  500px; height: 500px">
		
		<form action="" method="post" enctype="multipart/form-data" name="form1">
        <input type="hidden" name="cuota" id="cuota" value="<?php echo $_POST[cuota]; ?>"/> 
        	<table  class="inicio" align="center" >
      			<tr>
                	<td class="titulos" colspan="3">:: Asignaci&oacute;n de Fechas</td>
                    <td class="cerrar" style="width: 7%"><a onClick="salir();">&nbsp;Aceptar</a></td>
                </tr>
            </table> 
            <table  class="inicio" align="center" >
                <tr>
	    	    	<td class="titulos2" style="width: 15%">Item</td>
	        		<td class="titulos2">Fechas</td>
	            	<td class="titulos2" style="width: 40%;">Valor Cuota</td>
	    	  	</tr>
    	    	<?php 
                    $cuota=$_GET[cuota]; 
                    $i=1;
                    while($i<=intval($cuota)){
                    	$iter='saludo1a';
						$iter2='saludo2';
						$arreglo=$_POST[fecha][$i];
                    	echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\">
								<td>
									<input class='inpnovisibles' name='item[]' value='".$i."' type='text' readonly>
								</td>
								<td>
									<input name='fecha[]' type='text' id=\"fc_119897154$i\" title='DD/MM/YYYY' style='width:70%;' value='$arreglo' readonly>&nbsp;<a onClick=\"displayCalendarFor('fc_119897154$i');\" style='cursor:pointer;'><img src='imagenes/calendario04.png' style='width:20px;'/></a>
								</td>
								<td>
									<input name='valor_cuota[]'  type='text' style='width: 70%;text-align: right;'>
								</td>";
						echo "</tr>";
					    $i=$i+1;
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						echo "<script>cargardatos(); </script>";
                    }
                ?>
	    	</table>
   			<input type="hidden" name="oculto" id="oculto" value="1"/>  
    	
		</form>
	
  		
	</body>
</html> 
