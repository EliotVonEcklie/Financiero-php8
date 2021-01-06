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
				valg01=document.getElementById('codigo').value;
				valg02=document.getElementById('fecha').value;
				valg03=document.getElementById('conarticulos').value;
				if (valg01!='' && valg02!='' && valg03!=0){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
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
			 	else {despliegamodalm('visible','2','Falta información para poder Agregar Detalle de Modalidad');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}			
			function pdf(){
				document.form2.action="inve-pdfgreservas.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function iratras(scrtop, numpag, limreg, filtro){
				var idrecaudo=document.getElementById('codigo').value;
				location.href="inve-greservasbuscar.php?idcta="+idrecaudo;
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
  				<td colspan="3" class="cinta">
					<a href="inve-greservas.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
					<a href="inve-greservasbuscar.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onclick="pdf()" class="mgbt"><img src="imagenes/print.png" alt="Buscar"></a>
					<a onclick="iratras(60, 1, 10, '')" class="mgbt"><img src="imagenes/iratras.png" title="Atrás"></a>
				</td>
			</tr>
         </table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		  
 		<form name="form2" method="post" action="inve-greservaseditar.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
        	<?php
				if ($_POST[oculto]=="")
				{ 
					$_POST[codigo]=$_GET[idreserva];
					$sqlr="SELECT * FROM almreservas WHERE codigo='$_POST[codigo]'";
                    $resp=mysql_query($sqlr,$linkbd);
                    while ($row=mysql_fetch_row($resp))
                    {
						$_POST[fecha]=$row[1];
						$sqlr2="SELECT * FROM almreservas_det WHERE codreserva='$_POST[codigo]'";
						$resp2=mysql_query($sqlr2,$linkbd);
                        while ($row2=mysql_fetch_row($resp2))
                        {
							$codarticulo=substr($row2[1],-5);
							$sqlr3="SELECT nombre FROM almarticulos WHERE estado='S' AND codigo='$codarticulo'";
							$row3 =mysql_fetch_row(mysql_query($sqlr3,$linkbd));
							$narticulo=$row3[0];
							$sqlr4="SELECT nombre FROM conceptoscontables WHERE tipo='AS' AND codigo='$row2[2]' ";
							$row4=mysql_fetch_row(mysql_query($sqlr4,$linkbd));
							$_POST[agcodi][]=$row2[1];
							$_POST[agarti][]=$narticulo;
							$_POST[agnbod][]=$row2[3]; 
							$_POST[agnres][]=$row2[4];
							$_POST[agcuen][]=$row2[2];
							$_POST[agncue][]=$row4[0]; 
                        }
						
					}
					$_POST[conarticulos]=count($_POST[agcodi]);
					
				}
			?>
    		<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="8">.: Editar Reservas</td>
                    <td class="cerrar" style="width:7%;"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:3.6cm;">.: C&oacute;digo Reserva:</td>
                    <td style="width:10%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:100%;" readonly/></td>
                    <td class="saludo1" style="width:3.1cm;">.: Fecha Reserva:</td>
                    <td style="width:6%;"><input type="date" name="fecha" id="fecha" value="<?php echo $_POST[fecha]?>" style="width:100%;"/></td>
                    <td class="saludo1" style="width:3.2cm;">.: Articulo:</td>
                    <td style="width:12%;"><input type="text" name="articulo" id="articulo" value="<?php echo $_POST[articulo]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="guiabuscar('1');" style="width:80%"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/buscarep.png"/></a></td>
                    <td><input type="text" name="narticulo" id="narticulo" value="<?php echo $_POST[narticulo]?>" style="width:100%;text-transform:uppercase" readonly/></td>
      			</tr>
  				<tr>
       				<td class="saludo1" style="width:3.6cm;">.: Cantidad Bodega:</td>
                    <td style="width:6%;">
                    <input type="text" name="nbodega" id="nbodega" value="<?php echo $_POST[nbodega]?>" style="width:100%;" readonly/></td>
                    <td class="saludo1" style="width:3.1cm;">.: Unidad de Medida:</td>
                    <td style="width:12%;"><select id="umedida" name="umedida" onChange="validar()" style="width:100%">
                    	<?php
						$sqlm="SELECT * FROM almarticulos_det WHERE articulo='$_POST[articulo]' ORDER BY principal DESC, unidad ASC";
						$resm=mysql_query($sqlm,$linkbd);
						while($rowm=mysql_fetch_array($resm)){
							if($rowm[2]==$_POST[umedida]){
								$_POST[factor]=$rowm[3];
								echo "<option value='$rowm[2]' style='text-transform:uppercase' SELECTED>$rowm[2]</option>";										
							}
							else {
								echo "<option value='$rowm[2]' style='text-transform:uppercase'>$rowm[2]</option>";
							}
						}
						?>
                    </select>
                    <input type="hidden" name="factor" id="factor" value="<?php echo $_POST[factor]?>" >
                    </td>
                    <td class="saludo1" style="width:3.2cm;">.: Cantidad Reserva:</td>
                    <td style="width:10%;">
                    	<input type="hidden" name="nreserva" id="nreserva" value="<?php echo $_POST[nreserva]?>"/>
                        <input type="text" name="nreservav" id="nreservav" value="<?php echo $_POST[nreservav]?>" style="width:80%;text-align:right;" data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp="sinpuntitos('nreserva','nreservav');"/>
                    </td>
                    <td colspan="2">
					<input type="hidden" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>" >
					</td>
                    <td style="width:7%;"></td>
                </tr>
  				<tr>
                    <td class="saludo1" style="width:3.6cm;">.: Conceptos Contables:</td>
                    <td colspan="3"><select id="cuenta" name="cuenta" onChange="validar()" style="width:100%">
                    	<option value="">Seleccione...</option>
                    	<?php
						$sqlm="SELECT * FROM conceptoscontables WHERE tipo='AS' ORDER BY nombre";
						$resm=mysql_query($sqlm,$linkbd);
						while($rowm=mysql_fetch_array($resm))
						{
							if("$rowm[0]"==$_POST[cuenta])
							{
								$_POST[ncuenta]=$rowm[1];
								echo "<option value='$rowm[0]' style='text-transform:uppercase' SELECTED>$rowm[1]</option>";										
							}
							else {
								echo "<option value='$rowm[0]' style='text-transform:uppercase'>$rowm[1]</option>";
							}
						}
						?>						
                    </select>
					</td>
                    <td style="width:3.2cm"><input type="button" name="agregar" id="agregar"  onClick="agregardetalle()" value="&nbsp;&nbsp;Agregar&nbsp;&nbsp;" style="width:100%" /></td>
                    <td colspan="4" style="width:7%"></td>
                </tr>
            </table>
    		<input type="hidden" name="oculto" id="oculto" value="1"> 
            <input type="hidden" name="agregadet" id="agregadet" value="0" >
            <input type="hidden" name="busqueda" id="busqueda" value=""> 
            <input type='hidden' name='elimina' id='elimina'>
            <div class="subpantalla" style="height:64%; width:99.6%; overflow-x:hidden;">
				<table class='inicio'>
                    <tr><td class='titulos' colspan='7'>Detalles Modalidad</td></tr>
                    <tr>
                        <td class='titulos2' style="width:8%;">Cod. Articulo</td>
                        <td class='titulos2'>Nombre Articulo</td>
						<td class='titulos2' style="width:8%;">Bodega</td>
                        <td class='titulos2' style="width:8%;">Reserva</td>
						<td class='titulos2' style="width:8%;">Cod. Cuenta</td>
                        <td class='titulos2'>Nombre Cuenta</td>
                        <td class='titulos2' style="width:5%;">Eliminar</td>
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
						   	$_POST[agcodi]= array_values($_POST[agcodi]); 
						   	$_POST[agarti]= array_values($_POST[agarti]); 
						   	$_POST[agnbod]= array_values($_POST[agnbod]); 		 		 
						   	$_POST[agnres]= array_values($_POST[agnres]); 
						   	$_POST[agcuen]= array_values($_POST[agcuen]); 
						   	$_POST[agncue]= array_values($_POST[agncue]); 
		 				}
            		if ($_POST[agregadet]=='1')
					{
						$_POST[agcodi][]=$_POST[articulo];
						$_POST[agarti][]=$_POST[narticulo];
						$_POST[agnbod][]=$_POST[nbodega]; 
						$_POST[agnres][]=$_POST[nreserva];
						$_POST[agcuen][]=$_POST[cuenta];
						$_POST[agncue][]=$_POST[ncuenta]; 
						$_POST[agregadet]=0;
						echo "
						<script>
							document.getElementById('articulo').value='';
							document.getElementById('narticulo').value='';
							document.getElementById('nbodega').value='';
							document.getElementById('nreserva').value='';
							document.getElementById('cuenta').value='';
							document.getElementById('ncuenta').value='';
							//document.getElementById('articulo').focus();
						</script>";
					}
					$iter='saludo1a';
					$iter2='saludo2';
					$_POST[conarticulos]=count($_POST[agcodi]);
					for ($x=0;$x<count($_POST[agcodi]);$x++)
					{
					$sql="SELECT nombre FROM conceptoscontables WHERE almacen='S' and tipo='C' and modulo='3' and codigo='".$_POST[agcuen][$x]."' ORDER BY nombre";
					$re=mysql_query($sql,$linkbd);
					$r=mysql_fetch_array($re);
					echo "
						<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
							<td><input type='text' class='inpnovisibles' name='agcodi[]' value='".$_POST[agcodi][$x]."' style='width:100%;' readonly></td>
							<td><input type='text' class='inpnovisibles' name='agarti[]' value='".$_POST[agarti][$x]."' style='width:100%;' readonly></td>
							<td style='text-align:right;font-size:11px;'>".number_format($_POST[agnbod][$x],0,',','.')."</td>
							<td style='text-align:right;font-size:11px;'>".number_format($_POST[agnres][$x],0,',','.')."</td>
							<td><input type='text' class='inpnovisibles' name='agcuen[]' value='".$_POST[agcuen][$x]."' style='width:100%;' readonly></td>
							<td><input type='text' class='inpnovisibles' name='agncue[]' value='".$r[0]."' style='width:100%;' readonly></td>
							<td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
						</tr>
						<input type='hidden'  name='agnbod[]' value='".$_POST[agnbod][$x]."'/>
						<input type='hidden' name='agnres[]' value='".$_POST[agnres][$x]."'/>
						";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
					}
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
						echo "<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Código del Articulo Incorrecto');</script>";
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
						echo "<script>document.getElementById('valfocus').value='2';despliegamodalm('visible','2','Código Cuenta Incorrecto');</script>";
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
					$sqlr="UPDATE dominios SET descripcion_valor='$_POST[nombre]',tipo='$_POST[estado]' WHERE valor_inicial=$_POST[codigo] AND nombre_dominio='MODALIDAD_SELECCION' AND valor_final IS NULL ";	
 					$sqlr="UPDATE almreservas SET fecha='$_POST[fecha]',dependencia='$dependencia',cargo='$cargo'";
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se almaceno');</script>";}	
					else 
					{
						$sqlr5 ="DELETE FROM almreservas_det WHERE codreserva='$_POST[codigo]'";
						mysql_query($sqlr5,$linkbd);
						$cont=0;
						$contx=count($_POST[agcodi]);
						for ($x=0;$x<$contx;$x++)
						{
							$sqlr6="INSERT INTO almreservas_det (codreserva,articulo,cuenta,bodega,cantidad) VALUES ('$_POST[codigo]', '".$_POST[agcodi][$x]."','".$_POST[agcuen][$x]."','".$_POST[agnbod][$x]."','".$_POST[agnres][$x]."')";
							if (!mysql_query($sqlr6,$linkbd)){$cont=$cont+1;}
						}
						if ($cont!=0){echo"<script>despliegamodalm('visible','2',''Error no se almaceno');</script>";}
						else {echo"<script>despliegamodalm('visible','2','Reserva N° $_POST[codigo] Modifico con Exito');</script>";}
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