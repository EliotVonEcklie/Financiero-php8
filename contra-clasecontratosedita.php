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
				if (validacion01.trim()!='' && validacion02.trim()!=''){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else
				  {despliegamodalm('visible','2','Faltan datos para completar el registro');document.form2.estado.focus();document.form2.estado.select();}
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
					case "1":	document.getElementById('oculto').value='2';document.form2.submit();break;
				}
			}
		</script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=next;
				var idcta=document.getElementById('codigo').value;
				document.form2.action="cont-clasecontratosedita.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=prev;
				var idcta=document.getElementById('codigo').value;
				document.form2.action="contra-clasecontratosedita.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}

			function iratras(scrtop, numpag, limreg){
				var idcta=document.getElementById('codigo').value;
				location.href="contra-clasecontratosbusca.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg;
			}
		</script>
		<?php 
			titlepag();
			function eliminarDir()
			{
				$carpeta="informacion/plantillas_contratacion/temp";
				foreach(glob($carpeta . "/*") as $archivos_carpeta)
				{
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta);
			}
		?>
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
					<a href="contra-clasecontratos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="contra-clasecontratosbusca.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a>
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
 		<form name="form2" method="post" enctype="multipart/form-data"> 
		 <?php 
			if ($_GET[idproceso]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idproceso];</script>";}
			$sqlr="SELECT * FROM contraclasecontratos ORDER BY id DESC";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idproceso]!=""){
					if($_POST[codrec]!=""){
						$sqlr="SELECT * FROM contraclasecontratos where id='$_POST[codrec]'";
					}
					else{
						$sqlr="SELECT * FROM contraclasecontratos where id ='$_GET[idproceso]'";
					}
				}
				else{
					$sqlr="SELECT * FROM contraclasecontratos ORDER BY id DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}
            if($_POST[oculto]!="2")
            {
                $sqlr="SELECT * FROM contraclasecontratos WHERE id=$_POST[codigo]";
                $resp = mysql_query($sqlr,$linkbd);
                while ($row =mysql_fetch_row($resp))
                {
                    $_POST[codigo]=$row[0];
                    $_POST[nombre]=$row[1];				
                    $_POST[estado]=$row[2];
                    $_POST[nomarch]=$row[4];
                }
            }
			//NEXT
			$sqln="SELECT * FROM contraclasecontratos WHERE id > '$_POST[codigo]' ORDER BY id ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next=$row[0];
			//PREV
			$sqlp="SELECT * FROM contraclasecontratos WHERE id < '$_POST[codigo]' ORDER BY id DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev=$row[0];
         ?>
   			<table class="inicio" >
                <tr>
                    <td class="titulos" colspan="6">Editar Clase de Contrato</td>
                    <td class="cerrar" style='width:7%'><a href="contra-principal.php">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style='width:10%'>C&oacute;digo:</td>
                    <td colspan="2" style='width:30%'>
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>"  style='width:15%' readonly>
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                   	</td>
                    <td class="saludo1">Nombre</td>
                    <td><input  type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>"style='width:70%'></td>
                </tr>
                <tr>
                    <td class="saludo1">Plantilla</td>
                    <td><input type="text" name="nomarch" id="nomarch"  style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
                    <td>
                        <div class='upload'> 
                            <a href="#" title="Cargar Documento"><input type="file" name="plantillaad" onChange="document.form2.submit();" title="(Cargar)" /><img src='imagenes/upload01.png' style="width:18px" title='(Cargar)'  /></a>
                        </div> 
                    </td>
                    <td class="saludo1">Estado</td>
                    <td> 
                        <select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
                            <option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
                            <option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
                        </select>
                    </td>
                </tr>
        		<input id="estadooculto" name="estadooculto" type="hidden" value="<?php echo $_POST[estadooculto]?>">
       			<input type="hidden" name="oculto" id="oculto" value="1">
   			</table>
 			<?php  
				if($_POST[oculto]=="2")//********guardar
				{
					$sqlr="UPDATE contraclasecontratos SET nombre='$_POST[nombre]',estado='$_POST[estado]',adjunto='$_POST[nomarch]' WHERE id=$_POST[codigo] ";
					if (!mysql_query($sqlr,$linkbd))
					{
						 echo "<script>despliegamodalm('visible','2','ERROR EN LA CREACION DEL ANEXO');</script>";
						 echo $sqlr;
						 echo "error ".mysql_error($linkbd);
					}
		  			else
		  			{
						copy("informacion/plantillas_contratacion/temp/$_POST[nomarch]",("informacion/plantillas_contratacion/$_POST[nomarch]"));
						echo"<script>document.form2.nombre.focus();</script>";
						echo"<script>despliegamodalm('visible','3','Se Modifico la Clase de Contrato con Exito');</script>";
		  			}
				}
				if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 	//archivos
				{
					$sqlr="SELECT adjunto FROM contraclasecontratos";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$archad[]=$row[0];}
					if (in_array($_FILES['plantillaad']['name'], $archad))
					{echo"<script>despliegamodalm('visible','2','Ya existe una Plantilla con este nombre');</script>";}
					else
					{
						$rutaad="informacion/plantillas_contratacion/temp/";
						if(!file_exists($rutaad)){mkdir ($rutaad);}
						else {eliminarDir();mkdir ($rutaad);}
						echo"<script>document.getElementById('nomarch').value='". $_FILES['plantillaad']['name']."';</script>"; 
						copy($_FILES['plantillaad']['tmp_name'], $rutaad.$_FILES['plantillaad']['name']);
					}
				}
 			?>
 		</form>       
	</body>
</html>