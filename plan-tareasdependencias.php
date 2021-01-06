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
		<title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
        <script>
			function pdf()
			{
				document.form2.action="plan-pdfreportetareasdep.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
					}
				}
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
  				<td colspan="3" class="cinta"><a class="mgbt1"><img src="imagenes/add2.png"/></a><a class="mgbt1"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a><a onClick="<?php echo paginasnuevas("plan");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a class="mgbt" onClick="pdf();" ><img src="imagenes/print.png" title="Imprimir" style="width:29px; height:25px;"></a></td>
          	</tr>	
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="plan-tareasdependencias.php">
        	<table  class="inicio">
      			<tr>
        			<td class="titulos" colspan="6">:. Tareas programadas por Dependencias</td>
        			<td class="cerrar" style="width:7%;" ><a href="plan-principal.php">&nbsp;Cerrar</a></td>
           		<tr>
                	<td class="saludo1" style="width:2.5cm;">Fecha Inicial: </td>
                    <td style="width:10%;">
                    	<input type="date" name="fechaini" id="fechaini" value="<?php echo $_POST[fechaini];?>" style="width:100%;"/>
                    </td>
                    <td class="saludo1" style="width:2.5cm;">Fecha Final:</td>
                    <td style="width:10%;">
                    	<input type="date" name="fechafin" id="fechafin" value="<?php echo $_POST[fechafin];?>" style="width:100%;"/>
                    </td>
         			<td class="saludo1" style="width:2cm;">Dependencia:</td>
    				<td >
                    	<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:50%;"/>&nbsp;&nbsp; 
                        <input type="button" name="bboton" onClick="document.form2.submit();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
        		</tr>
           	</table>
            <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
            	<?php
					$crit1="";
					$crit2="";
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
						else {
							$crit2=" AND TB3.fechar BETWEEN CAST('$_POST[fechaini]' AS DATE) AND CAST('$_POST[fechafin]' AS DATE)";
						}
					}
					if ($_POST[nombre]!=""){$crit1="AND nombrearea like '%$_POST[nombre]%'";}
					$sqlr="SELECT * FROM planacareas WHERE estado='S' $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					echo "
					<table class='inicio' align='center' >
						<tr>
							<td colspan='6' class='titulos'>.: Resultados Busqueda:</td>
						</tr>
						<tr>
							<td colspan='2'>Dependencias Consultadas: $ntr</td>
						</tr>
						<tr>
							<td class='titulos2' rowspan='2' style='width:6%'>Item</td>
							<td class='titulos2' rowspan='2'>Dependencia</td>
							<td class='titulos2' colspan='4' style='text-align:center;'>Tareas</td>
							</tr>
						<tr>
							<td class='titulos2' style='width:8%;text-align:center;'>Total</td>
							<td class='titulos2' style='width:8%;text-align:center;'>Contestadas</td>
							<td class='titulos2' style='width:8%;text-align:center;'>Pendientes</td>
							<td class='titulos2'style='width:8%;text-align:center;'>Vencidas</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$conit=0;	
					while ($row = mysql_fetch_row($resp)) 
					{
						$sqlr2="SELECT TB1.estado, TB1.fechares, TB3.fechalimite FROM planacresponsables TB1,  planaccargos TB2, planacradicacion TB3 WHERE (TB1.estado='AC' OR TB1.estado='AN') AND TB2.codcargo=TB1.codcargo AND TB2.dependencia='$row[0]' AND TB3.numeror=TB1.codradicacion AND TB3.tipot='0' $crit2";
						$resp2 = mysql_query($sqlr2,$linkbd);
						$cont1=0; //contestadas
						$cont2=0; //sin contestar
						$cont3=0; //Vencidas
						$cont4=0; //total
						$conit++;
						$imgver="src='imagenes/ver.png' title='Ver'";//Imgen Lupa
						$fechahoy= explode("-",date("d-m-Y")); 
						while ($row2 = mysql_fetch_row($resp2)) 
						{	
							$cont4++;
							$fechares=explode("-",date('d-m-Y',strtotime($row2[1])));
							$fechalim=explode("-",date('d-m-Y',strtotime($row2[2])));
							if ($row2[0]=='AC')
							{
								$cont1++;
								if(gregoriantojd($fechalim[1],$fechalim[0],$fechalim[2])<= gregoriantojd($fechares[1],$fechares[0],$fechahoy[2]))
								{$cont3++;}
							}
							if ($row2[0]=='AN')
							{
								$cont2++;
								if(gregoriantojd($fechalim[1],$fechalim[0],$fechalim[2])<= gregoriantojd($fechahoy[1],$fechahoy[0],$fechahoy[2]))
								{$cont3++;}
							}
						}
						if($row[0] == $_GET[dependencia]){
						//background-color: yellow;
							echo "<tr class='' style='background-color: yellow;' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >";

							
						}else{
							echo 
							"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >";
						}
						echo"
							<td>$conit</td>
							<td>$row[1]</td>
							<td style='text-align:center;' onMouseOver=\"this.style.cursor='pointer';anterior=this.style.backgroundColor; this.style.backgroundColor='yellow';\" onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"location.href='plan-tareasdependenciareporte.php.php?dependencia=$row[0]&estado=total'\">
								$cont4
							</td>
							<td style='text-align:center;' onMouseOver=\"this.style.cursor='pointer';anterior=this.style.backgroundColor; this.style.backgroundColor='yellow';\" onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"location.href='plan-tareasdependenciareporte.php.php?dependencia=$row[0]&estado=AC'\">
								$cont1
							</td>
							<td style='text-align:center;' onMouseOver=\"this.style.cursor='pointer';anterior=this.style.backgroundColor; this.style.backgroundColor='yellow';\" onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"location.href='plan-tareasdependenciareporte.php.php?dependencia=$row[0]&estado=AN'\">
								$cont2
							</td>
							<td style='text-align:center;' onMouseOver=\"this.style.cursor='pointer';anterior=this.style.backgroundColor; this.style.backgroundColor='yellow';\" onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"location.href='plan-tareasdependenciareporte.php.php?dependencia=$row[0]&estado=V'\">
								$cont3
							</td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
					}
					echo"</table>";					
					
				?>
            </div>
        </form>
	</body>
</html>