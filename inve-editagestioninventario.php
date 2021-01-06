<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Almacen</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function despliegamodalm(_valor,_tip,mensa,pregunta, variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('docum').focus();
									document.getElementById('docum').select();
									break;
					}
					document.getElementById('valfocus').value='0';
				}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
						case "5":	document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();
								break;
					case "2":	document.form2.elimina.value=variable;
								vvend=document.getElementById('elimina');
								vvend.value=variable;
								document.form2.sw.value=document.getElementById('tipomov').value ;
								document.form2.submit();
								break;
				}
			}
			function pdf()
			{
				document.form2.action="pdfinventcompra.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function pdf2()
			{
				var tipo=document.getElementById('tipomov').value;
				if(tipo=='2')
				{
					var beneficiario = prompt("Digite el numero de firmas que necesita:");
					document.form2.action="pdfinventcompra2.php?beneficiario="+beneficiario;
				}
				else {document.form2.action="pdfinventcompra2.php";}
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function acta()
			{
				var tipo=document.getElementById('tipomov').value;
				if(tipo=='2')
				{
					var beneficiario = prompt("Digite el numero de firmas que necesita:");
					document.form2.action="pdfacta.php?beneficiario="+beneficiario;
				}
				else
				{
					document.form2.action="pdfacta.php";
				}
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function crearexcel()
			{
				document.form2.action="inve-editagestioninventarioexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function funcionmensaje(){document.location.href = "inve-gestioninventario.php";}
			function validar(){document.form2.submit();}
			function atrasc()
			{
				var vid = document.form2.numero.value;
				var vmov = document.form2.movr.value;
				var vent = document.form2.entr.value;
				var minim = document.form2.minimo.value;
				vid=parseFloat(vid)-1;
				if(vid => minim){document.location.href = "inve-editagestioninventario.php?is="+vid+"&mov="+vmov+"&ent="+vent;}
			}
			function adelante()
			{
				var vid = document.form2.numero.value;
				var vmov = document.form2.movr.value;
				var vent = document.form2.entr.value;
				var maxim = document.form2.maximo.value;
				vid=parseFloat(vid)+1;
				if(vid <= maxim){document.location.href = "inve-editagestioninventario.php?is="+vid+"&mov="+vmov+"&ent="+vent;}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("inve");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='inve-gestioninventarioentrada.php'" class="mgbt"/><img src="imagenes/guardad.png" title="Guardar" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" class="mgbt" onClick="location.href='inve-buscagestioninventario.php'"/><img src="imagenes/nv.png" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" title="nueva ventana" class="mgbt" /><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/print111.png"   title="Imprimir_v2" onClick="pdf2()" class="mgbt"/><img src="imagenes/excel.png" title="Excell" onclick="crearexcel()" class="mgbt"><img  src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='inve-buscagestioninventario.php'" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>	
		<form name="form2" method="post" action=""> 
			<?php
				if(!$_POST[oculto])
				{
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$vigencia=$vigusu;
					$_POST[entr]=$_GET[ent];
					$_POST[movr]=$_GET[mov];
					$sqlb="SELECT MIN(consec),MAX(consec) FROM almginventario WHERE tipomov='$_GET[mov]' AND tiporeg='$_GET[ent]'";
					$resb=mysql_query($sqlb,$linkbd);
					$rowb=mysql_fetch_array($resb);
					$_POST[maximo]=$rowb[1];
					$_POST[minimo]=$rowb[0];
					$sqlb="SELECT * FROM almginventario WHERE consec='$_GET[is]' AND tipomov='$_GET[mov]' AND tiporeg='$_GET[ent]' ";
					$resb=mysql_query($sqlb,$linkbd);
					$rowb=mysql_fetch_array($resb);
					$_POST[numacta]=$rowb[11];
				}
			?>
			<input type="hidden" name="entr" id="entr" value="<?php echo $_POST[entr]?>"/>
			<input type="hidden" name="movr" id="movr" value="<?php echo $_POST[movr]?>"/>
			<table class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="8">.: Gesti&oacute;n de Inventarios </td>
					<td class="cerrar" style="width:7%;"><a onClick="location.href='inve-principal.php'">&nbsp;Cerrar</a></td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.2cm">Consecutivo:</td>
					<td><img src="imagenes/back.png" onClick="atrasc()" class="icobut" title="Anterior"/>&nbsp;<input type="text" id="numero" name="numero" style="width:35%; text-align:center;" value="<?php echo $rowb[9]?>" onClick="document.getElementById('numero').focus(); document.getElementById('numero').select();"/>&nbsp;<img src="imagenes/next.png" onClick="adelante()" class="icobut" title="Sigiente"/></td>
					<td class="saludo1" style="width:10%" >Fecha Registro:</td>
					<td style="width:9%"><input type="date" name="fecha"  style="width:100%;" value="<?php echo $rowb[1];?>"/></td>
					<td class="saludo1" width="8%">Descripci&oacute;n:</td>
					<td width="25%"><input type="text" id="nombre" name="nombre" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $rowb[8]?>"/></td>
					<td class="saludo1" width="14%">Tipo de Movimiento: </td>
				<td colspan="1" >
					<select name="tipomov" id="tipomov" onChange="validar()"  style="width:100%;" >
						<option value="1" <?php if($rowb[2]=='1') echo "SELECTED"; ?>>1 - Entrada</option>
						<option value="2" <?php if($rowb[2]=='2') echo "SELECTED"; ?>>2 - Salida</option>
						<option value="3" <?php if($rowb[2]=='3') echo "SELECTED"; ?>>3 - Reversi&oacute;n de Entrada</option>
						<option value="4" <?php if($rowb[2]=='4') echo "SELECTED"; ?>>4 - Reversi&oacute;n de Salida</option>
					</select>
					<input type="hidden" name="sw" id="sw" value="<?php echo $_POST[tipomov] ?>"/>
					<input type="hidden" name="tip" value="<?php echo $rowb[2] ?>"/>
				</td>
				<td></td>
			</tr>
		</table>
			<input type="hidden" name="maximo" id="maximo" value="<?php echo $_POST[maximo] ?>"/>
			<input type="hidden" name="minimo" id="minimo" value="<?php echo $_POST[minimo] ?>"/>
		<table class="inicio">
			<tr><td colspan="6" class="titulos2">Gesti&oacute;n Inventario</td></tr>
			<tr>
				<td class="saludo1" style="width:3cm;">Tipo Entrada:</td>
				<td >
					<select name="tipoentra" id="tipoentra" >
						<?php
					 		$sqlr="Select * from almtipomov where tipom='$rowb[2]'";
		 					$resp = mysql_query($sqlr,$linkbd);
							while($row =mysql_fetch_row($resp)) 
							{
							$i=$row[0];
							if($i==$rowb[3]){echo "<option value=$row[0] SELECTED>".$row[1].$row[0]." - ".$row[2]."</option>";}
							else {echo "<option value=$row[0]>".$row[1].$row[0]." - ".$row[2]."</option>";}
			     		}   
						?>
				</select> 
         	</td>
	    	<td class="saludo1a" >Documento de Cruce</td>
           	<td >
               	<input type="text" name="docum" id="docum"  value="<?php echo $rowb[4];?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('1');" style="width:80%; text-align:center;"/>
            </td>
	    	<td class="saludo1a" >Descripci&oacute;n</td>
           	<td >
               	<input type="text" name="nombre" id="nombre" value="<?php echo $rowb[8]?>" style="width:100%" readonly/>
				
            </td>
		</tr>
		<tr>
			
			</td>
				<td class="saludo1a">Cargo:</td>
			<td>
				<input type="text" name="cargo"  style="width:100%;" value="<?php echo $_POST[cargo];?>">
			</td>
			<td class="saludo1a">Numero de Acta:</td>
			<td>
            	<input type="text" name="numacta"  style="width:100%;" value="<?php echo $_POST[numacta];?>">
           	</td>
			<td>
				<input name="generaracta" id="generaracta" type="button" value="Generar Acta" style="width:80%; height:22px" onClick="acta()" >
			</td>
		</tr>
	</table>
    <input type="hidden" name="oculto" id="oculto" value="1"/>
		<div class="subpantallac" style="height:50%; overflow-x:hidden;">
			<table class='inicio'>
				<tr>
    				<td class="titulos" colspan="7">Detalle Gesti&oacute;n Inventario - Entrada</td>
			    </tr>
				<tr>
        			<td class="titulos2">Codigo UNSPSC</td>
			       	<td class="titulos2">Codigo Articulo</td>
			        <td class="titulos2">Nombre Articulo</td>
							<td class="titulos2">Cantidad</td>
							<td class="titulos2">U.M</td>
							<td class="titulos2">Valor Unitario</td>
							<td class="titulos2">Valor Total</td>
				</tr>
  			<?php
			  //FIN BUSQUEDA
				$cant=0;
				$sqld="SELECT * FROM almginventario_det WHERE codigo='$_GET[is]' AND tipomov='$_GET[mov]' AND tiporeg='$_GET[ent]'  ORDER BY id_det";
				$resd=mysql_query($sqld,$linkbd);
				$sumvalortotal=0;
				$iter='saludo1a';
        $iter2='saludo2';
				while($rowd=mysql_fetch_array($resd)){
					$cant=$rowd[5];
					if($cant==0)
						$cant=$rowd[6];
					echo"<tr class='$iter'>
						<td  style='width:10%'>
							<input class='inpnovisibles' name='codunsd[]' value='".$rowd[2]."' type='text'  style='width:100%' readonly>	
						</td> 
						<td  style='width:10%'>
							<input class='inpnovisibles' name='codinard[]' value='".$rowd[3]."' type='text'  style='width:100%' readonly>	
						</td>";
						$crit1="WHERE concat_ws(' ', nombre, concat_ws('', grupoinven, codigo)) LIKE '%$rowd[3]'";
						$sqlr="SELECT * FROM almarticulos $crit1 ORDER BY length(grupoinven),grupoinven ASC, length(codigo),codigo ASC";
						$rart=mysql_query($sqlr,$linkbd);
						$wart=mysql_fetch_array($rart);
						echo"<td style='width:10%'>
							<input class='inpnovisibles' name='nomartd[]' value='".$wart[1]."' type='text'  style='width:100%;' readonly>	
						</td>
						<td style='width:10%'>
							<input class='inpnovisibles' name='cantidadd[]' value='".$cant."' type='text'  style='width:100%; text-align:left;' readonly>	
						</td> 
						<td style='width:10%'>
							<input class='inpnovisibles' name='unidadd[]' value='".$rowd[9]."' type='text'  style='width:100%; text-align:left;' readonly>
						</td>
						<td style='text-align:right; width:10%'>
							$ ".number_format($rowd[7],0,',','.')."
							<input class='inpnovisibles' type='hidden' name='valunit[]' value='".$rowd[7]."'>
						</td>
						<td style='text-align:right; width:10%'>
							$ ".number_format($rowd[8],0,',','.')."
							<input class='inpnovisibles' type='hidden' name='valtotal[]' value='".$rowd[8]."'>
						</td>
					 </tr>";
					 $sumvalortotal+=$rowd[8];
					 $aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
			}
			//$sumvalortotal=array_sum($_POST[valtotal]);
			echo"
				<tr class='$iter'>
						<td colspan='6'><h2>Total:</h2></td>
						<td style='text-align:right;'>$ ".number_format($sumvalortotal,0,',','.')."</td>
				</tr>";
		echo "</table>";
		?>
	</div>
</form>
</td></tr>     
</table>
</body>
</html>