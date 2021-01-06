<?php //V 1000 12/12/16 ?> 
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
		<title>:: Spid - Meci Calidad</title>
		<?php require "head.php";?>
		<script>
			function guardar()
			{
				if (document.getElementById('codigo').value !='' && document.getElementById('nombre').value!='')
 				{despliegamodalm('visible','4','Esta Seguro de Modificar','1')}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
 			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
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
			function funcionmensaje(){document.location.href = "meci-buscaareas.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.getElementById('oculto').value="2";
						document.form2.submit();
					break;
				}
			}

			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('idcomp').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					document.getElementById('idcomp').value=next;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="meci-editarareas.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('idcomp').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=prev;
					document.getElementById('idcomp').value=prev;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="meci-editarareas.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('idcomp').value;
				location.href="meci-buscaareas.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					<a onclick="location.href='meci-areas.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png"/><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar();" class="tooltip bottom mgbt"><img src="imagenes/guarda.png"/><span class="tiptext">Guardar</span></a>
					<a onclick="location.href='meci-buscaareas.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png" /><span class="tiptext">Buscar</span></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pesta&ntilde;a</span></a>
					<a onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="tooltip bottom mgbt"><img src="imagenes/iratras.png"><span class="tiptext">Atr&aacute;s</span></a>
				</td>
			</tr>
   		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
        <form name="form2" method="post" action="meci-editarareas.php">
			<?php
			if ($_GET[idtipocom]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idtipocom];</script>";}
			$sqlr="select MIN(CONVERT(id_cc, SIGNED INTEGER)), MAX(CONVERT(id_cc, SIGNED INTEGER)) from admareas ORDER BY CONVERT(id_cc, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idtipocom]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from admareas where id_cc='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from admareas where id_cc ='$_GET[idtipocom]'";
					}
				}
				else{
					$sqlr="select * from  admareas ORDER BY CONVERT(id_cc, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			   	$_POST[idcomp]=$row[0];
			}
		
 			if($_POST[oculto]!="2")
                {
                    $sqlr="SELECT * FROM admareas WHERE id_cc='$_POST[idcomp]'";
                    $res=mysql_query($sqlr,$linkbd);
                    while($row=mysql_fetch_row($res))
                    {
						$_POST[codigo]=$row[0];
                        $_POST[nombre]=$row[1];
                        $_POST[estado]=$row[2];
                    }
                }

			//NEXT
			$sqln="select *from admareas WHERE CONVERT(id_cc, SIGNED INTEGER) > CONVERT('$_POST[idcomp]', SIGNED INTEGER) ORDER BY CONVERT(id_cc, SIGNED INTEGER) ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from admareas WHERE CONVERT(id_cc, SIGNED INTEGER) < CONVERT('$_POST[idcomp]', SIGNED INTEGER) ORDER BY CONVERT(id_cc, SIGNED INTEGER) DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
            ?>
    		<table class="inicio ancho" align="center" >
                <tr>
                    <td class="titulos" colspan="6" width="100%">.: Editar areas</td>
                    <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                </tr>
      			<tr>
	    			<td class="saludo1" style="width:2cm;">Codigo:</td>
        			<td style="width:10%;">
	        	    	<a onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" class="centrartext" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" size="2" maxlength="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
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
        			<td class="saludo1" style="width:3cm;">Nombre:</td>
        			<td style="width:30%;"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:97%;"  onKeyUp="return tabular(event,this)"></td>
        			<td class="saludo1" style="width:2cm;">Activo:</td>
        			<td>
                    	<select name="estado" id="estado">
          					<option value="S" <?php if($_POST[estado]=='S') echo "selected" ?>>SI</option>
          					<option value="N" <?php if($_POST[estado]=='N') echo "selected" ?>>NO</option>
        				</select>  
              		</td>
       			</tr>  
    		</table>
    		<input type="hidden" name="oculto" id="oculto" value="1"/>  
            <input type="hidden" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp];?>"/>
  			<?php
				if($_POST[oculto]=="2")
				{
 					$sqlr="UPDATE admareas SET nombre='$_POST[nombre]',estado='$_POST[estado]',id_cc='$_POST[codigo]' WHERE id_cc='$_POST[idcomp]'";
  					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se almaceno el ');</script>";}
					else {echo"<script>despliegamodalm('visible','3','El Area se Modifico con exito');</script>";}
				}
			?>  
		</form>
	</body>
</html>