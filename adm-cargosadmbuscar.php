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
		<title>:: Meci - Calidad</title>
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
				location.href="adm-cargosadmmodificar.php?idcargo="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
        <script>
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea Activar este Cargo Administrativo','1');}
				else{despliegamodalm('visible','4','Desea Desactivar este Cargo Administrativo','2');}
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
					<a onclick="location.href='adm-cargosadmguardar.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png" /><span class="tiptext">Nuevo</span></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/guardad.png" /></a>
					<a onClick="document.form2.submit();" class="tooltip bottom mgbt"><img src="imagenes/busca.png" /><span class="tiptext">Buscar</span></a>
					<a onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
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
                    if($_POST[cambioestado]=="1")
                    {
                        $sqlr="UPDATE planaccargos SET estado='S' WHERE codcargo='$_POST[idestado]'";
                        mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
                    }
                    else 
                    {
                        $sqlr="UPDATE planaccargos SET estado='N' WHERE codcargo='$_POST[idestado]'";
                        
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
                    <td class="titulos" colspan="2" width="100%">:.Buscar Cargo Administrativo </td>
                    <td class="boton02" onClick="parent.cerrargeneral()">Cerrar</td>
                </tr>
                <tr><td class="titulos2" colspan="3">:&middot; Por Descripci&oacute;n </td></tr>
              	<tr>
                	<td style="width:3.5cm" class="saludo1">:. Código o Nombre:</td>
                	<td style="width:80%">
                    	<input name="nombre" type="text" style="width:50%" value="<?php echo $_POST[nombre]; ?>">
                    	<input name="oculto" id="oculto" type="hidden" value="1"> 
                	</td>
                	<td style="width:7%"></td>
               	</tr>                       
            </table>
            <input name="ocudel" type="hidden" id="ocudel" value="<?php echo $_POST[oculdel]?>"/>
            <input name="iddel" type="hidden" id="iddel" value="1"/>
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>"/>
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
            <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantallap" style="height:66%; width:99.6%; overflow-x:hidden;" id="divdet"/>
				<?php 
					$crit1="";
					if ($_POST[nombre]!="")
						$crit1="WHERE concat_ws(' ', codcargo, nombrecargo) LIKE '%$_POST[nombre]%'";
                    $sqlr="SELECT distinct * FROM planaccargos $crit1"; 
                    $resp=mysql_query($sqlr,$linkbd);
                    $_POST[numtop]=mysql_num_rows($resp);
                    $nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);

					$cond2="";
					if ($_POST[numres]!="-1"){ 
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}
                    $sqlr="SELECT distinct * FROM planaccargos $crit1 ORDER BY codcargo ASC ".$cond2; 
                    $resp=mysql_query($sqlr,$linkbd);
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
                            <td class='titulos' colspan='4'>:: Listado Cargos Administrativos</td>
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
                        <tr><td colspan='5'>Encontrados: $_POST[numtop]</td></tr>
                        <tr class='centrartext'>
                            <td class='titulos2' width='38%'>Cargo Administrativo</td>
                            <td class='titulos2'>Jefe directo</td>
                            <td class='titulos2' width='10%'>Dependencia</td>
                            <td class='titulos2' width='35%'>Tipo de Cargo</td>
                            <td class='titulos2' style='width:5%;'>Estado</td>
                         </tr>";
					$filas=1;
                    while ($rowEmp = mysql_fetch_assoc($resp)) 
                    {
                        if($rowEmp[estado]=='S')
                            {$coloracti="#0F0";$_POST[lswitch1][$rowEmp[codcargo]]=0;}
                        else
                            {$coloracti="#C00";;$_POST[lswitch1][$rowEmp[codcargo]]=1;}
                        if($rowEmp['codpadre']==0){$nompadre="Ninguno";}
                        else
                        {
                            $sqlr2="SELECT * FROM planaccargos WHERE  codcargo = ".$rowEmp['codpadre']; 
                            $res2=mysql_query($sqlr2,$linkbd);
                            $rowEmp2 = mysql_fetch_assoc($res2);
                            $nompadre=$rowEmp2['nombrecargo'];
                        }
                        $sqlr2="SELECT * FROM planacareas WHERE  codarea = ".$rowEmp['dependencia']; 
                        $res2=mysql_query($sqlr2,$linkbd);
                        $rowEmp2 = mysql_fetch_assoc($res2);
                        $nomdependencia=$rowEmp2['nombrearea'];
                        $sqlr2="SELECT * FROM humnivelsalarial WHERE id_nivel = ".$rowEmp['clasificacion']; 
                        $res2=mysql_query($sqlr2,$linkbd);
                        $rowEmp2 = mysql_fetch_assoc($res2);
                        $nomtipo=$rowEmp2['nombre'];
						if($gidcta!=""){
							if($gidcta==$rowEmp['codcargo']){
								$estilo='background-color:#FF9';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
						$idcta="'".$rowEmp['codcargo']."'";
						$numfil="'".$filas."'";
						$filtro="'".$_POST[nombre]."'";
						echo"<tr class='saludo2' onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
							<td class='icoop'>$rowEmp[nombrecargo]</td>
							<td class='centrartext icoop'>$nompadre</td>
							<td class='icoop'>$nomdependencia</td>
							<td class='icoop'>$nomtipo</td>
        					<td class='centrartext'><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$rowEmp[codcargo]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:80%' onChange='cambioswitch(\"".$rowEmp[codcargo]."\",\"".$_POST[lswitch1][$rowEmp[codcargo]]."\")' /></td>";
							echo"</tr>";
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