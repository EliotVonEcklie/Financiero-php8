<?php //V 1001 29/12/16 Se cambio a tipomovimiento 201?> 
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
	  		function buscacta(e)
	  		{
	   			if (document.form2.cuenta.value!="")
	   			{
		 			document.form2.bc.value='1';
		 			document.form2.submit();
	   			}
	  		}
	  		function validar(){document.form2.submit();}
	  		function buscater(e)
	  		{
	   			if (document.form2.tercero.value!="")
	   			{
					document.form2.bt.value='1';
					document.form2.submit();
	   			}
	  		}
	  		function agregardetalle()
	  		{
	   			if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
		 			document.form2.agregadet.value=1;
		  			document.form2.submit();
				}
	   			else {alert("Falta informacion para poder Agregar");}
	  		}
	  		function eliminar(variable)
	  		{
	   			if (confirm("Esta Seguro de Eliminar"))
	   			{
		 			document.form2.elimina.value=variable;
		 			document.form2.submit();
	   			}
	  		}
	  		function guardar()
	  		{
	   			if(document.form2.fecha.value!='' && document.form2.modorec.value!='' )
					{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
		   		else
				{
			  		despliegamodalm('visible','2','Faltan datos para completar el registro');
			 		document.form2.fecha.focus();
			 		document.form2.fecha.select();
		   		}
	  		}
	  	
			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
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
						case "5":	document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":
						document.form2.elimina.value=variable;
						//eli=document.getElementById(elimina);
						vvend=document.getElementById('elimina');
						//eli.value=elimina;
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje()
			{
				document.location.href = "teso-sinrecibocajaver.php?idrecibo="+document.getElementById('idcomp').value+"&scrtop=0&totreg=1&altura=461&numpag=1&limreg=10&filtro=";
			}

		  function pdf()
		  {
			document.form2.action="teso-pdfsinrecaja.php";
			document.form2.target="_BLANK";
			document.form2.submit(); 
			document.form2.action="";
			document.form2.target="";
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
					<a onClick="location.href='teso-sinrecibocaja.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a class="mgbt" onClick="location.href='teso-buscasinrecibocaja.php'"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a class="mgbt" onClick="mypop=window.open('teso-principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a class="mgbt" <?php if($_POST[oculto]==2) { ?>onClick="pdf()" <?php } ?>><img src="imagenes/print.png" alt="inprimir" /></a>
				</td>
            </tr>		  
  		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action=""> 
			<?php
				//$vigencia=date(Y);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$vigencia=$vigusu;
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) {$_POST[cuentacaja]=$row[0];}
				//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
				if(!$_POST[oculto])
				{
					$check1="checked";
					$fec=date("d/m/Y");
					$_POST[vigencia]=$vigencia;
					$sqlr="SELECT cuentacaja FROM tesoparametros";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[0];}
					$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$_POST[cobrorecibo]=$row[0];
						$_POST[vcobrorecibo]=$row[1];
						$_POST[tcobrorecibo]=$row[2];	 
					}
					$sqlr="select max(id_recibos) from tesosinreciboscaja ";
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					while($r=mysql_fetch_row($res)){$consec=$r[0];}
					$consec+=1;
					$_POST[idcomp]=$consec;	
			 		$fec=date("d/m/Y");
					$_POST[fecha]=$fec; 		 		  			 
					$_POST[valor]=0;		 
				}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';
				}
			?>
  			<input name="encontro" type="hidden" value="<?php echo $_POST[encontro]?>"/>
   			<input name="cobrorecibo" type="hidden" value="<?php echo $_POST[cobrorecibo]?>"/>
   			<input name="vcobrorecibo" type="hidden" value="<?php echo $_POST[vcobrorecibo]?>"/>
   			<input name="tcobrorecibo" type="hidden" value="<?php echo $_POST[tcobrorecibo]?>"/> 
   			<input name="codcatastral" type="hidden" value="<?php echo $_POST[codcatastral]?>"/>
   			<?php 
   				if($_POST[oculto])
   				{
	  				switch($_POST[tiporec]) 
	  				{
						case 1:
		  					$sqlr="select *from tesoliquidapredial where tesoliquidapredial.idpredial=$_POST[idrecaudo] and estado ='S' and 1=$_POST[tiporec]";
		   					$_POST[encontro]="";
		   					$res=mysql_query($sqlr,$linkbd);
		   					while ($row =mysql_fetch_row($res)) 
						   	{
								$_POST[codcatastral]=$row[1];		
								$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1];	
								$_POST[valorecaudo]=$row[8];		
								$_POST[totalc]=$row[8];	
								$_POST[tercero]=$row[4];	
								$_POST[ntercero]=buscatercero($row[4]);
							 	if ($_POST[ntercero]=='')
							  	{
									$sqlr2="select *from tesopredios where cedulacatastral='".$row[1]."' ";
									$resc=mysql_query($sqlr2,$linkbd);
									$rowc =mysql_fetch_row($resc);
									$_POST[ntercero]=$rowc[6];
							  	}	
							  	$_POST[encontro]=1;
						   	}
							break;
						case 2:
		   					$sqlr="select *from tesoindustria where tesoindustria.id_industria=$_POST[idrecaudo] and estado ='S' and 2=$_POST[tiporec]";
		  					$_POST[encontro]="";
		   					$res=mysql_query($sqlr,$linkbd);
		   					while ($row =mysql_fetch_row($res)) 
		   					{
			 					$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - ".$row[3];	
								$_POST[valorecaudo]=$row[6];		
								$_POST[totalc]=$row[6];	
								$_POST[tercero]=$row[5];	
								$_POST[ntercero]=buscatercero($row[5]);	
								$_POST[encontro]=1;
								$_POST[cuotas]=$row[9]+1;
								$_POST[tcuotas]=$row[8];
		  					}
							break;
						case 3:
		   					$sqlr="select *from tesosinrecaudos where tesosinrecaudos.id_recaudo=$_POST[idrecaudo] and estado ='S' and 3=$_POST[tiporec]";
		   					$_POST[encontro]="";
		   					$res=mysql_query($sqlr,$linkbd);
		   					while ($row =mysql_fetch_row($res)) 
		   					{
								$_POST[concepto]=$row[6];	
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
   			<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="2">Ingresos Propios</td>
                    <td class="cerrar" style="width:10%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
				<tr>
					<td style="width:80%;">
   						<table>
		   					<tr>
			  					<td style="width:2.5cm" class="saludo1" >No Recibo:</td>
			  					<td style="width:15%">
									<input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>"/>
									<input name="idcomp" id="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) " readonly/>
			  					</td>
			  					<td style="width:2.5cm" class="saludo1">Fecha:</td>
			  					<td style="width:15%">
									<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" style="width:45%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a> 
								</td>
			  					<td style="width:2.5cm" class="saludo1">Vigencia:</td>
			  					<td style="width:10%">
									<input type="text" id="vigencia" name="vigencia" style="width:30%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>     
                                 </td> 
							</tr>
							<tr>
			  					<td class="saludo1"> Recaudo:</td>
			  					<td >
									<select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" >
										<option value="3" <?php if($_POST[tiporec]=='3') echo "SELECTED"; ?>>Otros Recaudos</option>
									</select>
								</td>
								<?php $sqlr=""; ?>
								<td class="saludo1">No Liquid:</td>
								<td>
									<input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" style="width:100%" onKeyUp="return tabular(event,this)" onChange="validar()">
								</td>
								<td class="saludo1">Recaudado en:</td>
								<td style="width:22%;">
									<select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" style="width:100%;" onChange="validar()" >
										<option value="" >Seleccione...</option>
										<option value="caja" <?php if($_POST[modorec]=='caja') echo "SELECTED"; ?>>Caja</option>
										<option value="banco" <?php if($_POST[modorec]=='banco') echo "SELECTED"; ?>>Banco</option>
									</select>
								</td>
							</tr>
							<?php
							if ($_POST[modorec]=='banco')
							{
								// echo "<tr><td class='saludo1'>Recaudado en:</td><td>";
							  	// echo"<select id='banco' name='banco' style='width:69%;' onChange='validar()' onKeyUp='return tabular(event,this)'>
							   	// <option value=''>Seleccione....</option>";
							  
							  	// $sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
							  	// $res=mysql_query($sqlr,$linkbd);
							  	// while ($row =mysql_fetch_row($res)) 
							  	// {
									// echo "<option value=$row[1] ";
									// $i=$row[1];
									// if($i==$_POST[banco])
									// {
								   		// echo "SELECTED";
								   		// $_POST[nbanco]=$row[4];
								   		// $_POST[ter]=$row[5];
								   		// $_POST[cb]=$row[2];
									// }
									// echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	

								// }	 	
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
						?>
					  		<!-- </select> -->
					  		</td>
					  	
							</tr>
				 	<?php
				}
						 ?> 
					   </tr>
					   <tr>
						<td class="saludo1">Concepto:</td>
						<td colspan="5">
						 <input name="concepto" style="width:100%" type="text" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)">
						</td>
						<?php
						if($_POST[tiporec]==2)
						{
						?>   
						<td class="saludo1">No Cuota:</td>
						<td>
						  <input name="cuotas" size="1" type="text" value="<?php echo $_POST[cuotas] ?>" readonly/>
						  <input type="text" id="tcuotas" name="tcuotas" value="<?php echo $_POST[tcuotas] ?>" size="1"  readonly/></td>
						<?php
						 }
						?>
					   </tr>
					   <tr>
						 <td class="saludo1">Valor:</td>
						 <td>
						   <input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" style="width:100%" onKeyUp="return tabular(event,this)" readonly ></td><td  class="saludo1">Documento: </td>
						 <td >
						   <input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:100%" onKeyUp="return tabular(event,this)" readonly>
						 </td>
						 <td class="saludo1">Contribuyente:</td>
						 <td>
						   <input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" onKeyUp="return tabular(event,this) "  readonly>
						   
						   <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
						 
						   <input type="hidden" value="1" name="oculto" id="oculto">
						   <input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
						   <input type="hidden" value="0" name="agregadet"></td>
					   </tr>
				</table>
				</td>
				<td colspan="2" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" >
				</td>  
		</tr>
   		

		
     
	   </table>
		 <div class="subpantallac7">
		 <?php 
		  if($_POST[oculto] && $_POST[encontro]=='1')
		  {
		  switch($_POST[tiporec]) 
			 {
			  case 1: //********PREDIAL
				$sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
				// echo "$sqlr";
				$_POST[dcoding]= array(); 		 
				$_POST[dncoding]= array(); 		 
				$_POST[dvalores]= array(); 	
				$_POST[trec]='PREDIAL';
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
					 //echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
				  }
		  
				}  
			  break;
	  
			  case 2: //***********INDUSTRIA Y COMERCIO
				 $_POST[dcoding]= array(); 		 
				 $_POST[dncoding]= array(); 		 
				 $_POST[dvalores]= array(); 	
				 $_POST[trec]='INDUSTRIA Y COMERCIO';	 
				 $sqlr="select *from tesoindustria where tesoindustria.id_industria=$_POST[idrecaudo] and estado ='S' and 2=$_POST[tiporec]";
				//echo "$sqlr";
				 $res=mysql_query($sqlr,$linkbd);
				 while ($row =mysql_fetch_row($res)) 
				 {
				  $sqlr2="select * from tesoingresos where codigo='02'";
				  $res2=mysql_query($sqlr2,$linkbd);
				  $row2 =mysql_fetch_row($res2);
				  $_POST[dcoding][]=$row2[0];
				  $_POST[dncoding][]=$row2[1];			 		
				  $_POST[dvalores][]=$row[6]/$_POST[tcuotas];		
				 }
			  break;
	  
			   case 3: ///*****************otros recaudos *******************
				  $_POST[trec]='OTROS RECAUDOS';	 
				  // echo $_POST[tcobrorecibo];
				  $_POST[dcoding]= array();
				  $_POST[dncc]= array(); 		 
				  $_POST[dncoding]= array(); 		 
				  $_POST[dvalores]= array(); 
				  $sqlr="select *from tesosinrecaudos_det where tesosinrecaudos_det.id_recaudo=$_POST[idrecaudo] and estado ='S'  and 3=$_POST[tiporec]";
				 //  echo "$sqlr";				 
				  $res=mysql_query($sqlr,$linkbd);
				  while ($row =mysql_fetch_row($res)) 
				  {
					$_POST[dcoding][]=$row[2];
					$_POST[dncc][]=$row[5];
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
	   	<tr>
		 <td colspan="4" class="titulos">Detalle Recibo de Caja</td>
		</tr>                  
		<tr>
		 	<td class="titulos2">Codigo</td>
		 	<td class="titulos2">Ingreso</td>
		 	<td class="titulos2">Valor</td>
		</tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
 		 unset($_POST[dcoding][$posi]);	
 		 unset($_POST[dncoding][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  		 
		 $_POST[dcoding]= array_values($_POST[dcoding]); 		 
		 $_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcoding][]=$_POST[codingreso];
		 $_POST[dncoding][]=$_POST[ningreso];			 		
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.codingreso.value="";
				document.form2.valor.value="";	
				document.form2.ningreso.value="";				
				document.form2.codingreso.select();
		  		document.form2.codingreso.focus();	
		 </script>
		  <?php
		  }
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcoding]);$x++)
		 {		 
		 echo "<tr>
		 		<td style='width:10%' class='saludo1'>
		 			<input name='dcoding[]' value='".$_POST[dcoding][$x]."' style='width:100%;' type='text'>
		 		</td>
		 		<td tyle='width:65%' class='saludo1'>
					 <input name='dncoding[]' value='".$_POST[dncoding][$x]."' style='width:100%;' type='text' >
					 <input name='dncc[]' value='".$_POST[dncc][$x]."' style='width:100%;' type='hidden' >
		 		</td>
		 		<td tyle='width:15%' class='saludo1'>
		 			<input name='dvalores[]' value='".$_POST[dvalores][$x]."' style='width:100%;' type='text'>
		 		</td>
		 	</tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2);
		 }
 			$resultado = convertir($_POST[totalc],"PESOS");
			$_POST[letras]=$resultado." PESOS M/CTE";
		 echo "<tr>
		 		<td style='width:10%'>
		 		</td>
		 		<td style='width:65%' class='saludo2'>Total</td>
		 		<td style='width:15%' class='saludo1'>
		 			<input name='totalcf' type='text' value='$_POST[totalcf]' style='width:100%;' readonly>
		 			<input name='totalc' type='hidden' value='$_POST[totalc]'>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td style='width:20%' class='saludo1'>Son:</td>
		 		<td style='width:80%' colspan='2' >
		 			<input name='letras' type='text' style='width:100%;' value='$_POST[letras]' >
		 		</td>
		 	</tr>";
		?> 
	   </table></div>
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
//	  echo 'PREDIAL';
	  $sqlr="select count(*) from tesosinreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='1' ";
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		while($r=mysql_fetch_row($res))
		 {
			$numerorecaudos=$r[0];
		 }
	  if($numerorecaudos>=0)
	   { 	
	//   $sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='5'";
	//   mysql_query($sqlr,$linkbd);
	//    $sqlr="delete from comprobante_det where id_comp='5 $_POST[idcomp]'";
		//echo $sqlr;
//		mysql_query($sqlr,$linkbd);
	//	$sqlr="delete from pptosinrecibocajappto where idrecibo=$_POST[idcomp]";
		//echo $sqlr;		
	//	mysql_query($sqlr,$linkbd);
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
	   $sqlr="insert into tesosinreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo) values(0,'$fechaf',".$vigusu.",$_POST[idrecaudo],'$_POST[modorec]','$cajas','$cbancos','$_POST[totalc]','S','$_POST[tiporec]')";	  
		if (!mysql_query($sqlr,$linkbd))
		{
	 	echo "
									<script>
										despliegamodalm('visible','2','No se pudo ejecutar la ejecucion');
										document.getElementById('valfocus').value='2';
									</script>";
		}
  		else
  		 {
		 $concecc=mysql_insert_id();
		 }
	   	//************ insercion de cabecera recaudos ************
//		 $concecc=$_POST[idcomp];
		 //echo "ccc".$concecc;
		 echo "<input type='hidden' name='concec' value='$concecc'>";	
		  echo "<script>despliegamodalm('visible','1','Se ha almacenado el Recibo de Caja con exito');</script>";
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
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php		  			 
	//**********************CREANDO COMPROBANTE CONTABLE ********************************	 
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,25,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
		 mysql_query($sqlr,$linkbd);
		 
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
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia='$vigusu'";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL
			
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
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
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
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
	//				 echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
					}
				$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
				$re=mysql_query($sq,$linkbd);
				while($ro=mysql_fetch_assoc($re))
				{
					$_POST[fechacausa]=$ro["fechainicial"];
				}
				$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Vigente $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=round($valorcred-$descpredial,2);
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Vigente $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
					  }
					}
				  }
				 }
			break;  
			case '02': //***
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL			
					  }
					}
				  }
				 }
			
			break;  
			case '03': 
								$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P10' AND MODULO='4' and vigencia=$vigusu";
					$resds=mysql_query($sqlrds,$linkbd);
					while($rowds =mysql_fetch_row($resds))
		   			{
					 $descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);
	//				 echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
					}
				$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
				$re=mysql_query($sq,$linkbd);
				while($ro=mysql_fetch_assoc($re))
				{
					$_POST[fechacausa]=$ro["fechainicial"];
				}
				$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=round($valorcred-$descpredial,2);
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL			
					  }
					}
				  }
				 }
			break;  
			case 'P10': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					//		 echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P01': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P02': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P04': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P05': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P07': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P08': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
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
		  $sqlr="update tesosinreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
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
				$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
				$re=mysql_query($sq,$linkbd);
				while($ro=mysql_fetch_assoc($re))
				{
					$_POST[fechacausa]=$ro["fechainicial"];
				}
				$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred-$tasadesc*$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
					  }
					}
				  }
				 }
			break;  
			case 'P06': //***
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			
			break;  
			case '03': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred-$tasadesc*$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P01': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
					  }
					}
				  }
				 }
			break;  
			case 'P02': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					}
				   }
				  }
				 }
			break;  
			case 'P04': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P05': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P07': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P08': 
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
				 	 					
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
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
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
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
				//		echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
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
	  echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion Predial<img src='imagenes/alert.png'></center></td></tr></table>";
	 }//***FIN DE LA VERIFICACION
	   break;
	   case 2:  //********** INDUSTRIA Y COMERCIO
	   //echo "INDUSTRIA";
		      ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			  $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="select count(*) from tesosinreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='2' AND ESTADO='S'";
	$res=mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	while($r=mysql_fetch_row($res))
	 {
		$numerorecaudos=$r[0];
	 }
	 $sqlr="SELECT ncuotas,pagos,estado from tesoindustria  WHERE id_industria=$_POST[idrecaudo]";
		  $resic=mysql_query($sqlr,$linkbd);
		  $rowic=mysql_fetch_array($resic);
	 	  $ncuotas=$rowic[0];
		  $pagos=$rowic[1];
  if(($numerorecaudos==0) || ($ncuotas-$pagos)>0)
   {   	 
		 $sqlr="insert into tesosinreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo) values(0,'$fechaf',".$_SESSION["vigencia"].",$_POST[idrecaudo],'$_POST[modorec]','$cajas','$cbancos','$_POST[totalc]','S','$_POST[tiporec]')";	  
		if (!mysql_query($sqlr,$linkbd))
		{
	 	echo "
									<script>
										despliegamodalm('visible','2','No se puede ejecutar la peticion');
										document.getElementById('valfocus').value='2';
									</script>";	
		}
  		else
  		 {
		 
		 echo "<script>despliegamodalm('visible','1','Se ha almacenado el Recibo de Caja con Exito ');</script>";
		 $concecc=mysql_insert_id(); 
		 //*************COMPROBANTE CONTABLE INDUSTRIA
		  $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,25,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);
	$idcomp=mysql_insert_id();
	 	  $sqlr="update tesosinreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='2'";
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
//			echo "c:".count($_POST[dcoding]);	

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
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
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
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia='$vigusu'";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL
			
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
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
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
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
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 	$res=mysql_query($sqlri,$linkbd);
	//     echo "$sqlri <br>";	    
		  while($row=mysql_fetch_row($res))
		  {
			if($row[2]=='04') //*****industria
			  {
					$sq="select fechainicial from conceptoscontables_det where codigo='04' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
					$re=mysql_query($sq,$linkbd);
					while($ro=mysql_fetch_assoc($re))
					{
						$_POST[fechacausa]=$ro["fechainicial"];
					}
					$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='04' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$industria+$sanciones;
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Industria y Comercio $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
	//					echo "<br>$sqlr";
						//********** CAJA O BANCO
						 //*** retencion ica
						$sq="select fechainicial from conceptoscontables_det where codigo='P11' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
						$re=mysql_query($sq,$linkbd);
						while($ro=mysql_fetch_assoc($re))
						{
							$_POST[fechacausa]=$ro["fechainicial"];
						}
						$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
					$rescr=mysql_query($sqlr2,$linkbd);
					 while($rowcr=mysql_fetch_row($rescr))
					  {
					   if($rowcr[3]=='N')
						{
						 if($rowcr[6]=='S')
						 {
							$cuentaretencion= $rowcr[4];
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentaretencion."','".$_POST[tercero]."','".$row2[5]."','Retenciones Industria y Comercio','',".$retenciones.",0,'1','".$_POST[vigencia]."')";
							mysql_query($sqlr,$linkbd);
						 }
						}
					  }
					  //**fin rete ica
						 $valordeb=$industria+$sanciones;
						 $valorcred=0;
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','Industria y Comercio $_POST[modorec]','',".($valordeb-$retenciones).",0,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$valordeb  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
					 $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$valordeb,'".$vigusu."')";
						 //echo "ic rec:".$sqlr;
  						  mysql_query($sqlr,$linkbd);	
						 }
						}
					  }
			  }
			if($row[2]=='05')//************avisos
			  {
				$sq="select fechainicial from conceptoscontables_det where codigo='05' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
				$re=mysql_query($sq,$linkbd);
				while($ro=mysql_fetch_assoc($re))
				{
					$_POST[fechacausa]=$ro["fechainicial"];
				}
				$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='05' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$avisos;					
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Avisos y Tableros $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
//						echo "<br>$sqlr";						
						//********** CAJA O BANCO
						 $valordeb=$avisos;
						 $valorcred=0;
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','Avisos y Tableros $_POST[modorec]','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$avisos  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
						 $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$avisos,'".$vigusu."')";
						//  echo "av rec:".$sqlr;
		  			  mysql_query($sqlr,$linkbd);	
						

						 }
						}						
					  }
			  }
			if($row[2]=='06') //*********bomberil ********
			  {
					$sq="select fechainicial from conceptoscontables_det where codigo='06' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
					$re=mysql_query($sq,$linkbd);
					while($ro=mysql_fetch_assoc($re))
					{
						$_POST[fechacausa]=$ro["fechainicial"];
					}
					$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='06' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$bomberil;					
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Bomberil $_POST[ageliquida]','',".$valordeb.",$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
		//				echo "<br>$sqlr";						
						//********** CAJA O BANCO
						 $valordeb=$bomberil;
						 $valorcred=0;
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','Bomberil $_POST[modorec]','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);
			//***MODIFICAR PRESUPUESTO
						$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$bomberil  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
						 $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$bomberil,'".$vigusu."')";
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
	 {
	  echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion <img src='imagenes/alert.png'></center></td></tr></table>";
	 }
		 
		break; 
	  case 3: //**************OTROS RECAUDOS
	$sqlr="select count(*) from tesosinreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='3' AND ESTADO='S'";
	$res=mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	while($r=mysql_fetch_row($res))
	 {
		$numerorecaudos=$r[0];
	 }
  if($numerorecaudos==0)
   { 
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$concecc=0;
	$sqlr="select max(id_recibos ) from tesosinreciboscaja  ";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $concecc=$r[0];	  
	 }
	 $concecc+=1;
	 // $consec=$concecc;
