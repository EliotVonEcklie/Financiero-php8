<?php //V 1000 12/12/16 ?> 
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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
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
                $informes[1]="538";
                $informes[2]="539";
                $informes[3]="540";
                $informes[4]="541";
                $informes[5]="543";
                $informes[6]="544";
                ?>
  				<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a><a href="<?php echo "archivos/".$_SESSION[usuario]."informecgr".$fec.".csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="cs"></a><a href="descargartxt.php?id=<?php echo $informes[$_POST[reporte]].".txt"; ?>&dire=archivos" target="_blank" class="mgbt"><img src="imagenes/contraloria.png"  title="contraloria"></a></td>
  			</tr>
		</table>
	</body>
	<form name="form2" method="post" action="presu-reportescgr1.php">
 <?php
  $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
  $linkbd=conectar_bd();
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

			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
			 $sqlr="select *from configbasica where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
	 			{
  					$_POST[nitentidad]=$row[0];
  					$_POST[entidad]=$row[1];
					$_POST[codent]=$row[8];
 				 }
 ?>
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="6">.: Reportes CGR</td>
        <td width="74" class="cerrar"><a href="presu-principal.php">&nbsp;Cerrar</a></td>
      </tr>
      <tr  ><td class="saludo1">Reporte</td>
      <td>
       <select name="reporte" id="reporte">
        <option value="-1">Seleccione ....</option>
          <option value="1" <?php if($_POST[reporte]=='1') echo "selected" ?>>F50.1  PROGRAMACI&Oacute;N DE INGRESOS</option>
		  <option value="2" <?php if($_POST[reporte]=='2') echo "selected" ?>>F50.2  EJECUCI&Oacute;N DE INGRESOS</option>          
          <option value="3" <?php if($_POST[reporte]=='3') echo "selected" ?>>F50.4: PROGRAMACI&Oacute;N DE GASTOS - VIGENCIA ACTUAL</option>
		  <option value="4" <?php if($_POST[reporte]=='4') echo "selected" ?>>F50.5: PROGRAMACI&Oacute;N DE GASTOS - RESERVAS</option>  
		  <option value="5" <?php if($_POST[reporte]=='5') echo "selected" ?>>F50.7: EJECUCI&Oacute;N DE GASTOS - VIGENCIA ACTUAL</option>  
          <option value="6" <?php if($_POST[reporte]=='6') echo "selected" ?>>F50.8: EJECUCI&Oacute;N DE GASTOS - RESERVAS</option>  
        </select> 
      </td>   
		<td class='saludo1'>
		Periodos
		</td>
		<td>
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
      	</select><input type="hidden" name="periodo" value="<?php echo $_POST[periodo]?>">
                    <input type="text" name="cperiodo" value="<?php echo $_POST[cperiodo]?>"  style="width:45%;" readonly>
		</td>
		<td class="saludo3" style="width:11%;">Codigo Entidad</td>
                <td><input name="codent" type="text" value="<?php echo $_POST[codent]?>">		
        <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto"></td></tr>      
    </table>
     <?php
	
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			  
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=".$vigusu." and vigenciaf=$vigusu";
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
	<div class="subpantallap" style="height:66.5%; width:99.6%;">
	<?php
	$oculto=$_POST['oculto'];
	$iter="zebra1";
	$iter2="zebra2";
	if($_POST[oculto])
	{
		switch($_POST[reporte])
	   {
		   case 1: //programacion de ingresos -------------------------------------------------------------------------------------------------------
			$mes1=substr($_POST[periodo],1,2);
			$mes2=substr($_POST[periodo],3,2);
			$_POST[fecha]='01'.'/'.$mes1.'/'.$vigusu;	
			$_POST[fecha2]=intval(date("t",$mes2)).'/'.$mes2.'/'.$vigusu;	
			
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$iter="zebra1";
				$iter2="zebra2";
				echo "-----$cuentaPadre";
				$cuentaPadre=Array();
				$vectorDif=Array();
				cuentasAux();
				$linkbd=conectar_bd();
				$sqlr1="select codcontaduria from configbasica";
				$res1=mysql_query($sqlr1,$linkbd);
				$rowr=mysql_fetch_row($res1);
				$res1=$rowr[0];
				
				echo "<div class='subpantallac5' style='height:65%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>
						<table class='inicio' align='center' id='valores' >
							<tr class='titulos'>
						<td colspan='15'>.: Ejecucion Cuentas</td>
					</tr>
					<tr class='titulos2'>
						<td id='col1' >Cuenta</td>
						<td id='col2' >Nombre</td>
						<td id='col3' >Fuentes</td>
						<td id='col4' >Presupuesto Inicial</td>
						<td id='col5' >Adicion</td>
						<td id='col5' >Superavit</td>
						<td id='col6' >Reduccion</td>
						<td id='col9' >Presupuesto Definitivo</td>
						<td id='col9' >Ingresos</td>
						
					</tr>
						<tbody>";

							
					for ($i=0; $i <sizeof($cuentaPadre) ; $i++) { 
						buscaCuentasHijo($cuentaPadre[$i]);
					}
			
					$totPresuInicial=0;
					$totAdiciones=0;
					$totReducciones=0;
					$totPresuDefinitivo=0;
					$totIngresos=0;
					$totSuperavit=0;
					foreach ($cuentas as $key => $value) {
							$numeroCuenta=$cuentas[$key]['numCuenta'];
							$nombreCuenta=$cuentas[$key]['nomCuenta'];
							$fuenteCuenta=$cuentas[$key]['fuenCuenta'];
							$presupuestoInicial=number_format($cuentas[$key]['presuInicial'],2,",",".");
							$adicion=number_format($cuentas[$key]['adicion'],2,",",".");
							$reduccion=number_format($cuentas[$key]['reduccion'],2,",",".");
							$presupuestoDefinitivo=number_format($cuentas[$key]['presuDefinitivo'],2,",",".");
							$ingresos=number_format($cuentas[$key]['ingreso'],2,",",".");
							$superavit=number_format($cuentas[$key]['superavit'],2,",",".");
							
							$tipo=$cuentas[$key]['tipo'];
							$tasa=$cuentas[$key]['tasa'];
							$style='';
							if($saldo<0){
								$style='background: yellow';
							}
							if(strlen($numeroCuenta)==1){
								$totPresuInicial+=$cuentas[$key]['presuInicial'];
								$totAdiciones+=$cuentas[$key]['adicion'];
								$totReducciones+=$cuentas[$key]['reduccion'];
								$totPresuDefinitivo+=$cuentas[$key]['presuDefinitivo'];
								$totSuperavit=$cuentas[$key]['superavit'];
								$totIngresos+=$cuentas[$key]['ingreso'];
							}

							if(!empty($numeroCuenta)){  //----bloque nuevo 17/01/2016
								if($tipo=='Auxiliar' || $tipo=='auxiliar'){
								echo "<tr style='font-size:9px; text-rendering: optimizeLegibility;$style' class='$iter'>";
							echo "<td id='1' style='width: 5%'>$numeroCuenta</td><td id='2' style='width: 15%'>$nombreCuenta</td><td id='3' style='width: 10%'>$fuenteCuenta</td><td id='4' style='width: 5.5%'>$presupuestoInicial</td><td id='5' style='width: 4.5%'>$adicion</td><td id='6' style='width: 4.5%'>$superavit</td><td id='6' style='width: 4.5%'>$reduccion</td><td id='9' style='width: 5%'>$presupuestoDefinitivo</td><td id='7' style='width: 4.5%'>$ingresos</td>";
							echo "</tr>";
							}else{
								echo "<tr style='font-weight:bold; font-size:9px; text-rendering: optimizeLegibility' class='$iter'>";
							echo "<td id='1' style='width: 5%'>$numeroCuenta</td><td id='2' style='width: 15%'>$nombreCuenta</td><td id='3' style='width: 10%'>$fuenteCuenta</td><td id='4' style='width: 5.5%'>$presupuestoInicial</td><td id='5' style='width: 4.5%'>$adicion</td><td id='6' style='width: 4.5%'>$superavit</td><td id='6' style='width: 4.5%'>$reduccion</td><td id='9' style='width: 5%'>$presupuestoDefinitivo</td><td id='7' style='width: 4.5%'>$ingresos</td>";
							echo "</tr>";
					
							}
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							}  //----bloque nuevo 17/01/2016
							
							echo "<input type='hidden' name='codcuenta[]' id='codcuenta[]' value='".$numeroCuenta."' />";
							echo "<input type='hidden' name='nomcuenta[]' id='nomcuenta[]' value='".$nombreCuenta."' />";
							
							echo "<input type='hidden' name='fuente[]' id='fuente[]' value='".$fuenteCuenta."' />";
							echo "<input type='hidden' name='picuenta[]' id='picuenta[]' value='".$presupuestoInicial."' />";
							echo "<input type='hidden' name='padcuenta[]' id='padcuenta[]' value='".$adicion."' />";
							echo "<input type='hidden' name='psvcuenta[]' id='psvcuenta[]' value='".$superavit."' />";
							echo "<input type='hidden' name='predcuenta[]' id='predcuenta[]' value='".$reduccion."' />";
							echo "<input type='hidden' name='pdefcuenta[]' id='pdefcuenta[]' value='".$presupuestoDefinitivo."' />";
							echo "<input type='hidden' name='vicuenta[]' id='vicuenta[]' value='".$ingresos."' />";
							echo "<input type='hidden' name='tcodcuenta[]' id='tcodcuenta[]' value='".$tipo."' />";

						

					
				}
			
				
				echo "</tbody></table>
				</div>";
				echo "<div class='subpantallac5' style='height:20%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>";
						echo "<table class='inicio' align='center' id='valores' >
							<tr><td style='width: 6%'><img src='imagenes/sumatoria.png' style='width: 20px; height: 20px' /></td><td>Presupueso Inicial</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totPresuInicial)."</td><td>Adiciones</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totAdiciones)."</td><td>Superavit</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totSuperavit)."</td><td>Reducciones</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totReducciones)."</td><td>Presupuesto Definitivo</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totPresuDefinitivo)."</td><td>Ingresos</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totIngresos)."</td></tr>
							</table>";
				echo "</div>";
				
				
				function generaVectorCuenta($numCuenta,$vigencia,$fechaf,$fechaf2){
					$ejecucionxcuenta=Array();
					global $linkbd;
					$queryPresupuesto="SELECT valor,vigencia FROM pptocuentaspptoinicial WHERE cuenta='$numCuenta' AND vigencia=$vigencia";
				
					$result=mysql_query($queryPresupuesto, $linkbd);
					
								while($row=mysql_fetch_array($result)){
									
									$presuDefinitivo+=$row[0];
								 }

								$ejecucionxcuenta[0]=$presuDefinitivo;
							
							$queryAdiciones="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$numCuenta' AND pad.vigencia=$vigencia AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND NOT(pa.estado='N') AND  pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";

							$result=mysql_query($queryAdiciones, $linkbd);
							$totentAdicion=0.0;
							$totsalAdicion=0.0;
								if(mysql_num_rows($result)!=0){
									while($row=mysql_fetch_array($result)){
									$presuDefinitivo+=$row[0];
									$totentAdicion+=$row[0];
									$totsalAdicion+=0.0;
								}
								}
					$ejecucionxcuenta[1]=$totentAdicion;
					


								$queryReducciones="SELECT SUM(pr.valor),pr.id_reduccion,pa.fecha FROM pptoreducciones pr,pptoacuerdos pa WHERE pr.cuenta='$numCuenta' AND pr.vigencia=$vigencia AND pr.id_acuerdo=pa.id_acuerdo AND pr.id_acuerdo>0 AND NOT(pa.estado='N') AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY pr.cuenta";

								$result=mysql_query($queryReducciones, $linkbd);
								$totentReduccion=0.0;
								$totsalReduccion=0.0;
								if(mysql_num_rows($result)!=0){
									while($row=mysql_fetch_array($result)){
									$presuDefinitivo-=$row[0];
									$totentReduccion+=$row[0];
									$totsalReduccion+=0.0;
								}
								}

					$ejecucionxcuenta[2]=$totentReduccion;
					

					

					$presuDefinitivoSalida=$valCDP+$presuSalida;
					$ejecucionxcuenta[3]=$presuDefinitivo;
					$ejecucionxcuenta[4]=generaIngreso($numCuenta,$vigencia,$vigencia,$fechaf,$fechaf2);
					$ejecucionxcuenta[5]=generaSuperavit($numCuenta,$vigencia,$vigencia,$fechaf,$fechaf2);
					return $ejecucionxcuenta;		
					 
				}
				
				function generaSuperavit($cuenta,$vigencia,$vigenciaf,$fechaf,$fechaf2){
					global $linkbd;
					$tama=strlen($cuenta);
					$sqlr3="SELECT DISTINCT
						SUBSTR(pptocomprobante_det.cuenta,1,$tama),
						sum(pptocomprobante_det.valdebito),
						sum(pptocomprobante_det.valcredito)
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						   OR pptocomprobante_det.valcredito > 0)			   
						AND(pptocomprobante_cab.VIGENCIA=".$vigencia." or pptocomprobante_cab.VIGENCIA=".$vigenciaf.")
						AND(pptocomprobante_det.VIGENCIA=".$vigencia." or pptocomprobante_det.VIGENCIA=".$vigenciaf.")
						AND pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_cab.tipo_comp = 24 
						AND pptocomprobante_cab.tipo_comp = 24 
						AND SUBSTR(pptocomprobante_det.cuenta,1,$tama) = '".$cuenta."' 
						GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tama)
						ORDER BY pptocomprobante_det.cuenta";
						$res=mysql_query($sqlr3,$linkbd);
						$row =mysql_fetch_row($res);
						$psv=$row[1];
						return $psv;

				}
				function generaIngreso($cuenta,$vigencia,$vigenciaf,$fechaf,$fechaf2){
					global $linkbd;
					$tama=strlen($cuenta);
					$sqlr3="SELECT DISTINCT
						SUBSTR(pptocomprobante_det.cuenta,1,$tama),
						sum(pptocomprobante_det.valdebito),
						sum(pptocomprobante_det.valcredito)
						FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
						WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						   OR pptocomprobante_det.valcredito > 0)			   
						AND(pptocomprobante_cab.VIGENCIA=".$vigencia." or pptocomprobante_cab.VIGENCIA=".$vigenciaf.")
						AND(pptocomprobante_det.VIGENCIA=".$vigencia." or pptocomprobante_det.VIGENCIA=".$vigenciaf.")
						AND pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
						AND (pptotipo_comprobante.tipo = 'I' or pptotipo_comprobante.tipo = 'D')		   
						AND SUBSTR(pptocomprobante_det.cuenta,1,$tama) = '".$cuenta."' 
						GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tama)
						ORDER BY pptocomprobante_det.cuenta";
						$res=mysql_query($sqlr3,$linkbd);
						$row =mysql_fetch_row($res);
						$vitot=$row[1];	
						
						return $vitot;
				}

				function cuentasAux(){
					echo "holaaa";
				global $cuentas,$linkbd,$vigencia,$f1,$f2,$cuentaPadre,$cuentaInicial,$cuentaFinal,$vectorDif;
				$datosBase=datosiniciales();
				$orden='cuenta';
				$municipio="cumaribo";
				$baseDatos=$datosBase[0];
				
				if(empty($cuentaInicial) || empty($cuentaFinal)){
					$sql="SELECT cuenta,nombre,tipo,futfuentefunc,futfuenteinv FROM pptocuentas WHERE estado='S' AND clasificacion LIKE '%ingresos%' AND (vigencia=$vigencia OR vigenciaf=$vigencia) ORDER BY $orden ";
				}else{
					$sql="SELECT cuenta,nombre,tipo,futfuentefunc,futfuenteinv FROM pptocuentas WHERE estado='S' AND clasificacion LIKE '%ingresos%' AND (vigencia=$vigencia OR vigenciaf=$vigencia) AND cuenta>=$cuentaInicial AND cuenta<=$cuentaFinal ORDER BY $orden  ";
					echo $sql;
				}
				$result=mysql_query($sql,$linkbd);

				while($row = mysql_fetch_array($result)){
					if($row[2]=='Auxiliar' || $row[2]=='auxiliar'){
					$arregloCuenta=generaVectorCuenta($row[0],$vigencia,$f1,$f2);
					$cuentas[$row[0]]["numCuenta"]=$row[0];
					$cuentas[$row[0]]["nomCuenta"]=$row[1];
					$cuentas[$row[0]]["presuInicial"]=$arregloCuenta[0];
					$cuentas[$row[0]]["fuenCuenta"]=obtenerFuente($row[3],$row[4]);
					$cuentas[$row[0]]["adicion"]=$arregloCuenta[1];
					$cuentas[$row[0]]["reduccion"]=$arregloCuenta[2];
					$cuentas[$row[0]]["presuDefinitivo"]=$arregloCuenta[3];
					$cuentas[$row[0]]["ingreso"]=$arregloCuenta[4];
					$cuentas[$row[0]]["superavit"]=$arregloCuenta[5];
					$cuentas[$row[0]]["tipo"]="Auxiliar";

					}else{
					
					$cuentas[$row[0]]["numCuenta"]=$row[0];
					$cuentas[$row[0]]["nomCuenta"]=$row[1];
					$cuentas[$row[0]]["presuInicial"]=0;
					$cuentas[$row[0]]["fuenCuenta"]=obtenerFuente($row[3],$row[4]);
					$cuentas[$row[0]]["adicion"]=0;
					$cuentas[$row[0]]["reduccion"]=0;
					$cuentas[$row[0]]["presuDefinitivo"]=0;
					$cuentas[$row[0]]["ingreso"]=0;
					$cuentas[$row[0]]["superavit"]=0;
					$cuentas[$row[0]]["tipo"]="Mayor";
					$cuentaPadre[]=$row[0];
					}
					


				}

				}
					function buscaCuentasHijo($cuenta){
					global $cuentas,$linkbd,$vigencia,$f1,$f2,$cuentaPadre;
					$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '$cuenta%' AND estado='S' AND clasificacion  LIKE '%ingresos%' AND (vigencia=$vigencia OR vigenciaf=$vigencia) AND (tipo='Auxiliar' OR tipo='auxiliar')";
					$result=mysql_query($sql,$linkbd);
					$acumpptoini=0.0;
					$acumadic=0.0;
					$acumredu=0.0;
					$acumpptodef=0.0;
					$acumingreso=0.0;
					$acumsuperavit=0.0;
					while($row = mysql_fetch_array($result)){
					
						$acumpptoini+=$cuentas[$row[0]]["presuInicial"];
						$acumadic+=$cuentas[$row[0]]["adicion"];
						$acumredu+=$cuentas[$row[0]]["reduccion"];
						$acumpptodef+=$cuentas[$row[0]]["presuDefinitivo"];
						$acumingreso+=$cuentas[$row[0]]["ingreso"];
						$acumsuperavit+=$cuentas[$row[0]]["superavit"];
					}

					$cuentas[$cuenta]["presuInicial"]=$acumpptoini;
					$cuentas[$cuenta]["adicion"]=$acumadic;
					$cuentas[$cuenta]["reduccion"]=$acumredu;
					$cuentas[$cuenta]["presuDefinitivo"]=$acumpptodef;
					$cuentas[$cuenta]["ingreso"]=$acumingreso;
					$cuentas[$cuenta]["superavit"]=$acumsuperavit;



				}
				function obtenerFuente($fuenFuncion,$fuenInversion){
				global $linkbd;
				$codigo='';
				$nombre='';
				if(!empty($fuenFuncion) && $fuenFuncion!=null){
					$sql="SELECT codigo,nombre FROM pptofutfuentefunc WHERE codigo=$fuenFuncion";
				}else{
					$sql="SELECT codigo,nombre FROM pptofutfuenteinv WHERE codigo=$fuenInversion";
				}
				$result=mysql_query($sql,$linkbd);
				while($row = mysql_fetch_array($result)){
					$codigo = $row[0];
					$nombre = $row[1];
					break;
				}
				return $codigo." - ".$nombre;
				}
				function generaCuenta($cuenta){
				global $cuentas;
				$arreglo=Array($cuentas[$cuenta]['presuInicial'],$cuentas[$cuenta]['adicion'],$cuentas[$cuenta]['reduccion'],$cuentas[$cuenta]['credito'],$cuentas[$cuenta]['conCredito'],$cuentas[$cuenta]['presuDefinitivo'],$cuentas[$cuenta]['cdp'],$cuentas[$cuenta]['rp'],$cuentas[$cuenta]['cxp'],$cuentas[$cuenta]['egreso'],$cuentas[$cuenta]['saldo']);
				return $arreglo;	
				}
	   }
	}
	?>
	</div>
	</form>
	</body>