<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}
			function buscactap(e){if (document.form2.cuentap.value!=""){document.form2.bcp.value='1';document.form2.submit();}}
			function validar(){document.form2.submit();}
			function agregardetalle()
			{
				if(document.getElementById('tipo').value == "A")
				{
					if(document.getElementById('ncuentap').value!="" && document.getElementById('concecont').value!="-1"){document.getElementById('bloqueo01').value='1';document.form2.agregadet.value=1;document.form2.submit();}
 					else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
				}
				else
				{
					if(document.getElementById('concecont').value!="-1")
					{document.getElementById('bloqueo01').value='1';document.form2.agregadet.value=1;document.form2.submit();}
 					else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
				}
			}
			function eliminar(variable)
			{
					document.form2.elimina.value=variable;
					despliegamodalm('visible','4','Esta Seguro de Eliminar Detalle','1');
			}
			function guardar()
			{
			//alert("cd:"+document.getElementById('condeta').value);
				var validacion01=document.getElementById('nombre').value;
				if (document.form2.codigo.value!='' && validacion01.trim()!='' )
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','2')}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
 			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{document.getElementById('ventana2').src="scuentasppto-ventana01.php?ti=2";}
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
						document.getElementById('cuentap').focus();
						document.getElementById('cuentap').select();
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
					case "1":	//if(document.getElementById('condeta').value=='1'){document.getElementById('bloqueo01').value='0'}
								document.getElementById('oculto').value="6";
								document.form2.submit();break;
					case "2":	document.form2.oculto.value="2";
								document.form2.submit();break;
				}
			}
		</script>
		<script>
			function iratras(scrtop, numpag, limreg){
				var idcta=document.getElementById('codigo').value;
				location.href="hum-buscaparafiscales.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg;
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
		<table>
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
        	<tr>
  				<td colspan="3" class="cinta"><a href="hum-tablasparafiscales.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"  border="0" /></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="hum-buscaparafiscales.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a><a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
			</tr>		  
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" action="">
        	<input type="hidden" name="valfocus" id="valfocus" value="1"/>
			<?php
				$vigencia=date(Y);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if($_POST[oculto]==""){$_POST[bloqueo01]="1";}
				if(!$_POST[oculto])
				{
					$sqlr="select *from humparafiscales where  humparafiscales.codigo='$_GET[idr]' ";
					$cont=0;
 					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{	 
						$_POST[codigo]=$row[0];
						$_POST[nombre]=$row[1]; 	
						$_POST[tipo]=$row[2];
						$_POST[porcentaje]=$row[3];		 
						$cont=$cont+1; 
					}
					$_POST[dccs]=array();
					$_POST[dsecs]=array();		 
					$_POST[dcuentasp]=array();
					$_POST[dncuentasp]=array();
					$_POST[dcuentas]=array();
					$_POST[dncuentas]=array();
					$_POST[dconceptos]=array();
					$_POST[dnconceptos]=array();		 		 
					$_POST[dvalores]=array();
					$_POST[dcreditos]=array();
					$_POST[ddebitos]=array();
					$sqlr="select *from  humparafiscales_det  where humparafiscales_det.codigo='$_GET[idr]' and humparafiscales_det.vigencia='$vigusu'";
					$res=mysql_query($sqlr,$linkbd); 
					$cont=0;
					while ($row=mysql_fetch_row($res)) 
					{
						if( $_POST[tipo]=='D')// Desc
						{
							$_POST[dccs][]=$row[2];
							$_POST[dcuentasp][]=$row[6];
							$_POST[dncuentasp][]=buscacuentapres($row[6],2);
							$_POST[dcuentas][]=$row[3];
							$_POST[dncuentas][]=buscacuenta($row[3]);
							$_POST[dconceptos][]=$row[8];
							$_POST[dnconceptos][]=buscaconcepto($row[8], '2');		 
							$_POST[dvalores][]=$row[4];	
							$_POST[dcreditos][]=$row[5];
							$_POST[ddebitos][]=$row[4];	
						}
						if( $_POST[tipo]=='A')// A	
						{
							$_POST[dccs][]=$row[2];
							$_POST[dsecs][]=$row[7];		 
							$_POST[dcuentasp][]=$row[6];
							$_POST[dncuentasp][]=buscacuentapres($row[6],2);
							$_POST[dcuentas][]=$row[3];
							$_POST[dncuentas][]=buscacuenta($row[3]);
							$_POST[dconceptos][]=$row[8];
							$_POST[dnconceptos][]=buscaconcepto($row[8],'2');	 
							$_POST[dvalores][]=$row[4];
							$_POST[dcreditos][]=$row[5];
							$_POST[ddebitos][]=$row[4];				
						}
						$cont=$cont+1;
					}
					$fec=date("d/m/Y");
					$_POST[fecha]=$fec; 	
				}
                if($_POST[bcp]!='') //**** busca cuentas
                {
                    $nresul=buscacuentapres($_POST[cuentap],2);			
                    if($nresul!=''){$_POST[ncuentap]=$nresul;}
                    else{$_POST[ncuentap]="";}
                }
               
			?>
            <input type="hidden" name="bloqueo01" id="bloqueo01" value="<?php echo $_POST[bloqueo01];?>"/>
    		<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="8">.: Agregar Parafiscal</td>
                    <td class="cerrar" style="width:7%;"><a href="hum-principal.php">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:7%;">Codigo:</td>
                    <td style="width:6%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" maxlength="2"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:98%;"></td>
                    <td class="saludo1" style="width:7%;">Nombre:</td>
                    <td style="width:35%;"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)" style="width:99%;"></td>
                    <td class="saludo1" style="width:2%;">%</td>
                    <td style="width:8%;"><input type="text" name="porcentaje" id="porcentaje" value="<?php echo $_POST[porcentaje]?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width:90%;"></td>
                    <td class="saludo1" style="width:7%;">Tipo:</td>
                    <td>
                        <select name="tipo" id="tipo" onChange="validar()">
                            <?php
                                if ($_POST[bloqueo01]=="0")
                                {
                                    echo"<option value=''>Seleccione</option>"; 
                                    echo"<option value='D'";
                                    if($_POST[tipo]=='D') {echo "SELECTED";} 
                                    echo">Descuento</option>";	
                                    echo"<option value='A'"; 
                                    if($_POST[tipo]=='A') {echo "SELECTED";} 
                                    echo">Aporte</option>";	
                                }
                                elseif($_POST[tipo]=='D'){echo"<option value='D' SELECTED>Descuento</option>";}
                                else {echo"<option value='A' SELECTED>Aporte</option>";}
                                
                                
                            ?>
                        </select>
                    </td>
                </tr> 
      	</table>
      	<input type="hidden" name="oculto" id="oculto" value="1">
		<?php
			if($_POST[tipo]=='A')
	    	{			
	   	?>
	   	 		<table class="inicio">
	   				<tr><td colspan="8" class="titulos">Agregar Detalle Variable de Pago</td></tr>                  
	  		  		<tr>
                    	<td class='saludo1' style="width:14%;">Cuenta presupuestal: </td>
                        <td valign='middle' style="width:50%;"><input type='text' id='cuentap' name='cuentap' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur='buscactap(event)' value='<?php echo $_POST[cuentap]?>' onClick="document.getElementById('cuentap').focus();document.getElementById('cuentap').select();" style="width:30%;"><input type='hidden' value='' name='bcp' id='bcp'>&nbsp;<a href='#' onClick="despliegamodal2('visible','2');"><img src='imagenes/buscarep.png' align='absmiddle' border='0'></a>&nbsp;<input type='text' name='ncuentap' id="ncuentap"  value='<?php echo $_POST[ncuentap]?>' style="width:60%;"  readonly></td>
						<td class="saludo1" style="width:6%;">Sector:</td>
                        <td>
                        	<select name='sector' id="sector">
		   						<option value='N/A' <?php if($_POST[sector]=='N/A') echo 'SELECTED'; ?>>N/A</option>
		   						<option value='publico' <?php if($_POST[sector]=='publico') echo 'SELECTED'; ?>>Publico</option>
             					<option value='privado' <?php if($_POST[sector]=='privado') echo 'SELECTED'; ?>>Privado</option>
		  					</select>
                    	</td>
                   	</tr>
                    <tr>
	 	      			<td  class='saludo1'>Concepto Contable: </td>
                        <td colspan='1'  valign='middle' >
                            <select name='concecont' id='concecont' onChange='validar()' style="width:40%;">
                                <option value='-1'>Seleccione ....</option>
                                <?php
                                    $sqlr="Select * from conceptoscontables  where modulo='2' and tipo='H' order by codigo";
                                    $resp = mysql_query($sqlr,$linkbd);
                                    while ($row =mysql_fetch_row($resp)) 
                                    {
                                        if($row[0]==$_POST[concecont])
                                        {
                                            echo "<option value='$row[0]' SELECTED>$row[0] - $row[3] - $row[1]</option>";
                                            $_POST[concecontnom]=$row[0]." - ".$row[3]." - ".$row[1];
                                        }
                                        else {echo "<option value='$row[0]'>$row[0] - $row[3] - $row[1]</option>";} 
                                    }   
                                ?>
                            </select>
                            <input name="concecontnom" type="text" value="<?php echo $_POST[concecontnom]?>" style="width:53%;" readonly></td>	 
		  					<td  class="saludo1">CC:</td>
                            <td >
                                <select name="cc" id="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
                                    <?php
                                        $sqlr="select *from centrocosto where estado='S'";
                                        $res=mysql_query($sqlr,$linkbd);
                                        while ($row =mysql_fetch_row($res)) 
                                        {
                                            echo "";
                                            $i=$row[0];
                                            if($i==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                            else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";} 
                                        }	 	
                                    ?>
                                </select>
                                <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
                                <input type="hidden" value="0" name="agregadet">
                            </td>
                		</tr>
    				</table>
	 			<?php
					//**** busca cuenta
					if($_POST[bcp]!='')
			 		{
			  			$nresul=buscacuentapres($_POST[cuentap],2);
						if($nresul!='')
						{
							$_POST[ncuentap]=$nresul;
							echo"
							<script>
								document.getElementById('bcp').value='';
								document.getElementById('ncuentap').value='$nresul';
								document.getElementById('sector').focus();
							</script>";
						}
						else
						{
							echo "<script>document.getElementById('valfocus').value='3';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
						}
			 		}
				?>
       			<div class="subpantalla" style="height:56.5%; width:99.6%; overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="10">Detalle Variable - Parametrizacion</td></tr>
					<tr>
                    	<td class="titulos2" style='width:4%;'>CC</td>
                        <td class="titulos2" style='width:8%;'>Sector</td>
                        <td class="titulos2" style='width:10%;'>Cta Presup</td>
                        <td class="titulos2" style='width:30%;'>Nom Presupuestal</td>
                        <td class="titulos2" style='width:20%;'>Cta Contable</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2" style='width:5%;'>Eliminar<input type='hidden' name='elimina' id='elimina'></td>
                  	</tr>
					<?php
						if ($_POST[oculto]=='6')
		 				{ 
		 					$posi=$_POST[elimina];
							unset($_POST[dccs][$posi]);
							unset($_POST[dsecs][$posi]);
							unset($_POST[dcuentas][$posi]);
							unset($_POST[dncuentas][$posi]);
							unset($_POST[dcuentasp][$posi]);
							unset($_POST[dncuentasp][$posi]);
							unset($_POST[dconceptos][$posi]);	 		 		 		 		 
							unset($_POST[dnconceptos][$posi]);	 		 		 		 		 		  		
							$_POST[dccs]= array_values($_POST[dccs]); 
							$_POST[dsecs]= array_values($_POST[dsecs]); 		 
							$_POST[dcuentasp]= array_values($_POST[dcuentasp]); 
							$_POST[dncuentasp]= array_values($_POST[dncuentasp]); 		 		 
							$_POST[dcuentas]= array_values($_POST[dcuentas]); 
							$_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 
							$_POST[dconceptos]= array_values($_POST[dconceptos]); 
		 					$_POST[dnconceptos]= array_values($_POST[dnconceptos]); 		 	 		 		 		 
						}
						if ($_POST[agregadet]=='1')
		 				{
		  					$cuentacred=0;
		  					$cuentadeb=0;
		  					$diferencia=0;
		 					$_POST[dccs][]=$_POST[cc];
							$_POST[dsecs][]=$_POST[sector];		 
							$_POST[dcuentasp][]=$_POST[cuentap];
							$_POST[dncuentasp][]=$_POST[ncuentap];
							$_POST[dcuentas][]=$_POST[cuenta];
							$_POST[dncuentas][]=$_POST[ncuenta];
							$_POST[dconceptos][]=$_POST[concecont];		 
							$_POST[dnconceptos][]=$_POST[concecontnom];		 		 
							$_POST[dvalores][]=$_POST[valor];	
		  					if ($_POST[debcred]==1){$_POST[dcreditos][]='N';$_POST[ddebitos][]="S";}
		 					else{$_POST[dcreditos][]='S'; $_POST[ddebitos][]="N";}
		 					$_POST[agregadet]=0;
		  					echo"
		 					<script>		 	
                                document.form2.cuenta.value='';	
                                document.form2.ncuenta.value='';
                                document.form2.cuentap.value='';	
                                document.form2.ncuentap.value='';														
                                document.form2.cuentap.select();
                            </script>";
		 				}
		 				$iter='saludo1a';
						$iter2='saludo2';
						$cdtll=count($_POST[dccs]);
						$_POST[condeta]=$cdtll;
                        for ($x=0;$x< $cdtll;$x++)
                        {
                            echo"
                            <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
                                <td><input type='text' name='dccs[]' value='".$_POST[dccs][$x]."' class='inpnovisibles' style='width:100%;' readonly></td>
								<td><input type='text' name='dsecs[]' value='".$_POST[dsecs][$x]."' class='inpnovisibles' style='width:100%;' readonly></td>
                                <td><input type='text' name='dconceptos[]' value='".$_POST[dconceptos][$x]."' class='inpnovisibles' style='width:100%;' readonly></td>
                                <td><input type='text' name='dnconceptos[]' value='".$_POST[dnconceptos][$x]."' class='inpnovisibles' style='width:100%;' readonly></td>
                                <td><input type='text' name='dcuentasp[]' value='".$_POST[dcuentasp][$x]."' class='inpnovisibles' style='width:100%;' readonly></td>
                                <td><input type='text' name='dncuentasp[]' value='".$_POST[dncuentasp][$x]."' class='inpnovisibles' style='width:100%;' readonly></td>
                                <td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
                            </tr>";
							 $aux=$iter;
							 $iter=$iter2;
							 $iter2=$aux;
                        }	 
		 			?>
				</table>	
    		</div>
	   		<?php
				}
  				if ($_POST[tipo]=='D')		
				{
			?>
			    	<table class="inicio">
	   				<tr><td colspan="6" class="titulos">Agregar Detalle Variable de Pago</td></tr>                  
	  		  		<tr>
              	      <td class="saludo1" style="width:14%;">Concepto Contable: </td>
          			<td valign="middle" style="width:50%;">
          				<select name="concecont" id="concecont" onChange="validar()" style="width:40%;">
				  			<option value="-1">Seleccione ....</option>
							<?php
					 			$sqlr="Select * from conceptoscontables  where modulo='2' and tipo='H' order by codigo";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[concecont])
			 						{
				 						echo "<option value='$row[0]' SELECTED>$row[0] - $row[3] - $row[1]</option>";
										$_POST[concecontnom]=$row[0]." - ".$row[3]." - ".$row[1];
									}
									else {echo "<option value='$row[0]'>$row[0] - $row[3] - $row[1]</option>";}
			     				}   
							?>
		  				</select>
 						<input name="concecontnom" type="text" value="<?php echo $_POST[concecontnom]?>" style="width:53%;" readonly>
                 	</td>	 
               		<td class="saludo1" style="width:6%;">CC:</td>
                    <td>
						<select name="cc" id="cc" onChange="validar()" onKeyUp="return tabular(event,this)">
							<?php
								$sqlr="select *from centrocosto where estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				   	 			{
					 				if($row[0]==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}	 	
							?>
   						</select>
						<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
						<input type="hidden" value="0" name="agregadet">
                 	</td>
       				</tr>
   				</table>
	 			<?php
					if($_POST[bcp]!='')//**** busca cuenta
			 		{
			  			$nresul=buscacuentapres($_POST[cuentap],2);
						if($nresul!='')
						{
							$_POST[ncuentap]=$nresul;
							echo"
							<script>
								document.getElementById('bcp').value='';
								document.getElementById('ncuentap').value='$nresul';
								document.getElementById('bcp').value='';
							</script>";
						}
						else
						{
							echo "<script>document.getElementById('valfocus').value='3';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
						}
			 		}
				?>
        		<div class="subpantalla" style="height:60.2%; width:99.6%; overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="4">Detalle Variable - Parametrizacion</td></tr>
					<tr>
                    	<td class="titulos2" style='width:4%;'>CC</td>
                        <td class="titulos2">Concepto Contable</td>
                        <td class="titulos2">Nombre Concepto</td>
                        <td class="titulos2" style='width:5%;'>Eliminar<input type='hidden' name='elimina' id='elimina'></td>
                   	</tr>
					<?php
						if ($_POST[oculto]=='6')
		 				{ 
		 					$posi=$_POST[elimina];
		 					unset($_POST[dccs][$posi]);
							unset($_POST[dcuentas][$posi]);
							unset($_POST[dncuentas][$posi]);
							unset($_POST[dcuentasp][$posi]);
							unset($_POST[dncuentasp][$posi]);
							unset($_POST[dconceptos][$posi]);	 		 		 		 		 
							unset($_POST[dnconceptos][$posi]);	 		 		 		 		 		  		
							$_POST[dccs]= array_values($_POST[dccs]); 
							$_POST[dcuentasp]= array_values($_POST[dcuentasp]); 
							$_POST[dncuentasp]= array_values($_POST[dncuentasp]); 		 		 
							$_POST[dcuentas]= array_values($_POST[dcuentas]); 
							$_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 
							$_POST[dconceptos]= array_values($_POST[dconceptos]); 
							$_POST[dnconceptos]= array_values($_POST[dnconceptos]); 		 	 		 		 		 
		 				}
						if ($_POST[agregadet]=='1')
		 				{
		  					$cuentacred=0;
		  					$cuentadeb=0;
		  					$diferencia=0;
		 					$_POST[dccs][]=$_POST[cc];
		 					$_POST[dcuentasp][]=$_POST[cuentap];
		 					$_POST[dncuentasp][]=$_POST[ncuentap];
		 					$_POST[dcuentas][]=$_POST[cuenta];
		 					$_POST[dncuentas][]=$_POST[ncuenta];
		 					$_POST[dconceptos][]=$_POST[concecont];		 
		 					$_POST[dnconceptos][]=$_POST[concecontnom];		 		 
		 					$_POST[dvalores][]=$_POST[valor];	
		  					if ($_POST[debcred]==1){$_POST[dcreditos][]='N';$_POST[ddebitos][]="S";}
		 					else {$_POST[dcreditos][]='S';$_POST[ddebitos][]="N";}
		 					$_POST[agregadet]=0;
		  					echo"
		 						<script>
		 							document.form2.cuenta.value='';	
		 							document.form2.ncuenta.value='';			 										
									document.form2.cuenta.select();
		 						</script>";
		 				}
		 				$iter='saludo1a';
						$iter2='saludo2';
						$cdtll=count($_POST[dccs]);
						$_POST[condeta]=$cdtll;
		 				for ($x=0;$x< $cdtll;$x++)
		 				{
							echo "
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
								<td><input type='text' name='dccs[]' value='".$_POST[dccs][$x]."' class='inpnovisibles' style='width:100%;' readonly></td>
								<td><input type='text' name='dconceptos[]' value='".$_POST[dconceptos][$x]."' class='inpnovisibles' style='width:100%;' readonly></td>
								<td><input type='text' name='dnconceptos[]' value='".$_POST[dnconceptos][$x]."' class='inpnovisibles' style='width:100%;' readonly></td>
								<td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
							</tr>";
							 $aux=$iter;
							 $iter=$iter2;
							 $iter2=$aux;
		 				}	 
		 			?>
				</table>	
    		</div>
            <input type="hidden" name="condeta" id="condeta" value="<?php echo $_POST[condeta];?>"/>
		<?php	
		}
		$oculto=$_POST['oculto'];
		if($_POST[oculto]=='2')
		{
			if ($_POST[nombre]!="")
 			{
 				$nr="1";
 				$sqlr="delete from humparafiscales where codigo='$_POST[codigo]'";
 				mysql_query($sqlr,$linkbd);
 				$sqlr="INSERT INTO humparafiscales (codigo,nombre,tipo,porcentaje,estado)VALUES ('$_POST[codigo]','".$_POST[nombre]."','$_POST[tipo]' ,$_POST[porcentaje],'S')";
  				if (!mysql_query($sqlr,$linkbd))
				{
	 				despliegamodalm('visible','2','Manejador de Errores BD, No se pudo ejecutar la petición humparafiscales');
				}
  				else
  				{
					//****COMPUESTO	
					$sqlr="delete from humparafiscales_det where codigo='$_POST[codigo]' and humparafiscales_det.vigencia='$vigusu'";
 					mysql_query($sqlr,$linkbd);
					for($x=0;$x<count($_POST[dccs]);$x++)
		 			{
						$sqlr="INSERT INTO humparafiscales_det (codigo,cc,cuentacon,debito,credito,cuentapres,sector,concepto,estado,vigencia)VALUES ('$_POST[codigo]','".$_POST[dccs][$x]."', '".$_POST[dcuentas][$x]."', '".$_POST[ddebitos][$x]."', '".$_POST[dcreditos][$x]."','".$_POST[dcuentasp][$x]."' ,'".$_POST[dsecs][$x]."', '".$_POST[dconceptos][$x]."' ,'S',$vigusu)";
  						if (!mysql_query($sqlr,$linkbd))
						{despliegamodalm('visible','2','Manejador de Errores BD, No se pudo ejecutar la petición humparafiscales_det');}
 		 				else {//despliegamodalm('visible','3','Se ha almacenado el Detalle de la Variable con Exito');					
						$c=$c+1;
						}
					}//***** fin del for	
					?>
					<script>
					despliegamodalm("visible","3","Se ha almacenado Registros en el Detalle de la Variable con Exito")
					</script>;
					<?php
  				}
 			}
			else {despliegamodalm('visible','2','Falta informacion para Crear la Variable');}
		}
		?>
        <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
	</form>
	</body>
</html>