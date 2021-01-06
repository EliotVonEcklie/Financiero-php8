<?php //V 1001 20/12/16 Modificado implementacion de Reversion?>
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
		<title>:: SPID - Presupuesto</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
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
	function funcionmensaje()
	{
	}
	function respuestaconsulta(pregunta)
	{
		switch(pregunta)
		{
			case "1":	
				// alert("case 1");
				document.form2.oculto.value='2';
				document.form2.submit();
			break;
		}
	}
function pdf()
{
document.form2.action="pdfbalance.php";
document.form2.target="_BLANK";
document.form2.submit();
document.form2.action="";
document.form2.target="";
} 
function protocoloimport()
{
	document.form2.action="presu-cuentas-import.php";
	document.form2.target="_BLANK";
	document.form2.submit();
	document.form2.action="";
	document.form2.target="";
}
function cargar(){
	document.form2.import.value=1;
	document.form2.submit();
}
function guardar()
{
	if (document.form2.vigencia.value!='')
	{
		despliegamodalm('visible','4','Esta Seguro de Guardar','1');
	}
	else
	{
		despliegamodalm('visible','2','Faltan datos para completar el registro');
		document.form2.vigencia.focus();
		document.form2.vigencia.select();
	}
}

function cambioentidad(element){
	var valor=element.value;
	document.form2.entidades.value=valor;
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
					<a href="presu-importacuentas.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png"/></a>
					<a class="mgbt"><img src="imagenes/buscad.png"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" class="mgbt" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
     		</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form action="presu-importacuentas.php" method="post" enctype="multipart/form-data" name="form2">
			<table  align="center" class="inicio" >
				<tr >
					<td class="titulos" colspan="8">.: Importar Plan de Cuentas Presupuestales</td><td width="70" class="cerrar"><a href="presu-principal.php"> Cerrar</a></td>
				</tr>
				<tr>
				   <td style="width:10%;"  class="saludo1">Entidad: </td>
					<td style="width:10%;" >
						<select name="entidades" id="entidades" style="width: 100%" onchange="cambioentidad(this)">
							<option value="1" <?php if($_POST[entidades]=="1"){echo "selected"; }?> >Interna</option>
							<option value="2" <?php if($_POST[entidades]=="2"){echo "selected"; }?> >Externa</option>
						</select>
					</td>
					<td style="width:10%;" class="saludo1">Seleccione Archivo: </td>
					<td style="width:25%;">
						<input type="file" name="archivotexto" id="archivotexto" style="width:100%;">
					</td>
					<td style="width:10%;" class="saludo1" >Vigencia:</td>
					<td style="width:40%;" ><input name="vigencia" id="vigencia" type="text" size="4" maxlength="4" value="<?php echo $_POST[vigencia]?>" onKeyUp="return tabular(event,this) " onKeyPress="javascript:return solonumeros(event)" >
						<input type="button" name="generar" value="Cargar" onClick="cargar()">
						<input type="button" name="protocolo" value="Descargar Formato de Importacion" onClick="protocoloimport()">
						<input name="oculto" type="hidden" value="1">
						<input type="hidden" name="import" id="import" value="<?php echo $_POST[import] ?>" >
					</td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>
			<div class="subpantalla" style="height:67%; width:99.6%; overflow-x:hidden;">
					<?php
					function obtenerClasificacion($clasifica){
						global $linkbd;
						$sql="SELECT tipo FROM dominios WHERE nombre_dominio='CLASIFICACION_RUBROS' AND descripcion_valor='$clasifica' ";
						$result=mysql_query($sql,$linkbd);
						$row=mysql_fetch_row($result);
						if($row[0]=='G'){
							$retorno="gastos";
						}else{
							$retorno="ingresos";
						}
						return $retorno;

					}
					echo "
					<table class='inicio'>
						<tr>
							<td class='titulos2' style='width: 5%'>Posicion</td>
							<td class='titulos2' style='width: 10%'>Cuenta</td>
							<td class='titulos2' style='width: 30%'>Nombre</td>
							<td class='titulos2' style='width: 10%'>Tipo</td>
							<td class='titulos2' style='width: 10%'>Clasificacion</td>
							<td class='titulos2' style='width: 5%'>Regalias</td>
							<td class='titulos2' style='width: 5%'>Causacion Contable</td>
							<td class='titulos2' style='width: 10%'>Fuente</td>
						</tr>";
						if($_POST[import]==1){
							$_POST[cuenta]=array();
							$_POST[nombre]=array();
							$_POST[tipo]=array();
							$_POST[clasificacion]=array();
							$_POST[regalias]=array();
							$_POST[causacion]=array();
							$_POST[fuente]=array();
							$_POST[posicion]=array();

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

							require_once 'PHPExcel/Classes/PHPExcel.php';
							$inputFileType = PHPExcel_IOFactory::identify($archivo);
							$objReader = PHPExcel_IOFactory::createReader($inputFileType);
							$objPHPExcel = $objReader->load($archivo);
							$sheet = $objPHPExcel->getSheet(0); 
							$highestRow = $sheet->getHighestRow(); 
                            $highestColumn = $sheet->getHighestColumn();

							$cod = 1;
							for ($row = 3; $row <= $highestRow; $row++)
							{
								$val1 = $sheet->getCell("A".$row)->getValue();
								$val2 = utf8_decode($sheet->getCell("B".$row)->getValue());
								$val3 = $sheet->getCell("C".$row)->getValue();
								$val4 = $sheet->getCell("D".$row)->getValue();
								$val5 = $sheet->getCell("E".$row)->getValue();
								$val6 = $sheet->getCell("F".$row)->getValue();
								$val7 = $sheet->getCell("G".$row)->getValue();

								$_POST[cuenta][]=$val1;
								$_POST[nombre][]=$val2;
								$_POST[tipo][]=$val3;
								$_POST[clasificacion][]=$val4;
								$_POST[regalias][]=$val5;
								$_POST[causacion][]=$val6;
								$_POST[fuente][]=$val7;
								$_POST[posicion][]=$cod;
                                $cod+=1;
							}
							
							echo "<script>document.form2.import.value=2;</script>";
						}
						$iter="zebra1";
						$iter2="zebra2";	
						for($x = 0;$x < count($_POST[cuenta]);$x++)
						{
							echo "
								<input type='hidden' name='cuenta[]' value='".$_POST[cuenta][$x]."'>
								<input type='hidden' name='nombre[]' value='".$_POST[nombre][$x]."'>
								<input type='hidden' name='tipo[]' value='".$_POST[tipo][$x]."'>
								<input type='hidden' name='clasificacion[]' value='".$_POST[clasificacion][$x]."'>
								<input type='hidden' name='regalias[]' value='".$_POST[regalias][$x]."'>
								<input type='hidden' name='causacion[]' value='".$_POST[causacion][$x]."'>
								<input type='hidden' name='fuente[]' value='".$_POST[fuente][$x]."'>
								<input type='hidden' name='posicion[]' value='".$_POS[posicion][$x]."'>
							";
							echo "<tr class='$iter'>
									<td>".$_POST[posicion][$x]."</td>
									<td>".$_POST[cuenta][$x]."</td>
									<td>".$_POST[nombre][$x]."</td>
									<td>".$_POST[tipo][$x]."</td>
									<td>".$_POST[clasificacion][$x]."</td>
									<td>".$_POST[regalias][$x]."</td>
									<td>".$_POST[causacion][$x]."</td>
									<td>".$_POST[fuente][$x]."</td>
								</tr>
							";	
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							
						}
								
						echo "</table>"; 

						if($_POST[oculto]==2){
							//$sql="DELETE FROM pptocuentas_pos WHERE vigencia=$_POST[vigencia]";
							//mysql_query($sql,$linkbd);
							if($_POST[entidades]=="1"){
								for($x=0;$x<count($_POST[cuenta]);$x++){
								$sqlr="select cuenta from pptocuentas where vigencia=$_POST[vigencia] and cuenta='".$_POST[cuenta][$x]."'";
								$res=mysql_query($sqlr,$linkbd);
								$row=mysql_fetch_row($res);
								if($_POST[causacion][$x]=='S')$nomina='N';

								if($_POST[regalias][$x]=='S'){
									$sqlr="select * from dominios where nombre_dominio='VIGENCIA_RG' and (valor_inicial=$_POST[vigencia] or valor_final=$_POST[vigencia])";
									$res=mysql_query($sqlr,$linkbd);
									$row=mysql_fetch_row($res);
									$vigini=$row[0];
									$vigfin=$row[1];
								}else{
									$vigini=$vigfin=$_POST[vigencia];
								}
								// else $nomina='S';
								if($_POST[tipo][$x]=='Mayor' || $_POST[clasificacion][$x]=='ingresos')
								{
									$_POST[fuente][$x]='';
								}
								if($_POST[clasificacion][$x]=='inversion')
								{
									$sqlr="insert into pptocuentas(cuenta,nombre,tipo,estado,clasificacion,regalias,nomina,vigencia,vigenciaf,futfuenteinv ) values('".$_POST[cuenta][$x]."','".$_POST[nombre][$x]."','".$_POST[tipo][$x]."','S','".$_POST[clasificacion][$x]."','".$_POST[regalias][$x]."','$nomina',$vigini,$vigfin,'".$_POST[fuente][$x]."')";
								}
								else
								{
									$sqlr="insert into pptocuentas(cuenta,nombre,tipo,estado,clasificacion,regalias,nomina,vigencia,vigenciaf,futfuentefunc) values('".$_POST[cuenta][$x]."','".$_POST[nombre][$x]."','".$_POST[tipo][$x]."','S','".$_POST[clasificacion][$x]."','".$_POST[regalias][$x]."','$nomina',$vigini,$vigfin,'".$_POST[fuente][$x]."')";
								}
								// echo $sqlr;
								mysql_query($sqlr,$linkbd);
								$elimina="DELETE FROM pptocuentas_pos WHERE cuentapos='".$_POST[cuenta][$x]."' AND vigencia='$_POST[vigencia]' AND entidad='interna' ";
								mysql_query($elimina,$linkbd);
								$inserta="INSERT INTO pptocuentas_pos(posicion,cuentapos,tipo,vigencia,entidad) VALUES ('".$_POST[posicion][$x]."','".$_POST[cuenta][$x]."','".obtenerClasificacion($_POST[clasificacion][$x])."',$_POST[vigencia],'interna')";
								mysql_query($inserta,$linkbd);

								echo "<script>despliegamodalm('visible','1','Se ha almacenado las cuentas presupuestales con Exito');</script>";

								}
							}else{
								for($x=0;$x<count($_POST[cuenta]);$x++){
								$sqlr="select cuenta from pptocuentasentidades where vigencia=$_POST[vigencia] and cuenta='".$_POST[cuenta][$x]."'";
								$res=mysql_query($sqlr,$linkbd);
								$row=mysql_fetch_row($res);
								if($_POST[causacion][$x]=='S')$nomina='N';

								if($_POST[regalias][$x]=='S'){
									$sqlr="select * from dominios where nombre_dominio='VIGENCIA_RG' and (valor_inicial=$_POST[vigencia] or valor_final=$_POST[vigencia])";
									$res=mysql_query($sqlr,$linkbd);
									$row=mysql_fetch_row($res);
									$vigini=$row[0];
									$vigfin=$row[1];
								}else{
									$vigini=$vigfin=$_POST[vigencia];
								}
								// else $nomina='S';
								if($_POST[tipo][$x]=='Mayor' || $_POST[clasificacion][$x]=='ingresos')
								{
									$_POST[fuente][$x]='';
								}
								if($_POST[clasificacion][$x]=='inversion')
								{
									$sqlr="insert into pptocuentasentidades(cuenta,nombre,tipo,estado,clasificacion,regalias,nomina,vigencia,vigenciaf,futfuenteinv ) values('".$_POST[cuenta][$x]."','".$_POST[nombre][$x]."','".$_POST[tipo][$x]."','S','".$_POST[clasificacion][$x]."','".$_POST[regalias][$x]."','$nomina',$vigini,$vigfin,'".$_POST[fuente][$x]."')";
								}
								else
								{
									$sqlr="insert into pptocuentasentidades(cuenta,nombre,tipo,estado,clasificacion,regalias,nomina,vigencia,vigenciaf,futfuentefunc) values('".$_POST[cuenta][$x]."','".$_POST[nombre][$x]."','".$_POST[tipo][$x]."','S','".$_POST[clasificacion][$x]."','".$_POST[regalias][$x]."','$nomina',$vigini,$vigfin,'".$_POST[fuente][$x]."')";
								}
								// echo $sqlr;
								mysql_query($sqlr,$linkbd);

								//$elimina="DELETE FROM pptocuentas_pos WHERE cuentapos='".$_POST[cuenta][$x]."' AND vigencia='$_POST[vigencia]' AND entidad='externa' ";
								//mysql_query($elimina,$linkbd);

								if(strlen($_POST[cuenta][$x])>1){
								for($i=0;$i<strlen($_POST[cuenta][$x]);$i++){
								$nuevacuenta=substr($_POST[cuenta][$x],0,strlen($_POST[cuenta][$x])-$i);
								$sql="SELECT posicion  FROM  pptocuentas_pos  WHERE cuentapos LIKE  '".$nuevacuenta."%' AND vigencia=$_POST[vigencia] AND entidad='interna' ORDER BY cuentapos DESC  LIMIT 0 , 1";
								$result=mysql_query($sql,$linkbd);
								$filas=mysql_num_rows($result);
								if($filas==1){
									$row=mysql_fetch_row($result);
									$inserta="INSERT INTO pptocuentas_pos(posicion,cuentapos,tipo,vigencia,entidad) VALUES ($row[0],'".$_POST[cuenta][$x]."','".obtenerClasificacion($_POST[clasificacion][$x])."',$_POST[vigencia],'externa')";
									mysql_query($inserta,$linkbd);
									break;
								}

							}
						}else{
							$sql="SELECT posicion  FROM  pptocuentas_pos  WHERE cuentapos LIKE  '".$_POST[cuenta][$x]."%' AND vigencia=$_POST[vigencia] AND entidad='interna' ORDER BY cuentapos DESC  LIMIT 0 , 1";
							$result=mysql_query($sql,$linkbd);
							$row=mysql_fetch_row($result);
							$inserta="INSERT INTO pptocuentas_pos(posicion,cuentapos,tipo,vigencia,entidad) VALUES ($row[0],'".$_POST[cuenta][$x]."','".obtenerClasificacion($_POST[clasificacion][$x])."',$_POST[vigencia],'externa')";
							mysql_query($inserta,$linkbd);
						}

								//$inserta="INSERT INTO pptocuentas_pos(cuentapos,tipo,vigencia,entidad) VALUES ('".$_POST[cuenta][$x]."','".obtenerClasificacion($_POST[clasificacion][$x])."',$_POST[vigencia],'externa')";
								//mysql_query($inserta,$linkbd);



							}
							}

						}
					?>
			</div>
			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>	
		</form>
	</td>
</tr>
<tr><td></td></tr>
</table>

</body>
</html>
