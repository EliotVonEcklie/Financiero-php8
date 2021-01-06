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
        <title>:: Spid - Meci Calidad</title>
        <script>
			function busquedajs(tipo)
			{
				switch(tipo)
                {
                    case "1":
						if (document.form2.responsablet1.value!=""){document.form2.busquedas.value=tipo;document.form2.submit();}
						break;
					 case "2":
						if (document.form2.responsablet2.value!=""){document.form2.busquedas.value=tipo;document.form2.submit();}
						break;
					 case "3":
						if (document.form2.responsablet3.value!=""){document.form2.busquedas.value=tipo;document.form2.submit();}
						break;
				}
			}
			function despliegamodal2(_valor,tipo)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else{document.getElementById('ventana2').src="meci-insparticipacionresponsables.php?tipo="+tipo;}
			}
			function despliegamodalm(_valor,_tip,mensa)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
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
					}
				}
			}
			function guardar()
			{
				var pesact=document.form2.tabgroup1.value; var varver='N'; var nomgua='';
				switch(pesact)
                {
                    case "1":
						if(document.getElementById('responsablet1').value!="" && document.getElementById('nresponsablet1').value!="" && document.getElementById('cargo1').value!="" && document.getElementById('fechai1').value!="" && document.getElementById('fechar1').value!="")
							{varver='S';nomgua='Esta Seguro de Modificar la Informaci\xf3n del Representante del Comit\xe9 Coordinador CI';}
                        break;
                    case "2":
						if(document.getElementById('responsablet2').value!="" && document.getElementById('nresponsablet2').value!="" && document.getElementById('cargo2').value!="" && document.getElementById('fechai2').value!="" && document.getElementById('fechar2').value!="")
							{varver='S';nomgua='Esta Seguro de Modificar la Informaci\xf3n del Representante de la Alta Direcci\xf3n';}
                        break;
                    case "3":
						if(document.getElementById('responsablet3').value!="" && document.getElementById('nresponsablet3').value!="" && document.getElementById('cargo3').value!="" && document.getElementById('fechai3').value!="" && document.getElementById('fechar3').value!="")
							{varver='S';nomgua='Esta Seguro de Modificar la Informaci\xf3n del Representante del Equipo Meci'}
                        break;
                    case "4":
						if(document.getElementById('protocolo').value!="" && document.getElementById('nomarch').value!="" && document.getElementById('desmar').value!="" && document.getElementById('fecmls').value!="")
							{varver='S'; nomgua='Esta Seguro de Modificar la Informaci\xf3n del Protocolo Etico'}
                        break;
                }
				if(varver=='S'){if (confirm(nomgua)){document.form2.oculto.value="1";document.form2.submit();}}
				else{despliegamodalm('visible','2','Falta informaci\xf3n para poder Guardar');}
			}

			function iratras(){
                
                location.href="meci-insparticipacionbusca.php";
            }
		</script>
		<script type="text/javascript" src="css/programas.js"></script>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<?php 
			titlepag();
			function eliminarDir()
			{
				$carpeta="informacion/protocolos_eticos/temp";
				foreach(glob($carpeta . "/*") as $archivos_carpeta)
				{
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta);
			}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("meci");?></tr>
          	<tr>
          		<td colspan="3" class="cinta"><a href="meci-insparticipacion.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="meci-insparticipacionbusca.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" class="mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
        	</tr>
		</table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" enctype="multipart/form-data"> 
			<?php
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
                $linkbd=conectar_bd(); 
				//*****************************************************************
 				if($_POST[oculto]=="")
                {
					$_POST[oculid]=$_GET[id];
					$_POST[oculcl]=$_GET[clase];
					$_POST[busquedas]="";
					$_POST[oculto]="0";
					switch($_POST[oculcl])
                	{
                   		case 'CCI':
							$_POST[tabgroup1]=1;
							$_POST[bloqueo1]="";
							$_POST[bloqueo2]="disabled";
							$_POST[bloqueo3]="disabled";
							$_POST[bloqueo4]="disabled";
							$sql1="SELECT * FROM mecinsparticipacion WHERE id='".$_POST[oculid]."'";
							$row1=mysql_fetch_row(mysql_query($sql1,$linkbd));
							$_POST[responsablet1]=$row1[2];
							$_POST[nresponsablet1]=buscaresponsable($row1[2]);
							$_POST[cargo1]=$row1[3];
							$_POST[fechai1]=$row1[4];
							$_POST[fechar1]=$row1[5];
							break;
						case 'RAD':
							$_POST[tabgroup1]=2;
							$_POST[bloqueo1]="disabled";
							$_POST[bloqueo2]="";
							$_POST[bloqueo3]="disabled";
							$_POST[bloqueo4]="disabled";
							$sql2="SELECT * FROM mecinsparticipacion WHERE id='".$_POST[oculid]."'";
							$row2=mysql_fetch_row(mysql_query($sql2,$linkbd));
							$_POST[responsablet2]=$row2[2];
							$_POST[nresponsablet2]=buscaresponsable($row2[2]);
							$_POST[cargo2]=$row2[3];
							$_POST[fechai2]=$row2[4];
							$_POST[fechar2]=$row2[5];
							break;
						case 'REM':
							$_POST[tabgroup1]=3;
							$_POST[bloqueo1]="disabled";
							$_POST[bloqueo2]="disabled";
							$_POST[bloqueo3]="";
							$_POST[bloqueo4]="disabled";
							$sql3="SELECT * FROM mecinsparticipacion WHERE id='".$_POST[oculid]."'";
							$row3=mysql_fetch_row(mysql_query($sql3,$linkbd));
							$_POST[responsablet3]=$row3[2];
							$_POST[nresponsablet3]=buscaresponsable($row3[2]);
							$_POST[cargo3]=$row3[3];
							$_POST[fechai3]=$row3[4];
							$_POST[fechar3]=$row3[5];
							break;
						case 'CPE':
							$_POST[tabgroup1]=4;
							$_POST[bloqueo1]="disabled";
							$_POST[bloqueo2]="disabled";
							$_POST[bloqueo3]="disabled";
							$_POST[bloqueo4]="";
							$rutaad="informacion/protocolos_eticos/temp/";
							if(!file_exists($rutaad)){mkdir ($rutaad);}
							else {eliminarDir();mkdir ($rutaad);}
							$sql4="SELECT * FROM meciprotocoloseticos WHERE id='".$_POST[oculid]."'";
							$row4=mysql_fetch_row(mysql_query($sql4,$linkbd));
							$_POST[protocolo]=$row4[1];
							$_POST[nomarch]=$row4[4];
							$_POST[desmar]=$row4[3];
							$_POST[fecmls]=$row4[2];
							$_POST[banarc]="0";
					}
                }
				//*****************************************************************
                switch($_POST[tabgroup1])
                {
                    case 1:
                        $check1='checked';break;
                    case 2:
                        $check2='checked';break;
                    case 3:
                        $check3='checked';break;
                    case 4:
                        $check4='checked';break;
                }				
				//*****************************************************************
				if ($_POST[busquedas]!="")
				{
					 switch($_POST[busquedas])
					{
						case 1:
							$nresul=buscaresponsable($_POST[responsablet1]);
							if($nresul!=''){$_POST[nresponsablet1]=$nresul;}
							else
							{
								$_POST[nresponsablet1]="";
								?><script>
									despliegamodalm('visible','2','No existe o est\xe1 vinculado un funcionario con este documento');	
                               	</script><?php 
							}
							break;
						case 2:
							$nresul=buscaresponsable($_POST[responsablet2]);
							if($nresul!=''){$_POST[nresponsablet2]=$nresul;}
							else
							{
								$_POST[nresponsablet2]="";
								?><script>
									despliegamodalm('visible','2','No existe o est\xe1 vinculado un funcionario con este documento');	
                               	</script><?php 
							}
							break;
						case 3:
							$nresul=buscaresponsable($_POST[responsablet3]);
							if($nresul!=''){$_POST[nresponsablet3]=$nresul;}
							else
							{
								$_POST[nresponsablet3]="";
								?><script>
									despliegamodalm('visible','2','No existe o est\xe1 vinculado un funcionario con este documento');	
                               	</script><?php 
							}
							break;
					}
					$_POST[busquedas]="";	
				}
            ?>
            <input type="hidden" name="banmlg" id="banmlg" value="<?php echo $_POST[banmlg];?>" >
            <div class="tabsmeci"  style="height:76.5%; width:99.6%">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> <?php echo $_POST[bloqueo1];?>>
                    <label for="tab-1">Comit&eacute; Coordinador CI</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="7" style="width:93%">Comit&eacute; Coordinador CI</td>
                                <td class="cerrar" style="width:7%"><a href="meci-principal.php">Cerrar</a></td>
                            </tr>
							<tr>
                            	<td class="saludo1" style="width:10%">Responsable:</td>
                         		<td style="width:10%">
                            		<input type="text" name="responsablet1" id="responsablet1" style="width:100%" onKeyPress="return solonumeros(event);"  onBlur="busquedajs('1');" value="<?php echo $_POST[responsablet1]?>" >
                            	</td>                               	
            					<td style="width:30%" colspan="3">
									<input type="text" name="nresponsablet1" id="nresponsablet1" value="<?php echo $_POST[nresponsablet1]?>" style=" width:88.5% " readonly>
                                    <a href="#" onClick="despliegamodal2('visible','1');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
								</td>
                                <td class="saludo1" style="width:6%;">Cargo:</td>
                                <td>
                                	<select name="cargo1" id="cargo1" style="width:30%;" onChange="document.form2.submit();">
                        				<option value="" <?php if($_POST[cargo1]=='') {echo "SELECTED";}?>>...</option>
										<?php
                                            $linkbd=conectar_bd();
                                            $sqlr="SELECT * FROM mecivariables WHERE clase='CCC' AND estado='S' ORDER BY id ASC";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                echo "<option value=$row[0] ";
                                                $i=$row[0];
                                                if($i==$_POST[cargo1]){echo "SELECTED"; $_POST[cargo1]=$row[0];}
                                                echo ">".$row[1]." </option>";
                                            }	 	
                                        ?>
                       				</select>
                                </td>
                        	</tr>
                            <tr>        
                                <td class="saludo1" style="width:10%">Fecha Inicial:</td>
                                <td><input type="date" name="fechai1" id="fechai1" value="<?php echo $_POST[fechai1]?>"></td>
                                <td class="saludo1" style="width:10%">Fecha Retiro:</td>
                                 <td><input type="date" name="fechar1" id="fechar1" value="<?php echo $_POST[fechar1]?>"></td>
                            </tr>
                        </table>
                    </div>
                </div> 
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> <?php echo $_POST[bloqueo2];?>>
                    <label for="tab-2">Representante Alta Direcci&oacute;n</label>
                    <div class="content" style="overflow:hidden;">
                       <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="7" style="width:93%">Representante Alta Direcci&oacute;n</td>
                                <td class="cerrar" style="width:7%"><a href="meci-principal.php">Cerrar</a></td>
                            </tr>
							<tr>
                            	<td class="saludo1" style="width:10%">Responsable:</td>
                         		<td style="width:10%">
                            		<input type="text" name="responsablet2" id="responsablet12" style="width:100%" onKeyPress="return solonumeros(event);"  onBlur="busquedajs('2');" value="<?php echo $_POST[responsablet2]?>" >
                            	</td>                               	
            					<td style="width:30%" colspan="3">
									<input type="text" name="nresponsablet2" id="nresponsablet2" value="<?php echo $_POST[nresponsablet2]?>" style=" width:88.5% " readonly>
                                    <a href="#" onClick="despliegamodal2('visible','2');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
								</td>
                                <td class="saludo1" style="width:6%;">Cargo:</td>
                                <td>
                                	<select name="cargo2" id="cargo2" style="width:30%;" onChange="document.form2.submit();">
                        				<option value="" <?php if($_POST[cargo2]=='') {echo "SELECTED";}?>>...</option>
										<?php
                                            $linkbd=conectar_bd();
                                            $sqlr="SELECT * FROM mecivariables WHERE clase='CAD' AND estado='S' ORDER BY id ASC";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                echo "<option value=$row[0] ";
                                                $i=$row[0];
                                                if($i==$_POST[cargo2]){echo "SELECTED";$_POST[cargo2]=$row[0];}
                                                echo ">".$row[1]." </option>";
                                            }	 	
                                        ?>
                       				</select>
                                </td>
                        	</tr>
                            <tr>        
                                <td class="saludo1" style="width:10%">Fecha Inicial:</td>
                                <td><input type="date" name="fechai2" id="fechai2" value="<?php echo $_POST[fechai2]?>"></td>
                                <td class="saludo1" style="width:10%">Fecha Retiro:</td>
                                <td><input type="date" name="fechar2" id="fechar2" value="<?php echo $_POST[fechar2]?>"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> <?php echo $_POST[bloqueo3];?>>
                    <label for="tab-3">Equipo MECI</label>
                    <div class="content" style="overflow:hidden;">
                     	<table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="8" style="width:93%">Equipo MECI</td>
                                <td class="cerrar" style="width:7%"><a href="meci-principal.php">Cerrar</a></td>
                            </tr>
							<tr>
                            	<td class="saludo1" style="width:10%">Responsable:</td>
                         		<td style="width:10%">
                            		<input type="text" name="responsablet3" id="responsablet13" style="width:100%" onKeyPress="return solonumeros(event);"  onBlur="busquedajs('3');" value="<?php echo $_POST[responsablet3]?>" >
                            	</td>                               	
            					<td style="width:30%" colspan="3">
									<input type="text" name="nresponsablet3" id="nresponsablet3" value="<?php echo $_POST[nresponsablet3]?>" style=" width:88.5% " readonly>
                                    <a href="#" onClick="despliegamodal2('visible','3');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
								</td>
                                <td class="saludo1" style="width:6%;">Cargo:</td>
                                <td>
                                	<select name="cargo3" id="cargo3" style="width:30%;" onChange="document.form2.submit();">
                        				<option value="" <?php if($_POST[cargo3]=='') {echo "SELECTED";}?>>...</option>
										<?php
                                            $linkbd=conectar_bd();
                                            $sqlr="SELECT * FROM mecivariables WHERE clase='CEM' AND estado='S' ORDER BY id ASC";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                echo "<option value=$row[0] ";
                                                $i=$row[0];
                                                if($i==$_POST[cargo3]){echo "SELECTED";$_POST[cargo3]=$row[0];}
                                                echo ">".$row[1]." </option>";
                                            }	 	
                                        ?>
                       				</select>
                                </td>
                        	</tr>
                            <tr>        
                                <td class="saludo1" style="width:10%">Fecha Inicial:</td>
                                <td><input type="date" name="fechai3" id="fechai3" value="<?php echo $_POST[fechai3]?>"></td>
                                <td class="saludo1" style="width:10%">Fecha Retiro:</td>
                                 <td><input type="date" name="fechar3" id="fechar3" value="<?php echo $_POST[fechar3]?>"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> <?php echo $_POST[bloqueo4];?>>
                    <label for="tab-4">Protocolos Eticos</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="6">Protocolos Eticos</td>
                                 <td class="cerrar" ><a href="meci-principal.php">Cerrar</a></td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:10%;">Clase Protocolo:</td>
                                <td style="width:15%;">
                                	<select name="protocolo" id="protocolo" style="width:100%;" >
                                    	<option value="" <?php if($_POST[protocolo]=='') {echo "SELECTED";}?>>....</option>
                                    	<?php
                                            $sqlr="SELECT * FROM mecivariables WHERE clase='CPE' ORDER BY id ASC";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                echo "<option value=$row[0] ";
                                                $i=$row[0];
                                                if($i==$_POST[protocolo]){echo "SELECTED"; $_POST[protocolo]=$row[0];}
                                                echo ">".$row[1]." </option>";
                                            }	 	
                                        ?>
                                    </select>
                                </td>
                                <td class="saludo1" style="width:12%;">Documento Adjunto:</td>
                                <td ><input type="text" name="nomarch" id="nomarch"  style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
                                <td>
                                    <div class='upload'> 
                                        <input type="file" name="plantillaad" onChange="document.form2.submit();" />
                                        <img src='imagenes/attach.png'  title='Cargar Documento'  /> 
                                    </div> 
                                </td>
                            </tr>
                            <tr>
                                <td class="saludo1">Descripci&oacute;:</td>
                                <td colspan="3" style="width:72%">
                					<input type="text" name="desmar" id="desmar" value="<?php echo $_POST[desmar];?>" style="width:100%">
                                </td>
                            </tr>
                             <tr>
                                <td class="saludo1" style="width:5%;">Fecha:</td>
                                <td><input type="date" name="fecmls" id="fecmls" value="<?php echo $_POST[fecmls]?>"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>  
           
            <?php  
				//archivos
				if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
				{
					$rutaad="informacion/protocolos_eticos/temp/";
					?><script>document.getElementById('nomarch').value='<?php echo $_FILES['plantillaad']['name'];?>';</script><?php
					copy($_FILES['plantillaad']['tmp_name'], $rutaad.$_FILES['plantillaad']['name']);
					$_POST[banarc]="1";
				}
                //********guardar
                if($_POST[oculto]=="1")
                {
                    switch($_POST[tabgroup1])
					{
						case 1: //*************************************************
							$sqln="UPDATE mecinsparticipacion SET documento='".$_POST[responsablet1]."',cargo='".$_POST[cargo1]."', fechaini='".$_POST[fechai1]."',fechafin='".$_POST[fechar1]."' WHERE id='".$_POST[oculid]."'";
							mysql_query($sqln,$linkbd);
							$clamensaje="Se Modifico con Exito la informaci\xf3n del Representante del Comit\xe9 Coordinador CI";
							break;
						case 2: //*************************************************
							$sqln="UPDATE mecinsparticipacion SET documento='".$_POST[responsablet2]."',cargo='".$_POST[cargo2]."', fechaini='".$_POST[fechai2]."',fechafin='".$_POST[fechar2]."' WHERE id='".$_POST[oculid]."'";
							mysql_query($sqln,$linkbd);
							$clamensaje="Se Modifico con Exitola informaci\xf3n del Representante de la Alta Direcci\xf3n";
							break;
						case 3: //*************************************************
							$sqln="UPDATE mecinsparticipacion SET documento='".$_POST[responsablet3]."',cargo='".$_POST[cargo3]."', fechaini='".$_POST[fechai3]."',fechafin='".$_POST[fechar3]."' WHERE id='".$_POST[oculid]."'";
							mysql_query($sqln,$linkbd);
							$clamensaje="Se Modifico con Exito la informaci\xf3n del Representante del Equipo Meci";
							break;
						case 4: //*************************************************
							
							$sqln="UPDATE meciprotocoloseticos SET idclase='".$_POST[protocolo]."',fechaprotocolo='".$_POST[fecmls]."',descripcion='".$_POST[desmar]."',adjunto='".$_POST[nomarch]."'  WHERE id='".$_POST[oculid]."'";
							mysql_query($sqln,$linkbd);
							if($_POST[banarc]=="1")
							{copy("informacion/protocolos_eticos/temp/".$_POST[maradj][$x],("informacion/protocolos_eticos/".$_POST[maradj][$x]));}
							$clamensaje="Se Modifico con Exito el Documento de Protocolo Etico";
							break;
					}
					?><script>despliegamodalm('visible','3','<?php echo $clamensaje;?>');</script><?php
					$_POST[oculto]="0";
                }
            ?>
            <input type="hidden" name="agregamlg" value="0">
            <input type='hidden' name='eliminaml' id='eliminaml'> 
            <input type="hidden" name="banarc" id="banarc" value="<?php echo $_POST[banarc];?>">
            <input type="hidden" name="bloqueo1" id="bloqueo1" value="<?php echo $_POST[bloqueo1];?>">
			<input type="hidden" name="bloqueo2" id="bloqueo2" value="<?php echo $_POST[bloqueo2];?>">
            <input type="hidden" name="bloqueo3" id="bloqueo3" value="<?php echo $_POST[bloqueo3];?>">
            <input type="hidden" name="bloqueo4" id="bloqueo4" value="<?php echo $_POST[bloqueo4];?>">
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
            <input type="hidden" name="oculcl" id="oculcl" value="<?php echo $_POST[oculcl];?>">
            <input type="hidden" name="oculid" id="oculid" value="<?php echo $_POST[oculid];?>">
            <input type="hidden" name="busquedas" id="busquedas" value="<?php echo $_POST[busquedas];?>">
 		</form>     
        <div id="bgventanamodal2">
            <div id="ventanamodal2">
                <a href="javascript:despliegamodal2('hidden')" style="position: absolute; left: 810px; top: 5px; z-index: 100;"><img src="imagenes/exit.png" title="cerrar" width=22 height=22>Cerrar</a>
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>  
	</body>
</html>