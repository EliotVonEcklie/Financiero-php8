<?php //V 1000 12/12/16 ?> 
<?php
	ini_set('max_execution_time', 3600);
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
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<script>
			$(window).load(function () {
				$('#cargando').hide();
			});
			//************* ver reporte ************
			//***************************************
			function verep(idfac)
			{
				document.form1.oculto.value=idfac;
				document.form1.submit();
			}
			//************* genera reporte ************
			//***************************************
			function genrep(idfac)
			{
				document.form2.oculto.value=idfac;
				document.form2.submit();
			}
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value='1';
					document.form2.submit();
				}
			}
			function validar()
			{
				document.form2.submit();
			}
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
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else {
					alert("Falta informacion para poder Agregar");
				}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
				}
			}
			//************* genera reporte ************
			//***************************************
			function guardar()
			{
				
				if (confirm("Esta Seguro de Guardar"))
				{
					document.form2.oculto.value=2;
					document.form2.submit();
				}
			}
			function pdf()
			{
				document.form2.action="pdfpredial.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscar()
			{
				// alert("dsdd");
				document.form2.buscav.value='1';
				document.form2.submit();
			}
			function buscaprediales()
			{
				// alert("dsdd");
				document.form2.oculto.value='1';
				document.form2.submit();
			}
			function buscavigencias(objeto)
			{
				//document.form2.buscarvig.value='1';
				vvigencias=document.getElementsByName('dselvigencias[]');
				vtotalpred=document.getElementsByName("dpredial[]"); 	
				vtotaliqui=document.getElementsByName("dhavaluos[]"); 	
				vtotalbomb=document.getElementsByName("dimpuesto1[]"); 	
				vtotalmedio=document.getElementsByName("dimpuesto2[]"); 	
				vtotalintp=document.getElementsByName("dipredial[]"); 	
				vtotalintb=document.getElementsByName("dinteres1[]"); 	
				vtotalintma=document.getElementsByName("dinteres2[]"); 	
				vtotaldes=document.getElementsByName("ddescuentos[]"); 	
				sumar=0;
				sumarp=0;
				sumarb=0;
				sumarma=0;
				sumarint=0;
				sumarintp=0;
				sumarintb=0;
				sumarintma=0;
				sumardes=0;
				for(x=0;x<vvigencias.length;x++)
				{
					if(vvigencias.item(x).checked)
					{
						sumar=sumar+parseFloat(vtotaliqui.item(x).value);
						sumarp=sumarp+parseFloat(vtotalpred.item(x).value);
						sumarb=sumarb+parseFloat(vtotalbomb.item(x).value);
						sumarma=sumarma+parseFloat(vtotalmedio.item(x).value);
						sumarint=sumarint+parseFloat(vtotalintp.item(x).value)+parseFloat(vtotalintb.item(x).value)+parseFloat(vtotalintma.item(x).value);
						sumarintp=sumarintp+parseFloat(vtotalintp.item(x).value);
						sumarintb=sumarintb+parseFloat(vtotalintb.item(x).value);
						sumarintma=sumarintma+parseFloat(vtotalintma.item(x).value);	 	 
						sumardes=sumardes+parseFloat(vtotaldes.item(x).value);
					}
				}

				document.form2.totliquida.value=sumar;
				document.form2.totliquida2.value=sumar;
				document.form2.totpredial.value=sumarp;
				document.form2.totbomb.value=sumarb;
				document.form2.totamb.value=sumarma;
				document.form2.totint.value=sumarint;
				document.form2.intpredial.value=sumarintp;
				document.form2.intbomb.value=sumarintb;
				document.form2.intamb.value=sumarintma;
				document.form2.totdesc.value=sumardes;
			}
		</script>

		<?php titlepag();?>
	</head>
	<body>
		<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
			<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
		</div>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
			  <td colspan="3" class="cinta"><a href="teso-causacionpredial.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a> <a href="#" class="mgbt" onClick="guardar()" ><img src="imagenes/guarda.png" title="Guardar"/></a> <a href="teso-buscapredial.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> <a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"><img src="imagenes/print.png" title="Buscar" /></a> <a href="teso-gestionpredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
			</tr>		  
		</table>
		<?php
		$vigencia=vigencia_usuarios($_SESSION[cedulausu]);;
		$vact=vigencia_usuarios($_SESSION[cedulausu]);; 
		?>	

		<form name="form2" method="post" action="">
			<table class="inicio">
				<tr><td class="titulos" colspan="6">Causacion Predial</td><td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td></tr>
				<tr>
					<td class="saludo3">Fecha</td>
					<td>
						<input name="fecha" type="text" id="fecha" title="YYYY-MM-DD" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fecha');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>
					</td>
					<td class="saludo3">Fecha Final</td>
					<td>
						<input name="fechaf" type="text" id="fechaf" title="YYYY-MM-DD" size="10" value="<?php echo $_POST[fechaf]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fechaf');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>
					</td>
					<td class="saludo3">Causar Vigencia</td><td> 
				<select name="vigencias" id="vigencias" 	>
					<option value="">Sel..</option>
					<?php	  
						for($x=$vact;$x>=$vact-2;$x--)
						{
							$i=$x;  
							echo "<option  value=$x ";
							if($i==$_POST[vigencias])
							{
								echo " SELECTED";
							}
							echo " >".$x."</option>";	    
						}
					?>
				</select> <input name="buscapredios" type="button" value=" Buscar Predios " onClick="buscaprediales()"> <input name="oculto" type="hidden" value="<?php echo $_POST[oculto] ?>"></td></tr>
			</table>
			<div class="subpantallac" style="height:66.8%; width:99.6%; overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="9">Predios a Causar</td></tr>
					<tr><td class="titulos2">Cod Catastral</td><td class="titulos2">Direccion</td><td class="titulos2">Cedula/Nit</td><td class="titulos2">Propietario</td><td class="titulos2">Tipo Predio</td><td class="titulos2">Avaluo</td><td class="titulos2">Predial</td><td class="titulos2">Bomberil</td><td class="titulos2">Ambiental</td></tr>
					<?php
						$fec="";
						if($_POST[fechaf]!='')
						{
							$fec=" AND tesoliquidapredial.fecha between '$_POST[fecha]' and '$_POST[fechaf]'";
						}
						if($_POST[oculto]==1)
						{
							$linkbd=conectar_bd();
							//***verificacion si ya se causo esta vigencia ******************************************
							$sqlr="select count(*) from dominios where nombre_dominio='CAUSACION_PREDIAL' and valor_inicial='$vigusu'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{ 
								$ya=$row[0];	
							}
							//***************************************************************************************
							//$sqlr="select T2.codigocatastral,T2.avaluo,T1.direccion,T1.documento,T1.tipopredio,T1.estratos from tesopredios as T1, tesoprediosavaluos as T2 where  NOT EXIST (SELECT * FROM comprobante_det as T3 WHERE T3.detalle like  '%T2.codigocatastral %') ";

						$sqlr=	"SELECT f.codigocatastral,f.avaluo,g.direccion,g.documento,g.tipopredio,f.estratos FROM tesoprediosavaluos as f,tesopredios as g, tesoliquidapredial as h WHERE f.vigencia=$_POST[vigencias] AND f.codigocatastral=g.cedulacatastral AND h.fecha between '$_POST[fecha]' and '$_POST[fechaf]' AND h.codigocatastral=f.codigocatastral group by f.codigocatastral";
							$res=mysql_query($sqlr,$linkbd);
							$np=0;
							$tpredial=0;
							$tbomberil=0;
							$tambiental=0;
							
							while ($row =mysql_fetch_row($res)) 
							{
									$nter=buscatercero($row[3]);
									$sqlr2="select tasa from tesoprediosavaluos where vigencia='".$_POST[vigencias]."' and codigocatastral='$row[0]'";
									$res2=mysql_query($sqlr2,$linkbd);
									$row2=mysql_fetch_row($res2);
									$base=$row[1];
									$predial=$base*($row2[0]/1000);
									$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and concepto='03' order by concepto";
									//echo $sqlr2;
									$res3=mysql_query($sqlr2,$linkbd);
									$r3=mysql_fetch_row($res3);
									$bomberil=ceil($predial*($r3[5]/100));
									$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and concepto='02' order by concepto";
									//echo $sqlr2;
									$res3=mysql_query($sqlr2,$linkbd);
									$r3=mysql_fetch_row($res3);
									$ambiental=ceil($predial*($r3[5]/100));
									if($predial>0 && $bomberil>0 && $ambiental>0)
									{
										echo "<tr class='saludo3'>
														<td>$row[0]</td>
														<td>$row[2]</td>
														<td>$row[3]</td>
														<td>$nter</td>
														<td>$row[4]</td>
														<td>$row[1]</td>
														<td>$predial</td>
														<td>$bomberil</td>
														<td>$ambiental</td>
													";
										echo "
										<td>
											<input type='hidden' name='codcatastral[]' value='".$row[0]."'>
											<input type='hidden' name='tercero[]' value='".$row[3]."'>
											<input type='hidden' name='predial[]' value='".$predial."'>
											<input type='hidden' name='bomberil[]' value='".$bomberil."'>
											<input type='hidden' name='ambiental[]' value='".$ambiental."'>
										</td>
										</tr>";
										$tpredial+=$predial;
										$tbomberil+=$bomberil;
										$tambiental+=$ambiental;										
										
									}
									$np+=1;
							}
							echo "<tr class='saludo3'><td colspan='6'></td><td>".number_format($tpredial,2)."</td><td>".number_format($tbomberil,2)."</td><td>".number_format($tambiental,2)."</td></tr>";
						}
					?>
				</table>
			</div>      
			<?php
			if ($_POST[oculto]=='2')
			{
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaf],$fecha);
				$fechaf=$_POST[fecha];
				$linkbd=conectar_bd();
				$maximo=0;
				$numecomp=round(count($_POST[codcatastral])/40,0);
				echo $numecomp." - ".$np."<br>";
				$numecomp=$numecomp+1;
				$np1=0;
				for($x=0;$x<$numecomp;$x++)
				{
					$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp=1 ";
					$res=mysql_query($sqlr,$linkbd);
					//echo $sqlr;
					while($r=mysql_fetch_row($res))
					{
						$maximo=$r[0];
					}
					$maximo+=1;

					$sqlr2="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($maximo,'1','$fechaf','CAUSACION PREDIAL VIGENCIA $_POST[vigencias]',0,0,0,0,'1')";
					if (mysql_query($sqlr2,$linkbd))
					{
						$lim=$x*40;
						$limite=40+$lim;
						echo $limite." -- ".$lim."<br>";
						for($xy=$lim; $xy<$limite; $xy++)
						{
							$sqlre = "SELECT * FROM comprobante_det WHERE detalle LIKE '%$_POST[codcatastral][$xy]%' AND tipo_comp='1' AND vigencia='$_POST[vigencias]'";
							$rs3=mysql_query($sqlre,$linkbd);
							$row2=mysql_fetch_row($rs3);
							if($row2[0]=='')
							{
									$sq="select fechainicial from conceptoscontables_det where codigo='P09' and modulo='4' and tipo='C' and fechainicial<='$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='03' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{				 					  		
											if($row2[6]=='S')
											{
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('1 $maximo','".$row2[4]."','".$_POST[tercero][$xy]."','".$row2[5]."','CAUSACION BOMBERIL COD CAT ".$_POST[codcatastral][$xy]."','',".$_POST[bomberil][$xy].",0,'1','".$_POST[vigencias]."')";
												mysql_query($sqlr,$linkbd);
											}
											if($row2[6]=='N')
											{
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('1 $maximo','".$row2[4]."','".$_POST[tercero][$xy]."','".$row2[5]."','CAUSACION BOMBERIL COD CAT ".$_POST[codcatastral][$xy]."','',0,".$_POST[bomberil][$xy].",'1','".$_POST[vigencias]."')";
												mysql_query($sqlr,$linkbd);
											}				
										}
									}
									$sq="select fechainicial from conceptoscontables_det where codigo='P09' and modulo='4' and tipo='C' and fechainicial<='$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P09' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{				 					  		
											if($row2[6]=='S')
											{
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('1 $maximo','".$row2[4]."','".$_POST[tercero][$xy]."','".$row2[5]."','CAUSACION AMBIENTAL CUENTAS DE ORDEN COD CAT ".$_POST[codcatastral][$xy]."','',".$_POST[ambiental][$xy].",0,'1','".$_POST[vigencias]."')";
												mysql_query($sqlr,$linkbd);
											}
											if($row2[6]=='N')
											{
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('1 $maximo','".$row2[4]."','".$_POST[tercero][$xy]."','".$row2[5]."','CAUSACION AMBIENTAL CUENTAS DE ORDEN COD CAT ".$_POST[codcatastral][$xy]."','',0,".$_POST[ambiental][$xy].",'1','".$_POST[vigencias]."')";
												mysql_query($sqlr,$linkbd);
											}
								
											//echo "<tr class='saludo3'><td>$row[0]</td><td>$row[2]</td><td>$row[3]</td><td>$nter</td><td>$row[4]</td><td>$row[1]</td><td>$predial</td><td>$ambiental</td></tr>";
										}
									}	
									$sq="select fechainicial from conceptoscontables_det where codigo='P09' and modulo='4' and cc='$cc' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='01' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{				 					  		
											if($row2[6]=='S')
											{
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('1 $maximo','".$row2[4]."','".$_POST[tercero][$xy]."','".$row2[5]."','CAUSACION PREDIAL COD CAT $".$_POST[codcatastral][$xy]."','',".$_POST[predial][$xy].",0,'1','".$_POST[vigencias]."')";
												mysql_query($sqlr,$linkbd);
											}
											if($row2[6]=='N')
											{
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('1 $maximo','".$row2[4]."','".$_POST[tercero][$xy]."','".$row2[5]."','CAUSACION PREDIAL COD CAT ".$_POST[codcatastral][$xy]."','',0,".$_POST[predial][$xy].",'1','".$_POST[vigencias]."')";
												mysql_query($sqlr,$linkbd);
											}						
											//	echo "<tr class='saludo3'><td>$row[0]</td><td>$row[2]</td><td>$row[3]</td><td>$nter</td><td>$row[4]</td><td>$row[1]</td><td>$predial</td><td>$bomberil</td></tr>";
										}
									} 
								}
								$np1+=1;
							
						}
					}
					else
					{
					}	 
				}
			}
		?>
	</form>
 </td></tr>
</table>
</body>
</html>