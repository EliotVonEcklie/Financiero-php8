<?php require"../comun.inc";require"../funciones.inc";$linkbd=conectar_bd();?>
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head>
    	<meta http-equiv="Content-Type" content="text/html" />
		<link href="css/agenda2.css" rel="stylesheet" type="text/css" />
        <link href="../css/css2.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='agenda.js'></script>
        <script type='text/javascript'>
			function bcerrar(){parent.despliegamodal2("hidden");}
			function guardar()
			{
				
				if((document.getElementById('rfechas').value!="")&&(document.getElementById('rhoras').value!="")&&(document.getElementById('frecuenciah').value!="")&&(document.getElementById('desevento').value!=""))
				{
					document.client.oculto.value=2; 
					document.client.submit();
				}
				else{alert("Se deben ingresar todos los campos");}
			}
        </script>
    </head>
	<body id="cuerpomensaje" class="cuerpomensaje">
    	<div id="marcomensaje" class="marcomensaje">
        <form name ="client" id="client" method="POST" >
        	
        	<?php if ($_POST[oculto]== "")
			if ($_POST[oculto]== "")
				{
					$_POST[id]=$_GET[idact];
					$hoy=date('Y-m-d');
					$_POST[fechahoy]=$hoy;
					$sqlr="SELECT * FROM alertasdiarias WHERE codigo='".$_POST[id]."'";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[fechaevento]=$row[2];
					$desde=explode(" ",$row[3]);
					$_POST[rfechas]=$desde[0];
					$_POST[rhoras]=$desde[1];
					$_POST[frecuenciah]=$row[4];
					$_POST[desevento]=$row[5];
					
				}
			?>	
        	<table  class="inicio">
            	<tr>
                	<td colspan="5" class="titulos" style="width:85%;" >:.Actualizar Alerta</td>
                    <td class="cerrar" style="width:15%;" ><a href="#" onClick="bcerrar();">Cerrar</a></td>
                </tr>
            	<tr>
                	<td class="saludo1" style="width:14%">Remitente:</td>
                    <td style="width:30%"><input type="text" name="nombreremitente" id="nombreremitente" value="<?php echo $_SESSION[usuario]?>" readonly style="width:92%"></td>
                	<td class="saludo1" style="width:14%">Fecha:</td>
                    <td style="width:30%"><input type="date" name="fechaevento" id="fechaevento" value="<?php echo $_POST[fechaevento] ?>"  style="width:90%"  min="<?php echo $_POST[fechahoy]?>"></td>
              	</tr>
                <tr>
                	<td class="saludo1" style="width:14%">Recordar desde:</td>
                    <td>
                    	<input type="date" name="rfechas" id="rfechas" onChange="document.client.submit()" value="<?php echo $_POST[rfechas]?>" min="<?php echo $_POST[fechahoy]?>" max="<?php echo $_POST[fechaevento]?>">
                        <select id="rhoras" name="rhoras" onKeyUp="return tabular(event,this)">
                  			<?php
                      			for($ii=8;$ii<18;$ii++)
								{
									if ($ii<13){$horas=$ii;}
									else{$horas=$ii-12;}
									if ($ii<12){$ampm="am";}
									else{$ampm="pm";}
									if ($horas<10) {$horas="0".$horas;}
									echo'<option value="'.$ii.':00"';
									$i=$ii.':00';
									if($i==$_POST[rhoras]){echo " SELECTED";}
									echo '>'.$horas.':00 '.$ampm.'</option>';	
								}
							?>
                        </select>
                    </td>
                    <td class="saludo1" style="width:14%">Frecuencia:</td>
                     <td>
                    	<select id="frecuenciah" name="frecuenciah" onKeyUp="return tabular(event,this)" style="width:90%">
                            <?php
								echo'<option value="">Horas : Minutos</option>';
								for($ii=0;$ii<12;$ii++)
								{
									if($ii<10){$horr="0".$ii;}
									else{$horr=$ii;}
									if($ii==0)
									{
										for($xx=1;$xx<4;$xx++)
										{
											switch ($xx) 
											{
												case 1:$min="15";break;
												case 2:$min="30";break;
												case 3:$min="45";break;
											}
											echo'<option value="'.$horr.':'.$min.'"';
											$i=$horr.':'.$min;
											if($i==$_POST[frecuenciah]){echo " SELECTED";}
											echo '>'.$horr.':'.$min.'</option>';
										}
									}
									else
									{
										$min="00";echo'<option value="'.$horr.':'.$min.'"';
										$i=$horr.':'.$min;
										if($i==$_POST[frecuenciah]){echo " SELECTED";}
										echo '>'.$horr.':'.$min.'</option>';
									}
									
								}
								echo'<option value="12:00">12:00</option>';
							?>
                        </select>
                       
                    </td>
                </tr>
                <tr>
                	<td class="saludo1" style="width:14%">Descripci&oacute;n:</td>
                    <td colspan="4">
                    	<textarea name="desevento" id="desevento" style="width:96%; height:100px; resize:none"><?php echo $_POST[desevento];?></textarea>
                   </td>
                </tr>
                <tr>
                	<td colspan="6" align="middle">
                    	<input id="cancel" type="button" value ="Cancelar" onClick="bcerrar();"/>      
                		<input id="bguardar" type="button" name="bguardar" value ="Guardar" onClick="guardar();" />  
                    </td>
                </tr>
            </table>
			<input type="hidden" name="oculto" value="0">
            <input type="hidden" name="totalmeses" value="<?php echo $_POST[totalmeses] ?>">
            <input type="hidden" name="totaldias" value="<?php echo $_POST[totaldias] ?>">
            <input type="hidden" name="fechahoy" value="<?php echo $_POST[fechahoy] ?>">
            <input type="hidden" name="horainis" value="<?php echo $_POST[horainis] ?>">
             <input type="hidden" name="id" id="id" value="<?php echo $_POST[id] ?>">
			<?php
                if ($_POST[oculto]== 2)
                {
                    $linkbd=conectar_bd();
                    $sqlr = "UPDATE alertasdiarias SET fechaevento='$_POST[fechaevento]',fechainicio='".$_POST[rfechas]." ".$_POST[rhoras].":00',frecuencia='$_POST[frecuenciah]',descripcion='$_POST[desevento]' WHERE codigo='$_POST[id]'";
                    if(mysql_query($sqlr,$linkbd))
                    {
                         echo "<div class='renglon'>Se ha Guardado</div>";	
                        ?><script>parent.despliegamodal2("hidden");</script><?php					 
                    }
                    else{echo "<div class='renglon'>Error, No se pudo Guardar</div>";	}
                }
            ?>
        </form>
        </div>
     		
    </body>
</html>