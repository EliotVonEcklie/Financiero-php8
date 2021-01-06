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
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function despliegamodalm(_valor,_tip,mensa,pregunta, variable)
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
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();
								break;
				}
			}
			function funcionmensaje(){}
			function despliegamodal2(_valor,_pag)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_pag=="1"){document.getElementById('ventana2').src="inve-kardex-articulos.php";}
			}
			function validar()
			{
				document.getElementById('oculto').value="2";
				document.getElementById('form2').submit();
			}
			function busarticulo()
			{
				if(document.getElementById('articulo').value!="")
				{
					document.getElementById('oculto').value="3";
					document.getElementById('form2').submit();
				}
			}
			function pdf()
			{
				document.form2.action="inve-pdfkardex.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php titlepag();$vtipo='AE';?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("inve");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a onClick="location.href='inve-kardex.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt1"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a><a onClick="<?php echo paginasnuevas("inve");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a class="mgbt" onClick="pdf();" ><img src="imagenes/print.png" title="Imprimir" style="width:29px; height:25px;"></a></td>
        	</tr>	
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		  
 		<form name="form2" id="form2" method="post" action="inve-kardex.php">
			<table  class="inicio" style="width:99.7%" >
      			<tr>
        			<td class="titulos" colspan="7">:: Kardex Almacen</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='inve-principal.php'">Cerrar</a></td>
     			</tr>
      			<tr>
                	<td class="saludo1" style="width:2.5cm">Fecha Inicial:</td>
					 <td style="width:12%"><input type="text" name="fechain" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fechain]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:75%;"/>&nbsp;<img src="imagenes/calendario04.png"  onClick="displayCalendarFor('fc_1198971545');" title="Calendario" class="icoop"/></td>
                    <td class="saludo1" style="width:2.5cm">Fecha Final:</td>
					<td style="width:12%"><input type="text" name="fechafi" id="fc_1198971546" title="DD/MM/YYYY" value="<?php echo $_POST[fechafi]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:75%;">&nbsp;<img src="imagenes/calendario04.png"  onClick="displayCalendarFor('fc_1198971546');" title="Calendario" class="icoop"></td>
			    	<td class="saludo1" style="width:2.5cm">.: Art&iacuteculo:</td>
                    <td style="width:12%;"><input type="text" name="articulo" id="articulo" value="<?php echo $_POST[articulo]?>" onBlur="busarticulo();" style="width:80%"/>&nbsp;<a onClick="despliegamodal2('visible','1');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;" title="Lista Art&iacute;culos"/></a></td>
                    <td ><input type="text" name="narticulo" id="narticulo" value="<?php echo $_POST[narticulo]?>" style="width:90%;text-transform:uppercase" readonly/>&nbsp;&nbsp;<img src="imagenes/eraser.png" style="width:20px; cursor:pointer;" title="Borrar Art&iacute;culo" onClick="document.getElementById('articulo').value='';document.getElementById('narticulo').value='';"/></td>
       			</tr>                       
      			<tr>
                	<td class="saludo1">Bodega:</td>
        			<td colspan="2">
		                <select name="bodega" id="bodega" onChange="document.form2.submit();">
							<option value="-1">Seleccione ....</option>
							<?php
								$sqlr="Select * from almbodegas where estado='S' ORDER BY id_cc";
								$resp = mysql_query($sqlr,$linkbd);
								while($row =mysql_fetch_row($resp)) 
								{
									if("$row[0]"==$_POST[bodega])
									{
										echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										$_POST[bodega]=$row[0];$_POST[nbodegas]=$row[1];
									}
									else{echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	  
								}   
							?>
        		        </select>
                        <input type="hidden" name="nbodegas" id="nbodegas" value="<?php echo $_POST[nbodegas];?>"/>
                    </td>
                    <td><input type="button" name="buscarb" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" onClick="validar();" /></td>                    <td colspan="3"></td>              	
              	</tr>
    		</table>   
     		<input type="hidden" name="oculto" id="oculto" value="1"/>
     		<div class="subpantalla" style="height:65%; width:99.5%;overflow-x:hidden;">
            	<?php
				if($_POST[oculto]=="3")
				{
					$sqlr="SELECT nombre FROM almarticulos WHERE estado='S' AND concat_ws('', grupoinven, codigo) LIKE '$_POST[articulo]'";
					$resp=mysql_query($sqlr,$linkbd);
					$numres=mysql_num_rows($resp);
					$row=mysql_fetch_row($resp);
					if($numres==0)
					{
						echo "<script>despliegamodalm('visible','2','No existe un Art�culo con el c�digo: $_POST[articulo]');</script>";
					}
					else
					{
						echo "<script>document.getElementById('narticulo').value='$row[0]';</script>";
					}
					
				}
				if($_POST[oculto]=="2")
				{
					$crit1="";
					$crit2="";
					$fecha1=explode("/",$_POST[fechain]);
					$fecha2=explode("/",$_POST[fechafi]);
					$fecha1g=gregoriantojd($fecha1[1],$fecha1[0],$fecha1[2]);
					$fecha2g=gregoriantojd($fecha2[1],$fecha2[0],$fecha2[2]);
					{
						if($_POST[narticulo]!=""){$crit1=" AND CONCAT(T1.grupoinven,T1.codigo) = '$_POST[articulo]'";}
						if($_POST[bodega]!="-1")
						{
							if($_POST[narticulo]!=""){$crit2=" AND T2.bodega = '$_POST[bodega]' ";}
							else {$crit2="AND T2.bodega = '$_POST[bodega]' ";}
						}
						$sqlr="SELECT T1.grupoinven,T1.codigo,T1.nombre FROM almarticulos T1 INNER JOIN (almginventario_det T2 INNER JOIN almginventario T3 ON CONCAT(T2.codigo,T2.tipomov)=CONCAT(T3.consec,T3.tipomov)) ON CONCAT(T1.grupoinven,T1.codigo)=T2.codart where T3.estado='S' $crit1 $crit2 GROUP BY T1.grupoinven, T1.codigo, T1.nombre ORDER BY T1.grupoinven ASC, T1.codigo ASC ";
						//echo $sqlr;
						$resp = mysql_query($sqlr,$linkbd);
						while($row =mysql_fetch_row($resp))
						{
							echo"<table class='inicio' style='text-align:center;'>
								<tr class='tkardes01'>
									<td colspan='3'>
										Articulo: ".ucwords(strtolower($row[2]))."<br>C&oacute;digo:&nbsp;&nbsp;$row[0]$row[1]
									</td>
									<td colspan='4' style='text-align:center;'>Entradas</td>
									<td colspan='4' style='text-align:center;'>Salidas</td>
									<td colspan='4' style='text-align:center;'>Saldo</td>
								</tr>
								<tr>
									<td class='titulos2' style='width:6%'>Fecha</td>
									<td class='titulos2' style='width:5%'>Documento<br>Soporte</td>
									<td class='titulos2' style='width:5%'>Movimiento</td>
									<td class='titulos2' style='width:5.5%'>Cantidad</td>
									<td class='titulos2' style='width:5%'>Unidad de Medida</td>
									<td class='titulos2' style='width:8%'>Valor Unitario</td>
									<td class='titulos2' style='width:9.5%'>Costo Total</td>
									<td class='titulos2' style='width:5.5%'>Cantidad</td>
									<td class='titulos2' style='width:5%'>Unidad de Medida</td>
									<td class='titulos2' style='width:8%'>Valor Unitario</td>
									<td class='titulos2' style='width:9.5%'>Costo Total</td>
									<td class='titulos2' style='width:5.5%'>Cantidad</td>
									<td class='titulos2' style='width:5%'>Unidad de Medida</td>
									<td class='titulos2' style='width:8%'>Valor Unitario</td>
									<td class='titulos2' >Costo Total</td>
								</tr>";
								//BUSCAR KARDEX
								$sqlkar="SELECT DISTINCT T1.cantidad_entrada,T1.cantidad_salida,T1.tipomov,T1.tiporeg,T4.fecha,T1.codigo,T1.unidad,T1.valorunit FROM almginventario T4,almginventario_det T1 INNER JOIN almtipomov T3 ON CONCAT(T1.tipomov,T1.tiporeg)=CONCAT(T3.tipom,T3.codigo) WHERE T1.codart='$row[0]$row[1]' AND CONCAT(T1.tipomov,T1.tiporeg,T1.codigo)=CONCAT(T4.tipomov,T4.tiporeg,T4.consec) ORDER BY T4.fecha,T1.codigo";
								//echo $sqlkar;
								$reskar=mysql_query($sqlkar,$linkbd);
								$sumarent=0;
								$sumarsal=0;
								$canbod=0;
								$cansal=0;
								$totalcantidad=$totalcosto=$valunitariopro=0;
								$iter1='saludo1c';
								$iter2='saludo2c';
								while($rowkar=mysql_fetch_array($reskar))
								{
									$fecha3=explode("-",date('d-m-Y',strtotime($rowkar[4])));
									$fecha3g=gregoriantojd($fecha3[1],$fecha3[0],$fecha3[2]);
									switch($rowkar[2])
									{
										case '1':
										case '4':
										{
											$totalcantidad+=$rowkar[0];
											$total = $rowkar[0]*$rowkar[7];
											$totalcosto+=$total;
											$valunitariopro=$totalcosto/$totalcantidad;
											if((($fecha1g <= $fecha3g) && ($fecha3g <= $fecha2g))|| ($fecha1g==$fecha2g))
											{
												$sqlrtmv="SELECT nombre FROM almtipomov WHERE concat_ws('', tipom,codigo)='$wkar[3]$wkar[4]'";
												$rowtmv =mysql_fetch_row(mysql_query($sqlrtmv,$linkbd));
												echo"
												<tr class='$iter1'>
													<td style='text-align:center;'>".date('d-m-Y',strtotime($rowkar[4]))."</td>
													<td style='text-align:center;'>$rowkar[5]</td>
													<td style='text-align:center;' title='$rowtmv[0]'>$rowkar[2]$rowkar[3]</td>
													<td style='text-align:center;'>$rowkar[0]</td>
													<td style='text-align:center;'>$rowkar[6]</td>
													<td style='text-align:right;'>$".number_format($rowkar[7],2,',','.')."</td>
													<td style='text-align:right;'>$".number_format($total,2,',','.')."</td>
													<td style='text-align:center;'>-</td>
													<td style='text-align:center;'>-</td>
													<td style='text-align:right;'>$".number_format(0,2,',','.')."</td>
													<td style='text-align:right;'>$".number_format(0,2,',','.')."</td>
													<td style='text-align:center;'>$totalcantidad</td>
													<td style='text-align:center;'>$rowkar[6]</td>
													<td style='text-align:right;'>$".number_format($valunitariopro,2,',','.')."</td>
													<td style='text-align:right;'>$".number_format($totalcosto,2,',','.')."</td>
												</tr>";
											}
										}break;
										case '2':
										case '3':
										{
											$totalcantidad-=$rowkar[1];
											$total = $rowkar[1]*$rowkar[7];
											//$totalcosto+=$total;
											$totalcosto=$totalcosto-$total;
											$valunitariopro=$totalcosto/$totalcantidad;
											if((($fecha1g <= $fecha3g) && ($fecha3g <= $fecha2g))|| ($fecha1g==$fecha2g))
											{
												$sqlrtmv="SELECT nombre FROM almtipomov WHERE concat_ws('', tipom,codigo)='$rowkar[3]$rowkar[4]'";
												$rowtmv =mysql_fetch_row(mysql_query($sqlrtmv,$linkbd));
												echo"
												<tr class='$iter1'>
													<td style='text-align:center;'>".date('d-m-Y',strtotime($rowkar[4]))."</td>
													<td style='text-align:center;'>$rowkar[5]</td>
													<td style='text-align:center;' title='$rowtmv[0]'>$rowkar[2]$rowkar[3]</td>
													<td style='text-align:center;'>-</td>
													<td style='text-align:center;'>-</td>
													<td style='text-align:right;'>$".number_format(0,2,',','.')."</td>
													<td style='text-align:right;'>$".number_format(0,2,',','.')."</td>
													<td style='text-align:center;'>$rowkar[1]</td>
													<td style='text-align:center;'>$rowkar[6]</td>
													<td style='text-align:right;'>$".number_format($rowkar[7],2,',','.')."</td>
													<td style='text-align:right;'>$".number_format($total,2,',','.')."</td>
													<td style='text-align:center;'>$totalcantidad</td>
													<td style='text-align:center;'>$rowkar[6]</td>
													<td style='text-align:right;'>$".number_format($valunitariopro,2,',','.')."</td>
													<td style='text-align:right;'>$".number_format($totalcosto,2,',','.')."</td>
												</tr>";
											
											}
										}break;
									}
									$aux=$iter1;
									$iter1=$iter2;
									$iter2=$aux;
								}
								echo"
									<tr>
										<td colspan='11' style='text-align:right;'>Cantidad en Bodega:</td>
										<td style='text-align:left;'>&nbsp;&nbsp;$totalcantidad</td>
										<td style='text-align:right;'>Valor:</td>
										<td colspan='2' style='text-align:left;'>&nbsp;&nbsp;$".number_format($totalcosto,2,',','.')."</td>
									</tr>
								</table>";
						}
					}
					//else {echo "<script>despliegamodalm('visible','2','Ingrese el Rango de Fechas para Su Busqueda');</script>";}
				}
				?>
			</div>
			<div id="bgventanamodal2">
    			<div id="ventanamodal2">
		        	<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
        		    </IFRAME>
				</div>
			</div>
		</form>
	</body>
</html>