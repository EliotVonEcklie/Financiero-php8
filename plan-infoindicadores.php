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
			function pdf()
			{
				document.form2.action="plan-pdfindicadores.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
  				<td colspan="3" class="cinta">
					<a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a> 
					<a href="#" class="mgbt"><img src="imagenes/guardad.png" title="Guardar" /></a> 
					<a href="#" class="mgbt"><img src="imagenes/buscad.png" title="Buscar"/></a> 
					<a class="mgbt" onClick="pdf();" ><img src="imagenes/print.png" title="Imprimir" style="width:29px; height:25px;"></a> 
					<a class="mgbt" onClick="pdf();" ><img src="imagenes/chart.png" title="Imprimir" style="width:29px; height:25px;"></a> 
					<a href="#" class="mgbt" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> 
				</td>
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
                    <td class="titulos" colspan="3">Informe de Indicadores</td>  
                    <td class="cerrar" style='width:5%'><a href="plan-principal.php">Cerrar</a></td>
                </tr>
				<tr>
                    <td class="saludo1" style='width:10%'>Vigencia:</td>
                    <td style='width:20%'> 
						<select name="vigplan" onChange="validar()">
							<?php
							$sqlv="select *from dominios where nombre_dominio='VIGENCIA_PD' order by tipo desc, valor_inicial";
							$resv=mysql_query($sqlv,$linkbd);
							while($wv=mysql_fetch_row($resv)){
								if($_POST[vigplan]==$wv[0].' - '.$wv[1]){
									$selected='selected="selected"';
									$_POST[vigenciai]=$wv[0];
									$_POST[vigenciaf]=$wv[1];
								}
								else	
									$selected='';
								echo'<option value="'.$wv[0].' - '.$wv[1].'" '.$selected.'>'.$wv[0].' - '.$wv[1].'</option>';
							}
							?>
						</select>
						<input type="hidden" name="vigenciai" id="vigenciai" value="<?php echo $_POST[vigenciai];?>" >
						<input type="hidden" name="vigenciaf" id="vigenciaf" value="<?php echo $_POST[vigenciaf];?>" > 
                    </td>
					<td style='width:60%'></td>
				</tr>
  				<tr>
                	<td class="saludo1">Tipo de Creación</td>
  					<td>
                        <?php
                        $sqlr="SELECT * FROM plannivelespd WHERE inicial='$_POST[vigenciai]' AND final='$_POST[vigenciaf]' AND nombre='INDICADORES' ORDER BY orden";
                        $res=mysql_query($sqlr,$linkbd);
                        $row =mysql_fetch_row($res);
						$_POST[orden]=$row[1];
						$_POST[tipo]=$row[2];
						$_POST[nomtipo]=$row[2];
                        ?>
						<input type="text" id="tipo" name="tipo" value="<?php echo $_POST[tipo] ?>" readonly>
						<input type="hidden" id="orden" name="orden" value="<?php echo $_POST[orden] ?>">
						<input type="hidden" id="nomtipo" name="nomtipo" value="<?php echo $_POST[nomtipo] ?>">
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
							<td class='saludo1'>".strtoupper($wres[0]).":</td>
							<td colspan='2' style='width:100%'>
								<select name='niveles[$i]' onChange='validar()' onKeyUp='return tabular(event,this)' style='width:60%;'>
									<option value=''>Seleccione....</option>";
									$sqlr="SELECT * FROM presuplandesarrollo WHERE padre='$buspad' AND vigencia='$_POST[vigenciai]' AND vigenciaf='$_POST[vigenciaf]' ORDER BY codigo";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										if($row[0]==$_POST[niveles][$i]){
											$_POST[arrpad][$i]=$row[0];
											$_POST[arrnpad][$i]=$row[1];
											echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										}
										else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	 
									}	
								echo"</select>
								<input type='hidden' name='arrpad[$i]' value='".$_POST[arrpad][$i]."' >
								<input type='hidden' name='arrnpad[$i]' value='".$_POST[arrnpad][$i]."' >";

							echo"</td>
						</tr>";
					}
					$_POST[padre]=$_POST[arrpad][($i-1)];
				}
       			?>   
    		</table>
			<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]?>">
            <input type="hidden" name="valcod" id="valcod" value="0"/>
   			<?php
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
				
				$numvig=($_POST[vigenciaf]-$_POST[vigenciai])+1;
				$w=100/$numvig;
				$hw=(100/$numvig)/2;
				echo"
    			<table class='inicio'>
    				<tr>
						<td class='titulos' rowspan='2'>Tipo</td>";
						for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
						{
							echo "<td class='titulos' colspan='2' style='width:$w%;'>$x<input type='hidden' name='vigenciasm[]' value='$x'></td>";
						}
					echo"</tr>
					<tr>";
					for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
					{
						echo"<td class='titulos' style='width:$hw%;'>Programado</td>
						<td class='titulos' style='width:$hw%;'>Ejecutado</td>";
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
								$_POST[imetas][$c]=$rwd[4];
							}
							echo"<td>
								<input type='text' name='mmetas[]' value='".$_POST[mmetas][$c]."' placeholder='0' style='text-align:center; width:90%;' readonly>
							</td>
							<td>
								<input type='text' name='imetas[]' value='".$_POST[imetas][$c]."' placeholder='0' style='text-align:center; width:90%;' readonly>
							</td>";
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
								$_POST[ivetas][$c]=$rwd[3];
							}
							echo"<td>
								<input type='text' name='vmetas[]' value='".$_POST[vmetas][$c]."' placeholder='0' style='text-align:center; width:90%;' readonly>
							</td>
							<td>
								<input type='text' name='ivetas[]' value='".$_POST[ivetas][$c]."' placeholder='0' style='text-align:center; width:90%;' readonly>
							</td>";
							$c+=1;
						}
					echo"</tr>    
    			</table>"; 
			}
	  		?>
		</form>
	</body>
</html>