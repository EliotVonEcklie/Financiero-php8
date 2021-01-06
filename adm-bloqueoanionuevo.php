<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$_POST[oculto2]=$_GET[oculto2];
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid - Administracion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			
			function cambioswitch(id,bloqueo,valor)
			{
				//alert("cambio "+id+" "+bloqueo+" "+valor);
				if(valor=='0')
				{
					if (confirm("¿Desea Desbloquear el año?"))
					{
						document.form2.anio.value=id;
						document.form2.bloqueo.value=bloqueo;
						document.form2.oculto.value=2;
					}
					else
					{
						//document.form2.nocambioestado.value="1"
					}
				}
				else
				{
					if (confirm("¿Desea Bloquear el año?"))
					{
						document.form2.anio.value=id;
						document.form2.bloqueo.value=bloqueo;
						document.form2.oculto.value=2;
					}
					else
					{
						//document.form2.nocambioestado.value="0";
					}
				}
				
				document.form2.submit();
			}

			function guardar(){
			document.form2.oculto.value='2';
			document.form2.submit();	
			}
			function refrescar(){
			var seleccion=document.getElementById('anio').value;
			document.form2.seleccion.value=seleccion;
			document.form2.submit();
			}
		</script>
        <script src="css/calendario.js"></script>
        <script>
			function crearexcel(){
				alert("¡En Construccion!");
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
  				<td colspan="3" class="cinta">
				<a href="adm-bloqueoanionuevo.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guarda.png"/></a>
				<a  href="adm-bloqueoanio.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a></td>

         	</tr>	
		</table>
 		<form name="form2" method="post" action="adm-bloqueoanionuevo.php">  
            <div class="subpantallac5" style="height:69%; width:99.6%; margin-top:0px; overflow-x:hidden" id="divdet">
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]; ?>" >
                <?php
                    	$sqlr="select anio from admbloqueoanio ORDER BY anio DESC LIMIT 0,1";
						$resp=mysql_query($sqlr,$linkbd);
						$arreglo=mysql_fetch_array($resp);
                        echo utf8_decode ("
                            <table class='inicio' align='center'>
                                <tr>
                                    <td colspan='5' class='titulos'>.: Agregar año de bloqueo:</td>
                                </tr>
                                
                                 ");	
                        echo utf8_decode("<tr><td class='tamano01' style='width:4cm;''>:&middot; Año: </td>
      				<td colspan='2'>");

                        echo "<select style='width: 15%;height: 0.8cm' onchange='refrescar()' id='anio' name='anio'>";
      						for ($i=($arreglo[0]+1);$i<2030; $i++){
      							if($_POST[seleccion]==$i){
      								echo "<option value='$i' SELECTED>$i</option>";
      							}else{
      								echo "<option value='$i'>$i</option>";
      							}
      							
      						}
      					echo "</select>";
      					echo "<input type='hidden' name='seleccion' id='seleccion' value='$_POST[seleccion]' />";
      					echo "<input type='button' onClick='guardar()' value='Agregar' style='height: 0.8cm'/>";
      			echo "</td></tr>";
                 		if($_POST[oculto]=='2'){
                 			if(!empty($_POST[anio])){
                 				$sql="INSERT INTO admbloqueoanio(anio,bloqueado) VALUES ('$_POST[anio]','S')";
                 				$result=mysql_query($sql,$linkbd);
                 				if($result){
                 					echo "<script> alert('Periodo de bloqueo añadido'); </script>";
                 				}else{
                 					echo "<script> alert('El periodo ya existe en la base'); </script>";
                 				}
                 				$page=$_SERVER['PHP_SELF'];
                 				echo "<meta http-equiv='refresh' content='1;URL=$page'>";
                 			}
                 			
                 		}
                ?>
            </div>
        </form> 
</body>
</html>