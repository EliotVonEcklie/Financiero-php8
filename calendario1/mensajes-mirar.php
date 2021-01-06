<?php
	require"../comun.inc";
	require"../funciones.inc";
	$linkbd=conectar_bd();	
?>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml"> 
    <head>
    	 <meta http-equiv="Content-Type" content="text/html"  />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
		<link href="css/agenda2.css" rel="stylesheet" type="text/css" />
         <link href="../css/css2.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='agenda.js'></script>
        <script type='text/javascript'>function bcerrar(){parent.despliegamodal2("hidden");}</script>
    </head>
	<body id="cuerpomensaje" class="cuerpomensaje">
    	<div id="marcomensaje" class="marcomensaje">
        <form name ="client" id="client" method="POST" >
        <?php
        if ($_POST[oculto]== ""){
			$_POST[fecha]=$_GET[fecha];
			$_POST[horainis]=$_GET[horaini];
			$horamensaje=explode(":",$_GET[horaini]);
			$_POST[horainicial]=date('g:i a', mktime($horamensaje[0],$horamensaje[1],0,0,0,0));
			$sqlr="SELECT horafinal,evento,prioridad,tiempoalerta,frecuencia,descripcion FROM agenda WHERE fechaevento='$_POST[fecha]' AND horainicial='$_POST[horainis]'";
            $res=mysql_query($sqlr,$linkbd);
            $row=mysql_fetch_row($res);
			$horafinis=explode(":",$row[0]);
			$_POST[horafinal]=date('g:i a', mktime($horafinis[0],$horafinis[1],0,0,0,0));
			$sqlr2="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPO_EVENTO_AG' AND valor_inicial='$row[1]'";
            $res2=mysql_query($sqlr2,$linkbd);
            $row2 = mysql_fetch_row($res2); 
			$_POST[evento]=$row2[0];
			$sqlr2="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='PRIORIDAD_EVENTOS_AG' AND valor_inicial='$row[2]'";
			$res2=mysql_query($sqlr2,$linkbd);
			$row2 = mysql_fetch_row($res2);
			$_POST[prioevento]=$row2[0];
			$tiempoalerta=explode(":",$row[3]);
			$_POST[recordarem]=$tiempoalerta[0]." Meses"; 
			$_POST[recordared]=$tiempoalerta[1]." Dias";
			$_POST[frecuenciah]=$row[4]." Horas:Minutos";
			$_POST[desevento]=$row[5];
		}
		?>	
        	<table  class="inicio">
            	<tr>
                	<td colspan="5" class="titulos" style="width:85%;" >:.Evento Programado en la Agenda </td>
                    <td class="cerrar" style="width:15%;" ><a href="#" onClick="bcerrar();">Cerrar</a></td>
                </tr>
                <tr>
                	<td class="saludo1" style="width:14%">Remitente:</td>
                    <td style="width:30%"><input type="text" name="nombreremitente" id="nombreremitente" value="<?php echo $_SESSION[usuario]?>" readonly style="width:92%"></td>
                	<td class="saludo1" style="width:14%">Fecha:</td>
                    <td style="width:30%"><input type="text" name="fechaevento" id="fechaevento" value="<?php echo $_POST[fecha] ?>" readonly  style="width:90%"></td>
              	</tr>
                <tr>
                    <td class="saludo1" style="width:14%">Hora Inicio:</td>
                    <td><input id="horainicial" name="horainicial" style="width:92%" value="<?php echo $_POST[horainicial]?>" readonly></td>
                    <td class="saludo1" style="width:14%">Hora Final:</td>
                    <td><input id="horafinal" name="horafinal" style="width:90%" value="<?php echo $_POST[horafinal]?>"readonly></td>
                </tr>
                <tr>
                	<td class="saludo1" style="width:14%">Nombre Evento:</td>
                	<td><input id="evento" name="evento" style="width:92%" value="<?php echo $_POST[evento]?>"readonly></td>
                    <td class="saludo1" style="width:14%">Prioridad Evento:</td>
                    <td><input id="prioevento" name="prioevento" style="width:90%" value="<?php echo $_POST[prioevento]?>"readonly></td>
                </tr>
                <tr>
                	<td class="saludo1" style="width:14%">Recordar desde:</td>
                    <td>
                    	<input id="recordarem" name="recordarem" style="width:45%" value="<?php echo $_POST[recordarem]?>"readonly>
                        <input id="recordared" name="recordared" style="width:45%" value="<?php echo $_POST[recordared]?>"readonly>
                    </td>
                    <td class="saludo1" style="width:14%">Frecuencia:</td>
                     <td><input id="frecuenciah" name="frecuenciah" style="width:90%" value="<?php echo $_POST[frecuenciah]?>"readonly></td>
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
                        <input id="borrarmen" type="button" value ="Borrar" onClick="document.client.oculto.value=3;  document.client.submit();" />      
                		<input id="bguardar" type="button" name="bguardar" value ="Modificar" onClick="parent.actulizar(document.getElementById('fecha').value,document.getElementById('horainis').value);document.client.submit();" />  
                    </td>
                </tr>
        	</table>
			<input type="hidden" name="oculto" value="0">
            <input type="hidden" id="fecha" name="fecha" value="<?php echo $_POST[fecha] ?>">
            <input type="hidden" id="horainis" name="horainis" value="<?php echo $_POST[horainis] ?>">
            <input type="hidden" name="id" id="id" value="">
                <?php
				if($_POST[oculto]== 3)
				{
					$sqlr = "DELETE FROM agenda WHERE usrecibe = '$_SESSION[cedulausu]' AND fechaevento = '$_POST[fecha]' AND horainicial = '$_POST[horainis]'";

					if(mysql_query($sqlr,$linkbd))
				 	{
				 		echo "<div class='renglon'>Se ha Guardado</div>";	
				 ?>
						 <script> 
                        	parent.document.form2.submit();
							parent.despliegamodal2("hidden");
                         </script>
                 <?php					 
				 	}
					else
					{
						echo "<div class='renglon'>Error, No se pudo Guardar</div>";	
					}
				}
				?>
        </form>
        </div>
     		
    </body>
</html>