<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	require"validaciones.inc";
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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				if (document.form2.fecha.value!='' && document.form2.cc.value!='' && document.form2.trimestre.value!='')
				{
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.fecha.focus();
					document.form2.fecha.select();
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;
								document.form2.submit();
								break;
				}
			}
			function cargarotro(){document.form2.cargabal.value=1; document.form2.oculto.value=1; document.form2.submit();}
			function checktodos()
			{
				cali=document.getElementsByName('ctes[]');
				//valrubro=document.getElementsByName('dvalores[]');
				for (var i=0;i < cali.length;i++) 
				{ 
					if (document.getElementById("todoscte").checked == true) 
					{cali.item(i).checked = true;document.getElementById("todoscte").value=1;}
					else{cali.item(i).checked = false;document.getElementById("todoscte").value=0;}
				}	
			}
			function checktodosn()
			{
				cali=document.getElementsByName('nctes[]');
				//valrubro=document.getElementsByName('dvalores[]');
				for (var i=0;i < cali.length;i++) 
				{ 
					if (document.getElementById("todoscten").checked == true)
					{cali.item(i).checked = true;document.getElementById("todoscten").value=1;}
					else{cali.item(i).checked = false;document.getElementById("todoscten").value=0;}
				}	
			}
			function protocolofmt()
			{
				document.form2.action="formatos/FMT_CONSOLIDACION_ENTIDADES_PRESUING.csv";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function carnomarchivo()
			{	
			var comarchivo=document.getElementById('archivotexto').value;
				var elem = comarchivo.split('\\');
				var totalelem=elem.length-1;
				document.getElementById('nomarch').value=elem[totalelem];
			}
			function despliegamodal2(_valor,_nomve)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="terceros-ventana1.php";}
			}
		</script>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("presu");?></tr>
            <tr>
                <td colspan="3" class="cinta"><a href="presu-cargaentidades.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="presu-buscarcargaentidadesing.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="<?php echo "formatos/FMT_CONSOLIDACION_ENTIDADES.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" style="width:29px;height:25px;" title="csv"></a><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='presu-gestionentidades.php'" class="mgbt"/></td>
            </tr>
   		</table>
 		<form name="form2" action="presu-cargaentidadesingresos.php"  method="post" enctype="multipart/form-data" >
 			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if(!$_POST[oculto]){$_POST[pasos]=3;$_POST[oculto]=1; }
   				$vact=$vigusu; 
 			?>		 
	 		<table class="inicio">
      			<tr>
                    <td class="titulos" colspan="9">Cargar Ejecuciones de Entidades Externas - Ejecucion de Ingresos</td>
                    <td class="cerrar" style="width:7%;"><a href="presu-principal.php">&nbsp;Cerrar</a></td>
              	</tr>
      			<tr>
                	<td class="saludo1" style="width:6%;">Trimestre:</td>
                    <td>
						<select name="trimestre" id="trimestre">
    						<option value="">...</option>
							<option value="1" <?php if($_POST[trimestre]=="1"){echo "SELECTED"; } ?> >Enero-Marzo</option>
							<option value="2" <?php if($_POST[trimestre]=="2"){echo "SELECTED"; } ?>>Abril-Junio</option>
							<option value="3" <?php if($_POST[trimestre]=="3"){echo "SELECTED"; } ?> >Julio-Septiembre</option>
							<option value="4" <?php if($_POST[trimestre]=="4"){echo "SELECTED"; } ?>>Octubre-Diciembre</option>
   						</select>
	 				</td>
          			<td class="saludo1" style="width:10%;">Unidad Ejecutora:</td>
	  				<td>
						<select name="cc" onKeyUp="return tabular(event,this)">
    						<option value="">Seleccione...</option>
							<?php
								$sqlr="SELECT * FROM pptouniejecu WHERE estado='S' AND entidad='N'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
									if($row[0]==$_POST[cc]){echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
								}	 	
							?>
   						</select>
	 				</td>
             	</tr>
                <tr>
                	<td class="saludo1" >Fecha: </td>
          			<td>
						<input name="fecha" type="text" id="fecha" title="DD/MM/YYYY" style="width:30%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
					</td>
          		 	<td class="saludo1" style="width:10%;">Archivo (.CSV): </td>
        			<td colspan="2">
                    	<input type="text" name="nomarch" id="nomarch" style="width:90%" value="<?php echo $_POST[nomarch]?>" readonly>
                        <div class='upload' style="float:right;"> 
         					<a href="#" title="Cargar Documento"><input type="file" name="archivotexto" id="archivotexto" value="<?php echo $_POST[archivotexto] ?>" onChange="carnomarchivo();"><img src='imagenes/upload01.png' style="width:18px" title='Cargar Documento'/></a>
                        </div> 
                     </td>
                     <td>
                        <input type="button" name="cargar" value=" Cargar " onClick="cargarotro()">
          				<input type="button" name="protocolo" value="Descargar Protocolo Importacion" onClick="protocolofmt()" >
                  	</td>
       			</tr>                  
    		</table>   
    		<input type="hidden" name="bt" id="bt" value="0"/>
            <input type="hidden" name="gbalance" value="<?php echo $_POST[gbalance]?>"  readonly>
   			<input type="hidden" name="cargabal" value="<?php echo $_POST[cargabal]?>">
    		<input type="hidden" name="oculto" value="<?php echo $_POST[oculto]?>">
    		<div class="subpantalla" style="height:62.5%; width:99.6%; overflow-x:hidden;"> 	
	 		<?php 
				//archivos
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	 			if($_POST[cargabal]==1)
	   			{
		   			$nivel=5;
		   			$digitos=digitosnivelesctas($nivel);
      				if(is_uploaded_file($_FILES['archivotexto']['tmp_name']))
					{
		 				$archivo = $_FILES['archivotexto']['name'];
						$archivoF = "./archivos/$archivo";
						if(move_uploaded_file($_FILES['archivotexto']['tmp_name'],$archivoF))
		 				{	
		 					//echo "El archivo se subio correctamente";
							$mes1=substr($_POST[periodo],1,2);
							$mes2=substr($_POST[periodo],3,2);
							//$_POST[fecha]='01'.'/'.$mes1.'/'.$_POST[vigencias];	
							$_POST[fecha2]=intval(date("t",$mes2)).'/'.$mes2.'/'.$_POST[vigencias];	
		   					$fechab=date('Y-m-d');
							//Borrar el balance de prueba anterior
		 					$cerror=0;
		 					$fich=$archivoF;
							//echo "Archivo: $fich <br>";
							$contenido = fopen($fich,"r+"); 
							$exito=0;
							$errores=0;
							echo "
							<table class='inicio'>
								<tr>
									<td class='titulos'>CUENTA</td>
									<td class='titulos'>INICIAL</td>
									<td class='titulos'>ADICION</td>
									<td class='titulos'>SUPERAVIT</td>
									<td class='titulos'>REDUCCION</td>
									<td class='titulos'>DEFINITIVO</td>
									<td class='titulos'>RECAUDO ANTERIOR</td>
									<td class='titulos'>RECAUDO CONSULTA</td>
									<td class='titulos'>TOTAL RECAUDO</td>
									<td class='titulos'>SALDO POR RECAUDAR</td>
								</tr>";
							$cuentachipno=array(); 	
							$co='saludo1a';
	 						$co2='saludo2';		
	 						$sumdeb=0;
	 						$sumcred=0;
	 						$sqlr="create temporary table precarga (cuenta varchar(20),inicial double,adicion double,superavit double, reduccion double,definitivo double,recaudoant double, recaudocon double, totrecaudo double, saldo varchar(30))";
	  						mysql_query($sqlr,$linkbd);
		 					while(!feof($contenido))
			 				{ 
 								$buffer = fgets($contenido,4096);
			 					$datos = explode(";",$buffer);
			 					$campos=count($datos);
								$tama=strlen($datos[0]);
								//$arrayDatos = explode(",", $linea); 
								//echo "<br>Linea ".implode(';', trim($datos)) ;
								//echo "<br>Linea ".strlen($datos[0])."=$tama ".trim($datos[0])." ".trim($datos[1])." ".trim($datos[2])." ".trim($datos[3])." " ;		
								$sqlr1="select ";
 	 							if($datos[0]!='' && $datos[0]!='CUENTA' && $datos[0]!='Rubro' && $datos[0]!='RUBRO' && $datos[0]!='Ejecucion Presupuestal de Gastos' && $campos==13)
								{
									//echo "<br>Linea ".strlen($datos[0])." ".trim($datos[1])." ".trim($datos[2])." ".trim($datos[3])." " ;
	  		 							$sqlrchip="SELECT cuenta FROM pptocuentasentidad WHERE cuenta='$datos[0]'";
	  		 							$reschip=mysql_query($sqlrchip,$linkbd);
	   									$rowchip=mysql_fetch_row($reschip);
										$msg="";
	   		 							if($rowchip[0]==0)
	   		 							{
											$cuentachipno[]=$datos[0];		
											$msg="<img src='imagenes/alert.png'>CUENTA NO EXISTE";
											$errores+=1;
		      							}
			  							else {$msg="<img src='imagenes/confirm.png'>";$exito+=1;}
			  							//echo "hola";
										$credit=str_replace(",",".",$datos[6]);
										$contracredit=str_replace(",",".",$datos[7]);
			  							//echo ". $credit  - $contracredit .";
											$credito=$datos[5];
											$contracredito=$datos[6];   
											echo "
											<tr class='$co'>
												<td>$msg $datos[0]</td>
												<td> $datos[3]</td>
												<td>$datos[4]</td>
												<td>$datos[5]</td>
												<td>$datos[6]</td>
												<td> $datos[7]</td>
												<td>$datos[8]</td>
												<td>$datos[9]</td>
												<td> $datos[10]</td>
												<td>$datos[11]</td>
											</tr>";  
											$sumcred+=$datos[7];
											$sumdeb+=$contracredito;
											$aux=$co;
											$co=$co2;
											$co2=$aux;
											$sqlr="INSERT INTO precarga (cuenta,inicial,adicion,superavit,reduccion,definitivo,recaudoant,recaudocon , totrecaudo,saldo) VALUES ('$datos[0]', '$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]','$datos[8]','$datos[9]','$datos[10]','$datos[11]')";
	 										mysql_query($sqlr,$linkbd);
											echo "
												<input type='hidden' name='cuentas[]' value='$datos[0]'>
												<input type='hidden' name='inicial[]' value='$datos[3]'>
												<input type='hidden' name='adicion[]' value='$datos[4]'>
												<input type='hidden' name='superavit[]' value='$datos[5]'>
												<input type='hidden' name='reduccion[]' value='$datos[6]'>
												<input type='hidden' name='definitivo[]' value='$datos[7]'>
												<input type='hidden' name='recaudoant[]' value='$datos[8]'>
												<input type='hidden' name='recaudocon[]' value='$datos[9]'>
												<input type='hidden' name='totrecaudo[]' value='$datos[10]'>
												<input type='hidden' name='saldo[]' value='$datos[11]'>";		
		 						}		
 							}
							
	  						echo "<tr><td class='saludo3'>Exitosos: $exito <img src='imagenes/confirm.png'>Errores: $errores <img src='imagenes/alert.png'><input name='finalizar' type='hidden' value='$val'>$errordif</td></table>"; 
	  					}
					}
				}	
				if($_POST[oculto]=='2')
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha1);
					$fechaf=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
	 				for ($i=0;$i<count($_POST[cuentas]);$i++)
					{
						$sqlrdel="DELETE FROM entidadesing WHERE cuenta='".$_POST[cuentas][$i]."' AND vigencia='$vigusu' AND trimestre='$_POST[trimestre]'";
						mysql_query($sqlrdel,$linkbd);
						$sqlr="INSERT INTO entidadesing(cuenta,inicial,adicion,superavit,reduccion,definitivo,recaudoant,recaudocon,recaudotot,saldoporrecaudar,unidad,vigencia,trimestre,fecha) VALUES('".$_POST[cuentas][$i]."','".$_POST[inicial][$i]."','".$_POST[adicion][$i]."','".$_POST[superavit][$i]."','".$_POST[reduccion][$i]."','".$_POST[definitivo][$i]."','".$_POST[recaudoant][$i]."','".$_POST[recaudocon][$i]."','".$_POST[totrecaudo][$i]."','".$_POST[saldo][$i]."','$_POST[cc]','$vigusu','$_POST[trimestre]','$fechaf')";
						mysql_query($sqlr,$linkbd);
					}
					echo "<script>despliegamodalm('visible','1','Se guardo el archivo con Exito ');</script>";
				}
			?>	
  		</div>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
  		</form>
	</body>
</html>