<!--V 1.0 24/02/2015-->
<?php
	require"../../include/comun.php";
	require"../../include/funciones.php";
	session_start();
    $linkbd=conectar_v7();
    if(isset($_GET['codpag']))	
	    cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
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
			function verUltimaPos(idcta, filas){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="cont-editartipodoc.php?idtipocom="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg;
			}
		</script>
		<script>
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea activar Estado','1');}
				else{despliegamodalm('visible','4','Desea Desactivar Estado','2');}
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
		<?php titlepag();?>
        <?php
        if(isset($_GET['scrtop']))
		    $scrtop=$_GET['scrtop'];
		if(!isset($_GET['scrtop'])) $scrtop=0;
		echo"<script>
			window.onload=function(){
				$('#divdet').scrollTop(".$scrtop.")
			}
        </script>";
        if(isset($_GET['idcta']))
		    $gidcta=$_GET['idcta'];
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
					<td colspan="3" class="cinta"><a href="cont-tipodoc.php" class="mgbt"><img src="../../img/icons/add.png" title="Nuevo" style="height:25; width:25"/></a>
					<a class="mgbt"><img img src="../../img/icons/disabled-save.png"style="height:25; width:25"/></a>
					<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="../../img/icons/search.png" title="Buscar" style="height:25; width:25"/></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="../../img/icons/new-tv.png"style="height:25; width:25" title="Nueva Ventana"></a>
					<a href="" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="../../img/icons/agenda.png"style="height:25; width:25" title="Agenda"/></a>
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
        if(isset($_GET['numpag'] ))
        {
            if($_GET['numpag']!=""){
                $oculto=$_POST['oculto'];
                if($oculto!=2){
                    $_POST['numres']=$_GET['limreg'];
                    $_POST['numpos']=$_GET['limreg']*($_GET['numpag']-1);
                    $_POST['nummul']=$_GET['numpag']-1;
                }
            }
        }    
		else{
            if(isset( $_POST['nummul']))
            {
                if($_POST['nummul']==""){
                    $_POST['numres']=10;
                    $_POST['numpos']=0;
                    $_POST['nummul']=0;
                }
            }    
		}
		?>
 		<form name="form2" method="post" action="cont-buscatipodoc.php">
 			<?php
				if(!isset( $_POST['oculto2']))
				{
					$_POST['oculto2']="0";
					$_POST['cambioestado']="";
					$_POST['nocambioestado']="";
				}
				//*****************************************************************
				if($_POST['cambioestado']!="")
				{
					$linkbd=conectar_v7();
					if($_POST['cambioestado']=="1")
					{
                        $sqlr="UPDATE tipo_comprobante SET estado='S' WHERE id_tipo='".$_POST['idestado']."'";
                     	mysqli_fetch_row(mysqli_query($sqlr,$linkbd)); 
					}
					else 
					{
                        $sqlr="UPDATE tipo_comprobante SET estado='N' WHERE id_tipo='".$_POST['idestado']."'";
                     	mysqli_fetch_row(mysqli_query($sqlr,$linkbd)); 
					}
					echo"<script>document.form2.cambioestado.value=''</script>";
				}
				//*****************************************************************
				if($_POST['nocambioestado']!="")
				{
					if($_POST['nocambioestado']=="1"){$_POST['lswitch1'][$_POST['idestado']]=1;}
					else {$_POST['lswitch1'][$_POST['idestado']]=0;}
					echo"<script>document.form2.nocambioestado.value=''</script>";
				}
			?>
			<table  class="inicio" align="center" >
      			<tr>
                	<td class="titulos" colspan="4">:: Buscar Tipo Comprobantes </td>
                	<td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
              	</tr>
      			<tr>
                	<td class="saludo1" style='width:3.5cm;'>C&oacute;digo o Nombre:</td>
        			<td>
                    	<input type="text" name="nombre" id="nombre" value="<?php if(isset( $_POST['nombre'])) echo $_POST['nombre'];?>" style='width:50%;'/>
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
       			</tr>                       
    		</table>   
            <input type="hidden" name="oculto" id="oculto" value="1">
            <input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST['oculto2'];?>">
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST['cambioestado'];?>">
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST['nocambioestado'];?>">
            <input type="hidden" name="idestado" id="idestado" value="<?php if(isset( $_POST['idestado'])) echo $_POST['idestado'];?>">
            <input type="hidden" name="numres" id="numres" value="<?php if(isset( $_POST['numres'])) echo $_POST['numres'];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php if(isset( $_POST['numpos'])) echo $_POST['numpos'];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php if(isset( $_POST['nummul'])) echo $_POST['nummul'];?>"/>
    		<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
      		<?php
                $oculto = "";
                if(isset( $_POST['oculto']))
                {
                    $oculto=$_POST['oculto'];
                }    
				$cedula=$_SESSION['cedulausu'];
				$sql="SELECT usu_usu FROM usuarios WHERE cc_usu=$cedula";
				$result=mysqli_query($linkbd,$sql);
				$user=mysqli_fetch_row($result);
				//if($_POST[oculto])
				{
                    $crit1="";
                    if(isset( $_POST['nombre']))
					if ($_POST['nombre'] != ""){ 
                        $crit1="WHERE concat_ws(' ', nombre, codigo) LIKE '%$_POST[nombre]%'";
                    }
					$sqlr = "SELECT * FROM tipo_comprobante $crit1";
					$resp = mysqli_query($linkbd,$sqlr);
                    $_POST['numtop'] = mysqli_num_rows($resp);
                    if(isset( $_POST['numres']))
					$nuncilumnas=ceil($_POST['numtop']/$_POST['numres']);

                    $cond2="";
                    if(isset( $_POST['numres'])){
                        if ($_POST['numres'] != "-1"){ 
                            $cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
                        }
                    }
                        
					$crit2 = "";
					if(empty($crit1)){
						$crit2 = "WHERE cc.id=tc.id_cat";
					}else{
						$crit2 = "AND cc.id=tc.id_cat";
					}
					$sqlr="SELECT tc.id_tipo,tc.nombre,tc.estado,tc.codigo,tc.fijo,cc.nombre FROM tipo_comprobante as tc,categoria_compro as cc $crit1 $crit2 ORDER BY tc.id_tipo ".$cond2;
					$resp = mysqli_query($linkbd,$sqlr);
					$con=1;
					$numcontrol = "";
                    $nuncilumnas = "";
                    if(isset( $_POST['numres']))
                        $numcontrol=$_POST['nummul']+1;
					if($nuncilumnas==$numcontrol)
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
                    }
                    if(isset( $_POST['numres'])){    
                        if($_POST['numpos']==0)
                        {
                            $imagenback="<img src='imagenes/back02.png' style='width:17px'>";
                            $imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
                        }
                        else
                        {
                            $imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
                            $imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
                        }
                    }    
					echo "
						<table class='inicio' align='center' width='80%'>
							<tr>
								<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
								<td class='submenu'>
									<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
										<option value='10'"; if (isset($_POST['renumres']) && $_POST['renumres']=='10'){echo 'selected';} echo ">10</option>
										<option value='20'"; if (isset($_POST['renumres']) && $_POST['renumres']=='20'){echo 'selected';} echo ">20</option>
										<option value='30'"; if (isset($_POST['renumres']) && $_POST['renumres']=='30'){echo 'selected';} echo ">30</option>
										<option value='50'"; if (isset($_POST['renumres']) && $_POST['renumres']=='50'){echo 'selected';} echo ">50</option>
										<option value='100'"; if (isset($_POST['renumres']) && $_POST['renumres']=='100'){echo 'selected';} echo ">100</option>
										<option value='-1'"; if (isset($_POST['renumres']) && $_POST['renumres']=='-1'){echo 'selected';} echo ">Todos</option>
									</select>
								</td>
							</tr>
							<tr><td colspan='5'>Tipos de Comprobantes Encontrados: $_POST[numtop]</td></tr>
							<tr>
								<td class='titulos2' rowspan='2' style='width:5%;'>Item</td>
								<td class='titulos2' rowspan='2' style='width:5%;'>Codigo</td>
								<td class='titulos2' rowspan='2'>Nombre Comprobante</td>
								<td class='titulos2' rowspan='2'>Categoria Comprobante</td>
								<td class='titulos2'colspan='2' style='text-align:center;'>Fijo</td>
								<td class='titulos2' colspan='2' rowspan='2'  style='width:6%;'>Estado</td>
								<td class='titulos2' width='5%' rowspan='2'>Editar</td>
							</tr>
							<tr>
								<td class='titulos2' style='width:2%;'>Si</td>
								<td class='titulos2' style='width:2%;'>No</td>
							</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
				  	while ($row =mysqli_fetch_row($resp)) 
				   	{   
                        $con2 = "";
                        if(isset( $_POST['numpos']))
						$con2=$con+ $_POST['numpos'];
						if ($row[4]=='N')
					   	{
							$ddt='cont-editartipodoc.php?idtipocom=';
						   	$acti="";
						   	$imgedit="src='../../img/icons/edit-file.png' title='Editar'";
						   	$imgfig1="src='../../img/icons/circle-gray.png' ";
						   	$imgfig2="src='../../img/icons/circle-red.png' title='No Fijo'";
					   	}
					   	else
					   	{
						   	$ddt='#';
						   	$acti="disabled";
						   	$imgedit="src='../../img/icons/security-lock.png' title='No Editable'";
						   	$imgfig1="src='../../img/icons/circle-green.png' title='Fijo'";
						   	$imgfig2="src='../../img/icons/circle-gray.png' ";
					  	}
					   	if($row[2]=='S')
						  	{$imgsem="src='../../img/icons/circle-green.png' title='Activo'";$coloracti="#0F0";$_POST['lswitch1'][$row[0]]=0;}
					   	else
						  	{$imgsem="src='../../img/icons/circle-red.png' title='Inactivo'";$coloracti="#C00";;$_POST['lswitch1'][$row[0]]=1;}

                        if(isset( $_POST['gidcta']))
                        {
							if($gidcta==$row[0]){
								$estilo='background-color:yellow';
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
					   	echo "
						
							<tr class='$iter' style='text-transform:uppercase; $estilo' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\"onDblClick=\"verUltimaPos($idcta, $numfil)\">
								<td>$con2</td>
							   	<td>$row[3]</td>
							   	<td>$row[1]</td>
								<td>$row[5]</td>
							   	<td style='text-align:center;'><img $imgfig1 style='width:18px'/></td>
							  	<td style='text-align:center;'><img $imgfig2 style='width:18px'/></td>
							   	<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
							   	<td><input type='range' name='lswitch1[]' value='".$_POST['lswitch1'][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$row[0]\",\"".$_POST['lswitch1'][$row[0]]."\")' $acti /></td>";
								$opt="N";
								if($user[0]=='spid'){
									$opt="S";
								}
								
								if($row[4]==$opt){
									
									echo"<td style='text-align:center;'>
										<a onClick=\"verUltimaPos($idcta, $numfil)\" style='cursor:pointer;'>
											<img src='../../img/icons/edit-file.png' style='width:18px' title='Editar'>
										</a>
									</td>";
								}
								else{
							   		echo"<td style='text-align:center;'><a href='$ddt$row[0]'><img $imgedit style='width:18px' ></a></td>";
								}
							echo"</tr>";
						$con+=1;
					   	$aux=$iter;
					   	$iter=$iter2;
					   	$iter2=$aux;
						$filas++;
				   	}
					if ($_POST['numtop']==0)
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda $tibusqueda<img src='imagenes\alert.png' style='width:25px'></td>
							</tr>
						</table>";
                    }
                    $imagensback = "";
                    $imagenback = "";
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
					echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
								</td>
							</tr>
						</table>";
				}
				?>			
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST['numtop'];?>"/>
  		</form>
	</body>
</html>
