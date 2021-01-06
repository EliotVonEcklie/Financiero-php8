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
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>::SPID - Almacen</title>
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="funcioneshf.js"></script>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script>
			$(window).load(function () {
				$('#cargando').hide();
			});
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
						case "5":
							document.getElementById('ventanam').src="ventana-comentarios.php?infor="+mensa+"&bas=fulanita";break;	
					}
				}
			}
            function crearexcel()
			{
				document.form2.action="inve-saldoinvexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function respuestaconsulta(pregunta){
				switch(pregunta){
					case "1"://Eliminar Archivo Adjunto de la lista
						document.form2.oculto.value=2;
						document.form2.submit();
						break;
				}
			}

//************* guardar ************
			function funcionmensaje(){document.location.href = "inve-fisicoedita.php?is="+codfis;}
			function validar(){
				document.getElementById('oculto').value="2";
				document.getElementById('form2').submit();
			}
		</script>
        <?php
			titlepag();
		?>
	</head>
	<body>
		
  		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
		    <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
		    <tr><?php menu_desplegable("inve");?></tr>
          	<tr>
          		<td colspan="3" class="cinta"><img src="imagenes/add2.png" title="Nuevo" class="mgbt"/><img src="imagenes/guardad.png" title="Guardar" class="mgbt" /><img src="imagenes/buscad.png" title="Buscar" class="mgbt" /><a href="#" class="mgbt" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a class="mgbt" target="_blank"><img src="imagenes/print.png"></a><a class="mgbt"><img src="imagenes/excel.png" title="Excell" onclick="crearexcel()" class="mgbt"></a></td>
        	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" id="form2" method="post" enctype="multipart/form-data">
			<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
				<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
			</div>
			<table  class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="5">.: Saldo Inventario</td>
        			<td class="cerrar" style="width:7%;"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
     			</tr>
      			<tr>
                	<td class="saludo1" style="width:10%">Grupo Inventario:</td>
        			<td style="width:15%">
		                <select name="grupoinv" id="grupoinv">
							<option value="-1">Seleccione ....</option>
							<?php
						 	$sqlr="Select * from almgrupoinv where estado='S' ORDER BY codigo";
							$resp = mysql_query($sqlr,$linkbd);
							while($row =mysql_fetch_row($resp)) {
								$i=$row[0];
								echo "<option value=$row[0] ";
								if($i==$_POST[grupoinv]){
			 						echo "SELECTED";
			 						$_POST[grupoinv]=$row[0];
				 				}
								echo " >".$row[0]." - ".$row[1]."</option>";	  
		     				}   
							?>
        		        </select>
                    </td>
                    <td><input type="button" name="buscarb" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" onClick="validar();" /></td>      
					<td class="tamano03">
						<input type="checkbox" name="todos" id="todos" class="defaultcheckbox"  <?php if(!empty($_POST[todos])){echo "CHECKED"; }?>/>Todos
					</td>
			</tr>
    		</table>   
           	<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]?>" > 
			<table class="inicio">
				<tr>
					<td class="titulos" style="width:93%">:.Saldo Inventario</td>
                    <td class="cerrar" style="width:7%"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
            	</tr>
			</table>
				<div class="subpantalla" style="height:62%; width:99.6%; overflow-x:hidden;">
                    	<table class='inicio' width="100%">
                        	<tr>
								<td class="titulos2">Codigo sUNSPSC</td>
							    <td class="titulos2">Codigo Articulo</td>
						    	<td class="titulos2">Nombre Articulo</td>
								<td class="titulos2">Unidad de Medida</td>
								<td class="titulos2">Bodega</td>
								<td class="titulos2">Existencia</td>
                           	</tr>
                            <?php
							$crit1="";
							$crit2="";
							$co='saludo1a';
 							$co2='saludo2';
							if($_POST[grupoinv]!="-1")
								$crit1=" AND grupoinven = '$_POST[grupoinv]' ";
							if($_POST[bodega]!="-1")
								$crit2="almarticulos_exis.bodega = '$_POST[bodega]' AND";
							$sqlr="SELECT * FROM almarticulos WHERE estado='S' $crit1  ORDER BY length(grupoinven),grupoinven ASC, length(codigo),codigo ASC";
							$resp=mysql_query($sqlr,$linkbd);
							while($row=mysql_fetch_row($resp))
  							{
								$sqlr1="SELECT nombre FROM productospaa  WHERE codigo='$row[2]' AND tipo='5'";
								$row1 =mysql_fetch_row(mysql_query($sqlr1,$linkbd));
								$codUNSPSC="$row[2] - $row1[0]";
								$sqlr2="SELECT nombre FROM almgrupoinv WHERE codigo='$row[3]'";
								$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
								$grupinv="$row2[0]";
								$codart="$row[3]$row[0]";
								$unprinart=almconculta_um_principal($codart);
								$disponible=totalinventario2($codart,'2018-12-31');
								if(!empty($_POST[todos]))
								{
									echo"
									<tr class='$co' style='text-transform:uppercase'>
										<td>$codUNSPSC</td>
										<td>$codart</td>
										<td>$row[1]</td>
										<td>$unprinart</td>
										<td>ALMACEN GENERAL</td>
										<td style='text-align:right;'>".number_format($disponible,2,'.',',')."</td>
									</tr>";
									$aux=$co;
									$co=$co2;
									$co2=$aux;
								}
								else
								{
									if($disponible>0)
									{
										echo"
										<tr class='$co' style='text-transform:uppercase'>
											<td>$codUNSPSC</td>
											<td>$codart</td>
											<td>$row[1]</td>
											<td>$unprinart</td>
											<td>ALMACEN GENERAL</td>
											<td style='text-align:right;'>".number_format($disponible,2,'.',',')."</td>
                                        </tr>";
                                        echo "<tr>
                                                <td><input class='inpnovisibles' name='codUNSPSC[]' value='".$codUNSPSC."' type='hidden'  style='width:100%' readonly></td>
                                                <td><input class='inpnovisibles' name='codart[]' value='".$codart."' type='hidden'  style='width:100%' readonly></td>      
                                                <td><input class='inpnovisibles' name='nombreArt[]' value='".$row[1]."' type='hidden'  style='width:100%' readonly></td>      
                                                <td><input class='inpnovisibles' name='unprinart[]' value='".$unprinart."' type='hidden'  style='width:100%' readonly></td>      
                                                <td><input class='inpnovisibles' name='disponible[]' value='".$disponible."' type='hidden'  style='width:100%' readonly></td>           
                                        </tr>";
										$aux=$co;
										$co=$co2;
										$co2=$aux;
									}
								}
							}
							?>
	   				</table>
				</div>
        </form>
        <div id="bgventanamodal2">
            <div id="ventanamodal2">
                <a href="javascript:despliegamodal2('hidden')" style="position: absolute; left: 810px; top: 5px; z-index: 100;"><img src="imagenes/exit.png" alt="cerrar" width=22 height=22>Cerrar</a>
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>  
  	</body>
</html>