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
		<title>:: Spid - Almacen</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
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
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if (validacion01.trim()!='' && document.getElementById('codigo').value !='' && document.getElementById('concent').value !='' && document.getElementById('concentran').value !='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
		</script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="inve-editargrupoinv.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="inve-editargrupoinv.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="inve-buscagrupoinv.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
    		<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("inve");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="inve-grupoinv.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="inve-buscagrupoinv.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
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
			if ($_GET[codigo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[codigo];</script>";}
			$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from almgrupoinv ORDER BY CONVERT(codigo, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[codigo]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from almgrupoinv where codigo='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from almgrupoinv where codigo ='$_GET[codigo]'";
					}
				}
				else{
					$sqlr="select * from  almgrupoinv ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}

				if($_POST[oculto]!="2")
				{
					$sqlr="Select *from almgrupoinv where codigo=$_POST[codigo]";
					$res=mysql_query($sqlr,$linkbd);
					while($row=mysql_fetch_row($res))
					{
						$_POST[nombre]=$row[1];
						$_POST[estado]=$row[2];
						$_POST[codigo]=$row[0];
						$_POST[concent]=$row[3];
						$_POST[concentran]=$row[4];
					}
				}

			//NEXT
			$sqln="select *from almgrupoinv WHERE codigo > '$_POST[codigo]' ORDER BY codigo ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from almgrupoinv WHERE codigo < '$_POST[codigo]' ORDER BY codigo DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
			?>
    		<table class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="6">.: Editar Grupo Inventarios</td>
                    <td class="cerrar"><a href="inve-principal.php">Cerrar</a></td>
      			</tr>
      			<tr>
                    <td class="saludo1" style="width:2cm;">.: Codigo:</td>
                    <td style="width:10%;;">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" onKeyUp="return tabular(event,this)" style="width:30%;" readonly/>
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                   	</td>
                    <td class="saludo1" style="width:4.5cm;">.: Nombre Grupo:</td>
                    <td><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)" style="width:95%;"/></td>
                </tr>  
                <tr>
                	<td class="saludo1" style="width:2cm;">.: Activo:</td>
                    <td>
                        <select name="estado" id="estado" style="width:80%;">
                            <option value="S" <?php if($_POST[estado]=='S') echo "selected" ?>>SI</option>
          					<option value="N" <?php if($_POST[estado]=='N') echo "selected" ?>>NO</option>
                        </select>        
                    </td>
                    <td class="saludo1" style="width:4.5cm;">.: Concepto Entrada Almacen:</td>
                    <td style="width: 25%"> 
                        <select name="concent" id="concent" style="width:95%;">
                            <option value="">Seleccione ....</option>
                            <?php
                                $sqlr="SELECT * FROM conceptoscontables WHERE modulo='5' AND tipo='AE' ORDER BY codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[concent]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[3] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[3] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
					 <td class="saludo1" style="width:5cm;">.: Concepto Articulo en Transito:</td>
                   <td style="width: 25%"> 
                        <select name="concentran" id="concentran" style="width:95%;">
                            <option value="">Seleccione ....</option>
                            <?php
                                $sqlr="SELECT * FROM conceptoscontables WHERE modulo='5' AND tipo='AT' ORDER BY codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[concentran]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[3] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[3] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>                  
			</table>
    		<input type="hidden" name="oculto" id="oculto" value="1"/>         
		  	<?php
				if($_POST[oculto]=="2")
				{
					$sqlr="update almgrupoinv SET nombre='$_POST[nombre]',estado='$_POST[estado]',concepent='$_POST[concent]',conceptran='$_POST[concentran]' WHERE codigo='$_POST[codigo]'";echo $sqlr;
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se almaceno');</script>";}	
					else {echo"<script>despliegamodalm('visible','3','Se ha Actualizado el Articulo con Exito');</script>";}
				}
			?> 		
		</form>
	</body>
</html>