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
	 	<?php require "head.php"; ?>
        <title>:: Spid - Calidad</title>
        <script>
			function verUltimaPos(id,clase){
				location.href="meci-variableseditar.php?id="+id+"&clase="+clase;
			}
			function cambioswitch(id,valor)
			{
				if(valor==1)
				{
					despliegamodalm('visible','4','Desea activar esta Normativa','1');
					document.form2.nocambioestado.value="1";
				}
				else
				{
					despliegamodalm('visible','4','Desea Desactivar esta Normativa','2');
					document.form2.nocambioestado.value="0";
				}
				document.getElementById('idestado').value=id;
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				var recarga = "parent.document.form2.submit();";
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
						case "4":	
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta+"&recarga="+recarga;break;
					}
				}
			}
			function respuestaconsulta(pregunta)
            {
                switch(pregunta)
                {
                    case "1":
						document.form2.cambioestado.value="1";
						document.form2.submit();
					break;
					case "2":
						document.form2.cambioestado.value="0";
						document.form2.submit();
                    break;
                }
            }
		</script>
		<?php 
		
			$gidcta=$_GET['id']; 
			if ($_GET['clase']!='') 
			{
				$_POST[proceso]=$_GET['clase'];
			}
		?>
         <!-- <style>
			input[type='range'] {
			-webkit-appearance: none;
			border-radius: 5px;
			box-shadow: inset 0 0 5px #333;
			background-color: #999;
			height: 10px;
			vertical-align: middle;
			}
		</style> -->
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("meci");?></tr>
          	<tr>
          		<td colspan="3" class="cinta">
					<a onclick="location.href='meci-variables.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png" title="" /><span class="tiptext">Nuevo</span></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/guardad.png" title=""/></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/buscad.png" title=""/></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title=""><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pesta&ntilde;a</span></a>
				</td>
        	</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" action="meci-variableslbusca.php" enctype="multipart/form-data">
        <?php
			if($_POST[oculto]=="")
			{
				$_POST[oculto]="0";
				$_POST[cambioestado]="";
				$_POST[nocambioestado]="";
			}
			//*****************************************************************
			if($_POST[cambioestado]!="")
			{
				$linkbd=conectar_bd();
				if($_POST[cambioestado]=="1")
				{
					$sqlr="UPDATE mecivariables SET estado='S' WHERE id='".$_POST[idestado]."'";
					mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
				}
				else 
				{
					$sqlr="UPDATE mecivariables SET estado='N' WHERE id='".$_POST[idestado]."'";
					mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
				}
			}
			//*****************************************************************
			if($_POST[nocambioestado]!="")
			{
				if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
				else {$_POST[lswitch1][$_POST[idestado]]=0;}
				$_POST[nocambioestado]="";
			}
		?>
        	<table class="inicio ancho" >
				<tr>
                	<td class="titulos" colspan="4" style="width:100%">:: Buscar Estructura Organizacional </td>
                	<td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
              	</tr>
              	<tr>
                	<td class="saludo1">Clase Proceso:</td>
                	<td>
                    	<select name="proceso" id="proceso" onKeyUp="return tabular(event,this)" onChange="document.form2.submit();" >
                        	<option value="" <?php if($_POST[proceso]=='') {echo "SELECTED";}?>>....</option>
							<option value="NML" <?php if($_POST[proceso]=='NML') {echo "SELECTED";}?>>Normativas Marco Legal</option>
							<option value="CML" <?php if($_POST[proceso]=='CML') {echo "SELECTED";}?>>Categor&iacute;as Marco Legal</option>
          					<option value="CCC" <?php if($_POST[proceso]=='CCC') {echo "SELECTED";}?>>Cargos Comit&eacute; Coordinador CI</option>
                            <option value="CAD" <?php if($_POST[proceso]=='CAD') {echo "SELECTED";}?>>Cargos Alta Direcci&oacute;n</option>
                            <option value="CEM" <?php if($_POST[proceso]=='CEM') {echo "SELECTED";}?>>Cargos Equipo Meci</option>
                            <option value="CPE" <?php if($_POST[proceso]=='CPE') {echo "SELECTED";}?>>Clases Protocolos Eticos</option>
        				</select>
                    </td>
               </tr>                       
   			</table>
            <input name="idclase" id="idclase" type="hidden" value="<?php echo $_POST[idclase]?>">
            <input name="contador" id="contador" type="hidden" value="<?php echo $_POST[contador]?>">
            <input name="archdel" id="archdel" type="hidden" value="<?php echo $_POST[archdel]?>">
            <input name="ocudelplan" id="ocudelplan" type="hidden" value="<?php echo $_POST[ocudelplan]?>">
            <div class="subpantallac5" style="height:68%; width:99.5%; overflow-x:hidden">
            	<?php
					$linkbd=conectar_bd();
					if($_POST[proceso]!="")
					{
						switch($_POST[proceso])
						{
							case 'NML':
								$clase="Normativa Marco Legal";
								break;
							case 'CML':
								$clase="Categor&iacute;a Marco Legal";
								break;
							case 'CCC':
								$clase="Cargo Comit&eacute; Coordinador CI";
								break;
							case 'CAD':
								$clase="Cargo Alta Direcci&oacute;n";
								break;
							case 'CEM':
								$clase="Cargo Equipo Meci";
								break;
							case 'CPE':
								$clase="Clase Protocolo Etico";
								break;
						}
						$sqlr="SELECT * FROM mecivariables WHERE clase='".$_POST[proceso]."'  ORDER BY id ASC";
						$resp = mysql_query($sqlr,$linkbd);
						$ntr = mysql_num_rows($resp);
						$con=1;
						echo "
							<table class='inicio' align='center' width='80%'>
								<tr>
									<td colspan='5' class='titulos'>.: Resultados Busqueda:</td>
								</tr>
								<tr class='saludo3'>
									<td colspan='5'>Encontrados: $ntr</td>
								</tr>
								<tr class='centrartext'>
									<td class='titulos' style='width:4%;'>N&deg;</td>
									<td class='titulos' style='width:15%;'>Clase</td>
									<td class='titulos' style='width:20%;'>Nombre</td>
									<td class='titulos' style='width:40%;'>Descripci&oacute;n</td>
									<td class='titulos' style='width:5%;'>Estado</td>
								</tr>";
						while ($row =mysql_fetch_row($resp)) 
						  {
							if($row[3]=='S')
							{$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;}
							else
							{$coloracti="#C00";$_POST[lswitch1][$row[0]]=1;}
							if($gidcta!=""){
								if($gidcta==$row[0]){
									$estilo='background-color:#FF9';
								}
								else{
									$estilo="";
								}
							}
							else{
								$estilo="";
							}	
							echo "
								<tr class='saludo2' onDblClick=\"verUltimaPos($row[0],'$_POST[proceso]')\" style='$estilo'>	
									<td class='centrartext icoop'>$con</td>
									<td class='icoop'>$clase</td>
									<td class='icoop'>$row[1]</td>
									<td class='icoop'>".substr(ucwords(strtolower(str_replace("&lt;br/&gt;","\n",$row[2]))), 0, 80)."</td>
									<td class='centrartext'><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"".$row[0]."\",\"".$_POST[lswitch1][$row[0]]."\")' /></td>
								</tr>";
							 $con+=1;
						}
						echo"</table>";
					}
				?>
            
            </div>
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
            <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
        </form>
	</body>
</html>