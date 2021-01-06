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
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
 			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
				case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":
						document.form2.elimina.value=variable;
						//eli=document.getElementById(elimina);
						vvend=document.getElementById('elimina');
						//eli.value=elimina;
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){}
			function pdf()
			{
				document.form2.action="presu-ejecucioningresospdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="presu-ejecucioningresosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function validar()
			{
				document.getElementById('oculto').value='2';
				document.form2.submit(); 
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
  				<td colspan="3" class="cinta"> 
					<a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a> 
					<a href="#"  onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a> 
					<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a> 
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a> 
					<a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a> 
					<a href="presu-ejecucionpresupuestal.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>
        </table> 
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
<form name="form2" method="post" action="presu-ejecucioningresos.php">
    <table  align="center" class="inicio" >
		<tr >
			<td class="titulos" colspan="8">.: Ejecucion Ingresos</td>
			<td width="7%" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
		</tr>
		<tr>      
			<td width="10%" class="saludo1">Fecha Inicial:</td>
			<td width="10%"><input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
			<td width="10%" class="saludo1">Fecha Final: </td>
			<td width="10%"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  
			</td>
			<td width="5%" class="saludo1">Ver: </td>
			<td width="10%">
				<select name="vereg" id="vereg">
					<option value="1" <?php if($_POST[vereg]=='1') echo 'selected="selected"'; ?>>TODOS</option>
					<option value="2" <?php if($_POST[vereg]=='2') echo 'selected="selected"'; ?>>SGR</option>
				</select>
			</td>
			<td width="5%">
				<input type="button" name="generar" value="Generar" onClick="validar()"> 
				<input type="hidden" value="<?php echo $_POST[oculto]; ?>" name="oculto" id="oculto">
			</td>
			<td width="33%"></td>
		</tr>      
    </table>
		<?php
		$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$_POST[vigencia]=$vigusu;
		//validacion ppto
		if($_POST[oculto]==2){
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha1);
			$fechaf=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha2);
			$fechaf2=$fecha2[3]."-".$fecha2[2]."-".$fecha2[1];	
			if($_POST[vereg]=='1'){
				if($fecha1[3]==$fecha2[3]){
					$correcto=1;
					$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
					$resv=mysql_query($sqlv,$linkbd);
					if(mysql_num_rows($resv)!=0){
						$todos=1;
					}
					else{
						$todos=0;
					}
				}
				else{
					$correcto=0;
					echo "<script>despliegamodalm('visible','1','El Presupuesto General SOLO Aplica para Una Vigencia');</script>";				
				}
			}
			elseif($_POST[vereg]=='2'){
				if($fecha1[3]==$fecha2[3]){
					$correcto=1;
					$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
					$resv=mysql_query($sqlv,$linkbd);
					if(mysql_num_rows($resv)!=0){
						$todos=1;
					}
					else{
						$todos=0;
					}
				}
				else{
					$numvig=$fecha2[3]-$fecha1[3];
					if(($numvig>0)&&($numvig<3)){
						$vigenciarg=$fecha1[3].' - '.$fecha2[3];
						$sqlv2="SELECT * FROM pptocuentas WHERE vigenciarg='$vigenciarg'";
						$resv2=mysql_query($sqlv2,$linkbd);
						if(mysql_num_rows($resv2)!=0){
							$correcto=1;
							if($numvig>0){
								$todos=1;
							}
							else{
								$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]'";
								$resv=mysql_query($sqlv,$linkbd);
								if(mysql_num_rows($resv)!=0){
									$todos=1;
								}
								else{
									$todos=0;
								}
							}
						}
						else{
							$correcto=0;
							echo "<script>despliegamodalm('visible','1','Su Busqueda NO corresponde a una Vigencia del SGR');</script>";			
						}
					}
					else{
						$correcto=0;
						echo "<script>despliegamodalm('visible','1','La Vigencia para SGR se puede Consultar Maximo por 2 Años');</script>";				
					}
				}
			}
		}
		//fin validacion
		//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],1);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			  $linkbd=conectar_bd();
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and (vigencia=".$vigusu." or vigenciaf=$vigusu )";
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
	<div class="subpantallap" style="height:67%; width:99.6%; overflow-x:hidden;">
  <?php
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
	$oculto=$_POST['oculto'];
	//echo $todos;
	if($correcto==1)
	{
		if($todos==0){
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
			$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
			$fechafa=($fecha[3]-1)."-01-01";
			$fechaf2a=($fecha[3]-1)."-12-31";
			$iter="zebra1";
			$iter2="zebra2";

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
			echo "<table class='inicio' ><tr><td colspan='17' class='titulos'>Ejecucion Cuentas $_POST[fecha] - $_POST[fecha2]</td></tr>";
			//$nc=buscacuentap($_POST[cuenta]);
			$linkbd=conectar_bd();
			if($_POST[vereg]==2)
				$cond=" AND pptocuentas.regalias='S'";
			else
				$cond="";
			$sqlr2="Select distinct pptocuentas.cuenta, pptocuentas.tipo, pptocuentas.vigencia, pptocuentas.vigenciaf, pptocuentas.regalias, dominios.tipo from pptocuentas, dominios where dominios.descripcion_valor=pptocuentas.clasificacion AND dominios.nombre_dominio='CLASIFICACION_RUBROS' AND (dominios.tipo='I') and (pptocuentas.vigencia='".$vigusu."' or  pptocuentas.vigenciaf='".$vigusu."') $cond ORDER BY pptocuentas.cuenta ASC ";
			//echo $sqlr2;
			$pctas=array();
			$tpctas=array();
			$pctasvig1=array();
			$pctasvig2=array();	
			$rescta=mysql_query($sqlr2,$linkbd);
			while ($row =mysql_fetch_row($rescta)) 
			{
				$pctas[]=$row[0];
				$tpctas[$row[0]]=$row[1];
				$pctasvig1[$row[0]]=$row[2];
				$pctasvig2[$row[0]]=$row[3];
				$pctasvig1a[$row[0]]=$row[2]-1;
				$pctasvig2a[$row[0]]=$row[3]-1;
				$pctasreg[$row[0]]=$row[4];
				// 	echo "<br>$row[0]:".$tpctas[$row[0]];
			}	
			echo "<tr><td class='titulos2'>Cuenta</td><td class='titulos2'>Nombre</td><td class='titulos2'>Fuente</td><td class='titulos2'>PRES INI</td><td class='titulos2'>ADICIONES</td><td class='titulos2'>REDUCCIONES</td><td class='titulos2'>PRES DEF</td><td class='titulos2'>INGRESOS</td><td class='titulos2'>%</td></tr>";
			for($x=0;$x<count($pctas);$x++) 
			{		
				//año anterior
				//$nc=buscacuentap($_POST[cuenta]);
				if($pctasreg[$pctas[$x]]=='S'){
					$pdefa=0;
					$vitota=0;
					$todosa=0;	 	 
					$tamaa=strlen($pctas[$x]);
					$ctaniva=substr($pctas[$x],0,$tamaa);
					// echo "<br>".$ctaniv; 
					$nt=existecuentain($ctaniva);	
					//$vitot=$vi+$vit+$viret+$vissf+$notas+$visinrec;
					//$vporcentaje=round(($vitot/$pdef)*100,2);
					$negrilla="style='font-weight:bold'";	  
					$tcta="0"; 
			   
					//****ppto inicial
					$sqlr3="SELECT DISTINCT
					SUBSTR(pptocomprobante_det.cuenta,1,$tamaa),
					sum(pptocomprobante_det.valdebito),
					sum(pptocomprobante_det.valcredito)
					FROM pptocomprobante_det, pptocomprobante_cab
					WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
					AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
					AND pptocomprobante_cab.estado = 1
					AND (   pptocomprobante_det.valdebito > 0
					OR pptocomprobante_det.valcredito > 0)			   
					AND
					(pptocomprobante_cab.VIGENCIA=".$pctasvig1a[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2a[$pctas[$x]].")
					and(pptocomprobante_det.VIGENCIA=".$pctasvig1a[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2a[$pctas[$x]].")
					AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
					AND pptocomprobante_det.tipo_comp = 1 
					AND pptocomprobante_cab.tipo_comp = 1 		  
					AND SUBSTR(pptocomprobante_det.cuenta,1,$tamaa) = '".$pctas[$x]."' 
					GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tamaa)
					ORDER BY pptocomprobante_det.cuenta";
					//     echo "<br>".$sqlr3;
					$res=mysql_query($sqlr3,$linkbd);
					$row =mysql_fetch_row($res);
					$pia=$row[1];
					$pdefa+=$pia;
					//*** adiciones ***
					$sqlr3="SELECT DISTINCT
					SUBSTR(pptocomprobante_det.cuenta,1,$tamaa),
					sum(pptocomprobante_det.valdebito),
					sum(pptocomprobante_det.valcredito)
					FROM pptocomprobante_det, pptocomprobante_cab
					WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
					AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
					AND pptocomprobante_cab.estado = 1
					AND (   pptocomprobante_det.valdebito > 0
					   OR pptocomprobante_det.valcredito > 0)			   
					AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1a[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2a[$pctas[$x]].")
					AND(pptocomprobante_det.VIGENCIA=".$pctasvig1a[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2a[$pctas[$x]].")
					AND pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA  AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
					AND pptocomprobante_cab.tipo_comp = 2 
					AND pptocomprobante_cab.tipo_comp = 2 
					AND SUBSTR(pptocomprobante_det.cuenta,1,$tamaa) = '".$pctas[$x]."' 
					GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tamaa)
					ORDER BY pptocomprobante_det.cuenta";
					$res=mysql_query($sqlr3,$linkbd);
					$row =mysql_fetch_row($res);
					$pada=$row[1];	   
					$pdefa+=$pada;	   
					//  echo "<br>".$sqlr3;
					//*** reducciones ***
					$sqlr3="SELECT DISTINCT
					SUBSTR(pptocomprobante_det.cuenta,1,$tamaa),
					sum(pptocomprobante_det.valdebito),
					sum(pptocomprobante_det.valcredito)
					FROM pptocomprobante_det, pptocomprobante_cab
					WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
					AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
					AND pptocomprobante_cab.estado = 1
					AND (   pptocomprobante_det.valdebito > 0
					   OR pptocomprobante_det.valcredito > 0)			   
					AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1a[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2a[$pctas[$x]].")
					AND(pptocomprobante_det.VIGENCIA=".$pctasvig1a[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2a[$pctas[$x]].")
					AND pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA  AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
					AND pptocomprobante_cab.tipo_comp = 3 
					AND pptocomprobante_cab.tipo_comp = 3 
					AND SUBSTR(pptocomprobante_det.cuenta,1,$tamaa) = '".$pctas[$x]."' 
					GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tamaa)
					ORDER BY pptocomprobante_det.cuenta";
					$res=mysql_query($sqlr3,$linkbd);
					$row =mysql_fetch_row($res);
					$preda=$row[2];	   
					$pdefa-=$preda;	 
			   //**** PRUEBA TODOS LOS INGRESOS
				//*** todos los ingresos ***
					$sqlr3="SELECT DISTINCT
					SUBSTR(pptocomprobante_det.cuenta,1,$tamaa),
					sum(pptocomprobante_det.valdebito),
					sum(pptocomprobante_det.valcredito)
					FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
					WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
					AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
					AND pptocomprobante_cab.estado = 1
					AND (   pptocomprobante_det.valdebito > 0
					   OR pptocomprobante_det.valcredito > 0)			   
					AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1a[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2a[$pctas[$x]].")
					AND(pptocomprobante_det.VIGENCIA=".$pctasvig1a[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2a[$pctas[$x]].")
					AND pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA  AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
					AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
					AND (pptotipo_comprobante.tipo = 'I' or pptotipo_comprobante.tipo = 'D')		   
					AND SUBSTR(pptocomprobante_det.cuenta,1,$tamaa) = '".$pctas[$x]."' 
					GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tamaa)
					ORDER BY pptocomprobante_det.cuenta";
					$res=mysql_query($sqlr3,$linkbd);
					$row =mysql_fetch_row($res);
					$vitota=$row[1];	
				}
				//fin año anterior
				//**
				//año actual
				//$nc=buscacuentap($_POST[cuenta]);
				$pdef=0;
				$vitot=0;
				$todos=0;	 	 
				$tama=strlen($pctas[$x]);
				$ctaniv=substr($pctas[$x],0,$tama);
				// echo "<br>".$ctaniv; 
				$nt=existecuentain($ctaniv);	
				//$vitot=$vi+$vit+$viret+$vissf+$notas+$visinrec;
				//$vporcentaje=round(($vitot/$pdef)*100,2);
				$negrilla="style='font-weight:bold'";	  
				$tcta="0"; 
		   
				//****ppto inicial
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
				AND
				(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				and(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
				AND pptocomprobante_det.tipo_comp = 1 
				AND pptocomprobante_cab.tipo_comp = 1 		  
				AND SUBSTR(pptocomprobante_det.cuenta,1,$tama) = '".$pctas[$x]."' 
				GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tama)
				ORDER BY pptocomprobante_det.cuenta";
				//     echo "<br>".$sqlr3;
				$res=mysql_query($sqlr3,$linkbd);
				$row =mysql_fetch_row($res);
				if($pctasreg[$pctas[$x]]!='S')
					$pi=$row[1];
				else
					$pi=$vitota;
				$pdef+=$pi;
				//*** adiciones ***
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
				AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
				AND pptocomprobante_cab.tipo_comp = 2 
				AND pptocomprobante_cab.tipo_comp = 2 
				AND SUBSTR(pptocomprobante_det.cuenta,1,$tama) = '".$pctas[$x]."' 
				GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tama)
				ORDER BY pptocomprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				$row =mysql_fetch_row($res);
				$pad=$row[1];	   
				$pdef+=$pad;	   
				//  echo "<br>".$sqlr3;
				//*** reducciones ***
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
				AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
				AND pptocomprobante_cab.tipo_comp = 3 
				AND pptocomprobante_cab.tipo_comp = 3 
				AND SUBSTR(pptocomprobante_det.cuenta,1,$tama) = '".$pctas[$x]."' 
				GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tama)
				ORDER BY pptocomprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				$row =mysql_fetch_row($res);
				$pred=$row[2];	   
				$pdef-=$pred;	 
		   //**** PRUEBA TODOS LOS INGRESOS
			//*** todos los ingresos ***
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
				AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
				AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
				AND (pptotipo_comprobante.tipo = 'I' or pptotipo_comprobante.tipo = 'D')		   
				AND SUBSTR(pptocomprobante_det.cuenta,1,$tama) = '".$pctas[$x]."' 
				GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tama)
				ORDER BY pptocomprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				$row =mysql_fetch_row($res);
				$vitot=$row[1];	
				//**
				$vporcentaje=($vitot/$pdef)*100;
				if($tpctas[$ctaniv]=='Auxiliar')
				{		  
					$negrilla=" ";
					$tcta="1"; 
					$sumapcr+=$pcr;
					$sumapccr+=$pccr;
					$sumapred+=$pred;
					$sumapad+=$pad;
					$sumapi+=$pi;
					$sumai+=$pdef;
					$sumareca+=$vitot;	
				//$vporcentaje=$vitot/$pdef;
					$vporcentaje=round(($vitot/$pdef)*100,2);
					$vportot=$vporcentaje;
				}
				$fte=buscafuenteppto($ctaniv,$vigusu);
				echo "<tr class='$iter' style='font-size:9px;'>
					<td  $negrilla><input type='hidden' name='tcodcuenta[]' value='$tcta'><input type='hidden' name='codcuenta[]' value='$ctaniv'>".$ctaniv."</td>
					<td  $negrilla><input type='hidden' name='nomcuenta[]' value='$nt'>".strtoupper($nt)."</td>
					<td  $negrilla><input type='hidden' name='fuente[]' value='$fte'>".strtoupper($fte)."</td>
					<td align='right' $negrilla><input type='hidden' name='picuenta[]' value='$pi'>".number_format($pi,2)."</td>
					<td  align='right' $negrilla><input type='hidden' name='padcuenta[]' value='".number_format($pad,2,",","")."'>".number_format($pad,2)."</td>
					<td  align='right' $negrilla><input type='hidden' name='predcuenta[]' value='$pred'>".number_format($pred,2)."</td>
					<td  align='right' $negrilla><input type='hidden' name='pdefcuenta[]' value='$pdef'>".number_format($pdef,2)."</td>
					<td  align='right' $negrilla><input type='hidden' name='vicuenta[]' value='".number_format($vitot,2,",","")."'>".number_format($vitot,2)."</td>
					<td  align='right' $negrilla><input type='hidden' name='vipcuenta[]' value='$vporcentaje'>".number_format($vporcentaje,2)."%</td>
				</tr>";
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
				//fin año actual
			}//fin for
		}
		else{
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

			$linkbd=conectar_bd();
			if($_POST[vereg]==2)
				$cond=" AND pptocuentas.regalias='S'";
			else
				$cond="";
			$sqlr2="Select distinct pptocuentas.cuenta, pptocuentas.tipo, pptocuentas.vigencia, pptocuentas.vigenciaf, dominios.tipo from pptocuentas, dominios where dominios.descripcion_valor=pptocuentas.clasificacion AND dominios.nombre_dominio='CLASIFICACION_RUBROS' AND (dominios.tipo='I') and (pptocuentas.vigencia='".$vigusu."' or  pptocuentas.vigenciaf='".$vigusu."') $cond ORDER BY pptocuentas.cuenta ASC ";
			//echo "$sqlr2";
			$pctas=array();
			$tpctas=array();
			$pctasvig1=array();
			$pctasvig2=array();	
			$rescta=mysql_query($sqlr2,$linkbd);
			while ($row =mysql_fetch_row($rescta)) 
			{
				$pctas[]=$row[0];
				$tpctas[$row[0]]=$row[1];
				$pctasvig1[$row[0]]=$row[2];
				$pctasvig2[$row[0]]=$row[3];
				// 	echo "<br>$row[0]:".$tpctas[$row[0]];
			}	
			mysql_free_result($rescta);
			//echo "tc:".count($pctas);
			$iter="zebra1";
			$iter2="zebra2";
			echo "<table class='inicio' ><tr><td colspan='8' class='titulos'>Ejecucion Cuentas $_POST[fecha] - $_POST[fecha2]</td></tr>";
			echo "<tr><td class='titulos2'>Cuenta</td><td class='titulos2'>Nombre</td><td class='titulos2'>Fuente</td><td class='titulos2'>PRES INI</td><td class='titulos2'>ADICIONES</td><td class='titulos2'>REDUCCIONES</td><td class='titulos2'>PRES DEF</td><td class='titulos2'>INGRESOS</td><td class='titulos2'>%</td></tr>";
			for($x=0;$x<count($pctas);$x++) 
			{		
				//$nc=buscacuentap($_POST[cuenta]);
				$pdef=0;
				$vitot=0;
				$todos=0;	 	 
				$tama=strlen($pctas[$x]);
				$ctaniv=substr($pctas[$x],0,$tama);
				// echo "<br>".$ctaniv; 
				$nt=existecuentain($ctaniv);	
				//$vitot=$vi+$vit+$viret+$vissf+$notas+$visinrec;
				//$vporcentaje=round(($vitot/$pdef)*100,2);
				$negrilla="style='font-weight:bold'";	  
				$tcta="0"; 
		   
				//****ppto inicial
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
				AND
				(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				and(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
				AND pptocomprobante_det.tipo_comp = 1 
				AND pptocomprobante_cab.tipo_comp = 1 		  
				AND SUBSTR(pptocomprobante_det.cuenta,1,$tama) = '".$pctas[$x]."' 
				GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tama)
				ORDER BY pptocomprobante_det.cuenta";
				//     echo "<br>".$sqlr3;
				$res=mysql_query($sqlr3,$linkbd);
				$row =mysql_fetch_row($res);
				$pi=$row[1];
				$pdef+=$pi;
				//*** adiciones ***
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
				AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
				AND pptocomprobante_cab.tipo_comp = 2 
				AND pptocomprobante_cab.tipo_comp = 2 
				AND SUBSTR(pptocomprobante_det.cuenta,1,$tama) = '".$pctas[$x]."' 
				GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tama)
				ORDER BY pptocomprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				$row =mysql_fetch_row($res);
				$pad=$row[1];	   
				$pdef+=$pad;	   
				//  echo "<br>".$sqlr3;
				//*** reducciones ***
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
				AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
				AND pptocomprobante_cab.tipo_comp = 3 
				AND pptocomprobante_cab.tipo_comp = 3 
				AND SUBSTR(pptocomprobante_det.cuenta,1,$tama) = '".$pctas[$x]."' 
				GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tama)
				ORDER BY pptocomprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				$row =mysql_fetch_row($res);
				$pred=$row[2];	   
				$pdef-=$pred;	 
		   //**** PRUEBA TODOS LOS INGRESOS
			//*** todos los ingresos ***
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
				AND(pptocomprobante_cab.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_cab.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND(pptocomprobante_det.VIGENCIA=".$pctasvig1[$pctas[$x]]." or pptocomprobante_det.VIGENCIA=".$pctasvig2[$pctas[$x]].")
				AND pptocomprobante_det.VIGENCIA=pptocomprobante_cab.VIGENCIA  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
				AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
				AND (pptotipo_comprobante.tipo = 'I' or pptotipo_comprobante.tipo = 'D')		   
				AND SUBSTR(pptocomprobante_det.cuenta,1,$tama) = '".$pctas[$x]."' 
				GROUP BY SUBSTR(pptocomprobante_det.cuenta,1,$tama)
				ORDER BY pptocomprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				$row =mysql_fetch_row($res);
				$vitot=$row[1];	
				//**
				$vporcentaje=($vitot/$pdef)*100;
				if($tpctas[$ctaniv]=='Auxiliar')
				{		  
					$negrilla=" ";
					$tcta="1"; 
					$sumapcr+=$pcr;
					$sumapccr+=$pccr;
					$sumapred+=$pred;
					$sumapad+=$pad;
					$sumapi+=$pi;
					$sumai+=$pdef;
					$sumareca+=$vitot;	
				//$vporcentaje=$vitot/$pdef;
					$vporcentaje=round(($vitot/$pdef)*100,2);
				}
				$fte=buscafuenteppto($ctaniv,$vigusu);
				echo "<tr class='$iter' style='font-size:9px;'>
					<td  $negrilla><input type='hidden' name='tcodcuenta[]' value='$tcta'><input type='hidden' name='codcuenta[]' value='$ctaniv'>".$ctaniv."</td>
					<td  $negrilla><input type='hidden' name='nomcuenta[]' value='$nt'>".strtoupper($nt)."</td>
					<td  $negrilla><input type='hidden' name='fuente[]' value='$fte'>".strtoupper($fte)."</td>
					<td align='right' $negrilla><input type='hidden' name='picuenta[]' value='$pi'>".number_format($pi,2)."</td>
					<td  align='right' $negrilla><input type='hidden' name='padcuenta[]' value='".number_format($pad,2,",","")."'>".number_format($pad,2)."</td>
					<td  align='right' $negrilla><input type='hidden' name='predcuenta[]' value='$pred'>".number_format($pred,2)."</td>
					<td  align='right' $negrilla><input type='hidden' name='pdefcuenta[]' value='$pdef'>".number_format($pdef,2)."</td>
					<td  align='right' $negrilla><input type='hidden' name='vicuenta[]' value='".number_format($vitot,2,",","")."'>".number_format($vitot,2)."</td>
					<td  align='right' $negrilla><input type='hidden' name='vipcuenta[]' value='$vporcentaje'>".number_format($vporcentaje,2)."%</td>
				</tr>";
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
			}//fin for
		}
		$vportot=round(($sumareca/$sumai)*100,2);
		echo "<tr><td ></td><td ></td><td  align='right'>Totales:</td><td class='saludo3' align='right'>".number_format($sumapi,2)."</td><td class='saludo3' align='right'>".number_format($sumapad,2)."</td><td class='saludo3' align='right'>".number_format($sumapred,2)."</td><td class='saludo3' align='right'>".number_format($sumai,2)."</td><td class='saludo3' align='right'>".number_format($sumareca,2)."</td><td class='saludo3' align='right'>".number_format($vportot,2)."%</td></tr>";
 //} 
	}
	?> 
</div>
</form>
</body>
</html>