<?php
	require "comun.inc";
	require "funciones.inc";
	require "validaciones.inc";
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
		<title>:: Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function pdf()
			{
				document.form2.action="pdfbalance.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function validar(){document.form2.submit(); }
			function validarchip(){document.form2.vchip.value=1;document.form2.submit();}
			function next(){document.form2.pasos.value=parseFloat(document.form2.pasos.value)+1; document.form2.submit();}
			function generar(){document.form2.genbal.value=1;document.form2.gbalance.value=0;document.form2.submit();}
			function guardarbalance(){document.form2.gbalance.value=1;document.form2.submit();}
			function guardarchip(){document.form2.gchip.value=1; document.form2.submit();}
			function cargarotro(){document.form2.cargabal.value=1; document.form2.submit();}
			function checktodos()
			{
				cali=document.getElementsByName('ctes[]');
				for (var i=0;i < cali.length;i++) 
				{ 
					if (document.getElementById("todoscte").checked == true)
					{cali.item(i).checked = true;document.getElementById("todoscte").value=1;}
					else{cali.item(i).checked = false;document.getElementById("todoscte").value=0;}
				}	
			}
			function checktodosn()
			{
				cali=document.getElementsByName('nctes[]');
				for (var i=0;i < cali.length;i++) 
				{ 
					if (document.getElementById("todoscten").checked == true) 
					{cali.item(i).checked = true;document.getElementById("todoscten").value=1;	 }
					else{cali.item(i).checked = false;document.getElementById("todoscten").value=0;}
				}	
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
					<a href="cont-opereciprocas.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a>
					<?php if($_POST[gchip]=='1'){?><a href="<?php echo "archivos/".$_SESSION[usuario]."chip-$_POST[periodo].csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv"></a><a href="descargartxt.php?id=<?php echo "CGN2015_002_OPERACIONES_RECIPROCAS_CONVERGENCIA.txt"; ?>&dire=archivos" target="_blank" class="mgbt"><img src="imagenes/cgn.png" style="width: 40px; height: 40px;" title="contraloria general de la nacion"></a><?php } ?>
					<a href="cont-gestioninformecgr.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
         	</tr>
    	</table>
  		<form name="form2" action="cont-opereciprocas.php"  method="post" enctype="multipart/form-data" >
 			<?php
			 	if(!$_POST[oculto]){$_POST[pasos]=1;$_POST[oculto]=1;$_POST[reglas]=1;}
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				if($_POST[reglas]==1){$chkchip=" checked";}
 				else {$chkchip=" ";}
 				
   				$vact=$vigusu;    
	  			//*** PASO 2		  
				$sqlr="select *from configbasica where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
	 			{
  					$_POST[nitentidad]=$row[0];
  					$_POST[entidad]=$row[1];
					$_POST[codent]=$row[8];
				}
				if ($_POST[manual]=="0") 
				{
					$coloracti="#C00";
				}
				else
				{
					$coloracti="#0F0";
				}
	 		?> 
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto] ?>">
            <input type="hidden" name="pasos" id="pasos" value="<?php echo $_POST[pasos] ?>">
            <input type="hidden" name="periodo" id="periodo" value="<?php echo $_POST[periodo] ?>"> 
    		<table class="inicio" align="center"> 
      		<tr>
        		<td class="titulos" colspan="10">Operaciones Reciprocas</td>
        		<td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
     		</tr>   
      		<tr>
            	<td class="saludo3" style="width:6%;">Vigencia:</td>      
      			<td style="width:11%;">
      				<?php
      				
	   					if($_POST[pasos]>1)
	  	 				{
							?>
							<input type="text" name="vigencias" value="<?php echo $_POST[vigencias]?>" style="width:98%;" readonly>
							<?php  
		 				}	
						else
		 				{ 	  
							?>
							<select name="vigencias" id="vigencias" style="width:98%;">
								<option value="">Sel..</option>
								<?php	  
									for($x=$vact;$x>=$vact-2;$x--)
									{
										if($x==$_POST[vigencias]){echo "<option  value=$x SELECTED>$x</option>";}
										else {echo "<option value=$x>$x</option>";}
									}
								?>
							</select>
							<?php
						}
	 				?>
      			</td>
      			<td class="saludo3" style="width:6%;">Periodo:</td>
      			<td  style="width:14%;">
      				<?php 
	  					if($_POST[pasos]>1)
	  	 				{
							$sqlr="Select * from chip_periodos  where id=$_POST[periodos] ";		
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
		 					{
								$_POST[periodo]=$row[1]; 
								$_POST[cperiodo]=$row[2]; 			
		 					}	 
							?>
							<input type="hidden" name="periodos" value="<?php echo $_POST[periodos]?>">
							<?php  
						}	
						else
		 				{	  
							?>
							<select name="periodos" id="periodos" onChange="validar()"  style="width:45%;" >
								<option value="">Sel..</option>
								<?php	  
									$sqlr="Select * from chip_periodos  where estado='S' order by id";		
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										if($row[0]==$_POST[periodos])
										{
											echo "<option value=$row[0] SELECTED>$row[2]</option>";
											$_POST[periodo]=$row[1]; 
											$_POST[cperiodo]=$row[2]; 	
										}
										else {echo "<option value=$row[0]>$row[2]</option>";}
									}
								?>
							</select>
							<?php
		 				}
	  				?>
                    <input type="hidden" name="periodo" value="<?php echo $_POST[periodo]?>">
                    <input type="text" name="cperiodo" value="<?php echo $_POST[cperiodo]?>"  style="width:45%;" readonly>
      			</td>
      			<td class="saludo1" style="width:15%;">
                	<span style=" vertical-align:middle; width:10px"> Reglas Chip (Signos)&nbsp;
      					<input type="checkbox" name="reglas" id="reglas" class="defaultcheckbox" value="1" <?php echo $chkchip?>>
                  	</span>
               	</td>
                <td></td>
      			<td class="saludo3" style="width:11%;">Codigo Entidad</td>
                <td><input name="codent" id="codent" type="text" value="<?php echo $_POST[codent]?>"></td>
				<td style="width:10%;" class="saludo1">Automatico:</td>
				<td style="width:10%;">
					<input type="hidden" id="contador" name="contador"  value="<?php echo $_POST[contador]; ?>" >
					
					<input type="hidden" id="oculto12" name="oculto12"  value="<?php echo $_POST[oculto12]; ?>">
					<input type="hidden" name="estado"  value="<?php echo $_POST[estado]; ?>" >
					<?php 
					$valuees="ACTIVO";
					$stylest="width:100%; background-color:#0CD02A ;color:#fff; text-align:center;";	
					echo "<input type='hidden' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";		
					?>
					<input type='range' name='manual' id="manual" value='<?php echo $_POST[manual]?>' min ='0' max='1' step ='1' style='background: <?php echo $coloracti; ?>; width:100%;position: relative;float: left;' onChange='validar()'/></td>
				</td>
         	</tr>
      		<tr>
            	<td class="saludo3">Nit:</td>
                <td>
                	<input type="hidden" name="nivel" value="4">
                    <input type="hidden" name="genbal"  value=" <?php echo $_POST[genbal]?>">
                    <input type="text" name="nitentidad" value="<?php echo $_POST[nitentidad]?>" style="width:98%;"readonly>
               	</td>
                <td class="saludo3">Entidad:</td>
                <td colspan="3">
                	<input type="text" name="entidad" value="<?php echo $_POST[entidad]?>" style="width:100%;"  readonly></td>
                <td colspan="4"> 
                	<input type="button" name="genera" value=" Generar " onClick="generar()">
                    <input type="hidden" name="vchip" value="<?php echo $_POST[vchip]?>"  readonly>  
                    <input type="hidden" name="gbalance" value="<?php echo $_POST[gbalance]?>"  readonly>    
        			<input type="button" name="guardabal" value="Clasificar Cuentas" onClick="guardarbalance()"> 
                    <input name="finalizar" type="button" value="Generar Archivo CSV" onClick="guardarchip()" >       
      			</td>
       		</tr>  
    	</table>   
		<div class="subpantallap" style="height:62.2%; width:99.6%; overflow-x:hidden;"> 	
   			<?php
				//echo "$_POST[genbal]";
  				//**** para sacar la consulta del balance se necesitan estos datos ********
  				//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
				$niveles=array();
				if($_POST[genbal]==1 && $_POST[gbalance]==0 )
				{	
					if($_POST[manual]==1)
					{
						//**** para sacar la consulta del balance se necesitan estos datos ********
						//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
						$oculto=$_POST['oculto'];
						if($_POST[oculto])
						{
							$_POST[cuenta1]='1';
							$_POST[cuenta2]='9999999999999';
							$horaini=date('h:i:s');		
							
							$sqlr="Select * from nivelesctas  where estado='S' order by id_nivel";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)){$niveles[]=$row[4];}
							/*
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
							$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));*/
							$mes1=substr($_POST[periodo],1,2);
							$mes2=substr($_POST[periodo],3,2);
							$_POST[fecha]='01'.'/'.$mes1.'/'.$_POST[vigencias];
							$_POST[fecha2]=intval(date("t",$mes2)).'/'.$mes2.'/'.$_POST[vigencias];	
							//echo "Fechas:".$_POST[fecha].'  '.$_POST[fecha2];	
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
							$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							//echo "Fechas2:".$fechaf1.'  '.$fechaf2;	
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
							$f1=$fechafa2;	
							$f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);	
							$fechafa=$_POST[vigencias]."-01-01";
							$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
							//Borrar el balance de prueba anterior
							$sqlr2="select distinct digitos, posiciones from nivelesctas where estado='S' ORDER BY id_nivel DESC ";
							$resn=mysql_query($sqlr2,$linkbd);
							$rown=mysql_fetch_row($resn);
							$nivmax=$rown[0];
							$dignivmax=$rown[1];
							//continuar**** creacion balance de prueba
							//$namearch="archivos/".$_SESSION[usuario]."balanceprueba.csv";
							//$Descriptor1 = fopen($namearch,"w+"); 
							//fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");
							echo "<table class='inicio' >
									<tr>
										<td colspan='6' class='titulos'>Balance de Prueba</td>
									</tr>";
							echo "<tr>
										<td class='titulos2'>Codigo</td>
										<td class='titulos2'>Cuenta</td>
										<td class='titulos2'>Codio Entidad</td>
										<td class='titulos2'>Saldo Final</td>
								</tr>";
							$tam=$niveles[$_POST[nivel]-1];
							$crit1=" and left(cuenta,$tam)>='$_POST[cuenta1]' and left(cuenta,$tam)<='$_POST[cuenta2]' ";
							$sqlr2="select distinct cuenta,tipo from cuentas where estado ='S' and length(cuenta)=$tam ".$crit1." group by cuenta,tipo order by cuenta ";
							$rescta=mysql_query($sqlr2,$linkbd);
							$i=0;
							//echo $sqlr2;
							$pctas=array();
							$pctasb[]=array();
							while ($row =mysql_fetch_row($rescta)) 
							{
								$pctas[]=$row[0];
								$pctasb["$row[0]"][0]=$row[0];
								$pctasb["$row[0]"][1]=0;
								$pctasb["$row[0]"][2]=0;
								$pctasb["$row[0]"][3]=0;
								$pctasb["$row[0]"][4]=0;
							}
							mysql_free_result($rescta);
							$tam=$niveles[$_POST[nivel]-1];
							//echo "tc:".count($pctas);
							//******MOVIMIENTOS PERIODO
							$sqlr3="SELECT DISTINCT
							SUBSTR(comprobante_det.cuenta,1,$tam),
							sum(comprobante_det.valdebito),
							sum(comprobante_det.valcredito),
							entidadreciprocatercero.id_entidad
							FROM comprobante_det, comprobante_cab, entidadreciprocatercero
							WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
							AND comprobante_det.numerotipo = comprobante_cab.numerotipo
							AND comprobante_cab.estado = 1
							AND entidadreciprocatercero.tercero = comprobante_det.tercero
							AND (comprobante_det.valdebito > 0
							OR comprobante_det.valcredito > 0)
							AND comprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2'
							AND comprobante_det.tipo_comp <> 7 AND comprobante_det.tipo_comp <> 100 AND comprobante_det.tipo_comp <> 102 AND comprobante_det.tipo_comp <> 101 AND comprobante_det.tipo_comp <> 103 ".$critcons." ".$critconscierre."
							AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'
							AND comprobante_det.centrocosto like '%$_POST[cc]%'
							GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
							ORDER BY comprobante_det.cuenta";
							//echo $sqlr3;
							$res=mysql_query($sqlr3,$linkbd);
							while ($row =mysql_fetch_row($res))
							{
								$pctasb["$row[0]"][0]=$row[0];
								$pctasb["$row[0]"][2]=$row[1];
								$pctasb["$row[0]"][3]=$row[2];
								$pctasb["$row[0]"][4]=$row[3];
							}
							
							//**** SALDO INICIAL ***
							$sqlr3="SELECT DISTINCT
							SUBSTR(comprobante_det.cuenta,1,$tam),
							sum(comprobante_det.valdebito)-
							sum(comprobante_det.valcredito),
							entidadreciprocatercero.id_entidad
							FROM comprobante_det, comprobante_cab, entidadreciprocatercero
							WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
							AND comprobante_det.numerotipo = comprobante_cab.numerotipo
							AND comprobante_cab.estado = 1
							AND entidadreciprocatercero.tercero = comprobante_det.tercero
							AND (comprobante_det.valdebito > 0
							OR comprobante_det.valcredito > 0)         
							AND comprobante_det.tipo_comp = 102 
							AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'   
							AND comprobante_det.centrocosto like '%$_POST[cc]%' ".$critcons."
							GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
							ORDER BY comprobante_det.cuenta";
							$res=mysql_query($sqlr3,$linkbd);
							//echo $sqlr3;
							while ($row =mysql_fetch_row($res)) 
							{
								$pctasb["$row[0]"][0]=$row[0];
								$pctasb["$row[0]"][1]=$row[1];
								$pctasb["$row[0]"][4]=$row[2];
							}
	
							//*******MOVIMIENTOS PREVIOS PERIODO
							if($fechafa2>='2018-01-01')
							{
								$fecini='2018-01-01';
								$sqlr3="SELECT DISTINCT
								SUBSTR(comprobante_det.cuenta,1,$tam),
								sum(comprobante_det.valdebito)-
								sum(comprobante_det.valcredito),
								entidadreciprocatercero.id_entidad
								FROM comprobante_det, comprobante_cab, entidadreciprocatercero
								WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
								AND comprobante_det.numerotipo = comprobante_cab.numerotipo
								AND comprobante_cab.estado = 1
								AND entidadreciprocatercero.tercero = comprobante_det.tercero
								AND (comprobante_det.valdebito > 0
								OR comprobante_det.valcredito > 0)
								AND comprobante_det.tipo_comp <> 100
								AND comprobante_det.tipo_comp <> 101
								AND comprobante_det.tipo_comp <> 103
								AND comprobante_det.tipo_comp <> 104
								AND comprobante_det.tipo_comp <> 102
								AND comprobante_det.tipo_comp <> 7  ".$critcons."  
								AND comprobante_cab.fecha BETWEEN '$fecini' AND '$fechafa2'
								AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'		 
								AND comprobante_det.centrocosto like '%$_POST[cc]%'
								GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
								ORDER BY comprobante_det.cuenta";
								//echo $sqlr3;
								$res=mysql_query($sqlr3,$linkbd);
								//  sort($pctasb[]);
								while ($row = mysql_fetch_row($res)) 
								{
									$pctasb["$row[0]"][0]=$row[0];
									$pctasb["$row[0]"][1]+=$row[1]; 
									$pctasb["$row[0]"][4]=$row[2];
								} 
							} 
	
							//MOVIMIENTOS DEL COMPROBANTE 100 Y 101
					
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
							$sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),saldoinicial double,debito double,credito double,saldofinal double,entidaReciproca varchar(100))";
							mysql_query($sqlr,$linkbd);
							$i=1;
							foreach($pctasb as $k => $valores )
							{
								if(($pctasb[$k][1]<0 || $pctasb[$k][1]>0) || ($pctasb[$k][2]<0 || $pctasb[$k][2]>0) || ($pctasb[$k][3]<0 || $pctasb[$k][3]>0))
								{
									$saldofinal=$pctasb[$k][1]+$pctasb[$k][2]-$pctasb[$k][3];
									$nomc=existecuentanicsp($pctasb[$k][0]);	 
									
									$sqlr="insert into usr_session (id,cuenta,nombrecuenta,saldoinicial,debito,credito,saldofinal,entidaReciproca) values($i,'".$pctasb[$k][0]."','".$nomc."','".$pctasb[$k][1]."','".$pctasb[$k][2]."','".$pctasb[$k][3]."','".$saldofinal."','".$pctasb[$k][4]."')";
									mysql_query($sqlr,$linkbd);
									//echo "<br>".$sqlr;
									$i+=1;
								}
								//echo "<br>cuenta:".$k."  ".$pctasb[$k][1]."  ".$pctasb[$k][2]."  ".$pctasb[$k][3];	
							}
							$sqlr="select *from usr_session order by cuenta";
							$res=mysql_query($sqlr,$linkbd);
							$_POST[tsaldoant]=0;
							$_POST[tdebito]=0;
							$_POST[tcredito]=0;
							$_POST[tsaldofinal]=0;
							$cuentachipno=array();
							$namearch="archivos/CGN2015_002_OPERACIONES_RECIPROCAS_CONVERGENCIA.csv";
							$Descriptor1 = fopen($namearch,"w+"); 

							fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");
							$co='saludo1a';
							$co2='saludo2';
							while($row=mysql_fetch_row($res))
							{
								if(strlen($row[1])==6)
								{
									$sqlrchip="select count(*) from chipcuentas where cuenta=$row[1]";
									$reschip=mysql_query($sqlrchip,$linkbd);
									$rowchip=mysql_fetch_row($reschip);
									if($rowchip[0]==0)
									{
										$cuentachipno[]=$row[1];
										// $ncuentachipno[]=buscacuenta($row[1]);		 
									}
								}
								$negrilla="style='font-weight:bold'";
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
									$_POST[tsaldoant]+=$row[3];
									$_POST[tdebito]+=$row[4];
									$_POST[tcredito]+=$row[5];			  
									$_POST[tsaldofinal]+=$row[6];			  	
								}
								echo "<tr class='$co' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
								onMouseOut=\"this.style.backgroundColor=anterior\" >
								<td $negrilla>$row[1]</td>
								<td $negrilla>$row[2]</td>
								<td $negrilla>$row[7]</td>
								<td $negrilla align='right'>".number_format($row[6],2,".",",")."";
								echo "<input type='hidden' name='dcuentas[]' value= '".$row[1]."'> 
								<input type='hidden' name='dncuentas[]' value= '".$row[2]."'>
								<input type='hidden' name='dsaldoant[]' value= '".round($row[3],2)."'> 
								<input type='hidden' name='ddebitos[]' value= '".round($row[4],2)."'> 
								<input type='hidden' name='dcreditos[]' value= '".round($row[5],2)."'>
								<input type='hidden' name='dsaldo[]' value= '".round($row[6],2)."'>
								<input type='hidden' name='dEntidad[]' value= '".$row[7]."'>
								</td>
								</tr>" ;	 
								fputs($Descriptor1,$row[1].";".$row[2].";".number_format($row[3],3,",","").";".number_format($row[4],3,",","").";".number_format($row[5],3,",","").";".number_format($row[6],3,",","")."\r\n");
								$aux=$co;
								$co=$co2;
								$co2=$aux;
								$i=1+$i;
							}
							fclose($Descriptor1);
							echo "<tr class='$co'>
							<td colspan='3'>
							</td>
							<td class='$co' align='right'>".number_format($_POST[tsaldofinal],2,".",",")."
								<input type='hidden' name='tsaldofinal' value= '$_POST[tsaldofinal]'>
							</td>
							</tr>";  
							$horafin=date('h:i:s');	
							echo "<DIV class='ejemplo'>INICIO:$horaini FINALIZO: $horafin</DIV>";
						}
						?> 
						<?php
						if ($_POST[vchip]==1)
						{
							?>
							<div class="inicio"> 
							<div class="titulos">ERROR CUENTAS INEXISTENTES VALIDACION CHIP: <input type="text" name="erroresent" size="5" value="<?php echo count($cuentachipno) ?>" readonly></div>
							<?php
						}
						?>
					</div>
					<?php

					}
					else
					{
						//**** para sacar la consulta del balance se necesitan estos datos ********
						//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
						$oculto=$_POST['oculto'];
						if($_POST[oculto])
						{
							$_POST[cuenta1]='1';
							$_POST[cuenta2]='9999999999999';
							$horaini=date('h:i:s');		
							
							$sqlr="Select * from nivelesctas  where estado='S' order by id_nivel";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)){$niveles[]=$row[4];}
							/*
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
							$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));*/
							$mes1=substr($_POST[periodo],1,2);
							$mes2=substr($_POST[periodo],3,2);
							$_POST[fecha]='01'.'/'.$mes1.'/'.$_POST[vigencias];
							$_POST[fecha2]=intval(date("t",$mes2)).'/'.$mes2.'/'.$_POST[vigencias];	
							//echo "Fechas:".$_POST[fecha].'  '.$_POST[fecha2];	
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
							$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							//echo "Fechas2:".$fechaf1.'  '.$fechaf2;	
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
							$f1=$fechafa2;	
							$f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);	
							$fechafa=$_POST[vigencias]."-01-01";
							$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
							//Borrar el balance de prueba anterior
							$sqlr2="select distinct digitos, posiciones from nivelesctas where estado='S' ORDER BY id_nivel DESC ";
							$resn=mysql_query($sqlr2,$linkbd);
							$rown=mysql_fetch_row($resn);
							$nivmax=$rown[0];
							$dignivmax=$rown[1];
							//continuar**** creacion balance de prueba
							//$namearch="archivos/".$_SESSION[usuario]."balanceprueba.csv";
							//$Descriptor1 = fopen($namearch,"w+"); 
							//fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");
							echo "<table class='inicio' >
									<tr>
										<td colspan='6' class='titulos'>Balance de Prueba</td>
									</tr>";
							echo "<tr>
										<td class='titulos2'>Codigo</td>
										<td class='titulos2'>Cuenta</td>
										<td class='titulos2'>Codio Entidad</td>
										<td class='titulos2'>Saldo Final</td>
								</tr>";
							$tam=$niveles[$_POST[nivel]-1];
							$crit1=" and left(cuenta,$tam)>='$_POST[cuenta1]' and left(cuenta,$tam)<='$_POST[cuenta2]' ";
							$sqlr2="select distinct cuenta from cuentasreciprocas where estado ='S' and length(cuenta)=$tam ".$crit1." group by cuenta order by cuenta ";
							$rescta=mysql_query($sqlr2,$linkbd);
							$i=0;
							//echo $sqlr2;
							$pctas=array();
							$pctasb[]=array();
							while ($row =mysql_fetch_row($rescta)) 
							{
								$pctas[]=$row[0];
								$pctasb["$row[0]"][0]=$row[0];
								$pctasb["$row[0]"][1]=0;
								$pctasb["$row[0]"][2]=0;
								$pctasb["$row[0]"][3]=0;
								$pctasb["$row[0]"][4]=0;
							}
							mysql_free_result($rescta);
							$tam=$niveles[$_POST[nivel]-1];
							//echo "tc:".count($pctas);
							//******MOVIMIENTOS PERIODO
							$sqlr3="SELECT DISTINCT
							SUBSTR(comprobante_det.cuenta,1,$tam),
							sum(comprobante_det.valdebito),
							sum(comprobante_det.valcredito),
							entidadreciprocatercero.id_entidad
							FROM comprobante_det, comprobante_cab, entidadreciprocatercero,cuentasreciprocas
							WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
							AND comprobante_det.numerotipo = comprobante_cab.numerotipo
							AND cuentasreciprocas.cuenta = comprobante_det.cuenta
							AND comprobante_cab.estado = 1
							AND entidadreciprocatercero.tercero = comprobante_det.tercero
							AND (comprobante_det.valdebito > 0
							OR comprobante_det.valcredito > 0)
							AND comprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2'
							AND comprobante_det.tipo_comp <> 7 AND comprobante_det.tipo_comp <> 100 AND comprobante_det.tipo_comp <> 102 AND comprobante_det.tipo_comp <> 101 AND comprobante_det.tipo_comp <> 103 ".$critcons." ".$critconscierre."
							AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'
							AND comprobante_det.centrocosto like '%$_POST[cc]%'
							GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
							ORDER BY comprobante_det.cuenta";
							//echo $sqlr3;
							$res=mysql_query($sqlr3,$linkbd);
							while ($row =mysql_fetch_row($res))
							{
								$pctasb["$row[0]"][0]=$row[0];
								$pctasb["$row[0]"][2]=$row[1];
								$pctasb["$row[0]"][3]=$row[2];
								$pctasb["$row[0]"][4]=$row[3];
							}
							
							//**** SALDO INICIAL ***
							$sqlr3="SELECT DISTINCT
							SUBSTR(comprobante_det.cuenta,1,$tam),
							sum(comprobante_det.valdebito)-
							sum(comprobante_det.valcredito),
							entidadreciprocatercero.id_entidad
							FROM comprobante_det, comprobante_cab, entidadreciprocatercero,cuentasreciprocas
							WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
							AND comprobante_det.numerotipo = comprobante_cab.numerotipo
							AND cuentasreciprocas.cuenta = comprobante_det.cuenta
							AND comprobante_cab.estado = 1
							AND entidadreciprocatercero.tercero = comprobante_det.tercero
							AND (comprobante_det.valdebito > 0
							OR comprobante_det.valcredito > 0)         
							AND comprobante_det.tipo_comp = 102 
							AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'   
							AND comprobante_det.centrocosto like '%$_POST[cc]%' ".$critcons."
							GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
							ORDER BY comprobante_det.cuenta";
							$res=mysql_query($sqlr3,$linkbd);
							//echo $sqlr3;
							while ($row =mysql_fetch_row($res)) 
							{
								$pctasb["$row[0]"][0]=$row[0];
								$pctasb["$row[0]"][1]=$row[1];
								$pctasb["$row[0]"][4]=$row[2];
							}
	
							//*******MOVIMIENTOS PREVIOS PERIODO
							if($fechafa2>='2018-01-01')
							{
								$fecini='2018-01-01';
								$sqlr3="SELECT DISTINCT
								SUBSTR(comprobante_det.cuenta,1,$tam),
								sum(comprobante_det.valdebito)-
								sum(comprobante_det.valcredito),
								entidadreciprocatercero.id_entidad
								FROM comprobante_det, comprobante_cab, entidadreciprocatercero,cuentasreciprocas
								WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
								AND comprobante_det.numerotipo = comprobante_cab.numerotipo
								AND cuentasreciprocas.cuenta = comprobante_det.cuenta
								AND comprobante_cab.estado = 1
								AND entidadreciprocatercero.tercero = comprobante_det.tercero
								AND (comprobante_det.valdebito > 0
								OR comprobante_det.valcredito > 0)
								AND comprobante_det.tipo_comp <> 100
								AND comprobante_det.tipo_comp <> 101
								AND comprobante_det.tipo_comp <> 103
								AND comprobante_det.tipo_comp <> 104
								AND comprobante_det.tipo_comp <> 102
								AND comprobante_det.tipo_comp <> 7  ".$critcons."  
								AND comprobante_cab.fecha BETWEEN '$fecini' AND '$fechafa2'
								AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'		 
								AND comprobante_det.centrocosto like '%$_POST[cc]%'
								GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
								ORDER BY comprobante_det.cuenta";
								//echo $sqlr3;
								$res=mysql_query($sqlr3,$linkbd);
								//  sort($pctasb[]);
								while ($row = mysql_fetch_row($res)) 
								{
									$pctasb["$row[0]"][0]=$row[0];
									$pctasb["$row[0]"][1]+=$row[1]; 
									$pctasb["$row[0]"][4]=$row[2];
								} 
							} 
	
							//MOVIMIENTOS DEL COMPROBANTE 100 Y 101
					
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
							$sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),saldoinicial double,debito double,credito double,saldofinal double,entidaReciproca varchar(100))";
							mysql_query($sqlr,$linkbd);
							$i=1;
							foreach($pctasb as $k => $valores )
							{
								if(($pctasb[$k][1]<0 || $pctasb[$k][1]>0) || ($pctasb[$k][2]<0 || $pctasb[$k][2]>0) || ($pctasb[$k][3]<0 || $pctasb[$k][3]>0))
								{
									$saldofinal=$pctasb[$k][1]+$pctasb[$k][2]-$pctasb[$k][3];
									$nomc=existecuentanicsp($pctasb[$k][0]);	 
									
									$sqlr="insert into usr_session (id,cuenta,nombrecuenta,saldoinicial,debito,credito,saldofinal,entidaReciproca) values($i,'".$pctasb[$k][0]."','".$nomc."','".$pctasb[$k][1]."','".$pctasb[$k][2]."','".$pctasb[$k][3]."','".$saldofinal."','".$pctasb[$k][4]."')";
									mysql_query($sqlr,$linkbd);
									//echo "<br>".$sqlr;
									$i+=1;
								}
								//echo "<br>cuenta:".$k."  ".$pctasb[$k][1]."  ".$pctasb[$k][2]."  ".$pctasb[$k][3];	
							}
							$sqlr="select *from usr_session order by cuenta";
							$res=mysql_query($sqlr,$linkbd);
							$_POST[tsaldoant]=0;
							$_POST[tdebito]=0;
							$_POST[tcredito]=0;
							$_POST[tsaldofinal]=0;
							$cuentachipno=array();
							$namearch="archivos/CGN2015_002_OPERACIONES_RECIPROCAS_CONVERGENCIA.csv";
							$Descriptor1 = fopen($namearch,"w+"); 

							fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");
							$co='saludo1a';
							$co2='saludo2';
							while($row=mysql_fetch_row($res))
							{
								if(strlen($row[1])==6)
								{
									$sqlrchip="select count(*) from chipcuentas where cuenta=$row[1]";
									$reschip=mysql_query($sqlrchip,$linkbd);
									$rowchip=mysql_fetch_row($reschip);
									if($rowchip[0]==0)
									{
										$cuentachipno[]=$row[1];
										// $ncuentachipno[]=buscacuenta($row[1]);		 
									}
								}
								$negrilla="style='font-weight:bold'";
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
									$_POST[tsaldoant]+=$row[3];
									$_POST[tdebito]+=$row[4];
									$_POST[tcredito]+=$row[5];			  
									$_POST[tsaldofinal]+=$row[6];			  	
								}
								echo "<tr class='$co' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
								onMouseOut=\"this.style.backgroundColor=anterior\" >
								<td $negrilla>$row[1]</td>
								<td $negrilla>$row[2]</td>
								<td $negrilla>$row[7]</td>
								<td $negrilla align='right'>".number_format($row[6],2,".",",")."";
								echo "<input type='text' name='dcuentas[]' value= '".$row[1]."'> 
								<input type='hidden' name='dncuentas[]' value= '".$row[2]."'>
								<input type='hidden' name='dsaldoant[]' value= '".round($row[3],2)."'> 
								<input type='hidden' name='ddebitos[]' value= '".round($row[4],2)."'> 
								<input type='hidden' name='dcreditos[]' value= '".round($row[5],2)."'>
								<input type='hidden' name='dsaldo[]' value= '".round($row[6],2)."'>
								<input type='hidden' name='dEntidad[]' value= '".$row[7]."'>
								</td>
								</tr>" ;	 
								fputs($Descriptor1,$row[1].";".$row[2].";".number_format($row[3],3,",","").";".number_format($row[4],3,",","").";".number_format($row[5],3,",","").";".number_format($row[6],3,",","")."\r\n");
								$aux=$co;
								$co=$co2;
								$co2=$aux;
								$i=1+$i;
							}
							fclose($Descriptor1);
							echo "<tr class='$co'>
							<td colspan='3'>
							</td>
							<td class='$co' align='right'>".number_format($_POST[tsaldofinal],2,".",",")."
								<input type='hidden' name='tsaldofinal' value= '$_POST[tsaldofinal]'>
							</td>
							</tr>";  
							$horafin=date('h:i:s');	
							echo "<DIV class='ejemplo'>INICIO:$horaini FINALIZO: $horafin</DIV>";
						}
						?> 
						<?php
						if ($_POST[vchip]==1)
						{
							?>
							<div class="inicio"> 
							<div class="titulos">ERROR CUENTAS INEXISTENTES VALIDACION CHIP: <input type="text" name="erroresent" size="5" value="<?php echo count($cuentachipno) ?>" readonly></div>
							<?php
						}
						?>
					</div>
					<?php
					}
 					
			 }
			 echo "hola".$_POST[dcuentas][0];
			if($_POST[gbalance]==1 && $_POST[gchip]!='1' )
			{
				$fechab=date('Y-m-d');
				$linkbd=conectar_bd();
				$sqlr="Delete from chipcarga_cab where vigencia=$_POST[vigencias] and periodo=$_POST[periodo]";
				mysql_query($sqlr,$linkbd);
				$sqlr="Delete from chipcarga_det where vigencia=$_POST[vigencias] and periodo=$_POST[periodo]";
				mysql_query($sqlr,$linkbd);	
				$sqlr="insert into chipcarga_cab (entidad, nombre_entidad, vigencia, fecha, periodo, estado) values ('$_POST[nitentidad]','$_POST[entidad]','$_POST[vigencias]','$fechab','$_POST[periodo]','S') ";
				mysql_query($sqlr,$linkbd);	
				//echo "Error".mysql_error($linkbd); 
				$cerror=0;
				$cexit=0;
				for($x=0;$x<count($_POST[dcuentas]);$x++)
				{
					$sqlr="insert into chipcarga_det (entidad, vigencia, periodo, cuenta, saldoinicial, debitos, creditos, saldofinal, saldofincte, saldofincteno,id_entidad) values ('$_POST[nitentidad]','$_POST[vigencias]','$_POST[periodo]',".$_POST[dcuentas][$x].",".$_POST[dsaldoant][$x].",".$_POST[ddebitos][$x].",".$_POST[dcreditos][$x].",".$_POST[dsaldo][$x].",'','','".$_POST[dEntidad][$x]."') ";
					if(mysql_query($sqlr,$linkbd))	
					{
						$cexit+=1;
					}
					else
					{
					$cerror+=1;
					echo "$sqlr<br>Error".mysql_error($linkbd); 
					}
				}		 
	   		} 
			//**FIN PASO 2
			//***** PASO 3 ****			 
			//**** FIN PASO 3 ****
			//***** PASO 3 ****		 
	  		if($_POST[gbalance]==1)
	 		{
				?>      	
				<div class="subpantalla" style="height:100%;"> 	
				<table class="inicio">
					<tr>
						<td class="titulos" colspan="8">CLASIFICAR CUENTAS</td>
					</tr>
					<tr>
						<td class="titulos2">CUENTA</td>
						<td class="titulos2">NOMBRE</td>
						<td class="titulos2">CODIGO ENTIDAD</td>
						<td class="titulos2">SALDO FINAL</td>
						<td class="titulos2">CTE
	 						<input id="todoscte" name="todoscte" type="checkbox" value="1" onClick="checktodos()">
	 					</td>
						<td class="titulos2">NOCTE 
							<input id="todoscten"  name="todoscten" type="checkbox" value="1" onClick="checktodosn()">
						</td>
					</tr>
      				<?php
					$totalsalini=0;
					$totaldeb=0;
					$totalcred=0;
					$totalsalfin=0;	  	  	  
					$linkbd=conectar_bd();
					$sqlrc="select distinct cuenta, sum(saldoinicial),sum(debitos), sum(creditos), sum(saldofinal), id_entidad from chipcarga_det where vigencia=$_POST[vigencias] and periodo=$_POST[periodo] group by cuenta";
					$resc=mysql_query($sqlrc,$linkbd);
					$co='saludo1a';
					$co2='saludo2';
					while($rowc=mysql_fetch_row($resc))
					{
						$ncta=existecuentanicsp($rowc[0]);
						$negrilla="style='font-weight:bold'";
						//echo $niveles[$_POST[nivel]-1]."hola"; die();
						if(6==strlen($rowc[0]))
						{
							$negrilla=" ";  
						}
						echo "<tr class='$co'>
									<td $negrilla>
										<input type='hidden' name='cuentac[]' value='$rowc[0]'>$rowc[0]
									</td>
									<td $negrilla>$ncta</td>
									<td $negrilla>
										<input type='hidden' name='entidadReciproca[]' value='$rowc[5]'>$rowc[5]
									</td>
									<td $negrilla>
										<input type='hidden' name='saldofinc[]' value='$rowc[4]'>$rowc[4]
									</td>";
						$chk='';
						$chk2='';
						if(strlen($rowc[0])==6)
						{
							$noCorrienteDosDigitos = [16,17,18,27];
							$noCorrienteUnDigito = [3,4,5,6,7,8,9];
							$estaEnArrayNocorrienteDosDigitos = esta_en_array($noCorrienteDosDigitos,substr($rowc[0],0,2));
							$estaEnArrayNocorrienteUnDigito = esta_en_array($noCorrienteUnDigito,substr($rowc[0],0,1));
							if($estaEnArrayNocorrienteDosDigitos == 1 || $estaEnArrayNocorrienteUnDigito == 1)
							{
								$chk2="checked";
							}
							else
							{
								$chk="checked";
							}
							/* $ch=esta_en_array($_POST[ctes], $rowc[0]);
								if($ch==1)
								{
								$chk="checked";
								}
							$ch2=esta_en_array($_POST[nctes], $rowc[0]);
								if($ch2==1)
								{
								$chk2="checked";
								}	  */
							
							$totalsalfin+=$rowc[4]; 
							echo "	<td >
										<center>
											<input type='checkbox' name='ctes[]' value='$rowc[0]' onClick='actdes($rowc[0],1)' $chk>
										</center>
									</td>
									<td>
										<center><input type='checkbox' name='nctes[]' value='$rowc[0]' onClick='actdes($rowc[0],2)' $chk2></center>
									</td>
									</tr>";  
	  					}
	  					else 
						{
							echo "<td ></td><td></td></tr>";
						}
						$aux=$co;
						$co=$co2;
						$co2=$aux;
	   				}
	  				?>
      				<tr class="saludo3">
						<td></td>
						<td></td>
						<td>TOTAL</td>
						<td><?php echo $totalsalfin ?>  
							<input type="hidden" name="gchip" value="<?php //echo $_POST[gchip] ?>">
						</td>
					</tr>
      			</table>
          	</div>      
    		<!-- <div class='inicio'>Guardar y Finalizar Consolidado <input name="finalizar" type="button" value="Finalizar" onClick="guardarchip()" ></div>      --> 
        
	<?php
	if($_POST[gchip]=='1')
	{
		$namearch2="archivos/CGN2015_002_OPERACIONES_RECIPROCAS_CONVERGENCIA.txt";
		$Descriptor2 = fopen($namearch2,"w+");
		fputs($Descriptor2,"S\t".$_POST[codent]."\t".$_POST[periodo]."\t".$_POST[vigencias]."\tCGN2015_002_OPERACIONES_RECIPROCAS_CONVERGENCIA\r\n");

		$namearch="archivos/".$_SESSION[usuario]."chip-$_POST[periodo].csv";
		$Descriptor1 = fopen($namearch,"w+"); 
		fputs($Descriptor1,"S;".$_POST[codent].";".$_POST[periodo].";".$_POST[vigencias].";CGN2015_002_OPERACIONES_RECIPROCAS_CONVERGENCIA\r\n");
		for($x=0;$x<count($_POST[cuentac]);$x++)
		{	 
			$signo=cuenta_colocar_signo($_POST[cuentac][$x]);
			if(strlen($_POST[cuentac][$x])==6)
			{
				$chk="";  
				$chk2="";
				$salfinal=0;
				$entidadReciproca=0;
				$noCorrienteDosDigitos = [16,17,18,27];
				$noCorrienteUnDigito = [3,4,5,6,7,8,9];
				$estaEnArrayNocorrienteDosDigitos = esta_en_array($noCorrienteDosDigitos,substr($_POST[cuentac][$x],0,2));
				$estaEnArrayNocorrienteUnDigito = esta_en_array($noCorrienteUnDigito,substr($_POST[cuentac][$x],0,1));
				
				$ch=esta_en_array($_POST[ctes], $_POST[cuentac][$x]);
				$entidadReciproca=$_POST[entidadReciproca][$x];

				$salfinal=$_POST[saldofinc][$x]; 
				if($_POST[reglas]=='1')
				{
					$cuentasCredito = [2,3,4,9];
					$evaluaCuentaCreditoArray = esta_en_array($cuentasCredito,substr($_POST[cuentac][$x],0,1));
					if($evaluaCuentaCreditoArray == 1)
					{
						$saldoinicial=$saldoinicial*(-1);
						$salfinal=$salfinal*(-1);
					}
					else
					{
						$saldoinicial=$saldoinicial;
						$salfinal=$salfinal;
					}
					/*
					if(substr($_POST[cuentac][$x],0,1)>1 && substr($_POST[cuentac][$x],0,1)<5)
					{
						$saldoinicial=$saldoinicial*(-1);
						$salfinal=$salfinal*(-1);
					}
				
					else
					{
						$saldoinicial=$saldoinicial;
						$salfinal=$salfinal;
					}*/
				}		
				if($estaEnArrayNocorrienteDosDigitos == 1 || $estaEnArrayNocorrienteUnDigito == 1)
				{				
					$ncuentas=substr($_POST[cuentac][$x],0,1).".".substr($_POST[cuentac][$x],1,1).".".substr($_POST[cuentac][$x],2,2).".".substr($_POST[cuentac][$x],4,2); 
					fputs($Descriptor1,"D;".$ncuentas.";".$entidadReciproca.";0;".round($salfinal,2)."\r\n");

					fputs($Descriptor2,"D\t".$ncuentas."\t".$entidadReciproca."\t0\t".round($salfinal,2)."\r\n");
					$chk="checked";
					//echo "<br>D;".$ncuentas.";".abs($saldoinicial).";".round($_POST[debitosc][$x]/1000,0).";".round($_POST[creditosc][$x]/1000,0).";".$salfinal.";".$salfinal.";0";
				}
				//$ch2=esta_en_array($_POST[nctes], $_POST[cuentac][$x]);
				//if($ch2==1)
				else
				{
					//$salfinal=($_POST[saldoinic][$x]+$_POST[debitosc][$x]-$_POST[creditosc][$x])/1000; 
					$ncuentas=substr($_POST[cuentac][$x],0,1).".".substr($_POST[cuentac][$x],1,1).".".substr($_POST[cuentac][$x],2,2).".".substr($_POST[cuentac][$x],4,2); 
					fputs($Descriptor1,"D;".$ncuentas.";".$entidadReciproca.";".round($salfinal,2).";0\r\n");

					fputs($Descriptor2,"D\t".$ncuentas."\t".$entidadReciproca."\t".round($salfinal,2)."\t0\r\n");
					$chk2="checked";
					//  echo "<br>D;".$ncuentas.";".abs($saldoinicial).";".($_POST[debitosc][$x]/1000).";".($_POST[creditosc][$x]/1000).";".$salfinal.";".$salfinal.";0";
				}	  			 
			}
			fclose($namearch);
		}
	}
}
  ?>

</form></td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>