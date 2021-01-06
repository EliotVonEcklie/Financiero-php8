<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idplano'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID- Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function guardar()
			{
				if (document.form2.fecha.value!='' && document.form2.idcomp.value!='' )
  				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
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
			function funcionmensaje()
			{
				var numdocar=document.getElementById('idcomp').value;
				document.location.href = "teso-recibocajaver.php?idrecibo="+numdocar;
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
		</script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('idcomp').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('idcomp').value=next;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="teso-planosmasivo.php?idplano="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('idcomp').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('idcomp').value=prev;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="teso-planosmasivo.php?idplano="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('idcomp').value;
				location.href="teso-planosbusca.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=22*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a onClick="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a> 
					<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a> 
					<a class="mgbt" href="teso-planosbusca.php'"><img src="imagenes/busca.png"  title="Buscar" /></a> 
					<a class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
					<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" class="mgbt"></a>
				</td>
			</tr>		  
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			if ($_GET[idplano]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idplano];</script>";}
			$sqlr="select MIN(numero), MAX(numero) from tesoplanos ORDER BY numero";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idplano]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from tesoplanos where numero='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from tesoplanos where numero ='$_GET[idplano]'";
					}
				}
				else{
					$sqlr="select * from  tesoplanos ORDER BY numero DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[idcomp]=$row[0];
			}

			if(!$_POST[oculto])
			{
				$sqlr="Select *from tesoplanos where numero='$_POST[idcomp]'";
				$res=mysql_query($sqlr,$linkbd);
				//echo $sqlr;
				while($row=mysql_fetch_row($res))
				{
					$_POST[idcomp]=$row[0];
					$_POST[fecha]=$row[1];
					$_POST[vigencia]=$row[2];
					$_POST[convenio]=$row[3];
					$_POST[banco]=$row[4];
					$_POST[nbanco]=$row[5];
					$_POST[concepto]=$row[6];
					$_POST[numreg]=$row[9];
					$_POST[fecarc]=$row[10];
					$_POST[modlec]=$row[11];
					$_POST[valtot]=$row[8];
				}
			$sqld="Select tesoplanos_det.*, CONCAT(terceros.nombre1, ' ', terceros.nombre2, ' ', terceros.apellido1, ' ', terceros.apellido2, ' ', terceros.razonsocial) from tesoplanos_det left join terceros on tesoplanos_det.tercero=terceros.cedulanit where tesoplanos_det.plano='$_POST[idcomp]'";
				$resd=mysql_query($sqld,$linkbd);
				//echo $sqlr;
				while($wdet=mysql_fetch_row($resd)){
					$_POST[tpreg][]=$wdet[4];
					$_POST[fecrec][]=$wdet[2];
					$_POST[horec][]=$wdet[3];
					$_POST[nitpag][]=$wdet[6];
					$_POST[nompag][]=$wdet[9];
					$_POST[codliq][]=$wdet[7];
					$_POST[ref2][]=$wdet[8];
					$_POST[valrec][]=$wdet[5];
				}
			//PARAMETROS GRALES
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
					$_POST[cuentacaja]=$row[0];
				}
				$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
	 				$_POST[cobrorecibo]=$row[0];
	 				$_POST[vcobrorecibo]=$row[1];
	 				$_POST[tcobrorecibo]=$row[2];	 
				}
			}
			//NEXT
			$sqln="select *from tesoplanos WHERE numero > '$_POST[idcomp]' ORDER BY numero ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from tesoplanos WHERE numero < '$_POST[idcomp]' ORDER BY numero DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
		?>
 		<form name="form2" method="post" action="" enctype="multipart/form-data"> 
			<input type="hidden" name="vguardar" id="vguardar" value="">
 			<input name="encontro" type="hidden" value="<?php echo $_POST[encontro]?>" >
            <input name="cobrorecibo" type="hidden" value="<?php echo $_POST[cobrorecibo]?>" >
            <input name="vcobrorecibo" type="hidden" value="<?php echo $_POST[vcobrorecibo]?>" >
            <input name="tcobrorecibo" type="hidden" value="<?php echo $_POST[tcobrorecibo]?>" > 
            <input name="codcatastral" type="hidden" value="<?php echo $_POST[codcatastral]?>" >
           	<input type="hidden" name="cuentacaja"  value="<?php echo $_POST[cuentacaja]?>"/>
           	<input type="hidden" name="cuotas"  value="<?php echo $_POST[cuotas]?>"/>
           	<input type="hidden" name="tcuotas"  value="<?php echo $_POST[tcuotas]?>"/>
           	<input type="hidden" name="tercero"  value="<?php echo $_POST[tercero]?>"/>
    		<table class="inicio" style="width:99.7%;">
      			<tr >
        			<td class="titulos" colspan="7">Base Recaudo Bancos</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:2cm;">No Recaudo:</td>
        			<td style="width:20%;">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                        <input type="text" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this)" style="width:60%;" readonly />
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                   	</td>
	  				<td class="saludo1" style="width:2.5cm;">Fecha: </td>
        			<td style="width:18%;">
						<input type="text" name="fecha" value="<?php echo $_POST[fecha]?>" maxlength="10" style="width:80%;" readonly />&nbsp;
					</td>
        			<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
		  			<td style="width:12%;"><input type="text" id="vigencia" name="vigencia" style="width:100%;" readonly></td>
          			<td rowspan="6" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>        
        		</tr>
      			<tr>
        			<td class="saludo1" style="width:2.5cm;">Modo de Lectura:</td>
                    <td>
						<select id="modlec" name="modlec" onKeyUp="return tabular(event,this)" style="width:80%;" disabled >
         					<option value="1" <?php if($_POST[modlec]=='1') echo "SELECTED"; ?>>Archivo Plano</option>
          					<option value="2" <?php if($_POST[modlec]=='2') echo "SELECTED"; ?>><?php echo utf8_decode('Código de Barras') ?></option>
        				</select>
					</td>
					<?php
					echo'<td class="saludo1">Recaudado en:</td>
					<td>
						<input type="text" id="nbanco" name="nbanco" value="'.$_POST[nbanco].'" style="width:100%;" readonly>
					</td>
					<td class="saludo1">Cuenta:</td>
					<td>
						<input type="text" id="banco" name="banco" value="'.$_POST[banco].'" style="width:100%;" readonly>
					</td>';
					?>
               	</tr>
				<tr>
					<td class='saludo1'>Tipo:</td>
                    <td>
						<input type='text' id='tpcta' name='tpcta' value='<?php echo $_POST[tpcta]; ?>' style='width:100%;' readonly>
                   	</td>
					<td class='saludo1'>Convenio:</td>
                    <td>
						<input type='text' id='convenio' name='convenio' value='<?php echo $_POST[convenio]; ?>' style='width:100%;' readonly>
                   	</td>
					<td class='saludo1'>No. Registros:</td>
                    <td>
						<input type='text' id='numreg' name='numreg' value='<?php echo $_POST[numreg]; ?>' style='width:100%; text-align:center;' readonly>
                   	</td>
				</tr>
				<tr>
                	<td class="saludo1">Fecha Archivo:</td>
                    <td>
						<input type="text" name="fecarc" value="<?php echo $_POST[fecarc] ?>" style="width:100%;" readonly>
					</td>
                	<td class="saludo1">Valor Total:</td>
                    <td>
						<input type="text" name="valtot" value="<?php echo number_format($_POST[valtot],2,',','.') ?>" style="width:100%; text-align:right;" readonly>
					</td>
				</tr>
	  			<tr>
                	<td class="saludo1">Concepto:</td>
                    <td colspan="5">
						<input type="text" name="concepto" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly>
					</td>
	  			</tr>
      		</table>
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto] ?>"/>
			<input type="hidden" name="trec" value="<?php echo $_POST[trec]?>"/>
	    	<input type="hidden" name="agregadet" value="0"/>
     		<div class="subpantallac7"  style="height:61.3%; width:99.6%; overflow-x:hidden;" id="divdet">
	   			<table class="inicio">
	   	  			<tr><td colspan="7" class="titulos">Detalle Recaudos</td></tr>                  
					<tr>
                    	<td class="titulos2" style="width:5%;">No.</td>
                        <td class="titulos2">Fecha</td>
                        <td class="titulos2">Nit</td>
                        <td class="titulos2">Nombre Pagador</td>
                        <td class="titulos2">Referencia 1</td>
                        <td class="titulos2">Referencia 2</td>
                        <td class="titulos2" style="width:20%;">Valor Recaudado</td>
                  	</tr>
					<?php
		  				'".$_POST[valrec][$f]."'=0;
						$co="saludo1a";
		  				$co2="saludo2";
		 				for ($x=0;$x<count($_POST[codliq]);$x++)
		 				{		 
		 					echo "
							<input type='hidden' name='tpreg[]' value='".$_POST[tpreg][$x]."'>
							<input type='hidden' name='fecrec[]' value='".$_POST[fecrec][$x]."'>
							<input type='hidden' name='nitpag[]' value='".$_POST[nitpag][$x]."'>
							<input type='hidden' name='nompag[]' value='".$_POST[nompag][$x]."'>
							<input type='hidden' name='horec[]' value='".$_POST[horec][$x]."'>
							<input type='hidden' name='codliq[]' value='".$_POST[codliq][$x]."'>
							<input type='hidden' name='ref2[]' value='".$_POST[ref2][$x]."'>
							<input type='hidden' name='valrec[]' value='".$_POST[valrec][$x]."'>
							<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								<td>".($x+1)."</td>
								<td>".$_POST[fecrec][$x]."</td>
								<td>".$_POST[nitpag][$x]."</td>
								<td>".$_POST[nompag][$x]."</td>
								<td>".$_POST[codliq][$x]."</td>
								<td>".$_POST[ref2][$x]."</td>
								<td style='text-align:right;'>$ ".number_format($_POST[valrec][$x],2,',','.')."</td>
							</tr>";
		 					'".$_POST[valrec][$f]."'='".$_POST[valrec][$f]."'+$_POST[valrec][$x];
		 					$_POST[totalcf]=number_format('".$_POST[valrec][$f]."',2);
							$totalg=number_format('".$_POST[valrec][$f]."',2,'.','');
							$aux=$co;
							$co=$co2;
							$co2=$aux;
		 				}
						if ('".$_POST[valrec][$f]."'!='' && '".$_POST[valrec][$f]."'!=0){$_POST[letras] = convertirdecimal($totalg,'.');}
						else{$_POST[letras]=''; $_POST[totalcf]=0;}
		 				echo "
						<input type='hidden' name='totalcf' value='$_POST[totalcf]'>
						<input type='hidden' name='totalc' value=''".$_POST[valrec][$f]."''>
						<input type='hidden' name='letras' value='$_POST[letras]'>
						<tr class='$titulos2' style='text-align:right;'>
							<td colspan='6'>Total</td>
							<td>$ $_POST[totalcf]</td>
						</tr>
						<tr class='titulos2'>
							<td>Son:</td>
							<td colspan='6'>$_POST[letras]</td>
						</tr>";
					?> 
	   			</table>
         	</div>
	  		<?php
				if($_POST[oculto]=='5'){
	 				for ($f=0;$f<count($_POST[codliq]);$f++)
	 				{
						//APLICAR VALOR PARA VARIABLE ENCONTRO
						switch($_POST[ref2][$f]) 
						{
							case 1:	$sqlr="select * from tesoliquidapredial where tesoliquidapredial.idpredial='".$_POST[codliq][$f]."' and estado ='S' and '1'='".$_POST[ref2][$f]."'";
  								//echo "$sqlr";
  	 							$_POST[encontro]=0;
	  							$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
	 							{
									$_POST[codcatastral]=$row[1];		
									if($_POST[concepto]==""){$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1].' '.$row[19].' '.$row[20];}	
									$_POST[valorecaudo]=$row[8];		
									'".$_POST[valrec][$f]."'=$row[8];	
									$_POST[tercero]=$row[4];	
									$_POST[ntercero]=buscatercero($row[4]);
									if ($_POST[ntercero]=='')
		 							{
		  								$sqlr2="select *from tesopredios where cedulacatastral='$row[1]' and ord='$row[19]' and tot='$row[20]'";
		  								$resc=mysql_query($sqlr2,$linkbd);
		  								$rowc =mysql_fetch_row($resc);
		   								$_POST[ntercero]=$rowc[6];
		 							}	
	  								$_POST[encontro]=1;
								}
	  							break;
							case 2:	
								$sqlr="select *from tesoindustria where tesoindustria.id_industria='".$_POST[codliq][$f]."' and estado ='S' and '2'='".$_POST[ref2][$f]."'";
  								//echo "$sqlr";
							  	$_POST[encontro]=0;
							  	$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									if($_POST[concepto]==""){$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - ".$row[3];}	
									$_POST[valorecaudo]=$row[6];		
									'".$_POST[valrec][$f]."'=$row[6];	
									$_POST[tercero]=$row[5];	
									$_POST[ntercero]=buscatercero($row[5]);	
									$_POST[encontro]=1;
									$_POST[cuotas]=$row[9]+1;
									$_POST[tcuotas]=$row[8];
								}
	  							break;
							case 3:	
								$sqlr="select *from tesorecaudos where tesorecaudos.id_recaudo='".$_POST[codliq][$f]."' and estado ='S' and '3'='".$_POST[ref2][$f]."'";
  								//echo "$sqlr";
  	  							$_POST[encontro]=0;
	  							$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
	 							{
	  								if($_POST[concepto]==""){$_POST[concepto]=$row[6];	}
	  								$_POST[valorecaudo]=$row[5];		
	  								'".$_POST[valrec][$f]."'=$row[5];	
	  								$_POST[tercero]=$row[4];	
	  								$_POST[ntercero]=buscatercero($row[4]);	
	  								$_POST[encontro]=1;
	 							}
								break;	
						}
						//FIN ENCONTRO
						//GENERAR ARREGLOS PARA RECIBO DE CAJA
						if($_POST[encontro]=='1')
						{
							switch($_POST[ref2][$f]) 
							{
								case 1: //********PREDIAL
									$sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial='".$_POST[codliq][$f]."' and estado ='S'  and '1'='".$_POST[ref2][$f]."'";
									$_POST[dcoding]= array(); 		 
									$_POST[dncoding]= array(); 		 
									$_POST[dvalores]= array(); 	
									$_POST[trec]='PREDIAL';
									if($_POST[tcobrorecibo]=='S')
									{	 
										$_POST[dcoding][]=$_POST[cobrorecibo];
										$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
										$_POST[dvalores][]=$_POST[vcobrorecibo];
									}
									$res=mysql_query($sqlr,$linkbd);
									//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
									while ($row =mysql_fetch_row($res)) 
									{
										$vig=$row[1];
										if($vig==$vigusu)
										{
											$sqlr2="select * from tesoingresos where codigo='01'";
											$res2=mysql_query($sqlr2,$linkbd);
											$row2 =mysql_fetch_row($res2); 
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;			 		
											$_POST[dvalores][]=$row[11];		 
											//	echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
										}
										else
										{	
											$sqlr2="select * from tesoingresos where codigo='03'";
											$res2=mysql_query($sqlr2,$linkbd);
											$row2 =mysql_fetch_row($res2); 
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;			 		
											$_POST[dvalores][]=$row[11];		
										}
									}  
								break;
								case 2: //***********INDUSTRIA Y COMERCIO
									$_POST[dcoding]= array(); 		 
									$_POST[dncoding]= array(); 		 
									$_POST[dvalores]= array(); 	
									$_POST[trec]='INDUSTRIA Y COMERCIO';	 
									if($_POST[tcobrorecibo]=='S')
									{	 
										$_POST[dcoding][]=$_POST[cobrorecibo];
										$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
										$_POST[dvalores][]=$_POST[vcobrorecibo];
									}
									$sqlr="select *from tesoindustria where tesoindustria.id_industria='".$_POST[codliq][$f]."' and estado ='S' and '2'='".$_POST[ref2][$f]."'";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										$sqlr2="select * from tesoingresos where codigo='02' ";
										$res2=mysql_query($sqlr2,$linkbd);
										$row2 =mysql_fetch_row($res2);
										$_POST[dcoding][]=$row2[0];
										$_POST[dncoding][]=$row2[1];			 		
										$_POST[dvalores][]=$row[6]/$_POST[tcuotas];		
									}
								break;
								case 3: ///*****************otros recaudos *******************
									$_POST[trec]='OTROS RECAUDOS';	 
									$_POST[dcoding]= array(); 		 
									$_POST[dncoding]= array(); 		 
									$_POST[dvalores]= array(); 
									if($_POST[tcobrorecibo]=='S')
									{	 
										$_POST[dcoding][]=$_POST[cobrorecibo];
										$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
										$_POST[dvalores][]=$_POST[vcobrorecibo];
									}
									$sqlr="select *from tesorecaudos_det where tesorecaudos_det.id_recaudo='".$_POST[codliq][$f]."' and estado ='S'  and '3'='".$_POST[ref2][$f]."'";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										$_POST[dcoding][]=$row[2];
										$sqlr2="select nombre from tesoingresos where codigo='".$row[2]."'";
										$res2=mysql_query($sqlr2,$linkbd);
										$row2 =mysql_fetch_row($res2); 
										$_POST[dncoding][]=$row2[0];			 		
										$_POST[dvalores][]=$row[3];		 	
									}
								break;
							}
						}
		 				for ($x=0;$x<count($_POST[dcoding]);$x++)
		 				{		 
		 					echo "<input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."'>
							<input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."'>
							<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'>";
		 				}
						//FIN GENERAR
						//************VALIDAR SI YA FUE GUARDADO ************************
						switch($_POST[ref2][$f]) 
  	 					{
	 						case 1://***** PREDIAL *****************************************
	 							$sqlr="select count(*) from tesoreciboscaja where id_recaudo='".$_POST[codliq][$f]."' and tipo='1' ";
								$res=mysql_query($sqlr,$linkbd);
								//echo $sqlr;
								while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
	  							if($numerorecaudos<=0)
	   							{ 	
									$cuentacb=$_POST[banco];				
									$cajas="";
									$cbancos=$_POST[banco];
		     						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecrec][$f],$fecha);
			  						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	   								$sqlr="insert into tesoreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor, estado,tipo,descripcion) values('0','$fechaf','$vigusu','".$_POST[codliq][$f]."','banco','','$cbancos','".$_POST[valrec][$f]."','S', '".$_POST[ref2][$f]."','$_POST[concepto]')";	  
									if (!mysql_query($sqlr,$linkbd))
									{
	 									$e =mysql_error(mysql_query($sqlr,$linkbd));
                                		echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: $e');</script>";
									}
  									else
  		 							{
		 								$concecc=mysql_insert_id();
		  								$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito, total_credito,diferencia,estado) values($concecc,16,'$fechaf','RECIBO DE CAJA',$_POST[vigencia],0,0,0,1)";
	 	  								mysql_query($sqlr,$linkbd);	
		 							}
	   								//************ insercion de cabecera recaudos ************
									echo "<input type='hidden' name='concec' value='$concecc'>";	
									echo "<script>
											despliegamodalm('visible','1','>Se ha almacenado el Recibo de Caja con Exito');
											document.form2.vguardar.value='1';
											
										</script>";
		  							$sqlr="update tesoliquidapredial set estado='P' WHERE idpredial='".$_POST[codliq][$f]."'";
		  							mysql_query($sqlr,$linkbd);
		  							$sqlr="Select *from tesoliquidapredial_det where idpredial='".$_POST[codliq][$f]."'";
		  							$resq=mysql_query($sqlr,$linkbd);
		  							//echo "<br>$sqlr";
		  							while($rq=mysql_fetch_row($resq))
 		  							{
		   								$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE   idpredial='".$_POST[codliq][$f]."') AND vigencia=$rq[1]";
		   								mysql_query($sqlr2,$linkbd);
		   								//  echo "<br>$sqlr2";
		  							}
		 							echo"
		  							<script>
		  								document.form2.numero.value='';
		  								document.form2.valor.value=0;
		  							</script>";
									//**********************CREANDO COMPROBANTE CONTABLE ********************************	 
	 								$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito, diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,'".$_POST[valrec][$f]."','".$_POST[valrec][$f]."',0,'1')";
		 							mysql_query($sqlr,$linkbd);
		 							//******parte para el recaudo del cobro por recibo de caja
		 							for($x=0;$x<count($_POST[dcoding]);$x++)
		 							{
		 								if($_POST[dcoding][$x]==$_POST[cobrorecibo])
		 								{
		 									//***** BUSQUEDA INGRESO ********
											$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 										$resi=mysql_query($sqlri,$linkbd);
											//echo "$sqlri <br>";	    
											while($rowi=mysql_fetch_row($resi))
		 									{
	    										//**** busqueda cuenta presupuestal*****
												//busqueda concepto contable
			 									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
	 	 										$resc=mysql_query($sqlrc,$linkbd);	  
		 										//echo "concc: $sqlrc <br>";	      
												while($rowc=mysql_fetch_row($resc))
		 										{
			  										$porce=$rowi[5];
													if($rowc[7]=='S')
			 										{				 
														$valorcred=$_POST[dvalores][$x]*($porce/100);
														$valordeb=0;
														if($rowc[3]=='N')
			    										{
			   												//*****inserta del concepto contable  
			   												//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 												$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 												$respto=mysql_query($sqlrpto,$linkbd);	  
			 												//echo "con: $sqlrpto <br>";	      
															$rowpto=mysql_fetch_row($respto);
															$vi=$_POST[dvalores][$x]*($porce/100);
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
															mysql_query($sqlr,$linkbd);	
			  												//****creacion documento presupuesto ingresos
			  												$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'$vigusu')";
  			  												mysql_query($sqlr,$linkbd);	
			  												if($vi>0 && $rowi[6]!="")
			   												{
			  													$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito, valcredito,estado,vigencia,tipo_comp,numerotipo) values('$rowi[6]','','RECIBO CAJA ','$vi','0','1','$_POST[vigencia]','16','$concecc')";
	 	  														mysql_query($sqlr,$linkbd); 
		  													}
															//echo "ppt:$sqlr";
															//************ FIN MODIFICACION PPTAL
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','$valordeb','$valorcred','1','$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
															//echo $sqlr."<br>";						
															//***cuenta caja o banco
															$cuentacb=$_POST[banco];				
															$cajas="";
															$cbancos=$_POST[banco];
			   												//$valordeb=$_POST[dvalores][$x]*($porce/100);
															//$valorcred=0;
															//echo "bc:$_POST[modorec] - $cuentacb";
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','".$_POST[tercero]."','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','',$valorcred,'0','1','$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
															//echo "Conc: $sqlr <br>";					
														}
													}
		 										}
		 									}
	 									}
									}			 	 
	 								//*************** fin de cobro de recibo
		  							$sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial='".$_POST[codliq][$f]."' and estado ='S'  and '1'='".$_POST[ref2][$f]."'";
		 							$res=mysql_query($sqlrs,$linkbd);	
		 							$rowd==mysql_fetch_row($res);
		 							$tasadesc=($rowd[6]/100);
 									$sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial='".$_POST[codliq][$f]."' and estado ='S'  and '1'='".$_POST[ref2][$f]."'";
		 							$res=mysql_query($sqlr,$linkbd);
		 							//echo "<BR>".$sqlr;
									//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
									while ($row =mysql_fetch_row($res)) 
									{
										$vig=$row[1];
										$vlrdesc=$row[10];
										if($vig==$vigusu) //*************VIGENCIA ACTUAL *****************
		 								{
			 								// $tasadesc=$row[10]/($row[4]+$row[6]);		
											// echo "<BR>".$sqlr;
		 									$idcomp=mysql_insert_id();
		 									echo "<input type='hidden' name='ncomp' value='$idcomp'>";	
											$sqlr2="select * from tesoingresos_DET where codigo='01' AND MODULO='4' and vigencia=$vigusu";
											$res2=mysql_query($sqlr2,$linkbd);
											// echo "<BR>".$sqlr2;				 
				 							//****** $cuentacb   ES LA CUENTA CAJA O BANCO
											while($rowi =mysql_fetch_row($res2))
		 									{
												// echo "<br>conc: ".$rowi[2];
		  										switch($rowi[2])
		   										{
													case '01': //***
														$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P01' AND MODULO='4' and vigencia=$vigusu";
														$resds=mysql_query($sqlrds,$linkbd);
														while($rowds =mysql_fetch_row($resds))
		   												{
					 										$descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);
															//echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
														}
				 										$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
				 		 								//echo "<BR>".$sqlrc;
				 										while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{				 
																$valorcred=$row[4];
																$valordeb=0;					
																if($rowc[3]=='N')
				   												{
				 	 												if($valorcred>0)
					  												{
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Ingreso Impuesto Predial Vigente $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=round($valorcred-$descpredial,2);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','".$_POST[tercero]."', '$rowc[5]','Ingreso Impuesto Predial Vigente $vig','','$valordeb','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		// echo "<BR>".$sqlr;
					     												//******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO ******
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
			 															//echo "con: $sqlrpto <br>";	      
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);	
			 	 														//****creacion documento presupuesto ingresos
			  															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'$vigusu')";
  			  															mysql_query($sqlr,$linkbd);	
			  															if($vi>0 && $rowi[6]!="")
			   															{
			  																$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle, valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('$rowi[6]','','RECIBO CAJA ','$vi','0','1','$_POST[vigencia]','16','$concecc')";
	 	  																	mysql_query($sqlr,$linkbd); 
		  																}
																		//echo "ppt:$sqlr";
																		//************ FIN MODIFICACION PPTAL		
					  												}
																}
				  											}
														}
														break;  
													case '02': //***
			 											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
				 										// echo "<BR>".$sqlrc;
				 										while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{				 
																$valorcred=$row[8];
																$valordeb=0;					
																if($rowc[3]=='N')
				    											{
				 	 												if($valorcred>0)
					  												{
				 														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Ingreso Sobretasa Ambiental $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','".$_POST[tercero]."', '$rowc[5]','Ingreso Sobretasa Ambiental $vig','','$valordeb','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		// echo "<BR>".$sqlr;
					  													//*******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *******
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
			 															//echo "con: $sqlrpto <br>";	      
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);	
			  															//****creacion documento presupuesto ingresos
			  															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'$vigusu')";
  			  															mysql_query($sqlr,$linkbd);	
			  															if($vi>0 && $rowi[6]!="")
			   															{
			 																$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle, valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('$rowi[6]','','RECIBO CAJA ','$vi','0','1','$_POST[vigencia]',16,'$concecc')";
	 	 																	mysql_query($sqlr,$linkbd); 
		  																}
																		//echo "ppt:$sqlr";
																		//************ FIN MODIFICACION PPTAL			
					  												}
																}
				  											}
														}
														break;  
													case '03': 
														$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P10' AND MODULO='4' and vigencia='$vigusu'";
														$resds=mysql_query($sqlrds,$linkbd);
														while($rowds =mysql_fetch_row($resds))
		   												{
					 										$descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);
															//echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
				 										// echo "<BR>".$sqlrc;
														while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{				 
																$valorcred=$row[6];
																$valordeb=0;					
																if($rowc[3]=='N')
				    											{
				 	 												if($valorcred>0)
					  												{
				 														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Ingreso Sobretasa Bomberil $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=round($valorcred-$descpredial,2);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','".$_POST[tercero]."', '$rowc[5]','Ingreso Sobretasa Bomberil $vig','','$valordeb','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//echo "<BR>".$sqlr;
					  													//*********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
			 															//echo "con: $sqlrpto <br>";	      
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																		mysql_query($sqlr,$linkbd);	
			  															//****creacion documento presupuesto ingresos
			  															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'$vigusu')";
  			  															mysql_query($sqlr,$linkbd);	
			 	 														if($vi>0 && $rowi[6]!="")
			   															{
			  																$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle, valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('$rowi[6]','','RECIBO CAJA ','$vi','0','1','$_POST[vigencia]','16','$concecc')";
	 	  																	mysql_query($sqlr,$linkbd); 
		  																}
																		//echo "ppt:$sqlr";
																		//************ FIN MODIFICACION PPTAL			
					  												}
																}
				  											}
				 										}
														break;  
													case 'P10': 
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
				 										// echo "<BR>".$sqlrc;
				 										while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{				 
																$valordeb=round($row[10]*round(($porce/100),2),2);
																$valorcred=0;		
																//echo "<BR>$row[10] $porce ".$valordeb;			
																if($rowc[3]=='N')
				    											{
				 	 												if($valordeb>0)
					  												{						
				 														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Descuento Pronto Pago Bomberil $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//echo "<BR>".$sqlr;
							  											//********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
			 															//echo "con: $sqlrpto <br>";	      
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
																		mysql_query($sqlr,$linkbd);	
			  															//****creacion documento presupuesto ingresos
			  															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'$vigusu')";
  			 															mysql_query($sqlr,$linkbd);	
			  															if($vi>0 && $rowi[6]!="")
			   															{
			  																$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('$rowi[6]','','RECIBO CAJA ','$vi','0','1', '$_POST[vigencia]','16','$concecc')";
	 	  																	mysql_query($sqlr,$linkbd); 
		  																}
																		//echo "ppt:$sqlr";
																		//************ FIN MODIFICACION PPTAL	
					  												}
																}
				 											}
				 										}
													break;  
												case 'P01': 
													$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C'";
	 			 									$resc=mysql_query($sqlrc,$linkbd);	  
				 									//echo "<BR>".$sqlrc;
				 									while($rowc=mysql_fetch_row($resc))
													{
			  											$porce=$rowi[5];
														if($rowc[6]=='S')
			 	  										{				 
															$valordeb=round($row[10]*round($porce/100,2),2);
															// $descpredial=round($vlrdesc*round($rowds[5]/100,2),2);
															$valorcred=0;					
															if($rowc[3]=='N')
				    										{
				 												if($valordeb>0)
					  											{						
				 													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Descuento Pronto Pago Predial $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	// echo "<BR>".$sqlr;
							  										//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 														$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 														$respto=mysql_query($sqlrpto,$linkbd);	  
			 														//echo "con: $sqlrpto <br>";	      
																	$rowpto=mysql_fetch_row($respto);
																	$vi=$valordeb;
																	$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
																	mysql_query($sqlr,$linkbd);	
			  														//****creacion documento presupuesto ingresos
			  														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  														mysql_query($sqlr,$linkbd);	
			  														if($vi>0 && $rowi[6]!="")
			   														{
			  															$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('$rowi[6]','','RECIBO CAJA ','$vi','0','1', '$_POST[vigencia]','16','$concecc')";
	 	  																mysql_query($sqlr,$linkbd); 
		  															}	
																	//echo "ppt:$sqlr";
																	//************ FIN MODIFICACION PPTAL	
					  											}
															}
				  										}
				 									}
													break;  
												case 'P02': 
													$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C'";
	 			 									$resc=mysql_query($sqlrc,$linkbd);	  
				 									// echo "<BR>".$sqlrc;
				 									while($rowc=mysql_fetch_row($resc))
				 									{
			  											$porce=$rowi[5];
														if($rowc[6]=='S')
			 	  										{				 
															$valorcred=$row[5];
															$valordeb=0;					
															if($rowc[3]=='N')
				    										{
				 	 											if($valorcred>0)
					  											{
				 													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Intereses Predial $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	$valordeb=$valorcred;
																	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','".$_POST[tercero]."', '$rowc[5]','Intereses Predial $vig','','$valordeb','0','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	// echo "<BR>".$sqlr;
							  										//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 														$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 															$respto=mysql_query($sqlrpto,$linkbd);	  
			 														//echo "con: $sqlrpto <br>";	      
																	$rowpto=mysql_fetch_row($respto);
																	$vi=$valordeb;
																	$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
																	mysql_query($sqlr,$linkbd);	
			  														//****creacion documento presupuesto ingresos
			  														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'$vigusu')";
  			  														mysql_query($sqlr,$linkbd);	
			  														if($vi>0 && $rowi[6]!="")
			   														{
			  															$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('$rowi[6]','','RECIBO CAJA ','$vi','0','1', '$_POST[vigencia]','16','$concecc')";
	 	  																mysql_query($sqlr,$linkbd); 
		  															}
																	//echo "ppt:$sqlr";
																	//************ FIN MODIFICACION PPTAL	
					  											}
															}
				  										}
				 									}
													break;  
												case 'P04': 
													$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 									$resc=mysql_query($sqlrc,$linkbd);	  
				 									// echo "<BR>".$sqlrc;
				 									while($rowc=mysql_fetch_row($resc))
				 									{
			  											$porce=$rowi[5];
														if($rowc[6]=='S')
			 	  										{				 
															$valorcred=$row[7];
															$valordeb=0;					
															if($rowc[3]=='N')
				    										{
				 	 											if($valorcred>0)
					  											{						
				 													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	$valordeb=$valorcred;
																	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','".$_POST[tercero]."', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','$valordeb','0','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	// echo "<BR>".$sqlr;
							  										//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 														$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 		 													$respto=mysql_query($sqlrpto,$linkbd);	  
			 														//echo "con: $sqlrpto <br>";	      
																	$rowpto=mysql_fetch_row($respto);
																	$vi=$valordeb;
																	$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
																	mysql_query($sqlr,$linkbd);	
			  														//****creacion documento presupuesto ingresos
			  														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]','$concecc','$vi','$vigusu')";
  			  														mysql_query($sqlr,$linkbd);	
			  														if($vi>0 && $rowi[6]!="")
			   														{
			 															$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito, valcredito,estado,vigencia,tipo_comp,numerotipo) values('$rowi[6]','','RECIBO CAJA ','$vi','0','1','$_POST[vigencia]','16','$concecc')";
	 	  																mysql_query($sqlr,$linkbd); 
		  															}
																	//echo "ppt:$sqlr";
																	//************ FIN MODIFICACION PPTAL	
					 											}
															}
				  										}
					 								}
												break;  
											case 'P05': 
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 								$resc=mysql_query($sqlrc,$linkbd);	  
				 								// echo "<BR>".$sqlrc;
				 								while($rowc=mysql_fetch_row($resc))
				 								{
			  										$porce=$rowi[5];
													if($rowc[6]=='S')
			 	  									{				 
														$valorcred=$row[6];
														$valordeb=0;					
														if($rowc[3]=='N')
				    									{
				 	 										if($valorcred>0)
					  										{						
				 												$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','$valordeb','$valorcred','1',''$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$valordeb=$valorcred;
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','".$_POST[tercero]."', '$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','$valordeb','0','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																// echo "<BR>".$sqlr;
							 									//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 													$respto=mysql_query($sqlrpto,$linkbd);	  
			 													//echo "con: $sqlrpto <br>";	      
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta = '$rowi[6]' and vigencia='$vigusu'";
																mysql_query($sqlr,$linkbd);	
			  													//****creacion documento presupuesto ingresos
			  													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]','$concecc','$vi','$vigusu')";
  			  													mysql_query($sqlr,$linkbd);	
			  													if($vi>0 && $rowi[6]!="")
			   													{
			  														$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito, valcredito,estado,vigencia,tipo_comp,numerotipo) values('$rowi[6]','','RECIBO CAJA ','$vi','0','1','$_POST[vigencia]','16','$concecc')";
	 	  															mysql_query($sqlr,$linkbd); 
		  														}
																//echo "ppt:$sqlr";
																//************ FIN MODIFICACION PPTAL	
					  										}
														}
				  									}
				 								}
												break;  
											case 'P07': 
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 								$resc=mysql_query($sqlrc,$linkbd);	  
				 								// echo "<BR>".$sqlrc;
												while($rowc=mysql_fetch_row($resc))
				 								{
			  										$porce=$rowi[5];
													if($rowc[6]=='S')
			 	  									{				 
														$valorcred=$row[9];
														$valordeb=0;					
														if($rowc[3]=='N')
				    									{
				 											if($valorcred>0)
					  										{						
				 												$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Intereses Sobtretasa Ambiental $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$valordeb=$valorcred;
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','".$_POST[tercero]."', '$rowc[5]','Intereses Sobtretasa Ambiental $vig','','$valordeb','0','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																// echo "<BR>".$sqlr;
							  									//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 													$respto=mysql_query($sqlrpto,$linkbd);	  
			 													//echo "con: $sqlrpto <br>";	      
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
																mysql_query($sqlr,$linkbd);				
			  													//****creacion documento presupuesto ingresos
			 													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]','$concecc','$vi','$vigusu')";
  			  													mysql_query($sqlr,$linkbd);	
			  													if($vi>0 && $rowi[6]!="")
			   													{
			  														$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito, valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	  															mysql_query($sqlr,$linkbd); 
		  														}
																//echo "ppt:$sqlr";
																//************ FIN MODIFICACION PPTAL	
					  										}
														}
				  									}
				 								}
											break;  
										case 'P08': 
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 							$resc=mysql_query($sqlrc,$linkbd);	  
				 							// echo "<BR>".$sqlrc;
				 							while($rowc=mysql_fetch_row($resc))
				 							{
			  									$porce=$rowi[5];
												if($rowc[6]=='S')
			 	  								{				 
													$valorcred=0;
													$valordeb=$row[8];					
				  								}
				 								if($rowc[6]=='N')
			 	  								{				 
													$valorcred=$row[8];
													$valordeb=0;					
				 	 							}
												if($rowc[3]=='N')
				    							{
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);					
													// echo "<BR>".$sqlr;
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 										$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 										$respto=mysql_query($sqlrpto,$linkbd);	  
			 										//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valorcred;
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
													mysql_query($sqlr,$linkbd);	
			  										//****creacion documento presupuesto ingresos
			  										$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			 										mysql_query($sqlr,$linkbd);	
			  										if($vi>0 && $rowi[6]!="")
			   										{
			  											$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	  												mysql_query($sqlr,$linkbd); 
		  											}
													//echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL	
				   								}
				 							}
											break; 
									} 
									//echo "<br>".$sqlr;
		 						}
								$_POST[dcoding][]=$row2[0];
								$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    							$_POST[dvalores][]=$row[11];		 
								//	echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
	 						}
		 					else  ///***********OTRAS VIGENCIAS ***********
	   	 					{	
			 		 			$tasadesc=$row[10]/($row[4]+$row[6]);
								// $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,'".$_POST[valrec][$f]."','".$_POST[valrec][$f]."',0,'1')";
		 						//mysql_query($sqlr,$linkbd);
								// echo "<BR>".$sqlr;
								$idcomp=mysql_insert_id();
		 						echo "<input type='hidden' name='ncomp' value='$idcomp'>";	
		  						$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo='".$_POST[codliq][$f]."' and tipo='1'";
		  						mysql_query($sqlr,$linkbd);
								$sqlr2="select * from tesoingresos_DET where codigo='03' AND MODULO='4' and vigencia=$vigusu";
								$res2=mysql_query($sqlr2,$linkbd);
								// echo "<BR>".$sqlr2;
				 				//****** $cuentacb   ES LA CUENTA CAJA O BANCO
								while($rowi =mysql_fetch_row($res2))
		 						{
									// echo "<br>conc: ".$rowi[2];
		  							switch($rowi[2])
		   							{
										case 'P03': //***
				 						$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 						$resc=mysql_query($sqlrc,$linkbd);	  
				 		 				//echo "<BR>".$sqlrc;
						 				while($rowc=mysql_fetch_row($resc))
				 						{
			  								$porce=$rowi[5];
											if($rowc[6]=='S')
			 	  							{				 
												$valorcred=$row[4];
												$valordeb=0;					
												if($rowc[3]=='N')
				    							{
				 	 								if($valorcred>0)
					  								{						
				 										$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
														mysql_query($sqlr,$linkbd);
														$valordeb=$valorcred-$tasadesc*$valorcred;
														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
														mysql_query($sqlr,$linkbd);
														// echo "<BR>".$sqlr;
							
						  							//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
													$respto=mysql_query($sqlrpto,$linkbd);	  
			 										//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
													mysql_query($sqlr,$linkbd);	
			
			  										//****creacion documento presupuesto ingresos
			  										$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  										mysql_query($sqlr,$linkbd);	
			  										if($vi>0 && $rowi[6]!="")
			   										{
			  											$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	  												mysql_query($sqlr,$linkbd); 
		  											}
													//			echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL		
					  							}
											}
				  						}
				 					}
									break;  
								case 'P06': //***
			 						$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{				 
											$valorcred=$row[8];
											$valordeb=0;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					  							{						
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
													$valordeb=$valorcred;
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
													// echo "<BR>".$sqlr;
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 										$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 										$respto=mysql_query($sqlrpto,$linkbd);	  
			 										//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
													mysql_query($sqlr,$linkbd);	
													//****creacion documento presupuesto ingresos
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
													mysql_query($sqlr,$linkbd);	
													if($vi>0 && $rowi[6]!="")
			   										{
			  											$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito, valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	  												mysql_query($sqlr,$linkbd); 
		  											}
													//echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL	
					  							}
											}
				  						}
									}
									break;  
								case '03': 
									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{				 
											$valorcred=$row[6];
											$valordeb=0;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					  							{						
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Ingreso Sobretasa Bomberil $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
													$valordeb=$valorcred-$tasadesc*$valorcred;
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','".$_POST[tercero]."','$rowc[5]','Ingreso Sobretasa Bomberil $vig','','$valordeb',0,'1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
													// echo "<BR>".$sqlr;
							 						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 										$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 										$respto=mysql_query($sqlrpto,$linkbd);	  
			 										//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
													mysql_query($sqlr,$linkbd);	
			  										//****creacion documento presupuesto ingresos
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
													mysql_query($sqlr,$linkbd);	
			  										if($vi>0 && $rowi[6]!="")
			   										{
			  											$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	  												mysql_query($sqlr,$linkbd); 
		  											}
													//			echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL	
					  							}
											}
				 						}
				 					}
									break;  
								case 'P01': 
									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{				 
											$valordeb=$row[10];
											$valorcred=0;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					  							{						
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','".$_POST[tercero]."', '$rowc[5]','Descuento Pronto Pago $vig','', '$valordeb','$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
													// echo "<BR>".$sqlr;
					  							}
											}
				  						}
				 					}
									break;  
								case 'P02': 
									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{				 
											$valorcred=$row[5];
											$valordeb=0;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					 							{
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$rowc[4]','".$_POST[tercero]."','$rowc[5]','Intereses Predial $vig','','$valordeb', '$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
													$valordeb=$valorcred;
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$cuentacb','".$_POST[tercero]."','$rowc[5]','Intereses Predial $vig','','$valordeb', 0,'1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
													// echo "<BR>".$sqlr;
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
												 	$respto=mysql_query($sqlrpto,$linkbd);	  
													//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
													mysql_query($sqlr,$linkbd);	
													//****creacion documento presupuesto ingresos
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'$vigusu')";
													mysql_query($sqlr,$linkbd);	
													if($vi>0 && $rowi[6]!="")
			   										{
			  											$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	 												 mysql_query($sqlr,$linkbd); 
		  											}
													//			echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL	
												}
				   							}
				  						}
				 					}
									break;  
								case 'P04': 
									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{				 
											$valorcred=$row[7];
											$valordeb=0;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					  							{						
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
													$valordeb=$valorcred;
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
													// echo "<BR>".$sqlr;
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 										$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 										$respto=mysql_query($sqlrpto,$linkbd);	  
			 										//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
													mysql_query($sqlr,$linkbd);	
			  										//****creacion documento presupuesto ingresos
			  										$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
													mysql_query($sqlr,$linkbd);	
													if($vi>0 && $rowi[6]!="")
			   										{
			  											$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	  												mysql_query($sqlr,$linkbd); 
		  											}
													//echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL	
					  							}
											}
				  						}
				 					}
									break;  
								case 'P05': 
									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{				 
											$valorcred=$row[6];
											$valordeb=0;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					  							{
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$rowc[4]','".$_POST[tercero]."','$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
													$valordeb=$valorcred;
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
													// echo "<BR>".$sqlr;
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 										$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
													$respto=mysql_query($sqlrpto,$linkbd);	  
													//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
													mysql_query($sqlr,$linkbd);	
			  										//****creacion documento presupuesto ingresos
												  	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
													mysql_query($sqlr,$linkbd);	
												  	if($vi>0 && $rowi[6]!="")
			   										{
			  											$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	  												mysql_query($sqlr,$linkbd); 
		  											}
													//			echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL	
					 							}
											}
				  						}
				 					}
									break;  
								case 'P07': 
									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{				 
											$valorcred=$row[9];
											$valordeb=0;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					  							{						
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
													$valordeb=$valorcred;
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
													// echo "<BR>".$sqlr;
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
												 	$respto=mysql_query($sqlrpto,$linkbd);	  
													//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
													mysql_query($sqlr,$linkbd);	
			  										//****creacion documento presupuesto ingresos
			  										$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  										mysql_query($sqlr,$linkbd);	
			  										if($vi>0 && $rowi[6]!="")
			   										{
			  											$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	  												mysql_query($sqlr,$linkbd); 
		  											}
													//			echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL	
					  							}
											}
				  						}
				 					}
									break;  
								case 'P08': 
									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{				 
											$valorcred=0;
											$valordeb=$row[8];					
				  						}
				 						if($rowc[6]=='N')
			 	  						{				 
											$valorcred=$row[8];
											$valordeb=0;					
				  						}
										if($rowc[3]=='N')
				    					{
				 							$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
											mysql_query($sqlr,$linkbd);					
											// echo "<BR>".$sqlr;
							  				//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
											$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 								$respto=mysql_query($sqlrpto,$linkbd);	  
			 								//echo "con: $sqlrpto <br>";	      
											$rowpto=mysql_fetch_row($respto);			
											$vi=$valordeb;
											$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
											mysql_query($sqlr,$linkbd);	
			 								//****creacion documento presupuesto ingresos
			  								$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  								mysql_query($sqlr,$linkbd);	
			  								if($vi>0 && $rowi[6]!="")
			   								{
			  									$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	  										mysql_query($sqlr,$linkbd); 
		  									}
											//			echo "ppt:$sqlr";
											//************ FIN MODIFICACION PPTAL		
				   						}
				 					}
									break;  
							} 
							//echo "<br>".$sqlr;
		 				}
						$_POST[dcoding][]=$row2[0];
						$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    					$_POST[dvalores][]=$row[11];		 	
						//echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
		 			}
				}
				//*******************  
	 			$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[codliq][$f]";
		  		$resp=mysql_query($sqlr,$linkbd);
		 		while($row=mysql_fetch_row($resp,$linkbd))
		   		{
		    		$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[codliq][$f]) AND vigencia=$row[1]";
					mysql_query($sqlr2,$linkbd);
		   		}	 	  
   	 		} //fin de la verificacion
	 		else
	 		{
				echo"<script>despliegamodalm('visible','2','Ya Existe un Recibo de Caja para esta Liquidacion Predial');</script>";
			 }//***FIN DE LA VERIFICACION
	   		break;
	   		case 2:  //********** INDUSTRIA Y COMERCIO
	   			//echo "INDUSTRIA";
		      	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecrec][$f],$fecha);
			  	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$sqlr="select count(*) from tesoreciboscaja where id_recaudo='".$_POST[codliq][$f]."' and tipo='2' AND ESTADO='S'";
				$res=mysql_query($sqlr,$linkbd);
				//echo $sqlr;
				while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
	 			$sqlr="SELECT ncuotas,pagos,estado from tesoindustria  WHERE id_industria='".$_POST[codliq][$f]."'";
		 		$resic=mysql_query($sqlr,$linkbd);
		  		$rowic=mysql_fetch_array($resic);
	 	  		$ncuotas=$rowic[0];
		  		$pagos=$rowic[1];
  				if(($numerorecaudos==0) || ($ncuotas-$pagos)>0)
   				{   	 
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
		 			$sqlr="insert into tesoreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo, descripcion) values(0,'$fechaf','".$vigusu."','".$_POST[codliq][$f]."','banco','$cajas','$cbancos','".$_POST[valrec][$f]."','S','".$_POST[ref2][$f]."', '$_POST[concepto]')";	  
					if (!mysql_query($sqlr,$linkbd))
					{
	 					$e =mysql_error(mysql_query($sqlr,$linkbd));
                        echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: $e');</script>";
					}
  					else
  		 			{
						echo "<script>despliegamodalm('visible','1','Se ha almacenado el Recibo de Caja con Exito');</script>";
		 				$concecc=mysql_insert_id(); 		 
		  				$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($concecc,16,'$fechaf	','RECIBO DE CAJA',$_POST[vigencia],0,0,0,1)";
	 	  				mysql_query($sqlr,$linkbd);	
		 				//*************COMPROBANTE CONTABLE INDUSTRIA
		  				$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,'".$_POST[valrec][$f]."','".$_POST[valrec][$f]."',0,'1')";
						mysql_query($sqlr,$linkbd);
						$idcomp=mysql_insert_id();
	 	  				$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo='".$_POST[codliq][$f]."' and tipo='2'";
		  				mysql_query($sqlr,$linkbd);
		  				//*** N CUOTAS
		  				$sqlr="SELECT ncuotas,pagos,estado from tesoindustria  WHERE id_industria='".$_POST[codliq][$f]."'";
		  				$resic=mysql_query($sqlr,$linkbd);
		  				$rowic=mysql_fetch_array($resic);
		  				$ncuotas=$rowic[0];
					 	$pagos=$rowic[1];
					  	$estadoic=$rowic[2];	
		  				if (($ncuotas-$pagos)==1)
		   				{
							$sqlr="update tesoindustria set estado='P',pagos=pagos+1 WHERE id_industria='".$_POST[codliq][$f]."'";
		  					mysql_query($sqlr,$linkbd);   
						}	
						else
						{  		  
  		  					$sqlr="update tesoindustria set pagos=pagos+1 WHERE id_industria='".$_POST[codliq][$f]."'";
		  					mysql_query($sqlr,$linkbd);
						}
						//echo "c:".count($_POST[dcoding]);	
 						//******parte para el recaudo del cobro por recibo de caja
		 				for($x=0;$x<count($_POST[dcoding]);$x++)
		 				{
		 					if($_POST[dcoding][$x]==$_POST[cobrorecibo])
		 					{
		 						//***** BUSQUEDA INGRESO ********
								$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 							$resi=mysql_query($sqlri,$linkbd);
								//	echo "$sqlri <br>";	    
								while($rowi=mysql_fetch_row($resi))
		 						{
	    							//**** busqueda cuenta presupuestal*****
									//busqueda concepto contable
			 						$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
	 	 							$resc=mysql_query($sqlrc,$linkbd);	  
		 							//echo "concc: $sqlrc <br>";	      
									while($rowc=mysql_fetch_row($resc))
		 							{
			  							$porce=$rowi[5];
										if($rowc[7]=='S')
			  							{				 
											$valorcred=$_POST[dvalores][$x]*($porce/100);
											$valordeb=0;
											if($rowc[3]=='N')
			    							{
			   									//*****inserta del concepto contable  
			   									//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 									$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia='$vigusu'";
		 	 									$respto=mysql_query($sqlrpto,$linkbd);	  
			 									//echo "con: $sqlrpto <br>";	      
												$rowpto=mysql_fetch_row($respto);
												$vi=$_POST[dvalores][$x]*($porce/100);
			  									//****creacion documento presupuesto ingresos
			  									$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  									mysql_query($sqlr,$linkbd);	
			  									if($vi>0 && $rowi[6]!="")
			  									{
			  										$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	  											mysql_query($sqlr,$linkbd); 
		  										}
												//			echo "ppt:$sqlr";
												//************ FIN MODIFICACION PPTAL
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
												mysql_query($sqlr,$linkbd);
												//echo $sqlr."<br>";						
												//***cuenta caja o banco
												$cuentacb=$_POST[banco];				
												$cajas="";
												$cbancos=$_POST[banco];
			   									//$valordeb=$_POST[dvalores][$x]*($porce/100);
												//$valorcred=0;
												//echo "bc:$_POST[modorec] - $cuentacb";
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
												mysql_query($sqlr,$linkbd);
												//echo "Conc: $sqlr <br>";					
											}
			  							}
		 							}
								}
	  						}
						}			 	 
	 					//*************** fin de cobro de recibo
						for($x=0;$x<count($_POST[dcoding]);$x++)
	 					{
		 					//***** BUSQUEDA INGRESO ********
							$sqlr="Select * from tesoindustria_det where id_industria=".$_POST[codliq][$f];
	 						$res=mysql_query($sqlr,$linkbd);
							$row=mysql_fetch_row($res);
							$industria=$row[1]/$_POST[tcuotas];
							$avisos=$row[2]/$_POST[tcuotas];
							$bomberil=$row[3]/$_POST[tcuotas];	
							$sanciones=$row[5]/$_POST[tcuotas];	
							$retenciones=$row[4]/$_POST[tcuotas];	
							$intereses=$row[6]/$_POST[tcuotas];		
							$antivigant=$row[10]/$_POST[tcuotas];		
							$antivigact=$row[11]/$_POST[tcuotas];								
							$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
							$res=mysql_query($sqlri,$linkbd);
	     					//echo "sQL: $sqlri <br>";	    
		  					while($row=mysql_fetch_row($res))
		  					{
		  						if($row[2]=='00') //*****sanciones
			  					{					
					  				//**fin rete ica
									//$valordeb=$industria+$sanciones-$retenciones;
									//++
						 			$valorcred=0;
		  							if($row[6]!="")
			  						{
			   							$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo) values('".$row[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$sanciones.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
	  									mysql_query($sqlr,$linkbd); 		
	  									// echo "ic rec:".$sqlr;
			 						 }						
			  					}
		  						//echo "sQL: $sqlri <br>";	  
								if($row[2]=='04') //*****industria
			  					{
									$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='04' and tipo='C'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
					  				{
					   					if($row2[3]=='N')
										{				 					  		
					   						if($row2[6]=='S')
						 					{				 
						 						$valordeb=0;
						 						$valorcred=$industria+$sanciones+$intereses;
						  						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Industria y Comercio $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
												mysql_query($sqlr,$linkbd);	 
												//echo "<br>$sqlr";
												//********** CAJA O BANCO
						 						//*** retencion ica
												if($row[6]!="")
						  						{						  
			 			   							$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo) values('$row[6]','".$_POST[tercero]."','RECIBO DE CAJA','$industria',0,'1','$_POST[vigencia]',16,'$concecc')";
	  												mysql_query($sqlr,$linkbd); 		
	  		 										//echo "ic rec:".$sqlr;
						  						}	
						 						$valordeb=$industria+$sanciones+$intereses-$retenciones-$antivigant;
						 						$valorcred=0;
						 						if($valordeb<0)
						 						{
						 							$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
													$res2=mysql_query($sqlr2,$linkbd);
							 						while($row2=mysql_fetch_row($res2))
							  						{
							   							if($row2[3]=='N')
														{				 					  		
							   								if($row2[7]=='S')
								 							{	
						 		  								$cuentacbr=$row2[4];
								  								$valordeb=0;
								  								$valorcred=$retenciones-$industria;
								  								//$diferencia=$retenciones-$industria;
								 								// $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacbr."','".$_POST[tercero]."','".$row2[5]."','Industria y Comercio $_POST[modorec]','',0,".$diferencia.",'1','".$_POST[vigencia]."')";
																//mysql_query($sqlr,$linkbd);
								 							}
														}
							  						}			 
						 						}
						 						else {$cuentacbr=$cuentacb;}
						 						//**fin rete ica					 
						 						$valordeb=$industria+$sanciones+$intereses-$antivigant-$retenciones;
						 						$valorcred=0;
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $concecc','".$cuentacbr."','".$_POST[tercero]."','".$row2[5]."','Industria y Comercio $_POST[modorec]','',".($valordeb).",0,'1','".$_POST[vigencia]."')";
												mysql_query($sqlr,$linkbd);
												$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$valordeb  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
												mysql_query($sqlr,$linkbd);
					 							$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]','$concecc', '$valordeb','".$vigusu."')";
						 						//echo "ic rec:".$sqlr;
  						  						mysql_query($sqlr,$linkbd);	
						 					}
										}
					  				}
			  					}
			   					if($row[2]=='P11')//************ANTICIPOS VIG ACTUAL ****************** 
			  					{
									$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
									$res2=mysql_query($sqlr2,$linkbd);
					 				while($row2=mysql_fetch_row($res2))
					  				{
					   					if($row2[3]=='N')
										{				 					  		
					   						if($row2[7]=='S')
						 					{				 
						 						$valordeb=0;
						 						$valorcred=$antivigact;					
						  						$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','ANTICIPO VIGENCIA ACTUAL $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
												mysql_query($sqlr,$linkbd);	 
												//echo "<br>$sqlr";						
												//********** CAJA O BANCO
						 						$valordeb=$antivigact;
						 						$valorcred=0;
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','".$_POST[tercero]."','$row2[5]','ANTICIPO VIGENCIA ACTUAL $_POST[modorec]','','$valordeb' ,0,'1','$_POST[vigencia]')";
												mysql_query($sqlr,$linkbd);											
						 					}
										}						
					  				}
			 				 	}
			  					//*******************
			  					if($row[2]=='P11')//************ANTICIPOS VIG ANTERIOR ****************** 
			  					{
									$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
									$res2=mysql_query($sqlr2,$linkbd);
					 				while($row2=mysql_fetch_row($res2))
					  				{
					   					if($row2[3]=='N')
										{				 					  		
					   						if($row2[7]=='S')
						 					{				 
						 						$valorcred=0;
						 						$valordeb=$antivigant;					
						  						$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','".$_POST[tercero]."','$row2[5]','ANTICIPO VIGENCIA ANTERIOR $_POST[ageliquida]', '',$valordeb,$valorcred,'1','$_POST[vigencia]')";
												mysql_query($sqlr,$linkbd);	 
												//echo "<br>$sqlr";						
												//********** CAJA O BANCO									
						 					}
										}						
					  				}
			  					}
			  					//*******************
								if($row[2]=='05')//************avisos
			  					{
									$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='05' and tipo='C'";
									$res2=mysql_query($sqlr2,$linkbd);
					 				while($row2=mysql_fetch_row($res2))
					  				{
					   					if($row2[3]=='N')
										{				 					  		
					   						if($row2[6]=='S')
						 					{				 
						 						$valordeb=0;
												$valorcred=$avisos;					
						 						$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Avisos y Tableros $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
												mysql_query($sqlr,$linkbd);	 
												//echo "<br>$sqlr";						
												//********** CAJA O BANCO
						 						$valordeb=$avisos;
						 						$valorcred=0;
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','".$_POST[tercero]."','$row2[5]','Avisos y Tableros Banco','','$valordeb',0,'1', '$_POST[vigencia]')";
												mysql_query($sqlr,$linkbd);
												$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$avisos  WHERE cuenta='$row[6]' and vigencia='$vigusu'";
												mysql_query($sqlr,$linkbd);
				 								$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$avisos,'$vigusu')";
												//  echo "av rec:".$sqlr;
												mysql_query($sqlr,$linkbd);							
											}
										}						
					 				}
			  					}
								if($row[2]=='06') //*********bomberil ********
			 					{
									$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='06' and tipo='C'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
					  				{
					   					if($row2[3]=='N')
										{				 					  		
					   						if($row2[6]=='S')
						 					{				 
						 						$valordeb=0;
						 						$valorcred=$bomberil;					
						  						$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$row2[4]','".$_POST[tercero]."','$row2[5]','Bomberil $_POST[ageliquida]','','$valordeb','$valorcred','1','$_POST[vigencia]')";
												mysql_query($sqlr,$linkbd);	 
												//echo "<br>$sqlr";						
												//********** CAJA O BANCO
						 						$valordeb=$bomberil;
						 						$valorcred=0;
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','Bomberil $_POST[modorec]','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
												mysql_query($sqlr,$linkbd);
												//***MODIFICAR PRESUPUESTO
												$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$bomberil  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
												mysql_query($sqlr,$linkbd);
						 						$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]','$concecc' ,'$bomberil','".$vigusu."')";
  			  									mysql_query($sqlr,$linkbd);	
												// echo "bom rec:".$sqlr;
						 					}
										}
					  				}
			  					}
		    				}
		  				}
					}
   				}
	 			else
	 			{echo"<script>despliegamodalm('visible','2','Ya Existe un Recibo de Caja para esta Liquidacion');</script>";}
				break; 
	 		case 3: //**************OTROS RECAUDOS
				$sqlr="select count(*) from tesoreciboscaja where id_recaudo='".$_POST[codliq][$f]."' and tipo='3' AND ESTADO='S'";
				$res=mysql_query($sqlr,$linkbd);
				//echo $sqlr;
				while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
  				if($numerorecaudos==0)
   				{ 
 					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
					//***busca el consecutivo del comprobante contable
					$concecc=0;
					$sqlr="select max(id_recibos ) from tesoreciboscaja  ";
					//echo $sqlr;
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res)){$concecc=$r[0];}
	 				$concecc+=1;
	 				// $consec=$concecc;
					//***cabecera comprobante
	 				$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,'".$_POST[valrec][$f]."','".$_POST[valrec][$f]."',0,'1')";
					mysql_query($sqlr,$linkbd);
					$idcomp=mysql_insert_id();
					echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	  				$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia, estado) values($concecc,16,'$fechaf','RECIBO DE CAJA',$_POST[vigencia],0,0,0,1)";
	 	  			mysql_query($sqlr,$linkbd);	
					//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
					for($x=0;$x<count($_POST[dcoding]);$x++)
	 				{
		 				//***** BUSQUEDA INGRESO ********
						$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 					$resi=mysql_query($sqlri,$linkbd);
						//	echo "$sqlri <br>";	    
						while($rowi=mysql_fetch_row($resi))
		 				{
	    					//**** busqueda cuenta presupuestal*****
							//busqueda concepto contable
			 				$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 	 					$resc=mysql_query($sqlrc,$linkbd);	  
							// 		echo "concc: $sqlrc - $_POST[cobrorecibo]<br>";	      
							while($rowc=mysql_fetch_row($resc))
		 					{
			 					$porce=$rowi[5];
	  		 					if($_POST[dcoding][$x]==$_POST[cobrorecibo])
			 					{
			  						//$columna= $rowc[7];
									//echo "cred  $rowc[7]<br>";	      
			  						if($rowc[7]=='S'){$columna= $rowc[7];}
			  						else{$columna= 'N';}
			  						$cuentacont=$rowc[4];
			 					}
			 					else
			 					{
			  						$columna= $rowc[6];	
			  						$cuentacont=$rowc[4];			 
								}
								if($columna=='S')
			  					{				 
									$valorcred=$_POST[dvalores][$x]*($porce/100);
									$valordeb=0;
									//	echo "cuenta: $rowc[4] - $columna <br>";	      
									if($rowc[3]=='N')
			    					{
			   							//*****inserta del concepto contable  
			   							//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 							$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 		 						$respto=mysql_query($sqlrpto,$linkbd);	  
			 							//echo "con: $sqlrpto <br>";	      
										$rowpto=mysql_fetch_row($respto);
										$vi=$_POST[dvalores][$x]*($porce/100);
										$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia='$vigusu'";
										mysql_query($sqlr,$linkbd);	
			  							//****creacion documento presupuesto ingresos
			  							$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  							mysql_query($sqlr,$linkbd);	
			  							if($vi>0 && $rowi[6]!="")
			   							{
			  								$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA ',".$vi.",0,1,'$_POST[vigencia]',16,'$concecc')";
	 	  									mysql_query($sqlr,$linkbd); 
		 									//  $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','','RECIBO CAJA $consecc',0,".$vi.",1,'$_POST[vigencia]',1,'$_POST[vigencia]')";
	 	  									//mysql_query($sqlr,$linkbd);	
			   							}
										//			echo "ppt:$sqlr";
										//************ FIN MODIFICACION PPTAL
										$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('5 $concecc','".$cuentacont."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
										mysql_query($sqlr,$linkbd);
										//echo $sqlr."<br>";						
										//***cuenta caja o banco
										$cuentacb=$_POST[banco];				
										$cajas="";
										$cbancos=$_POST[banco];
			   							//$valordeb=$_POST[dvalores][$x]*($porce/100);
										//$valorcred=0;
										//echo "bc:$_POST[modorec] - $cuentacb";
										$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
										mysql_query($sqlr,$linkbd);
										//echo "Conc: $sqlr <br>";					
									}
			  					}
		 					}
		 				}
					}	
					//************ insercion de cabecera recaudos ************
					$sqlr="insert into tesoreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo, descripcion) values($idcomp,'$fechaf',".$vigusu.",'".$_POST[codliq][$f]."','banco','$cajas','$cbancos',''".$_POST[valrec][$f]."'','S','".$_POST[ref2][$f]."', '$_POST[concepto]')";	  
					if (!mysql_query($sqlr,$linkbd))
					{
						 $e =mysql_error(mysql_query($sqlr,$linkbd));
                         echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: $e');</script>";
					}
					else
  		 			{
		  				$sqlr="update tesorecaudos set estado='P' WHERE ID_RECAUDO='".$_POST[codliq][$f]."'";
		  				mysql_query($sqlr,$linkbd);
						echo"<script>despliegamodalm('visible','1','Se ha almacenado el Recibo de Caja con Exito');</script>";
						
		  			}
    			} //fin de la verificacion
	 			else { echo"<script>despliegamodalm('visible','2','Ya Existe un Recibo de Caja para esta Liquidación');</script>";}
	  			break;
	   			//********************* INDUSTRIA Y COMERCIO
		} //*****fin del switch
		$_POST[ncomp]=$concecc;
	 	//echo "c:  ".count($_POST[dcoding]);
		//******* GUARDAR DETALLE DEL RECIBO DE CAJA ******	
		for($x=0;$x<count($_POST[dcoding]);$x++)
		{
			$sqlr="insert into tesoreciboscaja_det (id_recibos,ingreso,valor,estado) values($concecc,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	  
		  	mysql_query($sqlr,$linkbd);  
	  		//echo $sqlr."<br>";
		 }		
		//***** FIN DETALLE RECIBO DE CAJA ***************		
					}						
   				}//**fin del oculto 
			?>	
			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>	
		</form>
	</body>
</html>