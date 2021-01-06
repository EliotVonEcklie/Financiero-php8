<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	sesion();
	$_SESSION["usuario"] ;
	$_SESSION["perfil"] ;
	$_SESSION["linkset"] ;
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
			function actualistado(){document.form2.oculto.value=1;document.form2.submit();}
			function agregar(){document.form2.action="verperfiles.php";document.form2.oculto.value="";document.form2.submit();}
			function habilitar(chkbox) 
			{ 
				habdesv=document.getElementsByName('habdes[]');
				chks=document.getElementsByName('asigna[]');
				for (var i=0;i < cali.length;i++) 
				{ 
					if(chks.item(i)==chkbox)
					{
						if (chkbox.checked==true)
						{
							habdesv.item(i).value="1";
							//alert("cabio"+habdesv.item(i).value)
						}
						else
							habdesv.item(i).value="0";
						//alert("cabio"+habdesv.item(i).value)
					}
				}
			} 
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
				}
			}
			function funcionmensaje(){document.location.href = "addperfil.php";}
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				var validacion02=document.getElementById('valor').value;
				if (validacion01.trim()!='' && validacion02.trim()!='' )
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
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
  				<td colspan="3" class="cinta"><a href="addperfil.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a><a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="perfiles.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
         	</tr>		  
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" action="">
			<?php
                if ($_POST[oculto]=="")
                {
                    $sqlr="select * from roles where id_rol=$_GET[idrol]";
                    $resp = mysql_query($sqlr,$linkbd);
                    $fila =mysql_fetch_row($resp);
                    // $fila = oci_fetch_array($resp,OCI_BOTH);
                    $cr=$fila[0];
                    $nombre=$fila[1];
                    $des=$fila[3];
                    desconectar_bd();
                }
                else
                {
                    $cr=$_POST[codigo];
                    $nombre=$_POST[nombre];
                    $des=$_POST[valor];
                }
            ?>
  			<table width="60%" class="inicio" align="center" >
    			<tr>
      				<td class="titulos" colspan="2">:: Agregar Perfil</td>
      				<td width='9%' class='cerrar'><a href='adm-principal.php'>Cerrar</a></td>
    			</tr>
    			<tr >
      				<td class='saludo1' style="width:2.5cm">:&middot; Nombre:</td>
      				<td><input type="text" name="nombre" id="nombre" style="width:50%" value="<?php echo $nombre ?>"/></td>
    			</tr>
    			<tr >
      				<td class="saludo1" style="width:2.5cm">:&middot; Descripcion: </td>
      				<td><input type="text" name="valor" id="valor" style="width:50%" value="<?php echo $des ?>"/></td>
    			</tr>
      		</table>
       		<input name="oculto" type="hidden" id="oculto" value="1">
       		<input type="hidden" name="codigo" id="codigo" value="<?php echo $cr ?>">
	  		<div class="subpantallap" style="height:64.5%; width:99.6%;overflow: hidden;">
  			<?php
            	//*****tabla de Privilegios *****
				echo " 
				<div class='subpantallap11'  style='float:left; width:30%; height:99%; overflow-x:hidden;'>
				<table class='inicio'  style='width:99%'>
 					<tr class='titulos'><td height='25' colspan='3'>:: Modulos del Perfil</td></tr>
					<tr>
						<td class='titulos2' width='10'><center>Item</center></td>
						<td class='titulos2' width='30'><center>Modulo</center></td>
						<td class='titulos2' width='10' height='25'><center> Sel </center></td></tr>";
				//********Sacar los privilegios****
				$_SESSION[idexacli]=array();
				$_SESSION[valexacli]=array();
				$sqlr="SELECT * FROM modulos ORDER BY nombre";
				$sqlr2="SELECT MR.ID_modulo, M.nombre, R.ID_ROL, MR.ID_ROL FROM ROLES R, modulo_rol MR, modulos M WHERE MR.ID_modulo=M.id_modulo "; 
     			$sqlr2=$sqlr2."and R.ID_ROL=MR.id_rol and MR.ID_ROL=$cr";
				$iter='fila1';
				$iter2='fila2';
				$resp = mysql_query($sqlr2,$linkbd);	
				$i=0;
				while ($row = mysql_fetch_row($resp)) 
 				{
 					$_SESSION[idexacli][$i]=$row[0];
 					$_SESSION[valexacli][$i]=$row[1];
 					$i+=1;
 				}
				$resp = mysql_query($sqlr,$linkbd);
				$i=1;
				while ($row =  mysql_fetch_row($resp)) 
				{
 					echo "<tr id='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
							<td>$i</td>
   							<td>$row[1]</td>";
					$i+=1;
  					if (!esta_en_array($_POST[tabla],$row[0]))
					{ 
					 echo "<td ><center><input type='checkbox' name=tabla[] value='$row[0]' onClick='actualistado()'></td></tr>";
					}
   					else //***** para cuando se registre las sesiones y las variables de sesion
   					{
  						$pos=pos_en_array($_POST[tabla],$row[0]);
  						$valor=$_POST[tabla][$pos];
  						echo "<td><center><input type='checkbox' name=tabla[] value='$row[0]' checked onClick='actualistado()' ></td></tr>";
   					}
  					$aux=$iter;
 					$iter=$iter2;
  					$iter2=$aux; 
 				}
				echo "
				</table></div>
				<div class='subpantallap11' style='float:left; width:69.5%;height:99%; overflow-x:hidden;'>";
				//*****tabla de Privilegios *****
				
				echo " 
				<table class='inicio' style='width:99%; '>
 					<tr class='titulos'><td height='25' colspan='5'>:: Privilegios del Perfil</td></tr>
					<tr>
						<td class='titulos2'>Item</td>
						<td class='titulos2'>Modulo</td>
						<td class='titulos2'>Menu</td>
						<td class='titulos2'>Nombre</td>
						<td class='titulos2'>Sel</td>
					</tr>";
				$i=1;
				$iter='saludo1a';
				$iter2='saludo2';
				foreach($_POST[tabla] as $modulo)
 				{
					$sqlr="SELECT distinct O.id_opcion,O.nom_opcion,O.ruta_opcion,O.niv_opcion, O.est_opcion,O.orden,O.modulo,M.nombre, N.nombre FROM opciones O,modulos M,niveles N WHERE M.id_modulo=O.modulo AND O.modulo=N.id_modulo AND N.id_nivel=O.niv_opcion AND O.especial<>'S' AND M.id_modulo=$modulo ORDER BY M.nombre, N.nombre";
					$resn = mysql_query($sqlr,$linkbd);
 					while ($rown =  mysql_fetch_row($resn)) 
  					{
	  					$chk="";
	 					if (esta_en_array($_POST[tablaop],$rown[0]))
  	  					$chk=" checked ";
   						echo "
						<tr class='$iter'>
							<td>$i</td>
							<td>$rown[7]</td>
							<td>$rown[8]</td>
							<td>$rown[1]</td>
							<td><input type='checkbox' name=tablaop[] value='$rown[0]' $chk></td>
						</tr>"; 
   						$i+=1;
    					$aux=$iter;
  						$iter=$iter2;
  						$iter2=$aux; 
  					}
				}
 				echo "</table> </div>";
				?>
				 </div>
                 <?php
				if($_POST['oculto']=='2')
				{
					/*$i=1;
					Foreach ($_POST[tabla] as $id)
					{
					$vd2=$id;
					$v[$i]=$vd2;
					$i+=1;
					}*/
					$sqlr="insert into roles (nom_rol,est_rol,desc_rol) values('$nombre','1','$des')";
					if(mysql_query($sqlr,$linkbd)){$ex="ok";}
					else {$ex="no";}
					$cod=mysql_insert_id();
					//echo "$sqlr.<br>";
					//$sqlr="update roles set nom_rol='$_POST[nombre]',desc_rol='$_POST[valor]' where id_rol=$_POST[codigo]";
					//$resp = mysql_query($sqlr,$linkbd);
					//$resp=oci_parse ($linkbd, $sqlr);
					//oci_execute ($resp);
					//sacar el consecutivo 
					//$sqlr="Delete from modulo_rol where id_rol=$_POST[codigo]";
					//echo $sqlr."<br>";
					//$resp=oci_parse ($linkbd, $sqlr);
					//oci_execute ($resp);
					//echo "$sqlr<br>";
					//$resp = mysql_query($sqlr,$linkbd);
					$i=0;
					foreach ($_POST[tabla] as $id)//For ($i=1;$i<=count($v);$i++)
					{
						$sqlr="Select MAX(id_modulo) from modulo_rol ";
						//$statement = oci_parse ($linkbd, $sqlr);
						//oci_execute ($statement);
						$statement = mysql_query($sqlr,$linkbd);
						$nr=0;
						//while ($row = oci_fetch_array ($statement, OCI_BOTH)) 
						while ($row =mysql_fetch_row($resp)) {$nr=$row[0]+1;}
						if ($nr==0){$nr=1;}
						//oci_free_statement($statement);
						$vd2=$id;
						$v[$i]=$vd2;
						$sqlr="insert into modulo_rol (id_rol,id_modulo,estado) values($cod,$v[$i],'1')";
						//$resp=oci_parse ($linkbd, $sqlr);
						//oci_execute ($resp);
						//echo $sqlr."<br>";
						$resp = mysql_query($sqlr,$linkbd);
						$i+=1;
					}
					foreach ($_POST[tablaop] as $idop)
					{
						$sqlr="insert into rol_priv (id_rol,id_opcion,est_rolpriv) values($cod,$idop,'1')";
						if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";}
					}
					echo"<script>despliegamodalm('visible','1','Se creo el Perfil con Exito');</script>";
					//oci_free_statement($resp);
					//oci_close($linkdb);
				}
			?>
		</form>
	</body>
</html>