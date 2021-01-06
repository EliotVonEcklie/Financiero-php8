<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
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
        <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/funciones.js"></script>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script>
//************* genera reporte ************
			function pdf(){
				document.form2.action="plan-pdfradicaciones.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function grafico(){
				document.form2.action="grafacreportes.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="plan-acradicacionexcel.php";
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
          		<td colspan="3" class="cinta"><a class="mgbt1"><img src="imagenes/add2.png" title="Nuevo" /></a><a class="mgbt1"><img src="imagenes/guardad.png" /></a><a class="mgbt" onClick="document.form2.submit();"><img src="imagenes/busca.png" title="Buscar"/></a><a class="mgbt" onClick="<?php echo paginasnuevas("plan");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  title="Imprimir" style="width:29px; height:25px;"/></a><a onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a></td>
        	</tr>
		</table>
        <form name="form2" method="post" action=""> 
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
            <table class="inicio">
                <tr>
                    <td height="25" colspan="8" class="titulos" >:.Buscar Documento Radicado</td>
                    <td class="cerrar" style="width:7%"><a onClick="location.href='plan-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr><td colspan="9" class="titulos2" >:&middot; Por Descripci&oacute;n </td></tr>
                <tr>
                	<td style="width:2.5cm" class="saludo1">Dependencia:</td>
                	<td colspan="3">
                    	<select name="dependencias" id="dependencias" onKeyUp="return tabular(event,this)" style="width:95%;text-transform:uppercase" onChange="limbusquedas();">
                        	<option value="" <?php if($_POST[dependencias]=='') {echo "SELECTED";$_POST[nomdep]="";}?>>- Todas</option>
          					<?php
								$sqlr="SELECT * FROM planacareas WHERE estado='S'";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if("$row[0]"==$_POST[dependencias])
									{
										echo "<option value='$row[0]' SELECTED>- $row[1]</option>";
										$_POST[nomdep]="Dependencia: $row[1]";
									}
                                    else {echo "<option value='$row[0]'>- $row[1]</option>";}	  
                                }
							?>
        				</select>
                    </td>
                	<td class="saludo1" style="width:2.5cm">Clase Proceso:</td>
                	<td >
                    	<select name="proceso" id="proceso" onKeyUp="return tabular(event,this)" style="width:95%;" onChange="limbusquedas();">
                        	<option value="" <?php if($_POST[proceso]=='') {echo "SELECTED";$_POST[nompro]="";}?>>....</option>
          					<option value="AN" <?php if($_POST[proceso]=='AN') {echo "SELECTED";$_POST[nompro]="Pendientes";}?>>Pendientes</option>
          					<option value="AC" <?php if($_POST[proceso]=='AC') {echo "SELECTED";$_POST[nompro]="Contestados";}?>>Contestados</option>
                            <option value="AV" <?php if($_POST[proceso]=='AV') {echo "SELECTED";$_POST[nompro]="Vencidos";}?>>Vencidos</option>
                            <option value="LN" <?php if($_POST[proceso]=='LN') {echo "SELECTED";$_POST[nompro]="Solo Lectura";}?>>Solo Lectura</option>
                            <option value="DL" <?php if($_POST[proceso]=='DL') {echo "SELECTED";$_POST[nompro]="Anulados";}?>>Anulados</option>
        				</select>
                    </td>
                    <td class="saludo1" style="width:4cm">:&middot; N° Rad. o Documento:</td>
                    <td ><input type="search" name="numero" id="numero" value="<?php echo $_POST[numero]?>"/></td>
                </tr>
                <tr>
                	<td  class="saludo1">Tercero:</td>
                    <td colspan="3"><input type="search" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style=" width:100%"/></td>
                    <td  class="saludo1">Tipo Rad.:</td>
                    <td colspan="3">
                    	<select name="tradicacion" id="tradicacion" style="width:100%;text-transform:uppercase;" onKeyUp="return tabular(event,this)"  onChange="limbusquedas();">
                          <option onChange="" value="" >Seleccione....</option>
                          <?php	
                              $sqlr="SELECT * FROM plantiporadicacion WHERE estado='S' AND radotar='RA' ORDER BY nombre ASC  ";
                              $resp=mysql_query($sqlr,$linkbd);
                              while ($row =mysql_fetch_row($resp)) 
                              {
                                  if($_POST[tradicacion]=="$row[0]")
                                  {
                                      echo "<option value='$row[0]' SELECTED>:- $row[1]</option>";
                                      $_POST[nomtiporadica]=$row[1];
                                  }
                                  else {echo "<option value='$row[0]'>:- $row[1]</option>";} 	 
                              }		
                          ?> 
                      </select>
               		</td>
                <tr>
                <tr>
                	<td  class="saludo1">Fecha Inicial:</td>
                	<td><input type="date" id="fechaini" name="fechaini" value="<?php echo $_POST[fechaini] ?>"/></td>
                	<td class="saludo1">Fecha Final:</td>
                	<td><input type="date" id="fechafin" name="fechafin" value="<?php echo $_POST[fechafin] ?>"/></td>
                    <td><input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
                </tr>
         	</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="nomdep" id="nomdep" value="<?php echo $_POST[nomdep];?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
          	<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <input type="hidden" name="nompro" id="nompro" value="<?php echo $_POST[nompro];?>"/>
            <input type="hidden" name="nomtiporadica" id="nomtiporadica" value="<?php echo $_POST[nomtiporadica];?>"/>
           	<div class="subpantallac5" style="height:65%; width:99.5%; overflow-x:hidden">
     			<?php 
					$cond1="";
					$cond2="";
					$cond3="";
					$cond4="";
					$cond5="";
					if ($_POST[fechaini]!="" xor $_POST[fechafin]!="")
					{
						if($_POST[fechaini]==""){echo "<script>despliegamodalm('visible','2','Se deben ingresar la fecha inicial ')</script>";}
						else {echo "<script>despliegamodalm('visible','2','Se deben ingresar la fecha final ')</script>";}
					}
					elseif ($_POST[fechaini]!="" && $_POST[fechafin]!="")
					{
						$fecini=explode("-",date('d-m-Y',strtotime($_POST[fechaini])));
						$fecfin=explode("-",date('d-m-Y',strtotime($_POST[fechafin])));
						if(gregoriantojd($fecfin[1],$fecfin[0],$fecfin[2])< gregoriantojd($fecini[1],$fecini[0],$fecini[2]))
						{echo "<script>despliegamodalm('visible','2','La fecha inicial no debe ser mayor a la fecha final')</script>";}
						else {$cond3=" AND TB1.fechar BETWEEN CAST('$_POST[fechaini]' AS DATE) AND CAST('$_POST[fechafin]' AS DATE)";}
					}
					if($_POST[dependencias]!="")
					{
						$cond2=" AND EXISTS(SELECT TB2.estado FROM planacresponsables TB2, planaccargos TB3 WHERE TB1.numeror=TB2.codradicacion AND TB3.codcargo=TB2.codcargo AND TB3.dependencia='$_POST[dependencias]')";
					}
					if($_POST[numero]!=""){$cond1="AND concat_ws(' ', TB1.codigobarras,TB1.idtercero) LIKE '%$_POST[numero]%'";}
					if($_POST[ntercero]!=""){$cond4="AND EXISTS(SELECT TB4.estado FROM terceros TB4 WHERE TB1.idtercero=TB4.cedulanit AND concat_ws(' ', TB4.nombre1,TB4.nombre2,TB4.apellido1,TB4.apellido2,TB4.razonsocial,TB4.cedulanit) LIKE '%$_POST[ntercero]%')";}
					if($_POST[tradicacion]!=""){$cond5="AND tipor='$_POST[tradicacion]'";}
					switch ($_POST[proceso]) 
					{
						case '':	$presqlr="SELECT TB1.* FROM planacradicacion TB1  WHERE TB1.tipot='0' $cond2 $cond1 $cond3 $cond4 $cond5 ORDER BY TB1.numeror";break;
						case 'LN':
						case 'LS':	$presqlr="SELECT TB1.* FROM planacradicacion TB1 WHERE TB1.tipot='0' AND (TB1.estado='LS' OR TB1.estado='LN') $cond2 $cond1 $cond3 $cond4 $cond5 ORDER BY TB1.numeror";break;
						case 'AC':
						case 'AN':	$presqlr="SELECT TB1.* FROM planacradicacion TB1 WHERE TB1.tipot='0' AND TB1.estado='$_POST[proceso]' $cond2 $cond1 $cond3 $cond4 $cond5 ORDER BY TB1.numeror";break;
						case 'AV':	$presqlr="SELECT TB1.* FROM planacradicacion TB1  WHERE TB1.tipot='0' AND EXISTS (SELECT TB2.codigo FROM planacresponsables TB2 WHERE TB2.codradicacion=TB1.numeror $cond2 $cond1 $cond3 $cond4 $cond5 AND ((TB2.fechares > TB1.fechalimite AND TB1.estado='AC') OR (TB1.estado='AN' AND TB1.fechalimite <= CURDATE()))) ORDER BY TB1.numeror";break;

					}
					$sqlr="$presqlr";
					$res=mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($res);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="$presqlr  DESC LIMIT $_POST[numpos],$_POST[numres]";
					$res=mysql_query($sqlr,$linkbd);
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
					echo"
					<table class='inicio'>
						<tr>
							<td class='titulos' colspan='8'>:: Lista de Documentos Radicados $_POST[nomdep]</td>
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
						<tr><td colspan='9'>Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2'><img src='imagenes/plus.gif'></td>
							<td class='titulos2' style='width:6%;'>Radicaci&oacute;n</td>
							<td class='titulos2' style='width:8%;'>Fecha Radicado</td>
							<td class='titulos2' style='width:9%;'>Fecha Vencimiento</td>
							<td class='titulos2' style='width:8%;'>Fecha Respuesta</td>
							<td class='titulos2' style='width:30%;'>Tercero</td>
							<td class='titulos2'>Descripci&oacute;n</td>
							<td class='titulos2' style='width:5%;'>Estado</td>
							<td class='titulos2' style='width:5%;'>Concluida</td>
						 </tr>";
					$iter='saludo1a';
					$iter2='saludo2';
					$con=1;
					while ($row = mysql_fetch_row($res))
					{
						$tercero=buscatercero($row[7]);
						$fechar=date("d-m-Y",strtotime($row[2]));
						$fechav=date("d-m-Y",strtotime($row[6]));
						$fechactual=date("d-m-Y");
						$tmp = explode('-',$fechav);
						$fcpv=gregoriantojd($tmp[1],$tmp[0],$tmp[2]);
						$tmp = explode('-',$fechactual);
						$fcpa=gregoriantojd($tmp[1],$tmp[0],$tmp[2]); 
						switch($row[20])
						{
							case "AC":
								$sqlac="SELECT fechares FROM planacresponsables WHERE estado='AC' AND codradicacion='$row[0]'";
								$rowac=mysql_fetch_row(mysql_query($sqlac,$linkbd));
								$fechares=explode("-",date('d-m-Y',strtotime($rowac[0])));
								if($fcpv <= gregoriantojd($fechares[1],$fechares[0],$fechares[2]))
								{$imgsem="src='imagenes/sema_rojoON.jpg' title='Vencida'";}
								else{$imgsem="src='imagenes/sema_verdeON.jpg' title='Contestada'";}
								$imgcon="src='imagenes/confirm3.png' title='Concluida'";
								$mfechares=date('d-m-Y',strtotime($rowac[0]));
								break;
							case "LN":
								$sqlec="SELECT usuariocon FROM planacresponsables WHERE estado='LN' AND codradicacion='$row[0]'";
								$reslec = mysql_query($sqlec,$linkbd);
								$nlec = mysql_num_rows($reslec);
								if ($nlec==0)
								{
									$imgsem="src='imagenes/sema_verdeON.jpg' title='Revisados'";
									$imgcon="src='imagenes/confirm3.png' title='Concluida'";
								}
								else
								{
									$imgsem="src='imagenes/sema_amarilloON.jpg' title='Pendiantes'";
									$imgcon="src='imagenes/confirm3d.png' title='No Concluida'";
								}
								$mfechares="Solo Lectura";
								$fechav="Sin Limite";
								break;
							case "AN": 
								if ($fcpv <= $fcpa){$imgsem="src='imagenes/sema_rojoON.jpg' title='Vencida'";}
								else {$imgsem="src='imagenes/sema_amarilloON.jpg' title='Sin Responder'";}
								$imgcon="src='imagenes/confirm3d.png' title='No Concluida'";
								$mfechares="00-00-000";
								break;
						}							
						echo 
						"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
							<td class='titulos2'>
								<a onClick='detallesdocradi($con, $row[0])' style='cursor:pointer;'>
									<img id='img$con' src='imagenes/plus.gif'>
								</a>
							</td>
							<td>$row[1]</td>
							<td>$fechar</td>
							<td>$fechav</td>
							<td>$mfechares</td>
							<td>$tercero</td>
							<td>$row[8]</td>
							<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
							<td style='text-align:center;'><img $imgcon style='width:20px'/></td>
						</tr>
						<tr>
							<td align='center'></td>
							<td colspan='6'>
								<div id='detalle$con' style='display:none'></div>
							</td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con++;
					}
					if ($_POST[numtop]==0)
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda $tibusqueda<img src='imagenes\alert.png' style='width:25px'></td>
							</tr>
						</table>";
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
        </form>
	</body>
</html>