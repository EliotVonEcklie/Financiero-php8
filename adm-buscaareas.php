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
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Administracion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function cambioswitch(id,valor)
			{
				if(valor==1)
				{
					if (confirm("Desea activar Estado")){document.form2.cambioestado.value="1";}
					else{document.form2.nocambioestado.value="1"}
				}
				else
				{
					if (confirm("Desea Desactivar Estado")){document.form2.cambioestado.value="0";}
					else{document.form2.nocambioestado.value="0"}
				}
				document.getElementById('idestado').value=id;
				document.form2.submit();
			}
        </script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
   	<tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("adm");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="adm-areas.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td></tr></table>
 <form name="form2" method="post" action="adm-buscaareas.php">
 			<?php
				if($_POST[oculto2]=="")
				{
					$_POST[oculto2]="0";
					$_POST[cambioestado]="";
					$_POST[nocambioestado]="";
				}
				//*****************************************************************
				if($_POST[cambioestado]!="")
				{
					$linkbd=conectar_bd();
					if($_POST[cambioestado]=="1")
					{
                        $sqlr="UPDATE admareas SET estado='S' WHERE id_cc='".$_POST[idestado]."'";
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
                        $sqlr="UPDATE admareas SET estado='N' WHERE id_cc='".$_POST[idestado]."'";
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
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4" style='width:93%'>:: Buscar Areas </td>
        <td class="cerrar" style='width:7%'><a href="adm-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td width="6%" class="saludo1">Nombre:</td>
        <td width="49%"><input name="nombre" type="text" value="" size="40">
        </td>
        <td width="13%" class="saludo1">Codigo Area:        </td>
        <td width="21%"><input name="documento" type="text" id="documento" value="" size="2" maxlength="2">
          <input name="oculto" type="hidden" value="1"></td>
       </tr>                       
    </table>    
    <input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2];?>">
    <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
    <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
    <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
    <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      <?php
		$oculto=$_POST['oculto'];
		if($_POST[oculto])
		{
			$crit1=" ";
			$crit2=" ";
			if ($_POST[nombre]!=""){$crit1=" WHERE (nombre like '%".$_POST[nombre]."%') ";}
			if ($_POST[documento]!="")
			{
				if ($_POST[nombre]!=""){$crit2=" and id_cc like '%$_POST[documento]%' ";}
				else{$crit2=" WHERE id_cc like '%$_POST[documento]%' ";}
			}
			$sqlr="select * from admareas ".$crit1.$crit2." order by id_cc";
			$resp = mysql_query($sqlr,$linkbd);
			$ntr = mysql_num_rows($resp);
			$con=1;
			echo "<table class='inicio' align='center' width='80%'><tr><td colspan='7' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='5'>Ubicaciones Encontrados: $ntr</td></tr><tr><td width='5%' class='titulos2'>Codigo</td><td class='titulos2'>Nombre</td><td class='titulos2' colspan='2' style='width:6%;'>ESTADO</td><td class='titulos2' width='5%'>EDITAR</td></tr>";	
			$iter='saludo1a';
			$iter2='saludo2';
 			while ($row =mysql_fetch_row($resp)) 
 			{
				if($row[2]=='S')
				{$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;}
				else
				{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";;$_POST[lswitch1][$row[0]]=1;}
	 			echo "<tr class='$iter' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
				<td>$row[0]</td>
				<td>$row[1]</td>
				<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
				<td><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"".$row[0]."\",\"".$_POST[lswitch1][$row[0]]."\")' /></td>
				<td style='text-align:center;'><a href='adm-editarareas.php?idtipocom=$row[0]'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a></td></tr>";
				$con+=1;
			   	$aux=$iter;
			   	$iter=$iter2;
			   	$iter2=$aux;
 			}
 			echo"</table>";
		}
?></div>
</form>
</body>
</html>