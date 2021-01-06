<?php
	require"../comun.inc";
	require"../funciones.inc";
	$linkbd=conectar_bd();	
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
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
			$_POST[horainicial]=$_GET[horaini];
			$hoy=date('Y-m-d');
			$_POST[totalmeses]=diferenciamesesfechas($hoy,$_GET[fecha]);
			$_POST[totaldias]=dias_transcurridos($hoy,$_GET[fecha]);	
			$sqlr="SELECT horafinal,evento,prioridad,tiempoalerta,frecuencia,descripcion FROM agenda WHERE fechaevento='$_POST[fecha]' AND horainicial='$_POST[horainicial]'";
            $res=mysql_query($sqlr,$linkbd);
            $row=mysql_fetch_row($res);
			$_POST[horafinasl]=$row[0];
			$_POST[evento]=$row[1];
			$_POST[prioevento]=$row[2];
			$tiempoalerta=explode(":",$row[3]);
			$_POST[recordarem]=$tiempoalerta[0]; 
			$_POST[recordared]=$tiempoalerta[1];
			$_POST[frecuenciah]=$row[4];
			$_POST[desevento]=$row[5];
		}
		?>	
        	<table  class="inicio">
            	<tr>
                	<td colspan="5" class="titulos" style="width:85%;" >:.Modificar Evento en la Agenda </td>
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
                     <td><input type="time" name="horainicial" value="<?php echo $_POST[horainicial];?>" step="900" onChange="var horamin='08:00:00';  if(document.client.horainicial.value<horamin){document.client.horainicial.value=horamin;}"></td>
                    <td class="saludo1" style="width:14%">Hora Final:</td>
                    <td><input type="time" name="horafinasl" value="<?php echo $_POST[horafinasl];?>" step="900" onChange="if(document.client.horafinasl.value<document.client.horainicial.value){document.client.horafinasl.value=document.client.horainicial.value;}"></td>
                </tr>
                <tr>
                	<td class="saludo1" style="width:14%">Nombre Evento:</td>
                	<td>
                    	<select id="evento" name="evento"  onKeyUp="return tabular(event,this)"  style="width:92%">
                            <option value="" >Seleccione....</option>
							<?php
                                $sqlr="SELECT * FROM dominios WHERE nombre_dominio='TIPO_EVENTO_AG' AND tipo='S'";
                                $res=mysql_query($sqlr,$linkbd);
                                while ($rowEmp = mysql_fetch_assoc($res)) 
                                {
                                    if($rowEmp[valor_inicial]==$_POST[evento])
                                    {
										echo "<option value='$rowEmp[valor_inicial]' SELECTED>$rowEmp[valor_inicial] - $rowEmp[descripcion_valor]</option>";
                                        $_POST[nombreevento]=$rowEmp[descripcion_valor];
                                    }
									else{echo"<option value='$rowEmp[valor_inicial]'>$rowEmp[valor_inicial] - $rowEmp[descripcion_valor]</option>";}
                                }	
                            ?> 
						</select> 
                    </td>
                    <td class="saludo1" style="width:14%">Prioridad Evento:</td>
                    <td>
                    	<select id="prioevento" name="prioevento"  onKeyUp="return tabular(event,this)" style="width:90%">
	      					<option value="">Seleccione....</option>
							<?php
								$sqlr="SELECT * FROM dominios WHERE nombre_dominio='PRIORIDAD_EVENTOS_AG' ";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_assoc($res)) 
								{
									if($rowEmp[valor_inicial]==$_POST[evento])
									{
										echo "<option value='$rowEmp[valor_inicial]' SELECTED>$rowEmp[valor_inicial] - $rowEmp[descripcion_valor]</option>";
										$_POST[nombreevento]=$rowEmp[descripcion_valor];
									}
									else{echo "<option value='$rowEmp[valor_inicial]'>$rowEmp[valor_inicial] - $rowEmp[descripcion_valor]</option>";}	 
								}	
                            ?>
						</select>  
                    </td>
                </tr>
                <tr>
                	<td class="saludo1" style="width:14%">Recordar desde:</td>
                    <td>
                    	<select id="recordarem" name="recordarem" onKeyUp="return tabular(event,this)" style="width:45%">
                        	<option value="">Meses</option>
                           <?php
								for($ii=1;$ii<=$_POST[totalmeses];$ii++)
								{
									if($ii==$_POST[recordarem]){echo"<option value=$ii SELECTED>$ii</option>";}
									else{echo"<option value=$ii>$ii</option>";}
								}
							?>
                        </select>
                        <select id="recordared" name="recordared" onKeyUp="return tabular(event,this)" style="width:45%">
                        	<option value="">D&iacute;as</option>
                             <?php
								if($_POST[totaldias]<31){$cont=$_POST[totaldias];}
								else{$cont=31;}
                            	for($ii=1;$ii<=$cont;$ii++)
								{
									if($ii==$_POST[recordared]){echo"<option value=$ii SELECTED>$ii</option>";}
									else{echo"<option value=$ii>$ii</option>";}
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
											if(0==strcmp($i,$_POST[frecuenciah])){echo " SELECTED";}
											echo '>'.$horr.':'.$min.'</option>';
										}
									}
									else
									{
										$min="00";echo'<option value="'.$horr.':'.$min.'"';
										$i=$horr.':'.$min;
										if(0==strcmp($i,$_POST[frecuenciah])){echo " SELECTED";}
										echo '>'.$horr.':'.$min.'</option>';}
								}
								echo'<option value="12:00" ';
								$i='12:00';
								if(0==strcmp($i,$_POST[frecuenciah])){echo " SELECTED";}
								echo'>12:00</option>';
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
                		<input id="bguardar" type="button" name="bguardar" value ="Guardar" onClick="document.client.oculto.value=2;  document.client.submit();" />  
                    </td>
                </tr>
        	</table>
			<input type="hidden" name="oculto" value="0">
            <input type="hidden" name="fecha" value="<?php echo $_POST[fecha] ?>">
            <input type="hidden" name="totalmeses" value="<?php echo $_POST[totalmeses] ?>">
            <input type="hidden" name="totaldias" value="<?php echo $_POST[totaldias] ?>">
            <input type="hidden" name="id" id="id" value="">
                <?php
				if ($_POST[oculto]== 2)
				{
					if($_POST[recordarem]==""){$tmeses="0";}
					else{$tmeses=$_POST[recordarem];}
					if($_POST[recordared]==""){$tdias="0";}
					else{$tdias=$_POST[recordared];}
					$talerta=$tmeses.":".$tdias;
                	$sqlr = "UPDATE agenda SET  fechaevento =  '$_POST[fecha]',horainicial = '$_POST[horainicial]',horafinal =  '$_POST[horafinasl]',evento =  '$_POST[evento]',descripcion =  '$_POST[desevento]',prioridad =  '$_POST[prioevento]',tiempoalerta='$talerta', frecuencia='$_POST[frecuenciah]' WHERE fechaevento =  '$_POST[fecha]' AND  horainicial =  '$_POST[horainicial]'";
					if(mysql_query($sqlr,$linkbd))
				 	{
				 		echo "<div class='renglon'>Se ha Guardado</div><script>parent.document.form2.submit();parent.despliegamodal2('hidden');</script>"; 
				 	}
					else{echo "<div class='renglon'>Error, No se pudo Guardar</div>";}
				}
				?>
        </form>
        </div>
     		
    </body>
</html>