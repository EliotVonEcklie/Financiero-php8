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
		<title>:: Spid - Calidad</title>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<?php titlepag();?>
	</head>
	<body>
		<?php
			$procesos[]=array();
			$tprocesos[]=array();
			$linkbd=conectar_bd();
			$sqlr="Select * from dominios where dominios.nombre_dominio='PROCESOS_CALIDAD' order by valor_final ";
			$resp = mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($resp))
			{
				$tprocesos[$row[1]][0]=$row[0];
				$tprocesos[$row[1]][1]=$row[1];
				$tprocesos[$row[1]][2]=$row[2];
				$tprocesos[$row[1]][4]=$row[4];
			}
			$sqlr="Select calprocesos.id, calprocesos.nombre, DOMINIOS.TIPO,calprocesos.clasificacion, calprocesos.prefijo from calprocesos, dominios where dominios.nombre_dominio='PROCESOS_CALIDAD' AND calprocesos.clasificacion=DOMINIOS.VALOR_FINAL AND calprocesos.estado='S' ";
			$resp = mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($resp))
			{
				$procesos[$row[0]][0]=$row[0];
				$procesos[$row[0]][2]=$row[2];
				$procesos[$row[0]][1]=$row[1];
				$procesos[$row[0]][3]=$row[3];
				$procesos[$row[0]][4]=$row[4];
			}
			$_POST[codigo]=$mx+1;
		?>
		<div class="row">
			<!-- panel panel-primary-->
			<div class="panel panel-primary table-responsive" style="margin-left: 20px;margin-right: 20px;  height: 95%">
				<div class="panel-heading" style='padding-bottom: 3px;padding-top: 3px;'>
					<h5 class="panel-title text-center">PROCESOS</h5>
				</div>
				<div class="panel-body center">
					<!-- Inicio Entradas-->
					<div class="col-lg-2" style="padding-right: 0px;left: 0.5%;">
						<div class="panel panel-verde" style='height: 90%;'> <!-- panel panel-primary-->
							<div class="panel-heading">
								<h5 class="panel-title">ENTRADAS</h5>
							</div> 
							<div class="panel-body center">
								<div class='' id='divloco' style='transform : rotate(270deg);width: 360px;height: 360px;'>
									<!-- small box -->
									<div class="small-box1 bg-aqua small-box-entrada-salida borde-redondo2" style="border: 1px solid #666;">
										<div class="inner">
											<?php 
												$cv=count($procesos);
												$ct=count($tprocesos);
												//   echo "sss".$ct;
												for($t=1;$t<$ct;$t++) // For 2
												{
													//echo "t:".$tprocesos[$t][4]."<>";
													if($tprocesos[$t][4]=='E' ) // IF 2
													{
														//echo "sss".$cv;
														for($x=1;$x<=$cv;$x++ ) // FOr 1
														{
															//echo "t:".$tprocesos[$t][1];
															if($procesos[$x][2]=='E' && $procesos[$x][3]==$tprocesos[$t][1])//IF 1
															{
																echo"
																<p class='text-center' style='color: black;'>".$procesos[$x][1]." (".$procesos[$x][4].")</p>";
																//echo "<b>".$procesos[$x][1]." (".$procesos[$x][4].")</b>";
																//echo "<img class='valign' />".$procesos[$x][1]." (".$procesos[$x][4].")";
															}//If 1
														}//FOR 1
													}//IF2
												}//FR 2
											?>
										</div>
										<div class="icon">
											<i class="glyphicon glyphicon-cog"></i>
										</div>
									</div>
								</div>
							</div> 
						</div>  <!-- Fin macroproceso -->
					</div><!- Fin Entradas ->
					<div class="col-lg-8">
						<!- Inicio Procesos ->
						<?php
							$cv=count($procesos);
							$ct=count($tprocesos);
							// echo "sss".$ct;
							$colorProcesos[1]='small-box bg-aqua';
							$colorProcesos[0]='small-box bg-yellow';
							$colorProcesos[2]='small-box bg-red';
							$colorProcesos[3]='small-box bg-green';
							$idcolorProcesos=0;
							for($t=1;$t<$ct;$t++)// INICIO For 1
							{
								//echo "t:".$tprocesos[$t][4];
								if($tprocesos[$t][4]=='P')// Inicio if 1
								{
									if($idcolorProcesos>=3){$idcolorProcesos=0;}
									else {$idcolorProcesos+=1;}
									$contadorSubprocesos=0;
									for($x=1;$x<=$cv;$x++ )
									{
										if($procesos[$x][2]=='P' && $procesos[$x][3]==$tprocesos[$t][1])
										{$contadorSubprocesos++;}
									}
									echo"
									<div class='panel panel-verde' style='margin-bottom: 3px;'> <!-- panel panel-primary-->
										<div class='panel-heading' style='padding-bottom: 3px;padding-top: 3px;'> 
											<h5 class='panel-title text-center'>".$tprocesos[$t][2]."</h5>
										</div>";
									$procesosarray =explode(" ",$tprocesos[$t][2]);
									echo"
										<div style='position: relative' id='collapseProcesos$t'>";
									if($tprocesos[$t][2]=='PROCESOS MISIONALES')
									{
										echo"
											<div class='flecha-derecha' style='position:absolute; z-index:3;left: 95%;'>
												<img src='imagenes/arrow-azul-derecha2.png' style='width: 80px;'>
											</div>
											<div class='flecha-derecha' style='position:absolute; z-index:3;left: -30px;'>
												<img src='imagenes/arrow-azul-derecha2.png' style='width: 80px;'>
											</div>";
									} 
									else if($tprocesos[$t][2]=='PROCESOS ESTRATEGICOS')
									{
										echo"
											<div class='flecha-abajo' style='position:absolute; z-index:3;left: 80%;'>
												<img src='imagenes/arrow-azul-abajo2.png' style='width: 70px;'>
											</div>
											<div class='flecha-abajo' style='position:absolute; z-index:3;left: 10%;'>
												<img src='imagenes/arrow-azul-abajo2.png' style='width: 70px;'>
											</div>";
									} 
									else
									{
										echo"
											<div class='flecha-ariba' style='position:absolute; z-index:3;left: 80%;'>
												<img src='imagenes/arrow-azul-ariba2.png' style='width: 70px;'>
											</div>
											<div class='flecha-ariba' style='position:absolute; z-index:3;left: 10%;'>
												<img src='imagenes/arrow-azul-ariba2.png' style='width: 70px;'>
											</div>";
									} 
									echo"
											<div class='panel-body' style='padding-bottom: 0px;' id='P".$tprocesos[$t][0]."'>";
									//small-box bg-aqua
									//small-box bg-yellow
									//small-box bg-red
									//small-box bg-green
									//$contadorSubprocesos=3;
									$auxContadorSubprocesos=0;
									for($x=1;$x<=$cv;$x++ )
									{	
										//echo "t:".$tprocesos[$t][1];
										if($procesos[$x][2]=='P' && $procesos[$x][3]==$tprocesos[$t][1]) 
										{
											switch ($contadorSubprocesos)
											{
												case 1:	$posicionProcesoso='col-lg-5 col-xs-6 col-md-offset-3';
														break;
												case 2:	$posicionProcesoso='col-lg-4 col-xs-4 ';
														if($auxContadorSubprocesos==0){$posicionProcesoso.='col-md-offset-2';}
														break;
												case 3:	$posicionProcesoso='col-lg-4 col-xs-4';
														break;
												default:$posicionProcesoso='col-lg-3 col-xs-3';
											}
											$auxContadorSubprocesos++;
											echo"
											<div class='$posicionProcesoso' id='divloco'><!-- small box -->
												<div class='small-box bg-aqua borde-redondo' style='border: 1px solid #666;'>
													<div class='inner'>
														<p class='text-center' style='color: black;font-size: xx-small'>".$procesos[$x][1]." (".$procesos[$x][4].")</p>
													</div>
													<div class='icon2'>
														<i class='glyphicon glyphicon-cog'></i>
													</div>
												</div>
											</div>";
										}
									}
									echo"
										</div> 
									</div> 
						</div> <!-- FIn panel panel-primary-->";
								} // Fin if 1
							}//Fin fr 1
						?>
						<!- Inicio Procesos ->
				</div>
				<div class="col-lg-2" style='right: 0.5%; padding-left: 0px;'><!- Inicio Salidas ->
					<div class="panel panel-verde" style='height: 90%;'> <!-- panel panel-primary-->
						<div class="panel-heading"> 
							<h5 class="panel-title">SALIDAS</h5>
						</div> 
						<div class="panel-body" >
							<div class='' id='divloco' style='transform : rotate(270deg);width: 360px;height: 360px;'><!-- small box -->
								<div class="small-box1 bg-aqua small-box-entrada-salida borde-redondo2" style='border: 1px solid #666;'>
									<div class="inner">
										<?php
											$cv=count($procesos);
											$ct=count($tprocesos);
											//   echo "sss".$ct;
											for($t=1;$t<$ct;$t++)// Inicio For 3
											{
												//   echo "t:".$tprocesos[$t][4];
												if($tprocesos[$t][4]=='S' )//inicio if 3
												{ 
													//   echo "sss".$cv;
													for($x=1;$x<=$cv;$x++ ) // Inicio For 4
													{ 
														//echo "t:".$tprocesos[$t][1];
														if($procesos[$x][2]=='S' && $procesos[$x][3]==$tprocesos[$t][1])//inicio if 4
														{ 
															//echo "<img class='valign' />".$procesos[$x][1]." (".$procesos[$x][4].")";
															echo"
															<p class='text-center' style='color: black;'>".$procesos[$x][1]." (".$procesos[$x][4].")</p>";
															//echo "<b>".$procesos[$x][1]." (".$procesos[$x][4].")</b>";
														} //fin if 4
													} //Fin for 4
												} //fin if 3
											} //Fin for 3
										?>
									</div>
									<div class="icon">
										<i class="glyphicon glyphicon-cog"></i>
									</div>
								</div>
							</div>
						</div><!- Fin Salidas ->
					</div>
				</div>
			</div>
		</div> 
		<style>
			.borde-redondo
			{
				border-radius: 123px 123px 123px 123px;
				-moz-border-radius: 123px 123px 123px 123px;
				-webkit-border-radius: 123px 123px 123px 123px;
			}
			.borde-redondo2
			{
				border-radius: 42px 42px 42px 42px;
				-moz-border-radius: 42px 42px 42px 42px;
				-webkit-border-radius: 42px 42px 42px 42px;
			}
		</style>
		<script type="text/javascript">
    $(document).ready(function() {

      var height = $('#collapseProcesos2').height();
      var top = parseInt(height/2)-40;
      $('.flecha-derecha').css({top: top});
      var height = $('#collapseProcesos1').height();
      var top = height+parseInt(height/3);
      $('.flecha-abajo').css({bottom: -50});
      var height = $('#collapseProcesos3').height();
      var top = height+parseInt(height/3);
      $('.flecha-ariba').css({bottom: 50});
	});
  </script>
</body>
</html>

