<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();
	session_start();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6 
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<?php require "head.php"; ?>
        <script>
			function guardar()
			{
				if (document.getElementById('ntercero').value !='' && document.getElementById('nombrecargo').value!='')
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
 			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=nombrecargo";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if (document.getElementById('valfocus').value =="1")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('ntercero').value='';
						document.getElementById('tercero').focus();
						document.getElementById('tercero').select();
					}
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
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.formmodificar.submit();break;
				}
			}
			function buscater(e){if (document.formmodificar.tercero.value!=""){document.formmodificar.bt.value='1';document.formmodificar.submit();}}

			function adelante(scrtop, numpag, limreg, filtro, next,cd){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('oculid').value;
				if(parseFloat(maximo)!=parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('oculid').value=next;
					var idcta=document.getElementById('codrec').value;
					document.formmodificar.action="adm-asignacioncargosmodificar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.formmodificar.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev,cd){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('oculid').value;
				if(parseFloat(minimo)!=parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('oculid').value=prev;
					var idcta=document.getElementById('codrec').value;
					document.formmodificar.action="adm-asignacioncargosmodificar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.formmodificar.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codrec').value;
				location.href="adm-asignacioncargosbuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
	</head>
	<body>
    	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
        <table>
        	<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("meci");?></tr>
    		<tr>
  				<td colspan="3" class="cinta">
					<a onclick="location.href='adm-asignacioncargosguardar.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png" /><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png"/><span class="tiptext">Guardar</span></a>
					<a onclick="location.href='adm-asignacioncargosbuscar.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png" /><span class="tiptext">Buscar</span></a>
					<a onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
					<a onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="tooltip bottom mgbt"><img src="imagenes/iratras.png" title="s"><span class="tiptext">Atrá</span></a>
				</td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="formmodificar" method="post" action="" >
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php 
			if ($_GET[idcargoasignado]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idcargoasignado];</script>";}
			$sqlr="SELECT MIN(pt.cedulanit), MAX(pt.cedulanit) FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo ORDER BY pt.cedulanit";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idcargoasignado]!=""){
					if($_POST[codrec]!=""){
						$sqlr="SELECT t.*, pl.*, pt.codestter FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo AND pt.codestter='$_POST[codrec]'";
					}
					else{
						$sqlr="SELECT t.*, pl.*, pt.codestter FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo AND pt.codestter ='$_GET[idcargoasignado]'";
					}
				}
				else{
					$sqlr="SELECT t.*, pl.*, pt.codestter FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo ORDER BY pt.cedulanit DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[oculid]=$row[12];
			}	

			if ($_POST[oculto]!="2")
			{
				$sqlr="SELECT t.*, pl.*, pt.codestter FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo AND pt.cedulanit = '$_POST[oculid]'";
				//echo $sqlr;
				$res=mysql_query($sqlr,$linkbd);
				$rowEmp = mysql_fetch_assoc($res);
				$nombreemp=$rowEmp['nombre1']." ".$rowEmp['nombre2']." ".$rowEmp['apellido1']." ".$rowEmp['apellido2']; ;
				$_POST[tercero]=$rowEmp[cedulanit];
				$_POST[ntercero]=$nombreemp;
				$_POST[nombrecargo]=$rowEmp[codcargo];
				$_POST[codrec]=$rowEmp[codestter];
			}

			//NEXT
			$sqln="SELECT t.*, pl.*, pt.codestter FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo AND pt.cedulanit > '$_POST[tercero]' ORDER BY pt.cedulanit ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[12]."'";

			//PREV
			$sqlp="SELECT t.*, pl.*, pt.codestter FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo AND pt.cedulanit < '$_POST[tercero]' ORDER BY pt.cedulanit DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[12]."'";
			?>
           <table class="inicio ancho" >
                <tr>
            		<td class="titulos" colspan="5" width="100%">:: Asignar Cargo a Tercero</td>
                  	<td class="boton02" onClick="parent.cerrargeneral()">Cerrar</td>
                </tr>
                <tr>
               		<td style="width:2.5cm" class="saludo1" >:&middot; Tercero:</td>
                    <td style="width:20%">
	        	    	<a onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" id="tercero" name="tercero" style="width:50%" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>">&nbsp;
	    	            <a onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <a onClick="despliegamodal2('visible');"><img src="imagenes/buscarep.png"></a>
						<script>
							document.addEventListener("keydown", function(event) {
								//console.log(event);
								if (event.keyCode==37) 
								{
									atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>);
								}
								else if(event.keyCode==39)
								{
									adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>);
								}
							});
						</script>
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                  	</td>
                 	<td style="width:30%">
                    	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly>
                   	</td>
                        
                    <td class="saludo1" style="width:10%">:&middot; Cargo:</td>
                    <td style="width:25%">
                    	<select id="nombrecargo" name="nombrecargo" class="Listahorasmen" style="width:100%;text-transform:uppercase">
                        <option value="">Seleccione....</option>
                     		<?php
								$sqlr="SELECT * FROM planaccargos WHERE estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res))
				    			{
					 				if($row[0]==$_POST[nombrecargo])
			 						{echo "<option value='$row[0]' SELECTED> &#8226; $row[2]</option>";}
					  				else {echo "<option value='$row[0]'> &#8226; $row[2]</option>";}
								}		 
              				?> 
                    	</select>
                    </td>
                </tr>
                	<input type="hidden" value="0" name="bt">
                    <input type="hidden" id="oculto" name="oculto" value="1">
					<input type="hidden" id="oculid" name="oculid" value="<?php echo $_POST[oculid]?>">
					<input type="hidden" id="ocultoid" name="ocultoid" value="<?php echo $_POST[ocultoid]?>">					
            </table>
           	<?php
				if($_POST[bt]=='1')//***** busca tercero
				{
					$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!='')
			   		{echo"<script>document.getElementById('ntercero').value='$nresul';document.getElementById('nombrecargo').focus();</script>";}
				 	else
					{echo"<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Documento Incorrecto');</script>";}
			 	}
				if ($_POST[oculto]=="2")
				{			
					$sqlr = "UPDATE planestructura_terceros SET  codcargo = '$_POST[nombrecargo]',cedulanit = '$_POST[tercero]' WHERE codestter =  '$_POST[oculid]'";
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se almaceno el ');</script>";}
					else {echo"<script>despliegamodalm('visible','1','Se modifico la asignaci�n del cargo con exito');</script>";}
				}
			?>
			<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
					</IFRAME>
				</div>
			</div>
        </form>
	</body>
</html>