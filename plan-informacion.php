<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();
	session_start();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
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
        <script type='text/javascript' src='jquery-1.11.0.min.js'></script>
        <script type='text/javascript' src='funcioneshf.js'></script>
        <script type="text/javascript" src="css/programas.js"></script>
         <style>
			.ocultanuevo{ position: relative; display:block; }
			.ocultamodificar{ position: relative; display:none; }
			.ocultabuscar{ position: relative; display:none; }
			.ocultarebuscar{ position: relative; display:none; }
		</style>
        <script >
			var modtitulo= new Array();
			var modimgnombre= new Array();
			var modimgtipo= new Array();
			var modtexnombre= new Array();
			var modtextipo= new Array();
			var dirfoto;
			
			function Ocultar_tabla(idtabla) 
			{
				document.getElementById(idtabla).style.display = 'none';
				switch(idtabla)
				{
					case 'tablanuevo':
						document.getElementById('oculnuevo').value='none';
						break;
					case 'tablamodificar':
						document.getElementById('oculmodificar').value='none';
						break;
					case 'tablabuscar':
						document.getElementById('oculbuscar1').value='none';
						break;
					case 'tablarebuscar':
						document.getElementById('oculbuscar2').value='none';
						break;
				}
			}
			
			function Ocultar_Modificar() 
			{var tabdis = document.getElementById('tablamodificar');tabdis.style.display = 'none';}
			
			function Mostrar_tabla(idtabla) 
			{
				document.getElementById(idtabla).style.display = 'block';
				switch(idtabla)
				{
					case 'tablanuevo':
						document.getElementById('bot2').innerHTML=("<img src='imagenes/guarda.png' onClick='guardar_informacion();'/>");
						document.getElementById('oculnuevo').value='block';
						break;
					case 'tablamodificar':
						document.getElementById('oculmodificar').value='block';
						break;
					case 'tablabuscar':
						document.getElementById('oculbuscar1').value='block';
						break;
					case 'tablarebuscar':
						document.getElementById('oculbuscar2').value='block';
						break;
				}
			}
			
			function Mostrar_Modificar(nomid) 
			{
				if (confirm("¿Seguro de Modificar esta Información de Interés?"))
				{
					var tabdis = document.getElementById('tablamodificar');
					tabdis.style.display = 'block';
					Ocultar_tabla('tablabuscar');Ocultar_tabla('tablarebuscar');
					document.getElementById('gratitulom').value=modtitulo[nomid];
					document.getElementById('graimagenm').src=modimgnombre[nomid];
					document.getElementById('ocuidm').value=nomid;
					document.getElementById('imagencm').src="informacion/imagenes/"+modimgnombre[nomid];
					document.getElementById('ocuimagen').value=modimgnombre[nomid];
					archtxt="informacion/archivos/"+modtexnombre[nomid];
					//cargar archivo TXT en textarea
					//$.ajax({url : archtxt, dataType: "text",success : function (data) {$("#ocutext").html(data);}});
					$.ajax({url: archtxt}).done(function(data){document.getElementById('gradescrm').innerHTML = data;});
					document.getElementById('bot2').innerHTML=("<img src='imagenes/guarda.png' onClick='modificar_informacion();'/>");
				}
			}
			
			function guardar_informacion()
			{
				if (confirm("¿Seguro de Guardar esta Información de Interés?"))
				{
					if(document.formulario.gratitulo.value!="" && document.formulario.gradescr.value!="Escribe aquí la Información de interés" && document.formulario.gradescr.value!="")
					{document.getElementById('oculto1').value="2";document.formulario.submit();}
					else
					{alert("Ingresar todos los Campos");}
				}
			}
			
			function modificar_informacion()
			{
				if (confirm("¿Seguro de Modificar esta Información de Interés?"))
				{
				if(document.formulario.gratitulom.value!="" && document.formulario.gradescrm.value!="")
					{document.formulario.oculto2.value="2"; document.formulario.submit();}
				else
					{alert("Ingresar todos los Campos");}
				}
				alert(document.getElementById('ocutext').value);
			}
			
			function eliminar_registro(nomid)
			{
				if (confirm("¿Seguro que Desea Eliminar esta Información de Interés?"))
				{
					document.getElementById('ocudel').value="2";
					document.getElementById('iddel').value=nomid;
					document.formulario.submit();
				}
			}
			
			function listado_informacion()
			{Ocultar_tabla('tablanuevo');Mostrar_tabla('tablabuscar');Mostrar_tabla('tablarebuscar');document.getElementById('oculto').value="2";document.formulario.submit(); }
			
			function borrarinicio()
			{
				if(document.getElementById('gradescr').value=="Escribe aquí la Información de interés")
				document.getElementById('gradescr').value="";
			}
		</script>
      <?php 
	  	function prueba($arg_1)
		{
			echo $arg_1;
		}
	  ?>
    </head>
	<body>
    <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
	<span id="todastablas2"></span>
   <form  name="formulario" method="post" enctype="multipart/form-data" action="#"> 
   	<input id="oculbuscar1" name="oculbuscar1" type="hidden" value="<?php echo $_POST[oculbuscar1];?>">
    <input id="oculbuscar2" name="oculbuscar2" type="hidden" value="<?php echo $_POST[oculbuscar2];?>">
    <input id="oculnuevo" name="oculnuevo" type="hidden" value="<?php echo $_POST[oculnuevo];?>">
    <input id="oculmodificar" name="oculmodificar" type="hidden" value="<?php echo $_POST[oculmodificar];?>">
    <table>
		<table>
        	<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr>
			<script>var pagini = '<?php echo $_GET[pagini];?>';barra_imgbotones("informacion");</script>
		</table>
        	<tr>
                <td colspan="3" class="tablaprin" ></td>
         	</tr>
	 	<span id="tablanuevo" class="ocultanuevo">
        <table class="inicio" >
            <tr>
              <td class="titulos"colspan="5">:: Ingresar Informaci&oacute de Inter&eacute;s</td>
              <td width="5%" class="cerrar" ><a href="plan-principal.php">Cerrar</a></td>
            </tr>
            <tr >
                <td class="saludo1" style="width:7%">:&middot; Titulo:</td>
                <td colspan='3'><input name="gratitulo" type="text" id="gratitulo" style="width:100%" required></td></tr>
                <tr>
                <td class="saludo1">:&middot; Fecha inicio</td>
                <td><input type="date" name="fechaini"></td>
                <td class="saludo1">:&middot; Fecha Final</td>
                <td><input type="date" name="fechafin"></td></tr>
 <tr >
                <td class="saludo1" style="width:7%">:&middot; Adjunto:</td>
                <td colspan='3'><input name="adjunto" type="file" id="adjunto" style="width:100%" required></td></tr>                
                <tr>
                <td class="saludo1" style="width:9%">:&middot; Imagen:</td>
                <td style="width:45%" ><input name="graimagen" type="file" id="graimagen" style="width:100%" accept="image/jpeg; image/gif"  required></td>
                <td id="vista_previa" height="310px" colspan="2" rowspan="2" style="background-color:#ffffff;font-weight:normal;border:#CCCCCC 1px solid;padding-left:3px;padding-right:3px;margin-bottom:1px;margin-top:1px;-webkit-border-radius: 2px;">
                	<img id="imagenc" src="imagenes/sinimagen1.jpg" style=" width:100%; alignment-adjust:middle;">
        		</td>
             </tr>
             <tr>   
                <td class="saludo1" style="width:9%">:&middot; Descripci&oacute;n:</td>
                <td  colspan="1" ><textarea  id="gradescr" name="gradescr" style="width:100%; height:410px" onClick="borrarinicio();">Escribe aqu&iacute; la Informaci&oacute;n de inter&eacute;s</textarea><input type="hidden" id="oculto1" name="oculto1" value="1"></td>
            </tr>
        </table>
    </span>
    </table>   
    <span id="tablamodificar" class="ocultamodificar">
        <table class="inicio" >
            <tr>
              <td class="titulos"colspan="5">:: Modificar Informaci&oacute de Inter&eacute;s</td>
              <td width="5%" class="cerrar" ><a href="plan-principal.php">Cerrar</a></td>
            </tr>
            <tr >
                <td class="saludo1" style="width:7%">:&middot; Titulo:</td>
                <td colspan='3'><input name="gratitulom" type="text" id="gratitulom" style="width:100%" value="<?php echo $_POST[gratitulom];?>" required></td>
                <tr>
                <td class="saludo1">:&middot; Fecha inicio</td>
                <td><input type="date" name="fechainim"></td>
                <td class="saludo1">:&middot; Fecha Final</td>
                <td><input type="date" name="fechafinm"></td></tr>
 <tr >
                <td class="saludo1" style="width:7%">:&middot; Adjunto:</td>
                <td colspan='3'><input name="adjuntom" type="file" id="adjunto" style="width:100%" required></td></tr>
                <td class="saludo1" style="width:9%">:&middot; Imagen:</td>
                <td style="width:45%" ><input name="graimagenm" type="file" id="graimagenm" style="width:100%" accept="image" > <input name="ocuimagen" id="ocuimagen" type="hidden" value="<?php echo $_POST[ocuimagen];?>"></td>
                <td id="vista_previam" height="310px" colspan="2" rowspan="2" style="background-color:#ffffff;font-weight:normal;border:#CCCCCC 1px solid;padding-left:3px;padding-right:3px;margin-bottom:1px;margin-top:1px;-webkit-border-radius: 2px;">
                	<img id="imagencm" src="<?php echo $_POST[imagencm];?>" style=" width:100%; alignment-adjust:middle;">
        		</td>
             </tr>
             <tr>   
                <td class="saludo1" style="width:9%">:&middot; Descripci&oacute;n:</td>
                <td id="areadetexto"  colspan="1" ><textarea id="gradescrm" name="gradescrm"  style="width:100%; height:410px" >
