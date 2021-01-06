<?php 
ini_set('max_execution_time',3600);
require "comun.inc";
require "funciones.inc";
session_start();

//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>:: Spid - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			$(window).load(function () { $('#cargando').hide();});
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

			function pdf()
			{
				document.form2.action="pdfmayorybalance.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function direccionaCuentaGastos(row)
			{
				var cell = row.getElementsByTagName("td")[0];
				var id = cell.innerHTML;
				var fech=document.getElementById("fecha").value;
				var fech1=document.getElementById("fecha2").value;
				window.open("cont-auxiliarcuenta.php?cod="+id+"&fec="+fech+"&fec1="+fech1);
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
				<td colspan="3" class="cinta">
					<a href="cont-mayorybalance.php" class="mgbt"><img src="imagenes/add.png"  alt="Nuevo" title="Nuevo"/></a>
					<a href="#"  onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png" alt="Guardar" title="Guardar"/></a>
					<a href="#" onClick="document.form2.submit()" class="mgbt"> <img src="imagenes/busca.png" alt="Buscar" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a> <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" alt="imprimir"></a>
					<a href="cont-balancepruebaexcel.php" target="_blank" class="mgbt"><img src="imagenes/excel.png"  alt="excel" title="Excel"></a>
					<a href="<?php echo "archivos/".$_SESSION[usuario]."balanceprueba-nivel$_POST[nivel].csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png"  alt="csv" title="csv"></a>
					<a href="cont-librosoficiales.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
				</td>
			</tr>
		</table>
		<tr>
			<td colspan="3" class="tablaprin"> 
 			<form name="form2" method="post" action="cont-mayorybalance.php">
			 	
				<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if($_POST[consolidado]=='')
					$chkcomp=' ';
				else
					$chkcomp=' checked ';
				if($_POST[cierre]=='')
				{
					$chkcierre=' ';
				}
				else
				{ 
					$chkcierre	=' checked ';
				}
 				?>
    			<table  align="center" class="inicio" >
      				<tr>
						<td class="titulos" colspan="7" >.: Libro Mayor y Balances</td>
						<td  class="cerrar"><a href="cont-principal.php">Cerrar</a></td>
      				</tr>
      				<tr>
						<td class="saludo1">Nivel:</td>
						<td>
							<select name="nivel" id="nivel">
								<?php
								$niveles=array();
								$linkbd=conectar_bd();
								$sqlr="Select * from nivelesctas  where estado='S' order by id_nivel";
								// echo $sqlr;
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									$i=$row[0];
									$niveles[]=$row[4];
									echo "<option value=$row[0] ";
									if($i==$_POST[nivel])
									{
										echo "SELECTED";
									}
									echo " >".$row[0]."</option>";	  
								}			
								?>
        					</select>
							<input name="oculto" type="hidden" value="1">
						</td>
						<td class="saludo1" >Mes Inicial:</td>
						<td>
							<select name="periodo1" id="periodo1" onChange=""  >
				  				<option value="-1">Seleccione ....</option>
								<?php
					 			$sqlr="Select * from meses where estado='S' ";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									$i=$row[0];
									echo "<option value=$row[0] ";
									if($i==$_POST[periodo1])
			 						{
										echo "SELECTED";
										$_POST[periodonom1]=$row[1];
										$_POST[periodo2]=$_POST[periodo1];
										//$_POST[periodonom1]=$row[2];
				 					}
									echo " >".$row[1]."</option>";	  
			     				}   
								?>
		  					</select>
		  
          					<input id="periodonom2" name="periodonom2" type="hidden" value="<?php echo $_POST[periodonom2]?>" >        
						</td>
       					<td class="saludo1">Centro Costo:</td>
	  					<td>
							<select name="cc" onKeyUp="return tabular(event,this)">
    							<option value="" >Seleccione...</option>
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
	 						<input type="button" name="generar" value="Generar" onClick="document.form2.submit()">
						</td>
						<td class="saludo1">
							<span  style=" vertical-align:middle; width:10px"> Consolidado 
							<input type="checkbox" name="consolidado" id="consolidado" value="1" <?php echo $chkcomp ?>  style="vertical-align:middle; "></span> <span  style=" vertical-align:middle"> Cierre 
							<input type="checkbox" name="cierre" id="cierre" value="1" <?php echo $chkcierre ?>  style="vertical-align:middle;"></span>
						</td>
       				</tr>  
	   				<tr><td></td></tr>                  
    			</table>
    
				<div class="subpantallap">
  					<?php
 					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					//**** para sacar la consulta del balance se necesitan estos datos ********
					//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
					$oculto=$_POST['oculto'];
					if($_POST[oculto])
					{
						?>
						<div class="loading" id="divcarga"><span>Cargando...</span></div> 
						<?php
						if($_POST[consolidado]=='1')
						{
							$critcons=" ";	 
							$_POST[cc]="";
						}
						if($_POST[consolidado]!='1')
						{
							$critcons="";
							if($_POST[tipocc]=='N' )
							{
								$critcons="";
							}
							else
							{
								$sqlrcc="SELECT id_cc from centrocosto where entidad='N'";
								$rescc=mysql_query($sqlrcc,$linkbd);
								while($rowcc=mysql_fetch_row($rescc))
 								{ 
  									$critcons.=" and comprobante_det.centrocosto <> '".$rowcc[0]."' ";	 
 								}
 							}	 
						}

						if($_POST[cierre]=='1')
						{
 							$critconscierre=" ";	 
						}
						else
						{
 							$critconscierre=" and comprobante_det.tipo_comp <> 13 ";	 
						}

						$horaini=date('h:i:s');		
						$linkbd=conectar_bd();
						//Borrar el balance de prueba anterior
						$sqlr2="SELECT distinct digitos, posiciones from nivelesctas where estado='S' ORDER BY id_nivel DESC ";
						$resn=mysql_query($sqlr2,$linkbd);
						$rown=mysql_fetch_row($resn);
						$nivmax=$rown[0];
						$dignivmax=$rown[1];

						$sqlr="Delete from balancepre";
						mysql_query($sqlr,$linkbd);

						$sqlr="Delete from balanceprueba";
						mysql_query($sqlr,$linkbd);
						//continuar**** creacion balance de prueba
						//$namearch="archivos/".$_SESSION[usuario]."balanceprueba.csv";
						//$Descriptor1 = fopen($namearch,"w+"); 
						//fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");
						$_POST[fecha]="01/".$_POST[periodo1]."/".$vigusu;
						$_POST[fecha2]="31/".$_POST[periodo1]."/".$vigusu;
						?>
						<input name="fecha" type="hidden" id="fecha" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">  <input id="periodonom1" name="periodonom1" type="hidden" value="<?php echo $_POST[periodonom1]?>" > 
    					<input name="fecha2" type="hidden" id="fecha2" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">  <input id="periodo2" name="periodo2" type="hidden" value="<?php echo $_POST[periodo2]?>" >
						<?php
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
						$f1=$fechafa2;	
						$f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);	
						$fechafa=$vigusu."-01-01";
						$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
						unset($pctas);
						unset($pctasb);
	 					$tam=$niveles[$_POST[nivel]-1];
						$sqlr2="SELECT distinct cuenta,tipo from cuentasnicsp where estado ='S'  and length(cuenta)=$tam ".$crit1."  order by cuenta ";
						$rescta=mysql_query($sqlr2,$linkbd);
						$i=0;
						//echo $sqlr2;
						while ($row =mysql_fetch_row($rescta)) 
 						{
							$pctas[]=$row[0];
							$pctasb["$row[0]"][0]=$row[0];
							$pctasb["$row[0]"][1]=0;
							$pctasb["$row[0]"][2]=0;
							$pctasb["$row[0]"][3]=0;
 						}
						mysql_free_result($rescta);
						for($mini=$_POST[periodo1];$mini<=$_POST[periodo2];$mini++)
						{
							$formato=mktime(0,0,0,$mini,1, $vigusu);
							$mf=strtoupper(strftime("%B",$formato));
							//$mesp="PERIODO: $mini";
							//$_POST[dncuentas][]="$mini".date("M",$mini);
							//echo "<input type='hidden' name='dcuentas[]' value= '$mesp'> <input type='hidden' name='dncuentas[]' value= '$mf'><input type='hidden' name='dsaldoant[]' value= ''> <input type='hidden' name='ddebitos[]' value= ''> <input type='hidden' name='dcreditos[]' value= ''><input type='hidden' name='dsaldo[]' value= ''>";
							//****borrar el array()
							foreach($pctasb as $k => $valores )
							{
								$pctasb[$k][1]=0;
								$pctasb[$k][2]=0;
								$pctasb[$k][3]=0;	
							}
							//unset($pctas);
							//unset($pctasb);
							//$pctas=array();
							//$pctasb[]=array();
							$_POST[fecha]="01/".$mini."/".$vigusu;
							$_POST[fecha2]="31/".$mini."/".$vigusu;
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
							$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
							$f1=$fechafa2;	
							$f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);	
							$fechafa=$vigusu."-01-01";
							$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
							$mesinicial="CONCAT(YEAR(fecha),'-',MONTH(fecha))";
							$mesinicial="CONCAT(YEAR(fecha),'-',MONTH(fecha))";
  							echo "<table class='inicio'><tr><td colspan='6' class='titulos'>Balance de Prueba MES: $mini - $mf   $_POST[fecha] $_POST[fecha2]</td></tr>";
  							echo "<tr><td class='titulos2'>Codigo</td><td class='titulos2'>Cuenta</td><td class='titulos2'>Saldo Anterior</td><td class='titulos2'>Debito</td><td class='titulos2'>Credito</td><td class='titulos2'>Saldo Final</td></tr>";
    						$tam=$niveles[$_POST[nivel]-1];
							//$crit1=" and left(cuenta,$tam)>='$_POST[cuenta1]' and left(cuenta,$tam)<='$_POST[cuenta2]' ";

							$tam=$niveles[$_POST[nivel]-1];
							//echo "tc:".count($pctas);

							//******MOVIMIENTOS PERIODO
							$sqlr3="SELECT DISTINCT
								SUBSTR(comprobante_det.cuenta,1,$tam),
								sum(comprobante_det.valdebito),
								sum(comprobante_det.valcredito)
     							FROM comprobante_det, comprobante_cab
    							WHERE     comprobante_cab.tipo_comp = comprobante_det.tipo_comp
								AND comprobante_det.numerotipo = comprobante_cab.numerotipo
								AND comprobante_cab.estado = 1
								AND (   comprobante_det.valdebito > 0
               					OR comprobante_det.valcredito > 0)
		    					AND comprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2'
          						AND comprobante_det.tipo_comp <> 7  AND comprobante_det.tipo_comp <> 102 AND comprobante_det.tipo_comp <> 100 AND comprobante_det.tipo_comp <> 101 AND comprobante_det.tipo_comp <> 103 AND comprobante_det.tipo_comp<>104 ".$critcons." ".$critconscierre."         
		  		  				AND comprobante_det.centrocosto like '%$_POST[cc]%'
		  						GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
								ORDER BY comprobante_det.cuenta";
   								$res=mysql_query($sqlr3,$linkbd);
 								//  echo $sqlr3;
								while ($row =mysql_fetch_row($res)) 
								{
									$pctasb["$row[0]"][0]=$row[0];
									$pctasb["$row[0]"][2]=$row[1];
									$pctasb["$row[0]"][3]=$row[2];
 								}
 
								$sqlrTipoComp = "SELECT codigo FROM tipo_comprobante WHERE codigo=102";
								$resTipoComp=mysql_query($sqlrTipoComp,$linkbd);
								$rowTipoComp =mysql_fetch_row($resTipoComp);
								if($rowTipoComp[0]!='')
								{
									$tipo_comp = 102;
								}
								else
								{
									$tipo_comp = 7;
								}
								//**** SALDO INICIAL ***
								$sqlr3="SELECT DISTINCT
								SUBSTR(comprobante_det.cuenta,1,$tam),
								sum(comprobante_det.valdebito)-
								sum(comprobante_det.valcredito)
     							FROM comprobante_det, comprobante_cab
    							WHERE  comprobante_cab.tipo_comp = comprobante_det.tipo_comp
								AND comprobante_det.numerotipo = comprobante_cab.numerotipo
								AND comprobante_cab.estado = 1
								AND (   comprobante_det.valdebito > 0
               					OR comprobante_det.valcredito > 0)         
          						AND comprobante_det.tipo_comp = $tipo_comp 
		  		  				AND comprobante_det.centrocosto like '%$_POST[cc]%'
		  						GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
								ORDER BY comprobante_det.cuenta";
   								$res=mysql_query($sqlr3,$linkbd);
  								// echo $sqlr3;
								while ($row =mysql_fetch_row($res)) 
								{
									$pctasb["$row[0]"][0]=$row[0];
									$pctasb["$row[0]"][1]=$row[1];
 								}
								//*******MOVIMIENTOS PREVIOS PERIODO
								if($fechafa2>='2018-01-01')
								{
									$fecini='2018-01-01';
									$sqlr3="SELECT DISTINCT
									SUBSTR(comprobante_det.cuenta,1,$tam),
									sum(comprobante_det.valdebito)-
									sum(comprobante_det.valcredito)
									FROM comprobante_det, comprobante_cab
									WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
									AND comprobante_det.numerotipo = comprobante_cab.numerotipo
									AND comprobante_cab.estado = 1
									AND (comprobante_det.valdebito > 0
									OR comprobante_det.valcredito > 0)
									AND comprobante_det.tipo_comp <> 100
									AND comprobante_det.tipo_comp <> 101
									AND comprobante_det.tipo_comp <> 103
									AND comprobante_det.tipo_comp <> 102
									AND comprobante_det.tipo_comp <> 104
									AND comprobante_det.cuenta!=''
									AND comprobante_det.tipo_comp <> 7  $critcons $critcons2
									AND comprobante_cab.fecha BETWEEN '$fecini' AND '$fechafa2'
									AND comprobante_det.centrocosto like '%$_POST[cc]%'
									GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
									ORDER BY comprobante_det.cuenta";
									$res=mysql_query($sqlr3,$linkbd);
									//  sort($pctasb[]);
									while ($row =mysql_fetch_row($res)) 
									{
										$pctasb["$row[0]"][0]=$row[0];
										$pctasb["$row[0]"][1]+=$row[1]; 
									} 
								}
								for ($y=0;$y<$_POST[nivel];$y++)
								{
									$lonc=count($pctasb);
									//foreach($pctasb as $k => $valores )
									$k=0;
									// echo "lonc:".$lonc;
									//   while($k<$lonc)
									foreach($pctasb as $k => $valores )
									{
										if (strlen($pctasb[$k][0])>=$niveles[$y-1])
										{
											$ncuenta=substr($pctasb[$k][0],0,$niveles[$y-1]);
											if($ncuenta!='')
											{
												$pctasb["$ncuenta"][0]=$ncuenta;
												$pctasb["$ncuenta"][1]+=$pctasb[$k][1];
												$pctasb["$ncuenta"][2]+=$pctasb[$k][2];
												$pctasb["$ncuenta"][3]+=$pctasb[$k][3];
												//echo "<br>N:".$niveles[$y-1]." : cuenta:".$k." NC:".$ncuenta."  ".$pctasb["$ncuenta"][1]."  ".$pctasb["$ncuenta"][2]."  ".$pctasb["$ncuenta"][3];	
	  										}
	 									}
	   									$k++;
									}
 								}
								$sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),saldoinicial double,debito double,credito double,saldofinal double)";
								mysql_query($sqlr,$linkbd);
								$i=1;
								$sqlr="delete from usr_session";
								mysql_query($sqlr,$linkbd);
								foreach($pctasb as $k => $valores )
								{
									if($pctasb[$k][0]!=' ' && ($pctasb[$k][1]<0 || $pctasb[$k][1]>0) || ($pctasb[$k][2]<0 || $pctasb[$k][2]>0) || ($pctasb[$k][3]<0 || $pctasb[$k][3]>0))
									{
										$saldofinal=$pctasb[$k][1]+$pctasb[$k][2]-$pctasb[$k][3];
										$nomc=existecuentanicsp($pctasb[$k][0]);
										$sqlr="insert into usr_session (id,cuenta,nombrecuenta,saldoinicial,debito,credito,saldofinal) values($i,'".$pctasb[$k][0]."','".$nomc."',".$pctasb[$k][1].",".$pctasb[$k][2].",".$pctasb[$k][3].",".$saldofinal.")";
										mysql_query($sqlr,$linkbd);
										//echo "<br>".$sqlr;
										$i+=1;
									}	
	 								//echo "<br>cuenta:".$k."  ".$pctasb[$k][1]."  ".$pctasb[$k][2]."  ".$pctasb[$k][3];	
								}
								$sqlr="SELECT *from usr_session order by cuenta";
								$res=mysql_query($sqlr,$linkbd);
								$_POST[tsaldoant]=0;
								$_POST[tdebito]=0;
								$_POST[tcredito]=0;
								$_POST[tsaldofinal]=0;
	 
								$namearch="archivos/".$_SESSION[usuario]."balanceprueba-nivel$_POST[nivel].csv";
								$Descriptor1 = fopen($namearch,"w+"); 
								fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");
								$co='saludo1';
								$co2='saludo2';
								while($row=mysql_fetch_row($res))
								{
									$negrilla="style='font-weight:bold'";
									$puntero="";
									$dobleclick="";
									if (strlen($row[1])==($dignivmax))
									{
										// $negrilla=" "; 
										//$_POST[tsaldoant]+=$row[3];
										//$_POST[tdebito]+=$row[4];
										//$_POST[tcredito]+=$row[5];
									}
									if($niveles[$_POST[nivel]-1]==strlen($row[1]))
									{
										$negrilla=" "; 
										$puntero="style=\"cursor: hand\" ";
										$dobleclick="ondblclick='direccionaCuentaGastos(this)'";			  
										$_POST[tsaldoant]+=$row[3];
										$_POST[tdebito]+=$row[4];
										$_POST[tcredito]+=$row[5];			  
										$_POST[tsaldofinal]+=$row[6];			  	
									}
									echo "
										<tr class='$co' $puntero $dobleclick>
											<td $negrilla>$row[1]</td>
											<td $negrilla>$row[2]</td>
											<td $negrilla align='right'>".number_format($row[3],2,".",",")."</td>
											<td $negrilla align='right'>".number_format($row[4],2,".",",")."</td>
											<td $negrilla align='right'>".number_format($row[5],2,".",",")."</td>
											<td $negrilla align='right'>".number_format($row[6],2,".",",")."</td>
										</tr>";
	 									echo "<input type='hidden' name='dcuentas[]' value= '$row[1]'> <input type='hidden' name='dncuentas[]' value= '$row[2]'><input type='hidden' name='dsaldoant[]' value= '$row[3]'> <input type='hidden' name='ddebitos[]' value= '$row[4]'> <input type='hidden' name='dcreditos[]' value= '$row[5]'><input type='hidden' name='dsaldo[]' value= '$row[6]'></tr>" ;
	 
	  								fputs($Descriptor1,$row[1].";".$row[2].";".number_format($row[3],2,",","").";".number_format($row[4],2,",","").";".number_format($row[5],2,",","").";".number_format($row[6],2,",","")."\r\n");
									$aux=$co;
									$co=$co2;
									$co2=$aux;
									$i=1+$i;
  								}
								fclose($Descriptor1);
  								echo "<tr class='$co'><td colspan='2'></td><td class='$co' align='right'>".number_format($_POST[tsaldoant],2,".",",")."<input type='hidden' name='tsaldoant' value= '$_POST[tsaldoant]'></td><td class='$co' align='right'>".number_format($_POST[tdebito],2,".",",")."<input type='hidden' name='tdebito' value= '$_POST[tdebito]'></td><td class='$co' align='right'>".number_format($_POST[tcredito],2,".",",")."<input type='hidden' name='tcredito' value= '$_POST[tcredito]'></td><td class='$co' align='right'>".number_format($_POST[tsaldofinal],2,".",",")."<input type='hidden' name='tsaldofinal' value= '$_POST[tsaldofinal]'></td></tr>";  
						}
						$horafin=date('h:i:s');	
						echo "<DIV class='ejemplo'>INICIO:$horaini FINALIZO: $horafin</DIV> <script>document.getElementById('divcarga').style.display='none';</script>";
					}
					?> 
				</div>
			</form>
		</td>
	</tr>
</table>
</body>
</html>