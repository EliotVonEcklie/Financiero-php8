<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Planeacion Estrategica</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function validar() {
				document.form2.oculto.value="1";
				document.form2.submit();
			}
			function guardar()
			{
				var validacion01=document.getElementById('descripcion').value;
				var validacion02=document.getElementById('padre').value;
				if (validacion01.trim()!='' && validacion02.trim()!='' && document.getElementById('tipo').value)
  				{
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  				}
  				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function validacod()
			{
				if(document.getElementById('consecutivo').value!='')
					{document.getElementById('valcod').value='1';document.form2.submit();}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if (document.getElementById('valfocus').value!="0")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('consecutivo').focus();
						document.getElementById('consecutivo').select();
					}
				}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";
								document.form2.submit();break;
				}
			}
 		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="plan-crearplandesarrollo.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="plan-buscaplandesarrollo.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>
  		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
            $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
            $sqlr="select *from dominios where nombre_dominio='VIGENCIA_PD' and tipo='S' order by VALOR_INICIAL";
            $res=mysql_query($sqlr,$linkbd);
            while ($row =mysql_fetch_row($res)) {$_POST[vigenciai]=$row[0];$_POST[vigenciaf]=$row[1];}
			$tiponom=array();
            ?>
  			<table  class="inicio" align="center">
                <tr>
                    <td class="titulos" colspan="4">Creaci�n Plan de Desarrollo</td>  
                    <td class="cerrar"><a href="plan-principal.php">Cerrar</a></td>
                </tr>
  				<tr>
                	<td class="saludo1" style='width:20%'>Tipo de Creaci�n</td>
  					<td> 
  	   					<select id="tipo" name="tipo"  onChange="validar()" >
                            <option value="">Seleccione....</option>
                            <?php
                                $sqlr="SELECT * FROM plannivelespd WHERE inicial='$_POST[vigenciai]' AND final='$_POST[vigenciaf]' ORDER BY orden";
                                $res=mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($res)) 
                                {
                                    if($row[0]==$_POST[tipo]){
										$_POST[orden]=$row[1];
										$_POST[nomtipo]=$row[2];
										echo "<option value='$row[0]' SELECTED>$row[1] - ".strtoupper($row[2])."</option>";
									}
                                    else {echo "<option value='$row[0]'>$row[1] - ".strtoupper($row[2])."</option>";}
                                }	 	
                            ?>
            			</select>
						<input type="hidden" id="orden" name="orden" value="<?php echo $_POST[orden] ?>">
						<input type="hidden" id="nomtipo" name="nomtipo" value="<?php echo $_POST[nomtipo] ?>">
  					</td>
                    <td class="saludo1" style='width:10%'>Vigencia:</td>
                    <td style='width:20%'> 
						<input type="text" name="vigenciai" id="vigenciai" value="<?php echo $_POST[vigenciai]?>" style='width:10%' readonly> - 
						<input type="text" name="vigenciaf" id="vigenciaf" value="<?php echo $_POST[vigenciaf]?>" style='width:10%' readonly> 
                    </td>
                    <td></td>
 			 	</tr>
  				<?php
				//$padre=array();
				if($_POST[orden]>1){
					for($i=1;$i<$_POST[orden];$i++)
					{
						$sqln="SELECT nombre FROM plannivelespd WHERE orden='$i' AND inicial='$_POST[vigenciai]' AND final='$_POST[vigenciaf]'";
						$resn=mysql_query($sqln,$linkbd);
						$wres=mysql_fetch_array($resn);
						if($i==1) $buspad='';
						elseif($_POST[arrpad][($i-1)]!="")
							$buspad=$_POST[arrpad][($i-1)];
						else
							$buspad='0';
						
						echo"	
						<tr>
							<td class='saludo1' style='width:20%'>".strtoupper($wres[0]).":</td>
							<td colspan='4'  style='width:100%'>
								<select name='niveles[$i]' onChange='validar()' onKeyUp='return tabular(event,this)' style='width:60%;'>
									<option value=''>Seleccione....</option>";
									$sqlr="SELECT * FROM presuplandesarrollo WHERE padre='$buspad' AND vigencia='$_POST[vigenciai]' AND vigenciaf='$_POST[vigenciaf]' ORDER BY codigo";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										if($row[0]==$_POST[niveles][$i]){
											$_POST[arrpad][$i]=$row[0];
											echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										}
										else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	 
									}	
								echo"</select>
								<input type='hidden' name='arrpad[$i]' value='".$_POST[arrpad][$i]."' >";

							echo"</td>
						</tr>";
					}
					$_POST[padre]=$_POST[arrpad][($i-1)];
					$sqlp="select codigo from presuplandesarrollo where padre='$_POST[padre]' AND vigencia='$_POST[vigenciai]' AND vigenciaf='$_POST[vigenciaf]' order by codigo";
					
					$consec=array();
					$i=0;
					$resp=mysql_query($sqlp,$linkbd);
					if(mysql_num_rows($resp)!=0){
						while($wp=mysql_fetch_array($resp)){
							$sepcon=explode('.',$wp[0]);
							$totsep=count($sepcon)-1;
							$consec[$i]=(int) $sepcon[$totsep];
							$i++;
						}
						sort($consec, SORT_NUMERIC);
						$_POST[consecutivo]=$consec[(count($consec)-1)]+1;
					}
					else
						$_POST[consecutivo]=1;
				}
				else{
					$sqlp="select codigo from presuplandesarrollo where padre='' AND vigencia='$_POST[vigenciai]' AND vigenciaf='$_POST[vigenciaf]' order by codigo desc";
					$resp=mysql_query($sqlp,$linkbd);
					if(mysql_num_rows($resp)!=0){
						$consecutivo=[];
						while($wp=mysql_fetch_array($resp))
						{
							$consecutivo[] += $wp[0];
						}
						$_POST[padre]=max($consecutivo)+1;
						$_POST[consecutivo]="";
					}
					else{
						$_POST[padre]=1;
						$_POST[consecutivo]="";
					}
				}
				if (strcmp($_POST[nomtipo],'INDICADORES')==0){
					$reado='readonly';
					$_POST[descripcion]='INDICADOR';
				}
				else
					$reado='';
       			?>   
       			<tr>
            		<td class="saludo1">Consecutivo:</td>
                    <td>
						<input type="text" name="padre" id="padre" size="10%" value="<?php echo $_POST[padre] ?>" readonly>.<input type="text" name="consecutivo" id="consecutivo" value="<?php echo $_POST[consecutivo];?>" size="4" onKeyPress="javascript:return solonumeros(event)" <?php echo $reado; ?> >
					</td>
                    <td class="saludo1">Descripcion:</td>
                    <td>
						<input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]; ?>" size="120" required = "required" style="text-transform:uppercase;" <?php echo $reado; ?> > 
					</td>
                    <td></td>
           		</tr>
    		</table>
			<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]?>">
            <input type="hidden" name="valcod" id="valcod" value="0"/>
   			<?php
	  			if($_POST[oculto]==2)
	  			{	
					
					if (strcmp($_POST[nomtipo],'INDICADORES')!=0)
					{
						if($_POST[consecutivo]!=""){$elemento=$_POST[padre].".".$_POST[consecutivo];}
						else {$elemento=$_POST[padre];}
						$sqle="select * from presuplandesarrollo where codigo='$elemento' AND vigencia='$_POST[vigenciai]' AND vigenciaf='$_POST[vigenciaf]'";
						$rese=mysql_query($sqle,$linkbd);
						if(mysql_num_rows($rese)<=0){
							$mxa=selconsecutivo('presuplandesarrollo','id');
							$descrip=strtoupper($_POST[descripcion]);
							if($_POST[orden]>1)
								$sqlr="INSERT INTO presuplandesarrollo (codigo, nombre, padre, vigencia, vigenciaf,prioridad, nivel, id) VALUES ('$elemento','$descrip','$_POST[padre]','$_POST[vigenciai]','$_POST[vigenciaf]','','$_POST[orden]', $mxa)";
							else
								$sqlr="INSERT INTO presuplandesarrollo (codigo, nombre, padre, vigencia, vigenciaf,prioridad, nivel, id) VALUES ('$elemento','$descrip','','$_POST[vigenciai]','$_POST[vigenciaf]','','$_POST[orden]', $mxa)";
							if (!mysql_query($sqlr,$linkbd))
							{
								echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b><img src='imagenes\alert.png'> </b></font></p>Ocurri� el siguiente problema:<br><pre></pre>$sqlr</center></td></tr></table>";
							}
							else
							{
								echo "<table class='inicio'><tr><td class='saludo1'>Se ha almacenado el elemento $elemento : $_POST[descripcion] con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";	
							}
						}
						/*else{
							echo "<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Error ya existe el Codigo: $elemento');</script>";
						}*/
					}
					else{
						$elemento=$_POST[padre];
						$sqle="select * from presuplandesarrollo where codigo='$elemento' AND vigencia='$_POST[vigenciai]' AND vigenciaf='$_POST[vigenciaf]'";
						$rese=mysql_query($sqle,$linkbd);
						if(mysql_num_rows($rese)>0){
							$rwe=mysql_fetch_array($rese);
							if((strcmp($_POST[nomtipo],'INDICADORES')==0))
							{
								$sqld="delete from planmetasindicadores where codigo='$rwe[7]'";
								mysql_query($sqld,$linkbd);
								$tam=count($_POST[vigenciasm]);	
								//MEDIBLES
								for($x=0;$x<$tam;$x++)
								{
									$maxid=selconsecutivo('planmetasindicadores','id');
									$sqlr="insert into planmetasindicadores (codigo,vigencia, descripcion, valorprogramado, valorejecutado, estado,tipo, id) values ('$rwe[7]','".$_POST[vigenciasm][$x]."','".$_POST[descripcion]."',".$_POST[mmetas][$x].",0,'S','M', ".$maxid.")";	
									if (!mysql_query($sqlr,$linkbd))
									{
										echo "<div class='inicio'><img src='imagenes\alert.png'>No se pudo agregar la vigencia '".$_POST[vigenciasm][$x]."' el Valor ".$_POST[mmetas][$x]." </div>";	
									}
									else
									{
										echo "<div class='inicio'><img src='imagenes\confirm.png'>Se agrego la vigencia '".$_POST[vigenciasm][$x]."' el Valor ".$_POST[mmetas][$x]." </div>";	
									}
								}
								//CUANTIFICABLES
								for($x=0;$x<$tam;$x++)
								{
									$maxid=selconsecutivo('planmetasindicadores','id');
									$sqlr="insert into planmetasindicadores (codigo,vigencia, descripcion, valorprogramado, valorejecutado, estado,tipo, id) values ('$rwe[7]','".$_POST[vigenciasm][$x]."','".$_POST[descripcion]."',".$_POST[vmetas][$x].",0,'S','C', ".$maxid.")";	
									if (!mysql_query($sqlr,$linkbd))
									{
										echo "<div class='inicio'><img src='imagenes\alert.png'>No se pudo agregar la vigencia '".$_POST[vigenciasm][$x]."' el Valor ".$_POST[vmetas][$x]." </div>";	
									}
									else
									{
										echo "<div class='inicio'><img src='imagenes\confirm.png'>Se agrego la vigencia '".$_POST[vigenciasm][$x]."' el Valor ".$_POST[vmetas][$x]." </div>";	
									}
								}
							}
						}
					}
	 			}

			if (strcmp($_POST[nomtipo],'INDICADORES')==0)
			{
				$elemento=$_POST[padre];
				$sqle="select * from presuplandesarrollo where codigo='$elemento' AND vigencia='$_POST[vigenciai]' AND vigenciaf='$_POST[vigenciaf]'";
				$rese=mysql_query($sqle,$linkbd);
				if(mysql_num_rows($rese)!=0){
					$rwe=mysql_fetch_array($rese);
					$temp=$rwe[7];
				}
				else
					$temp=0;
				
				echo"
    			<table class='inicio'>
    				<tr>
						<td class='titulos'>Tipo</td>";
						for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
						{
							echo "<td class='titulos'>Valor Programado $x<input type='hidden' name='vigenciasm[]' value='$x'></td>";
						}
					echo"</tr>
					<tr class='saludo1'>
						<td>Medibles</td>";
						$c=0;
						for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
						{
							$sqld="select * from planmetasindicadores where codigo='$temp' AND vigencia=$x AND tipo='M'";
							$resd=mysql_query($sqld,$linkbd);
							if(mysql_num_rows($resd)!=0){
								$rwd=mysql_fetch_array($resd);
								$_POST[mmetas][$c]=$rwd[3];
							}
							echo"
								<td><input type='number' name='mmetas[]' value='".$_POST[mmetas][$c]."' onKeyPress='solonumeros(event)' min=0 placeholder='Valor Programado' style='text-align:center;'></td>";
							$c+=1;
						}
					echo"</tr>    
					<tr class='saludo1'>
						<td>Cuantificables</td>";
						$c=0;
						for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
						{
							$sqld="select * from planmetasindicadores where codigo='$temp' AND vigencia=$x AND tipo='C'";
							$resd=mysql_query($sqld,$linkbd);
							if(mysql_num_rows($resd)!=0){
								$rwd=mysql_fetch_array($resd);
								$_POST[vmetas][$c]=$rwd[3];
							}
							echo"
								<td><input type='number' name='vmetas[]' value='".$_POST[vmetas][$c]."' onKeyPress='solonumeros(event)' min=0 placeholder='Valor Programado' style='text-align:right;'></td>";
							$c+=1;
						}
					echo"</tr>    
    			</table>"; 
			}
