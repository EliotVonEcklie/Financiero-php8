<?php // V 1001 21/12/16 ?>
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function pdf()
			{
				document.form2.action="pdfpredialprescripcion.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function atrasc(id)
			{
				id--;
				if (id!=0) 
				{
					document.form2.action="teso-prescripcionver.php?idpres="+id;
					document.form2.submit();
				}
			}
			function adelente(id)
			{
				id++;
				if (id<=document.form2.maximo.value)
				{
					document.form2.action="teso-prescripcionver.php?idpres="+id;
					document.form2.submit();
				}
			
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-prescripciones.php'" class="mgbt"/><img src="imagenes/guardad.png"  title="Guardar" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='teso-buscaprescripciones.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" /><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='teso-buscaprescripciones.php'" class="mgbt"></td>
			</tr>		  
		</table>
		<tr>
			<td colspan="3" class="tablaprin" align="center"> 
			<?php
                $vigencia=date(Y);
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
                $vigencia=$vigusu;
				$_POST[idpres]=$_GET[idpres];
				$_POST[dcuentas]=array();
				$_POST[dncuentas]=array();
				$_POST[dtcuentas]=array();		 
				$_POST[dvalores]=array();
	 			$sqlr="select *from  tesoparametros where estado='S' ";
	 			$res=mysql_query($sqlr,$linkbd);
	 			while($row=mysql_fetch_row($res))
	  			{
	 				$_POST[agespre]=0;
	  				$_POST[tesorero]=buscatercero($row[1]);
	  			}
	 			$sqlr="SELECT max(id) from tesoprescripciones";
	 			$res=mysql_query($sqlr,$linkbd);
	 			$row=mysql_fetch_row($res);
	 			$_POST[maximo]=$row[0];
	 			$sqlr="select *from tesoprescripciones where id=".$_POST[idpres]." ";
	 			$res=mysql_query($sqlr,$linkbd);
	 			$row=mysql_fetch_row($res);
	 			$_POST[idpres]=$row[0];
	 			$_POST[fecha]=$row[1];
	 			$_POST[nresol]=$row[2];
	 			$_POST[codcat]=$row[3];
	 			$sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." ";
	 			$res=mysql_query($sqlr,$linkbd);
	 			while($row=mysql_fetch_row($res))
	  			{
		  			$_POST[catastral]=$row[0];
		  			$_POST[propietario]=$row[6];
		  			$_POST[documento]=$row[5];
		  			$_POST[direccion]=$row[7];
					$_POST[ha]=$row[8];
				  	$_POST[mt2]=$row[9];
				  	$_POST[areac]=$row[10];
				  	$_POST[avaluo]=number_format($row[11],2);
				  	$_POST[tipop]=$row[14];
		 			if($_POST[tipop]=='urbano'){$_POST[estrato]=$row[15];}
					else{$_POST[rangos]=$row[15];}
					$_POST[dtcuentas][]=$row[1];		 
					$_POST[dvalores][]=$row[5];
		 			$_POST[buscav]="";
	  			}
			?>
			<form  name="form2" method="post" action="">
				<input type="hidden" name="maximo" value="<?php echo $_POST[maximo] ?>" >
				<table class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="6">.: Prescripci&oacute;n Predios</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
				</tr>     
				<tr> 
					<td class="saludo1">No Prescripci&oacute;n:</td>
					<td style="width:12%;"><img src="imagenes/back.png" title="anterior" class='icobut' onclick="atrasc(<?php echo $_POST[idpres]?>)" />&nbsp;<input type="text" name="idpres"  id="idpres"  style="width:65%;" onClick="document.getElementById('idpres').focus(); document.getElementById('idpres').select();" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[idpres]?>" readonly/><img src="imagenes/next.png" title="anterior" class='icobut' onclick="adelente(<?php echo $_POST[idpres]?>)"/></td>
        		</tr>
       			<tr>
					<td  class="saludo1" style="width:10%;">C&oacute;digo Catastral:</td>
					<td >
						<input name="tesorero" type="hidden" value="<?php echo $_POST[tesorero] ?>"/>
						<input id="codcat" type="text" name="codcat" style="width:100%;"onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" readonly/> 
						<input type="hidden" name="bt" value="0"/>
                        <input type="hidden" name="chacuerdo" value="1"/>
						<input type="hidden" name="oculto" id="oculto" value="1"/> 
					</td>
					<td class="saludo1" style="width:10%;">No Resoluci&oacute;n:</td>
					<td style="width:10%;"><input name="nresol" type="text" id="nresol" onClick="document.getElementById('nresol').focus(); document.getElementById('nresol').select();" onKeyUp="return tabular(event,this)" style="width:100%;" value="<?php echo $_POST[nresol]?>" readonly/></td>
					<td class="saludo1">Fecha: </td>
					<td><input type="text" name="fecha" value="<?php echo $_POST[fecha]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly/></td>
				</tr>
			</table>
			<table class="inicio">
				<tr><td class="titulos" colspan="8">Informaci&oacute;n Predio</td></tr>
				<tr>
					<td width="119" class="saludo1">C&oacute;digo Catastral:</td>
					<td width="202" >
						<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
						<input name="catastral" type="text" id="catastral" onBlur="buscater(event)" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>" size="20" readonly>
					</td>
					<td width="82" class="saludo1">Avaluo:</td>
					<td colspan="5"><input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" size="20" readonly></td>
				</tr>
                <tr>	    
                    <td width="82" class="saludo1">Documento:</td>         
                    <td>
                        <input name="documento" type="text" id="documento" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[documento]?>" size="20" readonly>
                    </td>
                    <td width="119" class="saludo1">Propietario:</td>
                    <td width="202" >
                        <input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
                        <input name="propietario" type="text" id="propietario" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[propietario]?>" size="40" readonly>
                    </td>
                </tr>
                <tr>
                    <td width="119" class="saludo1">Direcci&oacute;n:</td>
                    <td width="202" >
                        <input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
                        <input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" size="40" readonly>
                    </td>
                    <td width="82" class="saludo1">Ha:</td>
                    <td >
                        <input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" size="6" readonly>
                    </td>
                    <td  class="saludo1">Mt2:</td>
                    <td width="144">
                        <input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" size="6" readonly>
                    </td>
                    <td class="saludo1">Area Cons:</td>
                    <td width="206"><input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" size="6" readonly></td>
                </tr>
				<tr>
                    <td width="119" class="saludo1">Tipo:</td>
                    <td width="202">
                        <select name="tipop" onChange="validar();" disabled>
                            <option value="">Seleccione ...</option>
                            <option value="urbano" <?php if($_POST[tipop]=='urbano') echo "SELECTED"?>>Urbano</option>
                            <option value="rural" <?php if($_POST[tipop]=='rural') echo "SELECTED"?>>Rural</option>
                        </select>
                    </td>
					<?php
						if($_POST[tipop]=='urbano')
						{
							echo" 
								<td class='saludo1'>Estratos:</td>
								<td>
									<select name='estrato' disabled>
										<option value=''>Seleccione ...</option>";
							$sqlr="select *from estratos where estado='S'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								if($row[0]==$_POST[estrato])
								{
									echo "<option value='$row[0]' SELECTED>$row[1]</option>";
									$_POST[nestrato]=$row[1];
								}
							}	 	
							echo"          
									</select>  
									<input type='hidden' value='<$_POST[nestrato]' name='nestrato'/>
								</td>";
						}
						else
						{
			 				echo"
							<td class='saludo1'>Rango Avaluo:</td>
							<td>
								<select name='rangos' disabled>
								<option value=''>Seleccione ...</option>";
							$sqlr="select *from rangoavaluos where estado='S'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								if($row[0]==$_POST[rangos])
								{
									echo "<option value='$row[0]' SELECTED>Entre $row[1] - $row[2] SMMLV</option>";
									$_POST[nrango]=$row[1]." - ".$row[2]." SMMLV";
								}
							}	 	
							echo"            
								</select>
								<input type='hidden' name='nrango' value='$_POST[nrango]' />            
								<input type='hidden' name='agregadet' value='0'/>
							</td>";
						}
					?> 
				</tr> 
			</table>
    		<div class="subpantallac4">
				<table  class="inicio" style="width:30%">
					<tr><td colspan="12" class="titulos">.: Detalles</td></tr> 
					<tr>
						<td class="titulos2" style='text-align:center'>Vigencia</td>
						<td class="titulos2" style='text-align:center'>Avaluo</td>				
					</tr>          
					<?php
						$iter='saludo1a';
						$iter2='saludo2';
						$sqlr="Select * from tesoprescripciones_det where id=$_POST[idpres]";
						$res=mysql_query($sqlr,$linkbd);
						while($r=mysql_fetch_row($res))
						{
							$sqlrAvaluo="SELECT avaluo from tesoprediosavaluos where codigocatastral=$_POST[codcat] AND vigencia='$r[1]'";
							$resAvaluo=mysql_query($sqlrAvaluo,$linkbd);
							$rowAvaluo=mysql_fetch_row($resAvaluo);
							echo "
							<input type='hidden' name='pvigencias[]' id='pvigencias[]' value='$r[1]'/>
							<input type='hidden' name='pavaluo[]' id='pavaluo[]' value='$rowAvaluo[0]'/>
							<tr class='$iter'>
								<td style='text-align:center'>$r[1]</td>
								<td style='text-align:center'>".number_format($rowAvaluo[0],2)."</td>
							</tr>";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
					?>			
				</table>
    		</div>
		</form>
	</body>
</html>