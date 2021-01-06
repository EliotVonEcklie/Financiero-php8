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
	$idcta=$_GET['idproceso'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid - Control de Activos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('codigo').value
				var validacion02=document.getElementById('nombre').value
				if (validacion01.trim()!='' && validacion02.trim()!='' && document.form2.contdet.value!=0){
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.nombre.focus();
					document.form2.nombre.select();
				}
			}
			function agregardetalle()
			{
				validacion01=document.getElementById('nombredet').value;
				if(validacion01.trim()!=''){
					document.getElementById('oculto').value='1';
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
		 		else {despliegamodalm('visible','2','Falta información para poder Agregar Detalle de Modalidad');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar el Detalle de Modalidad','2');
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
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje()
			{document.location.href = "acti-editargrupos?idproceso="+document.getElementById('codigo').value;}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.form2.oculto.value=2;
						document.form2.submit();
						break;
					case "2":	
						document.form2.contdet.value=parseInt(document.form2.contdet.value)-1;
						document.getElementById('oculto').value='7';
						document.form2.submit();
						break;
				}
			}
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.form2.oculto.value="2";
									document.form2.submit();break;
						case "2":	document.form2.contdet.value=parseInt(document.form2.contdet.value)-1;
									document.getElementById('oculto').value='7';
									document.form2.submit();break;
						case "3":	document.form2.cambioestado.value="1";break;
						case "4":	document.form2.cambioestado.value="0";break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "3":	
							document.form2.nocambioestado.value="1";
							break;
						case "4":	
							document.form2.nocambioestado.value="0";
							break;
					}
				}
				document.form2.submit();
			}
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				document.getElementById('cambioestado').value=valor;
				if(valor==1){
					despliegamodalm('visible','4','Desea activar este Grupo','3');
				}else{
					despliegamodalm('visible','4','Desea Desactivar este Grupo','4');
				}
			}
		</script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=next;
				var idcta=document.getElementById('codigo').value;
				document.form2.action="acti-editargrupos.php?idproceso="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=prev;
				var idcta=document.getElementById('codigo').value;
				document.form2.action="acti-editargrupos.php?idproceso="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}

			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="acti-buscagrupo.php?idproceso="+idcta;
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
    		<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("acti");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
	  				<a href="acti-grupos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
	  				<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
	  				<a href="acti-buscagrupo.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
	  				<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
	  				<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
  				</td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action=""> 
        	<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
     		<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
			<?php
           	$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
           	//********guardar
 				if($_POST[oculto]=="2")
				{	
					$sqlr="DELETE FROM acti_grupo WHERE id_clase=$_POST[codigo]";
					echo $sqlr.'<br>';
					mysql_query($sqlr,$linkbd);

					for ($x=0;$x<count($_POST[dnvars]);$x++)
					{//acti_grupo (id_clase,nombre) values ('$_POST[codigo]','".$_POST[dnvars][$x]."') ";
						$sqlr="INSERT into acti_grupo (id_clase,nombre,estado) values ($_POST[codigo],'".$_POST[dnvars][$x]."','".$_POST[estadosub][$x]."')";
						//echo $sqlr.'<br>';
						mysql_query($sqlr,$linkbd);
					}
					echo"<script>despliegamodalm('visible','3','Se Modifico el Grupo con Exito');</script>";
	  			}
			if ($_GET[idproceso]!=""){
				echo "<script>document.getElementById('codrec').value=$_GET[idproceso];</script>";
			}
			
			if($_POST[oculto]==""){				
			   	$_POST[codigo]=$_GET[idproceso];
			}

			 //*****************************************************************
			if($_POST[cambioestado]!=""){
				if($_POST[cambioestado]=="1"){
					$sqlr="UPDATE acti_grupo SET estado='S' WHERE id='$_POST[idestado]' AND id_clase='$_POST[codigo]'";
					//echo '<br>'.$sqlr;
					mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
				}
				else{
					$sqlr="UPDATE acti_grupo SET estado='N' WHERE id='$_POST[idestado]' AND id_clase='$_POST[codigo]'";
					//echo '<br>'.$sqlr;
					mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
				}
				echo"<script>document.form2.cambioestado.value='';document.form2.submit();</script>";
			}


          	$_POST[cambioestado]="";
            $_POST[nocambioestado]="";
            $_POST[contdet]=0;

			if(($_POST[oculto]!="2")&&($_POST[oculto]!="7")){
            	$sqlr="SELECT * FROM acti_clase WHERE id=$_POST[codigo]";
            	//echo $sqlr;
               	$resp = mysql_query($sqlr,$linkbd);
                while ($row =mysql_fetch_row($resp)){
                	$_POST[codigo]=$row[0];
                  	$_POST[nombre]=strtoupper($row[1]);				
                    $_POST[estado]=$row[2];
               	}
           	}
			unset($_POST[estadosub]);
			unset($_POST[dids]);
            unset($_POST[dnvars]);
            unset($_POST[dadjs]);
            $sqlr2="SELECT * FROM acti_grupo WHERE id_clase=$_POST[codigo] ORDER BY id";
            //echo $sqlr2;
           	$resp2=mysql_query($sqlr2,$linkbd);
            while ($row2=mysql_fetch_row($resp2)){
               	$_POST[dids][]=$row2[0];
                $_POST[dnvars][]=$row2[2];
                $_POST[dadjs][]=$row2[1];
                $_POST[estadosub][]=$row2[3];
                $_POST[contdet]=$_POST[contdet]+1;
           	}
           
			//*****************************************************************
			if($_POST[nocambioestado]!=""){
				if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
				else {$_POST[lswitch1][$_POST[idestado]]=0;}
				echo"<script>document.form2.nocambioestado.value=''</script>";
			}
			//NEXT
			$sqln="SELECT * FROM acti_clase WHERE id > $_POST[codigo] LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next=$row[0];
			//PREV
			$sqlp="SELECT * FROM acti_clase WHERE id < $_POST[codigo] ORDER BY id DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev=$row[0];
 			?>
            <table class="inicio" >
                <tr>
                    <td class="titulos" colspan="5">Buscar Clase</td>
                    <td class="cerrar" style="width:7%"><a href="acti-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:8%">Codigo:</td>
                    <td style="width:10%;">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:50%;" readonly>
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
					
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                   	</td>
                    <td class="saludo1" style="width:8%">Nombre</td>
                    <td><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:100%;" readonly></td>
               
                    <td class="saludo1">Estado</td>
                    <td> 
                        <select name="estado" id="estado" onKeyUp="return tabular(event,this)" disabled style="width:80%;">
                            <option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
                            <option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
                        </select>
                    </td>
                </tr>
            </table>
            <table class="inicio" >
                <tr><td class="titulos" colspan="4">Agregar Grupo</td></tr>
                <tr>
                    <td class="saludo1" style="width:8%">Nombre:</td>
                    <td>
                        <input name="nombredet" id="nombredet" type="text" value="<?php echo $_POST[nombredet];?>" style="width:54.5%;">
                        <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
                    </td>
                </tr>
            </table>
            <input type="hidden" name="oculto" id="oculto" value="1">
            <input type="hidden" value="0" name="agregadet">
            
            <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
            <input type="hidden" name="contdet" id="contdet" value="<?php echo $_POST[contdet]?>">
            <input type='hidden' name='elimina' id='elimina' value="<?php echo $_POST[elimina];?>">
            <div class="subpantalla" style="height:56%; width:99.6%; overflow-x:hidden;">
				<table class="inicio" >
   					<tr><td class="titulos" colspan="4">Grupos</td></tr>
                    <tr>
                        <td class="titulos2" style="width:5%;">No</td>
                        <td class="titulos2">Nombre Variable</td>
                        <td class='titulos2' colspan='2' style="width:5%;">ESTADO</td>
                    </tr>    
					<?php 
                        if ($_POST[elimina]!='')
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
                                if (true){
									$_POST[estadosub][]="T";
                                    $_POST[dids][]=$_POST[iddet];
                                    $_POST[dnvars][]=$_POST[nombredet];
                                    $_POST[dadjs][]=$_POST[adjuntodet]; 
                                    $_POST[agregadet]=0;
                                    echo"
                                    <script>
                                        document.form2.contdet.value=parseInt(document.form2.contdet.value)+1;
                                        document.form2.iddet.value='';
                                        document.form2.nombredet.value=''; 
                                        document.form2.iddet.focus();	
                                    </script>
                                    ";
                                }
                        }
                        $iter='saludo1a';
                        $iter2='saludo2';
                        for ($x=0;$x<count($_POST[dnvars]);$x++)
                        {		 
                            echo "
                            <input type='hidden' class='inpnovisibles' name='estadosub[]' value='".$_POST[estadosub][$x]."'>
                            <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
                                <td><input type='text' class='inpnovisibles' name='dids[]' value='".($x+1)."' readonly ></td>
                                <td ><input type='text' class='inpnovisibles' name='dnvars[]' value='..".$_POST[dnvars][$x]."' style='text-transform:uppercase;width: 100%;' readonly></td>";
                            
                                if($_POST[estadosub][$x]=='S'){
                                	$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";
                                	$_POST[lswitch1][$_POST[dids][$x]]=0;
                                		
                                }else{
                                	$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";
                                	$_POST[lswitch1][$_POST[dids][$x]]=1;
                                	
									
                                }
                                echo"<td style='text-align:center;'><img $imgsem style='width:20px'/></td><td><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$_POST[dids][$x]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"".$_POST[dids][$x]."\",\"".$_POST[lswitch1][$_POST[dids][$x]]."\")' $abilitado /></td></tr>";
                            
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
                        }
                    ?>
                </table> 
            </div>
 		</form>       
	</body>
</html>