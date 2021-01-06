<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
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
		<title>:: Spid - Calidad</title>
	 	<?php require "head.php"; ?>
        <script>
			function guardar()
			{
				var validacion01=document.getElementById('granombre').value;
				if (validacion01.trim()!='' && document.getElementById('nombrepadre').value!='')
			  		{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
			  	else
				{
			  		despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.nombre.focus();document.form2.nombre.select();
			  	}
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
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){location.href="adm-dependenciasbuscar.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value='2';document.form2.submit();break;
				}
			}
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('oculid').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('oculid').value=next;
					var idcta=document.getElementById('oculid').value;
					document.form2.action="adm-dependenciasmodificar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('oculid').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('oculid').value=prev;
					var idcta=document.getElementById('oculid').value;
					document.form2.action="adm-dependenciasmodificar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('oculid').value;
				location.href="adm-dependenciasbuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<?php titlepag();?>
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
					<a onclick="location.href='adm-dependenciasguardar.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png" /><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png"/><span class="tiptext">Guardar</span></a>
					<a onclick="location.href='adm-dependenciasbuscar.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png" /><span class="tiptext">Buscar</span></a>
					<a onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pesta&ntilde;a</span></a>
					<a onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="tooltip bottom mgbt"><img src="imagenes/iratras.png"><span class="tiptext">Atrás</span></a>
				</td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" action="" >
			<?php 
			if ($_GET[iddependencia]!=""){echo "<script>document.getElementById('codrec').value=$_GET[iddependencia];</script>";}
			$sqlr="select MIN(codarea), MAX(codarea) from planacareas ORDER BY codarea";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[iddependencia]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from planacareas where codarea='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from planacareas where codarea ='$_GET[iddependencia]'";
					}
				}
				else{
					$sqlr="select * from  planacareas ORDER BY codarea DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[oculid]=$row[0];
			}
		
 			if($_POST[oculto]!="2")
				{
					$sqlr="SELECT * FROM planacareas WHERE  codarea=".$_POST[oculid];
					$res=mysql_query($sqlr,$linkbd);
					$rowEmp = mysql_fetch_assoc($res);
					$_POST[granombre]=$rowEmp[nombrearea];
					$_POST[nombrepadre]=$rowEmp[codpadrearea];
				}

			//NEXT
			$sqln="select *from planacareas WHERE  codarea > '$_POST[oculid]' ORDER BY codarea ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from planacareas WHERE  codarea < '$_POST[oculid]' ORDER BY codarea DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
			?>
            <table class="inicio ancho">
                <tr>
                  <td class="titulos"colspan="4" width="100%">:: Ingresar Dependencia</td>
                  <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:10%">:&middot; Dependencia:</td>
                    <td style="width:25%" >
	        	    	<a onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input name="granombre" type="text" id="granombre" style="width:70%" value="<?php echo $_POST[granombre]?>" required>
	    	            <a onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<script>
							document.addEventListener("keydown", function(event) {
								//console.log(event);
								if (event.keyCode==37) {
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
                    <td class="saludo1" style="width:10%">:&middot; Pertenece a:</td>
                    <td>
                    	<select id="nombrepadre" name="nombrepadre" class="Listahorasmen" style="width:40%"  >
                        <option value="">Seleccione....</option>
                        <option value=0 id="">&#8226; Ninguno</option>
                     		<?php
								$sqlr="SELECT * FROM planacareas WHERE estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
					 				if($row[0]==$_POST[nombrepadre])
			 						{echo "<option value='$row[0]' SELECTED> &#8226; $row[1]</option>";}
					  				else{echo "<option value='$row[0]'> &#8226; $row[1]</option>";}	 	 
								}	
              				?> 
                    	</select>
                        <input type="hidden" id="oculto" name="oculto" value="1">
                        <input type="hidden" id="oculid" name="oculid" value="<?php echo $_POST[oculid]?>">
                    </td>
                </tr>
            </table>
           	<?php
				if ($_POST[oculto]=="2")
				{			
					$sqlr = "UPDATE planacareas SET  nombrearea = '$_POST[granombre]',codpadrearea = '$_POST[nombrepadre]' WHERE codarea =  '$_POST[oculid]'";
					if (!mysql_query($sqlr,$linkbd))
					{echo"<script>despliegamodalm('visible','2',''Error no se almaceno el ');</script>";}
					else {echo"<script>despliegamodalm('visible','1','La Dependencia se Modifico con exito');</script>";}
				}
			?>
                
               
                
        </form>
</body>
</html>