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
        <title>:: Spid - Planeacion Estrategica</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('codigo').value
				var validacion02=document.getElementById('nombre').value
				if (validacion01.trim()!='' && validacion02.trim()!=''){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.nombre.focus();
					document.form2.nombre.select();
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
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "plan-nivelespd.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";document.form2.submit();break;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("plan");?></tr>
            <tr>
  				<td colspan="3" class="cinta">
					<a href="plan-nivelespd.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
					<a href="#"  onClick="guardar()"class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="plan-buscanivelespd.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a>
					<a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
				</td>
      		</tr>
   		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post"> 
 		<?php
			$sqlv="select * from dominios where nombre_dominio='VIGENCIA_PD' AND tipo='S'";
			$resv = mysql_query($sqlv,$linkbd);
			$wvig=mysql_fetch_array($resv);
			$_POST[vigenciai]=$wvig[0];
			$_POST[vigenciaf]=$wvig[1];

 			if($_POST[oculto]=="")
			{
				$mxa=selconsecutivo('plannivelespd','codigo');
				$_POST[codigo]=$mxa;
				$sqlv="select * from dominios where nombre_dominio='VIGENCIA_PD' AND tipo='S'";
				$resv = mysql_query($sqlv,$linkbd);
				if(mysql_num_rows($resv)!=0){
					$wvig=mysql_fetch_array($resv);
					$sqln="select orden from plannivelespd where inicial='$wvig[0]' and final='$wvig[1]' ORDER BY orden DESC";
					$resn = mysql_query($sqln,$linkbd);
					if(mysql_num_rows($resn)!=0){
						$wniv=mysql_fetch_array($resn);
						$_POST[nivel]=$wniv[0]+1;
					}
					else
						$_POST[nivel]=1;
				}
				else{
					$_POST[nivel]=1;
				}
			}
 		?>
            <table class="inicio" >
                <tr>
                    <td class="titulos" colspan="8" style='width:93%'>Crear Nivel PD</td>
                    <td class="cerrar" style='width:7%'><a href="plan-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style='width:5%'>Codigo:</td>
                    <td style='width:5%'>
						<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style='width:80%; text-align:center;' readonly="readonly">
					</td>
                    <td class="saludo1" style='width:5%'>Nivel:</td>
                    <td style='width:5%'>
						<input type="text" name="nivel" id="nivel" value="<?php echo $_POST[nivel]?>" style='width:80%; text-align:center;' readonly="readonly">
					</td>
                    <td class="saludo1" style='width:10%'>Nombre:</td>
                    <td style='width:43%'>
						<input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style='width:90%'>
					</td>
                    <td class="saludo1" style='width:10%'>Vigencia:</td>
                    <td style='width:10%'> 
						<input type="text" name="vigenciai" id="vigenciai" value="<?php echo $_POST[vigenciai]?>" style='width:40%' readonly> - 
						<input type="text" name="vigenciaf" id="vigenciaf" value="<?php echo $_POST[vigenciaf]?>" style='width:40%' readonly> 
                    </td>
                </tr>
            </table>
			<input type="hidden" name="oculto" value="1">
			<?php  
				if($_POST[oculto]=="2")//********guardar
				{
					$sqlv="select * from dominios where nombre_dominio='VIGENCIA_PD' AND tipo='S'";
					$resv = mysql_query($sqlv,$linkbd);
					if(mysql_num_rows($resv)!=0){
						$wvig=mysql_fetch_array($resv);

						$mxa=selconsecutivo('plannivelespd','codigo');
						$sqln="select orden from plannivelespd where inicial='$wvig[0]' and final='$wvig[1]' ORDER BY orden DESC";
						$resn = mysql_query($sqln,$linkbd);
						if(mysql_num_rows($resn)!=0){
							$wniv=mysql_fetch_array($resn);
							$nivel=$wniv[0]+1;
						}
						else
							$nivel=1;
						
						if($nivel>2){
							$signiv=$nivel-2;
							for($i=($nivel-1);$i>=$signiv;$i--){
								$orden=$i+1;
								$sql="UPDATE plannivelespd SET orden='$orden' where orden='$i' and inicial='$wvig[0]' and final='$wvig[1]'";
								$res=mysql_query($sql,$linkbd);
							}
						}
						else
							$signiv=$nivel;
						
								
						$sqlr="insert into plannivelespd (codigo, nombre, orden, estado, inicial, final) values ('$mxa','$_POST[nombre]',$signiv,'S','$wvig[0]','$wvig[1]') ";	
						if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','ERROR EN LA CREACION DEL NIVEL PD');</script>";}
						else {
							if($nivel==1){
								$sqlr="insert into plannivelespd (codigo, nombre, orden, estado, inicial, final) values ('2','METAS','2','S','$wvig[0]','$wvig[1]') ";	
								mysql_query($sqlr,$linkbd);
								$sqlr="insert into plannivelespd (codigo, nombre, orden, estado, inicial, final) values ('3','INDICADORES','3','S','$wvig[0]','$wvig[1]') ";	
								mysql_query($sqlr,$linkbd);
							}
							echo"<script>despliegamodalm('visible','1','Se ha almacenado el Nivel PD con Exito');</script>";
						}
					}
					else{
						echo"<script>despliegamodalm('visible','2','NO EXISTE UNA VIGENCIA PREDETERMINADA PARA CREAR LOS NIVELES PD');</script>";
					}
					
				}
			?>
		</form>       
	</body>
</html>