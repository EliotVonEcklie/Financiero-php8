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
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar(){if (confirm("Esta Seguro de Guardar"))
			{document.form2.oculto.value=2; document.form2.cargabal.value=1; document.form2.submit();}}
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
				document.form2.action="formatos/FMT_CONSOLIDACION_ENTIDADES.csv";
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
                <td colspan="3" class="cinta"><a href="presu-agregapresupuesto.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a class="mgbt"><img src="imagenes/buscad.png" title="Buscar" /></a><a href="#" onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="<?php echo "formatos/FMT_CONSOLIDACION_ENTIDADES.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" style="width:29px;height:25px;" title="csv"></a></td>
            </tr>
   		</table>
 		<form name="form2" action="presu-agregapresupuesto.php"  method="post" enctype="multipart/form-data" >
 			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if(!$_POST[oculto]){$_POST[pasos]=3;$_POST[oculto]=1; }
   				$vact=$vigusu; 
 			?>		 
	 		<table class="inicio">
      			<tr>
                    <td class="titulos" colspan="9">Cargar Balances Entidades </td>
                    <td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
              	</tr>
      			<tr>
                	<td class="saludo1" style="width:6%;">Nit:</td>
                    <td style="width:13%;"><input id="tercero" type="text" name="tercero" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();">&nbsp;<a href="#" onClick="despliegamodal2('visible');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
          			<td style="width:25%;" colspan="2"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:98%;" readonly></td>
          			<td class="saludo1" style="width:10%;">Centro Costo:</td>
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
						<input name="fecha" type="text" id="fecha" title="DD/MM/YYYY" style="width:50%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
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
							$_POST[fecha]='01'.'/'.$mes1.'/'.$_POST[vigencias];	
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
									<td class='titulos'>NOMBRE CUENTA</td>
									<td class='titulos'>DEBITO</td>
									<td class='titulos'>CREDITO</td>
								</tr>";
							$cuentachipno=array(); 	
							$co='saludo1a';
	 						$co2='saludo2';		
	 						$sumdeb=0;
	 						$sumcred=0;
	 						$sqlr="create temporary table precarga (cuenta varchar(20),tercero varchar(50),cc varchar(4), detalle varchar(200),debito double,credito double)";
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
 	 							if($datos[0]!='' && $tama==$digitos && $campos==6)
								{
									//echo "<br>Linea ".strlen($datos[0])." ".trim($datos[1])." ".trim($datos[2])." ".trim($datos[3])." " ;
									if(strlen($datos[0])==$digitos)
	 		 						{				 
	  		 							$sqlrchip="SELECT count(*) FROM cuentas WHERE cuenta=$datos[0]";
	  		 							$reschip=mysql_query($sqlrchip,$linkbd);
	   									$rowchip=mysql_fetch_row($reschip);
										//echo "<br>".$sqlrchip;
										$msg="";
	   		 							if($rowchip[0]==0)
	   		 							{
											$cuentachipno[]=$datos[0];		
											$msg="<img src='imagenes/alert.png'>CUENTA NO EXISTE";
											$errores+=1;
		      							}
			  							else {$msg="<img src='imagenes/confirm.png'>";$exito+=1;}
			  							$debi=str_replace(",",".",$datos[3]);
			  							$credi=str_replace(",",".",$datos[4]);	
			  							//echo "$debi  $credi";		  
			  							if($debi>0)
			   							{
											$deb=abs(round($debi,2));   
											$cred=0;	
											echo "
											<tr class='$co'>
												<td>$msg $datos[0]</td>
												<td>$datos[1]</td>
												<td style=''>$deb</td>
												<td>$cred</td>
											</tr>";  
											$sumcred+=$cred;
											$sumdeb+=$deb;
											$aux=$co;
											$co=$co2;
											$co2=$aux;		
											$sqlr="INSERT INTO precarga (cuenta,tercero,cc,detalle,debito,credito) VALUES ('$datos[0]', '$_POST[tercero]','$_POST[cc]','Consolidacion','$deb','$cred')";
	 										mysql_query($sqlr,$linkbd);
											echo "
												<input type='hidden' name='cuentas[]' value='$datos[0]'>
												<input type='hidden' name='debitos[]' value='$deb'>
												<input type='hidden' name='creditos[]' value='$cred'>";
										}
			  							if($credi>0)
										{
											$deb=0;
											$cred=abs(round($credi,2));   
											echo "
											<tr class='$co'>
												<td>$msg $datos[0]</td>
												<td>$datos[1]</td>
												<td style=''>$deb</td>
												<td>$cred</td>
											</tr>";  
											$sumcred+=$cred;
											$sumdeb+=$deb;
											$aux=$co;
											$co=$co2;
											$co2=$aux;
											$sqlr="insert into precarga (cuenta,tercero,cc,detalle,debito,credito) values('".$datos[0]."','".$_POST[tercero]."','".$_POST[cc]."','Consolidacion',".$deb.",".$cred.")";
	 										mysql_query($sqlr,$linkbd);
											echo "
												<input type='hidden' name='cuentas[]' value='".$datos[0]."'>
												<input type='hidden' name='debitos[]' value='$deb'>
												<input type='hidden' name='creditos[]' value='$cred'>";
			    						}
	  								}	
		 						}		
 							}
							echo "
							<tr class='$co'>
								<td></td>
								<td>Total:</td>
								<td>".round($sumdeb,0)."</td>
								<td>".round($sumcred,0)."</td>
							</tr>";
							$dif=round($sumdeb,0)-round($sumcred,0);
							$errordif="";
							if($dif==0 && $cerror==0){$val='S';}
		  					else
		   					{
			 					$val='N';
 								$errordif="<br>Error: Debitos y Creditos deben ser iguales  <img src='imagenes/alert.png'>";
		  					}
	  						echo "<tr><td class='saludo3'>Exitosos: $exito <img src='imagenes/confirm.png'>Errores: $errores <img src='imagenes/alert.png'><input name='finalizar' type='hidden' value='$val'>$errordif</td></table>"; 
	  					}
					}
				}	
				//echo "fin:".$_POST[finalizar]." oc:".$_POST[oculto]; 
				if($_POST[oculto]=='2')
				{
	 				if($_POST[finalizar]=='S' && $_POST[oculto]=='2')
	 				{
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
  						$sqlr="SELECT MAX(numerotipo) FROM comprobante_cab WHERE tipo_comp=19 ";
						$res=mysql_query($sqlr,$linkbd);
						while($r=mysql_fetch_row($res)){$maximo=$r[0];} 
						$maximo+=1;
		 				$co='saludo1';
	 					$co2='saludo2';
	 					//$sqlr="select *from precarga ";
	 					//$res=mysql_query($sqlr,$linkbd);
	 					//if(!$res)
						//echo "errorrororoorooror".mysql_error($linkbd);
	 					echo "
						<table class='inicio'>
							<tr>
								<td class='titulos'>CUENTA</td>
								<td class='titulos'>NOMBRE CUENTA</td>
								<td class='titulos'>TERCERO</td>
								<td class='titulos'>CC</td>
								<td class='titulos'>DEBITO</td>
								<td class='titulos'>CREDITO</td>
							</tr>";
	 					//while($row=mysql_fetch_row($res))
						$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($maximo,19,'$fechaf','CONSOLIDACION ENTIDAD $_POST[tercero]',0,0,0,0,'1')";
						if (mysql_query($sqlr,$linkbd))
						{
							//echo "<br>".$sqlr;
							$containse=0;
							$contanoinse=0;
	 						for($x=0;$x<count($_POST[cuentas]);$x++)
	 	 					{
								//echo "<tr class='$co'><td> $row[0]</td><td>$row[1]</td><td style=''>$row[4]</td><td>$row[5]</td></tr>";  
		 						echo "
								<tr class='$co'>
									<td>".$_POST[cuentas][$x]."</td>
									<td>".existecuenta($_POST[cuentas][$x])."</td>
									<td>$_POST[tercero]</td>
									<td>$_POST[cc]</td>
									<td style=''>".$_POST[debitos][$x]."</td>
									<td>".$_POST[creditos][$x]."</td>
								</tr>"; 
		 						$aux=$co;
	    						$co=$co2;
	     						$co2=$aux; 
		  						$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) VALUES ('19 $maximo','".$_POST[cuentas][$x]."','$_POST[tercero]','$_POST[cc]','CONSOLIDADO ','',".$_POST[debitos][$x].",".$_POST[creditos][$x].",'1','$vigusu')";
		  						if(!mysql_query($sqlr,$linkbd)){echo "<br>".mysql_error($linkbd);$contanoinse+=1;}
								else{$containse+=1;}
	  						}
						}
						else
		 				{
							echo "<table><tr><td class='saludo1'><center>NO Se ha almacenado el Comprobante con Exito:".mysql_error($linkbd)."<img src='imagenes/alert.png'></center></td></tr></table>";	 
		 				}	 
	 					echo "</table>";
	 					echo "<div class='saludo3'>Exitosos: $containse <img src='imagenes/confirm.png'>   Errores: $contanoinse <img src='imagenes/alert.png'></div>"; 
	 				}
	 				else
	 				{
						echo "<DIV class='SALUDO3'>NO SE PUEDE GUARDAR EL DOCUMENTO - VERIFIQUE LOS ERRORES  <img src='imagenes/alert.png'></DIV>"; 
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
	</body>
</html