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
	 	<meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function pdf()
			{
				document.form2.action="pdfbalance.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}

			function protocolofmt()
			{
				document.form2.action="formatos/FMT_PLAN_DE_CUENTAS_CHIP.csv";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
            function protocoloimport()
            {
                document.form2.action="conceptos-contables-import.php";
                document.form2.target="_BLANK";
                document.form2.submit(); 
                document.form2.action="";
                document.form2.target="";
            }
			function validar()
			{
				document.form2.oculto.value=2;
				document.form2.submit(); 
			}
			
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("presu");?></tr>
			<tr>
				<td colspan="3" class="cinta">
					<a href="presu-importar-conceptos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a class="mgbt" onClick="document.form2.submit()"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" style="width:29px;height:25px;" title="Imprimir"></a>
					<a href="#" target="_blank" class="mgbt"><img src="imagenes/csv.png" style="width:29px;height:25px;"   title="csv"></a>
				</td>
			</tr>
		</table>
		<form action="presu-importar-conceptos.php" method="post" enctype="multipart/form-data" name="form2">
			<table  align="center" class="inicio" >
				<tr >
					<td class="titulos" colspan="7">.: Importar Conceptos contables</td>
					<td width="7%" class="cerrar"><a href="presu-principal.php">X Cerrar</a></td>
				</tr>   
				<tr> 
					<td width="10%" class="saludo1">Vigencia: </td>
					<td width="10%">
						<select name="vigencia" onchange="document.form2.submit()" >
							<option value="">Sel...</option>
							<?php
							for($i=date('Y');$i>=(date('Y')-3);$i--){
								if($_POST[vigencia]==$i)
									$selected='selected="selected"';
								else
									$selected='';
								echo'<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
							}
							?>
						</select>
					</td>
					<td width="15%"  class="saludo1">Seleccione Archivo: </td>
					<td width="15%" >
						<input type="file" name="archivotexto" id="archivotexto">
					</td>
					<td colspan="7" >
						<input type="button" name="generar" value="Cargar Archivo" onClick="validar()">
						<input name="oculto" type="hidden" value="1">  
                        <input type="button" name="protocolo" value="Descargar Formato de Importacion" onClick="protocoloimport()">
					</td>
				</tr>                  
				<tr> 
					
				</tr>                  
			</table>
			<div class="subpantalla" style="height:60.5%; width:99.6%; overflow-x:hidden;">
				<?php
				//**** para sacar la consulta del balance se necesitan estos datos ********
				//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
				if((isset($_POST['vigencia']))&&(isset($_POST['trimestre']))){
					echo "<table class='inicio'>";
						echo "<tr>
							<td class='titulos'>CODIGO</td>
							<td class='titulos'>NOMBRE CUENTA</td>
							<td class='titulos'>SALDO FINAL</td>
						</tr>";
					if($_POST[oculto]==2)
					{
						if(is_uploaded_file($_FILES['archivotexto']['tmp_name']))
						{
							$archivo = $_FILES['archivotexto']['name'];
							$archivoF = "$archivo";
							if(move_uploaded_file($_FILES['archivotexto']['tmp_name'],$archivoF))
							{
								//echo "El archivo se subio correctamente ";
								$subio=1;
							}
						}
						//echo $archivo;
							require_once 'PHPExcel/Classes/PHPExcel.php';
							$inputFileType = PHPExcel_IOFactory::identify($archivo);
							$objReader = PHPExcel_IOFactory::createReader($inputFileType);
							$objPHPExcel = $objReader->load($archivo);
							$sheet = $objPHPExcel->getSheet(0); 
							$highestRow = $sheet->getHighestRow(); 
                            $highestColumn = $sheet->getHighestColumn();
                            $cod=1;
                            $co='saludo1';
							$co2='saludo2';
                            $sqlr="DELETE FROM cuentasaldos WHERE vigencia='".$_POST[vigencia]."' AND trimestre='".$_POST[trimestre]."'";
							mysql_query($sqlr,$linkbd);
							for ($row = 2; $row <= $highestRow; $row++){ 
                                    if($cod=='1')
                                        $codigo=$sheet->getCell("A".$row)->getValue();
                                    if($codigo=='CODIGO')
                                    {
                                        $row=$row+1;
                                        echo "<tr class='$co'>";
                                        $val1=$sheet->getCell("A".$row)->getValue();
                                        $val1 = str_replace(".", "",$val1);
                                        $val2 = utf8_decode($sheet->getCell("B".$row)->getValue());
                                        $val3 = $sheet->getCell("F".$row)->getValue();
                                        $val3 = str_replace(",", ".",$val3);
                                        echo "
                                            <td>".$val1."</td>
                                            <td>".$val2."</td>
                                            <td>".$val3."</td>
                                            </tr>
                                        ";
                                        $maxid=selconsecutivo('cuentasaldos','id');
                                        $sqlr="INSERT INTO cuentasaldos (cuenta, nommbre, saldofinal, vigencia, trimestre, id) VALUES ('".$val1."','".$val2."','".$val3."','".$_POST[vigencia]."','".$_POST[trimestre]."','".$maxid."')";
                                        if(!mysql_query($sqlr,$linkbd)){
                                            echo'<tr>
                                                <td>'.mysql_error().'</td>
                                            </tr>';
                                        }
                                        
                                        $aux=$co;
                                        $co=$co2;
                                        $co2=$aux;
                                        $row=$row-1;
                                        $cod=0;
                                    }
									
							}
					}
					else{
						$sql="select * from cuentasaldos where vigencia='".$_POST[vigencia]."' and trimestre='".$_POST[trimestre]."' order by cuenta";
						$res=mysql_query($sql, $linkbd);
						while($row=mysql_fetch_array($res)){
							echo'<tr>
								<td>'.$row[0].'</td>
								<td>'.utf8_encode($row[1]).'</td>
								<td align="right">'.number_format($row[2],2,',','.').'</td>
							</tr>';
						}
					}
				echo "</table>"; 
				}
				else{
				echo "<table class='inicio'>";
					echo "<tr>
						<td class='titulos'>SELECCIONES LA VIGENCIA Y EL TRIMESTRE</td>
					</tr>
				<table>";
				}
				?> 
			</div>
		</form>
	</body>
</html>