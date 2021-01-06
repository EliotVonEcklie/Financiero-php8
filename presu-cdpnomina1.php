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
        <title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
    	<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function guardar()
			{
				if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.solicita.value!='')
 				{
					if (confirm("Esta Seguro de Guardar"))
  					{
						document.form2.oculto.value=2;
						document.form2.submit();
						document.form2.action="pdfcdp.php";
  					}
  				}
  				else
				{
  					alert('Faltan datos para completar el registro');
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
  				}
			}
			function validar(formulario)
			{
				document.form2.chacuerdo.value=2;
				document.form2.action="presu-cdpnomina.php";
				document.form2.submit();
			}
			function validar2(formulario)
			{
				document.form2.chacuerdo.value=2;
				document.form2.action="presu-cdp.php";
				document.form2.submit();
			}
			function validarcdp()
			{
				valorp=document.getElementById("valor").value;
				nums=quitarpuntos(valorp);			
				if(nums<0 || nums> parseFloat(document.form2.saldo.value))
				{
					alert('Valor Superior al Disponible '+document.form2.saldo.value);
					document.form2.cuenta.select();
					document.form2.cuenta.focus();
				}
			}
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!="")
				{
 					document.form2.bc.value=2;
 					document.form2.submit();
 				}
 			}
			function agregardetalle()
			{
				if(document.form2.cuenta.value!="" &&  document.form2.fuente.value!="" && parseFloat(document.form2.valor.value) >=0 )
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
  					document.form2.chacuerdo.value=2;
					document.form2.elimina.value=variable;
					document.form2.submit();
				}
			}
			function pdf()
			{
				document.form2.action="pdfcdispre.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function finaliza()
 			{
  				if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
  				{
	  				document.form2.fin.value=1;
	  				document.form2.fin.checked=true; 
  				} 
  				else 
				{
					document.form2.fin.value=0;
  					document.form2.fin.checked=false; 
				}
		 	}
			function capturaTecla(e)
			{ 
				var tcl = (document.all)?e.keyCode:e.which;
				if (tcl==115)
				{
					alert(tcl);
					return tabular(e,elemento);
				}
			}
		</script>
		<?php titlepag();?>
    </head>
    <body >
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
				<a href="presu-cdpnomina.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" tilte="Guardar" /></a>
				<a href="#" class="mgbt"><img src="imagenes/buscad.png" title="Buscar" border="0" /></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a>
				<a href="presu-gestioncdp.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" border="0" /></a>
				</td>
        	</tr>
		</table>
  		<form name="form2" method="post" action="">
			<?php
				//$vigencia=date(Y);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
				$_POST[vigencia]=vigencia_usuarios($_SESSION[cedulausu]); 
				$vigencia=$vigusu;
				if(!$_POST[oculto])
				{
 		 			$fec=date("d/m/Y");
					$_POST[fecha]=$fec; 	
					$_POST[valor]=0; 			 
					$_POST[cuentaing]=0;
					$_POST[cuentagas]=0;
					$_POST[cuentaing2]=0;
					$_POST[cuentagas2]=0;
					$sqlr="select max(consvigencia) from pptocdp where vigencia=$_POST[vigencia] ";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res)){$maximo=$r[0];}
					if(!$maximo){$_POST[numero]=1;}
					else {$_POST[numero]=$maximo+1;}
				}
				if($_POST[chacuerdo]=='2')
				{
					$_POST[dcuentas]=array();	 
				 	$_POST[dncuentas]=array();	 
				 	$_POST[dgastos]=array();	 
				 	$_POST[dcfuentes]=array();	 
				 	$_POST[dfuentes]=array();	 
				 	$_POST[cuentagas2]=0;
				 	$_POST[cuentagas]=0;
				}
 				$sqlr="select humnom_presupuestal.cuenta,humnom_presupuestal.valor from  humnomina, humnom_presupuestal where humnomina.id_nom=$_POST[idliq] and  humnom_presupuestal.id_nom=$_POST[idliq] and humnomina.id_nom= humnom_presupuestal.id_nom and humnomina.vigencia=$vigusu";
				$res=mysql_query($sqlr,$linkbd); 
				$_POST[agregadet]='';		
				$cont=0;
				while ($row=mysql_fetch_row($res)) 
		 		{		
		 			$_POST[dcuentas][$cont]=$row[0];	 
		 			$_POST[dncuentas][$cont]=buscacuentapres($row[0]);
		 			$_POST[dgastos][$cont]=$row[1];
		 			$fuente=buscafuenteppto($row[0],$vigusu);
		  			$infofte = explode("_", $fuente);	 
		 			$_POST[dcfuentes][$cont]=$infofte[0];
		 			$_POST[dfuentes][$cont]=$infofte[1];
		 			$cont=$cont+1;
		 		}			
			?>
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="7">.: Certificado Disponibilidad Presupuestal </td>
                    <td class="cerrar" style="width:7%;" ><a onClick="location.href='presu-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
                	<td class="saludo1" style="width:3cm;">Vigencia:</td>
                    <td style="width:8%;"><input type="text" name="vigencia" value="<?php echo $_POST[vigencia] ?>" readonly style="width:95%;"/></td>
	  				<td class="saludo1" style="width:3cm;">Numero:</td>
		  			<td style="width:20%;"><input name="numero" type="text" id="numero" value="<?php echo $_POST[numero] ?>" readonly style="width:50%;"></td>
                    <td class="saludo1" style="width:3cm;">Fecha:</td>
        			<td style="width:20%;">
                    	<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%">&nbsp;<a onClick="displayCalendarFor('fc_1198971545');" style="cursor:pointer;"><img src="imagenes/calendario04.png" style="width:20px;"></a>        
                 	</td>
                     <td rowspan="4" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 90% 98%"></td>
             	</tr>
                <tr>
		  			<td class="saludo1">Solicitud Nomina:</td>
		  			<td>
		  				<select name="idliq" id="idliq" onChange="validar()" style="width:95%;">
				  			<option value="-1">Sel ...</option>
				 			<?php
				 				$sqlr="Select TB1.nomina,TB2.cc,TB2.mes,TB2.vigencia from hum_nom_cdp_rp TB1, humnomina TB2 WHERE TB1.cdp='0' AND TB1.nomina=TB2.id_nom";
		 						$resp = mysql_query($sqlr,$linkbd);
				 				while ($row =mysql_fetch_row($resp)) 
				 				{
				 					if("$row[0]"==$_POST[idliq])
			 	 					{
				 						echo "<option value='$row[0]' SELECTED>$row[0]</option>";
				  						$_POST[cc]=$row[1];
										$_POST[mesliq]=mesletras($row[2]);
										if($row[1]!='')
										{
											$sqlrcc="SELECT nombre FROM centrocosto where id_cc='$row[1]'";	
											$rowcc =mysql_fetch_row(mysql_query($sqlrcc,$linkbd));
											$_POST[nombrecc]=$rowcc[0];
										}
										else{$_POST[nombrecc]="TODOS";}
				 					}
									else 
									{
										echo "<option value='$row[0]'>$row[0]</option>";
										$_POST[nombrecc]="";
										$_POST[mesliq]="";
									}
			     				}   
							?>
		  				</select>
		  			</td>
                    <td class="saludo1">CC:</td>
          			<td>
                    	<input type="text" name="nombrecc" id="nombrecc" value="<?php echo $_POST[nombrecc];?>" style="width:98%;" />
          				<input type="hidden" name="cc" id="cc" value="<?php echo $_POST[cc];?>"/>
          			</td>
                     <td class="saludo1">Mes:</td>
          			<td><input type="text" name="mesliq" id="mesliq" value="<?php echo $_POST[mesliq];?>" /></td>
              	</tr>
                <input type="hidden" name="chacuerdo" value="1">
                <tr>
	   				<td class="saludo1">Solicita:</td>
       				
	   				<td colspan="5"><input name="solicita" type="text" id="solicita" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[solicita]?>" style="width:100%;"/></td>
              	</tr>
                <tr>
	   				<td class="saludo1">Objeto:</td>
                    <td colspan="5"><input name="objeto" type="text" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[objeto]?>" style="width:100%;" /></td>
	    		</tr>
          	</table>	  
        	<input type="hidden"  name="oculto" id="oculto" value="1"> 
			<?php
				if(!$_POST[oculto]){ echo"<script>document.form2.cuenta.focus();</script>";}
				if($_POST[bc]!='')//**** busca cuenta
			 	{
			  		$tipo=substr($_POST[cuenta],0,1);			 
			  		$nresul=buscacuentapres($_POST[cuenta],$tipo);
			  		if($nresul!='')
			   		{
			  			$_POST[ncuenta]=$nresul;
  			 			echo"
			  			<script>
			 				 document.getElementById('valor').focus();
			 				 document.getElementById('valor').select();
			  			</script>";
		  				$ind=substr($_POST[cuenta],0,1);
		   				$ind=substr($_POST[cuenta],0,1);
			  			if($ind=='R' || $ind=='r')
					 	{						
							$ind=substr($_POST[cuenta],1,1);						  
							//$criterio="and (pptocuentaspptoinicial.vigencia=".$vigusu." or   1 >=(select count(*) from  pptocuentas where estado='S' and cuenta='$_POST[cuenta]' and (vigencia=$vigusu or vigenciaf=$vigusu)))";					  
							$criterio="and (pptocuentaspptoinicial.vigencia=".$vigusu." or  pptocuentaspptoinicial.vigenciaf=$vigusu)";
					 	}
					 	//else {$criterio=" and pptocuentaspptoinicial.vigencia='$vigusu'";}
			  			if ($ind=='2')
			 				// $sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldos,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.vigencia=$vigusu and pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
			 				$sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldos,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
			  			if ($ind=='3' || $ind=='4')
//			  				$sqlr="select pptocuentas.futfuenteinv,pptocuentaspptoinicial.saldos,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.vigencia=$vigusu and pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
							$sqlr="select pptocuentas.futfuenteinv,pptocuentaspptoinicial.saldos,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
			  			$res=mysql_query($sqlr,$linkbd);
			  			$row=mysql_fetch_row($res);
    					if($row[1]!='' || $row[1]!=0)
			     		{
				  			$_POST[cfuente]=$row[0];
				  			$_POST[fuente]=$row[2];
				  			$_POST[valor]=0;			  
				  			$_POST[saldo]=$row[1];			  
				 		}
						else
				  		{
				  		 	/*$_POST[cfuente]="";
	  			   			$_POST[fuente]="";
				   			$_POST[valor]="";			  
				   			$_POST[saldo]="";
				   			$_POST[cuenta]="";			  
				   			$_POST[ncuenta]="";*/
				  		}  	
			 		}
			 		else
			 		{
			  			$_POST[ncuenta]="";
			  			$_POST[fuente]="";
			   			$_POST[valor]="";
			  			echo"
			  			<script>
							alert('Cuenta Incorrecta');
			   				document.form2.fuente.value='';
			  				document.form2.cuenta.focus()
						</script>";
			  		}
			 	}
			?>
			<div class="subpantalla" style="height:45%; width:99.6%; overflow-x:hidden;">
				<table class="inicio" width="99%">
        			<tr><td class="titulos" colspan="5">Detalle CDP</td></tr>
					<tr>
						<td class="titulos2">Cuenta</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2">Fuente</td>
                        <td class="titulos2" style="width:10%;">Valor</td>
                        <td class="titulos2"><img src="imagenes/del.png"></td>
					</tr>
					<?php 
						if ($_POST[elimina]!='')
		 				{ 
		 					$posi=$_POST[elimina];
		  					$cuentagas=0;
		  					$cuentaing=0;
		   					$diferencia=0;
		  					// array_splice($_POST[dcuentas],$posi, 1);
		 					unset($_POST[dcuentas][$posi]);
 		 					unset($_POST[dncuentas][$posi]);
		 					unset($_POST[dgastos][$posi]);		 		 		 		 		 
		 					unset($_POST[dcfuentes][$posi]);		 		 
		 					unset($_POST[dfuentes][$posi]);		 
		 					$_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 					$_POST[dncuentas]= array_values($_POST[dncuentas]); 
							$_POST[dgastos]= array_values($_POST[dgastos]); 
							$_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
							$_POST[dcfuentes]= array_values($_POST[dcfuentes]); 		 	
							$_POST[elimina]='';	 		 		 		 
		 				}	 
		 				if ($_POST[agregadet]=='1')
		 				{
							$ch=esta_en_array($_POST[dcuentas],$_POST[cuenta]);
							if($ch!='1')
			 				{			 
		  						$cuentagas=0;
		  						$cuentaing=0;
		  						$diferencia=0;
								$_POST[dcuentas][]=$_POST[cuenta];
								$_POST[dncuentas][]=$_POST[ncuenta];
								$_POST[dfuentes][]=$_POST[fuente];
								$_POST[dcfuentes][]=$_POST[cfuente];		 
								$_POST[valor]=str_replace(".","",$_POST[valor]);
								$_POST[dgastos][]=$_POST[valor];
								$_POST[agregadet]=0;
		  						echo"
		 						<script>
									document.form2.cuenta.value='';
									document.form2.ncuenta.value='';
									document.form2.fuente.value='';
									document.form2.cfuente.value='';				
		  							document.form2.cuenta.focus();	
								</script>";
							}
							else {echo "<script> alert('Ya existe este Rubro en el CDP');</script>";}
		  				}
		  			?>
   					<input type='hidden' name='elimina' id='elimina'>
  					<?php
						$iter='saludo1a';
						$iter2='saludo2';
		 				for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 				{		 
		 					echo "
							<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
							<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
							<input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'/>
							<input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."'/>
							<input type='hidden' name='dgastos[]' value='".$_POST[dgastos][$x]."'/>
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
								<td>".$_POST[dcuentas][$x]."&nbsp;</td>
								<td>".$_POST[dncuentas][$x]."</td>
								<td>".$_POST[dfuentes][$x]."</td>
								<td style='text-align:right;'>$ ".number_format($_POST[dgastos][$x],2,".",",")."</td>
								<td><img src='imagenes/del.png'/></td>
							</tr>";
							//$cred= $vc[$x]*1;
		 					$gas=$_POST[dgastos][$x];
							//$cred=number_format($cred,2,".","");
							//$deb=number_format($deb,2,".","");
		 					$gas=$gas;
		 					$cuentagas=$cuentagas+$gas;
		 					$_POST[cuentagas2]=$cuentagas;
		 					$total=number_format($total,2,",","");
 		 					$_POST[cuentagas]=number_format($cuentagas,2,".",",");
							$resultado = convertir($_POST[cuentagas2]);
							$_POST[letras]=$resultado." Pesos";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
		 				}
		 				echo "
						<input type='hidden' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]'/>
						<input type='hidden' id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]'/>
						<input type='hidden' id='letras' name='letras' value='$_POST[letras]'/>
						<tr class='$iter' style='text-align:right;'>
							<td colspan='3'>Total:</td>
							<td >$_POST[cuentagas]</td>
						</tr>
						<tr class='titulos2'>
							<td>Son:</td>
							<td colspan= '4'>$resultado</td>
						</tr>";
					?>
				</table>
			</div>
  			<?php
  				//***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
				$oculto=$_POST['oculto'];
				if($_POST[oculto]=='2')
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$bloq=bloqueos($_SESSION[cedulausu],$fechaf);
					if($bloq>=1)
					{
 						$sqlr="select count(*) from pptocdp where vigencia='$_POST[vigencia]' and consvigencia='$_POST[numero]'";
						$res=mysql_query($sqlr,$linkbd);
						while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0]; }
	  					if($numerorecaudos==0)
	  					{
 							$nr="1";	 	
							//************** modificacion del presupuesto **************
							$sqlr="insert into pptocdp (vigencia,consvigencia,fecha,valor,estado,solicita,objeto) values ($_POST[vigencia], $_POST[numero],'$fechaf',$_POST[cuentagas2],'S','$_POST[solicita]','$_POST[objeto]')";
							if (!mysql_query($sqlr,$linkbd))
							{
	 							echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b> <img src='imagenes\alert.png'> </b></font></p>";
								//	 $e =mysql_error($respquery);
	 							echo "Ocurrió el siguiente problema:<br>";
  	 							//echo htmlentities($e['message']);
  	 							echo "<pre>";
     							//echo htmlentities($e['sqltext']);
    							// printf("\n%".($e['offset']+1)."s", "^");
     							echo "</pre></center></td></tr></table>";
							}
  							else
  		 					{
		  						echo "<table class='inicio'><tr><td class='saludo1'>Se ha almacenado el CDP con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
  		  						$sqlr="insert into pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito, diferencia,estado) values($_POST[numero],6,'$fechaf','$_POST[solicita] - $_POST[objeto]',$_POST[vigencia],$_POST[cuentagas2],$_POST[cuentagas2],0,1)";
	 	 						mysql_query($sqlr,$linkbd);
								$sqlrco ="UPDATE hum_nom_cdp_rp SET cdp='$_POST[numero]' WHERE nomina='$_POST[idliq]' AND vigencia='$_POST[vigencia]'";
								mysql_query($sqlrco,$linkbd); 
		  					}
							for ($x=0;$x<count($_POST[dcuentas]);$x++)
	 						{
								$sqlr="update pptocuentaspptoinicial set saldos=saldos-".$_POST[dgastos][$x]." where cuenta='".$_POST[dcuentas][$x]."' and (vigencia=$vigusu or vigenciaf=$vigusu)";
								$res=mysql_query($sqlr,$linkbd); 
								$sqlr="insert into pptocdp_detalle (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado) values('$_POST[vigencia]','$_POST[numero]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0)";
								$res=mysql_query($sqlr,$linkbd);
	  							$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo) values('".$_POST[dcuentas][$x]."','','".$_POST[dfuentes][$x]."',".$_POST[dgastos][$x].",0,1,'$_POST[vigencia]',6,'$_POST[numero]')";
 	 							mysql_query($sqlr,$linkbd); 
	 						}
						}
						else
						{
		 					echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un CDP con este Numero <img src='imagenes/alert.png'></center></td></tr></table>";
						}
					}
					else
					{
						echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";	
					}
 				}//*** if de control de guardado
			?> 
		</form>
	</body>
</html>