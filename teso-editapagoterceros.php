<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
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
		<title>:: SPID - Tesoreria</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function agregardetalled()
			{
				if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
				{ 
					document.form2.agregadetdes.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
 				}
 				else 
				{alert("Falta informacion para poder Agregar");}
			}
			function eliminard(variable)
			{
				document.form2.eliminad.value=variable;
				document.form2.submit();
			}
			function guardar()
			{
				if (document.form2.fecha.value!='' && document.form2.tercero.value!='' && document.form2.banco.value!='')
  				{
					if (confirm("Esta Seguro de Guardar"))
  					{
  						document.form2.oculto.value=2;
  						document.form2.submit();
  					}
  				}
  				else
				{
  					alert('Faltan datos para completar el registro');
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
  				}
			}
			function calcularpago()
 			{
				valorp=document.form2.valor.value;
				descuentos=document.form2.totaldes.value;
				valorc=valorp-descuentos;
				document.form2.valorcheque.value=valorc;
				document.form2.valoregreso.value=valorp;
				document.form2.valorretencion.value=descuentos;
 			}
			function pdf()
			{
				document.form2.action="pdfpagoterceros.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscater(e)
 			{
				if (document.form2.tercero.value!="")
				{
 					document.form2.bt.value='1';
					document.form2.submit();
				}
 			}
 			function adelante(){
				if(document.form2.siguiente.value!=''){
					location.href="teso-editapagoterceros.php?idpago="+document.form2.siguiente.value;
				}
			}
		
			function atrasc(){
				if(document.form2.anterior.value!=''){
					location.href="teso-editapagoterceros.php?idpago="+document.form2.anterior.value;
				}
			}
			function iratras()
			{
				var idcta=document.getElementById('idcomp').value;
				location.href="teso-buscapagoterceros.php?idt="+idcta;
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
  					<a onClick="location.href='teso-pagoterceros.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
  					<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
  					<a class="mgbt" onClick="location.href='teso-buscapagoterceros.php'"><img src="imagenes/busca.png" title="Buscar"/></a>
  					<a onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  					<a class="mgbt" onClick="pdf()"><img src="imagenes/print.png" title="Imprimir" /></a>
  					<a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s">
  				</td>
			</tr>		  
		</table>
		<form name="form2" method="post" action=""> 
			<?php
				$vigencia=date(Y);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$sqlr="select *from cuentamiles where estado='S' ";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){$_POST[cuentamiles]=$row[1];}
	  			//*********** cuenta origen va al credito y la destino al debito

				$sqlr="select *from tesopagoterceros where tesopagoterceros.id_pago>-1 order by tesopagoterceros.id_pago";
				$res=mysql_query($sqlr,$linkbd);
				$contacu=0;
				$_POST[actual]=$_GET[idpago];
				while ($row=mysql_fetch_row($res)){
					if($contacu==0){
						$_POST[anterior]='';
					}
					if($row[0]==$_POST[actual]){
						$row=mysql_fetch_row($res);
						$_POST[siguiente]=$row[0];
						break;
					}
					$_POST[anterior]=$row[0];
					$contacu+=1;
					//echo "Anterior: ".$_POST[anterior]." Siguiente: ".$_POST[siguiente];
				}
				if(!$_POST[oculto])
				{
					$sqlr="select *from cuentapagar where estado='S' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
					$sqlr="select *from cuentamiles where estado='S' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentamiles]=$row[1];}
					$check1="checked";
					//$fec=date("d/m/Y");
					//$_POST[fecha]=$fec; 		 		  			 
					//$_POST[valor]=0;
					//$_POST[valorcheque]=0;
					//$_POST[valorretencion]=0;
					//$_POST[valoregreso]=0;
					//$_POST[totaldes]=0;
		 			$_POST[vigencia]=$vigusu; 		
	 				$sqlr="select * from tesopagoterceros where id_pago=$_GET[idpago]";
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					while($r=mysql_fetch_row($res))
		 			{
		  				$consec=$r[0];	  
		  				$fec=$r[10];
  		  				$_POST[fecha]=$fec; 		 		  		
	  	  				ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
		  				$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
  		  				$_POST[fecha]=$fechaf; 		 		  			 
		  				if ($r[3]!='')
		  				{
							$_POST[tipop]="cheque";
		  					$_POST[ncheque]=$r[3];		  
		  				}
		  				if($r[4]!='')
		  				{
							$_POST[tipop]="transferencia";		  
		  					$_POST[ntransfe]=$r[4];
		 				}
						if($r[4]=='' and $r[3]==''){
							$_POST[tipop]="caja";
						}
		  				$_POST[mes]=$r[6];
		  				$_POST[banco]=$r[2]; 		 		  			
 		  				$_POST[tercero]=$r[1]; 		 		  			
		  				$_POST[ntercero]=buscatercero($r[1]); 		 		  					  
		  				$_POST[cc]=$r[8]; 		 		  			
						$_POST[concepto]=$r[7];
						$_POST[valorpagar]=$r[5];
						$_POST[estado]=$r[9];
						$_POST[ajuste]=$r[11];	
		  				if($r[11]==1){$_POST[valorpagarmil]=round($_POST[valorpagar],0);}	  
						$_POST[vigencias]=$r[12];
	 				}
					//$consec+=1;
	 				$_POST[idcomp]=$consec;	
					$sqlr="select * from tesopagoterceros_det where id_pago=$_GET[idpago]";
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					$_POST[mddescuentos]=array();
					$_POST[mtdescuentos]=array();		
					$_POST[mddesvalores]=array();
					$_POST[mddesvalores2]=array();		
					$_POST[mdndescuentos]=array();
					$_POST[mdctas]=array();		
					while($r=mysql_fetch_row($res))
		 			{
		 				$_POST[ddescuentos][]=$r[1];
		 				$_POST[dndescuentos][]=$r[2].'-'.$r[1];
 		   				//mddescuentos
		   				$_POST[mtdescuentos][]=$r[2];
		   				if($r[2]=='I'){$_POST[mdndescuentos][]=buscaingreso($r[1]);}
		   				else {$_POST[mdndescuentos][]=buscaretencion($r[1]);}		  
	   	   				$_POST[mddesvalores][]=$r[3];
		   				$_POST[mddesvalores2][]=$r[3];
		  				$_POST[mddescuentos][]=$r[1];
		   				$_POST[mdctas][]=$r[4];
					}
				}
				$vact=$vigusu; 
				$meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
  				if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!=''){$_POST[ntercero]=$nresul;}
			 		else {$_POST[ntercero]="";}
			 	}	
			?>
	   		<table class="inicio" align="center" >
		   		<tr>
		     		<td colspan="8" class="titulos">Pago Terceros - Otros Pagos</td>
	                <td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
	          	</tr>
	      	 	<tr> 
            		<td style='width:11%;' class="saludo1" >N&uacute;mero Pago:</td>
        			<td style='width:15%;'>
        				<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
		        		<input type="hidden" name="anterior" id="anterior" value="<?php echo $_POST[anterior] ?>">
		        		<input type="hidden" name="actual" id="actual" value="<?php echo $_POST[actual] ?>">
                		<input name="cuentamiles" type="hidden"  value="<?php echo $_POST[cuentamiles]?>" readonly>
                		<input name="idcomp" id="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" readonly>
                		<a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
						<input type="hidden" name="siguiente" id="siguiente" value="<?php echo $_POST[siguiente] ?>">
                	</td>
	  				<td class="saludo1">Fecha: </td>
        			<td >
        				<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">&nbsp;
        				<a onClick="displayCalendarFor('fc_1198971545');" title="Calendario">
        					<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer"/>
        				</a>
        			</td>
	 			 	<td   class="saludo1">Vigencia: </td>
        			<td >
        				<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="4" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:50%;" readonly>
        			
         		</tr>
       			<tr>
            		<td class="saludo1">Forma de Pago:</td>
       				<td >
       					<select name="tipop" onChange="validar();">
       						<option value="">Seleccione ...</option>
				  			<option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
  				  			<option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
							<option value="caja" <?php if($_POST[tipop]=='caja') echo "SELECTED"?>>Caja</option>
						</select>
          			</td>
       				<td class="saludo1">Mes:</td>
       				<td >
       					<select name="mes" onChange="validar()">
      						<option value="">Seleccione ...</option>
		   					<?php
			   					for($x=1;$x<=12;$x++)
								{
									echo"<option value='$x'"; 
									if($_POST[mes]==$x) {echo " SELECTED>";}
									else {echo">";}
									echo "$meses[$x]</option>";
								}
			  				?>  
          				</select> 
                    	<select name="vigencias" id="vigencias" onChange="validar()" style="width:40%;">
      						<option value="">Sel..</option>
	  						<?php	  
     							for($x=$vact;$x>=$vact-2;$x--)
	  							{
		 							if($x==$_POST[vigencias]){echo "<option value='$x' SELECTED>$x</option>";}
									else {echo "<option value='$x'>$x</option>";}
								}
	  						?>
      					</select> 
          			</td>  
          			<td class="saludo1">Estado: </td>
        			<td>
					<input name="estado" type="hidden"  value="<?php echo $_POST[estado]?>" onKeyUp="return tabular(event,this) "  readonly>
        					<?php 
	                  				if($_POST[estado]=="S"){
				                    	$valuees="ACTIVO";
				                    	$stylest="width:50%; background-color:#0CD02A; color:white; text-align:center;";
				                    }else if($_POST[estado]=="N"){
				                    	$valuees="ANULADO";
				                    	$stylest="width:50%; background-color:#FF0000; color:white; text-align:center;";
				                    }else if($_POST[estado]=="P"){
				                    	$valuees="PAGO";
				                    	$stylest="width:50%; background-color:#0404B4; color:white; text-align:center;";
				                    }

				                    echo "<input type='text' name='estadoc' id='estadoc' value='$valuees' style='$stylest' readonly />";
                  				?>
        				
        			</td>         
       			</tr>
		         	<?php 
			 			//**** if del cheques
			  			if($_POST[tipop]=='cheque')
			    		{
			  				echo"   
		          			<tr>
			  					<td class='saludo1'>Cuenta Bancaria:</td>
			  					<td>
			    					<select id='banco' name='banco'  onChange='validar()' onKeyUp='return tabular(event,this)'>
			      						<option value=''>Seleccione....</option>";
							$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial, tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
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
								else {echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";} 	 
							}	
							echo" 	
		            				</select>
									<input name='cb' type='hidden' value='$_POST[cb]'/>
									<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/>
								</td>
								<td colspan='2'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%;' readonly></td>
								<td class='saludo1'>Cheque:</td>
								<td width='102'><input type='text' id='ncheque' name='ncheque' value='$_POST[ncheque]' size='20'></td>
			  				</tr>";
			     		}//cie	rre del if de cheques
			  			if($_POST[tipop]=='transferencia')//**** if del transferencias
			    		{
			 				echo" 
		      				<tr>
			  					<td class='saludo1'>Cuenta Bancaria:</td>
			  					<td >
			     					<select id='banco' name='banco'  onChange='validar()' onKeyUp='return tabular(event,this)'>
			      						<option value=''>Seleccione....</option>";
							$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial, tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
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
							 	else {echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";}	 	 
							}	 	
							echo"
		            				</select>
									<input name='cb' type='hidden' value='$_POST[cb]'/>
		                            <input type='hidden' id='ter' name='ter' value='$_POST[ter]'/>
								</td>
								<td colspan='2'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%;' readonly/></td>
								<td class='saludo1'>No Transferencia:</td>
								<td ><input type='text' id='ntransfe' name='ntransfe' value='$_POST[ntransfe]' style='width:50%;'/></td>
			  				</tr>";
			     		}//cierre del if de cheques   
		      		?> 
				<tr> 
      				<td  class="saludo1">Tercero:</td>
          			<td >
          				<input id="tercero" type="text" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" >
          				<a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px'); mypop.focus();">
          					<img src="imagenes/buscarep.png" align="absmiddle" border="0">
          				</a>
           			</td>
           			<td colspan="2">
           				<input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly>
           				<input type="hidden" value="0" name="bt">
           			</td>
           			<td class="saludo1">Centro Costo:</td>
           			<td colspan="3">
						<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
						<?php
						$linkbd=conectar_bd();
						$sqlr="select *from centrocosto where estado='S'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
									    {
										echo "<option value=$row[0] ";
										$i=$row[0];
							
										 if($i==$_POST[cc])
								 			{
											 echo "SELECTED";
											 }
										  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
										}	 	
						?>
					   </select>
	 				</td>
	 			</tr>
          		<tr>
              		<td class="saludo1">Concepto</td>
              		<td colspan="3">
              			<input type="text" name="concepto" style='width:100%;' value="<?php echo $_POST[concepto]?>" >
              		</td> 
          	  		<td class="saludo1">Valor a Pagar:</td>
          	  		<td>
          	  			<input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo round($_POST[valorpagar],0) ?>" style="width:50%;" readonly>
          	  		</td>
          	  	</tr>
      			<tr> 
      				<td class="saludo1">Retenciones e Ingresos:</td>
					<td colspan="1">
						<select name="retencion" style='width:100%;' onChange="validar()" onKeyUp="return tabular(event,this)">
							<option value="">Seleccione ...</option>
							<?php
							//PARA LA PARTE CONTABLE SE TOMA DEL DETALLE DE LA PARAMETRIZACION LAS CUENTAS QUE INICIAN EN 2**********************	
								$sqlr="SELECT TB3.* FROM tesoretenciones TB3 WHERE TB3.estado='S' AND TB3.terceros='1' AND TB3.id NOT IN(SELECT TB1.movimiento FROM tesopagoterceros_det TB1, tesopagoterceros TB2 WHERE TB1.id_pago=TB2.id_pago AND TB1.tipo='R' AND TB2.anos='$_POST[vigencias]' AND TB2.mes='$_POST[mes]')";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									if('R-'."$row[0]"==$_POST[retencion])
			 						{	
						 				echo "<option value='R-$row[0]' SELECTED>R - $row[1] - $row[2]</option>";
						  				$_POST[nretencion]='R - '.$row[1]." - ".$row[2];
						 			}
									else{echo "<option value='R-$row[0]'>R - $row[1] - $row[2]</option>";} 
								}	 	
								$sqlr="SELECT TB3.* FROM tesoingresos TB3 WHERE TB3.estado='S' AND TB3.terceros='1' AND TB3.codigo NOT IN(SELECT TB1.movimiento FROM tesopagoterceros_det TB1, tesopagoterceros TB2 WHERE TB1.id_pago=TB2.id_pago AND TB1.tipo='I' AND TB2.anos='$_POST[vigencias]' AND TB2.mes='$_POST[mes]')"; 
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
									if('I-'."$row[0]"==$_POST[retencion])
			 						{
						 				echo "<option value='I-$row[0]' SELECTED>I - $row[1] - $row[2]</option>";
						 				$_POST[nretencion]='I - '.$row[1]." - ".$row[2];
									}
					 				else{echo "<option value='I-$row[0]'>I - $row[1] - $row[2]</option>";} 
								}	 	
							?>
   						</select>
					</td> 
					
        			<td class="saludo1">Ajuste Miles:        
          				<input type="checkbox" name="ajuste" id="ajuste"  value="1" onClick="document.form2.submit()" <?php  if($_POST[ajuste]==1) echo "checked"; ?>>
          			</td>
          			<td>
          				<input name="valorpagarmil" type="text" id="valorpagarmil" onKeyUp="return tabular(event,this)" value="<?php echo round($_POST[valorpagarmil],0) ?>" readonly>
          				<input name="diferencia" type="text" id="diferencia" onKeyUp="return tabular(event,this)" value="<?php echo round($_POST[diferencia],0) ?>" size="5" readonly>
          			</td>
          			<td >
						<input type="hidden" value="<?php echo $_POST[nretencion]?>" name="nretencion">
						<input type="hidden" value="1" name="oculto">
						<input type="button" name="agregard" id="agregard" value="   Agregar   " onClick="agregardetalled()" >
						<input type="hidden" value="0" name="agregadetdes">
					</td>
          		</tr>	
      		</table>       
         <?php
           //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
			  <script>
			  document.getElementById('retencion').focus();document.getElementById('retencion').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				alert("Tercero Incorrecto o no Existe")				   		  	
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
			 ?>             
	  <div class="subpantallac4">
       <table class="inicio" >
        <tr><td class="titulos">Retenciones / Ingresos</td>
		<td class="titulos" style='width:15%;'>Contabilidad</td><td class="titulos" style='width:15%;'>Valor</td></tr>        
      	<?php		
		$totalpagar=0;
		//**** buscar movimientos		
		//********************************
		for ($x=0;$x<count($_POST[mddescuentos]);$x++)
		 {		 
		 echo "<tr><td class='saludo2'><input name='mdndescuentos[]' value='".$_POST[mdndescuentos][$x]."' type='text' style='width:100%;' readonly><input name='mddescuentos[]' value='".$_POST[mddescuentos][$x]."' type='hidden'><input name='mtdescuentos[]' value='".$_POST[mtdescuentos][$x]."' type='hidden'></td><td class='saludo2'><input name='mdctas[]' value='".$_POST[mdctas][$x]."' type='text' style='width:100%;' readonly></td>";
		echo "<td class='saludo2'><input name='mddesvalores[]' value='".round($_POST[mddesvalores][$x],0)."' type='hidden'><input name='mddesvalores2[]' value='".($_POST[mddesvalores2][$x])."' type='text' style='width:100%;' readonly></td></tr>";
		 }		 
		 $vmil=0;
		if($_POST[ajuste]=='1')
		 {
		$vmil=round(array_sum($_POST[mddesvalores]),-3);	 
		  }
		  else
		  {
		$vmil=array_sum($_POST[mddesvalores]);			  
		  }
		$resultado = convertir(round($vmil,0));
		$_POST[letras]=$resultado." PESOS M/CTE";
		 echo "<tr><td></td><td>Total:</td>
			<td>
				<input type='hidden' name='totalpago2' value='".round(array_sum($_POST[mddesvalores]),0)."' >
				
				<input type='text' name='totalpago' value='".number_format(array_sum($_POST[mddesvalores]),0)."' style='width:100%;' readonly></td></tr>";
		 echo "<tr>

		 <td colspan='3' style='text-align:right;'>Son:		
			<input name='letras' type='text' value='$_POST[letras]' style='width:97%;' ></td>";
		$dif=$vmil-array_sum($_POST[mddesvalores]);
		?>
        <script>
        document.form2.valorpagar.value=<?php echo round(array_sum($_POST[mddesvalores]),0);?>;	
        document.form2.valorpagarmil.value=<?php echo $vmil;?>;	
		document.form2.diferencia.value=<?php echo round($dif,0);?>;			//calcularpago();
        </script>
        </table>
	   </div>
        <?php	  
	//  echo "oculto".$_POST[oculto];
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	$p1=substr($_POST[fecha],0,2);
	$p2=substr($_POST[fecha],3,2);
	$p3=substr($_POST[fecha],6,4);
	$fechaf=$p3."-".$p2."-".$p1;	
	//$fechaf=$_POST[fecha];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	if($bloq>=1)
	{
	$sqlr="delete from tesopagoterceros where id_pago=$_POST[idcomp]";	
	mysql_query($sqlr,$linkbd);
	$sqlr="delete from tesopagoterceros_det where id_pago=$_POST[idcomp]";	
	mysql_query($sqlr,$linkbd);
	$sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp=12";	
	mysql_query($sqlr,$linkbd);
	$sqlr="delete from comprobante_det where numerotipo=$_POST[idcomp] and tipo_comp=12";	
	mysql_query($sqlr,$linkbd);
	//**verificacion de guardado anteriormente *****
	//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	//$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
//************CREACION DEL COMPROBANTE CONTABLE ************************
$sqlr="insert into tesopagoterceros (id_pago,tercero,banco,cheque,transferencia,valor,mes,concepto,cc,estado,fecha,ajuste,anos) values ($_POST[idcomp],'$_POST[tercero]','$_POST[banco]', '$_POST[ncheque]','$_POST[ntransfe]',$_POST[valorpagar],'$_POST[mes]','$_POST[concepto]', '$_POST[cc]','S','$fechaf','$_POST[ajuste]','$_POST[vigencias]')";
	mysql_query($sqlr,$linkbd);
	//echo "$sqlr <br>";	
//***busca el consecutivo del comprobante contable
$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($_POST[idcomp] ,12,'$fechaf','$_POST[concepto]',0,$totalpagar,$totalpagar,0,'1')";
	mysql_query($sqlr,$linkbd);
	echo "<br>C:".count($_POST[mddescuentos]);
	for ($x=0;$x<count($_POST[mddescuentos]);$x++)
	 {		
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('12 $_POST[idcomp]','".$_POST[mdctas][$x]."','".$_POST[tercero]."','".$_POST[cc]."','PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',".$_POST[mddesvalores][$x].",0,'1','". $_POST[vigencia]."')";
			//echo "$sqlr <br>";
			mysql_query($sqlr,$linkbd);  
		  
		 //*** Cuenta BANCO **
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('12 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',0,".$_POST[mddesvalores][$x].",'1','". $_POST[vigencia]."')";
			mysql_query($sqlr,$linkbd);
			//echo "$sqlr <br>";	
			
			$sqlr="insert into tesopagoterceros_det(`id_pago`, `movimiento`, `tipo`, `valor`, `cuenta`, `estado`) values ($_POST[idcomp],'".$_POST[mddescuentos][$x]."','".$_POST[mtdescuentos][$x]."',".$_POST[mddesvalores][$x].",'".$_POST[mdctas][$x]."','S')";
					mysql_query($sqlr,$linkbd);					  
	  }
	  if($_POST[diferencia]<>0)
	 	{
		 if($_POST[diferencia]>0)
		 {
			 $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('12 $_POST[idcomp]','".$_POST[cuentamiles]."','".$_POST[tercero]."','".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',".$_POST[diferencia].",0,'1','".$vigusu."')";
		//	echo "$sqlr <br>";
			mysql_query($sqlr,$linkbd);  
		  
		 //*** Cuenta BANCO **
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('12 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',0,".abs($_POST[diferencia]).",'1','". $_POST[vigencia]."')";
			mysql_query($sqlr,$linkbd);
		 }
		 if($_POST[diferencia]<0)
		 {
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('12 $_POST[idcomp]','".$_POST[cuentamiles]."','".$_POST[tercero]."','".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',0,".abs($_POST[diferencia]).",'1','". $_POST[vigencia]."')";
		//	echo "$sqlr <br>";
			mysql_query($sqlr,$linkbd);  
		  
		 //*** Cuenta BANCO **
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('12 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',".abs($_POST[diferencia]).",0,'1','". $_POST[vigencia]."')";
			mysql_query($sqlr,$linkbd); 
		 }
		}
	   echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recaudo a Terceros con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
	 }//*** if de guardado
	 else
	  {
		echo "<table class='inicio'><tr><td class='saludo1'><center><img src='imagenes/alert.png'>No tiene los privilegios suficientes</center></td></tr></table>";  
	  }		
}
?>	
</form>
</body>
</html>	 