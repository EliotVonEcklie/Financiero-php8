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
		<title>:: Spid - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
        <script>
			function fanular(idaincap)
			{
				
				document.form2.idanul.value=idaincap;
				despliegamodalm('visible','4','Esta Seguro de Anular la Incapacidad N° '+idaincap,'1');
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if(document.getElementById('valfocus').value=="2")
					{
						document.getElementById('valfocus').value='1';
						document.getElementById('documento').focus();
					}
				}
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
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value="9";
						document.form2.submit();
						break;
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
  				<td colspan="3" class="cinta"><a href="hum-incapacidades.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><img src="imagenes/guardad.png" title="Guardar" /><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
        	</tr>	
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" action="hum-buscaincapacidades.php">
        	<?php if($_POST[oculto]=="")
			{
			 $_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;$_POST[idanul]=0;
			 //$_POST[fecha1]=date('Y-m-d');
			 //$_POST[fecha2]=date('Y-m-d');
			}?>
            <table  class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="10">:. Buscar Incapacidades de Nomina</td>
                    <td class="cerrar" style="width:7%"><a href="hum-principal.php">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:8%;">CC/NIT:</td>
                    <td style="width:15%;"><input type="text" name="numero" id="numero" value="<?php echo $_POST[numero];?>" style="width:90%;"></td>
                    <td class="saludo1" style="width:12%;">Nombre Empleado: </td>
                    <td><input type="text" name="nombre" id="nombre" value="<?php $_POST[nombre];?>" style="width:60%;"></td>
                    <td  class="saludo1">Fecha Inicial:</td>
                    <td><input type='date' name='fecha1' value="<?php echo $_POST[fecha1]?>"></td>
                    <td  class="saludo1">Fecha Inicial:</td>
                    <td><input type='date' name='fecha2' value="<?php echo $_POST[fecha2]?>"></td>                    
                </tr>                       
            </table> 
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <input type="hidden" name="idanul" id="idanul" value="<?php echo $_POST[idanul];?>"/>
            <input type="hidden" name="oculto" id="oculto" value="1">   
            <div class="subpantallac5" style="height:68.5%; width:99.6%; overflow-x:hidden;">
                <?php
					if($_POST[oculto]==9)
					{
						$sqlr ="UPDATE humincapacidades SET estado='N' WHERE id_inca='$_POST[idanul]'";
						mysql_query($sqlr,$linkbd);
						echo"<script>document.form2.idanul.value='';</script>";
					}
                    $crit1=$crit2=$crit3=" ";
					$tnov=array("g"=>"Enfermedad General","p"=>"Enfermedad Profesional");
                    if($_POST[numero]!=""){$crit1=" AND humincapacidades.tercero LIKE '%$_POST[numero]%'";}
                    if($_POST[nombre]!=""){$crit2=" AND humretenempleados.nombre LIKE '%$_POST[nombre]%'";}
					if($_POST[fecha1]!=""){$crit3="AND fecha between '$_POST[fecha1]' and '$_POST[fecha2]'";}
                    $sqlr="SELECT * FROM humincapacidades  WHERE estado<>'' $crit1 $crit2 $crit3";
                    $resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="SELECT * FROM humincapacidades WHERE estado<>'' $crit1 $crit2 $crit3 ORDER BY id_inca LIMIT $_POST[numpos],$_POST[numres]";
					//echo $sqlr;  //rc 5683  fac 12456 $611.254
                    $resp = mysql_query($sqlr,$linkbd);
                    $ntr = mysql_num_rows($resp);
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
                    <table class='inicio' align='center' >
                        <tr>
							<td colspan='10' class='titulos'>.: Resultados Busqueda:</td>
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
                        <tr><td colspan='11'>Variables Encontradas: $_POST[numtop]</td></tr>
                        <tr>
                        	<td class='titulos2'>No</td>
                            <td class='titulos2'>Documento</td>
                            <td class='titulos2'>Nombre</td>
                            <td class='titulos2'>Mes</td>                                
                            <td class='titulos2'>Fecha Inicio</td>
                            <td class='titulos2'>Fecha Final</td>
                            <td class='titulos2'>Dias Novedad Mes</td>
                            <td class='titulos2'>Tipo Novedad</td>
							<td class='titulos2'>Estado</td>        
                            <td class='titulos2' style='text-align:center;width:5%;'>Anular</td>
                            <td class='titulos2' style='text-align:center;width:5%;'>Editar</td>
                        </tr>";	
                    $iter='saludo1a';
                    $iter2='saludo2';
                    while ($row =mysql_fetch_row($resp)) 
                    {
						$sqlrti="SELECT descripcion_valor FROM dominios WHERE valor_final='$row[9]' AND nombre_dominio LIKE 'LICENCIAS'";
					 	$rowti =mysql_fetch_row(mysql_query($sqlrti,$linkbd));
						$con2=$con+ $_POST[numpos];
                        $nemp=buscatercero($row[4]);
						$fechafinal = new DateTime($row[3]);
						$fechafinal->add(new DateInterval("P0$row[6]D"));
                        echo"
                        <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
                            	<td>$row[0]</td>
								<td>$row[2]</td>
								<td>".buscatercero($row[4])."</td>
								<td>".mesletras($row[7])."</td>
								<td>$row[3]</td>
								<td>".$fechafinal->format('Y-m-d')."</td>
								<td>$row[6]</td>
								<td>$rowti[0]</td>	
								<td>$row[16]</td>	
                            <td style='text-align:center;'><img src='imagenes/anular.png' onClick=\"fanular('$row[0]');\"></td>
                            <td style='text-align:center;'><a href='hum-editaincapacidades.php?idr=$row[0]'><img src='imagenes/b_edit.png'></a></td>
                        </tr>";
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
					echo"		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
								&nbsp;<a href='#'>$imagensforward</a>
							</td>
						</tr>
					</table>";
                ?>
            </div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
 		</form>
	</body>
</html>