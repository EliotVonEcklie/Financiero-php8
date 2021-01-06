<?php //V 1001 26/12/16 ?> 
<?php

	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
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
			function respuestaconsulta(pregunta)
				{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="3";
								document.form2.submit();break;
				}
			}
			function excell()
			{
				alert();
				document.form2.action="contra-informecontratosexccel.php";
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
            <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("contra");?></tr>
            <tr>
  				<td colspan="3" class="cinta">
					<a class="mgbt1"><img src="imagenes/add2.png"/></a>
					<a class="mgbt1"><img src="imagenes/guardad.png"/></a>
					<a onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("contra");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a class="mgbt"><img src="imagenes/print_off.png" title="Imprimir" style="width:29px; height:25px;"/></a>
					<a onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a>
				</td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	
 		<form name="form2" method="post" action="contra-informegestioncontratos.php">
			<?php 
				if($_POST[oculto]=="")
				{
					$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;
					$vact=vigencia_usuarios($_SESSION[cedulausu]);
					$_POST[vigencias]=$vact;
				}
				else{$vact=vigencia_usuarios($_SESSION[cedulausu]);}
				
			?>
            <table  class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="7">:: Buscar Contratos</td>
                    <td class="cerrar" style="width:7%"><a onClick="location.href='contra-principal.php'">Cerrar</a></td>
                </tr>
				<tr>
        			<td class="saludo1">Fecha Inicial:</td>
                    <td>
                     	
                        <input name="fechaini" id="fechaini" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechaini');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
                    </td>
                    <td class="saludo1">Fecha Final:</td>
                    <td>
                     <input name="fechafin" id="fechafin" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechafin');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
                    </td>
                    <td class="saludo1">Vigencia Exogena:</td>
                    <td>
                    	<select name="vigencias" id="vigencias" onChange=""  style="width:100%;">
	  						<?php	  
     							for($x=$vact;$x>=$vact-4;$x--)
	  							{
		 							if($x==$_POST[vigencias]){echo "<option value='$x' SELECTED>$x</option>";}
									else {echo "<option value='$x'>$x</option>";}
								}
	  						?>
      					</select>    
                   	</td>
                    <td><input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
				</tr>                     
            </table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantallac5" style="height:67.5%;">
				<?php 
					$crit1=" ";
					$crit2=" ";
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
						else
						{$cond1=" AND TB1.fecha_registro BETWEEN CAST('$_POST[fechaini]' AS DATE) AND CAST('$_POST[fechafin]' AS DATE)";}
					}
					$sqlr="SELECT TB1.numcontrato,TB1.objeto,TB1.contratista,TB1.plazo_ejecu,TB1.modalidad,TB1.tipo_contrato,TB2.codcdp,TB1.rp, TB1.fecha_registro,TB1.fecha_inicio,TB1.fecha_terminacion,TB1.codsolicitud,TB1.valor_contrato FROM contracontrato TB1, contrasoladquisiciones TB2 WHERE TB1.vigencia='$_POST[vigencias]' AND TB1.activo='1' AND TB1.codsolicitud=TB2.codsolicitud";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
					$sqlr="SELECT TB1.numcontrato,TB1.objeto,TB1.contratista,TB1.plazo_ejecu,TB1.modalidad,TB1.tipo_contrato,TB2.codcdp,TB1.rp, TB1.fecha_registro,TB1.fecha_inicio,TB1.fecha_terminacion,TB1.codsolicitud,TB1.valor_contrato FROM contracontrato TB1, contrasoladquisiciones TB2 WHERE TB1.vigencia='$_POST[vigencias]' AND TB1.activo='1' AND TB1.codsolicitud=TB2.codsolicitud $cond1 ORDER BY TB1.numcontrato $cond2";
					$resp = mysql_query($sqlr,$linkbd);
					$con=1;
					$numcontrol=$_POST[nummul]+1;
					if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px;cursor:default;'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px;cursor:default;' >";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px;cursor:pointer;' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px;cursor:pointer;' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px;cursor:default;'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px;cursor:default;'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px;cursor:pointer;' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px;cursor:pointer;' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					echo "
						<table class='inicio' align='center'>
							<tr>
								<td colspan='20' class='titulos'>.: Resultados Busqueda:</td>
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
							<tr class='saludo3'>
								<td colspan='21'>Encontrados: $_POST[numtop]</td>
							</tr>
							<tr>
								<td class='titulos2' >N&deg;</td>
								<td class='titulos2' >Objeto</td>
								<td class='titulos2' >Contratista</td>
								<td class='titulos2' >Identificaci&oacute;n</td>
								<td class='titulos2' >Rubro presupuestal</td>
								<td class='titulos2' >Tipo de rubro</td>
								<td class='titulos2' >Modalidad de selecci&oacute;n</td>
								<td class='titulos2' >Procedimiento</td>
								<td class='titulos2' >Fecha Contrato</td>
								<td class='titulos2' >Fecha Inicio</td>
								<td class='titulos2' >Fecha Terminaci&oacute;n</td>
								<td class='titulos2' >Tiempo ejecuci&oacute;n (En dias)</td>
								<td class='titulos2' >Valor contrato</td>
								<td class='titulos2' >N&deg; CDP</td>
								<td class='titulos2' >Fecha CDP</td>
								<td class='titulos2' >Valor CDP</td>
								<td class='titulos2' >N&deg; RP</td>
								<td class='titulos2' >Fecha RP</td>
								<td class='titulos2' >Valor RP</td>
								<td class='titulos2' >Prorrogas</td>
								<td class='titulos2' >Adiciones</td>
							</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					while ($row =mysql_fetch_row($resp)) 
					{	
						$contratista=buscatercero($row[2]);
						/*$duraciones=explode('/', $row[3]);
						if ($duraciones[0]==""){$plazdi=0;}
						else{$plazdi=$duraciones[0];}
						if ($duraciones[1]==""){$plazme=0;}
						else{$plazme=$duraciones[1];}
						$plazo="";
						if($plazdi==0)
						{
							if($plazme==1){$plazo="$plazme Mes";}
							else {$plazo="$plazme Meses";}
						}
						elseif($plazme==0)
						{
							if($plazdi==1){$plazo="$plazdi día";}
							else {$plazo="$plazdi días";}
						}
						else
						{
							if($plazdi==1){$plazo="$plazdi día";}
							else {$plazo="$plazdi días";}
							if($plazme==1){$plazo="$plazo y $plazme Mes";}
							else {$plazo="$plazo y $plazme Meses";}
						}*/
						$sqlrm = "SELECT descripcion_valor FROM dominios WHERE valor_inicial='$row[4]' AND nombre_dominio='MODALIDAD_SELECCION' AND (valor_final is NULL or valor_final='')";
                     	$resm = mysql_query($sqlrm,$linkbd);
						$rowm = mysql_fetch_row($resm);
						$sqlrcl = "SELECT nombre FROM contraclasecontratos WHERE id='$row[5]'";
               			$rescl = mysql_query($sqlrcl,$linkbd);
                 		$rowcl = mysql_fetch_row($rescl);
						$sqlrn = "SELECT rubro FROM contrasoladquisicionesgastos WHERE codsolicitud='$row[11]'";
						$resn = mysql_query($sqlrn,$linkbd);
						$rown = mysql_fetch_row($resn);
						$sqlrs = "SELECT nombre,clasificacion,tipo FROM pptocuentas WHERE cuenta='$rown[0]'";
						$res = mysql_query($sqlrs,$linkbd);
						$rowi = mysql_fetch_row($res);
						$plazodias=calculaPlazoDias($row[0]);
						$sqlrcdp="select distinct * from pptocdp where pptocdp.vigencia='".$_POST[vigencias]."' and pptocdp.consvigencia='".$row[6]."' ";
						$rowcdp=mysql_fetch_row(mysql_query($sqlrcdp,$linkbd));
						$modfecha1=date("d-m-Y",strtotime($rowcdp[3]));
						$sqlrrp="select distinct * from pptorp where pptorp.vigencia='".$_POST[vigencias]."' and pptorp.consvigencia='".$row[7]."' ";
						$rowrp=mysql_fetch_row(mysql_query($sqlrrp,$linkbd));
						$rpfecha1=date("d-m-Y",strtotime($rowrp[4]));
						echo "
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\">	
								<td>$row[0]</td>
								<td>$row[1]</td>
								<td>$contratista</td>
								<td>$row[2]</td>
								<td>$rown[0]</td>
								<td>$rowi[1]</td>
								<td>$rowm[0]</td>
								<td>$rowcl[0]</td>
								<td>".date('d-m-Y',strtotime($row[8]))."</td>
								<td>".date('d-m-Y',strtotime($row[9]))."</td>
								<td>".date('d-m-Y',strtotime($row[10]))."</td>
								<td>$plazodias</td>
								<td>$row[12]</td>
								<td>$row[6]</td>
								<td>$modfecha1</td>
								<td>$rowcdp[4]</td>
								<td>$row[7]</td>
								<td>$rpfecha1</td>
								<td>$rowrp[6]</td>
								<td></td>
								<td></td>
							</tr>";
						 $con+=1;
						 $aux=$iter;
						 $iter=$iter2;
						 $iter2=$aux;
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
									<a>$imagensback</a>&nbsp;
									<a>$imagenback</a>&nbsp;&nbsp;";
						if($nuncilumnas<=9){$numfin=$nuncilumnas;}
						else{$numfin=9;}
						for($xx = 1; $xx <= $numfin; $xx++)
						{
							if($numcontrol<=9){$numx=$xx;}
							else{$numx=$xx+($numcontrol-9);}
							if($numcontrol==$numx){echo"<a onClick='saltocol(\"$numx\")'; style='color:#24D915;cursor:pointer;'> $numx </a>";}
							else {echo"<a onClick='saltocol(\"$numx\")'; style='color:#000000;cursor:pointer;'> $numx </a>";}
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