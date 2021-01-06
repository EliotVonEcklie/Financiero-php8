<?php //V 1000 12/12/16 ?> 
<!-- V 1.0 02/08/2016 -->

<?php
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml" xml: lang="es">
	<head>
    	<meta http-equiv="content-type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid - Presupuesto </title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
        <script>
			function verUltimaPos(idcta,filas,filtro)
			{
				
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="ccp-editaruniejecutora.php?idtipocom="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
			
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.form2.cambioestado.value="1";break;
						case "2":	document.form2.cambioestado.value="0";break;
						case "3":	document.form2.ac.value=2;break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	document.form2.nocambioestado.value="1";break;
						case "2":	document.form2.nocambioestado.value="0";break;
						case "3":	break;
					}
				}
				document.form2.submit();
			}
			function anular(id)
			{
				document.form2.cod.value=id;
				despliegamodalm('visible','4',"Esta Seguro de Eliminar la Cuenta "+id,'3');
			}
		</script>
        <?php titlepag();?>
    </head>
    <body>
    	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("ccpet");?></tr>
			<tr>
            	<?php 
					if($_SESSION["prcrear"]==1)
					{$botonnuevo="<a onClick=\"location.href='ccp-uniejecutora.php'\" class='mgbt'><img src='imagenes/add.png' title='Nuevo' /></a>";}
					else
					{$botonnuevo="<a class='mgbt1'><img src='imagenes/add2.png' /></a>";}
				?>
                <td colspan="3" class="cinta"><?php echo $botonnuevo;?>
				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
				<a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a onClick="<?php echo paginasnuevas("ccpet");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
          	</tr>
            </table>
            <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <?php
			if($_POST[oculto]=="")
			{
				$_POST[scrtop]=$_GET['scrtop'];
				if($_POST[scrtop]==""){$_POST[scrtop]=0;}
				$_POST[gidcta]=$_GET['idcta'];
				if(isset($_GET['filtro'])){$_POST[numero]=$_GET['filtro'];}
			}
			echo"<script>window.onload=function(){ $('#divdet').scrollTop(".$_POST[scrtop].")}</script>";
			if($_GET[numpag]!="")
			{
				$oculto=$_POST[oculto];
				if($oculto!=2)
				{
				$_POST[numres]=$_GET[limreg];
				$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
				$_POST[nummul]=$_GET[numpag]-1;
				}
			}
			else
			{
				if($_POST[nummul]=="")
				{
					$_POST[numres]=10;
					$_POST[numpos]=0;
					$_POST[nummul]=0;
				}
			}
		?>
        <form name="form2" method="post" action="ccp-buscauniejecutora.php">
        	<?php
				if($_POST[oculto2]=="")
                {
                    $_POST[oculto2]="0";
                    $_POST[cambioestado]="";
                    $_POST[nocambioestado]="";
                }
				
				  if($_POST[cambioestado]!="")
                {
                    if($_POST[cambioestado]=="1")
                    {
                        $sqlr="UPDATE pptouniejecu SET estado='S' WHERE id_cc='$_POST[idestado]'";
                        mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
                    }
                    else 
                    {
                        $sqlr="UPDATE pptouniejecu SET estado='N' WHERE id_cc='$_POST[idestado]'";
                        mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
                    }
					echo"<script>document.form2.cambioestado.value=''</script>";
                }
				if($_POST[nocambioestado]!="")
                {
                    if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
                    else {$_POST[lswitch1][$_POST[idestado]]=0;}
                    echo"<script>document.form2.nocambioestado.value=''</script>";
                }
			?>
            <table  class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="4">:: Buscar Unidad Ejecutora </td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='ccp-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style='width:3cm;'>C&oacute;digo o Nombre:</td>
                    <td >
                    	<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style='width:50%;'/>
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
                </tr>                       
            </table> 
            <input name="oculto" id="oculto" type="hidden" value="1"/>
     		<input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2];?>"/>
    		<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>"/>
   			<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
    		<input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>"/> 
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <input type="hidden" name="scrtop" id="scrtop" value="<?php echo $_POST[scrtop];?>"/>
        	<input type="hidden" name="gidcta" id="gidcta" value="<?php echo $_POST[gidcta];?>"/>
    		<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
            
            <?php
				$oculto=$_POST['oculto'];
				//if($_POST[oculto])
				{
					$crit1="";
					if ($_POST[nombre]!=""){$crit1=" WHERE concat_ws(' ', id_cc, nombre) LIKE '%$_POST[nombre]%' ";}
					
					$sqlr="SELECT * FROM pptouniejecu $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					
					$cond2="";
				if ($_POST[numres]!="-1"){ 
					$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
				}
					$sqlr="SELECT * FROM pptouniejecu $crit1 ORDER BY id_cc ".$cond2;
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
					$ntips1=7;
					$ntips2=8;
					if($_SESSION["prdesactivar"]!=1){$ntips1=$ntips1-1;$ntips2=$ntips2-1;}
					if($_SESSION["preditar"]!=1){$ntips1=$ntips1-1;$ntips2=$ntips2-1;}
					if($_SESSION["preliminar"]!=1){$ntips1=$ntips1-1;$ntips2=$ntips2-1;}
					
					echo "
					<table class='inicio' align='center' width='80%'>
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
						<tr><td colspan='$ntips2'>Unidades Ejecutoras Encontradas: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2' style='width:5%;'>Item</td>
							<td class='titulos2' style='width:5%;'>Codigo</td>
							<td class='titulos2'>Nombre</td>
							<td class='titulos2' style='width:5%;'>Tipo</td>";
							
							if($_SESSION["prdesactivar"]==1){echo"<td class='titulos2' colspan='2' style='width:6%;' >Estado</td>";}	
							else {echo"<td class='titulos2' style='width:6%;' >Estado</td>";}
					if($_SESSION["preliminar"]==1){echo"<td class='titulos2' style='width:4%;' >Anular</td>";}
					if($_SESSION["preditar"]==1){echo"<td class='titulos2' style='width:4%;'>Editar</td>";}
					
					echo"</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
					 while ($row =mysql_fetch_row($resp)) 
					 {
						$tipo="";
						$con2=$con+ $_POST[numpos];
 						if($row[2]=='S')
	  						{$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;}
						else
							{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";;$_POST[lswitch1][$row[0]]=1;}
 						if($row[3]=='S'){$tipo="Entidad";}
 						if($row[3]=='N'){$tipo="Externo";} 
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
						else
						{
							echo"<tr class='$iter' style='text-transform:uppercase; $estilo' >";
						}
						echo"
						<td>$con2</td>
						<td>$row[0]</td>
						<td >$row[1]</td>
						<td>$tipo</td>
						<td style='text-align:center;'></td>";
						if($_SESSION["prdesactivar"]==1)
						{
							echo"<td style='text-align:center;'><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$row[0]\",\"".$_POST[lswitch1][$row[0]]."\")' /></td>";
						}
						if($_SESSION["preliminar"]==1)
						{
							echo"<td style='text-align:center;cursor:pointer;'><a onClick=anular(id=$row[0])><img src='imagenes/anular.png' style='width:22px' title='Anular'></a></td>";
						}
						if($_SESSION["preditar"]==1)
						{	
							echo"<td style='text-align:center;'>
									<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'>
										<img src='imagenes/b_edit.png' style='width:18px' title='Editar'>
									</a>
								</td>";
						}
						
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
    </body>
</html>












