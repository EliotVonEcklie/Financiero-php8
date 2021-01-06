<?php //V 1000 12/12/16 ?> 
<?php
  	require"comun.inc";
  	require"funciones.inc";
  	session_start();
  	$linkbd=conectar_bd();  
  	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
  	header("Cache-control: private"); // Arregla IE 6
  	date_default_timezone_set("America/Bogota");
	//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
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
		<title>:: Spid - Calidad</title>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				var validacion02=document.getElementById('prefijo').value;
				if (document.getElementById('codigo').value !='' && validacion01.trim()!='' && validacion02.trim()!='')
 				{despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
				}
			}

			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="meci-documentosedita.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=prev;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="meci-documentosedita.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="meci-documentosbusca.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					<a onclick="location.href='meci-documentos.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png"/><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png" /><span class="tiptext">Guardar</span></a>
					<a onclick="location.href='meci-documentosbusca.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png"/><span class="tiptext">Buscar</span></a>
					<a onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
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
 		<form name="form2" method="post"> 
 			<?php
			if ($_GET[idproceso]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idproceso];</script>";}
			$sqlr="select MIN(id), MAX(id) from caldocumentos ORDER BY id";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idproceso]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from caldocumentos where id='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from caldocumentos where id ='$_GET[idproceso]'";
					}
				}
				else{
					$sqlr="select * from  caldocumentos ORDER BY id DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}
		
 				if($_POST[oculto]!="2")
				{
					$sqlr="Select * from caldocumentos where id=$_POST[codigo] ";
					$resp = mysql_query($sqlr,$linkbd);
	    			while ($row =mysql_fetch_row($resp))
					{
						$_POST[codigo]=$row[0];
						$_POST[nombre]=$row[1];
						$_POST[prefijo]=$row[2];						
						$_POST[estado]=$row[3];		
					}
				}

			//NEXT
			$sqln="select *from caldocumentos WHERE id > '$_POST[codigo]' ORDER BY id ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from caldocumentos WHERE id < '$_POST[codigo]' ORDER BY id DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
 			?>
   			<table class="inicio ancho" >
   				<tr>
                	<td class="titulos" colspan="4" width="100%">Editar Tipo de Documento</td>
                	<td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
              	</tr>
   				<tr>
                	<td class="saludo1" style="width:2cm;">Codigo:</td>
                    <td style="width:10%;">
	        	    	<a onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" class="centrartext" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:35%;" readonly/>
	    	            <a onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<script>
							document.addEventListener("keydown", function(event) {
								console.log(event);
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
                    <td class="saludo1" style="width:2cm;">Nombre:</td>
                    <td><input name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:60%;"/></td>
                </tr>
  					<td class="saludo1" style="width:2cm;">Prefijo:</td>
                    <td><input type="text" name="prefijo" id="prefijo" value="<?php echo $_POST[prefijo]?>" maxlength="2" style="width:100%;"/></td>
   					<td class="saludo1" style="width:2cm;">Estado:</td>
                    <td> 
                    	<select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
          					<option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
          					<option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
        				</select>
                  	</td>
   				</tr>
   			</table>
            <input type="hidden" name="oculto" id="oculto" value="1">
 			<?php  
				if($_POST[oculto]=="2")
				{
					$sqlr="UPDATE caldocumentos SET nombre='$_POST[nombre]',prefijo='$_POST[prefijo]',estado ='$_POST[estado]' WHERE id='$_POST[codigo]'";	
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se almaceno');</script>";}	
					else {echo"<script>despliegamodalm('visible','3','El Tipo de Documento se Modifico con exito');</script>";}
	}
 ?>
 </form>       
 </td>       
 </tr>       
	</table>
</body>
</html>