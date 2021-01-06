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
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='botones.js'></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('granombrem').value;
				var validacion02=document.getElementById('gradescrm').value;
				if (validacion01.trim()!='' && validacion02.trim()!='')
			  		{despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
			  	else
				{
			  		despliegamodalm('visible','2','Faltan datos para Modificar La Prioridad');
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
			function funcionmensaje(){document.location.href = "plan-prioridades.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";document.form2.submit();break;
				}
			}
		</script>
<script>
	function adelante(scrtop, numpag, limreg, filtro, totreg, next){
		if(parseFloat(document.form2.graidm.value)<parseFloat(document.form2.maximo.value)){
			document.getElementById('oculto').value='1';
			document.getElementById('graidm').value=next;
			var idcta=document.getElementById('graidm').value;
			totreg++;
			document.form2.action="plan-prioridadeseditar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg+"&filtro="+filtro;
			document.form2.submit();
		}
	}

	function atrasc(scrtop, numpag, limreg, filtro, totreg, prev){
		if(document.form2.graidm.value>1){
			document.getElementById('oculto').value='1';
			document.getElementById('graidm').value=prev;
			var idcta=document.getElementById('graidm').value;
			totreg--;
			document.form2.action="plan-prioridadeseditar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg+"&filtro="+filtro;
			document.form2.submit();
 		}
	}

	function iratras(scrtop, numpag, limreg, filtro){
		var idcta=document.getElementById('graidm').value;
		location.href="plan-prioridadesbuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
    	<table >
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr> 
    		<tr>
     	 		<td colspan="3" class="cinta"><a href="plan-prioridades.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="plan-prioridadesbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a onClick="iratras(<?php echo "$scrtop, $numpag,$limreg,$filtro"; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
    		</tr>
       	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
   			<div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	
        <form name="form2" method="post" action="">
        	<?php
			if ($_GET[idprioridad]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idprioridad];</script>";}
			$sqlr="SELECT * FROM dominios WHERE nombre_dominio = 'PRIORIDAD_EVENTOS_AG' ORDER BY valor_inicial DESC";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];

			if($_POST[oculto]=="")
				{
					if ($_POST[codrec]!="" || $_GET[idprioridad]!="")
					{
						if($_POST[codrec]!=""){$sqlr="SELECT * FROM dominios WHERE nombre_dominio = 'PRIORIDAD_EVENTOS_AG' AND valor_inicial=$_POST[codrec] ";}
						else{$sqlr="SELECT * FROM dominios WHERE nombre_dominio = 'PRIORIDAD_EVENTOS_AG' AND valor_inicial=$_GET[idprioridad] ";}
					}
					else{$sqlr="SELECT * FROM dominios WHERE nombre_dominio = 'PRIORIDAD_EVENTOS_AG' ORDER BY valor_inicial DESC";}
					$res=mysql_query($sqlr,$linkbd);
					$rowEmp = mysql_fetch_assoc($res);
					$_POST[graidm]=$rowEmp[valor_inicial];
					$_POST[granombrem]=$rowEmp[descripcion_valor];
					$_POST[gracolorm]=$rowEmp[valor_final];
					$_POST[gradescrm]=$rowEmp[descripcion_dominio];
					$_POST[gracolorhxm]=$rowEmp[valor_final];
					$_POST[gratiem]=$rowEmp[tipo];
				}

			if($_POST[oculto]!="2"){
				$sqlr="SELECT * FROM dominios WHERE nombre_dominio = 'PRIORIDAD_EVENTOS_AG' AND valor_inicial=$_POST[graidm] ";
				$res=mysql_query($sqlr,$linkbd);
					$rowEmp = mysql_fetch_assoc($res);
					$_POST[graidm]=$rowEmp[valor_inicial];
					$_POST[granombrem]=$rowEmp[descripcion_valor];
					$_POST[gracolorm]=$rowEmp[valor_final];
					$_POST[gradescrm]=$rowEmp[descripcion_dominio];
					$_POST[gracolorhxm]=$rowEmp[valor_final];
					$_POST[gratiem]=$rowEmp[tipo];
			}
			//NEXT
			$sqln="SELECT * FROM dominios WHERE nombre_dominio = 'PRIORIDAD_EVENTOS_AG' AND valor_inicial > '$_POST[graidm]' ORDER BY valor_inicial ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next=$row[0];
			//PREV
			$sqlp="SELECT * FROM dominios WHERE nombre_dominio = 'PRIORIDAD_EVENTOS_AG' AND valor_inicial < '$_POST[graidm]' ORDER BY valor_inicial DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev=$row[0];
			?>
       		<table class="inicio" >
            	<tr>
              		<td class="titulos"colspan="12">:: Modificar Prioridad</td>
              		<td class="cerrar" style="width:7%;"><a href="plan-principal.php">&nbsp;Cerrar</a></td>
           		</tr>
            	<tr >
                	<td class="saludo1" style="width:7%">:&middot; Nombre:</td>
                	<td style="width:30%">
	        	    	<a onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $totreg; ?>, <?php echo $prev; ?>)" style='cursor:pointer;'><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
						<input type="text" name="granombrem" id="granombrem" style="width:60%" value="<?php echo $_POST[granombrem];?>"/>
	    	            <a onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $totreg; ?>, <?php echo $next; ?>)" style='cursor:pointer;'><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
					</td>
                	<td class="saludo1" style="width:6%">:&middot; color:</td>
                	<td style="width:4%"><input type="color" name="gracolorm" id="gracolorm" style="width:100%" onChange="document.getElementById('gracolorhxm').value=document.getElementById('gracolorm').value" value="<?php echo $_POST[gracolorm];?>"/></td>
                	<td class="saludo1" style="width:9%">:&middot; Descripci&oacute;n:</td>
               	 	<td><input type="text" name="gradescrm" id="gradescrm" style="width:90%" value="<?php echo $_POST[gradescrm];?>"></td>
                    <td class="saludo1" style="width:5%">:&middot; Estado:</td>
                	<td style="width:4%">
                    	<select name="gratiem" id="gratiem">
                        	<option value="N" <?php if($_POST[gratiem]=="N"){echo "selected";}?>>Inactivo</option>
                            <option value="S" <?php if($_POST[gratiem]=="S"){echo "selected";}?>>Activo</option>
                        </select>
                    </td>
            	</tr>
        	</table>
            <input type="hidden" name="oculto" id="oculto" value="1">
            <input type="hidden" name="gracolorhxm" id="gracolorhxm" value="<?php echo $_POST[gracolorhxm];?>">
			<input type="hidden" name="graidm" id="graidm" value="<?php echo $_POST[graidm];?>">
    		<?php
				if ($_POST[oculto]== 2)
				{
					$sqlr = "UPDATE dominios SET valor_final = '$_POST[gracolorhxm]', descripcion_valor = '$_POST[granombrem]', nombre_dominio = 'PRIORIDAD_EVENTOS_AG', tipo = '$_POST[gratiem]', descripcion_dominio = '$_POST[gradescrm]' WHERE valor_inicial =  '$_POST[graidm]' AND  nombre_dominio =  'PRIORIDAD_EVENTOS_AG'";
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se modifico la Prioridad');</script>";}
					else {echo"<script>despliegamodalm('visible','3','Se ha modificado la Prioridad con Exito');</script>";}
				}
			?>
     	</form>
    </body>
</html>