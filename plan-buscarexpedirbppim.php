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
				window.location.href='plan-editarexpedirbppim.php?id='+id;
			}
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm3('visible','4','Desea activar Estado','1');}
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
 				<td colspan="3" class="cinta"><a href="plan-expedirbppim.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a><a href="#"  onClick="#" class="mgbt"><img src="imagenes/guardad.png"/></a><a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a><a href="#" class="mgbt" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>
		</table>	
 		<form name="form2" method="post" action="plan-buscarexpedirbppim.php" enctype="multipart/form-data">
		<table  class="inicio" align="center" >
     	<tr >
        <td class="titulos" colspan="6" style="width:92%">:: Buscar Solicitudes BPIM </td>
        <td width="11%" class="cerrar" style="width:8%"><a href="plan-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td style="width:6%" class="saludo1">C&oacute;digo:</td>
        <td style="width:20%"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]; ?>" style="width:98%" ></td>
         <td style="width:7%" class="saludo1">Estado:</td>
        <td style="width:10%"><select name="estado" id="estado" style="width: 100%"> 
        <option value="A" <?php if($_POST[estado]=='A'){echo "SELECTED"; }; ?> >Pendientes</option>
        <option value="CE" <?php if($_POST[estado]=='CE'){echo "SELECTED"; }; ?>>Certificados</option>
        <option value="CO" <?php if($_POST[estado]=='CO'){echo "SELECTED"; }; ?>>Por Corregir</option>
        <option value="CC" <?php if($_POST[estado]=='CC'){echo "SELECTED"; }; ?>>Corregidos</option>
        </select></td>
        <td style="width:7%" class="saludo1">Descripcion:</td>
        <td><input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]; ?>" style="width:100%"></td>
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

			$oculto=$_POST['oculto'];
		
			$contad=0;
			$linkbd=conectar_bd();
			$crit1=" ";
			$crit2=" ";
			$crit3=" ";
			$cmoff='imagenes/sema_rojoOFF.jpg';
			$cmrojo='imagenes/sema_rojoOFF.jpg';
			$cmverde='imagenes/sema_verdeON.jpg';
			if ($_POST[codigo]!=""){$crit1=" AND codsolicitud LIKE '%$_POST[codigo]%' ";}
			if ($_POST[descripcion]!=""){$crit2=" AND descripcion LIKE '%$_POST[descripcion]%' ";}
			if ($_POST[estado]!=""){$crit3=" AND estado LIKE '%$_POST[estado]%' ";}
			//sacar el consecutivo 
			$sqlr="SELECT * FROM contrasolicitudproyecto WHERE codigo>0 AND estado<>'S' ".$crit1.$crit2.$crit3." ORDER BY CAST(codigo AS UNSIGNED)";
			//echo $sqlr;
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
						<td class='titulos2' style=\"width:7%\" rowspan='2'>Item</td>
						<td class='titulos2' style=\"width:8%\" rowspan='2' >Codigo Solicitud</td>
						<td class='titulos2' style=\"width:28%\" rowspan='2'>Nombre del Proyecto</td>
						<td class='titulos2' style=\"width:8%\" rowspan='2'>Vigencia</td>
						<td class='titulos2' style=\"width:10%\" align=\"middle\" colspan='5' >Estado</td>
						<td class='titulos2' width='3%' align=\"middle\" rowspan='2'>Editar</td>
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
				$click="onDblClick='entra($row[0])' ";
				$sql="SELECT activo FROM contrasoladquisiciones WHERE codsolicitud='$row[1]' ";
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
					$url="href='plan-editarexpedirbppim.php?id=".$row[0]."'";
					$click="onDblClick='entra($row[0])' ";
				}
				
				if($row[4]=='S')
	  				{$ruta1=$cmverde;$ruta2=$cmrojo;$ruta3=$cmrojo;$ruta4=$cmrojo;$ruta5=$cmrojo; }
				else if($row[4]=='CE')
					{$ruta1=$cmrojo;$ruta2=$cmrojo;$ruta3=$cmrojo;$ruta4=$cmrojo;$ruta5=$cmverde; }
				else if($row[4]=='CO')
					{$ruta1=$cmrojo;$ruta2=$cmrojo;$ruta3=$cmverde;$ruta4=$cmrojo;$ruta5=$cmrojo; }
				else if($row[4]=='CC')
					{$ruta1=$cmrojo;$ruta2=$cmrojo;$ruta3=$cmrojo;$ruta4=$cmverde;$ruta5=$cmrojo; }
				else if($row[4]=='A')
					{$ruta1=$cmrojo;$ruta2=$cmverde;$ruta3=$cmrojo;$ruta4=$cmrojo;$ruta5=$cmrojo; }
				echo "
					<tr class='$iter'  $click >
						
						<td>".$con."</td>
						<td>".$row[1]."</td>
						<td>".strtoupper($row[10])."</td>
						<td>".$row[3]."</td>
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

?></div>
 <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
</form>
</td></tr>     
</table>
</body>
</html>