/*			if (strcmp($_POST[nomtipo],'INDICADORES')==0)
			{
				echo"<table class='inicio'>
    				<tr><td class='titulos'>Tipo</td>";
						for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
						{echo "<td class='titulos'>Valor Programado $x<input type='hidden' name='vigenciasm[]' value='$x'></td>";}
					echo"</tr>
					<tr class='saludo1'>";
						$c=0;
						echo "
							<td>
								<select name='tipoind'>
       								<option value=''>Seleccione ...</option>
				 					<option value='M'";if($_POST[tipoind]=='M') {echo " SELECTED";}echo">Medible</option>
  				  					<option value='C'";if($_POST[tipoind]=='C') {echo " SELECTED";}echo">Cuantificable</option>
				  				</select>
                  			</td>";
						for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
						{
							echo "<td><input type='number' name='vmetas[]' value='".$_POST[vmetas][$c]."' onKeyPress='solonumeros(event)' min=0 placeholder='Valor Programado'></td>";
							$c+=1;
						}
					echo"    
						</tr>    
    				</table>";
				}*/
/*				if($_POST[valcod]=="1")
				{
					if($_POST[consecutivo]!=""){$nomval=$_POST[padre].".".$_POST[consecutivo];}
					else{$nomval=$_POST[padre];}
					$nresul=busquedageneralSN('presuplandesarrollo','codigo',$nomval);
					if($nresul!='SI')
			   		{
  			 			echo"
	  						<script>
								document.getElementById('valcod').value='';
			  					document.getElementById('descripcion').focus();
			  				</script>";
			  		}
			 		else
			 		{
						echo "<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Error ya existe el Codigo: $nomval');</script>";
			  		}
				}*/
	  		?>
		</form>
	</body>
</html>