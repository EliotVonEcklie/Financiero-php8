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
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a></td>
         	</tr>	
		</table>
 		<form name="form2" method="post" action="">  
 			<input type="hidden" name="anio" id="anio" value="<?php echo $_POST[anio] ?>">
 			<input type="hidden" name="bloqueo" id="bloqueo" value="<?php echo $_POST[bloqueo] ?>">
 			<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto] ?>">
            <div class="subpantallac5" style="height:69%; width:99.6%; margin-top:0px; overflow-x:hidden" id="divdet">
                <?php

                	if($_POST[oculto]==2){
						//echo "bloqueo ".$_POST[bloqueo]." " ;
						if($_POST[bloqueo]=='S'){
							$sqlr="update admbloqueoanio set bloqueado='N' where anio=".$_POST[anio].";";
							mysql_query($sqlr,$linkbd);
							//echo $sqlr;
						}
						if($_POST[bloqueo]=='N'){
							$sqlr="update admbloqueoanio set bloqueado='S' where anio=".$_POST[anio].";";
							mysql_query($sqlr,$linkbd);
							//echo $sqlr;
						}
					}
                    //$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
                    $sqlr="select count(anio) from admbloqueoanio";
					$r=mysql_query($sqlr,$linkbd);
                    $row =mysql_fetch_row($r);
                    $ntr=$row[0];

                        echo utf8_decode ("
                            <table class='inicio' align='center'>
                                <tr>
                                    <td colspan='5' class='titulos'>.: Resultados Busqueda:</td>
                                </tr>
                                <tr>
                                    <td colspan='8'>Años Encontrados: $ntr</td>
                                </tr>
                                <tr>
                                    <td class='titulos2' style='width:90%;'>Año</td>
                                    <td class='titulos2' style='width:10%;'>Estado</td>
                                </tr>");	
                        $iter='saludo1a';
                        $iter2='saludo2';
						$filas=1;

						$sqlr="select * from admbloqueoanio ORDER BY anio DESC";
						$resp=mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($resp)) 
                        {
                            if($row[1]=="N")
                            {
                                $imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";
	  							$coloracti="#0F0";
	  							$_POST[lswitch1]=1;
                            }
                            else
                            {
                                $imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";
								$coloracti="#C00";
								$_POST[lswitch1]=0;
                            }
							echo"<tr class='$iter' >
	                                <td>$row[0]</td>
	                                <td style='text-align:center;'>
	                                	<input type='range' name='lswitch1[]' value='".$_POST[lswitch1]."' min ='0' max='1' step ='1' style='background:$coloracti; width:70%' onChange='cambioswitch(\"".$row[0]."\",\"".$row[1]."\",\"".$_POST[lswitch1]."\")' />
	                                </td>
								</tr>
							";
									
                            $con+=1;
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
							$filas++;
                        } 

                ?>
            </div>
        </form> 
</body>
</html>