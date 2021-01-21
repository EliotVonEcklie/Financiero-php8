<?php //V 1000 12/12/16 ?> 
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
		<script type='text/javascript' src='../../js/JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="../../js/programas.js"></script>
		<script>
			$(window).load(function () {
				$('#cargando').hide();
			});
			function verUltimaPos(idcta, filas, filtro)
			{
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag=="")){numpag=0;}
				if((limreg==0)||(limreg=="")){limreg=20;}
				numpag++;
				location.href="cont-editarplancuentanicsp.php?idtipocom="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<script>
			function anular(id)
			{
				document.form2.cod.value=id;
				despliegamodalm('visible','4',"Esta Seguro de Eliminar la Cuenta "+id,'3');
			}
			function cambioswitch(id,valor)
			{	
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea Activar este Plan de Cuentas','1');}
				else{despliegamodalm('visible','4','Desea Desactivar este Plan de Cuentas','2');}
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
			function crearexcel(){
				document.form2.action="cont-cuentasnicspxls1.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
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
  				<td colspan="3" class="cinta">
					<a onClick="location.href='cont-cuentasaddnicsp.php'" class='mgbt'><img src="../../img/icons/add.png" title="Nuevo" style="height:25; width:25"/></a>
					<a class="mgbt1"><img img src="../../img/icons/disabled-save.png"style="height:25; width:25"/></a>
					<a onClick="document.form2.submit()" class="mgbt"><img src="../../img/icons/search.png" title="Buscar" style="height:25; width:25"/></a>
					<a href="" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="../../img/icons/agenda.png"style="height:25; width:25" title="Agenda"/></a>
					<a onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="../../img/icons/new-tv.png"style="height:25; width:25" title="Nueva Ventana"></a>
					<a href="#" onclick="crearexcel()" class="mgbt"><img src="../../img/icons/excel.png"style="height:25; width:25" title="Excel"></a>
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
            if(isset($_GET['oculto']))
                if($_POST['oculto']=="")
                {
                    $_POST['scrtop']=$_GET['scrtop'];
                    if($_POST['scrtop']==""){$_POST['scrtop']=0;}
                    $_POST['gidcta']=$_GET['idcta'];
                    if(isset($_GET['filtro'])){$_POST['numero']=$_GET['filtro'];}
                }
                if(isset($_GET['scrtop']))
			echo"<script>window.onload=function(){ $('#divdet').scrollTop(".$_POST['scrtop'].")}</script>";
            if(isset($_GET['numpag']))
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
			else{if($_POST['nummul']==""){$_POST['numres']=20;$_POST['numpos']=0;$_POST['nummul']=0;}}
		?>
   		<form name="form2" action="cont-cuentasnicsp.php" method="post" > 
   		<?php
        //	if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}
        if(isset($_GET['oculto2']))
			if($_POST['oculto2']=="")
			{
				$_POST['oculto2']="0";
				$_POST['cambioestado']="";
				$_POST['nocambioestado']="";
			}
			//*****************************************************************
			if(isset($_GET['cambioestado']))
			if($_POST['cambioestado']!="")
			{
				if($_POST['cambioestado']=="1")
				{
					$sqlr="UPDATE cuentasnicsp SET estado='S' WHERE cuenta='".$_POST['idestado']."'";
                    mysqli_fetch_row(mysqli_query($linkbd, $sqlr)); 
				}
				else 
				{
					$sqlr="UPDATE cuentasnicsp SET estado='N' WHERE cuenta='".$_POST['idestado']."'";
					mysqli_fetch_row(mysqli_query($sqlr,$linkbd)); 
				}
				echo"<script>document.form2.cambioestado.value=''</script>";
			}
            //*****************************************************************
            if(isset($_GET['nocambioestado']))
			if($_POST['nocambioestado']!="")
			{
				if($_POST['nocambioestado']=="1"){$_POST['lswitch1'][$_POST['idestado']]=1;}
				else {$_POST['lswitch1'][$_POST['idestado']]=0;}
				echo"<script>document.form2.nocambioestado.value=''</script>";
			}
		?> 
  			<table class="inicio">
    		<tr>
          		<td colspan="4" class="titulos" >:.Buscar Cuentas </td>
              	<td class="cerrar" style="width:7%;" ><a onClick="location.href='cont-principal.php'">&nbsp;Cerrar</a></td>
    		</tr>
            <tr><td colspan="5" class="titulos2">:&middot; Por Descripcion </td></tr>
			<tr>
                <td style="width:4cm;" class="saludo1" >:&middot; Cuenta o Descripci&oacute;n:</td>
                <td colspan="2">
                	<input type="search" name="numero" id="numero" value="<?php if(isset($_GET['numero'])) echo $_POST['numero'];?>" style="width:90%;"/>
                    <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                </td>
				 <td class="tamano03">
                	<input type="checkbox" name="todos" id="todos" class="defaultcheckbox"  <?php if(!empty($_POST['todos'])){echo "CHECKED"; }?>/>Todos
                </td>
			</tr>
  		</table>
		<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
			<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
		</div>
        <input type="hidden" name="oculto" id="oculto" value="1" >
        <input type="hidden" name="ac" id="ac" value="1" >
        <input type="hidden" name="cod" id="cod" value="1" >
        <input type="hidden" name="oculto2" id="oculto2" value="<?php if(isset($_GET['oculto2'])) echo $_POST['oculto2'];?>">
        <input type="hidden" name="cambioestado" id="cambioestado" value="<?php if(isset($_GET['cambioestado'])) echo $_POST['cambioestado'];?>">
        <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php if(isset($_GET['nocambioestado'])) echo $_POST['nocambioestado'];?>">
        <input type="hidden" name="idestado" id="idestado" value="<?php if(isset($_GET['idestado'])) echo $_POST['idestado'];?>">
        <input type="hidden" name="numres" id="numres" value="<?php if(isset($_GET['numres'])) echo $_POST['numres'];?>"/>
    	<input type="hidden" name="numpos" id="numpos" value="<?php if(isset($_GET['numpos'])) echo $_POST['numpos'];?>"/>
       	<input type="hidden" name="nummul" id="nummul" value="<?php if(isset($_GET['nummul'])) echo $_POST['nummul'];?>"/>
        <input type="hidden" name="scrtop" id="scrtop" value="<?php if(isset($_GET['scrtop'])) echo $_POST['scrtop'];?>"/>
        <input type="hidden" name="gidcta" id="gidcta" value="<?php if(isset($_GET['gidcta'])) echo $_POST['gidcta'];?>"/>
		<div class="subpantallap" style="height:65%; width:99.6%; overflow-x:hidden;" id="divdet">
        <?php
            $ca = "";
            if(isset($_GET['ac']))
			$ca=$_POST['ac'];
			if ($ca==2)
			{
				$sqlr="select count(*) from comprobante_det where  cuenta='$_POST[cod]'";
				$res=mysqli_query($linkbd, $sqlr);
				$cf =mysqli_fetch_row($res);
				if($cf[0]==0)
				{
					$sqlr="delete from cuentasnicsp  where cuenta='$_POST[cod]' ";
					$cont=0;
					$resp=mysqli_query($linkbd, $sqlr);
					if (!$resp) 
					{	
						echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
						//$e =mysql_error($respquery);
						echo "Ocurri� el siguiente problema:<br>";
						echo "<pre>";
						echo "</pre></center></td></tr></table>";
					}
					else
					{
						$ntr = mysqli_affected_rows($linkbd);
						if ($ntr==0){echo "<script>despliegamodalm('visible','2','No se puede anular la cuenta por ser de tipo Mayor');</script>";}
					}
				}
				else{echo "<script>despliegamodalm('visible','2','No se puede anular, la cuenta tiene movimientos contables anteriores');</script>";}
            }
            if(isset($_GET['oculto']))   
			$oculto=$_POST['oculto'];
			//if($oculto!="")
			{
                $cond="";
                if(isset($_GET['numero']))
				if ($_POST['numero']!=""){$cond="WHERE concat_ws(' ', tabla.cuenta, tabla.nombre) LIKE '%$_POST[numero]%'";$cond1="WHERE concat_ws(' ', cuenta, nombre) LIKE '%$_POST[numero]%'"; }
				if(!empty($_POST['todos'])){
					$sqlr="SELECT * FROM cuentasnicsp $cond1";
				}else{
					$sqlr="SELECT * FROM (SELECT cn1.cuenta FROM cuentasnicsp AS cn1 INNER JOIN cuentasnicsp AS cn2 ON cn2.tipo='Auxiliar'  AND cn2.cuenta LIKE CONCAT( cn1.cuenta,  '%' ) WHERE cn1.tipo='Mayor' GROUP BY cn1.cuenta UNION SELECT cuenta FROM cuentasnicsp WHERE tipo='Auxiliar') AS tabla  $cond";
				}
				
                if(isset($_GET['oculto']))
				if($_POST['oculto']!=2){
					$resp = mysqli_query($linkbd, $sqlr);		
					$_POST['numtop']=mysqli_num_rows($resp);
				}
				if(isset($_GET['numtop']))
				$nuncilumnas=ceil($_POST['numtop'] && $_POST['numres']);
                $cond2="";
                
                if(!isset($_POST['numres']))
                {
                    $cond2 = 'LIMIT $_POST[numpos], $_POST[numres]';
                }
				if(!empty($_POST['todos'])){
					$sqlr="SELECT * FROM cuentasnicsp $cond1 ORDER BY cuenta $cond2";
				}else{
					$sqlr="SELECT * FROM (SELECT cn1.cuenta,cn1.nombre,cn1.naturaleza,cn1.centrocosto,cn1.tercero,cn1.tipo,cn1.estado FROM cuentasnicsp AS cn1 INNER JOIN cuentasnicsp AS cn2 ON cn2.tipo='Auxiliar'  AND cn2.cuenta LIKE CONCAT( cn1.cuenta,  '%' ) WHERE cn1.tipo='Mayor' GROUP BY cn1.cuenta UNION SELECT cuenta,nombre,naturaleza,centrocosto,tercero,tipo,estado FROM cuentasnicsp WHERE tipo='Auxiliar') AS tabla $cond ORDER BY 1 $cond2";
				}
                $resp = mysqli_query($linkbd, $sqlr);
                if(isset($_GET['nummul']))		
                $numcontrol=$_POST['nummul']+1;
                if(isset($_GET['numres']))	
				if(($nuncilumnas==$numcontrol)||($_POST['numres']=="-1"))
				{
					$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
					$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
				}
				else 
				{
					$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
					$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
                }
                if(isset($_GET['numpos']))	
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
				$ntips1=6;
				$ntips2=8;
				if($_SESSION["prdesactivar"]!=1){$ntips1=$ntips1-1;$ntips2=$ntips2-1;}
				if($_SESSION["preditar"]!=1){$ntips1=$ntips1-1;$ntips2=$ntips2-1;}
				if($_SESSION["preliminar"]!=1){$ntips1=$ntips1-1;$ntips2=$ntips2-1;}
				echo "
				<table class='inicio'>
					<tr>
						<td colspan='$ntips1' class='titulos'>:.Resultados Busqueda </td>
						<td class='submenu'>
							<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
								<option value='20'"; if ($_POST['renumres']=='20'){echo 'selected';} echo ">20</option>
								<option value='40'"; if ($_POST['renumres']=='40'){echo 'selected';} echo ">40</option>
								<option value='80'"; if ($_POST['renumres']=='80'){echo 'selected';} echo ">80</option>
								<option value='100'"; if ($_POST['renumres']=='100'){echo 'selected';} echo ">100</option>
								<option value='200'"; if ($_POST['renumres']=='200'){echo 'selected';} echo ">200</option>
								<option value='-1'"; if ($_POST['renumres']=='-1'){echo 'selected';} echo ">Todos</option>
							</select>
						</td>
					</tr>
					<tr><td colspan='$ntips2'>Cuentas Encontradas: $_POST[numtop]</td></tr>
					<tr>
						<td class='titulos2' style='width:5%;'>Item</td>
						<td class='titulos2' style='width:12%;'>Cuenta </td>
						<td class='titulos2'>Descripcion</td>
						<td class='titulos2' style='width:15%;'>Tipo</td>";
				if($_SESSION["prdesactivar"]==1){echo"<td class='titulos2' colspan='2' style='width:6%;' >Estado</td>";}	
				else {echo"<td class='titulos2' style='width:6%;' >Estado</td>";}
				echo"<td class='titulos2' style='width:4%;'>Naturaleza</td>";
				echo"</tr>";		
				$co='saludo1a';
				$co2='saludo2';	
				$i=1;
				$filas=1;
                while ($row = mysqli_fetch_row($resp)) 
				{
					$con2=$i+ $_POST['numpos'];
					if($r[6]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST['lswitch1'][$r[0]]=0;}
					else{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";;$_POST['lswitch1'][$r[0]]=1;}
					if($_POST['gidcta']!="")
					{
						if($_POST['gidcta']==$r[0]){$estilo='background-color:yellow';}
						else{$estilo="";}
					}
					else{$estilo="";}	
					$idcta="'$r[0]'";
					$numfil="'$filas'";
					$filtro="'$_POST[numero]'";
					if($_SESSION["preditar"]==1)
					{
						echo"<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
		onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >";
					}
					else
					{
						echo"<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
		onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase; $estilo' >";
					}
					echo"
					<input type='hidden' name='item[]' id='item[]' value='$con2'>
					<input type='hidden' name='cuenta[]' id='cuenta[]' value='$r[0]'>
					<input type='hidden' name='descripcion[]' id='descripcion[]' value='$r[1]'>
					<input type='hidden' name='tipo[]' id='tipo[]' value='$r[5]'>
					<input type='hidden' name='estado[]' id='estado[]' value='$r[6]'>
					<input type='hidden' name='naturaleza[]' id='naturaleza[]' value='$r[2]'>
					<td>$con2</td>
					<td>$r[0]</td>
					<td>$r[1]</td>
					<td>$r[5]</td>
					<td style='text-align:center;'><img $imgsem style='width:20px'/></td>";
					if($_SESSION["prdesactivar"]==1)
					{
					echo"<td style='text-align:center;'><input type='range' name='lswitch1[]' value='".$_POST['lswitch1'][$r[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$r[0]\",\"".$_POST['lswitch1'][$r[0]]."\")' /></td>";
					}
					echo"<td>$r[2]</td>";
					echo "</tr>";
					$aux=$co;
					$co=$co2;
					$co2=$aux;
					$i=1+$i;
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
						if($numcontrol==$numx){echo"<a  onClick='saltocol(\"$numx\")'; style='color:#24D915;cursor:pointer;'> $numx </a>";}
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
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST['numtop'];?>" />
		</form>
	</body>
</html>
