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
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if (document.getElementById('codigo').value!='' && validacion01.trim()!='' && document.getElementById('valor').value !='')
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
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
			function funcionmensaje(){document.location.href = "hum-nivelsalarial.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
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
					document.form2.action="hum-editanivelsalarial.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="hum-editanivelsalarial.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="hum-buscanivelsalarial.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="hum-nivelsalarial.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="hum-buscanivelsalarial.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
			</tr>		  
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php
			if ($_GET[idr]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";}
			$sqlr="select MIN(id_nivel), MAX(id_nivel) from humnivelsalarial ORDER BY id_nivel";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idr]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from humnivelsalarial where id_nivel='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from humnivelsalarial where id_nivel ='$_GET[idr]'";
					}
				}
				else{
					$sqlr="select * from  humnivelsalarial ORDER BY id_nivel DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}

			if ($_POST[oculto]!="2")
 			{
				$sqlr="select * from humnivelsalarial where id_nivel=$_POST[codigo] ";
				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res))
				{
					$_POST[codigo]=$r[0];
					$_POST[nombre]=$r[1];
					$_POST[valor]=$r[2];	
					$_POST[estado]=$r[3];	
				}
			}
			//NEXT
			$sqln="select *from humnivelsalarial where id_nivel > '$_POST[codigo]' ORDER BY id_nivel ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from humnivelsalarial where id_nivel < '$_POST[codigo]' ORDER BY id_nivel DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
		?>
 		<form name="form2" method="post" action="">
    		<table class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="8">.: Agregar Nivel Salarial</td>
                    <td class="cerrar" style="width:7%" ><a href="hum-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
	  				<td class="saludo1" style="width:7%;">Numero:</td>
        			<td  style="width:6%;">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" maxlength="3" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:35%;" readonly/>
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                   	</td>
        			<td class="saludo1" style="width:7%;">Nivel:</td>
        			<td  style="width:30%;"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)"  style="width:98%;"/></td>
        			<td class="saludo1" style="width:7%;">Valor:</td>
        			<td  style="width:15%;"><input type="text" name="valor" id="valor" value="<?php echo $_POST[valor]?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width:98%;"/></td>
        			<td class="saludo1" style="width:7%;">Activo:</td>
                    <td>
                    	<select name="estado" id="estado" >
          					<option value="S" <?php if($_POST[estado]=="S"){echo "selected";}?> >SI</option>
         			 		<option value="N" <?php if($_POST[estado]=="N"){echo "selected";}?> >NO</option>
        				</select>        
                 	</td>
       			</tr>  
    		</table>
    		<input type="hidden" name="oculto" id="oculto"  value="1">
  			<?php
				if($_POST[oculto]==2)
				{
					$nr="1";
 					$sqlr="update humnivelsalarial set nombre='$_POST[nombre]',valor=$_POST[valor],estado='$_POST[estado]' where id_nivel='$_POST[codigo]'";
  					if (!mysql_query($sqlr,$linkbd))
					{
	 					echo"<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD, No se pudo ejecutar la petición humnivelsalarial');</script>";
					}
  					else {echo"<script>despliegamodalm('visible','3','Se ha Actualizado con Exito');</script>";}
 				}
			?> 
		</form>
	</body>
</html>