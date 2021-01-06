<?php //V 1000 12/12/16 ?> 
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
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gesti&oacute;n Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden") {document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function despliegamodal2(_valor,_num,_funci)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '1':	document.getElementById('ventana2').src="cargafuncionarios-ventana01.php?objeto=funcionarios01";break;
						case '2':	document.getElementById('ventana2').src="cargafuncionarios-ventana01.php?objeto="+_funci;break;
					}
				}
			}
			
		</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("hum");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><img src="imagenes/add.png" class="mgbt1"  title="Nuevo" onClick="location.href='hum-prepararnomina.php'"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-prepararnominabuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
        	</tr>
        </table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="">
        	<?php
				if ($_POST[oculto] =="")
				{
					$_POST[idcomp]=$_GET[idpre];
					$sql="SELECT fecha,mes,vigencia FROM hum_prenomina WHERE codigo='$_GET[idpre]'";
					$res = mysql_query($sql,$linkbd);
					$row =mysql_fetch_row($res);
					$_POST[fecha]=date('d/m/Y',strtotime($row[0]));
					$_POST[periodo]=$row[1];
					$_POST[vigencia]=$row[2];
					$_POST[tiponum]=$_POST[tiponom]=$_POST[funcionarios01]="";
					$sqlr="SELECT 1 FROM hum_prenomina_det WHERE codigo='$_POST[idcomp]' LIMIT 1";
					$res = mysql_query($sqlr,$linkbd);
					if (mysql_num_rows($res) > 0) 
					{
						$_POST[tiponum]='01';
						$_POST[tiponom]="01 - ".buscavariblespagonomina('01');
						$_POST[tpcheck]='01';
					}
					$sql="SELECT DISTINCT codpag FROM hum_otrospagos WHERE codpre='$_GET[idpre]' ORDER BY codpag"; 
					$res = mysql_query($sql,$linkbd);
					while ($row =mysql_fetch_row($res))
					{
						if($_POST[tiponum]=='')
						{
							$_POST[tiponum]=(string)$row[0];
							$_POST[tiponom]="$row[0] - ".buscavariblespagonomina($row[0]);
							$_POST[tpcheck]=(string)$row[0];
						}
						else
						{
							$_POST[tiponum]=$_POST[tiponum]."<->".(string)$row[0];
							$_POST[tiponom]=$_POST[tiponom]."<->"."$row[0] - ".buscavariblespagonomina($row[0]);
						}
					}
					$_POST[tipoacti]="N";
					$_POST[datodel01]=$_POST[datodel02]=$_POST[datodel03]=$_POST[datodel04]="";
					//carga parametros admfiscales
					$sqlr="SELECT transporte,alimentacion,balimentacion,btransporte,anauxalim,anauxtrans FROM admfiscales WHERE vigencia='$_POST[vigencia]'";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[transp]=$row[0];
					$_POST[alim]=$row[1];
					$_POST[balim]=$row[2];
					$_POST[btrans]=$row[3];
					$_POST[anauxalim]=$row[4];
					$_POST[anauxtrans]=$row[5];
				}
				$vtiponum=array();
				$vtiponom=array();
				$vtiponum = explode('<->', $_POST[tiponum]);
				$vtiponom= explode('<->', $_POST[tiponom]);
				if($_POST[datodel01]!="")
				{
					switch($_POST[datodel01])
					{
						case 1:	if($_POST[datodel03]==1){$_POST[funcionarios01]="";}
								else
								{
									if($_POST[datodel04]==0){$idbusca=":".$_POST[datodel02].':<->';$_POST[funcionarios01]=str_replace($idbusca,"",$_POST[funcionarios01]);}
									else {$idbusca='<->:'.$_POST[datodel02].":";$_POST[funcionarios01]=str_replace($idbusca,"",$_POST[funcionarios01]);}
								}break;
						case 2:	if($_POST[datodel03]==1){$_POST[funcionarios02]="";}
								else
								{
									if($_POST[datodel04]==0){$idbusca=":".$_POST[datodel02].':<->';$_POST[funcionarios02]=str_replace($idbusca,"",$_POST[funcionarios02]);}
									else {$idbusca='<->:'.$_POST[datodel02].":";$_POST[funcionarios02]=str_replace($idbusca,"",$_POST[funcionarios02]);}
								}break;
					}
					$_POST[datodel01]=$_POST[datodel02]=$_POST[datodel03]=$_POST[datodel04]="";
				}
			?>
			<!-- Variables parametros admfiscales --> 
			<input type="hidden" id="balim" name="balim"  value="<?php echo $_POST[balim];?>"/>
			<input type="hidden" id="alim" name="alim" value="<?php echo $_POST[alim];?>"/>
			<input type="hidden" id="btrans" name="btrans" value="<?php echo $_POST[btrans];?>"/>
			<input type="hidden" id="transp" name="transp"  value="<?php echo $_POST[transp];?>"/>
            <input type="hidden" id="anauxalim" name="anauxalim"  value="<?php echo $_POST[anauxalim];?>"/>
            <input type="hidden" id="anauxtrans" name="anauxtrans"  value="<?php echo $_POST[anauxtrans];?>"/>
            
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="8">.: Preparar Preliquidaci&oacute;n</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
      			</tr>
                <tr>
                	<td class="saludo1" style="width:3cm;">No Preliquidaci&oacute;n:</td>
                    <td style="width:10%;"><input type="text" id="idcomp" name="idcomp" value="<?php echo $_POST[idcomp]?>" style="width:95%;" readonly></td>
                   	<td class="saludo1" style="width:2.5cm;">Fecha:</td>
                    <td style="width:15%;"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" style="width:80%;" readonly></td>
                    <td class="saludo1" style="width:2.5cm;">Vigencia:</td> 
                    <td style="width:10%;"><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" style="width:80%;" readonly></td>
                    <td class="saludo1" style="width:2.5cm;">Mes:</td>
          			<td>
                    	<select name="periodo" id="periodo" >
							<?php
					 			$sqlr="Select * from meses where estado='S' ";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[periodo])
			 						{
				 						echo "<option value='$row[0]' SELECTED>$row[1]</option>";
				 						$_POST[periodonom]=$row[1];
				 						$_POST[periodonom]=$row[2];
				 					}
			     				}   
							?>
		  				</select>
                 	</td>
	    		</tr>
    		</table>
            <input type="hidden" name="oculto" id="oculto" value="0"/>
            <input type="hidden" name="tiponum" id="tiponum" value="<?php echo $_POST[tiponum];?>"/>
            <input type="hidden" name="tiponom" id="tiponom" value="<?php echo $_POST[tiponom];?>"/>
            <input type="hidden" name="tipoacti" id="tipoacti" value="<?php echo $_POST[tipoacti];?>"/>
            <input type="hidden" name="tpcheck" id="tpcheck" value="<?php echo $_POST[tpcheck];?>"/>
            <input type='hidden' name='datodel01' id="datodel01" value="<?php echo $_POST[datodel01];?>"/>
            <input type='hidden' name='datodel02' id="datodel02" value="<?php echo $_POST[datodel02];?>"/>
            <input type='hidden' name='datodel03' id="datodel03" value="<?php echo $_POST[datodel03];?>"/>
            <input type='hidden' name='datodel04' id="datodel04" value="<?php echo $_POST[datodel04];?>"/>
           
            <div class="tabscontra" style="height:60%; width:99.6%;"> 
            	<?php 
					for($xtipos=0;$xtipos<count($vtiponum);$xtipos++)
					{ 
						if ($vtiponum[$xtipos]=="01")
						{	
							$_POST[tipoacti]='S';
							if(($_POST[tpcheck]==$vtiponum[$xtipos])){$vcheck='checked';}
							else {$vcheck='';}
							$nomtitulo=explode(' - ', $vtiponom[$xtipos]);
							$vtab="tab-$vtiponum[$xtipos]";
							$nomv="funcionarios".$vtiponum[$xtipos];
							echo"
							<input type='hidden' name='$nomv' id='$nomv' value='$_POST[$nomv]'/>
							<script>document.form2.tipoacti.value='S'</script>
							<div class='tab'>
								<input type='radio' id='$vtab' name='tabgroup1' value='1' $vcheck  onClick=\"cambiopes('$vtiponum[$xtipos]');\"/>
								<label for='$vtab'>$nomtitulo[1]</label>
								<div class='content' style='overflow:hidden'>
									<table class='inicio' >
										<tr>
											<td class='titulos' colspan='2'>.: SUELDO PERSONAL DE NOMINA</td>
											
										</tr>
									</table>
									<div class='subpantalla1' style='height:90%; width:99.6%;overflow-x:hidden'>
										<table class='inicio' align='center'>
											<tr style='text-align:center;'>
												<td class='titulos2' style='width:3%'>ID</td>
												<td class='titulos2' style='width:6%'>DOCUMENTO</td>
												<td class='titulos2' >NOMBRE</td>
												<td class='titulos2'>CARGO</td>
												<td class='titulos2' style='width:18%'>CENTRO DE COSTO</td>
												<td class='titulos2' style='width:6%'>PERIDO</td>
												<td class='titulos2' style='width:7%'>SALARIO BASICO</td>
												<td class='titulos2' style='width:3%'>DIAS</td>
												<td class='titulos2' style='width:3%'>DIAS INC</td>
												<td class='titulos2' style='width:3%'>DIAS VAC</td>
												<td class='titulos2' style='width:7%'>DEVENGADO</td>
												<td class='titulos2' style='width:5%'>PAGO SALARIO</td>
												<td class='titulos2' style='width:5%'>PAGO SALUD</td>
												<td class='titulos2' style='width:5%'>PAGO PENSION</td>
												<td class='titulos2' style='width:5%'>PAGO ARL</td>
												<td class='titulos2' style='width:5%'>PAGO PARAFIS.</td>
												<td class='titulos2' style='width:5%'>RETIRO</td>
											</tr>";
							$iter='saludo1b';
							$iter2='saludo2b';
							$sqlf="SELECT codigofun,documefun,nombrefun,cargofun,ccfun,perliq,salarifun,diast,diasi,diasv,devengado,psal,peps, ppen,parl,ppar,retiro FROM hum_prenomina_det WHERE codigo='$_POST[idcomp]'";
							$resf = mysql_query($sqlf,$linkbd);
							while ($rowf =mysql_fetch_row($resf))
							{
								$nomcargo=cargofuncionarioid($rowf[3]);
								$nombrecc=nombrecentrocosto($rowf[4]);
								$nombrefun=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$rowf[2]);
								if($rowf[5]==30){$verper="MENSUAL";}							
								else {$verper="QUINCENAL";}
								if($rowf[11]=='S'){$imgsema="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
								else{$imgsema="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
								if($rowf[12]=='S'){$imgsemb="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
								else{$imgsemb="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
								if($rowf[13]=='S'){$imgsemc="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
								else{$imgsemc="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
								if($rowf[14]=='S'){$imgsemd="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
								else{$imgsemd="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
								if($rowf[15]=='S'){$imgseme="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
								else{$imgseme="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
								if($rowf[16]=='S'){$imgsemf="src='imagenes/sema_verdeON.jpg' title=' Paga días asignados'";}
								else{$imgsemf="src='imagenes/sema_rojoON.jpg' title='Paga los 30 días'";}
								echo "
										<tr class='$iter' style='text-transform:uppercase'>
											<td class='icoop2' style='text-align:right;'>$rowf[0]&nbsp;</td>
											<td class='icoop2' style='text-align:right;'>".number_format($rowf[1],0)."&nbsp;</td>
											<td class='icoop2'>$nombrefun</td>
											<td class='icoop2'>$nomcargo</td>
											<td class='icoop2'>$rowf[4] - $nombrecc</td>
											<td class='icoop2'>$verper</td>
											<td class='icoop2' style='text-align:right;'>$ ".number_format($rowf[6],0)."&nbsp;</td>
											<td class='icoop2' style='text-align:right;'>$rowf[7]</td>
											<td class='icoop2' style='text-align:right;'>$rowf[8]</td>
											<td class='icoop2' style='text-align:right;'>$rowf[9]</td>
											<td class='icoop2' style='text-align:right;'>$ ".number_format($rowf[10],0)."&nbsp;</td>
											<td style='text-align:center;'><img class='icoop' $imgsema onClick=\"cambiosema('psal01','$x');\"/></td>
											<td style='text-align:center;'><img class='icoop' $imgsemb onClick=\"cambiosema('peps01','$x');\"/></td>
											<td style='text-align:center;'><img class='icoop' $imgsemc onClick=\"cambiosema('ppen01','$x');\"/></td>
											<td style='text-align:center;'><img class='icoop' $imgsemd onClick=\"cambiosema('parl01','$x');\"/></td>
											<td style='text-align:center;'><img class='icoop' $imgseme onClick=\"cambiosema('ppar01','$x');\"/></td>
											<td style='text-align:center;'><img class='icoop' $imgsemf onClick=\"cambiosema('retiro01','$x');\"/></td>
										</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}
									echo"
										</table>
									</div>
								</div>
							</div>
							";
						}
						if ($vtiponum[$xtipos]!="01" && $vtiponum[$xtipos]!="")
						{
							$_POST[tipoacti]='S';
							if($_POST[tpcheck]==$vtiponum[$xtipos]){$vcheck='checked';}
							else {$vcheck='';}
							$nomtitulo=explode(' - ', $vtiponom[$xtipos]);
							$vtab="tab-$vtiponum[$xtipos]";
							$sqlft="SELECT DISTINCT codpag FROM hum_otrospagos WHERE codpre='$_POST[idcomp]' ORDER BY codpag";
							$resft = mysql_query($sqlft,$linkbd);
							//while ($rowft =mysql_fetch_row($resft))
							{
								echo"
								<input type='hidden' name='$nomv' id='$nomv' value='$_POST[$nomv]'/>
								<script>document.form2.tipoacti.value='S'</script>
								<div class='tab'>
									<input type='radio' id='$vtab' name='tabgroup1' value='2' $vcheck  onClick=\"cambiopes('$vtiponum[$xtipos]');\"/>
									<label for='$vtab'>$nomtitulo[1]</label>
									<div class='content' style='overflow:hidden'>
										<table class='inicio'>
											<tr>
												<td class='titulos' colspan='2'>.: $nomtitulo[1]</td>
											</tr>
										</table>
										<div class='subpantalla1' style='height:90%; width:99.6%;overflow-x:hidden'>
											<table class='inicio' align='center'>
												<tr style='text-align:center;'>
													<td class='titulos2' style='width:3%'>ID</td>
													<td class='titulos2' style='width:6%'>DOCUMENTO</td>
													<td class='titulos2' >NOMBRE</td>
													<td class='titulos2'>CARGO</td>
													<td class='titulos2' style='width:18%'>CENTRO DE COSTO</td>
													<td class='titulos2' style='width:7%'>VALOR BASICO</td>
													<td class='titulos2' style='width:5%'>HORAS O DIAS</td>
													<td class='titulos2' style='width:7%'>VALOR ASIGNADO</td>
													<td class='titulos2' style='width:5%'>PAGO </td>
													<td class='titulos2' style='width:5%'>PAGO SALUD</td>
													<td class='titulos2' style='width:5%'>PAGO PENSION</td>
													<td class='titulos2' style='width:5%'>PAGO ARL</td>
													<td class='titulos2' style='width:5%'>PAGO PARAFIS.</td>
												</tr>";
								$sqlf="SELECT codigofun,documefun,nombrefun,ccfun,salarifun,horasdias,valpago,psal,peps,ppen,parl,ppar FROM hum_otrospagos WHERE codpre='$_POST[idcomp]' AND codpag='$vtiponum[$xtipos]' ORDER BY codigofun";
								$resf = mysql_query($sqlf,$linkbd);
								while ($rowf =mysql_fetch_row($resf))
								{
									$sqlcf="SELECT cargofun FROM hum_prenomina_det WHERE codigo='$_POST[idcomp]' AND codigofun='$rowf[0]'";
									$rescf = mysql_query($sqlcf,$linkbd);
									$rowcf =mysql_fetch_row($rescf);
									if($rowcf[0]!=''){$nomcargo=cargofuncionarioid($rowcf[0]);}
									else{$nomcargo=cargofuncionario($rowf[0]);}
									$nombrecc=nombrecentrocosto($rowf[3]);
									if($rowf[7]=='S'){$imgsema="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsema="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($rowf[8]=='S'){$imgsemb="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsemb="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($rowf[9]=='S'){$imgsemc="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsemc="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($rowf[10]=='S'){$imgsemd="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgsemd="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									if($rowf[11]=='S'){$imgseme="src='imagenes/sema_verdeON.jpg' title=' Si Pagar'";}
									else{$imgseme="src='imagenes/sema_rojoON.jpg' title='No Pagar'";}
									echo "	
											<tr class='$iter' style='text-transform:uppercase'>
												<td>$rowf[0]</td>
												<td>$rowf[1]</td>
												<td>$rowf[2]</td>
												<td>$nomcargo</td>
												<td>$nombrecc</td>
												<td style='text-align:right;'>$ ".number_format($rowf[4],0)."</td>
												<td style='text-align:right;'>$rowf[5]</td>
												<td style='text-align:right;'>$ ".number_format($rowf[6])."</td>
												<td style='text-align:center;'><img class='icoop' $imgsema/></td>
												<td style='text-align:center;'><img class='icoop' $imgsemb/></td>
												<td style='text-align:center;'><img class='icoop' $imgsemc/></td>
												<td style='text-align:center;'><img class='icoop' $imgsemd/></td>
												<td style='text-align:center;'><img class='icoop' $imgseme/></td>
											</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								}	
								echo"
											</table>
										</div>
									</div>
								</div>
								";
							}
						}
					}
            	?>
            </div>
		</form>
        <div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
        	</div>
		</div>
	</body>
</html>