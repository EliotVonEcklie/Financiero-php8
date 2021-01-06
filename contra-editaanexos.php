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
		<title>:: Spid - Contrataci&oacute;n</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('codigo').value
				var validacion02=document.getElementById('nombre').value
				if (validacion01.trim()!='' && validacion02.trim()!=''){despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
			  	else
			  	{
					despliegamodalm('visible','2','Faltan datos para Modificar el registro');
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
			function funcionmensaje(){document.location.href = "contra-anexos.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value='2';document.form2.submit();break;
				}
			}
		</script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, totreg, next){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=next;
				var idcta=document.getElementById('codigo').value;
				totreg++;
				document.form2.action="contra-editaanexos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg+"&filtro="+filtro;
				document.form2.submit();
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, totreg, prev){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=prev;
				var idcta=document.getElementById('codigo').value;
				totreg--;
				document.form2.action="contra-editaanexos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg+"&filtro="+filtro;
				document.form2.submit();
			}

			function iratras(scrtop, numpag, limreg){
				var idcta=document.getElementById('codigo').value;
				location.href="contra-buscaanexos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg;
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
            <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("contra");?></tr>
            <tr>
  				<td colspan="3" class="cinta">
					<a href="contra-anexos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="contra-buscaanexos.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
					<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
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
			$sqlr="Select * from contraanexos ORDER BY id DESC";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idproceso]!=""){
					if($_POST[codrec]!=""){
						$sqlr="Select * from contraanexos where id='$_POST[codrec]'";
					}
					else{
						$sqlr="Select * from contraanexos where id ='$_GET[idproceso]'";
					}
				}
				else{
					$sqlr="Select * from contraanexos ORDER BY id DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}
 			if($_POST[oculto]!="2")
			{
				$sqlr="Select * from contraanexos where id=$_POST[codigo] ";
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp))
				{
					$_POST[codigo]=$row[0];
					$_POST[nombre]=$row[1];					
					$_POST[estado]=$row[2];		
					$_POST[tipo]=$row[4];				
				}
			}
			//NEXT
			$sqln="Select * from contraanexos where id > '$_POST[codigo]' ORDER BY id ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next=$row[0];
			//PREV
			$sqlp="Select * from contraanexos where id < '$_POST[codigo]' ORDER BY id DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev=$row[0];
 		?>
			<table class="inicio" >
				<tr>
                  	<td class="titulos" colspan="4">Crear Anexos</td>
                  	<td class="cerrar" style='width:7%'><a href="contra-principal.php">Cerrar</a></td></tr>
               	<tr>
					<td class="saludo1" style='width:10%'>Codigo:</td>
                    <td style='width:30%'>
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $totreg; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style='width:15%'>
	    	            <a onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $totreg; ?>, <?php echo $next; ?>)"  style='cursor:pointer;'><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                   	</td>
                    <td class="saludo1" style='width:10%'>Nombre</td>
                    <td><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style='width:70%'></td>
              	</tr>
   				<tr> 
      				<td class="saludo1">Tipo</td>
                    <td> 
                    	<select name="tipo" id="tipo" onKeyUp="return tabular(event,this)"  >
            				<option  value="" >Seleccione....</option>
							<?php
								$sqlr="SELECT * FROM dominios where nombre_dominio='CONTRATACION_ANEXOS'";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_row($res)) 
				    			{
					 				if($rowEmp[0]==$_POST[tipo]) {echo "<option value=$rowEmp[0] SELECTED>$rowEmp[0] - $rowEmp[1]</option>";}
					  				else {echo "<option value=$rowEmp[0]>$rowEmp[0] - $rowEmp[1]</option>";}
								}	
              				?> 
        				</select>
                	</td>
   					<td class="saludo1">Estado</td>
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
 				if($_POST[oculto]=="2") //********guardar
				{
					$sqlr="update  contraanexos set nombre='$_POST[nombre]',estado ='$_POST[estado]', fase='$_POST[tipo]' where id=$_POST[codigo]  ";	
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','ERROR EN LA CREACION DEL ANEXO');</script>";}
		 			else {echo"<script>despliegamodalm('visible','1','Se ha Modificado el ANEXO con Exito');</script>";}
				}
			?>
		</form>       
	</body>
</html>