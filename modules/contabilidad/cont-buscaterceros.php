<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php

	require '../../include/comun.php';
    require '../../include/funciones.php';
    
	session_start();
    $linkbd = conectar_v7();
    	
    // cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
    
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>

		<title>:: Spid - Contabilidad</title>

        <link href="../../css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
        <link href="../../css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>

		<script type="text/javascript" src="../../js/JQuery/jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="../../js/programas.js"></script>

		<script>
			function verUltimaPos(idcta, filas, filtro)
			{
				var scrtop = $('#divdet').scrollTop();
				var altura = $('#divdet').height();
                
                var numpag = $('#nummul').val();
				var limreg = $('#numres').val();
                
                if((numpag <= 0) || (numpag == ""))
					numpag = 0;
				if((limreg == 0) || (limreg == ""))
					limreg = 10;
                
                numpag++;
                
                location.href = "cont-editaterceros.php?idter="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function anulatercero(id, documento)
			{
			 	if(confirm("Esta Seguro de Eliminar el Tercero: " + documento))
			  	{
			  		document.form2.ac.value = 2;
			  		document.form2.cod.value = documento;
			 		document.form2.submit();
			  	}
			}
			function cambioswitch(id, valor)
			{
                document.getElementById('idestado').value = id;
                
                if(valor == 1)
                {
                    despliegamodalm('visible', '4', 'Desea activar este Tercero', '1');
                }
                else
                {
                    despliegamodalm('visible', '4', 'Desea Desactivar este Tercero', '2');
                }
			}
			function despliegamodalm(_valor, _tip, mensa, pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility = _valor;
                if(_valor == "hidden")
                {
                    document.getElementById('ventanam').src = '';
                }
				else
				{
					switch(_tip)
					{
						case "1":
                            document.getElementById('ventanam').src = "ventana-mensaje1.php?titulos=" + mensa;
                            break;
						case "2":
                            document.getElementById('ventanam').src = "ventana-mensaje3.php?titulos=" + mensa;
                            break;
						case "3":
                            document.getElementById('ventanam').src = "ventana-mensaje2.php?titulos=" + mensa;
                            break;
						case "4":
                            document.getElementById('ventanam').src = "ventana-consulta2.php?titulos=" + mensa + "&idresp=" + pregunta;
                            break;	
					}
				}
			}
			function funcionmensaje(){}
			function respuestaconsulta(estado,pregunta)
			{
				if(estado == 'S')
				{
					switch(pregunta)
					{
                        case "1":
                            document.form2.cambioestado.value = '1';
                            break;
                        case "2":	
                            document.form2.cambioestado.value = '0';
                            break;
					}
				}
				else
				{
					switch(pregunta)
					{
                        case "1":	
                            document.form2.nocambioestado.value = "1";
                            break;
                        case "2":	
                            document.form2.nocambioestado.value = "0";
                            break;
					}
				}
				document.form2.submit();
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
   			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
            	<?php 
					if($_SESSION["prcrear"]==1)
					{$botonnuevo="<a onClick=\"location.href='cont-terceros.php'\" class='mgbt'><img src='imagenes/add.png' title='Nuevo' /></a>";}
					else
					{$botonnuevo="<a class='mgbt1'><img src='imagenes/add2.png' /></a>";}
				?>
            	<td colspan="3" class="cinta">
					<?php echo $botonnuevo;?>
					<a class="mgbt1"><img src="imagenes/guardad.png"/></a>
					<a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
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
			if($_POST['oculto']=="")
			{
				$_POST['scrtop'] = $_GET['scrtop'];
                if($_POST['scrtop'] == "")
                {
                    $_POST['scrtop'] = 0;
                }

                $_POST['gidcta']=$_GET['idcta'];
                
                if(isset($_GET['filtro']))
                {
                    $_POST['numero'] = $_GET['filtro'];
                }
            }
            
            echo "<script>window.onload=function(){ $('#divdet').scrollTop(".$_POST['scrtop'].")}</script>";
            
			if($_GET['numpag'] != '')
			{
				$oculto = $_POST['oculto'];
				if($oculto != 2)
				{
					$_POST['numres'] = $_GET['limreg'];
					$_POST['numpos'] = $_GET['limreg'] * ($_GET['numpag'] - 1);
					$_POST['nummul'] = $_GET['numpag'] - 1;
				}
			}
            else
            {
                if($_POST['nummul'] == '')
                {
                    $_POST['numres'] = 10;
                    $_POST['numpos'] = 0;
                    $_POST['nummul'] = 0;
                }
            }
		?>
 		<form name="form2" method="post" action="cont-buscaterceros.php">
 			<?php
				if($_POST['oculto2']=="")
				{
					$_POST['oculto2']="0";
					$_POST['cambioestado']="";
					$_POST['nocambioestado']="";
				}
				//*****************************************************************
				if($_POST['cambioestado'] != "")
				{
					if($_POST['cambioestado'] == "1")
					{
                        $sqlr = 'UPDATE terceros SET estado=\'S\' WHERE id_tercero=\''.$_POST['idestado'].'\'';
                     	mysql_fetch_row(mysql_query($sqlr, $linkbd)); 
					}
					else 
					{
                        $sqlr="UPDATE terceros SET estado='N' WHERE id_tercero='$_POST[idestado]'";
                     	mysql_fetch_row(mysql_query($sqlr, $linkbd)); 
					}
					echo"<script>document.form2.cambioestado.value=''</script>";
				}
				//*****************************************************************
				if($_POST[nocambioestado]!="")
				{
					if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
					else {$_POST[lswitch1][$_POST[idestado]]=0;}
					echo"<script>document.form2.nocambioestado.value=''</script>";
				}
			?>
			<table  class="inicio" align="center" >
           		<tr>
                	<td class="titulos" colspan="4">:: Buscar Tercero</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='cont-principal.php'">&nbsp;Cerrar</a></td>
              	</tr>
      			<tr>
        			<td class="saludo1" style='width:4cm;'>:: Documento o Nombre:</td>
        			<td>
                    	<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style='width:50%;'/>
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
       			</tr>                       
    		</table> 
            <input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="ac" id="ac" value="1"/>
			<input type="hidden" name="cod" id="cod" value="1"/>   
    		<?php 
				$ca=$_POST[ac];
				if ($ca==2)
				{
					$sqlr="select count(*) from comprobante_det where  tercero='$_POST[cod]'";
					$res=mysql_query($sqlr,$linkbd);
					$cf =mysql_fetch_row($res);
					if($cf[0]==0)
		 			{
						$sqlr="delete from terceros  where cedulanit='$_POST[cod]' ";
						$cont=0;
						$resp=mysql_query($sqlr,$linkbd);
						if (!$resp) 
						{	
	 						echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
							//$e =mysql_error($respquery);
	 						echo "Ocurrió el siguiente problema:<br>";
  	 						//echo htmlentities($e['message']);
  	 						echo "<pre>";
     						//echo htmlentities($e['sqltext']);
    						//printf("\n%".($e['offset']+1)."s", "^");
     						echo "</pre></center></td></tr></table>";
						}
						else
						{
							$ntr = mysql_affected_rows();
							if ($ntr==0){echo "<script>alert('No se puede anular la cuenta por ser de tipo Mayor');</script>";}
						}
					}
					else {echo "<script>alert('No se puede anular, porque el Tercero tiene movimientos contables anteriores');</script>";}
				}   
  			?>
    		<input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2];?>"/>
    		<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>"/>
    		<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
    		<input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <input type="hidden" name="scrtop" id="scrtop" value="<?php echo $_POST[scrtop];?>"/>
        	<input type="hidden" name="gidcta" id="gidcta" value="<?php echo $_POST[gidcta];?>"/>
			<div class="subpantallap" style="height:68%; width:99.6%; overflow-x:hidden;" id="divdet">
      		<?php
				$oculto=$_POST['oculto'];
				//if($_POST[oculto])
				{
					$crit1=" ";
					if ($_POST[nombre]!="")
					{$crit1="WHERE concat_ws(' ', nombre1,nombre2,apellido1,apellido2,razonsocial,cedulanit) LIKE '%$_POST[nombre]%'";}
					$sqlr="SELECT * FROM terceros $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]"; }
					$sqlr="SELECT * FROM terceros $crit1 ORDER BY apellido1,apellido2,nombre1,nombre2,razonsocial $cond2";
					$resp = mysql_query($sqlr,$linkbd);
					$con=1;
					$numcontrol=$_POST[nummul]+1;
					if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px;cursor:default;'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px;cursor:default;' >";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px;cursor:pointer;' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px;cursor:pointer;' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px;cursor:default;'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px;cursor:default;'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px;cursor:pointer;' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px;cursor:pointer;' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					$ntips1=10;
					$ntips2=11;
					if($_SESSION["prdesactivar"]!=1){$ntips1=$ntips1-1;$ntips2=$ntips2-1;}
					if($_SESSION["preditar"]!=1){$ntips1=$ntips1-1;$ntips2=$ntips2-1;}
					if($_SESSION["preliminar"]!=1){$ntips1=$ntips1-1;$ntips2=$ntips2-1;}
					echo "
						<table class='inicio'>
							<tr>
								<td colspan='$ntips1' class='titulos'>.: Resultados Busqueda:</td>
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
							<tr><td colspan='$ntips2'>Terceros Encontrados: $_POST[numtop]</td></tr>
							<tr>
								<td class='titulos2' style='width:4%;'>Item</td>
								<td class='titulos2' >Raz&oacute;n Social</td>
								<td class='titulos2' style='width:10%;'>Primer Apellido</td>
								<td class='titulos2' style='width:10%;'>Segundo Apellido</td>
								<td class='titulos2' style='width:10%;'>Primer Nombre</td>
								<td class='titulos2' style='width:10%;'>Segundo Nombre</td>
								<td class='titulos2' style='width:8%;'>Documento</td>";
								if($_SESSION["prdesactivar"]==1){echo"<td class='titulos2' colspan='2' style='width:6%;' >Estado</td>";}	
								else {echo"<td class='titulos2' style='width:6%;' >Estado</td>";}
								if($_SESSION["preditar"]==1){echo"<td class='titulos2' style='width:4%;'>Editar</td>";}
								if($_SESSION["preliminar"]==1){echo"<td class='titulos2' style='width:4%;' >Eliminar</td>";}
								echo"</tr>";
								
							$iter='saludo1a';
							$iter2='saludo2';
							$filas=1;
 							while ($row =mysql_fetch_row($resp)) 
 							{	 
								$con2=$con+ $_POST[numpos];
 	 							if($row[21]=='S')
	  								{$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;}
								else
									{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";;$_POST[lswitch1][$row[0]]=1;}
		 						$nombresc=strtoupper($row[5]).' '.strtoupper($row[3]).' '.strtoupper($row[4]).' '.strtoupper($row[1]).' '.strtoupper($row[2]);
								if($_POST[gidcta]!="")
								{
									if($_POST[gidcta]==$row[0]){$estilo='background-color:yellow';}
									else{$estilo="";}
								}
								else{$estilo="";}	
								$idcta="'$row[0]'";
								$numfil="'$filas'";
								$filtro="'$_POST[nombre]'";
							if($_SESSION["preditar"]==1)
							{
								echo"<tr class='$iter' onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >";
							}
							else {echo"<tr class='$iter' style='text-transform:uppercase; $estilo' >";}
							echo"
										<td>$con2</td>
										<td>$row[5]</td>
										<td>$row[3]</td>
										<td>$row[4]</td>
										<td>$row[1]</td>
										<td>$row[2]</td>
										<td>$row[12]</td>
	 									<td style='text-align:center;'><img $imgsem style='width:20px'/></td>";
							if($_SESSION["prdesactivar"]==1)
							{
								echo"<td style='text-align:center;'><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$row[0]\",\"".$_POST[lswitch1][$row[0]]."\")' /></td>";
							}
	 						if($_SESSION["preditar"]==1)
							{		
								echo"<td style='text-align:center;'>
									<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'>
										<img src='imagenes/b_edit.png' style='width:18px' title='Editar'>
									</a>
								</td>";
							}
							if($_SESSION["preliminar"]==1)
							{
	 									echo"<td style='text-align:center;><a href='#' onClick='anulatercero($row[0],$row[12])'><img src='imagenes/anular.png'></a></td>";
							}
	 						echo "</tr>";
								 $con+=1;
								 $aux=$iter;
								 $iter=$iter2;
								 $iter2=$aux;
								 $filas++;
 							}
							if ($_POST[numtop]==0)
							{
								echo "
								<table class='inicio'>
									<tr>
										<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda $tibusqueda<img src='imagenes\alert.png' style='width:25px'></td>
									</tr>
								</table>";
							}
 							echo"
						</table>
						<table class='inicio'>
							<tr>
								<td style='text-align:center;'>
									<a>$imagensback</a>&nbsp;
									<a>$imagenback</a>&nbsp;&nbsp;";
					if($nuncilumnas<=9){$numfin=$nuncilumnas;}
					else{$numfin=9;}
					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){$numx=$xx;}
						else{$numx=$xx+($numcontrol-9);}
						if($numcontrol==$numx){echo"<a onClick='saltocol(\"$numx\")'; style='color:#24D915;cursor:pointer;'> $numx </a>";}
						else {echo"<a onClick='saltocol(\"$numx\")'; style='color:#000000;cursor:pointer;'> $numx </a>";}
					}
					echo"			&nbsp;&nbsp;<a>$imagenforward</a>
									&nbsp;<a>$imagensforward</a>
								</td>
							</tr>
						</table>";
					}
				?>
            </div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
	 	</form>
	</body>
</html>
