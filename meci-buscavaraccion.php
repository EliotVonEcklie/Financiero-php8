<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
  	require"funciones.inc";
  	session_start();
  	$linkbd=conectar_bd();  
  	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
  	header("Cache-control: private"); // Arregla IE 6
  	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
    	<?php require "head.php"; ?>
		<title>:: Spid - Calidad</title>
		<script>
			function verUltimaPos(idcta, filas, filtro){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="meci-editavaraccion.php?idproceso="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function cambioswitch(id1,id2,valor)
			{
				document.getElementById('idestado1').value=id1;
				document.getElementById('idestado2').value=id2;
				if(valor==1){despliegamodalm('visible','4','Desea Activar este Anexo','1');}
				else{despliegamodalm('visible','4','Desea Desactivar este Anexo','2');}
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
			function funcionmensaje(){}
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.form2.cambioestado.value="1";break;
						case "2":	document.form2.cambioestado.value="0";break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	document.form2.nocambioestado.value="1";break;
						case "2":	document.form2.nocambioestado.value="0";break;
					}
				}
				document.form2.submit();
			}
		</script>
        <?php
		$scrtop=$_GET['scrtop'];
		if($scrtop=="") $scrtop=0;
		echo"<script>
			window.onload=function(){
				$('#divdet').scrollTop(".$scrtop.")
			}
		</script>";
		$gidcta=$_GET['idcta'];
		if(isset($_GET['filtro']))
			$_POST[nombre]=$_GET['filtro'];
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("meci");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
					<a href="meci-varaccion.php" class="tooltip bottom mgbt"><img src="imagenes/add.png" title=""/><span class="tiptext">Nuevo</span></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/guardad.png"/></a>
					<a onClick="document.form2.submit()" class="tooltip bottom mgbt"><img src="imagenes/busca.png"  title=""/><span class="tiptext">Buscar</span></a>
					<a onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/nv.png" title=""><span class="tiptext">Nueva Ventana</span></a>
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
        <?php
		if($_GET[numpag]!=""){
			$oculto=$_POST[oculto];
			if($oculto!=2){
				$_POST[numres]=$_GET[limreg];
				$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
				$_POST[nummul]=$_GET[numpag]-1;
			}
		}
		else{
			if($_POST[nummul]==""){
				$_POST[numres]=10;
				$_POST[numpos]=0;
				$_POST[nummul]=0;
			}
		}
		?>
 		<form name="form2" method="post" action="meci-buscavaraccion.php">
        	<?php
				if($_POST[oculto]=="")
				{
					$_POST[cambioestado]="";
					$_POST[nocambioestado]="";
				}
				//*****************************************************************
				if($_POST[cambioestado]!="")
				{
					$iddivi = explode('_', $_POST[idestado2]);
					if($_POST[cambioestado]=="1")
					{
						$sqlr="UPDATE calvaraccion_det SET estado='S' WHERE id_det='$iddivi[0]' AND id_varaccion='$iddivi[1]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
						$sqlr="UPDATE calvaraccion_det SET estado='N' WHERE id_det='$iddivi[0]' AND id_varaccion='$iddivi[1]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
				}
				//*****************************************************************
				if($_POST[nocambioestado]!="")
				{
					if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
					else {$_POST[lswitch1][$_POST[idestado]]=0;}
					$_POST[nocambioestado]="";
				}
			?>
            <table  class="inicio ancho" align="center" >
                <tr>
                    <td class="titulos" colspan="2" width="100%">:: Buscar Variable Plan de Acci&oacute;n </td>
                    <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                </tr>
                <tr><td colspan="2" class="titulos2" >:&middot; Por Descripci&oacute;n </td></tr>
              	<tr>
                	<td style="width:3.5cm" class="saludo1">:. Código o Nombre:</td>
                	<td style="width:80%">
                    	<input name="nombre" type="text" style="width:50%" value="<?php echo $_POST[nombre]; ?>">
                    	<input name="oculto" id="oculto" type="hidden" value="1"> 
                	</td>
                	<td style="width:7%"></td>
               	</tr>                       
            </table>
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>"/>
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
            <input type="hidden" name="idestado1" id="idestado1" value="<?php echo $_POST[idestado1];?>">
            <input type="hidden" name="idestado2" id="idestado2" value="<?php echo $_POST[idestado2];?>">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    		<div class="subpantallac5" style="height:66%; width:99.6%; overflow-x:hidden;" id="divdet">
      			<?php
					$crit1="";
					if ($_POST[nombre]!="")
					$crit1="and concat_ws(' ', id, nombre) LIKE '%$_POST[nombre]%'";
					$sqlr="SELECT * FROM calvaraccion WHERE estado <> '' $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
                    $nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);

					$cond2="";
					if ($_POST[numres]!="-1"){ 
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}
					$sqlr="SELECT * FROM calvaraccion WHERE estado <> '' $crit1 ORDER BY id ".$cond2;
					$resp = mysql_query($sqlr,$linkbd);
					$con=1;
					$numcontrol=$_POST[nummul]+1;
					if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1")){
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
					}
					else{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if(($_POST[numpos]==0)||($_POST[numres]=="-1")){
						$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
					}
					else{
						$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					echo "
					<table class='inicio' align='center' width='80%'>
						<tr>
							<td colspan='4' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu'>
                                <select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
                                    <option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
                                    <option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
                                    <option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
                                    <option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
                                    <option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
									<option value='-1'"; if ($_POST[renumres]=='-1'){echo 'selected';} echo ">Todos</option>
                                </select>
                            </td>
						</tr>
						<tr><td colspan='7'>Encontrados: $_POST[numtop]</td></tr>
						<tr class='centrartext'>
							<td width='5%' class='titulos2'>C&oacute;digo</td>
							<td class='titulos2' style='width:25%;'>Nombre</td>
							<td class='titulos2'>Detalle</td>
							<td class='titulos2' style='width:5%;'>Adjunto</td>
							<td class='titulos2' colspan='2' style='width:6%;'>Estado</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
 					while ($row =mysql_fetch_row($resp)) 
 					{
						$con2=$con+ $_POST[numpos];
						$sqlr2="SELECT * FROM calvaraccion_det WHERE id_varaccion='$row[0]' ORDER BY id_det";
						$resp2=mysql_query($sqlr2,$linkbd);
						$row2 =mysql_fetch_row($resp2);
						$ntr2 = mysql_num_rows($resp2);
						$nomcod="codigo".$con2;
						$nomnom="nombre".$con2;
						$posid1=$row2[2]."H".$row2[0];
						$posid2="$row2[2]_$row2[0]";
						if($row2[3]=='S'){$tiparc="SI";}
						else {$tiparc="NO";}
						if($row2[4]=='S')
							{$coloracti="#0F0";$_POST[lswitch1][$posid1]=0;}
						else
							{$coloracti="#C00";$_POST[lswitch1][$posid1]=1;}
						if($gidcta!=""){
							if($gidcta==$row[0]){
								$estilo='background-color:#FF9';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
						$idcta="'".$row[0]."'";
						$numfil="'".$filas."'";
						$filtro="'".$_POST[nombre]."'";
						echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
	 							<td rowspan='$ntr2' class='centrartext icoop' id='$nomcod'>$row[0]</td>
								<td  class='icoop' rowspan='$ntr2' id='$nomnom'>$row[1]</td>
								<td class='icoop'>$row2[1]</td>
								<td class='centrartext icoop'>$tiparc</td>
								<td class='centrartext'><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$posid1]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$posid1\",\"$posid2\",\"".$_POST[lswitch1][$posid1]."\")' /></td>
							</tr>";
						if($ntr2!=1)
						{
							while ($row2 =mysql_fetch_row($resp2))
							{	
								$posid1=$row2[2]."H".$row2[0];
								$posid2="$row2[2]_$row2[0]";
								if($row2[4]=='S')
								{
									$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";
									$coloracti="#0F0";
									$_POST[lswitch1][$posid1]=0;
								}
								else 
								{
									$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";
									$coloracti="#C00";
									$_POST[lswitch1][$posid1]=1;
								}
								echo "
	 							<tr class='$iter' onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor=document.getElementById('$nomcod').style.backgroundColor=document.getElementById('$nomnom').style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=document.getElementById('$nomcod').style.backgroundColor=document.getElementById('$nomnom').style.backgroundColor=anterior\" style='text-transform:uppercase; $estilo'>
									<td class='icoop'>$row2[1]</td>
									<td class='centrartext icoop'>$tiparc</td>
									<td class='centrartext'><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$posid1]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$posid1\",\"$posid2\",\"".$_POST[lswitch1][$posid1]."\")' /></td>";
								$idcta="'".$row[0]."'";
								$numfil="'".$filas."'";
								echo"
							</tr>";
								
							}
						}
						 $con+=1;
						 $aux=$iter;
						 $iter=$iter2;
						 $iter2=$aux;
						 $filas++;
 					}
 					echo"
                    </table>
                    <table class='inicio'>
                        <tr>
                            <td style='text-align:center;'>
                                <a href='#'>$imagensback</a>&nbsp;
                                <a href='#'>$imagenback</a>&nbsp;&nbsp;";
                    if($nuncilumnas<=9){$numfin=$nuncilumnas;}
                    else{$numfin=9;}
                    for($xx = 1; $xx <= $numfin; $xx++)
                    {
                        if($numcontrol<=9){$numx=$xx;}
                        else{$numx=$xx+($numcontrol-9);}
                        if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
                        else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
                    }
                    echo "		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
                                &nbsp;<a href='#'>$imagensforward</a>
                            </td>
                        </tr>
                    </table>";
				?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>