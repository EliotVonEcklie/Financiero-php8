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
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src="css/programas.js"></script>
        <script>
			function pdf()
			{
				document.form2.action="hum-pdfreptercerosnomina.php";
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
			function detallesfuncionario(id, nomdoc)
			{
				if($('#detalle'+id).css('display')=='none')
				{
					$('#detalle'+id).css('display','block');
					$('#img'+id).attr('src','imagenes/minus.gif');
				}
				else
				{
					$('#detalle'+id).css('display','none');
					$('#img'+id).attr('src','imagenes/plus.gif');
				}
				var toLoad= 'hum-detreptercerosnomina.php';
				$.post(toLoad,{nomdoc:nomdoc},function (data){
					$('#detalle'+id).html(data.detalle);
					return false;
				},'json');
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
  				<td colspan="3" class="cinta"><a class="mgbt1"><img src="imagenes/add2.png"/></a><a class="mgbt1"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a><a onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a class="mgbt" onClick="pdf();" ><img src="imagenes/print.png" title="Imprimir" style="width:29px; height:25px;"></a></td>
          	</tr>	
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="hum-reptercerosnomina.php">
        	<table  class="inicio">
      			<tr>
        			<td class="titulos" colspan="6">:. Información General Funcionarios Nomina</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='hum-principal.php'">&nbsp;Cerrar</a></td>
           		<tr>
                	<td class="saludo1" style="width:3.5cm;">Documento o Nombre:</td>
    				<td style="width:25%">
                    	<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:100%;"/>
                    </td>
         			 <td class="saludo1" style="width:2cm">Dependencia:</td>
                    <td>
                    	<select name="dependencias" id="dependencias" onKeyUp="return tabular(event,this)" style="text-transform:uppercase">
                        	<option value="" <?php if($_POST[dependencias]=='') {echo "SELECTED";}?>>- Todas</option>
          					<?php
								$sqlr="SELECT * FROM planacareas WHERE estado='S'";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if("$row[0]"==$_POST[dependencias]){echo "<option value='$row[0]' SELECTED>- $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>- $row[1]</option>";}	  
                                }
							?>
        				</select>&nbsp;&nbsp; 
                        <input type="button" name="bboton" onClick="document.form2.submit();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
        		</tr>
           	</table>
            <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
            	<?php
					$crit1="";
					if ($_POST[nombre]!="")
					{
						$crit1="AND concat_ws(' ', TB2.nombre1, TB2.nombre2, TB2.apellido1, TB2.apellido2, TB2.razonsocial, TB2.cedulanit) LIKE '%$_POST[nombre]%'";
					}
					if($_POST[dependencias]!='')
					{
						$sqlr="SELECT concat_ws(' ', TB2.apellido1, TB2.apellido2, TB2.nombre1, TB2.nombre2, TB2.razonsocial), TB1.* FROM terceros_nomina TB1, terceros TB2, planestructura_terceros TB3, planaccargos TB4, planacareas TB5 WHERE TB1.estado='S' AND TB1.cedulanit=TB2.cedulanit $crit1 AND TB3.cedulanit=TB1.cedulanit AND TB3.codcargo=TB4.codcargo AND TB4.dependencia=TB5.codarea AND TB5.codarea='$_POST[dependencias]' ORDER BY TB2.apellido1,TB2.apellido2,TB2.nombre1,TB2.nombre2, TB2.razonsocial";
					}
					else
					{
						$sqlr="SELECT concat_ws(' ', TB2.apellido1, TB2.apellido2, TB2.nombre1, TB2.nombre2, TB2.razonsocial), TB1.* FROM terceros_nomina TB1, terceros TB2 WHERE TB1.estado='S' AND TB1.cedulanit=TB2.cedulanit $crit1 ORDER BY TB2.apellido1,TB2.apellido2,TB2.nombre1,TB2.nombre2, TB2.razonsocial";
					}
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					echo "
					<table class='inicio'>
						<tr>
							<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
						</tr>
						<tr>
							<td colspan='8'>Funcionarios: $ntr</td>
						</tr>
						<tr>
							<td class='titulos2'><img src='imagenes/plus.gif'></td>
							<td class='titulos2' style='width:3%'>ITEM</td>
							<td class='titulos2' style='text-align:center;'>FUNCIONARIO</td>
							<td class='titulos2' style='text-align:center;width:16%;'>NIVEL</td>
							<td class='titulos2' style='text-align:center;width:16%;'>EPS</td>
							<td class='titulos2' style='text-align:center;width:16%;'>ARP</td>
							<td class='titulos2' style='text-align:center;width:16%;'>AFP</td>
							<td class='titulos2' style='text-align:center;width:16%;'>FONDO CESANTIAS</td>
						</tr>";	
					$iter='saludo1b';
					$iter2='saludo2b';
					$cont=1;
					while ($row = mysql_fetch_row($resp)) 
					{
						$nomeps=buscatercero($row[4]);if($nomeps==""){$nomeps="No Disponible";}
						$nomarp=buscatercero($row[5]);if($nomarp==""){$nomarp="No Disponible";}
						$nomafp=buscatercero($row[6]);if($nomafp==""){$nomafp="No Disponible";}
						$nomfce=buscatercero($row[7]);if($nomfce==""){$nomfce="No Disponible";}
						$sqlrns="SELECT nombre FROM humnivelsalarial WHERE id_nivel='$row[8]'";
						$rowns =mysql_fetch_row(mysql_query($sqlrns,$linkbd));
						if ("$rowns[0]"!=""){$nomniv=$rowns[0];}
						else {$nomniv="No Disponible";}
						echo"
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
							<td class='titulos2'>
								<a onClick='detallesfuncionario($cont, $row[1])' style='cursor:pointer;'>
									<img id='img$cont' src='imagenes/plus.gif'>
								</a>
							</td>
							<td>$cont</td>
							<td style='padding-left:5px;padding-right:5px;'>$row[0]</td>
							<td style='text-align:justify;padding-left:5px;padding-right:5px;'>$nomniv</td>
							<td style='text-align:justify;padding-left:5px;padding-right:5px;'>$nomeps</td>
							<td style='text-align:justify;padding-left:5px;padding-right:5px;'>$nomarp</td>
							<td style='text-align:justify;padding-left:5px;padding-right:5px;'>$nomafp</td>
							<td style='text-align:justify;padding-left:5px;padding-right:5px;'>$nomfce</td>
						</tr>
						<tr>
							<td align='center'></td>
							<td colspan='6'>
								<div id='detalle$cont' style='display:none'></div>
							</td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$cont++;
					}
					if ($ntr==0)
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda $tibusqueda<img src='imagenes\alert.png' style='width:25px'></td>
							</tr>
						</table>";
					}
				?>
            </div>
        </form>
	</body>
</html>