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
        <script src="JQuery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			function despliegamodal2(_valor,_pag)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_pag=="1"){document.getElementById('ventana2').src="inve-greservas-articulos.php";}
				else {document.getElementById('ventana2').src="inve-greservas-cuentas.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('articulo').focus();
									document.getElementById('articulo').select();
									break;
						case "2":	document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();
									break;
					}
					document.getElementById('valfocus').value='0';
				}
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":	document.getElementById('oculto').value="3";
								document.form2.submit();break;
				}
			}
			function funcionmensaje(){document.location.href = "inve-greservas.php";}
			function guardar()
			{
				valg01=document.form2.codigo.value;
				valg02=document.form2.fecha.value;
				valg03=document.form2.conarticulos.value;
				if (valg01!='' && valg02!='' && valg03!=0)
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function guiabuscar(_opc)
			{
				if(_opc==1){if(document.getElementById('articulo').value!=""){document.getElementById('busqueda').value='1';}}
				else{if(document.getElementById('cuenta').value!=""){document.getElementById('busqueda').value='2';}}
				document.form2.submit();
			}
			function agregardetalle()
			{
				val01=document.getElementById('narticulo').value;
				val02=document.getElementById('nreserva').value;
				val03=document.getElementById('ncuenta').value;
				if(val01!="" && val02!="" && val03!=""){document.form2.agregadet.value=1;document.form2.submit();}
			 	else {despliegamodalm('visible','2','Falta informaci�n para poder Agregar Detalle de Modalidad');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function validar(_opc){document.form2.submit();}
			function limpiar()
			{
				document.getElementById('articulo').value='';
				document.getElementById('narticulo').value='';
				document.getElementById('nbodega').value='';
				document.getElementById('nreserva').value='';
				document.getElementById('nreservav').value='';
				document.getElementById('cuenta').value='';
				document.getElementById('ncuenta').value='';
				document.getElementById('cc').value='';
				document.getElementById('umedida').value='';
			}
			jQuery(function($){ $('#nreservav').autoNumeric('init',{mDec:'0'});});
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='inve-greservas.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='inve-greservasbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("inve");?>" class="mgbt"></td>
			</tr>
         </table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		  
 		<form name="form2" method="post" action="inve-greservas.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
        	<?php
				if ($_POST[oculto]=="")
				{ 
					$_POST[fecha]=date("d/m/Y");
					$_POST[conarticulos]=0;
					$_POST[codigo]=selconsecutivo('almreservas','codigo');
				}

			?>
    		<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="8">.: Gesti&oacute;n de Reservas</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='inve-principal.php'">Cerrar</td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:3.6cm;">.: C&oacute;digo Reserva:</td>
                    <td style="width:9%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:100%;" readonly/></td>
                    <td class="saludo1" style="width:3.1cm;">.: Fecha Reserva:</td>
                    <td style="width:14%;"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width: 70%">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut"/><input type="hidden" name="chacuerdo" value="1"></td>
                    <td class="saludo1" style="width:4cm;">.: Articulo:</td>
                    <td style="width:10%;"><input type="text" name="articulo" id="articulo" value="<?php echo $_POST[articulo]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('1');" style="width:78%"/>&nbsp;<img class='icobut' src='imagenes/find02.png'  title='Listado de Articulos' onClick="despliegamodal2('visible','1');"/></td>
                    <td><input type="text" name="narticulo" id="narticulo" value="<?php echo $_POST[narticulo]?>" style="width:90%;text-transform:uppercase" readonly/>&nbsp;&nbsp;<img src="imagenes/eraser.png"  class='icobut' title="Borrar Art&iacute;culo" onClick="limpiar();"/></td>
      			</tr>
             	<tr>
                	<td class="saludo1">.: Cantidad Bodega:</td>
                    <td ><input type="text" name="nbodega" id="nbodega" value="<?php echo $_POST[nbodega];?>" style="width:100%;" readonly/></td>
                    <input type="hidden" name="npbodega" id="npbodega" value="<?php echo $_POST[npbodega];?>"/>
                    <input type="hidden" name="usbodega" id="usbodega" value="<?php echo $_POST[usbodega];?>"/>
                    <td class="saludo1">.: Unidad de Medida:</td>
                    <td>
                    	<select id="umedida" name="umedida" onChange="validar()" style="width:100%">
                    	<?php
							$sqlm="SELECT * FROM almarticulos_det WHERE articulo='$_POST[articulo]' ORDER BY principal DESC, id_det ASC";
							$resm=mysql_query($sqlm,$linkbd);
							while($rowm=mysql_fetch_array($resm))
							{
								if($rowm[2]==$_POST[umedida])
								{
									$_POST[factor]=$rowm[3];
									echo"
									<script>
									document.form2.nbodega.value=(document.form2.npbodega.value - document.form2.usbodega.value) *$_POST[factor]; </script>
									<option value='$rowm[2]' style='text-transform:uppercase' SELECTED>$rowm[2]</option>";										
								}
								else {echo "<option value='$rowm[2]' style='text-transform:uppercase'>$rowm[2]</option>";}
							}
						?>
     					</select>
                    	<input type="hidden" name="factor" id="factor" value="<?php echo $_POST[factor]?>"/>
                    </td>
          			<td class="saludo1" >.: Descripci&oacute;n:</td>
                    <td colspan="3"><input type="text" name="detalleres" id="detalleres" value="<?php echo $_POST[detalleres]?>" style="width:100%;" /></td>
                </tr>
  				<tr>
                    <td class="saludo1" >.: Cantidad Reserva:</td>
                    <td >
                    	<input type="hidden" name="nreserva" id="nreserva" value="<?php echo $_POST[nreserva]?>"/>
                        <input type="text" name="nreservav" id="nreservav" value="<?php echo $_POST[nreservav]?>" style="width:100%;text-align:right;" data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp="sinpuntitos('nreserva','nreservav');"/>
                    </td>
                    <td class="saludo1">.: Centro de Costo:</td>
					<td >
                    	<input type="hidden" name="ccaux" id="ccaux" value="<?php echo $_POST[ccaux];?>"/>
                        <select name="cc" id="cc" style="width:100%;text-align:right;">
							<?php
                                $sql="SELECT id_cc,nombre FROM centrocosto WHERE estado='S' AND entidad='S' ORDER BY id_cc";
                                $result=mysql_query($sql,$linkbd);
                                while($row = mysql_fetch_row($result))
                                {
                                    if($row[0]==$_POST[ccaux]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }
                            ?>
						</select>
                    </td>
   					<td class="saludo1">.: Conceptos Contables:</td>
                    <td colspan="3">
                    	<select id="cuenta" name="cuenta" onChange="validar()" style="width:100%">
                    		<option value="">Seleccione...</option>
							<?php
								$sqlm="SELECT * FROM conceptoscontables WHERE almacen='S' and tipo='C' and modulo='3' ORDER BY codigo";
								$resm=mysql_query($sqlm,$linkbd);
								while($rowm=mysql_fetch_array($resm))
								{
									if("$rowm[0]"==$_POST[cuenta])
									{
										$_POST[ncuenta]=$rowm[1];
										echo "<option value='$rowm[0]' style='text-transform:uppercase' SELECTED>$rowm[0] - $rowm[1]</option>";										
									}
									else {
										echo "<option value='$rowm[0]' style='text-transform:uppercase'>$rowm[0] - $rowm[1]</option>";
									}
								}
							?>
                    	</select>
               			<input type="hidden" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>" >
                    </td>
                </tr>
  				<tr>
                    <td ><input type="button" name="agregar" id="agregar"  onClick="agregardetalle()" value="&nbsp;&nbsp;Agregar&nbsp;&nbsp;" style="width:100%" /></td>
                    <td colspan="4" style="width:7%"></td>
                </tr>
            </table>
    		<input type="hidden" name="oculto" id="oculto" value="1"> 
            <input type="hidden" name="agregadet" id="agregadet" value="0" >
            <input type="hidden" name="busqueda" id="busqueda" value=""> 
            <input type='hidden' name='elimina' id='elimina'>
            <div class="subpantalla" style="height:50%; width:99.6%; overflow-x:hidden;">
				<table class='inicio'>
                    <tr><td class='titulos' colspan='9'>Detalles Modalidad</td></tr>
                    <tr class='titulos2'>
                        <td style="width:8%;">Cod. Articulo</td>
                        <td >Nombre Articulo</td>
                        <td style="width:5%;">U.M.</td>
						<td style="width:5%;">Bodega</td>
                        <td style="width:5%;">Reserva</td>
						<td style="width:8%;">Cod. Cuenta</td>
                        <td>Nombre Cuenta</td>
                        <td style="width:5%;">CC</td>
                        <td style="width:4%;">Eliminar</td>
                    </tr>
             		<?php
						if ($_POST[oculto]=='3')
						{ 
							$posi=$_POST[elimina];
							unset($_POST[agcodi][$posi]);
							unset($_POST[agarti][$posi]);
							unset($_POST[agnbod][$posi]);
							unset($_POST[agnres][$posi]);
							unset($_POST[agcuen][$posi]);
							unset($_POST[agncue][$posi]);
							unset($_POST[aguni][$posi]);
							unset($_POST[agncc][$posi]);
							$_POST[agcodi]= array_values($_POST[agcodi]); 
							$_POST[agarti]= array_values($_POST[agarti]); 
							$_POST[agnbod]= array_values($_POST[agnbod]); 		 		 
							$_POST[agnres]= array_values($_POST[agnres]); 
							$_POST[agcuen]= array_values($_POST[agcuen]); 
							$_POST[agncue]= array_values($_POST[agncue]); 
							$_POST[aguni]= array_values($_POST[aguni]); 
							$_POST[agncc]= array_values($_POST[agncc]);
						}
						if ($_POST[agregadet]=='1')
						{
							//$cantres=$_POST[nreserva]*$_POST[factor];
							if($_POST[nreserva]>$_POST[nbodega])
							{
								echo"<script>despliegamodalm('visible','2','La Reserva Supera la Cantidad de Articulos en Bodega. No obstante, se procedera con su Solicitud');</script>";
							}
							$_POST[agcodi][]=$_POST[articulo];
							$_POST[agarti][]=$_POST[narticulo];
							$_POST[agnbod][]=$_POST[nbodega]; 
							$_POST[agnres][]=$_POST[nreserva];
							$_POST[agcuen][]=$_POST[cuenta];
							$_POST[agncue][]=$_POST[ncuenta]; 
							$_POST[aguni][]=$_POST[umedida]; 
							$_POST[agfact][]=$_POST[factor];
							$_POST[agncc][]=$_POST[cc]; 
							$_POST[agregadet]=0;
							echo "<script>document.form2.nbodega.value=document.form2.nbodega.value-$_POST[nreserva];</script>";
							
						}
						$iter='saludo1a';
						$iter2='saludo2';
						$totalbodega=0;
						$_POST[conarticulos]=count($_POST[agcodi]);
						for ($x=0;$x<count($_POST[agcodi]);$x++)
						{		 
							echo "
							<input type='hidden' name='agcodi[]' value='".$_POST[agcodi][$x]."'/>
							<input type='hidden' name='agarti[]' value='".$_POST[agarti][$x]."'/>
							<input type='hidden' name='agnbod[]' value='".$_POST[agnbod][$x]."'/>
							<input type='hidden' name='agnres[]' value='".$_POST[agnres][$x]."'/>
							<input type='hidden' name='agcuen[]' value='".$_POST[agcuen][$x]."'/>
							<input type='hidden' name='agncue[]' value='".$_POST[agncue][$x]."'/>
							<input type='hidden' name='aguni[]' value='".$_POST[aguni][$x]."'/>
							<input type='hidden' name='agfact[]' value='".$_POST[agfact][$x]."'/>
							<input type='hidden' name='agncc[]' value='".$_POST[agncc][$x]."'/>
							<tr class='$iter'>
								<td>".$_POST[agcodi][$x]."</td>
								<td>".$_POST[agarti][$x]."</td>
								<td>".$_POST[aguni][$x]."</td>
								<td style='text-align:right;'>".$_POST[agnbod][$x]."</td>
								<td style='text-align:right;'>".$_POST[agnres][$x]."</td>
								<td>".$_POST[agcuen][$x]."</td>
								<td>".$_POST[agncue][$x]."</td>
								<td style='text-align:center;'>".$_POST[agncc][$x]."</td>
								<td class='icobut' style='text-align:center;'><img src='imagenes/del.png' onclick='eliminar($x)'></td>
							</tr>";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							
							if($_POST[agcodi][$x]==$_POST[articulo])
							{$totalbodega=$totalbodega+($_POST[agnres][$x]/$_POST[agfact][$x]);}
						}
						echo"<script>
								document.form2.usbodega.value=$totalbodega;
								document.form2.nbodega.value=(document.form2.npbodega.value - document.form2.usbodega.value) *$_POST[factor]; </script>";
					?>
                </table>
            </div>
  			<?php
				
				if($_POST[busqueda]!="")
				{
					if($_POST[busqueda]=="1")
					{
						$nresul=buscararticulos($_POST[articulo]);
						if($nresul!='')
						{
							echo "<script>document.getElementById('narticulo').value='$nresul';document.getElementById('nreserva').focus(); document.getElementById('nreserva').select();</script>";
						}
						else
						{
						echo "<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','C�digo del Articulo Incorrecto');</script>";
						}
					}
					else
					{
						$nresul=buscaconcepto2($_POST[cuenta],'3','C');
						if($nresul!='')
						{
							echo "<script>document.getElementById('ncuenta').value='$nresul';</script>";
						}
						else
						{
						echo "<script>document.getElementById('valfocus').value='2';despliegamodalm('visible','2','C�digo Cuenta Incorrecto');</script>";
						}
					}
				}		
				if($_POST[oculto]=="2")
				{
					$sqlr="SELECT  pl.codcargo, pl.dependencia FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.estado='S' AND pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo and t.cedulanit='$_SESSION[cedulausu]'";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$cargo=$row[0];
					$dependencia=$row[1];
					$_POST[codigo]=selconsecutivo('almreservas','codigo');
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
 					$sqlr="INSERT INTO almreservas (codigo,fecha,solicitante,dependencia,cargo,estado,detalle) VALUES ('$_POST[codigo]','$fechaf', '$_SESSION[cedulausu]','$dependencia','$cargo','ENT','$_POST[detalleres]')";	
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";}	
					else 
					{
						$cont=0;
						$contx=count($_POST[agcodi]);
						for ($x=0;$x<$contx;$x++)
						{
							$sqlr="INSERT INTO almreservas_det (codreserva,articulo,cuenta,bodega,cantidad,estado,unidad,cc) VALUES ('$_POST[codigo]', '".$_POST[agcodi][$x]."','".$_POST[agcuen][$x]."','".$_POST[agnbod][$x]."','".$_POST[agnres][$x]."','ENT','".$_POST[aguni][$x]."','".$_POST[agncc][$x]."')";
							if (!mysql_query($sqlr,$linkbd)){$cont=$cont+1;}
						}
						if ($cont!=0){echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";}
						else {echo"<script>despliegamodalm('visible','1','Reserva N� $_POST[codigo] solicitada con Exito');</script>";}
					}
				}
			?>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
            <input type="hidden" name="conarticulos" id="conarticulos" value="<?php echo $_POST[conarticulos];?>"> 
 		</form>
	</body>
</html>