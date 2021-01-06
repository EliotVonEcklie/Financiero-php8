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
	 	<?php require "head.php"; ?>
		<title>:: Spid - Calidad</title>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('codigo').value;
				var validacion02=document.getElementById('nombre').value;
				if (validacion01.trim()!='' && validacion02.trim()!='')
			  		{despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
			  	else
				{
			  		despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.nombre.focus();document.form2.nombre.select();
			  	}
			 }
			function agregardetalle()
			{
				validacion01=document.getElementById('nombredet').value
				validacion02=document.getElementById('iddet').value
				if(validacion01.trim()!='' && validacion02.trim()!=''){
					document.form2.agregadet.value="1";
					document.getElementById('oculto').value='7';
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta información para poder Agregar Detalle de la Variable del Plan de Acción');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar el Detalle de la Variable del Plan de Acción','2');
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
			function funcionmensaje(){document.location.href = "meci-buscavaraccion.php?idproceso="+document.getElementById('codigo').value;}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value='2';break;
					case "2":	document.getElementById('oculto').value='3';break;
					case "3":	document.form2.cambioestado.value="1";break;
					case "4":	document.form2.cambioestado.value="0";break;
				}
				document.form2.submit();
			}
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea activar este Detalle de la Variable del Plan de Acción','3');}
				else{despliegamodalm('visible','4','Desea Desactivar este Detalle de la Variable del Plan de Acción','4');}
			}
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="meci-editavaraccion.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="meci-editavaraccion.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="meci-buscavaraccion.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					<a onclick="location.href='meci-varaccion.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png" /><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png" /><span class="tiptext">Guardar</span></a>
					<a onclick="location.href='meci-buscavaraccion.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png"/><span class="tiptext">Buscar</span></a>
					<a onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="tooltip bottom mgbt"><img src="imagenes/iratras.png"><span class="tiptext">Atrás</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
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
        	<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
     		<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
 			<?php
			if ($_GET[idproceso]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idproceso];</script>";}
			$sqlr="select MIN(id), MAX(id) from calvaraccion ORDER BY id";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idproceso]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from calvaraccion where id='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from calvaraccion where id ='$_GET[idproceso]'";
					}
				}
				else{
					$sqlr="select * from  calvaraccion ORDER BY id DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}
		
 			if(($_POST[oculto]!="2")&&($_POST[oculto]!="3")&&($_POST[oculto]!="7")){	
					$sqlr="Select * from calvaraccion where id=$_POST[codigo] ";
					$resp = mysql_query($sqlr,$linkbd);
	    			while ($row =mysql_fetch_row($resp))
					{
						$_POST[codigo]=$row[0];
						$_POST[nombre]=$row[1];					
						$_POST[estado]=$row[2];		
					}
				}
				unset($_POST[estadosub]);
				unset($_POST[dids]);
 				unset($_POST[dnvars]);
				unset($_POST[dadjs]);	
				$sqlr="Select * from calvaraccion_det where id_varaccion=$_POST[codigo] ";
				$resp = mysql_query($sqlr,$linkbd);
	    		while ($row =mysql_fetch_row($resp))
				{
					$_POST[dids][]=$row[2];
					$_POST[dnvars][]=$row[1];
					$_POST[dadjs][]=$row[3];
					$_POST[estadosub][]=$row[4];
				}
				
				//*****************************************************************
				if($_POST[cambioestado]!="")
				{
					if($_POST[cambioestado]=="1")
					{
						$sqlr="UPDATE calvaraccion_det SET estado='S' WHERE id_det = '$_POST[idestado]' AND id_varaccion = '$_POST[codigo]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd));
					}
					else 
					{
						$sqlr="UPDATE calvaraccion_det SET estado='N' WHERE id_det = '$_POST[idestado]' AND id_varaccion = '$_POST[codigo]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					echo"<script>document.form2.cambioestado.value='';document.form2.submit();</script>";
				}
				//*****************************************************************
				if($_POST[nocambioestado]!="")
				{
					if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
					else {$_POST[lswitch1][$_POST[idestado]]=0;}
					echo"<script>document.form2.nocambioestado.value=''</script>";
				}
			//NEXT
			$sqln="select *from calvaraccion WHERE id > '$_POST[codigo]' ORDER BY id ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from calvaraccion WHERE id < '$_POST[codigo]' ORDER BY id DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
			?>
 			<table class="inicio ancho" >
   				<tr>
     				  <td class="titulos" colspan="6" width="100%">Editar Variable Plan Acción</td>
                    <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
             	</tr>
   				 <tr>
                    <td class="saludo1" style="width:1.5cm">Código:</td>
                    <td style="width:7%;">
	        	    	<a onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" class="centrartext" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:35%" readonly/>
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
                    <td class="saludo1" style="width:1.5cm">Nombre:</td>
                    <td style="width:35%;"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:90%;"/></td>
                    <td class="saludo1" style="width:1.5cm">Estado:</td>
                    <td> 
                        <select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
                            <option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
                            <option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
                        </select>
                    </td>
                </tr>
   			</table>
			<table class="inicio ancho" >
 				<tr><td class="titulos" colspan="6">Agregar Detalles Variable Plan Acción</td></tr>
 				 <tr>
                    <td class="saludo1" style="width:1.5cm">Id:</td>
                    <td style="width:7%;"><input type="text" name="iddet" id="iddet" value="<?php echo $_POST[iddet];?>" style="width:60%"></td>
                    <td class="saludo1" style="width:1.5cm">Nombre:</td>
                    <td style="width:35%;"><input type="text" name="nombredet" id="nombredet" value="<?php echo $_POST[nombredet];?>" style="width:90%;"></td>
                    <td class="saludo1" style="width:4.6cm">Archivo Adjunto Obligatorio:</td>
                    <td>
                        <select name="adjuntodet" id="adjuntodet" onKeyUp="return tabular(event,this)" >
                            <option value="N" <?php if($_POST[adjuntodet]=='N') echo "SELECTED"; ?>>NO</option>
                            <option value="S" <?php if($_POST[adjuntodet]=='S') echo "SELECTED"; ?>>SI</option>
                        </select>&nbsp; 
                        <em class="botonflecha" name="agregar" id="agregar" onClick="agregardetalle()" >Agregar</em>
                 	</td>
                </tr>
 			</table>     
 			<input type="hidden" name="oculto" id="oculto" value="1">
 			<input type="hidden" name="agregadet" id="agregadet" value="0">
            <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
            <input type='hidden' name='elimina' id='elimina' value="<?php echo $_POST[elimina];?>">
            <div class="subpantalla" style="height:59.5%; width:99.6%; overflow-x:hidden;">
 				<table class="inicio" >
   					<tr><td class="titulos" colspan="5">Detalle Variables Plan de Acción</td></tr>
					<tr class="centrartext">
						<td class="titulos2">No</td>
                        <td class="titulos2">Nombre Variable</td>
                        <td class="titulos2">Archivo Adjunto Obligatorio</td>
                        <td class='titulos2' style="width:7%;">ESTADO</td>
   					</tr>    
   					<?php 
						if ($_POST[oculto]=='3')
		 				{ 
		 					$posi=$_POST[elimina];
							unset($_POST[estadosub][$posi]);
		 					unset($_POST[dids][$posi]);
 		 					unset($_POST[dnvars][$posi]);
		 					unset($_POST[dadjs][$posi]);	
							$_POST[estadosub]= array_values($_POST[estadosub]);		 		 		 		 		 
		 					$_POST[dids]= array_values($_POST[dids]); 
		 					$_POST[dnvars]= array_values($_POST[dnvars]); 
		 					$_POST[dadjs]= array_values($_POST[dadjs]); 
		 					 echo"<script>document.form2.elimina.value='';</script>";		 		 		 
		 				}	 
		 				if ($_POST[agregadet]=='1')
		 				{
							 if (in_array($_POST[iddet], $_POST[dids]))
                                    {echo "<script>despliegamodalm('visible','2','ID del Detalle duplicado favor corregir');</script>";}
							 else
                                {
									$_POST[estadosub][]="T";
									$_POST[dids][]=$_POST[iddet];
									$_POST[dnvars][]=$_POST[nombredet];
									$_POST[dadjs][]=$_POST[adjuntodet]; 		 
									$_POST[agregadet]=0;
									echo"
									<script>
										document.form2.iddet.value='';
										document.form2.nombredet.value='';
										document.form2.iddet.focus();	
									 </script>";
								}
		  				}
						$iter='saludo1';
						$iter2='saludo2';
						for ($x=0;$x<count($_POST[dnvars]);$x++)
		 				{		 
							echo "
							<input type='hidden' class='inpnovisibles' name='estadosub[]' value='".$_POST[estadosub][$x]."'>
							<tr class='$iter'>
								<td style='width:5%;'><input class='inpnovisibles centrartext' type='text' name='dids[]' value='".$_POST[dids][$x]."'  style='width:100%;text-transform:uppercase' readonly></td>
								<td><input class='inpnovisibles' type='text' name='dnvars[]' value='".$_POST[dnvars][$x]."' style='width:100%;text-transform:uppercase' readonly></td>
								<td style='width:14%;'><input class='inpnovisibles centrartext' type='text' name='dadjs[]' value='".$_POST[dadjs][$x]."' style='width:100%;text-transform:uppercase' readonly></td>";
							if ($_POST[estadosub][$x]!="T")
                            {
                                if($_POST[estadosub][$x]=='S'){$coloracti="#0F0";$_POST[lswitch1][$_POST[dids][$x]]=0;}
                                else{$coloracti="#C00";$_POST[lswitch1][$_POST[dids][$x]]=1;}
                                echo"<td class='centrartext'><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$_POST[dids][$x]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"".$_POST[dids][$x]."\",\"".$_POST[lswitch1][$_POST[dids][$x]]."\")' $abilitado /></td></tr>";
                            }
                            else {echo"<td colspan='2' style='text-align:center;'><a href='#' onclick='eliminar($x);'><img src='imagenes/del.png'></a></td></tr>";}
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
		  			?>                 
  				</table>   
			</div>   
 			<?php  
 				if($_POST[oculto]=="2")
				{
					$sqlr="UPDATE calvaraccion SET nombre='$_POST[nombre]', estado='$_POST[estado]' WHERE id=$_POST[codigo]";	
					if (!mysql_query($sqlr,$linkbd))
					{echo"<script>despliegamodalm('visible','2','ERROR EN LA CREACION DE LA VARIABLE DEL PLAN DE ACCION');document.form2.nombre.focus();</script>";}
		  			else
		  			{
		   				for ($x=0;$x<count($_POST[dnvars]);$x++)
		 				{
							if ($_POST[estadosub][$x]=="T")
							{
			 					$sqlr="INSERT INTO calvaraccion_det (id_varaccion, nombre,id_det, adjunto,estado) VALUES ($_POST[codigo], '".$_POST[dnvars][$x]."', '".$_POST[dids][$x]."','".$_POST[dadjs][$x]."','S') ";	
			 					mysql_query($sqlr,$linkbd);
							}
						}
						echo"
						<script>
							despliegamodalm('visible','3','Se Modifico la Variable del Plan de Acci�n con Exito');
						</script>";
		  			}
				}
			?>
 		</form>       
	</body>
</html>