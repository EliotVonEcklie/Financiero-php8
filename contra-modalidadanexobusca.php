<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
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
		<title>:: Spid - Contrataci&oacute;n</title>
		
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function verUltimaPos(idcta, subm, filas){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="contra-modalidadanexoedita.php?idproceso="+idcta+"&idproceso2="+subm+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg;
			}
		</script>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script>
			function eliminar_inf(codigo)
			{
				document.getElementById('iddel').value=codigo;
				despliegamodalm('visible','4','Esta Seguro de Eliminar los Datos Basicos de Contrato','1');
			}
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
			function funcionmensaje(){document.location.href = "contra-modalidadanexo.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('ocudel').value="1";document.form2.submit();break;
				}
			}
		</script>
		<?php titlepag();?>
        <?php
		$scrtop=$_GET['scrtop'];
		if($scrtop=="") $scrtop=0;
		echo"<script>
			window.onload=function(){
				$('#divdet').scrollTop(".$scrtop.")
			}
		</script>";
		$gidcta=$_GET['idcta'];
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
            <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("contra");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a href="contra-modalidadanexo.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" border="0" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
				</td>
			</tr>
		</table>	
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <?php
		if($_GET[numpag]!=""){
			$oculto=$_POST[oculto];
			if($oculto!=2){
				$_POST[numres]=$_GET[limreg];
				$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
				$_POST[nummul]=$_GET[numpag]-1;
			}
		}
		else{
			if($_POST[nummul]==""){
				$_POST[numres]=10;
				$_POST[numpos]=0;
				$_POST[nummul]=0;
			}
		}
		?>
 		<form name="form2" method="post" action="contra-modalidadanexobusca.php" >
            <table  class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="5">:: Buscar Datos B&aacute;sicos Contratos </td>
                    <td class="cerrar" style="width:7%" ><a href="contra-principal.php">Cerrar</a></td>
                </tr>
            </table>
            <input type="hidden" name="oculto" id="oculto"  value="1"/>
            <input type="hidden" name="ocudel" id="ocudel"  value="<?php echo $_POST[ocudel]?>"/>
            <input type="hidden" name="iddel" id="iddel"  value="<?php echo $_POST[iddel]?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantallac5" style="height:72.2%; width:99.6%; overflow-x:hidden;">
            <?php 
                if($_POST['ocudel']=="1")
                {
                    $sqlr="UPDATE contramodalidadanexos SET estado='N' WHERE idmodalidad='$_POST[iddel]'";
                    mysql_query($sqlr,$linkbd);
                    echo"<script>despliegamodalm('visible','2','El Datos Basicos de Contrato Eliminados con exito');</script>";
                    $_POST['ocudel']="2";
                }
                //if($_POST[oculto])
                {
                    $crit1=" ";
                    $crit2=" ";
                    if ($_POST[codigo]!=""){$crit1=" where (sn.idmodalidad like '%".$_POST[codigo]."%') ";}
                    if ($_POST[cliente]!=""){$crit2=" and sn.idpadremod like '%$_POST[cliente]%' ";}
                    $sqlr="SELECT DISTINCT idmodalidad, idpadremod FROM  contramodalidadanexos $crit1 $crit2";
                    $resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);

					$cond2="";
					if ($_POST[numres]!="-1"){ 
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}
					$sqlr="SELECT DISTINCT idmodalidad, idpadremod FROM  contramodalidadanexos $crit1 $crit2 ORDER BY idmodalidad ".$cond2;
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
                            <td colspan='7' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
									<option value='-1'"; if ($_POST[renumres]=='-1'){echo 'selected';} echo ">Todos</option>
								</select>
							</td>
                        </tr>
                        <tr>
                            <td colspan='7'>Encontrados: $_POST[numtop]</td>
                        </tr>
                        <tr>
                            <td class='titulos2' style=\"width:3%\">Item</td>
                            <td class='titulos2' style=\"width:20%\">Modalidad</td>
                            <td class='titulos2' style=\"width:20%\">Proceso</td>
                            <td class='titulos2'>Anexos</td>
                            <td class='titulos2' style=\"width:4%\">Soporte</td>
                            <td class='titulos2' style=\"width:4%\">Obligatorio</td>
                            <td class='titulos2' style=\"width:4%\">Editar</td>
                            <td class='titulos2' style=\"width:5%\">Anular</td>
                        </tr>";
                        $iter='saludo1a';
                        $iter2='saludo2';
                        $iteru='saludo1a';
                        $iteru2='saludo2';
						$filas=1;
                        while ($row =mysql_fetch_row($resp)) 
                        {
							$con2=$con+ $_POST[numpos];
                            $sqlr2="SELECT idanexo,obligatorio,estado,fase FROM contramodalidadanexos WHERE idmodalidad='$row[0]' AND idpadremod='$row[1]' ORDER BY idanexo";
                            $resp2=mysql_query($sqlr2,$linkbd);
                            $row2 =mysql_fetch_row($resp2);
                            $ntr2 = mysql_num_rows($resp2);
                            $sqlr3="SELECT descripcion_valor FROM dominios WHERE valor_inicial='$row[0]' AND (valor_final IS NULL OR valor_final='' ) AND nombre_dominio='MODALIDAD_SELECCION'";
                            $resp3=mysql_query($sqlr3,$linkbd);
                            $row3 =mysql_fetch_row($resp3);
                            $sqlr4="SELECT descripcion_valor,descripcion_dominio FROM dominios WHERE valor_inicial='$row[1]' AND valor_final='$row[0]' AND nombre_dominio='MODALIDAD_SELECCION'";
                            $resp4=mysql_query($sqlr4,$linkbd);
                            $row4 =mysql_fetch_row($resp4);
                            $sqlr5="SELECT nombre FROM contraanexos WHERE id='$row2[0]'";
                            $resp5=mysql_query($sqlr5,$linkbd);
                            $row5 =mysql_fetch_row($resp5);
                            if ($row2[1]=="S"){$sino1="SI";} 
                            else{$sino1="NO";}
                            if ($row2[2]=="S"){$sino2="SI";} 
                            else{$sino2="NO";}
                            if ($row2[3]==1){$fase="Precontractual";} 
                            else if ($row2[3]==2){$fase="Contractual";}
							else{$fase="Postcontractual";}
						if($gidcta!=""){
							if($gidcta==$row[0]){
								$estilo='background-color:yellow';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
						$idcta="'".$row[0]."'";
						$subm="'".$row[1]."'";
						$numfil="'".$filas."'";
						echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $subm, $numfil)\" style='text-transform:uppercase; $estilo' >
                                    <td rowspan='$ntr2'>$con2</td>
                                    <td rowspan='$ntr2'>".strtoupper($row3[0])."</td>
                                    <td rowspan='$ntr2'>".strtoupper($row4[0])."</td>
                                    <td>$row5[0] ($fase)</td>
                                    <td>$sino1</td>
                                    <td>$sino2</td>";
								echo"<td align=\"middle\" rowspan='$ntr2'>
									<a onClick=\"verUltimaPos($idcta, $subm, $numfil)\" style='cursor:pointer;'>
										<img src='imagenes/b_edit.png' style='width:18px' title='Editar'>
									</a>
								</td>";
                                    echo"<td align=\"middle\" rowspan='$ntr2'><a href='#' onClick='eliminar_inf($row[0]);'><img src='imagenes/del.png'></a></td>
                                </tr>";
                                    if($ntr2!=1)
                                    {
                                        while ($row2 =mysql_fetch_row($resp2))
                                        {	
                                            $sqlr5="SELECT nombre FROM contraanexos WHERE id='$row2[0]'";
                                            $resp5=mysql_query($sqlr5,$linkbd);
                                            $row5 =mysql_fetch_row($resp5);
                                            $auxu=$iteru;
                                            $iteru=$iteru2;
                                            $iteru2=$auxu;	
											if ($row2[3]==1){$fase="Precontractual";} 
											else if ($row2[3]==2){$fase="Contractual";}
											else{$fase="Postcontractual";}
                                            echo"
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase; $estilo'>
                                                <td>$row5[0] ($fase)</td>
                                                <td>$sino1</td>
                                                <td>$sino2</td>
                                            </tr>";	

                                        }                                    }
                            $con+=1;
                            $aux=$iter;
                            $iter=$iter2;
                             $iter2=$aux;
							 $filas++;
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
						echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
										&nbsp;<a href='#'>$imagensforward</a>
									</td>
								</tr>
							</table>";
                    }
				?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>