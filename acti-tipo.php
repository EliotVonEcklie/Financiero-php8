<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
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
		<title>:: Spid - Contrataci&oacute;n</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function validar(codigo)
			{
				tipo=codigo.split('-'); ;
				switch(tipo[1])
				{
					case "1":	document.getElementById('codgrupo').value=tipo[0];break;
					case "2":	document.getElementById('codsegmento').value=tipo[0].substring(0,2);break;
					case "3":	document.getElementById('codfamilia').value=tipo[0].substring(2,4);break;
					case "4":	document.getElementById('codclases').value=tipo[0].substring(4,6);break;
				}
				document.form1.submit();
			}
			function validarcre(tipo)
			{
				document.getElementById('letrerog').value="";
				switch(tipo)
				{
					case "1":	document.getElementById('bloqueo1').value="style='display:none'";
								document.getElementById('bloqueo2').value="style='width:100%; background-color:#A9A9A9;' disabled";
								document.getElementById('bloqueo3').value="style='width:100%; background-color:#A9A9A9;' disabled";
								document.getElementById('bloqueo4').value="style='width:100%; background-color:#A9A9A9;' disabled";
								document.getElementById('bloqueo5').value="style='width:100%; background-color:#A9A9A9;' disabled";
								document.getElementById('ocultar1').value="style='width:100%; display:block;'";
								document.getElementById('ocultar2').value="style='display:none;'";
								document.getElementById('ocultar3').value="style='display:none;'";
								document.getElementById('ocultar4').value="style='display:none;'";
								document.getElementById('ocultar5').value="style='display:none;'";
								document.getElementById('grupo').value="";
								
								document.getElementById('segmento').value="";
								document.getElementById('familia').value="";
								
								document.getElementById('blocodi1').value="";
								
								document.getElementById('blocodi2').value=" readonly";
								document.getElementById('blocodi3').value=" readonly";
								
								document.getElementById('blocodi4').value=" readonly";
								document.getElementById('blocodi5').value=" readonly";
								document.getElementById('codgrupo').value="0";
								document.getElementById('codsegmento').value="00";
								document.getElementById('codfamilia').value="000";
																
								break;
					case "2":	document.getElementById('bloqueo1').value="style='width:100%;' ";
								document.getElementById('bloqueo2').value="style='display:none'";
								document.getElementById('bloqueo3').value="style='width:100%; background-color:#A9A9A9;' disabled";
								document.getElementById('bloqueo4').value="style='width:100%; background-color:#A9A9A9;' disabled";
								document.getElementById('bloqueo5').value="style='width:100%; background-color:#A9A9A9;' disabled";
								document.getElementById('ocultar1').value="style='display:none;'";
								document.getElementById('ocultar2').value="style='width:100%; display:block;'";
								document.getElementById('ocultar3').value="style='display:none;'";
								document.getElementById('ocultar4').value="style='display:none;'";
								document.getElementById('ocultar5').value="style='display:none;'";
								document.getElementById('segmento').value="";
								document.getElementById('familia').value="";
								document.getElementById('blocodi1').value=" readonly";
								document.getElementById('blocodi2').value="";
								document.getElementById('blocodi3').value=" readonly";
								document.getElementById('blocodi4').value=" readonly";
								document.getElementById('blocodi5').value=" readonly";
								document.getElementById('codsegmento').value="00";
								document.getElementById('codfamilia').value="000";
								break;
					case "3":	document.getElementById('bloqueo1').value="style='width:100%;' ";
								document.getElementById('bloqueo2').value="style='width:100%;' ";
								document.getElementById('bloqueo3').value="style='display:none'";
								document.getElementById('bloqueo4').value="style='width:100%; background-color:#A9A9A9;' disabled";
								document.getElementById('bloqueo5').value="style='width:100%; background-color:#A9A9A9;' disabled";
								document.getElementById('ocultar1').value="style='display:none;'";
								document.getElementById('ocultar2').value="style='display:none;'";
								document.getElementById('ocultar3').value="style='width:100%; display:block;'";
								document.getElementById('ocultar4').value="style='display:none;'";
								document.getElementById('ocultar5').value="style='display:none;'";
								document.getElementById('familia').value="";
								document.getElementById('blocodi1').value=" readonly";
								document.getElementById('blocodi2').value=" readonly";
								document.getElementById('blocodi3').value="";
								document.getElementById('blocodi4').value=" readonly";
								document.getElementById('blocodi5').value=" readonly";
								document.getElementById('codfamilia').value="000";
								break;
				}
				document.form1.submit();	
			}
			function guardar()
			{
				if(document.getElementById('secrea').value!="")
				{
					banderin=0;
					switch(document.getElementById('secrea').value)
					{
						case "1":	if((document.getElementById('ingrupo').value!="")&&(document.getElementById('codgrupo').value!="")&&(document.getElementById('codgrupo').value!="00")){banderin=1;}break;
						case "2":	if((document.getElementById('grupo').value!="")&&(document.getElementById('codgrupo').value!="")&&(document.getElementById('codgrupo').value!="00")&&(document.getElementById('insegmento').value!="")&&(document.getElementById('codsegmento').value!="")&&(document.getElementById('codsegmento').value!="00")){banderin=1;}break;
						case "3":	if((document.getElementById('grupo').value!="")&&(document.getElementById('codgrupo').value!="")&&(document.getElementById('codgrupo').value!="00")&&(document.getElementById('segmento').value!="")&&(document.getElementById('codsegmento').value!="")&&(document.getElementById('codsegmento').value!="00")&&(document.getElementById('infamilia').value!="")&&(document.getElementById('codfamilia').value!="")&&(document.getElementById('codfamilia').value!="00")){banderin=1;}break;
						case "4":	if((document.getElementById('grupo').value!="")&&(document.getElementById('codgrupo').value!="")&&(document.getElementById('codgrupo').value!="00")&&(document.getElementById('segmento').value!="")&&(document.getElementById('codsegmento').value!="")&&(document.getElementById('codsegmento').value!="00")&&(document.getElementById('familia').value!="")&&(document.getElementById('codfamilia').value!="")&&(document.getElementById('codfamilia').value!="00")&&(document.getElementById('inclases').value!="")&&(document.getElementById('codclases').value!="")&&(document.getElementById('codclases').value!="00")){banderin=1;}break;
						case "5":	if((document.getElementById('grupo').value!="")&&(document.getElementById('codgrupo').value!="")&&(document.getElementById('codgrupo').value!="00")&&(document.getElementById('segmento').value!="")&&(document.getElementById('codsegmento').value!="")&&(document.getElementById('codsegmento').value!="00")&&(document.getElementById('familia').value!="")&&(document.getElementById('codfamilia').value!="")&&(document.getElementById('codfamilia').value!="00")&&(document.getElementById('inproductos').value!="")&&(document.getElementById('codproductos').value!="")&&(document.getElementById('codproductos').value!="00")){banderin=1;}break;
					}	
					if (banderin==1){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
				}
				else{despliegamodalm('visible','2','Seleccione el Tipo de Creación');}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
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
					}
				}
			}
			function funcionmensaje(){document.location.href = "acti-tipo.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form1.oculgen.value=2;document.form1.submit();break;
				}
			}
			function valDep()
			{
				if($('#deprecia').is(":checked")){
					$('#valdeprecia').removeAttr('readonly');
					$('#valdep').val('0');
				}
				else{
					$('#valdeprecia').attr('readonly','readonly');
					$('#valdeprecia').val('0');
					$('#valdep').val('1');
					$('#valdep').attr('checked',true);
					}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
    	<tr><?php menu_desplegable("acti");?></tr>	
            <tr>
            	<td colspan="3" class="cinta">
					<a href="acti-tipo.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a href="acti-buscatipo.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
        	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form1" method="post">
     	<?php
			if($_POST[oculgen]=="")
			{
				$_POST[bloqueo1]="style='width:100%; background-color:#A9A9A9;' disabled ";
				$_POST[bloqueo2]="style='width:100%; background-color:#A9A9A9;' disabled ";
				$_POST[bloqueo3]="style='width:100%; background-color:#A9A9A9;' disabled ";
				$_POST[bloqueo4]="style='width:100%; background-color:#A9A9A9;' disabled ";
				$_POST[bloqueo5]="style='width:100%; background-color:#A9A9A9' disabled ";
				$_POST[ocultar1]="style='display:none'";
				$_POST[ocultar2]="style='display:none'";
				$_POST[ocultar3]="style='display:none'";
				$_POST[ocultar4]="style='display:none'";
				$_POST[ocultar5]="style='display:none'";
				$_POST[blocodi1]=" readonly";
				$_POST[blocodi2]=" readonly";
				$_POST[blocodi3]=" readonly";
				$_POST[blocodi4]=" readonly";
				$_POST[blocodi5]=" readonly";
				$_POST[codgrupo]="0";
				$_POST[codsegmento]="00";
				$_POST[codfamilia]="000";
				$_POST[oculgen]=1;
			}
		?>  
 			<table class="inicio" >
                <tr>
                    <td colspan="6" class="titulos">Clasificacion de activos</td>
                    <td class="cerrar" style="width:7%;"><a href="contra-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1">Tipo de Creaci&oacute;n</td>
                    <td colspan="3">
                        <select id="secrea" name="secrea" onChange="validarcre(this.value);" >
                            <option value=''>Seleccione ...</option>
                            <?php
                                $sqlr="SELECT id,nombre FROM acti_clase WHERE  estado='S'";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[secrea]){echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";}
                                    else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
                                }	
                            ?>
                        </select> 
                    </td>
                    <td class="saludo1" style="width:4%;">Codigo</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:12%;" ><?php $dominio='UNSPSC' ; $clasificacion=buscaclase('1'); echo strtoupper($clasificacion);?></td>
                    <td style="width:40%;" colspan="3">
                        <select id="grupo" name="grupo" onChange="validar(this.value)" <?php echo $_POST[bloqueo1];?>  >
                            <option value=''>Seleccione ...</option>
                            <?php
                                $sqlr="Select * from actipo  where tipo='1'  and estado='S' order by tipo,codigo asc";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    $i="$row[0]-$row[2]";
                                    if($i==$_POST[grupo]){echo "<option value=$i SELECTED>$row[0] - $row[1]</option>";}
									else{echo "<option value=$i>$row[0] - $row[1]</option>";}
                                }			
                        	?>
                    	</select>
                    	<input type="text" id="ingrupo" name="ingrupo" value="<?php echo $_POST[ingrupo];?>" <?php echo $_POST[ocultar1];?>>
                	</td>
                	<td>
                    	<input type="text" id="codgrupo" name="codgrupo" value="<?php echo $_POST[codgrupo];?>" maxlength="1" size="3px" <?php echo $_POST[blocodi1];?>>
                	</td>
            	</tr>
                <tr>
                    <td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscaclase('2'); echo strtoupper($clasificacion);?></td>
                    <td colspan="3">
                        <select id="segmento" name="segmento" onChange="validar(this.value)" <?php echo $_POST[bloqueo2];?>>
                            <option value=''>Seleccione ...</option>
                            <?php
                               $ngrupo=explode("-",$_POST[grupo]);
                               $sqlr="Select * from actipo  where tipo='2' and niveluno='$ngrupo[0]' and estado='S' order by tipo,codigo asc";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    $i="$row[0]-$row[2]";
                                    if($i==$_POST[segmento]){echo "<option value=$i SELECTED>$row[0] - $row[1]</option>";}
									else{echo "<option value=$i>$row[0] - $row[1]</option>";}
                                 }			
                            ?>
                        </select>
                        <input type="text" id="insegmento" name="insegmento" value="<?php echo $_POST[insegmento];?>" <?php echo $_POST[ocultar2];?> >
                    </td>
                     <td >
                        <input type="text" id="codsegmento" name="codsegmento" value="<?php echo $_POST[codsegmento];?>" maxlength="2" size="3px" <?php echo $_POST[blocodi2];?>>
                    </td>
                </tr>
                <tr>
                    <td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscaclase('3'); echo strtoupper($clasificacion);?></td>
                    <td colspan="3">
                        <select id="familia" name="familia" onChange="validar(this.value)" <?php echo $_POST[bloqueo3];?>>
                            <option value=''>Seleccione ...</option>
                            <?php
                       			$nsegnento=explode("-",$_POST[segmento]);
                               	$sqlr="Select * from actipo  where tipo='3' and niveluno='$nsegnento[0]' and estado='S' order by tipo,codigo asc";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    $i="$row[0]-$row[2]";
                                    if($i==$_POST[familia]){echo "<option value=$i SELECTED>$row[0] - $row[1]</option>";}
									else{echo "<option value=$i>$row[0] - $row[1]</option>";}
                                 }			
                            ?>
                        </select>
                        <input type="text" id="infamilia" name="infamilia" value="<?php echo $_POST[infamilia];?>" <?php echo $_POST[ocultar3];?> >
                    </td>
                    <td>
                        <input type="text" id="codfamilia" name="codfamilia" value="<?php echo $_POST[codfamilia];?>" maxlength="3" size="3px" <?php echo $_POST[blocodi3];?>>
                    </td>
                </tr>
				<?php
				if($_POST[segmento]==''){
				}else{
					$_POST[valdep]="1";
					echo"<script>valDep();</script>";
					?>
					<tr>
						<td class="saludo1">Deprecia</td>
						<td>
							<input type="checkbox" id="deprecia" name="deprecia" onClick="valDep()" <?php if ($_POST[valdep]==1) {echo ' checked="checked"';} ?>>
							<input type="hidden" id="valdep" name="valdep" value="<?php echo $_POST[valdep]?>" >
						</td>
						<td class="saludo1" style="width:9%" >Meses Depreciacion </td>
						<td colspan="2"><input type="text" id="valdeprecia" name="valdeprecia" value="<?php echo $_POST[valdeprecia];?>" maxlength="3" size="2px" > Meses</td>
					</tr>
				<?php 
					} 
				?>
 			</table>
            <input type="hidden" id="bloqueo1" name="bloqueo1" value="<?php echo $_POST[bloqueo1];?>">
            <input type="hidden" id="bloqueo2" name="bloqueo2" value="<?php echo $_POST[bloqueo2];?>">
            <input type="hidden" id="bloqueo3" name="bloqueo3" value="<?php echo $_POST[bloqueo3];?>">
            <input type="hidden" id="bloqueo4" name="bloqueo4" value="<?php echo $_POST[bloqueo4];?>">
            <input type="hidden" id="bloqueo5" name="bloqueo5" value="<?php echo $_POST[bloqueo5];?>">
            <input type="hidden" id="ocultar1" name="ocultar1" value="<?php echo $_POST[ocultar1];?>">
            <input type="hidden" id="ocultar2" name="ocultar2" value="<?php echo $_POST[ocultar2];?>">
            <input type="hidden" id="ocultar3" name="ocultar3" value="<?php echo $_POST[ocultar3];?>">
            <input type="hidden" id="ocultar4" name="ocultar4" value="<?php echo $_POST[ocultar4];?>">
            <input type="hidden" id="ocultar5" name="ocultar5" value="<?php echo $_POST[ocultar5];?>">
            <input type="hidden" id="blocodi1" name="blocodi1" value="<?php echo $_POST[blocodi1];?>">
            <input type="hidden" id="blocodi2" name="blocodi2" value="<?php echo $_POST[blocodi2];?>">
            <input type="hidden" id="blocodi3" name="blocodi3" value="<?php echo $_POST[blocodi3];?>">
            <input type="hidden" id="blocodi4" name="blocodi4" value="<?php echo $_POST[blocodi4];?>">
            <input type="hidden" id="blocodi5" name="blocodi5" value="<?php echo $_POST[blocodi5];?>">
            <input type="hidden" id="letrerog" name="letrerog" value="<?php echo $_POST[letrerog];?>">
            <input type="hidden" id="oculgen" name="oculgen" value="<?php echo $_POST[oculgen];?>">
		<?php 
            if($_POST[oculgen]=="2")
            {
				
				switch ($_POST[secrea]) 
                    {
                        case "1":
                            $codpadre="0";
							$codabuelo="0";
							$descripcion=$_POST[ingrupo];
                            break;
                        case "2":
                            $codpadre=$_POST[codgrupo];
							$descripcion=$_POST[insegmento];
							$codabuelo="0";
                            break;
                        case "3":
							$codabuelo=$_POST[codgrupo];
                            $codpadre=$_POST[codsegmento];
							$descripcion=$_POST[infamilia];
                            break;
                    }
				
                $ntr="";
                if($_POST[secrea]=="1") 
                {
                    $numcodigo=$_POST[codgrupo];
                    $sqlr="SELECT nombre FROM actipo WHERE codigo='$_POST[codgrupo]'";
                    $resp = mysql_query($sqlr,$linkbd);
                    $ntr = mysql_num_rows($resp);
                }
                elseif($_POST[secrea]=="2")
                {
                    $numcodigo=$_POST[codsegmento];
                    $sqlr="SELECT nombre FROM actipo WHERE codigo='$numcodigo' and niveluno='$codpadre'";
                    $resp = mysql_query($sqlr,$linkbd);
                    $ntr = mysql_num_rows($resp);		
                }
				else
				{
                    $numcodigo=$_POST[codfamilia];
                    $sqlr="SELECT nombre FROM actipo WHERE codigo='$numcodigo' and niveluno='$codpadre' and niveldos='$codabuelo'";
                    $resp = mysql_query($sqlr,$linkbd);
                    $ntr = mysql_num_rows($resp);		
                }	
                if($ntr==0)
                {
					if($_POST[secrea]=="3"){
						$sqlr="INSERT INTO actipo (codigo,nombre,tipo,niveluno,niveldos,estado,deprecia) VALUES ('$numcodigo','$descripcion','$_POST[secrea]','$codpadre','$codabuelo','S','$_POST[valdeprecia]')";
						mysql_query($sqlr,$linkbd);
						echo"<script>despliegamodalm('visible','1','Proceso de almacenado con Exito');</script>";
					}else{
						$sqlr="INSERT INTO actipo (codigo,nombre,tipo,niveluno,niveldos,estado,deprecia) VALUES ('$numcodigo','$descripcion','$_POST[secrea]','$codpadre','$codabuelo','S','0')";
						mysql_query($sqlr,$linkbd);
						echo"<script>despliegamodalm('visible','1','Proceso de almacenado con Exito');</script>";
					}
                }
                else {echo "Codigo $numcodigo Repetido";}
                echo"<script>document.getElementById('oculgen').value=1; </script>";
            }
        ?> 
        </form>  
	</body>
</html>