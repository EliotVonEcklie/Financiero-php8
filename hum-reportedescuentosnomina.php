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
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script>
			function pdf(varnom)
			{
				document.form2.numnomp.value=varnom;
				document.form2.action="hum-reportedescuentosnominapdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none;"></IFRAME>
		<span id="todastablas2"></span>
		<table>
            <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"></td>
       		</tr>	
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
            </IFRAME>
         </div>
        </div>
 		<form name="form2" id="form2" method="post" action="hum-reportenominaentidad.php">
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
            <table class="inicio">
                <tr>
                    <td class="titulos" colspan="6" >:. Buscar Nomina Liquidada</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
                </tr>
                <tr>
                    <td class="saludo1"style="width:2.5cm">No Nomina:</td>
                    <td ><input type="text" name="numero" id="numero" value="<?php echo $_POST[numero];?>" ></td>
                </tr>                       
            </table> 
            <input type="hidden" name="oculto" id="oculto" value="1"/>   
            <input type="hidden" name="numnomp" id="numnomp" value="<?php echo $_POST[numnomp];?>"/>
            <input type="hidden" name="desdel" id="desdel" value="<?php echo $_POST[desdel];?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      		<?php
				
			
				$crit1=" ";
				$crit2=" ";
				if ($_POST[numero]!="")
				$crit1="AND id_nom like '%$_POST[numero]%'";
				$sqlr="SELECT * FROM humnomina WHERE estado!='' $crit1";
				$resp = mysql_query($sqlr,$linkbd);
				$_POST[numtop]=mysql_num_rows($resp);
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				$sqlr="SELECT * FROM humnomina WHERE estado!='' $crit1 ORDER BY id_nom DESC LIMIT $_POST[numpos],$_POST[numres]";
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
						<td colspan='7' class='titulos'>.: REPORTE DESCUENTOS DE NOMINA.</td>
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
					<tr><td colspan='8'>Liquidaciones Encontradas: $_POST[numtop]</td></tr>
					<tr>
						<td class='titulos2' style='width:5%'>N&deg; Nomina</td>
						<td class='titulos2' style='width:8%'>Fecha</td>
						<td class='titulos2' style='width:15%'>Periodo</td>
						<td class='titulos2' style='width:10%'>Mes</td>
						<td class='titulos2'>Centro de Costo</td>
						<td class='titulos2' style='width:8%'>Vigencia</td>
						<td class='titulos2' style='width:4%'>Estado</td>
						<td class='titulos2' style='width:4%'>Ver</td>
					</tr>";	
				$iter='saludo1a';
				$iter2='saludo2';
				while ($row =mysql_fetch_row($resp)) 
				{
					$vcc="";
					$con2=$con+ $_POST[numpos];
					$sqlr2="select count(*) from humnomina_aprobado where estado='S' and id_nom='$row[0]' ";
					$resp2 = mysql_query($sqlr2,$linkbd);
					$row2 =mysql_fetch_row($resp2);
					$conc=$row2[0];
					$sqlrp="SELECT nombre FROM humperiodos WHERE id_periodo='$row[2]'";
					$rowp =mysql_fetch_row(mysql_query($sqlrp,$linkbd));
					$vmes=strtoupper(mesletras($row[3]));
					$sqlcc1="SELECT DISTINCT cc FROM humnomina_det WHERE estado='S' AND id_nom='$row[0]' ";
					$rescc1 =mysql_query($sqlcc1,$linkbd);
					while ($rowcc1 =mysql_fetch_row($rescc1)) 
					{
						$sqlcc2="SELECT nombre from centrocosto where id_cc='$rowcc1[0]' ORDER BY id_cc";
						$rowcc2 =mysql_fetch_row(mysql_query($sqlcc2,$linkbd));	
						if($vcc==''){$vcc="$rowcc1[0] - $rowcc2[0]";}
						else {$vcc=$vcc." <-> $rowcc1[0] - $rowcc2[0]";}
					}
					switch ($row[8]) 
					{
						case "P":	$imgsem="src='imagenes/sema_verdeON.jpg' title='Aprobada'";break;
						case "S":	$imgsem="src='imagenes/sema_amarilloON.jpg' title='Activa'";break;
						case "N":	$imgsem="src='imagenes/sema_rojoON.jpg' title='Anulada'";
					}
					$fechaul = new DateTime("$row[7]-$row[3]-01");
					$fechaul->modify('last day of this month');
					$ultfecha=$fechaul->format('d-m-Y');
					$varfecha="$row[7]-$row[3]-01";
					$pirfecha=date('d-m-Y',strtotime($varfecha));
					echo "
					<tr class='$iter'>
						<td>$row[0]</td>
						<td>".date('d-m-Y',strtotime($row[1]))."</td>
						<td> $pirfecha al $ultfecha</td>
						<td>$vmes</td>
						<td>$vcc</td>
						<td>$row[7]</td>
						<td style='text-align:center;'><img $imgsem style='width:18px'/></td>
						<td style='text-align:center;cursor:pointer;'><img src='imagenes/print.png' title='Imprimir' onClick=\"pdf('$row[0]')\" class='icoop'/> </td>
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
				echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
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