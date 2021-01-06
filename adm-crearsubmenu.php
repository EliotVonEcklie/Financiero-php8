<?php //V 1000 12/12/16 ?> 
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
        <title>:: SPID - Administracion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script>
		//************* ver reporte ************
		//***************************************
		function guardar(idfac)
		{
		if (  document.form2.nombremenu.value!='' && document.form2.ruta.value!='' &&document.form2.modulos.value!='' && document.form2.nivel.value!='' && document.form2.orden.value!='' )
		  {
			if (confirm("Esta Seguro de Guardar"))
			{
			document.form2.oculto.value=2;
			document.form2.submit();
			}
		  }
		  else
		  {
			alert("Faltan campos por llenar");  
		  }
		}
		//************* genera reporte ************
		//***************************************
		function genrep(idfac)
		{
		  document.form2.oculto.value=idfac;
		  document.form2.submit();
		  }
		  function validar(){document.form2.submit();}
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
  				<td colspan="3" class="cinta"><a href="adm-crearsubmenu.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a class="mgbt" href="adm-listasubmenus.php"><img src="imagenes/busca.png"/></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
         	</tr>
  		</table>
		<?php
			// if(!$_POST[oculto])
			// {
 				
				// $sqlr="select id_modulo,nombre from modulos";
 				// $res=mysql_query($sqlr,$linkbd);
 				// while($r=mysql_fetch_row($res)){$_POST[nombremenu]=$r[1];}
			// }
		?>
 		<form name="form2" method="post" action="">
  			<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="8">Crear sub-Menu </td>
                    <td style='width:7%' class="cerrar" ><a href="adm-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                    <td style="width:7%" class="saludo1" >Nombre Sub-Menu :</td>
                    <td style="width:10%" >
						<input name="nombremenu" type="text" id="nombremenu" style="width:100%" value="<?php echo $_POST[nombremenu]?>">
						<input name="oculto" type="hidden" id="oculto" value="1"> </td>
						<td style="width:7%" class="saludo1" >Ruta :</td>
                    <td style="width:10%" colspan="3">
						<input name="ruta" type="text" id="ruta" style="width:100%" value="<?php echo $_POST[ruta]?>">
				    </td>
				</tr>
				<tr>
      				<td style="width:7%" class="saludo1" >Modulo:</td>
      				<td style="width:10%" >
                    	<select name="modulos" id="modulos"   style="width:100%;" onChange="validar()" >
      						<option value="" >Seleccione...</option>
      						<?php
								$sqlr="select id_modulo,nombre from modulos";
								$res=mysql_query($sqlr,$linkbd);
								while($row=mysql_fetch_row($res)){
										
									if($row[0]==$_POST[modulos]){echo "<option value=$row[0] SELECTED>$row[1]</option>";}
					 				else {echo "<option value=$row[0]>$row[1]</option>";}  
								}
      							
      						?>
      					</select> 
                	</td>
					<td style="width:7%" class="saludo1" >Nivel:</td>
      				<td style="width:10%" >
                    	<select name="nivel" id="nivel"  style="width:100%;">
      						<option value="">Seleccione...</option>
      						<?php
								$sqlr="select * from niveles where id_modulo='$_POST[modulos]' order by id_nivel";
								$res=mysql_query($sqlr,$linkbd);
								while($row=mysql_fetch_row($res)){
									if($row[0]==$_POST[nivel]){echo "<option value=$row[0] SELECTED>$row[2]</option>";}
					 				else {echo "<option value=$row[0]>$row[2]</option>";} 
								}
      							
      						?>
      					</select> 
                	</td>
					<td style="width:7%" class="saludo1" >Orden:</td>
					<td style="width:7%">
						<input name="orden" type="text" id="orden" style="width:100%" value="<?php echo $_POST[orden]?>">
					</td>
					<td style="width:7%" class="saludo1" >Comando:</td>
					<td style="width:7%">
						<input name="comando" type="text" id="comando" style="width:100%" value="<?php echo $_POST[comando]?>">
					</td>
					
				</tr>
    		
  			</table>
		</form>    
		<?php
			
			if($_POST[oculto]==2)
			{
				
				$sqlr="insert into opciones(nom_opcion,ruta_opcion,niv_opcion,est_opcion,orden,modulo,especial,comando) values('$_POST[nombremenu]','$_POST[ruta]','$_POST[nivel]',1,'$_POST[orden]','$_POST[modulos]','','$_POST[comando]')";
				mysql_query($sqlr,$linkbd);
				$sqlr="select max(id_opcion) from opciones";
				$resp=mysql_query($sqlr1,$linkbd);
				$row=mysql_fetch_row($resp);
				$sqlr="insert into rol_priv(id_rol,id_opcion,est_rolpriv) values(1,'$row[0]',1) ";				
				if(!mysql_query($sqlr,$linkbd))
  				{
	  				echo "<table class='inicio'><tr><td class='saludo1'><img src='imagenes\alert.png'> Error no se pudo actualizar $sqlr</td></tr></table>";	
  				}
  				else
  				{
	  				echo "<table class='inicio'><tr><td class='saludo1'>Se ha agregado el Sub-menu:$_POST[nombremenu]  <img src='imagenes\confirm.png'></td></tr></table>";	
  				}
			}
		?>
	</body>
</html>