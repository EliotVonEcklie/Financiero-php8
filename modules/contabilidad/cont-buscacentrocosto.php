<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require "../../include/comun.php";
	require "../../include/funciones.php";
	session_start();
    $linkbd = conectar_v7();	

    if(isset($_GET['codpag']))
        cargarcodigopag($_GET['codpag'],$_SESSION['nivel']);
    
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
				location.href="cont-editarcentrocosto.php?idtipocom="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("cont");?></tr>
			<tr>
            	<?php 
					if($_SESSION["prcrear"]==1)
					{
                        $botonnuevo = '<a onClick="location.href=\'cont-centrocostos.php\'" class="mgbt"><img src="../../img/icons/add.png" title="Nuevo" style="height:25; width:25" /></a>';
                    }
					else
					{
                        $botonnuevo = "<a class='mgbt1'><img src='../../img/icons/add.png' /></a>";
                    }
				?>
  				<td colspan="3" class="cinta">
				<?php echo $botonnuevo;?>
					<a class="mgbt"><img src="../../img/icons/disabled-save.png"style="height:25; width:25"/></a>
					<a onClick="document.form2.submit();" class="mgbt"><img src="../../img/icons/search.png" title="Buscar" style="height:25; width:25"/></a>
					<a href="" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="../../img/icons/agenda.png"style="height:25; width:25" title="Agenda"/></a>
					<a onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="../../img/icons/new-tv.png"style="height:25; width:25" title="Nueva Ventana"></a>
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
			if(!isset( $_POST['oculto']))
			{
                if(isset($_GET['scrtop']))
                    $_POST['scrtop'] = $_GET['scrtop'];
                if(isset($_GET['scrtop'] ))    
				    if($_POST['scrtop'] = $_GET['scrtop'])
				        $_POST['gidcta']=$_GET['idcta'];
				if(isset($_GET['filtro'])){$_POST['numero']=$_GET['filtro'];}
            }
            if(isset($_GET['scrtop'] ))
            {
                echo"<script>window.onload=function(){ $('#divdet').scrollTop(".$_POST['scrtop'].")}</script>";
            }
            $oculto = "";
            if(isset($_GET['numpag'] ))
            {
                if($_GET['numpag']!="")
                {
                    $oculto=$_POST['oculto'];
                    if($oculto!=2)
                    {
                    $_POST['numres']=$_GET['limreg'];
                    $_POST['numpos']=$_GET['limreg']*($_GET['numpag']-1);
                    $_POST['nummul']=$_GET['numpag']-1;
                    }
                }
            }    
			else
			{
                 
                    if(isset( $_POST['nummul']))
                    {
                        $_POST['numres']=10;
                        $_POST['numpos']=0;
                        $_POST['nummul']=0;
                    }
                }
		?>
 		<form name="form2" method="post" action="cont-buscacentrocosto.php">
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
                    if($_POST['cambioestado']=="1")
                    {
                        $sqlr = 'UPDATE centrocosto SET estado=\'S\' WHERE id_cc=\''.$_POST['idestado'].'\'';
                        mysqli_fetch_row(mysqli_query($sqlr,$linkbd)); 
                    }
                    else 
                    {
                        $sqlr="UPDATE centrocosto SET estado='N' WHERE id_cc='$_POST[idestado]'";
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
                    <td class="titulos" colspan="4">:: Buscar Centro de Costos </td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='cont-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style='width:3cm;'>C&oacute;digo o Nombre:</td>
                    <td >
                    	<input type="search" name="nombre" id="nombre" value="<?php if(isset( $_POST['nombre'])) echo $_POST['nombre'];?>" style='width:50%;'/>
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
                </tr>                       
            </table>  
            <input name="oculto" id="oculto" type="hidden" value="1"/>
     		<input type="hidden" name="oculto2" id="oculto2" value="<?php if(isset( $_POST['oculto2'])) echo $_POST['oculto2'];?>"/>
    		<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST['cambioestado'];?>"/>
   			<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php if(isset( $_POST['nocambioestado'])) echo $_POST['nocambioestado'];?>"/>
    		<input type="hidden" name="idestado" id="idestado" value="<?php if(isset( $_POST['idestado'])) echo $_POST['idestado'];?>"/> 
            <input type="hidden" name="numres" id="numres" value="<?php if(isset( $_POST['numres'])) echo $_POST['numres'];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php if(isset( $_POST['numpos'])) echo $_POST['numpos'];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php if(isset( $_POST['nummul'])) echo $_POST['nummul'];?>"/>
            <input type="hidden" name="scrtop" id="scrtop" value="<?php if(isset( $_POST['scrtop'])) echo $_POST['scrtop'];?>"/>
        	<input type="hidden" name="gidcta" id="gidcta" value="<?php if(isset( $_POST['gidcta'])) echo $_POST['gidcta'];?>"/>
    		<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
      		<?php
            $oculto = ""; 
            if(isset( $_POST['oculto']))
            {
				$oculto=$_POST['oculto'];
			}	//if($_POST[oculto])
				{
                    $crit1="";
                    if(isset( $_POST['numres']))
					if ($_POST['nombre']!=""){$crit1=" WHERE concat_ws(' ', id_cc, nombre) LIKE '%  $_POST[nombre]%' ";}
					$sqlr="SELECT * FROM centrocosto $crit1";
					$resp = mysqli_query($linkbd,$sqlr);
                    $_POST['numtop']=mysqli_num_rows($resp);
                    if(isset( $_POST['numres']))
					$nuncilumnas=ceil($_POST['numtop']/$_POST['numres']);

                $cond2="";
                if(isset( $_POST['numres']))
				if ($_POST['numres']!="-1"){ 
					$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
				}
					$sqlr="SELECT * FROM centrocosto $crit1 ORDER BY id_cc ".$cond2;
					$resp = mysqli_query($linkbd,$sqlr);
                    $con=1;
                    $numcontrol = "";
                    $nuncilumnas = "";
                    if(isset( $_POST['numres'])){
                        $numcontrol=$_POST['nummul']+1;
                        if(($nuncilumnas==$numcontrol)||($_POST['numres']=="-1"))
                        {
                            $imagenforward="<img src='imagenes/forward02.png' style='width:17px;cursor:default;'>";
                            $imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px;cursor:default;' >";
                        }
                        else 
                        {
                            $imagenforward="<img src='imagenes/forward01.png' style='width:17px;cursor:pointer;' title='Siguiente' onClick='numsiguiente()'>";
                            $imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px;cursor:pointer;' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
                        }
                    }
                    
                    if(isset( $_POST['numres'])){    
                        if(($_POST['numpos']==0)||($_POST['numres']=="-1"))
                        {
                            $imagenback="<img src='imagenes/back02.png' style='width:17px;cursor:default;'>";
                            $imagensback="<img src='imagenes/skip_back02.png' style='width:16px;cursor:default;'>";
                        }
                        else
                        {
                            $imagenback="<img src='imagenes/back01.png' style='width:17px;cursor:pointer;' title='Anterior' onClick='numanterior();'>";
                            $imagensback="<img src='imagenes/skip_back01.png' style='width:16px;cursor:pointer;' title='Inicio' onClick='saltocol(\"1\")'>";
                        }
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
                                
									<option value='10'"; if (isset($_POST['renumres']) && $_POST['renumres']=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if (isset($_POST['renumres']) && $_POST['renumres']=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if (isset($_POST['renumres']) && $_POST['renumres']=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if (isset($_POST['renumres']) && $_POST['renumres']=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if (isset($_POST['renumres']) && $_POST['renumres']=='100'){echo 'selected';} echo ">100</option>
									<option value='-1'"; if (isset($_POST['renumres']) && $_POST['renumres']=='-1'){echo 'selected';} echo ">Todos</option>
								</select>
							</td>
						</tr>
						<tr><td colspan='$ntips2'>Centro de Costos Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2' style='width:5%;'>Item</td>
							<td class='titulos2' style='width:5%;'>Codigo</td>
							<td class='titulos2'>Nombre</td>
							<td class='titulos2' style='width:5%;'>Tipo</td>";
					if($_SESSION["prdesactivar"]==1){echo"<td class='titulos2' colspan='2' style='width:6%;' >Estado</td>";}	
					else {echo"<td class='titulos2' style='width:6%;' >Estado</td>";}
					if($_SESSION["preditar"]==1){echo"<td class='titulos2' style='width:4%;'>Editar</td>";}
					if($_SESSION["preliminar"]==1){echo"<td class='titulos2' style='width:4%;' >Eliminar</td>";}
					echo"</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
					 while ($row =mysqli_fetch_row($resp)) 
					 {
                        $con2 = "";
                        $tipo="";
                        if(isset( $_POST['numpos']))
						$con2=$con+ $_POST['numpos'];
 						if($row[2]=='S')
	  						{$imgsem="src='../../img/icons/green-circle.png' title='Activo'";$coloracti="#0F0";$_POST['lswitch1'][$row[0]]=0;}
						else
							{$imgsem="src='../../img/icons/red-circle.png' title='Inactivo'";$coloracti="#C00";;$_POST['lswitch1'][$row[0]]=1;}
 						if($row[3]=='S'){$tipo="Entidad";}
 						if($row[3]=='N'){$tipo="Externo";} 
						if(isset( $_POST['gidcta']))
						{
							if($_POST['gidcta']==$row[0]){$estilo='background-color:yellow';}
							else{$estilo="";}
						}
						else{$estilo="";}	
						$idcta="'$row[0]'";
                        $numfil="'$filas'";
                        $filtro="";
                        if(isset( $_POST['nombre']))
						$filtro="'$_POST[nombre]'";
						if($_SESSION["preditar"]==1)
						{
							echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >";
						}
						else
						{
							echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase; $estilo' >";
						}
						echo"
						<td>$con2</td>
						<td>$row[0]</td>
						<td >$row[1]</td>
						<td>$tipo</td>
						<td style='text-align:center;'><img $imgsem style='width:20px'/></td>";
						if($_SESSION["prdesactivar"]==1)
						{
							echo"<td style='text-align:center;'><input type='range' name='lswitch1[]' value='".$_POST['lswitch1'][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$row[0]\",\"".$_POST['lswitch1'][$row[0]]."\")' /></td>";
						}
	 					if($_SESSION["preditar"]==1)
						{	
							echo"<td style='text-align:center;'>
									<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'>
										<img src='../../img/icons/edit-file.png' style='width:18px' title='Editar'>
									</a>
								</td>";
						}
						if($_SESSION["preliminar"]==1)
						{
							echo"<td style='text-align:center;cursor:pointer;'><a onClick=anular(id=$row[0])><img src='../../img/icons/delete.png' style='width:22px' title='Eliminar'></a></td>";
						}
	 					$con+=1;
	 					$aux=$iter;
	 					$iter=$iter2;
	 					$iter2=$aux;
						$filas++;
                     }
                     $tibusqueda = "";
					if ($_POST['numtop']==0)
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%'><img src='../../img/icons/warning.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda $tibusqueda<img src='../../img/icons/warning.png' style='width:25px'></td>
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
                    $imagenforward = "";
                    $imagensforward = "";
					echo"			&nbsp;&nbsp;<a>$imagenforward</a>
									&nbsp;<a>$imagensforward</a>
								</td>
							</tr>
						</table>";
				}
			?>			
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST['numtop'];?>" />
		</form>
	</body>
</html>
