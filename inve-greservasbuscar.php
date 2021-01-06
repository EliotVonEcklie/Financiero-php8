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
		<title>:: Spid - Almacen</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function anular(variable)
			{
				despliegamodalm('visible','5','Desea Cancelar la Reserva','3',variable);
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="plan-acresponsables.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
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
						case "5": 	document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;		
					}
				}
			}
			function respuestaconsulta(pregunta,variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":	document.getElementById('oculto').value="3";
								document.form2.submit();break;
					case "3":	document.getElementById('oculto').value="7";
								document.getElementById('elimina').value=variable;
								document.form2.submit();
					break;
				}
			}
			function redirecciona(cod){window.location.href = "inve-greservaseditar.php?idreserva="+cod
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
  				<td colspan="3" class="cinta">
					<a><img src="imagenes/add.png" title="Nuevo" onClick="location.href='inve-greservas.php'" class="mgbt"/></a>
					<a><img src="imagenes/guardad.png" class="mgbt1"/></a>
					<a><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a><img src="imagenes/nv.png" title="Nueva Ventana"  onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"></a>
				</td>
          	</tr>
     	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	
 		<form name="form2" method="post" action="inve-greservasbuscar.php">
            <?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}
            	  if($_POST[oculto]=="7"){
            	  	$sql = "UPDATE  almreservas SET estado = 'DEL' WHERE codigo=$_POST[elimina];";
            	  	view($sql);
            	  	$sql = "UPDATE  almreservas_det SET estado = 'DEL' WHERE codreserva=$_POST[elimina];";
            	  	view($sql);
            	  }
            ?>
			<table  class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="5">:: Buscar Reservas</td>
        			<td class="cerrar" style="width:7%;"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:2cm;">c&oacute;digo:</td>
        			<td style="width:15%;"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:100%;"></td>
        			<td class="saludo1" style="width:2cm;">.: Solicitante:</td>
                    <td style="width:12%;"><input type="text" name="responsable" id="responsable" value="<?php echo $_POST[responsable]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('1');" style="width:80%"/>&nbsp;<a href="#" onClick="despliegamodal2('visible');"><img src="imagenes/buscarep.png"/></a></td>
                    <td><input type="text" name="nresponsable" id="nresponsable" value="<?php echo $_POST[nresponsable]?>" style="width:60%;text-transform:uppercase" readonly/>&nbsp;<input type="submit" name="Submit" value="&nbsp;Buscar&nbsp;" ></td>
       			</tr>                       
    		</table> 
    		<input type="hidden" name="oculto" id="oculto" value="1">
    		<input type="hidden" name="elimina" id="elimina">
    		<input type="hidden" name="cargotercero" id="cargotercero">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
       		<div class="subpantalla" style="height:69.5%; width:99.6%; overflow-x:hidden;">
				<?php
                    $crit1=" ";
                    $crit2=" ";
                    if ($_POST[nombre]!=""){$crit1="WHERE codigo LIKE '%$_POST[nombre]%'";}
                    if ($_POST[responsable]!="")
                    {
                        if ($_POST[nombre]!=""){$crit2="AND solicitante LIKE '%$_POST[responsable]%'";}
                        else {$crit2="WHERE solicitante LIKE '%$_POST[responsable]%'";}
                    }
                    $sqlr="SELECT * FROM almreservas $crit1 $crit2";
                    $resp = mysql_query($sqlr,$linkbd);
                    $_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="SELECT * FROM almreservas $crit1 $crit2 ORDER BY codigo LIMIT $_POST[numpos],$_POST[numres]";
                    $resp = mysql_query($sqlr,$linkbd);
                    $con=1;
					$numcontrol=$_POST[nummul]+1;
					if($nuncilumnas==$numcontrol)
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if($_POST[numpos]==0)
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
					}
                    echo "
                    <table class='inicio' align='center' width='80%'>
                        <tr>
							<td colspan='9' class='titulos'>.: Resultados Busqueda: <label style='float:right;'>::<img src='imagenes/sema_azulON.jpg' style='width:16px'/>&nbsp;Reserva Entregada&nbsp;&nbsp;::<img src='imagenes/sema_verdeON.jpg' style='width:16px'/>&nbsp;Reserva Activa&nbsp;&nbsp;::<img src='imagenes/sema_rojoON.jpg' style='width:16px'/>&nbsp;Reserva Cancelada&nbsp;&nbsp;::<img src='imagenes/candado.png' style='width:15px'/>&nbsp;Bloqueo por Usuario&nbsp;&nbsp;&nbsp;</label></td>
							<td class='submenu'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
								</select>
							</td>
						</tr>
                        <tr><td colspan='9'>Bodegas Encontrados: $_POST[numtop]</td>
							
						</tr>
                        <tr>
                            <td class='titulos2'>C&oacute;digo</td>
                            <td class='titulos2'>Fecha</td>
							<td class='titulos2'>Solicitante</td>
							<td class='titulos2'>Dependencia</td>
							<td class='titulos2'>Articulo</td>
							<td class='titulos2'>Cantidad</td>
							<td class='titulos2'>U.M</td>
							<td class='titulos2' width='4%'>Estado</td>
                            <td class='titulos2' width='4%'>Editar</td>
							<td class='titulos2' width='4%'>Cancelar</td>
                        </tr>";	
                    $iter='saludo1a';
                    $iter2='saludo2';
                    while ($row =mysql_fetch_row($resp)) 
                    {
						$dependencia= buscarareatrabajo($row[3]);
						$tercero= buscatercero($row[2]);
						$sqlr2="SELECT * FROM almreservas_det WHERE codreserva='$row[0]'";
						$resp2=mysql_query($sqlr2,$linkbd);
						$row2 =mysql_fetch_row($resp2);
						$ntr2 = mysql_num_rows($resp2);
						$codarticulo=substr($row2[1],-5);
						$sqlr3="SELECT nombre FROM almarticulos WHERE estado='S' AND codigo='$codarticulo'";
						$row3 =mysql_fetch_row(mysql_query($sqlr3,$linkbd));
						$narticulo=$row3[0];
						$imganu="<a href='#' onclick='anular($row[0])' ><img src='imagenes/anular.png' title='Anular' style='width:24px'/></a>";
						$imgedi="<a href='inve-greservaseditar.php?idreserva=$row[0]'><img src='imagenes/b_edit.png' title='Editar'></a>";
						switch($row[5])
						{
							case "S":	$imgsem="<img src='imagenes/sema_verdeON.jpg' title='Activa' style='width:21px'/>";break;
							case "ENT":	$imgsem="<img src='imagenes/sema_azulON.jpg' title='Entregada' style='width:21px'/>";
										$imganu="<img src='imagenes/anulard.png' title='Imposible Anular' style='width:24px'/>";
										$imgedi="<img src='imagenes/b_editd.png' title='Imposible Editar' />";
										break;
							
							case "DEL": $imgsem="<img src='imagenes/sema_rojoON.jpg' title='Anulada' style='width:21px'/>";
										$imgedi="<img src='imagenes/b_editd.png' title='Imposible Editar' />";
										$imganu="<img src='imagenes/anulard.png' title=' Ya Anulada' style='width:24px'/>";
										break;
						}
						if($row[2]!=$_SESSION[cedulausu])
						{
							$imganu="<img src='imagenes/candado.png' title='Solo Usuario Solicitante' style='width:22px'/>";
							$imgedi="<img src='imagenes/candado.png' title='Solo Usuario Solicitante' style='width:22px'/>";
						}
                        echo "
                        <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick='redirecciona($row[0])' style='text-transform:uppercase'>
                            <td rowspan='$ntr2'>$row[0]</td>
                            <td rowspan='$ntr2'>$row[1]</td>
                            <td rowspan='$ntr2'>$tercero</td>
                            <td rowspan='$ntr2'>$dependencia</td>
							<td>$narticulo</td>
							<td style='text-align:right;'>".number_format($row2[4],0,',','.')."</td>
							<td>$row2[6]</td>
							<td rowspan='$ntr2' style='text-align:center;'>$imgsem</td>
                            <td rowspan='$ntr2' style='text-align:center;'>$imgedi</td>
							<td rowspan='$ntr2' style='text-align:center;'>$imganu</td>
                        </tr>";
						if($ntr2!=1)
						{
							while ($row2 =mysql_fetch_row($resp2))
							{
								$codarticulo=substr($row2[1],-5);
								$sqlr3="SELECT nombre FROM almarticulos WHERE estado='S' AND codigo='$codarticulo'";
								$row3 =mysql_fetch_row(mysql_query($sqlr3,$linkbd));
								$narticulo=$row3[0];	
								echo"
									<tr class='$iter' style='text-transform:uppercase'>
										<td>$narticulo</td>
										<td style='text-align:right;'>".number_format($row2[4],0,',','.')."</td>
									</tr>";
							}
						}
						
						
                        $con+=1;
                        $aux=$iter;
                        $iter=$iter2;
                        $iter2=$aux;
                    }
                    echo"
						</table>
						<table class='inicio'>
							<tr>
								<td style='text-align:center;'>
									<a href='#'>$imagensback</a>&nbsp;
									<a href='#'>$imagenback</a>&nbsp;&nbsp;";
					if($nuncilumnas<=9){$numfin=$nuncilumnas;}
					else{$numfin=9;}
					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){$numx=$xx;}
						else{$numx=$xx+($numcontrol-9);}
						if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
						else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
					}
					echo "		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
								</td>
							</tr>
						</table>";
                ?>	
            </div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
    		<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
		</form>
	</body>
</html>