<?php //V 1000 12/12/16 ?> 
<?php
error_reporting(0);
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <script>
			function entra(id){
				window.location.href='plan-proyectoseditar.php?idproceso='+id;
			}
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1 ){despliegamodalm3('visible','4','Desea activar Estado','1');}
				else{despliegamodalm3('visible','4','Desea Desactivar Estado','2');}
			}
			function eliminar_inf(codigo,nombredel)
			{
				if (confirm("Seguro desea Anular:\n"+nombredel.toUpperCase()))
				{
					document.getElementById('iddel').value=codigo;
					document.getElementById('archdel').value=nombredel;
					document.getElementById('ocudel').value="1";
					document.form2.submit();
				}
			}
			function eliminar_arch(cod1,narch)
			{
				if (confirm("Esta Seguro de Eliminar el Proyecto \""+narch.toUpperCase()+"\""))
				{
					document.getElementById('idclase').value=cod1;
					document.getElementById('archdel').value=narch;
					document.getElementById('ocudelplan').value="1";
					document.form2.submit();
				}
			}
			function despliegamodalm3(_valor,_tip,mensa,pregunta)
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
			function respuestaconsulta(estado,id){
				document.form2.cambia.value="1";
				document.form2.nocambioestado.value=id;
				document.form2.submit();
			}
			function funcionmensaje(){
				
			}
			function despliegamodalm(_valor,_tipo,_nomb)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tipo)
					{
						case 1:
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos=Se Anul\xf3 El Proyecto \""+_nomb+"\" con Exito";break;
						case 2:
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos=Se Elimino El Archivo \""+_nomb+"\" con Exito";break;
						case 3:
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos=Se ingres\xf3 Exito el Archivo con el nombre \""+_nomb+"\"";break;
						case 4:
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos=Ya se ingres\xf3 un Archivo con el nombre \""+_nomb+"\"";break;
					}
						
				}
			}
        </script>
		<script type="text/javascript" src="css/programas.js"></script>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <table>
            <tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("plan");?></tr>
            <tr>
 				<td colspan="3" class="cinta"><a href="plan-proyectos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a><a href="#"  onClick="#" class="mgbt"><img src="imagenes/guardad.png"/></a><a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a><a href="#" class="mgbt" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>
		</table>	
 		<form name="form2" method="post" action="plan-proyectosbuscar.php" enctype="multipart/form-data">
		<table  class="inicio" align="center" >
     	<tr >
        <td class="titulos" colspan="6" style="width:92%">:: Buscar Proyectos </td>
        <td width="11%" class="cerrar" style="width:8%"><a href="plan-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td style="width:6%" class="saludo1">C&oacute;digo:</td>
        <td style="width:20%"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]; ?>" style="width:98%" ></td>
         <td style="width:7%" class="saludo1">Vigencia:</td>
        <td style="width:10%"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]; ?>" style="width:95%" ></td>
        <td style="width:7%" class="saludo1">Nombre:</td>
        <td><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]; ?>" style="width:100%"></td>
       </tr>                       
    </table>
	<input name="oculto" type="hidden" value="1">
    <input name="iddel" id="iddel" type="hidden" value="<?php echo $_POST[iddel]?>">
    <input name="ocudel" id="ocudel" type="hidden" value="<?php echo $_POST[ocudel]?>">
    <input name="archdel" id="archdel" type="hidden" value="<?php echo $_POST[archdel]?>">
    <input name="nomdel" id="nomdel" type="hidden" value="<?php echo $_POST[nomdel]?>">
    <input name="idclase" id="idclase" type="hidden" value="<?php echo $_POST[idclase]?>">
    <input name="ocudelplan" id="ocudelplan" type="hidden" value="<?php echo $_POST[ocudelplan]?>">
    <input name="contador" id="contador" type="hidden" value="<?php echo $_POST[contador]?>">
    <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
    <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>"/> 
	<input type="hidden" name="cambia" id="cambia" value="<?php echo $_POST[cambia];?>"/> 
    <div class="subpantallac5" style="height:68%">
	<?php
	if($_POST[nocambioestado]!="")
        {
           if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
           else {$_POST[lswitch1][$_POST[idestado]]=0;}
           echo"<script>document.form2.nocambioestado.value=''</script>";
        }
		
			if(!empty($_POST[cambia])){
				if($_POST[cambia]=="1"){
				$linkbd=conectar_bd();
				if($_POST[nocambioestado]=="1"){
					
					$sqlr ="UPDATE planproyectos SET estado='S' WHERE consecutivo='".$_POST[idestado]."'";
					mysql_query($sqlr,$linkbd);
				}
			   else if($_POST[nocambioestado]=="2"){
				   $sqlr ="UPDATE planproyectos SET estado='N' WHERE consecutivo='".$_POST[idestado]."'";
					mysql_query($sqlr,$linkbd);
			   }
			  
			}
		 echo"<script>document.form2.nocambioestado.value='';document.form2.cambia.value=''</script>";
	}
		
		//Eliminar Clase Contrato
		if($_POST['ocudel']=="1")
		{
			$linkbd=conectar_bd();
			$sqlr ="UPDATE planproyectos SET estado='N' WHERE consecutivo='".$_POST[iddel]."' ";
			mysql_query($sqlr,$linkbd);
			?><script>document.form2.ocudel.value="2";despliegamodalm('visible',1,'<?php echo $_POST[archdel]; ?>');</script><?php
			$_POST['ocudel']="2";
		}
		
		//Eliminar Archivos
		if($_POST['ocudelplan']=="1")
		{
			$linkbd=conectar_bd();
			$sqlr="UPDATE planproyectos SET archivo='' WHERE consecutivo='".$_POST[idclase]."'";
			mysql_query($sqlr,$linkbd);
			unlink($_POST[archdel]);
			?><script>document.form2.ocudelplan.value="2";despliegamodalm('visible',2,'<?php echo $_POST[archdel]; ?>');</script><?php 
		}
		//Cargar Archivo
		if (is_uploaded_file($_FILES['upload']['tmp_name'][$_POST[contador]])) 
		{	
			$linkbd=conectar_bd();
			$trozos = explode(".",$_FILES['upload']['name'][$_POST[contador]]);  
			$extension = end($trozos);  
			$nomar=$_FILES['upload']['name'][$_POST[contador]];
			$sqlr="SELECT * FROM planproyectos WHERE archivo='".$nomar."'";
			$resp = mysql_query($sqlr,$linkbd);
			$ntr = mysql_num_rows($resp);
			if($ntr==0)
			{
				copy($_FILES['upload']['tmp_name'][$_POST[contador]], "informacion/proyectos/".$nomar);
				$linkbd=conectar_bd();
				$sqlr="UPDATE planproyectos SET archivo='".$nomar."' WHERE consecutivo='".$_POST[idclase]."'";
				mysql_query($sqlr,$linkbd);
				{?><script>despliegamodalm('visible',3,'<?php echo $nomar; ?>');</script><?php }
			}
			else
				{?><script>despliegamodalm('visible',4,'<?php echo $nomar; ?>');</script><?php }
		}
		$oculto=$_POST['oculto'];
		
			$contad=0;
			$linkbd=conectar_bd();
			$crit1=" ";
			$crit2=" ";
			$crit3=" ";
			if ($_POST[codigo]!=""){$crit1=" AND codigo LIKE '%$_POST[codigo]%' ";}
			if ($_POST[nombre]!=""){$crit2=" AND nombre LIKE '%$_POST[nombre]%' ";}
			if ($_POST[vigencia]!=""){$crit3=" AND vigencia LIKE '%$_POST[vigencia]%' ";}
			//sacar el consecutivo 
			$sqlr="SELECT * FROM planproyectos WHERE estado<>'M' ".$crit1.$crit2.$crit3." ORDER BY CAST(consecutivo AS UNSIGNED)";
			$resp = mysql_query($sqlr,$linkbd);
			$ntr = mysql_num_rows($resp);
			$con=1;
			echo "
				<table class='inicio' align='center' width='80%'>
					<tr>
						<td colspan='12' class='titulos'>.: Resultados Busqueda:</td>
					</tr>
					<tr>
						<td colspan='7'>Proyectos Encontrados: $ntr</td>
					</tr>
					<tr>
						<td class='titulos2' style=\"width:7%\">C&oacute;digo</td>
						<td class='titulos2' style=\"width:8%\">vigencia</td>
						<td class='titulos2' style=\"width:18%\">Nombre</td>
						<td class='titulos2' style=\"width:5%\" align=\"middle\">Estado</td>
						<td class='titulos2' width='3%' align=\"middle\">Editar</td>
						<td class='titulos2' width='3%' align=\"middle\">Anular</td>
					</tr>";	
			$iter='saludo1a';
			$iter2='saludo2';
			while ($row =mysql_fetch_row($resp)) 
			{
				
				$sql="SELECT * FROM contrasolicitudproyecto WHERE codproyecto='$row[1]' AND estado='CE' ";
				$res=mysql_query($sql,$linkbd);
				$num = mysql_num_rows($res);
				
				
				if($row[5]!='N')
	  				{$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;}
				else
					{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";$_POST[lswitch1][$row[0]]=1;}

				if ($row[4]!="")
				{
					$bdescargar='<a href="'.$row[4].'" target="_blank"><img src="imagenes/descargar.png" title="Descargar" ></a>';
					$beliminar='<a href="#" onClick="eliminar_arch('.$row[0].',\''.$row[4].'\');"><img src="imagenes/cross.png" title="Eliminar Archivo"></a>';
					$bcargar="<div class='upload' style='display:none'><input type='file' name='upload[]'/></div><img src='imagenes/del3.png'>";
					$nomarchivo=explode(".",$row[4]);
					$icoext=traeico($row[4]);
				} 
				else
				{
					$bdescargar='<img src="imagenes/vacio2.png" title="Sin Archivo" >';
					$beliminar='<img src="imagenes/del4.png" >';
					$bcargar="<div class='upload'><input type='file' name='upload[]' onFocus='document.form2.contador.value=".$contad."; document.form2.idclase.value=".$row[0].";document.form2.nomdel.value=\"".$row[4]."\";' onChange='document.form2.submit();' /><img src='imagenes/attach.png' title='Cargar'  /> </div>";
					$icoext=traeico("");
				}
				if($num==0){
					$imagen="b_edit.png";
					$estilo="";
					$url="href='plan-proyectoseditar.php?idproceso=".$row[0]."'";
					$dblclick="onDblClick='entra($row[0])'";
					$cambio="onChange='cambioswitch(\"$row[0]\",\"".$_POST[lswitch1][$row[0]]."\")'";
					$anula="onClick='eliminar_inf(\"".$row[0]."\",\"".$row[3]."\");'";
				}else{
					$imagen="candado.png";
					$estilo="style='width: 20px;height: 20px'";
					$url="";
					$dblclick="onDblClick='entra($row[0])'";
					$cambio="disabled";
					$anula="";
				}
				$contad++;
				echo "
					<tr class='$iter' $dblclick >
						
						<td>".$row[1]."</td>
						<td>".$row[2]."</td>
						<td>".strtoupper($row[3])."</td>
						<td align=\"middle\"><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' $cambio /></td>
						<td align=\"middle\"><a $url><img src='imagenes/$imagen' $estilo></a></td>
						<td align=\"middle\"><a href='#' $anula><img src='imagenes/anular.png'></a></td>
					</tr>";
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
			 }
 echo"</table>";

?></div></form>
</td></tr>     
</table>
</body>
</html>