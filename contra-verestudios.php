<?php //V 1000 12/12/16 ?> 
<?php 
	error_reporting(0);
	require"comun.inc";
	require"funciones.inc";
	require"conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script> 
			function ponprefijo(pref,opc,valor,valor2,cargo)
			{   
				parent.despliegamodalm2('hidden');
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
  		<form action="" method="post" enctype="multipart/form-data" name="form2">
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
			<?php
			$i=0;
			$sqlr="SELECT * FROM contrasolicanexos WHERE codsolicitud='$_GET[solicitud]' AND  tipo='previo' ";
			$res=mysql_query($sqlr,$linkbd);
			while($row = mysql_fetch_row($res)){
				$_POST[nomarchivosest][]="Adjunto No. $i";
				$_POST[rutarchivosest][]=$row[2];
				$_POST[descripest][]=$row[3];
				$i++;
			}
			//-----****
			$i=0;
			$sqlr="SELECT * FROM contrasolicanexos WHERE codsolicitud='$_GET[solicitud]' AND tipo='sector' ";
			$res=mysql_query($sqlr,$linkbd);
			while($row = mysql_fetch_row($res)){
				$_POST[nomarchivossec][]="Adjunto No. $i";
				$_POST[rutarchivossec][]=$row[2];
				$_POST[descripsec][]=$row[3];
				$i++;
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
			}
					
			?>
			<table  class="inicio" style="width:99.4%;">
                <tr>
                    <td class="titulos" >:: Estudios Previos</td>
                    <td class="cerrar" style="width:10%;"><a onClick="parent.despliegamodalm2('hidden');" href="#" >&nbsp;Cerrar</a></td>
                </tr>                      
    		</table> 
    		<input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="tobjeto" id="tobjeto" value="<?php echo $_POST[tobjeto]?>"/>
            <input type="hidden" name="tnobjeto" id="tnobjeto" value="<?php echo $_POST[tnobjeto]?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			
			<?php
			 echo"
				<div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
						<table class='inicio' width='99%'>
							<tr>
								<td class='titulos' colspan='4'>Detalle Estudios Previos</td>
							</tr>
							<tr>
								<td class='titulos2'>Nombre</td>
								<td class='titulos2'>Ruta</td>
								<td class='titulos2'>".utf8_decode("Descripcion")."</td>
								<td class='titulos2'></td>
							</tr>";
		 
				$itern='saludo1a';
				$iter2n='saludo2';
				for ($x=0;$x<count($_POST[nomarchivosest]);$x++)
				{
					$rutaarchivo="informacion/proyectos/temp/".$_POST[patharchivosest][$x];
					echo "
					<input type='hidden' name='nomarchivosest[]' value='".$_POST[nomarchivosest][$x]."'/>
					<input type='hidden' name='rutarchivosest[]' value='".$_POST[rutarchivosest][$x]."'/>
					<input type='hidden' name='descripest[]' value='".$_POST[descripest][$x]."'/>
					<input type='hidden' name='patharchivosest[]' value='".$_POST[patharchivosest][$x]."'/>
						<tr class='$itern'>
							<td>".$_POST[nomarchivosest][$x]."</td>
							<td>".$_POST[rutarchivosest][$x]."</td>
							<td>".$_POST[descripest][$x]." </td>
							<td style='text-align:center;width: 30px'><a href='$rutaarchivo' target='_blank' ><img src='imagenes/descargar.png'  title='(Descargar)' ></a></td>
						</tr>";
					$auxn=$itern;
					$itern=$itern2;
					$itern2=$auxn;
				}
				echo "
					</table></div>";
                  ?>
					

			<table  class="inicio" style="width:99.4%;">
                <tr>
                    <td class="titulos" >:: Analisis del Sector</td>
                </tr>                      
    		</table> 
			<?php
                        	 echo"
                                <div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='4'>Detalle Estudios Previos</td>
                                            </tr>
                                            <tr>
                                                <td class='titulos2'>Nombre</td>
                                                <td class='titulos2'>Ruta</td>
                                                <td class='titulos2'>".utf8_decode("Descripcion")."</td>
                                                <td class='titulos2'></td>
                     
                                            </tr>";	 
                                $itern='saludo1a';
                                $iter2n='saludo2';
                                for ($x=0;$x<count($_POST[nomarchivossec]);$x++)
                                {
                                	$rutaarchivo="informacion/proyectos/temp/".$_POST[patharchivossec][$x];
                                    echo "
                                    <input type='hidden' name='nomarchivossec[]' value='".$_POST[nomarchivossec][$x]."'/>
                                    <input type='hidden' name='rutarchivossec[]' value='".$_POST[rutarchivossec][$x]."'/>
                                    <input type='hidden' name='descripsec[]' value='".$_POST[descripsec][$x]."'/>
                                    <input type='hidden' name='patharchivossec[]' value='".$_POST[patharchivossec][$x]."'/>
                                        <tr class='$itern'>
                                            <td>".$_POST[nomarchivossec][$x]."</td>
                                            <td>".$_POST[rutarchivossec][$x]."</td>
                                            <td>".$_POST[descripsec][$x]." </td>
                                            <td style='text-align:center;width: 30px'><a href='$rutaarchivo' target='_blank' ><img src='imagenes/descargar.png'  title='(Descargar)' ></a></td>

                                        </tr>";
                                    $auxn=$itern;
                                    $itern=$itern2;
                                    $itern2=$auxn;
                                }
                                echo "
                                    </table></div>";
                         ?>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>
