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
    	<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
    	<script>
    		function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if (validacion01.trim()!='' && document.getElementById('codigo').value!='')
			  		{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
			  	else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
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
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="presu-tipomovimientoeditar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="presu-tipomovimientoeditar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				var idcta1=document.getElementById('id').value;
				location.href="presu-tipomovdocumentosbuscar.php?idcta="+idcta1+"&idcta1="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("presu");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
					<img src="imagenes/add.png"  title="Nuevo" href="presu-tipomovimiento.php" class="mgbt"/><img src="imagenes/guardad.png" title="Guardar"  href="#"  class="mgbt"/><img src="imagenes/busca.png" title="Buscar" href="presu-tipomovdocumentosbuscar.php" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda"  onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt">
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
			if ($_GET[codproceso]!=""){echo "<script>document.getElementById('codrec1').value=$_GET[codproceso];</script>";}
			$sqlr="SELECT MIN(id), MAX(id) FROM tipo_movdocumentos ORDER BY id";
			
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idproceso]!=""){
					if($_POST[codrec]!=""){
						$sqlr="SELECT * FROM tipo_movdocumentos where id='$_POST[codrec]' and codigo='$_GET[codproceso]' ";
						
					}
					else{
						$sqlr="SELECT * FROM tipo_movdocumentos where id='$_GET[idproceso]' and codigo='$_GET[codproceso]'";
						
					}
				}
				else{
					$sqlr="SELECT * FROM tipo_movdocumentos  ORDER BY id DESC";
					
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[1];
				$_POST[id]=$row[0];
				$_POST[nombre]=$row[2];
				$_POST[estado]=$row[3];
				
			}
		
 			if($_POST[oculto]!="2")
        		{
					$sqlr="SELECT id,codigo,descripcion,estado FROM tipo_movdocumentos where id=".$_POST[id]."and codigo =".$_POST[codigo];
            		$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$_POST[id]=$row[0];
						
						$_POST[codigo]=$row[1];
		
						$_POST[nombre]=$row[2];
											
						$_POST[estado]=$row[3];
					
					}
        		}
			//NEXT
			$sqln="SELECT * FROM tipo_movdocumentos where CONVERT(id, SIGNED INTEGER) > CONVERT('$_POST[id]', SIGNED INTEGER) ORDER BY CONVERT(id, SIGNED INTEGER) ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="SELECT * FROM tipo_movdocumentos WHERE CONVERT(id, SIGNED INTEGER) < CONVERT('$_POST[id]', SIGNED INTEGER) ORDER BY CONVERT(id, SIGNED INTEGER) DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
     		?>
   			<table class="inicio" >
				<tr>
       				<td class="titulos" colspan="6">Editar Tipo de Movimientos</td>
         			<td class="cerrar" style="width:7%;"><a href="meci-principal.php">&nbsp;Cerrar</a></td>
				</tr>
   				<tr>
        			<td class="saludo1" style="width:2cm">C&oacute;digo:</td>
                    <td style="width:10%;">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:35%;" readonly />
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
						<input type="hidden" value="<?php echo $_POST[codrec1]?>" name="codrec1" id="codrec1">
						<input type="hidden" name="id" id="id" value="<?php echo $_POST[id]?>"/>
                   	</td>
					<td class="saludo1" style="width:2cm">Nombre:</td>
            		<td style="width:35%"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)" style="width:100%"/></td>
   					<td class="saludo1" style="width:2cm">Estado</td>
            		<td> 
            			<select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
          					<option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
          					<option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
        				</select>
        			</td>
   				</tr>
   			</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
 			<?php  
 				if($_POST[oculto]=="2")//********guardar
				{
					$sqlr="UPDATE tipo_movdocumentos SET descripcion='$_POST[nombre]',estado='$_POST[estado]' WHERE codigo=$_POST[codigo] ";
					if (!mysql_query($sqlr,$linkbd))
					{echo"<script>despliegamodalm('visible','2',''Error no se almaceno el Tipo de Movimiento');</script>";}
		  			else {echo"<script>despliegamodalm('visible','3','Se Modifico el Tipo de Movimiento con Exito');</script>";}
				}
 			?>	
		</form>              
	</body>
</html>