//***cabecera comprobante
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,25,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);
	$idcomp=mysql_insert_id();
	
	 $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($concecc,18,'$fechaf','INGRESOS PROPIOS $_POST[concepto]',$vigusu,0,0,0,'1')";
	 	  mysql_query($sqlr,$linkbd);
		//echo "$sqlr <br>";	  
	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
			$porce=$rowi[5];
			$vi=$_POST[dvalores][$x]*($porce/100);
	    //**** busqueda cuenta presupuestal*****
			$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$rowi[6]."','".$_POST[tercero]."','INGRESO PROPIO',".$vi.",0,'1','$_POST[vigencia]',18,'$concecc','201','1','','$fechaf')";
	  mysql_query($sqlr,$linkbd); 	
			//echo "$sqlr <br>";	  
			//busqueda concepto contable
			$sq="select fechainicial from conceptoscontables_det where codigo='".$rowi[2]."' and modulo='4' and tipo='C'  and cc='".$_POST[dncc][$x]."' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'  and cc='".$_POST[dncc][$x]."' and fechainicial='".$_POST[fechacausa]."'";
	 	 $resc=mysql_query($sqlrc,$linkbd);	  
		// 		echo "concc: $sqlrc - $_POST[cobrorecibo]<br>";	      
		while($rowc=mysql_fetch_row($resc))
		 {
	  		 if($_POST[dcoding][$x]==$_POST[cobrorecibo])
			 {
			  //$columna= $rowc[7];
			//  echo "cred  $rowc[7]<br>";	      
			  if($rowc[7]=='S')
  			  {
			  $columna= $rowc[7];
			   }
			  else
			  {
				  $columna= 'N';
				}
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
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia='$vigusu'";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$_POST[dvalores][$x]*($porce/100);
			
			  
			//************ FIN MODIFICACION PPTAL
			
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentacont."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
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
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				
				
			
				//echo "Conc: $sqlr <br>";					
				}
			
			  }
		 }
		 }
	}	
	//************ insercion de cabecera recaudos ************

	$sqlr="insert into tesosinreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo) values($idcomp,'$fechaf',".$vigusu.",$_POST[idrecaudo],'$_POST[modorec]','$cajas','$cbancos','$_POST[totalc]','S','$_POST[tiporec]')";	  
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "
									<script>
										despliegamodalm('visible','2','No se pudo ejecutar la petici�n');
										document.getElementById('valfocus').value='2';
									</script>";
	}
  		
		else
  		 {
		  echo "<script>despliegamodalm('visible','1','Se ha almacenado el Recibo de Caja con Exito ');</script>";
		  $sqlr="update tesosinrecaudos set estado='P' WHERE ID_RECAUDO=$_POST[idrecaudo]";
		  mysql_query($sqlr,$linkbd);

		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php
		  }
    } //fin de la verificacion
	 else
	 {
	  echo "<table ><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion <img src='imagenes/alert.png'></center></td></tr></table>";
	 }
	   break;
	   //********************* INDUSTRIA Y COMERCIO
	} //*****fin del switch
	$_POST[ncomp]=$concecc;
	//******* GUARDAR DETALLE DEL RECIBO DE CAJA ******	
		for($x=0;$x<count($_POST[dcoding]);$x++)
		 {
		  $sqlr="insert into tesosinreciboscaja_det (id_recibos,ingreso,valor,estado) values($concecc,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	  
		  mysql_query($sqlr,$linkbd);  
	//	  echo $sqlr."<br>";
		 }		
	//***** FIN DETALLE RECIBO DE CAJA ***************		
	  }
  else
   {
    echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
   }
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
 </td></tr>
</table>
</body>
</html>