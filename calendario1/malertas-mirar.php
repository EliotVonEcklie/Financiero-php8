<?php require"../comun.inc";require"../funciones.inc";$linkbd=conectar_bd();?>
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head>
    	<meta http-equiv="Content-Type" content="text/html" />
		<link href="css/agenda2.css" rel="stylesheet" type="text/css" />
        <link href="../css/css2.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='agenda.js'></script>
        <script type='text/javascript'>
			function bcerrar(){parent.despliegamodal2("hidden");}
        </script>
    </head>
	<body id="cuerpomensaje" class="cuerpomensaje">
    	<div id="marcomensaje" class="marcomensaje">
        <form name ="client" id="client" method="POST" >
        	<?php 
				if ($_POST[oculto]== "")
				{
					$_POST[id]=$_GET[idalerta];
					$sqlr="SELECT * FROM alertasdiarias WHERE codigo='".$_POST[id]."'";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[fecha]=$row[2];
					$desde=explode(" ",$row[3]);
					$_POST[rfechas]=$desde[0];
					$_POST[rhoras]=$desde[1];
					$_POST[frecuenciah]=$row[4];
					$_POST[desevento]=$row[5];
					
				}
			?>	
        	<table  class="inicio">
            	<tr>
                	<td colspan="5" class="titulos" style="width:85%;" >:.Alerta Diaria Programada </td>
                    <td class="cerrar" style="width:15%;" ><a href="#" onClick="bcerrar();">Cerrar</a></td>
                </tr>
            	<tr>
                	<td class="saludo1" style="width:14%">Remitente:</td>
                    <td style="width:30%" colspan="2"><input type="text" name="nombreremitente" id="nombreremitente" value="<?php echo $_SESSION[usuario]?>" readonly style="width:92%"></td>
                	<td class="saludo1" style="width:14%">Fecha:</td>
                    <td style="width:30%"><input type="text" name="fechaevento" id="fechaevento" value="<?php echo $_POST[fecha] ?>" readonly  style="width:90%"></td>
              	</tr>
                <tr>
                	<td class="saludo1" style="width:14%">Recordar desde:</td>
                    <td><input type="text" name="rfechas" id="rfechas" value="<?php echo $_POST[rfechas]?>" readonly></td>
                    <td><input type="text" name="rhoras" id="rhoras" value="<?php echo $_POST[rhoras]?>" readonly></td>
                    <td class="saludo1" style="width:14%">Frecuencia:</td>
                    <td><input id="frecuenciah" name="frecuenciah" style="width:90%" value="<?php echo $_POST[frecuenciah]?>" readonly></td>
                </tr>
                <tr>
                	<td class="saludo1" style="width:14%">Descripci&oacute;n:</td>
                    <td colspan="4">
                    	<textarea name="desevento" id="desevento" style="width:96%; height:100px; resize:none" readonly><?php echo $_POST[desevento];?></textarea>
                   </td>
                </tr>
                <tr>
                	<td colspan="6" align="middle">
                    	<input id="cancel" type="button" value ="Cancelar" onClick="bcerrar();"/>    
                		<input id="bguardar" type="button" name="bguardar" value ="Modificar" onClick="window.parent.actualizar('<?php echo $_POST[id] ?>');" />  
                    </td>
                </tr>
            </table>
			<input type="hidden" name="oculto" value="0">
            <input type="hidden" name="id" id="id" value="<?php echo $_POST[id] ?>">
            <input type="hidden" name="fecha" value="<?php echo $_POST[fecha] ?>">
        </form>
        </div>
     		
    </body>
</html>