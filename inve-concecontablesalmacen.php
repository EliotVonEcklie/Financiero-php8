<!--V 1000 14/12/16 -->
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
		<title>:: Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else{document.getElementById('ventana2').src="cuentas-ventana01.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if(document.getElementById('valfocus').value=="1")
					{
						document.getElementById('cuenta').focus();
						document.getElementById('cuenta').select();
						document.getElementById('valfocus').value='0';
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":	document.getElementById('oculto').value="3";
								document.form2.submit();break;
				}
			}
			function funcionmensaje(){document.location.href = "inve-concecontablesalmacen.php";}
			function guardar()
			{
				valg01=document.getElementById('codigo').value;
				valg02=document.getElementById('nombre').value;
				valg03=document.getElementById('conarticulos').value;
				if (valg01!='' && valg02!='' && valg03!=0)
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function agregardetalle()
			{
				if(document.getElementById('fecha1').value!='')
				{
					val01=document.getElementById('ncuenta').value;
					if(val01!=""){document.form2.agregadet.value="1";document.form2.submit();}
					else {despliegamodalm('visible','2','Falta informaci�n para poder Agregar Detalle de Modalidad');}
				}
				else
				{
					alert('Falta digitar la Fecha');
				}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function buscacta(e)
			{
				if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}
			}
			function validar3(formulario)
			{
				document.form2.action="teso-concecongastosban.php";
				document.form2.submit();
			}
			
			function despliegamodal2(_valor,v)
			{
				if (document.form2.fecha1.value!='')
				{
					document.getElementById("bgventanamodal2").style.visibility=_valor;
					if(_valor=="hidden"){
						document.getElementById('ventana2').src="";
						document.form2.submit();
					}
					else {
						if(v==1){
							document.getElementById('ventana2').src="cuentasin-ventana1.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==2)
						{
							document.getElementById('ventana2').src="cuentas-ventana2.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==3)
						{
							document.getElementById('ventana2').src="cuentas-ventana3.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==4)
						{
							document.getElementById('ventana2').src="cuentas-ventana4.php?fecha="+document.form2.fecha1.value;
						}
					}
				}
				else
				{
					alert ("Falta digitar la fehca");
				}
			}
		</script>
		<?php titlepag();$vtipo='A';?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="inve-concecontablesalmacen.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="inve-buscaconcecontablesalmacen.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="inve-concecontables.php" class="mgbt"><img src="imagenes/iratras.png" title="Buscar" /></a></td>
			</tr>
   		</table>
  		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" action="inve-concecontablesalmacen.php"> 
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
                if($_POST[oculto]=="")
                {
					$_POST[conarticulos]=0;
                    $sqlr="select MAX(CONVERT(codigo, SIGNED INTEGER)) from conceptoscontables where modulo=5 and tipo='$vtipo' order by codigo Desc";
                    $res=mysql_query($sqlr,$linkbd);
                    $row=mysql_fetch_row($res);
                    $_POST[codigo]=$row[0]+1;
                    if(strlen($_POST[codigo])==1){ $_POST[codigo]="0$_POST[codigo]";}
                }
			?>
    		<table class="inicio" align="center">
      			<tr>
        			<td class="titulos" colspan="8">.: Concepto Contable Deterioro NICSP</td>
        			<td class="cerrar" style="width:7%;"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
					<td class="saludo1" style="width:2cm;">C&oacute;digo:</td>
          			<td style="width:8%;"><input type="text" name="codigo" id="codigo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[codigo]?>" readonly style="width:100%;"/></td>
		 			<td class="saludo1" style="width:2cm;">Nombre:</td>
          			<td style="width:40%;"><input type="text" id="nombre" name="nombre" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();" style="width:100%;"/></td>
                    <td class="saludo1" style="width:2cm;">Tipo:</td>
                    <td>
						<input type="text" name="tipo" id="tipo" value="Causaci�n" style="width:40%;">
						<input type="hidden" value="<?php echo $_POST[defecto]?>" name="defecto" id="defecto">
					</td>
	    		</tr>
    		</table>
			<table class="inicio">
				<tr><td colspan="5" class="titulos2">Crear Detalle Concepto</td></tr>
				<tr>
			<td class="saludo1" style="width:10%">Fecha Inicial:</td>
			<td style="width:10%;">
				<input name="fecha1" id="fecha1" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha1');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
			</td> 
			<td class="saludo1" style="width:2cm;">Cuenta: </td>
         			<td style="width:12%;" >
					<input name="cuenta" id="cuenta" type="text"  value="<?php echo $_POST[cuenta]?>" onKeyUp="return tabular(event,this) " style="width:75%;" onBlur="buscacta(event)"><input type="hidden" value="" name="bc" id="bc">
					<input name="cuenta_" type="hidden" value="<?php echo $_POST[cuenta_]?>">&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',1);" title="Buscar cuenta" class="icobut" />
					</td>
          			<td><input type="text" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>" style="width:87%;" readonly></td>
		</tr>
				<tr>
                	
					
				</tr>
				<tr>
					<td class="saludo1" style="width:2cm;">Tipo:</td>
                    <td>
                    	<select name="debcred" style="width:75%;">
		   					<option value="1" <?php if($_POST[debcred]=='1') echo "SELECTED"; ?>>Debito</option>
		  				</select>
					<td class="saludo1" style="width:2cm;">CC:</td>
                    <td style="width:20%;">
						<select name="cc" id="cc" style="width:75%;" onChange="document.form2.submit();" onKeyUp="return tabular(event,this)" style='width:100%;text-transform:uppercase'>
							<?php
                                $sqlr="SELECT * FROM centrocosto WHERE estado='S'";
                                $res=mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($res)) 
                                {
                                    if($row[0]==$_POST[cc]) {echo "<option value='$row[0]' style='text-transform:uppercase' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]' style='text-transform:uppercase'>$row[0] - $row[1]</option>";}
                                }	 	
                            ?>
   						</select>
	 				</td>
					<td>
          			<input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ></td>
            	</tr>
			</table>
            <input type="hidden" name="oculto" id="oculto" value="0"/>	
    		<input type="hidden" name="agregadet" id="agregadet" value="0"/>
		  	<?php
				if($_POST[bc]=='1')
			 	{
			  		$nresul=buscacuenta($_POST[cuenta]);
			  		if($nresul!='')
			   		{
			  			$_POST[ncuenta]=$nresul;
						echo "<script>document.getElementById('ncuenta').value='$nresul';</script>";
			  		}
					else
			 		{
			 			$_POST[ncuenta]="";
						echo "<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
			  		}
			 	}
			?>
    		<div class="subpantallac2" style="height:57.2%; width:99.6%; overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="7">Detalle Concepto</td></tr>
					<tr>
						<td class="titulos2">Fecha</td>
                    	<td class="titulos2">CC</td>
                        <td class="titulos2">Cuenta</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2">Debito</td>
                        <td class="titulos2">Credito</td>
                        <td class="titulos2">Eliminar</td>
               		</tr>
                    <input type='hidden' name='elimina' id='elimina'>
					<?php
						if ($_POST[oculto]=='3')
						{ 
		 					$posi=$_POST[elimina];
		 					unset($_POST[dcuentas][$posi]);
 		 					unset($_POST[dncuentas][$posi]);
		 					unset($_POST[dccs][$posi]);
		 					unset($_POST[dcreditos][$posi]);		 		 		 		 		 
		 					unset($_POST[ddebitos][$posi]);	
							unset($_POST[fecha][$posi]);
		 					$_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 					$_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 
		 					$_POST[dccs]= array_values($_POST[dccs]);
							$_POST[fecha]= array_values($_POST[fecha]);
		 					$_POST[dcreditos]= array_values($_POST[dcreditos]); 
		 					$_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
						}
						if ($_POST[agregadet]=='1')
		 				{
							$_POST[dccs][]=$_POST[cc];
							$_POST[fecha][]=$_POST[fecha1];	
		 					$_POST[dcuentas][]=$_POST[cuenta];
		 					$_POST[dncuentas][]=$_POST[ncuenta];
		 					if ($_POST[debcred]==1){$_POST[dcreditos][]='N';$_POST[ddebitos][]="S";}
		 					else {$_POST[dcreditos][]='S';$_POST[ddebitos][]="N";}
		 					$_POST[agregadet]=0;
		  					echo"<script>document.getElementById('ncuenta').value='';document.getElementById('cuenta').value='';</script>";
		 				}
						$_POST[conarticulos]=count($_POST[dcuentas]);
						$iter='saludo1a';
		  				$iter2='saludo2';
		 				for ($x=0;$x< count($_POST[dcuentas]);$x++)
						{
							echo "
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
								<td style='width:10%'><input name='fecha[]' value='".$_POST[fecha][$x]."' type='text' class='inpnovisibles' style='width:100%;' readonly></td>
								<td style='width:5%'><input type='text' class='inpnovisibles' name='dccs[]' value='".$_POST[dccs][$x]."' readonly style='width:100%;'  ></td>
								<td style='width:10%'><input type='text' class='inpnovisibles' name='dcuentas[]' value='".$_POST[dcuentas][$x]."' style='width:100%;'  readonly></td>
								<td><input type='text' class='inpnovisibles' name='dncuentas[]' value='".$_POST[dncuentas][$x]."' style='width:100%;' readonly></td>
								<td style='width:5%'><input type='text' class='inpnovisibles' name='ddebitos[]' value='".$_POST[ddebitos][$x]."' style='width:100%;'  onDblClick='llamarventanadeb(this,$x)' readonly></td>
								<td style='width:5%'><input type='text' class='inpnovisibles' name='dcreditos[]' value='".$_POST[dcreditos][$x]."' style='width:100%;'  onDblClick='llamarventanacred(this,$x)' readonly></td>
								<td style='width:5%'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
							</tr>";
							$aux=$iter;
		 					$iter=$iter2;
		 					$iter2=$aux;
		 				}	 
		 			?>
				</table>
				<?php 
					if($_POST[oculto]=='2')	//********** GUARDAR EL COMPROBANTE ***********
					{
						//rutina de guardado cabecera
						$sqlr="insert into conceptoscontables (codigo,nombre,modulo,tipo) values ('$_POST[codigo]','$_POST[nombre]','5', '$vtipo')";
						if(!mysql_query($sqlr,$linkbd))
		 					{echo"<script>despliegamodalm('visible','2','No Se ha Almacenado El Concepto Contable');</script>";}
		 				else
		 				{
							for($x=0;$x<count($_POST[dcuentas]);$x++) //**** crear el detalle del concepto
		 					{
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha][$x],$fecha);
								$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		  						$sqlr="insert into conceptoscontables_det (codigo,tipo,tipocuenta,cuenta,cc,debito,credito,estado,modulo,fechainicial) values ('$_POST[codigo]','$vtipo','N','".$_POST[dcuentas][$x]."','".$_POST[dccs][$x]."','".$_POST[ddebitos][$x]."','".$_POST[dcreditos][$x]."','S','5','$fechaf')";
								if(!mysql_query($sqlr,$linkbd))
		  						echo"<script>despliegamodalm('visible','2','No Se han Almacenado los Detalles  del Concepto Contable');</script>";
								else{echo"<script>despliegamodalm('visible','1','Se han Almacenado con Exito El Concepto Contable');</script>";}
		 					}
		 				}	
	   				}
				?>	
			</div>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
        	<input type="hidden" name="conarticulos" id="conarticulos" value="<?php echo $_POST[conarticulos];?>"> 
		</form>
	</body>
</html>