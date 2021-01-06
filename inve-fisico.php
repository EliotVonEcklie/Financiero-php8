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
						case "5":
							document.getElementById('ventanam').src="ventana-comentarios.php?infor="+mensa+"&bas=fulanita";break;	
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta){
					case "1"://Eliminar Archivo Adjunto de la lista
						document.form2.oculto.value=2;
						document.form2.submit();
						break;
				}
			}
//************* guardar ************
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if(validacion01.trim()!=''){despliegamodalm('visible','4','Esta Seguro de Guardar','1','0');}
				else
				{
					document.form2.nombre.focus();
					document.form2.nombre.select();
					despliegamodalm('visible','2','Faltan Datos para Completar el Registro');
				}
			}
			function funcionmensaje(){}
		</script>
        <?php titlepag();?>
	</head>
	<body>
  		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
		    <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
		    <tr><?php menu_desplegable("inve");?></tr>
          	<tr>
          		<td colspan="3" class="cinta"><a href="inve-fisico.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="inve-fisicobuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" class="mgbt" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a class="mgbt"><img src="imagenes/printd.png"></a></td>
        	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" id="form2" method="post" enctype="multipart/form-data">
           	<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]?>" > 
        	<?php
			$_POST[tabgroup1]=1;
			//*****************************************************************
            switch($_POST[tabgroup1]){
            	case 1:
                	$check1='checked';break;
               	case 2:
                	$check2='checked';break;
               	case 3:
                	$check3='checked';break;
               	case 4:
                	$check4='checked';break;
           	}
			?>
			<table class="inicio">
				<tr>
    				<td colspan="6" class="titulos2">Gesti&oacute;n Inventario F&iacute;sico</td>
            	</tr>
				<tr>
		    		<td class="saludo1a" width="10%">Consecutivo</td>
	                <td style="width:10%;">
    	               	<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" readonly> 
               		</td>
		    		<td class="saludo1a" width="10%">Fecha</td>
	                <td  width="15%">
    	              	<input type="text" name="fecha" id="fecha" value="<?php echo $_POST[fecha]?>" readonly/>
        	       	</td>
		    		<td width="10%">Nombre</td>
	                <td  width="45%">
    	              	<input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:100%" />
        	       	</td>
    			</tr>
	   		</table>
            <div class="tabsmeci"  style="height:76.5%; width:99.6%">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Revisi&oacute;n 1</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio">
                            <tr>
                                <td class="titulos" style="width:93%">:.Inventario F&iacute;sico </td>
                                <td class="cerrar" style="width:7%"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                                <td width="100%" class="saludo1" style="width:100%" colspan="2" >
                                	<table width="100%">
                                    	<tr>
							    	    	<td class="titulos2">Codigo UNSPSC</td>
							        		<td class="titulos2">Codigo Articulo</td>
						    	        	<td class="titulos2">Nombre Articulo</td>
								            <td class="titulos2">Existencia</td>
								            <td class="titulos2">Cantidad Verificada</td>
                                        </tr>
                                        <?php
										$sql="SELECT * FROM almarticulos WHERE estado='S' ORDER BY codigo";
										$res=mysql_query($sql, $linkbd);
										while($row=mysql_fetch_array($res)){
											echo'<tr>
												<td style="width:10%">
													<input name="codunsv[]" type="hidden" value="'.$row[2].'" >
													<input name="codinarv[]" type="hidden" value="'.$row[3].$row[0].'" >
													<input name="cantidadv[]" type="hidden" value="'.$wart[5].'" >
													'.$row[2].'
												</td>
												<td style="width:10%">'.$row[3].$row[0].'</td>
												<td style="width:60%">'.$row[1].'</td>
												<td style="width:10%" align="center">'.$row[5].'</td>
												<td  style="width:10%">
													<input name="cantver[]" type="text" style="width:100%; text-align:right" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" >
												</td> 
											</tr>';
										}
										?>
                                    </table>
                                </td>
                           	</tr>
                        </table>
      				</div>
				</div>
            	<div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Revisi&oacute;n 2</label>
                    <div class="content" style="overflow:hidden;" >
                        <table class="inicio">
                            <tr>
                                <td class="titulos" style="width:93%">:.Inventario F&iacute;sico </td>
                                <td class="cerrar" style="width:7%"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                                <td width="100%" class="saludo1" style="width:100%" colspan="2" >
                                	<table width="100%">
                                    	<tr>
							    	    	<td class="titulos2">Codigo UNSPSC</td>
							        		<td class="titulos2">Codigo Articulo</td>
						    	        	<td class="titulos2">Nombre Articulo</td>
								            <td class="titulos2">Cantidad Verificada</td>
								            <td class="titulos2">Reconteo</td>
                                        </tr>
                                        <?php
										if($_POST[codigo]!=""){
											$sql="SELECT * FROM almfisico_det WHERE revision='1' AND codigo='$_POST[codigo]' ORDER BY id_det";
											$res=mysql_query($sql, $linkbd);
											while($row=mysql_fetch_array($res)){
												$crit1="WHERE concat_ws(' ', nombre, concat_ws('', grupoinven, codigo)) LIKE '%$wres[1]'";
												$sqlr="SELECT * FROM almarticulos $crit1 ORDER BY length(grupoinven),grupoinven ASC, length(codigo),codigo ASC";
												$rart=mysql_query($sqlr,$linkbd);
												$wart=mysql_fetch_array($rart);
												echo'<tr>
													<td style="width:10%">
														<input name="codidr[]" type="hidden" value="'.$row[0].'" >
														<input name="codunsr[]" type="hidden" value="'.$wart[2].'" >
														<input name="codinarr[]" type="hidden" value="'.$wart[3].$wart[0].'" >
														<input name="cantidadr[]" type="hidden" value="'.$row[5].'" >
														'.$wart[2].'
													</td>
													<td style="width:10%">'.$row[4].'</td>
													<td style="width:60%">'.$wart[1].'</td>
													<td style="width:10%" align="center">'.$row[5].'</td>
													<td  style="width:10%">
														<input name="cantrec[]" type="text" style="width:100%; text-align:right" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" >
													</td> 
												</tr>';
											}
										}
										?>
                                    </table>
                                </td>
                           	</tr>
                        </table>
                    </div>
             	</div>
				<div class="tab">
                    <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
                    <label for="tab-3">Ajuste de Inventario</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio">
                            <tr>
                                <td class="titulos" style="width:93%">:.Inventario F&iacute;sico - Ajuste </td>
                                <td class="cerrar" style="width:7%"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                                <td width="100%" class="saludo1" style="width:100%" colspan="2" >
                                	<table width="100%">
                                    	<tr>
							    	    	<td class="titulos2">Codigo UNSPSC</td>
							        		<td class="titulos2">Codigo Articulo</td>
						    	        	<td class="titulos2">Nombre Articulo</td>
								            <td class="titulos2">Cantidad Verificada</td>
								            <td class="titulos2">Reconteo</td>
                                        </tr>
                                        <?php
										if($_POST[codigo]!=""){
											$sql="SELECT * FROM almfisico_det WHERE revision='2' AND codigo='$_POST[codigo]' ORDER BY id_det";
											$res=mysql_query($sql, $linkbd);
											while($row=mysql_fetch_array($res)){
												$crit1="WHERE concat_ws(' ', nombre, concat_ws('', grupoinven, codigo)) LIKE '%$wres[1]'";
												$sqlr="SELECT * FROM almarticulos $crit1 ORDER BY length(grupoinven),grupoinven ASC, length(codigo),codigo ASC";
												$rart=mysql_query($sqlr,$linkbd);
												$wart=mysql_fetch_array($rart);
												echo'<tr>
													<td style="width:10%">
														<input name="codida[]" type="hidden" value="'.$row[0].'" >
														<input name="codunsa[]" type="hidden" value="'.$wart[2].'" >
														<input name="codinarr[]" type="hidden" value="'.$wart[3].$wart[0].'" >
														<input name="cantidada[]" type="hidden" value="'.$row[5].'" >
														'.$wart[2].'
													</td>
													<td style="width:10%">'.$row[4].'</td>
													<td style="width:60%">'.$wart[1].'</td>
													<td style="width:10%" align="center">'.$row[5].'</td>
													<td  style="width:10%">
														<input name="cantaj[]" type="text" style="width:100%; text-align:right" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" >
													</td> 
												</tr>';
											}
										}
										?>
                                    </table>
                                </td>
                           	</tr>
                        </table>
                    </div>
             	</div>
			</div>
            <!-- FIN DIV DE TABS -->
			<?php 
			//********** GUARDAR EL COMPROBANTE ***********
			if($_POST[oculto]=='2'){
				echo'<script>document.form2.oculto.value=0</script>';
				//ID tabla
				if($_POST[codigo]==''){
					$sql="select codigo, fecha from almfisico order by codigo desc";
					$res=mysql_query($sql);
					if(mysql_num_rows($res)!=0){
						$winv=mysql_fetch_array($res);
						$codinv=$winv[0]+1;
					}
					else{
						$codinv=1;
					}
				}
				else{
					$codinv=$_POST[codigo];
				}
				$hoy="'".date('d-m-Y')."'";
				echo"<script>
					document.form2.codigo.value='$codinv';
					document.form2.fecha.value='$hoy';
				</script>";
				$sqlb="SELECT * FROM almfisico WHERE codigo='$codinv'";
				$resb=mysql_query($sqlb, $linkbd);
				if(mysql_num_rows($resb)!=0){
					//ACTUALIZA REVISIONES
					//REVISION 2
					if(count($_POST[cantrec])>0){
						for($x=0;$x<count($_POST[cantrec]);$x++){
							$sqlr="update almfisico_det set verificado = '".$_POST[cantrec][$x]."' where id_det='".$_POST[codidr][$x]."'";
			  				$res=mysql_query($sqlr,$linkbd);
						}
					}
					//AJUSTE
					if(count($_POST[cantaj])>0){
						for($x=0;$x<count($_POST[cantaj]);$x++){
							$sqlr="update almfisico_det set verificado = '".$_POST[cantaj][$x]."' where id_det='".$_POST[codida][$x]."'";
			  				$res=mysql_query($sqlr,$linkbd);
						}
					}
					echo"<script>
						despliegamodalm('visible','1','Se ha almacenado la Revisión de Inventario Físico con Exito');
					</script>";
				//FIN ACTUALIZA
				}
				else{
				//INGRESA
					$sqlr="insert into almfisico (codigo, fecha, hora, usuario, estado, nombre) values ('$codinv', now(), now(), '', 'S', '$_POST[nombre]')";
					if(!mysql_query($sqlr,$linkbd)){
						echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
					 }
		 			else{
						//REVISION 1
						if(count($_POST[cantver])>0)
						{
							for($x=0;$x<count($_POST[cantver]);$x++)
							{
								$idtabla=selconsecutivo('almfisico_det','id_det');
								$sqlr="insert into almfisico_det (id_det,codigo, revision, unspsc, articulo, existencia, verificado) values ('$idtabla','$codinv', '1', '".$_POST[codunsv][$x]."','".$_POST[codinarv][$x]."','".$_POST[cantidadv][$x]."','".$_POST[cantver][$x]."')";
				  				$res=mysql_query($sqlr,$linkbd);
								
							}
						}
						//REVISION 2
						if(count($_POST[cantrec])>0)
						{
							for($x=0;$x<count($_POST[cantrec]);$x++)
							{
								$idtabla=selconsecutivo('almfisico_det','id_det');
								$sqlr="insert into almfisico_det (id_det,codigo, revision, unspsc, articulo, existencia, verificado) values ('$idtabla','$codinv', '2', '".$_POST[codunsr][$x]."','".$_POST[codinarr][$x]."','".$_POST[cantidadr][$x]."','".$_POST[cantrec][$x]."')";
				  				$res=mysql_query($sqlr,$linkbd);
							}
						}
						//AJUSTE
						if(count($_POST[cantaj])>0){
							for($x=0;$x<count($_POST[cantaj]);$x++)
							{
								$idtabla=selconsecutivo('almfisico_det','id_det');
								$sqlr="insert into almfisico_det (id_det,codigo, revision, unspsc, articulo, existencia, verificado) values ('$idtabla','$codinv', '3', '".$_POST[codunsa][$x]."','".$_POST[codinara][$x]."','".$_POST[cantidada][$x]."','".$_POST[cantaj][$x]."')";
				  				$res=mysql_query($sqlr,$linkbd);
							}
						}
						echo"<script>
							despliegamodalm('visible','1','Se ha almacenado la Revisión de Inventario Físico con Exito');
						</script>";
					}
				}
			}
			?>
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