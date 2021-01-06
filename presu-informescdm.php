<?php //V 1000 12/12/16 ?> 
<?php
	ini_set('max_execution_time',3600);
	require "comun.inc";
	require "funciones.inc";
	require "validaciones.inc";
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
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value=2;
					document.form2.submit();
 				}
 			}
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
				document.form2.action="pdfejecuciongastos.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="presu-ejecuciongastosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function agregardetalled()
			{
				if(document.form2.retencion.value!="" )
				{ 
					document.form2.agregadetdes.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else 
				{
					alert("Seleccione una retencion");
				}
			}
			function eliminard(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.eliminad.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('eliminad');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function validar(){document.form2.submit();}
			function crear(){document.form2.genbal.value=1;document.form2.gbalance.value=0;document.form2.submit();}
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
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
			<?php
                $informes=array();
                $informes[1]="F05-Registros_PresupuestalesCDM";
                $informes[2]="F06-IngresosCDM";
                $informes[3]="F07-FuentedeRecursosCDM";
                $informes[4]="F08-ContratoPrincipalCDM";
                $informes[5]="F17A-MesaRendirCDM(ESTAMPILLAS PROCULTURA)";
                $informes[6]="F17B-MesaRendirCDM(ESTAMPILLAS PROTURISMO)";
                $informes[7]="F17C-MesaRendirCDM(ESTAMPILLAS PRODESARROLLO)";
                $informes[8]="F17D-MesaRendirCDM(ESTAMPILLAS PROUNILLANOS)";
                $informes[9]="F18-EntidadCDM";
                $informes[10]="F20-1A-NITCDM";
                $informes[11]="F20-1B-NITCDM";
                $informes[12]="F20-1C-NITConsorcioCDM";
                $informes[13]="F20-2AGR-EntidadFiducianteCDM";
                $informes[14]="F25-VigenciasCDM";
                $informes[15]="SIA";
            ?>
  			<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
            <a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar"/></a>
            <a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
            <a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
            <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a>
            <a href="<?php echo "archivos/FORMATO_".$informes[$_POST[reporte]].".csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv"></a><a href="descargartxt.php?id=<?php echo $informes[$_POST[reporte]].".txt"; ?>&dire=archivos" target="_blank" class="mgbt"><img src="imagenes/contraloria.png"  title="contraloria"></a></td>
			</tr>
		</table>
 		<form name="form2" method="post" action="presu-informescdm.php">
 			<?php
 			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 			?>
    		<table  align="center" class="inicio" >
				<tr >
					<td class="titulos" colspan="6">.: Reportes CDM</td>
					<td width="74" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
				</tr>
      			<tr>
					<td class="saludo1">Reporte</td>
      				<td>
						<select name="reporte" id="reporte">
						<option value="-1">Seleccione ....</option>
							<option value="1" <?php if($_POST[reporte]=='1') echo "selected" ?>>F05 - Registros Presupuestales CDM</option>
							<option value="2" <?php if($_POST[reporte]=='2') echo "selected" ?>>F06 - Ingresos CDM</option>
							<option value="3" <?php if($_POST[reporte]=='3') echo "selected" ?>>F06B - Ingresos CDM</option>
							
							</select>
      				</td> 
					<td width="88" class="saludo1">Fecha Inicial:</td>
					<td width="193"><input type="hidden" value="<?php echo $vigusu ?>" name="vigencias"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
					<td width="79" class="saludo1">Fecha Final: </td>
					<td width="613"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto"></td>
				</tr>      
    		</table>
			<?php
			//**** busca cuenta
			if($_POST[bc]!='')
			{
				$nresul=buscacuentapres($_POST[cuenta],2);
				if($nresul!='')
				{
					$_POST[ncuenta]=$nresul;
					$linkbd=conectar_bd();
					$sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=".$vigusu;
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[valor]=$row[5];		  
					$_POST[valor2]=$row[5];		  			  
					?>
					<script>
						document.form2.fecha.focus();
						document.form2.fecha.select();
			  		</script>
			  		<?php
			  	}
			 	else
			 	{
			  		$_POST[ncuenta]="";
			  		?>
	  				<script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			  		<?php
			  	}
			}
			?>
			<div class="subpantallap" style="height:65.5%; width:99.6%; overflow-x:hidden;">
  				<?php
				//**** para sacar la consulta del balance se necesitan estos datos ********
				//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
				$oculto=$_POST['oculto'];
				if($_POST[oculto])
				{
					$linkbd=conectar_bd();
					$iter='zebra1';
					$iter2='zebra2';
  					switch($_POST[reporte])
   					{
						case 1: //F05 - Registros Presupuestales CDM
							$crit1=" ";
							$crit2=" ";
							$crit3=" ";
							$crit4=" ";
							$crit5=" ";
							$_POST[nominforme]="F05-Registros_PresupuestalesCDM";
							$namearch="archivos/FORMATO_F05-Registros_PresupuestalesCDM.csv";
							$_POST[nombrearchivo]=$namearch;
							$namearch2="archivos/".$informes[$_POST[reporte]].".txt";
							$Descriptor2 = fopen($namearch2,"w+"); 	
							$Descriptor1 = fopen($namearch,"w+"); 
							fputs($Descriptor1,"(N) RP;(C) Rubro;(F)Fecha;(D)Valor;(N)Numero De Cdp;(C)N� Contrato;(C)Objeto;(C) Contratista;(C) Nit Tercero\r\n");
							fputs($Descriptor2,"S\t".$_POST[codent]."\t".$_POST[periodo]."\t".$vigusu."\tREGISTROS_PRESUPUESTALES\r\n");
							if ($vigusu!="")
							$crit1=" and pptorp.vigencia ='$vigusu' ";
							if ($_POST[numero]!="")
							$crit2=" and pptorp.consvigencia like '%$_POST[numero]%' ";
							if ($_POST[fecha]!="" and $_POST[fecha2]!="" )
							{
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
								$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
								$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
								$crit3=" and pptorp.fecha between '$fechai' and '$fechaf'  ";
							}
							$sqlr="select *from pptorp inner join pptorp_detalle 
							where pptorp.estado<>'N' and pptorp.estado!='R' and pptorp_detalle.estado!='R' and  pptorp.estado!=''".$crit1.$crit2.$crit3." 
							and pptorp.consvigencia=pptorp_detalle.consvigencia and pptorp.vigencia=".$vigusu." and pptorp_detalle.vigencia=".$vigusu." order by pptorp.consvigencia";
							$resp = mysql_query($sqlr,$linkbd);
							$ntr = mysql_num_rows($resp);
							$con=1;
							echo "<table class='inicio' align='center' width='80%'>
							<tr><td colspan='10' class='titulos'>.: F05 - REGISTROS PRESUPUESTALES CDM:</td></tr>
							<tr><td colspan='5'>Registro Presupuestal Encontrados: $ntr</td></tr>
							<tr><td class='titulos2'>RP</td><td class='titulos2' >Rubro</td>
							<td class='titulos2' >Nombre Rubro</td><td class='titulos2' >Fecha</td>
							<td class='titulos2' >Valor</td><td class='titulos2'>CDP</td>
							<td class='titulos2' >Contrato</td><td class='titulos2'>Objeto</td>
							<td class='titulos2'>Nit Tercero</td><td class='titulos2'>Tercero</td></tr>";	
			
							while ($row =mysql_fetch_row($resp)) 
							{
								$sqlr2="select pptocdp.objeto from pptocdp where pptocdp.consvigencia=$row[2] and pptocdp.vigencia=$row[0]";
								//echo $sqlr2."<br>";
								$resp2 = mysql_query($sqlr2,$linkbd);
								$r2 =mysql_fetch_row($resp2);
								$nrub= buscacuentapres($row[16],2);
								//echo $nrub."hola";
								$tercero=buscatercero($row[5]);
								if($nrub!="")
								{
									ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $row[4],$fecha);
									$fechaf=$fecha[1]."/".$fecha[2]."/".$fecha[3]; 
									echo "<tr class='$iter'>
									<td>$row[1]</td>
									<td>$row[16]</td>
									<td>".str_replace(","," ",$nrub)."</td><td>".$fechaf."</td>
									<td>".number_format($row[18],0)."</td>
									<td>$row[2]</td>
									<td>".$row[8]."</td>
									<td>".str_replace(","," ",$r2[0])."</td>
									<td>$row[5]</td><td >".str_replace(","," ",$tercero)."</td></tr>";
									fputs($Descriptor1,$row[1].";".$row[16].";".$fechaf.";".number_format($row[18],2,".","").";".$row[2].";".$row[8].";".str_replace(","," ",$r2[0]).";".str_replace(","," ",$tercero).";".$row[5]."\r\n");
									fputs($Descriptor2,"D\t".$row[1]."\t".$row[16]."\t".$fechaf."\t".number_format($row[18],2,".","")."\t".$row[2]."\t1\t".$row[8]."\t".str_replace(","," ",$r2[0])."\t".str_replace(","," ",$tercero)."\t".$row[5]."\r\n");	
									$con+=1;
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								}
							}
							echo"</table>";
							fclose($Descriptor1);
						break;
	
						//------------------------------------------------------------------------------------------------
	
						case 2:	//F06 - Ingresos CDM
						case 3:
							$crit3=" ";
							$crit4=" ";	
							$namearch="archivos/FORMATO_F06-IngresosCDM.csv";
							$_POST[nombrearchivo]=$namearch;
							$Descriptor1 = fopen($namearch,"w+");
	
							if ($_POST[fecha]!="" and $_POST[fecha2]!="" )
							{
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
								$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
								$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
							}
							
							$sq = "SELECT nit, razonsocial FROM configbasica ";
							$rsq=mysql_query($sq,$linkbd);
							$rw =mysql_fetch_row($rsq);
							$nit = $rw[0];
							$razonSocial = $rw[1];

	 						$sumareca=0;
							$sumarp=0;	
							$sumaop=0;	
							$sumap=0;			
							$sumai=0;
							$sumapi=0;				
							$sumapad=0;	
							$sumapred=0;	
							$sumapcr=0;	
							$sumapccr=0;						
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
							$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
							$vigenciaTr = $fecha[3];
							$iter="zebra1";
							$iter2="zebra2";
							echo "<table class='inicio' ><tr><td colspan='9' class='titulos'>Ejecucion Cuentas $_POST[fecha] - $_POST[fecha2]</td></tr>";
							if($_POST[reporte]==2)
							{
								echo "<tr><td class='titulos2'>Cuenta</td><td class='titulos2'>Nombre</td><td class='titulos2'>Fuente</td><td class='titulos2'>PRES INI</td><td class='titulos2'>ADICIONES</td><td class='titulos2'>REDUCCIONES</td><td class='titulos2'>PRES DEF</td><td class='titulos2'>INGRESOS</td><td class='titulos2'>%</td></tr>";
							}
							else
							{
								echo "<tr><td class='titulos2'>Entidad</td><td class='titulos2'>Nit</td><td class='titulos2'>Presupuesto Definitivo</td><td class='titulos2'>Total Recaudado</td> <td class='titulos2'>Total Compromisos</td></tr>";
							}
							$linkbd=conectar_bd();
							if($_POST[vereg]==2)
								$cond=" AND pptocuentas.regalias='S'";
							else
								$cond="";
							$sqlr2="Select distinct pptocuentas.cuenta, pptocuentas.tipo, pptocuentas.vigencia, pptocuentas.vigenciaf from pptocuentas where (pptocuentas.vigencia='".$vigenciaTr."' or  pptocuentas.vigenciaf='".$vigenciaTr."') AND (pptocuentas.clasificacion='ingresos' or pptocuentas.clasificacion='reservas-ingresos') $cond ORDER BY pptocuentas.cuenta ASC ";
							$cuentaPadre=Array();
							$rescta=mysql_query($sqlr2,$linkbd);
							while ($row =mysql_fetch_row($rescta)) 
							{
								$pdef=0;
								$vitot=0;
								$todos=0;	 	 
								$nt=existecuentain($row[0]);	
								$negrilla="style='font-weight:bold'";	  
								$tcta="0"; 
								if($row[1]=='Auxiliar' || $row[1]=='auxiliar')
								{
									$arregloCuenta=generaReporteIngresos($row[0],$row[2],$fechaf,$fechaf2);
									$cuentas[$row[0]]["numCuenta"]=$row[0];
									$cuentas[$row[0]]["nomCuenta"]=$nt;
									$cuentas[$row[0]]["presuInicial"]=$arregloCuenta[0];
									$cuentas[$row[0]]["adicion"]=$arregloCuenta[1];
									$cuentas[$row[0]]["reduccion"]=$arregloCuenta[2];
									$cuentas[$row[0]]["presuDefinitivo"]=$arregloCuenta[3];
									$cuentas[$row[0]]["ingreso_tot"]=$arregloCuenta[6];
									$cuentas[$row[0]]["porcentaje"]=round(($arregloCuenta[6]/$arregloCuenta[3])*100,2);
									$cuentas[$row[0]]["tipo"]="Auxiliar";
								}
								else
								{
									$cuentas[$row[0]]["numCuenta"]=$row[0];
									$cuentas[$row[0]]["nomCuenta"]=$nt;
									$cuentas[$row[0]]["presuInicial"]=0;
									$cuentas[$row[0]]["adicion"]=0;
									$cuentas[$row[0]]["reduccion"]=0;
									$cuentas[$row[0]]["presuDefinitivo"]=0;
									$cuentas[$row[0]]["ingreso_tot"]=0;
									$cuentas[$row[0]]["porcentaje"]=0;
									$cuentas[$row[0]]["tipo"]="Mayor";
									$cuentaPadre[]=$row[0];
								}
							}
			
							function buscaCuentasHijo($cuenta)
							{
								global $cuentas,$linkbd,$vigenciaTr,$f1,$f2,$cuentaPadre;
								$arreglo=Array('0','1','2','3','4','5','6','7','8','9');
								$numcuenta=strlen($cuenta);
								$cuentaPunto = strpos($cuenta,'.');
								$cuentaGuion = strpos($cuenta,'-');
					
								if($cuenta=="01-TI.A.1.2.1"){$cuenta=$cuenta."-";}
								if(($numcuenta==1 || $numcuenta==2) && !is_numeric($cuenta)){
									$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '%$cuenta%' AND estado='S' AND clasificacion  LIKE '%ingresos%' AND vigencia=$vigenciaTr AND (tipo='Auxiliar' OR tipo='auxiliar')";
								}else{
									if($cuentaPunto==1 && $cuentaGuion==false)
									{
										$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '$cuenta.%' AND estado='S' AND clasificacion  LIKE '%ingresos%' AND vigencia=$vigenciaTr AND (tipo='Auxiliar' OR tipo='auxiliar')";
									}
									else
									{
										$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '$cuenta%' AND estado='S' AND clasificacion  LIKE '%ingresos%' AND vigencia=$vigenciaTr AND (tipo='Auxiliar' OR tipo='auxiliar')";
									}
								}
								$result=mysql_query($sql,$linkbd);
								$acumpptoini=0.0;
								$acumadic=0.0;
								$acumredu=0.0;
								$acumpptodef=0.0;
								$acumingreso_tot=0.0;
								$acumporcentaje=0.0;
								while($row = mysql_fetch_array($result)){
									$acumpptoini+=$cuentas[$row[0]]["presuInicial"];
									$acumadic+=$cuentas[$row[0]]["adicion"];
									$acumredu+=$cuentas[$row[0]]["reduccion"];
									$acumpptodef+=$cuentas[$row[0]]["presuDefinitivo"];
									$acumingreso_tot+=$cuentas[$row[0]]["ingreso_tot"];
									$acumporcentaje+=$cuentas[$row[0]]["porcentaje"];
								}
								$cuentas[$cuenta]["presuInicial"]=$acumpptoini;
								$cuentas[$cuenta]["adicion"]=$acumadic;
								$cuentas[$cuenta]["reduccion"]=$acumredu;
								$cuentas[$cuenta]["presuDefinitivo"]=$acumpptodef;
								$cuentas[$cuenta]["ingreso_tot"]=$acumingreso_tot;
								$cuentas[$cuenta]["porcentaje"]=$acumporcentaje;
							}
							$contCuentaPadre = sizeof($cuentaPadre);
							for ($i=0; $i < $contCuentaPadre; $i++) 
							{
								buscaCuentasHijo($cuentaPadre[$i]);
							}
			
							$totPresuInicial=0;
							$totAdiciones=0;
							$totReducciones=0;
							$totPresuDefinitivo=0;
							$totIngresos_tot=0;
							$totSaldo=0;
							$totPorcentaje=0;
							foreach ($cuentas as $key => $value) 
							{
								$numeroCuenta=$cuentas[$key]['numCuenta'];
								$nombreCuenta=$cuentas[$key]['nomCuenta'];
								$presupuestoInicial=$cuentas[$key]['presuInicial'];
								$adicion=$cuentas[$key]['adicion'];
								$reduccion=$cuentas[$key]['reduccion'];
								$presupuestoDefinitivo=$cuentas[$key]['presuDefinitivo'];
								$ingresos_tot=$cuentas[$key]['ingreso_tot'];
								$porcentaje=$cuentas[$key]['porcentaje'];
								$tipo=$cuentas[$key]['tipo'];
								$saldo=0;
								$style='';
								if($saldo<0){
									$style='background: yellow';
								}
								//fputs($Descriptor2,"D\t".$numeroCuenta."\t".$_POST[periodo]."\t".$vigusu."\tPROGRAMACIONDEINGRESOS\r\n");
								$nombreCuentaff=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$nombreCuenta);
								if(!empty($numeroCuenta))//----bloque nuevo 17/01/2016
								{
									if($tipo=='Auxiliar' || $tipo=='auxiliar')
									{
										$totPresuInicial+=$cuentas[$key]['presuInicial'];
										$totAdiciones+=$cuentas[$key]['adicion'];
										$totReducciones+=$cuentas[$key]['reduccion'];
										$totPresuDefinitivo+=$cuentas[$key]['presuDefinitivo'];
										$totIngresos_tot+=$cuentas[$key]['ingreso_tot'];
										$totPorcentaje+=$cuentas[$key]['porcentaje'];
										if($_POST[reporte]=='2')
										{
											echo "<tr style='font-size:9px; text-rendering: optimizeLegibility;$style' class='$iter' ondblclick='direccionaCuentaGastos(this)'>";
											echo "
											<td id='1' style='width: 5%'>$numeroCuenta</td>
											<td id='2' style='width: 15%'>$nombreCuentaff</td>
											<td id='2' style='width: 15%'></td>
											<td id='3' style='width: 5.5%'>".number_format($presupuestoInicial,2,",",".")."</td>
											<td id='4' style='width: 4.5%'>".number_format($adicion,2,",",".")."</td>
											<td id='5' style='width: 4.5%'>".number_format($reduccion,2,",",".")."</td>
											<td id='6' style='width: 5%'>".number_format($presupuestoDefinitivo,2,",",".")."</td>
											<td id='10' style='width: 4.5%'>".number_format($ingresos_tot,2,",",".")."</td>
											<td id='12' style='width: 4.5%'>".$porcentaje."%</td>";
											echo "</tr>";
										}
										$vporcentaje = $porcentaje;
										$sumapi = $sumapi + $presupuestoInicial;
										$sumapad = $sumapad + $adicion;
										$sumapred = $sumapred + $reduccion;
										$sumai = $sumai + $presupuestoDefinitivo;
										$sumareca = $sumareca + $ingresos_tot;
									}
									else
									{
										if($_POST[reporte]=='2')
										{
											echo "<tr style='font-weight:bold; font-size:9px; text-rendering: optimizeLegibility' class='$iter'>";
											
											echo "
											<td id='1' style='width: 5%'>$numeroCuenta</td>
											<td id='2' style='width: 15%'>$nombreCuentaff</td>
											<td id='2' style='width: 15%'></td>
											<td id='3' style='width: 5.5%'>".number_format($presupuestoInicial,2,",",".")."</td>
											<td id='4' style='width: 4.5%'>".number_format($adicion,2,",",".")."</td>
											<td id='5' style='width: 4.5%'>".number_format($reduccion,2,",",".")."</td>
											<td id='6' style='width: 5%'>".number_format($presupuestoDefinitivo,2,",",".")."</td>
											<td id='10' style='width: 4.5%'>".number_format($ingresos_tot,2,",",".")."</td>
											<td id='12' style='width: 4.5%'>".ROUND(($ingresos_tot/$presupuestoDefinitivo)*100,2)."%</td>";
											echo "</tr>";
										}
										$vporcentaje = ROUND(($ingresos_tot/$presupuestoDefinitivo)*100,2);
										
									}
									if($_POST[reporte]=='2')
									{
										$nombreCuentaffcsv = str_replace(',',' ',$nombreCuentaff);
										fputs($Descriptor1,$numeroCuenta.",".strtoupper($nombreCuentaffcsv).",".number_format($presupuestoInicial,0,'.','').",".number_format($adicion,0,'.','').",".number_format($reduccion,0,'.','').",".number_format($presupuestoDefinitivo,0,'.','').",".number_format($ingresos_tot,0,'.','').",".number_format($vporcentaje,2,".","")."\r\n");
									}
									
									
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								}  //----bloque nuevo 17/01/2016
		
							}
							$compromisos = 0;
							function totalCompromisos()
							{
								global $vigenciaTr,$linkbd;
								$sqlComp = "SELECT D.cuenta, SUM(D.valor), D.tipo_mov FROM pptorp_detalle D WHERE D.vigencia=$vigenciaTr  AND NOT(D.estado='N') AND D.valor>0   GROUP BY D.tipo_mov, D.cuenta";echo $sqlComp;
								$resultComp=mysql_query($sqlComp,$linkbd);
								
								while($rowComp = mysql_fetch_array($resultComp))
								{
									if($rowComp[2] == '201')
									{
										$compromisos = $compromisos + $rowComp[1];
										echo $compromisos."1 <br>";
									}
									else
									{
										echo $compromisos."2 <br>";
										$compromisos = $compromisos - $rowComp[1];
										echo $compromisos."3 <br>";
									}
								}
								var_dump($compromisos);
							}
							if($_POST[reporte]=='2')
							{
								$vportot=round(($sumareca/$sumai)*100,2);
								echo "<tr><td ></td><td ></td><td  align='right'>Totales:</td><td class='saludo3' align='right'>".number_format($sumapi,2)."</td><td class='saludo3' align='right'>".number_format($sumapad,2)."</td><td class='saludo3' align='right'>".number_format($sumapred,2)."</td><td class='saludo3' align='right'>".number_format($sumai,2)."</td><td class='saludo3' align='right'>".number_format($sumareca,2)."</td><td class='saludo3' align='right'>".number_format($vportot,2)."%</td></tr>";
							}
							else
							{
								echo "<tr style='font-weight:bold; font-size:9px; text-rendering: optimizeLegibility' class='$iter'>";
								totalCompromisos();
								echo "
								<td id='1' style='width: 5%'>$nit</td>
								<td id='2' style='width: 15%'>$razonSocial</td>
								<td id='3' style='width: 5%'>".number_format($sumai,2,",",".")."</td>
								<td id='4' style='width: 4.5%'>".number_format($sumareca,2,",",".")."</td>
								<td id='5' style='width: 4.5%'>".number_format($sumareca,2,",",".")."</td>";
								echo "</tr>";
							}
   							fclose($Descriptor1);
						break;
						//----------------------------------------------------------------------------------------------
						case 3: //F07 - Fuente de Recursos CDM
							
						break;
						case 5:  //****** F17B - Mes a Rendir CDM (ESTAMPILLAS PRO CULTURA)
							
						break;	
						case 6://****** F17B - Mes a Rendir CDM (ESTAMPILLAS PROTURISMO)
							
						break;
						case 15: //SIA
						break;
					}
				}
				?>
			</div>
		</form>
	</td>
	</tr>
</table>
</body>
</html