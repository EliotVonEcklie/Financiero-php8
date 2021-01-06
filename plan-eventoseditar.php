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
        <title>::SPID-Planeacion Estrategica</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='funcioneshf.js'></script>
        <script type='text/javascript' src='css/programas.js'></script>
        <script>
			function guardar()
			{
				var validacion01=document.getElementById('granombre').value;
				var validacion02=document.getElementById('gradescr').value;
				if (validacion01.trim()!='' && validacion02.trim()!='')
			  		{despliegamodalm('visible','4','Esta Seguro de Modificar El Evento','1');}
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
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.getElementById('oculto').value='2';
						document.form2.submit();break;
				}
			}
		</script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('oculid').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('oculid').value=next;
					var idcta=document.getElementById('oculid').value;
					document.form2.action="plan-eventoseditar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="plan-eventoseditar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('oculid').value;
				location.href="plan-eventosbuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="plan-eventos.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="plan-eventosbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
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
			if ($_GET[idevento]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idevento];</script>";}
			$sqlr="SELECT MIN(CONVERT(valor_inicial, SIGNED INTEGER)), MAX(CONVERT(valor_inicial, SIGNED INTEGER)) FROM dominios WHERE nombre_dominio = 'TIPO_EVENTO_AG' ORDER BY CONVERT(valor_inicial, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idevento]!=""){
					if($_POST[codrec]!=""){
						$sqlr="SELECT * FROM dominios WHERE nombre_dominio = 'TIPO_EVENTO_AG' AND valor_inicial='$_POST[codrec]'";
					}
					else{
						$sqlr="SELECT * FROM dominios WHERE nombre_dominio = 'TIPO_EVENTO_AG' AND valor_inicial ='$_GET[idevento]'";
					}
				}
				else{
					$sqlr="SELECT MAX(valor_inicial) FROM dominios WHERE nombre_dominio = 'TIPO_EVENTO_AG' ORDER BY CONVERT(valor_inicial, SIGNED INTEGER)";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[oculid]=$row[0];
			}

				if ($_POST[oculto]!="2"){
					$sqlr="SELECT * FROM dominios WHERE nombre_dominio = 'TIPO_EVENTO_AG' AND valor_inicial=".$_POST[oculid];
					$res=mysql_query($sqlr,$linkbd);
					$rowEmp = mysql_fetch_assoc($res);
					$_POST[granombre]=$rowEmp[descripcion_valor];
					$_POST[gradescr]=$rowEmp[descripcion_dominio];
				}
			//NEXT
			$sqln="SELECT * FROM dominios WHERE nombre_dominio = 'TIPO_EVENTO_AG' AND CONVERT(valor_inicial, SIGNED INTEGER) > CONVERT('$_POST[oculid]', SIGNED INTEGER) ORDER BY CONVERT(valor_inicial, SIGNED INTEGER) ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="SELECT * FROM dominios WHERE nombre_dominio = 'TIPO_EVENTO_AG' AND CONVERT(valor_inicial, SIGNED INTEGER) < CONVERT('$_POST[oculid]', SIGNED INTEGER) ORDER BY CONVERT(valor_inicial, SIGNED INTEGER) DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
			?>
        	<table class="inicio" >
         		<tr>
          			<td class="titulos" colspan="6">:: Ingresar Evento</td>
                  	<td class="cerrar" style="width:7%"><a href="plan-principal.php">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:7%">:&middot; Nombre:</td>
                    <td style="width:25%">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" name="granombre" id="granombre" style="width:70%" value="<?php echo $_POST[granombre]?>">
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                   	</td>
                    <td class="saludo1" style="width:9%">:&middot; Descripci&oacute;n:</td>
                    <td><input type="text" name="gradescr" id="gradescr" style="width:70%" value="<?php echo $_POST[gradescr]?>"></td>
                </tr>
            </table>
            <input type="hidden" id="oculto" name="oculto" value="1">
            <input type="hidden" id="oculid" name="oculid" value="<?php echo $_POST[oculid]?>">
            <?php
				if ($_POST[oculto]=="2")
				{
					$sqlr = "UPDATE dominios SET  descripcion_valor = '$_POST[granombre]',descripcion_dominio = '$_POST[gradescr]' WHERE nombre_dominio = 'TIPO_EVENTO_AG' AND valor_inicial =  '$_POST[oculid]'";
					
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se Modifico el Evento');</script>";}
					else {echo"<script>despliegamodalm('visible','3','Se Modifico el Evento con Exito');</script>";}
				}
			?>
        </form>
    </body>
</html>