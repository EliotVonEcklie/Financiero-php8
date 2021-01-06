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
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("plan");?></tr>
          	<tr>
          		<td colspan="3" class="cinta"><a href="plan-tareasasignar.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" class="mgbt"><img src="imagenes/guardad.png" /></a><a href="plan-tareasbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" class="mgbt" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
		</table>
       	<form name="form2" id="form2" method="post" enctype="multipart/form-data">
        	<?php
        		if ($_POST[oculto]=="")
				{
					$_POST[oculid]=$_GET[id];
					$sqlr="SELECT * FROM planacradicacion WHERE numeror = '".$_POST[oculid]."'";
					$row = mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$_POST[nradicado]=$row[1];
					$_POST[fecharad]=date("d-m-Y",strtotime($row[2]));
					$_POST[horarad]=date("h:i a",strtotime($row[3]));
					$sqlrtp="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPO_RADICACION_AC' AND valor_inicial=$row[5]";
					$rowtp = mysql_fetch_row(mysql_query($sqlrtp,$linkbd));
					$_POST[tradicacion]=$rowtp[0];
					$_POST[fechares]=date("d-m-Y",strtotime($row[6]));
					$_POST[raddescri]=$row[8];
					$_POST[trescrito]=$row[9];
					$_POST[trtelefono]=$row[10];
					$_POST[trcorreo]=$row[11];
					$_POST[mararcori]=$row[19];
					$sqlrar="SELECT nomarchivo FROM planacarchivosad WHERE idradicacion = '".$_POST[oculid]."' ORDER BY idarchivoad ASC";
					$resar=mysql_query($sqlrar,$linkbd);
					while ($rowar = mysql_fetch_row($resar)){$_POST[nomarchivo][]=$rowar[0];}
					$sqlres="SELECT usuariocon,estado FROM planacresponsables WHERE codradicacion = '".$_POST[oculid]."' ORDER BY codigo ASC";
					$resre=mysql_query($sqlres,$linkbd);
					while ($rowre = mysql_fetch_row($resre))
					{
						$_POST[docres][]=$rowre[0];
						$_POST[nomdes][]=buscaresponsable($rowre[0]);
						$_POST[estadoes][]=$rowre[1];
					}
					$_POST[tabgroup1]=1;
					$_POST[oculto]="0";
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
			?>
            <input type="hidden" name="mararcori" id="mararcori" value="<?php echo $_POST[mararcori];?>">
			<div class="tabsmeci"  style="height:76.5%; width:99.6%">
        		<div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Informaci&oacute;n General</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio">
                            <tr>
                                <td colspan="11" class="titulos" style="width:93%">:.Vista Tarea Asignada</td>
                                <td class="cerrar" style="width:5%" ><a href="plan-principal.php" >Cerrar</a></td>
                            </tr>
                            <tr>
                                <td width="13%" class="saludo1" style="width:9%" >:&middot; N&deg; de Tarea:</td>
                                <td style="width:12%"><input type="text" name="nradicado" id="nradicado" style="width:100%" value="<?php echo $_POST[nradicado]?>" readonly></td>
                                <td class="saludo1" style="width:6%">:&middot; Fecha:</td>
                                <td style="width:10.5%"> <input type="text" name="fecharad" id="fecharad" style="width:100%" value="<?php echo $_POST[fecharad];?>" readonly></td>
                                <td class="saludo1" style="width:5%" >:&middot; Hora:</td>
                                <td style="width:9%"><input type="text" name="horarad" id="horarad" style="width:100%" value="<?php echo $_POST[horarad];?>" readonly></td>
                           	</tr>
                            <tr>
                                <td class="saludo1" style="width:10%">:&middot;Tipo de Tarea:</td>
                                <td colspan="3" ><input type="text" name="tradicacion" id="tradicacion" style="width:100%" value="<?php echo $_POST[tradicacion];?>" readonly></td>
                                <td class="saludo1" style="width:8%">:&middot; Fecha L&iacute;mite:</td>
                                <td colspan="2"><input type="text" name="fechares" id="fechares" style="width:100%" value="<?php echo $_POST[fechares]?>" readonly></td>
                            </tr>
                            <tr>
                                <td class="saludo1" >:&middot; Descripci&oacute;n:</td>
                                <td colspan="9"><input id="raddescri" name="raddescri" type="text" style="width:100%" value="<?php echo $_POST[raddescri]?>" readonly></td>
                            </tr>
                            <tr>
                                <td class="saludo1">:&middot; Modo de Respuesta :</td>
                                <td class="saludo2" colspan="3">
									<input type="checkbox"  name="trescrito" <?php if($_POST[trescrito]!=0){echo "checked";} ?>  value="escr" id="trescrito" class="defaultcheckbox" disabled/>Escrita &nbsp;&nbsp;&nbsp;&nbsp;
                                	<input readonly type="checkbox" name="trtelefono" <?php if($_POST[trtelefono]!=0){echo "checked";} ?> value="<?php echo $_POST[trtelefono]?>" id="trtelefono" class="defaultcheckbox" disabled/>Telef&oacute;nica &nbsp;&nbsp; &nbsp;&nbsp;
         							<input type="checkbox" name="trcorreo" <?php if($_POST[trcorreo]!=0){echo "checked";} ?> value="<?php echo $_POST[trcorreo]?>" id="trcorreo" class="defaultcheckbox" disabled/>Correo Electr&oacute;nico
                                </td>
                            </tr>
                        </table>
               		</div>
				</div>
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Responsables</label>
                    <div class="content" style="overflow-x:hidden;">
                    	<table class="inicio">
                            <tr>
                                <td colspan="6" class="titulos">Responsables</td>
                            </tr>
                            <tr>
                                <td class="titulos2" style="width:5%;">Item</td>
                                <td class="titulos2" style="width:15%;">Documento</td>
                                <td class="titulos2" style="width:65%;">Nombre</td>
                                <td class="titulos2" style="width:5%;">Tipo</td>
                                <td class="titulos2" style="width:5%;" title="Documento Original">Original</td>
                                <td class="titulos2" style="width:5%;">Estado</td>
                            </tr>
                            <?php
                                $iter="saludo1";
                                $iter2="saludo2";
                                $con=1;
                                $tam=count($_POST[docres]);   
                                for($x=0;$x<$tam;$x++)
                                {
									if($_POST[mararcori]==$_POST[docres][$x]){$marcador='checked';}
                                    else {$marcador='';}
                                    switch ($_POST[estadoes][$x]) 
                                    {
                                        case "C":
                                            $imgsem="src='imagenes/sema_verdeON.jpg' title='Contestada'";
                                            $imgtip="src='imagenes/escritura.png' title='Responder'";
                                            break;
                                        case "A":
                                            $imgsem="src='imagenes/sema_amarilloON.jpg' title='Pendiante'";
                                            $imgtip="src='imagenes/escritura.png' title='Responder'";
                                            break;
                                        case "R":
                                            $imgsem="src='imagenes/sema_azulON.jpg' title='Redirigido'";
                                            $imgtip="src='imagenes/escritura.png' title='Responder'";
                                            break;
                                        case "LN":
                                            $imgsem="src='imagenes/sema_amarilloON.jpg' title='Sin Revisar'";
                                            $imgtip="src='imagenes/lectura.jpg' title='Solo Lectura'";
                                            break;
                                        case "LS":
                                            $imgsem="src='imagenes/sema_verdeON.jpg' title='Revisado'";
                                            $imgtip="src='imagenes/lectura.jpg' title='Solo Lectura'";
                                            break;
                                    }
                                    echo "
                                        <tr class='$iter'>
                                            <td>$con</td>
                                            <td><input class='inpnovisibles type='text' name='docres[]' value='".$_POST[docres][$x]."' style='width:100%;' readonly></td>
                                            <td><input class='inpnovisibles type='text' name='nomdes[]' value='".$_POST[nomdes][$x]."' style='width:100%;' readonly></td>
                                            <input type='hidden' name='estadoes[]' value='".$_POST[estadoes][$x]."'>
                                            <td style='text-align:center;'><img ".$imgtip." style='width:20px'/></td>
											 <td><input type='radio' name='docorig' class='defaultradio' $marcador disabled /></td>
                                            <td style='text-align:center;'><img ".$imgsem." style='width:20px'/></td>
                                        </tr>";   
                                    $aux=$iter;
                                    $iter=$iter2;
                                    $iter2=$aux;
                                    $con=$con+1;
                                }
                            ?>
                        </table>
                    </div>
             	</div>
                <div class="tab">
                    <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
                    <label for="tab-3">Archivos Adjuntos</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio" >
                            <tr>
                                <td colspan="4" class="titulos">Archivos Adjuntos</td>
                            </tr>                  
                            <tr>
                                <td class="titulos2" style="width:5%;">Item</td>
                                <td class="titulos2" style="width:85%;">Nombre del Archivo</td>
                                <td class="titulos2" style="width:10%;">Tipo</td>
                                
                            </tr>
                            <?php
                                $iter="saludo1";
                                $iter2="saludo2";
                                $con=1;
                                $tam=count($_POST[nomarchivo]);   
                                for($x=0;$x<$tam;$x++)
                                {
                                    echo "
                                        <tr class='$iter'>
                                            <td>$con</td>
                                            <td><input class='inpnovisibles type='text' name='nomarchivo[]' value='".$_POST[nomarchivo][$x]."' style='width:100%;' readonly></td>
                                            <td style='text-align:center;'>".traeico($_POST[nomarchivo][$x])."</td>
                                        </tr>";   
                                    $aux=$iter;
                                    $iter=$iter2;
                                    $iter2=$aux;
                                    $con=$con+1;
                                }
                            ?>
                        </table>
                    </div>
                </div>
			</div> 
            <input type="hidden" id="oculid" name="oculid" value="<?php echo $_POST[oculid]?>">
       		<input type="hidden" id="oculto" name="oculto" value="<?php echo $_POST[oculto]?>">
       	</form>
	</body>
</html>