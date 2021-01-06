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
		<title>:: Spid - Administracion</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
        //************* ver reporte ************
        //***************************************
        function verep(idfac)
        {
          document.form1.oculto.value=idfac;
          document.form1.submit();
          }
        //************* genera reporte ************
        //***************************************
        function genrep(idfac)
        {
          document.form2.oculto.value=idfac;
          document.form2.submit();
          }
        function checktodos()
        {
         cali=document.getElementsByName('bloqueados[]');
         for (var i=0;i < cali.length;i++) 
         { 
            if (document.getElementById("todos").checked == true) 
            {
             cali.item(i).checked = true;
             document.getElementById("todos").value=1;	 
            }
            else
            {
            cali.item(i).checked = false;
            document.getElementById("todos").value=0;
            }
         }	
        }
        
        //************* ver reporte ************
        //***************************************
        function guardar()
        {
            if (confirm("Esta Seguro de Guardar"))
            {
              document.form2.oculto.value=2;
              document.form2.submit();
            }
        }
        </script>
		</script> 
		<?php titlepag();?>
		<style>
		.fc_main{
			top:200 !important;
		}
		</style>
		<?php titlepag();?>
    </head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
            <tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("adm");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="adm-bloqueos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
         	</tr>
  		</table>
 		<form name="form2" method="post" action="">
 		<?php
			if (!$_POST[oculto])
			{
				$sqlr="select valor_inicial,valor_final from dominios where dominios.nombre_dominio='FECHA_LIMITE_MODIFICA_DOC'";
				$resp = mysql_query($sqlr,$linkbd);
				$fila =mysql_fetch_row($resp);
				ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fila[0],$fecha);
				$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
				$_POST[fecha]=$fechaf;
				$_POST[ages]=$fila[1];
				$chekt="  ";
				
			}
			$sqlr="select *from parametros where estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			while($r=mysql_fetch_row($res)){$_POST[vigenciaact]=$r[1];}
 		?>
  			<table  class="inicio" align="center">
    			<tr>
      				<td class="titulos" colspan="4">:: Bloqueos </td>
                    <td style='width:7%' class="cerrar" ><a href="adm-principal.php">Cerrar</a></td>
    			</tr>
    			<tr>
      				<td class="saludo3">:&middot; Fecha General:</td>
      				<td>
                    	<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   
                        <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle"></a>     
                        <input name="oculto" type="hidden" id="oculto" value="1"> 
                 	</td>
                    <td  class="saludo3" >Vigencia Trabajo Gral:</td>
     				<td>
                    	<select name="ages">
      						<option value="">Seleccione...</option>
      						<?php
      							for($x=($_POST[vigenciaact]-20);$x<=($_POST[vigenciaact]+5);$x++)
							   	{
								 	echo "<option value='$x' ";
								  	if($_POST[ages]==$x) 
								  	echo " SELECTED";
								 	echo " >$x</option>";	  
							   	}
      						?>
      					</select>
                 	</td>
    			</tr>
  			</table>
  			<?php
				$oculto=$_POST['oculto'];
				if($_POST[oculto]=='2')
 				{
	  				echo "<div class=''>";
				  	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fechas);
				  	$fechan=$fechas[3]."-".$fechas[2]."-".$fechas[1];
				  	$sqlr="update  dominios set dominios.valor_inicial='$fechan', dominios.valor_final='$_POST[ages]'  where dominios.NOMBRE_DOMINIO='FECHA_LIMITE_MODIFICA_DOC'";
	   				if(!mysql_query($sqlr,$linkbd))
	   					echo "<table class='inicio'><tr><td class='saludo1'><center>No se ha Actualizado la Fecha de Bloqueo General ".$_POST[fecha]." Error: ".mysql_error($linkbd)." <img src='imagenes/alert.png'></center></td></tr></table>";
	   				else
	  					 //echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado la Fecha de Bloqueo General ".$_POST[fecha]." - $_POST[ages]<img src='imagenes/confirm.png'></center></td></tr></table>";
	 				$tam=count($_POST[id]);	 
	 				for ($x=0;$x<$tam;$x++)
	  				{
		 				if(!esta_en_array($_POST[bloqueados],$_POST[id][$x]))	  
		  				{
			  				$fechad=$_POST[fechau][$x];
			  				$vigusu=$_POST[vigt][$x];
		  				}
		 				else
					  	{
					 		$fechad=$_POST[fecha];
					  		$vigusu=$_POST[ages];
					  	}
		  				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fechad,$fechas);
					   	$fechad=$fechas[3]."-".$fechas[2]."-".$fechas[1];
					   	$sqlr="update  dominios set dominios.valor_final='$fechad', dominios.tipo='$vigusu'  where dominios.NOMBRE_DOMINIO='PERMISO_MODIFICA_DOC' and dominios.valor_inicial='".$_POST[id][$x]."'";
	  					if(!mysql_query($sqlr,$linkbd))
	    				{
							echo "<table class='inicio'><tr><td class='saludo1'><center>No se ha Actualizado la Fecha de Bloqueo del Usuario "." ".$_POST[id][$x]." ".$_POST[nombres][$x]." Error: ".mysql_error($linkbd)." <img src='imagenes/alert.png'></center></td></tr></table>";
						}
	   					else
	    				{
		 					//echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado la Fecha de Bloqueo del Usuario ".$_POST[nombres][$x]." <img src='imagenes/confirm.png'></center></td></tr></table>";	
						}
	  				}
	  				echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado la Fecha de Bloqueo del Usuario ".$_POST[nombres][$x]." <img src='imagenes/confirm.png'></center></td></tr></table>";	
	  				echo "</div>";
 				}
			?>
            <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
			<table  class="inicio" align="center">
				<tr><td class="titulos" colspan="8">:: Usuarios </td></tr>
				<tr>
                	<td class="titulos2">Id</td>
                    <td class="titulos2">Nombre</td>
                    <td class="titulos2">Documento</td>
                    <td class="titulos2">Usuario</td>
                    <td class="titulos2">Perfil</td>
                    <td class="titulos2">Fecha Bloqueo</td>
					<td class="titulos2">Vigencia Trabajo Ppto</td>
					<td class="titulos2"><center>Bloqueo Gral<input id="todos" type="checkbox" name="todos" value="1" onClick="checktodos()" <?php echo $chekt;  ?>></center></td>
            	</tr>
				<?php
					$sqlr="Select dominios.valor_inicial, dominios.descripcion_valor, dominios.valor_final,usuarios.usu_usu, roles.nom_rol,dominios.tipo from usuarios,dominios, roles where dominios.NOMBRE_DOMINIO='PERMISO_MODIFICA_DOC' and dominios.valor_inicial=usuarios.cc_usu and usuarios.id_rol=roles.id_rol";
					$resp = mysql_query($sqlr,$linkbd);
					$i=1;
					$idf=1198971546;
					$co="saludo1";
					$co2="saludo2";
					while($r =mysql_fetch_row($resp))
 					{
 						$idf+=1;
 						ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $r[2],$fecha);
 						$fechab=$fecha[3]."/".$fecha[2]."/".$fecha[1];
 						$chk=" ";
 						$vig=$r[5];
  						if(esta_en_array($_POST[bloqueados],$r[0]) || !$_POST[oculto])	  
		  				$chk="  ";
 						echo "<tr class='$co'>
						<td><input type='hidden' name='id[]' value='$r[0]'>$i</td>
						<td><input type='hidden' name='nombres[]' value='$r[1]'>$r[1]</td>
						<td>$r[0]</td>
						<td>$r[3]</td>
						<td>$r[4]</td>
						<td><input name='fechau[]' type='text' value='$fechab' maxlength='10' size='10' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)'  id='fc_".$idf."' onKeyDown='mascara(this,//,patron,true)' title='DD/MM/YYYY'>";
 				?>
 						<a href="#" onClick="displayCalendarFor('fc_'+<?php echo $idf ?>+'');"><img src='imagenes/buscarep.png' align='absmiddle' border='0'></a>
 				<?php 
						echo "</td>";
						echo "<td  ><select name='vigt[]' >";
						echo "<option value=''>Seleccione...</option>";
						for($x=($_POST[vigenciaact]-20);$x<=($_POST[vigenciaact]+5);$x++)
						{
							echo "<option value='$x' ";
							if($vig==$x) 
							echo "SELECTED";	  
							echo " >$x</option>";
						}
						echo " </td>";
						echo "<td><center><input type='checkbox' name='bloqueados[]' value='$r[0]' ".$chk."></center></td></tr>";
  	 					$i+=1;
 	 					$aux=$co;
	 					$co=$co2;
	 					$co2=$aux;
 					}
				?>
			</table>
            </div>
		</form>      
	</body>
</html>