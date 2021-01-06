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
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.getElementById('oculto').value='3';
						document.form2.submit();
						break;
				}
			}
			function fundeshacer(coddes)
			{
				document.getElementById('descod').value=coddes;
				despliegamodalm('visible','4','Esta Seguro de Deshacer la aprobación de la nomina N°:'+coddes,'1');
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
  				<td colspan="3" class="cinta"><a onClick="location.href='hum-liquidarnominaaprobar.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a class="mgbt"><img src="imagenes/guardad.png" title="Guardar" /></a><a onClick="location.href='hum-buscanominasaprobadas.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
    		</tr>	
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" action="hum-buscanominasaprobadas.php">
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
			<table  class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="6">:. Buscar Nominas Aprobadas</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='hum-principal.php'">&nbsp;Cerrar</a></td>
     			</tr>
      			<tr>
        			<td class="saludo1" style="width:10%" >No Nomina:</td>
        			<td style="width:15%;"><input type="search" name="numero" id="numero" value="<?php $_POST[numero];?>" style="width:90%"/></td>
         			<td class="saludo1">Mes: </td>
    				<td>
                    	<input type="search" name="nombre" value="<?php $_POST[nombre];?>"/>
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>  
        		</tr>                       
    		</table>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <input type="hidden" name="descod" id="descod" value="<?php echo $_POST[descod];?>"/>
            <input type="hidden" name="oculto" id="oculto"  value="1">  	 
 			<div class="subpantallac5" style="height:68.5%; width:99.6%;overflow-x:hidden">
      			<?php
					if($_POST[oculto]=="3")
					{
						$sqlr ="DELETE FROM humnomina_aprobado WHERE id_nom='$_POST[descod]'";
						mysql_query($sqlr,$linkbd);
						$sqlr ="DELETE FROM pptocomprobante_cab WHERE numerotipo='$_POST[descod]' AND tipo_comp='9'";
						mysql_query($sqlr,$linkbd);
						$sqlr ="DELETE FROM pptocomprobante_det WHERE numerotipo='$_POST[descod]' AND tipo_comp='9'";
						mysql_query($sqlr,$linkbd);
						$sqlr="UPDATE humnomina SET estado='S' WHERE id_nom='$_POST[descod]'"; 
	 					mysql_query($sqlr,$linkbd);
						$sqlr="UPDATE humnom_presupuestal SET estado='S' WHERE id_nom='$_POST[descod]'";
	 					mysql_query($sqlr,$linkbd);
						$sqlr ="DELETE FROM comprobante_cab WHERE numerotipo='$_POST[descod]' AND tipo_comp='4'";
						mysql_query($sqlr,$linkbd);
						$sqlr ="DELETE FROM comprobante_det WHERE numerotipo='$_POST[descod]' AND tipo_comp='4'";
						mysql_query($sqlr,$linkbd);
						echo"<script>despliegamodalm('visible','3','Se Deshizo la aprobación de la nomina N°:$_POST[descod]');</script>";
					}
					$crit1=" ";
					$crit2=" ";
					if ($_POST[numero]!=""){$crit1="and humnomina.id_nom like '%$_POST[numero]%'";}
					if ($_POST[nombre]!=""){$crit2="and humnomina.mes like '%$_POST[nombre]%' ";}
					$sqlr="select humnomina.id_nom, humnomina_aprobado.id_aprob, humnomina.fecha, humnomina.fecha, humnomina_aprobado.id_rp, humnomina.mes, humnomina.vigencia, humnomina_aprobado.estado from humnomina,humnomina_aprobado where humnomina.id_nom=humnomina_aprobado.id_nom and  humnomina_aprobado.estado='S' $crit1 $crit2";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="select humnomina.id_nom, humnomina_aprobado.id_aprob, humnomina.fecha, humnomina.fecha, humnomina_aprobado.id_rp, humnomina.mes, humnomina.vigencia, humnomina_aprobado.estado from humnomina,humnomina_aprobado where humnomina.id_nom=humnomina_aprobado.id_nom and  humnomina_aprobado.estado='S' $crit1 $crit2 order by humnomina.id_nom LIMIT $_POST[numpos],$_POST[numres]";
					$resp = mysql_query($sqlr,$linkbd);
					$con=1;
					$numcontrol=$_POST[nummul]+1;
					if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
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
					<table class='inicio' align='center'>
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
						<tr><td colspan='11'>Nominas Encontradas: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2'>No Liquid</td>
							<td class='titulos2'>No Aprobacion</td>
							<td class='titulos2'>Fecha Liquid</td>
							<td class='titulos2'>Fecha Aprob</td>
							<td class='titulos2'>RP</td>
							<td class='titulos2' style='text-align:center;'>Mes</td>
							<td class='titulos2' style='text-align:center;'>Vigencia</td>
							<td class='titulos2' style='text-align:center; width:5%;'>Estado</td>
							<td class='titulos2' style='text-align:center; width:5%;'>Deshacer</td>
							<td class='titulos2' style='text-align:center; width:5%;'>Anular</td>
							<td class='titulos2' style='text-align:center; width:5%;'>Ver</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					while ($row =mysql_fetch_row($resp)) 
 					{
						$sqlreg="SELECT id_egreso FROM tesoegresosnomina WHERE id_orden='$row[0]' AND estado='S'";
						$respeg = mysql_query($sqlreg,$linkbd);
						$numegr=mysql_num_rows($respeg);
						
						if ($numegr==0)
						{ 
							$fundes="fundeshacer(\"$row[0]\");";
							$imgdes="flechades.png";
							$imgsem="sema_amarilloON.jpg";
							$titsem="Sin Orden de Pago";
						}
						else
						{
							$imgdes="flechadesd.png";
							if($row[7]=='S')
							{
								$imgsem="sema_verdeON.jpg";
								$titsem="Con Orden de Pago";
							}
						}
						echo "
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
							<td>$row[0]</td>
							<td>$row[1]</td>
							<td>$row[2]</td>
							<td>$row[3]</td>
							<td>$row[4]</td>
							<td>$row[5]</td>
							<td>$row[6]</td>
							<td style='text-align:center;'><img src='imagenes/$imgsem' style='width:19px; cursor:pointer' title='$titsem'></td>	
							<td style='text-align:center;'><img src='imagenes/$imgdes' style='width:19px; cursor:pointer' onClick='$fundes'></td>
							<td style='text-align:center;'><img src='imagenes/anular.png'></td>
							<td style='text-align:center;'><img src='imagenes/lupa02.png' style='width:19px; cursor:pointer' onClick=\"location.href='hum-nominasaprover.php?idr=$row[0]'\"/></td>
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
						if($numcontrol==$numx){echo"<a  onClick='saltocol(\"$numx\")'; style='color:#24D915;cursor:pointer;'> $numx </a>";}
						else {echo"<a onClick='saltocol(\"$numx\")'; style='color:#000000;cursor:pointer;'> $numx </a>";}
					}
					echo"			&nbsp;&nbsp;<a>$imagenforward</a>
									&nbsp;<a>$imagensforward</a>
								</td>
							</tr>
						</table>";
			
				?>
    		</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
 		</form>
	</body>
</html>