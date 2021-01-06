<?php //V 1001 17/12/16 ?> 
<?php
	error_reporting(0);
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
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Contrataci&oacute;n</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
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
				location.href="contra-modalidadedita.php?idproceso="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function entra(id){
				window.location.href='contra-editarexpedirpaaa.php?id='+id;
			}
		</script>
		<script>
			function cambioswitch(id1,id2,valor)
			{
				document.getElementById('idestado1').value=id1;
				document.getElementById('idestado2').value=id2;
				if(valor==1){despliegamodalm('visible','4','Desea activar esta Modalidad de Contratación','1');}
				else{despliegamodalm('visible','4','Desea Desactivar esta Modalidad de Contratación','2');}
			}
            function eliminar_inf(codigo)
            {
				document.getElementById('iddel').value=codigo;
				//despliegamodalm('visible','4','Esta Seguro de Eliminar la Modalidad de Contratación','1');
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
			function funcionmensaje(){document.location.href = "contra-modalidad.php";}
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
			function buscar(){
				document.form2.submit();
			}
		</script>
		<?php titlepag();?>
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
			$_POST[modalidad]=$_GET['filtro'];
		?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("inve");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a href="contra-expedirpaa.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" border="0" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
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
 		<form name="form2" method="post" action="contra-expedirpaabuscar.php">
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
						$sqlr="UPDATE dominios SET tipo='S' WHERE valor_inicial='$iddivi[0]' AND valor_final='$iddivi[1]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
						$sqlr="UPDATE dominios SET tipo='N' WHERE valor_inicial='$iddivi[0]' AND valor_final='$iddivi[1]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					echo"<script>document.form2.cambioestado.value=''</script>";
				}
				//*****************************************************************
				if($_POST[nocambioestado]!="")
				{
					if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado1]]=1;}
					else {$_POST[lswitch1][$_POST[idestado1]]=0;}
					echo"<script>document.form2.nocambioestado.value=''</script>";
				}
			?>
			<table  class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="6S">:: Buscar Solicitud PAA</td>
        			<td class="cerrar" style='width:7%'><a href="contra-principal.php">Cerrar</a></td>
     			</tr>
      			 <tr >
				<td style="width:6%" class="saludo1">C&oacute;digo:</td>
				<td style="width:20%"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]; ?>" style="width:98%" ></td>
				 <td style="width:7%" class="saludo1">Estado:</td>
				<td style="width:10%"><select name="estado" id="estado" style="width: 100%"> 
				<option value="" <?php if($_POST[estado]==''){echo "SELECTED"; }; ?> >Seleccione</option>
				<option value="A" <?php if($_POST[estado]=='A'){echo "SELECTED"; }; ?> >Pendientes</option>
				<option value="CE" <?php if($_POST[estado]=='CE'){echo "SELECTED"; }; ?>>Certificados</option>
				<option value="CO" <?php if($_POST[estado]=='CO'){echo "SELECTED"; }; ?>>Por Corregir</option>
				<option value="CC" <?php if($_POST[estado]=='CC'){echo "SELECTED"; }; ?>>Corregidos</option>
				</select></td>
				<td style="width:7%" class="saludo1">Descripcion:</td>
				<td><input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]; ?>" style="width:87%"><input type="button" name="busca" value="  Buscar " onclick="buscar()" style="float: right;"></td>
			   </tr>                        
    		</table>
     		<input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
            <input type="hidden" name="idestado1" id="idestado1" value="<?php echo $_POST[idestado1];?>">
            <input type="hidden" name="idestado2" id="idestado2" value="<?php echo $_POST[idestado2];?>">
        	<input type="hidden" name="ocudel" id="ocudel" value="<?php echo $_POST[ocudel]?>">
        	<input type="hidden" name="iddel" id="iddel" value="<?php echo $_POST[iddel]?>">
    		<div class="subpantallac5" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
			<?php

			$oculto=$_POST['oculto'];
			$cmoff='imagenes/sema_rojoOFF.jpg';
			$cmrojo='imagenes/sema_rojoOFF.jpg';
			$cmamarillo='imagenes/sema_amarilloON.jpg';
			$cmverde='imagenes/sema_verdeON.jpg';
			$contad=0;
			$linkbd=conectar_bd();
			$crit1=" ";
			$crit2=" ";
			$crit3=" ";
			$cmverde='imagenes/sema_verdeON.jpg';
			$cmoff='imagenes/sema_rojoOFF.jpg';
			if ($_POST[codigo]!=""){$crit1=" AND codigo LIKE '%$_POST[codigo]%' ";}
			if ($_POST[descripcion]!=""){$crit2=" AND descripcion LIKE '%$_POST[descripcion]%' ";}
			if ($_POST[estado]!=""){$crit3=" AND estado LIKE '%$_POST[estado]%' ";}
			//sacar el consecutivo 
			$sqlr="SELECT * FROM contrasolicitudpaa WHERE codigo>0 AND estado<>'S' ".$crit1.$crit2.$crit3." ORDER BY CAST(codigo AS UNSIGNED)";
			$resp = mysql_query($sqlr,$linkbd);
			$ntr = mysql_num_rows($resp);
			$_POST[numtop]=$ntr;
			$con=1;
			echo "
				<table class='inicio' align='center' width='80%'>
					<tr>
						<td colspan='12' class='titulos'>.: Resultados Busqueda:</td>
					</tr>
					<tr>
						<td colspan='7'>Solicitudes Encontrados: $ntr</td>
					</tr>
					<tr>
						<td class='titulos2' style=\"width:7%\" rowspan='2'>Codigo</td>
						<td class='titulos2' style=\"width:8%\"  rowspan='2'>Codigo Solicitud</td>
						<td class='titulos2' style=\"width:28%\" rowspan='2'>Descripcion Solicitud</td>
						<td class='titulos2' style=\"width:12%\" rowspan='2'>Codigos Aprobados</td>
						<td class='titulos2' style=\"width:8%\" rowspan='2'>Vigencia</td>
						<td class='titulos2' style=\"width:10%\" align=\"middle\" colspan='5' >Estado</td>
						<td class='titulos2' width='3%' align=\"middle\"  rowspan='2'>Editar</td>
					</tr>
					<tr>
						

						
						<td class='titulos2' align='middle' style=\"width:2%\">ACTIVO</td>
						<td class='titulos2' align='middle' style=\"width:2%\">PENDIENTE</td>
						<td class='titulos2' align='middle' style=\"width:2%\">POR CORREGIR</td>
						<td class='titulos2' align='middle' style=\"width:2%\">CORREGIDO</td>
						<td class='titulos2' align='middle' style=\"width:2%\">CERTIFICADO</td>
						
					
					</tr>";	
			$iter='saludo1a';
			$iter2='saludo2';
	
			while ($row =mysql_fetch_row($resp)) 
			{
				$imagen="b_edit.png";
				$estilo="";
				$url="";
				$click="";
				$sql="SELECT activo FROM contrasoladquisiciones WHERE codsolicitud='$row[1]'  ";
				$res=mysql_query($sql,$linkbd);
				$fila=mysql_fetch_row($res);
				if($fila[0]=='1'){
					$imagen="candado.png";
					$estilo="style='width: 20px;height: 20px'";
					$url="";
					$click="onDblClick='entra($row[0])'";
				}else{
					$imagen="b_edit.png";
					$estilo="";
					$url="href='contra-editarexpedirpaaa.php?id=".$row[0]."'";
					$click="onDblClick='entra($row[0])' ";
				}
				if($row[3]=='S')
	  				{$ruta1=$cmverde;$ruta2=$cmrojo;$ruta3=$cmrojo;$ruta4=$cmrojo;$ruta5=$cmrojo; }
				else if($row[3]=='CE')
					{$ruta1=$cmrojo;$ruta2=$cmrojo;$ruta3=$cmrojo;$ruta4=$cmrojo;$ruta5=$cmverde; }
				else if($row[3]=='CO')
					{$ruta1=$cmrojo;$ruta2=$cmrojo;$ruta3=$cmverde;$ruta4=$cmrojo;$ruta5=$cmrojo; }
				else if($row[3]=='CC')
					{$ruta1=$cmrojo;$ruta2=$cmrojo;$ruta3=$cmrojo;$ruta4=$cmverde;$ruta5=$cmrojo; }
				else if($row[3]=='A')
					{$ruta1=$cmrojo;$ruta2=$cmverde;$ruta3=$cmrojo;$ruta4=$cmrojo;$ruta5=$cmrojo; }
				if($row[1]==0){
					$row[1] = "N/A";
				}
				echo "
					<tr class='$iter' $click >
						
						<td>".$row[0]."</td>
						<td>".$row[1]."</td>
						<td>".strtoupper($row[6])."</td>
						<td>".$row[7]."</td>
						<td>".$row[5]."</td>
						<td align=\"middle\" style='font-weight: bold;text-align:center;text-rendering: optimizeLegibility;' ><img src='$ruta1' width='16' height='16'></td>
						<td align=\"middle\" style='font-weight: bold;text-align:center;text-rendering: optimizeLegibility;' ><img src='$ruta2' width='16' height='16'></td>
						<td align=\"middle\" style='font-weight: bold;text-align:center;text-rendering: optimizeLegibility;' ><img src='$ruta3' width='16' height='16'></td>
						<td align=\"middle\" style='font-weight: bold;text-align:center;text-rendering: optimizeLegibility;' ><img src='$ruta4' width='16' height='16'></td>
						<td align=\"middle\" style='font-weight: bold;text-align:center;text-rendering: optimizeLegibility;' ><img src='$ruta5' width='16' height='16'></td>
						<td align=\"middle\"><a $url><img src='imagenes/$imagen' $estilo></a></td>
					</tr>";
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
			 }
if ($_POST[numtop]==0)
{

	echo "
	<table class='inicio'>
		<tr>
			<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda<img src='imagenes\alert.png' style='width:25px'></td>
		</tr>
	</table>";
}
 echo"</table>";

?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>