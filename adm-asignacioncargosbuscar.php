<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
				location.href="adm-asignacioncargosmodificar.php?idcargoasignado="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}

			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea Activar este Cargo Asignado','1');}
				else{despliegamodalm('visible','4','Desea Desactivar este Cargo Asignado','2');}
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
					<a href="adm-asignacioncargosguardar.php" class="tooltip bottom mgbt"><img src="imagenes/add.png"  title=""/><span class="tiptext">Nuevo</span></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/guardad.png" /></a>
					<a onClick="document.form2.submit();" class="tooltip bottom mgbt"><img src="imagenes/busca.png" title="" /><span class="tiptext">Buscar</span></a>
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
    	<form name="form2" method="post" action="">
        	<?php
				if($_POST[oculto]=="")
				{
					$_POST[cambioestado]="";
					$_POST[nocambioestado]="";
				}
				//*****************************************************************
				if($_POST[cambioestado]!="")
				{
					$linkbd=conectar_bd();
					if($_POST[cambioestado]=="1")
					{
                        $sqlr="UPDATE planestructura_terceros SET estado='S' WHERE codestter='".$_POST[idestado]."'";
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
                        $sqlr="UPDATE planestructura_terceros SET estado='N' WHERE codestter='".$_POST[idestado]."'";
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
			<table class="inicio ancho">
          		<tr>
              		<td class="titulos" colspan="2" width="100%">:.Buscar Cargo Asignado </td>
                 	<td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
           		</tr>
         		<tr><td class="titulos2" colspan="3">:&middot; Por Descripci&oacute;n </td></tr>
              	<tr>
                	<td style="width:4.5cm" class="saludo1">:. N&deg; Documento, Nombre Empleado o Cargo:</td>
                	<td style="width:70%">
                    	<input name="nombre" type="text" style="width:60%" value="<?php echo $_POST[nombre]; ?>">
                    	<input name="oculto" id="oculto" type="hidden" value="1"> 
                	</td>
                	<td style="width:7%"></td>
               	</tr>                       
        	</table>
         	<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
         	<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
          	<input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
         	<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
          	<div class="subpantallap" style="height:66%; width:99.8%; overflow-x:hidden;" id="divdet" >
           		<?php 
					$crit1="";
					if ($_POST[nombre]!="")
					$crit1="concat_ws(' ', t.cedulanit, t.nombre1, pl.nombrecargo) LIKE '%$_POST[nombre]%' AND";
                	$sqlr="SELECT distinct t.*, pl.*, pt.* FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE $crit1 t.cedulanit = pt.cedulanit AND pl.codcargo = pt.codcargo"; 
					$resp=mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
                    $nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);

					$cond2="";
					if ($_POST[numres]!="-1"){ 
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}
					$sqlr="SELECT distinct t.*, pl.*, pt.* FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE $crit1 pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo ORDER BY pt.cedulanit ASC ".$cond2; 
					$resp=mysql_query($sqlr,$linkbd);
					$filas=mysql_num_rows($resp);
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
					echo"
					<table class='inicio'>        
                		<tr>
                            <td class='titulos' colspan='3'>:: Listado Cargos Asignados</td>
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
						<tr><td colspan='4'>Encontrados: $_POST[numtop]</td></tr>
                        <tr class='centrartext'>
                            <td class='titulos2' width='40%'>Cargo Administrativo</td>
                            <td class='titulos2' >Documento</td>
                            <td class='titulos2' width='40%'>Nombre Empleado</td>
                            <td class='titulos2' width='6%'>Estado</td>
                         </tr>";
					$filas=1;
                  	while ($rowEmp = mysql_fetch_row($resp)) 
                 	{
						if($rowEmp[31]=='S') 
						{
							$coloracti="#0F0";
							$_POST[lswitch1][$rowEmp[28]]=0;
						}
						else 
						{
							$coloracti="#C00";
							$_POST[lswitch1][$rowEmp[28]]=1;
						}
						$nombreemp=$rowEmp[1]." ".$rowEmp[2]." ".$rowEmp[3]." ".$rowEmp[4];
						if($gidcta!=""){
							if($gidcta==$rowEmp[28]){
								$estilo='background-color:#FF9';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
						$idcta="'".$rowEmp[28]."'";
						$numfil="'".$filas."'";
						$filtro="'".$_POST[nombre]."'";
						echo"<tr class='saludo2'  onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
								<td class='icoop'>$rowEmp[24]</td>
								<td class='icoop'>$rowEmp[12]</td>
								<td class='icoop'>$nombreemp</td>
								<td class='icoop centrartext'><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$rowEmp[28]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$rowEmp[28]\",\"".$_POST[lswitch1][$rowEmp[28]]."\")' /></td>
							</tr>";
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