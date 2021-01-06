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
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function guardar()
			{	
				var vg="<?php  
					$sqlr="SELECT * FROM tesoreciboscaja WHERE id_recibos=$_POST[idcomp]";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					if($r[0]==""){echo "S";}
					else{echo "N";}
					?>";
				if(vg=="S")
				{
					if (document.form2.fecha.value!='' && document.form2.modorec.value!='' && document.form2.tiporec.value!='' )
	  				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
	 				else
					{
	  					despliegamodalm('visible','2','Faltan datos para completar el registro');
	  					document.form2.fecha.focus();
	  					document.form2.fecha.select();
	 	 			}
				}
				else
				{
					var id="<?php 
						$sqlr="select id_recibos from tesoreciboscaja order by id_recibos desc";
						$res=mysql_query($sqlr,$linkbd);
						$r=mysql_fetch_row($res); 
						$_POST[idcomp]=$r[0]+1;
						echo $r[0];
						?>"
					document.form2.idcomp.value=id;
				}
			}
			function pdf()
			{
				document.form2.action="teso-pdfrecaja.php";
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
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
				<a onClick="location.href='teso-recibocaja.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
				<a class="mgbt" onClick="location.href='teso-buscarecibocaja.php'"><img src="imagenes/busca.png"  title="Buscar" /></a>
				<a class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				<a class="mgbt1"><img src="imagenes/printd.png" style="width:29px;height:25px;"/></a></td>
			</tr>		  
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php
			//$vigencia=date(Y);
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)){ $_POST[cuentacaja]=$row[0];}
	  		//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
			if(!$_POST[oculto])
			{
				$_POST[modorec]=='banco';
				$check1="checked";
				$fec=date("d/m/Y");
				$_POST[vigencia]=$vigencia;
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) {$_POST[cuentacaja]=$row[0];}
				$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
	 				$_POST[cobrorecibo]=$row[0];
	 				$_POST[vcobrorecibo]=$row[1];
	 				$_POST[tcobrorecibo]=$row[2];	 
				}
				$sqlr="select max(id_recibos) from tesoreciboscaja ";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 			$consec+=1;
	 			$_POST[idcomp]=$consec;	
 		 		$fec=date("d/m/Y");
		 		$_POST[fecha]=$fec; 		 		  			 
		 		$_POST[valor]=0;
				$_POST[modorec]='banco';		 
			}
		?>

 		<form name="form2" method="post" action="">

			<input type="hidden" name="vguardar" id="vguardar" value="">
 			<input name="encontro" type="hidden" value="<?php echo $_POST[encontro]?>" >
            <input name="cobrorecibo" type="hidden" value="<?php echo $_POST[cobrorecibo]?>" >
            <input name="vcobrorecibo" type="hidden" value="<?php echo $_POST[vcobrorecibo]?>" >
            <input name="tcobrorecibo" type="hidden" value="<?php echo $_POST[tcobrorecibo]?>" > 
            <input name="codcatastral" type="hidden" value="<?php echo $_POST[codcatastral]?>" >
 			<?php 
 				if($_POST[oculto])
				{
					switch($_POST[tiporec]) 
  	 				{
	  					case 1:	$sqlr="select * from tesoliquidapredial where tesoliquidapredial.idpredial=$_POST[idrecaudo] and estado ='S' and 1=$_POST[tiporec]";
  								//echo "$sqlr";
  	 							$_POST[encontro]="";
	  							$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
	 							{
									$_POST[codcatastral]=$row[1];		
									if($_POST[concepto]==""){$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1].' '.$row[19].' '.$row[20];}	
									$_POST[valorecaudo]=$row[8];		
									$_POST[totalc]=$row[8];	
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
	  					case 2:	$sqlr="select *from tesoindustria where tesoindustria.id_industria=$_POST[idrecaudo] and estado ='S' and 2=$_POST[tiporec]";
  								//echo "$sqlr";
							  	$_POST[encontro]="";
							  	$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									if($_POST[concepto]==""){$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - ".$row[3];}	
									$_POST[valorecaudo]=$row[6];		
									$_POST[totalc]=$row[6];	
									$_POST[tercero]=$row[5];	
									$_POST[ntercero]=buscatercero($row[5]);	
									$_POST[encontro]=1;
									$_POST[cuotas]=$row[9]+1;
									$_POST[tcuotas]=$row[8];
								}
	  							break;
	  					case 3:	$sqlr="select *from tesorecaudos where tesorecaudos.id_recaudo=$_POST[idrecaudo] and estado ='S' and 3=$_POST[tiporec]";
  								//echo "$sqlr";
  	  							$_POST[encontro]="";
	  							$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
	 							{
	  								if($_POST[concepto]==""){$_POST[concepto]=$row[6];	}
	  								$_POST[valorecaudo]=$row[5];		
	  								$_POST[totalc]=$row[5];	
	  								$_POST[tercero]=$row[4];	
	  								$_POST[ntercero]=buscatercero($row[4]);	
	  								$_POST[encontro]=1;
	 							}
								break;	
					}
				}
 			?>
    		<table class="inicio" style="width:99.7%;">
      			<tr >
        			<td class="titulos" colspan="7">Recibo de Caja</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:2cm;" >No Recibo:</td>
        			<td style="width:20%;">
                    	<input type="hidden" name="cuentacaja"  value="<?php echo $_POST[cuentacaja]?>"/>
                        <input type="text" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly/>
                   	</td>
	  				<td class="saludo1" style="width:2.3cm;">Fecha: </td>
        			<td style="width:18%;"><input type="text" name="fecha" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;"/>&nbsp;<a onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer"></a></td>
        			<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
		  			<td style="width:12%;"><input type="text" id="vigencia" name="vigencia" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" style="width:100%;" readonly></td>
          			<td rowspan="6" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>        
        		</tr>
      			<tr>
                	<td class="saludo1"> Recaudo:</td>
                    <td>
                    	<select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:100%;">
							<option value=""> Seleccione ...</option>
         					<option value="1" <?php if($_POST[tiporec]=='1') echo "SELECTED"; ?>>Predial</option>
          					<option value="2" <?php if($_POST[tiporec]=='2') echo "SELECTED"; ?>>Industria y Comercio</option>
          					<option value="3" <?php if($_POST[tiporec]=='3') echo "SELECTED"; ?>>Otros Recaudos</option>
        				</select>
          			</td>
          			<?php $sqlr="";?>
        			<td class="saludo1">No Liquidaci&oacute;n:</td>
                    <td><input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>"  onKeyUp="return tabular(event,this)" onChange="validar()" style="width:80%;"></td>
	 				<td class="saludo1">Recaudado en:</td>
                    <td>
                    	<select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:100%;">
							<option value="">Seleccione ...</option>
          					<option value="banco" <?php if($_POST[modorec]=='banco') echo "SELECTED"; ?>>Banco</option>
		 					<option value="caja" <?php if($_POST[modorec]=='caja') echo "SELECTED"; ?>>Caja</option>         
        				</select>
                   	</td>
               	</tr>
				<?php
					if ($_POST[modorec]=='banco')
					{
						/*echo"
						<tr>
							<td class='saludo1'>Cuenta:</td>
							<td>
								<select id='banco' name='banco' onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%'>
									<option value=''>Seleccione....</option>";
									$sqlr="select TB1.estado,TB1.cuenta,TB1.ncuentaban,TB1.tipo,TB2.razonsocial,TB1.tercero from tesobancosctas TB1,terceros TB2 where TB1.tercero=TB2.cedulanit and TB1.estado='S' ";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							if("$row[1]"==$_POST[banco])
							{
								echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
								$_POST[nbanco]=$row[4];
								$_POST[ter]=$row[5];
								$_POST[cb]=$row[2];
							}
							else{echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";}
						}	 	
						echo"
								</select>
							</td>
							<input type='hidden' name='cb' value='$_POST[cb]'/>
							<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/></td>
							<td class='saludo1'>Banco:</td>
							<td colspan='3'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%;' readonly></td>
						</tr>";*/
							echo "<tr>
					  				<td class='saludo1'>Cuenta :</td>
				                    <td>
				                    	<input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%;'/>&nbsp;
				                    	<a onClick=\"despliegamodal2('visible');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'>	
				                    		<img src='imagenes/find02.png' style='width:20px;'/>
				                    	</a>
				                    </td>
				                    <td colspan='4'>
				        					<input type='text' id='nbanco' name='nbanco' style='width:100%;' value='$_POST[nbanco]'  readonly>
				      				</td>
				                            <input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
											<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/></td>
								</tr>";
						
					}
				?> 
	  			<tr>
                	<td class="saludo1">Concepto:</td>
                    <td colspan="<?php if($_POST[tiporec]==2){echo '3';}else{echo'5';}?>"><input type="text" name="concepto" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)" style="width:100%;"></td>
      				<?php
	  					if($_POST[tiporec]==2)
	   					{
							echo" 
      						<td class='saludo1'>No Cuota:</td>
							<td><input type='text' name='cuotas' size='1' value='$_POST[cuotas]' readonly>/<input type='text' id='tcuotas' name='tcuotas' value='$_POST[tcuotas]' size='1' readonly ></td>";
	   					}
	  				?>
	  			</tr>
      			<tr>
                    <td  class="saludo1">Documento: </td>
        			<td><input type="text" name="tercero" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
			  		<td class="saludo1">Contribuyente:</td>
	  				<td colspan="3">
                    	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly>
                       
	  				</td>
               	</tr>
                <tr>
                	<td class="saludo1">Valor:</td>
                    <td><input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly ></td>
                </tr>
                <?php if ($_POST[modorec]!='banco'){echo"<tr style='height:20;'><tr>";}?>
      		</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="trec" value="<?php echo $_POST[trec]?>"/>
     		<div class="subpantallac7"  style="height:49.3%; width:99.6%; overflow-x:hidden;" id="divdet">
      		<?php 
				if($_POST[oculto] && $_POST[encontro]=='1')
				{
  					switch($_POST[tiporec]) 
  					{
	  					case 1: //********PREDIAL
							$sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
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
							$sqlr="select *from tesoindustria where tesoindustria.id_industria=$_POST[idrecaudo] and estado ='S' and 2=$_POST[tiporec]";
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
  							$sqlr="select *from tesorecaudos_det where tesorecaudos_det.id_recaudo=$_POST[idrecaudo] and estado ='S'  and 3=$_POST[tiporec]";
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
 				?>
	   			<table class="inicio">
	   	  			<tr><td colspan="4" class="titulos">Detalle Recibo de Caja</td></tr>                  
					<tr>
                    	<td class="titulos2" style="width:15%;">Codigo</td>
                        <td class="titulos2">Ingreso</td>
                        <td class="titulos2" style="width:20%;">Valor</td>
                  	</tr>
					<?php 		
		  				$_POST[totalc]=0;
						$co="saludo1a";
		  				$co2="saludo2";
		 				for ($x=0;$x<count($_POST[dcoding]);$x++)
		 				{		 
		 					echo "
							<input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."'>
							<input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."'>
							<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'>
							<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								<td>".$_POST[dcoding][$x]."</td>
								<td>".$_POST[dncoding][$x]."</td>
								<td style='text-align:right;'>$ ".number_format($_POST[dvalores][$x],2)."</td>
							</tr>";
		 					$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 					$_POST[totalcf]=number_format($_POST[totalc],2);
							$totalg=number_format($_POST[totalc],2,'.','');
							$aux=$co;
							$co=$co2;
							$co2=$aux;
		 				}
						if ($_POST[totalc]!='' && $_POST[totalc]!=0){$_POST[letras] = convertirdecimal($totalg,'.');}
						else{$_POST[letras]=''; $_POST[totalcf]=0;}
		 				echo "
						<input type='hidden' name='totalcf' value='$_POST[totalcf]'>
						<input type='hidden' name='totalc' value='$_POST[totalc]'>
						<input type='hidden' name='letras' value='$_POST[letras]'>
						<tr class='$co' style='text-align:right;'>
							<td colspan='2'>Total</td>
							<td>$ $_POST[totalcf]</td>
						</tr>
						<tr class='titulos2'>
							<td>Son:</td>
							<td colspan='2'>$_POST[letras]</td>
						</tr>";
					?> 
	   			</table>
         	</div>
	  		<?php
				if($_POST[oculto]=='2')
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
					if($bloq>=1)
					{
						//************VALIDAR SI YA FUE GUARDADO ************************
						switch($_POST[tiporec]) 
  	 					{
	 						case 1://***** PREDIAL *****************************************
								//echo 'PREDIAL';
	 							$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='1' ";
								$res=mysql_query($sqlr,$linkbd);
								//echo $sqlr;
								while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
	  							if($numerorecaudos>=0)
	   							{ 	
									//$sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='5'";
									//mysql_query($sqlr,$linkbd);
									//$sqlr="delete from comprobante_det where id_comp='5 $_POST[idcomp]'";
									//echo $sqlr;
									//mysql_query($sqlr,$linkbd);
									//$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
									//echo $sqlr;		
									//mysql_query($sqlr,$linkbd);
		   							if($_POST[modorec]=='caja')
			  						{				 
										$cuentacb=$_POST[cuentacaja];
										$cajas=$_POST[cuentacaja];
										$cbancos="";
			  						}
									if($_POST[modorec]=='banco')
			    					{
										$cuentacb=$_POST[banco];				
										$cajas="";
										$cbancos=$_POST[banco];
			    					}	   
		     						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			  						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	   								$sqlr="insert into tesoreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor, estado,tipo,descripcion) values('0','$fechaf','$vigusu','$_POST[idrecaudo]','$_POST[modorec]','$cajas','$cbancos','$_POST[totalc]','S', '$_POST[tiporec]','$_POST[concepto]')";	  
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
									//$concecc=$_POST[idcomp];
		 							//echo "ccc".$concecc;
									echo "<input type='hidden' name='concec' value='$concecc'>";	
									echo "<script>
											despliegamodalm('visible','1','>Se ha almacenado el Recibo de Caja con Exito');
											document.form2.vguardar.value='1';
											
										</script>";
		  							$sqlr="update tesoliquidapredial set estado='P' WHERE idpredial=$_POST[idrecaudo]";
		  							mysql_query($sqlr,$linkbd);
		  							$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
		  							$resq=mysql_query($sqlr,$linkbd);
		  							//echo "<br>$sqlr";
		  							while($rq=mysql_fetch_row($resq))
 		  							{
		   								$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE   idpredial=$_POST[idrecaudo]) AND vigencia=$rq[1]";
		   								mysql_query($sqlr2,$linkbd);
		   								//  echo "<br>$sqlr2";
		  							}
		 							echo"
		  							<script>
		  								document.form2.numero.value='';
		  								document.form2.valor.value=0;
		  							</script>";
									//**********************CREANDO COMPROBANTE CONTABLE ********************************	 
	 								$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito, diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
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
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]', '$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','$valordeb','$valorcred','1','$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
															//echo $sqlr."<br>";						
															//***cuenta caja o banco
															if($_POST[modorec]=='caja')
			  												{				 
																$cuentacb=$_POST[cuentacaja];
																$cajas=$_POST[cuentacaja];
																$cbancos="";
			  												}
															if($_POST[modorec]=='banco')
			    											{
																$cuentacb=$_POST[banco];				
																$cajas="";
																$cbancos=$_POST[banco];
			    											}
			   												//$valordeb=$_POST[dvalores][$x]*($porce/100);
															//$valorcred=0;
															//echo "bc:$_POST[modorec] - $cuentacb";
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','',$valorcred,'0','1','$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
															//echo "Conc: $sqlr <br>";					
														}
													}
		 										}
		 									}
	 									}
									}			 	 
	 								//*************** fin de cobro de recibo
		  							$sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
		 							$res=mysql_query($sqlrs,$linkbd);	
		 							$rowd==mysql_fetch_row($res);
		 							$tasadesc=($rowd[6]/100);
 									$sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
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
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Ingreso Impuesto Predial Vigente $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=round($valorcred-$descpredial,2);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Ingreso Impuesto Predial Vigente $vig','','$valordeb','0','1','$_POST[vigencia]')";
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
				 														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Ingreso Sobretasa Ambiental $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Ingreso Sobretasa Ambiental $vig','','$valordeb','0','1','$_POST[vigencia]')";
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
				 														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Ingreso Sobretasa Bomberil $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=round($valorcred-$descpredial,2);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Ingreso Sobretasa Bomberil $vig','','$valordeb','0','1','$_POST[vigencia]')";
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
				 														$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Descuento Pronto Pago Bomberil $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
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
				 													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Descuento Pronto Pago Predial $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
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
				 													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	$valordeb=$valorcred;
																	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','$valordeb','0','1','$_POST[vigencia]')";
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
				 													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	$valordeb=$valorcred;
																	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','$valordeb','0','1','$_POST[vigencia]')";
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
				 												$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','$valordeb','$valorcred','1',''$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$valordeb=$valorcred;
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','$valordeb','0','1','$_POST[vigencia]')";
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
				 												$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobtretasa Ambiental $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																$valordeb=$valorcred;
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Intereses Sobtretasa Ambiental $vig','','$valordeb','0','1','$_POST[vigencia]')";
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
								// $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
		 						//mysql_query($sqlr,$linkbd);
								// echo "<BR>".$sqlr;
								$idcomp=mysql_insert_id();
		 						echo "<input type='hidden' name='ncomp' value='$idcomp'>";	
		  						$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
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
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Ingreso Sobretasa Bomberil $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
													$valordeb=$valorcred-$tasadesc*$valorcred;
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Bomberil $vig','','$valordeb',0,'1','$_POST[vigencia]')";
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
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Descuento Pronto Pago $vig','', '$valordeb','$valorcred','1','$_POST[vigencia]')";
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
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','$valordeb', '$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
													$valordeb=$valorcred;
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','$valordeb', 0,'1','$_POST[vigencia]')";
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
				 									$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','$valordeb','$valorcred','1','$_POST[vigencia]')";
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
	 			$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
		  		$resp=mysql_query($sqlr,$linkbd);
		 		while($row=mysql_fetch_row($resp,$linkbd))
		   		{
		    		$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[1]";
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
		      	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			  	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='2' AND ESTADO='S'";
				$res=mysql_query($sqlr,$linkbd);
				//echo $sqlr;
				while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
	 			$sqlr="SELECT ncuotas,pagos,estado from tesoindustria  WHERE id_industria=$_POST[idrecaudo]";
		 		$resic=mysql_query($sqlr,$linkbd);
		  		$rowic=mysql_fetch_array($resic);
	 	  		$ncuotas=$rowic[0];
		  		$pagos=$rowic[1];
  				if(($numerorecaudos==0) || ($ncuotas-$pagos)>0)
   				{   	 
   					if($_POST[modorec]=='caja')
			  		{				 
						$cuentacb=$_POST[cuentacaja];
						$cajas=$_POST[cuentacaja];
						$cbancos="";
			  		}
					if($_POST[modorec]=='banco')
			    	{
						$cuentacb=$_POST[banco];				
						$cajas="";
						$cbancos=$_POST[banco];
			   		}
		 			$sqlr="insert into tesoreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo, descripcion) values(0,'$fechaf','".$vigusu."',$_POST[idrecaudo],'$_POST[modorec]','$cajas','$cbancos','$_POST[totalc]','S','$_POST[tiporec]', '$_POST[concepto]')";	  
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
		  				$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
						mysql_query($sqlr,$linkbd);
						$idcomp=mysql_insert_id();
	 	  				$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='2'";
		  				mysql_query($sqlr,$linkbd);
		  				//*** N CUOTAS
		  				$sqlr="SELECT ncuotas,pagos,estado from tesoindustria  WHERE id_industria=$_POST[idrecaudo]";
		  				$resic=mysql_query($sqlr,$linkbd);
		  				$rowic=mysql_fetch_array($resic);
		  				$ncuotas=$rowic[0];
					 	$pagos=$rowic[1];
					  	$estadoic=$rowic[2];	
		  				if (($ncuotas-$pagos)==1)
		   				{
							$sqlr="update tesoindustria set estado='P',pagos=pagos+1 WHERE id_industria=$_POST[idrecaudo]";
		  					mysql_query($sqlr,$linkbd);   
						}	
						else
						{  		  
  		  					$sqlr="update tesoindustria set pagos=pagos+1 WHERE id_industria=$_POST[idrecaudo]";
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
												if($_POST[modorec]=='caja')
			  									{				 
													$cuentacb=$_POST[cuentacaja];
													$cajas=$_POST[cuentacaja];
													$cbancos="";
			  									}
												if($_POST[modorec]=='banco')
												{
													$cuentacb=$_POST[banco];				
													$cajas="";
													$cbancos=$_POST[banco];
												}
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
							$sqlr="Select * from tesoindustria_det where id_industria=".$_POST[idrecaudo];
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
			 			   							$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo) values('$row[6]','$_POST[tercero]','RECIBO DE CAJA','$industria',0,'1','$_POST[vigencia]',16,'$concecc')";
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
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','ANTICIPO VIGENCIA ACTUAL $_POST[modorec]','','$valordeb' ,0,'1','$_POST[vigencia]')";
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
						  						$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','ANTICIPO VIGENCIA ANTERIOR $_POST[ageliquida]', '',$valordeb,$valorcred,'1','$_POST[vigencia]')";
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
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','Avisos y Tableros $_POST[modorec]','','$valordeb',0,'1', '$_POST[vigencia]')";
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
						  						$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','Bomberil $_POST[ageliquida]','','$valordeb','$valorcred','1','$_POST[vigencia]')";
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
				$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='3' AND ESTADO='S'";
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
	 				$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
					mysql_query($sqlr,$linkbd);
					$idcomp=mysql_insert_id();
					echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	  				$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia, estado) values($concecc,16,'$fechaf	','RECIBO DE CAJA',$_POST[vigencia],0,0,0,1)";
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
										if($_POST[modorec]=='caja')
										{				 
											$cuentacb=$_POST[cuentacaja];
											$cajas=$_POST[cuentacaja];
											$cbancos="";
										}
										if($_POST[modorec]=='banco')
										{
											$cuentacb=$_POST[banco];				
											$cajas="";
											$cbancos=$_POST[banco];
										}
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
					$sqlr="insert into tesoreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo, descripcion) values($idcomp,'$fechaf',".$vigusu.",$_POST[idrecaudo],'$_POST[modorec]','$cajas','$cbancos','$_POST[totalc]','S','$_POST[tiporec]', '$_POST[concepto]')";	  
					if (!mysql_query($sqlr,$linkbd))
					{
						 $e =mysql_error(mysql_query($sqlr,$linkbd));
                         echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: $e');</script>";
					}
					else
  		 			{
		  				$sqlr="update tesorecaudos set estado='P' WHERE ID_RECAUDO=$_POST[idrecaudo]";
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
  	else {echo"<script>despliegamodalm('visible','2','No Tiene los Permisos para Modificar este Documento');</script>";}
  //****fin if bloqueo  
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