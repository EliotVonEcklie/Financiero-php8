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
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value='1';
 					document.form2.submit();
 				}
 			}
			function buscatercero(e)
 			{
				if (document.form2.tercero.value!="")
				{
 					document.form2.bc.value='1';
 					document.form2.submit();
 				}
 			}
			function guardar()
			{
				if (document.form2.fecha.value!='' ){despliegamodalm('visible','4','Esta Seguro de Guardar','2');}
  				else
				{
  					despliegamodalm('visible','2','Faltan datos para completar el registro');
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
 				}
			}
			function pdf()
			{
				document.form2.action="pdfreporegresos.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=cc";
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	//document.getElementById('valfocus').value='';
									document.getElementById('vigencias').focus();
									//document.getElementById('tercero').select();
									break;
						case "2":	//document.getElementById('banco').value='';
									document.getElementById('vigencias').focus();
									//document.getElementById('banco').select();
					}
				}
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
			function despliegamodal3(_valor,pos)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="cont-codigosinternosexogena-ventana.php?pos="+pos;}
			}
			function funcionmensaje()
			{
				//var numdocar=document.getElementById('idcomp').value;
				//document.location.href = "teso-exogena1001.php";
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value='2';
								document.form2.submit();
								break;
					case "2":	document.form2.oculto.value='2';
								document.form2.submit();
								break;
				}
			}
			function excell()
			{
				document.form2.action="teso-exogena1001excel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell2276()
			{
				document.form2.action="teso-exogena2276excel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
 				<td colspan="3" class="cinta"><a onClick="location.href='teso-exogena1001.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt" onClick="guardar()" ><img src="imagenes/guarda.png" title="Guardar" /></a><a class="mgbt" onClick="location.href='teso-buscaexogena1001.php'"><img src="imagenes/busca.png" title="Buscar" /></a><a class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a class="mgbt" onClick="pdf()"><img src="imagenes/print.png" title="imprimir" style="width:29px;height:25px;"/></a><a class="mgbt" onClick="location.href='<?php echo "archivos/".$_SESSION[usuario]."-reporteegresosexogena.csv"; ?>'" ><img src="imagenes/csv.png" title="csv" style="width:26px;height:25px;"/></a><a class="mgbt" onClick="excell();"><img src="imagenes/excel.png" title="Exogena 1001" style='width:24px;height:24px;'></a><a href="teso-buscaexogena1001.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
        	</tr>	
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="">
        	<input type="hidden" name="ordestados" id="ordestados" value="<?php echo $_POST[ordestados];?>"/>
 			<?php
 				if($_POST[oculto]=="")
 				{
					
 					$sqlr="select * from exogena_cab where id_exo='$_GET[idexo]'";
 					$resp=mysql_query($sqlr,$linkbd);
 					$row=mysql_fetch_row($resp);
 					$_POST[idexo]=$row[0];
 					$_POST[fecha]=$row[1];
  					$_POST[vigencias]=$row[2];
					$_POST[concepto]=$row[3];
 					$sqlr="select * from exogena_det where id_exo=$_GET[idexo] ORDER BY tercero";
					$resp=mysql_query($sqlr,$linkbd);
 					while($row=mysql_fetch_row($resp))
					{
	 					$_POST[conexogena][]=$row[1];
						$_POST[egresos][]=$row[2];
						$_POST[ordenes][]=$row[3];
						$_POST[fechas][]=$row[4];	 
						$_POST[terceros][]=$row[5];
						$_POST[nterceros][]=buscatercero($row[5]);
						$_POST[conceptos][]=$row[6];	 
						$_POST[valoresb][]=$row[7];	 	 	 	 	 	 
						$_POST[valores][]=$row[8];
						$_POST[valoresiv][]=$row[9];	 
						$_POST[estados][]=$row[10];	 
					}
 				}
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				$vact=$vigusu; 
 				//echo "vig:".$_POST[vigencias];
 				if($_POST[bc]=='1')
				{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!=''){$_POST[ntercero]=$nresul;}
			 		else {$_POST[ntercero]="";}
			 	}
 			?>
			<table  class="inicio" align="center" >
      			<tr >
        			<td class="titulos" colspan="8">:. Formato Exogena 1001</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
 				<tr>
                    <td class="saludo1" style="width:2.5cm;">No Exogena:</td>
                    <td style="width:8%"><input type="text" id="idexo" name="idexo" value="<?php echo $_POST[idexo]?>" style="width:100%" readonly></td>
                    <td class="saludo1"  style="width:2cm;">Fecha:</td>
                    <td style="width:10%"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:100%;" readonly></td>
                    <td class="saludo1"  style="width:2cm;">Concepto:</td>
                    <td style="width:30%"><input type="text" id="concepto" name="concepto" value="<?php echo $_POST[concepto]?>" style="width:100%" readonly/></td>
                    <td class="saludo1" style="width:3.5cm;">Vigencia Exogena:</td>
                    <td><input type="text" name="vigencias" id="vigencias" value="<?php echo $_POST[vigencias];?>" style="width:50%;" readonly/></td>
                    <input type="hidden" name="oculto" id="oculto" value="1">
            	</tr>                    
				<?php 
					if($_POST[bc]=='1')
			 		{
			  			$nresul=buscatercero($_POST[tercero]);
			 	 		if($nresul!='')
			   			{
			  				$_POST[ntercero]=$nresul;
  			  				echo "<script>document.form2.fecha.focus();document.form2.fecha.select();</script>";
			 			}
			 			else
						{
			  				$_POST[ntercero]="";
			 				echo"<script>alert('Tercero Incorrecta');document.form2.tercero.focus();</script>";
			  			}
			 		}
			 	?>
			</table>  
    		<div class="subpantallap" style="height:68%;overflow-x:hidden;">
      			<?php	  
					$oculto=$_POST['oculto'];
					$con=1;
					$namearch="archivos/".$_SESSION[usuario]."-reporteegresosexogena.csv";
					$namearch2="archivos/fmt1001_".$_POST[vigencias].".csv";
					$Descriptor1 = fopen($namearch,"w+"); 
					$Descriptor2 = fopen($namearch2,"w+"); 
					fputs($Descriptor1,"CONCEPTO;TIPODOC;Doc Tercero;DV;FECHA;CHEQUE;VALOR;VALOR PAGO;CONCEPTO;ESTADO\r\n");
					//fputs($Descriptor2,"CONCEPTO;TIPODOC;Doc Tercero;DV;FECHA;CHEQUE;VALOR;VALOR PAGO;CONCEPTO;ESTADO\r\n");
					fputs($Descriptor2,"Concepto;Tipo de documento;N�mero identificaci�n del informado;DV;Primer apellido del informado;Segundo apellido del informado;Primer nombre del informado;Otros nombres del informado;Raz�n social informado;Direcci�n;C�digo dpto;C�digo mcp;Pa�s de residencia o domicilio;Pago o abono en cuenta deducible;Pago o abono en cuenta no deducible;Iva mayor valor del costo o gasto deducible;Iva mayor valor del costo o gasto no deducible;Retenci�n en la fuente practicada en renta;Retenci�n en la fuente asumida en renta;Retenci�n en la fuente practicada IVA r�gimen com�n;Retenci�n en la fuente asumida  IVA r�gimen simplificado;Retenci�n en la fuente practicada IVA no domiciliados;Retenci�n en la fuente practicadas CREE;Retenci�n en la fuente asumidas CREE\r\n");
					echo "
					<table class='inicio' align='center' >
					<tr><td colspan='11' class='titulos'>.: Resultados Busqueda:</td></tr>
					<tr><td colspan='11' class='saludo3'>Pagos Encontrados: ".($ntr+$ntr2+$ntr3+$ntr4)."</td></tr>
					<tr>
						<td  class='titulos2'>CONCEPTO</td>
						<td  class='titulos2'>EGRESO</td>
						<td  class='titulos2'>ORDEN</td>
						<td class='titulos2'>DOC TERCERO</td>
						<td class='titulos2'>TERCERO</td>
						<td class='titulos2'>FECHA</td>
						<td class='titulos2'>VALOR</td>
						<td class='titulos2'>Retencion en la Fuente</td>
						<td class='titulos2'>Rete IVA</td>
						<td class='titulos2'>Descripcion</td>
						<td class='titulos2' width='3%'><center>Estado</td>
					</tr>";	
					$iter='zebra11';
					$iter2='zebra22';
					//echo "t:".count($_POST[conexogena]);
 					for($x=0;$x<count($_POST[conexogena]);$x++) 
 					{
						//$ntr=buscatercero($row[11]);
						echo "
						<tr class='$iter'>
							<td ><input type='text' name='conexogena[]' value='".$_POST[conexogena][$x]."' size='4' onDblClick='despliegamodal3(\"visible\",$x)'></td>
							<td ><input type='hidden' name='egresos[]' value='".$_POST[egresos][$x]."'>".$_POST[egresos][$x]."</td>
							<td ><input type='hidden' name='ordenes[]' value='".$_POST[ordenes][$x]."'>".$_POST[ordenes][$x]."</td>
							<td ><input type='hidden' name='terceros[]' value='".$_POST[terceros][$x]."'>".$_POST[terceros][$x]."</td>
							<td ><input type='hidden' name='nterceros[]' value='".$_POST[nterceros][$x]."'>".$_POST[nterceros][$x]."</td>
							<td ><input type='hidden' name='fechas[]' value='".$_POST[fechas][$x]."'>".$_POST[fechas][$x]."</td>
							<td ><input type='hidden' name='valoresb[]' value='".$_POST[valoresb][$x]."'>".number_format($_POST[valoresb][$x],2)."</td>
							<td ><input type='hidden' name='valores[]' value='".$_POST[valores][$x]."'>".number_format($_POST[valores][$x],2)."</td>
							<td ><input type='hidden' name='valoresiv[]' value='".$_POST[valoresiv][$x]."'>".number_format($_POST[valoresiv][$x],2)."</td>
							<td ><input type='hidden' name='conceptos[]' value='".$_POST[conceptos][$x]."'>".strtoupper($_POST[conceptos][$x])."</td>
							<td ><input type='hidden' name='estados[]' value='".$_POST[estados][$x]."'>".strtoupper($_POST[estados][$x])."</td>
						</tr>";
						//fputs($Descriptor1,$row4[0].";".$row4[0].";".$row4[1].";".$ntr.";".$row4[10].";".$row4[3]."; ".number_format($row4[5],2,".","")."; ".number_format($row4[5],2,".","").";".strtoupper("PAGO VIG ANTERIOR".$row4[7]).";".strtoupper($row4[9])."\r\n");
  						$aux=$iter;
	 					$iter=$iter2;
	 					$iter2=$aux;
					}
 					fclose($Descriptor1);
					echo"</table>";
					if($_POST[oculto]==2 || $_POST[oculto]==3)
					{
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						//$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$fechaf=$_POST[fecha];
						$sqlr="delete from exogena_cab where id_exo=$_POST[idexo]";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into exogena_cab (id_exo,fecha,vigencia,descripcion,estado) values ($_POST[idexo],'$fechaf', '$_POST[vigencias]','$_POST[concepto]','S')";
						if(mysql_query($sqlr,$linkbd))
						{
							//$id=mysql_insert_id($linkbd);
							$sqlr="delete from exogena_det where id_exo=$_POST[idexo]";
							mysql_query($sqlr,$linkbd);
	 						echo"<script>despliegamodalm('visible','3','Se ha almacenado La Exogena con Exito');</script>";
	 						$conta=count($_POST[conexogena]);
	 						for($x=0;$x<$conta;$x++)
	 						{
	  							$sqlr="insert into exogena_det (id_exo, concepto, id_egre, id_cxp, fecha, tercero, detalle, valor, retefte,reteiva, tipoegre) values ($_POST[idexo],'".$_POST[conexogena][$x]."','".$_POST[egresos][$x]."','".$_POST[ordenes][$x]."','".$_POST[fechas][$x]."','".$_POST[terceros][$x]."','".$_POST[conceptos][$x]."','".$_POST[valoresb][$x]."','".$_POST[valores][$x]."','".$_POST[valoresiv][$x]."','".$_POST[estados][$x]."')";
	  							mysql_query($sqlr,$linkbd);
	 						}
	   						if($_POST[oculto]==3)
	   						{
	    						$sqlr="select distinct concepto,tercero,sum(valor),sum(retefte),sum(reteiva) from exogena_det where id_exo=$_POST[idexo] group by concepto,tercero order by concepto,tercero";
								$resp=mysql_query($sqlr,$linkbd);
								while($row=mysql_fetch_row($resp))
								{
		 							$sqlrt="select *from terceros where cedulanit=$row[1]";
		 							$rest=mysql_query($sqlrt,$linkbd);
		 							$rowt=mysql_fetch_row($rest);
									fputs($Descriptor2,$row[0].";".$rowt[11].";".$rowt[12].";".$rowt[13].";".$rowt[3].";".$rowt[4].";".$rowt[1].";".$rowt[2].";".$rowt[5].";".$rowt[6].";".$rowt[14].";".$rowt[15].";169;0;".$row[2].";0;0;".$row[3].";0;".$row[4].";0;0;0;0\r\n");
		 							//***Concepto	Tipo de documento	N�mero identificaci�n del informado	DV	Primer apellido del informado	Segundo apellido del informado	Primer nombre del informado	Otros nombres del informado	Raz�n social informado	Direcci�n	C�digo dpto.	C�digo mcp	Pa�s de residencia o domicilio	Pago o abono en cuenta deducible	 Pago o abono en cuenta no deducible 	 Iva mayor valor del costo o gasto deducible 	 Iva mayor valor del costo o gasto no deducible 	 Retenci�n en la fuente practicada en renta 	 Retenci�n en la fuente asumida en renta 	 Retenci�n en la fuente practicada IVA r�gimen com�n 	 Retenci�n en la fuente asumida  IVA r�gimen simplificado 	 Retenci�n en la fuente practicada IVA no domiciliados 	" Retenci�n en la fuente practicadas CREE "	" Retenci�n en la fuente asumidas CREE "
								}
	   						}		 
						}
						else {echo"<script>despliegamodalm('visible','2','Ya Se ha almacenado un documento con ese consecutivo');</script>";}
					}
				?>
                <div id="bgventanamodal2">
                    <div id="ventanamodal2">
                        <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                        </IFRAME>
                    </div>
                </div>	
            </div>
		</form>
	</body>
</html>