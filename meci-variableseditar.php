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
			function despliegamodalm(_valor,_tip,mensa,pregunta)
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
						case "4":	
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;
					}
				}
			}
			function funcionmensaje(){document.location.href = "meci-variableslbusca.php";}
            function respuestaconsulta(pregunta)
            {
                switch(pregunta)
                {
                    case "1":
						document.form2.oculto.value="1";
						document.form2.submit();
                    break;
                }
            }
			function guardar()
			{
				var pesact=document.form2.tabgroup1.value;
				var varver='N';
				var nomgua='';
				switch(pesact)
                {
                    case "1":
						if(document.getElementById('nombre1').value!="" && document.getElementById('descripcion1').value!="")
							{nomgua='Esta Seguro de Modificar la Normativa del Marco Legal';varver='S';}
						 break;
					case "2":
						if(document.getElementById('nombre2').value!="" && document.getElementById('descripcion2').value!="")
							{nomgua='Esta Seguro de Modificar el Cargo para El Comit\xe9 Coordibador CI';varver='S';}
						 break;
					case "3":
						if(document.getElementById('nombre3').value!="" && document.getElementById('descripcion3').value!="")
							{nomgua='Esta Seguro de Modificar el Cargo para la Alta Direcci\xf3n';varver='S';}
						 break;
					case "4":
						if(document.getElementById('nombre4').value!="" && document.getElementById('descripcion4').value!="")
							{nomgua='Esta Seguro de Modificar el Cargo para el Equipo Meci';varver='S';}
						 break;
					case "5":
						if(document.getElementById('nombre5').value!="" && document.getElementById('descripcion5').value!="")
							{nomgua='Esta Seguro de Modificar la Clase de Protocolos Eticos';varver='S';}
						 break;
					case "6":
						if(document.getElementById('nombre6').value!="" && document.getElementById('descripcion6').value!="")
							{nomgua='Esta Seguro de Modificar la Categoría de Marco Legal';varver='S';}
						 break;
				}
				if(varver=='S')
				{ 
					despliegamodalm('visible','4',nomgua,'1');
				}
				else
				{
					despliegamodalm('visible','1','Falta informaci\xf3n para poder Modificar');
				}
			}
			function iratras(){
				location.href="meci-variableslbusca.php?id=<?php echo $_GET[id] ?>&clase=<?php echo "$_GET[clase]" ?>";
			}
		</script>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("meci");?></tr>
          	<tr>
          		<td colspan="3" class="cinta">
					<a onclick="location.href='meci-variables.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a onClick="guardar();" class="tooltip bottom mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a onclick="location.href='meci-variableslbusca.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pesta&ntilde;a</span></a>
					<a onClick="iratras()" class="tooltip bottom mgbt"><img src="imagenes/iratras.png"><span class="tiptext">Atr&aacute;s</span></a>
				</td>
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
        		//*****************************************************************
				$linkbd=conectar_bd(); 
 				if($_POST[oculto]=="")
                {
					$_POST[oculid]=$_GET[id];
					$_POST[oculcl]=$_GET[clase];
					$_POST[oculto]="0";
					switch($_POST[oculcl])
                	{
                   		case 'NML':
							$_POST[tabgroup1]=1;
							$_POST[bloqueo1]="";
							$_POST[bloqueo2]="disabled";
							$_POST[bloqueo3]="disabled";
							$_POST[bloqueo4]="disabled";
							$_POST[bloqueo5]="disabled";
							$_POST[bloqueo6]="disabled";
							$sql1="SELECT * FROM mecivariables WHERE id='".$_POST[oculid]."'";
							$row1=mysql_fetch_row(mysql_query($sql1,$linkbd));
							$_POST[nombre1]=$row1[1];
							$_POST[descripcion1]=$row1[2];
							break;
						case 'CML':
							$_POST[tabgroup1]=6;
							$_POST[bloqueo1]="disabled";
							$_POST[bloqueo2]="disabled";
							$_POST[bloqueo3]="disabled";
							$_POST[bloqueo4]="disabled";
							$_POST[bloqueo5]="disabled";
							$_POST[bloqueo6]="";
							$sql1="SELECT * FROM mecivariables WHERE id='".$_POST[oculid]."'";
							$row1=mysql_fetch_row(mysql_query($sql1,$linkbd));
							$_POST[nombre6]=$row1[1];
							$_POST[descripcion6]=$row1[2];
							break;
						case 'CCC':
							$_POST[tabgroup1]=2;
							$_POST[bloqueo1]="disabled";
							$_POST[bloqueo2]="";
							$_POST[bloqueo3]="disabled";
							$_POST[bloqueo4]="disabled";
							$_POST[bloqueo5]="disabled";
							$_POST[bloqueo6]="disabled";
							$sql1="SELECT * FROM mecivariables WHERE id='".$_POST[oculid]."'";
							$row1=mysql_fetch_row(mysql_query($sql1,$linkbd));
							$_POST[nombre2]=$row1[1];
							$_POST[descripcion2]=$row1[2];
							break;
						case 'CAD':
							$_POST[tabgroup1]=3;
							$_POST[bloqueo1]="disabled";
							$_POST[bloqueo2]="disabled";
							$_POST[bloqueo3]="";
							$_POST[bloqueo4]="disabled";
							$_POST[bloqueo5]="disabled";
							$_POST[bloqueo6]="disabled";
							$sql1="SELECT * FROM mecivariables WHERE id='".$_POST[oculid]."'";
							$row1=mysql_fetch_row(mysql_query($sql1,$linkbd));
							$_POST[nombre3]=$row1[1];
							$_POST[descripcion3]=$row1[2];
							break;
						case 'CEM':
							$_POST[tabgroup1]=4;
							$_POST[bloqueo1]="disabled";
							$_POST[bloqueo2]="disabled";
							$_POST[bloqueo3]="disabled";
							$_POST[bloqueo4]="";
							$_POST[bloqueo5]="disabled";
							$_POST[bloqueo6]="disabled";
							$sql1="SELECT * FROM mecivariables WHERE id='".$_POST[oculid]."'";
							$row1=mysql_fetch_row(mysql_query($sql1,$linkbd));
							$_POST[nombre4]=$row1[1];
							$_POST[descripcion4]=$row1[2];
							break;
						case 'CPE':
							$_POST[tabgroup1]=5;
							$_POST[bloqueo1]="disabled";
							$_POST[bloqueo2]="disabled";
							$_POST[bloqueo3]="disabled";
							$_POST[bloqueo4]="disabled";
							$_POST[bloqueo5]="";
							$_POST[bloqueo6]="disabled";
							$sql1="SELECT * FROM mecivariables WHERE id='".$_POST[oculid]."'";
							$row1=mysql_fetch_row(mysql_query($sql1,$linkbd));
							$_POST[nombre5]=$row1[1];
							$_POST[descripcion5]=$row1[2];
							break;
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
					case 5:
						$check5='checked';break;
					case 6:
                        $check6='checked';break;
                }
				//*****************************************************************
			?>
            <div class="tabsmeci"  style="height:76.5%; width:99.6%">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> <?php echo $_POST[bloqueo1];?>>
                    <label for="tab-1">Normativas Marco Legal</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:100%">Normativas Marco Legal</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre1" id="nombre1" value="<?php echo $_POST[nombre1];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td>
                                	<input type="text" name="descripcion1" id="descripcion1" value="<?php echo $_POST[descripcion1];?>" style="width:100%">
                                </td>
                            </tr>
                        </table>
                    </div>
				</div> 
				<div class="tab">
                    <input type="radio" id="tab-6" name="tabgroup1" value="6" <?php echo $check6;?> <?php echo $_POST[bloqueo6];?>>
                    <label for="tab-6">Categor&iacute;as de Marco Legal</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:100%">Categor&iacute;as de Marco Legal</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre6" id="nombre6" value="<?php echo $_POST[nombre6];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td>
                                	<input type="text" name="descripcion6" id="descripcion6" value="<?php echo $_POST[descripcion6];?>" style="width:100%">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> <?php echo $_POST[bloqueo2];?>>
                    <label for="tab-2">Cargos Comit&eacute; Coordinador CI</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:100%">Cargos Comit&eacute; Coordinador CI</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre2" id="nombre2" value="<?php echo $_POST[nombre2];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td>
                                	<input type="text" name="descripcion2" id="descripcion2" value="<?php echo $_POST[descripcion2];?>" style="width:100%">
                                </td>
                            </tr>
                        </table>  
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> <?php echo $_POST[bloqueo3];?>>
                    <label for="tab-3">Cargos Alta Direcci&oacute;n</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:100%">Cargos Alta Direcci&oacute;n</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre3" id="nombre3" value="<?php echo $_POST[nombre3];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td>
                                	<input type="text" name="descripcion3" id="descripcion3" value="<?php echo $_POST[descripcion3];?>" style="width:100%">
                                </td>
                            </tr>
                        </table>  
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> <?php echo $_POST[bloqueo4];?>>
                    <label for="tab-4">Cargos Equipo Meci</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:100%">Cargos Equipo Meci/td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre4" id="nombre4" value="<?php echo $_POST[nombre4];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td>
                                	<input type="text" name="descripcion4" id="descripcion4" value="<?php echo $_POST[descripcion4];?>" style="width:100%">
                                </td>
                            </tr>
                        </table>  
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-5" name="tabgroup1" value="5" <?php echo $check5;?> <?php echo $_POST[bloqueo5];?>>
                    <label for="tab-5">Clases Protocolos Eticos</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:100%">Clases Protocolos Eticos</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre5" id="nombre5" value="<?php echo $_POST[nombre5];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td>
                                	<input type="text" name="descripcion5" id="descripcion5" value="<?php echo $_POST[descripcion5];?>" style="width:100%">
                                </td>
                            </tr>
                        </table>  
                    </div>
                </div>
            </div>  
            <?php  
			 //********guardar
                if($_POST[oculto]=="1")
                {
					$linkbd=conectar_bd();;
					switch($_POST[tabgroup1])
					{
						case 1://************************************************
							$sqln="UPDATE mecivariables SET nombre='".$_POST[nombre1]."',descripcion='".$_POST[descripcion1]."' WHERE id='".$_POST[oculid]."'";
							$conmensaje="Se modifico con exito la Normativa del Marco Legal";
							mysql_query($sqln,$linkbd);
							break;
						case 2://************************************************
							$sqln="UPDATE mecivariables SET nombre='".$_POST[nombre2]."',descripcion='".$_POST[descripcion2]."' WHERE id='".$_POST[oculid]."'";
							$conmensaje="Se modifico con exito el Cargo para El Comit� Coordinador CI";
							mysql_query($sqln,$linkbd);
							break;
						case 3://************************************************
							$sqln="UPDATE mecivariables SET nombre='".$_POST[nombre3]."',descripcion='".$_POST[descripcion3]."' WHERE id='".$_POST[oculid]."'";
							$conmensaje="Se modifico con exito el Cargo para la Alta Direcci�n";
							mysql_query($sqln,$linkbd);
							break;
						case 4://************************************************
							$sqln="UPDATE mecivariables SET nombre='".$_POST[nombre4]."',descripcion='".$_POST[descripcion4]."' WHERE id='".$_POST[oculid]."'";
							$conmensaje="Se modifico con exito el Cargos para el Equipo Meci";
							mysql_query($sqln,$linkbd);
							break;
						case 5://************************************************
							$sqln="UPDATE mecivariables SET nombre='".$_POST[nombre5]."',descripcion='".$_POST[descripcion5]."' WHERE id='".$_POST[oculid]."'";
							$conmensaje="Se modifico con exito La Clase de Protocolos Eticos";
							mysql_query($sqln,$linkbd);
							break;
						case 6://************************************************
							$sqln="UPDATE mecivariables SET nombre='".$_POST[nombre6]."',descripcion='".$_POST[descripcion6]."' WHERE id='".$_POST[oculid]."'";
							$conmensaje="Se modifico con exito la Categoría del Marco Legal";
							mysql_query($sqln,$linkbd);
							break;
					}
					?><script>despliegamodalm('visible','1','<?php echo $conmensaje;?>');</script><?php
					$_POST[oculto]="0";
				}
            ?>
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
            <input type="hidden" name="bloqueo1" id="bloqueo1" value="<?php echo $_POST[bloqueo1];?>">
			<input type="hidden" name="bloqueo2" id="bloqueo2" value="<?php echo $_POST[bloqueo2];?>">
            <input type="hidden" name="bloqueo3" id="bloqueo3" value="<?php echo $_POST[bloqueo3];?>">
            <input type="hidden" name="bloqueo4" id="bloqueo4" value="<?php echo $_POST[bloqueo4];?>">
			<input type="hidden" name="bloqueo5" id="bloqueo5" value="<?php echo $_POST[bloqueo5];?>">
			<input type="hidden" name="bloqueo6" id="bloqueo6" value="<?php echo $_POST[bloqueo6];?>">
            <input type="hidden" name="oculcl" id="oculcl" value="<?php echo $_POST[oculcl];?>">
            <input type="hidden" name="oculid" id="oculid" value="<?php echo $_POST[oculid];?>">
 		</form>     
      
	</body>
</html>