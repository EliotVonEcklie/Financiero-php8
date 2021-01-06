<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
	<title>:: SPID - Tesoreria</title>
	<script>
		function buscacta(e)
		{
			if (document.form2.cuenta.value!="")
			{
				document.form2.bc.value='1';
				document.form2.submit();
			}
		}

		function validar()
		{
			document.form2.submit();
		}

		function agregardetalle()
		{
			if(document.form2.valor.value!="" &&  document.form2.concecont.value!="")
			{	 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.vavlue=2;
				document.form2.submit();
			}
			else {
				alert("Falta informacion para poder Agregar");
			}
		}

		function eliminar(variable)
		{
			if (confirm("Esta Seguro de Eliminar"))
			{
				document.form2.elimina.value=variable;
				//eli=document.getElementById(elimina);
				vvend=document.getElementById('elimina');
				//eli.value=elimina;
				vvend.value=variable;
				document.form2.submit();
			}
		}

		function guardar()
		{
			var validacion01=document.getElementById('codigo').value;
			var validacion02=document.getElementById('nombre').value;
			if (validacion01.trim()!='' && validacion02.trim()!='' && document.form2.concecont.value!='' && document.form2.tipo.value!='')
			{
				despliegamodalm('visible','4','Esta Seguro de Guardar','1');
			}
 			else
			{
				despliegamodalm('visible','2','Faltan datos para completar el registro');
				document.form2.codigo.focus();
				document.form2.codigo.select();
			}

		}

		function despliegamodal2(_valor)
		{
			document.getElementById("bgventanamodal2").style.visibility=_valor;
			if(_valor=="hidden"){document.getElementById('ventana2').src="";}
			else {document.getElementById('ventana2').src="cuentasppto-ventana1.php?ti=1";}
		}

		function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
		{
			document.getElementById("bgventanamodalm").style.visibility=_valor;
			if(_valor=="hidden"){document.getElementById('ventanam').src="";}
			else
			{
				switch(_tip)
				{
					case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
					case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
					case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
					case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
				}
			}
		}

		function respuestaconsulta(pregunta, variable)
		{
			switch(pregunta)
			{
				case "1":	document.getElementById('oculto').value="2";
							document.form2.submit();break;
				case "2":
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
					break;
			}
		}

		function funcionmensaje(){document.location.href = "teso-editaingresos.php?idr="+document.getElementById('codigo').value}
		function validafinalizar(e)
		 {
			 var id=e.id;
			 var check=e.checked;
			 if(id=='terceros'){
				 document.form2.regalias.checked=false;
			 }else{
				 document.form2.terceros.checked=false;
			 }
			 var x = document.getElementById("tipop").value;
			 document.form2.submit();
		 }
	</script>
	<script src="css/programas.js"></script>
	<link href="css/css2.css" rel="stylesheet" type="text/css" />
	<link href="css/css3.css" rel="stylesheet" type="text/css" />
	<?php titlepag();?>
