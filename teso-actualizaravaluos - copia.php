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
	 	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
    	<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
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
			function agregardetalle()
			{
				var ult=document.form2.ultimo.value;
				if (ult == document.form2.dvigen.value)
				{ 
					alert("Existe avaluo para esta vigencia");
	 			}
				else
				{ 
					if(document.form2.dvigen.value!="" &&  document.form2.ava.value!="")
					{ 
						document.form2.agregadet.value=1;
						document.form2.submit();
					}
					else {alert("Falta informacion para poder Agregar");}
	 			}
				
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.elimina.value=variable;
					vvend=document.getElementById('elimina');
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function guardar()
			{
				if (document.form2.tipop.value!='' )
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
  					document.form2.tercero.focus();
  					document.form2.tercero.select();
  				}
			}
			function buscater(e)
			{
				if (document.form2.tercero.value!="")
				{
	 				document.form2.bt.value='1';
	 				document.form2.submit();
	 			}
			}
			function buscar()
			{
				document.form2.actualiza.value='0';	
	 			document.form2.buscav.value='1';
	 			document.form2.submit();
 			}
 			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="catastral-ventana01.php";}
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
		  		<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-predialactualizar.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="buscar()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='teso-gestionpredial.php'" class="mgbt"/></td>
			</tr>		  
		</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			function buscarCc($cc)
			{
				$vecotorCcInsert = explode('@@@', $_POST[vecotorCcInsert]);
				$existe = false;
				for ($i=0; $i < count($vecotorCcInsert) ; $i++) 
				{ 
					if ($vecotorCcInsert[$i] == $cc) {$existe = true;}
				}
				return $existe;
			}
			if(!$_POST[oculto])
			{
				$fec=date("d/m/Y");
				$_POST[fecha]=$fec; 	
				$_POST[valoradicion]=0;
				$_POST[valorreduccion]=0;
				$_POST[valortraslados]=0;		 		  			 
				$_POST[valor]=0;		 
			}
			if ($_POST[chacuerdo]=='2')
			{
	    		$_POST[dcuentas]=array();
	    		$_POST[dncuetas]=array();
	    		$_POST[dingresos]=array();
	    		$_POST[dgastos]=array();
				$_POST[diferencia]=0;
				$_POST[cuentagas]=0;
				$_POST[cuentaing]=0;																			
			}	
		?>
		<form  name="form2" method="post" action="">
 			<?php 
				if($_POST[bt]=='1')
				{
					$nresul=buscatercero($_POST[tercero]);
					if($nresul!=''){$_POST[ntercero]=$nresul;}
					else{$_POST[ntercero]="";}
				}
				if($_POST[oculto]=='2')
				{
					$sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." order by ord";
					$res=mysql_query($sqlr,$linkbd);
 					while($row=mysql_fetch_row($res))
					{
						$_POST[doc][]=$row[4];
						$_POST[ords][]=$row[1];
						$_POST[ntercero][]=$row[6];
						$_POST[tercero][]=$row[5];
					}
				}
				if($_POST[buscav]=='1')
				{
					$_POST[dvigencias]=array();
					$_POST[davaluos]=array();
					$_POST[dtodos]=array();		 
					$_POST[dtots]=array();		 
					$_POST[dords]=array();
					$_POST[doc]=array();
					$_POST[ords]=array();
					$_POST[ntercero]=array();
					$_POST[tercero]=array();
					$sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." order by ord";
					$res=mysql_query($sqlr,$linkbd);
 					while($row=mysql_fetch_row($res))
	  				{
		 				$_POST[catastral]=$row[0];
						$_POST[ord]=$row[1];
						$_POST[tot]=$row[2];
						$_POST[doc][]=$row[4];
						$_POST[ords][]=$row[1];
						$_POST[ntercero][]=$row[6];
						$_POST[tercero][]=$row[5];
						$_POST[direccion]=$row[7];
						$_POST[ha]=$row[8];
						$_POST[mt2]=$row[9];
						$_POST[areac]=$row[10];
						$_POST[avaluo]=$row[11];
						$_POST[tipop]=$row[14];
						$_POST[estadop]=$row[13];
		  				if($_POST[tipop]=='urbano'){$_POST[estrato]=$row[15];}
						else {$_POST[rangos]=$row[15];}
						$_POST[buscav]="";
	  				}
	 				$sqlr="select * from tesoprediosavaluos where codigocatastral='".$_POST[codcat]."'"; 
	 				$res=mysql_query($sqlr,$linkbd);
	 				while($row=mysql_fetch_row($res))
	  				{
	  					$_POST[dvigencias][]=$row[0];
						$_POST[davaluos][]=$row[2];
					   	$_POST[dtodos][]=$row[3];
					   	$_POST[dords][]=$row[6];
					   	$_POST[dtots][]=$row[5];
						$_POST[dtod]=$row[3];
					   	$_POST[dor]=$row[6];
					   	$_POST[dtot]=$row[5];
	 				}
  				}
			?>
 			<input type="hidden" value="" name="tipoDoc" id="tipoDoc">
    		<table class="inicio" align="center" >
      		<tr >
        		<td class="titulos" colspan="8">.: Actualizar Avaluos</td>
                <td class="cerrar" style='width:7%'><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      		</tr>
     	
	  		<tr> 
				<td  class="saludo1" style="width:10%;">C&oacute;digo Catastral:</td>
        		<td colspan="2"><input id="codcat" type="text" name="codcat"  onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" onClick="document.getElementById('codcat').focus();document.getElementById('codcat').select();">
			<input id="ord" type="hidden" name="ord"   value="<?php echo $_POST[ord]?>" style="width:5%;" readonly>
			<input id="tot" type="hidden" name="tot"  value="<?php echo $_POST[tot]?>" style="width:5%;" readonly> 
			<input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" id="oculto" name="oculto"> 
			<input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav">
			<input type="hidden" value="<?php echo $_POST[actualiza]?>" name="actualiza">
			<a title="Listado de Predios" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"/></a>
			<input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar()" ></td>
        </tr>
	  </table>
	  <table class="inicio">
	  	<tr>
	    	<td class="titulos" colspan="10">Informaci&oacute;n Predio</td>
	   	</tr>
	  	<tr>
		  	<td class="saludo1">C&oacute;digo Catastral:</td>
		  	<td  style="width:10%;">
		  		<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco">
		  		<input  style="width:100%;" name="catastral" type="text" id="catastral" onBlur="buscater(event)" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>"  readonly>
		  	</td>
				   
			<td class="saludo1">Avaluo:</td>
		  	<td style="width:10%;" >
		  		<input style="width:100%;" name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" >
		  	</td>

		  	<td  class="saludo1">Area Cons:</td>
		  	<td style="width:10%;">
		  		<input style="width:100%;" name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" >
		  	</td>
		  	<td class="saludo1">Ha:</td>
		  	<td style="width:10%;">
		  		<input style="width:100%;" name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" >
		  	</td>
			<td  class="saludo1">Mt2:</td>
	  		<td style="width:10%;">
	  			<input style="width:100%;" name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" >
	  		</td>
	  	</tr>
	  	<tr>
			<td width="119" class="saludo1">Tipo:</td>
	     	<td width="202">
	     		<select style='width:100%;' id='tipop' name="tipop">
					<option value="urbano" <?php if($_POST[tipop]=='urbano') echo "SELECTED"?>>Urbano</option>
	  				<option value="rural" <?php if($_POST[tipop]=='rural') echo "SELECTED"?>>Rural</option>
				s</select>
            </td>
		  	<td  class="saludo1">Direcci&oacute;n:</td>
	  		<td colspan='3'>
	  			<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco">
	  			<input style='width: 100%;' name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" >
	  		</td>

	  		<td  class="saludo1">Estado:</td>
		   	<td style="width:10%;">
			   	<select style="width:100%;" name="estadop" onChange="">
		       		<option value="">Seleccione ...</option>
					<option value="S" <?php if($_POST[estadop]=='S') echo "SELECTED"?>>Activo</option>
		  			<option value="N" <?php if($_POST[estadop]=='N') echo "SELECTED"?>>Inactivo</option>
				</select>
			</td>
        </tr>
		<tr>
			<td class="saludo1">Vigencia:</td>
		  	<td  style="width:10%;">
		  		<input type="text" value="<?php echo $_POST[dvigen]?>" name="dvigen">
		  	</td>
			<td class="saludo1">Avaluo:</td>
		  	<td  style="width:10%;">
		  		<input type="text" value="<?php echo $_POST[ava]?>" name="ava">
				<input type="hidden" value="<?php echo $_POST[dtod]?>" name="dtod">
				<input type="hidden" value="<?php echo $_POST[dor]?>" name="dor">
				<input type="hidden" value="<?php echo $_POST[dtot]?>" name="dtot">
		  	</td>
			<td>
				<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
     			<input type="hidden" value="0" name="agregadet"> 
			</td>
		</tr>
      </table>
		        		</div>
				</td>
				
				<td style="width:25%;" valign="top">
					<div class="subpantalla" style=" width:99.6%; overflow-x:hidden;">
					<table class="inicio" id='tablavaluos'>
						<tr>
							<td class="titulos" colspan="7" >Avaluos Vigencias</td>
						</tr>
						  
					    <tr>
							<td class="titulos2" >Vigencia</td>
							<td class="titulos2" >Avaluo</td>
							<td class="titulos2" >PAGO(S/N)</td>
							<td class="titulos2">Ord</td>
							<td class="titulos2">Tot</td>
							<td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td>
						</tr>
					      <?php
						  if ($_POST[elimina]!='')
						 { 
						 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
						 $posi=$_POST[elimina];
						 unset($_POST[dvigencias][$posi]);
						 unset($_POST[davaluos][$posi]);
						 unset($_POST[dtodos][$posi]);		 
						 unset($_POST[dords][$posi]);
						 unset($_POST[dtots][$posi]);
						 $_POST[dvigencias]= array_values($_POST[dvigencias]); 
						  $_POST[davaluos]= array_values($_POST[davaluos]); 
						  $_POST[dtodos]= array_values($_POST[dtodos]); 
						 $_POST[dords]= array_values($_POST[dords]); 	
						 $_POST[dtots]= array_values($_POST[dtots]);
						 ?>
							    <script>
										//document.form2.cuenta.focus();	
										document.form2.dvigen.value="";
										document.form2.ava.value="";
										document.form2.cb.value="";
										document.form2.dvigen.select();
										document.form2.dvigen.focus();	
								 </script>
							<?php
						 }
						   if ($_POST[agregadet]=='1')
							{
							// $_POST[dcuentas][]=$_POST[estrato];		
							$_POST[dvigencias][]=$_POST[dvigen];		 
							$_POST[davaluos][]=$_POST[ava];
							$_POST[dtodos][]=$_POST[dtod];
							$_POST[dords][]=$_POST[dor];
							$_POST[dtots][]=$_POST[dtot];
							$_POST[agregadet]=0;
							
							  ?>
							 <script>
									//document.form2.cuenta.focus();	
									document.form2.dvigen.value="";
									document.form2.ava.value="";
									document.form2.cb.value="";
									document.form2.dvigen.select();
									document.form2.dvigen.focus();	
							 </script>
							  <?php
							  }
							  $co="zebra1";
						  	  $co2="zebra2";
							  $tam=count($_POST[dvigencias]);
								for($x=0; $x<$tam; $x++)
								{
								echo "
									<tr>
										<td class='$co' style='width:20%'>
											<input type='text' style='width:100%' name='dvigencias[]' value='".$_POST[dvigencias][$x]."' readonly>
										</td>
										<td class='$co' style='width:30%'>
											<input type='text' style='width:100%' name='davaluos[]' value='".$_POST[davaluos][$x]."' readonly>
										</td>
										<td class='$co' style='width:20%'>
											<input type='text' style='width:100%' name='dtodos[]' value='".$_POST[dtodos][$x]."' maxlength=1>
											<input type='hidden'  name='dsistema[]' value='S'>
										</td>
										<td class='$co' style='width:12%'>
											<input type='text' style='width:100%' name='dords[]' value='".$_POST[dords][$x]."' readonly>
										</td>
										<td class='$co' style='width:12%'>
											<input type='text' style='width:100%' name='dtots[]' value='".$_POST[dtots][$x]."' readonly>
										</td>
										<td class='$co' style='width:5%;'>
											<a href='#' onclick='eliminar($x)' style='100%'>
												<img src='imagenes/del.png'>
											</a>
										</td>
									</tr>";	
								$_POST[ultimo]=$_POST[dvigencias][$x];
								$aux=$co;
								$co=$co2;
								$co2=$aux;
								}
									
							?>	
							<input type="hidden" value="<?php echo $_POST[ultimo]?>" name="ultimo">
					</table>
					</div>
				</td>
			</tr>

				<input id="vectorOrd" type="hidden" name="vectorOrd">
				<input id="vectorTipoDoc" type="hidden" name="vectorTipoDoc">
				<input id="vecotorCc" type="hidden" name="vecotorCc">
				<input id="vecotorNombre" type="hidden" name="vecotorNombre">

				<input id="vecotorCcEliminar" type="hidden" name="vecotorCcEliminar">
				<input id="vecotorCcInsert" type="hidden" name="vecotorCcInsert">
				
				
		</table>
		<?php 
	if($_POST[oculto]=='2' )
	{
		//******crear y actualizar predio avaluos	
		$tam=count($_POST[dvigencias]);
		for($x=0; $x<$tam; $x++)
		{
				$sqlr="insert into tesoprediosavaluos (vigencia,codigocatastral,avaluo,pago,estado,tot,ord,ha,met2,areacon) values ('".$_POST[dvigencias][$x]."','".$_POST[catastral]."','".$_POST[davaluos][$x]."','".$_POST[dtodos][$x]."','S','".$_POST[dtots][$x]."','".$_POST[dords][$x]."',$_POST[ha],$_POST[mt2],$_POST[areac])";
				mysql_query($sqlr,$linkbd);	
				//echo $sqlr;
				$sqlr="update tesoprediosavaluos set pago='".$_POST[dtodos][$x]."' where codigocatastral='".$_POST[catastral]."' AND Vigencia='".$_POST[dvigencias][$x]."'";
				mysql_query($sqlr,$linkbd);	
				$sqlr="update tesoprediosavaluos set avaluo='".$_POST[davaluos][$x]."' where codigocatastral='".$_POST[catastral]."' AND Vigencia='".$_POST[dvigencias][$x]."'";
				mysql_query($sqlr,$linkbd);	
				
				if (!mysql_query($sqlr,$linkbd))
				{
				 echo "<table class='inicio'><tr class='saludo1'><td><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
			//	 $e =mysql_error($respquery);
				 echo "Ocurrió el siguiente problema:<br>";
				 //echo htmlentities($e['message']);
				 echo "<pre>";
				 ///echo htmlentities($e['sqltext']);
				// printf("\n%".($e['offset']+1)."s", "^");
				 echo "</pre></center></td></tr></table>";
				}
					else
					 {
					  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha actualizado con exito <img src='imagenes/confirm.png'></center></td></tr></table>";
					  ?>
					  <script>
					  document.form2.tercero.value="";
					  document.form2.ntercero.value="";
					  </script>
					  <?php
					  }
		}	 
	}
		?>
		
		<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
   </form>
</table>
</body>
</html>