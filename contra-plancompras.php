<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
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
		<title>:: Spid - Contratacion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			jQuery(function($){ $('#vlrestimadovl').autoNumeric('init');});
			jQuery(function($){ $('#vlrestimadoactvl').autoNumeric('init');});
			function validarimport(formulario)
				{
					document.form2.import.value=1;
					document.form2.action="contra-plancompras.php";
					document.form2.submit();
				}
			function protocoloimport()
				{
					document.form2.action="plan-compras-import.php";
					document.form2.target="_BLANK";
					document.form2.submit(); 
					document.form2.action="";
					document.form2.target="";
				}
			function agregardetalle()
			{
				if(document.form2.cuenta.value!="" && document.form2.ncuenta.value!="" )
				{
					document.form2.agregadet.value="1";
					document.getElementById('banderin2').value=parseInt(document.getElementById('banderin2').value)+1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Falta informacion del Producto para poder Agregar');}
			}
			function agregaradqui()
			{ 
				var validacion01=document.getElementById('descripcion').value;
				var validacion02=document.getElementById('duracion1').value;
				var validacion03=document.getElementById('vlrestimado').value;
				var validacion04=document.getElementById('vlrestimadoact').value;
				var validacion05=document.getElementById('duracion2').value;
				if((document.form2.fecha.value!="")&&(document.form2.fecha2.value!="")&&((validacion02.trim()!='' || validacion02!=0) || (validacion05.trim()!='' || validacion05!=0))&&(document.form2.modalidad.value!="")&&(validacion01.trim()!='')&&(document.form2.fuente.value!="")&&(validacion03.trim()!='')&&(validacion04.trim()!='')&&(document.form2.requierev.value!="")&&(document.form2.estadorequierev.value!="")&&(document.getElementById('banderin2').value!=0))
				{
					document.form2.agregadetadq.value=1;
					document.getElementById('banderin1').value=parseInt(document.getElementById('banderin1').value)+1;
					document.getElementById('banderin2').value=0;
					document.getElementById('limpiar').value="1";
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Falta informacion de la Adquisición para poder Agregar');}
			}
			function eliminarlist(variable)
			{
				document.form2.eliminarlista.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar esta Adquisición','2');
			}
			function eliminard(variable)
			{
				document.form2.eliminar.value=variable;
				despliegamodalm('visible','4','Esta seguro de eliminar el Producto de la lista','3');
			}
			function buscacta(e)
			{
				if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
			function guardar()
			{
				var pasa=document.form2.clear.value;
				if (document.getElementById('banderin1').value!=0){
					if(pasa==0){
						despliegamodalm('visible','4','Esta Seguro de Guardar','1');
					}else{
						despliegamodalm('visible','2','Faltan datos para completar el registro');
					}
					
					
					}
				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function pdf()
			{
				document.form2.action="contra-plancompraspdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
			function funcionmensaje(){document.location.href = "contra-plancompras.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculgen.value="2";document.form2.submit();break;
					case "2":	document.getElementById('banderin1').value=parseInt(document.getElementById('banderin1').value)-1;
								document.form2.oculto.value='2';document.form2.submit();break;
					case "3":	document.getElementById('banderin2').value=parseInt(document.getElementById('banderin2').value)-1;
								document.form2.oculto.value='3';document.form2.submit();break;
				}
			}
			
		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("inve");?></tr>
    		<tr>
  				<td colspan="3" class="cinta">
					<a href="contra-plancompras.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
					<a href="contra-plancomprasbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" class="mgbt" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir" /></a>
				</td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
    	<form name="form2" method="post" enctype="multipart/form-data">
            <input type="hidden" name="oculgen" id="oculgen" value="<?php echo $_POST[oculgen] ?> ">
            <input type="hidden" name="banderin1" id="banderin1" value="<?php echo $_POST[banderin1];?>">
            <input type="hidden" name="banderin2" id="banderin2" value="<?php echo $_POST[banderin2];?>">
            <input type="hidden" name="limpiar" id="limpiar" value="<?php echo $_POST[limpiar];?>"> 
			<input type="hidden" name="clear" id="clear" value="<?php echo $_POST[clear];?>"> 
			<?php

			function existeProducto($codpro){
				$registros=explode(" ",$codpro);
				$retorno=false;
				for($i=0;$i<count($registros);$i++){
					$sql="SELECT * FROM productospaa WHERE codigo='$registros[$i]' AND estado='S' ";
					$result=mysql_query($sql,$linkbd);
					$num=mysql_num_rows($result);
					if($num==0){
						$retorno=false;
						break;
					}else{
						$retorno=true;
					}
				}
				return $retorno;
			}
				$_POST[clear]=0;
				echo "<script>
				document.form2.clear.value=0;
					</script>";			
			if($_POST[import]==1){
					unset($_POST[adqprodtodos]);
					unset($_POST[adqindice]);
					unset($_POST[adqdescripcion]);
					unset($_POST[adqfecha2]);
					unset($_POST[adqduracion1]);	
					unset($_POST[adqduracion2]);		
					unset($_POST[adqmodalidad]);	
					unset($_POST[adqfuente]);
					unset($_POST[adqvlrestimado]);	
					unset($_POST[adqvlrvig]);	
					unset($_POST[adqfecha]);
					unset($_POST[adqprodtodosg]);
					unset($_POST[adqrequierevig]);
					unset($_POST[adqestadovigfut]);
					unset($_POST[codigoadqisicion]);
					unset($_POST[adqmodalidad2]);
					unset($_POST[adqfuente2]);
					$_POST[adqprodtodos]= array_values($_POST[adqprodtodos]); 
					$_POST[adqindice]= array_values($_POST[adqindice]); 
					$_POST[adqdescripcion]= array_values($_POST[adqdescripcion]); 
					$_POST[adqfecha2]= array_values($_POST[adqfecha2]); 
					$_POST[adqduracion1]= array_values($_POST[adqduracion1]); 
					$_POST[adqduracion2]= array_values($_POST[adqduracion2]); 
					$_POST[adqmodalidad]= array_values($_POST[adqmodalidad]);
					$_POST[adqfuente]= array_values($_POST[adqfuente]);
					$_POST[adqvlrestimado]= array_values($_POST[adqvlrestimado]);
					$_POST[adqvlrvig]= array_values($_POST[adqvlrvig]);
					$_POST[adqfecha]= array_values($_POST[adqfecha]);
					$_POST[adqprodtodosg]= array_values($_POST[adqprodtodosg]);
					$_POST[adqrequierevig]= array_values($_POST[adqrequierevig]);
					$_POST[adqestadovigfut]= array_values($_POST[adqestadovigfut]);
					$_POST[codigoadqisicion]= array_values($_POST[codigoadqisicion]);
					$_POST[adqmodalidad2]= array_values($_POST[adqmodalidad2]);
					$_POST[adqfuente2]= array_values($_POST[adqfuente2]);
					
					if(is_uploaded_file($_FILES['archivotexto']['tmp_name']))
					{
						$archivo = $_FILES['archivotexto']['name'];
						$archivoF = "$archivo";
						if(move_uploaded_file($_FILES['archivotexto']['tmp_name'],$archivoF))
						{
							$subio=1;
						}
					}
					
					require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';
					$objPHPExcel = PHPExcel_IOFactory::load("$archivo");
					foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
						$worksheetTitle     = $worksheet->getTitle();
						$highestRow         = $worksheet->getHighestRow();
						$highestColumn      = $worksheet->getHighestColumn();
						$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
						$nrColumns = ord($highestColumn) - 64;
						
						
						for ($j = 3; $j <= $highestRow; ++ $j) {

							$cell = $worksheet->getCellByColumnAndRow(0, $j);
							$val1 = trim($cell->getValue());
							if($val1!='' && existeProducto($val1)){
							$cell = $worksheet->getCellByColumnAndRow(1, $j);
							$val2 = trim($cell->getValue());
							
							$cell = $worksheet->getCellByColumnAndRow(2, $j);
							$val3 = trim($cell->getValue());
							
							$cell = $worksheet->getCellByColumnAndRow(3, $j);
							$val4 = trim($cell->getValue());
							
							$cell = $worksheet->getCellByColumnAndRow(4, $j);
							$val5 = trim($cell->getValue());
							
							$cell = $worksheet->getCellByColumnAndRow(5, $j);
							$val6 = trim($cell->getValue());
							
							$cell = $worksheet->getCellByColumnAndRow(6, $j);
							$val7 = trim($cell->getValue());
							
							$cell = $worksheet->getCellByColumnAndRow(7, $j);
							$val8 = trim($cell->getValue());
							
							$cell = $worksheet->getCellByColumnAndRow(8, $j);
							$val9 = trim($cell->getValue());
							
							$cell = $worksheet->getCellByColumnAndRow(9, $j);
							$val10 = trim($cell->getValue());
							
							$cell = $worksheet->getCellByColumnAndRow(10, $j);
							$val11 = trim($cell->getValue());
							
							$cell = $worksheet->getCellByColumnAndRow(11, $j);
							$val12 = trim($cell->getValue());
							echo "<script>
										document.getElementById('banderin1').value=parseInt(document.getElementById('banderin1').value)+1;
									</script>";
							
							if($val1=='' || $val2=='' || $val3=='' || $val4=='' || $val5=='' ||$val6=='' || $val7=='' || $val8=='' || $val9=='' || $val10=='' || $val11=='' || $val12==''){
								$_POST[clear]=1;
								echo "<script>
										document.form2.clear.value=1;
									</script>";
							}
							
							$_POST[adqprodtodos][]=$val1;
							$_POST[adqdescripcion][]=$val2;
							$_POST[fecha]="";
							$_POST[fecha2]=$val3;
							$_POST[adqfecha2][]=$val3;
							$_POST[duracion1]=$val4;
							$_POST[duracion2]=$val5;
							$_POST[descripcion]=$val2;
							$_POST[adqduracion1][]=$val4;
							$_POST[adqduracion2][]=$val5;
							$_POST[vlrestimadovl]=$val8;
							$_POST[adqvlrestimado][]=$val8;
							$_POST[vlrestimadoactvl]=$val9;
							$_POST[adqvlrvig][]=$val9;
							if($val6!=''){
								$arreglo=explode("-",$val6);
								$abrevi=$arreglo[0];
								$sql="Select valor_inicial from dominios  where nombre_dominio='MODALIDAD_SELECCION' and (valor_final IS NULL or valor_final ='') AND (tipo='S' OR tipo='1') AND descripcion_dominio='$abrevi' order by valor_inicial asc LIMIT 0,1";
								$result=mysql_query($sql,$linkbd);
								$row=mysql_fetch_row($result);
								$num=mysql_num_rows($result);
								if($num==1){
									
									$_POST[modalidad]=$row[0];
									$_POST[adqmodalidad][]=$row[0];
								}
							}

								$_POST[requierev]=strtoupper(substr($val10,0,1));
							
							$arregloFuente=explode("-",$val7);
							$_POST[fuente]=$arregloFuente[0];
							if($val7!=''){
								$sql="SELECT * FROM (Select codigo,nombre from pptofutfuentefunc UNION Select * from pptofutfuenteinv) AS u WHERE u.codigo=$arregloFuente[0]";
								$result=mysql_query($sql,$linkbd);
								$row=mysql_fetch_row($result);
								$_POST[adqfuente][]=$row[1];
							}
							$_POST[contacto1]=$val12;
							$_POST[cargo]="ALMACENISTA";
							if($val11!=''){
								$sql="SELECT * FROM dominios WHERE nombre_dominio =  'ESTADO_VIGENCIASF' AND descripcion_valor='".strtoupper($val11)."' ";
								$result=mysql_query($sql,$linkbd);
								$row=mysql_fetch_row($result);
								$_POST[estadorequierev]=$row[0];
							}
							}else{
								echo "<script>
										despliegamodalm('visible','2','Hay codigos que no existen');
										</script>";
								
							}
							
						}
					}
					echo "<script>
							document.form2.import.value=2;
						</script>";
						
				
				}
		
				if($_POST[oculto]=='')
				{
					$_POST[dproductos]=array();
					$_POST[dproductos]=array();
					$_POST[adqproductos][]=array();
					$_POST[adqindice]=array();
					$_POST[adqdescripcion]=array();
					$_POST[adqfecha2]=array();
					$_POST[adqprodtodos]=array();
					$_POST[adqcontacto]=array();
					$_POST[dtipos]=array(); 
					$_POST[duracion1]=0;
					$_POST[duracion2]=0;
				} 
					if($_POST[oculgen]=="")
					{
						$_POST[vigenciactual]=vigencia_usuarios($_SESSION[cedulausu]);
						echo"
						<script>
							document.getElementById('banderin1').value=0;
							document.getElementById('banderin2').value=0;
							document.getElementById('oculgen').value='1';
						</script>";
					}
					if ($_POST[oculto]=='2')
					{ 
						$posi=$_POST[eliminarlista];
						unset($_POST[adqprodtodos][$posi]);
						unset($_POST[adqindice][$posi]);
						unset($_POST[adqdescripcion][$posi]);
						unset($_POST[adqcontacto][$posi]);
						unset($_POST[adqfecha2][$posi]);
						unset($_POST[adqduracion1][$posi]);
						unset($_POST[adqduracion2][$posi]);
						unset($_POST[adqmodalidad][$posi]);
						unset($_POST[adqfuente][$posi]);
						unset($_POST[adqvlrestimado][$posi]);
						unset($_POST[adqvlrvig][$posi]);
						unset($_POST[adqmodalidad][$posi]);
						unset($_POST[adqrequierevig][$posi]);
						unset($_POST[adqestadovigfut][$posi]);
						unset($_POST[adqfecha][$posi]);
						unset($_POST[adqprodtodosg][$posi]);
						unset($_POST[codigoadqisicion][$posi]);
						unset($_POST[adqmodalidad2][$posi]);
						unset($_POST[adqfuente2][$posi]);
						$_POST[adqprodtodos]= array_values($_POST[adqprodtodos]); 
						$_POST[adqindice]= array_values($_POST[adqindice]); 
						$_POST[adqdescripcion]= array_values($_POST[adqdescripcion]); 	
						$_POST[adqcontacto]= array_values($_POST[adqcontacto]); 
						$_POST[adqfecha2]= array_values($_POST[adqfecha2]); 
						$_POST[adqduracion1]= array_values($_POST[adqduracion1]); 
						$_POST[adqduracion2]= array_values($_POST[adqduracion2]); 
						$_POST[adqmodalidad]= array_values($_POST[adqmodalidad]); 
						$_POST[adqfuente]= array_values($_POST[adqfuente]); 	
						$_POST[adqvlrestimado]= array_values($_POST[adqvlrestimado]); 
						$_POST[adqvlrvig]= array_values($_POST[adqvlrvig]); 
						$_POST[adqrequierevig]= array_values($_POST[adqrequierevig]); 
						$_POST[adqestadovigfut]= array_values($_POST[adqestadovigfut]); 	
						$_POST[adqfecha]= array_values($_POST[adqfecha]); 
						$_POST[adqprodtodosg]= array_values($_POST[adqprodtodosg]); 
						$_POST[codigoadqisicion]=array_values($_POST[codigoadqisicion]);
						$_POST[adqmodalidad2]=array_values($_POST[adqmodalidad2]);
						$_POST[adqfuente2]= array_values($_POST[adqfuente2]);
						echo"<script>document.form2.oculto.value='1';</script>";
					}
					if ($_POST[agregadet]=='1')
					{
						$_POST[dproductos][]=$_POST[cuenta];
						$_POST[dnproductos][]=$_POST[ncuenta]; 
						$nt=buscaproductotipo($_POST[cuenta]);
						$_POST[dtipos][]=buscadominiov2("UNSPSC",$nt);
						$_POST[agregadet]=0;
						$_POST[cuenta]="";
						$_POST[ncuenta]="";
					}
					 //**** busca cuenta
					if ($_POST[agregadetadq]=='1')
					{
					$indice=count($_POST[adqindice]);
					$_POST[adqindice][]=$indice;
					$_POST[adqdescripcion][]=$_POST[descripcion];
					$_POST[adqfecha][]=$_POST[fecha];
					$_POST[adqfecha2][]=$_POST[fecha2];	
					$_POST[adqduracion1][]=$_POST[duracion1];	
					$_POST[adqduracion2][]=$_POST[duracion2];
					$_POST[adqmodalidad][]=$_POST[modalidad];	
					$_POST[adqfuente][]=$_POST[fuente];
					$_POST[adqvlrestimado][]=$_POST[vlrestimado];
					$_POST[adqvlrvig][]=$_POST[vlrestimadoact];
					$_POST[adqrequierevig][]=$_POST[requierev];
					$_POST[adqestadovigfut][]=$_POST[estadorequierev];
					$_POST[adqcontacto][]=$_POST[contactol];
					for($x=0;$x<count($_POST[dproductos]);$x++)
					{$_POST[adqproductos][$indice][$x]=$_POST[dproductos][$x]; }
					$codigos=implode("<br>", $_POST[adqproductos][$indice]);
					$_POST[adqprodtodosg][]=implode("-", $_POST[adqproductos][$indice]);
					$_POST[adqprodtodos][]=$codigos;
					$_POST[agregadetadq]=0;
					$_POST[codigoadqisicion][]="";
					$t=count($_POST[dproductos]);
					$sqlr="SELECT valor_inicial FROM dominios  WHERE nombre_dominio='MODALIDAD_SELECCION' AND (valor_final IS NULL or valor_final ='') AND valor_inicial='".$_POST[modalidad]."'";
					$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$_POST[adqmodalidad2][]=$row[0];
					$sqlr2="SELECT nombre FROM pptosidefrecursos WHERE codigo='".$_POST[fuente]."'";
					$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
					$_POST[adqfuente2][]=$row2[0];
					for ($x=0;$x<$t;$x++)
					{
						unset($_POST[dproductos][$x]);
						unset($_POST[dnproductos][$x]);
						unset($_POST[dtipos][$x]);
					}
					$_POST[dproductos]= array_values($_POST[dproductos]); 
					$_POST[dnproductos]= array_values($_POST[dnproductos]); 
					$_POST[dtipos]= array_values($_POST[dtipos]);
								
				}
            ?>
				<table  align="center" class="inicio" >
				<tr >
					<td class="titulos" colspan="7">.: Importar Plan Anual de Adquisiciones</td>
				</tr>   
				<tr> 
					<td width="15%"  class="saludo1">Seleccione Archivo: </td>
					<td width="15%" >
						<input type="file" name="archivotexto" id="archivotexto">
					</td>
					<td colspan="7" >
						<input type="button" name="generar" value="Cargar Archivo" onClick="validarimport()">
						<input type="hidden" name="import" id="import" value="<?php echo $_POST[import] ?>" >
						<input type="button" name="protocolo" value="Descargar Formato de Importacion" onClick="protocoloimport()">
					</td>
				</tr>                  
			</table>
 			<table class="inicio" >
                <tr>
                    <td colspan="8" class="titulos" >Plan Anual de Adquisiciones</td>
                    <td class="cerrar" style="width:7%"><a href="contra-principal.php">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td  class="saludo1" style="width:8%" >Fecha Registro:</td>
                    <td style="width:10%">
						<input type="text" style="width:80%" name="fecha" id="fecha" title="DD/MM/YYYY" value="<?php echo $_POST[fecha];?>" readonly>
						<a onClick="displayCalendarFor('fecha') ;  " maxlength="5" style="width:40%;"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"/></a>
					</td>
                    <td class="saludo1" style="width:10%">Fecha Estimada Inicio Selecci&oacute;n:</td>
                    <td style="width:15%">
						<input type="text" style="width:60%" name="fecha2" id="fecha2" title="DD/MM/YYYY" value="<?php echo $_POST[fecha2];?>" readonly>
						<a onClick="displayCalendarFor('fecha2') ;  " maxlength="5" style="width:40%;"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"/></a>
					</td>
                    <td class="saludo1" style="width:10%">Duraci&oacute;n Contrato (D&iacute;as / Meses):</td>
                    <td style="width:3%">
                    	<input type="text" name="duracion1" id="duracion1"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[duracion1]; ?>" style="width:48%">
                        <input type="text" name="duracion2" id="duracion2"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[duracion2]; ?>" style="width:48%">
                    </td>
                    <td class="saludo1" style="width:10%">Modalidad Selecci&oacute;n:</td>
                    <td colspan="2" style="width:21%">
                        <select name="modalidad" id="modalidad" style="width:100%;text-transform:uppercase;">
                            <option value=''>Seleccione ...</option>
                            <?php
                                $sqlr="Select * from dominios  where nombre_dominio='MODALIDAD_SELECCION' and (valor_final IS NULL or valor_final ='') AND (tipo='S' OR tipo='1') order by valor_inicial asc"; 
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
									$sqlr2="SELECT * FROM dominios WHERE nombre_dominio='MODALIDAD_SELECCION' AND valor_final='$row[0]' AND tipo='S' ORDER BY valor_inicial ASC  ";
									$res2=mysql_query($sqlr2,$linkbd);
									$ntr = mysql_num_rows($res2);
									if($ntr!=0)
									{
                                 		if($row[0]==$_POST[modalidad]){echo "<option value=$row[0] SELECTED>$row[0] - $row[2]</option>";}
                                    	else{echo "<option value=$row[0]>$row[0] - $row[2]</option>";}
									}
                                 }			
                            ?>
                        </select>
                    </td>    
                </tr>
                <tr>
                    <td class="saludo1">Descripci&oacute;n:</td>
                    <td colspan="5">
						<input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]; ?>" style="width:100%"/></td>
                    <td class="saludo1">Fuente Recurso:</td>
                    <td colspan="2">
                        <select name="fuente" id="fuente" style="width:100%;text-transform:uppercase;">
                            <option value=''>Seleccione ...</option>
                            <?php
                                $sqlr="Select codigo,nombre from pptofutfuentefunc UNION Select * from pptofutfuenteinv order by CAST(codigo AS SIGNED INTEGER) asc";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[fuente]){echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";}
                                    else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
                                 }			
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="saludo1">Valor Estimado</td>
                    <td>
                    	<input type="hidden" name="vlrestimado" id="vlrestimado" value="<?php echo $_POST[vlrestimado]; ?>" />
                    	<input type="text" name="vlrestimadovl" id="vlrestimadovl" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('vlrestimado','vlrestimadovl');return tabular(event,this);" value="<?php echo $_POST[vlrestimadovl]; ?>" style='text-align:right;' autocomplete="off"/>
                    </td>
                    <td class="saludo1">Vlr Estimado Vig. Actual</td>
                    <td>
                    	<input type="hidden" name="vlrestimadoact" id="vlrestimadoact" value="<?php echo $_POST[vlrestimadoact]; ?>">
                    	<input type="text" name="vlrestimadoactvl" id="vlrestimadoactvl" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('vlrestimadoact','vlrestimadoactvl');return tabular(event,this);" value="<?php echo $_POST[vlrestimadoactvl]; ?>" style='text-align:right;' autocomplete="off"/>
                    </td>
                    <td class="saludo1">	 Futuras:</td>
                    <td>
                        <select name="requierev" id="requierev">
                            <option value=''>SELECCIONE ...</option>
                            <?php
                                $sqlr="Select * from dominios  where nombre_dominio='VIGENCIASF' order by valor_inicial asc";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[requierev]){echo "<option value=$row[0] SELECTED>$row[2]</option>";}
                                    else{echo "<option value=$row[0]>$row[2]</option>";}
                                 }			
                            ?>
                        </select>
                    </td>
                    <td class="saludo1">Estado de Solicitud Vigencias Futuras:</td>
                    <td colspan="2">
                        <select name="estadorequierev" id="estadorequierev" style="width:100%;text-transform:uppercase;">
                            <option value=''>Seleccione ...</option>
                            <?php
                                $sqlr="Select * from dominios  where nombre_dominio='ESTADO_VIGENCIASF'   order by valor_inicial asc";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[estadorequierev]){echo "<option value=$row[0] SELECTED>$row[2]</option>";}
                                    else{echo "<option value=$row[0]>$row[2]</option>";}
                                 }			
                            ?>
                        </select>
                    </td>
                </tr>
				<tr> 
					<td class="saludo1"> Contacto responsable: </td>
					 <td colspan="3">
                    	<input type="hidden" name="contacto" id="contacto" value="<?php echo $_POST[contacto]; ?>" />
                    	<input type="text" name="contacto1" id="contacto1" value="<?php echo $_POST[contacto1]; ?>" style="width:100%" />
                    </td>
					<td class="saludo1"> Cargo: </td>
					 <td colspan="3">
                    	
                    	<input type="text" name="cargo" id="cargo" value="<?php echo $_POST[cargo]; ?>" style="width:75%" />
                    </td>
				</tr>
           	 	<tr><td colspan="9" class="titulos2">Productos Adquisici&oacute;n</td></tr>
                <tr>
                    <td class="saludo1">C&oacute;digo Producto:</td>
                    <td valign="middle">
                        <input type="text" name="cuenta" id="cuenta" onKeyPress="javascript:return solonumeros(event)" 
              onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" style="width:70%" >
                        <input type="hidden" value="0" name="bc">
                        <a href="#" onClick="despliegamodal2('visible');"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" class="icobut"></a></td>
                    <td colspan='5'><input type="text" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>" style="width:100%"  readonly></td>
                    <td style="width:20%" colspan='2'>
                        <input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" >
                        <input type="hidden" value="0" name="agregadet"> 
                        <input type="button" name="agregaadq" value="Agregar Adquisicion" onClick="agregaradqui()" >
                        <input type="hidden" value="0" name="agregadetadq">
                    </td>
                </tr>
 			</table>
            <input type="hidden" name="vigenciactual" id="vigenciactual" value="<?php echo $_POST[vigenciactual];?>">
            <div class="subpantalla" style="height:19.2%; width:99.5%; overflow-x:hidden">
            <table class="inicio" style="width:100%">
                <tr>
                    <td class="titulos2" style="width:10%">Codigo</td>
                    <td class="titulos2" style="width:60%">Nombre</td>
                    <td class="titulos2"style="width:25%">Tipo</td>
                    <td class="titulos2" style="width:5%" align="middle">Eliminar<input type='hidden' name='eliminar' id='eliminar'></td>
                </tr>
                <?php
				
					if($_POST[bc]=='1')
					{
						echo"<script>document.form2.bc.value='0';</script>";
						$dosdigitos=substr($_POST[cuenta], 6);
						if($dosdigitos!="00" && $dosdigitos!="")
						{
							$nresul=buscaproducto($_POST[cuenta]);
							if($nresul!='')
							{
								echo"<script>
									document.form2.ncuenta.value='$nresul'; 
									document.getElementById('agrega').focus();
									document.getElementById('agrega').select();</script>";
							}
						   	else
							{
								echo"<script>
									despliegamodalm('visible','2','Codigo Incorrecto');
									document.form2.ncuenta.value='';
									document.form2.cuenta.value='';
								</script>";
							}
						}
						else
						{
							echo"<script>
								despliegamodalm('visible','2','Codigo Incorrecto');
								document.form2.ncuenta.value='';
								document.form2.cuenta.value='';
							</script>";
						}
					}
					if ($_POST[oculto]=='3')
					{ 
						$posi=$_POST[eliminar];
						unset($_POST[dproductos][$posi]);
						unset($_POST[dnproductos][$posi]);
						unset($_POST[dtipos][$posi]);
						$_POST[dproductos]= array_values($_POST[dproductos]); 
						$_POST[dnproductos]= array_values($_POST[dnproductos]); 
						$_POST[dtipos]= array_values($_POST[dtipos]);
						echo"<script>document.form2.oculto.value='1';</script>";
					}
                    $iter='saludo1';
                    $iter2='saludo2';
                    for ($x=0;$x<count($_POST[dproductos]);$x++)
                    {		 
                        echo "
                            <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
                                <td><input class='inpnovisibles' name='dproductos[]' value='".$_POST[dproductos][$x]."' type='text' readonly></td>
                                <td><input class='inpnovisibles' name='dnproductos[]'  value='".$_POST[dnproductos][$x]."' type='text' style=\"width:100%\" readonly></td>
                                <td><input class='inpnovisibles' name='dtipos[]' value='".$_POST[dtipos][$x]."' type='text'  readonly></td>";		
                        echo "<td align=\"middle\"><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";	
                        $aux=$iter;
                        $iter=$iter2;
                        $iter2=$aux;
                    }	
                ?>
 			</table>
 			</div>
            <div class="subpantallac" style="height:29.5%; width:99.5%; overflow-x:hidden">
            <table class="inicio">
                <tr><td class="titulos" colspan="10">ADQUISICIONES</td></tr>
                <tr>
                    <td class="titulos2" style="width:13%">Codigo UNSPSC</td>
                    <td class="titulos2">Descripcion</td>
                    <td class="titulos2">Fecha Estimada</td>
                    <td class="titulos2">Duracion Estimada</td>
                    <td class="titulos2">Modalidad Seleccion</td>
                    <td class="titulos2">Fuente</td>
                    <td class="titulos2">Vlr Estimado</td>
                    <td class="titulos2">Vlr Estimado Vig Actual</td>
					<td class="titulos2">Eliminar<input type='hidden' name='eliminarlista' id='eliminarlista'></td>
                </tr>
                <?php
				
				
					if($_POST[limpiar]=="1")
					{
						echo"<script>
						document.getElementById('limpiar').value='0';
						document.form2.fecha.value='';
						document.form2.fecha2.value='';
						document.form2.duracion.value='';
						document.form2.modalidad.value='';
						document.form2.descripcion.value='';
						document.form2.fuente.value='';
						document.form2.vlrestimado.value='';
						document.form2.vlrestimadovl.value='';
						document.form2.vlrestimadoact.value='';
						document.form2.vlrestimadoactvl.value='';
						document.form2.requierev.value='';
						document.form2.estadorequierev.value='';
						document.form2.cuenta.value='';
						document.form2.ncuenta.value='';
						document.form2.contactol.value='';
						</script>";
					}
                    $co='saludo1a';
                    $co2='saludo2';
                    for($k=0;$k<count($_POST[adqdescripcion]); $k++  )
                    {
                        $codigos=$_POST[adqprodtodos][$k];
                        $codigos2=str_replace("</br>",", ",$codigos);
                        echo "
                        <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
                            <td>$codigos2 <input name='adqprodtodos[]' value='".$_POST[adqprodtodos][$k]."' type='hidden' ></td>
                            <td>
                                <input name='adqindice[]' value='".$_POST[adqindice][$k]."' type='hidden'>
                                <input name='adqdescripcion[]' value='".$_POST[adqdescripcion][$k]."' type='hidden' >".$_POST[adqdescripcion][$k]."</td>
                            <td><input name='adqfecha2[]' value='".$_POST[adqfecha2][$k]."' type='hidden' >".$_POST[adqfecha2][$k]."</td>
                            <td>
								<input name='adqduracion1[]' value='".$_POST[adqduracion1][$k]."' type='hidden' >
								<input name='adqduracion2[]' value='".$_POST[adqduracion2][$k]."' type='hidden' >
									";
						if($_POST[adqduracion1][$k]>1 ){echo $_POST[adqduracion1][$k]." Dias ";}
						elseif($_POST[adqduracion1][$k]==1){echo $_POST[adqduracion1][$k]." Dia ";}
						if($_POST[adqduracion1][$k]>1 && $_POST[adqduracion2][$k]>1){echo " y ";}
						if($_POST[adqduracion2][$k]>1 ){echo $_POST[adqduracion2][$k]." Meses";}
						elseif($_POST[adqduracion2][$k]==1){echo $_POST[adqduracion2][$k]." Mes";}
						echo"
							</td>
                            <td><input name='adqmodalidad[]' value='".$_POST[adqmodalidad][$k]."' type='hidden' >".$_POST[adqmodalidad][$k]."</td>
                            <td><input name='adqfuente[]' value='".$_POST[adqfuente][$k]."' type='hidden' >".$_POST[adqfuente][$k]."</td>
                            <td style='text-align:right'><input name='adqvlrestimado[]' value='".$_POST[adqvlrestimado][$k]."' type='hidden' >\$".number_format($_POST[adqvlrestimado][$k],2)."</td>
                            <td style='text-align:right'><input name='adqvlrvig[]' value='".$_POST[adqvlrvig][$k]."' type='hidden' >\$".number_format($_POST[adqvlrvig][$k],2)."</td>
                            <td align=\"middle\"><a href='#' onclick='eliminarlist($k)'><img src='imagenes/del.png'></a></td>
                            <input name='adqfecha[]' value='".$_POST[adqfecha][$k]."' type='hidden' >
                            <input name='adqprodtodosg[]' value='".$_POST[adqprodtodosg][$k]."' type='hidden' >
                            <input name='adqrequierevig[]' value='".$_POST[adqrequierevig][$k]."' type='hidden' >
                            <input name='adqestadovigfut[]' value='".$_POST[adqestadovigfut][$k]."' type='hidden' >
                            <input name='codigoadqisicion[]' value='".$_POST[codigoadqisicion][$k]."' type='hidden' >
                            <input name='adqmodalidad2[]' value='".$_POST[adqmodalidad2][$k]."' type='hidden' >
                            <input name='adqfuente2[]' value='".$_POST[adqfuente2][$k]."' type='hidden' >
                        </tr>";	
                        $aux=$co;
                        $co=$co2;
                        $co2=$aux;
                    }
                   
                ?>
            </table>
 			</div>
            <input type="hidden" name="oculto" id="oculto" value="1">
			<?php
   				if($_POST[oculgen]=="2")
				{
					$sqlr="SELECT MAX(CONVERT(codplan, SIGNED INTEGER)) FROM contraplancompras WHERE vigencia='$_POST[vigenciactual]'";
					$row=mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$codplan=$row[0]+1;	
					$tt=count($_POST[adqdescripcion]);
					for($k=0;$k<$tt; $k++)
					{
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[adqfecha][$k],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[adqfecha2][$k],$fecha1);
						$fechaf1=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
						if($_POST[codigoadqisicion][$k]==""){$codadqisicion=$codplan;$codplan=$codplan+1;}
						else {$codadqisicion=$_POST[codigoadqisicion][$k];}
						$duraciontotal=$_POST[adqduracion1][$k]."/".$_POST[adqduracion2][$k];
						$sqlr="INSERT INTO contraplancompras (codplan,vigencia,fecharegistro,codelaboradopor,codigosunspsc,descripcion, fechaestinicio,duracionest,modalidad,fuente,valortotalest,valorestvigactual,requierevigfut,estadovigfut,estado,contacto_respon ) VALUES ('$codadqisicion', '$_POST[vigenciactual]','$fechaf','$_SESSION[cedulausu]','".$_POST[adqprodtodosg][$k]."','".$_POST[adqdescripcion][$k]."','$fechaf1','$duraciontotal','".$_POST[adqmodalidad][$k]."','".$_POST[adqfuente][$k]."','".$_POST[adqvlrestimado][$k]."', '".$_POST[adqvlrvig][$k]."','".$_POST[adqrequierevig][$k]."','".$_POST[adqestadovigfut][$k]."','S','".$_POST[contacto1]."-".$_POST[cargo]."')";
						mysql_query($sqlr,$linkbd);	
					}
					echo"<script>despliegamodalm('visible','1','Se ha almacenaron las Adquisiciones al Plan Anual con Exito');</script>";
				}
   			?>
		</form>
        <div id="bgventanamodal2">
            <div id="ventanamodal2">
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>
	</body>
</html>