</head>
<body>
	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
	<span id="todastablas2"></span>
	<table>
		<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("teso");?></tr>
		<tr>
			<td colspan="3" class="cinta">
				<a href="teso-ingresos.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
				<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar" /></a> 
				<a href="teso-buscaingresos.php" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
			</td>
		</tr>		  
	</table>

	<?php
	$vigencia=date(Y);
	$linkbd=conectar_bd();
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 

	if(!$_POST[oculto])
	{
		$fec=date("d/m/Y");
		$_POST[fecha]=$fec; 	
 	 	$_POST[tipo]='S';
		$_POST[valoradicion]=0;
		$_POST[valorreduccion]=0;
		$_POST[valortraslados]=0;		 		  			 
		$_POST[valor]=0;	
		$_POST[precio]=0;	
		$sqlr="SELECT codigo FROM tesoingresos WHERE codigo NOT REGEXP  '^[a-z]' ORDER BY codigo DESC";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
		{
			$numIngreso[]=$row[0];
		}
		$_POST[codigo]=max($numIngreso)+1;
		if(strlen($_POST[codigo])==1)
		{
		   $_POST[codigo]='0'.$_POST[codigo];
		}	 
	}
	?>

    <div id="bgventanamodalm" class="bgventanamodalm">
        <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
            </IFRAME>
        </div>
    </div>	  

	<form name="form2" method="post" action="">
		<?php //**** busca cuenta
	  	if($_POST[bc]!='')
		{
			$nresul=buscacuentapres($_POST[cuenta],1);			
			if($nresul!='')
			{
				$_POST[ncuenta]=$nresul;
			}
			else
			{
				$_POST[ncuenta]="";	
			}
		}
		?>
 
    <table class="inicio" align="center" >
		<tr >
			<td class="titulos" colspan="12">.: Agregar Ingresos</td>
			<td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
		</tr>
		<tr  >
			<td  style="width:5%;" class="saludo1">Codigo: </td>
			<td style="width:5%;">
				<input style="width:80%;" name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="4" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"> 
			</td>
			<td style="width:8%;" class="saludo1">Nombre Ingreso: </td>
			<td style="width:28%;">
				<input style="width:95%;" name="nombre" id="nombre" type="text" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)"> 
			</td>
			<td class="saludo1" style="width:6%">Precio Venta:</td>
			<td style="width:7%">
				<input id="precio" name="precio" type="text" value="<?php echo $_POST[precio]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" >
			</td>
			<td style="width:4%" class="saludo1">Tipo:   </td>
			<td style="width:8%;">
				<select style="width:100%" name="tipo" id="tipo"  onChange="validar()" >
					
					<option value="S" <?php if($_POST[tipo]=='S') echo "SELECTED"?>>Simple</option>
					<option value="C" <?php if($_POST[tipo]=='C') echo "SELECTED"?>>Compuesto</option>
				</select>
				<input id="oculto" name="oculto" type="hidden" value="1">		  
			</td>
			<td width="" class="saludo1">Terceros:        </td>
					<td> 
						<div class="c1">
							<input type="checkbox" id="terceros" name="terceros"  onChange="validafinalizar(this)" <?php if($_POST[terceros]=="1"){echo "checked"; } ?> />	
								<label for="terceros" id="t1" ></label
						</div>
					</td>
			        <td  style="width:10%;" class="saludo1">Regalias:</td> 
					<td> 
						<div class="c1">
							<input type="checkbox" id="regalias" name="regalias"  onChange="validafinalizar(this)" <?php if($_POST[terceros]=="R"){echo "checked"; }?> />
							<label for="regalias" id="t1" ></label>
						</div>
					</td>
		</tr> 
	</table>
	<?php
	if($_POST[tipo]=='S') //***** SIMPLE
	{
		//$linkbd=conectar_bd();
	?>
	<table class="inicio">
		<tr>
			<td colspan="2" class="titulos">Agregar Detalle Ingreso</td>
		</tr>                  
		<tr>
			<td style="width:7%;" class="saludo1">Concepto Contable:</td>
			<td style="width:50%;">
				<select name="concecont" id="concecont" style="width:45%;" >
					<option value="-1">Seleccione ....</option>
					<?php
					$sqlr="Select * from conceptoscontables  where modulo='4' and tipo='C' order by codigo";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)) 
					{
						$i=$row[0];
						echo "<option value=$row[0] ";
						if($i==$_POST[concecont])
						{
							echo "SELECTED";
							$_POST[concecontnom]=$row[0]." - ".$row[3]." - ".$row[1];
						}
						echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
					}			
					?>
				</select>
				<input id="concecontnom" name="concecontnom" type="hidden" value="<?php echo $_POST[concecontnom]?>" >
			</td>
		</tr>
        <tr>
			<td style="width:7%;" class="saludo1">Cuenta presupuestal: </td> 
			<td style="width:50%;" valign="middle" >
				<input type="text" id="cuenta" name="cuenta" style="width:10%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">
				<input type="hidden" value="" name="bc" id="bc">
				<a title="Cuentas presupuestales" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"/></a>
				<input name="ncuenta" type="text" style="width:33%;" value="<?php echo $_POST[ncuenta]?>"  readonly>
			</td>
	    </tr> 
		<tr>
			<td style="width:7%;" class="saludo1">Porcentaje:</td>
			<td>
				<input id="valor" name="valor" type="text" value="<?php echo $_POST[valor]; ?>" style="width:10%;" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" > %
			</td>
		</tr>
    </table>
	<?php
	}
	if($_POST[tipo]=='C') //**** COMPUESTO
	{
		//$linkbd=conectar_bd();
		?>
		<table class="inicio">
			<tr>
				<td colspan="3" class="titulos">Agregar Detalle Ingreso</td>
			</tr>                  
		  	<tr>
				<td style="width:7%;" class="saludo1">Concepto Contable:</td>
				<td style="width:50%;">
		  			<select name="concecont" id="concecont" style="width:62%;" >
					  	<option value="-1">Seleccione ....</option>
						<?php
						 	$sqlr="Select * from conceptoscontables  where modulo='4' and tipo='C' order by codigo";
				 			$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								$i=$row[0];
								echo "<option value=$row[0] ";
								if($i==$_POST[concecont])
					 			{
						 			echo "SELECTED";
						 			$_POST[concecontnom]=$row[0]." - ".$row[3]." - ".$row[1];
						 		}
								echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
					     	}   
						?>
			  		</select>
			  		<input id="concecontnom" name="concecontnom" type="hidden" value="<?php echo $_POST[concecontnom]?>" >
			  	</td>
			</tr>
			<tr>
				<td style="width:7%;" class="saludo1">Cuenta presupuestal: </td>
	          	<td style="width:50%;" valign="middle" >
	          		<input type="text" id="cuenta" style="width:10%" name="cuenta" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">
			  		<input type="hidden" value="" name="bc" id="bc">
			  			<a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
			  			<img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>            
			  		<input name="ncuenta" type="text" style="width:50%;" value="<?php echo $_POST[ncuenta]?>" readonly>
			  	</td> 
			</tr>
			<tr>	
				<td style="width:7%;" class="saludo1">Porcentaje:</td>
			  	<td style="width:50%;" >
			  		<input id="valor" name="valor" type="text" value="<?php echo $_POST[valor]; ?>" style="width:10%;" onKeyUp="return tabular(event,this)"  oneyPress="javascript:return solonumeros(event)" >%
			  		<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
	          		<input type="hidden" value="0" name="agregadet">
	          	</td>
		    </tr> 
	    </table>
		 	<?php
				//**** busca cuenta
				if($_POST[bc]!='')
				{
				  	$nresul=buscacuentapres($_POST[cuenta],1);
				  	if($nresul!='')
				   	{
				  		$_POST[ncuenta]=$nresul;
	  		?>
			<script>
				document.getElementById('agregar').focus();
				document.getElementById('agregar').select();
			</script>
			<?php
				  	}
				 	else
				 	{
				  		$_POST[ncuenta]="";
			?>
			<script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			<?php
				  	}
				}
			?>
		<table class="inicio">
			<tr>
				<td class="titulos" colspan="6">Detalle Ingreso</td>
			</tr>
			<tr>
				<td class="titulos2">Cuenta</td>
				<td class="titulos2">Nombre Cuenta</td>
				<td class="titulos2">Concepto</td>
				<td class="titulos2">Porcentaje</td>
				<td class="titulos2">
					<img src="imagenes/del.png" >
					<input type='hidden' name='elimina' id='elimina'>
				</td>
			</tr>
			<?php
					 
				if ($_POST[elimina]!='')
				{ 
					$posi=$_POST[elimina];
					unset($_POST[dcuentas][$posi]);
			 		unset($_POST[dncuentas][$posi]);
					unset($_POST[dconceptos][$posi]);	 		 		 		 		 
					unset($_POST[dnconceptos][$posi]);	 		 		 		 		 		 
					unset($_POST[dvalores][$posi]);		 		
					$_POST[dcuentas]= array_values($_POST[dcuentas]); 
					$_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 
					$_POST[dconceptos]= array_values($_POST[dconceptos]); 
					$_POST[dnconceptos]= array_values($_POST[dnconceptos]); 		 
					$_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 
				}
			
				if ($_POST[agregadet]=='1')
				{
					$cuentacred=0;
					$cuentadeb=0;
					$diferencia=0;
					$_POST[dcuentas][]=$_POST[cuenta];
					$_POST[dncuentas][]=$_POST[ncuenta];
					$_POST[dconceptos][]=$_POST[concecont];		 
					$_POST[dnconceptos][]=$_POST[concecontnom];		 		 
					$_POST[dvalores][]=$_POST[valor];	
					$_POST[agregadet]=0;
			?>
			<script>
				//document.form2.cuenta.focus();	
				document.form2.concecont.select();
			</script>
			<?php
				}
				for ($x=0;$x< count($_POST[dcuentas]);$x++)
				{
					echo "
						<tr>
							<td class='saludo2'>
								<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='8' readonly>
							</td>
							<td class='saludo2'>
								<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='80' readonly>
							</td>
							<td class='saludo2'>
								<input name='dconceptos[]' value='".$_POST[dconceptos][$x]."' type='hidden'>
								<input name='dnconceptos[]' value='".$_POST[dnconceptos][$x]."' type='text' size='80' onDblClick='llamarventanadeb(this,$x)' readonly>
							</td>
							<td class='saludo2'>
								<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='5' onDblClick='llamarventanacred(this,$x)'  readonly>%
							</td>
							<td class='saludo2'>
								<a href='#' onclick='eliminar($x)'>
								<img src='imagenes/del.png'></a>
							</td>
						</tr>";
				}	 
			?>
			<tr></tr>
		</table>	
	<?php
	}
	?>
	<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	</div>
    </form>
  		<?php
			$oculto=$_POST['oculto'];
			if($_POST[oculto]=='2')
			{
				$linkbd=conectar_bd();
				if ($_POST[nombre]!="")
				{
				 	$nr="1";
					if($_POST[terceros]!='')
					{
						$sqlr="INSERT INTO tesoingresos (codigo,nombre,tipo,estado,terceros)VALUES ('$_POST[codigo]','".utf8_decode($_POST[nombre])."','$_POST[tipo]' ,'S','1')";
					}
					elseif($_POST[regalias]!='')
					{
						$sqlr="INSERT INTO tesoingresos (codigo,nombre,tipo,estado,terceros)VALUES ('$_POST[codigo]','".utf8_decode($_POST[nombre])."','$_POST[tipo]' ,'S','R')";
					}else{
						$sqlr="INSERT INTO tesoingresos (codigo,nombre,tipo,estado,terceros)VALUES ('$_POST[codigo]','".utf8_decode($_POST[nombre])."','$_POST[tipo]' ,'S','')";
					}
				 //echo "sqlr:".$sqlr;
				  	if (!mysql_query($sqlr,$linkbd))
					{
					 	echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png' > Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
						//	 $e =mysql_error($respquery);
					 	echo "Ocurri� el siguiente problema:<br>";
				  	 	//echo htmlentities($e['message']);
				  	 	echo "<pre>";
				     	///echo htmlentities($e['sqltext']);
				    	// printf("\n%".($e['offset']+1)."s", "^");
				     	echo "</pre></center></td></tr></table>";
					}
					else
					{
				 		$fecha=date('Y-m-d h:i:s');
						$sqlr="update tesoingresos_precios set estado='N' where ingreso='$_POST[codigo]'";
						mysql_query($sqlr,$linkbd);
				 		$sqlr="INSERT INTO tesoingresos_precios (ingreso,precio,fecha,estado) VALUES ('$_POST[codigo]',$_POST[precio],'$fecha','S')";
						mysql_query($sqlr,$linkbd);
  
						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Ingreso con Exito <img src='imagenes/confirm.png' ></center></td></tr></table>";
						if($_POST[tipo]=='S') //**** simple
	   					{
							//******
							$_POST[valor]=100;
							$sqlr="INSERT INTO tesoingresos_det (codigo,concepto,modulo,tipoconce,porcentaje,cuentapres,estado,vigencia)VALUES ('$_POST[codigo]','$_POST[concecont]','4', 'S', '$_POST[valor]', '$_POST[cuenta]','S',$vigusu)";
					 		//echo "sqlr:".$sqlr;
					  		if (!mysql_query($sqlr,$linkbd))
					  		{
								echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png' > Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
								//	 $e =mysql_error($respquery);
								echo "Ocurri� el siguiente problema:<br>";
							  	 //echo htmlentities($e['message']);
							  	echo "<pre>";
							     ///echo htmlentities($e['sqltext']);
							    // printf("\n%".($e['offset']+1)."s", "^");
							    echo "</pre></center></td></tr></table>";
							}
	 		 				else
				  			{
				 			 	//echo "<table class='inicio'><tr><td class='saludo1'><center> Se ha almacenado el Detalle del Ingreso con Exito <img src='imagenes/confirm.png' ></center></td></tr></table>";
								echo "<script>despliegamodalm('visible','1','Se ha almacenado el Detalle del Ingreso con Exito');</script>";
								//****
					  	 	}
  						}
						//****COMPUESTO	
	 					if($_POST[tipo]=='C') //**** COMPUESTO
	   					{
							//******
							for($x=0;$x<count($_POST[dcuentas]);$x++)
							{
								$sqlr="INSERT INTO tesoingresos_det (codigo,concepto,modulo,tipoconce,porcentaje,cuentapres,estado, vigencia)VALUES ('$_POST[codigo]','".$_POST[dconceptos][$x]."','4', 'C', '".$_POST[dvalores][$x]."', '".$_POST[dcuentas][$x]."','S', $vigusu)";
					 			//echo "sqlr:".$sqlr;
					  			if (!mysql_query($sqlr,$linkbd))
					  			{
									echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png' > Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
									//	 $e =mysql_error($respquery);
	 								echo "Ocurri� el siguiente problema:<br>";
  	 								//echo htmlentities($e['message']);
  	 								echo "<pre>";
     								///echo htmlentities($e['sqltext']);
    								// printf("\n%".($e['offset']+1)."s", "^");
     								echo "</pre></center></td></tr></table>";
								}
 		 						else
  								{
 			 						
									echo "<script>despliegamodalm('visible','1','Se ha almacenado el Detalle del Ingreso con Exito');</script>";
		
	  	 						}
							}//***** fin del for	
  						}
					}
				}
				else
 				{
  					echo "<table class='inicio'><tr><td class='saludo1'><center>Falta informacion para Crear el Centro Costo <img src='imagenes/confirm.png' ></center></td></tr></table>";
 				}
			}
		?> 
		</td>
	</tr>
</table>
</body>
</html>