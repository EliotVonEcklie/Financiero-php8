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
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/funciones.js"></script>
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
                    <td class="titulos" colspan="3">Metas Ejecutadas</td>  
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
                	<td class="saludo1">Informe</td>
  					<td>
                        <?php
                        $sqlr="SELECT * FROM plannivelespd WHERE inicial='$_POST[vigenciai]' AND final='$_POST[vigenciaf]' AND nombre='INDICADORES' ORDER BY orden";
                        $res=mysql_query($sqlr,$linkbd);
                        $row =mysql_fetch_row($res);
						$_POST[orden]=$row[1];
						$_POST[tipo]=$row[2];
						$_POST[nomtipo]=$row[2];
                        ?>
						<input type="text" id="informe" name="informe" value="VALOR EJECUTADO VS VALOR PLANIFICADO" style="width: 100%" readonly>
						<input type="hidden" id="tipo" name="tipo" value="<?php echo $_POST[tipo] ?>" >
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
						$sqln="SELECT nombre FROM plannivelespd WHERE orden='$i' AND inicial='$_POST[vigenciai]' AND final='$_POST[vigenciaf]' ";
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
											$_POST[nmeta]=$row[0];
											echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										}
										else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	 
									}	
								echo"</select>
								<input type='hidden' name='arrpad[$i]' value='".$_POST[arrpad][$i]."' >
								<input type='hidden' name='arrnpad[$i]' value='".$_POST[arrnpad][$i]."' >
								<input type='hidden' name='nmeta' value='".$_POST[nmeta]."' >";
								

							echo"</td>
						</tr>";
					}
					$_POST[padre]=$_POST[arrpad][($i-1)];
				}
       			?>   
    		</table>
			<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]?>">
            <input type="hidden" name="valcod" id="valcod" value="0"/>
			<div class="container" style="background-color: white !important;height:50%; overflow-y:scroll; overflow-x:hidden">
   			<table >
			<tr class="titulos">
			<td style="width: 5%" rowspan="2"><img src='imagenes/plus.gif'></td>
			<td colspan="2" rowspan="2" style="width: 35%">Meta</td>
			<?php
			 $conta=0;
			for($i=$_POST[vigenciai]; $i<=$_POST[vigenciaf]; $i++){
				echo "<td  style='width: 15%' colspan='2' >$i</td>";
				$conta++;
			}
			
			?>

			</tr>
			<tr class="titulos">
			
			<?php
			for($i=0; $i<$conta; $i++){
				echo "<td >Ejecutado</td><td >Planificado</td>";
			}
			
			?>
			
			</tr>
			<?php
			$sql="SELECT PD1.codigo,PD1.nombre  FROM presuplandesarrollo AS PD1 WHERE PD1.vigencia BETWEEN '$_POST[vigenciai]' AND '$_POST[vigenciaf]' AND (LENGTH(PD1.codigo)-LENGTH(REPLACE(PD1.codigo, '.', '')))=(SELECT MAX(LENGTH(PD2.codigo)-LENGTH(REPLACE(PD2.codigo, '.', ''))) FROM presuplandesarrollo AS PD2)  AND PD1.codigo LIKE '$_POST[nmeta]%' ";
			$res=mysql_query($sql,$linkbd);
			$zebra1="zebra1";
			$zebra2="zebra2";
			$np=1;
			while($row = mysql_fetch_row($res)){
				$meta=$row[0];
				$vigenciai=$_POST[vigenciai];
				$vigenciaf=$_POST[vigenciaf];
				echo "<tr class='$zebra1'>";
				echo "<td>
				<a onClick=\"verDetalleFuentesCompara($np, '$meta','$vigenciai','$vigenciaf')\" style='cursor:pointer;'>
				<img id='img".$np."' src='imagenes/plus.gif'>
				</a></td>";
				echo "<td>$row[0]</td>";
				echo "<td>$row[1]</td>";
				for($i=$_POST[vigenciai]; $i<=$_POST[vigenciaf]; $i++){
				$sql1="SELECT IF(SUM(TB4.valortotal) IS NULL,0,SUM(TB4.valortotal)) FROM presucdpplandesarrollo AS TB1,pptorp AS TB2,tesoordenpago AS TB3,tesoegresos AS TB4,pptocdp AS TB5 WHERE TB1.codigo_meta='$row[0]' AND TB1.id_cdp=TB5.consvigencia AND  TB5.tipo_mov='201' AND TB1.vigencia='$i'  AND TB2.idcdp=TB1.id_cdp AND TB2.tipo_mov='201' AND TB2.vigencia='$i' AND TB3.id_rp=TB2.consvigencia AND TB3.tipo_mov='201' AND TB3.vigencia='$i'  AND TB4.id_orden=TB3.id_orden AND TB4.vigencia='$i' AND NOT EXISTS (SELECT 1 FROM tesoegresos AS TEGRE WHERE TEGRE.tipo_mov='401' AND TEGRE.id_orden=TB3.id_orden) ";
				$resul=mysql_query($sql1,$linkbd);
				$sumaeje=mysql_fetch_row($resul);
				$sql1="SELECT SUM(valor) FROM planfuentes WHERE meta='$row[0]' AND vigencia='$i'  ";
				$resul=mysql_query($sql1,$linkbd);
				$sumaplani=mysql_fetch_row($resul);
				echo "<td>$ ".number_format($sumaeje[0],2,',','.')."</td>";
				echo "<td>$ ".number_format($sumaplani[0],2,',','.')."</td>";
				}
				echo "</tr>
					<tr>
						<td colspan='11' align='right'>
							<div id='detalle".$np."' style='display:none;padding-left: 0%'></div>
						</td>
					</tr>";
				$aux=$zebra1;
				$zebra1=$zebra2;
				$zebra2=$aux;
				$np+=1;
			}
			?>
		
			</table>
			</div>
		</form>
	</body>
</html>