<?php echo $_POST[gradescrm];?></textarea><input  type="hidden" id="oculto2" name="oculto2" value="1"><input type="hidden" id="ocuidm" name="ocuidm"></td>
            </tr>
        </table>
    </span>
    <span id="tablabuscar" class="ocultabuscar">
    	
  			<table class="inicio">
                <tr >
                  <td height="25" colspan="4" class="titulos" >:.Buscar Informaci&oacute;n de Inter&eacute;s </td>
                  <td width="5%" class="cerrar" ><a href="plan-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                  <td colspan="5" class="titulos2" >:&middot; Por Descripci&oacute;n </td>
                </tr>
				<tr >
				  <td width="13%" class="saludo1" >:&middot; Prioridad:</td>
				  <td  colspan="3"><input name="numero" type="text" size="30" >
			      <input name="oculto" type="hidden" id="oculto" value="1" >
                  <input name="ocudel" type="hidden" id="ocudel" value="1">
                  <input name="iddel" type="hidden" id="iddel" value="1">
                  
				  <input name="ac" type="hidden" id="ac" value="1" >
			      <input name="cod" type="hidden" id="cod" value="1" >
			      </td>
			    </tr>
			</table>
		
    </span>
    <span id="tablarebuscar" class="ocultarebuscar">
		<div class="subpantallap">
	<table class="inicio">        
    	<tr>
      		<td class="titulos" colspan="7">:: Prioridades</td>
        </tr>
        <tr >
   			
            <td class="titulos2" >Titulo</td>
            <td class="titulos2" >Imagen</td>
            <td class="titulos2" >Texto</td>
            <td class="titulos2" style=" width:5%">Editar</td>
            <td class="titulos2" style=" width:5%">Eliminar</td>
         </tr>
            <?php 
				$oculto=$_POST['oculto'];
                if($oculto=="2")
				{
				$cond=" (titulos like'%".$_POST[numero]."%')";
                $sqlr="SELECT distinct * FROM infor_interes WHERE".$cond."  ORDER BY indices ASC"; 
                $res=mysql_query($sqlr,$linkbd);//ASC acendente DESC desendedte
                $iter='saludo1';
                $iter2='saludo2';
				$contador1=1;		
                while ($rowEmp = mysql_fetch_assoc($res)) 
                {
                    echo '<tr class="'.$iter.'" ><td >'.$rowEmp['titulos'].'</td>
                    <td>'.$rowEmp['imgnombre'].'</td>
                    <td>'.$rowEmp['texnombre'].'</td>
					<td><a href="#"><img id="'.$rowEmp['indices'].'" src="imagenes/b_edit.png" onClick="Mostrar_Modificar(this.id);" /></a></td>
					<td><a href="#"><img id="'.$rowEmp['indices'].'" src="imagenes/del.png" onClick="eliminar_registro(this.id);" /></a></td></tr>';
                    $aux=$iter;
                    $iter=$iter2;
                    $iter2=$aux;
				?>
					<script>
						modtitulo['<?php echo $rowEmp['indices'];?>']= '<?php echo $rowEmp['titulos'] ;?>';
						modimgnombre['<?php echo $rowEmp['indices'];?>']= '<?php echo $rowEmp['imgnombre'] ;?>';
						modimgtipo['<?php echo $rowEmp['indices'];?>']= '<?php echo $rowEmp['imgtipo'] ;?>';
						modtexnombre['<?php echo $rowEmp['indices'];?>']= '<?php echo $rowEmp['texnombre'] ;?>';
						modtextipo['<?php echo $rowEmp['indices'];?>']= '<?php echo $rowEmp['textipo'] ;?>';
                   	</script>
				<?php
				$contador1++;
                }
				$_POST[oculto]="1";	
				}
            ?>
         </table>
		</div>
	</span>  

        <script>
			//function cargar_imagen(){
    		if (window.FileReader) {
      			function seleccionArchivo(evt) 
	  			{
       				var files = evt.target.files; 
					var f = files[0];
					var leerArchivo = new FileReader();
					leerArchivo.onload = (function(elArchivo) {
					return function(e) {document.getElementById('vista_previa').innerHTML = '<img src="'+ e.target.result +'" alt=""  style="height:100%; width:100%; alignment-adjust:middle;"  />';};})(f);
        			leerArchivo.readAsDataURL(f);
					var oculto1=document.getElementById('oculto1');
     			}
				function seleccionArchivo2(evt) 
	  			{
       				var files = evt.target.files; 
					var f = files[0];
					var leerArchivo = new FileReader();
					leerArchivo.onload = (function(elArchivo) {
					return function(e) {document.getElementById('vista_previam').innerHTML = '<img src="'+ e.target.result +'" alt=""  style="height:100%; width:100%; alignment-adjust:middle;"  />';};})(f);
        			leerArchivo.readAsDataURL(f);
					var oculto2=document.getElementById('oculto2');
     			}
     		} 
			else {document.getElementById('vista_previa').innerHTML = "El navegador no soporta vista previa";}
     		 document.getElementById('graimagen').addEventListener('change', seleccionArchivo, false);
			 document.getElementById('graimagenm').addEventListener('change', seleccionArchivo2, false);
    </script>
    <?php 
				if (is_uploaded_file($_FILES['adjunto']['tmp_name'])) 
				{
					copy($_FILES['adjunto']['tmp_name'], 'informacion/adjuntos/'.$_FILES['adjunto']['name'].'');
					$adnombre=$_FILES['adjunto']['name'];
 				}
				else
				{$adnombre="";}
				
				//combertir en .txt	el textarea	
		$oculto1=$_POST['oculto1'];
			if($oculto1=="2")
			{
				//almacenar en el servidor la imagen
				if (is_uploaded_file($_FILES['graimagen']['tmp_name'])) 
				{
					copy($_FILES['graimagen']['tmp_name'], 'informacion/imagenes/'.$_FILES['graimagen']['name'].'');
					$imgarchivo=$_FILES['graimagen']['tmp_name'];
					$imgtipo=$_FILES['graimagen']['type'];
					$imgnombre=$_FILES['graimagen']['name'];
 				}
				else
				{
					$imgtipo="NULL";
					$imgnombre="sinimagen1.jpg";
				}
				//almacenar en el servidor archivo
				
				$ar=fopen("informacion/archivos/".$_POST[gratitulo].".txt","a") or die("Problemas en la creacion");
				fputs($ar,$_REQUEST['gradescr']);
				fputs($ar,"\n");
				fclose($ar);
				
				//comprimir archivos txt
				$zip = new ZipArchive(); 
				$filename = 'informacion/archivos/'.$_POST[gratitulo].'.zip'; 
				if($zip->open($filename,ZIPARCHIVE::CREATE)===true) 
				{ 
					$zip->addFile('informacion/archivos/'.$_POST[gratitulo].'.txt'); 
					$zip->close(); 
				} 
				else { echo 'Error creando '.$filename; } 
				
				//comprimir archivos imagen
				$zip = new ZipArchive(); 
				$filename = 'informacion/imagenes/'.$_POST[gratitulo].'.zip'; 
				if($zip->open($filename,ZIPARCHIVE::CREATE)===true) 
				{ 
					$zip->addFile('informacion/imagenes/'.$_FILES['graimagen']['name']); 
					$zip->close(); 
				} 
				else { echo 'Error creando '.$filename; }
				//archivar
				
				$texnombre=$_POST[gratitulo].'.txt';
				$titulo=$_POST[gratitulo];
				$sqlr="INSERT INTO infor_interes VALUES (NULL,'$_SESSION[cedulausu]','$titulo','$imgnombre','$imgtipo','$texnombre',NULL,'$_POST[fechaini]','$_POST[fechafin]','$adnombre','S')";
				$res=mysql_query($sqlr,$linkbd);
				$_POST['oculto1']="1";
				?> <script> alert("La información se Guardo con exito");</script><?php
			}
		//Modificar
		if (is_uploaded_file($_FILES['adjuntom']['tmp_name'])) 
				{
					copy($_FILES['adjuntom']['tmp_name'], 'informacion/adjuntos/'.$_FILES['adjuntom']['name'].'');
					$adnombre=$_FILES['adjuntom']['name'];
 				}
				else
				{$adnombre="";}
		$oculto2=$_POST['oculto2'];
		if ($oculto2=="2")
		{
			if (($_POST[ocuidm]!="")&&($_POST[gratitulom]!=""))
			{
				//almacenar en el servidor la imagen
				
				if (is_uploaded_file($_FILES['graimagenm']['tmp_name'])) 
				{
					copy($_FILES['graimagenm']['tmp_name'], 'informacion/imagenes/'.$_FILES['graimagenm']['name'].'');
					$imgtipo=$_FILES['graimagenm']['type'];
					$imgnombre=$_FILES['graimagenm']['name'];
 				}
				else
				{
					$imgtipo="NULL";
					$imgnombre=$_POST[ocuimagen];
				}
				$idinforma=	$_POST[ocuidm];	
				$texnombre=$_POST[gratitulom].'.txt';
				$titulo=$_POST[gratitulom];
				//combertir en .txt	el textarea	
				$ar=fopen("informacion/archivos/".$_POST[gratitulom].".txt","w+") or die("Problemas en la creacion");
				fputs($ar,$_REQUEST['gradescrm']);
				fputs($ar,"\n");
				fclose($ar);
				$sqlr = "UPDATE infor_interes SET  indices = '$idinforma',usuario = '$_SESSION[cedulausu]',titulos = '$titulo',imgnombre= '$imgnombre', imgtipo = '$imgtipo',texnombre = '$texnombre',textipo =  NULL, fecha_inicio='$_POST[fechainim]',fecha_fin='$_POST[fechafinm]',adjunto='$adnombrem',estado='S' WHERE indices =  '$idinforma'";
				if(mysql_query($sqlr,$linkbd))
					 {?> <script> alert("La información se Modifico con exito");</script><?php }
			}
			$_POST['oculto2']="1";
		}
		
		//Eliminar
		if($_POST[ocudel]=="2")
		{
			if (($_POST[iddel]!="")&&($_POST[iddel]!="0"))
			{
				$sqlr ="SELECT * FROM infor_interes WHERE indices='$_POST[iddel]'";
				$res=mysql_query($sqlr,$linkbd);		
                $rowEmp = mysql_fetch_assoc($res);
				/*$trozos = explode("." , $rowEmp['imgnombre']);
				$cuantos = count($trozos);
				$ext = $trozos[0];*/ //separar la extencion del nombre al archivo
				unlink("informacion/imagenes/".$rowEmp['titulos'].".zip");
				unlink("informacion/archivos/".$rowEmp['titulos'].".zip");
				unlink("informacion/imagenes/".$rowEmp['imgnombre']);
				unlink("informacion/archivos/".$rowEmp['texnombre']);
				$sqlr ="DELETE FROM infor_interes WHERE indices='$_POST[iddel]'";
				if(mysql_query($sqlr,$linkbd)){ ?> <script> alert("La información se Elimino con exito");</script><?php }
			}
			$_POST['ocudel']="1";
		}
	?>
    <script>
    		document.getElementById('tablanuevo').style.display = document.getElementById('oculnuevo').value;
			document.getElementById('tablamodificar').style.display = document.getElementById('oculmodificar').value;
			document.getElementById('tablabuscar').style.display = document.getElementById('oculbuscar1').value;
			document.getElementById('tablarebuscar').style.display = document.getElementById('oculbuscar2').value;
			//alert (document.getElementById('tablanuevo').style.display);
			try {
				var z=document.getElementById('tablanuevo').style.display;
				if(z==""){Mostrar_tabla('tablanuevo');}}
			catch(e){alert(e.name + " - "+e.message);}
			
			
    </script>
 	</form>
    </body>
</html>