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
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'"; 
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function agregardetalle()
			{
				var validacion00=document.getElementById('numero').value;
				if(validacion00.trim()!='' &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
 				}
 				else {despliegamodalm('visible','2','Falta informacion para poder agregar');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de eliminar el detalle','1');
			}
			function guardar()
			{
				if (document.form2.fecha.value!=''){despliegamodalm('visible','4','Esta Seguro de Guardar','2');}
  				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
  				}
			}
			function pdf()
			{
				document.form2.action="teso-pdfconsignaciones.php";
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
			function funcionmensaje(){document.location.href = "teso-consignaciones.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="5";
								document.form2.submit();break;
					case "2":	document.form2.oculto.value="2";
								document.form2.submit();break;
				}
			}
			jQuery(function($){ $('#valorvl').autoNumeric('init');});
		</script>
		<script>
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('idcomp').value;
				location.href="teso-buscaconsignaciones.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <?php $numpag=$_GET[numpag];$limreg=$_GET[limreg];$scrtop=34*$totreg;?>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
				<a class="mgbt" href="teso-consignaciones.php"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"href="#" onClick="guardar();"><img src="imagenes/guarda.png" title="Guardar" /></a>
				<a class="mgbt" href="teso-buscaconsignaciones.php"><img src="imagenes/busca.png"  title="Buscar" /></a>
				<a class="mgbt" href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				<a class="mgbt" href="#" onClick="pdf()"><img src="imagenes/print.png"  title="Buscar" /></a>
				<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
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
				$vigencia=date(Y);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
	  			//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
				if(!$_POST[oculto])
				{
					$sqlr="select cuentacaja from tesoparametros";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) {$_POST[cuentacaja]=$row[0];}

					$sqlr="SELECT * FROM tesoconsignaciones_cab, tesoconsignaciones,terceros,tesobancosctas WHERE	tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban= tesoconsignaciones.ncuentaban and tesobancosctas.estado='S'
 and tesoconsignaciones_cab.id_consignacion=$_GET[idr]  AND tesoconsignaciones_cab.ID_CONSIGNACION=tesoconsignaciones.ID_CONSIGNACIONCAB";
					$res=mysql_query($sqlr,$linkbd);
					$cont=0;
					$_POST[comp]=$_GET[idr];
					$_POST[idcomp]=$_GET[idr];
					$_POST[ncomp]=$_GET[idr];
					$total=0;
					while ($row =mysql_fetch_row($res)) 
					{	
						$_POST[fecha]=$row[2];
						if($row[4]=='S'){$_POST[estado]=1;}
						else {$_POST[estado]=0;}
						$_POST[dccs][$cont]=$row[10];
						$_POST[dconsig][$cont]=$row[9];			 
						$_POST[dbancos][$cont]=$row[39];		 
						$_POST[dnbancos][$cont]=$row[22];		 
						$_POST[dcts][$cont]=$row[29];
						$_POST[dcbs][$cont]=$row[11];
						$_POST[concepto]=$row[5];
						$total=$total+$row[15]; 
						$_POST[totalc]=$total;
						$_POST[dvalores][$cont]=$row[15];
						$cont=$cont+1;		
					}		
				}
			?>
    		<table class="inicio" align="center" >
      			<tr>
       				<td class="titulos" colspan="7">.: Editar Consignaciones</td>
        			<td class="cerrar" style="width:7%;"><a href="teso-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
      				<td class="saludo1" style="width:4cm;">Numero Comp:</td>
        			<td style="width:20%;"><input type="text" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" readonly style="width:45%;"/><input type="hidden" name="estado" id="estado" value="<?php echo $_POST[estado]?>" readonly ></td>
	  				<td class="saludo1" style="width:3cm;">Fecha:</td>
        			<td  style="width:30%;">
						<input id="fc_1198971545" title="DD/MM/YYYY" name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)">   
					<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>
					</td>  
                     <td rowspan="4" style="background:url(imagenes/invoice.png); background-repeat:no-repeat; background-position:center; background-size: 75% 110%"></td>              	
               	</tr>
                <tr>
        			<td  class="saludo1">Concepto Consignaci&oacute;n:</td>
        			<td colspan="3"><input type="text" name="concepto" id="concepto"  value="<?php echo $_POST[concepto]?>"  onKeyUp="return tabular(event,this)" style="width:100%;"></td> 
        		</tr>
        		<tr>
        	  		<td class="saludo1">N� Consignaci&oacute;n:</td>
        			<td ><input type="text" name="numero" id="numero"  value="<?php echo $_POST[numero]?>" onKeyUp="return tabular(event,this)" style="width:90%;"></td>
					<td class="saludo1">Cuenta Bancaria:</td>
	  				<td>
	    				<select id="banco" name="banco" onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%">
	      					<option value="">Seleccione....</option>
		  					<?php
								$sqlr="SELECT TB.estado,TB.cuenta,TB.ncuentaban,TB.tipo,T.razonsocial,TB.tercero FROM tesobancosctas TB,terceros T WHERE TB.tercero=T.cedulanit and TB.estado='S' ";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
									echo "";
									if($row[1]==$_POST[banco])
			 						{
						 				echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3] - $row[4]</option>";
										$_POST[nbanco]=$row[4];
						 				$_POST[cb]=$row[2];
						 				$_POST[ct]=$row[5];
						 			}
									else{echo "<option value='$row[1]'>$row[2] - Cuenta $row[3] - $row[4]</option>";}
								}	 	
							?>
            			</select> 
                        <input type="hidden" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" readonly/>
                        <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
                        <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
                	</td>
       			</tr> 
	  			<tr>
	  				<td class="saludo1">Centro Costo:</td>
                    <td >
						<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:90%;">
							<?php
								$sqlr="select *from centrocosto where estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				   				{
					 				if($row[0]==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else{echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}	 	
							?>
   						</select>
	 				</td>	  
                    <td class="saludo1">Valor:</td>
                    <td >
                    	<input type="hidden" id="valor" name="valor" value="<?php echo $_POST[valor]?>"/>
                    	<input type="text" id="valorvl" name="valorvl" value="<?php echo $_POST[valorvl]?>" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('valor','valorvl');return tabular(event,this);" style="width:45%;text-align:right;"/>&nbsp;
                        <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" />
                 	</td>
	  			</tr> 
	  		</table>
            <input type="hidden" name="agregadet" value="0">
            <input type="hidden" name="oculto" id="oculto" value="1" >
            <input type="hidden" name="cuentacaja" value="<?php echo $_POST[cuentacaja] ?>" >
	  		<div class="subpantallac7" style="height:56.7%; width:99.6%; overflow-x:hidden;">
	   			<table class="inicio">
	   	   			<tr><td colspan="6" class="titulos">Detalle Consignaciones</td></tr>                  
					<tr>
                    	<td class="titulos2" style='width:10%'>CC</td>
                        <td class="titulos2" style='width:15%'>Consignacion</td>
                        <td class="titulos2" style='width:20%'>Cuenta Bancaria</td>
                        <td class="titulos2">Banco</td>
                        <td class="titulos2" style='width:20%'>Valor</td>
                        <td class="titulos2" style='width:5%'><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td>
                   	</tr>
					<?php 		
						if ($_POST[oculto]=='5')
						{ 
		 					$posi=$_POST[elimina];
		 					unset($_POST[dccs][$posi]);
		 					unset($_POST[dconsig][$posi]);
		  					unset($_POST[dbancos][$posi]);
							unset($_POST[dnbancos][$posi]);		 
 							unset($_POST[dcbs][$posi]);	
							unset($_POST[dcts][$posi]);			 
							unset($_POST[dvalores][$posi]);			  
							$_POST[dccs]= array_values($_POST[dccs]); 
							$_POST[dconsig]= array_values($_POST[dconsig]);  
							$_POST[dbancos]= array_values($_POST[dbancos]); 
							$_POST[dnbancos]= array_values($_POST[dnbancos]); 
							$_POST[dcbs]= array_values($_POST[dcbs]); 		 
							$_POST[dcts]= array_values($_POST[dcts]); 		 		 
							$_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 				}	 
		 				if ($_POST[agregadet]=='1')
		 				{
							$_POST[dccs][]=$_POST[cc];
						 	$_POST[dconsig][]=$_POST[numero];			 
						 	$_POST[dbancos][]=$_POST[banco];		 
						 	$_POST[dnbancos][]=$_POST[nbanco];		 
						 	$_POST[dcbs][]=$_POST[cb];
						 	$_POST[dcts][]=$_POST[ct];
						  	$_POST[dvalores][]=$_POST[valor];
						 	$_POST[agregadet]=0;
							echo"
								<script>
									document.form2.banco.value='';
									document.form2.nbanco.value='';
									document.form2.cb.value='';
									document.form2.valor.value='';
									document.form2.valorvl.value='';	
									document.form2.numero.value='';				
									document.form2.numero.select();
									document.form2.numero.focus();	
								</script>";
		  				}
		 				$_POST[totalc]=0;
						$iter='saludo1a';
						$iter2='saludo2';
		 				for ($x=0;$x<count($_POST[dbancos]);$x++)
		 				{		 
							echo "
							<tr class='$iter'>
								<td><input type='text' name='dccs[]' value='".$_POST[dccs][$x]."' readonly class='inpnovisibles'  style='width:100%'/></td>
								<td><input type='text' name='dconsig[]' value='".$_POST[dconsig][$x]."' class='inpnovisibles' style='width:100%'/></td>
								<td>
									<input type='text' name='dcbs[]' value='".$_POST[dcbs][$x]."'  class='inpnovisibles' style='width:100%'/>
									<input type='hidden' name='dcts[]' value='".$_POST[dcts][$x]."'>
									<input type='hidden' name='dbancos[]' value='".$_POST[dbancos][$x]."'  >
								</td>
								<td><input type='text' name='dnbancos[]' value='".$_POST[dnbancos][$x]."' class='inpnovisibles' style='width:100%'/></td>
								<td style='text-align:right;'><input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'/>".number_format($_POST[dvalores][$x],2,',','.')."&nbsp;&nbsp;</td>
								<td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
							</tr>";
		 					$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
							$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
							$aux=$iter;
							$iter=$iter2;
					 		$iter2=$aux;
		 				}
 						$resultado = convertir($_POST[totalc]);
						$_POST[letras]=$resultado." PESOS";
		 				echo "
						<tr class='$iter'>
							<td colspan='3'></td>
							<td style='text-align:right;'>Total:</td>
							<td style='text-align:right;'>".number_format($_POST[totalc],2,',','.')."&nbsp;&nbsp;
								<input type='hidden' name='totalcf' value='$_POST[totalcf]'/>
								<input type='hidden' name='totalc' value='$_POST[totalc]'/>
							</td>
						</tr>
						<tr>
							<td style='text-align:right;'>Son:</td>
							<td colspan='4'><input type='text' name='letras' value='$_POST[letras]' style='width:100%'></td>
						</tr>";
					?> 
	   			</table>
     		</div>
			<?php
				if($_POST[oculto]=='2')
				{
					$p1=substr($row[2],0,4);
					$p2=substr($row[2],5,2);
					$p3=substr($row[2],8,2);		
					$fechaf=$_POST[fecha];	
					$bloq=bloqueos($_SESSION[cedulausu],$_POST[fecha]);	
					if($bloq>=1)
					{
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						
						if($fecha[3]=='')
						{
							$fechaf=$_POST[fecha];
						}

						//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
						//***busca el consecutivo del comprobante contable
						//***cabecera comprobante
						$sqlr="delete from comprobante_cab where tipo_comp=8 and numerotipo=$_POST[idcomp] ";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) values ($_POST[idcomp],8,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estado]')";
						mysql_query($sqlr,$linkbd);
						//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
						$sqlr="delete from comprobante_det where id_comp='8 $_POST[idcomp]'";
						mysql_query($sqlr,$linkbd);
						for($x=0;$x<count($_POST[dbancos]);$x++)
						{
							//**** consignacion  BANCARIA*****
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('8 $_POST[idcomp]','".$_POST[dbancos][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Consignacion ".$_POST[dconsig][$x]." ".$_POST[dnbancos][$x]."','',".$_POST[dvalores][$x].",0,'1',".$vigusu.")";
							mysql_query($sqlr,$linkbd);
							//*** Cuenta CAJA **
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('8 $_POST[idcomp]','".$_POST[cuentacaja]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Consignacion ".$_POST[dconsig][$x]." ".$_POST[dnbancos][$x]."','',0,".$_POST[dvalores][$x].",'1',".$vigusu.")";
							mysql_query($sqlr,$linkbd);
						}	
						//************ insercion de cabecera consignaciones ************
						$sqlr="update tesoconsignaciones_cab set fecha='$fechaf',estado='S',concepto='$_POST[concepto]' where id_consignacion=$_POST[idcomp] and vigencia=".$vigusu."";	  
						mysql_query($sqlr,$linkbd);
						$sqlr="select *from tesoconsignaciones_cab where id_CONSIGNACION=$_POST[comp]";
						$resp=mysql_query($sqlr,$linkbd);
						$row=mysql_fetch_row($resp);
						$idconsig=$row[0];
						//************** insercion de consignaciones **************
						$sqlr="delete from tesoconsignaciones where id_consignacioncab='$_POST[idcomp]'";
						mysql_query($sqlr,$linkbd);
						for($x=0;$x<count($_POST[dbancos]);$x++)
						{
							$sqlr="insert into tesoconsignaciones (id_consignacioncab,fecha,ntransaccion,cc,ncuentaban,tercero,tpago,cheque, valor,estado) values($_POST[idcomp],'$fechaf','".$_POST[dconsig][$x]."','".$_POST[dccs][$x]."','".$_POST[dcbs][$x]."','".$_POST[dcts][$x]."','E','',".$_POST[dvalores][$x].",'S')";	  
							if (!mysql_query($sqlr,$linkbd))
							{
							echo $sqlr;
								echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n');</script>";
							}
							else
							{echo "<script>despliegamodalm('visible','3','Se ha almacenado la Consignacion con Exito');</script>";}
						}	
					}
					else
					{
						echo "<script>despliegamodalm('visible','2',' No Tiene los Permisos para Modificar este Documento');</script>";
					}
					 //****fin if bloqueo  
				}
			?>	
            <script type="text/javascript">$('#concepto').alphanum({allow: '_-'});</script>
            <script type="text/javascript">$('#numero').alphanum({allow: ''});</script>
		</form>
	</body>
</html>